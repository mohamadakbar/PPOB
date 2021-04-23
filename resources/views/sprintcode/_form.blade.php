<div class="form-group col-md-6 row">
	{!! Form::label('responseCode', 'Response Code', ['class'=>'col-md-5 p-r-0 p-t-10 control-label text-md-left']) !!}
	<div class="col-md-7 p-l-0">
	  {!! Form::text('responseCode', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
	  {!! $errors->first('responseCode', '<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group col-md-6 row">
	{!! Form::label('status', 'Status', ['class'=>'col-md-5 p-r-0 p-t-10 control-label text-md-left']) !!}
	<div class="col-md-7 p-l-0">
	  {!! Form::text('status', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
	  {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group col-md-6 row">
	{!! Form::label('description', 'Description', ['class'=>'col-md-5 p-r-0 p-t-10 control-label text-md-left']) !!}
	<div class="col-md-7 p-l-0">
	  {!! Form::text('description', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
	  {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group row mb-0">
    <div class="col-md-6">
      {!! Form::button('Submit', ['class'=>'btn btn-primary btn-submit']) !!}
    </div>
</div>

<script type="text/javascript">

  $('.btn-submit').click(function() {

    var url = $('#form-default').attr('posturl');
    var method = $('#form-default').attr('postmethod');

      if ($('#responseCode').val() === "") {
          $('#responseCode').focus();
          swal({
              title: "Response Code error!",
              text: "This field is required : Response Code",
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

      if ($('#description').val() === "") {
          $('#description').focus();
          swal({
              title: "Description error!",
              text: "Please Choose Description",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

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
          responseCode: $('#responseCode').val(), 
          status : $('#status').val(),
          description : $('#description').val()
        },
        success: function(test) {
          swal({
            title: "Done!",
            text: "Data has been "+method+" successfully!",
            type: "success",
               },function() {   
                setTimeout(function () {        
                  window.location = "{{ route('sprint-code.index') }}";
                },50);
          });

        }
      });
    });


</script>
