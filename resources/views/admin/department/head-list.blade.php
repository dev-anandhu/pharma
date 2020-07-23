@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Department Heads</div>

                <div class="card-body">

                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User name</th>
                            <th>Department</th>
                            <th>Status</th>
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
</div>
@section('javascripts')
<script type="application/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('department.head-list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false},
            {data: 'first_name', name: 'first_name'},
            {data: 'department', name: 'department'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
  $('body').on('click', '.delete', function() {
    id = $(this).data('id'); 
    $.ajax({
        url: '{{ URL('employee/delete') }}/'+id, 
        type: 'get',
        success: function (resp) {
            $.toaster({ priority :'success', title :'Success', message : resp.message });
            $('.data-table').DataTable().ajax.reload();
        },
        error: function(error){ 
            data = jQuery.parseJSON(error.responseText);
            if(Object.values(data.errors)){
                msg = Object.values(data.errors)[0][0];
            }else{
                msg = data.message;
            }
            $.toaster({ priority :'danger', title :'Error', message : msg });
        }
    });
  });

  $('body').on('click', '.status', function() {
    id = $(this).data('id'); 
    $.ajax({
        url: '{{ URL('employee/status') }}/'+id, 
        type: 'get',
        success: function (resp) {
            successMessage(resp);
        },
        error: function(error){ 
            errorHandle(error);
        }
    });
  });

  $( "#add-department" ).on( "submit", function( event ) {
        event.preventDefault();
        data = $( this ).serialize();
        $.ajax({
            url: "{{ route('department.add') }}",
            data: data,
            type: 'POST',
            success: function (resp) {
                $('#name').val('')
                $('.data-table').DataTable().ajax.reload();
                $.toaster({ priority :'success', title :'Success', message : resp.message });
            },
            error: function(error){ 
            data = jQuery.parseJSON(error.responseText);
                if(Object.values(data.errors)){
                    msg = Object.values(data.errors)[0][0];
                }else{
                    msg = data.message;
                }
                $.toaster({ priority :'danger', title :'Error', message : msg });
            }
        });
    });
</script>
@show

@endsection
