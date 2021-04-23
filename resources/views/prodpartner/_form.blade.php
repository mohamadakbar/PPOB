<div class="form-group row">
    {!! Form::label('partner_name', 'Partner Name', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::hidden('id', null, ['class'=>'form-control']) !!}
      {!! Form::text('partner_name', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
      {!! $errors->first('partner_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('partner_pic', 'PIC Name', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::text('partner_pic', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
      {!! $errors->first('partner_pic', '<p class="help-block">:message</p>') !!}
    </div>
</div>

{{--<div class="form-group row">--}}
{{--    {!! Form::label('logo', 'Logo', ['class'=>'col-md-2 control-label text-md-left']) !!}--}}
{{--    <div class="col-md-6">--}}
{{--      {!! Form::file('logo', null, ['autofocus'=>'autofocus']) !!}--}}
{{--      {!! $errors->first('logo', '<p class="help-block">:message</p>') !!}--}}
{{--    </div>--}}
{{--</div>--}}

<div class="form-group row">
    {!! Form::label('partner_nohp', 'No Hp PIC', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::text('partner_nohp', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
      {!! $errors->first('partner_nohp', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('partner_threshold_deposit', 'Thresehold Deposit', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::text('partner_threshold_deposit', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
      {!! $errors->first('partner_threshold_deposit', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('partner_email', 'Email PIC', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::email('partner_email', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
      {!! $errors->first('partner_email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('partner_norek', 'No. Rekening', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::text('partner_norek', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
      {!! $errors->first('partner_norek', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('partner_bank', 'Bank', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
        {!! Form::select('partner_bank', App\Bank::pluck('bank_name')->all(), null, ['class'=>'js-selectize form-control dynamic','placeholder' => '--- Choose ---', 'data-dependent' => 'partner_bank_code']) !!}
        {!! $errors->first('partner_bank', '<p class="help-block">:message</p>') !!}
    </div>
</div>
{{ csrf_field() }}

<div class="form-group row">
    {!! Form::label('partner_bank_code', 'Bank Code', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
        {!! Form::text('partner_bank_code', null, ['class'=>'form-control','autofocus'=>'autofocus', 'id' => 'partner_bank_code', 'disabled']) !!}
        {!! $errors->first('partner_bank_code', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row">
    {!! Form::label('partner_deposit', 'Deposit', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::text('partner_deposit', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
      {!! $errors->first('partner_deposit', '<p class="help-block">:message</p>') !!}
    </div>
</div>

{{--<div class="form-group row">--}}
{{--    {!! Form::label('protocol', 'Protocol', ['class'=>'col-md-2 control-label text-md-left']) !!}--}}
{{--    <div class="col-md-6">--}}
{{--      {!! Form::select('protocol', array('' => '--- Choose ---', 'http' => 'Http', 'https' => 'Https'), null, ['class'=>'form-control']); !!}--}}
{{--      {!! $errors->first('protocol', '<p class="help-block">:message</p>') !!}--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="form-group row">--}}
{{--    {!! Form::label('method', 'Method', ['class'=>'col-md-2 control-label text-md-left']) !!}--}}
{{--    <div class="col-md-6">--}}
{{--      {!! Form::select('method', array('' => '--- Choose ---', 'get' => 'Get', 'post' => 'Post', 'put' => 'Put', 'delete' => 'Delete'), null, ['class'=>'form-control']); !!}--}}
{{--      {!! $errors->first('method', '<p class="help-block">:message</p>') !!}--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="form-group row">--}}
{{--    {!! Form::label('url', 'URL', ['class'=>'col-md-2 control-label text-md-left']) !!}--}}
{{--    <div class="col-md-6">--}}
{{--      {!! Form::text('url', null, ['class'=>'form-control']) !!}--}}
{{--      {!! $errors->first('url', '<p class="help-block">:message</p>') !!}--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="form-group row">--}}
{{--    {!! Form::label('body_type', 'Body Type', ['class'=>'col-md-2 control-label text-md-left']) !!}--}}
{{--    <div class="col-md-6">--}}
{{--      {!! Form::select('body_type', array('' => '--- Choose ---', 'form' => 'Form Data', 'formencode' => 'Form Data URL Encode', 'raw' => 'Raw JSON'), null, ['class'=>'form-control']); !!}--}}
{{--      {!! $errors->first('body_type', '<p class="help-block">:message</p>') !!}--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="form-group row" id="btype-div" style="Display:none;">--}}
{{--    <div class="col-md-2">&nbsp;</div>--}}
{{--    <div class="col-md-6"><button id="btnModal" type="button" class="btn btn-success" data-toggle="modal" data-target="#showModal" style="Display:none;">Edit Body Type</button><button id="btnModal2" type="button" class="btn btn-success" data-toggle="modal" data-target="#showModal2" style="Display:none;">Edit Body Type</button></div>--}}
{{--</div>--}}

{{--<div class="form-group row">--}}
{{--    {!! Form::label('authorization', 'Authorization', ['class'=>'col-md-2 control-label text-md-left']) !!}--}}
{{--    <div class="col-md-6">--}}
{{--      {!! Form::select('authorization', array('' => '--- Choose ---', 'basic' => 'Basic Auth', 'key' => 'API Key', 'token' => 'Token'), null, ['class'=>'form-control']); !!}--}}
{{--      {!! $errors->first('authorization', '<p class="help-block">:message</p>') !!}--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="form-group row" id="atype-div" style="Display:none;">--}}
{{--    <div class="col-md-2">&nbsp;</div>--}}
{{--    <div class="col-md-6"><button id="btnModal3" type="button" class="btn btn-success" data-toggle="modal" data-target="#showModal3" style="Display:none;">Edit Authorization</button><button id="btnModal4" type="button" class="btn btn-success" data-toggle="modal" data-target="#showModal4" style="Display:none;">Edit Authorization</button><button id="btnModal5" type="button" class="btn btn-success" data-toggle="modal" data-target="#showModal5" style="Display:none;">Edit Authorization</button></div>--}}
{{--</div>--}}

{{--<div class="form-group row hide">--}}
{{--    {!! Form::label('header', 'Header', ['class'=>'col-md-2 control-label text-md-left']) !!}--}}
{{--    <div class="col-md-6">--}}
{{--      <input type="checkbox" id="useheader" name="useheader" value="active"> Active--}}
{{--      {!! $errors->first('useheader', '<p class="help-block">:message</p>') !!}--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="form-group row">--}}
{{--    {!! Form::label('contype', 'Connection Type', ['class'=>'col-md-2 control-label text-md-left']) !!}--}}
{{--    <div class="col-md-6">--}}
{{--      {!! Form::select('contype', array('' => '--- Choose ---', 'close' => 'Close', 'alive' => 'Keep Alive'), null, ['class'=>'form-control']); !!}--}}
{{--      {!! $errors->first('contype', '<p class="help-block">:message</p>') !!}--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="form-group row">--}}
{{--    {!! Form::label('timeout', 'Timeout', ['class'=>'col-md-2 control-label text-md-left']) !!}--}}
{{--    <div class="col-md-6">--}}
{{--      {!! Form::text('timeout', '30', ['class'=>'form-control']) !!}--}}
{{--      {!! $errors->first('timeout', '<p class="help-block">:message</p>') !!}--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="form-group row">--}}
{{--    {!! Form::label('resptype', 'Response Type', ['class'=>'col-md-2 control-label text-md-left']) !!}--}}
{{--    <div class="col-md-6">--}}
{{--      {!! Form::select('resptype', array('' => '--- Choose ---', 'text' => 'Text', 'xml' => 'XML', 'json' => 'JSON'), null, ['class'=>'form-control']); !!}--}}
{{--      {!! $errors->first('resptype', '<p class="help-block">:message</p>') !!}--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="form-group row" id="rtype-div" style="Display:none;">--}}
{{--    {!! Form::label('separator', 'Separator', ['class'=>'col-md-2 control-label text-md-left']) !!}--}}
{{--    <div class="col-md-6">--}}
{{--      {!! Form::text('separator', null, ['class'=>'form-control']) !!}--}}
{{--      {!! $errors->first('separator', '<p class="help-block">:message</p>') !!}--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="form-group row">--}}
{{--    {!! Form::label('succcode', 'Success Code', ['class'=>'col-md-2 control-label text-md-left']) !!}--}}
{{--    <div class="col-md-6">--}}
{{--      <button id="btnSucc" type="button" class="btn btn-success" data-toggle="modal" data-target="#showModal6">Add Code</button><button id="btnSuccEdit" type="button" class="btn btn-success" data-toggle="modal" data-target="#showModal6" style="display:none">Edit Code</button>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="form-group row">--}}
{{--    {!! Form::label('errcode', 'Error Code', ['class'=>'col-md-2 control-label text-md-left']) !!}--}}
{{--    <div class="col-md-6">--}}
{{--      <button id="btnErr" type="button" class="btn btn-success" data-toggle="modal" data-target="#showModal7">Add Code</button>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="form-group row">
    {!! Form::label('partner_active', 'Status', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::select('partner_active', array('' => '--- Choose ---', '1' => 'Active', '0' => 'Inactive'), null, ['class'=>'form-control']); !!}
      {!! $errors->first('partner_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-2">
      {!! Form::button('Submit', ['class'=>'btn btn-primary btn-submit']) !!}
    </div>
</div>

@include('prodpartner.bodytype')
@include('prodpartner.auth')
@include('prodpartner.response')

<script src="/js/bodytype.js" type="text/javascript"></script>
<script src="/js/authorization.js" type="text/javascript"></script>
<script src="/js/response.js" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        $('.dynamic').change(function () {

            if($(this).val() != "" )
            {
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token  = $('input[name="_token"]').val();
                console.log(_token);

                $.ajax({
                    url: "{{ route('fetch.bank') }}",
                    method: "POST",
                    data:{select:select, value:value, dependent:dependent, _token:_token},
                    success:function (res) {
                        console.log(res);
                        $('#partner_bank_code').val(res);
                    }
                });
            }
        });
    });
</script>

<script type="text/javascript">

  $('#partner_name').keypress(function (event) {
    var inputValue = event.charCode;
      if(!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123) || (inputValue >= 48 && inputValue <= 57) ||(inputValue==32) || (inputValue==0))){
          event.preventDefault();
      }
  });

  $('#partner_pic').keypress(function (event) {
    var inputValue = event.charCode;
      if(!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123) ||(inputValue==32) || (inputValue==0))){
          event.preventDefault();
      }
  });

  $('#partner_nohp, #partner_norek').keypress(function (event) {
    var inputValue = event.charCode;
      if(!((inputValue >= 48 && inputValue <= 57) || (inputValue==32) || (inputValue==0))){
          event.preventDefault();
      }
  });

  $( '#partner_threshold_deposit, #partner_deposit' ).mask('000,000,000', {reverse: true});

  $('.btn-submit').click(function() {

    var url = $('#form-default').attr('posturl');
    var method = $('#form-default').attr('postmethod');

      if ($('#partner_name').val() === "") {
          $('#partner_name').focus();
          swal({
              title: "Name error!",
              text: "This field is required : Name",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#partner_name').val().length < 3) {
          $('#partner_name').focus();
          swal({
              title: "Name error!",
              text: "Name must be minimal 3 characters",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#partner_pic').val() === "") {
          $('#partner_pic').focus();
          swal({
              title: "PIC Name error!",
              text: "This field is required : PIC Name",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#partner_pic').val().length < 3) {
          $('#partner_pic').focus();
          swal({
              title: "PIC Name error!",
              text: "PIC Name must be minimal 3 characters",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#partner_nohp').val() === "") {
          $('#partner_nohp').focus();
          swal({
              title: "PIC Name error!",
              text: "This field is required : PIC Name",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#partner_nohp').val().length < 10) {
          $('#partner_nohp').focus();
          swal({
              title: "No HP PIC error!",
              text: "No HP PIC must be minimal 10 numbers",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#partner_email').val() === "") {
          $('#partner_email').focus();
          swal({
              title: "PIC Email error!",
              text: "This field is required : PIC Email",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }
      var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i

      if (!pattern.test($('#partner_email').val())) {
          $('#partner_email').focus();
          swal({
              title: "PIC Email error!",
              text: "PIC Email must be a valid email",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#partner_active').val() === "") {
          $('#partner_active').focus();
          swal({
              title: "Status error!",
              text: "Please Choose Status",
              timer: 1500,
              showConfirmButton: false
          });
          return false;
      }

      if ($('#partner_bank').val() === "") {
          $('#partner_bank').focus();
          swal({
              title: "Bank Error!",
              text: "Please Choose Bank",
              timer: 2500,
              showConfirmButton: false
          });
          return false;
      }
      // console.log($('#logo')[0].files[0]);
      var formData = new FormData();
      formData.append("partner_name", $('#partner_name').val());
      formData.append("partner_pic", $('#partner_pic').val());
      formData.append("partner_nohp", $('#partner_nohp').val());
      formData.append("partner_threshold_deposit", $('#partner_threshold_deposit').val());
      formData.append("partner_email", $('#partner_email ').val());
      formData.append("partner_bank", $('#partner_bank').val());
      formData.append("partner_bank_code", $('#partner_bank_code').val());
      formData.append("partner_norek", $('#partner_norek').val());
      formData.append("partner_deposit", $('#partner_deposit').val());
      // formData.append("protocol", $('#protocol').val());
      // formData.append("url", $('#url').val());
      // formData.append("method", $('#method').val());
      // formData.append("body_type", $('#body_type').val());
      // formData.append("authorization", $('#authorization').val());
      // formData.append("contype", $('#contype').val());
      // formData.append("timeout", $('#timeout').val());
      formData.append("partner_active", $('#partner_active').val());
      $.ajax({
        crossDomain: true,
        crossOrigin: true,
        cache: false,
        type: "POST",
        url: url,
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: formData,
        contentType: false,
        processData: false,
        success: function(test) {
          swal({
            title: "Done!",
            text: "Data has been "+method+" successfully!",
            type: "success",
               },function() {
                setTimeout(function () {
                  window.location = "{{ route('prodpartner.index') }}";
                },50);
          });

        }
      });
    });


</script>
