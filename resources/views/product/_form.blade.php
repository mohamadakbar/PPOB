<style>
    .chosen-container.chosen-container-multi {
        border: 1px solid #ced4da;
        border-radius: 5px;
        height: 100%;
        padding-top: 3%;
        cursor: pointer;
    }

    .padding-td-table {
        padding-right: 20px;
        padding-bottom: 20px;
    }

    .padding-thead-table {
        padding-bottom: 30px;
    }

    .sweet-alert h2 {
        font-size: 20px;
        margin: 20px 0;
        line-height: 20px;
    }

    .invalid-feedback {
        padding-top: 0px !important;
        position: absolute;
    }

</style>
<div class="panel panel-default">
    
    <div class="row col-md-9 p-0 m-b-10">
        <div class="col-sm-12 m-t-30 row">
            <div class="col-md-2">Method*</div>
            <div class="row col-md-5 m-b-30">
                <div class="col-md-4 p-0">
                    <label>
                        {!! Form::radio('method', 'manual', true, ['class'=>'chk-method', 'style'=>'position: relative;left:
                        0px;opacity: 1;']) !!}
                        Manual
                    </label>
                </div>
                <div class="col-md-6 p-0">
                    <label class="fromfile">
                        {!! Form::radio('method', 'fromfile', false, ['class'=>'chk-method fromfile', 'style'=>'position:
                        relative;left: 0px;opacity: 1;']) !!}
                        From File
                    </label>
                </div>
            </div>
            <div class="col-md-12"></div>
            <div class="col-md-12"></div>
            <label for="name" class="col-md-1 control-label panel-status">Partner</label>
            <div class="col-md-3 m-b-30">
                {!! Form::select('manproduct_partner_id', App\ProductPartner::pluck('partner_name','id')->all(), null, ['class'=>'js-selectize form-control','placeholder' => '--- Choose ---', 'id' => 'manproduct_partner_id']) !!}
            </div>
            <label for="sprint-status" class="col-md-2 p-r-0 p-t-10 control-label text-md-left">Prod Method</label>
            <div class="col-md-3 m-b-30">
                <select class="form-control fz13" name="sprintstatus" id="manproduct_method" multiple>
                    @isset($expl)
                        @foreach($expl as $item)
                            $@if ($item == 1)
                                <option value="{{$item}}" selected>Inquiry</option>
                            @elseif($item == 2)
                                <option value="{{$item}}" selected>Payment</option>
                            $@elseif($item == 3)
                                <option value="{{$item}}" selected>Rev</option>
                            @endif
                        @endforeach
                    @endisset
                    <option value="1">Inquiry</option>
                    <option value="2">Payment</option>
                    <option value="3">Reversal</option>
                    {{-- <option value="">Payment</option>
                    <option value="">Reversal</option> --}}
                </select>
                {{-- {!! Form::select('manproduct_active', $expl, null, ['class'=>'form-control fz13', 'id' => 'manproduct_method', 'multiple']); !!} --}}
            </div>
            <div class="col-md-12"></div>
            {!! Form::label('manproduct_category_id', 'Category', ['class'=>'col-md-1 control-label panel-status']) !!}
            <div class="col-md-3 m-b-30">
                {!! Form::select('manproduct_category_id', App\ProductCategory::pluck('category_name', 'id')->all(), null, ['class'=>'js-selectize form-control dynamic','placeholder' => '--- Choose ---', 'id' => 'manproduct_category_id', 'data-dependent' => 'manproduct_type_id']) !!}
                {!! $errors->first('manproduct_category_id', '<p class="help-block">:message</p>') !!}
            </div>
            {!! Form::label('manproduct_type_id', 'Product Type', ['class'=>'col-md-1 p-r-0 p-t-00 control-label
            text-md-left']) !!}
            <div class="col-md-3 m-b-30">
                {!! Form::select('manproduct_type_id', App\ProductType::pluck('producttype_name', 'id')->all(), null, ['class'=>'js-selectize form-control','placeholder' => '--- Choose ---', 'id' => 'manproduct_type_id']) !!}
                {!! $errors->first('manproduct_type_id', '<p class="help-block">:message</p>') !!}
            </div>
            {{ csrf_field() }}

            {!! Form::label('manproduct_active', 'Status', ['class'=>'col-md-1 control-label panel-status']) !!}
            <div class="col-md-2 m-b-30">
                {!! Form::select('manproduct_active', array('' => 'Choose', '1' => 'Active', '2' => 'Inactive'), null,
                ['class'=>'form-control']); !!}
                {!! $errors->first('manproduct_active', '<p class="help-block">:message</p>') !!}
            </div>

        </div>
    </div>
</div>

<div class="content-chk" id="manual">
    <div class="row col-md-9 m-b-10 p-0">
        <div class="col-md-6 row">
            {!! Form::label('manproduct_name', 'Product Name', ['class'=>'col-md-5 p-r-0 p-t-10 control-label
            text-md-left']) !!}
            <div class="col-md-7 p-l-0">
                <input type="text" name="manproduct_name" id="manproduct_name" class="form-control"
                    autofocus="autofocus"
                    value="@if(isset($product->manproduct_name)){{ $product->manproduct_name }} @endif">
                {!! $errors->first('manproduct_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="col-md-6 row p-l-0">
            {!! Form::label('manproduct_code', 'Product Code', ['class'=>'col-md-4 p-r-5 p-t-10 control-label
            text-md-left']) !!}
            <div class="col-md-8 p-l-0">
                {!! Form::text('manproduct_code', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}
                {{--                {!! Form::text('partner_norek', null, ['class'=>'form-control','autofocus'=>'autofocus']) !!}--}}
                {!! $errors->first('manproduct_code', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="row col-md-9 m-b-10 p-0">
        <div class="col-md-6 row">
            {!! Form::label('manproduct_price_cashback', 'Cashback', ['class'=>'col-md-5 p-r-0 p-t-10 control-label
            text-md-left']) !!}
            <div class="col-md-7 p-l-0">
                {!! Form::text('manproduct_price_cashback', null, ['class'=>'form-control','autofocus'=>'autofocus',
                'placeholder'=>'Rp.']) !!}
                {!! $errors->first('manproduct_price_cashback', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="col-md-6 row p-l-0">
            {!! Form::label('manproduct_expired', 'Until', ['class'=>'col-md-4 p-r-5 p-t-10 control-label
            text-md-left']) !!}
            <div class="col-md-8 p-l-0">
                {!! Form::date('manproduct_expired', null, ['class'=>'form-control','autofocus'=>'autofocus',
                'placeholder'=>'Rp.']) !!}
                {!! $errors->first('manproduct_expired', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="row col-md-9 m-b-10 p-0">
        <div class="col-md-6 row">
            {!! Form::label('manproduct_price_buttom', 'Bottom Price', ['class'=>'col-md-5 p-r-0 p-t-10 control-label
            text-md-left']) !!}
            <div class="col-md-7 p-l-0">
                {!! Form::text('manproduct_price_buttom', null, ['class'=>'form-control','autofocus'=>'autofocus',
                'placeholder'=>'Rp.']) !!}
                {!! $errors->first('manproduct_price_buttom', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="col-md-6 row p-l-0">
            {!! Form::label('manproduct_price_denom', 'Denom', ['class'=>'col-md-4 p-r-5 p-t-10 control-label
            text-md-left']) !!}
            <div class="col-md-8 p-l-0">
                {!! Form::text('manproduct_price_denom', null, ['class'=>'form-control','autofocus'=>'autofocus',
                'placeholder'=>'Rp.']) !!}
                {!! $errors->first('manproduct_price_denom', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

</div>

<!--div class="row col-md-9 m-b-10 p-0">
	<div class="col-md-6 row">
		{!! Form::label('manproduct_active', 'Status', ['class'=>'col-md-5 p-r-0 p-t-10 control-label text-md-left']) !!}
    <div class="col-md-7 p-l-0">
{!! Form::select('manproduct_active', array('' => 'Choose', '1' => 'Active', '2' => 'Inactive'), null, ['class'=>'form-control']); !!}
{!! $errors->first('manproduct_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div-->

<div class="content-chk" id="fromfile" style="display:none;">
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
    <form method="post" enctype="multipart/form-data" action="{!! route('productUpload') !!}">
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
    $(document).ready(function () {
        $("#manproduct_method").chosen({
            width: '100%'
        });
        $("#manproduct_method").chosen();
		$('#manproduct_method').trigger("chosen:updated");
        $('.dynamic').change(function () {
            if ($(this).val() != "") {
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ route('dynamicdependent.fetch') }}",
                    method: "POST",
                    data: {
                        select: select,
                        value: value,
                        dependent: dependent,
                        _token: _token
                    },
                    success: function (result) {
                        $('#manproduct_type_id').append(result);
                    }
                });
            }
            $('#manproduct_type_id')
                .find('option')
                .remove()
                .end()
                .append('<option value="">Choose</option>')
                .val('whatever');
        });
    });

</script>

<script>
    $('#manproduct_name, #manproduct_code, #manproduct_partner_id').keypress(function (event) {
        var inputValue = event.charCode;
        if (!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123) || (inputValue >=
                48 && inputValue <= 57) || (inputValue == 32) || (inputValue == 0))) {
            event.preventDefault();
        }
    });

    var method = $('#form-default').attr('postmethod');
    if (method == "Edited") {
        //$("input[value=fromfile").prop("checked",true);
        $(".fromfile").hide();
    }

    // setTimeout(function(){$('#inqType,#categoryId,#productTypeId').chosen();},2000);
    // setTimeout(function(){$('#inqType,#categoryId').chosen();},2000);

    $('#manproduct_price_buttom, #manproduct_price_cashback, #manproduct_price_denom, #adminFee').mask('000.000.000', {
        reverse: true
    });

    $('.chk-method').change(function () {

        var tab = $(this).val();

        $('.content-chk').hide();
        $('#' + tab).show();

        if (tab == "manual") {
            $('#form-default').attr('action', "/adminpanel/product/create");
            $('.manual').show();
        } else {
            $('#form-default').attr('action', "{!! route('productUpload') !!}");
            $('.manual').hide();
        }

    });

    $('.btn-secondary').click(function () {
        setTimeout(function () {
            window.location = "{{ route('product.index') }}";
        }, 50);
    });
    $('.btn-submit').click(function () {

        var url = $('#form-default').attr('posturl');
        var method = $('#form-default').attr('postmethod');

        /*if ($('#name').val() === "") {
            $('#name').focus();
            swal({
                title: "Name error!",
                text: "This field is required : Name",
                timer: 1500,
                showConfirmButton: false
            });
            return false;
        }

        if ($('#name').val().length < 3) {
            $('#name').focus();
            swal({
                title: "Name error!",
                text: "Name must be minimal 3 characters",
                timer: 1500,
                showConfirmButton: false
            });
            return false;
        }

        if ($('#productTypeId').val() === "") {
            $('#productTypeId').focus();
            swal({
                title: "Product Type error!",
                text: "Please Choose Product Type",
                timer: 1500,
                showConfirmButton: false
            });
            return false;
        }

        if ($('#categoryId').val() === "") {
            $('#categoryId').focus();
            swal({
                title: "Product Category error!",
                text: "Please Choose Product Category",
                timer: 1500,
                showConfirmButton: false
            });
            return false;
        }

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

        /*if ($('#product_code').val() === "") {
            $('#product_code').focus();
            swal({
                title: "Product Code error!",
                text: "This field is required : Product Code",
                timer: 1500,
                showConfirmButton: false
            });
            return false;
        }

        if ($('#product_code').val().length < 3) {
            $('#product_code').focus();
            swal({
                title: "Product Code error!",
                text: "Product Code must be minimal 3 characters",
                timer: 1500,
                showConfirmButton: false
            });
            return false;
        }

        if ($('#partner_product_code').val() === "") {
            $('#partner_product_code').focus();
            swal({
                title: "Partner Product Code error!",
                text: "This field is required : Partner Product Code",
                timer: 1500,
                showConfirmButton: false
            });
            return false;
        }

        if ($('#partner_product_code').val().length < 3) {
            $('#partner_product_code').focus();
            swal({
                title: "Partner Product Code error!",
                text: "Partner Product Code must be minimal 3 characters",
                timer: 1500,
                showConfirmButton: false
            });
            return false;
        }

        if ($('#denom').val() === "") {
            $('#denom').focus();
            swal({
                title: "denom error!",
                text: "This field is required :denom",
                timer: 1500,
                showConfirmButton: false
            });
            return false;
        }

        if ($('#product_price').val() === "") {
            $('#product_price').focus();
            swal({
                title: "Product Price error!",
                text: "This field is required :Product Price",
                timer: 1500,
                showConfirmButton: false
            });
            return false;
        }

        if ($('#partner_product_price').val() === "") {
            $('#partner_product_price').focus();
            swal({
                title: "Partner Product Price error!",
                text: "This field is required :Partner Product Price",
                timer: 1500,
                showConfirmButton: false
            });
            return false;
        }

        if ($('#basePrice').val() === "") {
            $('#basePrice').focus();
            swal({
                title: "Discount Type error!",
                text: "This field is required :Harga Dasar",
                timer: 1500,
                showConfirmButton: false
            });
            return false;
        }

        if ($('#retailPrice').val() === "") {
            $('#retailPrice').focus();
            swal({
                title: "Discount Value error!",
                text: "This field is required : Harga Jual",
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
        }*/
        $('#manproduct_price_buttom, #manproduct_price_cashback, #manproduct_price_denom, #adminFee').unmask();
        var arrMethod = $('#manproduct_method').val();
        var implode = arrMethod.join(":;:");
        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: {
                manproduct_code: $('#manproduct_code').val(),
                manproduct_name: $('#manproduct_name').val(),
                manproduct_active: $('#manproduct_active').val(),
                manproduct_method: implode,
                manproduct_type_id: $('#manproduct_type_id').val(),
                manproduct_expired: $('#manproduct_expired').val(),
                manproduct_partner_id: $('#manproduct_partner_id').val(),
                manproduct_category_id: $('#manproduct_category_id').val(),
                manproduct_price_buttom: $('#manproduct_price_buttom').val(),
                manproduct_price_denom: $('#manproduct_price_denom').val(),
                manproduct_price_cashback: $('#manproduct_price_cashback').val()

            },
            success: function (test) {
                swal({
                    title: "Done!",
                    text: "Data has been " + method + " successfully!",
                    type: "success",
                }, function () {
                    setTimeout(function () {
                        window.location = "{{ route('product.index') }}";
                    }, 50);
                });

            }
        });
    });

</script>
