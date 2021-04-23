@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Error 403 Access Denied') }}</div>
                <div class="card-body">User group has been deactivated</div>
            </div>
        </div>
    </div>
</div>
@endsection
