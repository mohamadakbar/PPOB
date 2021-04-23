<div class="form-group row">
    {!! Form::label('category_name', 'Name', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::hidden('id', null, ['class'=>'form-control']) !!}
      {!! Form::text('category_name', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
      {!! $errors->first('category_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('category_active', 'Status', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::select('category_active', array('' => '--- Choose ---', '1' => 'Active', '2' => 'Inactive'), null, ['class'=>'form-control']); !!}
      {!! $errors->first('category_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-2">
      {!! Form::button('Submit', ['class'=>'btn btn-primary btn-submit']) !!}
    </div>
</div>

<script>

  $('#name').keypress(function (event) {
    var inputValue = event.charCode;
      if(!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123) || (inputValue >= 48 && inputValue <= 57) ||(inputValue==32) || (inputValue==0))){
          event.preventDefault();
      }
  });

  $('.btn-submit').click(function() {

    var url = $('#form-default').attr('posturl');
    console.log(url);
    var method = $('#form-default').attr('postmethod');

      if ($('#category_name').val() === "") {
          $('#category_name').focus();
          swal({
              title: "Name error!",
              text: "This field is required : Name",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#category_name').val().length < 3) {
          $('#category_name').focus();
          swal({
              title: "Name error!",
              text: "Name must be minimal 3 characters",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#category_active').val() === "") {
          $('#category_active').focus();
          swal({
              title: "Status error!",
              text: "Please Choose Status",
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
            category_name: $('#category_name').val(),
            category_active: $('#category_active').val()
        },
        success: function(test) {
          swal({
            title: "Done!",
            text: "Data has been "+method+" successfully!",
            type: "success",
               },function() {
                setTimeout(function () {
                  window.location = "{{ route('prodcat.index') }}";
                },50);
          });

        }
      });

  });

</script>
