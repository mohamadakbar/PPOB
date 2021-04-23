@extends('layouts.sandeza')
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group row col-md-12 p-l-0">
                <label for="name" class="col-sm-1 control-label panel-status">Partner</label>
                <div class="col-sm-2">
                    <select class="form-control comCor fz13" name="partner" id="partner">
                        <option value="" selected>All</option>
                    </select>
                </div>
                <label for="name" class="col-sm-1 control-label panel-status">Category</label>
                <div class="col-md-2">
                    <select class="form-control comCor fz13" name="category" id="category">
                        <option value="" selected>All</option>
                    </select>
                </div>
                <label for="name" class="col-sm-1 control-label panel-status">Prod Type</label>
                <div class="col-md-2">
                    <select class="form-control comCor fz13" name="product_type" id="product_type">
                        <option value="" selected>All</option>
                    </select>
                </div>
{{--                <label for="name" class="col-md-1 control-label panel-status">Status</label>--}}
{{--                <div class="col-md-2">--}}
{{--                    <select class="form-control comCor fz13" name="changestatus" id="changestatus">--}}
{{--                        <option value="" selected>All</option>--}}
{{--                        <option value="1">Active</option>--}}
{{--                        <option value="2">Inactive</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
                <br>
                <br>
            </div>
            <a id="btnNew" class="btn btn-info fz13 btn-sm" href="{{ route('product.create') }}">New</a>
            <a id="btnDelete" class="btn btn-info fz13 btn-sm" href="javascript:void(0)">Delete</a>
            <table id="dataTable" width="100%" cellspacing="0"
                   class="table table-bordered table-striped p15 fz13 va-mid p-td-imp">
                <thead>
                <tr class="bold">
                    <th>
                        <input type="checkbox" name="chkid" data-id="datainputAll" id="datainputAll"
                               class="dataAllUser filled-in chk-col-light-blue">
                    </th>
                    <th>Product Name</th>
                    <th>Product Category</th>
                    <th>Partner Name</th>
                    <th>Product Type</th>
                    <th>Product Code</th>
                    <th>Denom</th>
                    <th>Bottom Price</th>
                    <th>Admin Fee</th>
                    <th>Cashback</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Status</th>
                    <th width="7%">Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr class="bold">
                    <th></th>
                    <th>Product Name</th>
                    <th>Product Category</th>
                    <th>Partner Name</th>
                    <th>Product Type</th>
                    <th>Product Code</th>
                    <th>Denom</th>
                    <th>Bottom Price</th>
                    <th>Admin Fee</th>
                    <th>Cashback</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Status</th>
                    <th width="7%">Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            getProductType();
            getAllPartners();
            getProductCategories();
            DataTableProduct();
            $('#product_type, #changestatus').change(function () {
                var product_type = $("#product_type").val();
                var changestatus = $("#changestatus").val();
                var data = {product_type_id: product_type, status: changestatus, partner_id:partner, category_id:category};
                $('#dataTable').DataTable().destroy();
                DataTableProduct(data);
            });

            function DataTableProduct(dataFilter = []) {
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    pageLength: 50,
                    ajax: {
                        "url": '{!! route('get.product') !!}',
                        "type": "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: dataFilter
                    },
                    columns: [
                        {data: 'chkid', name: 'chkid'},
                        {data: 'manproduct_name', name: 'manproduct_name'},
                        {data: 'manproduct_category_id', name: 'manproduct_category_id'},
                        {data: 'manproduct_partner_id', name: 'manproduct_partner_id'},
                        {data: 'manproduct_type_id', name: 'manproduct_type_id'},
                        {data: 'manproduct_code', name: 'manproduct_code'},
                        {data: 'manproduct_price_denom', name: 'manproduct_price_denom'},
                        {data: 'manproduct_price_buttom', name: 'manproduct_price_buttom'},
                        {data: 'manproduct_price_admin', name: 'manproduct_price_admin'},
                        {data: 'manproduct_price_cashback', name: 'manproduct_price_cashback'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'updated_at', name: 'updated_at'},
                        {
                            data: function (d) {
                                if (d.manproduct_active == 1) {
                                    return "Active";
                                } else {
                                    return "Inactive";
                                }

                            }, name: 'manproduct_active'
                        },
                        {data: 'action', name: 'action'}

                    ],
                    columnDefs: [
                        {"targets": [0, 9], "searchable": false, "orderable": false, "visible": true}
                    ]

                });
            }

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
                                    window.location = "{{ route('product.index') }}";
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
                            url: 'deleteproduct/' + id,
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
                        $('#category').append('<option value="' + result.id + '">' + result.category_name + '</option>');
                    }
                    $('#category').chosen();

                }
            });
        }

        function getProductType() {
            $.ajax({
                crossDomain: true,
                crossOrigin: true,
                cache: false,
                type: "GET",
                url: '{!! route('allprodtype') !!}',
                success: function (data) {

                    for (var i = 0; i < data.length; i++) {
                        var result = data[i];
                        $('#product_type').append('<option value="' + result.id + '">' + result.producttype_name + '</option>');
                    }
                    $('#product_type').chosen();

                }
            });
        }

        function getAllPartners() {
            $.ajax({
                crossDomain: true,
                crossOrigin: true,
                cache: false,
                type: "GET",
                url: '{!! route('allpartners') !!}',
                success: function (data) {

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
