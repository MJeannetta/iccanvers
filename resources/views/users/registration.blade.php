@extends('layouts/app')

@section('title', 'S\'inscrire')

@section('content')
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="card">
            <div class="card-body">
                {{-- FORMULAIRE D'INSCRIPTION --}}
                <form action="{{ route('registration') }}" method="post">
                    @csrf
                    <h4>Inscrivez-vous</h4>

                    <label for="name">Nom</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Entrez le nom" value="{{ old('name') }}">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Entrez l'email" value="{{ old('email') }}">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control">
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label>Sexe</label>
                    <div>
                        <input type="radio" id="homme" name="gender" value="Male">
                        <label for="homme">Homme</label>
                    </div>
                    <div>
                        <input type="radio" id="femme" name="gender" value="Female">
                        <label for="femme">Femme</label>
                    </div>
                    @error('gender')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="birthDate">Date de naissance</label>
                    <input type="date" name="birthDate" id="birthDate" class="form-control datepicker" required>
                    @error('birthDate')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="">Ville</label>
                    <select name="location" class="form-control" required>
                        <option value="" selected disabled>-- Choisissez une ville --</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                    @error('town')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="buttons">
                        <button type="submit" class="btn btn-info mt-1">S'inscrire</button>
                    </div>
                    <p class="mt-1">Déjà membre ? <a href="{{ route('login') }}">Se connecter</a></p>
                </form>
            </div>
        </div>
    </div>
@endsection