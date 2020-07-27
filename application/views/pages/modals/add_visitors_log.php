<div class="modal fade" id="visitors_log" tabindex="-1" role="dialog" style="overflow: auto !important; " data-keyboard="false" data-backdrop="static">>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Visitor</h5>
        <button type="button" class="close" id="modal_close_btn" data-toggle="modal" data-target="#modal_close_confirm" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div id="vl_form_error"></div>
      <?php echo form_open_multipart('daily_activity/add_visitors_log', array( 'id' => 'add_visitors_form', 'class' => 'needs-validation', 'novalidate' => true, 'role' => 'form'));?>
          <div class="modal-body">
            <input type="hidden" class="form-control" id="v_activity_id" name="v_activity_id">
            <div class="row">
                <div class="col-lg-4 col-md-4 mb-3">
                  <label for="date_visit">Date of Visit <span style="color: red">*</span></label>
                  <input type="date" class="form-control" id="date_visit" name="date_visit" required readonly>
                </div>
                 <div class="col-lg-4 col-md-4 mb-3">
                 
                </div>
                <div class="col-lg-4 col-md-4 mb-3">
                </div>

                <div class="col-lg-4 col-md-4 mb-3">
                  <label for="visitor_name">Firstname <span style="color: red">*</span></label>
                  <input type="text" class="form-control" maxlength="50" id="visitor_fname" name="visitor_fname" required>
                </div>
                <div class="col-lg-4 col-md-4 mb-3">
                  <label for="visitor_name">Middlename</label>
                  <input type="text" class="form-control" maxlength="50" id="visitor_mname" name="visitor_mname">
                </div>
                <div class="col-lg-4 col-md-4 mb-3">
                  <label for="visitor_name">Lastname <span style="color: red">*</span></label>
                  <input type="text" class="form-control" maxlength="50" id="visitor_lname" name="visitor_lname" required>
                </div>
                 <div class="col-lg-4 col-md-4 mb-3">
                  <label for="mobile">Email Address <span style="color: red">*</span></label>
                  <input type="email" maxlength="30" class="form-control" id="email" name="email" required>
                </div>
                <div class="col-lg-4 col-md-4 mb-3">
                  <label for="mobile">Mobile Number <span style="color: red">*</span></label>
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">09</span>
                      </div>
                    <input type="text" placeholder="eg. 09123456789" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="mobile" name="mobile" maxlength="9" required>
                  </div>
                </div>
                 <div class="col-lg-4 col-md-4 mb-3">
                  <label for="landline">Landline</label>
                  <input type="text" maxlength="10" onkeypress="return number_or_special_char(event)" class="form-control" id="landline" name="landline">
                </div>
                <div class="col-lg-6 col-md-4 mb-3">
                  <label for="company">Company <span style="color: red">*</span></label>
                  <input type="text" maxlength="50" class="form-control" id="company" name="company" required>
                </div>
                <div class="col-lg-6 col-md-4 mb-3">
                  <label for="company_address">Company Address <span style="color: red">*</span></label>
                  <input type="text" maxlength="50" class="form-control" id="company_address" name="company_address" required>
                </div>
               
                <div class="col-lg-6 col-md-4 mb-3">
                  <label for="residential_address">Residential Address <span style="color: red">*</span></label>
                  <input type="text" maxlength="50" class="form-control" id="residential_address" name="residential_address" required>
                </div>
                <div class="col-lg-6 col-md-4 mb-3">
                  <label for="person_visiting">Person/Group Visiting <span style="color: red">*</span></label>
                     <select class="form-control" id="person_visiting" name="person_visiting" required disabled>
                      <?php foreach ($users as $user) : ?>
                        <option value="<?= $user->EMP_CODE ?>"><?= $user->EMP_LNAME ?>, <?= $user->EMP_FNAME ?></option>
                      <?php endforeach;?>
                    </select>
                    <input type="hidden" class="form-control" id="input_person_visiting" name="person_visiting" value="<?= $user->EMP_CODE ?>">
                </div>
                <div class="col-lg-12 col-md-4 mb-3">
                  <label for="purpose">Purpose of Visit <span style="color: red">*</span></label>
                  <textarea rows="3" maxlength="50" class="form-control" id="purpose" name="purpose"></textarea>
                </div>
         
                 <div class="col-lg-12 col-md-4 mb-3">
                  <label for="q1"><?= $Q1->QUESTION; ?> <span style="color: red">*</span></label>
                  <input type="hidden" class="form-control" id="q1_id" name="q1_id" value="<?= $Q1->QCODE ?>">
                  <select class="multiselect-ui-2 form-control" id="q1_answer" name="q1_answer[]" multiple="multiple" required>
                    <option value=""> -- Please Choose --</option>
                    <?php foreach(json_decode($Q1->POSS_ANSWER) as $key => $value) :?>
                      <option value="<?= $key; ?>"> <?= $value; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class = "col-lg-6 col-md-4 mb-3" id="divSicknessOther">
                    <div class="col-md-12 mb-12">
                        <label for="inputOtherSickness">Please Indicate:</label>
                        <input type="text" class="form-control" id="inputOtherSickness" placeholder="Enter your other sickness" name = "inputOtherSickness">
                    </div>
                </div>

                <div class = "col-lg-6 col-md-4 mb-3" id="divSicknessDate">
                    <div class="col-md-12 mb-12">
                        <label for="inputStartEndDate">If yes, date when it started and ended:</label>
                        <input type="text" maxlength="50" class="form-control" name="inputStartEndDate" id="inputStartEndDate" value="" />
                    </div>
                </div>

                 <div class="col-lg-12 col-md-4 mb-3">
                  <label for="q2"><?= $Q2->QUESTION; ?> <span style="color: red">*</span></label>
                  <input type="hidden" class="form-control" id="q2_id" name="q2_id" value="<?= $Q2->QCODE ?>">
                  <select class="form-control" id="q2_answer" name="q2_answer" required>
                    <option value=""> -- Please Choose --</option>
                    <?php foreach(json_decode($Q2->POSS_ANSWER) as $key => $value) :?>
                      <option value="<?= $key; ?>"> <?= $value; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                   <div class = "col-lg-6 col-md-4 mb-3" id="divTravel">
                        <div class="col-md-12 mb-12">
                            <label for="inputTravelDate">If yes, Please state the travel date:</label>
                            <input type="text" maxlength="30" class="form-control" id="inputTravelDate"  name = "inputTravelDate">
                        </div>
                    </div>

                    <div class = "col-lg-6 col-md-4 mb-3" id="divTravel2">
                        <div class="col-md-12 mb-12">
                            <label for="inputTravelLoc">State the exact place of travel:</label>
                            <input type="text" maxlength="30" class="form-control" id="inputTravelLoc"  placeholder="Enter country/city"  name = "inputTravelLoc">
                        </div>
                    </div>

                    <div class = "col-lg-6 col-md-4 mb-3" id="divTravel3">
                        <div class="col-md-12 mb-12">
                            <label for="inputDatOfReturn">Date of return to PH/Manila:</label>
                            <input type="date" class="form-control" id="inputDatOfReturn" name = "inputDatOfReturn" max="2999-12-31">
                        </div>
                    </div>
                
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btn_save_visitors" onclick="save_visitors_form()" class="btn btn-primary">Save</button>
          <button type="button" onclick="save_add_form()" class="btn btn-outline-secondary">Save & Add</button>
        </div>
      <?php echo form_close();?>
    </div>
  </div>
</div>

<!-- MODAL CLOSE CONFIRMATION Modal -->

  <div class="modal fade" id="modal_close_confirm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
        </div>
       <?php echo form_open('daily_activity/delete_activity', array( 'id' => 'cancel_visitors', 'class' => 'needs-validation', 'novalidate' => true, 'role' => 'form'));?>
        <div class="modal-body">
           <input type="hidden" class="form-control" id="delete_activity_id" name="delete_activity_id">
          You are about to exit the form, do you wish to continue?
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Yes</button>
          <button type="button" data-dismiss="modal" class="btn btn-outline-secondary">No</button>
        </div>
        <?php echo form_close();?>
      </div>
    </div>
  </div>

  <!-- End of MODAL CLOSE CONFIRMATION  Modal -->


