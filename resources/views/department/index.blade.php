@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Department Head Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p> Name : {{$user->first_name.' '.$user->last_name}} </p> 
                    <p> Department : {{$user->user_department->name}} </p> 
                    <p> NO. of employees : {{$count}} </p> 
                    <p> NO. of verification pending reports : {{$verificationReports}} </p> 

                </div>
            </div>
        </div>
    </div>
</div>

@endsection