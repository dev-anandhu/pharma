@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Employee Report Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p> Name : {{$user->first_name.' '.$user->last_name}} </p> 
                    <p> Department : {{$user->user_department->name}} </p> 
                    <p> Status : @if($user->status) Active @endif @if(!$user->status) Not active @endif  </p> 

                    <p>Current week - {{$week}}</p>
                    <p>Today - {{date('Y-m-d')}}</labpel>
                    @if($count > 0)
                        <p style="color:green;">Weekly update already submited</p>
                    @endif
                    @if($count == 0)
                        <p style="color:red;">Weekly update not submited</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection