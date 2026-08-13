@extends('gouvernance.partials._layout')

@section('title', 'Modifier la fiche gouvernance - ' . ($projet->name ?? $projet->id))

@section('content')
    <h3 class="mb-4">Modifier la fiche gouvernance — Projet : {{ $projet->name ?? $projet->id }}</h3>

    @include('gouvernance.partials._form', ['projet' => $projet, 'gouvernance' => $gouvernance])
@endsection
