@push('upper-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
@endpush
@extends('layouts.admin')
@section('title', 'Create Product Review')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Create Product Review') }}</h1>

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

    <form method="POST" action="{{ route('product.review.create.process', $id) }}" autocomplete="off"
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
                                        <label class="form-control-label" for="review">{{ __('Review') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-Product" title="review"
                                            placeholder="{{ __('review') }}" name="review" required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <label for="rating" class="form-control-label">{{ __('Rating') }}<span
                                                class="small text-danger">*</span></label>
                                        <select name="rating" id="instance"
                                            class="form-control @error('rating') is-invalid @enderror">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="user" class="form-control-label">{{ __('User') }}<span
                                                class="small text-danger">*</span></label>
                                        <select name="user" id="instance"
                                            class="form-control @error('user') is-invalid @enderror">
                                            @foreach ($data_user as $it)
                                                <option value="{{ $it->id }}">{{ $it->name }}</option>
                                            @endforeach
                                        </select>
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
