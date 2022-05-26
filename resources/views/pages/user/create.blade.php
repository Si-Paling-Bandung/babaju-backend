@push('upper-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
@endpush
@extends('layouts.admin')
@section('title', 'Create User')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Create User') }}</h1>

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

    <form method="POST" action="{{ route('user.create.process') }}" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-lg-12 order-lg-1">

                <div class="card shadow mb-4">

                    <div class="card-body">

                        <div class="pl-lg-4">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="name">{{ __('Name') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-user" name="name"
                                            placeholder="{{ __('Name') }}" value="{{ old('name') }}" required
                                            autofocus>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="name">{{ __('Username') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-user" name="username"
                                            placeholder="{{ __('Username') }}" value="{{ old('username') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="password">{{ __('Password') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="password" class="form-control form-control-user" name="password"
                                            placeholder="{{ __('Password') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="role" class="form-control-label">Role</label>
                                        <select name="role" id="role"
                                            class="form-control @error('role') is-invalid @enderror" onclick="myFunction()">
                                            <option value="kader">Pendamping PRIMA</option>
                                            <option value="tenaga_kesehatan">Tenaga Kesehatan</option>
                                            <option value="trainer">Trainer</option>
                                            <option value="perangkat_daerah">Perangkat Daerah</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="form-group" id="text2" style="display:block">
                                        <label for="id_instance" class="form-control-label">Instantion</label>
                                        <select name="id_instance" id="instance"
                                            class="form-control @error('id_instance') is-invalid @enderror">
                                            @foreach ($data_instance as $it)
                                                <option value="{{ $it->id }}">{{ $it->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" id="text" style="display:none">
                                        <label for="id_local_official" class="form-control-label">Local Official</label>
                                        <select name="id_local_official" id="id_local_official"
                                            class="form-control @error('id_local_official') is-invalid @enderror">
                                            @foreach ($data_regional as $it)
                                                <option value="{{ $it->id }}">{{ $it->title }}</option>
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
    <script>
        $(document).ready(function() {
            //change selectboxes to selectize mode to be searchable
            $("select").select2();
        });
    </script>
    <script>
        function myFunction() {
            var checkBox = document.getElementById("myCheck");
            var text = document.getElementById("text");
            var text2 = document.getElementById("text2")
            if (document.getElementById('role').value == "kader" || document.getElementById('role').value ==
                "tenaga_kesehatan" || document.getElementById('role').value == "trainer") {
                text.style.display = "none";
                text2.style.display = "block";
            } else if (document.getElementById('role').value == "perangkat_daerah") {
                text.style.display = "block";
                text2.style.display = "none";
            } else {
                text.style.display = "none";
                text2.style.display = "none";
            }
        }
    </script>

@endsection
