@extends('layouts.sandeza')
@section('content')

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="table-responsive">
                <div class="card m-r-20 m-l-15 m-b-20">
                    <div class="card-body">
                        <div class="big-label form-content-show-hide fz15 bold" data-id="form-filter">Form Filter <!-- <span class="sh-toggle-top" data-id="up"> <i class="fa fa-angle-up"></i></span> --></div>
                        <form class="fz13 ">
                            <div class="col-md-12">
                                <div class="form-group " id="Period">
                                    <label style="width:15%">Period </label><label style="width:1%">:</label>
                                    <input type="text" name="timeStart" id="timeStart" class="form-control fz13 curs" style="margin-left: 2%;width: 13%;" placeholder="Select Date" readonly="readonly">
                                    <button type="button" disabled class="btn btn-infos" style="font-size: 15px;margin-left: -4px;margin-top: -2px;"><i class="fa fa-calendar"></i></button>
                                    <label style="margin-left:2%">-</label>
                                    <input type="text" name="timeEnd" id="timeEnd" class="form-control fz13 curs " style="margin-left: 2%;width: 13%;" placeholder="Select Date" readonly="readonly">
                                    <button type="button" disabled  class="btn btn-infos" style="font-size: 15px;margin-left: -4px;margin-top: -2px;"><i class="fa fa-calendar"></i></button>
                                </div>

                            </div>

                            <div class="col-md-12 row" style="margin-bottom: 10px;">
                                <!-- <div class="form-group " id="Filename" > -->
                                <div class="col-2">
                                    <label >Username</label>
                                </div>
                                <label style="width:17px">:</label>
                                <div class="col-6 senderCm">
                                    <input type="text" name="clients" id="clients" class="form-control fz13" placeholder="Username">
                                </div>
                            </div>

                            <div class="form-group" style="margin-top:50px;margin-left: 15px;">
                                <button type="button" id="btnSearchDatas" class="btn btn-primary fz13" >Submit</button>
{{--                                <button type="button" id="btnExportReport" class="btn btn-secondary fz13">Export Data to Excel</button>--}}
                            </div>

                        </form>
                    </div>
                    <!--card-body-->
                </div>
                <!--card-->
            </div>

            <div class="s-table" style="display: none">
                <div class="child-content-show-parent card card m-r-20 m-l-15">
                    <div class="card-body">
                        <div class="big-label child-content-show-hide fz15 bold">Detail Audit Trail </div>
                        <div class="contenTable fz13" style="overflow-x: scroll">
                            <table id="dataTable" class="display" width="100%" cellspacing="0" class="table table-striped table-sm table-bordered table-hover" style="width:100%;font-size:12px">
                                <thead>
                                <tr class="bold">
                                    <th>Username</th>
                                    <th>Menu</th>
                                    <th>Submenu</th>
                                    <th>Action</th>
                                    <th>Desc Before</th>
                                    <th>Desc After</th>
                                    <th>Deleted</th>
                                    <th>Time</th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready( function () {

            var t = $('#dataTable').DataTable( {
                "columnDefs": [ {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                } ],
                "order": [[ 1, 'asc' ]]
            } );

            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

            $( "#timeStart" ).datepicker({
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

        });

        $('#btnSearchDatas').click(function() {
            var timeStart = $("#timeStart").val();
            var timeEnd = $("#timeEnd").val();
            var audit_username = $("#clients").val();

            console.log(audit_username);
            var data = { timeStart: timeStart, timeEnd: timeEnd, audit_username: audit_username };

            $('.s-table').css('display', 'block');
            $("#dataTable").removeClass("display dataTable").addClass("table table-bordered table-striped dataTable no-footer");

            $('#dataTable').DataTable().destroy();
            $('#dataTable').DataTable({

                processing: true,
                fixedColumns: true,
                serverSide: true,
                ajax: {
                    url: '{!! route('get.audit-filter') !!}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: data
                },
                columns: [
                    { data: 'audit_username', name: 'audit_username' },
                    { data: 'audit_menu', name: 'audit_menu' },
                    { data: 'audit_submenu', name: 'audit_submenu' },
                    { data: 'audit_action', name: 'audit_action' },
                    { data: 'audit_desc_before', name: 'audit_desc_before' },
                    { data: 'audit_desc_after', name: 'audit_desc_after' },
                    { data: 'audit_del', name: 'audit_del' },
                    { data: 'audit_time_log', name: 'audit_time_log' },
                ]
            });
        });

        $("#btnExportReport").click(function (e) {
            e.preventDefault();
            let timeStart     = $("#timeStart").val();
            let timeEnd       = $("#timeEnd").val();
            let id    = $("#partner").val();
            let id_client     = $("#client").val();
            let id_category   = $("#category").val();
            let id_type       = $("#type").val();
            let productName   = $("#product_name").val();
            window.open(`{{ route('get.audit-export') }}?timeStart=`+timeStart+`&timeEnd=`+timeEnd+`&id_partner=`+id_partner+`&id_client=`+id_client+`&id_category=`+id_category+`&id_type=`+id_type+`&product_name=`+productName, "_blank");
        });

    </script>
@endsection