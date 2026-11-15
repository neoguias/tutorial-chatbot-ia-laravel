<?php

namespace Tests\Feature;

use App\Models\User;
use EduLazaro\Larachat\Knowledge\Stores\JsonStore;
use EduLazaro\Larachat\Support\OpenAi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * El chat de Radios sin llamar a OpenAI: las respuestas del filtro, de los embeddings y del
 * modelo principal se simulan con Http::fake().
 */
class ChatbotTest extends TestCase
{
    use RefreshDatabase;

    /** Las llamadas al modelo, por paso: el filtro ("scope") o la respuesta ("reply"). */
    private array $sent = [];

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'larachat.openai.api_key' => 'sk-test',
            'larachat.knowledge.json.path' => storage_path('framework/testing/larachat-index.php'),
        ]);
    }

    protected function tearDown(): void
    {
        File::delete(storage_path('framework/testing/larachat-index.php'));

        parent::tearDown();
    }

    public function test_the_index_reads_every_page_of_the_sitemap(): void
    {
        $this->fakeOpenAi();

        $this->artisan('larachat:index')->assertSuccessful();

        $prices = collect((new JsonStore)->page(route('prices'), 'es'))->pluck('content')->implode(' ');

        $this->assertStringContainsString('Puesta a punto básica', $prices);
        $this->assertStringContainsString('35 €', $prices);
        $this->assertNotEmpty((new JsonStore)->page(route('contact'), 'es'));
    }

    public function test_the_bot_answers_from_the_pages_and_knows_the_prices(): void
    {
        $this->fakeOpenAi(['reply' => 'La puesta a punto básica cuesta 35 €. Tienes todos los precios en '.route('prices')]);
        $this->artisan('larachat:index')->assertSuccessful();

        $response = $this->say('¿Cuánto cuesta una puesta a punto?')->assertOk();

        $this->assertStringContainsString('35 €', $response->json('ai_reply'));
        $this->assertSame(['scope', 'reply'], array_column($this->sent, 'step'));

        $prompt = json_encode($this->sent[1]['body']['messages'], JSON_UNESCAPED_UNICODE);
        $this->assertStringContainsString('Puesta a punto básica: 35 €', $prompt);
        $this->assertStringContainsString('LIVE SITE CONTENT', $prompt);

        $this->assertSame('contact_form', $response->json('form.kind'));
    }

    public function test_a_request_for_code_is_refused_without_calling_openai(): void
    {
        $this->fakeOpenAi();

        $response = $this->say('Escríbeme una función en Python que ordene una lista')->assertOk();

        $this->assertNotEmpty($response->json('ai_reply'));
        $this->assertSame([], $this->sent);
    }

    public function test_an_off_topic_question_never_reaches_the_main_model(): void
    {
        $this->fakeOpenAi(onTopic: false);

        $response = $this->say('¿Me das una receta de paella?')->assertOk();

        $this->assertNotEmpty($response->json('ai_reply'));
        $this->assertSame(['scope'], array_column($this->sent, 'step'));
    }

    public function test_the_conversations_are_only_for_the_owner(): void
    {
        $this->get('/conversaciones')->assertNotFound();
        $this->get('/entrar')->assertOk();

        $owner = User::factory()->create(['email' => 'marta@radios.test']);
        $this->actingAs($owner)->get('/conversaciones')->assertOk();

        $stranger = User::factory()->create();
        $this->actingAs($stranger)->get('/conversaciones')->assertNotFound();
    }

    /**
     * Abre una conversación y envía un mensaje, como hace el widget.
     */
    private function say(string $message): TestResponse
    {
        $token = $this->postJson('/api/chat/init', ['page' => '/'])->assertOk()->json('token');

        return $this->postJson('/api/chat/send', ['token' => $token, 'message' => $message, 'page' => '/']);
    }

    /**
     * Simula OpenAI: los embeddings, el filtro (la llamada con 20 tokens como máximo) y la
     * respuesta del modelo principal, en el formato JSON que espera Larachat.
     *
     * @param  array<string, mixed>  $reply
     */
    private function fakeOpenAi(array $reply = [], bool $onTopic = true): void
    {
        $reply += ['reply' => 'Hola, soy Rita.', 'handoff' => false, 'qualified' => false, 'visitor_name' => null, 'visitor_email' => null, 'visitor_phone' => null];

        Http::fake(function (Request $request) use ($reply, $onTopic) {
            if ($request->url() === OpenAi::EMBEDDINGS_URL) {
                return Http::response(['data' => array_map(
                    fn (int $index) => ['index' => $index, 'embedding' => [0.1, 0.2, 0.3]],
                    array_keys((array) $request->data()['input']),
                )]);
            }

            $step = ($request->data()['max_completion_tokens'] ?? null) === 20 ? 'scope' : 'reply';
            $this->sent[] = ['step' => $step, 'body' => $request->data()];

            $content = $step === 'scope' ? ['on_topic' => $onTopic] : $reply;

            return Http::response(['choices' => [['message' => ['content' => json_encode($content)], 'finish_reason' => 'stop']], 'usage' => ['prompt_tokens' => 10]]);
        });
    }
}
