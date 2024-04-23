@extends('layouts/app')

@section('title', 'Accueil')

@section('carroussel')
    <div class="container">
      <div id="diaporama" class="carousel slide" data-bs-ride="carousel">

        {{-- CARROUSSEL --}}
        <div class="carousel-inner">
          <div class="carousel-item active">
		  
            <img src="https://www.pierre-giraud.com/bootstrap-carrousel-slide-1.jpg" alt="Carrousel slide 1" class="d-block w-100">
            <div class="carousel-caption d-none d-md-block">
              
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://www.pierre-giraud.com/bootstrap-carrousel-slide-2.jpg" alt="Carrousel slide 2" class="d-block w-100">
            <div class="carousel-caption d-none d-md-block text-dark">
              
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://www.pierre-giraud.com/bootstrap-carrousel-slide-3.jpg" alt="Carrousel slide 3" class="d-block w-100">
            <div class="carousel-caption d-none d-md-block">
              
            </div>
          </div>
        </div>

        {{-- CONTRÔLES --}}
        <button class="carousel-control-prev" data-bs-target="#diaporama" type="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" data-bs-target="#diaporama" type="button" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
    </div>
@endsection