<!--Param Form Data-->
<div class="modal fade" id="showModal6" tabindex="-1" role="dialog" aria-labelledby="showModal6Label">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="showModal6Label">Success Code</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
        <div class="modal-body">
            <input type="hidden" id="cache_expire6" name="cache_expire6" value="300"> <!--Expired in 5 minutes-->
            <div class="input_fields_wrap2">
              <div class="row">
                <div class="col-sm">
                  <label for="succ-code" class="control-label">RC</label>
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" id="succ-code[]" name="succ-code[]">
                </div>
                <div class="col-sm">
                  <label for="succ-desc" class="control-label">Description</label>
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" id="succ-desc[]" name="succ-desc[]">
                </div>
                <div class="col-sm">
                  <button type="button" class="add_field_button2"> + </button>
                </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button id="savesucc" type="button" class="btn btn-primary">Save</button>
        </div>
    </div>
  </div>
</div>
