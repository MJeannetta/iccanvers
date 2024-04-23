@extends('layouts.app')

@section('content') 
    <div class="container">
        <h1>Créer un ministère</h1>
        <form action="{{ route('ministries.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nom du ministère:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="leader">Responsable:</label>
                <select class="form-control" name="leader" required>
                    <option value="" selected disabled>-- Choisissez un(e) responsable --</option>
                    @foreach($leaders as $leader)
                        <option value="{{ $leader->id }}">{{ $leader->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>
    </div>
@endsection
