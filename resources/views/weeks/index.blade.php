@extends('layout.authenticated')
@section('nav')
@section('nav')
    <li class="nav-item">
        <a class="nav-link" href="/periods/{{$period->id}}">{{$period->name}}</a>
    </li>
@endsection
@endsection
@section('content')
    <div class="container mb-5 pb-5">
        <div class="row">
            <div class="col-12 text-center">
                <h2>WEEK PLANNER</h2>
                <p>New week: <i class="bi bi-calendar2-plus cursor" data-toggle="modal" data-target="#newWeekModal" style="font-size: 2em"></i></p>
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

        <div class="row mb-4">
            <div class="col-10 offset-1 text-center" style="border: black solid 1px; border-radius: 25px">
                <h4>Current week</h4>
            </div>
        </div>
        <div class="row">
            @if($week!== null && collect($week->getDays()!= null))
                @foreach($week->getDays() as $day)
                  <div class="col-lg-4 col-md-6 col-sm-12 pb-5" style="border:solid 1px black;">
                      <div class="row">
                          <div class="col-12">
                              <p class="font-weight-bold text-center my-3" style="background-color: #caf0f8; border-radius: 10px">{{$week->dayExtraInfo($day)}}</p>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-8 offset-2 font-weight-bold" style="border-bottom: solid black 1px">
                              <p>Classes <span class="float-right"><i class="bi bi-journal-plus cursor class_action" data-toggle="modal" data-target="#newClassModal" data-date="{{$week->dayFormatConverter($day)}}" id="DAY{{$day}}"></i></span></p>
                          </div>
                      </div>
                      @foreach($week->lessonsOnDay($day) as $lesson)
                          <div class="row">
                              <div class="col-10 offset-2">
                                  <p><span class="font-weight-bold">{{$lesson->course->name}}</span> {{$lesson->name}}</p>
                                  <p>{{$lesson->getStartTime()}} - {{$lesson->getEndTime()}}</p>
                              </div>
                          </div>
                      @endforeach
                  </div>
                @endforeach
            @else
                        <p>No week planned.</p>
            @endif
        </div>

        <!-- FIRST FUTURE WEEK -->
        <div class="row mt-5 mb-4">
            <div class="col-10 offset-1 text-center" style="border: black solid 1px; border-radius: 25px">
                <h4>Next planned week</h4>
            </div>
        </div>
        <div class="row">
            @if($firstFuture!== null && collect($firstFuture->getDays()!= null))
                @foreach($firstFuture->getDays() as $day)
                    <div class="col-lg-4 col-md-6 col-sm-12 pb-5" style="border:solid 1px black;">
                        <div class="row">
                            <div class="col-12">
                                <p class="font-weight-bold text-center my-3" style="background-color: #caf0f8; border-radius: 10px">{{$firstFuture->dayExtraInfo($day)}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8 offset-2 font-weight-bold" style="border-bottom: solid black 1px">
                                <p>Classes <span class="float-right"><i class="bi bi-journal-plus cursor class_action" data-toggle="modal" data-target="#newClassModalFTW" data-date="{{$firstFuture->dayFormatConverter($day)}}" id="DAYFT{{$day}}"></i></span></p>
                            </div>
                        </div>
                        @foreach($firstFuture->lessonsOnDay($day) as $lesson)
                            <div class="row">
                                <div class="col-10 offset-2">
                                    <p><span class="font-weight-bold">{{$lesson->course->name}}</span> {{$lesson->name}}</p>
                                    <p>{{$lesson->getStartTime()}} - {{$lesson->getEndTime()}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @else
                <p>No week planned.</p>
            @endif
        </div>
    </div>

    {{--NEW WEEK MODAL--}}
    <div class="modal fade" id="newWeekModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New week</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="/periods/{{$period->id}}/week-planner/create" id="weekCreateForm">
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
                                   class="form-control @error('start_date') is-invalid @enderror" required
                                   value="{{$nextDay}}">
                            @error('start_date')
                            <p class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="end_date">End date</label>
                            <input type="date" name="end_date" id="end_date"
                                   class="form-control @error('end_date') is-invalid @enderror" required
                                   value="{{$endDay}}">
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

    <!--NEW CLASS MODAL CURRENT WEEK -->
    <div class="modal fade" id="newClassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New class for current week</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" @if($week !== null)action="/weeks/{{$week->id}}/class/create"@endif id="classCreateForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="classDate">Date</label>
                            <input readonly type="date" id="classDate" name="date" class="form-control classDate">
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
    <!--NEW CLASS MODAL FUTURE WEEK -->
    <div class="modal fade" id="newClassModalFTW" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New class for next week</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" @if($firstFuture !== null)action="/weeks/{{$firstFuture->id}}/class/create"@endif id="classCreateForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="classDate">Date</label>
                            <input readonly type="date" id="classDate"  name="date" class="form-control classDate">
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
        $(function () {
            $(".class_action").click(function () {
                console.log("setDate");
                let id = $(this).attr("id");
                let date = document.getElementById(id).dataset['date'];
                $('.classDate').val(date);
                console.log(date);
            });
        });

    </script>
@endsection

