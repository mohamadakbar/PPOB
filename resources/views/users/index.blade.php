@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
      <div class="panel-body" >
          <a id="btnNew" class="btn btn-info fz13 btn-sm" href="{{ route('manusers.create') }}">New</a>
          <a id="btnDelete" class="btn btn-info fz13 btn-sm" href="javascript:void(0)">Delete</a>
          <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered table-striped p15 fz13 va-mid p-td-imp">
            <thead>
              <th>
                  <input type="checkbox" name="chkid" data-id="datainputAll" id="datainputAll" class="dataAllUser filled-in chk-col-light-blue">
              </th>
              <th width="10%">Username</th>
              <th width="15%">Full Name</th>
              <th>Phone Number</th>
              <th>Client</th>
              <th>Role User</th>
              <th>Change Password</th>
              <th width="7%">Action</th>
            </thead>
            <tfoot>
                <tr class="bold">
                    <th></th>
                    <th width="10%">Username</th>
                    <th width="15%">Full Name</th>
                    <th>Phone Number</th>
                    <th>Client</th>
                    <th>Role User</th>
                    <th>Change Password</th>
                    <th width="7%">Action</th>
                </tr>
            </tfoot>
          </table>
      </div>
  </div>
<script>
  $(document).ready( function () {
      $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{!! route('get.users') !!}',
            type: "POST",
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        },
        order: [ [0, 'desc'] ],
        columns: [
            { data: 'chkid', name: 'chkid' },
            { data: 'username', name: 'username' },
            { data: 'name', name: 'name' },
            { data: 'phonenumber', name: 'phonenumber' },
            { data: 'client_id', name: 'client_id' },
            { data: 'role_id', name: 'role_id' },
            { data: 'change_password', name: 'change_password' },
            { data: 'action', name: 'action' }
        ],
        columnDefs: [
          { "targets": [0, 7], "searchable": false, "orderable": false, "visible": true }
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
            $.each(check, function(index, row){
              arrId.push(row.id);
            });
            deleteCorporate(arrId);
        });
    } else {
        swal("Warning!", "Data that you want to delete has not been selected!", "warning")
    }

    function deleteCorporate(ids) {
      console.log(ids);
      $.ajax({
        processing: true,
        serverSide: true,
        url:'{!! route('delete.users') !!}',
        type: "POST",
        data:{ids: ids},
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function (data) {
          swal({
          title: "Done!",
          text: "Data has been deleted.",
          type: "success",
              },function() {
              setTimeout(function () {
                window.location = "{{ route('manusers.index') }}";
              },50);
          });
        }
      });
    }
});

$(document).on("click", ".dataAllUser", function () {
  if (!$(".dataAllUser").is(":checked")) {
    // console.log('masuk');
    $(".cbUser").prop("checked", false);
  } else {
    // console.log('masuk2');
    $(".cbUser").prop("checked", true);
  }
});
$(document).on("click", ".cbUser", function () {
	var lengthCb=$(".cbUser").length;
	if ( $(".cbUser:checked").length == lengthCb ){
		$(".dataAllUser").prop("checked",true);
	}else{
		$(".dataAllUser").prop("checked",false);
	}
});
$(document).on("click", "#btnEdit, #btnNew, #btnChPassword", function () {
	$(this).html("<i class='fa fa-spin fa-spinner'></i>");
});

</script>
@endsection
