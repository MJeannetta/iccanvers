@extends('layouts/app')

@section('title', 'Formulaire de contact')

@section('content')

  {{-- NOTIFICATION DE SUCCÈS --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- <div class="container min-vh-100 d-flex justify-content-center align-items-center"> POUR CENTRE UN FORMULAIRE --}}
  <h1 class="mt-2">Contactez-nous</h1>
  <div class="row mt-1 min-vh-100">
    <div class="col-md-4">
      <div class="card-md-4 mt-3">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('send.message.google') }}" class="form-product" method="post">
              @csrf
              @method('post')
              <label for="name"><b>Nom</b></label>
              <input type="text" id="name" name="name" class="form-control" placeholder="Votre nom..">
              
              @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror

              <label for="email"><b>Email</b></label>
              <input type="email" id="email" name="email" class="form-control" placeholder="Votre email..">
              
              @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror

              <label for="message"><b>Message</b></label>
              <textarea id="message" name="message" class="form-control" placeholder="Ecrivez quelque chose.." style="height:200px"></textarea>
              
              @error('message')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror

              <div><button class="btn btn-primary">Envoyer</button></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection