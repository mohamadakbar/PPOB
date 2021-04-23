@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
        <div class="panel-body" >
            <a id="btnNew" class="btn btn-info fz13 btn-sm" href="{{ route('groupuser.create') }}">New</a>
            <a id="btnDelete" class="btn btn-info fz13 btn-sm" href="javascript:void(0)">Delete</a>
            <table class="table table-striped table-sm table-bordered table-hover" id="dataTable" style="width:100%">
                <thead>
                <th>
                    <input type="checkbox" name="chkid" data-id="datainputAll" id="datainputAll" class="dataAllUser filled-in chk-col-light-blue">
                </th>
                <th width="15%">Name</th>
                <th>Display Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Author</th>
                <th>Action</th>
                </thead>
                <tfoot>
                <tr class="bold">
                    <th></th>
                    <th width="15%">Name</th>
                    <th>Display Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Author</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    </div>
    </div>
    </div>
    <script>
        $(document).ready( function () {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! route('get.groupuser') !!}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                },
                order: [ [0, 'desc'] ],
                columns: [
                    { data: 'chkid', name: 'chkid' },
                    { data: 'name', name: 'name' },
                    { data: 'display_name', name: 'display_name' },
                    { data: 'description', name: 'description' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'author', name: 'author' },
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

            // if (c > 0) {
            // swal({
            // title: "Are you sure to delete this data?",
            // type: "warning",
            // showCancelButton: true,
            // confirmButtonColor: "#DD6B55",
            // confirmButtonText: "Yes, Delete Data!",
            // closeOnConfirm: false
            // }, function () {
            // var arrId = [];
            // $.each(check, function(index, rowId){
            // deleteCorporate(rowId.id, c);
            // }).promise().done( function(){
            // swal({
            // title: "Done!",
            // text: "Data has been deleted.",
            // type: "success",
            // },function() {
            // setTimeout(function () {
            // window.location = "{{ route('groupuser.index') }}";
            // },50);
            // });
            // });
            // });
            // }

            if (c > 0) { /*delve change*/
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
                                window.location = "{{ route('groupuser.index') }}";
                            },50);
                        });
                    });
                });
            }

            else {
                swal("Warning!", "Data that you want to delete has not been selected!", "warning")
            }

            function deleteCorporate(id) {
                setTimeout(function () {
                    $.ajax({
                        url:'deletegroupuser/'+id,
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

        $(document).on("click", ".cbUser", function () {
            var lengthCb=$(".cbUser").length;
            if ( $(".cbUser:checked").length == lengthCb ){
                $(".dataAllUser").prop("checked",true);
            }else{
                $(".dataAllUser").prop("checked",false);
            }
        });

        $(document).on("click", "#btnEdit, #btnNew", function () {
            $(this).html("<i class='fa fa-spin fa-spinner'></i>");
        });

    </script>
@endsection
