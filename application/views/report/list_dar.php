<div class="card">
    <div class="card-header bg-info text-white">
        <h4 class="text-center" id="export_title">Summary of Daily Activity Report per Employee</h4>
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
        <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%" data-uri="<?= $data_uri ?>" id="dar_table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time From</th>
                <th>Time To</th>
                <th>Activity Type</th>
                <th>Requester</th>
                <th>Participants</th>
                <th>Location</th>
                <th>Status</th>
                <th>Visitors</th>
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
        
        let column = [{

            targets: 5,
            visible: true,
            render: function(data,type,row,meta){
                
                let employees = (row[5] ? `<p><span class="font-weight-bold">Employees: </span>${row[5]}</p>` : '');
                let visitors = (row[8] ? `<p><span class="font-weight-bold">Visitors: </span>${row[8]}</p>` : '')

                let participants = employees+visitors;

                return participants;
            }
        },{

            targets: 8,
            visible: false,
            search: true

        }];
                 
        let ssp = {

            url:url,
            columns:column,

        }

        let dar_ssp = init_table('#dar_table',ssp,title);  
        
    });
</script>