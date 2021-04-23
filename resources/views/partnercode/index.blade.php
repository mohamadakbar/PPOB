@extends('layouts.sandeza')
@section('content')
	<style>
		.chosen-container.chosen-container-multi{
			border: 1px solid #ced4da;
			cursor: pointer;
		}
		.padding-td-table{
			padding-right:20px;
			padding-bottom:20px;
		}
		.padding-thead-table{
			padding-bottom:30px;
		}
		.sweet-alert h2 {
			font-size:20px;
			margin:20px 0;
			line-height: 20px;
		}
		.invalid-feedback{
			padding-top:0px !important;
			position:absolute;
		}
	</style>
	<div class="col-md-6 row" style="cursor:pointer">
		<label class="control-label">Partner Response Code</label>
	</div>
    <div class="panel panel-default">	  
		<div class="row col-md-9 p-0 m-b-10">
			<div class="col-sm-12 m-t-30 row">
				<label for="name" class="col-md-1 control-label panel-status">Partner</label>
				<div class="col-md-3 m-b-30">
				  <select class="form-control comCor fz13" name="partner" id="partner">
					<option value="" selected>Choose Partner</option>
					@foreach($partners as $partner)
						<option value="{{ $partner->name }}">{{$partner->name}}</option>
					@endforeach
				  </select>
				</div>
				<div class="col-md-12"></div>
				<label for="sprint-status" class="col-md-1 control-label panel-status">Status</label>
				<div class="col-md-3 m-b-30">
					<select class="form-control fz13" name="sprintstatus" id="filter-sprint-status" multiple>
						<option value="" disabled>Choose Status</option>
						@foreach($sprintCodes as $sprintCode){
							<option value="{{$sprintCode->status}}">{{$sprintCode->status}}</option>
						@endforeach
					</select>
					<button class="btn btn-primary btn-sm mt-3" style="float:right" id="btn-filter">Filter</button>
				</div>
				<div class="col-md-12">
				</div>
				<div class="row col-md-12 form-group">
					<div class="row col-md-1 m-l-5">
						<a id="btnNew" class="btn btn-info fz13 btn-sm" href="#add-modal" data-toggle="modal">New</a>
					</div>
					<div class="row col-md-1 m-l-5">
						<a id="btnDelete" class="btn btn-info fz13 btn-sm" href="#edit-modal" data-toggle="modal">Edit</a>
					</div>
					<div class="row col-md-12 m-l-5 m-t-10 m-b-10">
						<table class="table table-striped table-sm table-bordered table-hover" id="dataTable" style="width:100%">
						  <thead>
							<tr class="bold">
								<th>Response Code</th>
								<th>Partner</th>
								<th>Marked as</th>
								<th>Description</th>
							</tr>
						  </thead>
						  <tbody></tbody>
						  <tfoot>
							  <tr class="bold">
								<th>Response Code</th>
								<th>Partner</th>
								<th>Marked as</th>
								<th>Description</th>
							  </tr>
						  </tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	  </div>
<!-- Start: Modal Add Form Code -->
<div id="add-modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" style="background:#d4dcfb">
            <h5 class="modal-title">Add New Response Code</h5>
        </div>
        <div class="modal-body">
            <table style="width:100%">
                <tr>
					<th class="padding-thead-table">Partner</th>
                    <th class="padding-thead-table">Response Code</th>
                    <th class="padding-thead-table">Mark As</th>
                    <th class="padding-thead-table">Description</th>
                </tr>
                @for($i=0;$i<6;$i++)
                <tr>
					<td class="padding-td-table" width="25%">
						<select name="partner" id="a-partner-{{$i}}" class="form-control comCor fz13 partner-list">
							<option value="" selected>Choose Partner</option>
							@foreach($partners as $partner)
								<option value="{{$partner->name}}">{{$partner->name}}</option>
							@endforeach
						</select>
						<div class="invalid-feedback">
                          This form can't empty
                        </div>
					</td>
                    <td class="padding-td-table" width="25%">
                        <input type="text" name="responsecode[]" class="form-control" id="a-response-code-{{$i}}" placeholder="Response Code">
                        <div class="invalid-feedback">
                          This form can't empty
                        </div>
                    </td>
                    <td class="padding-td-table" width="25%">
						<select name="partner" id="a-status-{{$i}}" class="form-control comCor fz13 sprint-status">
							<option value="" selected>Choose Status</option>
							@foreach($sprintCodes as $sprintCode)
								<option value="{{$sprintCode->status}}">{{$sprintCode->status}}</option>
							@endforeach
						</select>
                        <div class="invalid-feedback">
                          This form can't empty
                        </div>
                    </td>
                    <td class="padding-td-table" width="25%">
                        <input type="text" name="description[]" class="form-control" id="a-description-{{$i}}" placeholder="Description">
                    </td>
                </tr>
                @endfor
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" id="btn-save-code" class="btn btn-primary">Save</button>
            <button type="button" id="cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </div>
  </div>
</div>
<!-- End: Modal Add Form Code -->

<!-- Start: Modal Edit Form Code -->
<div id="edit-modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" style="background:#d4dcfb">
            <h5 class="modal-title">Edit Response Code</h5>
        </div>
        <div class="modal-body">
            <table id="table-form-edit" style="width:100%">
              <thead>
                <tr>
					<th class="padding-thead-table" width="24%">Partner</th>
                    <th class="padding-thead-table" width="24%">Response Code</th>
                    <th class="padding-thead-table" width="24%">Mark As</th>
                    <th class="padding-thead-table" width="24%">Description</th>
                    <th class="padding-thead-table" width="4%"></th>
                </tr>
              </thead>
              <tbody></tbody>
                
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" id="btn-update-code" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </div>
  </div>
</div>
<!-- End: Modal Edit Form Code -->
<script>
  $(document).ready( function () {	  
	const partnerList = <?= $partners ?>;
	const sprintCodeList = <?= $sprintCodes ?>;

	DataTableResponseCode();
	$('.sprint-status').chosen();
	$(".partner-list").chosen();
	$("#filter-sprint-status").chosen({width:'100%'});
	function DataTableResponseCode(dataFilter = ""){
		$('#dataTable').DataTable().destroy();
		console.log(dataFilter);
		$('#dataTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				"url": '{!! route('get.partnercode') !!}',
				"type": "POST",
				headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				data:dataFilter
			},
			"drawCallback": function(response) {
				let resJson = response.json;
				let resData = resJson.data;
				$.each(resData, function (index, element) { 
					generateForm(index, element);
				});
				//do whatever  
			},
			columns: [
				{ data: 'responseCode', name: 'responseCode' },
				{ data: 'partner', name: 'partner' },
				{ data: 'markedas', name: 'markedas' },
				{ data: 'description', name: 'description' }
			],
			columnDefs: []
	  });
	}

	function formValidation(collection){
		var elementNotValid = [];
		var numberEmptyForm = collection.length;
		$.each(collection, function (index, element) {
			$.each(element, function (i, e) { 
				if(e != ""){	
					numberEmptyForm--;
					if(jQuery.inArray("", element) !== -1){
						elementNotValid[index] = element;
					}	
					// Partner
					if(element[0] == ""){
						$("#a-partner-"+index).addClass('is-invalid');
						$("#u-partner-"+index).addClass('is-invalid');
					}
					// Response Code
					if(element[1] == ""){
						$("#a-response-code-"+index).addClass('is-invalid');
						$("#u-response-code-"+index).addClass('is-invalid');
					}
					// Status
					if(element[2] == ""){
						$("#a-status-"+index).addClass('is-invalid');
						$("#u-markas-"+index).addClass('is-invalid');
					}
				}
			});						
		});
		
		// check if all form input is empty
		if(collection.length == numberEmptyForm){
			return false;
		}
		// Check if all data form valid for saving
		if(numberEmptyForm < collection.length && elementNotValid.length == 0){
			return true;
		}

		if(numberEmptyForm < collection.length && elementNotValid.length > 0){
			return elementNotValid;
		}
		
	}
	function generateForm(index, data){
        let htmlForm = `
		  <tr id="`+index+`">
			<td class="padding-td-table">			
				<input type="hidden" name="code_id[]" id="code-id-`+index+`" class="code-ids" value="`+data.id+`" />
				<select name="partner[]" id="u-partner-`+index+`" class="form-control fz13 partner-list">
					<option value="">Choose Partner</option>
				</select>
				<div class="invalid-feedback">
					This form can't empty
				</div>
			</td>
            <td class="padding-td-table">
                <input type="text" name="responsecode[]" value="`+data.responseCode+`" class="form-control responseCode" id="u-response-code-`+index+`" placeholder="Response Code">
                <div class="invalid-feedback">
                  This form can't empty
                </div>
            </td>
            <td class="padding-td-table">
			  <select name="partner" id="u-markas-`+index+`" class="form-control comCor fz13 sprint-status">
					<option value="" selected>Choose Status</option>
		      </select>
              <div class="invalid-feedback">
                This form can't empty
              </div>
            </td>
            <td class="padding-td-table">
                <input type="text" name="description[]" value="`+data.description+`" class="form-control description" id="u-description-`+index+`" placeholder="Description">
            </td>
            <td>
              <a href="#" class="btn-class-delete-response" data-index="`+index+`" data-id="`+data.id+`"><i class="far fa-trash-alt"></i></a>
            </td>
          </tr>
        `;
		$("#table-form-edit tbody").append(htmlForm);
		optionPartner(index, data.partner);
		optionSprintCode(index, data.markedas);
		
		$('.sprint-status').chosen();
		$('.sprint-status').trigger("chosen:updated");
		$(".partner-list").chosen();
		$('.partner-list').trigger("chosen:updated");
	}
	function optionPartner(id, name){
		if(partnerList.length > 0){
			$.each(partnerList, function (i, v) {
				$uPartner = $("#u-partner-"+id); 				
				$uPartner.append(`<option value="`+v.name+`">`+v.name+`</option>`);		
				$uPartner.val(name);
			});
		}else{
			$("#u-partner-"+id).append(`<option>No have data partner.</option>`);	
		}
	}
	function optionSprintCode(id, status){
		if(sprintCodeList.length > 0){
			$.each(sprintCodeList, function (i, v) { 
				$uMarked = $("#u-markas-"+id);
				$uMarked.append(`<option value="`+v.status+`">`+v.status+`</option>`);	
				$uMarked.val(status);
			});
		}else{
			$("#u-markas-"+id).append(`<option>No have data status.</option>`);	
		}
	}
	  
	$("#btn-save-code").click(function (e) { 
		e.preventDefault();
		$('button').prop('disabled', true);
		
		var formData = new FormData();
		var formAddCollection = [];
		$('.partner-list').each(function (index, value) {
			let $partnerList = $(this);
			let $responseCode = $("#a-response-code-"+index);
			let $status = $("#a-status-"+index);
			let $description = $("#a-description-"+index);

			// Clear
			$partnerList.removeClass('is-invalid');
			$responseCode.removeClass('is-invalid');
			$status.removeClass('is-invalid');

			formAddCollection.push([$partnerList.val(), $responseCode.val(), $status.val()]);
			formData.append('partner[]', $partnerList.val());   
			formData.append('responseCode[]', $responseCode.val());        
			formData.append('markedas[]', $status.val());        
			formData.append('description[]', $description.val());
		});
		let collectionValidation = formValidation(formAddCollection);
		if(collectionValidation !== true){
			if(collectionValidation === false){
				swal({
					title: "",
					text: "Form can't empty!"
				});
				$('button').prop('disabled', false);
			}			
		}else{
			$.ajax({
				type: "POST",
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				url: "{!! route('partnercode.link') !!}",
				data: formData,
				processData: false,
				contentType: false,
				success: function (response) {
				if(response.finish == "success"){
					swal({
						title: "",
						text: response.message,
						html:true,
						}, function() {
						window.location = "{{ route('partner-code.index') }}";
					});
				}else if(response.number_of_data == 0){
					$('button').prop('disabled', false);
					swal({
						title: "",
						text: "Form can't empty!"
					});
				}          
			}
		});
		}
  	});
	
	$("#btn-update-code").click(function (e) { 
		e.preventDefault();
		$('button').prop('disabled', true);
		$('input').prop('disabled', true);
		$('select').prop('disabled', true);

		var formData = new FormData();
		var formUpdateCollection = [];
		$('.code-ids').each(function (index, value) {
			let codeId        = $(this).val();
			let $partner 	  = $("#u-partner-"+index);
			let $responseCode = $("#u-response-code-"+index);
			let $status       = $("#u-markas-"+index);
			let $description  = $("#u-description-"+index);

			$partner.removeClass('is-invalid');
			$responseCode.removeClass('is-invalid');
			$status.removeClass('is-invalid');

			formUpdateCollection[index] = [$partner.val(), $responseCode.val(), $status.val()];
			formData.append('id[]', codeId); 
			formData.append('partner[]', $partner.val());        
			formData.append('responseCode[]', $responseCode.val());        
			formData.append('markedas[]', $status.val());        
			formData.append('description[]', $description.val());

		});
		let collectionValidation = formValidation(formUpdateCollection);
		if(collectionValidation !== true){
			$('button').prop('disabled', false);
			$('input').prop('disabled', false);
			$('select').prop('disabled', false);
			if(collectionValidation === false){
				swal({
					title: "",
					text: "Form can't empty!"
				});
				$('button').prop('disabled', false);
			}			
		}else{
			$.ajax({
				type: "POST",
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				url: "{!! url('adminpanel/partner-code/update/1') !!}",
				data: formData,
				processData: false,
				contentType: false,
				success: function (response) {
					if(response.finish == "success"){
					swal({
						title: "",
						text: "Successfully save changes",
					}, function() {
						window.location = "{{ route('partner-code.index') }}";
					});
					}
					if(response.number_of_data === 0){          
					$('button').prop('disabled', false);
					$('input').prop('disabled', false);
					$('select').prop('disabled', false);
					swal({
						title: "",
						text: "Must fill in one of the form lines"
					});
					}     
				}
			});
		}		
  	});

	$("#table-form-edit tbody").on("click", ".btn-class-delete-response", function (e) { 
      e.preventDefault();
      $('button').prop("disabled", true);

	  var id = $(this).attr('data-id');
	  var dataIndex = $(this).attr('data-index');
      var valResponseCode = $('#u-response-code-'+dataIndex).val();
      let contentSwal = `
		<table width="100%" style="text-align:left">
		  <tr>
            <td class="padding-td-table" width="40%">Partner</td>
            <td class="padding-td-table">`+$('#u-partner-'+dataIndex).val()+`</td>
          </tr>
          <tr>
            <td class="padding-td-table" width="40%">Response Code</td>
            <td class="padding-td-table">`+valResponseCode+`</td>
          </tr>
          <tr>
            <td class="padding-td-table" width="40%">Marked As</td>
            <td class="padding-td-table">`+$('#u-markas-'+dataIndex).val()+`</td>
          </tr>
          <tr>
            <td class="padding-td-table" width="40%">Description</td>
            <td class="padding-td-table">`+$('#u-description-'+dataIndex).val()+`</td>
          </tr>
        </table>
      `;
      swal({
        title: "Delete Response Code?",
        text: contentSwal,
        html:true,
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
      },
      function(isConfirm){
        if (isConfirm) {
          $.ajax({
            type: "GET",
            url: "{{ url('adminpanel/deletePartnerCode') }}/"+id,
            success: function (response) {
              if(response.finish == 'success'){
                let htmlResponse = `
                  <p class="mb-3">Response Code <b style="font-weight:bold">`+valResponseCode+`</b></p>
                  <p>Successfully deleted</p>
                `;
                swal({
                  title:'',
                  text:htmlResponse,
                  html:true
                }, function() {
                  window.location = "{{ url('adminpanel/partner-code') }}";
                })
              }
            }
          });
        }else{
          swal.close();
        }
      });
	});


	$("#btn-filter").click(function (e) { 
		e.preventDefault();
		var sprintCodeStatus = $("#filter-sprint-status").val();
		var partner = $("#partner").find(":selected").text();

		$("#table-form-edit tbody tr").remove();
		var data = { partner: partner, sprint_status: sprintCodeStatus };	
		DataTableResponseCode(data);
	});
	$(document).on("change","#partner",function() {
		var partner = $(this).find(":selected").text();
		var sprintCodeStatus = $("#filter-sprint-status").val();
		var data = { partner: partner, sprint_status: sprintCodeStatus };		
		
		$("#table-form-edit tbody tr").remove();
		DataTableResponseCode(data);
	});

  });
</script>
@endsection
