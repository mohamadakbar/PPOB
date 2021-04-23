@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::model($prodforpartner, ['id' => 'form-default', 'postmethod' => 'Edited', 'posturl' => '/adminpanel/productforpartner/update/'.$prodforpartner->id,'method'=>'put', 'class'=>'form-horizontal']) !!}
            @include('prodforpartner._form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
