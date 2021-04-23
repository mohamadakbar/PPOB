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
                
                <div class="col-md-12 row " id="Filename" style="margin-bottom: 10px;">   
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
                <div class="form-group" style="margin-top:50px;margin-left: 15px;">
                            <button type="button" id="btnSearchDatas" class="btn btn-primary fz13" data-dismiss="modal" >Submit</button>
                            <button type="button" id="btnExportReport" class="btn btn-secondary fz13" data-dismiss="modal">Export Data to Excel</button>
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
                    <div class="contenTable fz13">
                        <table id="dataTable" class="display" width="100%" cellspacing="0" class="table table-striped table-sm table-bordered table-hover" style="width:100%;font-size:12px">
                            <thead>
                                <tr class="bold">                
                                    <th>Partner</th>
                                    <th>Date</th>
                                    <th>Transaction</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Saldo</th>   
                                    <th>Balance</th>   
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

      getPartners();

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

  $('#btnSearchDatas').click(function() {
        var timeStart = $("#timeStart").val();
        var timeEnd = $("#timeEnd").val();
        var partner = $("#partner").val();
        var data = { timeStart: timeStart, timeEnd: timeEnd, partner: partner };

        $('.s-table').css('display', 'block');
        $("#dataTable").removeClass("display dataTable").addClass("table table-bordered table-striped dataTable no-footer");

        $('#dataTable').DataTable().destroy();
        $('#dataTable').DataTable({

          processing: true,
          serverSide: true,
          ajax: {
              url: '{!! route('get.deposit') !!}',
              type: "POST",
              headers: {
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
              },
              data: data
          },
          columns: [
              { data: 'partnerId', name: 'partnerId' },
              { data: 'date', name: 'date' },
              { data: 'transaction', name: 'transaction' },
              { data: 'debit', name: 'debit' },
              { data: 'credit', name: 'credit' },
              { data: 'saldo', name: 'saldo' },
              { data: 'balance', name: 'balance' }
          ],
          columnDefs: [
            { "targets": [0], "searchable": false, "orderable": false, "visible": true }
          ]
        });
    });
     
</script>
@endsection
