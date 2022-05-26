@extends('layouts.admin')
@section('title', 'User Task')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('User Task') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('exercise.grade.process', [$id_topic, $userTask->id]) }}" autocomplete="off"
        enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col order-lg-1">

                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-danger">User Task</h6>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-6">
                                <h1><b>User Name</b></h1>
                                <p><b>Download File Here</b> : <a href="{{ asset('storage/' . $userTask->file) }}"
                                        target="_blank">Here</a></p>
                                <p><b>User Note</b> :</p>
                                <p>{{ $userTask->user_notes }}</p>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="grade">{{ __('Grade') }}<span
                                                    class="small text-danger">*</span></label>
                                            <input type="number" id="name" class="form-control" name="grade"
                                                value="{{ $userTask->grade ? $userTask->grade : 0 }}"
                                                placeholder="0 - 100" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="notes">{{ __('Teacher Note') }}<span
                                                    class="small text-danger">*</span></label>
                                            <textarea class="form-control" id="notes" class="form-control" name="notes"
                                                placeholder="Example : Sudah bagus">{{ $userTask->teacher_notes ? $userTask->teacher_notes : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col text-center">
                                    <a href="{{ url()->previous() }}" class="btn btn-dark">Back</a>
                                    <button type="submit" class="btn btn-primary">{{ __('Grade') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </form>

@endsection
