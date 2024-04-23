@extends('layouts/app')

@section('content')
    {{-- PAGE PROFIL D'UN MEMBRE --}}
    <h4><span style="color:green">{{ Auth::user()->name }}</span>'s articles</h4>
    <ul class="list-group mt-1">
        @forelse($myArticles as $article)
            <li class="list-group-item">
                <a href="{{ route('articles.show', $article->id) }}" class="titre">{{ $article->titre }}</a>
                <div class="description">{{ $article->description }}</div>
            </li>
        @empty
            <li class="text text-info">Aucun article trouvé</li>
        @endforelse
    </ul>
@endsection