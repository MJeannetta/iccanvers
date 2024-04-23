@extends('layouts/app')

@section('content')
    {{-- NOTIFICATION DE SUCCÈS --}}
        <div class="card-md-4 mt-3">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>

                {{-- La balise meta sert à actualiser la page après quelques secondes (content="10")/ après 10 secondes --}}
                <meta http-equiv="refresh" content="10">
            @endif
        </div>

    {{-- FORMULAIRE DE MODIFICATION DU CONTENU DE LA RÉPONSE --}}
    <form action="{{ route('comments.replies.update', $reply->id) }}" method="post">               
        @csrf   
        @method('put')    
        
        @if ($reply->user_id === Auth::user()->id)
            <div class="form-outline mb-4">
                <input type="text" name="content" class="form-control" placeholder="Répondre..." value="{{ $reply->content }}" autocomplete="off" />
            </div>
        @endif

        <button class="btn btn-success">Enregistrer</button>
    </form>
@endsection                                                       