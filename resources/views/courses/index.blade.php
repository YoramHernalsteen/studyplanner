@extends('layout.authenticated')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2>OVERVIEW</h2>
            </div>
        </div>
        @if ($errors->any())
            <div class="row alert alert-danger mt-3">
                @foreach ($errors->all() as $error)
                    <p class="w-100">{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <p>Hey, {{$user->name}}  <i class="bi bi-plus-square cursor" style="font-size: 2em" data-toggle="modal" data-target="#newCourseModal"></i></p>
            </div>
        </div>
        @if(collect($courses)->isNotEmpty())
            @foreach($courses as $course)
                <div class="row">
                    <div class="col-7">
                        <h4>{{$course->getName()}}</h4>
                    </div>
                    <div class="col-5">
                        <i class="bi bi-bookmark-plus" style="font-size: 1.25em"></i>
                    </div>
                </div>

                @if(collect($course->getChapters)->isNotEmpty())
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-5 font-weight-bold">Title</div>
                            <div class="col-2 font-weight-bold">Pages</div>
                            <div class="col-5 font-weight-bold">Status</div>
                        </div>
                        <hr>
                            @foreach($course->getChapters as $chapter)
                                <div class="row">
                                    <div class="col-5">{{$chapter->getName()}}</div>
                                    <div class="col-2">{{$chapter->getPages()}}</div>
                                    <div class="col-5">
                                        <form method="post" action="/chapters/change-status/{{$chapter->id}}">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group btn-group btn-group-toggle col-12" onchange="this.form.submit()" data-toggle="buttons">
                                                    <label class="col-4 btn btn-outline-danger">
                                                        <input type="radio" name="status" onchange="this.form.submit()" id="option1" autocomplete="off" value="not-started" @if($chapter->getStatus()=== "not-started") checked @endif> <i class="bi bi-square"></i>
                                                    </label>
                                                    <label class="col-4 btn btn-outline-danger">
                                                        <input type="radio" name="status" onchange="this.form.submit()" id="option2" autocomplete="off" value="busy" @if($chapter->getStatus()=== "busy") checked @endif> <i class="bi bi-square-half"></i>
                                                    </label>
                                                    <label class="col-4 btn btn-outline-danger">
                                                        <input type="radio" name="status" onchange="this.form.submit()" id="option3" autocomplete="off" value="done" @if($chapter->getStatus()=== "done") checked @endif> <i class="bi bi-check-square-fill"></i>
                                                    </label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                    </div>
                </div>
                @endif
            @endforeach
        @else
        @endif
    </div>

    <!--NEW COURSE MODAL -->
    <div class="modal fade" id="newCourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="/courses/create" id="courseCreateForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" name="name" id="name"
                                   class="form-control @error('name') is-invalid @enderror" required value="{{old('name')}}">
                            @error('name')
                            <p class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="exam_form">Exam form</label>
                            <input type="text" name="exam_form" id="exam_form"
                                   class="form-control @error('exam_form') is-invalid @enderror" required value="{{old('exam_form')}}">
                            @error('exam_form')
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
