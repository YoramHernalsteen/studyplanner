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
    <div class="container mb-5">
        <div class="row">
            <div class="col-12 text-center">
                <h2>EXAM PLANNER</h2>
                <p>New exam planner: <i class="bi bi-calendar2-plus cursor" data-toggle="modal"
                                        data-target="#newPlannerModal" style="font-size: 2em"></i></p>
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
            @if(session('error-message'))
                <div class="alert alert-danger col-md-12">
                    {{session('error-message')}}
                </div>
            @endif
        </div>

        <div class="row mb-5 pb-5">
            <div class="col-12">
                @if($examPlanner !== null)
                    @foreach(array_chunk($examPlanner->getDays(), 7) as $week)
                        <div class="row">
                            @foreach($week as $day)
                                <div class="col" style="padding: 1em; border: solid black 2px">
                                    {{$day}}
                                </div>
                            @endforeach
                        </div>

                    @endforeach
                @else
                    <div class="row">
                        <div class="col-6 offset-3">
                            <p>No exam planner</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- NEW PLANNER MODAL-->
    <div class="modal fade" id="newPlannerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New exam planner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="/periods/{{$period->id}}/exam-planner/create" id="plannerCreateForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name"
                                   class="form-control @error('name') is-invalid @enderror" required
                                   value="{{old('name')}}">
                            @error('name')
                            <p class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="start_date">Start date</label>
                            <input type="date" name="start_date" id="start_date"
                                   class="form-control @error('start_date') is-invalid @enderror" required>
                            @error('start_date')
                            <p class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="end_date">End date</label>
                            <input type="date" name="end_date" id="end_date"
                                   class="form-control @error('end_date') is-invalid @enderror" required>
                            @error('end_date')
                            <p class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-danger">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
