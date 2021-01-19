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
                        <div class="row mb-1 mx-1"
                             style="border: black solid 1px; border-radius: 15px; background-color: {{$course->randomColor()}}">
                            <div class="col-8 mt-1">
                                <p  style="font-size: 1.25em">{{$course->getName()}}</p>
                            </div>
                            <div class="col-1 mt-1">
                                <i class="bi bi-bookmark-plus align-middle cursor chapter_create" id="chapterCreate{{$course->id}}"
                                   style="font-size: 1.25em" data-toggle="modal" data-target="#newChapterModal"
                                   data-course="{{$course->getName()}}"
                                   data-action="/chapters/create/{{$course->id}}"></i>
                            </div>
                            <div class="col-1 mt-1">
                                <i class="bi bi-pencil cursor edit_course" id="CRS{{$course->id}}" data-toggle="modal" data-target="#editCourseModal"  data-name="{{$course->getName()}}" data-action="/courses/edit/{{$course->id}}" data-exam="{{$course->getExamForm()}}" style="font-size: 1.25em"></i>
                            </div>
                            <div class="col-1 mt-1">
                                <i class="bi bi-x-circle cursor delete_course" data-toggle="modal" id="CRSDEL{{$course->id}}" data-target="#deleteCourseModal" data-name="{{$course->getName()}}" data-action="/courses/delete/{{$course->id}}" style="font-size: 1.25em"></i>
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
                         style="border: black solid 1px; background-color:#3340a3;color: white; border-radius: 15px">
                        <div class="col-12">
                            <p class="mt-1 text-center" style="font-size: 1.25em">Statistics</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-12">
                            <div class="row" >
                                <div class="col-6" >Total tasks</div>
                                <div class="col-6">{{$period->getTotalChapters()}}</div>
                            </div>
                            <div class="row" >
                                <div class="col-6" >Completed</div>
                                <div class="col-6">{{$period->getChaptersCompletedAbsolute()}}%</div>
                            </div>
                            <div class="row" >
                                <div class="col-6" >Days left</div>
                                <div class="col-6">{{$period->getDaysToDueDate()}}</div>
                            </div>
                            <div class="row" >
                                <div class="col-6" >Due date</div>
                                <div class="col-6">{{$period->getDueDate()}}</div>
                            </div>
                            <div class="row" >
                                <div class="col-6" >Study rate</div>
                                <div class="col-6">{{$period->studyRate()}}x expected rate</div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12">
                    <p>No courses added for {{$period->getName()}}, why don't you add some?</p>
                </div>
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
    <!--EDIT COURSE MODAL -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit <span class="activeCourse"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="" id="courseEditForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" name="name" id="name"
                                   class="form-control editNameCourse @error('name') is-invalid @enderror" required
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
                                   class="form-control editExamFormCourse @error('exam_form') is-invalid @enderror" required
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
    <!-- DELETE COURSE MODAL-->
    <div class="modal fade" id="deleteCourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete <span class="activeCourse"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="" id="courseDeleteForm">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure you want to delete <span class="activeCourse"></span>? All chapters that belong to <span class="activeCourse"></span> will get destroyed too.</p>
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
                //FINDING ELEMENTS OF ROWS AND STORING THEM IN VARIABLES
                let id = $(this).attr("id");
                let name = document.getElementById(id).dataset['course'];
                let action = document.getElementById(id).dataset['action'];
                $('.activeCourse').text(name);
                $('#chapterCreateForm').attr('action', action);
            });
        });
        $(function () {
            $(".edit_course").click(function () {
                //FINDING ELEMENTS OF ROWS AND STORING THEM IN VARIABLES
                let id = $(this).attr("id");
                let name = document.getElementById(id).dataset['name'];
                let action = document.getElementById(id).dataset['action'];
                let exam = document.getElementById(id).dataset['exam'];
                $('.activeCourse').text(name);
                $('#courseEditForm').attr('action', action);
                $('.editNameCourse').val(name);
                $('.editExamFormCourse').val(exam);
            });
        });
        $(function () {
            $(".delete_course").click(function () {
                console.log("yessss");
                //FINDING ELEMENTS OF ROWS AND STORING THEM IN VARIABLES
                let id = $(this).attr("id");
                let name = document.getElementById(id).dataset['name'];
                let action = document.getElementById(id).dataset['action'];
                $('.activeCourse').text(name);
                $('#courseDeleteForm').attr('action', action);
            });
        });

    </script>
@endsection
