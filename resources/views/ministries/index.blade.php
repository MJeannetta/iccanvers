@extends('layouts.app')

@section('title', 'Ministères')

@section('content')
    <div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    </div>
    <div class="container">
        <h1>Liste des ministères</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Responsable</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ministries as $ministry)
                    <tr>
                        <td>{{ mb_strtoupper($ministry->name, 'UTF-8') }}</td>
                        <td>{{ $ministry->description }}</td>
                        <td>
                            @if($ministry->users->isNotEmpty())
                                @foreach($ministry->users as $leader)
                                    {{ $leader->fullname() }}
                                @endforeach
                            @else
                                Aucun leader défini
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('ministries.edit', $ministry->id) }}" class="btn btn-primary">Modifier</a>
                            <form action="{{ route('ministries.destroy', $ministry->id) }}" method="post" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('ministries.create', $ministry->id) }}" class="btn btn-primary">Créer un ministère</a>
    </div>
@endsection
