<div class="form-group row">
    {!! Form::label('partnerconfig_name', 'Name', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
      {!! Form::hidden('id', null, ['class'=>'form-control']) !!}
      {!! Form::text('partnerconfig_name', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
      {!! $errors->first('partnerconfig_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

{{-- <div class="form-group row">
    {!! Form::label('partnerconfig_partner_id', 'Partner ID', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
        {!! Form::text('partnerconfig_partner_id', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
      {!! $errors->first('partnerconfig_partner_id', '<p class="help-block">:message</p>') !!}
    </div>
</div> --}}

<div class="form-group row">
    {!! Form::label('partnerconfig_partner_id', 'Partner Name', ['class'=>'col-md-2 control-label text-md-left']) !!}
    <div class="col-md-6">
        {!! Form::select('partnerconfig_partner_id', App\ProductPartner::pluck('partner_name')->all(), null, ['class'=>'js-selectize form-control','placeholder' => '--- Choose ---']) !!}
      {!! $errors->first('partnerconfig_partner_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>