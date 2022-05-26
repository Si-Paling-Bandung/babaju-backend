@push('upper-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
@endpush
@extends('layouts.admin')
@section('title', 'Create Product Variant')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Create Product Variant') }}</h1>

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

    <form method="POST" action="{{ route('product.variant.create.process', $id) }}" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-lg-12 order-lg-1">

                <div class="card shadow mb-4">

                    <div class="card-body">

                        <div class="pl-lg-4">

                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="form-group">
                                        <label class="form-control-label" for="stock">{{ __('Stock') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-Product" title="stock"
                                            placeholder="{{ __('stock') }}" value="{{ old('stock') }}" name="stock"
                                            required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="price">{{ __('Price') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-Product" title="price"
                                            placeholder="{{ __('price') }}" value="{{ old('price') }}" name="price"
                                            required autofocus>

                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label"
                                            for="discounted_price">{{ __('Discounted Price') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-Product"
                                            title="discounted_price" placeholder="{{ __('discounted_price') }}"
                                            value="{{ old('discounted_price') }}" name="discounted_price" required
                                            autofocus>

                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="photo">{{ __('Photo') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="file" class="form-control form-control-Product" title="photo"
                                            placeholder="{{ __('photo') }}" value="{{ old('photo') }}" name="photo"
                                            required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="color" class="form-control-label">{{ __('Color') }}</label>
                                        <select name="color" id="color"
                                            class="form-control @error('color') is-invalid @enderror">
                                            @foreach ($data_color as $it)
                                                <option value="{{ $it->id }}">{{ $it->color_name }} |
                                                    {{ $it->color_code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="size" class="form-control-label">{{ __('Size') }}</label>
                                        <select name="size" id="size"
                                            class="form-control @error('size') is-invalid @enderror">
                                            @foreach ($data_size as $it)
                                                <option value="{{ $it->id }}">{{ $it->size }}</option>
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
