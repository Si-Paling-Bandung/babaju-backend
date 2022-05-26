@push('css')
    <link href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
@endpush
@push('script')
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('user') }}",
                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },
                ]
            });
        });
    </script>
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
@section('title', 'User Management')

@section('main-content')
    <!-- Page Heading -->

    <nav class="navbar navbar-light px-0 py-3">
        <h1 class="h3 mb-4 text-gray-800">{{ __('User Management') }}</h1>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="{{ route('user.create') }}" class="btn btn-dark border-0">New User</a>
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

    <div class="row">

        <div class="col order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">Users</h6>
                </div>

                <div class="card-body">

                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection
