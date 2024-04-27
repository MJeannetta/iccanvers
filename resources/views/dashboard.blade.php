@extends('layouts/app')

@section('content')
    <div style="color:green">
        Salut <strong>{{Auth::user()->fullname()}}</strong> !
    </div>
@endsection