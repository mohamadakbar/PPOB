@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
      <div class="panel-body">
        {!! Form::model($prodpartner, ['files' => true, 'id' => 'form-default', 'postmethod' => 'Edited', 'posturl' => route('prodpartner.updates', $prodpartner->id),'method'=>'put', 'class'=>'form-horizontal']) !!}
        @include('prodpartner._form')
        {!! Form::close() !!}
      </div>
    </div>
@endsection
