@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifier un ministère</h1>
        <form action="{{ route('ministries.update', $ministry->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nom du ministère:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $ministry->name }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description">{{ $ministry->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="leaderId">Leader:</label>
                <select class="form-control" id="leaderId" name="leader" required>
                    @foreach($leaders as $leader)
                        <option value="{{ $leader->id }}">{{ $leader->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
@endsection
