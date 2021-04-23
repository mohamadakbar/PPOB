@extends('layouts.sandeza')
@section('content')
<div class="panel panel-default">
  <div class="panel-body">
    {!! Form::model($roleuser, ['id' => 'formroleuser', 'url' => route('roleusers.update', $roleuser->id),'method'=>'put', 'class'=>'form-horizontal']) !!}
    @include('roleuser._form')
    {!! Form::close() !!}
  </div>
</div>
@endsection
