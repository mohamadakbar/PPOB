@extends('layouts.sandeza')
@section('content')
<div class="panel panel-default">
    <div class="panel-body">
		<!--div class="row col-md-12 p-l-0 m-b-10">
            <label for="name" class="col-md-2 control-label panel-status">Partner</label>
            <div class="col-md-3">
              <select class="form-control comCor fz13" name="partner" id="partner">
                <option value="" selected>All</option>
              </select>
            </div>
            <label for="name" class="col-md-1 control-label panel-status">Category</label>
            <div class="col-md-3">
              <select class="form-control comCor fz13" name="changecategory" id="changecategory">
                <option value="" selected>All</option>
              </select>
            </div>
        </div
		<div class="form-group row col-md-12 p-l-0">
            <label for="name" class="col-md-2 control-label panel-status">Product Type</label>
            <div class="col-md-3">
              <select class="form-control comCor fz13" name="product_type" id="product_type">
                <option value="" selected>All</option>
              </select>
            </div>
            <label for="name" class="col-md-1 control-label panel-status">Status</label>
            <div class="col-md-2">
              <select class="form-control comCor fz13" name="changestatus" id="changestatus">
                <option value="" selected>All</option>
                <option value="1">Active</option>
                <option value="2">Inactive</option>
              </select>
            </div>
            <br>
            <br>
          </div>-->
        <!--a id="btnNew" class="btn btn-info fz13 btn-sm" href="{{ route('prodforpartner.create') }}">New</a-->
        <a id="btnNew" class="btn btn-info fz13 btn-sm" href="javascript:void(0)">New</a>
        <a id="btnDelete" class="btn btn-info fz13 btn-sm" href="javascript:void(0)">Delete</a>
        <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered table-striped p15 fz13 va-mid p-td-imp">
            <thead>
                <tr class="bold">
                    <th>
                        <input type="checkbox" name="chkid" data-id="datainputAll" id="datainputAll" class="dataAllUser filled-in chk-col-light-blue">
                    </th>
                    <!--th>Partner</th-->
                    <th>Product Name</th>
                    <!--th>Category</th-->
                    <!--th>Product Type</th-->
                    <th>Product Code</th>
                    <th>Partner Price</th>
                    <th>Denom</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Status</th>
                    <th width="7%">Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr class="bold">
                    <th></th>
                    <!--th>Partner</th-->
                    <th>Product Name</th>
                    <!--th>Category</th-->
                    <!--th>Product Type</th-->
                    <th>Product Code</th>
                    <th>Partner Price</th>
                    <th>Denom</th>
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
  $(document).ready( function () {
		getProductType();
		getAllPartners();
		getProductCategories();

      $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": '/adminpanel/getproductforpartner/{!! $id !!}',
            "type": "POST",
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        },
        columns: [
            { data: 'chkid', name: 'chkid' },
            //{ data: 'partner_name', name: 'partner_name' },
            //{ data: 'productName', name: 'productName' },
            //{ data: 'product_category_name', name: 'product_category_name' },
            { data: 'partnerProductName', name: 'partnerProductName' },
            { data: 'partnerProductCode', name: 'partnerProductCode' },
            { data: 'price', name: 'price' },
            { data: 'denom', name: 'denom' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: function(d){
				if(d.status == 1){
					return "Active";
				}else{
					return "Inactive";
				}

			} , name: 'status' },
            { data: 'action', name: 'action' }

        ],
        columnDefs: [
          { "targets": [0, 4], "searchable": false, "orderable": false, "visible": true }
        ]

      });

	  $('#partner, #changecategory, #product_type, #changestatus').change(function() {
            var partner = $("#partner").val();
            var category = $("#changecategory").val();
            var product_type = $("#product_type").val();
            var changestatus = $("#changestatus").val();
            var data = { partner: partner, id_category: category, id:product_type, status: changestatus };
            $('#dataTable').DataTable().destroy();
            $('#dataTable').DataTable({

              processing: true,
              serverSide: true,
              ajax: {
                  url: '{!! route('get.product') !!}',
                  type: "POST",
                  headers: {
                  'X-CSRF-TOKEN': "{{ csrf_token() }}"
                  },
                  data: data
              },
              columns: [
				{ data: 'chkid', name: 'chkid' },
				//{ data: 'partner_name', name: 'partner_name' },
				//{ data: 'productName', name: 'productName' },
				//{ data: 'product_category_name', name: 'product_category_name' },
				{ data: 'partnerProductName', name: 'partnerProductName' },
				{ data: 'partnerProductCode', name: 'partnerProductCode' },
				{ data: 'price', name: 'price' },
				{ data: 'denom', name: 'denom' },
				{ data: 'created_at', name: 'created_at' },
				{ data: 'updated_at', name: 'updated_at' },
				{ data: function(d){
					if(d.status == 1){
						return "Active";
					}else{
						return "Inactive";
					}

				} , name: 'status' },
				{ data: 'action', name: 'action' }
              ],
              columnDefs: [
                { "targets": [0, 4], "searchable": false, "orderable": false, "visible": true }
              ]

            });
        });

  $('#btnNew').on('click', function (e) {
	  setCookie("partnerId","{!! $id !!}",1);
	  window.location.href = "{{ route('prodforpartner.create') }}";
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
            $.each(check, function(index, rowId){
               deleteProductforpartner(rowId.id, c);
            }).promise().done( function(){
              swal({
              title: "Done!",
              text: "Data has been deleted.",
              type: "success",
                 },function() {
                  setTimeout(function () {
                    //window.location = "{{ route('prodforpartner.index') }}";
                    location.reload();
                  },50);
                });
            });
        });
    } else {
        swal("Warning!", "Data that you want to delete has not been selected!", "warning")
    }

    function deleteProductforpartner(id) {
      setTimeout(function () {
        $.ajax({
          url:'../deleteproductforpartner/'+id,
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

    function setCookie(cname,cvalue,exdays) {
	  var d = new Date();
	  d.setTime(d.getTime() + (exdays*24*60*60*1000));
	  var expires = "expires=" + d.toGMTString();
	  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	function getCookie(cname) {
	  var name = cname + "=";
	  var decodedCookie = decodeURIComponent(document.cookie);
	  var ca = decodedCookie.split(';');
	  for(var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
		  c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
		  return c.substring(name.length, c.length);
		}
	  }
	  return "";
	}

	function checkCookie() {
	  var user=getCookie("username");
	  if (user != "") {
		alert("Welcome again " + user);
	  } else {
		 user = prompt("Please enter your name:","");
		 if (user != "" && user != null) {
		   setCookie("username", user, 30);
		 }
	  }
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
              $('#changecategory').append('<option value="' + result.id + '">' + result.name + '</option>');
          }
          $('#changecategory').chosen();

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
              $('#product_type').append('<option value="' + result.id + '">' + result.name + '</option>');
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
        success: function(data) {

          for (var i = 0; i < data.length; i++) {
              var result = data[i];
              $('#partner').append('<option value="' + result.id + '">' + result.name + '</option>');
          }
          $('#partner').chosen();

        }
    });
  }

</script>
@endsection
