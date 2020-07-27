
<link rel="stylesheet" href="dist/custom_css/multiselect.css"/>
<link rel="stylesheet" type="text/css" href="dist/fontawesome/css/all.min.css">
<link rel="stylesheet" href="dist/custom_css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="dist/dataTables/dataTables.bootstrap4.min.css">
<style type="text/css">
  table.dataTable tbody tr.selected {
    color: #007bff !important;
    background-color: #eeeeee !important;
}
</style>
<div class="col-md-12 col-lg-12" style="padding: 20px;">
    <div class="container box p-3 ">
        <h3>Daily Activity</h3><hr>

       
        <div class="col-lg-10 col-md-10">
          <div id="search_form_error"></div>
            <?php echo form_open('daily_activity/daily_activities_list', array( 'id' => 'filter_table_form', 'class' => 'needs-validation', 'novalidate' => true));?>
             <div class="row">
                <div class="col-lg-6 col-md-4 mb-3">
                    <label for="requestor">Requestor</label>
                     <select class="auto-select form-control" id="requestor" name="requestor">
                      <option value=""> -- Please Choose --</option>
                        <?php foreach ($users as $user) : ?>
                          <option value="<?= $user->EMP_CODE ?>"><?= $user->EMP_LNAME ?>, <?= $user->EMP_FNAME ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-lg-6 col-md-4 mb-3">
                    <label for="participants">Participant</label>
                     <select class="auto-select form-control" id="participants" name="participants">
                      <option value=""> -- Please Choose --</option>
                        <?php foreach ($users as $user) : ?>
                          <option value="<?= $user->EMP_CODE ?>"><?= $user->EMP_LNAME ?>, <?= $user->EMP_FNAME ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-lg-6 col-md-4 mb-3">
                    <label for="activity_type">Activity Type</label>
                    <select class="form-control" id="activity_type" name="activity_type">
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
                <div class="col-lg-6 col-md-4 mb-3">
                    <label for="status">Status</label>
                     <select class="form-control" id="status" name="status">
                        <option value=""> -- Please Choose --</option>
                        <option value="FOR CONFIRMATION">FOR CONFIRMATION</option>
                        <option value="CONFIRMED">CONFIRMED</option>
                        <option value="DENIED">DENIED</option>
                        <option value="DONE">DONE</option>
                        <option value="CANCELLED">CANCELLED</option>
                    </select>
                </div>
            
                <div class="col-md-6 mb-3">
                    <label>Period (Date) <span class="fa fa-calendar"></span></label>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="date" class="form-control" id="start_dt" name="start_dt">
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="date" class="form-control" id="end_dt" name="end_dt">
                        </div>
                    </div>
                </div>
                    
               
                <div class="col-md-6 mb-3" style="padding: 20px;">
                    <button class="btn btn-primary my-2 mr-2" type="button" onclick="search_activities()"><span class="fa fa-search"></span> Search</button>
                    <button class="btn btn-outline-secondary my-2" type="button" onclick="clear_form();"><span class="fa fa-eraser"></span> Clear</button>
                </div>
            </div>
            <?php echo form_close();?>
        </div>

        <div id="daily_activity" style="padding-bottom: 30px;">
            <div class="col-lg-12 cold-12">
                <div style=" background-color: #495057; color: #f2e9da; padding: 5px; padding-left: 20px; margin-bottom: 20px;">
                  <span class="fa fa fa-bookmark"></span> Daily Activity Report
                </div>
                <div id="daily_activity_div">
                    <table class="table table-bordered display" id="daily_activity_table" width="100%">
                      <thead class="thead-light">
                        <tr>
                          <th scope="col">ID</th>
                          <th scope="col">Date</th>
                          <th scope="col">Time From</th>
                          <th scope="col">Time To</th>
                          <th scope="col">Activity Type</th>
                          <th scope="col">Requestor</th>
                          <th scope="col">Location</th>
                          <th scope="col">Status</th>
                          <th scope="col">Other Info</th>
                        </tr>
                      </thead>
                    
                    </table>
                    <div class="mb-3 float-right" style="padding: 20px;">
                        <button class="btn btn-primary my-2 mr-2" type="button" data-toggle="modal" data-target="#add_daily_activity"><span class="fa fa-plus"></span> Add</button>
                        <button class="btn btn-outline-success my-2 mr-2" type="button" id="edit_btn"><span class="fa fa-edit"></span> Edit</button>
                        <button class="btn btn-outline-danger my-2 mr-2" type="button" id="cancel_btn"><span class="fa fa-times"></span> Cancel Activity</button>
                    </div>

                </div>
            </div>
       </div>

       
       <div id="pending_confirmation" style="padding-top: 50px;">
        <div class="col-lg-12 cold-12">
            <div style=" background-color: #dc3545; color: #f2e9da; padding: 5px; padding-left: 20px; margin-bottom: 20px;">
              <span class="fa fa-exclamation-triangle"></span> Pending Activities for Confirmation
            </div>
            <div id="pending_confirmation_div">
                <table class="table table-bordered display" id="pending_confirmation_table">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Date</th>
                      <th scope="col">Time From</th>
                      <th scope="col">Time To</th>
                      <th scope="col">Activity Type</th>
                      <th scope="col">Requestor</th>
                      <th scope="col">Location</th>
                    </tr>
                  </thead>
              </table>

                <div class="mb-3" style="padding: 20px; text-align: right;" id="confirm_deny_btns">
                    <button class="btn btn-outline-success my-2 mr-2" type="button" id="confirm_btn"><span class="fa fa-check"></span> Confirm</button>
                    <button class="btn btn-outline-danger my-2 mr-2" type="button" id="denied_btn"><span class="fa fa-times"></span> Deny Activity</button>
                </div>
            </div>
        </div>
       </div>

    
        <?= $this->load->view('pages/modals/add_visitors_log', '', TRUE) ?>
        <?= $this->load->view('pages/modals/add_daily_activity', '', TRUE) ?>
        <div id= "show_modal"></div>
    

    </div>

</div>

    

<!-- Defaults -->
<script src="dist/js/jquery.min.js"></script>
<script src="dist/js/popper.min.js"></script>
<script src="dist/bootstrap/js/bootstrap.min.js"></script>
<script src="dist/js/jquery.form.validator.min.js"></script> 

<!-- For datatable -->
<script type="text/javascript" src="dist/DataTables/datatables.min.js"></script>
<script type="text/javascript" src="dist/DataTables/dataTables.bootstrap4.min.js"></script>
<script src="dist/custom_js/selectize.min.js"></script>
<script type="text/javascript" src="dist/da_scripts/custom_da.js"></script>
<footer class="text-center border border-grey border-bottom-0 border-left-0 border-right-0 p-2">
    <a href="#!" class="toTop font-weight-bolder text-decoration-none text-dark">^</a><br>
    <small class="font-weight-bold mb-0">Employee Tracking System version <?= APP_VERSION ?></small><br>
    <small>Copyright © 2020 Federal Land Inc.</small><br>
</footer>