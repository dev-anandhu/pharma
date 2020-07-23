@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Weekly Report</div>

                <div class="card-body">
                    @if($count > 0)
                        <p style="color:green;">Weekly update already submited</p>
                    @endif
                    @if($count == 0)
                    <form id="add-report">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Current week - {{$week}}</label>
                                    <label for="">Today - {{date('Y-m-d')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Report description</label>
                                    <textarea class="form-control" name="description"  ></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">File</label>
                                    <input type="file" class="form-control" name="file" ></textarea>
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('javascripts')

<script type="application/javascript">

    function errorHandle(error){ 
        data = jQuery.parseJSON(error.responseText);
        if(data.errors){
            Object.values(data.errors)
            msg = Object.values(data.errors)[0][0];
        }else{
            msg = data.message;
        }
        $.toaster({ priority :'danger', title :'Error', message : msg });
    }

    $( "#add-report" ).on( "submit", function( event ) {
        event.preventDefault();
        var form = $("#add-report");
        var data = new FormData(form[0]);
        $.ajax({
            url: "{{ route('report.add') }}",
            data: data,
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            type: 'POST',
            success: function (resp) {
                $.toaster({ priority :'success', title :'Success', message : resp.message });
                window.location.replace("{{ route('home') }}");
            },
            error: function(error){  
                errorHandle(error)
            }
        });
    });
</script>

@show

@endsection