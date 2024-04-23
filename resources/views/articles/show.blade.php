@extends('layouts/app')

@section('content')
    <div class="card">
        <div class="card-body">
            <a class="btn btn-primary" href="{{ route('articles.index') }}" role="button">Retour</a>
            <div class="titre">{{ $article->titre }}</div>
            <p>{{ $article->description }}</p>
        </div>

        @auth()
            @if(Auth::user()->role === ('admin'))
                <div class="card-footer">
                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-info">Editer</a>
                    
                    <form action="{{ route('articles.delete', $article->id) }}" method="post">
                        @csrf
                        @method('delete')

                        <button class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
@endsection