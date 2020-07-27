<!-- ADD USER PROFILE Modal -->
  <div class="modal fade" id="add_user_profile" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

         <div id="um_form_error"></div>
        <?php echo form_open('admin/add_user_profile_ajax', array( 'id' => 'add_user_form', 'class' => 'needs-validation', 'novalidate' => true, 'role' => 'form'));?>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6 col-md-4 mb-3">
                  <label for="employee_name">Employee Name</label>
                   <select class="auto-select form-control" id="employee_name" name="employee_name">
                    <option value=""> -- Please Choose --</option>
                    <?php if($users_without_info): ?>
                      <?php foreach ($users_without_info as $user) : ?>
                        <option value="<?= $user->EMP_CODE?>"> <?= $user->EMP_LNAME?>, <?= $user->EMP_FNAME?> </option>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </select>
              </div>
              <div class="col-lg-6 col-md-4 mb-3">
                <label for="employee_number">Employee No. <span style="color: red">*</span></label>
                <input type="text" class="form-control" id="employee_number" name="employee_number" readonly>
              </div>

              <div class="col-lg-4 col-md-4 mb-3">
                <label for="login_id">Login ID <span style="color: red">*</span></label>
                 <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text"><span class="fa fa-user"></span></div>
                  </div>
                   <input type="text" class="form-control" id="login_id" name="login_id">
                </div>
               
              </div>

              <div class="col-lg-4 col-md-4 mb-3">
                <label for="password">Password <span style="color: red">*</span></label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text"><span class="fa fa-lock"></span></div>
                  </div>
                   <input type="password" class="form-control" id="password" name="password">
                </div>
              </div>

               <div class="col-lg-4 col-md-4 mb-3">
                  <label for="user_role">User Role <span style="color: red">*</span></label>
                    <select class="auto-select form-control" id="user_role" name="user_role">
                      <option value=""> -- Please Choose --</option>
                     <?php if($roles): ?>
                      <?php foreach ($roles as $role) : ?>
                        <option value="<?= $role->ROLE_ID?>"> <?= $role->ROLE_DESCRIPTION?></option>
                      <?php endforeach; ?>
                    <?php endif; ?>
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
                      <input type="text" class="form-control" id="lastname" name="lastname" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="middlename">Middle Name</label>
                      <input type="text" class="form-control" id="middlename" name="middlename" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="firstname">First Name</label>
                      <input type="text" class="form-control" id="firstname" name="firstname" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="gender">Gender</label>
                      <input type="text" class="form-control" id="gender" name="gender" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="birthday">Birthday</label>
                      <input type="date" class="form-control" id="birthday" name="birthday" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="age">Age</label>
                      <input type="text" class="form-control" id="age" name="age" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="email_address">Email Address <span style="color: red">*</span></label>
                      <input type="email" class="form-control" id="email_address" name="email_address">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="mobile">Mobile No. <span style="color: red">*</span></label>
                      <input type="text" class="form-control" id="mobile" name="mobile">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="telephone">Telephone No. </label>
                      <input type="text" class="form-control" id="telephone" name="telephone">
                    </div>

                    <div class="col-lg-6 col-md-4 mb-3">
                      <label for="present_address">Present Address</label>
                     <textarea rows="2" class="form-control" id="present_address" name="present_address" readonly></textarea>
                    </div>

                    <div class="col-lg-6 col-md-4 mb-3">
                      <label for="provincial_address">Provincial Address</label>
                      <textarea rows="2" class="form-control" id="provincial_address" name="provincial_address" readonly></textarea>
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
                      <input type="text" class="form-control" id="location" name="location" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="company">Company</label>
                      <input type="text" class="form-control" id="company" name="company" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="group">Group</label>
                      <input type="text" class="form-control" id="group" name="group" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="department">Department</label>
                      <input type="text" class="form-control" id="department" name="department" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="date_hired">Date Hired</label>
                      <input type="date" class="form-control" id="date_hired" name="date_hired" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="date_eoc">Date EOC</label>
                      <input type="date" class="form-control" id="date_eoc" name="date_eoc" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="employee_status">Employee Status</label>
                      <input type="email" class="form-control" id="employee_status" name="employee_status" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="level">Level</label>
                      <input type="text" class="form-control" id="level" name="level" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                      <label for="team_schedule">Team Schedule</label>
                      <input type="text" class="form-control" id="team_schedule" name="team_schedule" readonly>
                    </div>

                  
                </div>
              </div>
            </div>

          </div>

          </div>
        
          <div class="modal-footer">
            <button type="button" onclick="save_user_profile()" class="btn btn-primary">Save</button>
            <button type="button" data-dismiss="modal"  class="btn btn-outline-secondary">Cancel</button>
          </div>
          <?php echo form_close();?>
      </div>
    </div>
  </div>
  <!-- End of ADD USER PROFILE Modal -->