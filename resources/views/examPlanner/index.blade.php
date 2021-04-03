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
                                    <!-- EXAMS -->
                                    <div class="row">
                                        <div class="col-12 font-weight-bold" style="border-bottom: solid black 1px">
                                            <p><span style="background-color: #ffc6ff">Exams </span><span class="float-right"><i class="bi bi-journal-plus cursor class_action" data-toggle="modal" data-target="#newExamModal" onclick="examCreator('{{$examPlanner->dayFormatConverter($day)}}')"></i></span></p>
                                        </div>
                                    </div>
                                    @foreach($examPlanner->examsOnDay($day) as $exam)
                                        <div class="row"style="background-color:  #ffc6ff ">
                                            <div id="exam{{$exam->id}}" style="display: block;position: relative; visibility: hidden; top: -15em"></div>
                                            <div class="col-12 offset">
                                                <p>
                                                    <span class="font-weight-bold">{{$exam->course->name}}</span>
                                                </p>
                                                <p>{{$exam->getStartTime()}} - {{$exam->getEndTime()}}</p>
                                                <p>
                                                    <i class="bi bi-pencil-square float-left cursor" onclick="editExam('{{$exam->date}}',{{$exam->id}}, {{$exam->course->id}}, {{$examPlanner->id}},'{{$examPlanner->start_date}}', '{{$examPlanner->end_date}}', '{{$exam->getStartTime()}}', '{{$exam->getEndTime()}}')"  data-toggle="modal" data-target="#editExamModal"></i>
                                                    <i class="bi bi-trash float-right cursor" data-toggle="modal" data-target="#deleteExamModal" onclick="deleteExam({{$exam->id}})"></i>
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                <!-- STUDY -->
                                    <div class="row mt-3">
                                        <div class="col-12  font-weight-bold" style="border-bottom: solid black 1px">
                                            <p><span style="background-color: #fdffb6">Study </span><span class="float-right"><i class="bi bi-journal-plus cursor" data-toggle="modal" data-target="#newStudyModal" onclick="studyCreator('{{$examPlanner->dayFormatConverter($day)}}')" ></i></span></p>
                                        </div>
                                    </div>
                                    @foreach($examPlanner->studySessionsOnDay($day) as $study)
                                        <div id="study{{$study->id}}" style="display: block;position: relative; visibility: hidden; top: -15em"></div>
                                        <div class="row">
                                            <div class="col-12 offset">
                                                <p>
                                                    <span class="font-weight-bold">{{$study->course->name}}</span>
                                                </p>
                                                <p>{{$study->hours}} hours</p>
                                                <p>{{$study->info}}</p>
                                                <p>
                                                    <i class="bi bi-pencil-square float-left cursor"  data-toggle="modal" data-target="#editStudyModal" onclick="editStudy('{{$study->date}}',{{$study->id}}, {{$study->course->id}}, {{$examPlanner->id}},'{{$examPlanner->start_date}}', '{{$examPlanner->end_date}}', {{$study->hours}}, '{{$study->info}}' )"></i>
                                                    <i class="bi bi-trash float-right cursor" data-toggle="modal" data-target="#deleteStudyModal" onclick="deleteStudy({{$study->id}})"></i>
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach

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

    <!-- EDIT EXAM MODEL -->
    <div class="modal fade" id="editExamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action=""  id="ExamEditForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="dateEditExam">Date</label>
                            <input type="date" name="date" id="dateEditExam" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="courseEditExam">Course</label>
                            <select name="course" id="courseEditExam" class="form-control">
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
                        <div class="form-group">
                            <label for="startEditExam">Start time</label>
                            <input type="time" name="start_time" id="startEditExam" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="endEditExam">End time</label>
                            <input type="time" name="end_time" id="endEditExam" class="form-control">
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

    <!-- EXAM DELETE MODAL -->
    <div class="modal fade" id="deleteExamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action=""  id="ExamDeleteForm">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure you want to delete this exam?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-danger">Yes, I am sure</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- NEW STUDY MODAL -->
    <div class="modal fade" id="newStudyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New study session</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" @if($examPlanner !== null)action="/exam-planner/{{$examPlanner->id}}/study-session/create"@endif id="StudyCreateForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="studyDate">Date</label>
                            <input readonly type="date"   name="date" id="studyDate" class="form-control">
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
                        <div class="form-group">
                            <label for="info">Info</label>
                            <input type="text" name="info" id="info"
                                   class="form-control @error('info') is-invalid @enderror" required
                                   value="{{old('info')}}">
                            @error('info')
                            <p class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="hours">Study time</label>
                            <input type="number" name="hours" id="hours" step="0.25"
                                   class="form-control @error('hours') is-invalid @enderror" required
                                   value="{{old('hours')}}">
                            @error('hours')
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

    <!-- STUDY EDIT MODAL -->
    <div class="modal fade" id="editStudyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit study session</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action=""  id="StudyEditForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="dateEditExam">Date</label>
                            <input type="date" name="date" id="dateEditStudy" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="courseEditExam">Course</label>
                            <select name="course" id="courseEditStudy" class="form-control">
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
                        <div class="form-group">
                            <label for="infoEditStudy">Info</label>
                            <input type="text" name="info" id="infoEditStudy"
                                   class="form-control @error('info') is-invalid @enderror" required>
                            @error('info')
                            <p class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="hoursEditStudy">Study time</label>
                            <input type="number" name="hours" id="hoursEditStudy" step="0.25"
                                   class="form-control @error('hours') is-invalid @enderror" required>
                            @error('hours')
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

    <!-- STUDY DELETE MODAL -->
    <div class="modal fade" id="deleteStudyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete study session</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action=""  id="StudyDeleteForm">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure you want to delete this study session?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-danger">Yes, I am sure</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function examCreator(date){
            document.getElementById("examDate").value = date;
        }
        function studyCreator(date){
            document.getElementById("studyDate").value = date;
        }
        function editExam( date, id, course, examPlanner, startDay, endDay, startTime, endTime){
            document.getElementById('dateEditExam').value =date;
            document.getElementById("dateEditExam").min = startDay;
            document.getElementById("dateEditExam").max = endDay;
            document.getElementById('courseEditExam').value=course;
            document.getElementById('startEditExam').value = startTime;
            document.getElementById('endEditExam').value= endTime;
            document.getElementById('endEditExam').min=startTime;
            document.getElementById("ExamEditForm").action= "/exams/" + examPlanner + "/" + id + "/update";
        }
        function editStudy( date, id, course, examPlanner, startDay, endDay, hours, info){
            document.getElementById('dateEditStudy').value =date;
            document.getElementById("dateEditStudy").min = startDay;
            document.getElementById("dateEditStudy").max = endDay;
            document.getElementById('courseEditStudy').value=course;
            document.getElementById('infoEditStudy').value=info;
            document.getElementById('hoursEditStudy').value=hours;
            document.getElementById("StudyEditForm").action= "/study-sessions/" + examPlanner + "/" + id + "/update#exam" + id;
        }
        function deleteExam(examID){
            document.getElementById("ExamDeleteForm").action="/exams/" + examID + "/delete";
        }
        function deleteStudy(studyID){
            document.getElementById("StudyDeleteForm").action="/study-sessions/" + studyID + "/delete";
        }
    </script>

@endsection
