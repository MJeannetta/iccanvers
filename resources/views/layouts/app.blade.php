<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous" defer></script>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <title>@yield('title')</title>
</head>
<body>
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="{{ route('accueil') }}">MON SITE</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">À PROPOS</a>
          </li>

          <li class="nav-item active">
            <a class="nav-link" href="{{ route('ministries.index') }}">MINISTÈRES</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('events.index') }}">ÉVÉNEMENTS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('articles.index') }}">BLOG</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('form.contact.google') }}">CONTACT</a>
          </li>
          @auth()
            <li class="nav-item">
              <a class="nav-link" href="{{ route('logout') }}">SE DÉCONNECTER</a>
            </li>
          @endauth
          @guest()
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">SE CONNECTER</a>
            </li>
          @endguest
        </ul>
        {{--
          <form class="form-inline my-2 my-lg-0" action="{{ route('eventSearch') }}" method="get">
            <input class="form-control mr-sm-2" type="search" name="query" placeholder="Recherche l'événement..." aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0 ml-auto" type="submit">Rechercher</button>
          </form>
        --}}
      </div> 
    </nav>

    <div>
      @yield('extra_js')
    </div>
    <div>
      @yield('carroussel')
    </div>
    <div>
      @yield('content')
    </div>
  </div>
</body>
</html>