@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Employee Reports Details</div>

                <div class="card-body">

                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Not verified Report</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                </div>
            </div>
        </div>
    </div>
</div>
@section('javascripts')
<script type="application/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('department.reports') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false},
            {data: 'first_name', name: 'first_name'},
            {data: 'report_count', name: 'report_count'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action'},
        ]
    });
    
  });

</script>
@show

@endsection
