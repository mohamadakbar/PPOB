<div class="form-group row">
    {!! Form::label('name', 'Client Name', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::hidden('id', null, ['class'=>'form-control']) !!}
      {!! Form::text('name', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
      {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('picEmail', 'Email PIC', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::text('picEmail', null, ['class'=>'form-control']) !!}
      {!! $errors->first('picEmail', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('userid', 'User Id', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::text('userid', null, ['class'=>'form-control']) !!}
      {!! $errors->first('userid', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('password', 'Password', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::text('password', null, ['class'=>'form-control']) !!}
      {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('picPhone', 'No. Telp PIC', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::text('picPhone', null, ['class'=>'form-control']) !!}
      {!! $errors->first('picPhone', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('status', 'Status', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::select('status', array('' => '--- Choose ---', '1' => 'Active', '2' => 'Inactive'), null, ['class'=>'form-control']); !!}
      {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-2">
      {!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}
    </div>
</div>

<script>


  $('#name').keypress(function (event) {
    var inputValue = event.charCode;
      if(!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123)||(inputValue==32) || (inputValue==0))){
          event.preventDefault();
      }
  });

  $('#userid').keypress(function (event) {
    var inputValue = event.charCode;
      if(!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123) || (inputValue > 47 && inputValue < 58))){
          event.preventDefault();
      }
  });

    
  $(".showPass").on('click', function(event) {
      event.preventDefault();
      
      if($('#password').attr("type") == "password"){
          var type = 'text';
          var addClassI = "fa-eye";
          var removeClassI = "fa-eye-slash";
      }else if($('#password').attr("type") == "text"){
          var type = 'password';
          var addClassI = "fa-eye-slash";
          var removeClassI = "fa-eye";
      } 
      
      $('#password').attr('type', type);
      $('.showPass > i').removeClass(removeClassI);
      $('.showPass > i').addClass(addClassI);
  });

  $('#formclient').submit(function() {

      if ($('#name').val() === "") {
          $('#name').focus();
          swal({
              title: "Name error!",
              text: "This field is required : Name",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#name').val().length < 3) {
          $('#name').focus();
          swal({
              title: "Name error!",
              text: "Name must be minimal 3 characters",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#userid').val() === "") {
          $('#userid').focus();
          swal({
              title: "Userid error!",
              text: "This field is required : Userid",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#userid').val().length < 3) {
          $('#userid').focus();
          swal({
              title: "Userid error!",
              text: "Userid must be minimal 3 characters",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#password').val() === "") {
          $('#password').focus();
          swal({
              title: "Password error!",
              text: "This field is required : Password",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#password').val().length < 6) {
          $('#password').focus();
          swal({
              title: "Password error!",
              text: "Password must be minimal 6 characters",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#ip_source').val() === "") {
          $('#ip_source').focus();
          swal({
              title: "IP Source error!",
              text: "This field is required : IP Source",
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