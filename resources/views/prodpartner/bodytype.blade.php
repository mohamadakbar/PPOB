<!--Param Form Data-->
<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="showModalLabel">Params</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
        <div class="modal-body">
            <input type="hidden" id="cache_expire" name="cache_expire" value="300"> <!--Expired in 5 minutes-->
            <div class="input_fields_wrap">
              <div class="row">
                <div class="col-sm">
                  <label for="key-param" class="control-label">Key</label>
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" id="key-param[]" name="key-param[]">
                </div>
                <div class="col-sm">
                  <label for="key-value" class="control-label">Value</label>
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" id="key-value[]" name="key-value[]">
                </div>
                <div class="col-sm">
                  <button type="button" class="add_field_button"> + </button>
                </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button id="saveform1" type="button" class="btn btn-primary">Save</button>
        </div>
    </div>
  </div>
</div>

<!--Param JSON-->
<div class="modal fade" id="showModal2" tabindex="-1" role="dialog" aria-labelledby="showModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="showModalLabel">JSON Body</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
          <input type="hidden" id="cache_expire2" name="cache_expire2" value="300"> <!--Expired in 5 minutes-->
          <div class="form-group row">
              <div class="col-lg-12">
                <textarea cols="50" rows="5" id="jsonparam" name="jsonparam" class="form-control"></textarea>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="saveform2" type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>
