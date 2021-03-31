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
                        <div class="row seven-cols">
                            @foreach($week as $day)
                                <div class="col" style="padding: 1em; border: solid black 2px">
                                    <div class="row">
                                        <div class="col-12">
                                          <p class="font-weight-bold text-center my-3" style="background-color: #caf0f8; border-radius: 10px">{{$examPlanner->dayExtraInfo($day)}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8 offset-2 font-weight-bold" style="border-bottom: solid black 1px">
                                            <p><span style="background-color: #ffc6ff">Exams </span><span class="float-right"><i class="bi bi-journal-plus cursor class_action" data-toggle="modal" data-target="#newExamModal" onclick="examCreator('{{$examPlanner->dayFormatConverter($day)}}')"></i></span></p>
                                        </div>
                                    </div>
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
    <!-- NEW EXAM MODEL -->
    <div class="modal fade" id="newExamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" @if($examPlanner !== null)action="/exam-planner/{{$examPlanner->id}}/exam/create"@endif id="examCreateForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="classDate">Date</label>
                            <input readonly type="date" id="examDate" name="date" class="form-control examDate">
                        </div>
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
                        <div class="form-group">
                            <label for="course">Course</label>
                            <select name="course" id="course" class="form-control">
                                @foreach($period->courses as $course)
                                    <option value="{{$course->id}}">{{$course->name}}</option>
                                @endforeach
                            </select>
                            @error('course')
                            <p class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="start_time">Start time</label>
                            <input type="time" name="start_time" id="start_time"
                                   class="form-control @error('start_time') is-invalid @enderror" required
                                   value="{{old('start_time')}}">
                            @error('start_time')
                            <p class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="end_time">End time</label>
                            <input type="time" name="end_time" id="end_time"
                                   class="form-control @error('end_time') is-invalid @enderror" required
                                   value="{{old('end_time')}}">
                            @error('end_time')
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

    <script>
        function examCreator(date){
            document.getElementById("examDate").value = date;
        }
    </script>

@endsection
