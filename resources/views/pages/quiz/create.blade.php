@push('third_party_stylesheets')
    <!-- include libraries(jQuery, bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@endpush
@push('third_party_scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script>
        $('#summernote').summernote({
            placeholder: 'type indonesian here...',
            tabsize: 2,
            height: 500
        });
    </script>

@endpush
@extends('layouts.admin')
@section('title', 'Create Quiz')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Create Quiz') }}</h1>

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

    <form method="POST" action="{{ route('quiz.create.process', $id_topic) }}" autocomplete="off"
        enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-lg-12 order-lg-1">

                <div class="card shadow mb-4">

                    <div class="card-body">

                        <div class="pl-lg-4">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="type" class="form-control-label">Question Type<span
                                                class="small text-danger">*</span></label>
                                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                                            <option value="pre_test">Pre Test</option>
                                            <option value="post_test">Post Test</option>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="editor1">{{ __('Question') }}<span
                                                class="small text-danger">*</span></label>
                                        <textarea name="editor1" placeholder="type indonesian description here..."
                                            id="summernote"
                                            class="form-control border-0 rounded-0 @error('editor1') is-invalid @enderror"
                                            rows="4" cols="50" required></textarea>
                                        @error('editor1')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="answer_1">{{ __('Answer 1') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" id="answer_1" class="form-control" name="answer_1"
                                            value="{{ old('answer_1') }}" placeholder="Example : olahraga" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="answer_2">{{ __('Answer 2') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" id="answer_2" class="form-control" name="answer_2"
                                            value="{{ old('answer_2') }}" placeholder="Example : malas - malasan"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="answer_3">{{ __('Answer 3') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" id="answer_3" class="form-control" name="answer_3"
                                            value="{{ old('answer_3') }}"
                                            placeholder="Example : makan junk food setiap hari" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="answer_4">{{ __('Answer 4') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" id="answer_4" class="form-control" name="answer_4"
                                            value="{{ old('answer_4') }}" placeholder="Example : merokok" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="key" class="form-control-label">Key<span
                                                class="small text-danger">*</span></label>
                                        <select name="key" id="key" class="form-control @error('key') is-invalid @enderror">
                                            <option value="answer_1">answer_1</option>
                                            <option value="answer_2">answer_2</option>
                                            <option value="answer_3">answer_3</option>
                                            <option value="answer_4">answer_4</option>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="explanation">{{ __('Explanation') }}<span
                                                class="small text-danger">*</span></label>
                                        <textarea class="form-control" id="explanation" name="explanation"
                                            rows="3">{{ old('explanation') }}</textarea>
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
