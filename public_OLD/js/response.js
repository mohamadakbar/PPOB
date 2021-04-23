//On Change Auth
$('#resptype').on('change', function(e){
    var resptype = $('#resptype').val();
    if(resptype == 'text'){
      $('#rtype-div').show();
    }else{
      $('#rtype-div').hide();
    }
});

//On Click Save Succ
$(document).ready(function(){
  $("#savesucc").click(function(){

    var rcode = [];
    var rdesc = [];
    var expire = $("#cache_expire6").val();

    //Get Key
    $.each($("input[name^='succ-code']"), function(){
      //console.log($(this).val());
      rcode.push($(this).val());
    });

    //Get Value
    $.each($("input[name^='succ-desc']"), function(){
      //console.log($(this).val());
      rdesc.push($(this).val());
    });

    var dataString = 'type=form&rcode='+ rcode + '&rdesc='+ rdesc + '&expiration='+ expire;
    if(rcode==''||rdesc=='')
    {
      alert("The code and desc field is required.");
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
        url: "/adminpanel/store_resptype",
        data: dataString,
        cache: false,
        success: function(result){
        console.log("Result:"+result);
        $('#showModal6').modal('hide');
        $('#btnSucc').hide();
        $('#btnSuccEdit').show();
        }
      });
    }
    return false;

  });
});
