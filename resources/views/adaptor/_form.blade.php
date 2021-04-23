<div class="row col-md-9 p-0 m-b-10">
	<div class="col-sm-6 row">
		<div class="col-md-3 p-l-0">{!! Form::label('partnerId', 'Partner', ['class'=>'col-md-12 control-label text-md-left']) !!} </div>
		<div class="col-md-7 p-l-0">
		  <select class="form-control" id="partnerId" name="partnerId" >
			  <option value="">-- Choose --</option>
			   @foreach ($data['product_partner'] as $id => $name)   
					 <option value="{{$id}}"
					  @if (isset($data['adaptor'])) @if ($id == $data['adaptor']['partnerId'])
						  selected="selected" @endif @endif 
					>{{$name}}</option>
			   @endforeach
		 </select>
		  {!! $errors->first('partnerId', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
</div>

<div class="row col-md-9 m-b-10 p-0">
	<div class="col-md-6 row">
		<div class="col-md-3 p-l-0">{!! Form::label('code', 'Code', ['class'=>'col-md-5 p-r-0 p-t-10 control-label text-md-left']) !!} </div>
		<div class="col-md-7 p-l-0">
		  {!! Form::text('code', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
		  {!! $errors->first('code', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
</div>

<div class="row col-md-9 m-b-10 p-0">
	<div class="col-md-6 row">
		<div class="col-md-3 p-l-0">{!! Form::label('desc', 'Description', ['class'=>'col-md-4 p-r-5 p-t-10 control-label text-md-left']) !!} </div>
		<div class="col-md-8 p-l-0">
		  {!! Form::textarea('desc', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
		  {!! $errors->first('desc', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
</div>

<div class="row col-md-9 m-b-10 p-0">
	<div class="col-md-6 row">
		<div class="col-md-3 p-l-0">{!! Form::label('status', 'Status', ['class'=>'col-md-5 p-r-0 p-t-10 control-label text-md-left']) !!}</div>
		<div class="col-md-7 p-l-0">
		  {!! Form::select('status', array('' => '--- Choose ---', 'active' => 'Active', 'inactive' => 'Inactive'), null, ['class'=>'form-control']); !!}
		  {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
</div>
	
<div class="row col-md-9 m-b-10 m-t-30">
    <div class="">
      {!! Form::button('Save Data', ['class'=>'btn btn-primary btn-submit']) !!}
      {!! Form::reset('Cancel', ['class'=>'btn btn-secondary', 'style'=>'height:38px']) !!}
    </div>
</div>



<script>


  $('.btn-secondary').click(function() {
		setTimeout(function () {        
		  window.location = "{{ route('adaptor.index') }}";
		},50);
  });
  $('.btn-submit').click(function() {
    
	var url = $('#form-default').attr('posturl');
    var method = $('#form-default').attr('postmethod');
	
      if ($('#partnerId').val() === "") {
          $('#partnerId').focus();
          swal({
              title: "Product Partner error!",
              text: "Please Choose Product Partner",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }
      if ($('#code').val() === "") {
          $('#code').focus();
          swal({
              title: "Code error!",
              text: "Please Fill The Code",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }
      if ($('#desc').val() === "") {
          $('#desc').focus();
          swal({
              title: "Desc Empty!",
              text: "Please Fill The Description",
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

		
		$.ajax({
			type: "POST",
			url: url,
			headers: {
			  'X-CSRF-TOKEN': "{{ csrf_token() }}"
			},
			data: { 
			  partnerId: $('#partnerId option:selected').val(), 
			  code : $('#code').val(),
			  desc : $('#desc').val(),
			  status : $('#status').val()
			},
			success: function(test) {
			  swal({
				title: "Done!",
				text: "Data has been "+method+" successfully!",
				type: "success",
				   },function() {   
					setTimeout(function () {        
					  window.location = "{{ route('adaptor.index') }}";
					},50);
			  });

			}
		  });	  
  });
</script>