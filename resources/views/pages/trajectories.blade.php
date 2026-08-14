@php
    $seo_title = 'Cursos Anuales Online: Programación y creación de Videojuegos - Mi-empresa ';
    $seo_description = '¡Encuentra los mejores cursos anuales online! ✔️Clases desde casa ✔ Profesores cualificados. Entra aquí y... ¡descubre los mejores cursos!';
@endphp

@extends('layouts.main')
@section('main_id') <v-app id="trajectories"> @endsection

@section('main_content')
    <div>
        <landing-trajectories></landing-trajectories>
    </div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/trajectories-landing.js') }}" defer></script>
@endpush
