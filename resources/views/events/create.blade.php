@extends('layouts/app')

@section('content')
    <h1>Créer un nouvel événement</h1>

    <form method="post" action="{{ route('events.store') }}">
        @csrf
        @method('post')

        <div class="form-group">
            <label for="title">Titre :</label>
            <input type="text" class="form-control" name="title" required>
        </div>

        <div class="form-group">
            <label for="description">Description :</label>
            <textarea class="form-control" name="description" required></textarea>
        </div>

        <div class="form-group">
            <label for="startDate">Heure de début :</label>
            <input type="date" class="form-control datepicker" name="startDate" required>
        </div>

        <div class="form-group">
            <label for="endDate">Heure de fin :</label>
            <input type="date" class="form-control datepicker" name="endDate" required>
        </div>

        <div class="form-group">
            <label for="typeEvent">Type d'événement :</label>
            <input type="text" class="form-control" name="typeEvent" required>
        </div>

        <div class="form-group">
            <label>Organisateurs :</label><br>
            @foreach($organizers as $organizer)
                <input type="checkbox" name="organizers_id[]" class="organizer-checkbox" value="{{ $organizer->id }}">
                <label>{{ $organizer->name }}</label><br>
            @endforeach
        </div>

        <div class="form-group">
            <label for="location_id">Ville :</label>
            <select name="location_id" class="form-control" required>
                <option value="#" selected disabled>--Choisir une ville--</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="theme_id">Thème :</label>
            <select name="theme_id" class="form-control" required>
                <option value="#" selected disabled>--Choisir un thème--</option>
                @foreach($themes as $theme)
                    <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Enrégistrer</button>
    </form>
@endsection