@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
    <ul class="breadcrumb">
      <li><a href="{{ url('/home') }}">Dashboard</a></li>&nbsp;/&nbsp;
      <li class="active">Manage Users</li>
    </ul>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Manage Users</h3>
        </div><br>
          <div class="panel-body">
            {!! $dataTable->table(['class' => 'table table-striped table-sm table-bordered table-hover'], false) !!}
          </div>
        </div>
      </div>
  </div>
</div>
@endsection
@section('scripts')
  {!! $dataTable->scripts() !!}
@endsection
