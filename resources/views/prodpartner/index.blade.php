@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row col-md-12 p-l-0 form-group">
                <label for="name" class="col-md-1 control-label panel-status">Partner</label>
                <div class="col-md-3">
                    <select class="form-control comCor fz13" name="partner" id="partner">
                        <option value="" selected>All Partner</option>
                    </select>
                </div>
            </div>
            <a id="btnNew" class="btn btn-info fz13 btn-sm" href="{{ route('prodpartner.create') }}">New</a>
            <a id="btnDelete" class="btn btn-info fz13 btn-sm" href="javascript:void(0)">Delete</a>
            <table class="table table-striped table-sm table-bordered table-hover" id="dataTable" style="width:100%">
                <thead>
                <th>
                    <input type="checkbox" name="chkid" data-id="datainputAll" id="datainputAll"
                           class="dataAllUser filled-in chk-col-light-blue">
                </th>
                <th width="15%">Partner Name</th>
                <th>PIC Name</th>
                <th>Email PIC</th>
                <th>No HP PIC</th>
                <th>No Rekening</th>
                <th>Bank Name</th>
                <th>Deposit</th>
                <th>Status</th>
                <!-- <th>Method</th>
                <th>URL</th>
                <th>Body Type</th> -->
                <!-- <th>Params</th>
                <th>Authorization</th>
                <th>Header</th> -->
                <!-- <th>Rank</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Author</th> -->
                <th></th>
                <th width="7%">Action</th>
                </thead>
                <tfoot>
                <tr class="bold">
                    <th></th>
                    <th width="15%">Partner Name</th>
                    <th>PIC Name</th>
                    <th>Email PIC</th>
                    <th>No HP PIC</th>
                    <th>No Rekening</th>
                    <th>Bank Name</th>
                    <th>Deposit</th>
                    <th>Status</th>
                    <!--  <th>Method</th>
                     <th>URL</th>
                     <th>Body Type</th> -->
                    <!-- <th>Params</th>
                    <th>Authorization</th>
                    <th>Header</th> -->
                    <!--  <th>Rank</th>
                     <th>Created At</th>
                     <th>Updated At</th>
                     <th>Author</th> -->
                    <th></th>
                    <th width="7%">Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            getAllPartner();
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! route('get.prodpartner') !!}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                },
                order: [[0, 'desc']],
                columns: [
                    {data: 'chkid', name: 'chkid'},
                    {data: 'partner_name', name: 'partner_name'},
                    {data: 'partner_pic', name: 'partner_pic'},
                    {data: 'partner_email', name: 'partner_email'},
                    {data: 'partner_nohp', name: 'partner_nohp'},
                    {data: 'partner_norek', name: 'partner_norek'},
                    {data: 'partner_bank', name: 'partner_bank'},
                    {data: 'partner_deposit', name: 'partner_deposit'},
                    {
                        data: function (d) {
                            if (d.partner_active == 1) {
                                return "Active";
                            } else {
                                return "Inactive";
                            }

                        }, name: 'partner_active'
                    },
                    // { data: 'method', name: 'method' },
                    // { data: 'url', name: 'url' },
                    // { data: 'body_type', name: 'body_type' },
                    // { data: 'params', name: 'params' },
                    // { data: 'authorization', name: 'authorization' },
                    // { data: 'header', name: 'header' },
                    // { data: 'rank', name: 'rank' },
                    // { data: 'created_at', name: 'created_at' },
                    // { data: 'updated_at', name: 'updated_at' },
                    // { data: 'author', name: 'author' },
                    {
                        data: function (d) {
                            return decodeHTMLEntities(d.productBtn);
                        }, name: 'productBtn'
                    },
                    {data: 'action', name: 'action'}
                ],
                columnDefs: [
                    {"targets": [0, 7], "searchable": false, "orderable": false, "visible": true}
                ]

            });

            $(document).on('click', '.productBtn', function (e) {
                var id = $(this).attr("id");
                window.location = id;
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
                                    window.location = "{{ route('prodpartner.index') }}";
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
                            url: 'deletepartner/' + id,
                            type: "GET",
                            dataType: 'json',
                            success: function (data) {
                                console.log(data);
                            }
                        });
                    }, 500);
                }
            });

            $('#partner').change(function () {
                var data = {partner: $("#partner").val()};
                console.log(data);
                $('#dataTable').DataTable().destroy();
                $('#dataTable').DataTable({

                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{!! route('get.prodpartner') !!}',
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: data
                    },
                    columns: [
                        {data: 'chkid', name: 'chkid'},
                        {data: 'partner_name', name: 'partner_name'},
                        {data: 'partner_pic', name: 'partner_pic'},
                        {data: 'partner_email', name: 'partner_email'},
                        {data: 'partner_nohp', name: 'partner_nohp'},
                        {data: 'partner_norek', name: 'partner_norek'},
                        {data: 'partner_bank', name: 'partner_bank'},
                        {
                            data: function (d) {
                                if (d.partner_active == 1) {
                                    return "Active";
                                } else {
                                    return "Inactive";
                                }

                            }, name: 'partner_active'
                        },
                        {data: 'partner_deposit', name: 'partner_deposit'},
                        // { data: 'method', name: 'method' },
                        // { data: 'url', name: 'url' },
                        // { data: 'body_type', name: 'body_type' },
                        // { data: 'params', name: 'params' },
                        // { data: 'authorization', name: 'authorization' },
                        // { data: 'header', name: 'header' },
                        // { data: 'rank', name: 'rank' },
                        // { data: 'status', name: 'status' },
                        // { data: 'created_at', name: 'created_at' },
                        // { data: 'updated_at', name: 'updated_at' },
                        // { data: 'author', name: 'author' },
                        {
                            data: function (d) {
                                return decodeHTMLEntities(d.productBtn);
                            }, name: 'productBtn'
                        },
                        {data: 'action', name: 'action'}
                    ],
                    columnDefs: [
                        {"targets": [0, 7], "searchable": false, "orderable": false, "visible": true}
                    ]

                });
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
                        $('#partner').append('<option value="' + result.id + '">' + result.partner_name + '</option>');
                    }
                    $('#client').chosen();

                }
            });
        }

        function decodeHTMLEntities(text) {
            return $("<textarea/>")
                .html(text)
                .text();
        }
    </script>
@endsection
