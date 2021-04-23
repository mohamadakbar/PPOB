@extends('layouts.sandeza')
@section('content')
<div class="panel panel-default">
  <div class="panel-body">
    {!! Form::open(['id' => 'form-default', 'postmethod' => 'Added', 'posturl' => route('partnercode.link'),'method' => 'post','files'=>'true','class'=>'form-horizontal']) !!}
    @include('partnercode._form')
    {!! Form::close() !!}
  </div>
</div>
@endsection
