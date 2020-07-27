var submitted = 0;
var editted = 0;
var due_time = 0;
var server_time = 0;
var due_time = 0;
$(document).ready(function(){
    $("#form_div").hide();

    var get_server_time = $.ajax({
        url: "api/server_time",
        method: "GET",
        dataType: "json",
        async: false
    });

    get_server_time.done(function(data){
        server_time = data;
    });

    var get_due_time = $.ajax({
        url: "api/due_time",
        method: "GET",
        dataType: "json",
        async: false
    });

    get_due_time.done(function(data){
        due_time = data;
    });

    var request = $.ajax({
        url: "api/questions/EHC",
        method: "GET",
        dataType: "json"
    });

    request.done(function(data) {
        var form = "";
        // var currentD = new Date();
        // var due_time = new Date();
        // due_time.setHours(13,00,0);
        for(var x = 0; x < data.length; x++){
            if(data[x]['TYPE'] == 4){
                form += "<div class='form-group'>";
                    form += "<div class='form-row'>";
                        form += "<div class='col'>";
                            form += "<div class='form-group'>";
                                form += "<label for='"+data[x]['TRANSACTION']+data[x]['SEQUENCE']+"'>"+data[x]['QUESTION']+"</label>";
                            form += "</div>";
                        form += "</div>";
                    form += "</div>";
                    form += "<div class='form-row'>";
                        form += "<div class='col-8'>";
                            form += "<div class='form-group'>";
                                form += inputType(data[x]['TYPE'], data[x]['POSS_ANSWER'], data[x]['SEQUENCE']);
                            form += "</div>";
                        form += "</div>";
                    form += "</div>";
                    form += inputType(5, '', data[x]['SEQUENCE']);
                form += "</div>";
            }
            else{
                form += "<div class='form-group'>";
                    form += "<div class='form-row'>";
                        form += "<div class='col'>";
                            form += "<div class='form-group'>";
                                form += "<label for='"+data[x]['TRANSACTION']+data[x]['SEQUENCE']+"'>"+data[x]['QUESTION']+"</label>";
                            form += "</div>";
                        form += "</div>";
                    form += "</div>";
                    form += "<div class='form-row'>";
                        form += "<div class='col-8'>";
                            form += "<div class='form-group'>";
                                form += inputType(data[x]['TYPE'], data[x]['POSS_ANSWER'], data[x]['SEQUENCE']);
                            form += "</div>";
                        form += "</div>";
                    form += "</div>";
                form += "</div>";
            }
        }
        form += "<div class='form-group' id='late_filing'>";
            form += "<div class='form-row'>";
                form += "<div class='col'>";
                    form += "<div class='form-group'>";
                        form += "<label for='reason'>Reason for late filing:</label>";
                    form += "</div>";
                form += "</div>";
            form += "</div>";
            form += "<div class='form-row'>";
                form += "<div class='col-8'>";
                    form += "<div class='form-group'>";
                        form += "<input type='text' class='form-control' id='reason' name='reason' required>";
                        form += "<div class='invalid-feedback'>";
                            form += "Please provide your reason for late filing.";
                        form += "</div>";
                    form += "</div>";
                    
                form += "</div>";
            form += "</div>";
        form += "</div>";
        $("#form_area").html(form);

        
        if(server_time > due_time){
            $("#late_filing").show();
            $("#reason").prop("disabled", false);
        }
        else{
            $("#late_filing").hide();
            $("#reason").prop("disabled", true);
        }

        $("#A2WHEN_ROW1").hide();
        $("#A2WHEN_ROW2").hide();
        $("#A4WHEN_ROW1").hide();
        $("#A4WHEN_ROW2").hide();
        $("#A4WHERE_ROW1").hide();
        $("#A4WHERE_ROW2").hide();
        $("#A5WHEN_ROW1").hide();
        $("#A5WHEN_ROW2").hide();

        $("#A1").prop("maxlength", 5);
    });

    var submitted_ehc = $.ajax({
        url: "api/get_submitted_ehc",
        method: "GET",
        dataType: "json"
    });

    submitted_ehc.done(function(data){
        var currentD = new Date();
        var due_time = new Date();
        due_time.setHours(13,00,0);
        

        if(data[0]['SUBMITTED_EHC'] == 0){
            $('#tbl_add').prop('disabled', false);
            // $('#modal_title').html("You're done for today!");
            // $('#confirm_body').html("You have already submitted your daily health check. Come back again tomorrow.");
            // $('#confirm_header').css('background-color', '#ccffcc');
            // $('#confirm_body').css('background-color', '#ccffcc');
            // $('#confirm_footer').css('background-color', '#ccffcc');
        }
        else if(currentD > due_time){
            // $('#modal_title').html('Oops!');
            // $('#confirm_body').html("It's already past the due of the submission of daily health check. You can still submit but a ticket will automatically be created in Rush.Net.");
            // $('#confirm_header').css('background-color', '#ffff99');
            // $('#confirm_body').css('background-color', '#ffff99');
            // $('#confirm_footer').css('background-color', '#ffff99');
            // $('#dhc_modal').modal('show');
        }
        else{
            $("#late_filing").hide();
            $("#reason").prop('disabled', true);
            $("#reason").prop('required', false);
        }
    });

    $('#dhc_tbl').DataTable( {
        "order": [[ 1, "desc" ]],
        responsive: {
            details: false
        },
        "ajax": {
            "url": "api/get_all_ehc",
            "type": "GET"
        },
        "columns": [
            {"data": "EHC_ID"},
            {"data": "EHC_DATE"},
            {"data": "COMPLETION_DATE"},
            {"data": "A1"},
            {"data": "RUSHNO"},
            {"data": "STATUS"},
        ],
        columnDefs: [
            { 
                targets: 0,
                searchable: false,
                orderable: false,
                render: function(data, type, full, meta){
                   if(type === 'display'){
                      data = '<input type="radio" name="selected_ehc" value="' + data + '">';      
                   }
    
                   return data;
                }
            },
            {
                targets: [0, 1, 2, 3, 4, 5],
                className: "text-center"
            },
            {
                targets: 0,
                orderable: false
            },
            {
                targets: 5,
                orderable: false,
                render: function(data, type, full, meta){
                    if(type === 'display'){
                        if(data == "null/undef"){
                            data = '';
                        }
                    }
                    return data;
                 }
            }
        ]
    } );

    $("#view_div").hide();

    $("#tbl_add").on("click", function(event){
        // added form reset on click of add button 7/6/2020
        $('#dhc_form').trigger("reset");
        $("#tbl_div").hide();
        $("#form_div").show();
    });

    $("#tbl_edit").on("click", function(event){
        $("#dhc_form :input").prop("disabled", false);
        editted = 1;
        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();

        var output = d.getFullYear() + '-' +
            (month<10 ? '0' : '') + month + '-' +
            (day<10 ? '0' : '') + day;
        var data = $("input[name='selected_ehc']:checked").val();
        if(data !== undefined){
            var ehc_details = $.ajax({
                url: "api/get_ehc_details/"+data,
                method: "GET",
                dataType: "json"
            });
    
            ehc_details.done(function(data){
                if(data[0]['EHC_DATE'] < output || data[0]['STATUS'] === "I" || data[0]['STATUS'] === "A" || data[0]['STATUS'] === "R"){
                    alert("You can't edit this record.");
                }
                else{
                    $("#tbl_div").hide();
                    $("#form_div").show();
                    
                    $("input[name='A1']").val(data[0]['A1']);
                    
                    $("select[name='A2']").val(data[0]['A2']);
                    if(data[0]['A2'] == "Y"){
                        $("#A2WHEN_ROW1").show();
                        $("#A2WHEN_ROW2").show();

                        $("input[name='A2WHEN']").prop("required", true);
                        $("input[name='A2WHEN']").prop("disabled", false);

                        $("input[name='A2WHEN']").val(data[0]['A2WHEN']);
                        
                    }
                    else{
                        $("input[name='A2WHEN']").prop("disabled", true);
                        $("input[name='A2WHEN']").prop("required", false);
                    }

                    var symptoms = JSON.parse(data[0]['A3'])
                    for(x = 0; x < symptoms.length; x++){
                        var done = 0;
                        $('input[type=checkbox]').filter(function(){
                            if(this.value === symptoms[x]){
                                done = 1;
                                $(this).trigger('click');
                                return true;
                            }
                            return false;
                        }).prop('checked', true);
                        if(!done){
                            $('#OTHERS_CHK').filter(function(){
                                done = 1;
                                $(this).trigger('click');
                                return this.value === "Others" || this.value === "Others";
                            }).prop('checked', true);
                            $("#OTHER_SYMP").prop("disabled", false);
                            $("#OTHER_SYMP").val(symptoms[x]);
                        }
                        else{
                            $("#OTHER_SYMP").prop("disabled", true);
                        }
                    }
                    
                    $("select[name='A4']").val(data[0]['A4']);
                    if(data[0]['A4'] == "Y"){
                        $("#A4WHERE_ROW1").show();
                        $("#A4WHERE_ROW2").show();
                        $("#A4WHEN_ROW1").show();
                        $("#A4WHEN_ROW2").show();

                        $("input[name='A4WHERE']").prop("required", true);
                        $("input[name='A4WHERE']").prop("disabled", false);
                        $("input[name='A4WHEN']").prop("required", true);
                        $("input[name='A4WHEN']").prop("disabled", false);

                        $("input[name='A4WHERE']").val(data[0]['A4WHERE']);
                        $("input[name='A4WHEN']").val(data[0]['A4WHEN']);
                    }
                    else{
                        $("input[name='A4WHERE']").prop("required", false);
                        $("input[name='A4WHERE']").prop("disabled", true);
                        $("input[name='A4WHEN']").prop("required", false);
                        $("input[name='A4WHEN']").prop("disabled", true);
                    }

                    $("select[name='A5']").val(data[0]['A5']);
                    if(data[0]['A5'] == "Y"){
                        $("#A5WHEN_ROW1").show();
                        $("#A5WHEN_ROW2").show();
                        
                        $("input[name='A5WHEN']").prop('disabled', false);
                        $("input[name='A5WHEN']").prop('required', true);
                        $("input[name='A5WHEN']").val(data[0]['A5WHEN']);
                    }
                    else{
                        $("input[name='A5WHEN']").prop("disabled", true);
                        $("input[name='A5WHEN']").prop('required', false);
                    }

                    if(data[0]['REASON'] != null){
                        $("#late_filing").show();
                        $("input[name='reason']").val(data[0]['REASON']);
                    }
                    else{
                        $("#late_filing").hide();
                        $("input[name='reason']").prop("disabled", true);
                    }
                    $("#ehc_id").prop("disabled", false);
                    $("#ehc_id").val(data[0]['EHC_ID']);
                }
                
            });
        }
        
    });

    $("#tbl_view").on("click", function(event){
        var data = $("input[name='selected_ehc']:checked").val();
        if(data !== undefined){
            var ehc_details = $.ajax({
                url: "api/get_ehc_details/"+data,
                method: "GET",
                dataType: "json"
            });
    
            ehc_details.done(function(data){
                $("#tbl_div").hide();
                $("#view_div").show();

                var answers = data;
                var form = "";
                
                var temp = JSON.parse(answers[0]['A3']);
                var symptoms = "";
                
                symptoms += "<ul>";
                for(var x = 0; x < temp.length; x++){
                    symptoms += "<li>"+temp[x]+"</li>";
                }
                symptoms += "</ul>";

                var request = $.ajax({
                    url: "api/questions/EHC",
                    method: "GET",
                    dataType: "json"
                });
            
                request.done(function(data) {
                    for(var x = 0; x < data.length; x++){
                            form += "<div class='form-group'>";
                                form += "<div class='form-row'>";
                                    form += "<div class='col'>";
                                        form += "<div class='form-group'>";
                                            form += "<label for='"+data[x]['TRANSACTION']+data[x]['SEQUENCE']+"'>"+data[x]['QUESTION']+"</label>";
                                        form += "</div>";
                                    form += "</div>";
                                form += "</div>";
                                form += "<div class='form-row'>";
                                    form += "<div class='col-8'>";
                                        form += "<div class='form-group'>";
                                        if(data[x]['SEQUENCE'] == 3){
                                            
                                            form += symptoms;
                                            
                                        }
                                        else{
                                            if(answers[0]['A'+data[x]['SEQUENCE']] == "Y"){
                                                form += "<div>";
                                                    form += "Yes";
                                                form += "</div>";
                                                if(data[x]['SEQUENCE'] == 2){
                                                    form += "<div class='form-group'>";
                                                        form += "<label>If YES, please specify WHEN it started:</label>";
                                                        form += "<div>"+answers[0]['A2WHEN']+"</div>";
                                                    form += "</div>";
                                                }
                                                else if(data[x]['SEQUENCE'] == 4){
                                                    form += "<div>";
                                                        form += "<label>If YES, please specify WHERE:</label>";
                                                        form += "<div>"+answers[0]['A4WHERE']+"</div>";
                                                        form += "<label>If YES, please specify WHEN:</label>";
                                                        form += "<div>"+answers[0]['A4WHEN']+"</div>";
                                                    form += "</div>";
                                                }
                                                else if(data[x]['SEQUENCE'] == 5){
                                                    form += "<div>";
                                                        form += "<label>If YES, please specify WHEN:</label>";
                                                        form += "<div>"+answers[0]['A5WHEN']+"</div>";
                                                    form += "</div>";
                                                }
                                            }
                                            else if(answers[0]['A'+data[x]['SEQUENCE']] == "N"){
                                                form += "<div>";
                                                    form += "No";
                                                form += "</div>";
                                            }
                                            else{
                                                form += answers[0]['A'+data[x]['SEQUENCE']];
                                            }
                                        }
                                        form += "</div>";
                                    form += "</div>";
                                form += "</div>";
                            form += "</div>";
                    }
                    if(answers[0]['REASON'] != null){
                        form += "<div class='form-group' id='late_filing'>";
                            form += "<div class='form-row'>";
                                form += "<div class='col'>";
                                    form += "<div class='form-group'>";
                                        form += "<label for='reason'>Reason for late filing:</label>";
                                    form += "</div>";
                                form += "</div>";
                            form += "</div>";
                            form += "<div class='form-row'>";
                                form += "<div class='col-8'>";
                                    form += "<div class='form-group'>";
                                        form += answers[0]['REASON'];
                                        form += "<div class='invalid-feedback'>";
                                            form += "Please provide your reason for late filing.";
                                        form += "</div>";
                                    form += "</div>";
                                form += "</div>";
                            form += "</div>";
                        form += "</div>";
                    }
                    
                    $("#view_area").html(form);
                });

                
            });
        }
    });

    $('#dhc_modal').on('hidden.bs.modal', function (e) {
        location.reload();
    });
    
    // validate if user already submitted ehc
    var no_ehc = true;
    var has_ehc_ajax = $.ajax({
        url: "api/get_ehc_today",
        method: "GET",
        async: false
    });
    has_ehc_ajax.done(function(data){
        no_ehc = data;
    });

    $("#submit").on("click", function(event){
        if(no_ehc){
            submitted = 1;
            var x = $(".custom-control-input:checked").length;
            if(x < 1){
                $("#invalid_symp").show();
                $(".custom-control-input").prop("required", true);
            }
            else{
                $("#invalid_symp").hide();
                $(".custom-control-input").prop("required", false);
            }

            $("#dhc_form").addClass('was-validated');
            if($("#dhc_form")[0].checkValidity()){
                //Serialize form as array
                var serializedForm = $("#dhc_form").serializeArray();
                //trim values
                for(var i = 0; i < serializedForm.lengthen ;i++){
                    serializedForm[i] = $.trim(serializedForm[i]);
                }
                //turn it into a string
                serializedForm = $.param(serializedForm);
                // disable submit button to prevent double submit
                $("#submit").prop("disabled", true);
                $("#submit").html("Submitting...");
                // submit thru ajax
                if(!editted){
                    $.ajax({
                        url: 'api/submit_ehc',
                        type: 'POST',
                        data: serializedForm,
                        cache: 'no-cache',
                        success: function(data) {
                            data = JSON.parse(data);
                            // if(data['late'] == 1){
                            //     $('#modal_title').html('Well done!');
                            //     $('#confirm_body').html('You have submitted your daily health check. A Rush.NET ticket was created for approval.');
                            //     $('#confirm_header').css('background-color', '#ffff99');
                            //     $('#confirm_body').css('background-color', '#ffff99');
                            //     $('#confirm_footer').css('background-color', '#ffff99');
                            //     $('#dhc_modal').modal('show');
                            // }
                            // else{
                                $('#modal_title').html('Well done!');
                                $('#confirm_body').html('You have submitted your daily health check.');
                                $('#confirm_header').css('background-color', '#ccffcc');
                                $('#confirm_body').css('background-color', '#ccffcc');
                                $('#confirm_footer').css('background-color', '#ccffcc');
                                $('#dhc_modal').modal('show');
                            // }
                            // $('#dhc_tbl').DataTable().ajax.reload();
                            // $('#dhc_form').trigger("reset");
                            // $("#dhc_form").removeClass('was-validated');
                            // $("#submit").html("Submit");
                            // $("#submit").prop("disabled", false);
                            // $("#tbl_div").show();
                            // $('#tbl_add').prop('disabled',true);
                            // $("#form_div").hide();
                        },
                        fail: function(err){
                            alert('An error has occured. Please contact your system administrator. Error: '+err);
                            console.log(err)
                        }
                    });
                }
                else{
                    $.ajax({
                        url: 'api/update_ehc',
                        type: 'POST',
                        data: serializedForm,
                        cache: 'no-cache',
                        success: function(data) {
                            $('#modal_title').html('Well done!');
                            $('#confirm_body').html('You have updated your daily health check.');
                            $('#confirm_header').css('background-color', '#ccffcc');
                            $('#confirm_body').css('background-color', '#ccffcc');
                            $('#confirm_footer').css('background-color', '#ccffcc');
                            // $('#dhc_tbl').DataTable().ajax.reload();
                            $('#dhc_modal').modal('show');
                            // $('#dhc_form').trigger("reset");
                            // $("#dhc_form").removeClass('was-validated');
                            // $("#submit").html("Submitted");
                            // $("#tbl_div").show();
                            // $('#tbl_add').prop('disabled',true);
                            // $("#form_div").hide();
                        },
                        fail: function(err){
                            alert('An error has occured. Please contact your system administrator. Error: '+err);
                            console.log(err)
                        }
                    });
                }
            }
        }
        else{
            var x = $(".custom-control-input:checked").length;
            if(x < 1){
                $("#invalid_symp").show();
                $(".custom-control-input").prop("required", true);
            }
            else{
                $("#invalid_symp").hide();
                $(".custom-control-input").prop("required", false);
            }

            $("#dhc_form").addClass('was-validated');
            if($("#dhc_form")[0].checkValidity()){
                //Serialize form as array
                var serializedForm = $("#dhc_form").serializeArray();
                //trim values
                for(var i = 0; i < serializedForm.lengthen ;i++){
                    serializedForm[i] = $.trim(serializedForm[i]);
                }
                //turn it into a string
                serializedForm = $.param(serializedForm);
                // disable submit button to prevent double submit
                $("#submit").prop("disabled", true);
                $("#submit").html("Submitting...");
                // submit thru ajax
                if(!editted){
                    $('#modal_title').html('Oops!');
                    $('#confirm_body').html('You already submitted your daily health check. You can only submit once a day.');
                    $('#confirm_header').css('background-color', '#fcd874');
                    $('#confirm_body').css('background-color', '#fcd874');
                    $('#confirm_footer').css('background-color', '#fcd874');
                    $('#dhc_modal').modal('show');
                }
                else{
                    $.ajax({
                        url: 'api/update_ehc',
                        type: 'POST',
                        data: serializedForm,
                        cache: 'no-cache',
                        success: function(data) {
                            $('#modal_title').html('Well done!');
                            $('#confirm_body').html('You have updated your daily health check.');
                            $('#confirm_header').css('background-color', '#ccffcc');
                            $('#confirm_body').css('background-color', '#ccffcc');
                            $('#confirm_footer').css('background-color', '#ccffcc');
                            // $('#dhc_tbl').DataTable().ajax.reload();
                            $('#dhc_modal').modal('show');
                            // $('#dhc_form').trigger("reset");
                            // $("#dhc_form").removeClass('was-validated');
                            // $("#submit").html("Submitted");
                            // $("#tbl_div").show();
                            // $('#tbl_add').prop('disabled',true);
                            // $("#form_div").hide();
                        },
                        fail: function(err){
                            alert('An error has occured. Please contact your system administrator. Error: '+err);
                            console.log(err)
                        }
                    });
                }
            }
        }
    });

    $("#cancel").on("click", function(event){
        $('#dhc_form').trigger("reset");
        $("#dhc_form").removeClass('was-validated');
        editted = 0;
        $("#form_div").hide();
        $("#tbl_div").show();
    });

    $("#cancel_view").on("click", function(event){
        $('#dhc_form').trigger("reset");
        $("#dhc_form").removeClass('was-validated');
        editted = 0;
        $("#view_div").hide();
        $("#tbl_div").show();
    });

});


function inputType(type, ans, label){
    var input = "";
    if(type == 1){
        input += "<input type='text' class='form-control' id='A"+label+"' name='A"+label+"' onkeydown='return isNumber(event)' onchange='checkDecimalPoint(this.id); checkDecimalNumbers(this.id)' required>";
        input += "<input type='hidden' class='form-control ehc' name='Q"+label+"' value='"+label+"'>";
        input += "<div class='invalid-feedback'>";
            input += "This field is required.";
        input += "</div>";
    }
    if(type == 3){
        $.each(JSON.parse(ans), function(index, value) {
            if(value.toUpperCase() == "OTHERS"){
                input += "<div class='custom-control custom-checkbox'>";
                    input += "<input type='checkbox' class='custom-control-input ehc' name='A"+label+"[]' value='"+value+"' id='OTHERS_CHK' onclick='othersChkClick(); isValid(this.id); ifNone(this.id);' required>";
                    input += "<label class='custom-control-label' for='OTHERS_CHK'>"+value+"</label>";
                    input += "<input type='text' class='form-control' id='OTHER_SYMP' name='OTHER_SYMP'  disabled>";
                input += "</div>";
            }
            else{
                input += "<div class='custom-control custom-checkbox'>";
                    input += "<input type='checkbox' class='custom-control-input ehc' value='"+value+"' id='SYMP_"+index+"' name='A"+label+"[]' onclick='isValid(this.id); ifNone(this.id);' required>";
                    input += "<label class='custom-control-label' for='SYMP_"+index+"'>"+value+"</label>";
                input += "</div>";
            }
        });
        input += "<input type='hidden' class='form-control ehc' name='Q"+label+"' value='"+label+"'>";
        input += "<div id='invalid_symp' class='invalid-feedback'>";
            input += "Please select at least one.";
        input += "</div>";
    }
    if(type == 4){
        input += "<select id='A"+label+"' name='A"+label+"' class='custom-select ehc' required onchange='selectValue(this)'>"
        input += "<option selected disabled value=''>--Please choose--</option>";
        $.each(JSON.parse(ans), function(index, value) {
            if(value == "Yes"){
                var val = "Y";
            }
            else{
                var val = "N";
            }
            input += "<option value='"+val+"'>"+value+"</option>";
        });
        input += "</select>";
        input += "<input type='hidden' class='form-control ehc' name='Q"+label+"' value='"+label+"'>";
        input += "<div class='invalid-feedback'>";
            input += "Please select an answer from the dropdown.";
        input += "</div>";
    }
    if(type == 5){
        if(label == 2){
            input += "<div class='form-row' id='A2WHEN_ROW1'>";
                input += "<div class='col'>";
                    input += "<div class='form-group'>";
                        input += "<label for='A2WHEN'>If YES, please specify WHEN it started:</label>";
                    input += "</div>";
                input += "</div>";
            input += "</div>";
            input += "<div class='form-row' id='A2WHEN_ROW2'>";
                input += "<div class='col-8'>";
                    input += "<div class='form-group'>";
                        input += "<input type='date' class='form-control ehc' id='A2WHEN' name='A2WHEN' onchange='checkDate(this)'>";
                        input += "<div class='invalid-feedback'>";
                            input += "This field is required.";
                        input += "</div>";
                    input += "</div>";
                input += "</div>";
            input += "</div>";
        }
        else if(label == 4){
            input += "<div class='form-row' id='A4WHERE_ROW1'>";
                input += "<div class='col'>";
                    input += "<div class='form-group'>";
                        input += "<label for='A4WHERE'>If YES, please specify WHERE:</label>";
                    input += "</div>";
                input += "</div>";
            input += "</div>";
            input += "<div class='form-row' id='A4WHERE_ROW2'>";
                input += "<div class='col-8'>";
                    input += "<div class='form-group'>";
                        input += "<input type='text' class='form-control ehc' id='A4WHERE' name='A4WHERE'>";
                        input += "<div class='invalid-feedback'>";
                            input += "This field is required.";
                        input += "</div>";
                    input += "</div>";
                input += "</div>";
            input += "</div>";
            input += "<div class='form-row' id='A4WHEN_ROW1'>";
                input += "<div class='col'>";
                    input += "<div class='form-group'>";
                        input += "<label for='A4WHEN'>If YES, please specify WHEN:</label>";
                    input += "</div>";
                input += "</div>";
            input += "</div>";
            input += "<div class='form-row'>";
                input += "<div class='col-8'>";
                    input += "<div class='form-group' id='A4WHEN_ROW2'>";
                        input += "<input type='date' class='form-control ehc' id='A4WHEN' name='A4WHEN' onchange='checkDate(this)'>";
                        input += "<div class='invalid-feedback'>";
                            input += "This field is required.";
                        input += "</div>";
                    input += "</div>";
                input += "</div>";
            input += "</div>";
        }
        else if(label == 5){
            input += "<div class='form-row' id='A5WHEN_ROW1'>";
                input += "<div class='col'>";
                    input += "<div class='form-group'>";
                        input += "<label for='A5WHEN'>If YES, please specify WHEN:</label>";
                    input += "</div>";
                input += "</div>";
            input += "</div>";
            input += "<div class='form-row' id='A5WHEN_ROW2'>";
                input += "<div class='col-8'>";
                    input += "<div class='form-group'>";
                        input += "<input type='date' class='form-control ehc' id='A5WHEN' name='A5WHEN' onchange='checkDate(this)'>";
                        input += "<div class='invalid-feedback'>";
                            input += "This field is required.";
                        input += "</div>";
                    input += "</div>";
                input += "</div>";
            input += "</div>";
        }
    }
    return input;
}

function othersChkClick(){
    if($("#OTHERS_CHK").prop('checked')){
        $("#OTHER_SYMP").prop('disabled', false);
        $("#OTHER_SYMP").prop('required', true);
    }
    else{
        $("#OTHER_SYMP").prop('disabled', true);
        $("#OTHER_SYMP").prop('required', false);
    }
}

function isValid(id){
    if(submitted){
        if($("#"+id).prop('checked') && $(".custom-control-input:checked").length > 0){
            $("#invalid_symp").hide();
        }
        else if($("#"+id).prop('checked') == false && $(".custom-control-input:checked").length > 0){
            $("#invalid_symp").hide();
        }
        else if($("#"+id).prop('checked') == false && $(".custom-control-input:checked").length == 0){
            $("#invalid_symp").show();
        }
    }
}

function selectValue(data){

    switch(data.id){
        case 'A2':
            var sick = $("#"+data.id).val();
            if(sick == "Y"){
                $("#A2WHEN_ROW1").show();
                $("#A2WHEN_ROW2").show();
                $("#A2WHEN").prop('disabled', false);
                $("#A2WHEN").prop('required', true);

                var now = new Date();

                var day = ("0" + now.getDate()).slice(-2);
                var month = ("0" + (now.getMonth() + 1)).slice(-2);

                var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

                $("#A2WHEN").val(today);
            }
            else{
                $("#A2WHEN_ROW1").hide();
                $("#A2WHEN_ROW2").hide();
                $("#A2WHEN").prop('disabled', true);
                $("#A2WHEN").prop('required', false);
                $("input[name='A2WHEN']").prop('disabled', true);
                $("input[name='A2WHEN']").prop('required', false);
            }
            break;
        case 'A4':
            var travel = $("#"+data.id).val();
            if(travel == "Y"){
                $("#A4WHEN_ROW1").show();
                $("#A4WHEN_ROW2").show();
                $("#A4WHEN").prop('disabled', false);
                $("#A4WHEN").prop('required', true);
                $("#A4WHERE_ROW1").show();
                $("#A4WHERE_ROW2").show();
                $("#A4WHERE").prop('disabled', false);
                $("#A4WHERE").prop('required', true);

                var now = new Date();

                var day = ("0" + now.getDate()).slice(-2);
                var month = ("0" + (now.getMonth() + 1)).slice(-2);

                var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

                $("#A4WHEN").val(today);
            }
            else{
                $("#A4WHEN_ROW1").hide();
                $("#A4WHEN_ROW2").hide();
                $("#A4WHEN").prop('disabled', true);
                $("#A4WHEN").prop('required', false);
                $("#A4WHERE_ROW1").hide();
                $("#A4WHERE_ROW2").hide();
                $("#A4WHERE").prop('disabled', true);
                $("#A4WHERE").prop('required', false);
            }
            break;
        case 'A5':
            var contact = $("#"+data.id).val();
            if(contact == "Y"){
                $("#A5WHEN_ROW1").show();
                $("#A5WHEN_ROW2").show();
                $("#A5WHEN").prop('disabled', false);
                $("#A5WHEN").prop('required', true);
            }
            else{
                $("#A5WHEN_ROW1").hide();
                $("#A5WHEN_ROW2").hide();
                $("#A5WHEN").prop('disabled', true);
                $("#A5WHEN").prop('required', false);
            }
            break;
        default:
            break;
    }
        
}

function checkDate(data){
    var d = new Date();

    var month = d.getMonth()+1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' +
        (month<10 ? '0' : '') + month + '-' +
        (day<10 ? '0' : '') + day;

    var val = $("#"+data.id).val();
    // 
    if(data.id == "A2WHEN"){
        if(val > output){
            alert("You can only enter past or current date.");
            
            var now = new Date();

            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);

            var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

            $("#A2WHEN").val(today);
        }
    }
    // travel
    if(data.id == "A4WHEN"){
        if(val > output){
            alert("You can only enter past or current date.");

            var now = new Date();

            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);

            var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

            $("#A4WHEN").val(today);
        }
    }
    if(data.id == "A5WHEN"){
        if(val > output){
            alert("You can only enter past or current date.");
            $("#"+data.id).val("");
        }
    }
}

function isNumber(evt){
    var charCode = event.keyCode;
    if ((charCode < 48 || charCode > 57) && (charCode < 96 || charCode > 105) && (charCode != 110) && (charCode != 190) && (charCode != 8)){
        return false;
    }
    return true;
}

function checkDecimalNumbers(id){
    var element = $("#"+id);

    var value = element.val();

    if(value.indexOf('.') === -1){
        if(value.length > 2){
            alert("Temperature is limited to 2 digits (excluding period (.) and decimal number/s).");
            element.val(value[0]+value[1]);
        }
    }    
    else{    
        var decimal_num = value.split(".");
        if(decimal_num[1].length > 2 || value.indexOf('.') === -1){
            alert("Decimal number is limited to 2 digits.");
            element.val(decimal_num[0]+"."+decimal_num[1][0]+decimal_num[1][1]);
        }
    }
}

function ifNone(id){
    if(id == "SYMP_11"){
        if($("#SYMP_11").prop('checked')){
            $("#OTHER_SYMP").prop('disabled', true);
            $("#OTHER_SYMP").prop('required', false);
            $("#SYMP_1").prop('disabled', true);
            $("#SYMP_2").prop('disabled', true);
            $("#SYMP_3").prop('disabled', true);
            $("#SYMP_4").prop('disabled', true);
            $("#SYMP_5").prop('disabled', true);
            $("#SYMP_6").prop('disabled', true);
            $("#SYMP_7").prop('disabled', true);
            $("#SYMP_8").prop('disabled', true);
            $("#SYMP_9").prop('disabled', true);
            $("#SYMP_10").prop('disabled', true);
            $("#OTHERS_CHK").prop('disabled', true);
        }
        else{
            $("#OTHER_SYMP").prop('disabled', true);
            $("#OTHER_SYMP").prop('required', false);
            $("#SYMP_1").prop('disabled', false);
            $("#SYMP_2").prop('disabled', false);
            $("#SYMP_3").prop('disabled', false);
            $("#SYMP_4").prop('disabled', false);
            $("#SYMP_5").prop('disabled', false);
            $("#SYMP_6").prop('disabled', false);
            $("#SYMP_7").prop('disabled', false);
            $("#SYMP_8").prop('disabled', false);
            $("#SYMP_9").prop('disabled', false);
            $("#SYMP_10").prop('disabled', false);
            $("#OTHERS_CHK").prop('disabled', false);
        }
    }
    else{
        if($("#"+id).prop('checked')){
            $("#SYMP_11").prop('disabled', true);
        }
        else{
            var x = $(".custom-control-input:checked").length;
            if(x < 1){
                $("#SYMP_11").prop('disabled', false);
            }
            else{
                $("#SYMP_11").prop('disabled', true);
            }
        }
    }
}

function checkDecimalPoint(id){
    element = $("#"+id);
    element.val(element.val().match(/\d*\.?\d+/));
}
