@extends('layout.authenticated')
@section('nav')
    <li class="nav-item">
        <a class="nav-link" href="/periods/{{$course->period->id}}">{{$course->period->name}}</a>
    </li>
@endsection
@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-12 text-center">
                <p style="font-size: 2em">{{$course->name}}</p>
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
            <div class="col-10">
                <p style="font-size: 2em">Chapters</p>
            </div>
            <div class="col-2">
                <p style="font-size: 1.75em">
                    <i class="bi bi-bookmark-plus align-middle cursor"
                       data-toggle="modal" data-target="#newChapterModal"></i>
                </p>
            </div>
        </div>
        @foreach($course->getChapters as $chapter)
        <div class="row">
            <div class="col-5" style="font-size: 1em">{{$chapter->getName()}}, {{$chapter->getPages()}}p</div>
            <div class="col-4">
                <form method="post" action="/chapters/change-status/{{$chapter->id}}">
                    @csrf
                    <input type="hidden" value="/courses/show/{{$course->id}}" style="" name="action_url">
                    <div class="row">
                        <div class="form-group btn-group btn-group-toggle col-12"
                             onchange="this.form.submit()" data-toggle="buttons">
                            <label class="col-4 btn btn-outline-danger "
                                   style="font-size: 0.65em">
                                <input type="radio" name="status"
                                       onchange="this.form.submit()" id="option1"
                                       autocomplete="off" value="not-started"
                                       @if($chapter->getStatus()=== "not-started") checked @endif>
                                <i class="bi bi-square"></i>
                            </label>
                            <label class="col-4 btn btn-outline-warning"
                                   style="font-size: 0.65em">
                                <input type="radio" name="status"
                                       onchange="this.form.submit()" id="option2"
                                       autocomplete="off" value="busy"
                                       @if($chapter->getStatus()=== "busy") checked @endif>
                                <i class="bi bi-square-half"></i>
                            </label>
                            <label class="col-4 btn btn-outline-success"
                                   style="font-size: 0.65em">
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
            <div class="col-3">
                <i class="bi bi-pencil cursor edit_chapter" id="CHPT{{$chapter->id}}" data-toggle="modal" data-target="#editChapterModal"  data-name="{{$chapter->getName()}}" data-action="/chapters/edit/{{$chapter->id}}" data-pages="{{$chapter->getPages()}}" style="font-size: 1em"></i>
                <i class="bi bi-x-circle cursor delete_chapter" data-toggle="modal" id="CHPTDEL{{$chapter->id}}" data-target="#deleteChapterModal" data-name="{{$chapter->getName()}}" data-action="/chapters/delete/{{$chapter->id}}" style="font-size: 1em"></i>
            </div>
        </div>
        @endforeach
        <div class="row mt-2">
            <div class="col-12">
                <p style="font-size: 2em">Statistics</p>
            </div>
        </div>
        <div class="row mx-1">
            <div class="col-12">
                <div class="row" >
                    <div class="col-6" >Total tasks</div>
                    <div class="col-6">{{$course->chapterCount()}}</div>
                </div>
                <div class="row" >
                    <div class="col-6" >Tasks Completed</div>
                    <div class="col-6">{{$course->getCompletedChaptersAbsolutePercent()}}%</div>
                </div>
                <div class="row" >
                    <div class="col-6" >Total pages</div>
                    <div class="col-6">{{$course->getTotalPages()}}</div>
                </div>
                <div class="row" >
                    <div class="col-6" >Pages completed</div>
                    <div class="col-6">{{$course->getPagesCompletedPercent()}}%</div>
                </div>
                <div class="row" >
                    <div class="col-6" >Days left</div>
                    <div class="col-6">{{$course->period->getDaysToDueDate()}}</div>
                </div>
                <div class="row" >
                    <div class="col-6" >Due date</div>
                    <div class="col-6">{{$course->period->getDueDate()}}</div>
                </div>
                <div class="row" >
                    <div class="col-6" >Study rate</div>
                    <div class="col-6">{{$course->studyRate()}}x expected rate</div>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-12">
                <p style="font-size: 2em">Extra info</p>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-12">
                <p style="font-size: 1em">Exam is: {{$course->getExamForm()}}</p>
            </div>
        </div>
    </div>
    <!--NEW CHAPTER -->
    <div class="modal fade" id="newChapterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New chapter for {{$course->name}}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="/chapters/create/{{$course->id}}" id="chapterCreateForm">
                    @csrf
                    <input type="hidden" value="/courses/show/{{$course->id}}" name="action_url">
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
    <!--EDIT CHAPTER -->
    <div class="modal fade" id="editChapterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit chapter <span class="activeChapter"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="" id="chapterEditForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" name="name" id="name"
                                   class="form-control chapterName @error('name') is-invalid @enderror" required
                                   value="{{old('name')}}">
                            @error('name')
                            <p class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="pages">Pages</label>
                            <input type="numeric" name="pages" id="pages" min="0"
                                   class="form-control chapterPages @error('pages') is-invalid @enderror" required
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
    <!-- DELETE CHAPTER -->
    <div class="modal fade" id="deleteChapterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete <span class="activeChapter"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="" id="chapterDeleteForm">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure you want to delete <span class="activeChapter"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--JAVASCRIPT -->
    <script>
        $(function () {
            $(".edit_chapter").click(function () {
                //FINDING ELEMENTS OF ROWS AND STORING THEM IN VARIABLES
                let id = $(this).attr("id");
                let name = document.getElementById(id).dataset['name'];
                let action = document.getElementById(id).dataset['action'];
                let pages = document.getElementById(id).dataset['pages'];
                $('.activeChapter').text(name);
                $('#chapterEditForm').attr('action', action);
                $('.chapterName').val(name);
                $('.chapterPages').val(pages);
            });
        });
        $(function () {
            $(".delete_chapter").click(function () {
                //FINDING ELEMENTS OF ROWS AND STORING THEM IN VARIABLES
                let id = $(this).attr("id");
                let name = document.getElementById(id).dataset['name'];
                let action = document.getElementById(id).dataset['action'];
                $('.activeChapter').text(name);
                $('#chapterDeleteForm').attr('action', action);
            });
        });
    </script>
@endsection
