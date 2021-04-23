<span class="required" style="color:red;">*</span>
<div class="row col-md-9 m-b-10 p-0">
  <div class="col-md-6 row">
    {!! Form::label('name', 'Full Name', ['class'=>'col-md-5 p-r-0 p-t-10 control-label text-md-left req']) !!}
    <div class="col-md-7 p-l-0">
      {!! Form::hidden('id', null, ['class'=>'form-control']) !!}
      {!! Form::text('name', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
      {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
  </div>

  <div class="col-md-6 row p-l-0">
    <!--{!! Form::label('phonenumber', 'Phone Number', ['class'=>'col-md-4 p-r-5 p-t-10 control-label text-md-left'], '<font color="#FF0000">*</font>') !!} -->
    {!! Form::label('phonenumber', 'Phone Number ', ['class'=>'col-md-4 p-r-5 p-t-10 control-label text-md-left']) !!}
    <div class="col-md-8 p-l-0">
        {!! Form::text('phonenumber', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
        {!! $errors->first('phonenumber', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
</div>

<div class="row col-md-9 m-b-10 p-0">
  <div class="col-md-6 row">
    {!! Form::label('username', 'Username', ['class'=>'col-md-5 p-r-0 p-t-10 control-label text-md-left req']) !!}
    <div class="col-md-7 p-l-0">
      {!! Form::text('username', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
	  <p class="help-note"></p>
      {!! $errors->first('username', '<p class="help-block">:message</p>') !!}
	  
    </div>
  </div>

  <div class="col-md-6 row p-l-0">
    {!! Form::label('email', 'Email', ['class'=>'col-md-4 p-r-5 p-t-10 control-label text-md-left req']) !!}
    <div class="col-md-8 p-l-0">
        {!! Form::email('email', null, ['class'=>'form-control']) !!}
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
</div>

<div class="row col-md-9 m-b-10 p-0">
  <div class="col-md-6 row"> 
    {!! Form::label('role_id', 'Role User', ['class'=>'col-md-5 p-r-0 p-t-10 control-label text-md-left req ']) !!}
    <div class="col-md-7 p-l-0">
      {!! Form::select('role_id', [''=>'']+App\Role::pluck('name','id')->all(), null, ['class'=>'form-control']) !!}
      {!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
    </div>
  </div>

  <div class="col-md-6 row p-l-0">
    {!! Form::label('id_client', 'Client', ['class'=>'col-md-4 p-r-5 p-t-10 control-label text-md-left']) !!}
    <div class="col-md-8 p-l-0">
        <select class="form-control" id="id_client" name="id_client" >
            <option value="">-- Choose --</option>
             @foreach ($client as $id => $name)  
                    <option value="{{$id}}"
                    @if (isset($user)) @if ($id == $user['id_client'])
                        selected="selected" @endif @endif 
                  >{{$name}}</option>
             @endforeach
       </select>
        {!! $errors->first('id_client', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
</div>

<div class="edited-info">
  <div class="row col-md-9 m-b-10 p-0">
    <div class="col-md-6 row">
      {!! Form::label('password', 'Password', ['class'=>'col-md-5 p-r-0 p-t-10 control-label text-md-left req']) !!}
      <div class="col-md-7 p-l-0">
          <div class="input-group">
          {!! Form::password('password', ['class'=>'form-control bright-none', 'maxlength' => 8]) !!}
            <div class="input-group-append">
              <div class="form-control showPass password" onclick="showPass('password')">
                <i class="fa fa-eye-slash"></i>
              </div>
            </div>
          </div>
          {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
      </div>
    </div>
  </div>
</div>

<div class="edited-info">
  <div class="row col-md-9 m-b-10 p-0 ">
    <div class="col-md-6 row">
      {!! Form::label('passwpassword_confirmationord', 'Confirm Password', ['class'=>'col-md-5 p-r-0 p-t-10 control-label text-md-left req']) !!}
      <div class="col-md-7 p-l-0">
        <div class="input-group">
        {!! Form::password('password_confirmation', ['class'=>'form-control bright-none', 'maxlength' => 8, 'id' => 'password_confirmation']) !!}
          <div class="input-group-append">
            <div class="form-control showPass password_confirmation" onclick="showPass('password_confirmation')">
              <i class="fa fa-eye-slash"></i>
            </div>
          </div>
        </div>
        {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
      </div>
    </div>
  </div>
</div>

<div class="form-group row hide">
    {!! Form::label('status', 'Status', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::select('status', array('active' => 'Active', 'inactive' => 'Inactive'), null, ['class'=>'form-control']); !!}
      {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="row col-md-9 m-b-10 m-t-30">
    <div class="">
      {!! Form::button('Next', ['class'=>'btn btn-primary btn-next']) !!}
	   {!! Form::button('Cancel', ['class'=>'btn btn-secondary btnCancel', 'data-dismiss'=>'modal']) !!}
    </div>
</div>

<div class="modal" id="popup" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Product:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
		<div class="row col-md-12">
			@foreach ($product as $id => $name)
			<div class="col-md-4 p-0">
			   <label>
					<input type="checkbox" name="id_product" class="id_product" value="{{$id}}" @if (isset($user)) @if (in_array($id, $user['id_product'])) checked @endif @endif style="position: relative;left: 0px;opacity: 1;"/>
			   {{$name}}
			   </label> 
			</div>
			@endforeach
		</div>
      </div>
      <div class="modal-footer">
        {!! Form::button('Submit', ['class'=>'btn btn-primary btn-submit']) !!}
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>

  $(document).ready(function(){
	// var t = window.location.href;
	// t = t.substr(0, t.lastIndexOf("\/"));
	var urlPath = document.referrer;
	$("a.name_Nav").attr("href",urlPath);

	if($('#form-default').hasClass('formedit')){
		var username = $('#username').val();
		if(username !== ''){
			$('#username').prop('readonly', 'true');
		}
		$('.edited-info').css('display', 'none');
	}

	 $("span.required").appendTo( ".req" );
  });
  
  
  $(document).on("click",".btn-next",function(){
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

      if ($('#username').val() === "") {
          $('#username').focus();
          swal({
              title: "Username error!",
              text: "This field is required : Username",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#username').val().length < 3) {
          $('#username').focus();
          swal({
              title: "Username error!",
              text: "Username must be minimal 3 characters",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($(".userexist").hasClass("red") || $(".help-note").html() !== ""){ //help-note add by delve
        $('#username').focus();
          swal({
              title: "Username error!",
              text: "Username must be unique",
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

      if ($('#phonenumber').val() !== "") {
        if ($('#phonenumber').val().length < 10) {
            $('#phonenumber').focus();
            swal({
                title: "Phone Number error!",
                text: "Phone number must be minimal 10 characters",
                timer: 1500,
                showConfirmButton: false
            });
            return false;
        }
      }

      if ($('#email').val() === "") {
          $('#email').focus();
          swal({
              title: "Email error!",
              text: "This field is required : Email",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      if (!emailReg.test($('#email').val())) {
          $('#email').focus();
         swal({
              title: "Email error!",
              text: "Wrong format email",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      } 

      if(!$('#form-default').hasClass('formedit')){

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
      }

      if ($('#password').val() !== "") {
        if ($('#password').val().length < 6 && $('#password').val().length > 8) {
            $('#password').focus();
            swal({
                title: "Password error!",
                text: "Password must be minimal 6 characters",
                timer: 1500,
                showConfirmButton: false
            });
            return false;
        }

        if ($('#password_confirmation').val() === "") {
            $('#password_confirmation').focus();
            swal({
                title: "Confirm Password error!",
                text: "This field is required : Confirm Password",
                timer: 1500,
                showConfirmButton: false
            });
            return false;
        }

        if ($('#password_confirmation').val() !== $('#password').val()) {
            $('#password_confirmation').focus();
            swal({
                title: "Password error!",
                text: "Password and Confirm Password must be identical",
                timer: 1500,
                showConfirmButton: false
            });
            return false;
        }
      }

      // if ($('#id_client').val() === "") {
          // $('#id_client').focus();
          // swal({
              // title: "Client error!",
              // text: "Please Choose Client",
              // timer: 1500,
              // showConfirmButton: false
          // });
          // return false;
      // }
	  
	  $("#popup").modal("show");
	  
	});

  function showPass(id) {
	  console.log(id);
	  console.log("2");
    event.preventDefault();
    
    if($('#'+id).attr("type") == "password"){
      var type = 'text';
      var addClassI = "fa-eye";
      var removeClassI = "fa-eye-slash";
    }else if($('#'+id).attr("type") == "text"){
      var type = 'password';
      var addClassI = "fa-eye-slash";
      var removeClassI = "fa-eye";
    } 
    
    $('#'+id).attr('type', type);
    $('.'+id+'.showPass > i').removeClass(removeClassI);
    $('.'+id+'.showPass > i').addClass(addClassI);
  }

  /*setTimeout(function () {    
    $('#id_product_chosen.chosen-container').addClass('form-control');
  }, 1000);*/

  $('#name').keypress(function (event) {
    var inputValue = event.charCode;
      if(!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123)||(inputValue==32) || (inputValue==0))){
          event.preventDefault();
      }
  });

  $('#username').keypress(function (event) {
    var inputValue = event.charCode;
      if(!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123) || (inputValue > 47 && inputValue < 58))){
          event.preventDefault();
      }
  });

  $("#username").keyup(function(event){
    event.preventDefault()
    if($("#username").val().length >= 3){
        var username = $("#username").val();
        $.ajax({
          url: '../username/'+username,
          type: "GET",
          dataType: 'json', 
          success: function (data) {
            console.log(data);
            if(data == true){
              $(".help-note, .userexist").html("");
            }else{
              $(".userexist").addClass("red").html("*User already exist");
              $(".help-note").html("*User already exist");
            }
          } 
        });
    }
  });

  $('#phonenumber').keypress(function (event) {
    var inputValue = event.charCode;
      if(!(inputValue > 47 && inputValue < 58)){
          event.preventDefault();
      }
  });

  $('.btn-submit').click(function() {

    var url = $('#form-default').attr('posturl');
	
    var method = $('#form-default').attr('postmethod');

	  var id_products = "";
	  $(document).find(".id_product:checked").each(function(){
		  id_products += $(this).val() +",";
	  });
	  
	  var final_id_product = id_products.slice(0, -1);
	
      $.ajax({
        crossDomain: true,
        crossOrigin: true,
        cache: false,
        type: "POST",
        url: url,
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: { 
          name : $('#name').val(),
          username : $('#username').val(),
          phonenumber : $('#phonenumber').val(),
          id_product : final_id_product,
          id_client : $('#id_client').val(),
          email : $('#email').val(),
          password :  $('#password').val(),
          password_confirmation :  $('#password_confirmation').val(),
          role_id : $('#role_id').val(),
          status : $('#status').val()
        },
        success: function(test) {
			console.log(test);
			console.log("test delve");
          swal({
            title: "Done!",
            text: "Data has been "+method+" successfully!",
            type: "success",
               },function() {   
                setTimeout(function () {        
                  window.location = "{{ route('manusers.index') }}";
                },50);
          });

        }
      });
  });
$(document).on('click', '.btnCancel', function() {
	
	var urlPath = document.referrer;
	$(this).html("<i class='fa fa-spin fa-spinner'></i>");
	$(this).attr("href",urlPath);
	window.location = urlPath;
});
</script>