@extends('layouts/app')

@section('content')
    <div style="color:green">
        Salut <strong>{{Auth::user()->name}}</strong> !
    </div>
@endsection