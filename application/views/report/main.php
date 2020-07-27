<!-- Style sheet links: A -->
    <link rel="stylesheet" href="<?= base_url('dist/DataTables/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('dist/DataTables/Buttons-1.6.1/css/buttons.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('dist/DataTables/Responsive-2.2.3/css/responsive.bootstrap4.min.css') ?>">
    <style>
        th,tr{
            font-size: 12px;
        }   
    </style>
<!-- End: A -->
<div class="report_panel card border-primary" style="display:none">
    <div class="card-header bg-primary text-white">
        <h2>Reports</h2>
        <a href="#!"><button class="collapser btn btn-light btn-sm btn-block" style="display:none">Search New</button></a>
    </div>
    <div class="card-body" id="main_collapse">
        <?= form_open('reports')?>
            <div class="row form-group">
                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                    <?= form_label('Company','COMP_CODE') ?>
                    <?= form_dropdown('COMP_CODE',$company_list,'',['id' => 'COMP_CODE','class' => 'form-control','data-uri' => base_url('employees')]) ?>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                    <?= form_label('Group','GRP_CODE') ?>
                    <?= form_dropdown('GRP_CODE',$group_list,'',['id' => 'GRP_CODE','class' => 'form-control','data-uri' => base_url('employees')]) ?>
                </div>                
            </div>
            <div class="row mt-2 form-group">
                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                    <?= form_label('Employee','EMP_CODE') ?>
                    <?= form_dropdown('EMP_CODE',$employee_list,'',['id' => 'EMP_CODE','class' => 'form-control']) ?>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                    <?= form_label('Report Type','report_type') ?>
                    <?= form_dropdown('report_type',$report_list,'',['id' => 'report_type','class' => 'form-control','data-uri' => base_url('reports')]) ?>                     
                </div>                
            </div>
            <hr>
            <div class="row mt-2 form-group" id="dateFields">
                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                    <?= form_label('Date From','date_start') ?>
                    <input type="date" class="form-control" id="date_start" name="date_start" placeholder="" value="">
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                    <?= form_label('Date To','date_end') ?>
                    <input type="date" class="form-control" id="date_end" name="date_end" placeholder="" value="">
                </div>                
            </div>
            <div class="mb-2" id="specials" style="display:none">
                                                   
            </div>
            <hr>            
            <div class="row mt-2 form-group">
                <div class="col-9 col-sm-10 col-md-10 col-lg-10">
                    <?= form_submit('submit','Generate',['class' => 'generate_report btn btn-primary btn-sm btn-block']); ?>
                </div>
                <div class="col-3 col-sm-2 col-md-2 col-lg-2">
                    <a href="<?= base_url('reports') ?>"><button class="clear_form btn btn-outline-default btn-sm border-dark btn-block">Clear</button></a>
                </div>                
            </div>            
        <?= form_close() ?>
    </div>
</div>
<!-- Script Links: C -->

    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.4/b-flash-1.5.4/b-html5-1.5.4/b-print-1.5.4/datatables.min.js"></script>
<!-- End: D -->
<!-- End: C -->
<script src="dist/custom_js/report.js"></script>