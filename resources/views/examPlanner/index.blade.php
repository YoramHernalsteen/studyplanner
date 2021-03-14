@extends('layout.authenticated')
@section('nav')
    <li class="nav-item">
        <a class="nav-link" href="/periods/{{$period->id}}">{{$period->name}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/periods/{{$period->id}}/week-planner">week planner</a>
    </li>
@endsection
@section('content')
    <div class="container">
        <p>EXAM PLANNER SAYS WHATUP BITCHES</p>
    </div>

@endsection
