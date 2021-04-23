@extends('layouts.sandeza')
@section('content')
<style>
    .nav.product-category{
        padding-left:15px !important;
        padding-right:15px !important;
    }
    .nav-pills .nav-link{
        color: #fff !important;
        background-color: #007bff !important;
        margin-right: 5px;
        margin-bottom: 5px;
        transition: 300ms;
    }
    .nav-pills .nav-link.active,
    .nav-pills .nav-link:hover{
        color: #007bff !important;
        background-color: unset !important;
        border: 1px solid #007bff;
    }
    .required-input{
        display: none;
    }
</style>
    <div class="panel panel-default">
        
      <div class="panel-body">	  
            <div class="row col-md-12 p-l-0 form-group">
                <ul class="nav product-category nav-pills">
                    @foreach($productCategories as $category)
                    <li class="nav-item">
                        <a class="nav-link button-product-category" href="#" data-product-category-id="{{ $category->id }}">{{ strtoupper($category->name) }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>	
            <div class="row p-l-0 form-group">
                <label class="col-sm-2 mb-3" for="productType">Product Type</label>
                <div class="col-sm-3 mb-3">
                    <select name="product_type" id="productType" class="form-control comCor fz13">
                        <option value="" selected>All</option>
                        @foreach($productTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>      
                <label class="col-sm-1 mb-3" for="status">Status</label>
                <div class="col-sm-3 mb-3">
                    <select name="status" id="status" class="form-control comCor fz13">
                        <option value="" selected>All</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>            
            </div>
          <table class="table table-striped table-sm table-bordered table-hover" id="dataTable" style="width:100%">
            <thead>
                <tr>
                    <th width="15%">Product Name</th>
                    <th>Product Category</th>
                    <th>Product Type</th>
                    <th>Product Code</th>
                    <th>Bottom Price</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
              <tr class="bold">
                <th width="15%">Product Name</th>
                <th>Product Category</th>
                <th>Product Type</th>
                <th>Product Code</th>
                <th>Bottom Price</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal" id="modal-edit-price" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Price - <span id="title-product-name"></span></h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <input name="price_type" type="radio" class="price-type" id="inputBottomPrice" value="1">                        
                        <label for="inputBottomPrice">Bottom Price</label>
                    </div>
                    <div class="col-sm-6 form-group">
                        <input name="price_type" type="radio" class="price-type" id="inputManualPrice" value="2">                        
                        <label for="inputManualPrice">Manual Price</label>
                    </div>
                </div>
                <div class="row">
                    <label for="inputPrice" class="col-sm-4">Set Price <small class="required-input text-danger">*</small></label>
                    <div class="col-sm-7">
                        <input type="text" id="inputPrice" class="form-control format-price" value="" disabled>
                    </div>                   
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-secondary" id="btnCancel" data-dismiss="modal" value="cancel">
                <input type="button" class="btn btn-primary" id="btnSave" value="Save">
            </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function(){
    var urlGetTablePrice = '{!! route('get.clientprice') !!}?clientID={!! Request::segment(3) !!}';
    var state = {
        categoryID: '',
        productType: '',
        status: '',
        productID:''
    };
    

    var $inputBottomPrice = $("#inputBottomPrice");
    var $inputManualPrice = $("#inputManualPrice");
    var $inputPrice = $("#inputPrice");

    dataTablePrice();
    $(".product-category .nav-link:first").addClass('active');
    $(".button-product-category").click(function(){
        $(".button-product-category").removeClass('active');
        $(this).addClass('active');
        state.categoryID = $(this).attr('data-product-category-id');
        urlGetTablePrice = urlGetTablePrice+'&productCategoryID='+state.categoryID;
        dataTablePrice();
    });

    $('#productType').change(function(){
        state.productType = $(this).val();
        urlGetTablePrice = urlGetTablePrice+'&productType='+state.productType;
        dataTablePrice();
    });

    $('#status').change(function(){
        state.status = $(this).val();
        urlGetTablePrice = urlGetTablePrice+'&status='+state.status;
        dataTablePrice();
    });

    $('#dataTable tbody').on('click', 'tr td .edit-price', function(e){
        e.preventDefault();
        var bottomPrice = $(this).attr('data-bottom-price');
        var manualPrice = $(this).attr('data-manual-price');
        var priceType = $(this).attr('data-price-type');
        var productName = $(this).attr('data-product-name');
        state.productID = $(this).attr('data-product-id');

        $("#modal-edit-price").modal('show');        
        $("#title-product-name").html(productName);

        if(priceType == 1 || priceType == ''){ // 1 menandakan dia bottomPrice
            $inputPrice.prop('disabled', true);
            $inputPrice.val(bottomPrice);
            $inputBottomPrice.prop('checked', true);
            $('.required-input').css('display','none');
        }else{
            $inputPrice.prop('disabled', false);
            $inputPrice.val(manualPrice);
            $inputManualPrice.prop('checked', true);
            $('.required-input').css('display','inline-block');
        }

        $inputBottomPrice.click(function(){
            if($inputBottomPrice.is(":checked") == true){
                $inputPrice.prop('disabled', true);
                $inputPrice.val(bottomPrice);
                $('.required-input').css('display','none');
            }
        });

        $inputManualPrice.click(function(){
            if($inputManualPrice.is(":checked") == true){
                $inputPrice.prop('disabled', false);
                $inputPrice.val(manualPrice);
                $('.required-input').css('display','inline-block');
            }
        });
    });

    var btnSave = document.getElementById("btnSave");

    $("#btnSave").click(function(e){
        e.preventDefault();
        var inputPriceType = $('input[name=price_type]:checked').val();
        
        $(this).prop('value', 'Process...');
        $(this).prop('disabled', true);
        $("#btnCancel").prop("disabled", true);

        if(inputPriceType == 2 && $inputPrice.val() == ''){
            alert('Field Set Price must be filled');
            return;
        }

        var formData = new FormData();
        formData.append('client_id', '{!! Request::segment(3) !!}');
        formData.append('product_id', state.productID);
        formData.append('price_type', inputPriceType);
        formData.append('set_price', $inputPrice.val());
        $.ajax({
            type: "POST",
            url: '{!! route('clientPrice.editPrice') !!}',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend:function(){                
            },
            success: function (response) {
                console.log("response",response);
                if(response.status == 'success'){
                    swal({
                        title: "Success!",
                        text: "Price has been updated.",
                        type: "success"
                    });
                }else{
                    swal({
                        title: "Failed!",
                        text: "Ups. Any wrong in server",
                        type: "warning"
                    });  
                }
                $('#modal-edit-price').modal('hide');
                dataTablePrice();         
                btnSave.value = 'Save';
                btnSave.disabled = false;       
                $("#btnCancel").prop("disabled", false);
            }
        });
    });

    function dataTablePrice(){
        $('#dataTable').DataTable().destroy();
        $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: urlGetTablePrice,
            type: "POST",
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        },
        columns: [
            { data: 'productName', name: 'productName' },
            { data: 'categoryName', name: 'category.name' },
            { data: 'productTypeName', name: 'producttype.name' },
            { data: 'productCode', name: 'productpartner.productCode' },
            { data: 'bottomPrice', name: 'bottomPrice' },
            { data: 'price', name: 'price' },
            { data: function(s){
				if(s.status == 1){ return "Active"; }else{ return "Inactive"; }
			}, name: 'status' },
            { data: 'action', name: 'action' }
        ],
        columnDefs: [
          { "targets": 0, "searchable": false, "orderable": false, "visible": true }
        ]

      });
    }

    // Validation
    $(".format-price").keypress(function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
});
</script>
@endsection
