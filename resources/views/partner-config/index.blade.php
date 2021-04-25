@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group row col-md-12">
                <label for="name" class="col-md-1 control-label panel-status">Partner</label>
                <div class="col-md-3">
                    <select class="form-control comCor fz13" name="partner" id="partner">
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
                <th>Config Name</th>
                <th>Partner</th>
                <th>Type</th>
                <th>Protocol</th>
                <th>Method</th>
                <th>URL</th>
                <th>Body Type</th>
                <th>Auth</th>
                <th>Content Type</th>
                <th>Timeout</th>
                <th>Resp Type</th>
                <th>Resp Type Header</th>
                <th>Status</th>
                <th>Created At</th>
                <th width="7%">Action</th>
                </thead>
                <tfoot>
                <tr class="bold">
                    <th></th>
                    <th>Config Name</th>
                    <th>Partner</th>
                    <th>Type</th>
                    <th>Protocol</th>
                    <th>Method</th>
                    <th>URL</th>
                    <th>Body Type</th>
                    <th>Auth</th>
                    <th>Content Type</th>
                    <th>Timeout</th>
                    <th>Resp Type</th>
                    <th>Resp Type Header</th>
                    <th>Status</th>
                    <th>Created At</th>
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
                pageLength: 5,
                ajax: {
                    url: '{!! route('get.partnerconf') !!}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                },
                order: [],
                columns: [
                    {data: 'chkid', name: 'chkid'},
                    {data: 'partnerconfig_name', name: 'partnerconfig_name'},
                    {data: 'partnerconfig_partner_name', name: 'partnerconfig_partner_name'},
                    {data: 'partnerconfig_tipe_name', name: 'partnerconfig_tipe_name'},
                    {data: 'partnerconfig_protocol', name: 'partnerconfig_protocol'},
                    {data: 'artnerconfig_method', name: 'artnerconfig_method'},
                    {data: 'partnerconfig_url', name: 'partnerconfig_url'},
                    {data: 'partnerconfig_bodytype', name: 'partnerconfig_bodytype'},
                    {data: 'partnerconfig_auth', name: 'partnerconfig_auth'},
                    {data: 'partnerconfig_conntype', name: 'partnerconfig_conntype'},
                    {data: 'partnerconfig_timeout', name: 'partnerconfig_timeout'},
                    {data: 'partnerconfig_resptype', name: 'partnerconfig_resptype'},
                    {data: 'partnerconfig_resptype_header', name: 'partnerconfig_resptype_header'},
                    {data: 'created_by', name: 'created_by'},
                    {data: 'created_at', name: 'created_at'},
                    {
                        data: function (d) {
                            if (d.partnerconfig_active == 1) {
                                return "Active";
                            } else {
                                return "Inactive";
                            }

                        }, name: 'partnerconfig_active'
                    }
                ],
                columnDefs: [
                    {"targets": [0, 2], "searchable": false, "orderable": false, "visible": true}
                ]

            });

            $('#partner').change(function () {
                var data = {partner: $("#partner").val()};
                console.log(data);
                $('#dataTable').DataTable().destroy();
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{!! route('get.partnerconf') !!}',
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: data,
                    },
                    columns: [
                        {data: 'chkid', name: 'chkid'},
                        {data: 'partnerconfig_name', name: 'partnerconfig_name'},
                        {data: 'partnerconfig_partner_name', name: 'partnerconfig_partner_name'},
                        {data: 'partnerconfig_tipe_name', name: 'partnerconfig_tipe_name'},
                        {data: 'partnerconfig_protocol', name: 'partnerconfig_protocol'},
                        {data: 'artnerconfig_method', name: 'artnerconfig_method'},
                        {data: 'partnerconfig_url', name: 'partnerconfig_url'},
                        {data: 'partnerconfig_bodytype', name: 'partnerconfig_bodytype'},
                        {data: 'partnerconfig_auth', name: 'partnerconfig_auth'},
                        {data: 'partnerconfig_conntype', name: 'partnerconfig_conntype'},
                        {data: 'partnerconfig_timeout', name: 'partnerconfig_timeout'},
                        {data: 'partnerconfig_resptype', name: 'partnerconfig_resptype'},
                        {data: 'partnerconfig_resptype_header', name: 'partnerconfig_resptype_header'},
                        {data: 'created_by', name: 'created_by'},
                        {data: 'created_at', name: 'created_at'},
                        {
                            data: function (d) {
                                if (d.partnerconfig_active == 1) {
                                    return "Active";
                                } else {
                                    return "Inactive";
                                }

                            }, name: 'partnerconfig_active'
                        }
                    ],
                    columnDefs: [
                        {"targets": [0, 2], "searchable": false, "orderable": false, "visible": true}
                    ]

                });
            });

            // $('#btnDelete').on('click', function (e) {
            //     var check = $(".cbUser:checked");
            //     var id = check.attr("id");
            //     var c = check.length;

            //     if (c > 0) {
            //         swal({
            //             title: "Are you sure to delete this data?",
            //             type: "warning",
            //             showCancelButton: true,
            //             confirmButtonColor: "#DD6B55",
            //             confirmButtonText: "Yes, Delete Data!",
            //             closeOnConfirm: false
            //         }, function () {
            //             var arrId = [];
            //             $.each(check, function (index, rowId) {
            //                 deleteCorporate(rowId.id, c);
            //             }).promise().done(function () {
            //                 swal({
            //                     title: "Done!",
            //                     text: "Data has been deleted.",
            //                     type: "success",
            //                 }, function () {
            //                     setTimeout(function () {
            //                         window.location = "{{ route('prodcat.index') }}";
            //                     }, 50);
            //                 });
            //             });
            //         });
            //     } else {
            //         swal("Warning!", "Data that you want to delete has not been selected!", "warning")
            //     }

            //     function deleteCorporate(id) {
            //         setTimeout(function () {
            //             $.ajax({
            //                 url: 'deleteprodcat/' + id,
            //                 type: "GET",
            //                 dataType: 'json',
            //                 success: function (data) {
            //                     console.log(data);
            //                 }
            //             });
            //         }, 500);
            //     }
            // });


            // $(document).on("click", ".dataAllUser", function () {
            //     if (!$(".dataAllUser").is(":checked")) {
            //         console.log('masuk');
            //         $(".cbUser").prop("checked", false);
            //     } else {
            //         console.log('masuk2');
            //         $(".cbUser").prop("checked", true);
            //     }
            // });
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
                    $('#partner').chosen();

                }
            });
        }
    </script>
@endsection
