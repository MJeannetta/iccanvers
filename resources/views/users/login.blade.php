@extends('layouts/app')

@section('title', 'Se connecter')

@section('content')
    {{-- NOTIFICATION DE SUCCÈS de l'inscription --}}
    <div class="card-md-4 mt-3">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="card">
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- FORMULAIRE DE CONNEXION --}}
                <form action="{{ route('login') }}" method="post">
                    @method('post')
                    @csrf
                    <h4>Connectez-vous</h4>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Entrez l'email" value="{{ old('email') }}" >
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="password">Mot de pase</label>
                    <input type="password" name="password" id="password" class="form-control" >
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    
                    <div class="buttons">
                        <button class="btn btn-info mt-1">Se connecter</button>
                    </div>
                </form>
                <p class="mt-1">Pas membre ? <a href="{{ route('registration') }}">S'inscrire</a></p>
            </div>
        </div>
    </div>
@endsection