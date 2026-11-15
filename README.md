# Chatbot con IA para una web en Laravel

La web de Radios, un taller de bicicletas inventado, con un chat en el que contesta Rita, una asistente con IA que responde a partir de las propias páginas de la web: servicios, precios, horario y contacto. Cuando alguien pide hablar con una persona, la conversación llega a un panel privado desde el que la dueña del taller contesta.

El chat es [Larachat](https://edulazaro.com/portfolio/larachat). Antes de llamar al modelo principal filtra las preguntas que no son para este chat con un modelo barato, frena sin coste los intentos de manipular el bot y pide los datos de contacto con un formulario dentro de la conversación.

El tutorial completo, paso a paso, está en Neoguias: [Cómo crear un chatbot con IA para tu web con Laravel](https://www.neoguias.com/crear-chatbot-ia-laravel/).

## Cómo arrancarlo

```bash
composer install
cp .env.example .env && php artisan key:generate
php artisan migrate
```

Pon tu clave de OpenAI en `OPENAI_API_KEY` y el correo de quien atenderá el chat en `CHAT_ADMIN_EMAIL`. Después indexa las páginas, crea su usuario del panel y arranca la web:

```bash
php artisan larachat:index
php artisan larachat:admin marta@radios.test
php artisan serve
```

Abre `http://localhost:8000` y pregúntale a Rita por los precios o el horario. Las conversaciones se ven en `http://localhost:8000/conversaciones`, entrando antes por `http://localhost:8000/entrar` con la contraseña que muestra `larachat:admin`.

Los tests simulan OpenAI con `Http::fake()`, así que no necesitan clave ni gastan nada:

```bash
php artisan test
```

Requiere PHP 8.3 y Laravel 13. Larachat instala Livewire 3, que solo usa su panel.

## Dónde está cada cosa

- [`app/Chat/RadiosPersona.php`](app/Chat/RadiosPersona.php): quién es Rita, qué puede contar, los precios que puede dar y las páginas que puede enlazar.
- [`config/larachat.php`](config/larachat.php): la configuración del chat: el persona, el idioma, las rutas del panel, quién puede entrar en él y los colores del widget.
- [`config/shop.php`](config/shop.php): los datos del taller. Las páginas los muestran y Rita los lee de aquí, así que un precio se cambia una sola vez.
- [`resources/views/layouts/site.blade.php`](resources/views/layouts/site.blade.php): la plantilla de la web, con el contenido dentro de `<main>` y el widget del chat.
- [`resources/views/pages`](resources/views/pages): las cuatro páginas del taller.
- [`app/Http/Controllers/SitemapController.php`](app/Http/Controllers/SitemapController.php): el sitemap, que es también la lista de páginas que indexa Larachat.
- [`tests/Feature/ChatbotTest.php`](tests/Feature/ChatbotTest.php): los tests.

## Autor

Creado por [Edu Lázaro](https://edulazaro.com) para [Neoguias](https://www.neoguias.com).

## Licencia

Este ejemplo es software libre con [licencia MIT](LICENSE).
