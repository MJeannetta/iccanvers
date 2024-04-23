@extends('layouts/app')

@section('title', 'Blog')

@section('extra_js')
    <script>
        //BOUTON QUI CACHE ET AFFICHE LE CHAMP DU CONTENU D'UN COMMENTAIRE
        function toggleReplyComment(id)
        {
            let element = document.getElementById("replyComment~" + id);
            element.classList.toggle("d-none");
        }
    </script>
    <script>
        //BOUTON QUI CACHE ET AFFICHE LES RÉPONSES D'UN COMMENTAIRE
        document.addEventListener("DOMContentLoaded", function() {
            const toggleReplyButtons = document.querySelectorAll('.toggle-reply');
            
            toggleReplyButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = 'brown';
                    this.style.color = 'white';
                });

                //En survolant le bouton, on change sa couleur de fond et son texte. 
                button.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                    this.style.color = '';
                });

                button.addEventListener('click', function() {
                    const replies = this.nextElementSibling;
                    replies.classList.toggle('d-none');
                });
            });
        });
    </script>
    <style>
        .toggle-reply {
            border: none; /* Supprimer les bordures */
            cursor: pointer; /* Définir le curseur sur pointer */
        }
        .btSimple {
            border: none;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="row mt-2">
        <div class="col-md-4">

                {{-- NOTIFICATION DE SUCCÈS --}}
                <div class="card-md-4 mt-3">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- NOTIFICATION D'ECHEC --}}
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                @auth()
                    @if (Auth::check() && Auth::user()->roles->contains('name', 'admin'))
                        <div class="card">  
                            <div class="card-body">
                                
                                {{-- FORMULAIRE DE LA CRÉATION D'UN ARTICLE --}}
                                <form action="{{ route('articles.store') }}" method="post" class="form-product">
                                    @method('post')
                                    @csrf

                                    <h4>Enrégistrez un nouveau article</h4>
                                    <div class="form-group">
                                        <label for="titre">Titre</label>
                                        <input type="text" name="titre" id="titre" class="form-control" placeholder="Saisissez le titre" value="{{ old('titre') }}">

                                        @error('titre')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control" placeholder="Entrez la description"></textarea>

                                        @error('description')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div><button class="btn btn-success">Ajouter</button></div>
                                </form>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
    <h4 class="mt-2">Articles disponibles</h4>

    {{-- AFFICHAGE DE TOUS LES ARTICLES --}}
    <ul class="list-group mt-1">
        @forelse($articles as $article)
            <li class="list-group-item">
                <a href="{{ route('articles.show', $article->id) }}" class="titre">{{ $article->titre }}</a>
                <div class="description">{{ $article->description }}</div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="col-md-8 col-lg-6">
                        
                        {{-- TOTAL DE TOUS LES COMMENTAIRES --}}                       
                        <h4> {{ $article->comments->count() }} {{ $article->comments->count() > 1 ? 'commentaires' : 'commentaire' }}</h4>
                        <div class="card shadow-0 border mb-3" style="background-color: #f0f2f5;">
                            <div class="card-body p-4">

                                {{-- FORMULAIRE DE COMMENTAIRES --}}
                                <form action="{{ route('comment', $article->id) }}" method="post">
                                    @method('post')
                                    @csrf
                                    <div class="form-outline mb-4">
                                        <input type="text" name="content" class="form-control" placeholder="Commentez..." value="{{ old('content') }}" autocomplete="off" />
                                    </div>
                                </form>
                                
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">

                                            {{-- AFFICHAGE DES COMMENTAIRES --}}
                                            <div class="col">
                                                @foreach($article->comments as $comment)
                                                    <div class="d-flex flex-start">
                                                   
                                                        {{-- PHOTO DE PROFILDE L'UTILISATEUR --}}
                                                        <img class="rounded-full object-cover w-10 h-10 sm:w-12 sm:h-12 profile-picture""
                                                        src="{{ Gravatar::get($comment->user->email) }}" alt="image de profil" width="55 height="55" />
                                                        <div class="flex-grow-1 flex-shrink-1">
                                                            <div>
                                                                <div class="d-flex justify-content-between align-items-center">

                                                                    {{-- NOM D'UTILISATEUR ET LA DATE DE CRÉATION DE SON COMMENTAIRE --}}
                                                                    <p class="mb-1">
                                                                        @<span class="username">{{ $comment->user->name }}</span> <span class="small">{{ $comment->created_at->diffForHumans() }}</span>
                                                                    </p>
                                                                    <div>

                                                                        {{-- MODIFICATION & SUPPRESSION DU COMMENTAIRE --}}
                                                                        <ul class="menu">
                                                                            @if (Auth::check() && ($comment->user_id == Auth::user()->id || Auth::user()->roles->contains('name', 'admin')))
                                                                                <li><button class="button"><i class="bi bi-three-dots-vertical"></i></button>
                                                                                    <ul class="sousmenu">
                                                                                        <li><a href="{{ route('comments.edit', $comment->id) }}">Modifier</a></li>
                                                                                        <form action="{{ route('comments.delete', $comment->id) }}" method="post">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                            <button class="btSimple">Supprimer</button>  
                                                                                        </form>                                                                          
                                                                                    </ul>
                                                                                </li>
                                                                            @endif
                                                                        </ul>                                                                   
                                                                    </div>
                                                                </div>
                                                                
                                                                {{-- AFFICHAGE DU COMMENTAIRE --}}                                                      
                                                                <p class="comment">
                                                                    {{ $comment->content }}
                                                                </p>                                                          
                                                                <div>
                                                                    {{-- BOUTONS LIKE & DISLIKE --}}
                                                                    <i class="bi bi-hand-thumbs-up" type="button"></i>
                                                                    <i class="bi bi-hand-thumbs-down" type="button"></i>
                                                                    
                                                                    {{-- BOUTON POUR RÉPONDRE AU COMMENTAIRE --}}
                                                                    <button class="btn btn-info" onclick="toggleReplyComment({{ $comment->id }})">Répondre</button>
                                                                    
                                                                    {{-- CHAMP POUR RÉPONSES => Ce formulaire est lié au bouton ci-haut grâce à "~" --}}
                                                                    <form action="{{ route('comments.replies.store', $comment) }}" id="replyComment~{{ $comment->id }}" class="ml-3 d-none" method="post">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <div class="input-container">                                                                     
                                                                            <input type="text" id="replyComment" name="content" placeholder="Saisissez votre réponse..." value="{{ old('content') }}" autocomplete="off" />
                                                                            
                                                                            <button class="btSimple mt-1">Répondre</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                            {{-- AFFICHAGE DES RÉPONSES --}}
                                                            <div class="reply-container">
                                                                @if($comment->replies->isNotEmpty())
                                                                    @if($comment->replies->count() > 1)
                                                                        <button class="toggle-reply mt-1">Afficher les réponses ( {{ $comment->replies->count() }} )</button>
                                                                    @else
                                                                        <button class="toggle-reply mt-1">Afficher la réponse ( {{ $comment->replies->count() }} )</button>
                                                                    @endif
                                                                @endif
                                                                <div class="replies d-none">
                                                                    @foreach ($comment->replies as $reply)
                                                                        <div class="d-flex flex-start mt-4">                                                                
                                                                            <a class="me-3" href="#">
                                                                                <img class="rounded-circle shadow-1-strong"
                                                                                src="{{ Gravatar::get($reply->user->email) }}" alt="image de profil" width="55 height="55" />
                                                                            </a>                                                                                                                                
                                                                            <div class="flex-grow-1 flex-shrink-1">
                                                                                <div>
                                                                                    <div class="d-flex justify-content-between align-items-center">

                                                                                        {{-- NOM D'UTILISATEUR ET LA DATE DE CRÉATION DE LA RÉPONSE --}}
                                                                                        <p class="mb-1">                                                                            
                                                                                            @<span class="username">{{ $reply->user->name }}</span> <span class="small">{{ $reply->created_at->diffForHumans() }}</span>                                                                            
                                                                                        </p>
                                                                                        <div>
                                                                                            <ul class="menu">
                                                                                                @if (Auth::check() && ($reply->user_id == Auth::user()->id || Auth::user()->roles->contains('name', 'admin')))
                                                                                                    <li><button class="button"><i class="bi bi-three-dots-vertical"></i></button>
                                                                                                        <ul class="sousmenu">

                                                                                                            {{-- MODIFICATION & SUPPRESSION DE LA RÉPONSE DU COMMENTAIRE --}}
                                                                                                            <li><a href="{{ route('comments.replies.edit', $reply->id) }}">Modifier</a></li>
                                                                                                            
                                                                                                            <form action="{{ route('comments.replies.delete', $reply->id) }}" method="post">
                                                                                                                @csrf
                                                                                                                @method('DELETE')
                                                                                                                <button class="btSimple">Supprimer</button>  
                                                                                                            </form>   
                                                                                                        </ul>
                                                                                                    </li>
                                                                                                @endif
                                                                                            </ul>
                                                                                        </div> 
                                                                                    </div>

                                                                                    {{-- AFFICHAGE DE LA RÉPONSE --}}                                                                            
                                                                                    <div class="reply">                                                                                
                                                                                        <p class="small mb-3">
                                                                                            {{ $reply->content }}
                                                                                        </p>
                                                                                    </div>                                                                       
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="text text-info">Aucun article trouvé</li>
        @endforelse
    </ul>

    {{-- PAGINATION --}}
    <div>
        {{ $articles->links() }}
    </div>
@endsection
