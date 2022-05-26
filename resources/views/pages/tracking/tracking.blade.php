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
                url: "{{ route('tracking') }}",
            },
            columns: [{
                    data: 'id_user',
                    name: 'id_user'
                },
                {
                    data: 'id_lesson',
                    name: 'id_lesson'
                },
                {
                    data: 'is_done',
                    name: 'is_done'
                },
            ]
        });
    });
</script>
<script>
    $(function() {
        $.getScript("https://www.jqueryscript.net/demo/Delete-Confirmation-Dialog-Plugin-with-jQuery-Bootstrap/bootstrap-confirm-delete.js", function() {
            $('.delete').bootstrap_confirm_delete({
                heading: '',
                message: 'Are you sure you want to delete this record?'
            });
        });
    });
</script>
@endpush
@extends('layouts.admin')
@section('title', 'Tracking Lesson')

@section('main-content')
<!-- Page Heading -->

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark">Tracking</h6>
    </div>
    <div class="card-body">
        <!-- TABLE HERE -->
        <div class="table-responsive">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>ID User</th>
                        <th>ID Lesson</th>
                        <th>Status</th>
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