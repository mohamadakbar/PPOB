@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
          <div class="panel-body">
            {!! Form::open(['id' => 'form-default', 'postmethod' => 'POST', 'posturl' => route('manusers.link'),'method' => 'post','files'=>'true','class'=>'form-horizontal']) !!}
            @include('users._form')
            {!! Form::close() !!}
          </div>
    </div>
@endsection
