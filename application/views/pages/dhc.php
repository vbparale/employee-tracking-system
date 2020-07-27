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
        <div class="modal fade" id="dhc_modal" tabindex="-1" role="dialog" aria-labelledby="modal_title" aria-hidden="true">
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
        <!-- start form -->
        <div class="container box p-3 border mb-5">
            <h3>Daily Health Check</h3>
            <hr>
            <form id="table_form">
                <div id="tbl_div">
                    <div class="form-group">
                        <button class="btn btn-primary" type="button" id="tbl_add" disabled>Add</button>
                        <button class="btn btn-primary" type="button" id="tbl_edit">Edit</button>
                        <button class="btn btn-primary" type="button" id="tbl_view">View</button>
                    </div>
                    <h5>Health Check History</h5>
                    <hr>
                    <table class="table table-striped table-bordered" id="dhc_tbl" style="width:100%">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Health Check Date</th>
                                <th>Completion Date & Time</th>
                                <th>Body Temperature</th>
                                <th>Rush.Net #</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </form>
            <div id="form_div">
                <?php echo form_open('', array( 'id' => 'dhc_form', 'class' => 'needs-validation', 'novalidate' => true));?>
                    <input type="hidden" name="ehc_id" id="ehc_id" disabled>
                    <div id="form_area">
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
                <?php echo form_close();?>
            </div>
            <div id="view_div">
                
                    <input type="hidden" name="ehc_id" id="ehc_id" disabled>
                    <div id="view_area">
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
        <!-- end form -->
        
