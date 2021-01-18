@extends('layout.authenticated')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2>OVERVIEW</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p>Hey, {{$user->name}}</p>
            </div>
        </div>
    </div>
@endsection
