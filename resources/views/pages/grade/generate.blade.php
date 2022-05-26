@extends('layouts.admin')

@section('title', 'Overview Grade : All User')

@section('main-content')
    <a href="{{ route('grade') }}" class="previous">&laquo; Back to Pagination</a>
    <nav class="navbar navbar-light px-0 py-3">
        <h1 class="h3 mb-4 text-gray-800">{{ __('List Grades : All User') }}</h1>
        <ul class="navbar-nav">
            <li class="nav-item">
                <button type="button" id="export_button" class="btn btn-success btn-sm">Generate Report</button>
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

            XLSX.writeFile(file, 'HLP Overview Grade ' + date + "." + type);
        }

        const export_button = document.getElementById('export_button');
        export_button.addEventListener('click', () => {
            html_table_to_excel('xlsx');
        });
    </script>
@endpush
