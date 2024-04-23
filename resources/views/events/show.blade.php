<!-- resources/views/events/show.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Détails de l'événement</h1>

    <div>
        <h2>{{ $event->titre }}</h2>
        <p><strong>Thème :</strong> {{ $event->theme->name }}</p>
        <p><strong>Description :</strong> {{ $event->description }}</p>
        <p><strong>Lieu :</strong> {{ $event->location->name }}</p>
        <p><strong>Debut :</strong> {{ $event->start_date }}</p>
        <p><strong>Fin :</strong> {{ $event->end_date }}</p>
        <p><strong>Type d'événement :</strong> {{ $event->type }}</p>

        <p><strong>Organisateurs :</strong>
            @foreach($event->organizers as $organizer)
                {{ $organizer->name }}
            @endforeach
        </p>  
    </div>

    <a href="{{ route('events.index') }}" class="btn btn-primary">Retour à la liste des événements</a>
@endsection
