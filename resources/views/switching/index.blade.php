@extends('layouts.sandeza')
@section('content')
<style>
	.collection-partner-item{
		width: 100% !important;
		display: flex;
		border: 1px solid #cccccc;
		border-radius: 3px;
		padding: 5px 16px;
		justify-content: space-between;
	}
</style>
    <div class="panel panel-default">
		<nav>
		  <div class="nav nav-tabs" id="nav-tab" role="tablist">
			<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Manage Automatic</a>
		  </div>
		</nav>
		<div class="tab-content" id="nav-tabContent">
		  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"> 	  
			<div class="row col-sm-12 p-0 m-b-10">
				<div class="col-sm-12 m-t-30 row">
					<div class="row col-md-12 form-group">
						<label for="name" class="col-md-1 control-label panel-status">Client</label>
						<div class="col-md-3">
						  <select class="form-control comCor fz13" name="client" id="client">
							<option value="" selected>Choose Client</option>
						  </select>
						</div>
						<div class="m-l-20 m-b-15 p-b-20" style="border-bottom:1px solid #eee;width: 92.5%;"></div>
						<div class="row col-md-12 m-l-5 m-t-10 m-b-10">
							<div class="col-md-6 row" style="cursor:pointer">
								<label style="cursor:pointer">
								  <input class="chk-method" style="position: relative;left: 0px;opacity: 1;" name="by" type="radio" query-id="2" value="price">
								  By Price
								</label>
							</div>
							<div id="price" class="c-radio col-md-12 p-r-30" style="display:none;">
								<table class="table table-striped table-sm table-bordered table-hover" id="dataTable" style="width:100%">
								  <thead>
									<th>Product</th>
									<th>Best Price</th>
									<th>Mitracom</th>
									<th>Prismalink</th>
									<th>Bimasakti</th>
									<th>Status</th>
								  </thead>
								  <tfoot>
									  <tr class="bold">
										<th>Product</th>
										<th>Best Price</th>
										<th>Mitracom</th>
										<th>Prismalink</th>
										<th>Bimasakti</th>
										<th>Status</th>
									  </tr>
								  </tfoot>
								</table>
							
								<div class="m-t-10" style="color:#00F;border-bottom: 1px solid #eee;width: 100%;padding-bottom: 20px;">
									*Harga jam 12.00 PM (Next Batch 00.00 AM)
								</div>
							</div>
						</div>
						<div class="row col-md-12 m-l-5 m-t-10 m-b-10">
							<div class="col-sm-6 row" style="cursor:pointer">
								<label style="cursor:pointer">
								  <input class="chk-method" style="position: relative;left: 0px;opacity: 1;" name="by" type="radio" query-id="1" value="service">
								  By Service
								</label>
							</div>
							
							<div id="service" class="c-radio" style="display:none;">
								<div class="col-sm-12 row " style="">
									<div class="col-sm-12 m-b-20 m-t-20"> <strong>Primary</strong>
										<div style="text-align:right;float:right">
										  <select class="form-control fz13" name="last" id="last">
											<option value="2" selected>Last 3 Month</option>
											<option value="1">Last Month</option>
											<option value="3">Last Week</option>
											<option value="4">Last Day</option>
										  </select>
										</div>
									</div>
									@if(isset($dataByService[0]->partnerId))
									<div class="col-sm-6"> <img src="<?php echo url('/'); ?>/images/{{$dataByService[0]->logo_image}}" width="210px"> </div>
									<div class="col-sm-6" style="text-align: right;font-size: 30px;font-weight: bold;"> {{$dataByService[0]->percentage}}%</div>
									<div class="col-sm-12 p-b-20 m-b-30" style="text-align: right;border-bottom: 1px solid #eee;"> {{ number_format($dataByService[0]->trxSuccess)}} Success Transaction for {{ number_format($dataByService[0]->trxCount)}} Transaction</div>
									@endif								
								</div>
								@php
								unset($dataByService[0]);
								@endphp
								@if(isset($dataByService[1]))
									@foreach($dataByService as $service)
										<div class="col-sm-12 row">
											<div class="col-sm-12 m-b-20"> <strong>Backup</strong></div>
											<div class="col-sm-6"> <img src="<?php echo url('/'); ?>/images/{{$service->logo_image}}" width="210px"> </div>
											<div class="col-sm-6" style="text-align: right;font-size: 30px;font-weight: bold;"> {{$service->percentage}}%</div>
											<div class="col-sm-12 p-b-20 m-b-30" style="text-align: right;border-bottom: 1px solid #eee;"> {{number_format($service->trxSuccess)}} Success Transaction for {{ number_format($service->trxCount)}} Transaction</div>
										</div>
									@endforeach
								@endif
								
							</div>
						</div>
						<div class="row col-md-12 m-l-5 m-t-10 m-b-10">
							<div class="col-sm-6 row" style="cursor:pointer">
								<label style="cursor:pointer">
								  <input class="chk-method" style="position: relative;left: 0px;opacity: 1;" name="by" type="radio" query-id="" value="custom">
								  Custom Preference
								</label>
							</div>							
							<div id="custom" class="c-radio col-sm-12 mt-4" style="display:none;">
								<div class="row" style="">
									<div class="col-sm-5 mb-5">
										<h4>Primary Partner</h4>
										<div id="collectionSelectedPartner"></div>
									</div>	
									<div class="col-sm-2">
										<button id="addCollectionPartner" class="btn btn-primary mt-4"><< Add</button>
									</div>		
									<div class="col-sm-5">
										<h4>Partner List</h4>
										<select name="form_i_partner" id="form_i_partner" class="form-control">
											<option value="" disabled>Selected Partner</option>
											@foreach($partners as $partner)
												<option value="{{$partner->id}}">{{$partner->name}}</option>
											@endforeach
										</select>
									</div>				
								</div>								
							</div>
						</div>
						<div class="col-md-12 m-l-5 m-t-10 m-b-10">
							<div class="text-right" style="">
							  <input class="btn btn-sm btn-secondary" style="height:31px" type="reset" value="Cancel">
							  <button class="btn btn-sm btn-primary btn-submit m-r-30" type="button">Save Data</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		  </div>
		</div> 
  </div>
<script>
var urlGetTablePrice = '{!! route('get.switchbyprice') !!}';
var state = {
	partnerId: '',
	partnerName: ''
}
var collectionPartner = [];
var sequencePartner = 0;
// Initialize
dataTablePrice();
$(document).ready( function () {
	
    getAllClient();
	$(".chk-method").first().trigger("click");

	$("#addCollectionPartner").click(function (e) { 
		e.preventDefault();		
		let partnerId = $("#form_i_partner option:selected").val();
		let partnerName = $("#form_i_partner option:selected").text();
		if(partnerId != ""){
			if(collectionPartner.indexOf(partnerId) == -1){
				state.partnerId = partnerId;
				state.partnerName = partnerName;
				collectionPartner.push(state.partnerId);
				appendCollectionPartner();
			}else{
				swal({
					title: "Failed!",
					text: "Partner "+partnerName+" has been added",
					type: "warning"
				}); 
			}			
		}		
	});
	$("#collectionSelectedPartner").on('click', '.removeCollectionPartner',function (e) { 
		e.preventDefault();
		let partnerId = $(this).attr("data-partner-id");
		$("#collection-partner-"+partnerId).remove();
		collectionPartner.splice(collectionPartner.indexOf(partnerId),1);
	});
	function appendCollectionPartner() { 
		let descAdd = "Primary Partner";
		let typePartner = "1";
		let lengthAlternative = 0;
		sequencePartner++;
		if(collectionPartner.length > 1){
			lengthAlternative = collectionPartner.length - 1;
			descAdd = "Alternative "+lengthAlternative;
			typePartner = 2;
		}
		let html = `
			<div class="form-group" id="collection-partner-`+state.partnerId+`">
				<input type="hidden" name="partnerId[`+state.partnerId+`]" id="i_partnerId_`+state.partnerId+`" class="i_partnerId" value="`+state.partnerId+`"/>
				<input type="hidden" name="typePartner[`+state.partnerId+`]" id="i_typePartner_`+state.partnerId+`" class="i_typePartner" value="`+typePartner+`"/>
				<input type="hidden" name="sort[`+state.partnerId+`]" id="i_sort_`+state.partnerId+`" class="i_sort" value="`+sequencePartner+`"/>
				<div class="row">
					<div class="col-sm-7">
						<div class="collection-partner-item">
							`+state.partnerName+`
							<a href="#" class="action removeCollectionPartner" data-partner-id="`+state.partnerId+`">x</a>
						</div>
					</div>
					<div class="col-sm-5">
						<div class="">
							<b>`+descAdd+`</b>
						</div>
					</div>												
				</div>
			</div>
		`;
		$("#collectionSelectedPartner").append(html);
	}
	
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
		{ data: 'productName', name: 'product.productName', width: '35%' },
		{ data: 'bestPrice', name: 'bestPrice' },
		{ data: 'mitracomm', name: 'mitracomm' },
		{ data: 'prismalink', name: 'prismalink' },
		{ data: 'bimasakti', name: 'bimasakti' },
		{ data: function(s){
			if(s.status == 1){ return "Active"; }else{ return "Inactive"; }
		}, name: 'status' },
	],
	columnDefs: [
		{ "targets": [1,2,3], "searchable": false, "orderable": false, "visible": true }
	]

	});
}

  function getAllClient() {
    $.ajax({
        crossDomain: true,
        crossOrigin: true,
        cache: false,
        type: "GET",
        url: '{!! route('allclients') !!}',
        success: function(data) {

          for (var i = 0; i < data.length; i++) {
              var result = data[i];
              $('#client').append('<option value="' + result.id + '">' + result.name + '</option>');
          }
          $('#client').chosen();

        }
    });
  }

  $( ".chk-method" ).change(function() {
  var val = $(this).val();
  
  $(".c-radio").hide();
  $("#"+val).show();
  
  if(val == "price"){
	  $('#dataTable').DataTable();
	  $('#dataTable_info, #dataTable_paginate, #dataTable_length, #dataTable_filter').css({"font-size":"10px","color":"#000"});
  }

});

  $('.btn-submit').click(function() {
	if($('#client option:selected').val() == ""){
		swal({
			title: "Error!",
			text: "Client is required!",
			type: "error",
		});
		return false;
	}
	
	var collection_partner = new Array();

	if($(".chk-method:checked").val() == "price"){
		var valueSchema = "1";		
		var schemaDuration = "no";
	}else if($(".chk-method:checked").val() == "service"){
		var valueSchema = "2";
		var schemaDuration = $('#last option:selected').val();
	}else{
		var valueSchema = "3";		
		var schemaDuration = "no";
		if(collectionPartner.length == 0){
			swal({
				title: "Error!",
				text: "Partner is must added!",
				type: "error",
			});
			return false;
		}		
		$('.i_partnerId').each(function (index, partner) {
			let partnerId = $(this).val();
			let typePartner = $("#i_typePartner_"+partnerId).val();
			let sequence = $("#i_sort_"+partnerId).val();
			collection_partner.push({
				partnerId:partnerId,
				typePartner:typePartner,
				sequence:sequence
			});
		});
	}
	
	
	
    $.ajax({
		type: "POST",
		url: "{!! route('switching.link') !!}",
		headers: {
		  'X-CSRF-TOKEN': "{{ csrf_token() }}"
		},
		data: { 
		  clientId: $('#client option:selected').val(), 
		  clientName: $('#client option:selected').text(), 
		  schema: valueSchema,
		  schemaDuration: schemaDuration,
		  queryId: $('.chk-method:checked').attr("query-id"),
		  collectionpartner: JSON.stringify(collection_partner)
		},
		success: function(response) {
			console.log("response", response);
			if(response.status == "success"){
				swal({
					title: "Done!",
					text: response.message,
					type: "success",
					},function() {   
						setTimeout(function () {        
						window.location = "{{ url('adminpanel/switching') }}";
						},50);
				});
			}else{
				swal({
					title: "Failed !",
					text: response.message,
					type: "warning",
					},function() {   
						setTimeout(function () {        
						window.location = "{{ url('adminpanel/switching') }}";
						},50);
				});
			}
		}
	  });	  
  });
     
</script>
@endsection
