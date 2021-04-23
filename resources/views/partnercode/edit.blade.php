@extends('layouts.sandeza')
@section('content')
<div class="panel panel-default">
  <div class="panel-body">
    {!! Form::model($partnercode, ['id' => 'form-default', 'postmethod' => 'Edited', 'posturl' => '/adminpanel/partner-code/update/'.$partnercode->id,'method'=>'put', 'class'=>'form-horizontal']) !!}
	@include('partnercode._form')
    {!! Form::close() !!}
  </div>
</div>
@endsection
