@extends('layouts.admin')

@section('title', 'Overview Grade : Home')

@section('main-content')

    <nav class="navbar navbar-light px-0 py-3">
        <h1 class="h3 mb-4 text-gray-800">{{ __('List Grades : Pagging') }}</h1>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a type="button" href="{{ route('grade.generate') }}" class="btn btn-primary btn-sm">All User At Once</a>
            </li>
        </ul>
    </nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">List Grades</h6>
        </div>
        <div class="card-body">
            <div class="">
                <table id="grade_data" class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>No Telpon</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Asal Instansi</th>
                            @foreach ($topic as $tp)
                                <th>Status Course : {{ $tp->title }}</th>
                                <th>Nilai Pre Test : {{ $tp->title }}</th>
                                <th>Nilai Post Test : {{ $tp->title }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $us)
                            <tr>
                                <td>{{ $us->name }}</td>
                                <td>{{ $us->no_telp }}</td>
                                <td>{{ $us->username }}</td>
                                <td>{{ $us->role }}</td>
                                <td>{{ $us->asal }}</td>
                                <?php $i = 0; ?>
                                @foreach ($topic as $tp)
                                    <td>{{ $us->status[$i] }}</td>
                                    <td>{{ $us->pre_test[$i] }}</td>
                                    <td>{{ $us->post_test[$i] }}</td>
                                    <?php $i++; ?>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Pagination -->
    <nav class="d-flex justify-content-center" aria-label="Page navigation example">
        <ul class="pagination mx-auto">
            {{ $user->links() }}
        </ul>
    </nav>
@endsection
