<!-- EDIT USER PROFILE Modal -->
<?php if($profile):  ?>
  <div class="modal fade" id="edit_user_profile" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

         <div id="update_um_form_error"></div>
        <?php echo form_open('admin/edit_user_profile', array( 'id' => 'edit_user_form', 'class' => 'needs-validation', 'novalidate' => true, 'role' => 'form'));?>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6 col-md-4 mb-3">
                <label for="employee_number">Employee No. <span style="color: red">*</span></label>
                <input type="text" class="form-control" id="eemployee_number" name="employee_number" value="<?= $profile->EMP_CODE ?>" readonly>
              </div>

              <div class="col-lg-4 col-md-4 mb-3">
                <label for="login_id">Login ID <span style="color: red">*</span></label>
                 <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text"><span class="fa fa-user"></span></div>
                  </div>
                   <input type="text" class="form-control" id="login_id" name="login_id" value="<?= $profile->LOGIN_ID ?>" readonly>
                </div>
               
              </div>

              <div class="col-lg-4 col-md-4 mb-3">
                <label for="password">Password <span style="color: red">*</span></label>
                <div class="input-group">
                  <input type="password" class="form-control pwd" name="password" id="epassword">
                  <span class="input-group-btn">
                    <button class="btn btn-outline-secondary reveal" type="button" onclick="show_hide_password()"><i class="fa fa-eye"></i></button>
                  </span>          
                </div>
              </div>

               <div class="col-lg-4 col-md-4 mb-3">
                  <label for="user_role">User Role <span style="color: red">*</span></label>
                    <select class="auto-select form-control" id="euser_role" name="user_role">
                      <option value=""> -- Please Choose --</option>
                       <?php if($roles): ?>
                        <?php foreach ($roles as $role) : ?>
                          <option value="<?= $role->ROLE_ID?>" <?php if($profile->ROLE_ID == $role->ROLE_ID): echo "selected"; endif; ?>> <?= $role->ROLE_DESCRIPTION?></option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
              </div>

               <div class="col-lg-4 col-md-4 mb-3">
                  <label for="user_role">Status <span style="color: red">*</span></label>
                    <select class="auto-select form-control" id="estatus" name="status">
                      <option value=""> -- Please Choose --</option>
                      <option value="0" <?php if($profile->STATUS == 0) { echo "selected"; } ?> >Active</option>
                      <option value="2" <?php if($profile->STATUS == 2) { echo "selected"; } ?>>Active Initial Password</option>
                      <option value="256" <?php if($profile->STATUS == 256) { echo "selected"; } ?>>Locked by System Administrator</option>
                    </select>
              </div>
            </div>

            <div id="information_div">
            <div class="card border-info" style="margin-top: 30px;">
              <div class="card-header" style="background-color: rgb(23, 162, 184); color: #fff;"><span class="fa fa-id-card"></span> Personal Information</div>
              <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="lastname">Last Name</label>
                      <input type="text" class="form-control" id="lastname" name="lastname" readonly value="<?= $profile->EMP_LNAME ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="middlename">Middle Name</label>
                      <input type="text" class="form-control" id="middlename" name="middlename" readonly value="<?= $profile->EMP_MNAME ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="firstname">First Name</label>
                      <input type="text" class="form-control" id="firstname" name="firstname" readonly value="<?= $profile->EMP_FNAME ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="gender">Gender</label>
                      <input type="text" class="form-control" id="gender" name="gender" readonly value="<?= $profile->GENDER ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="birthday">Birthday</label>
                      <input type="date" class="form-control" id="birthday" name="birthday" readonly value="<?= $profile->BIRTHDATE ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="age">Age</label>
                      <input type="text" class="form-control" id="age" name="age" readonly value="<?= $profile->AGE ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="email_address">Email Address <span style="color: red">*</span></label>
                      <input type="email" class="form-control" id="eemail_address" name="email_address" value="<?= $profile->EMAIL_ADDRESS ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="mobile">Mobile No. <span style="color: red">*</span></label>
                      <input type="text" class="form-control" id="emobile" name="mobile" value="<?= $profile->MOBILE_NO ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="telephone">Telephone No. </label>
                      <input type="text" class="form-control" id="telephone" name="telephone" value="<?= $profile->TEL_NO ?>">
                    </div>

                    <div class="col-lg-6 col-md-4 mb-3">
                      <label for="present_address">Present Address</label>
                     <textarea rows="2" class="form-control" id="present_address" name="present_address" readonly>
                       <?= $profile->PRESENT_ADDR1 ?> <?= $profile->PRESENT_ADDR2 ?> <?= $profile->PRESENT_CITY ?> <?= $profile->PRESENT_PROV ?>
                     </textarea>
                    </div>

                    <div class="col-lg-6 col-md-4 mb-3">
                      <label for="provincial_address">Provincial Address</label>
                      <textarea rows="2" class="form-control" id="provincial_address" name="provincial_address" readonly><?= $profile->PERM_CITY ?> <?= $profile->PERM_PROV ?></textarea>
                    </div>
                </div>
              </div>
            </div>

            <div class="card border-success" style="margin-top: 30px;">
              <div class="card-header" style="background-color: rgb(40, 167, 69); color: #fff;"><span class="fa fa-briefcase"></span> Employment Information</div>
              <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="location">Location</label>
                      <input type="text" class="form-control" id="location" name="location" readonly value="<?= $profile->LOCATION_NAME ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="company">Company</label>
                      <input type="text" class="form-control" id="company" name="company" readonly value="<?= $profile->COMP_NAME ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="group">Group</label>
                      <input type="text" class="form-control" id="group" name="group" readonly value="<?= $profile->GRP_NAME ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="department">Department</label>
                      <input type="text" class="form-control" id="department" name="department" readonly value="<?= $profile->DEPT_NAME ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="date_hired">Date Hired</label>
                      <input type="date" class="form-control" id="date_hired" name="date_hired" readonly value="<?= $profile->DATE_HIRED ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="date_eoc">Date EOC</label>
                      <input type="date" class="form-control" id="date_eoc" name="date_eoc" readonly value="<?= $profile->DATE_EOC ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="employee_status">Employee Status</label>
                      <input type="email" class="form-control" id="employee_status" name="employee_status" readonly value="<?= $profile->EMPSTAT_DESC ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="level">Level</label>
                      <input type="text" class="form-control" id="level" name="level" readonly value="<?= $profile->RANK_DESC ?>">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="team_schedule">Team Schedule</label>
                      <input type="text" class="form-control" id="team_schedule" name="team_schedule" readonly value="<?= $profile->SCHEDULE ?>">
                    </div>

                  
                </div>
              </div>
            </div>

          </div>

          </div>
        
          <div class="modal-footer">
            <button type="button" onclick="update_user_profile();"  class="btn btn-primary">Update</button>
            <button type="button" data-dismiss="modal"  class="btn btn-outline-secondary">Cancel</button>
          </div>
          <?php echo form_close();?>
      </div>
    </div>
  </div>
<?php endif; ?>
  <!-- End of EDIT USER PROFILE Modal -->

