@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::model($product, ['id' => 'form-default', 'postmethod' => 'Edited', 'posturl' => '/adminpanel/product/update/'.$product->id,'method'=>'put', 'class'=>'form-horizontal']) !!}
            @include('product._form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
