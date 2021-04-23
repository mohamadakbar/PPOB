@extends('layouts.sandeza')
@section('content')
<div class="panel panel-default">
    <div class="panel-body">
		<div class="row col-md-12 p-l-0 m-b-10">
            <label for="name" class="col-md-1 control-label panel-status">Partner</label>
            <div class="col-md-3">
              <select class="form-control comCor fz13" name="partner" id="partner">
                <option value="" selected>All</option>
              </select>
            </div>
            <label for="name" class="col-md-1 control-label panel-status">Status</label>
            <div class="col-md-3">
              <select class="form-control comCor fz13" name="status" id="status">
                <option value="" selected>All</option>
                <option value="active" >Active</option>
                <option value="inactive" >Inactive</option>
              </select>
            </div>
        </div>

        <a id="btnNew" class="btn btn-info fz13 btn-sm" href="{{ route('adaptor.create') }}">New</a>
        <a id="btnDelete" class="btn btn-info fz13 btn-sm" href="javascript:void(0)">Delete</a>
        <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered table-striped p15 fz13 va-mid p-td-imp">
            <thead>
                <tr class="bold">
                    <th>
                        <input type="checkbox" name="chkid" data-id="datainputAll" id="datainputAll" class="dataAllUser filled-in chk-col-light-blue">
                    </th>
                    <th>Partner</th>
                    <th>Code</th>
                    <th>Desc</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Status</th>
                    <th width="7%">Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr class="bold">
                    <th></th>
                    <th>Partner</th>
                    <th>Code</th>
                    <th>Desc</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Status</th>
                    <th width="7%">Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
  </div>
<script>
  $(document).ready( function () {
	  getAllPartner();
      $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": '{!! route('get.adaptor') !!}',
            "type": "POST",
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        },
        columns: [
            { data: 'chkid', name: 'chkid' },
            { data: 'partner_name', name: 'partner_name' },
			{ data: 'code', name: 'code' },
			{ data: 'desc', name: 'desc' },
			{ data: 'created_at', name: 'created_at' },
			{ data: 'updated_at', name: 'updated_at' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action' }
        ],
        columnDefs: [
          { "targets": [0, 4], "searchable": false, "orderable": false, "visible": true }
        ]

      });
	  
	  $('#partner, #status').change(function() {
            var partner = $("#partner").val();
            var status = $("#status").val();
            var data = { partner: partner, status:status};
            $('#dataTable').DataTable().destroy();
            $('#dataTable').DataTable({

              processing: true,
              serverSide: true,
              ajax: {
                  url: '{!! route('get.adaptor') !!}',
                  type: "POST",
                  headers: {
                  'X-CSRF-TOKEN': "{{ csrf_token() }}"
                  },
                  data: data
              },
              columns: [
					{ data: 'chkid', name: 'chkid' },
					{ data: 'partner_name', name: 'partner_name' },
					{ data: 'code', name: 'code' },
					{ data: 'desc', name: 'desc' },
					{ data: 'created_at', name: 'created_at' },
					{ data: 'updated_at', name: 'updated_at' },
					{ data: 'status', name: 'status' },
					{ data: 'action', name: 'action' }
              ],
              columnDefs: [
                { "targets": [0, 4], "searchable": false, "orderable": false, "visible": true }
              ]

            });
        });

  $('#btnDelete').on('click', function (e) {
    var check = $(".cbUser:checked");
    var id = check.attr("id");
    var c = check.length;

    if (c > 0) {
        swal({
            title: "Are you sure to delete this data?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete Data!",
            closeOnConfirm: false
        }, function () {
           var arrId = [];
            $.each(check, function(index, rowId){
               deleteAdaptor(rowId.id, c);
            }).promise().done( function(){ 
              swal({
              title: "Done!",
              text: "Data has been deleted.",
              type: "success",
                 },function() {   
                  setTimeout(function () {        
                    window.location = "{{ route('adaptor.index') }}";
                  },50);
                });
            });
        });
    } else {
        swal("Warning!", "Data that you want to delete has not been selected!", "warning")
    }

    function deleteAdaptor(id) {
      setTimeout(function () {  
        $.ajax({
          url:'deleteadaptor/'+id,
          type: "GET",
          dataType: 'json',          
          success: function (data) {
            console.log(data);
          }
        });
      }, 500);
    }
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

  
  function getAllPartner() {
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
