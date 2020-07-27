<div class="card">
    <div class="card-header bg-info text-white">
        <h4 class="text-center" id="export_title">Health Declaration per Employee</h4>
        <p class="mt-0 text-center" id="export_date"><?= ($form_input['cut_off'] != 0 ? 'as of '.date("F d, Y",strtotime($form_input['cut_off'])) : '') ?></p>
    </div>    
    <div class="card-body">
        <p>Export Options</p>
        <a href="<?= $export_uri ?>"><button class="export_excel btn btn-success btn-sm">Excel</button></a>
        <hr>    
        <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%" data-uri="<?= $data_uri ?>" id="hdf_table">
        <thead>        
            <tr>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Civil Status</th>
                <th>Provinical Address</th>
                <th>Present Address/Home Address</th>
                <th>Telephone Number</th>
                <th>Mobile Number</th>
                <th>Company</th>
                <!-- -->
                <th>Group</th>
                <th>Type of current residence</th>
                <th>If Renting, How often do you<br>go to your permanent address</th>
                <th>Total number of person<br>in your households</th>
                <th>Persons in your household<br>with ages 51 and above</th>
                <th>Live with someone diagnosed<br>with chronic diseases</th>
                <th>Do you share room with others?</th>
                <th>If yes, how many are you?</th>
                <th>Fever in the last 14 days?</th>
                <th>If yes, Indicate Body temperature?</th>
                <!-- -->
                <th>Do you have the following<br>signs and symptoms?</th>
                <th>If yes, date when it started and ended</th>
                <th>What medications did you take?</th>
                <th>Which of the following you have had, or been<br>told you had, or sought advice or treatment for:</th>
                <th>For the past 6 months,<br>have you consulted a medical doctor</th>
                <th>If yes, Specify the reason<br>of the medical test</th>
                <th>Any health symptoms, recurring or persistent pains, or complaints<br>for which physician has not been consulted or treatment has not been received?</th>
                <th>If Yes, Specify the symptoms/recurring pain/complaints,<br>and the period of sickness</th>
                <th>Travelled from a locations with documented cases of COVID19?</th>
                <th>State the exact place of travel</th>
                <!-- -->
                <th>Exact place of travel</th>
                <th>Date of return to PH/Metro Manila</th>
                <th>Scheduled trip abroad or local for the next 3 months?</th>
                <th>If yes, please state travel dates</th>
                <th>Exact place of travel</th>
                <th>Date of return to PH/Metro Manila</th>
                <th>Close contact to a PUI or confirmed case of the disease (COVID 19)?</th>
                <th>If yes, please state date of contact</th>
                <th>History of visit to a HEALTHCARE facility<br>in a geographic location/country where documented<br>cases of COVID19 have been reported?</th>
                <th>If yes, state the name of the Healthcare facility</th>
                <!-- -->
                <th>Date visited</th>
                <th>Exposure with patients who are Probable<br>COVID19 patients who are awaiting results</th>
                <th>If Yes, please state the details of exposure</th>
                <th>Exposure from Relatives or Friends with recent travel<br>to location/country with documented cases of COVID19<br>and/or had direct exposure with confirmed COVID19 case?</th>
                <th>If yes, State the date<br>of travel/exposure</th>
                <th>Any Signs/Symptoms experienced by the person/s?</th>
                <th>Have you recently traveled to an area with known local spread of Covid-19<br>(e.g. hospital, supermarket, drug store and etc)</th>
                <th>If yes, please state the exact place</th>
                <th>Are there any frontliners in your household?</th>
                <th>Type of Frontliner</th>
                <!-- -->
                <th>How often do you or your family member go out for i.e. for grocery shopping etc</th>
                <th>Who often goes out of the house?</th>
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

        let columns = [{

                targets: 20,
                visible: true,
                data: null,
                render: function(data,type,row,meta){
                    let res = JSON.parse(row[20])
                    
                    if (res) {
                        
                        return res;
                    } else {

                        return 'None'
                    }
                    
                }            
            },{

                targets: 23,
                visible: true,
                data: null,
                render: function(data,type,row,meta){

                    if (row[23]) {
                        
                        let res = JSON.parse(row[23]);

                        res = res.join('\n');
                        return res;

                    } else {

                        return 'None';
                    }
                }            
            },{

                targets: 45,
                visible: true,
                data: null,
                render: function(data,type,row,meta){

                    if (row[45]) {
                        
                        let res = JSON.parse(row[45]);

                        res = res.join('\n');
                        return res;

                    } else {

                        return 'None';
                    }
                }            
            },{

                targets: 49,
                visible: true,
                data: null,
                render: function(data,type,row,meta){

                    if (row[49]) {
                        
                        let res = JSON.parse(row[49]);

                        res = res.join('\n');
                        return res;

                    } else {

                        return 'None';
                    }
                }            
            }];

        let ssp = {

            url:url,
            columns:columns
        }

        let hdf_ssp = init_table('#hdf_table',ssp,title,"POST");
        
    });
</script>