@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
      <div class="panel-body">
        {!! Form::model($client, ['id' => 'formclient', 'url' => route('client.update', $client->id),'method'=>'put', 'class'=>'form-horizontal']) !!}
        @include('client._form')
        {!! Form::close() !!}
      </div>
    </div>
@endsection
