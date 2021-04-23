@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
      <div class="panel-body">
	  	<div class="row col-md-12 p-l-0 form-group">
            <label for="name" class="col-md-1 control-label panel-status">Client</label>
            <div class="col-md-3">
              <select class="form-control comCor fz13" name="client" id="client">
                <option value="" selected>Choose Client</option>
              </select>
            </div>
        </div>
          <a id="btnNew" class="btn btn-info fz13 btn-sm" href="{{ route('client.create') }}">New</a>
          <a id="btnDelete" class="btn btn-info fz13 btn-sm" href="javascript:void(0)">Delete</a>
          <table class="table table-striped table-sm table-bordered table-hover" id="dataTable" style="width:100%">
            <thead>
              <th>
                  <input type="checkbox" name="chkid" data-id="datainputAll" id="datainputAll" class="dataAllUser filled-in chk-col-light-blue">
              </th>
              <th width="15%">Client</th>
              <th>User Id</th>
              <th>Email</th>
              <th>No.Tlpn</th>
              <th>Status</th>
              <th></th>
              <th></th>
            </thead>
            <tfoot>
              <tr class="bold">
                  <th></th>
                  <th width="15%">Client</th>
				  <th>User Id</th>
				  <th>Email</th>
				  <th>No.Tlpn</th>
				  <th>Status</th>
                  <th></th>
                  <th></th>
              </tr>
            </tfoot>
          </table>
      </div>
    </div>
<script>
  $(document).ready( function () {
	  getAllClient();
      $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{!! route('get.client') !!}',
            type: "POST",
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        },
        columns: [
            { data: 'chkid', name: 'chkid' },
            { data: 'name', name: 'name' },
            { data: 'userid', name: 'userid' },
            { data: 'picEmail', name: 'picEmail' },
            { data: 'picPhone', name: 'picPhone' },
            { data: function(s){
				if(s.status == 1){ return "Active"; }else{ return "Inactive"; }
			}, name: 'status' },
            { data: 'action_setprice', name: 'action_setprice' },
            { data: 'action', name: 'action' }
        ],
        columnDefs: [
          { "targets": [0, 4], "searchable": false, "orderable": false, "visible": true }
        ]

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
               deleteCorporate(rowId.id, c);
            }).promise().done( function(){ 
              swal({
              title: "Done!",
              text: "Data has been deleted.",
              type: "success",
                 },function() {   
                  setTimeout(function () {        
                    window.location = "{{ route('client.index') }}";
                  },50);
                });
            });
        });
    } else {
        swal("Warning!", "Data that you want to delete has not been selected!", "warning")
    }

  });
  
  $('#client').change(function() {
		var data = {client: $("#client").val() };
		$('#dataTable').DataTable().destroy();
		$('#dataTable').DataTable({

		  processing: true,
		  serverSide: true,
		  ajax: {
				url: '{!! route('get.client') !!}',
				type: "POST",
				headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				data: data
		  },
		  columns: [
			{ data: 'chkid', name: 'chkid' },
            { data: 'name', name: 'name' },
            { data: 'userid', name: 'userid' },
            { data: 'picEmail', name: 'picEmail' },
            { data: 'picPhone', name: 'picPhone' },
			{ data: function(s){
				if(s.status == 1){ return "Active"; }else{ return "Inactive"; }
			}, name: 'status' },
            { data: 'action_setprice', name: 'action_setprice' },
            { data: 'action', name: 'action' }
		  ],
		  columnDefs: [
			{ "targets": [0, 4], "searchable": false, "orderable": false, "visible": true }
		  ]

		});
	});
  
  
    function deleteCorporate(id) {
      setTimeout(function () {  
        $.ajax({
          url:'deleteclient/'+id,
          type: "GET",
          dataType: 'json',          
          success: function (data) {
            console.log(data);
          }
        });
      }, 500);
    }

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
</script>
@endsection
