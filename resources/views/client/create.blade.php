@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
      <div class="panel-body">
        {!! Form::open(['id' => 'formclient', 'url' => route('client.store'),'method' => 'post','files'=>'true','class'=>'form-horizontal']) !!}
        @include('client._form')
        {!! Form::close() !!}
      </div>
    </div>
@endsection
