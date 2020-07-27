<!-- ADD DAILY ACTIVITY Modal -->
  <div class="modal fade" id="add_daily_activity" tabindex="-1" role="dialog" aria-hidden="true"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Activity</h5>
           <button type="button" class="close" data-toggle="modal" data-target="#modal_close_act" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

         <div id="da_form_error"></div>

         <?php echo form_open_multipart('daily_activity/add_daily_activity', array( 'id' => 'add_da_form', 'class' => 'needs-validation', 'novalidate' => true));?>
          <div class="modal-body">
            <div class="row">
            
               <div class="col-lg-6 col-md-4 mb-3">
                  <label for="activity_date">Date <span style="color: red">*</span></label>
                  <input type="date" class="form-control" id="activity_date" name="activity_date" min="<?php echo date("Y-m-d",strtotime("-1 days")); ?>" max="2999-12-31" required>
                </div>
               <div class="col-lg-6 col-md-4 mb-3">
                  <label for="time_from">Time From <span style="color: red">*</span></label>
                  <input type="time" class="form-control" id="time_from" name="time_from" required>
              </div>
               <div class="col-lg-6 col-md-4 mb-3">
                  <label for="time_to">Time To <span style="color: red">*</span></label>
                  <input type="time" class="form-control" id="time_to" name="time_to" required>
              </div>
              <div class="col-lg-6 col-md-4 mb-3">
                    <label for="participants">Participants</label>
                     <select class="multiselect-ui form-control" id="prtcpnts" name="participants[]" multiple="multiple">
                      <?php foreach ($users as $user) : ?>
                        <option value="<?= $user->EMP_CODE ?>"><?= $user->EMP_LNAME ?>, <?= $user->EMP_FNAME ?></option>
                      <?php endforeach;?>
                    </select>
                </div>
                <div class="col-lg-6 col-md-4 mb-3">
                    <label for="activity_type">Activity Type <span style="color: red">*</span></label>
                    <select class="form-control" id="a_activity_type" name="activity_type" required>
                        <option value=""> -- Please Choose --</option>
                        <option value="Lunch">Lunch</option>
                        <option value="Site Inspection">Site Inspection</option>
                        <option value="Internal Meeting Only">Internal Meeting Only</option>
                        <option value="Meeting with Visitor/s">Meeting with Visitor/s</option>
                        <option value="Going Home">Going Home</option>
                        <option value="Going to the Office">Going to the Office</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="col-lg-6 col-md-4 mb-3" id="host_emp_div">
                  <label for="host_emp">Host Employee <span style="color: red">*</span></label>
                  <select class="auto-select form-control" id="host_emp" name="host_emp">
                    <option value=""> -- Please Choose --</option>
                      <?php foreach ($users as $user) : ?>
                        <option value="<?= $user->EMP_CODE ?>"><?= $user->EMP_LNAME ?>, <?= $user->EMP_FNAME ?></option>
                      <?php endforeach;?>
                    </select>
                </div>
                <div class="col-lg-12 col-md-4 mb-3">
                  <label for="location">Location <span style="color: red">*</span></label>
                  <input type="text" class="form-control" id="location" name="location" maxlength="50" required>
                </div>
            </div>
          </div>
        
          <div class="modal-footer">
            <button type="button" id="btn_save_activity" onclick="save_daily_activity()" class="btn btn-primary">Save</button>
            <button type="button" data-toggle="modal" data-target="#modal_close_act" class="btn btn-outline-secondary">Cancel</button>
          </div>
        <?php echo form_close();?>
      </div>
    </div>
  </div>
  <!-- End of ADD DAILY ACTIVITY Modal -->

  <!-- MODAL CLOSE CONFIRMATION Modal -->

  <div class="modal fade" id="modal_close_act" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
        </div>
        <div class="modal-body">
          Details will not be saved. Do you wish to cancel the transaction?
        </div>
        <div class="modal-footer">
          <button type="button" onclick="reload_page()" class="btn btn-primary">Yes</button>
          <button type="button" data-dismiss="modal" class="btn btn-outline-secondary">No</button>
        </div>
      </div>
    </div>
  </div>

  <!-- End of MODAL CLOSE CONFIRMATION  Modal -->

