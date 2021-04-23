<div class="form-group row">
    {!! Form::label('producttype_name', 'Name', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::text('producttype_name', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
      {!! $errors->first('producttype_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row {!! $errors->has('author_id') ? 'has-error' : '' !!}">
  {!! Form::label('producttype_category_id', 'Product Category', ['class'=>'col-md-2 control-label']) !!}
  <div class="col-md-6">
    {!! Form::select('producttype_category_id', App\ProductCategory::pluck('category_name','id')->all(), null, ['class'=>'js-selectize form-control','placeholder' => '--- Choose ---']) !!}
    {!! $errors->first('producttype_category_id', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group row">
    {!! Form::label('producttype_active', 'Status', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::select('producttype_active', array('' => '--- Choose ---', '1' => 'Active', '2' => 'Inactive'), null, ['class'=>'form-control']); !!}
      {!! $errors->first('producttype_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-2">
      {!! Form::button('Submit', ['class'=>'btn btn-primary btn-submit']) !!}
    </div>
</div>

<script type="text/javascript">

  $('#producttype_name').keypress(function (event) {
    var inputValue = event.charCode;
      if(!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123) || (inputValue >= 48 && inputValue <= 57) ||(inputValue==32) || (inputValue==0))){
          event.preventDefault();
      }
  });

  $('.btn-submit').click(function() {

    var url = $('#form-default').attr('posturl');
    var method = $('#form-default').attr('postmethod');

      if ($('#producttype_name').val() === "") {
          $('#producttype_name').focus();
          swal({
              title: "Name error!",
              text: "This field is required : Name",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#producttype_name').val().length < 3) {
          $('#producttype_name').focus();
          swal({
              title: "Name error!",
              text: "Name must be minimal 3 characters",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#producttype_category_id').val() === "") {
          $('#producttype_category_id').focus();
          swal({
              title: "Product Type error!",
              text: "Please Choose Product Type",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#producttype_active').val() === "") {
          $('#producttype_active').focus();
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
            producttype_name: $('#producttype_name').val(),
            producttype_category_id : $('#producttype_category_id').val(),
            producttype_active : $('#producttype_active').val()
        },
        success: function(test) {
          swal({
            title: "Done!",
            text: "Data has been "+method+" successfully!",
            type: "success",
               },function() {
                setTimeout(function () {
                  window.location = "{{ route('prodtype.index') }}";
                },50);
          });

        }
      });
    });


</script>
