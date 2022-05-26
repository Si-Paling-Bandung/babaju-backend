@extends('layouts.admin')
@section('title', 'Create Video Lesson')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Create Video Lesson') }}</h1>

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

<form method="POST" action="{{ route('lesson.create.process', [$id_topic, $id_lo]) }}" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="row">

        <div class="col-lg-12 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-body">

                    <div class="pl-lg-4">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">{{ __('Name') }}<span class="small text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name" value="{{ old('name')}}" placeholder="Example : Penting nya menjaga kesehatan" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="video_url">{{ __('Video URL') }}<span class="small text-danger">*</span></label>
                                    <input type="text" id="video_url" class="form-control" name="video_url" value="{{ old('video_url')}}" placeholder="Example : https://www.youtube.com/watch?v=Zyq1jIdmRMU" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="video_duration">{{ __('Video Duration') }}<span class="small text-danger">*</span></label>
                                    <input type="time" id="video_duration" class="form-control" name="video_duration" step="1" required>
                                    <p class="text-muted">Format HH:MM:SS</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col text-center">
                                <a href="{{ url()->previous() }}" class="btn btn-dark">Back</a>
                                <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</form>

@endsection