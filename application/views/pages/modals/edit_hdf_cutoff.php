<!-- EDIT DAILY ACTIVITY Modal -->

  <div class="modal fade" id="edit_cutoff" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Cutoff Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="edit_cutoff_form_error"></div>

        <?php echo form_open_multipart('', array( 'id' => 'edit_cutoff_form', 'class' => 'needs-validation', 'novalidate' => true));?>
          <div class="modal-body">
            <div class="row">
              <input type="hidden" name="cutoffid" id="cutoffid" />
               <div class="col-lg-6 col-md-4 mb-3">
                  <label for="submission_date">Submission Date <span style="color: red">*</span></label>
                  <input type="date" class="form-control" id="edit_submission_date" name="submission_date" min="<?php echo date("Y-m-d",strtotime("+1 days")); ?>" required>
                </div>
               <div class="col-lg-6 col-md-4 mb-3">
                  <label for="cutoff_time">Cutoff Time<span style="color: red">*</span></label>
                  <input type="time" class="form-control" id="edit_cutoff_time" name="cutoff_time" required>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-4 mb-3">
                <label for="emp_flag">Required Users<span style="color: red">*</span></label>
                <select class="form-control" id="edit_emp_flag" name="emp_flag" required>
                    <option value="" disabled> -- Please Choose --</option>
                    <option value="1">All Employees</option>
                    <option value="2">Specific Employees</option>
                </select>
              </div>
            </div>
            <div>
                <div id="edit_select_users">
                  <div class="mb-3">
                    <label for="participants">Select employees to answer the HDF</label>
                    <small class="text-muted"><br>Press CTRL + left-click to select multiple users</small>
                    <select size="8" class="multiselect-ui form-control" id="edit_emp_code" name="emp_code[]" multiple="multiple">
                      <option value="" disabled>--Please Choose--</option>
                    </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="update_cutoff_btn" class="btn btn-primary">Update</button>
            <button type="button" data-dismiss="modal"  class="btn btn-outline-secondary">Cancel</button>
          </div>
        <?php echo form_close();?>
      </div>
    </div>
  </div>
  <!-- End of EDIT DAILY ACTIVITY Modal -->

  <!-- For multi-select-->
<script src="dist/custom_js/selectize.min.js"></script>
<script type="text/javascript">
$(function() {
  $('.edit-multiselect-ui').selectize({
      plugins: ['remove_button'],
      delimiter: ',',
      persist: false
  });

  console.log(data);
});
</script>