@extends('layouts.sandeza')
@section('content')

<style>
	.details-control{
		cursor: pointer;
	}
</style>

<div class="panel panel-default">
    <div class="panel-body">
		<div class="row col-md-12 p-l-0 m-b-10">
            <!--label for="name" class="col-md-2 control-label panel-status">Partner</label>
            <div class="col-md-3">
              <select class="form-control comCor fz13" name="partner" id="partner">
                <option value="" selected>All</option>
              </select>
            </div>
            <label for="name" class="col-md-1 control-label panel-status">Category</label>
            <div class="col-md-3">
              <select class="form-control comCor fz13" name="changecategory" id="changecategory">
                <option value="" selected>All</option>
              </select>
            </div-->
        </div>
		<div class="form-group row col-md-12 p-l-0">
			<label for="name" class="col-md-1 control-label panel-status">Category</label>
            <div class="col-md-3">
              <select class="form-control comCor fz13" name="changecategory" id="changecategory">
                <option value="" selected>All</option>
              </select>
            </div>
            <label for="name" class="col-md-2 control-label panel-status">Product Type</label>
            <div class="col-md-3">
              <select class="form-control comCor fz13" name="product_type" id="product_type">
                <option value="" selected>All</option>
              </select>
            </div>
            <label for="name" class="col-md-1 control-label panel-status">Status</label>
            <div class="col-md-2">
              <select class="form-control comCor fz13" name="changestatus" id="changestatus">
                <option value="" selected>All</option>
                <option value="1">Active</option>
                <option value="2">Inactive</option>
              </select>
            </div>
            <br>
            <br>
          </div>

        <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered table-striped p15 fz13 va-mid p-td-imp">
            <thead>
                <tr class="bold">
                    <th>

                    </th>
                    <th>Product Name</th>
                    <th>Partner</th>
                    <th>Category</th>
                    <th>Product Type</th>
                    <th>Denom</th>
                    <th>Base Price</th>
                    <th>Admin Fee</th>
                    <th>CashBack</th>
                    <th>Status</th>
                    <th width="7%">Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr class="bold">
                    <th></th>
                    <th>Product Name</th>
                    <th>Partner</th>
                    <th>Category</th>
                    <th>Product Type</th>
                    <th>Denom</th>
                    <th>Base Price</th>
                    <th>Admin Fee</th>
                    <th>CashBack</th>
                    <th>Status</th>
                    <th width="7%">Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
  </div>
<script>
  $(document).ready( function () {
		getProductType();
		getAllPartners();
		getProductCategories();
		DataTableProduct();
    function DataTableProduct(data_filter = []){
      $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": '{!! route('get.productList') !!}',
            "type": "POST",
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data:data_filter
        },
        columns: [
            { name: 'chkid',
			  data: function($data){
				return "Sprint";
			  }
			},
      { data: function(d){ return "<span data-cat='"+d.manproduct_name+"' data-type='"+d.manproduct_type_id+"' id='"+d.productCode+"'>"+d.manproduct_code+"</span>"; }, class: 'details-control', name: 'productName' },
      { data: 'manproduct_partner_id', name: 'partner_name' },
      { data: 'manproduct_category_id', name: 'categoryId' },
      { data: 'manproduct_type_id', name: 'productTypeId' },
      { data: 'manproduct_price_denom', name: 'denom' },
      { data: 'manproduct_price_bottom', name: 'bottomPrice' },
      { data: 'adminFee', name: 'adminFee' },
      { data: 'manproduct_price_cashback', name: 'cashback' },
      { data: function(d){
				if(d.status == 1){
					return "Active";
				}else{
					return "Inactive";
				}
			}, name: 'status' },
            { data: 'action', name: 'action' }
        ],
        columnDefs: [
          { "targets": [0, 9], "searchable": false, "orderable": false, "visible": true }
        ]
      });
    }

	  $(document).on('click', 'td.details-control', function () {
			var tr = $(this).parents('tr');
			var row = $('#dataTable').DataTable().row( tr );
			var pCode = $(this).find("span").attr("id");
			var dCat = $(this).find("span").attr("data-cat");
			var dType = $(this).find("span").attr("data-type");

			if ( row.child.isShown() ) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');

				$(document).find("tr."+$(this).parent().next().attr("data-id")).hide();
				console.log($(this).parent().next().attr("data-id"));

			}
			else {
				// Open this row (the format() function would return the data to be shown)
				if(row.child() && row.child().length)
				{
					row.child.show();
					$(document).find("tr."+$(this).parent().next().attr("data-id")).show();
					console.log($(this).parent().next().attr("data-id"));
				}
				else {
					var n = Math.floor((Math.random() * 1000000) + 1);
					var data = { "id": pCode };

					$.ajax({
						type: "POST",
						url: '{!! route('get.partnerListByProductCode') !!}',
						headers: {
						  'X-CSRF-TOKEN': "{{ csrf_token() }}"
						  },
						data: data,
						success: function(data) {
							json = data.data;
							row.child('<tr class="new-row" id="'+n+'"></tr>').show();
							var td = '';

							if(json.length > 0){
								for (var i = 0; i < json.length; i++) {
									var status = (json[i].status == 1)?"Active":"Inactive";

									if(i==0){
										$(document).find("#"+n).parent().parent().html('<td></td>\
										<td class="new-row" id="'+n+'">'+json[i].partnerProductName+'</td>\
										<td><a href="getlistprodpartner/'+json[i].partnerId+'">'+json[i].partnerName+'</a></td><td>'+dCat+'</td><td>'+dType+'</td>\
										<td>'+json[i].denom+'</td>\
										<td>'+json[i].price+'</td>\
										<td>'+json[i].adminFee+'</td>\
										<td>'+json[i].cashback+'</td>\
										<td>'+status+'</td>\
										<td width="7%">'+json[i].action+'</td>').addClass(""+n).attr("data-id",n);
									}else{
										td += '<td></td>\
										<td class="new-row" id="'+n+'">'+json[i].partnerProductName+'</td>\
										<td><a href="getlistprodpartner/'+json[i].partnerId+'">'+json[i].partnerName+'</a></td><td>'+dCat+'</td><td>'+dType+'</td>\
										<td>'+json[i].denom+'</td>\
										<td>'+json[i].price+'</td>\
										<td>'+json[i].adminFee+'</td>\
										<td>'+json[i].cashback+'</td>\
										<td>'+status+'</td>\
										<td width="7%">'+json[i].action+'</td>';
									}
								}
							}else{
								td += '<td class="new-row" id="'+n+'" align="left" colspan="12"><b>Product Not Found</b></td>';
								$(document).find("#"+n).parent().parent().html(td).addClass(""+n).attr("data-id",n);
							}

							if(json.length > 1){
								$(document).find("tr."+n).after('<tr class="'+n+'" data-id="'+n+'">'+td+'</tr>');
							}
						}
					});


				}
				tr.addClass('shown');
			}
		});

  $('#changecategory, #product_type, #changestatus').change(function() {
    var category = $("#changecategory").val();
    var productType = $("#product_type").val();
    var changestatus = $("#changestatus").val();
    var data = { categoryId: category, id:productType, status: changestatus };
    $('#dataTable').DataTable().destroy();
    DataTableProduct(data);
  });


      $(document).on("click", ".dataAllUser", function () {
        if (!$(".dataAllUser").is(":checked")) {
          console.log('masuk');
          $(".cbUser").prop("checked", false);
        } else {
          console.log('masuk2');
          $(".cbUser").prop("checked", true);
        }
      });
  });

    function getProductCategories() {
    $.ajax({
        crossDomain: true,
        crossOrigin: true,
        cache: false,
        type: "GET",
        url: '{!! route('allprodcat') !!}',
        success: function(data) {

          for (var i = 0; i < data.length; i++) {
              var result = data[i];
              $('#changecategory').append('<option value="' + result.id + '">' + result.name + '</option>');
          }
          $('#changecategory').chosen();

        }
    });
  }

  function getProductType() {
    $.ajax({
        crossDomain: true,
        crossOrigin: true,
        cache: false,
        type: "GET",
        url: '{!! route('allprodtype') !!}',
        success: function(data) {

          for (var i = 0; i < data.length; i++) {
              var result = data[i];
              $('#product_type').append('<option value="' + result.id + '">' + result.name + '</option>');
          }
          $('#product_type').chosen();

        }
    });
  }

  function getAllPartners() {
    $.ajax({
        crossDomain: true,
        crossOrigin: true,
        cache: false,
        type: "GET",
        url: '{!! route('allpartners') !!}',
        success: function(data) {

          for (var i = 0; i < data.length; i++) {
              var result = data[i];
              $('#partner').append('<option value="' + result.id + '">' + result.name + '</option>');
          }
          $('#partner').chosen();

        }
    });
  }

</script>
@endsection
