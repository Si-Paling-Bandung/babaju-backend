@push('css')
    <link href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
@endpush
@push('script')
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('detail.grade.show', $user->id) }}",
                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'pre-test',
                        name: 'pre-test'
                    },
                    {
                        data: 'post-test',
                        name: 'post-test'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
        });
    </script>
@endpush
@extends('layouts.admin')

@section('title', 'Detail Grade')

@section('main-content')
    <a href="{{ route('detail.grade') }}" class="previous">&laquo; Back to Detail Grade List</a>
    <nav class="navbar navbar-light px-0 py-3">
        <h1 class="h3 mb-4 text-gray-800">{{ __('Detail Grades') }}{{ ' : ' . $user->name }}</h1>
        <ul class="navbar-nav">
            <li class="nav-item">
                <button type="button" id="export_button" class="btn btn-success btn-sm">Generate <b>{{ $user->name }}
                    </b>Report</button>
            </li>
        </ul>
    </nav>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">List Grades : {{ $user->name }} | {{ $user->username }}</h6>
        </div>
        <div class="card-body">
            <div class="">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>Nama Course</th>
                            <th>Status Course</th>
                            <th>Nilai Pre Test</th>
                            <th>Nilai Post Test</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <table id="grade_data" class="table" hidden>
        <thead>
            <tr>
                <th>Nama Course</th>
                <th>Status Course</th>
                <th>Nilai Pre Test</th>
                <th>Nilai Post Test</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topic as $us)
                <tr>
                    <td>{{ $us->title }}</td>
                    <td>{{ $us->status }}</td>
                    <td>{{ $us->pre_test }}</td>
                    <td>{{ $us->post_test }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
@push('script')
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
        function html_table_to_excel(type) {
            var data = document.getElementById('grade_data');

            var file = XLSX.utils.table_to_book(data, {
                sheet: "sheet1"
            });

            XLSX.write(file, {
                bookType: type,
                bookSST: true,
                type: 'base64'
            });

            var today = new Date();

            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate() + '-' + today.getHours() +
                '-' + today.getMinutes() + '-' + today.getSeconds();

            var user = "{{ $user->name }}";

            XLSX.writeFile(file, 'HLP Detail Grade ' + user + " " + date + "." + type);
        }

        const export_button = document.getElementById('export_button');

        export_button.addEventListener('click', () => {
            html_table_to_excel('xlsx');
        });
    </script>
@endpush
