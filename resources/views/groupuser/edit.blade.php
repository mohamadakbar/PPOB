@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
          <div class="panel-body">
            {!! Form::model($guser, ['id' => 'formgroupuser', 'url' => route('groupuser.update', $guser->id),'method'=>'put', 'class'=>'form-horizontal']) !!}
            @include('groupuser._form')
            {!! Form::close() !!}
          </div>
        </div>
@endsection
