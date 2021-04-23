@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
      <div class="panel-body">
        {!! Form::model($prodcat, ['id' => 'form-default', 'postmethod' => 'Edited', 'posturl' => '/adminpanel/prodcat/update/'.$prodcat->id,'method'=>'put', 'class'=>'form-horizontal']) !!}
        @include('prodcat._form')
        {!! Form::close() !!}
      </div>
    </div>
@endsection
