@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
      <div class="panel-body">
        {!! Form::open(['id' => 'formroleuser', 'url' => route('roleusers.store'),'method' => 'post','files'=>'true','class'=>'form-horizontal']) !!}
        @include('roleuser._form')
        {!! Form::close() !!}
      </div>
    </div>
@endsection
