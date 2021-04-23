@extends('layouts.sandeza')
@section('content')
<div class="panel panel-default">
  <div class="panel-body">
    {!! Form::model($adaptor, ['id' => 'form-default', 'postmethod' => 'Edited', 'posturl' => '/adminpanel/adaptor/update/'.$adaptor->id,'method'=>'put', 'class'=>'form-horizontal']) !!}
	@include('adaptor._form')
    {!! Form::close() !!}
  </div>
</div>
@endsection
