<div class="col-lg-12 col-md-12">
  <div class="col-lg-12 col-md-8" style="padding-top: 50px;">

    <button type="button" class="btn btn-block btn-primary collapsible" style="margin-bottom: 50px;">Advance Search <span class="fa fa-search"></span></button>
      <div class="content" style="display: none;">
       <?php echo form_open('', array( 'id' => 'filter_table_form', 'class' => 'needs-validation', 'novalidate' => true));?>
         <div class="row">
            <div class="col-lg-6 col-md-4 mb-3">
                <label for="company">Company</label>
                 <select class="auto-select form-control" id="company" name="company">
                  <option value=""> -- Please Choose --</option>
                  <?php foreach ($companies as $company) : ?>
                    <option value="<?= $company->COMP_CODE  ?>"><?= $company->COMP_NAME  ?></option>
                  <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-6 col-md-4 mb-3">
                <label for="group">Group</label>
                 <select class="auto-select form-control" id="group" name="group">
                  <option value=""> -- Please Choose --</option>
                  <?php foreach ($groups as $group) : ?>
                    <option value="<?= $group->GRP_CODE ?>"><?= $group->GRP_NAME  ?></option>
                  <?php endforeach; ?>
                </select>
            </div>

            <div class="col-lg-6 col-md-4 mb-3">
                <label for="firstname">First Name</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name">
                </select>
            </div>

            <div class="col-lg-6 col-md-4 mb-3">
                <label for="lastname">Last Name</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name">
            </div>

            <div class="col-lg-4 col-md-4 mb-3">
                <label for="access_group">Access Group</label>
                <select class="auto-select form-control" id="access_group" name="access_group">
                  <option value=""> -- Please Choose --</option>
                   <?php if($roles): ?>
                      <?php foreach ($roles as $role) : ?>
                        <option value="<?= $role->ROLE_ID?>"> <?= $role->ROLE_DESCRIPTION?></option>
                      <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="col-lg-4 col-md-4 mb-3">
                <label for="status">Status</label>
                 <select class="form-control" id="status" name="status">
                    <option value=""> -- Please Choose --</option>
                    <?php foreach ($statuses as $status) : ?>
                    <option value="<?= $status->EMPSTAT_CODE ?>"><?= $status->EMPSTAT_DESC  ?></option>
                  <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4 mb-3" style="padding: 20px;">
                <button class="btn btn-primary my-2 mr-2" type="button" onclick="search_user()"><span class="fa fa-search"></span> Search</button>
                <button class="btn btn-outline-secondary my-2" type="button" onclick="clear_form();"><span class="fa fa-eraser"></span> Clear</button>
            </div>
        </div>
        <?php echo form_close();?>
      </div>
       
    </div>

    <div id="user_maintenance_table">
        <table class="table table-bordered display" id="users_table">
          <thead class="thead-light">
            <tr>
              <th scope="col">Login ID</th>
              <th scope="col">Employee No.</th>
              <th scope="col">Last Name</th>
              <th scope="col">First Name</th>
              <th scope="col">Middle Name</th>
              <th scope="col">Company</th>
              <th scope="col">Group</th>
              <th scope="col">Status</th>
              <th scope="col">Access Group</th>
            </tr>
          </thead>

      </table>

       <div class="mb-3 float-right" style="padding: 20px;">
          <button class="btn btn-primary my-2 mr-2" type="button" data-toggle="modal" data-target="#add_user_profile"><span class="fa fa-plus"></span> Add Profile</button>
          <button class="btn btn-outline-success my-2 mr-2" id="edit_btn" type="button"><span class="fa fa-edit"></span> Edit Profile</button>
      </div>
    </div>
</div>

<?= $this->load->view('pages/modals/add_user_profile', '', TRUE) ?>
<div id="show_modal"></div>

<script type="text/javascript">
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
</script>