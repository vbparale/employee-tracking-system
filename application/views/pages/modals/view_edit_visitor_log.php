<!-- Modal Adding visitor log -->
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditModalHeader">View</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBodyEdit">
            <?= form_open_multipart('visitor/add_visitor_log' , ['id' => 'fromEditVisitorLogModal', 'role' => 'form' ]); ?>
                    <label id="labelStatus"><?= $visitor->STATUS; ?></label>
                    <label id="labelStatusActivity"><?= $visitor->Act_status; ?></label>
                    <div class="form-group row">
                        <div class="col-md-12 mb-12">
                            <label for="EditdateOfVisit">Date of Visit</label>
                            <input type="hidden" class="form-control" id="visitorid" name = "visitorid" value="<?= $visitor->VISITOR_ID; ?>">
                            <input type="date" class="form-control" id="EditdateOfVisit" name ="EditdateOfVisit" value="<?= $visitor->VISIT_DATE; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 mb-6">
                            <label for="EditinputCheckIn">Check-In Time</label>
                            <input type="time" class="form-control" id="EditinputCheckIn" name="EditinputCheckIn" readonly value="<?= $visitor->CHECKIN_TIME; ?>">
                        </div>
                        <div class="col-md-6 mb-6">
                            <label for="EditinputCheckOut">Check-Out Time</label>
                            <input type="time" class="form-control" id="EditinputCheckOut" name="EditinputCheckOut" readonly value="<?= $visitor->CHECKOUT_TIME; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 mb-6">
                            <label for="EditinputTimeFrom">Time From</label>
                            <input type="time" class="form-control" id="EditinputTimeFrom" name="EditinputTimeFrom" value="<?= $visitor->TIME_FROM; ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-6">
                            <label for="EditinputTimeTo">Time To</label>
                            <input type="time" class="form-control" id="EditinputTimeTo" name="EditinputTimeTo" value="<?= $visitor->TIME_TO; ?>" readonly> 
                        </div>
                        <div class="col-md-12 mb-12">
                            <small id="EditinputTimeToWarning" class="text-danger" hidden>
                                <p id="text"><p>
                            </small> 
                        </div>  
                    </div>

                    <label>Visitor Name</label>

                    <div class="input-group ">
                        <div class="input-group-prepend">
                        </div>
                        <input type="text" class="form-control" placeholder="Last Name"  id="EditinputVisitorNameLN" name="EditinputVisitorNameLN" value="<?= $visitor->VISIT_LNAME; ?>" readonly onkeypress="return onlyAlphabets(event,this);">
                        <input type="text" class="form-control" placeholder="First Name"  id="EditinputVisitorNameFN" name="EditinputVisitorNameFN" value="<?= $visitor->VISIT_FNAME; ?>" readonly onkeypress="return onlyAlphabets(event,this);">
                        <input type="text" class="form-control" placeholder="Middle Name"  id="EditinputVisitorNameMN" name="EditinputVisitorNameMN" value="<?= $visitor->VISIT_MNAME; ?>" readonly onkeypress="return onlyAlphabets(event,this);">
                    </div>
                    <br>
                    <div class = "form-group row">
                        <div class="col-md-12 mb-12">
                            <label for="EditinputEmail">Email Address</label>
                            <input type="text" class="form-control" id="EditinputEmail" placeholder="Enter Email Address" name = "EditinputEmail"  value="<?= $visitor->EMAIL_ADDRESS; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 mb-6">
                            <label for="EditinputCompany">Company</label>
                            <input type="text" class="form-control" id="EditinputCompany" placeholder="Enter Company" name ="EditinputCompany" value="<?= $visitor->COMP_NAME; ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-6">
                            <label for="EditinputCompanyAdd">Company Address</label>
                            <input type="text" class="form-control" id="EditinputCompanyAdd" placeholder="Enter Company Address" name = "EditinputCompanyAdd"  value="<?= $visitor->COMP_ADDRESS; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 mb-6">
                            <label for="EditinputMobile">Mobile No.</label>
                            <input type="text" class="form-control" id="EditinputMobile" placeholder="Enter Mobile No. 09xxx" name = "EditinputMobile"  value="<?= $visitor->MOBILE_NO; ?>" readonly onkeypress='return restrictAlphabets(event)'>
                        </div>
                        <div class="col-md-6 mb-6">
                            <label for="EditinputLandline">Landline</label>
                            <input type="text" class="form-control" id="EditinputLandline" placeholder="Enter Landline" name = "EditinputLandline"  value="<?= $visitor->TEL_NO; ?>" readonly onkeypress='return restrictAlphabets(event)'>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12 mb-12">
                            <label for="EditinputResAdd">Residential Address</label>
                            <input type="text" class="form-control" id="EditinputResAdd" placeholder="Enter Residential Address" name = "EditinputResAdd"  value="<?= $visitor->RES_ADDRESS; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">    
                        <div class="col-md-12 mb-12">
                            <label for="EditinputHost">Person to Visit(Host)</label>
                            <select class="auto-select form-control" id="EditinputHost" name="EditinputHost" readonly>
                               <option value=""> -- Please Choose --</option>
                            <?php foreach($employee as $emp): ?>
                                <?php  if($visitor->PERS_TOVISIT == $emp->EMP_CODE){ $text="selected"; } else{ $text=''; } ?> 
                                <option value="<?= $emp->EMP_CODE; ?>" <?= $text ?>><?= $emp->EMP_FULLNAME; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                   <div class = "form-group row" >
                        <div class="col-md-12 mb-12">
                            <label for="EditinputPart">Others Participants</label>
                            <select class="multiselect-ui form-control" id="EditinputPart" name="EditinputPart[]" multiple="multiple">
                                <option value=""> -- Please Choose --</option>
                                <?php foreach ($employee as $user) : ?>
                                    <?php $text = ""; 
                                    if(in_array($user->EMP_CODE,$participants)){ $text="selected"; } ?>
                                    <option value="<?= $user->EMP_CODE ?>" <?= $text ?>><?= $user->EMP_LNAME ?>, <?= $user->EMP_FNAME ?></option>
                                <?php endforeach;?>
                            </select>   
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12 mb-12">
                            <label for="EditInputMeetingLocation">Meeting Location</label>
                            <input type="text" class="form-control" id="EditInputMeetingLocation" placeholder="Enter Meeting location" name = "EditInputMeetingLocation" value="<?= $visitor->Location; ?>" readonly>
                        </div>
                    </div>

                    <div class = "form-group row">
                        <div class="col-md-12 mb-12">
                        <label for="EditinputPurposeVisit">Purpose of Visit</label>
                            <textarea class="form-control" id="EditinputPurposeVisit" placeholder="Enter the purpose of visit" name = "EditinputPurposeVisit" readonly><?= $visitor->VISIT_PURP; ?></textarea>
                        </div>
                    </div>

                    <div class = "form-group row">
                        <div class="col-md-12 mb-12">
                            <label for="EditinputBodyTemp">Body Temperature</label>
                            <input type="text" class="form-control" id="EditinputBodyTemp" placeholder="Enter Body Temperature" name = "EditinputBodyTemp" value="<?= $visitor->A1; ?>" readonly>
                        </div>
                    </div>

                   <div class = "form-group row" >
                        <div class="col-md-12 mb-12" >
                            <label for="EditcontrolSelectStatusQ1">Do you have the following sickness/symptoms</label>
                            <select class="multiselect-ui form-control" id="EditcontrolSelectStatusQ1" name="EditcontrolSelectStatusQ1[]" multiple="multiple">
                                <option value=""> -- Please Choose --</option>
                                <?php foreach(json_decode($Q1->POSS_ANSWER) as $key => $value) :?>
                                <?php  if(in_array($key , json_decode($visitor->A2))){ $text="selected"; } else{ $text=''; } ?> 
                                <option value="<?= $key; ?>" <?= $text ?>> <?= $value; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class = "form-group row" id="EditdivSicknessOther">
                        <div class="col-md-12 mb-12">
                            <label for="EditinputOtherSickness">Please indicate</label>
                            <input type="text" class="form-control" id="EditinputOtherSickness" placeholder="Enter your other sickness" name = "EditinputOtherSickness" readonly  
                            <?php foreach(json_decode($visitor->A2) as $value) :?>
                                value="<?php $arr = json_decode($visitor->A2); echo end($arr); ?>"
                            <?php endforeach; ?>
                            >
                        </div>
                    </div>

                    <div class = "form-group row" id="EditdivSicknessDate">
                        <div class="col-md-12 mb-12">
                            <label for="EditinputStartEndDate">If yes, date when it started and ended</label>
                            <input type="text" class="form-control" name="EditinputStartEndDate" id="EditinputStartEndDate" value="<?= $visitor->A2DATES; ?>" readonly>
                        </div>
                    </div>

                   <div class = "form-group row">
                        <div class="col-md-12 mb-12">
                            <label for="EditcontrolSelectStatusQ2">travelled from a geographic location/country with document cases of CoVid 19?</label>
                            <select class="form-control" id="EditcontrolSelectStatusQ2" name = "EditcontrolSelectStatusQ2" readonly>
                                <option value=""> -- Please Choose --</option>
                                <?php foreach(json_decode($Q2->POSS_ANSWER) as $key => $value) :?>
                                    <?php  if($visitor->A3 == $key){ $text="selected"; } else{ $text=''; } ?> 
                                    <option value="<?= $key; ?>" <?= $text ?>> <?= $value; ?></option>
                                <?php endforeach; ?>
                            </select>   
                        </div>
                    </div>

                    <div class = "form-group row" id="EditdivTravel">
                        <div class="col-md-12 mb-12">
                            <label for="EditinputTravelDate">If yes, please state the travel dates</label>
                            <input type="date" class="form-control" id="EditinputTravelDate"  name = "EditinputTravelDate" value="<?= $visitor->A3TRAVEL_DATES; ?>" max="<?php echo date("Y-m-d"); ?>" readonly>
                        </div>
                    </div>

                    <div class = "form-group row" id="EditdivTravel2">
                        <div class="col-md-12 mb-12">
                            <label for="EditinputTravelLoc">State the exact place of travel</label>
                            <input type="text" class="form-control" id="EditinputTravelLoc"  placeholder="Enter country/city"  name = "EditinputTravelLoc" value="<?= $visitor->A3PLACE; ?>" readonly>
                        </div>
                    </div>

                    <div class = "form-group row" id="EditdivTravel3">
                        <div class="col-md-12 mb-12">
                            <label for="EditinputDatOfReturn">Date of return to PH/Manila</label>
                            <input type="date" class="form-control" id="EditinputDatOfReturn" name = "EditinputDatOfReturn" value="<?= $visitor->A3RETURN_DATE; ?>" max="<?php echo date("Y-m-d"); ?>" readonly>
                        </div>
                    </div>
                    
                <?= form_close() ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal" >Close</button>
                    <button type="button" class="btn btn-primary" id="EditsubmitModal" onClick="btnSaveEdited()">Edit</button>
            </div>
            </div>
            </div>
        </div>
    </div>
<!-- End of Modal Adding visitor log -->

<script type="text/javascript">

$(function() {
    $('#labelStatus').prop('hidden' , true);
    $('#labelStatusActivity').prop('hidden' , true);
    $('.multiselect-ui').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false
    });


    /* For Date range on the date end and start sickness */
    $('input[name="EditinputStartEndDate"]').daterangepicker({
        autoUpdateInput: false,
        maxDate: new Date(),
        drops: 'up',
        locale: {
            cancelLabel: 'Clear'
        }
    });


    /* For Date range Picker */
    $('input[name="EditinputStartEndDate"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('input[name="EditinputStartEndDate"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
    /* ENd For Date range Picker */


    /* Show input box base on the user selected answer sickness */
    $('#EditcontrolSelectStatusQ1').on('change', function() {
        
        var $select = $('#EditcontrolSelectStatusQ1').selectize();
        var control = $select[0].selectize;
        var sickness = [];
    
        
        $.each($(".multiselect-ui option:selected"), function(){            
            sickness.push($(this).val());
        }); 

        if(sickness.includes("11")){
            $('#EditdivSicknessOther').prop('hidden' , true);
            $('#EditdivSicknessDate').prop('hidden' , true);
            $('#EditcontrolSelectStatusQ1')[0].selectize.removeItem("1");
            $('#EditcontrolSelectStatusQ1')[0].selectize.removeItem("2");
            $('#EditcontrolSelectStatusQ1')[0].selectize.removeItem("3");
            $('#EditcontrolSelectStatusQ1')[0].selectize.removeItem("4");
            $('#EditcontrolSelectStatusQ1')[0].selectize.removeItem("5");
            $('#EditcontrolSelectStatusQ1')[0].selectize.removeItem("6");
            $('#EditcontrolSelectStatusQ1')[0].selectize.removeItem("7");
            $('#EditcontrolSelectStatusQ1')[0].selectize.removeItem("8");
            $('#EditcontrolSelectStatusQ1')[0].selectize.removeItem("9");
            $('#EditcontrolSelectStatusQ1')[0].selectize.removeItem("10");
            $('#EditcontrolSelectStatusQ1')[0].selectize.removeItem("12");
            $('#EditcontrolSelectStatusQ1')[0].selectize.addItem("11");
        }else {
            $('#EditcontrolSelectStatusQ1')[0].selectize.removeItem("11");
            $('#EditdivSicknessOther').prop('hidden' , false);
            $('#EditdivSicknessDate').prop('hidden' , false);
        }
                
        /* For other sickness selected value */
            if (jQuery.inArray( "12", sickness ) >= 0){
                $('#EditdivSicknessOther').prop('hidden' , false);
                $('#EditdivSicknessDate').prop('hidden' , false);
            }else{
                $('#EditdivSicknessOther').prop('hidden' , true);
            }
        /* End For other sickness selected value */
    
    });
    /* End input box base on the user selected answer */

    

    $('#EditinputPart').change(function(e){  
        if($('#EditinputPart').val().includes($("#EditinputHost").val())){
            alert('Host Employee cannot be participant. Please select another employee');
            $('#EditinputPart')[0].selectize.removeItem($("#EditinputHost").val());
        }
    })

    $('#EditinputHost').change(function(e){
        if($('#EditinputPart').val().includes($("#EditinputHost").val())){
            alert('Participant employee cannot be participant. Please select another employee.');
            var $select = $('#EditinputHost').selectize();
            var control = $select[0].selectize;
            control.clear();
        }
    })


    if($('#EditinputOtherSickness').text() != ""){
        $('#EditdivSicknessDate').prop('hidden' , false);
        $('#EditdivSicknessOther').prop('hidden' , false);
    }else{
        $('#EditdivSicknessDate').prop('hidden' , true);
        $('#EditdivSicknessOther').prop('hidden' , true);
    }


   /* Show Edit input box base on the user selected answer YES/NO */
   $('#EditcontrolSelectStatusQ2').on('change', function() {
        if ( this.value == 1){
            $('#EditdivTravel').show();
            $('#EditdivTravel2').show();
            $('#EditdivTravel3').show();
        }else{
            $('#EditdivTravel').hide();
            $('#EditdivTravel2').hide();
            $('#EditdivTravel3').hide();
        }
    });
    /* End input box base on the user selected answer */

    Travelled = $('#EditcontrolSelectStatusQ2').val();

    if (Travelled == 2){
        $('#EditdivTravel').hide();
        $('#EditdivTravel2').hide();
        $('#EditdivTravel3').hide();
    }else{
        $('#EditdivTravel').show();
        $('#EditdivTravel2').show();
        $('#EditdivTravel3').show();
    }

    if($('#labelStatus').text() == 'DONE'){
        $('#EditsubmitModal').prop('hidden' , true);
    }else if ($('#labelStatusActivity').text() == 'DENIED'){
        $('#EditsubmitModal').prop('hidden' , true);
    }else if ($('#labelStatusActivity').text() == 'CANCELLED'){
        $('#EditsubmitModal').prop('hidden' , true);
    }else{
        $('#EditsubmitModal').prop('hidden' , false);
    }
    
    if ($('#EditcontrolSelectStatusQ1').val().indexOf('12') < 0){
        $('#EditdivSicknessOther').prop('hidden' , true);
        $('#EditdivSicknessDate').prop('hidden' , true);
    }else{
        $('#EditdivSicknessOther').prop('hidden' , false);
        $('#EditdivSicknessDate').prop('hidden' , false);
    }
});

$(document).ready(function(){
    /*  For showing the field of range if has value */
        if($('#EditinputStartEndDate').val() != ''){
            $('#EditdivSicknessDate').prop('hidden' , false);
        }else{
                $('#EditdivSicknessDate').prop('hidden' , true);
        }
    /*  END For showing the field of range if has value */

});

$('#EditinputBodyTemp').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1)&&(event.which < 48 || event.which > 57)) {
               if((event.which != 46 || $(this).val().indexOf('.') != -1)){
              //alert('Multiple Decimals are not allowed');
          }
          event.preventDefault();
       }
       if(this.value.indexOf(".")>-1 && (this.value.split('.')[1].length > 1))		{
           // alert('Two numbers only allowed after decimal point');
            event.preventDefault();
        }
    });
</script>

