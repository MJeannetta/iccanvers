@extends('layouts/app')

@section('title', 'Événements')

@section('content')
    <h1>Liste des événements</h1>
    
    {{-- NOTIFICATIONS --}}
    <div class="card-md-4 mt-3">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>

            {{-- La balise meta sert à actualiser la page après quelques secondes (content="10")/ après 10 secondes --}}
            <meta http-equiv="refresh" content="10">
        @endif
        {{-- NOTIFICATION D'ECHEC --}}
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    </div>
 
    {{-- L'AFFICHAGE DE L'OBJET ÉVÉNEMENT --}}
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Thème</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Lieu</th>
                    <th>Debut</th>
                    <th>Fin</th>
                    <th>Type d'événement</th>
                    <th>Organisateurs</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>{{ $event->theme->name }}</td>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->description }}</td>
                        <td>{{ $event->location->name }}</td>
                        <td>{{ $event->start_date }}</td>
                        <td>{{ $event->end_date }}</td>
                        <td>{{ $event->type }}</td>
                        <td>
                            @if($event->organizers->isNotEmpty())
                                @foreach($event->organizers as $organizer)
                                    {{ $organizer->name }} <br>
                                @endforeach
                            @else
                                Aucun organisateur trouvé
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-info btn-sm">Voir</a>
                            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-info btn-sm">Modifier</a>
                            <a href="{{ route('events.create', $event->id) }}" class="btn btn-secondary btn-sm">Ajouter</a>

                            <form action="{{ route('events.destroy', $event->id) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-secondary btn-sm">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('events.create') }}" class="btn btn-primary">Créer l'événement</a>

    {{-- PAGINATION --}}
    <div>
        {{ $events->links() }}
    </div>
@endsection