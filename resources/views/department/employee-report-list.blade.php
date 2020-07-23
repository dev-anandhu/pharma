@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Employee Reports Details</div>

                <div class="card-body">

                <p>Name : <b>{{$user->first_name.' '.$user->last_name}}</b></p>
                <p>Email : <b>{{$user->email}}</b></p>

                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Week</th>
                            <th>created at</th>
                            <th>Status</th>
                            <th>View</th>
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
        url: '{{ URL('department/report/user/') }}/'+{{ Request::segment(4) }}, 
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false},
            {data: 'week', name: 'week'},
            {data: 'created_at', name: 'created_at'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action'},
        ]
    });
    
  });

</script>
@show

@endsection
