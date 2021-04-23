<div class="form-group row p-0 col-md-12 m-b-40">
	<div class="col-md-2">Method*</div>
    <div class="row col-md-5">
		<div class="col-md-4 p-0">
			<label>
			  {!! Form::radio('method', 'manual', true, ['class'=>'chk-method', 'style'=>'position: relative;left: 0px;opacity: 1;']) !!}
			  Manual
			</label>
		</div>
		<div class="col-md-6 p-0">
			<label class="fromfile">
			  {!! Form::radio('method', 'fromfile', false, ['class'=>'chk-method fromfile', 'style'=>'position: relative;left: 0px;opacity: 1;']) !!}
			  From File
			</label>
		</div>
    </div>
</div>

<div class="form-group row col-md-12 s-product-sprint">
		<div class="form-group row col-md-5">
			{!! Form::label('productSprint', 'Product Name (Sprint)', ['class'=>'control-label text-md-left panel-status']) !!}
			<div class="col-md-7">
			  <select class="form-control" id="productSprint" name="productSprint" >
				  <option value="">-- Choose --</option>
				   @foreach ($data['productPartner'] as $id => $name)
						  <option value="{{$id}}"
						  @if (isset($prodforpartner['productCode'])) @if ($id == $prodforpartner['productCode'])
							  selected="selected" @endif @endif
						>{{$name}}</option>
				   @endforeach
			  </select>
			  {!! $errors->first('productSprint', '<p class="help-block">:message</p>') !!}
			</div>
		</div>
	</div>

<div class="content-chk" id="manual">

	<div class="row col-md-9 m-b-10 p-0">
		<div class="col-md-6 row">
			{!! Form::label('partnerProductName', 'Product Names', ['class'=>'col-md-5 p-r-0 p-t-10 control-label text-md-left']) !!}
			<div class="col-md-7 p-l-0">
			  {!! Form::text('partnerProductName', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
			  {!! $errors->first('partnerProductName', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="col-md-6 row p-l-0">
			{!! Form::label('partnerProductCode', 'Product Code', ['class'=>'col-md-4 p-r-5 p-t-10 control-label text-md-left']) !!}
			<div class="col-md-8 p-l-0">
			  {!! Form::text('partnerProductCode', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
			  {!! $errors->first('partnerProductCode', '<p class="help-block">:message</p>') !!}
			</div>
		</div>
	</div>

	<div class="row col-md-9 m-b-10 p-0">
		<div class="col-md-6 row">
			{!! Form::label('price', 'Partner Price', ['class'=>'col-md-5 p-r-0 p-t-10 control-label text-md-left']) !!}
			<div class="col-md-7 p-l-0">
			  {!! Form::text('price', null, ['class'=>'form-control','autofocus'=>'autofocus', 'placeholder'=>'Rp.']) !!}
			  {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
			</div>
		</div>
		<div class="col-md-6 row p-l-0">
			{!! Form::label('denom', 'denom', ['class'=>'col-md-4 p-r-5 p-t-10 control-label text-md-left']) !!}
			<div class="col-md-8 p-l-0">
			  {!! Form::text('denom', null, ['class'=>'form-control','autofocus'=>'autofocus', 'placeholder'=>'Rp.']) !!}
			  {!! $errors->first('denom', '<p class="help-block">:message</p>') !!}
			</div>
		</div>
	</div>

	<div class="row col-md-9 m-b-10 p-0">
		<div class="col-md-6 row">
			{!! Form::label('cashback', 'Cashback', ['class'=>'col-md-5 p-r-0 p-t-10 control-label text-md-left']) !!}
			<div class="col-md-7 p-l-0">
			  {!! Form::text('cashback', null, ['class'=>'form-control','autofocus'=>'autofocus', 'placeholder'=>'Rp.']) !!}
			  {!! $errors->first('cashback', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="col-md-6 row p-l-0">
			{!! Form::label('adminFee', 'Admin Fee', ['class'=>'col-md-4 p-r-5 p-t-10 control-label text-md-left']) !!}
			<div class="col-md-8 p-l-0">
			  {!! Form::text('adminFee', null, ['class'=>'form-control','autofocus'=>'autofocus', 'placeholder'=>'Rp.']) !!}
			  {!! $errors->first('adminFee', '<p class="help-block">:message</p>') !!}
			</div>
		</div>
	</div>

	<div class="row col-md-9 m-b-10 p-0">
		<div class="col-md-6 row">
			{!! Form::label('status', 'Status', ['class'=>'col-md-5 p-r-0 p-t-10 control-label text-md-left']) !!}
			<div class="col-md-7 p-l-0">
			  {!! Form::select('status', array('' => '--- Choose ---', '1' => 'Active', '2' => 'Inactive'), null, ['class'=>'form-control']); !!}
			  {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
			</div>
		</div>
	</div>

</div>

<!--div class="row col-md-9 m-b-10 p-0">
	<div class="col-md-6 row">
		{!! Form::label('status', 'Status', ['class'=>'col-md-5 p-r-0 p-t-10 control-label text-md-left']) !!}
		<div class="col-md-7 p-l-0">
		  {!! Form::select('status', array('' => '--- Choose ---', '1' => 'Active', '2' => 'Inactive'), null, ['class'=>'form-control']); !!}
		  {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
</div-->

<div class="content-chk" id="fromfile"style="display:none;">
	@if(count($errors) > 0)
    <div class="alert alert-danger">
     Upload Validation Error<br><br>
     <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif

   @if($message = Session::get('success'))
   <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
           <strong>{{ $message }}</strong>
   </div>
   @endif
   <form method="post" enctype="multipart/form-data" action="{!! route('productforpartnerUpload') !!}">
    {{ csrf_field() }}
    <div class="form-group">
     <table class="table">
      <tr>
       <td width="40%" align="right"><label>Select File for Upload</label></td>
       <td width="30">
        <input type="file" name="select_file" />
       </td>
       <td width="30%" align="left">
        <input type="submit" name="upload" class="btn btn-primary" value="Upload">
       </td>
      </tr>
      <tr>
       <td width="40%" align="right"></td>
       <td width="30"><span class="text-muted">.xls, .xslx</span></td>
       <td width="30%" align="left"></td>
      </tr>
     </table>
    </div>
   </form>
</div>

<div class="row col-md-9 m-b-10 m-t-30 manual">
	<div class="offset-md-8">
	  {!! Form::button('Save Data', ['class'=>'btn btn-primary btn-submit']) !!}
	  {!! Form::reset('Cancel', ['class'=>'btn btn-secondary', 'style'=>'height:38px']) !!}
	</div>
</div>
<script>

  $('#name, #product_code, #partner_product_code').keypress(function (event) {
    var inputValue = event.charCode;
      if(!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123) || (inputValue >= 48 && inputValue <= 57) ||(inputValue==32) || (inputValue==0))){
          event.preventDefault();
      }
  });

  var method = $('#form-default').attr('postmethod');
	if(method == "Edited"){
	  //$("input[value=fromfile").prop("checked",true);
	  $(".fromfile").hide();
	}

  setTimeout(function(){$('#productSprint').chosen();},2000);

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

  $( '#price, #cashback, #denom, #adminFee' ).mask('000.000.000', {reverse: true});

  $('.chk-method').change(function() {
		var tab = $(this).val();

		$('.content-chk').hide();
		$('#'+tab).show();

		if(tab == "manual"){
			$('#form-default').attr('action', "/adminpanel/prodforpartner/create");
			$('.manual, .s-product-sprint').show();
		}else{
			$('#form-default').attr('action', "{!! route('productforpartnerUpload') !!}");
			$('.manual, .s-product-sprint').hide();
		}

  });

  $('.btn-secondary').click(function() {
		setTimeout(function () {
		  //window.location = "{{ route('prodforpartner.index') }}";
		  window.history.back();
		},50);
  });
  $('.btn-submit').click(function() {

	var url = $('#form-default').attr('posturl');
    var method = $('#form-default').attr('postmethod');

      if ($('#partnerProductName').val() === "") {
          $('#partnerProductName').focus();
          swal({
              title: "Product Name error!",
              text: "This field is required : Product Name",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#partnerProductName').val().length < 3) {
          $('#partnerProductName').focus();
          swal({
              title: "Product Name error!",
              text: "Product Name must be minimal 3 characters",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#partnerProductCode').val() === "") {
          $('#partnerProductCode').focus();
          swal({
              title: "Product Code error!",
              text: "Please Fill Product Code",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#price').val() === "") {
          $('#price').focus();
          swal({
              title: "Partner Price error!",
              text: "Please Fill Partner Price",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#denom').val() === "") {
          $('#denom').focus();
          swal({
              title: "Denom error!",
              text: "Please Fill Denom",
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
		$( '#price, #cashback, #denom, #adminFee' ).unmask();

		$.ajax({
			type: "POST",
			url: url,
			headers: {
			  'X-CSRF-TOKEN': "{{ csrf_token() }}"
			},
			data: {
			  partnerId : getCookie("partnerId"),
			  productSprint : $('#productSprint option:selected').val(),
			  partnerProductName : $('#partnerProductName').val(),
			  partnerProductCode : $('#partnerProductCode').val(),
			  price : $('#price').val(),
			  denom : $('#denom').val(),
			  cashback : $('#cashback').val(),
			  adminFee : $('#adminFee').val(),
			  status : $('#status').val()

			},
			success: function(test) {
			  swal({
				title: "Done!",
				text: "Data has been "+method+" successfully!",
				type: "success",
				   },function() {
					setTimeout(function () {
					  //window.location = "{{ route('product.index') }}";
					  window.history.back();
					},50);
			  });

			}
		  });
  });
</script>
