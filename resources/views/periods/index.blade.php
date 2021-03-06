@extends('layout.authenticated')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2>SEMESTER OVERVIEW</h2>
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
            <div class="col-8">
                <p style="font-size: 2em">Hey, {{$user->name}}!</p>
            </div>
            <div class="col-4">
                <i class="bi bi-plus-square cursor" style="font-size: 2em" data-toggle="modal"
                   data-target="#newPeriodModal"></i>
            </div>
        </div>
        @forelse($periods as $period)
            <div class="row p-2 mb-2" style="border: solid black 1px; border-radius: 15px">
                <div class="col-8">
                    <a href="/periods/{{$period->id}}" class="semLink">{{$period->name}} [{{$period->getDueDate()}}]</a>
                </div>
                <div class="col-2">
                    <i class="bi bi-pencil cursor edit_period" id="PER{{$period->id}}" data-toggle="modal" data-target="#editPeriodModal" data-date="{{$period->due_date}}" data-name="{{$period->getName()}}" data-action="/periods/edit/{{$period->id}}" style="font-size: 1.5em"></i>
                </div>
                <div class="col-2">
                    <i class="bi bi-x-circle cursor delete_period" data-toggle="modal" id="PERDEL{{$period->id}}" data-target="#deletePeriodModal" data-name="{{$period->getName()}}" data-action="/periods/delete/{{$period->id}}" style="font-size: 1.5em"></i>
                </div>
            </div>
        @empty
            <div class="row">
                <div class="col-12 p-2">
                  <p>No semesters/trimesters/quarters added! Why don't you add some?</p>
                </div>
            </div>
        @endforelse
    </div>

    <!--NEW SEMESTER MODAL -->
    <div class="modal fade" id="newPeriodModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New semester/trimester/quarter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="/periods/create" id="periodCreateForm">
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
                            <label for="due_date">Due date</label>
                            <input type="date" name="due_date" id="due_date"
                                   class="form-control @error('due_date') is-invalid @enderror" required
                                   value="{{old('due_date')}}">
                            @error('due_date')
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
    <!--EDIT SEMESTER MODAL -->
    <div class="modal fade" id="editPeriodModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit <span class="activePeriod"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="" id="periodEditForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" name="name" id="name"
                                   class="form-control editName @error('name') is-invalid @enderror" required
                                   value="{{old('name')}}">
                            @error('name')
                            <p class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="due_date">Due date</label>
                            <input type="date" name="due_date" id="due_date"
                                   class="form-control editDueDate @error('due_date') is-invalid @enderror" required
                                   value="{{old('due_date')}}">
                            @error('due_date')
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
    <!--DELETE SEMESTER MODAL -->
    <div class="modal fade" id="deletePeriodModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete <span class="activePeriod"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="" id="periodDeleteForm">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure you want to delete <span class="activePeriod"></span>? All courses that belong to <span class="activePeriod"></span> will get destroyed too.</p>
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
            $(".edit_period").click(function () {
                //FINDING ELEMENTS OF ROWS AND STORING THEM IN VARIABLES
                let id = $(this).attr("id");
                let name = document.getElementById(id).dataset['name'];
                let action = document.getElementById(id).dataset['action'];
                let dueDate = document.getElementById(id).dataset['date'];
                $('.activePeriod').text(name);
                $('#periodEditForm').attr('action', action);
                $('.editName').val(name);
                $('.editDueDate').val(dueDate);
            });
        });
        $(function () {
            $(".delete_period").click(function () {
                //FINDING ELEMENTS OF ROWS AND STORING THEM IN VARIABLES
                let id = $(this).attr("id");
                let name = document.getElementById(id).dataset['name'];
                let action = document.getElementById(id).dataset['action'];
                $('.activePeriod').text(name);
                $('#periodDeleteForm').attr('action', action);
            });
        });
    </script>

@endsection
