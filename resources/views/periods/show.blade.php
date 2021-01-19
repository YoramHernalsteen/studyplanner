@extends('layout.authenticated')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2>OVERVIEW FOR {{$period->getName()}}</h2>
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
            <div class="col-12">
                <p><i class="bi bi-plus-square cursor" style="font-size: 2em" data-toggle="modal"
                                           data-target="#newCourseModal"></i></p>
            </div>
        </div>
        <div class="row">
            @if(collect($courses)->isNotEmpty())
                @foreach($courses as $course)
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                        <div class="row mb-1 mx-1 "
                             style="border: black solid 1px; background-color: {{$course->randomColor()}}">
                            <div class="col-9">
                                <h4>{{$course->getName()}} : {{$course->chapterCount()}}</h4>
                            </div>
                            <div class="col-3">
                                <i class="bi bi-bookmark-plus cursor chapter_create" id="chapterCreate{{$course->id}}"
                                   style="font-size: 1.75em" data-toggle="modal" data-target="#newChapterModal"
                                   data-course="{{$course->getName()}}"
                                   data-action="/chapters/create/{{$course->id}}"></i>
                            </div>
                        </div>
                        @if(collect($course->getChapters)->isNotEmpty())
                            <div class="row mx-1">
                                <div class="col-12">
                                    @foreach($course->getChapters as $chapter)
                                        <div class="row" style="height: 1.6em">
                                            <div class="col-6" style="font-size: 0.75em">{{$chapter->getName()}}</div>
                                            <div class="col-6">
                                                <form method="post" action="/chapters/change-status/{{$chapter->id}}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="form-group btn-group btn-group-toggle col-12"
                                                             onchange="this.form.submit()" data-toggle="buttons">
                                                            <label class="col-4 btn btn-outline-danger "
                                                                   style="font-size: 0.5em">
                                                                <input type="radio" name="status"
                                                                       onchange="this.form.submit()" id="option1"
                                                                       autocomplete="off" value="not-started"
                                                                       @if($chapter->getStatus()=== "not-started") checked @endif>
                                                                <i class="bi bi-square"></i>
                                                            </label>
                                                            <label class="col-4 btn btn-outline-warning"
                                                                   style="font-size: 0.5em">
                                                                <input type="radio" name="status"
                                                                       onchange="this.form.submit()" id="option2"
                                                                       autocomplete="off" value="busy"
                                                                       @if($chapter->getStatus()=== "busy") checked @endif>
                                                                <i class="bi bi-square-half"></i>
                                                            </label>
                                                            <label class="col-4 btn btn-outline-success"
                                                                   style="font-size: 0.5em">
                                                                <input type="radio" name="status"
                                                                       onchange="this.form.submit()" id="option3"
                                                                       autocomplete="off" value="done"
                                                                       @if($chapter->getStatus()=== "done") checked @endif>
                                                                <i class="bi bi-check-square-fill"></i>
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
                    </div>
                @endforeach
            <!--STATS -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                    <div class="row mb-1 mx-1 "
                         style="border: black solid 1px; background-color:red;color: white">
                        <div class="col-12">
                            <h4>STATISTICS</h4>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-12">
                            <div class="row" >
                                <div class="col-6" >Total tasks</div>
                                <div class="col-6"></div>
                            </div>
                            <div class="row" >
                                <div class="col-6" >Completed</div>
                                <div class="col-6"></div>
                            </div>
                            <div class="row" >
                                <div class="col-6" >Days left</div>
                                <div class="col-6">15</div>
                            </div>
                            <div class="row" >
                                <div class="col-6" >Due date</div>
                                <div class="col-6">15</div>
                            </div>
                            <div class="row" >
                                <div class="col-6" >Study rate</div>
                                <div class="col-6">15</div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            @endif
        </div>
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
                <form method="POST" action="/courses/create/{{$period->id}}" id="courseCreateForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Title</label>
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
                            <label for="exam_form">Exam form</label>
                            <input type="text" name="exam_form" id="exam_form"
                                   class="form-control @error('exam_form') is-invalid @enderror" required
                                   value="{{old('exam_form')}}">
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
    <!-- NEW CHAPTER -->
    <div class="modal fade" id="newChapterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New chapter for <span class="activeCourse"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="" id="chapterCreateForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Title</label>
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
                            <label for="pages">Pages</label>
                            <input type="numeric" name="pages" id="pages"
                                   class="form-control @error('pages') is-invalid @enderror" required
                                   value="{{old('pages')}}">
                            @error('pages')
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

    <!--JAVASCRIPT -->
    <script>
        $(function () {
            $(".chapter_create").click(function () {
                console.log("yessss");
                //FINDING ELEMENTS OF ROWS AND STORING THEM IN VARIABLES
                let id = $(this).attr("id");
                let name = document.getElementById(id).dataset['course'];
                let action = document.getElementById(id).dataset['action'];
                $('.activeCourse').text(name);
                $('#chapterCreateForm').attr('action', action);
            });
        });

    </script>
@endsection
