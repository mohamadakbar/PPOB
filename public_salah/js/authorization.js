//On Change Auth
$('#authorization').on('change', function(e){
    var author = $('#authorization').val();
    if(author == 'basic'){
      $('#showModal3').modal('show');
    }else if(author == 'key'){
      $('#showModal4').modal('show');
    }else if(author == 'token'){
      $('#showModal5').modal('show');
    }
});

//On Click Save Form 3
$(document).ready(function(){
  $("#saveform3").click(function(){

    var uname = $("#uname").val();
    var passwd = $("#passwd").val();
    var expire = $("#cache_expire3").val();

    var dataString = 'auth=basic&uname='+ uname + '&passwd='+ passwd + '&expiration='+ expire;
    if(uname==''||passwd=='')
    {
      alert("The username and password field is required.");
    }
    else
    {
      //AJAX Code To Submit Form.
      $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
      });
      $.ajax({
        type: "POST",
        url: "/adminpanel/store_authtype",
        data: dataString,
        cache: false,
        success: function(result){
        console.log("Result:"+result);
        $('#showModal3').modal('hide');
        $('#atype-div').show();
        $('#btnModal3').show();
        $('#btnModal4').hide();
        $("#useheader").prop("checked",false);
        }
      });
    }
    return false;

  });
});


//On Click Save Form 4
$(document).ready(function(){
  $("#saveform4").click(function(){

    var apikey = $("#apikey").val();
    var apivalue = $("#apivalue").val();
    var expire = $("#cache_expire4").val();

    var dataString = 'auth=key&apikey='+ apikey + '&apivalue='+ apivalue + '&expiration='+ expire;
    if(apikey==''||apivalue=='')
    {
      alert("The key and value field is required.");
    }
    else
    {
      //AJAX Code To Submit Form.
      $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
      });
      $.ajax({
        type: "POST",
        url: "/adminpanel/store_authtype",
        data: dataString,
        cache: false,
        success: function(result){
        console.log("Result:"+result);
        $('#showModal4').modal('hide');
        $('#atype-div').show();
        $('#btnModal4').show();
        $('#btnModal3').hide();
        $("#useheader").prop("checked",true);
        }
      });
    }
    return false;

  });
});


//On Click Save Form 5
$(document).ready(function(){
  $("#saveform5").click(function(){

    var token = $("#token").val();
    var expire = $("#cache_expire5").val();

    var dataString = 'auth=token&token='+ token + '&expiration='+ expire;
    if(token=='')
    {
      alert("The token field is required.");
    }
    else
    {
      //AJAX Code To Submit Form.
      $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
      });
      $.ajax({
        type: "POST",
        url: "/adminpanel/store_authtype",
        data: dataString,
        cache: false,
        success: function(result){
        console.log("Result:"+result);
        $('#showModal5').modal('hide');
        $('#atype-div').show();
        $('#btnModal5').show();
        $('#btnModal4').hide();
        $('#btnModal3').hide();
        $("#useheader").prop("checked",false);
        }
      });
    }
    return false;

  });
});
