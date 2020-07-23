@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Manage Departments</div>

                <div class="card-body">
                    
                <div class="box-header">
                    <h6 class="box-title">Add Department</h6>
                </div>
                    <form method="POST" id="add-department">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Department name<span>*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" required >
                                </div>
                            </div>
                            <div class="col-md-3"  style="margin-top: 30px;">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <button type="submit" id="submit" class="btn btn-success">ADD</button>
                                </div>
                            </div>
                        </div>
                    </form>

                <div class="box-header">
                    <h6 class="box-title">Departments</h6>
                </div>

                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
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
        ajax: "{{ route('department.list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });

  function errorHandle(error){
    data = jQuery.parseJSON(error.responseText);
    if(Object.values(data.errors)){
        msg = Object.values(data.errors)[0][0];
    }else{
        msg = data.message;
    }
    $.toaster({ priority :'danger', title :'Error', message : msg });
  }

  function successMessage(resp){
    $.toaster({ priority :'success', title :'Success', message : resp.message });
    $('.data-table').DataTable().ajax.reload();
  }

  $('body').on('click', '.delete', function() {
    id = $(this).data('id'); 
    $.ajax({
        url: '{{ URL('department/delete') }}/'+id, 
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
                    successMessage(resp);
                },
                error: function(error){ 
                    errorHandle(error);
                }
            });
        });

</script>
@show

@endsection
