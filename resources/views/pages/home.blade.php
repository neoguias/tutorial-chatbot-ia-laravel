@extends('layouts.site')

@section('title', 'Taller de bicicletas en Zaragoza')
@section('description', 'Radios repara bicicletas de carretera, montaña, urbanas y eléctricas en Zaragoza, sin cita y con el precio antes de empezar.')

@section('content')
    <section class="hero">
        <h1>Tu bici, lista en dos días</h1>
        <p>Radios es un taller de bicicletas en el centro de Zaragoza. Reparamos bicis de carretera, de montaña, urbanas y eléctricas, y la mayoría de trabajos están listos en dos días laborables.</p>
        <a class="button" href="{{ route('prices') }}">Ver precios</a>
    </section>

    <section>
        <h2>Cómo trabajamos</h2>
        <p>Traes la bici sin cita, la revisamos delante de ti y te damos el precio antes de empezar. Si aparece algo que no estaba previsto, te llamamos antes de tocarlo.</p>
        <p>Si no puedes acercarte, la recogemos y te la devolvemos en casa por 10 euros, dentro de Zaragoza.</p>
    </section>
@endsection
