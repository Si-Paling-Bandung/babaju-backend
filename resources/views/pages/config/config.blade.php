@extends('layouts.admin')

@section('title', 'Config : Home')

@section('main-content')
    <!-- <div class="container-fluid"> -->
    <!-- Content here -->
    <!-- <div class="row justify-content-center">
                <div class="col-lg-10"> -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">Config</h6>
        </div>
        <div class="card-body">
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <form method="POST" action="{{ route('config.update') }}">
                        @csrf

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

                        <div class="form-group">
                            <label for="wa_admin" class="small">Admin WhatsApp</label>
                            <input type="text"
                                class="form-control border-0 rounded-0 @error('wa_admin') is-invalid @enderror"
                                placeholder="instagram api..." value="{{ $config->wa_admin }}" name="wa_admin"
                                id="wa_admin" required>
                            @error('wa_admin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group row mb-0">
                            <div class="">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
