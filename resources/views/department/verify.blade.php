@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Employee Report</div>

                <div class="card-body">

                    <h6> Name : {{$user->first_name.' '.$user->last_name}} </h6> 
                    <h6> Department : {{$user->user_department->name}} </h6> 

                    <h6> Week : {{$week}} </h6> 
                    <h6> Created at : {{$report->created_at}} </h6> 
                    @if($report->description)
                        <h6>Description</h6>
                        <p>{{$report->description}}</p>
                    @endif
                    @if($report->file)
                    <h6>File</h6>
                    <p>
                         <a target="_blank" href="{{ Storage::url('public/files/'.$report->file) }}">{{$report->file}}</a>
                    </p>
                    @endif
                    <h6>Status</h6>
                    @if($report->status)
                        <p>Verified</p>
                    @endif
                    @if(!$report->status)
                        <p>Not verified</p>
                    

                    <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <button type="button" id="button" class="btn btn-success">Verify</button>
                                </div>
                            </div>
                    </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@section('javascripts')
<script type="application/javascript">

  $( "#button" ).on( "click", function( event ) {
        event.preventDefault();
        $.ajax({
            url: '{{ URL('department/report/verify') }}/'+{{ Request::segment(4) }},
            type: 'get',
            success: function (resp) {
                $.toaster({ priority :'success', title :'Success', message : resp.message });
                window.location.replace("{{ route('department.reports') }}");
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