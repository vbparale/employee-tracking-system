<style>
    .box 
        {
            margin-left: auto;
            margin-right: auto;
            margin-top: 3%;
            border-radius: 10px;
        }
</style>
        <link rel="stylesheet" href="dist/dataTables/dataTables.bootstrap4.min.css">
        <!-- start confirm modal -->
        <div class="modal fade" id="hdf_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modal_title" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" id="confirm_header">
                        <h5 class="modal-title" id="modal_title">Well done!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="confirm_body">
                        You have submitted your daily health check. Come back again tomorrow.
                    </div>
                    <div class="modal-footer" id="confirm_footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end confirm modal -->
        <!-- start error modal -->
        <div class="modal fade" id="error_modal" tabindex="-1" role="dialog" aria-labelledby="modal_title" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" id="error_header">
                        <h5 class="modal-title" id="error_title">Well done!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="error_body">
                        You have submitted your daily health check. Come back again tomorrow.
                    </div>
                    <div class="modal-footer" id="error_footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end error modal -->
        <!-- start cancel modal -->
        <div class="modal fade" id="cancel_modal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" id="cancel_modal_header">
                        <h5 class="modal-title" id="cancelModalLabel">Leave changes?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="cancel_modal_body">
                        Details will not be saved. Do you wish to cancel the transaction?
                    </div>
                    <div class="modal-footer" id="cancel_modal_footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-danger" id="confirm_cancel">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end cancel modal -->
        <!-- start form -->
        <div class="container box p-3 border mb-5">
            <h3>Health Declaration Form</h3>
            <hr>
            <input type="hidden" id="EMP_CODE" name="EMP_CODE" value="<?php echo $_SESSION['EMP_CODE']; ?>" />
            <input type="hidden" id="LOGIN_ID" name="LOGIN_ID" value="<?php echo $_SESSION['LOGIN_ID']; ?>" />
            <form id="table_form">
                <div id="tbl_div">
                    <div class="form-group">
                        <button class="btn btn-primary" type="button" id="tbl_add" disabled>Add</button>
                        <button class="btn btn-primary" type="button" id="tbl_edit">Edit</button>
                        <button class="btn btn-primary" type="button" id="tbl_view">View</button>
                    </div>
                    <h5>Health Declaration History</h5>
                    <hr>
                    <table class="table table-striped table-bordered" id="hdf_tbl" style="width:100%">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Health Declaration Date</th>
                                <th>Completion Date & Time</th>
                                <th style="width: 600px;">Had fever for the last 14 days?</th>
                                <th style="width: 600px;">Travel History and/or History of Exposure?</th>
                                <th>Place of Travel</th>
                                <th>With Scheduled Trip for the next 3 months?</th>
                                <th>Travel Date</th>
                                <th>Place of Travel</th>
                                <th>Rush No.</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </form>
            <div id="form_div">
                <?php echo form_open('', array( 'id' => 'hdf_form', 'class' => 'needs-validation', 'novalidate' => true));?>
                   
                <div id="form_area" class='form-group'>
                    <div class='form-group'>
                        <input type="hidden" id="hdf_id" name="hdf_id" disabled />
                        <input type="hidden" id="cutoff_id" name="cutoff_id" />
                            <div class="accordion" id="hdf_accordion">
                                <div class="card">
                                    <div class="card-header" id="emp_dtls_header">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#emp_dtls_body" aria-expanded="true" aria-controls="emp_dtls_body">
                                                Employee Details Header
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="emp_dtls_body" class="collapse show" aria-labelledby="emp_dtls_header" data-parent="#hdf_accordion">
                                        <div class="card-body" id="emp_dtls_form_area">
                                            <div class='form-group'>
                                                <div class='form-row'>
                                                    <div class='col-6'>
                                                        <div class='form-group'>
                                                            <label for='EMP_LNAME'>Last Name</label>
                                                            <input readonly type='text' class='form-control' id='EMP_LNAME' name='EMP_LNAME' required>
                                                            <div class='invalid-feedback'>
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='col-6'>
                                                        <div class='form-group'>
                                                            <label for='EMP_FNAME'>First Name</label>
                                                            <input readonly type='text' class='form-control' id='EMP_FNAME' name='EMP_FNAME' required>
                                                            <div class='invalid-feedback'>
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='form-row'>
                                                    <div class='col-6'>
                                                        <div class='form-group'>
                                                            <label for='EMP_AGE'>Age</label>
                                                                <input readonly type='text' class='form-control' id='EMP_AGE' name='EMP_AGE' required>
                                                            <div class='invalid-feedback'>
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='col-6'>
                                                        <div class='form-group'>
                                                        <label for='EMP_GENDER'>Gender</label>
                                                            <select disabled id='EMP_GENDER' name='EMP_GENDER' class='custom-select' required>
                                                                <option disabled selected>Please choose</option>
                                                                <option value='MALE'>Male</option>
                                                                <option value='FEMALE'>Female</option>
                                                            </select>
                                                            <div class='invalid-feedback'>
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='form-row'>
                                                    <div class='col-6'>
                                                        <div class='form-group'>
                                                            <label for='CIVIL_STAT'>Civil Status</label>
                                                            <select id='CIVIL_STAT' name='CIVIL_STAT' class='custom-select' required>
                                                                <option disabled selected>Please choose</option>
                                                                <option value='SINGLE'>Single</option>
                                                                <option value='MARRIED'>Married</option>
                                                                <option value='WIDOWED'>Widowed</option>
                                                                <option value='SEPARATED'>Separated</option>
                                                                <option value='DIVORCED'>Divorced</option>
                                                                <option value='WITH LIVE-IN PARTNER'>With Live-in Partner</option>
                                                            </select>
                                                            <div class='invalid-feedback'>
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class='form-row'>
                                                        <div class='col-6'>
                                                            <h6>Provincial Address</h6>
                                                            <small class="text-muted">Put N/A if not applicable.</small>
                                                        </div>
                                                    </div>
                                                    <div class='form-row'>
                                                        <div class='col-6'>
                                                            <div class='form-group'>
                                                                <label for='PERM_CITY'>City</label>
                                                                <input type='text' class='form-control' id='PERM_CITY' name='PERM_CITY' maxlength="50" required>
                                                                <div class='invalid-feedback'>
                                                                    This field is required.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='col-6'>
                                                            <div class='form-group'>
                                                                <label for='PERM_PROV'>Province</label>
                                                                <input type='text' class='form-control' id='PERM_PROV' name='PERM_PROV' maxlength="50" required>
                                                                <div class='invalid-feedback'>
                                                                    This field is required.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='form-row'>
                                                    <div class='col-6'>
                                                        <h6>Present Address/Home Address</h6>
                                                        <small class="text-muted">Put N/A if not applicable.</small>
                                                    </div>
                                                </div>
                                                <div class='form-row'>
                                                    <div class='col-6'>
                                                        <div class='form-group'>
                                                            <label for='ADDRESS1'>Street No. and Name</label>
                                                            <input type='text' class='form-control' id='PRESENT_ADDR1' name='PRESENT_ADDR1' maxlength="50" required>
                                                            <div class='invalid-feedback'>
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='col-6'>
                                                        <div class='form-group'>
                                                            <label for='PRESENT_ADDR2'>Village/Town/Municipality</label>
                                                            <input type='text' class='form-control' id='PRESENT_ADDR2' name='PRESENT_ADDR2' maxlength="50" required>
                                                            <div class='invalid-feedback'>
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='form-row'>
                                                    <div class='col-6'>
                                                        <div class='form-group'>
                                                            <label for='PRESENT_CITY'>City</label>
                                                            <input type='text' class='form-control' id='PRESENT_CITY' name='PRESENT_CITY' maxlength="50" required>
                                                            <div class='invalid-feedback'>
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='col-6'>
                                                        <div class='form-group'>
                                                            <label for='PRESENT_PROV'>Province</label>
                                                            <input type='text' class='form-control' id='PRESENT_PROV' name='PRESENT_PROV' maxlength="50" required>
                                                            <div class='invalid-feedback'>
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='form-row'>
                                                    <div class='col-6'>
                                                        <div class='form-group'>
                                                            <label for='TEL_NO'>Telephone Number</label>
                                                            <input type='text' class='form-control' id='TEL_NO' name='TEL_NO' onkeydown="return validateTel(event)" maxlength="10">
                                                        </div>
                                                    </div>
                                                    <div class='col-6'>
                                                        <div class='form-group'>
                                                            <label for='MOBILE_NO'>Mobile Number</label>
                                                            <input type='text' class='form-control' id='MOBILE_NO' name='MOBILE_NO' onkeydown="return isNumber(event)" minlength="11" maxlength="11" required>
                                                            <div class='invalid-feedback' id='mobile_err_msg'>
                                                                Invalid Mobile Number: Please input 11 digits.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='form-row'>
                                                    <div class='col-6'>
                                                        <div class='form-group'>
                                                            <label for='COMP_CODE'>Company</label>
                                                            <select disabled id='COMP_CODE' name='COMP_CODE' class='custom-select' required>
                                                                <option disabled selected>Please choose</option>
                                                                <option value='FLI'>FLI</option>
                                                                <option value='FPMC'>FPMC</option>
                                                                <option value='FHI'>FHI</option>
                                                                <option value='Federal Retail'>Federal Retail</option>
                                                                <option value='Horizon Land'>Horizon Land</option>
                                                                <option value='STRC'>STRC</option>
                                                                <option value='BLRDC'>BLRDC</option>
                                                                <option value='OTHER'>Other</option>
                                                            </select>
                                                            <div class='invalid-feedback'>
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='col-6'>
                                                        <div class='form-group'>
                                                            <label for='GRP_CODE'>Group</label>
                                                            <select disabled id='GRP_CODE' name='GRP_CODE' class='custom-select' required>
                                                                <option disabled selected>Please choose</option>
                                                                <!-- <option value='AUDIT'>Audit</option>
                                                                <option value='CMG'>CMG</option>
                                                                <option value='EO'>Executive Office</option>
                                                                <option value='FIN'>Finance</option>
                                                                <option value='HR'>Human Resources</option>
                                                                <option value='IT'>Information Technology</option>
                                                                <option value='LSNG'>Leasing</option>
                                                                <option value='LEG'>Legal</option>
                                                                <option value='MRKT'>Marketing</option>
                                                                <option value='OPS'>Operations</option>
                                                                <option value='PERM'>Permits</option>
                                                                <option value='PDG'>PDG</option>
                                                                <option value='PUR'>Purchasing</option>
                                                                <option value='QSCM'>QS & Cost Management</option>
                                                                <option value='SALES'>Sales</option>
                                                                <option value='TOWN'>Township</option>
                                                                <option value='OTHER'>Other</option> -->
                                                            </select>
                                                            <div class='invalid-feedback'>
                                                                This field is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="hh_dtls_header">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#hh_dtls_body" aria-expanded="false" aria-controls="hh_dtls_body">
                                                Household Details
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="hh_dtls_body" class="collapse" aria-labelledby="hh_dtls_header" data-parent="#hdf_accordion">
                                        <div class="card-body" id="hh_dtls_form_area">
                                            <div class="form-group">
                                                
                                                <div id="hdfhh_form_area">
                                                    <!-- insert fields using js -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="health_dec_header">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#health_dec_body" aria-expanded="false" aria-controls="health_dec_body">
                                                Health Declaration
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="health_dec_body" class="collapse" aria-labelledby="health_dec_header" data-parent="#hdf_accordion">
                                        <div class="card-body" id="health_dec_form_area">
                                            <div class="form-group">
                                                <div id="hdfhd_form_area">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="history_header">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#history_body" aria-expanded="false" aria-controls="history_body">
                                                Travel History and/or History of Exposure
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="history_body" class="collapse" aria-labelledby="history_header" data-parent="#hdf_accordion">
                                        <div class="card-body" id="history_form_area">
                                            <div class="form-group">
                                                <div id="hdfth_form_area">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="consent_header">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#consent_body" aria-expanded="false" aria-controls="consent_body">
                                                Employee Declaration
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="consent_body" class="collapse" aria-labelledby="consent_header" data-parent="#hdf_accordion">
                                        <div class="card-body" id="consent_form_area">
                                        <div class="form-group">
                                                <div id="hdfoi_form_area">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='form-row text-center'>
                            <div class='col-12'>
                                <div class='form-group'>
                                    <button id='submit' type='button' class='btn btn-primary'>Submit</button>
                                    <button id='cancel' type='button' class='btn btn-danger'>Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close();?>
            <div id="view_div">
                <div id="form_area" class='form-group'>
                    <div class='form-group'>
                        <input type="hidden" id="hdf_id" name="hdf_id" disabled />
                        <input type='hidden' id='hdf_date' value=''>
                        <div class="accordion" id="hdf_accordion">
                            <div class="card">
                                <div class="card-header" id="emp_dtls_header">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#emp_dtls_body" aria-expanded="true" aria-controls="emp_dtls_body">
                                            Employee Details Header
                                        </button>
                                    </h2>
                                </div>
                                <div id="emp_dtls_body" class="collapse show" aria-labelledby="emp_dtls_header" data-parent="#hdf_accordion">
                                    <div class="card-body" id="emp_dtls_form_area">
                                        <div class='form-group'>
                                            <div class='form-row'>
                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <label for='EMP_LNAME'>Last Name:</label>
                                                        <div id="VIEW_EMP_LNAME"></div>
                                                    </div>
                                                </div>
                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <label for='EMP_FNAME'>First Name:</label>
                                                        <div id="VIEW_EMP_FNAME"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='form-row'>
                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <label for='EMP_AGE'>Age:</label>
                                                        <div id="VIEW_EMP_AGE"></div>
                                                    </div>
                                                </div>
                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <label for='EMP_GENDER'>Gender:</label>
                                                        <div id="VIEW_EMP_GENDER"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='form-row'>
                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <label for='CIVIL_STAT'>Civil Status:</label>
                                                        <div id="VIEW_CIVIL_STAT"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class='form-row'>
                                                <div class='col-6'>
                                                    <h6>Provincial Address</h6>
                                                </div>
                                            </div>
                                            <div class='form-row'>
                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <label for='PERM_CITY'>City:</label>
                                                        <div id="VIEW_PERM_CITY"></div>
                                                    </div>
                                                </div>
                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <label for='PERM_PROV'>Province:</label>
                                                        <div id="VIEW_PERM_PROV"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='form-row'>
                                                <div class='col-6'>
                                                    <h6>Present Address/Home Address</h6>
                                                </div>
                                            </div>
                                            <div class='form-row'>
                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <label for='ADDRESS1'>Street No. and Name:</label>
                                                        <div id="VIEW_PRESENT_ADDR1"></div>
                                                    </div>
                                                </div>
                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <label for='PRESENT_ADDR2'>Village/Town/Municipality:</label>
                                                        <div id="VIEW_PRESENT_ADDR2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='form-row'>
                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <label for='PRESENT_CITY'>City:</label>
                                                        <div id="VIEW_PRESENT_CITY"></div>
                                                    </div>
                                                </div>
                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <label for='PRESENT_PROV'>Province:</label>
                                                        <div id="VIEW_PRESENT_PROV"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='form-row'>
                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <label for='TEL_NO'>Telephone Number:</label>
                                                        <div id="VIEW_TEL_NO"></div>
                                                    </div>
                                                </div>
                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <label for='MOBILE_NO'>Mobile Number:</label>
                                                        <div id="VIEW_MOBILE_NO"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='form-row'>
                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <label for='COMP_CODE'>Company:</label>
                                                        <div id="VIEW_COMP_CODE"></div>
                                                    </div>
                                                </div>
                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <label for='GRP_CODE'>Group:</label>
                                                        <div id="VIEW_GRP_CODE"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="hh_dtls_header">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#hh_dtls_body" aria-expanded="false" aria-controls="hh_dtls_body">
                                            Household Details
                                        </button>
                                    </h2>
                                </div>
                                <div id="hh_dtls_body" class="collapse" aria-labelledby="hh_dtls_header" data-parent="#hdf_accordion">
                                    <div class="card-body" id="hh_dtls_form_area">
                                        <div class="form-group">
                                            <div id="hdfhh_view_area">
                                                <!-- insert fields using js -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="health_dec_header">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#health_dec_body" aria-expanded="false" aria-controls="health_dec_body">
                                            Health Declaration
                                        </button>
                                    </h2>
                                </div>
                                <div id="health_dec_body" class="collapse" aria-labelledby="health_dec_header" data-parent="#hdf_accordion">
                                    <div class="card-body" id="health_dec_form_area">
                                        <div class="form-group">
                                            <div id="hdfhd_view_area">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="history_header">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#history_body" aria-expanded="false" aria-controls="history_body">
                                            Travel History and/or History of Exposure
                                        </button>
                                    </h2>
                                </div>
                                <div id="history_body" class="collapse" aria-labelledby="history_header" data-parent="#hdf_accordion">
                                    <div class="card-body" id="history_form_area">
                                        <div class="form-group">
                                            <div id="hdfth_view_area">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="consent_header">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#consent_body" aria-expanded="false" aria-controls="consent_body">
                                            Employee Declaration
                                        </button>
                                    </h2>
                                </div>
                                <div id="consent_body" class="collapse" aria-labelledby="consent_header" data-parent="#hdf_accordion">
                                    <div class="card-body" id="consent_form_area">
                                        <div class="form-group">
                                                <div id="hdfoi_view_area">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='form-row text-center'>
                            <div class='col-12'>
                                <div class='form-group'>
                                    <button id='cancel_view' type='button' class='btn btn-danger'>Back</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end form -->
<footer class="text-center border border-grey border-bottom-0 border-left-0 border-right-0 p-2">
    <a href="#!" class="toTop font-weight-bolder text-decoration-none text-dark">^</a><br>
    <small class="font-weight-bold mb-0">Employee Tracking System version <?= APP_VERSION ?></small><br>
    <small>Copyright © 2020 Federal Land Inc.</small><br>
</footer>
<!-- Script Links -->
<script src="dist/js/jquery-3.4.1.min.js"></script>
<script src="dist/js/popper.min.js"></script>
<script src="dist/bootstrap/js/bootstrap.min.js"></script>
<script src="dist/js/jquery.form.validator.min.js"></script> 
<script src="dist/custom_js/hdf.js"></script>
<script type="text/javascript" src="dist/DataTables/datatables.min.js"></script>
<script type="text/javascript" src="dist/DataTables/dataTables.bootstrap4.min.js"></script> 
<script src="dist/custom_js/login.js"></script>
<script src="dist/custom_js/ets.js"></script>
<script src="dist/custom_js/custom.js"></script>
<!-- End -->

<!-- VIEL 05182020 -->
<script type="text/javascript">
  function hasValue(elem) {
    return $(elem).filter(function() { return $(this).val(); }).length > 0;
}

function validate_password() {
 if (hasValue('#current_pass') <= 0 || hasValue('#new_pass') <= 0 || hasValue('#confirm_pass') <= 0 ) {
    alert('Please fill out the required field to proceed.');
  } else {

      $ajaxData = $.ajax({
      url: "<?= base_url('api/check_password') ?>",
      method: "GET",
      data: {
        password : $("#current_pass").val()
      },
      dataType: "html",
      success:function(data){
        // check current pass if true
        if(data == 'true') {
          if ($("#new_pass").val() == $("#confirm_pass").val()){
             $('#change_pw_form').submit();
          } else {
            // not equal new pass and confirm pass
            alert('New Password you have entered does not matched. ');
          }
        } else {
          alert('Current Password is incorrect. ');
        }
      }

    });
  }
 
}
</script>
<!-- END 05182020 -->

</body>
</html>
