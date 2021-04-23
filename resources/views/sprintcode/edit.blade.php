@extends('layouts.sandeza')
@section('content')
<div class="panel panel-default">
  <div class="panel-body">
    {!! Form::model($sprintCode, ['id' => 'form-default', 'postmethod' => 'Edited', 'posturl' => '/adminpanel/sprint-code/update/'.$sprintCode->id,'method'=>'put', 'class'=>'form-horizontal']) !!}
	@include('sprintcode._form')
    {!! Form::close() !!}
  </div>
</div>
@endsection
