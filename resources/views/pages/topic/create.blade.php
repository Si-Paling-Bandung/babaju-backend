@push('script')
    <script>
        let urlPath;
        let loadFile = function(event) {
            let output = document.getElementById('img-banner');
            let container = document.getElementById('container-img-banner');
            urlPath = URL.createObjectURL(event.target.files[0]);
            output.src = urlPath;
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
            container.classList.remove('d-none');
            container.classList.add('d-block');
        };

        let reset = function(event) {
            const output = document.getElementById('img-banner');
            const container = document.getElementById('container-img-banner');
            output.src = '';
            container.classList.remove('d-block');
            container.classList.add('d-none');
            document.getElementById('btn-img-upload').value = "";
        }
    </script>
@endpush

@extends('layouts.admin')
@section('title', 'Create Product')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Create Product') }}</h1>

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

    <form method="POST" action="{{ route('topic.create.process') }}" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-lg-4 order-lg-2">

                <div class="card shadow mb-4">

                    <div class="card-body">
                        <div class="form-group">
                            <label class="" for="btn-img-upload">{{ __('Topic Image') }}</label>
                            <input type="file" name="foto" class="form-control-file @error('foto') is-invalid @enderror"
                                id="btn-img-upload" required onchange="loadFile(event)">
                            @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group d-none" id="container-img-banner">
                            <img src="" class="w-100" id="img-banner">
                            <a class="btn btn-secondary mt-3" onclick="reset(event)" id="btn-reset">Reset</a>
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-lg-8 order-lg-1">

                <div class="card shadow mb-4">

                    <div class="card-body">

                        <div class="pl-lg-4">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="title">{{ __('Title') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" id="title" class="form-control" name="title"
                                            value="{{ old('title') }}"
                                            placeholder="Example : Penting nya menjaga kesehatan" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="author">{{ __('Author') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" id="author" class="form-control" name="author"
                                            value="{{ old('author') }}" placeholder="Example : M. Faiz Triputra" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label"
                                            for="short_description">{{ __('Topic Short Description') }}<span
                                                class="small text-danger">*</span></label>
                                        <textarea class="form-control" id="short_description" name="short_description"
                                            rows="3">{{ old('short_description') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label"
                                            for="description">{{ __('Topic Full Description') }}<span
                                                class="small text-danger">*</span></label>
                                        <textarea class="form-control" id="description" name="description" rows="7">{{ old('description') }}</textarea>
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