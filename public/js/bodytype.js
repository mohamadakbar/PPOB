//On Change Body Type
$('#body_type').on('change', function(e){
    var bodyval = $('#body_type').val();
    if(bodyval == 'form' || bodyval == 'formencode'){
      $('#showModal').modal('show');
    }else if(bodyval == 'raw'){
      $('#showModal2').modal('show');
    }
});

//On Click Save Form 1
$(document).ready(function(){
  $("#saveform1").click(function(){

    var keys = [];
    var values = [];
    var expire = $("#cache_expire").val();

    //Get Key
    $.each($("input[name^='key-param']"), function(){
      //console.log($(this).val());
      keys.push($(this).val());
    });

    //Get Value
    $.each($("input[name^='key-value']"), function(){
      //console.log($(this).val());
      values.push($(this).val());
    });

    var dataString = 'type=form&keys='+ keys + '&values='+ values + '&expiration='+ expire;
    if(keys==''||values=='')
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
        url: "/adminpanel/store_formtype",
        data: dataString,
        cache: false,
        success: function(result){
        console.log("Result:"+result);
        $('#showModal').modal('hide');
        $('#btype-div').show();
        $('#btnModal').show();
        $('#btnModal2').hide();
        }
      });
    }
    return false;

  });
});

//On Click Save Form 2
$(document).ready(function(){
  $("#saveform2").click(function(){

    var jsonparam = btoa($('textarea#jsonparam').val());
    var expire = $("#cache_expire2").val();

    var dataString = 'type=json&json='+ jsonparam + '&expiration='+ expire;
    if(jsonparam=='')
    {
      alert("The JSON Body field is required.");
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
        url: "/adminpanel/store_formtype",
        data: dataString,
        cache: false,
        success: function(result){
        console.log("Result:"+result);
        $('#showModal2').modal('hide');
        $('#btype-div').show();
        $('#btnModal2').show();
        $('#btnModal').hide();
        }
      });
    }
    return false;

  });
});
