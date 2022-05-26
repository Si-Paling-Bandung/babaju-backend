@push('css')
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <style>
        .card-columns .card {
            display: inline-block;
            width: 100%;
        }

    </style>
@endpush
@push('script')
    <script>
        $(function() {
            $.getScript(
                "https://www.jqueryscript.net/demo/Delete-Confirmation-Dialog-Plugin-with-jQuery-Bootstrap/bootstrap-confirm-delete.js",
                function() {
                    $('.delete').bootstrap_confirm_delete({
                        heading: '',
                        message: 'Are you sure you want to delete this record?'
                    });
                });
        });
    </script>
@endpush
@extends('layouts.admin')
@section('title', 'Topic')

@section('main-content')
    <!-- Page Heading -->

    <nav class="navbar navbar-light px-0 py-3">
        <h1 class="h3 mb-4 text-gray-800">{{ __('All Topic') }}</h1>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="{{ route('topic.create') }}" class="btn btn-dark border-0">New Topic</a>
            </li>
        </ul>
    </nav>

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

    <div class="row mx-1 mb-5">
        <div class="col-md-12 order-lg-1 bg-white rounded shadow">
            <div class="my-3 d-inline-block w-100">
                <h6 class="m-0 font-weight-bold text-danger">Topics</h6>
            </div>
            {{-- Cards --}}
            {{-- <div class="card-columns bg-warning"> --}}
            {{-- <div class="card-columns"> --}}
            <div class="row my-2">
                @foreach ($data as $dt)
                    <div class="col-4 my-2">
                        <div class="card">
                            <img src="{{ asset('storage/' . $dt->cover_image) }}" class="card-img-top" alt="..."
                                style="max-width: 100%; height: 300px; object-fit:cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $dt->title }}</h5>

                                <p class="card-text">{{ substr($dt->description, 0, 200) }}</p>

                                <p class="card-text"><small class="text-muted">Last Updated at
                                        {{ $dt->updated_at->format('d, M Y H:i') }}</small></p>

                            </div>
                            <div class="card-footer">
                                <div class="dropdown">
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                            data-toggle="dropdown">
                                            Option
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('lo', $dt->id) }}"><i
                                                    class="mr-2 fas fa-fw fa-info"></i>Detail</a>
                                            <a class="dropdown-item" href="{{ route('topic.update', $dt->id) }}"><i
                                                    class="mr-2 fas fa-fw fa-edit"></i>Edit</a>
                                            <a class="dropdown-item" href="{{ route('quiz', $dt->id) }}"><i
                                                    class="mr-2 fas fa-fw fa-question"></i>Quizzes</a>
                                            <a class="dropdown-item" href="{{ route('exercise', $dt->id) }}"><i
                                                    class="mr-2 fas fa-fw fa-file"></i>Exercise</a>
                                            <a class="dropdown-item" href="{{ route('certificate', $dt->id) }}"><i
                                                    class="mr-2 fas fa-fw fa-certificate"></i>Certificate<b>(Soon)</b></a>
                                            <a class="dropdown-item" href="{{ route('feedback', $dt->id) }}"><i
                                                    class="mr-2 fas fa-fw fa-comment"></i>Feedbacks</a>
                                            <a class="dropdown-item" data-toggle="confirmation" data-singleton="true"
                                                data-popout="true" href="{{ route('topic.delete', $dt->id) }}"
                                                type="button" name="delete"
                                                onclick="return confirm('Are you sure you want to delete this item?');"><i
                                                    class="mr-2 fas fa-fw fa-trash"></i>Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- <div style="padding-bottom:10%" class="bg-primary">
                </div> --}}
            {{-- </div> --}}
            {{-- End Cards --}}
        </div>
    </div>

@endsection
