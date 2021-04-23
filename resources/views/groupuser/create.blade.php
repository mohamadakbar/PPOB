@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
      <div class="panel-body">
        {!! Form::open(['id' => 'formgroupuser', 'url' => route('groupuser.store'),'method' => 'post','files'=>'true','class'=>'form-horizontal']) !!}
        @include('groupuser._form')
        {!! Form::close() !!}
      </div>
    </div>
@endsection

