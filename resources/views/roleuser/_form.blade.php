<div class="form-group row">
    {!! Form::label('user_id', 'User', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::hidden('id', null, ['class'=>'form-control']) !!}

      @if (isset($roleuser))
        {!! Form::hidden('user_id', null, ['class'=>'form-control','readonly' => 'true']) !!}
        {!! Form::select('user_id', [''=>'']+App\User::pluck('name','id')->all(), null, ['class'=>'form-control','disabled' => 'true']) !!}
      @else
        <!-- {!! Form::text('user_id', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!} -->
        {!! Form::select('user_id', [''=>'']+App\User::pluck('name','id')->all(), null, ['class'=>'form-control']) !!}
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
      @endif

    </div>
</div>

<!-- <div class="form-group row">
    {!! Form::label('role_id', 'Role User', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::text('role_id', null, ['class'=>'form-control']) !!}
      {!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
    </div>
</div> -->

<div class="form-group row {!! $errors->has('author_id') ? 'has-error' : '' !!}">
  {!! Form::label('role_id', 'Role User', ['class'=>'col-md-2 control-label']) !!}
  <div class="col-md-6">
    {!! Form::select('role_id', [''=>'']+App\Role::pluck('name','id')->all(), null, ['class'=>'form-control']) !!}
    {!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group row">
    {!! Form::label('status', 'Status', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::select('status', array('' => '--- Choose ---', 'active' => 'Active', 'inactive' => 'Inactive'), null, ['class'=>'form-control']); !!}
      {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-2">
      {!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}
    </div>
</div>


<script>

  $('#formroleuser').submit(function() {

      if ($('#user_id').val() === "") {
          $('#user_id').focus();
          swal({
              title: "User error!",
              text: "Please Choose User",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#role_id').val() === "") {
          $('#role_id').focus();
          swal({
              title: "Role error!",
              text: "Please Choose Role",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#status').val() === "") {
          $('#status').focus();
          swal({
              title: "Status error!",
              text: "Please Choose Status",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      return true; 
  });

</script>