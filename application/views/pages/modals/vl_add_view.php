<!-- Modal Adding visitor log -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitleAdd">Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <?= form_open_multipart('vl/add' , ['id' => 'fromAddVisitorLogModal', 'role' => 'form' ]); ?>
                    <div class="form-group row">
                        <div class="col-md-12 mb-12">
                            <label for="dateOfVisit">Date of Visit</label>
                            <input type="date" class="form-control" id="dateOfVisit" name ="dateOfVisit" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 mb-6">
                            <label for="inputCheckIn">Check-In Time</label>
                            <input type="time" class="form-control" id="inputCheckIn" name="inputCheckIn" readonly>
                        </div>
                        <div class="col-md-6 mb-6">
                            <label for="inputCheckOut">Check-Out Time</label>
                            <input type="time" class="form-control" id="inputCheckOut" name="inputCheckOut" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 mb-6">
                            <label for="inputTimeFrom">Time From</label>
                            <input type="time" class="form-control" id="inputTimeFrom" name="inputTimeFrom">
                        </div>
                        <div class="col-md-6 mb-6">
                            <label for="inputTimeTo">Time To</label>
                            <input type="time" class="form-control" id="inputTimeTo" name="inputTimeTo">
                        </div>
                        <div class="col-md-12 mb-12">
                            <small id="inputTimeToWarning" class="text-danger" hidden>
                                 <p id="text"><p>
                            </small> 
                        </div>  
                    </div>

                    <label>Visitor Name</label>

                    <div class="input-group ">
                        <div class="input-group-prepend">

                        </div>
            
                        <input type="text" class="form-control" placeholder="Last Name"  id="inputVisitorNameLN" name="inputVisitorNameLN"  onkeypress="return onlyAlphabets(event,this);">
                        <input type="text" class="form-control" placeholder="First Name"  id="inputVisitorNameFN" name="inputVisitorNameFN"  onkeypress="return onlyAlphabets(event,this);">
                        <input type="text" class="form-control" placeholder="Middle Name"  id="inputVisitorNameMN" name="inputVisitorNameMN"  onkeypress="return onlyAlphabets(event,this);">
                    </div>
                    <br>
                    <div class = "form-group row">
                        <div class="col-md-12 mb-12">
                            <label for="inputEmail">Email Address</label>
                            <input type="text" class="form-control" id="inputEmail" placeholder="Enter Email Address" name = "inputEmail">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 mb-6">
                            <label for="inputCompany">Company</label>
                            <input type="text" class="form-control" id="inputCompany" placeholder="Enter Company" name ="inputCompany">
                        </div>
                        <div class="col-md-6 mb-6">
                            <label for="inputCompanyAdd">Company Address</label>
                            <input type="text" class="form-control" id="inputCompanyAdd" placeholder="Enter Company Address" name = "inputCompanyAdd">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 mb-6">
                            <label for="inputMobile">Mobile No.</label>
                            <input type="text" class="form-control" id="inputMobile" placeholder="Enter Mobile No. 09xxx" name = "inputMobile" onkeypress='return restrictAlphabets(event)'>
                        </div>
                        <div class="col-md-6 mb-6">
                            <label for="inputLandline">Landline</label>
                            <input type="text" class="form-control" id="inputLandline" placeholder="Enter Landline" name = "inputLandline"  onkeypress='return restrictAlphabets(event)'>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12 mb-12">
                            <label for="inputResAdd">Residential Address</label>
                            <input type="text" class="form-control" id="inputResAdd" placeholder="Enter Residential Address" name = "inputResAdd">
                        </div>
                    </div>

                    <div class="form-group row">    
                        <div class="col-md-12 mb-12">
                            <label for="inputHost">Person to Visit(Host)</label>
                            <select class="auto-select form-control" id="inputHost" name="inputHost" >
                               <option value=""> -- Please Choose --</option>
                                <?php foreach($employee as $emp): ?>
                                <option value="<?= $emp->EMP_CODE; ?>"><?= $emp->EMP_FULLNAME; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    

                   <div class = "form-group row">
                        <div class="col-md-12 mb-12">
                            <label for="inputPart">Other Participants</label>
                            <select class="auto-select form-control" id="inputPart" name="inputPart[]" multiple="multiple">
                                <option value=""> -- Please Choose --</option>
                                <?php foreach($employee as $emp): ?>
                                <option value="<?= $emp->EMP_CODE; ?>"><?= $emp->EMP_FULLNAME; ?></option>
                                <?php endforeach; ?>
                            </select>   
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12 mb-12">
                            <label for="InputMeetingLocation">Meeting Location</label>
                            <input type="text" class="form-control" id="InputMeetingLocation" placeholder="Enter Meeting location" name = "InputMeetingLocation">
                        </div>
                    </div>

                    <div class = "form-group row">
                        <div class="col-md-12 mb-12">
                        <label for="inputPurposeVisit">Purpose of Visit</label>
                            <textarea class="form-control" id="inputPurposeVisit" placeholder="Enter the purpose of visit" name = "inputPurposeVisit" ></textarea>
                        </div>
                    </div>

                    <div class = "form-group row">
                        <div class="col-md-12 mb-12">
                            <label for="inputBodyTemp">Body Temperature</label>
                            <input type="text" class="form-control" id="inputBodyTemp" placeholder="Enter Body Temperature" name = "inputBodyTemp" >
                        </div>
                    </div>

                   <div class = "form-group row">
                        <div class="col-md-12 mb-12">
                            <label for="controlSelectStatusQ1">Do you have the following sickness/symptoms</label>
                            <select class="auto-select form-control" id="controlSelectStatusQ1" name="controlSelectStatusQ1[]" multiple="multiple">
                                <option value=""> -- Please Choose --</option>
                                <?php foreach(json_decode($Q1->POSS_ANSWER) as $key => $value) :?>
                                <option value="<?= $key; ?>"> <?= $value; ?></option>
                                <?php endforeach; ?>
                            </select>   
                        </div>
                    </div>

                    <div class = "form-group row" id="divSicknessOther">
                        <div class="col-md-12 mb-12">
                            <label for="inputOtherSickness">Please indicate</label>
                            <input type="text" class="form-control" id="inputOtherSickness" placeholder="Enter your other sickness" name = "inputOtherSickness">
                        </div>
                    </div>

                    <div class = "form-group row" id="divSicknessDate">
                        <div class="col-md-12 mb-12">
                            <label for="inputStartEndDate">if yes, date when it started and ended</label>
                            <input type="text" class="form-control" name="inputStartEndDate" id="inputStartEndDate" value="" />
                        </div>
                    </div>

                   <div class = "form-group row">
                        <div class="col-md-12 mb-12">
                            <label for="controlSelectStatusQ2">travelled from a geographic location/country with document cases of CoVid 19?</label>
                            <select class="form-control" id="controlSelectStatusQ2" name = "controlSelectStatusQ2">
                                <option value=""> -- Please Choose --</option>
                                <?php foreach(json_decode($Q2->POSS_ANSWER) as $key => $value) :?>
                                <option value="<?= $key; ?>"> <?= $value; ?></option>
                                <?php endforeach; ?>
                            </select>   
                        </div>
                    </div>

                    <div class = "form-group row" id="divTravel">
                        <div class="col-md-12 mb-12">
                            <label for="inputTravelDate">If yes, please state the travel dates</label>
                            <input type="date" class="form-control" id="inputTravelDate"  name = "inputTravelDate" max="<?php echo date("Y-m-d"); ?>">
                        </div>
                    </div>

                    <div class = "form-group row" id="divTravel2">
                        <div class="col-md-12 mb-12">
                            <label for="inputTravelLoc">State the exact place of travel</label>
                            <input type="text" class="form-control" id="inputTravelLoc"  placeholder="Enter city/country"  name = "inputTravelLoc">
                        </div>
                    </div>

                    <div class = "form-group row" id="divTravel3">
                        <div class="col-md-12 mb-12">
                            <label for="inputDatOfReturn">Date of return to PH/Manila</label>
                            <input type="date" class="form-control" id="inputDatOfReturn" name = "inputDatOfReturn" max="<?php echo date("Y-m-d"); ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal" ><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                    <button type="button" class="btn btn-primary" id="submitAddModal"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                </div>
                <?= form_close() ?>
            </div>
            </div>
        </div>
    </div>
<!-- End of Modal Adding visitor log -->

<script>
    /* Auto populate the field of date visit */
    let today = new Date().toISOString().substr(0, 10);
    document.querySelector("#dateOfVisit").value = today;
    /* document.querySelector("#dateOfVisit").valueAsDate = new Date();*/
    /* End Auto populat the field of date visit */    
</script>

