@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$title}} User</div>

                <div class="card-body">
                    
                    <form id="add-employee">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">First name<span>*</span></label>
                                    <input type="text" class="form-control" name="first_name" required value="{{ old('first_name',$user->first_name) }}" >
                                    <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Last name<span>*</span></label>
                                    <input type="text" class="form-control" name="last_name" required value="{{ old('last_name',$user->last_name) }}" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Email<span>*</span></label>
                                    <input type="email" class="form-control" name="email" required value="{{ old('email',$user->email) }}" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Password<span>*</span></label>
                                    <input type="text" class="form-control" name="password" @if($user->password == null) required  @endif >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">User type<span>*</span></label>
                                    <select class="form-control" name="type" required >
                                        <option selected="selected" disabled >Select</option>
                                        @foreach($userType as $key => $value)
                                            @php $sel = ''; @endphp
                                            @if($key == $user->type)
                                                @php $sel = 'selected="selected"'; @endphp
                                            @endif
                                            <option {{$sel}} value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Department<span>*</span></label>
                                    <select class="form-control" name="department" @if($user->type != null && $user->type != 1) required  @endif >
                                        <option selected="selected" value="" >Select</option>
                                        @foreach($departments as $res)
                                            @php $sel = ''; @endphp
                                            @if($res->id == $user->department)
                                                @php $sel = 'selected="selected"'; @endphp
                                            @endif
                                        <option {{$sel}} value="{{$res->id}}">{{$res->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        @if($user->password)
                            <p style="color:red"> Please leave blank the password field if you don't want to change it.</p>
                        @endif
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <button type="submit" id="submit" class="btn btn-success">{{$title}}</button>
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
                $.toaster({ priority :'success', title :'Success', message : resp.message });
                window.location.replace("{{ route('employees') }}");
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
