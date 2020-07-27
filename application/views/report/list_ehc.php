<div class="card border border-info">
    <div class="card-header bg-info text-white">
        <h4 class="text-center" id="export_title">Summary of Daily Health Check per Employee</h4>
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
        <a href="<?= $export_pdf ?>"><button class="export_pdf btn btn-danger btn-sm">PDF</button></a>
        <hr>
        <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%" data-uri="<?= $data_uri ?>" id="ehc_table">
        <thead>            
            <tr>
                <th>Health Check Date</th>
                <th>Completion Date and Time</th>
                <th>Body Temperature</th>
                <th>Feeling Sick today?</th>
                <th>Sickness/Symptoms?</th>
                <th>Travel outside</th>
                <th>Where</th>
                <th>When</th>
                <th>Close contact with positive CoViD Person and/or (PUI)?</th>
                <th>When</th>
                <th>Rush.Net #</th>
                <th>Reason</th>
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
        let title = $('#export_title').text()+`\n`+$('#export_date').text();

        let column = [];        

        let ssp = {

            url:url,
            columns: column
        }

        let ehc_ssp = init_table('#ehc_table',ssp,title);
        
    });
</script>