@extends('layouts/app')

@section('content')
    <div class="row mt-2">
        <div class="col-md-4">
            <div class="card-md-4 mt-3">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('articles.update', $article->id) }}" method="post">
                            @method('put')
                            @csrf
                            <h4>Modifier l'article</h4>

                            <label for="titre">Modifier un titre</label>
                            <input type="text" name="titre" id="titre" class="form-control" value="{{ $article->titre }}">
                            <label for="description">Modifier la description</label>
                            <textarea name="description" id="description" class="form-control mt-1">{{ $article->description }}</textarea>

                            <div class="buttons">
                                <button class="btn btn-success mt-1">Actualiser</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection