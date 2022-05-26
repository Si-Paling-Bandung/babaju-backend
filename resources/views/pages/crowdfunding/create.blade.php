@push('upper-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
@endpush
@extends('layouts.admin')
@section('title', 'Create Crowdfunding Post')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Create Crowdfunding Post') }}</h1>

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

    <form method="POST" action="{{ route('crowdfunding.create.process') }}" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-lg-12 order-lg-1">

                <div class="card shadow mb-4">

                    <div class="card-body">

                        <div class="pl-lg-4">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="title">{{ __('Title') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-Product" title="title"
                                            placeholder="{{ __('title') }}" value="{{ old('title') }}" name="title"
                                            required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="content">{{ __('Content') }}<span
                                                class="small text-danger">*</span></label>
                                        <textarea class="form-control form-control-Product" title="content" placeholder="{{ __('content') }}" name="content"
                                            required autofocus rows="20">{{ old('content') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="lat">{{ __('Lat') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-Product" title="lat"
                                            placeholder="{{ __('lat') }}" name="lat" required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="lang">{{ __('Lang') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-Product" title="lang"
                                            placeholder="{{ __('lang') }}" name="lang" required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="location">{{ __('Location') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-Product" title="location"
                                            placeholder="{{ __('location') }}" name="location" required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="cover_image">{{ __('Cover Image') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="file" class="form-control form-control-Product" title="cover_image"
                                            placeholder="{{ __('cover_image') }}" value="{{ old('cover_image') }}"
                                            name="cover_image" required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <label for="project_category"
                                            class="form-control-label">{{ __('Category') }}<span
                                            class="small text-danger">*</span></label>
                                        <select name="project_category" id="instance"
                                            class="form-control @error('project_category') is-invalid @enderror">
                                            @foreach ($data_category as $it)
                                                <option value="{{ $it->id }}">{{ $it->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="attachment">{{ __('Attachment') }}</label>
                                        <input type="file" class="form-control form-control-Product" title="attachment"
                                            placeholder="{{ __('attachment') }}" value="{{ old('attachment') }}"
                                            name="attachment" autofocus>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
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
