@extends('layout.authenticated')
@section('nav')
@section('nav')
    <li class="nav-item">
        <a class="nav-link" href="/periods/{{$period->id}}">{{$period->name}}</a>
    </li>
@endsection
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2>WEEK PLANNER</h2>
            </div>
        </div>
        @if ($errors->any())
            <div class="row alert alert-danger mt-3">
                @foreach ($errors->all() as $error)
                    <p class="w-100">{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <div class="row mt-3">
            @if(session('message'))
                <div class="alert alert-success col-md-12">
                    {{session('message')}}
                </div>
            @endif
        </div>
        <div class="row">
                @forelse($week->getDays() as $day)
                  <div class="col-lg-4 col-md-6 col-sm-12 mb-5">
                      <p class="font-weight-bold text-center">{{$day}}</p>
                  </div>
                @empty
                    <p>No week planned.</p>
                @endforelse
        </div>
    </div>
@endsection
