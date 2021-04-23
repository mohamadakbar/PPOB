 @extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
      <div class="panel-body">
        {!! Form::model($user, ['id' => 'form-default', 'postmethod' => 'Edited', 'posturl' => route('manusers.updates', $user->id),'method'=>'put', 'class'=>'form-horizontal formedit']) !!}
        
          <div class="form-group row">
                {!! Form::label('old_password', 'Old Password', ['class'=>'col-md-2 control-label text-md-left']) !!}
                <div class="col-md-6">
                  <div class="input-group">
                  {!! Form::password('old_password', ['class'=>'form-control bright-none', 'maxlength' => 8, 'data-password' => $user->password]) !!}
                    <div class="input-group-append">
                      <div class="form-control showPass old_password" onclick="showPass('old_password')">
                        <i class="fa fa-eye-slash"></i>
                      </div>
                    </div>
                  </div>
                  {!! $errors->first('old_password', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group row">
                {!! Form::label('password', 'New Password', ['class'=>'col-md-2 control-label text-md-left']) !!}
                <div class="col-md-6">
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

            <div class="form-group row">
                {!! Form::label('password_confirmation', 'Confirm Password', ['class'=>'col-md-2 control-label text-md-left']) !!}
                <div class="col-md-6">
                  <div class="input-group">
                  {!! Form::password('password_confirmation', ['class'=>'form-control bright-none', 'maxlength' => 8]) !!}
                    <div class="input-group-append">
                      <div class="form-control showPass password_confirmation" onclick="showPass('password_confirmation')">
                        <i class="fa fa-eye-slash"></i>
                      </div>
                    </div>
                  </div>
                  {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
                </div>
            </div>


          <div class="edited-info">
            <div class="form-group row">
                {!! Form::label('name', 'Full Name', ['class'=>'col-md-2 control-label text-md-left']) !!}
                <div class="col-md-6">
                  {!! Form::hidden('id', null, ['class'=>'form-control']) !!}
                  {!! Form::text('name', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
                  {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('username', 'Username', ['class'=>'col-md-2 control-label text-md-left']) !!}
                <div class="col-md-6">
                  {!! Form::text('username', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
                  {!! $errors->first('username', '<p class="help-block">:message</p>') !!}
                  <span class="userexist"></span>
                </div>
            </div>

            <div class="form-group row {!! $errors->has('author_id') ? 'has-error' : '' !!}">
              {!! Form::label('role_id', 'Role User', ['class'=>'col-md-2 control-label']) !!}
              <div class="col-md-6">
                {!! Form::select('role_id', [''=>'']+App\Role::pluck('name','id')->all(), null, ['class'=>'form-control']) !!}
                {!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
              </div>
            </div>

            <div class="form-group row">
                {!! Form::label('phonenumber', 'Phone Number', ['class'=>'col-md-2 control-label text-md-left']) !!}
                <div class="col-md-6">
                  {!! Form::text('phonenumber', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
                  {!! $errors->first('phonenumber', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('email', 'Email', ['class'=>'col-md-2 control-label text-md-left']) !!}
                <div class="col-md-6">
                  {!! Form::email('email', null, ['class'=>'form-control']) !!}
                  {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group row">
                {!! Form::label('id_client', 'Client', ['class'=>'col-md-2 control-label text-md-left']) !!}
                <div class="col-md-6">
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

            <div class="form-group row">
                {!! Form::label('id_product', 'Product', ['class'=>'col-md-2 control-label text-md-left']) !!}
                <div class="col-md-6">
                  <select multiple data-placeholder="Choose Product" class="form-control" id="id_product" name="id_product">
                       @foreach ($product as $id => $name)  
                              <option value="{{$id}}"
                              @if (isset($user)) @if (in_array($id, $user['id_product']))
                                  selected="selected" @endif @endif 
                            >{{$name}}</option>
                       @endforeach
                 </select>
                  {!! $errors->first('id_client', '<p class="help-block">:message</p>') !!}
                </div>
            </div>



            <div class="form-group row hide">
                {!! Form::label('status', 'Status', ['class'=>'col-md-2 control-label text-md-left']) !!}
                <div class="col-md-6">
                  {!! Form::select('status', array('active' => 'Active', 'inactive' => 'Inactive'), null, ['class'=>'form-control']); !!}
                  {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
          </div>

          <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-2">
                {!! Form::button('Submit', ['class'=>'btn btn-primary btn-submit']) !!}
				  {!! Form::button('Cancel', ['class'=>'btn btn-secondary btnCancel', 'data-dismiss'=>'modal']) !!}
              </div>
          </div>

          
            <script>

              $("#id_product").chosen({
                max_selected_options: 1,
                no_results_text: "Oops, nothing found!",
                width: "95%",
                //max_shown_results:3
              });

              $(document).ready(function(){
				var urlPath = document.referrer;
				$("a.name_Nav").attr("href",urlPath);
				  
                 if($('#form-default').hasClass('formedit')){
                    var username = $('#username').val();
                      if(username !== ''){
                        $('#username').prop('readonly', 'true');
                      }
                    $('.edited-info').css('display', 'none');
                 }
              });

              function showPass(id) {
                event.preventDefault();
                console.log(id);
				console.log("1");
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

              $('.btn-submit').click(function() {

                var url = $('#form-default').attr('posturl');
                var method = $('#form-default').attr('postmethod');
                  console.log('aaaaa');

                    if ($('#old_password').val() === "") {
                        $('#old_password').focus();
                        swal({
                            title: "Old Password error!",
                            text: "This field is required : Old Password",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        return false;
                    }

                    if ($('#old_password').val().length !== 8) {
                        $('#old_password').focus();
                        swal({
                            title: "Old Password error!",
                            text: "Password must be 8 characters",
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

                    if ($('#password').val().length !== 8) {
                        $('#password').focus();
                        swal({
                            title: "Password error!",
                            text: "Password must be 8 characters",
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

                    $.ajax({
                      cache: false,
                      type: "POST",
                      url:  '{!! route('manusers.checkpass') !!}',
                      headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                      },
                      data: { 
                        old_password :  $('#old_password').val(),
                        password_hash :  $('#old_password').attr('data-password')
                      },
                      success: function(test) {
                        if (test !== "success") {
                            $('#old_password').focus();
                            swal({
                                title: "Old Password error!",
                                text: "Old Password must be the same as your last password",
                                timer: 1500,
                                showConfirmButton: false
                            });
                            return false;
                        }else{
                          $.ajax({
                            cache: false,
                            type: "POST",
                            url:  url,
                            headers: {
                              'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            data: { 
                              name : $('#name').val(),
                              username : $('#username').val(),
                              phonenumber : $('#phonenumber').val(),
                              id_product : $('#id_product').val(),
                              id_client : $('#id_client').val(),
                              email : $('#email').val(),
                              password :  $('#password').val(),
                              password_confirmation :  $('#password_confirmation').val(),
                              role_id : $('#role_id').val(),
                              status : $('#status').val()
                            },
                            success: function(test) {
                              console.log(url);
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
                        }


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


        {!! Form::close() !!}
      </div>
    </div>
@endsection
 

