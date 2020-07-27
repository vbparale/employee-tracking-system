<!-- ADD HDF CUTOFF Modal -->
<div class="modal fade" id="add_hdf_cutoff" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add HDF Cutoff</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div id="cutoff_form_error"></div>

        <?php echo form_open_multipart('', array( 'id' => 'cutoff_form', 'class' => 'needs-validation', 'novalidate' => true));?>
          <div class="modal-body">
            <div class="row">
            
               <div class="col-lg-6 col-md-4 mb-3">
                  <label for="submission_date">Submission Date <span style="color: red">*</span></label>
                  <input type="date" class="form-control" id="submission_date" name="submission_date" min="<?php echo date("Y-m-d"); ?>" required>
                </div>
               <div class="col-lg-6 col-md-4 mb-3">
                  <label for="cutoff_time">Cutoff Time<span style="color: red">*</span></label>
                  <input type="time" class="form-control" id="cutoff_time" name="cutoff_time" required>
              </div>
              </div>
            <div class="row">
              <div class="col-lg-6 col-md-4 mb-3">
                <label for="emp_flag">Required Users<span style="color: red">*</span></label>
                <select class="form-control" id="emp_flag" name="emp_flag" required>
                    <option value="" selected disabled> -- Please Choose --</option>
                    <option value="1">All Employees</option>
                    <option value="2">Specific Employees</option>
                </select>
              </div>
            </div>
            <div class="">
                <div id="select_users">
                  <div class="mb-3">
                    <label for="participants">Select employees to answer the HDF</label>
                    <small class="text-muted"><br>Press CTRL + left-click to select multiple users</small>
                    <select size="8" class="multiselect-ui form-control" id="emp_code" name="emp_code[]" multiple="multiple">
                      <option value="" disabled selected>--Please Choose--</option>
                    </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="save_cutoff_btn" class="btn btn-primary">Save</button>
            <button type="button" data-dismiss="modal"  class="btn btn-outline-secondary">Cancel</button>
          </div>
        <?php echo form_close();?>
      </div>
    </div>
  </div>
  <!-- End of ADD HDF CUTOFF Modal -->

