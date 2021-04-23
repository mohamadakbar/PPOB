@extends('layouts.master')
@section('content')

<div class="breadcrumbs ace-save-state" id="breadcrumbs">
  <ul class="breadcrumb">
    <li>
      <i class="ace-icon fa fa-home home-icon"></i>
      <a href="{{ url('/home') }}">Home</a>
    </li>
    <li class="active">Product</li>
  </ul>
</div>
<div class="page-content">
  <div class="page-header">
    <h1>MANAGE PRODUCT</h1>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <!-- PAGE CONTENT BEGINS -->

      <div class="row">
        <div class="col-xs-12">
          <div>
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
              <thead>
                  <tr>
                    <th class="center">
                      <label class="pos-rel">
                        <input type="checkbox" class="ace" />
                        <span class="lbl"></span>
                      </label>
                    </th>
                    <th>Id</th>
                    <th width="10%">Name</th>
                    <th>Product Type</th>
                    <th>Product Category</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Author</th>
                    <th width="7%">Action</th>
                  </tr>
                </thead>

              <tbody>
                <tr>
                  <td class="center">
                    <label class="pos-rel">
                      <input type="checkbox" class="ace" />
                      <span class="lbl"></span>
                    </label>
                  </td>

                  <td>
                    <a href="#">app.com</a>
                  </td>
                  <td>$45</td>
                  <td class="hidden-480">3,330</td>
                  <td>Feb 12</td>

                  <td class="hidden-480">
                    <span class="label label-sm label-warning">Expiring</span>
                  </td>

                  <td>
                    <div class="hidden-sm hidden-xs action-buttons">
                      <a class="blue" href="#">
                        <i class="ace-icon fa fa-search-plus bigger-130"></i>
                      </a>

                      <a class="green" href="#">
                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                      </a>

                      <a class="red" href="#">
                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                      </a>
                    </div>

                    <div class="hidden-md hidden-lg">
                      <div class="inline pos-rel">
                        <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                          <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                          <li>
                            <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
                              <span class="blue">
                                <i class="ace-icon fa fa-search-plus bigger-120"></i>
                              </span>
                            </a>
                          </li>

                          <li>
                            <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                              <span class="green">
                                <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                              </span>
                            </a>
                          </li>

                          <li>
                            <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                              <span class="red">
                                <i class="ace-icon fa fa-trash-o bigger-120"></i>
                              </span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
  </div><!-- /.row -->


<script>
  $(document).ready( function () {
      $('#dynamic-table').DataTable({
        bAutoWidth: false,
        "aoColumns": [
          { "bSortable": false },
          null, null,null, null, null,
          { "bSortable": false }
        ],
        "aaSorting": [],   
        processing: true,
        serverSide: true,
        ajax: '{!! route('get.product') !!}',
        order: [ [0, 'desc'] ],
        columns: [
            {
              "data": "id",
              "className": "pilih"
            },
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'product_type_name', name: 'product_type_name' },
            { data: 'product_category_name', name: 'product_category_name' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'author', name: 'author' },
            { data: 'action', name: 'action' }
        ],
        'columnDefs': [{
            'targets': 0,
            'width':'2%',
            'searchable': false,
            'orderable': false,
            'className': 'selected-checkbox',
            'render': function (data, type, full, meta) {
                return '<input type="checkbox" name="chkid" id="' + data +
                    '" class="cbUser filled-in chk-col-light-blue">';
            }
        }],
        select: {
          style: 'multi'
        }
      });

      
        $('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
          var th_checked = this.checked;//checkbox inside "TH" table header
          
          $('#dynamic-table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) myTable.row(row).select();
            else  myTable.row(row).deselect();
          });
        });
        
        //select/deselect a row when the checkbox is checked/unchecked
        $('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
          var row = $(this).closest('tr').get(0);
          if(this.checked) myTable.row(row).deselect();
          else myTable.row(row).select();
        });
      
      
      
        $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
          e.stopImmediatePropagation();
          e.stopPropagation();
          e.preventDefault();
        });
  });

</script>
@endsection
