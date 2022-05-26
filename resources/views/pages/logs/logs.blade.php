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
                url: "{{ route('logs') }}",
            },
            columns: [
                {
                    data: 'content',
                    name: 'content'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
            ]
        });
    });
</script>
@endpush
@extends('layouts.admin')

@section('title', 'Logs : Home')

@section('main-content')
<!-- <div class="container-fluid"> -->
<!-- Content here -->
<!-- <div class="row justify-content-center">
        <div class="col-lg-10"> -->
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark">List Logs</h6>
    </div>
    <div class="card-body">
        <!-- TABLE HERE -->
        <div class="table-responsive">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Content</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <!-- END OF TABLE -->
    </div>
</div>
@endsection
