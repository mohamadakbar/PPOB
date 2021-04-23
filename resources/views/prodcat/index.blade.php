@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group row col-md-12">
                <label for="name" class="col-md-1 control-label panel-status">Category</label>
                <div class="col-md-3">
                    <select class="form-control comCor fz13" name="changecategory" id="changecategory">
                        <option value="" selected>All</option>
                    </select>
                </div>
                {{-- <label for="name" class="col-md-1 control-label panel-status">Status</label>
                <div class="col-md-2">
                    <select class="form-control comCor fz13" name="changestatus" id="changestatus">
                        <option value="" selected>All</option>
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                    </select>
                </div> --}}
                <br>
                <br>
            </div>
            <a id="btnNew" class="btn btn-info fz13 btn-sm" href="{{ route('prodcat.create') }}">New</a>
            <a id="btnDelete" class="btn btn-info fz13 btn-sm" href="javascript:void(0)">Delete</a>
            <table class="table table-striped table-sm table-bordered table-hover" id="dataTable" style="width:100%">
                <thead>
                <th>
                    <input type="checkbox" name="chkid" data-id="datainputAll" id="datainputAll"
                           class="dataAllUser filled-in chk-col-light-blue">
                </th>
                <th width="15%">Name</th>
                <th>Status</th>
                <th>Author</th>
                <th>Created At</th>
                <th>Updated By</th>
                <th>Updated At</th>
                <th width="7%">Action</th>
                </thead>
                <tfoot>
                <tr class="bold">
                    <th></th>
                    <th width="15%">Name</th>
                    <th>Status</th>
                    <th>Author</th>
                    <th>Created At</th>
                    <th>Updated By</th>
                    <th>Updated At</th>
                    <th width="7%">Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            getProductCategories();

            $('#dataTable').DataTable({

                processing: true,
                serverSide: true,
                pageLength: 50,
                ajax: {
                    url: '{!! route('get.prodcat') !!}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                },
                order: [],
                columns: [
                    {data: 'chkid', name: 'chkid'},
                    {data: 'category_name', name: 'category_name'},
                    {
                        data: function (d) {
                            if (d.category_active == 1) {
                                return "Active";
                            } else {
                                return "Inactive";
                            }

                        }, name: 'category_active'
                    },
                    {data: 'created_by', name: 'created_by'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_by', name: 'updated_by'},
                    {data: 'updated_at', name: 'updated_at'},
                    // { data: 'author', name: 'author' },
                    {data: 'action', name: 'action'}
                ],
                columnDefs: [
                    {"targets": [0, 2], "searchable": false, "orderable": false, "visible": true}
                ]

            });

            $('#changestatus,#changecategory').change(function () {
                var status = $("#changestatus").val();
                var category = $("#changecategory").val();
                var data = {status: status, id: category};
                console.log(data);
                $('#dataTable').DataTable().destroy();
                $('#dataTable').DataTable({

                    processing: true,
                    serverSide: true,
                    pageLength: 50,
                    ajax: {
                        url: '{!! route('get.prodcat') !!}',
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: data
                    },
                    order: [],
                    columns: [
                        {data: 'chkid', name: 'chkid'},
                        {data: 'category_name', name: 'category_name'},
                        {
                            data: function (d) {
                                if (d.category_active == 1) {
                                    return "Active";
                                } else {
                                    return "Inactive";
                                }
                            }, name: 'category_active'
                        },
                        {data: 'created_by', name: 'created_by'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'updated_by', name: 'updated_by'},
                        {data: 'updated_at', name: 'updated_at'},
                        // { data: 'author', name: 'author' },
                        {data: 'action', name: 'action'}
                    ],
                    columnDefs: [
                        {"targets": [0, 2], "searchable": false, "orderable": false, "visible": true}
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
                        $.each(check, function (index, rowId) {
                            deleteCorporate(rowId.id, c);
                        }).promise().done(function () {
                            swal({
                                title: "Done!",
                                text: "Data has been deleted.",
                                type: "success",
                            }, function () {
                                setTimeout(function () {
                                    window.location = "{{ route('prodcat.index') }}";
                                }, 50);
                            });
                        });
                    });
                } else {
                    swal("Warning!", "Data that you want to delete has not been selected!", "warning")
                }

                function deleteCorporate(id) {
                    setTimeout(function () {
                        $.ajax({
                            url: 'deleteprodcat/' + id,
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

        function getProductCategories() {
            $.ajax({
                crossDomain: true,
                crossOrigin: true,
                cache: false,
                type: "GET",
                url: '{!! route('allprodcat') !!}',
                success: function (data) {

                    for (var i = 0; i < data.length; i++) {
                        var result = data[i];
                        $('#changecategory').append('<option value="' + result.id + '">' + result.category_name + '</option>');
                    }
                    $('#changecategory').chosen();

                }
            });
        }
    </script>
@endsection
