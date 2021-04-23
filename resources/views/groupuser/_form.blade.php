<span class="required" style="color:red;">*</span>
<div class="form-group row">
    {!! Form::label('name', 'Name', ['class'=>'col-md-2 control-label text-md-left req']) !!}
    <div class="col-md-6">
      {!! Form::hidden('id', null, ['class'=>'form-control']) !!}
      {!! Form::text('name', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
      {!! $errors->first('name', '<p class="help-block" >*:message</p>') !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('display_name', 'Display Name', ['class'=>'col-md-2 control-label text-md-left req']) !!}
    <div class="col-md-6">
      {!! Form::text('display_name', null, ['class'=>'form-control']) !!}
      {!! $errors->first('display_name', '<p class="help-block">*:message</p>') !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('description', 'Description', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
      {!! $errors->first('description', '<p class="help-block">*:message</p>') !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('status', 'Status', ['class'=>'col-md-2 control-label text-md-left req']) !!}
    <div class="col-md-6">
      {!! Form::select('status', array('' => '--- Choose ---', 'active' => 'Active', 'inactive' => 'Inactive'), null, ['class'=>'form-control']); !!}
      {!! $errors->first('status', '<p class="help-block">*:message</p>') !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('role', 'Role', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      <span id="acces">{!! $menus !!}</span>
      {!! $errors->first('role', '<p class="help-block">*:message</p>') !!}
    </div>
</div>

<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-2">
      {!! Form::submit('Submit', ['class'=>'btn btn-primary btnSubmit']) !!}
	  {!! Form::button('Cancel', ['class'=>'btn btn-secondary btnCancel', 'data-dismiss'=>'modal']) !!}
    </div>
</div>


<script>
 $(document).ready( function () {
	var urlPath = document.referrer;
	$("a.name_Nav").attr("href",urlPath);

	$("span.required").appendTo( ".req" );
  });

  $('#name').keypress(function (event) {
    var inputValue = event.charCode;
      if(!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123)||(inputValue==32) || (inputValue==0))){
          event.preventDefault();
      }
  });

  $('#display_name').keypress(function (event) {
    var inputValue = event.charCode;
      if(!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123)||(inputValue==32) || (inputValue==0))){
          event.preventDefault();
      }
  });

  $("li:has(li) > input[type='checkbox']").change(function() {
    $(this).siblings('ul').find("input[type='checkbox']").prop('checked', this.checked);
  });
  $("input[type='checkbox'] ~ ul input[type='checkbox']").change(function() {
    $(this).closest("li:has(li)").children("input[type='checkbox']").prop('checked', $(this).closest('ul').find("input[type='checkbox']").is(':checked'));
  });


  $('#formgroupuser').submit(function() {

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

      if ($('#display_name').val() === "") {
          $('#display_name').focus();
          swal({
              title: "Display Name error!",
              text: "This field is required : Display Name",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#display_name').val().length < 3) {
          $('#display_name').focus();
          swal({
              title: "Display Name error!",
              text: "Display Name must be minimal 3 characters",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#status').val() === "") {
          $('#status').focus();
          swal({
              title: "Status error!",
              text: "This field is required : Status",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }
		$(".btnSubmit").html("<i class='fa fa-spin fa-spinner'></i>");
		setTimeout(function () {
			 return true;
		},500);

  });
  // $('#btnCancel').click(function() {

$(document).on('click', '.btnCancel', function() {

	var urlPath = document.referrer;
	$(this).html("<i class='fa fa-spin fa-spinner'></i>");
	$(this).attr("href",urlPath);
	window.location = urlPath;
  });
  $(document).on('click', '.btnSubmit', function() {
	  console.log("click test");
	$(this).html("<i class='fa fa-spin fa-spinner'></i>");
  });

</script>
