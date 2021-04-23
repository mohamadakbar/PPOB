//Multi param
$(document).ready(function() {
	var max_fields      = 10; //maximum input boxes allowed
	var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID

	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
			$(wrapper).append('<p><div id="rootmulti" class="row"><div class="col-sm"><label for="key-param" class="control-label">Key</label></div><div class="col-4"><input type="text" class="form-control" id="key-param[]" name="key-param[]"></div><div class="col-sm"><label for="key-value" class="control-label">Default</label></div><div class="col-4"><input type="text" class="form-control" id="key-value[]" name="key-value[]"></div><div class="col-sm"><button type="button" class="remove_field"> - </button></div></div></p>'); //add input box
		}
	});

	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
	})
});

//Multi RC
$(document).ready(function() {
	var max_fields      = 10; //maximum input boxes allowed
	var wrapper   		= $(".input_fields_wrap2"); //Fields wrapper
	var add_button      = $(".add_field_button2"); //Add button ID

	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
			$(wrapper).append('<p><div id="rootmulti" class="row"><div class="col-sm"><label for="succ-code" class="control-label">RC</label></div><div class="col-4"><input type="text" class="form-control" id="succ-code[]" name="succ-code[]"></div><div class="col-sm"><label for="succ-desc" class="control-label">Description</label></div><div class="col-4"><input type="text" class="form-control" id="succ-desc[]" name="succ-desc[]"></div><div class="col-sm"><button type="button" class="remove_field"> - </button></div></div></p>'); //add input box
		}
	});

	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
	})
});
