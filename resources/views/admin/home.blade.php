@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Super Admin Dashbaord</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Total Departments <b>{{$department}}</b> </p>
                    <p>Total Active Employees <b>{{$employees}}</b> </p>
                    <p>New not active Employees <b>{{$new_employees}}</b> </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
