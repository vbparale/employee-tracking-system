<link rel="stylesheet" href="dist/custom_css/multiselect.css"/>
<link rel="stylesheet" href="dist/custom_css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="dist/dataTables/dataTables.bootstrap4.min.css">
<style type="text/css">
  table.dataTable tbody tr.selected {
    color: #007bff !important;
    background-color: #eeeeee !important;
}

table td {
  word-wrap: break-word;
  max-width: 400px;
}

table {
 /*  table-layout:fixed; */
  font-size: 15px;
  table-layout: auto;
}

.bs-example{
    margin: 60px;
    position: relative;
}


</style>
    <div class="col-md-12 col-lg-12" style="padding: 20px;">
        <div class="container box p-3 border mb-5">
            <!-- start form -->
            <h3>Visitor's Log</h3>
            <hr>
            <?= form_open('visitor/search_CheckOut' , ['id' => 'formSearch', 'role' => 'form' ]); ?>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="inputVisitorName" name ="inputVisitorName">Visitor's Name</label>
                            <input type="text" class="form-control" id="inputVisitorName" name = "inputVisitorName" aria-describedby="inputVisitorName" placeholder="Enter visitor's name">
                            <!--  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="inputPersonToVisitSearch">Person to Visit(Host)</label>
                            <select class="auto-select form-control" id="inputPersonToVisitSearch" name="inputPersonToVisitSearch">
                               <option value=""> -- Please Choose --</option>
                            <?php foreach($employee as $emp): ?>
                                <?php  if($visitor->PERS_TOVISIT == $emp->EMP_CODE){ $text="selected"; } else{ $text=''; } ?> 
                                <option value="<?= $emp->EMP_CODE; ?>" <?= $text ?>><?= $emp->EMP_FULLNAME; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="controlSelectStatus">Status</label>
                            <select class="form-control" id="controlSelectStatus" name="controlSelectStatus">
                            <option value = '0'>-Please Choose-</option>
                            <option value = '1'>For Confirmation</option>
                            <option value = '2'>Confirmed</option>
                            <option value = '3'>On-going</option>
                            <option value = '4'>Denied</option>
                            <option value = '5'>Done</option>
                            <option value = '6'>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="datefilter">Period (From - To)</label>
                            <input type="text" class="form-control" name="datefilter" id="datefilter" value="" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="inputMeetingID">Meeting ID</label>
                            <input type="text" class="form-control" id="inputMeetingID" name ="inputMeetingID" placeholder="Enter meeting ID">
                        </div>
                    </div>
                <?= form_close() ?>

                <div class="row">
                    <div class="col-md-4 mb-3">
                    <button type="button" class="btn btn-dark" onClick="search_activities()"><span class="fa fa-search"></span>Search</button>
                    <button type="button" class="btn btn-danger" id='btnClear' onClick="clear_button()"><span class="fa fa-eraser" ></span>Clear</button>
                    </div>
                </div>

            
            <!-- end form -->
          <!--   <div class="toast" id="myToast"  style="position: absolute; top: 20px; right: 50px;" data-delay="1000">
                <div class="toast-header">
                    <strong class="mr-auto"><i class="fa fa-grav"></i>System Message</strong>
                    <small>Just Now</small>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    <div>Data was successfully update. Thank you!</div>
                </div>
            </div>  -->     



            <!-- start visitor table checkin checkout section -->
                <div class="container box p-3 border mb-5">
                    <h4><i class="fa fa-check-square" aria-hidden="true"></i> Visitor Check In/Check Out</h4>
                    <hr>
                    <table class="table table-bordered display w-100 p-3" id="tableChckInOut">
                    <thead>
                        <tr>
                            <th>Meeting ID</th>
                            <th>Date of Visit</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Visitor's Name</th>
                            <th>Person to Visit</th>
                            <th>Purpose of Visit</th>
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    </table>
                    <!-- <button type="submit" class="btn btn-dark" data-toggle="modal" data-target="#chckoutModal">Check In</button> -->
                    <!--   <button type="submit" class="btn btn-outline-dark" data-toggle="modal" data-target="#chckoutModal">Check out</button>			 -->
                </div>
            <!-- end visitor table checkin checkout section -->

            <!-- start visitor table log section -->
             <div class="container box p-3 border mb-5">
                    <h4><i class="fa fa-th-list" aria-hidden="true"></i> Visitor's Log</h4>
                    <hr>
                    <table class="table table-bordered display w-100 p-3" id="tableVisitorLog" >
                    <thead>
                        <tr>
                            <th>Meeting ID</th>
                            <th>Date of Visit</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Visitor's Name</th>
                            <th>Person to Visit</th>
                            <th>Purpose of Visit</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    </table>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus" aria-hidden="true"></i>Add</button>
             </div> 
            <!-- End visitor table log section -->

            <!-- Load Modal -->
            <?= $this->load->view('pages/modals/vl_add_view', '', TRUE) ?>
            <!-- End Load Modal -->

            <div id= "show_modal"></div>
            
            <!-- Modal System message-->
            <div class="modal fade" id="ModalMessage" tabindex="-1" role="dialog" aria-labelledby="ModalMessageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalMessageModalLabel">Employee Tracking System</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Record was successfully saved. Thank you!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                </div>
                </div>
            </div>
            </div>                    
    </div>

    <!-- Modal For System Message -->
    <div class="modal fade" id="SystemMessageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            ...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
    </div>
    

    <!-- For Date picker range -->  
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- For bootstrap -->  
    <script src="dist/js/popper.min.js"></script>
    <script src="dist/bootstrap/js/bootstrap.min.js"></script> 


    <!-- jQuery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <!-- Data table UI -->  
    <script type="text/javascript" src="dist/DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="dist/DataTables/dataTables.bootstrap4.min.js"></script>


    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="dist/vl_scripts/custom_vl_scripts.js"></script>
    <script src="dist/custom_js/selectize.min.js"></script>

    <script type="text/javascript">
        $(function() {
            /* For Date range on the Search Section */
            $('input[name="datefilter"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
            });

            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            /* End For Date range on the Search Section */

            /* For Date range on the date end and start sickness */
            $('input[name="inputStartEndDate"]').daterangepicker({
                autoUpdateInput: false,
                maxDate: new Date(),
                drops: 'up',
                locale: {
                    cancelLabel: 'Clear'
                }
            });


            /* For Date range Picker */
            $('input[name="inputStartEndDate"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });

            $('input[name="inputStartEndDate"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
             /* ENd For Date range Picker */

            /* Hide the input */
                $('#divSicknessOther').hide();
                $('#divSicknessDate').hide();
                $('#divTravel').hide();
                $('#divTravel2').hide();
                $('#divTravel3').hide();
            /* END Hide the input */ 


            /* Show input box base on the user selected answer YES/NO */
                $('#controlSelectStatusQ2').on('change', function() {
                    if ( this.value == 1){
                        $('#divTravel').show();
                        $('#divTravel2').show();
                        $('#divTravel3').show();
                    }else{
                        $('#divTravel').hide();
                        $('#divTravel2').hide();
                        $('#divTravel3').hide();
                    }
                });
            /* End input box base on the user selected answer */
                
            /* Show input box base on the user selected answer sickness */
            $('#controlSelectStatusQ1').on('change', function() {
                
                var $select = $('#controlSelectStatusQ1').selectize();
                var control = $select[0].selectize;
                var sickness = [];
            
                
                $.each($(".auto-select option:selected"), function(){            
                    sickness.push($(this).val());
                }); 
        
                if(sickness.includes("11")){
                    $('#divSicknessOther').hide();
                    $('#divSicknessDate').hide();
                    $('#controlSelectStatusQ1')[0].selectize.removeItem("1");
                    $('#controlSelectStatusQ1')[0].selectize.removeItem("2");
                    $('#controlSelectStatusQ1')[0].selectize.removeItem("3");
                    $('#controlSelectStatusQ1')[0].selectize.removeItem("4");
                    $('#controlSelectStatusQ1')[0].selectize.removeItem("5");
                    $('#controlSelectStatusQ1')[0].selectize.removeItem("6");
                    $('#controlSelectStatusQ1')[0].selectize.removeItem("7");
                    $('#controlSelectStatusQ1')[0].selectize.removeItem("8");
                    $('#controlSelectStatusQ1')[0].selectize.removeItem("9");
                    $('#controlSelectStatusQ1')[0].selectize.removeItem("10");
                    $('#controlSelectStatusQ1')[0].selectize.removeItem("12");
                    $('#controlSelectStatusQ1')[0].selectize.addItem("11");
                }else {
                    $('#controlSelectStatusQ1')[0].selectize.removeItem("11");
                    $('#divSicknessDate').show();
                    $('#divSicknessOther').hide();
                }
                        

                /* For other sickness selected value */
                    if (jQuery.inArray( "12", sickness ) >= 0){
                        $('#divSicknessOther').show();
                        $('#divSicknessDate').show();
                    }else{
                        $('#divSicknessOther').hide();
                    }
                /* End For other sickness selected value */
            
            });
            /* End input box base on the user selected answer */

            /* Multi Select function */
            $('.multiselect-ui').selectize({
                plugins: ['remove_button'],
                delimiter: ',',
                persist: false
            });

            $('.auto-select').selectize({
                sortField: 'text'
            });
            /* End Multi Select function */


            function view_visitor_logs(id) {
                $ajaxData = $.ajax({
                    url: "<?= base_url('visitor/view_visitor_logs') ?>",
                    method: "GET",
                    data: {
                        id : id
                    },
                    dataType: "html",
                    success:function(data){
                        $('#view_edit_visitor_log').modal('show');
                    }
                });
            }

            /* To remove the selected employee to the Other participant when the employee selected as host employee */
            //$('#inputHost').data('pre', $(this).val());
            $('#inputPart').change(function(e){
             /*    var before_change_code = $(this).data('pre');//get the pre data
                $(this).data('pre', $(this).val());//update the pre data

                var emp_code = $( "#inputHost option:selected" ).val();
                var $select = $('#inputPart').selectize();
                var control = $select[0].selectize;
                control.removeOption(emp_code);
    
                if(before_change_code != undefined){
                    control.addOption({value: before_change_code, text: before_change_code});
                } */
                var PartEmployee = $('#inputPart').val();
                if($('#inputPart').val().includes($("#inputHost").val())){
                    alert('Host Employee cannot be participant please select other employee.');
                    var $select = $('#inputPart').selectize();
                    var control = $select[0].selectize;
                    control.clear();
                }
            })
            /* End To remove the selected employee to the Other participant when the employee selected as host employee */

            $('#inputHost').change(function(e){
                if($('#inputPart').val().includes($("#inputHost").val())){
                    alert('Participant employee cannot be participant please select other employee.');
                    var $select = $('#inputHost').selectize();
                    var control = $select[0].selectize;
                    control.clear();
                }
            })
          
        });
    </script>
        
<footer class="text-center border border-grey border-bottom-0 border-left-0 border-right-0 p-2">
        <a href="#!" class="toTop font-weight-bolder text-decoration-none text-dark">^</a><br>
        <small class="font-weight-bold mb-0">Employee Tracking System version <?= APP_VERSION ?></small><br>
        <small>Copyright © 2020 Federal Land Inc.</small><br>
</footer>
    