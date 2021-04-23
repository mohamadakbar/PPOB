@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
      <div class="panel-body">
        {!! Form::model($prodtype, ['id' => 'form-default', 'postmethod' => 'Edited', 'posturl' => '/adminpanel/prodtype/update/'.$prodtype->id, 'method'=>'put', 'class'=>'form-horizontal']) !!}
        @include('prodtype._form')
        {!! Form::close() !!}
      </div>
    </div>
@endsection
