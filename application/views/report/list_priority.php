<div class="card border-info">
    <div class="card-header bg-info text-white">
        <h4 class="text-center">Summary for Priority for Testing</h4>
        <p class="mt-0 text-center" id="export_date"><?= ($form_input['date_start'] != 0 ? 'Period From '.date("F d, Y",strtotime($form_input['date_start'])) : '') ?></p>
        <hr>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                <p><span class="font-weight-bold">Company</span>: <?= ($form_input['company'] ? $form_input['company'] : 'All Company') ?></p>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                <p><span class="font-weight-bold">Group</span>: <?= ($form_input['group'] ? $form_input['group'] : 'All Groups') ?></p>
            </div>            
        </div>
    </div>
    <div class="card-body">
        <p>Export Options</p>
        <a href="<?= $export_excel ?>"><button class="export_excel btn btn-success btn-sm">Excel</button></a>
        <a href="<?= $export_pdf ?>"><button class="export_pdf btn btn-danger btn-sm">PDF</button></a>        
        <hr>
        <table class="table table-striped table-bordered" style="width:100%" data-uri="#!" id="priority_table">
            <thead>
                <tr>
                    <th>Priority For Testing</th>
                    <th>Count</th>                
                </tr>
            </thead>
                <tbody>
                    <tr>
                        <td>
                        Those who are symptomatic, whether or not they had known contacts with confirmed COVID-19 patients. Here are the usual symptoms:
                            <ul>
                                <li>Dry cough</li>
                                <li>Sore throat</li>
                                <li>Muscle pain and weakness</li>
                                <li>Decreased ability to smell (this has been a common symptom reported)</li>
                                <li>Decreased ability to taste (less often than decreased ability to smell)</li>
                                <li>Diarrhea</li>
                                <li>Difficulty breathing (as soon as difficulty breathing occurs with the fever, then think COVID unless proven otherwise)</li>
                                <li>Conjunctivitis in the presence of persistent fever and/or any of the above symptoms. This has been reported in a few patients.</li> 
                            </ul>
                        </td>
                        <td>
                            <?= $priority[0]['symptomatic'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Employee with Fever (during the survey)
                        </td>
                        <td>
                            <?= $priority[0]['with_fever'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Employees who are high risk and asymptomatic. (e.g. senior citizens or those that are above 50 years old with those with co-morbidities<br>such as diabetes, hypertension chronic renal diseases and lung diseases, cancer patients on treatment, those with gross obesity with a BMI >/= 41,<br>and those on immunosuppressive medicines, etc.                        
                        </td>
                        <td>
                            <?= $priority[0]['asymptomatic'] ?>
                        </td>                    
                    </tr>
                    <tr>
                        <td>
                            Employees with age 50+ living with someone with co-morbidities
                        </td>
                        <td>
                            <?= $priority[0]['old_coMorbidities'] ?>
                        </td>                        
                    </tr>
                    <tr>
                        <td>
                            Employees living with Relatives with existing co-morbidities
                        </td>
                        <td>
                            <?= $priority[0]['coMorbidities'] ?>
                        </td>                        
                    </tr>
                    <tr>
                        <td>
                            Symptomatic or asymptomatic persons who live with or are in close contact with front liners i.e. Medical personnel, security, retail, package/food delivery personnel etc.
                        </td>
                        <td>
                            <?= $priority[0]['close_contact'] ?>
                        </td>                        
                    </tr>
                    <tr>
                        <td>
                            Employees with exposure with PUI, confirmed COVID19 patient
                        </td>
                        <td>
                            <?= $priority[0]['with_exposure'] ?>
                        </td>                        
                    </tr>                                                            
                </tbody>
        </table>
    </div>
</div>