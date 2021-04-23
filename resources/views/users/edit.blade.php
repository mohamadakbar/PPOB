@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
      <div class="panel-body">
        {!! Form::model($user, ['id' => 'form-default', 'postmethod' => 'Edited', 'posturl' => route('manusers.updates', $user->id),'method'=>'put', 'class'=>'form-horizontal formedit']) !!}
        @include('users._form')
        {!! Form::close() !!}
      </div>
    </div>
@endsection
