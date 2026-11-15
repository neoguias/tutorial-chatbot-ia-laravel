<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

/**
 * El sitemap de la web. Además de servir a los buscadores, es la lista de páginas que
 * `larachat:index` lee para saber qué tiene que indexar.
 */
class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $pages = ['home', 'services', 'prices', 'contact'];

        return response()
            ->view('sitemap', ['urls' => array_map(fn (string $name) => route($name), $pages)])
            ->header('Content-Type', 'application/xml');
    }
}
