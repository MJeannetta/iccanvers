@extends('layouts.app')

@section('content')
    <h1>Modifier l'événement</h1>

    <form method="post" action="{{ route('events.update', $event->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="theme">Thème :</label>
            <input type="text" class="form-control" name="theme" value="{{ old('theme', $event->theme->name) }}" required>
        </div>

        <div class="form-group">
            <label for="title">Titre :</label>
            <input type="text" class="form-control" name="title" value="{{ old('title', $event->title) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description :</label>
            <textarea class="form-control" name="description" required>{{ old('description', $event->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="location">Lieu :</label>
            <select name="location_id" class="form-control" required>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="startDate">Heure de début :</label>
            <input type="date" class="form-control" name="startDate" value="{{ old('start_date', $event->start_date) }}" required>
        </div>

        <div class="form-group">
            <label for="endDate">Heure de fin :</label>
            <input type="date" class="form-control" name="endDate" value="{{ old('end_date', $event->end_date) }}" required>
        </div>

        <div class="form-group">
            <label for="typeEvent">Type d'événement :</label>
            <input type="text" class="form-control" name="typeEvent" value="{{ old('type', $event->type) }}" required>
        </div>

        <div class="form-group">
            <label>Organisateurs :</label><br>
            @foreach($organizers as $organizer)
                <input type="checkbox" name="organizers_id[]" class="organizer-checkbox" value="{{ $organizer->id }}">
                <label>{{ $organizer->name }}</label><br>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
    </form>

    <a href="{{ route('events.index') }}" class="btn btn-secondary">Annuler</a>
@endsection
