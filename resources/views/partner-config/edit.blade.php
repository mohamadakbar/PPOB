@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::model($partner, ['id' => 'form-default', 'postmethod' => 'Edited', 'posturl' => '/adminpanel/partnerconfig/update/'.$partner->id,'method'=>'put', 'class'=>'form-horizontal']) !!}
            @include('partner-config._form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
