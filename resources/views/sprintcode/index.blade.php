@extends('layouts.sandeza')
@section('content')
  <style>
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
		<label class="control-label">Sprint Response Code</label>
	</div>
    <div class="panel panel-default">	  
		<div class="row col-md-9 p-0 m-b-10">
			<div class="col-sm-12 m-t-30 row">
				<div class="row col-md-12 form-group">
					<div class="row col-md-1 m-l-5">
						<a id="btnNew" class="btn btn-info fz13 btn-sm" href="#modal-form-add-code" data-toggle="modal">New</a>
					</div>
					<div class="row col-md-1 m-l-5">
						<a id="btnEdit" class="btn btn-info fz13 btn-sm" href="#modal-form-edit-code" data-toggle="modal">Edit</a>
					</div>
					<div class="row col-md-12 m-l-5 m-t-10 m-b-10">
						<table class="table table-striped table-sm table-bordered table-hover" id="dataTable" style="width:100%">
						  <thead>
							<tr class="bold">
								<th>Response Code</th>
								<th>Status</th>
								<th>Description</th>
							</tr>
						  </thead>
						  <tbody></tbody>
						  <tfoot>
							  <tr class="bold">
								<th>Response Code</th>
								<th>Status</th>
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
<div id="modal-form-add-code" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" style="background:#d4dcfb">
            <h5 class="modal-title">Add New Response Code</h5>
        </div>
        <div class="modal-body">
            <table style="width:100%">
                <tr>
                    <th class="padding-thead-table">Response Code</th>
                    <th class="padding-thead-table">Status</th>
                    <th class="padding-thead-table">Description</th>
                </tr>
                @for($i=0;$i<6;$i++)
                <tr>
                    <td class="padding-td-table">
                        <input type="text" name="responsecode[]" class="form-control addResponseCode" id="a-response-code-{{$i}}" placeholder="Response Code">
                        <div class="invalid-feedback">
                          This form can't empty
                        </div>
                    </td>
                    <td class="padding-td-table">
                        <input type="text" name="status[]" class="form-control" id="a-status-{{$i}}" placeholder="Status">
                        <div class="invalid-feedback">
                          This form can't empty
                        </div>
                    </td>
                    <td class="padding-td-table">
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
<div id="modal-form-edit-code" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" style="background:#d4dcfb">
            <h5 class="modal-title">Edit Response Code</h5>
        </div>
        <div class="modal-body">
            <table id="table-form-edit" style="width:100%">
              <thead>
                <tr>
                    <th class="padding-thead-table">Response Code</th>
                    <th class="padding-thead-table">Status</th>
                    <th class="padding-thead-table">Description</th>
                    <th class="padding-thead-table"></th>
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

      getAllClient();
	  $(".chk-method").first().trigger("click");
      $("#timeStart").datepicker({
        onSelect: function(dateText, inst) {
          $('#timeEnd').datepicker('option', 'minDate', $(this).val());
        },
        minDate: 0
      }).on('change', function(){
          $('.datepicker').hide();
      }).datepicker("setDate", new Date());
      $( "#timeEnd" ).datepicker({
        onSelect: function(dateText, inst) {
          if($( "#timeStart" ).val() == ''){
            $( "#timeEnd" ).val('');
          }
        },
      }).on('change', function(){
          $('.datepicker').hide();
      }).datepicker("setDate", new Date());
	  
	  $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": '{!! route('get.sprintcode') !!}',
            "type": "POST",
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        },
        "drawCallback": function(response) {
          let resJson = response.json;
          let resData = resJson.data;

          $.each(resData, function (index, element) { 
            generateForm(element);
          });
          //do whatever  
        },
        columns: [
            { data: 'responseCode', name: 'responseCode' },
            { data: 'status', name: 'status' },
            { data: 'description', name: 'description' }
        ],
        columnDefs: [
          
        ]

      });

      function generateForm(data){
        let htmlForm = `
          <tr id="`+data.id+`">
            <td class="padding-td-table">
                <input type="hidden" name="code_id" id="code-id-`+data.id+`" class="code-ids" value="`+data.id+`" />
                <input type="text" name="responsecode[]" value="`+data.responseCode+`" class="form-control responseCode" id="u-response-code-`+data.id+`" placeholder="Response Code">
                <div class="invalid-feedback">
                  This form can't empty
                </div>
            </td>
            <td class="padding-td-table">
              <input type="text" name="status[]" value="`+data.status+`" class="form-control status" id="u-status-`+data.id+`" placeholder="Status">
              <div class="invalid-feedback">
                This form can't empty
              </div>
            </td>
            <td class="padding-td-table">
                <input type="text" name="description[]" value="`+data.description+`" class="form-control description" id="u-description-`+data.id+`" placeholder="Description">
            </td>
            <td>
              <a href="#" class="btn-class-delete-response" data-id="`+data.id+`"><i class="far fa-trash-alt"></i></a>
            </td>
          </tr>
        `;
        $("#table-form-edit tbody").append(htmlForm);
      }

    $("#table-form-edit tbody").on("click", ".btn-class-delete-response", function (e) { 
      e.preventDefault();
      $('button').prop("disabled", true);

      var id = $(this).attr('data-id');
      var valResponseCode = $('#u-response-code-'+id).val();
      let contentSwal = `
        <table width="100%" style="text-align:left">
          <tr>
            <td class="padding-td-table" width="40%">Response Code</td>
            <td class="padding-td-table">`+valResponseCode+`</td>
          </tr>
          <tr>
            <td class="padding-td-table" width="40%">Status</td>
            <td class="padding-td-table">`+$('#u-status-'+id).val()+`</td>
          </tr>
          <tr>
            <td class="padding-td-table" width="40%">Description</td>
            <td class="padding-td-table">`+$('#u-description-'+id).val()+`</td>
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
            url: "{{ url('adminpanel/deleteSprintCode') }}/"+id,
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
                  window.location = "{{ route('sprint-code.index') }}";
                })
              }
            }
          });
        }else{
          swal.close();
        }
      });
    });
  });

  $("#btn-save-code").click(function (e) { 
    e.preventDefault();
    $('button').prop('disabled', true);
    
    var formData = new FormData();
    $('.addResponseCode').each(function (index, value) {
      let $responseCode = $(this);
      let $status = $("#a-status-"+index);
      let $description = $("#a-description-"+index);

      // Clear
      $responseCode.removeClass('is-invalid');
      $status.removeClass('is-invalid');

      formData.append('responsecode[]', $responseCode.val());        
      formData.append('status[]', $status.val());        
      formData.append('description[]', $description.val());

      if($responseCode.val() != "" && $status.val() == ""){
        $status.addClass('is-invalid');
        $('button').prop('disabled', false);
      }else if($responseCode.val() == "" && $status.val() != ""){
        $responseCode.addClass('is-invalid');
        $('button').prop('disabled', false);
      }
    });
    $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        url: "{!! route('sprintcode.link') !!}",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          if(response.finish == "success"){
            swal({
              title: "",
              text: "New Response Code Successfully Added",
            }, function() {
              window.location = "{{ route('sprint-code.index') }}";
            });
          }else if(response.number_of_data == 0){
            $('button').prop('disabled', false);
            swal({
              title: "",
              text: "Must fill in one of the form lines"
            });
          }          
        }
    });
  });

  $("#btn-update-code").click(function (e) { 
    e.preventDefault();
    $('button').prop('disabled', true);
    $('input').prop('disabled', true);

    var formData = new FormData();
    $('.code-ids').each(function (index, value) {
      let codeId        = $(this).val();
      let $responseCode = $("#u-response-code-"+codeId);
      let $status       = $("#u-status-"+codeId);
      let $description  = $("#u-description-"+codeId);

      $responseCode.removeClass('is-invalid');
      $status.removeClass('is-invalid');

      formData.append('id[]', codeId); 
      formData.append('responsecode[]', $responseCode.val());        
      formData.append('status[]', $status.val());        
      formData.append('description[]', $description.val());

      if($responseCode.val() != "" && $status.val() == ""){
        $status.addClass('is-invalid');
        $('button').prop('disabled', false);
        $('input').prop('disabled', false);
      }else if($responseCode.val() == "" && $status.val() != ""){
        $responseCode.addClass('is-invalid');
        $('button').prop('disabled', false);
        $('input').prop('disabled', false);
      }
    });
    $.ajax({
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
      },
      url: "{!! url('adminpanel/sprint-code/update/1') !!}",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if(response.finish == "success"){
          swal({
            title: "",
            text: "Successfully save changes",
          }, function() {
            window.location = "{{ route('sprint-code.index') }}";
          });
        }
        if(response.number_of_data === 0){          
          $('button').prop('disabled', false);
          $('input').prop('disabled', false);
          swal({
            title: "",
            text: "Must fill in one of the form lines"
          });
        }     
      }
    });
  });


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

  $(document).on('keyup', '#dataTable_filter input', function (e) { 
    $("#table-form-edit tbody tr").remove();
  });

</script>
@endsection
