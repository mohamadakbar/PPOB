@extends('layouts.login')

@section('content')


@if(Session::has('error'))
      <script type="text/javascript">
         alert("Login Error : Username or Password not match");
       </script>
@endif
    <div class="login-box row shadow-s ">
      <div class="card-body col-sm-6 br-5-l left-card class-card" align="center" style="background-size:auto 100%;background-repeat:no-repeat;background-position: -31px;border-right: 1px solid #eee;">
              
    </div>
    <div class="card-body col-sm-6 bg-l-t br-5-r right-card" style="min-height: 420px;">
    <form class="form-horizontal form-material loginform" id="loginform" method="POST" action="{{ url('/login') }}">
        {{ csrf_field() }}
        <div class="text-l-t-s">
            <h2>Login</h2>
        </div>
        <div class="login-switch">
            <div class="form-group" style="margin-top:35px;">
                <div class="col-xs-12">
                    <input class="form-control mName" name="email" maxlength="50" type="text" required="" value="{{ old('email') }}" placeholder="Email / Username" style="padding-left:6px;">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 fz13">
                    <div class="input-group">
                        <input class="form-control mPass p-l-6" name="password" maxlength="8" type="password" required="" value="" placeholder="Password" style="padding-left:6px;">
                        <div class="input-group-append">
                            <div class="form-control showPass" style="padding: 10px 5px; cursor: pointer;">
                                <i class="fa fa-eye-slash"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row fz13">
                <div class="col-sm-6">
                    <div class="checkbox checkbox-primary pull-left fz13">
                        <input id="checkbox-signup" type="checkbox" class="filled-in chk-col-light-blue">
                        <label for="checkbox-signup"> Remember</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <a href="javascript:void(0)" id="to-recover" class="text-dark-blue "><!--i class="fa fa-lock m-r-5"--></i> Forget Password ?</a> 
                </div>
            </div>
            <div class="form-group text-center m-t-20">
              <input type="submit" class="btn btn-info btn-md text-uppercase btn-rounded" value="Login">
            </div>
        </div>
        <div class="chooseDivisionForm" style="display:none;margin-top: 70px;">
            <div class="form-group ">
                <div class="col-xs-12" style="text-align: center;">
                    <select class="form-control chooseDivision" name="chooseDivision"></select>
                    <div align="center" class="selectdivisionSpin"></div>
                    <button class="btn btn-info btn-sm text-uppercase choose-back-to-login" style="margin-top:30px" type="button">Back To Login</button>
                </div>
            </div>
        </div>
      </form>
    </div> 
  </div>

  <div class="form-horizontal card-body br-full col-sm-3 right-card" id="recoverform">
    <!--div class="form-group ">
      <div class="col-xs-12">
      <h3>Forgot Password</h3>
      <p class="text-muted">Enter your username and instructions will be sent to your email! </p>
      </div>
    </div-->
    <div class="img-l-s mb-30" align="center">Forget Password</div>
    <div class="form-group form-material">
      <div class="col-xs-12">
        <input class="form-control Forgotusername" type="text" required="" placeholder="Email / Username" name="Forgotusername">
      </div>
    </div>
    <div class="form-group msg-ss-p" align="center" style="display:none;padding: 3px;box-shadow: 0px 0px 4px #ef2510;border-radius: 3px;">
      <div class="msg-ss"></div>
    </div>
    <div class="form-group text-center m-t-20">
      <div class="col-xs-12">
        <button class="btn btn-outline btn-block text-uppercase fw-600 text-dark-blue ForgotusernameBtn" type="submit">submit</button>
      </div>
      <div class="col-xs-12" style="margin-top: 15px;">
        <button class="btn btn-outline btn-sm btn-block text-uppercase fw-600 back-to-login text-dark-blue"> &lt; Back To Login</button>
      </div>
    </div>
  </div>    




<!-- ALERT -->
<div id="mAlertDialog" aria-hidden="true" role="dialog" tabindex="-1" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div id="mHeader" class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button id="mBtnOk" class="btn btn-primary" type="button" data-dismiss="modal">&nbsp;&nbsp;OK&nbsp;&nbsp;</button>
      </div>
    </div>
  </div>
</div>  

<!-- LOADER -->
<div id="mLoaderDialog" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content bg-black-rgba">
      <div class="modal-body bg-black-trans" style="text-align: center;">
        <p><span>Silahkan tunggu...</span></p>
      </div>  
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function(){    
    cek_width_d($(document).width());
    
    $( window ).resize(function() {
      cek_width_d($(document).width());
    });
    
  });
  
  function cek_width_d(w){
    if(w<768){
      $(".login-box").css("width","90%");
      $(".login-register").css({"position":"relative","overflow":"visible"});
      $("body,html").css({"background":"#007bff","overflow":"visible"});
      $(".left-card").removeClass("br-5-l"); $(".right-card").removeClass("br-5-r");
      }else{
      $(".login-box").css("width","800px");
      $(".login-register").css({"position":"fixed","overflow":"hidden"});
      $(".left-card").addClass("br-5-l"); $(".right-card").addClass("br-5-r");                
      $("body").addClass("bg-body");
    }
  }
  
  function animated(selector,anim){
    $(selector).addClass('animated '+anim+' delay-2s');
    $(selector).show(); 
    setTimeout(function(){
      $(selector).removeClass('animated '+anim+' delay-2s');
    },1000);       
  }
  
  $(function() {
    $(".preloader").fadeOut();
    $('[data-toggle="tooltip"]').tooltip();
  });
  // ============================================================== 
  // Login and Recover Password 
  // ============================================================== 
  
  $('#to-recover').on("click", function() {
    //$("#loginform").slideUp();
    animated(".login-box","fadeOutUp");
    setTimeout(function(){
      $(".login-box").hide();
      animated("#recoverform","fadeInUp");
    },700);
    
  });
    
    $(".showPass").on('click', function(event) {
        event.preventDefault();
        
        if($('.mPass').attr("type") == "password"){
            var type = 'text';
            var addClassI = "fa-eye";
            var removeClassI = "fa-eye-slash";
        }else if($('.mPass').attr("type") == "text"){
            var type = 'password';
            var addClassI = "fa-eye-slash";
            var removeClassI = "fa-eye";
        } 
        
        $('.mPass').attr('type', type);
        $('.showPass > i').removeClass(removeClassI);
        $('.showPass > i').addClass(addClassI);
    });
  
  $('.choose-back-to-login').on("click", function() {
    $(".chooseDivisionForm").hide();
        $(".login-switch").show();
        
    });
  
    $('.back-to-login').on("click", function() {
    animated("#recoverform","fadeOutDown");
    setTimeout(function(){
      $(".chooseDivisionForm").hide();
      $("#recoverform").hide();
      $("#loginform").show();
      animated(".login-box","fadeInDown");
    },700);            
  });
  
  $('.back-to-login2').on("click", function() {
    $("#loginform").slideDown();
    $("#recoverform").slideUp();
    $(".chooseDivisionForm").hide();
  });
  
  $('.ForgotusernameBtn').on("click", function() {
    
    if ($.trim($(".Forgotusername").val()) === '') {
      alert('This field is required: Username');
      return;
    }
    
    var username = $(".Forgotusername").val();
    var userData = { "userName": username };
    
    $.ajax({
      url: baseApiUrl +"/api/application/resetpassword",
      type: "POST",
      contentType: "application/json",
      beforeSend: function(xhr, settings) {
        //xhr.setRequestHeader('Authorization','Bearer ' + token);
        
      },
      data: JSON.stringify(userData),
      success: function(data, status) {
        
        if(data.status === "failed"){
          alert('Failed: ' + data.message);
          }else{
          alert('Success: new password has been sent to your e-mail');
        }       
        
      } 
    }); 
  });
  
  $('.mPass, .mName').keypress(function(event){
    
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
      $('.btn-rounded').click();
    }
    
    event.stopPropagation();
  });
  
  function convertDate(inputFormat) {
    function pad(s) { return (s < 10) ? '0' + s : s; }
    var d = new Date(inputFormat);
    return [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join('/');
  }
  
  function setCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
  
  function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }    

  
  $('.ForgotusernameBtn').on("click", function() {
    
    if ($.trim($(".Forgotusername").val()) === '') {
      alert('This field is required: Username');
      return;
    }
    
    var username = $(".Forgotusername").val();
    var userData = { "userName": username };
    
    $.ajax({
      url: baseApiUrl +"/api/application/resetpassword",
      type: "POST",
      contentType: "application/json",
      beforeSend: function(xhr, settings) {
        
      },
      data: JSON.stringify(userData),
      success: function(data, status) {
        
        if(data.status === "failed"){
          alert('Failed: ' + data.message);
          }else{
          alert('Success: new password has been sent to your e-mail');
        }       
        
      } 
    }); 
  });
  
</script>

@endsection
