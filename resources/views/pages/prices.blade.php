@extends('layouts.site')

@section('title', 'Precios')
@section('description', 'Precios de las reparaciones y puestas a punto de Radios, taller de bicicletas en Zaragoza.')

@section('content')
    <h1>Precios</h1>
    <p>Los precios incluyen la mano de obra. Las piezas que haya que cambiar se cobran aparte, y siempre te las enseñamos antes.</p>

    <table class="prices">
        <thead>
            <tr><th>Servicio</th><th>Precio</th></tr>
        </thead>
        <tbody>
            @foreach (config('shop.prices') as $price)
                <tr><td>{{ $price['service'] }}</td><td>{{ $price['price'] }}</td></tr>
            @endforeach
        </tbody>
    </table>
@endsection
