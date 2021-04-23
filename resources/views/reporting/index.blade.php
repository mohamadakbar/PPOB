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
                        <!--form-group-->
                
                <div class="col-md-12 row" style="margin-bottom: 10px;">   
                <!-- <div class="form-group " id="Filename" > -->
                  <div class="col-2">
                  <label >Partner</label>
                  </div>
                  <label style="width:17px">:</label>
                    <div class="col-6 senderCm">
                      <select class="custom-select col-12  fz13 filenm" name="partner" id="partner" placeholder="Choose Partners " style="width:83%;">
                          <option value="">All</option>
                      </select>
                      </div>
                </div>

                <div class="col-md-12 row" style="margin-bottom: 10px;">   
                <!-- <div class="form-group " id="Filename" > -->
                  <div class="col-2">
                  <label >Client</label>
                  </div>
                  <label style="width:17px">:</label>
                    <div class="col-6 senderCm">
                      <select class="custom-select col-12  fz13 filenm" name="client" id="client" placeholder="Choose Client " style="width:83%;">
                          <option value="">All</option>
                      </select>
                      </div>
                </div>

                <div class="col-md-12 row" style="margin-bottom: 10px;">   
                <!-- <div class="form-group " id="Filename" > -->
                  <div class="col-2">
                  <label >Category</label>
                  </div>
                  <label style="width:17px">:</label>
                    <div class="col-6 senderCm">
                      <select class="custom-select col-12  fz13 filenm" name="category" id="category" placeholder="Choose Category " style="width:83%;">
                          <option value="">All</option>
                      </select>
                      </div>
                </div>

                <div class="col-md-12 row" style="margin-bottom: 10px;">   
                <!-- <div class="form-group " id="Filename" > -->
                  <div class="col-2">
                  <label >Product Type</label>
                  </div>
                  <label style="width:17px">:</label>
                    <div class="col-6 senderCm">
                      <select class="custom-select col-12  fz13 filenm" name="type" id="type" placeholder="Choose Product Type " style="width:83%;">
                          <option value="">All</option>
                      </select>
                      </div>
                </div>

                <div class="col-md-12 row" style="margin-bottom: 10px;">   
                <!-- <div class="form-group " id="Filename" > -->
                  <div class="col-2">
                  <label >Product Name</label>
                  </div>
                  <label style="width:17px">:</label>
                    <div class="col-6 senderCm">
                      <input type="text" name="product_name" id="product_name" class="form-control fz13" placeholder="Product Name">
                      </div>
                </div>

                <div class="form-group" style="margin-top:50px;margin-left: 15px;">
                  <button type="button" id="btnSearchDatas" class="btn btn-primary fz13" >Submit</button>
                  <button type="button" id="btnExportReport" class="btn btn-secondary fz13">Export Data to Excel</button>
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
                    <div class="big-label child-content-show-hide fz15 bold">Detail Report </div>
                    <div class="contenTable fz13" style="overflow-x: scroll">
                        <table id="dataTable" class="display" width="100%" cellspacing="0" class="table table-striped table-sm table-bordered table-hover" style="width:100%;font-size:12px">
                            <thead>
                                <tr class="bold">                
                                    <th>Partner Name</th>
                                    <th>Category</th>
                                    <th>Product Type</th>
                                    <th>Product Name</th>
                                    <th>Client Name</th>
                                    <th>Denom</th>   
                                    <th>Prepaid</th>  
                                    <th>Postpaid</th>  
                                    <th>Biaya Admin</th>  
                                    <th>Sprint to Biller</th> 
                                    <th>Cashback</th>  
                                    <th>Margin</th>  
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

      getPartners(); getClients(); getProductCategories(); getProductType();

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

  function getPartners() {
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

  function getClients() {
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

  function getProductCategories() {
    $.ajax({
        crossDomain: true,
        crossOrigin: true,
        cache: false,
        type: "GET",
        url: '{!! route('allprodcat') !!}',
        success: function(data) {

          for (var i = 0; i < data.length; i++) {
              var result = data[i];
              $('#category').append('<option value="' + result.id + '">' + result.name + '</option>');
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
        success: function(data) {

          for (var i = 0; i < data.length; i++) {
              var result = data[i];
              $('#type').append('<option value="' + result.id + '">' + result.name + '</option>');
          }
          $('#type').chosen();

        }
    });
  }

  $('#btnSearchDatas').click(function() {
        var timeStart = $("#timeStart").val();
        var timeEnd = $("#timeEnd").val();
        var partner = $("#partner").val();
        var client = $("#client").val();
        var category = $("#category").val();
        var type = $("#type").val();
        var product_name = $("#product_name").val();
        var data = { timeStart: timeStart, timeEnd: timeEnd, partner: partner, client: client, category: category, type: type, product_name: product_name };

        $('.s-table').css('display', 'block');
        $("#dataTable").removeClass("display dataTable").addClass("table table-bordered table-striped dataTable no-footer");

        $('#dataTable').DataTable().destroy();
        $('#dataTable').DataTable({

          processing: true,
          serverSide: true,
          ajax: {
              url: '{!! route('get.reporting') !!}',
              type: "POST",
              headers: {
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
              },
              data: data
          },
          columns: [
              { data: 'id_partner', name: 'id_partner' },
              { data: 'id_category', name: 'id_category' },
              { data: 'id_type', name: 'id_type' },
              { data: 'product_name', name: 'product_name' },
              { data: 'id_client', name: 'id_client' },
              { data: 'denom', name: 'denom' },
              { data: 'prepaid', name: 'prepaid' },
              { data: 'postpaid', name: 'postpaid' },
              { data: 'biaya_admin', name: 'biaya_admin' },
              { data: 'sprint_to_biller', name: 'sprint_to_biller' },
              { data: 'cashback', name: 'cashback' },
              { data: 'margin', name: 'margin' }
          ]
        });
    });

    $("#btnExportReport").click(function (e) { 
      e.preventDefault();
      let timeStart     = $("#timeStart").val();
      let timeEnd       = $("#timeEnd").val();
      let id_partner    = $("#partner").val();
      let id_client     = $("#client").val();
      let id_category   = $("#category").val();
      let id_type       = $("#type").val();
      let productName   = $("#product_name").val();
      window.open(`{{ route('download.excelreporting') }}?timeStart=`+timeStart+`&timeEnd=`+timeEnd+`&id_partner=`+id_partner+`&id_client=`+id_client+`&id_category=`+id_category+`&id_type=`+id_type+`&product_name=`+productName, "_blank");
    });
     
</script>
@endsection
