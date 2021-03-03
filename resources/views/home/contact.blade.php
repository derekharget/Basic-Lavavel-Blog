@extends('layouts.app')

@section('title', "contact page")
    

@section('content')
    <h1>contact</h1>

    @can('home.secret')
        <p><a href="{{ route('secret') }}">Special account details</a></p>

    @endcan
@endsection