<?php

use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');
Route::view('/servicios', 'pages.services')->name('services');
Route::view('/precios', 'pages.prices')->name('prices');
Route::view('/contacto', 'pages.contact')->name('contact');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
