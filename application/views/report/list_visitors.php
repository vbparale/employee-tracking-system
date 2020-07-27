<div class="card">
    <div class="card-header bg-info text-white">
        <h4 class="text-center" id="export_title">Visitor's Log Information</h4>
        <p class="mt-0 text-center" id="export_date"><?= ($form_input['date_start'] != 0 ? 'Period From '.date("F d, Y",strtotime($form_input['date_start'])).' to '.($form_input['date_end'] ? date("F d, Y",strtotime($form_input['date_end'])) : '') : '') ?></p>
        <hr>
        <div class="row">
            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                <p><span class="font-weight-bold">Employee No.</span>: <?= ($form_input['employee_code'] ? $form_input['employee_code'] : 'No Selected') ?></p>
                <p><span class="font-weight-bold">Employee Name</span>: <?= ($form_input['employee'] ? $form_input['employee'] : 'All Employee') ?></p>
            </div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                <p><span class="font-weight-bold">Company</span>: <?= ($form_input['company'] ? $form_input['company'] : 'All Company') ?></p>
                <p><span class="font-weight-bold">Group</span>: <?= ($form_input['group'] ? $form_input['group'] : 'All Groups') ?></p>
            </div>
        </div>
    </div>
    <div class="card-body">
        <p>Export Options</p>
        <a href="<?= $export_excel ?>"><button class="export_excel btn btn-success btn-sm">Excel</button></a>
        <hr>
        <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%" data-uri="<?= $data_uri ?>" id="visitors_table">
        <thead>     
            <tr>
                <th>Date of Visit</th>
                <th>Checkin Time</th>
                <th>Checkout Time</th>
                <th>Visitor's Name</th>
                <th>Company</th>
                <th>Company Address</th>
                <th>Email Address</th>
                <th>Mobile No</th>
                <th>Landline</th>
                <th>Residential Address</th>
                <th>Purpose of Visit</th>
                <th>Person to Visit</th>
                <th>Body Temperature</th>
                <th>Do you have the following<br>sickness/symptoms? </th>
                <th>Date when it started and ended?</th>
                <th>Travelled from a geographic location/country<br>with documented cases of COVID19?</th>
                <th>Travel Dates</th>
                <th>Exact Place of Travel</th>
                <th>Date of return to<br>PH/Metro Manila</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        </table>    
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        let url = $('table').attr('data-uri');

        let ssp = {

            url:url,
            columns:[]
        }

        let visitor_ssp = init_table('#visitors_table',ssp);
        
    });
</script>