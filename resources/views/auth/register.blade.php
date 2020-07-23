@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                <form id="add-employee">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">First name<span>*</span></label>
                                    <input type="text" class="form-control" name="first_name" required >
                                    <input type="hidden" name="id" id="id" value="">
                                    <input type="hidden" name="type" id="type" value="3">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Last name<span>*</span></label>
                                    <input type="text" class="form-control" name="last_name" required  >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Email<span>*</span></label>
                                    <input type="email" class="form-control" name="email" required  >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Password<span>*</span></label>
                                    <input type="text" class="form-control" name="password"  required   >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Department<span>*</span></label>
                                    <select class="form-control" name="department" required  >
                                        <option selected="selected" value="" >Select</option>
                                        @foreach($departments as $res)
                                        <option  value="{{$res->id}}">{{$res->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <button type="submit" id="submit" class="btn btn-success">ADD</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('javascripts')
<script type="application/javascript">

  $( "#add-employee" ).on( "submit", function( event ) {
        event.preventDefault();
        $.ajax({
            url: "{{ route('employee.request') }}",
            data: $( this ).serialize(),
            type: 'POST',
            success: function (resp) {
                $( "#add-employee" )[0].reset();
                $.toaster({ priority :'success', title :'Success', message : 'You can login after admin verification' });
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
