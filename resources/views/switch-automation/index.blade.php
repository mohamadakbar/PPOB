@extends('layouts.sandeza')
@section('content')
<style>
	.collection-partner-item{
		width: 100% !important;
		display: flex;
		border: 1px solid #cccccc;
		border-radius: 3px;
		padding: 5px 16px;
		justify-content: space-between;
	}
    .switch {position: relative;display: inline-block;width: 60px;height: 34px;}
    .switch input {opacity: 0;width: 0;height: 0;}
    .slider {position: absolute;cursor: pointer;top: 0;left: 0;right: 0;bottom: 0;background-color: #ccc;-webkit-transition: .4s;transition: .4s;}
    .slider:before {position: absolute;content: "";height: 26px;width: 26px;left: 4px;bottom: 4px;background-color: white;-webkit-transition: .4s;transition: .4s;}
    input:checked + .slider {background-color: #2196F3;}
    input:focus + .slider {box-shadow: 0 0 1px #2196F3;}
    input:checked + .slider:before {-webkit-transform: translateX(26px);-ms-transform: translateX(26px);transform: translateX(26px);}
    .slider.round {border-radius: 34px;width: unset;height: unset;}
    .slider.round:before {border-radius: 50%;}
</style>
<div class="panel panel-default">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Manage Automatic</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"> 	  
        <div class="row col-sm-12 p-0 m-b-10">
            <div class="col-sm-12 m-t-30 row">
                <div class="row col-md-12 form-group">
                    <label for="name" class="col-md-1 control-label panel-status">Client</label>
                    <div class="col-md-3">
                        <select class="form-control comCor fz13" name="client" id="client">
                        <option value="" selected>Choose Client</option>
                        </select>
                    </div>
                    <div class="m-l-20 m-b-15 p-b-20" style="border-bottom:1px solid #eee;width: 92.5%;"></div>
                    <h4>Primary Partner</h4>
                    <div id="collection-partners" style="width:100%">

                    </div>

                    <div class="row show-content mt-5 mb-4" style="width:100%">
                        <input type="hidden" class="customId" value="">
                        <div class="col-sm-12">
                            <table width="100%" id="triggerCondition">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Status</th>
                                        <th>Condition</th>
                                        <th>Variables</th>
                                        <th>Reset after</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="warning-content mb-3 mt-3"></div>

                    <div class="col-md-12 mt-3 mb-3 text-center show-content">
                        <a href="#" id="addTriggerCondition"><img src="<?php echo url('/'); ?>/images/plus-circle-solid.svg" width="25px" /></a>
                    </div>
                    <!-- <div class="col-md-12 m-l-5 m-t-10 m-b-10 show-content">
                        <div class="text-right" style="">
                            <input class="btn btn-sm btn-secondary" style="height:31px" type="reset" value="Cancel">
                            <button class="btn btn-sm btn-primary btn-submit m-r-30" type="button">Save Data</button>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        </div>
    </div> 
</div>
<script>
var state = {
    number:0
};
$(document).ready(function () {
    var urlGetCollectionPartners = '{!! route('get.collectionpartner') !!}';
    var responseCodes = {!! json_encode($responseCodes) !!};
    $('.show-content').css('display', 'none');
    getAllClient();

    $("#client").change(function () { 
        let clientId = $(this).val();
        getCollectionPartners(clientId);
        getSelectedTable(clientId);
    });

    function getAllClient() {
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

    function getCollectionPartners(queryString) {         
        $("#collection-partners div").remove();
        $("#triggerCondition tbody tr").remove();
        $.ajax({
            crossDomain: true,
            crossOrigin: true,
            cache: false,
            type: "GET",
            url: urlGetCollectionPartners+'?client_id='+queryString,
            success: function(response) {
                let data = response.data;
                $(".customId").val(response.id);
                if(data.length > 0){
                    $('.show-content').css('display', 'block'); 
                    $('.warning-content').html('');
                }else{
                    $('.show-content').css('display', 'none');
                    $('.warning-content').html('No have data switching partner.');
                }
                for (var i = 0; i < data.length; i++) {
                    var result = data[i];
                    let html = `
                    <div class="row" style="align-items:center">
                        <div class="col-sm-3">
                            <div class="collection-partner-item">
                                `+result.partner+`
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="">
                                <b>`+result.text+`</b>
                            </div>
                        </div>												
                    </div>
                    `;
                    $('#collection-partners').append(html);
                }
            }
        });
    }
    $("#addTriggerCondition").click(function (e) { 
        e.preventDefault();
        state.number++;
        tableCondition();
    });
    function getSelectedTable(clientId) { 
        $.ajax({
            type: "GET",
            url: '{!! route('get.switchingcustomdetail') !!}?clientId='+clientId,
            success: function (response) {
                let responseData = response.data;
                state.number = 1;
                responseData.forEach(function(item, index){
                    tableCondition(item.id);
                    let isActive = false;
                    if(item.isactive == 1){
                        isActive = true;
                    }
                    if(item.condition == 2){ // Within period
                        $(".period").eq(index).css('display', 'inline-block');
                        $(".period").eq(index).val(item.period);
                    }
                    // Set up input form                    
                    $(".status").eq(index).prop("checked", isActive);
                    $(".status_response").eq(index).val(item.response_code);
                    $(".condition").eq(index).val(item.condition);
                    $(".values").eq(index).val(item.value);
                    $(".reset_after").eq(index).val(item.reset_after);

                    validateToggleActive(index);
                    state.number++;
                });                
            }
        });
     }
    function tableCondition(switchingCustomDetailId = '') {
        // 1.Consecutive 2.Within Period 3. Success Ratio
        
        let html = `
            <tr id="row-`+state.number+`">
                <input type="hidden" name="switchingCustomDetailId" class="switchingCustomDetailId" value="`+switchingCustomDetailId+`"/>
                <td>
                    <label class="switch">
                        <input type="checkbox" name="status[]" class="status" disabled>
                        <span class="slider round"></span>
                    </label>
                </td>
                <td>
                    <select name="status_response[]" class="status_response">
                        <option value="">Select Status</option>                        
                    </select>
                </td>
                <td>
                    <select name="condition[]" class="condition" data-number="`+state.number+`">
                        <option value="1">Consecutive</option>      
                        <option value="2">Within Period</option>
                        <option value="3">Success Ratio</option>                            
                    </select>
                </td>
                <td id="column-variable-`+state.number+`"> 
                    <input type="number" name="values[]" class="values" />                     
                    <input type="time" name="period[]" class="period" value="" style="display:none"/>
                </td>
                <td>
                    <input type="time" name="reset_after[]" class="reset_after" />
                </td>
                <td>
                    <a href="#" class="updateCondition mr-3 mb-2"><img src="<?php echo url('/'); ?>/images/sync-alt-solid.svg" width="15px" /></a> 
                    <a href="#" class="deleteCondition" data-number="`+state.number+`" data-id="`+switchingCustomDetailId+`"><img src="<?php echo url('/'); ?>/images/trash-alt-solid.svg" width="15px" /></a>
                </td>
            </tr>
        `;
        $("#triggerCondition tbody").append(html);

        responseCodes.forEach(function(item, index){
            let html = `
                <option value="`+item.responseCode+`">`+item.status+`</option>
            `;
            $("#row-"+state.number+">td>.status_response").append(html);
        });

        $("#row-"+state.number).on('change', '.status_response', function (e) { 
            e.preventDefault();
            let indexElement = $('.status_response').index(this);
            validateToggleActive(indexElement);
        });

        // Change Condition
        $("#row-"+state.number).on('change', '.condition', function (e) { 
            e.preventDefault();
            let conditionId = $(this).val();
            let indexElement = $('.condition').index(this);
            if(conditionId == 2){ // Within Period
                $(".period").eq(indexElement).css('display', 'inline-block');
            }else{
                $(".period").eq(indexElement).css('display', 'none');
                $(".period").eq(indexElement).val('');
            }
            validateToggleActive(indexElement);
        });

        $("#row-"+state.number).on('change', '.values', function (e) { 
            e.preventDefault();
            let indexElement = $('.values').index(this);
            validateToggleActive(indexElement);
        });
        $("#row-"+state.number).on('keyup', '.period', function (e) { 
            e.preventDefault();
            let indexElement = $('.period').index(this);
            validateToggleActive(indexElement);
        });
        $("#row-"+state.number).on('keyup', '.reset_after', function (e) { 
            e.preventDefault();
            let indexElement = $('.reset_after').index(this);
            validateToggleActive(indexElement);
        });

        $("#row-"+state.number).on('click', '.updateCondition', function (e) { 
            e.preventDefault();
            let attrNumber = $(this).attr('data-number');
            let indexElement = $('.updateCondition').index(this);

            //validation
            
            var formData = {
                customId: $('.customId').val(),
                switchingCustomDetailId: $('.switchingCustomDetailId').eq(indexElement).val(),
                status: $('.status').eq(indexElement).is(':checked'),
                status_response: $('.status_response').eq(indexElement).val(),
                condition: $('.condition').eq(indexElement).val(),
                values: $('.values').eq(indexElement).val(),
                period: $('.period').eq(indexElement).val(),
                reset_after: $('.reset_after').eq(indexElement).val()
            }        
            console.log("formData",formData);
            validateSubmit(formData, indexElement);    

            $.ajax({
                type: "POST",
                url: "{!! route('post.storeswitchingautomation') !!}",
                headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: formData,
                success: function (response) {
                    if(response.status == "success"){
                        swal({
                            title: "Success!",
                            text: response.message,
                            type: "success",
                            },function() {   
                                setTimeout(function () {        
                                window.location = "{{ url('adminpanel/switch-automation') }}";
                                },50);
                        });
                    }                   
                }
            });
        });

        // Delete Row
        $("#row-"+state.number).on('click', '.deleteCondition', function () { 
            var attrNumber = $(this).attr('data-number');
            var attrId = $(this).attr('data-id');
            let indexElement = $('.deleteCondition').index(this);
            swal({
                title: "Are you sure?",
                text: "Delete Will be permanently.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete it!",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: false
                },
                function(isConfirm){
                if (isConfirm) {
                    if(attrId != ""){
                        $.ajax({
                            type: "POST",
                            url: "{!! route('post.deleteswitchingcustomdetail') !!}",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            data: {
                                id:attrId
                            },
                            success: function (response) {   
                                swal({
                                    title: "Success!",
                                    text: "Data has been removed",
                                    type: "success",
                                    },function() {  
                                        swal.close();  
                                        $("#row-"+attrNumber).remove();
                                });                         
                            }
                        }); 
                    }else{
                        swal.close(); 
                        $("#row-"+attrNumber).remove();
                    }
                    
                } else {
                    swal("Cancelled", "Your file :)", "error");
                }
            });
        });
     }

     function validateSubmit(formData, indexElement) { 
        if(formData.customId != "" && formData.status != "" && formData.status_response != "" && formData.condition != "" && formData.values != "" && formData.reset_after != ""){
            if(formData.condition == 2){ // within period
                if(formData.period){
                    $('.status').eq(indexElement).prop("disabled", false);
                }
            }else{
                $('.status').eq(indexElement).prop("disabled", false);
            }
        }

        if(formData.customId == ""){
            swal({
                title: "Failed!",
                text: "Client is required",
                type: "warning"
            }); 
            return false;
        }

        if(formData.status_response == ""){
            swal({
                title: "Failed!",
                text: "Status is required",
                type: "warning"
            }); 
            return false;
        }
        if(formData.condition == ""){
            swal({
                title: "Failed!",
                text: "Condition is required",
                type: "warning"
            }); 
            return false;
        }
        if(formData.values == ""){
            swal({
                title: "Failed!",
                text: "variable is required",
                type: "warning"
            }); 
            return false;
        }

        if(formData.condition == 2){ // within period
            if(formData.period == ""){
                swal({
                    title: "Failed!",
                    text: "Period is required",
                    type: "warning"
                }); 
                return false;
            }
        }

        if(formData.reset_after == ""){
            swal({
                title: "Failed!",
                text: "Reset after is required",
                type: "warning"
            }); 
            return false;
        }
      }

     function validateToggleActive(indexElement){
        var data = {
            customId: $('.customId').eq(indexElement).val(),
            status: $('.status').eq(indexElement).val(),
            status_response: $('.status_response').eq(indexElement).val(),
            condition: $('.condition').eq(indexElement).val(),
            values: $('.values').eq(indexElement).val(),
            period: $('.period').eq(indexElement).val(),
            reset_after: $('.reset_after').eq(indexElement).val()
        }

        if(data.customId != "" && data.status != "" && data.status_response != "" && data.condition != "" && data.values != "" && data.reset_after != ""){
            if(data.condition == 2){ // within period
                if(data.period){
                    $('.status').eq(indexElement).prop("disabled", false);
                }
            }else{
                $('.status').eq(indexElement).prop("disabled", false);
            }
        }
     }
});
</script>
@endsection