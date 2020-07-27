<!-- EDIT DAILY ACTIVITY Modal -->
<?php if($activity): ?>
  <div class="modal fade" id="edit_daily_activity" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Activity</h5>
          <button type="button" class="close" data-toggle="modal" data-target="#edit_modal_close_act" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="eda_form_error"></div>

        <?php echo form_open_multipart('daily_activity/update_daily_activity', array( 'id' => 'edit_da_form', 'class' => 'needs-validation', 'novalidate' => true));?>
        <div class="modal-body">
          <div class="row">
            <input type="hidden" class="form-control" id="e_activity_id" name="activity_id" value="<?= $activity->ACTIVITY_ID ?>">
             <input type="hidden" class="form-control" id="e_status" name="current_status" value="<?= $activity->STATUS ?>">
               <div class="col-lg-6 col-md-4 mb-3">
                  <label for="activity_date">Date</label>
                  <input type="date" class="form-control" id="e_activity_date" name="activity_date" value="<?= $activity->ACTIVITY_DATE ?>" min="<?php echo date("Y-m-d"); ?>" max="2999-12-31">
                </div>
               <div class="col-lg-6 col-md-4 mb-3">
                  <label for="time_from">Time From</label>
                  <input type="time" class="form-control" id="e_time_from" name="time_from"  value="<?= $activity->TIME_FROM ?>">
              </div>
               <div class="col-lg-6 col-md-4 mb-3">
                  <label for="time_to">Time To</label>
                  <input type="time" class="form-control" id="e_time_to" name="time_to" value="<?= $activity->TIME_TO ?>">
              </div>
              <div class="col-lg-6 col-md-4 mb-3">
                    <label for="participants">Participants</label>
                     <select class="edit-multiselect-ui form-control" id="e_participants" onchange="if_allowed_participant()" name="participants[]" multiple="multiple">
                      <?php foreach ($users as $user) : ?>
                        <?php $text = ""; 
                        if(in_array($user->EMP_CODE,$participants)){ $text="selected"; } ?>
                        <option value="<?= $user->EMP_CODE ?>" <?= $text ?>><?= $user->EMP_LNAME ?>, <?= $user->EMP_FNAME ?></option>
                      <?php endforeach;?>
                    </select>
                </div>
                <div class="col-lg-6 col-md-4 mb-3">
                    <label for="activity_type">Activity Type</label>
                    <select class="form-control" id="e_activity_type" name="activity_type" onchange="e_activity_change(this.value)" disabled>

                      <option value=""> -- Please Choose --</option>
                      <option value="Lunch" <?php if($activity->ACTIVITY_TYPE == 'Lunch'){ echo 'selected'; } ?>>Lunch</option>
                      <option value="Site Inspection" <?php if($activity->ACTIVITY_TYPE == 'Site Inspection'){ echo 'selected'; } ?>>Site Inspection</option>
                      <option value="Internal Meeting Only" <?php if($activity->ACTIVITY_TYPE == 'Internal Meeting Only'){ echo 'selected'; } ?>>Internal Meeting Only</option>
                      <option value="Meeting with Visitor/s" <?php if($activity->ACTIVITY_TYPE == 'Meeting with Visitor/s'){ echo 'selected'; } ?>>Meeting with Visitor/s</option>
                      <option value="Going Home" <?php if($activity->ACTIVITY_TYPE == 'Going Home'){ echo 'selected'; } ?>>Going Home</option>
                      <option value="Going to the Office" <?php if($activity->ACTIVITY_TYPE == 'Going to the Office'){ echo 'selected'; } ?>>Going to the Office</option>
                      <option value="Others" <?php if($activity->ACTIVITY_TYPE == 'Others'){ echo 'selected'; } ?>>Others</option>
                    </select>
                    <input type="hidden" class="form-control" id="hidden_activity_type" name="hidden_activity_type" value="<?= $activity->ACTIVITY_TYPE ?>">
                </div>
                <?php if($activity->HOST_EMP): ?>
                 <div class="col-lg-6 col-md-4 mb-3" id="e_host_emp_div">
                  <label for="host_emp">Host Employee <span style="color: red">*</span></label>
                  <select class="auto-select form-control" id="e_host_emp" name="host_emp" disabled>
                    <option value=""> -- Please Choose --</option>
                      <?php foreach ($users as $user) : ?>
                        <option value="<?= $user->EMP_CODE ?>" <?php if($activity->HOST_EMP == $user->EMP_CODE){ echo 'selected'; } ?>><?= $user->EMP_LNAME ?>, <?= $user->EMP_FNAME ?></option>
                      <?php endforeach;?>
                    </select>
                     <input type="hidden" class="form-control" id="hidden_host_employee" name="hidden_host_employee" value="<?= $activity->HOST_EMP ?>">
                </div>
              <?php endif; ?>
                <div class="col-lg-6 col-md-4 mb-3">
                  <label for="location">Location</label>
                  <input type="text" class="form-control" id="e_location" name="location"  value="<?= $activity->LOCATION ?>">
                </div>
          </div>

          
        </div>
        <div class="modal-footer">
         <!--  onclick="update_daily_activity(<?= $activity->ACTIVITY_ID ?>)" -->
          <button type="button" onclick="update_daily_activity(<?= $activity->ACTIVITY_ID ?>)" class="btn btn-primary">Update</button>
          <button type="button" data-toggle="modal" data-target="#edit_modal_close_act" class="btn btn-outline-secondary">Cancel</button>
        </div>
         <?php echo form_close();?>
      </div>
    </div>
  </div>
<?php endif; ?>
  <!-- End of EDIT DAILY ACTIVITY Modal -->

    <!-- MODAL CLOSE CONFIRMATION Modal -->

  <div class="modal fade" id="edit_modal_close_act" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
        </div>
        <div class="modal-body">
          Details will not be saved. Do you wish to cancel the changes you have made?
        </div>
        <div class="modal-footer">
          <button type="button" onclick="reload_page()" class="btn btn-primary">Yes</button>
          <button type="button" data-dismiss="modal" class="btn btn-outline-secondary">No</button>
        </div>
      </div>
    </div>
  </div>

  <!-- End of MODAL CLOSE CONFIRMATION  Modal -->


  <!-- For multi-select-->
<script src="dist/custom_js/selectize.min.js"></script>
<script type="text/javascript">
$(function() {
  $('.edit-multiselect-ui').selectize({
      plugins: ['remove_button'],
      delimiter: ',',
      persist: false
  });
});
</script>