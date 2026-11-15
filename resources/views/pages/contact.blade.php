@extends('layouts.site')

@section('title', 'Contacto y horario')
@section('description', 'Dirección, teléfono y horario de Radios, taller de bicicletas en Zaragoza.')

@section('content')
    <h1>Contacto y horario</h1>

    <section>
        <h2>Dónde estamos</h2>
        <p>{{ config('shop.address') }}. No hace falta cita para traer la bici.</p>
    </section>

    <section>
        <h2>Horario</h2>
        <ul>
            @foreach (config('shop.hours') as $line)
                <li>{{ $line }}</li>
            @endforeach
        </ul>
    </section>

    <section>
        <h2>Teléfono y correo</h2>
        <p>Llámanos al {{ config('shop.phone') }} o escríbenos a {{ config('shop.email') }}. Para las recogidas a domicilio, avísanos con un día de antelación.</p>
    </section>
@endsection
