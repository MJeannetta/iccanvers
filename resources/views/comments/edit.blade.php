@extends('layouts/app')

@section('content')
    {{-- NOTIFICATION DE SUCCÈS --}}
    <div class="card-md-4 mt-3">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>

            {{-- La balise meta sert à actualiser la page après quelques secondes (content="1")/ après une seconde --}}
            <meta http-equiv="refresh" content="1">
        @endif
    </div>

    {{-- FORMULAIRE DE MODIFICATION DU COMMENTAIRE --}}
    <form action="{{ route('comments.update', $comment->id) }}" method="post">               
        @csrf   
        @method('put')    
        
        @if ($comment->user_id === Auth::user()->id)
            <div class="form-outline mb-4">
                <input type="text" name="content" class="form-control" placeholder="Commenter..." value="{{ $comment->content }}" autocomplete="off" />
            </div>
        @endif

        <button class="btn btn-success">Enregistrer</button>
    </form>
@endsection                                                       