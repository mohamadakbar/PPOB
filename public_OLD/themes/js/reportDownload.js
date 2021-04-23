//untuk report download table
$('#reportDownload').DataTable();
$("#tDownload").click(function(){

    console.log("kliklik");
    var tglStart = $("#vstart").val();
    var tglEnd = $("#vend").val();
    var _token = $('#_token').val();

    //$( "#blockingDetail" ).removeClass( "display dataTable" ).addClass( "display dataTable table table-bordered table-striped dataTable no-footer" );
    var table = $('#reportDownload').DataTable( {
        "lengthMenu": [[10,100,150,200, 0], [10,100,150,200, "All"]],
        "destroy": true,
        'searchable':false,
        "processing": false,
        "loadingIndicator": true,
        "sPaginationType": "full_numbers",
        "serverSide": true,
        "paging":true,
        "searching":false,
        "ajax": function ( data, callback, settings ) {
            //console.log(data);
            if(data.order.length > 0){
                var column = data.columns[data.order[0].column].data;
                var dir = data.order[0].dir;
            }else{
                var column = "tanggal";
                var dir = "desc";
            }
            var order = [];
            order.push({
                columnName:column,
                order: dir
            });
            //console.log(order);
            if(parseInt(data.start) == 0){
                var start = (data.start);
            }else{
                var start = (parseInt(data.start/data.length)+1);
            }
            //alert(parseInt(start));
            var data = {
                rowPerPage: parseInt(data.length),
                pageNumber: parseInt(start),
                orderBy: order,
                _token : _token,
                start: tglStart,
                end: tglEnd

            };
            //var url = '{{ url('/')}}';
            $.ajax({
                url:  "search_download",
                cache:false,
                method: "POST",
                data: data,
                success: function (json) {
                    //console.log(json);

                    var json = JSON.parse(json);
                    //alert(json.status);
                    if(json.status == "success"){
                        if(json.data.length > 0){
                            //console.log(json.data.rows);
                            setTimeout( function () {
                                callback( {
                                    draw: json.draw,
                                    data: json.data,
                                    recordsTotal: json.recordsTotal,
                                    recordsFiltered: json.recordsFiltered
                                } );
                            }, 50 );
                        }else{
                            setTimeout( function () {
                                callback( {
                                    draw: 1,
                                    data: json.data,
                                    recordsTotal: 0,
                                    recordsFiltered: 0
                                } );
                            }, 50 );
                            console.log("data kosong");
                        }
                    }else{
                        setTimeout( function () {
                                callback( {
                                    draw: 1,
                                    data: [],
                                    recordsTotal: 0,
                                    recordsFiltered: 0
                                } );
                            },
                            50 );
                        console.log("data failed");
                    }

                },
                error: function(event, xhr) {
                    alert(event.statusText);

                },
                timeout: 0
            });
        },
        "deferRender": true,
        "columns": [
            { "data": "id",render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },"orderable": false },
            { "data": "report_file","orderable": true },
            { "data": "provider" ,"orderable": true},
            { "data": "null","orderable": true,"render": function ( data, type, row ) {
                    var report_file = row.report_file;
                    return '<a href="download/'+report_file+'" class="btn btn-primary btn-sm changeUserPwd">Download File</a>';
                }
            }
        ],
        "order" :[]
    });

});