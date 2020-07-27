
var submitted = 0;
var editted = 0;
var server_time = 0;

$(document).ready(function(){
    
    $('#hdf_modal').on('hidden.bs.modal', function (e) {
        location.reload();
    });

    // hide add/view form

    $("#form_div").hide();
    $("#view_div").hide();

    // datatable initialize
    $('#hdf_tbl').DataTable( {
        "order": [[ 1, "desc" ]],
        responsive: {
            details: false
        },
        "ajax": {
            "url": "api/hdf",
            "type": "GET"
        },
        "columns": [
            {"data": "HDF_ID"},
            {"data": "HDF_DATE"},
            {"data": "COMPLETION_DATE"},
            {"data": "FEVER"},
            {"data": "TRAVEL_HIST"},
            {"data": "PLACE_FROM"},
            {"data": "TRAVEL_SCHED"},
            {"data": "TRAVEL_DATE"},
            {"data": "PLACE_TOGO"},
            {"data": "RUSHNO"},
            {"data": "STATUS"},
        ],
        columnDefs: [
            { 
                targets: 0,
                searchable: false,
                orderable: false,
                render: function(data, type){
                   if(type === 'display'){
                      data = '<input type="radio" name="selected_hdf" value="' + data + '">';      
                   }
    
                   return data;
                }
            },
            { 
                targets: 3,
                searchable: false,
                orderable: false,
                render: function(data, type){
                   if(type === 'display'){
                       if(data == "Y"){
                           data = "Yes"
                       }
                       else{
                           data = "No" 
                       }     
                   }
    
                   return data;
                }
            },
            { 
                targets: 4,
                searchable: false,
                orderable: false,
                render: function(data, type){
                   if(type === 'display'){
                       if(data == "Y"){
                           data = "Yes"
                       }
                       else{
                           data = "No" 
                       }     
                   }
    
                   return data;
                }
            },
            { 
                targets: 6,
                searchable: false,
                orderable: false,
                render: function(data, type){
                   if(type === 'display'){
                       if(data == "Y"){
                           data = "Yes"
                       }
                       else{
                           data = "No" 
                       }     
                   }
    
                   return data;
                }
            },
            {
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                className: "text-center"
            },
            {
                targets: 0,
                orderable: false
            },
            { 
                targets: 10,
                searchable: false,
                orderable: false,
                render: function(data, type){
                   if(type === 'display'){
                       if(data == "null/undef"){
                           data = ""
                       }
                   }
                   return data;
                }
            }
        ]
    } );

    var groups = $.ajax({
        url: "api/get_group",
        method: "GET",
        dataType: "json"
    })

    groups.done(function(data){
        
        $.each(data, function (i) {
            $('#GRP_CODE').append($('<option>', { 
                value: data[i]['GRP_CODE'],
                text : data[i]['GRP_NAME'] 
            }));
        });
    });

    var groups = $.ajax({
        url: "api/get_company",
        method: "GET",
        dataType: "json"
    })

    groups.done(function(data){
        
        $.each(data, function (i) {
            $('#COMP_CODE').append($('<option>', { 
                value: data[i]['COMP_CODE'],
                text : data[i]['COMP_NAME'] 
            }));
        });
    });

    // load form fields

    var hdfhh_ajax = new XMLHttpRequest();
    var hdfhh_form = "";
    hdfhh_ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            hdfhh_form = buildRow(JSON.parse(this.response));
        }
    };
    hdfhh_ajax.open("GET", "api/questions/HDFHH", false);
    hdfhh_ajax.send();
    $("#hdfhh_form_area").html(hdfhh_form);

    var hdfhd_ajax = new XMLHttpRequest();
    var hdfhd_form = "";
    hdfhd_ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            hdfhd_form = buildRow(JSON.parse(this.response));
        }
    };
    hdfhd_ajax.open("GET", "api/questions/HDFHD", false);
    hdfhd_ajax.send();
    $("#hdfhd_form_area").html(hdfhd_form);

    var hdfth_ajax = new XMLHttpRequest();
    var hdfth_form = "";
    hdfth_ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            hdfth_form = buildRow(JSON.parse(this.response));
        }
    };
    hdfth_ajax.open("GET", "api/questions/HDFTH", false);
    hdfth_ajax.send();
    $("#hdfth_form_area").html(hdfth_form);

    var hdfoi_ajax = new XMLHttpRequest();
    var hdfoi_form = "";
    hdfoi_ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            hdfoi_form = buildRow(JSON.parse(this.response));
        }
    };
    hdfoi_ajax.open("GET", "api/questions/HDFOI", false);
    hdfoi_ajax.send();
    hdfoi_form += consentStatement();
    $("#hdfoi_form_area").html(hdfoi_form);

    // initially hide follow up questions

    $("#A6HOWMANY_ROW").hide();
    $("#A1OTHERS_ROW").hide();
    $("#A1TEMP_ROW").hide();
    $("#A4REASON_ROW").hide();
    $("#A5SYMPTOMS_ROW").hide();
    $("#A5PERIOD_ROW").hide();
    $("#A1TRAVEL_DATES_ROW").hide();
    $("#A1PLACE_ROW").hide();
    $("#A1RETURN_DATE_ROW").hide();
    $("#A2TRAVEL_DATES_ROW").hide();
    $("#A2PLACE_ROW").hide();
    $("#A2RETURN_DATE_ROW").hide();
    $("#A3CONTACT_DATE_ROW").hide();
    $("#A4NAME_ROW").hide();
    $("#A4VISIT_DATE_ROW").hide();
    $("#A1DETAILS_ROW").hide();
    $("#A2EXPOSURE_DATE_ROW").hide();
    $("#A4PLACE_ROW").hide();
    $("#A5FRONTLINER_ROW").hide();
    $("#A6OTHERS_ROW").hide();
    $("#REASON_ROW").hide();

    // field validations
    $("#A1OTHERS").prop("maxlength", 30);
    $("#HDFHH_A2").prop("maxlength", 30);
    $("#HDFHH_A3").prop("max", 100);
    $("#HDFHH_A3").on('keydown', function(event){
        return isNumber(event);
    });

    $("#HDFHH_A3").on('keydown', function(event){
        if(event.keyCode != 8){
            if($(this).val().length >= 2){
                return false;
            }
            return true;
        }
        return true;
    });

    $("#HDFHH_A4").on('keydown', function(event){
        return isNumber(event);
    });

    $("#HDFHH_A4").on('keydown', function(event){
        if(event.keyCode != 8){
            if($(this).val().length >= 2){
                return false;
            }
            return true;
        }
        return true;
    });
    
    $("#OTHER_DISEASE_HDFHH").prop('maxlength', 100);

    $("#A6HOWMANY").prop("maxlength", 2);
    $("#A6HOWMANY").on('keydown', function(event){
        return isNumber(event);
    });

    $("#A1TEMP").prop("maxlength", 5);
    $("#A1TEMP").on('keydown', function(event){
        return isTemp(event);
    });

    $("#HDFHD_A2").prop("maxlength", 30);
    $("#OTHER_DISEASE_HDFHD").prop("maxlength", 30);
    $("#A4REASON").prop("maxlength", 50);
    $("#A5SYMPTOMS").prop("maxlength", 50);
    $("#A5PERIOD").prop("maxlength", 50);
    $("#A1TRAVEL_DATES").prop("maxlength", 30);
    $("#A1PLACE").prop("maxlength", 30);
    $("#A2TRAVEL_DATES").prop("maxlength", 30);
    $("#A2PLACE").prop("maxlength", 30);
    $("#A3CONTACT_DATE").prop("maxlength", 50);
    $("#A4NAME").prop("maxlength", 50);
    $("#A1DETAILS").prop("maxlength", 50);
    $("#OTHER_DISEASE_HDFOI").prop("maxlength", 30);
    $("#A4PLACE").prop("maxlength", 50);
    $("#OTHER_FRONTLINER_VALUE").prop("maxlength", 30);
    $("#A6OTHERS").prop("maxlength", 30);
    $("#HDFOI_A7").prop("maxlength", 30);
    $("#REASON").prop("maxlength", 50);

    // fill up fields from nets_emp_info
    fillUpEmpInfo();

    // field changes
    
    $("#HDFHH_A1").on('change', function(){
        if($(this).val() == "Others"){
            $("#A1OTHERS_ROW").show();
            $("input[name='A1OTHERS'").prop('disabled', false);
            $("input[name='A1OTHERS'").prop('required', true);
        }
        else{
            $("#A1OTHERS_ROW").hide();
            $("input[name='A1OTHERS'").prop('disabled', true);
            $("input[name='A1OTHERS'").prop('required', false);
        }
    });

    $("#HDFHH_CHK_16").on('click', function(){
        if($(this).prop('checked')){
            $("#OTHER_DISEASE_HDFHH").prop('disabled', false);
            $("#OTHER_DISEASE_HDFHH").prop('required', true);
        }
        else{
            $("#OTHER_DISEASE_HDFHH").prop('disabled', true);
            $("#OTHER_DISEASE_HDFHH").prop('required', false);
        }
    });

    $("#HDFHH_A6").on('change', function(){
        if($(this).val() == "Yes"){
            $("#A6HOWMANY_ROW").show();
            $("input[name='A6HOWMANY'").prop('disabled', false);
            $("input[name='A6HOWMANY'").prop('required', true);
        }
        else{
            $("#A6HOWMANY_ROW").hide();
            $("input[name='A6HOWMANY'").prop('disabled', true);
            $("input[name='A6HOWMANY'").prop('required', false);
        }
    });

    $("#HDFHD_A1").on('change', function(){
        if($(this).val() == "Yes"){
            $("#A1TEMP_ROW").show();
            $("#A1TEMP").prop('disabled', false);
            $("#A1TEMP").prop('required', true);
        }
        else{
            $("#A1TEMP_ROW").hide();
            $("#A1TEMP").prop('disabled', true);
            $("#A1TEMP").prop('required', false);
        }
    });

    $("#HDFHD_CHK_9").on('click', function(){
        if($(this).prop('checked')){
            $("#OTHER_DISEASE_HDFHD").prop('disabled', false);
            $("#OTHER_DISEASE_HDFHD").prop('required', true);
        }
        else{
            $("#OTHER_DISEASE_HDFHD").prop('disabled', true);
            $("#OTHER_DISEASE_HDFHD").prop('required', false);
        }
    });

    $("#HDFHD_A4").on('change', function(){
        if($(this).val() == "Yes"){
            $("#A4REASON_ROW").show();
            $("#A4REASON").prop('disabled', false);
            $("#A4REASON").prop('required', true);
        }
        else{
            $("#A4REASON_ROW").hide();
            $("#A4REASON").prop('disabled', true);
            $("#A4REASON").prop('required', false);
        }
    });

    $("#HDFHD_A5").on('change', function(){
        if($(this).val() == "Yes"){
            $("#A5SYMPTOMS_ROW").show();
            $("#A5PERIOD_ROW").show();
            $("#A5SYMPTOMS").prop('disabled', false);
            $("#A5SYMPTOMS").prop('required', true);
            $("#A5PERIOD").prop('disabled', false);
            $("#A5PERIOD").prop('required', true);
        }
        else{
            $("#A5SYMPTOMS_ROW").hide();
            $("#A5PERIOD_ROW").hide();
            $("#A5SYMPTOMS").prop('disabled', true);
            $("#A5SYMPTOMS").prop('required', false);
            $("#A5PERIOD").prop('disabled', true);
            $("#A5PERIOD").prop('required', false);
        }
    });

    $("#HDFTH_A1").on('change', function(){
        if($(this).val() == "Yes"){
            $("#A1TRAVEL_DATES_ROW").show();
            $("#A1PLACE_ROW").show();
            $("#A1RETURN_DATE_ROW").show();
            $("#A1TRAVEL_DATES").prop('disabled', false);
            $("#A1TRAVEL_DATES").prop('required', true);
            $("#A1PLACE").prop('disabled', false);
            $("#A1PLACE").prop('required', true);
            $("#A1RETURN_DATE").prop('disabled', false);
            $("#A1RETURN_DATE").prop('required', true);
        }
        else{
            $("#A1TRAVEL_DATES_ROW").hide();
            $("#A1PLACE_ROW").hide();
            $("#A1RETURN_DATE_ROW").hide();
            $("#A1TRAVEL_DATES").prop('disabled', true);
            $("#A1TRAVEL_DATES").prop('required', false);
            $("#A1PLACE").prop('disabled', true);
            $("#A1PLACE").prop('required', false);
            $("#A1RETURN_DATE").prop('disabled', true);
            $("#A1RETURN_DATE").prop('required', false);
        }
    });

    $("#HDFTH_A2").on('change', function(){
        if($(this).val() == "Yes"){
            $("#A2TRAVEL_DATES_ROW").show();
            $("#A2PLACE_ROW").show();
            $("#A2RETURN_DATE_ROW").show();
            $("#A2TRAVEL_DATES").prop('disabled', false);
            $("#A2TRAVEL_DATES").prop('required', true);
            $("#A2PLACE").prop('disabled', false);
            $("#A2PLACE").prop('required', true);
            $("#A2RETURN_DATE").prop('disabled', false);
            $("#A2RETURN_DATE").prop('required', true);
        }
        else{
            $("#A2TRAVEL_DATES_ROW").hide();
            $("#A2PLACE_ROW").hide();
            $("#A2RETURN_DATE_ROW").hide();
            $("#A2TRAVEL_DATES").prop('disabled', true);
            $("#A2TRAVEL_DATES").prop('required', false);
            $("#A2PLACE").prop('disabled', true);
            $("#A2PLACE").prop('required', false);
            $("#A2RETURN_DATE").prop('disabled', true);
            $("#A2RETURN_DATE").prop('required', false);
        }
    });

    $("#HDFTH_A3").on('change', function(){
        if($(this).val() == "Yes"){
            $("#A3CONTACT_DATE_ROW").show();
            $("#A3CONTACT_DATE").prop('disabled', false);
            $("#A3CONTACT_DATE").prop('required', true);
        }
        else{
            $("#A3CONTACT_DATE_ROW").hide();
            $("#A3CONTACT_DATE").prop('disabled', true);
            $("#A3CONTACT_DATE").prop('required', false);
        }
    });

    $("#HDFTH_A4").on('change', function(){
        if($(this).val() == "Yes"){
            $("#A4NAME_ROW").show();
            $("#A4VISIT_DATE_ROW").show();
            $("#A4NAME").prop('disabled', false);
            $("#A4NAME").prop('required', true);
            $("#A4VISIT_DATE").prop('disabled', false);
            $("#A4VISIT_DATE").prop('required', true);
        }
        else{
            $("#A4NAME_ROW").hide();
            $("#A4VISIT_DATE_ROW").hide();
            $("#A4NAME").prop('disabled', true);
            $("#A4NAME").prop('required', false);
            $("#A4VISIT_DATE").prop('disabled', true);
            $("#A4VISIT_DATE").prop('required', false);
        }
    });

    $("#HDFOI_A1").on('change', function(){
        if($(this).val() == "Yes"){
            $("#A1DETAILS_ROW").show();
            $("#A1DETAILS").prop('disabled', false);
            $("#A1DETAILS").prop('required', true);
        }
        else{
            $("#A1DETAILS_ROW").hide();
            $("#A1DETAILS").prop('disabled', true);
            $("#A1DETAILS").prop('required', false);
        }
    });

    $("#HDFOI_A2").on('change', function(){
        if($(this).val() == "Yes"){
            $("#A2EXPOSURE_DATE_ROW").show();
            $("#A2EXPOSURE_DATE").prop('disabled', false);
            $("#A2EXPOSURE_DATE").prop('required', true);
        }
        else{
            $("#A2EXPOSURE_DATE_ROW").hide();
            $("#A2EXPOSURE_DATE").prop('disabled', true);
            $("#A2EXPOSURE_DATE").prop('required', false);
        }
    });
    
    $("#HDFOI_CHK_12").on('click', function(){
        if($(this).prop('checked')){
            $("#OTHER_DISEASE_HDFOI").prop('disabled', false);
            $("#OTHER_DISEASE_HDFOI").prop('required', true)
        }
        else{
            $("#OTHER_DISEASE_HDFOI").prop('disabled', true);
            $("#OTHER_DISEASE_HDFOI").prop('required', false)
        }
    });

    $("#HDFOI_A4").on('change', function(){
        if($(this).val() == "Yes"){
            $("#A4PLACE_ROW").show();
            $("#A4PLACE").prop('disabled', false);
            $("#A4PLACE").prop('required', true);
        }
        else{
            $("#A4PLACE_ROW").hide();
            $("#A4PLACE").prop('disabled', true);
            $("#A4PLACE").prop('required', false);
        }
    });

    $("#HDFOI_A5").on('change', function(){
        if($(this).val() == "Yes"){
            $("#A5FRONTLINER_ROW").show();
            $("#A5FRONTLINER").prop('disabled', false);
            $("#A5FRONTLINER").prop('required', true);
            $(".frontline_chck").prop('required', true);
        }
        else{
            $("#A5FRONTLINER_ROW").hide();
            $(".frontline_chck").prop('required', false);
        }
        $("#OTHER_FRONTLINER").on('click', function(){
            if($(this).prop('checked')){
                $("#OTHER_FRONTLINER_VALUE").prop('disabled', false);
                $("#OTHER_FRONTLINER_VALUE").prop('required', true);
            }
            else{
                $("#OTHER_FRONTLINER_VALUE").prop('disabled', true);
                $("#OTHER_FRONTLINER_VALUE").prop('required', false);
            }
        })
    });

    $("#HDFOI_A6").on('change', function(){
        if($(this).val() == "Others"){
            $("#A6OTHERS_ROW").show();
            $("#A6OTHERS").prop('disabled', false);
            $("#A6OTHERS").prop('required', true);
        }
        else{
            $("#A6OTHERS_ROW").hide();
            $("#A6OTHERS").prop('disabled', true);
            $("#A6OTHERS").prop('required', false);
        }
    });

    $("#A1TEMP").on('change', function(){
        if(parseFloat($(this).val()) < 37){
            alert("Value can't be lower than 37°");
            $(this).val("");
        }
        else{
            $(this).val($(this).val().match(/\d*\.?\d+/));

            var value = $(this).val();
            var decimal_num = value.split(".");

            if(decimal_num[1]){
                if(decimal_num[1].length > 2){
                    alert("Decimal number is limited to 2.");
                    $(this).val(decimal_num[0]+"."+decimal_num[1][0]+decimal_num[1][1]);
                }
            }
        }
    });

    $(".HDFHH_CHK").on('click', function(){
        var val = $(this).val();
        var checked = $(this).prop('checked');
        var len = $("input[name='HDFHH_A5[]']:checked").length;

        if(checked){
            if(val == "None"){
                $(".HDFHH_CHK").each(function () {
                    if ($(this).val() != "None") {
                        $(this).prop('disabled', true);
                    }
                });
            }
            else{
                $(".HDFHH_CHK").each(function () {
                    if ($(this).val() == "None") {
                        $(this).prop('disabled', true);
                    }
                });
            }
        }
        else{
            if(val == "None"){
                $(".HDFHH_CHK").each(function () {
                    if ($(this).val() != "None") {
                        $(this).prop('disabled', false);
                    }
                });
            }
            else{
                if(len < 1){
                    $("#HDFHH_CHK_15").prop('disabled', false);
                }
            }
        }
    });

    $(".HDFHD_CHK").on('click', function(){
        var val = $(this).val();
        var checked = $(this).prop('checked');
        var len = $("input[name='HDFHD_A3[]']:checked").length;

        if(checked){
            if(val == "None"){
                $(".HDFHD_CHK").each(function () {
                    if ($(this).val() != "None") {
                        $(this).prop('disabled', true);
                    }
                });
            }
            else{
                $(".HDFHD_CHK").each(function () {
                    if ($(this).val() == "None") {
                        $(this).prop('disabled', true);
                    }
                });
            }
        }
        else{
            if(val == "None"){
                $(".HDFHD_CHK").each(function () {
                    if ($(this).val() != "None") {
                        $(this).prop('disabled', false);
                    }
                });
            }
            else{
                if(len < 1){
                    $("#HDFHD_CHK_8").prop('disabled', false);
                }
            }
        }
    });

    $(".HDFOI_CHK").on('click', function(){
        var val = $(this).val();
        var checked = $(this).prop('checked');
        var len = $("input[name='HDFOI_A3[]']:checked").length;

        if(checked){
            if(val == "None"){
                $(".HDFOI_CHK").each(function () {
                    if ($(this).val() != "None") {
                        $(this).prop('disabled', true);
                    }
                });
            }
            else{
                $(".HDFOI_CHK").each(function () {
                    if ($(this).val() == "None") {
                        $(this).prop('disabled', true);
                    }
                });
            }
        }
        else{
            if(val == "None"){
                $(".HDFOI_CHK").each(function () {
                    if ($(this).val() != "None") {
                        $(this).prop('disabled', false);
                    }
                });
            }
            else{
                if(len < 1){
                    $("#HDFOI_CHK_11").prop('disabled', false);
                }
            }
        }
    });

    $("#HDFHH_A4").on('change', function(){
        var household_members = parseInt($("#HDFHH_A3").val().trim());
        var oldies = parseInt($("#HDFHH_A4").val().trim());
        if(household_members < oldies){
            alert("Value exceeded total number of person/s in your household.");
            $("#HDFHH_A4").val("");
        }
    });

    $("#A6HOWMANY").on('change', function(){
        var household_members = parseInt($("#HDFHH_A3").val().trim());
        var room_share = parseInt($("#A6HOWMANY").val().trim());
        if(household_members < room_share){
            alert("Value exceeded total number of person/s in your household.");
            $("#A6HOWMANY").val("");
        }
    });

    $("#A4VISIT_DATE").on('change', function(){
        var get_server_date = new XMLHttpRequest();
        var server_date = '';

        get_server_date.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                server_date = this.response;
            }
        };

        get_server_date.open("GET", "api/server_date", false);
        get_server_date.send();
    
        var val = $("#A4VISIT_DATE").val();

        if(val > server_date){
            alert("You can only enter past or current date.");
            $("#A4VISIT_DATE").val("");
        }
    });

    $("#A2EXPOSURE_DATE").on('change', function(){
        var get_server_date = new XMLHttpRequest();
        var server_date = '';

        get_server_date.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                server_date = this.response;
            }
        };

        get_server_date.open("GET", "api/server_date", false);
        get_server_date.send();
    
        var val = $("#A2EXPOSURE_DATE").val();

        if(val > server_date){
            alert("You can only enter past or current date.");
            $("#A2EXPOSURE_DATE").val("");
        }
    });

    $("#A1RETURN_DATE").on('change', function(){
        var get_server_date = new XMLHttpRequest();
        var server_date = '';

        get_server_date.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                server_date = this.response;
            }
        };

        get_server_date.open("GET", "api/server_date", false);
        get_server_date.send();
    
        var val = $("#A1RETURN_DATE").val();

        if(val > server_date){
            alert("You can only enter past or current date.");
            $("#A1RETURN_DATE").val("");
        }
    });

    $("#A2RETURN_DATE").on('change', function(){
        var get_server_date = new XMLHttpRequest();
        var server_date = '';

        get_server_date.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                server_date = this.response;
            }
        };

        get_server_date.open("GET", "api/server_date", false);
        get_server_date.send();
    
        var val = $("#A2RETURN_DATE").val();

        if(val < server_date){
            alert("You can only enter current or future date.");
            $("#A2RETURN_DATE").val("");
        }
    });

    $("#HDFHH_A2").prop('required', false);
    $("#HDFHD_A2").prop('required', false);

    $("#A1TEMP").prop("maxlength", 5);
    $("#A1TEMP").on('change', function(){
        $(this).val($(this).val().match(/\d*\.?\d+/));
        var value = $(this).val();
        if(value.indexOf('.') === -1){
            if(value.length > 2){
                alert("Temperature is limited to 2 digits (excluding period (.) and decimal number/s).");
                $(this).val(value[0]+value[1]);
            }
        }    
        else{    
            var decimal_num = value.split(".");
            if(decimal_num[1].length > 2 || value.indexOf('.') === -1){
                alert("Decimal number is limited to 2 digits.");
                $(this).val(decimal_num[0]+"."+decimal_num[1][0]+decimal_num[1][1]);
            }
        }
    });

    
    var emp_info = $.ajax({
        url: "api/get_submitted_hdf",
        method: "GET",
        dataType: "json"
    })

    emp_info.done(function(data){
        if(data[0]['SUBMITTED_HDF'] == 1){
            $("#tbl_add").prop('disabled', true);
        }
        else{
            var cutoff_details = $.ajax({
                url: "api/get_hdf_cutoff_details",
                method: "GET",
                dataType: "json"
            });
        
            cutoff_details.done(function(data){
                if(data.length > 0){
                    $("#cutoff_id").val(data[0]['CUTOFFID']);
                    if(data[0]['EMP_FLAG'] == 1){
                        $("#tbl_add").prop('disabled', false);
                    }
                    else if(data[0]['EMP_FLAG'] == 2){
                        var required_emps = $.ajax({
                            url: "api/get_required_emps/"+data[0]['CUTOFFID'],
                            method: "GET",
                            dataType: "json"
                        });
            
                        required_emps.done(function(data){
                            for(var x = 0; x < data.length; x++){
            
                                if(data[x]['EMP_CODE'] == $("#EMP_CODE").val()){
                                    $("#tbl_add").prop('disabled', false);
                                }
                            }
                        });
                    }
                }
                else{
                    $("#tbl_add").prop('disabled', true);
                }
            });
        }
    });

    

    $("#tbl_add").on('click', function(){
        // added form reset on click of add button 7/6/2020
        $('#hdf_form').trigger("reset");
        fillUpEmpInfo();
        $("#tbl_div").hide();
        $("#form_div").show();

        var get_server_time = $.ajax({
            url: "api/server_time",
            method: "GET",
            dataType: "json",
            async: false
        });
    
        get_server_time.done(function(data){
            server_time = data;
        })
    
        var sched =  $.ajax({
            url: "api/get_hdf_cutoff",
            method: "GET",
            dataType: "json"
        });
    
        sched.done(function(data){
            var today = new Date();
            var now = today.getMilliseconds();
            if(server_time > data){
                $("#REASON_ROW").show();
                $("#REASON").prop('disabled', false);
                $("#REASON").prop('required', true);
            }
            else{
                $("#REASON_ROW").hide();
                $("#REASON").prop('disabled', true);
                $("#REASON").prop('required', false);
            }
        });

        
        
    });

    $("#tbl_edit").on('click', function(){
        var hdf_id = $("input[name='selected_hdf']:checked").val();
        if(hdf_id !== undefined){

            var hdf_details = $.ajax({
                url: "api/hdf/"+hdf_id,
                method: "GET",
                dataType: "json"
            });

            var server_date = "";
            var get_server_date = $.ajax({
                url: "api/server_date/",
                method: "GET",
                async: false
            });

            get_server_date.done(function(data){
                server_date = data;
            });
                
            hdf_details.done(function(data){
                if(data[0]['HDF_DATE'] < server_date || data[0]['STATUS'] == "I" || data[0]['STATUS'] == "A" || data[0]['STATUS'] == "R" || data[0]['STATUS'] == "C"){
                    alert("You can't edit this record.");
                }
                else{
                    editted = 1;
                    fillUpEmpInfo();
                    $("#tbl_div").hide();
                    $("#form_div").show();
                    
                    // get saved values
                    var hh_details = $.ajax({
                        url: "api/hh/"+hdf_id,
                        method: "GET",
                        dataType: "json"
                    });
        
                    hh_details.done(function(data){
        
                        $("input[name='HDFHH_Q1']").val(data[0]['Q1']);
                        if(data[0]['A1'] == "Residential House"){
                            $("#HDFHH_A1").val(data[0]['A1']);
                        }
                        else if(data[0]['A1'] == "Townhouse"){
                            $("#HDFHH_A1").val(data[0]['A1']);
                        }
                        else if(data[0]['A1'] == "Bed space"){
                            $("#HDFHH_A1").val(data[0]['A1']);
                        }
                        else if(data[0]['A1'] == "Apartment/Condo"){
                            $("#HDFHH_A1").val(data[0]['A1']);
                        }
                        else if(data[0]['A1'] == "Boarding House"){
                            $("#HDFHH_A1").val(data[0]['A1']);
                        }
                        else{
                            $("#HDFHH_A1").val("Others");
                            $("#HDFHH_A1").trigger('change');
                            $("#A1OTHERS").val(data[0]['A1']);
                        }
                        
                        // if(data[0]['A1'] !== "Residential House" || data[0]['A1'] != "Townhouse" || data[0]['A1'] != "Bed space" || data[0]['A1'] != "Apartment/Condo" || data[0]['A1'] != "Boarding House"){
                        //     $("#HDFHH_A1").val("Others");
                        //     $("#HDFHH_A1").trigger('change');
                        //     $("#A1OTHERS").val(data[0]['A1']);
                        // }
                        // else{
                        //     $("#HDFHH_A1").val(data[0]['A1']);
                        // }
        
                        $("input[name='HDFHH_Q2']").val(data[0]['Q2']);
                        $("#HDFHH_A2").val(data[0]['A2']);
        
                        $("input[name='HDFHH_Q3']").val(data[0]['Q3']);
                        $("#HDFHH_A3").val(data[0]['A3']);
                        
                        $("input[name='HDFHH_Q4']").val(data[0]['Q4']);
                        $("#HDFHH_A4").val(data[0]['A4']);
        
                        $("input[name='HDFHH_Q5']").val(data[0]['Q5']);
        
                        $("input[name='HDFHH_Q6']").val(data[0]['Q6']);
                        if(data[0]['A6'] == "Y"){
                            $("#HDFHH_A6").val("Yes");
                            $("#HDFHH_A6").trigger('change');
                            $("#A6HOWMANY").val(data[0]['A6HOWMANY']);
                        }
                        else{
                            $("#HDFHH_A6").val("No");
                            $("#HDFHH_A6").trigger('change');
                        }
                        
        
                    });
        
                    var hhcd_details = $.ajax({
                        url: "api/hhcd/"+hdf_id,
                        method: "GET",
                        dataType: "json"
                    });
        
                    hhcd_details.done(function(data){
                        
                        for(var x = 0; x < data.length; x++){
                            var done = 0;
                            $("input[name='HDFHH_A5[]']").filter(function(){
                                if(this.value === data[x]['DISEASE']){
                                    done = 1;
                                    var val = data[x]['DISEASE'];
                                    if(val == "None"){
                                        $(".HDFHH_CHK").each(function () {
                                            if ($(this).val() != "None") {
                                                $(this).prop('disabled', true);
                                            }
                                        });
                                    }
                                    else{
                                        $(".HDFHH_CHK").each(function () {
                                            if ($(this).val() == "None") {
                                                $(this).prop('disabled', true);
                                            }
                                        });
                                    }
                                    return true;
                                }
                                return false;
                            }).prop('checked', true);
                            
                            if(!done){
                                $("#HDFHH_CHK_16").filter(function(){
                                    done = 1;
                                    var val = data[x]['DISEASE'];
                                    if(val == "None"){
                                        $(".HDFHH_CHK").each(function () {
                                            if ($(this).val() != "None") {
                                                $(this).prop('disabled', true);
                                            }
                                        });
                                    }
                                    else{
                                        $(".HDFHH_CHK").each(function () {
                                            if ($(this).val() == "None") {
                                                $(this).prop('disabled', true);
                                            }
                                        });
                                    }
                                    return this.value === "Others" || this.value === "Other";
                                }).prop('checked', true);
                                $("#OTHER_DISEASE_HDFHH").prop("disabled", false);
                                $("#OTHER_DISEASE_HDFHH").val(data[x]['DISEASE']);
                            }
                            else{
                                $("#OTHER_DISEASE_HDFHH").prop("disabled", true);
                            }
                        }
                    });
        
                    var hd_details = $.ajax({
                        url: "api/hd/"+hdf_id,
                        method: "GET",
                        dataType: "json"
                    });
        
                    hd_details.done(function(data){
                        
                        $("input[name='HDFHD_Q1']").val(data[0]['Q1']);
                        if(data[0]['A1'] == "Y"){
                            $("#HDFHD_A1").val("Yes");
                            $("#HDFHD_A1").trigger('change');
                            $("#A1TEMP").val(data[0]['A1TEMP']);
                        }
                        else{
                            $("#HDFHD_A1").val("No");
                            $("#HDFHD_A1").trigger('change');
                        }
        
                        $("input[name='HDFHD_Q2']").val(data[0]['Q2']);
                        $("#HDFHD_A2").val(data[0]['A2']);
        
                        $("input[name='HDFHD_Q3']").val(data[0]['Q3']);
                        var disease = JSON.parse(data[0]['A3']);
                        for(var x = 0; x < disease.length; x++){
                            var done = 0;
                            
                            $("input[name='HDFHD_A3[]']").filter(function(){
                                if(this.value === disease[x]){
                                    done = 1;
                                    var val = disease[x];

                                    if(val == "None"){
                                        $(".HDFHD_CHK").each(function () {
                                            if ($(this).val() != "None") {
                                                $(this).prop('disabled', true);
                                            }
                                        });
                                    }
                                    else{
                                        $(".HDFHD_CHK").each(function () {
                                            if ($(this).val() == "None") {
                                                $(this).prop('disabled', true);
                                            }
                                        });
                                    }
                                    return true;
                                }
                                return false;
                            }).prop('checked', true);
                            if(!done){
                                $("#HDFHD_CHK_9").filter(function(){
                                    done = 1;
                                    var val = disease[x];
                                    if(val == "None"){
                                        $(".HDFHD_CHK").each(function () {
                                            if ($(this).val() != "None") {
                                                $(this).prop('disabled', true);
                                            }
                                        });
                                    }
                                    else{
                                        $(".HDFHD_CHK").each(function () {
                                            if ($(this).val() == "None") {
                                                $(this).prop('disabled', true);
                                            }
                                        });
                                    }
                                    return this.value === "Others" || this.value === "Other";
                                }).prop('checked', true);
                                $("#OTHER_DISEASE_HDFHD").prop("disabled", false);
                                $("#OTHER_DISEASE_HDFHD").val(disease[x]);
                            }
                            else{
                                $("#OTHER_DISEASE_HDFHD").prop("disabled", true);
                            }
                        }
        
                        $("input[name='HDFHD_Q4']").val(data[0]['Q4']);
                        if(data[0]['A4'] == "Y"){
                            $("#HDFHD_A4").val("Yes");
                            $("#HDFHD_A4").trigger('change');
                            $("#A4REASON").val(data[0]['A4REASON']);
                        }
                        else{
                            $("#HDFHD_A4").val("No");
                            $("#HDFHD_A4").trigger('change');
                        }
                        
                        $("input[name='HDFHD_Q5']").val(data[0]['Q5']);
                        if(data[0]['A5'] == "Y"){
                            $("#HDFHD_A5").val("Yes");
                            $("#HDFHD_A5").trigger('change');
                            $("#A5PERIOD").val(data[0]['A5PERIOD']);
                            $("#A5SYMPTOMS").val(data[0]['A5SYMPTOMS']);
                        }
                        else{
                            $("#HDFHD_A5").val("No");
                            $("#HDFHD_A5").trigger('change');
                        }
                    });
        
                    var th_details = $.ajax({
                        url: "api/th/"+hdf_id,
                        method: "GET",
                        dataType: "json"
                    });
            
                    th_details.done(function(data){
            
                        $("input[name='HDFTH_Q1']").val(data[0]['Q1']);
                        if(data[0]['A1'] == "Y"){
                            $("#HDFTH_A1").val("Yes");
                            $("#HDFTH_A1").trigger('change');
                            $("#A1PLACE").val(data[0]['A1PLACE']);
                            $("#A1RETURN_DATE").val(data[0]['A1RETURN_DATE']);
                            $("#A1TRAVEL_DATES").val(data[0]['A1TRAVEL_DATES']);
                        }
                        else{
                            $("#HDFTH_A1").val("No");
                            $("#HDFTH_A1").trigger('change');
                        }
            
                        $("input[name='HDFTH_Q2']").val(data[0]['Q2']);
                        if(data[0]['A2'] == "Y"){
                            $("#HDFTH_A2").val("Yes");
                            $("#HDFTH_A2").trigger('change');
                            $("#A2PLACE").val(data[0]['A2PLACE']);
                            $("#A2RETURN_DATE").val(data[0]['A2RETURN_DATE']);
                            $("#A2TRAVEL_DATES").val(data[0]['A2TRAVEL_DATES']);
                        }
                        else{
                            $("#HDFTH_A2").val("No");
                            $("#HDFTH_A2").trigger('change');
                        }
            
                        $("input[name='HDFTH_Q3']").val(data[0]['Q3']);
                        if(data[0]['A3'] == "Y"){
                            $("#HDFTH_A3").val("Yes");
                            $("#HDFTH_A3").trigger('change');
                            $("#A3CONTACT_DATE").val(data[0]['A3CONTACT_DATE']);
                        }
                        else{
                            $("#HDFTH_A3").val("No");
                            $("#HDFTH_A3").trigger('change');
                        }
            
                        $("input[name='HDFTH_Q4']").val(data[0]['Q4']);
                        if(data[0]['A4'] == "Y"){
                            $("#HDFTH_A4").val("Yes");
                            $("#HDFTH_A4").trigger('change');
                            $("#A4NAME").val(data[0]['A4NAME']);
                            $("#A4VISIT_DATE").val(data[0]['A4VISIT_DATE']);
                        }
                        else{
                            $("#HDFTH_A4").val("No");
                            $("#HDFTH_A4").trigger('change');
                        }
                    });
            
                    var oi_details = $.ajax({
                        url: "api/oi/"+hdf_id,
                        method: "GET",
                        dataType: "json"
                    });
            
                    oi_details.done(function(data){
            
                        $("input[name='HDFOI_Q1']").val(data[0]['Q1'])
                        if(data[0]['A1'] == "Y"){
                            $("#HDFOI_A1").val("Yes");
                            $("#HDFOI_A1").trigger('change');
                            $("#A1DETAILS").val(data[0]['A1DETAILS']);
                        }
                        else{
                            $("#HDFOI_A1").val("No");
                            $("#HDFOI_A1").trigger('change');
                        }
            
                        $("input[name='HDFOI_Q2']").val(data[0]['Q2'])
                        if(data[0]['A2'] == "Y"){
                            $("#HDFOI_A2").val("Yes");
                            $("#HDFOI_A2").trigger('change');
                            $("#A2EXPOSURE_DATE").val(data[0]['A2EXPOSURE_DATE']);
                        }
                        else{
                            $("#HDFOI_A2").val("No");
                            $("#HDFOI_A2").trigger('change');
                        }
            
                        $("input[name='HDFOI_Q3']").val(data[0]['Q3']);
                        var disease = JSON.parse(data[0]['A3']);
                        for(var x = 0; x < disease.length; x++){
                            var done = 0;
                            $("input[name='HDFOI_A3[]']").filter(function(){
                                if(this.value === disease[x]){
                                    done = 1;
                                    var val = disease[x];
                                    if(val == "None"){
                                        $(".HDFOI_CHK").each(function () {
                                            if ($(this).val() != "None") {
                                                $(this).prop('disabled', true);
                                            }
                                        });
                                    }
                                    else{
                                        $(".HDFOI_CHK").each(function () {
                                            if ($(this).val() == "None") {
                                                $(this).prop('disabled', true);
                                            }
                                        });
                                    }
                                    return true;
                                }
                                return false;
                            }).prop('checked', true);
                            
                            if(!done){
                                $("#HDFOI_CHK_12").filter(function(){
                                    done = 1;
                                    var val = disease[x];
                                    if(val == "None"){
                                        $(".HDFOI_CHK").each(function () {
                                            if ($(this).val() != "None") {
                                                $(this).prop('disabled', true);
                                            }
                                        });
                                    }
                                    else{
                                        $(".HDFOI_CHK").each(function () {
                                            if ($(this).val() == "None") {
                                                $(this).prop('disabled', true);
                                            }
                                        });
                                    }
                                    return this.value === "Others" || this.value === "Others";
                                }).prop('checked', true);
                                $("#OTHER_DISEASE_HDFOI").prop("disabled", false);
                                $("#OTHER_DISEASE_HDFOI").val(disease[x]);
                            }
                            else{
                                $("#OTHER_DISEASE_HDFOI").prop("disabled", true);
                            }
                        }
            
                        $("input[name='HDFOI_Q4']").val(data[0]['Q4']);
                        if(data[0]['A4'] == "Yes"){
                            $("#HDFOI_A4").val("Yes");
                            $("#HDFOI_A4").trigger('change');
                            $("#A4PLACE").val(data[0]['A4PLACE']);
                        }
                        else{
                            $("#HDFOI_A4").val("No");
                            $("#HDFOI_A4").trigger('change');
                        }
            
                        $("input[name='HDFOI_Q5']").val(data[0]['Q5']);
                        if(data[0]['A5'] == "Yes"){
                            $("#HDFOI_A5").val("Yes");
                            $("#HDFOI_A5").trigger('change');
                            var frontliner = JSON.parse(data[0]['A5FRONTLINER']);
                            for(var x = 0; x < frontliner.length; x++){
                                var done = 0;
                                $("input[name='A5FRONTLINER[]']").filter(function(){
                                    if(this.value === frontliner[x]){
                                        done = 1;
                                        return true;
                                    }
                                    return false;
                                }).prop('checked', true);
                                if(!done){
                                    $("#OTHER_FRONTLINER").filter(function(){
                                        done = 1;
                                        return this.value === "Other" || this.value === "Other";
                                    }).prop('checked', true);
                                    $("#OTHER_FRONTLINER_VALUE").prop("disabled", false);
                                    $("#OTHER_FRONTLINER_VALUE").val(frontliner[x]);
                                }
                                else{
                                    $("#OTHER_FRONTLINER_VALUE").prop("disabled", true);
                                }
                            }
                        }
                        else{
                            $("#HDFOI_A5").val("No");
                            $("#HDFOI_A5").trigger('change');
                        }
            
                        $("input[name='HDFOI_Q6']").val(data[0]['Q6']);
                        
                        if(data[0]['A6'] == "Everyday" || data[0]['A6'] == "Twice a week" || data[0]['A6'] == "Once a week"){
                            $("#HDFOI_A6").val(data[0]['A6']);
                            
                        }
                        else{
                            $("#HDFOI_A6").val("Others");
                            $("#HDFOI_A6").trigger('change');
                            $("#A6OTHERS").val(data[0]['A6']);
                        }
            
                        $("input[name='HDFOI_Q7']").val(data[0]['Q7']);
                        $("#HDFOI_A7").val(data[0]['A7']);
                    });
        
                    var hdf_details = $.ajax({
                        url: "api/hdf/"+hdf_id,
                        method: "GET",
                        dataType: "json"
                    });
        
                    hdf_details.done(function(data){
                        
                        if(data[0]['HEALTH_DEC']){
                            $("#consent").prop("checked", true);
                        }
                        else{
                            $("#consent").prop("checked", false);
                        }
        
                        if(data[0]['REASON'] != null){
                            $("#REASON_ROW").show();
                            $("#REASON").prop('disabled', false);
                            $("#REASON").prop('required', true);
                            $("#REASON").val(data[0]['REASON']);
                        }
                        else{
                            $("#REASON_ROW").hide();
                            $("#REASON").prop('disabled', true);
                            $("#REASON").prop('required', false);
                        }
        
                        $("#hdf_id").prop('disabled', false);
                        $("#hdf_id").val(data[0]['HDF_ID']);
                    });
                }
            });
            
        }
    });

    $("#tbl_view").on('click', function(){
        var hdf_id = $("input[name='selected_hdf']:checked").val();
        
        if(hdf_id !== undefined){
            $("#tbl_div").hide();
            $("#view_div").show();
            fillUpEmpInfo();

            var hdf_details = $.ajax({
                url: "api/hdf/"+hdf_id,
                method: "GET",
                dataType: "json"
            });

            hdf_details.done(function(data){
                $("#hdf_date").val(data[0]['HDF_DATE']);
                var input = "";
                if(data[0]['REASON'] != null){
                    input += "<div class='form-group' id='REASON_ROW'>";
                        input += "<label for='reason'>Reason for late filing</label>";
                            input += "<div>"+data[0]['REASON']+"</div>";
                        input += "<div class='invalid-feedback'>";
                            input += "This field is required.";
                        input += "</div>";
                    input += "</div>";
                }
                $("#hdfoi_view_area").append(input);
                input = "";
                if(data[0]['HEALTH_DEC']){
                    input += "<div class='form-group'>";
                        input += "<label>Employee Declaration</label>";
                        input += "<div class='custom-control custom-checkbox'>";
                            input += "<input checked required type='checkbox' class='custom-control-input consent' id='consent' name='consent' value='1'>";
                            input += "<label class='custom-control-label' for='consent'>I declare that the information given within this Employee Declaration of Health is true and complete to the best of my knowledge. I allow Federal Land, Inc. to seek further information about my health using the result of this survey for any purpose deemed appropriate and necessary.</label>";
                        input += "</div>";
                        input += "<div class='invalid-feedback'>";
                            input += "This field is required.";
                        input += "</div>";
                    input += "</div>";
                }
                else{
                    input += "<div class='form-group'>";
                        input += "<label>Employee Declaration</label>";
                        input += "<div class='custom-control custom-checkbox'>";
                            input += "<input required type='checkbox' class='custom-control-input consent' id='consent' name='consent' value='1'>";
                            input += "<label class='custom-control-label' for='consent'>I declare that the information given within this Employee Declaration of Health is true and complete to the best of my knowledge. I allow Federal Land, Inc. to seek further information about my health using the result of this survey for any purpose deemed appropriate and necessary.</label>";
                        input += "</div>";
                        input += "<div class='invalid-feedback'>";
                            input += "This field is required.";
                        input += "</div>";
                    input += "</div>";
                }
                $("#hdfoi_view_area").append(input)
                
            });
            
            var hh_details = $.ajax({
                url: "api/hh/"+hdf_id,
                method: "GET",
                dataType: "json"
            });

            var hdfhh_ajax = new XMLHttpRequest();
            var hdfhh_form = "";
            hdfhh_ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    hdfhh_form = buildView(JSON.parse(this.response));
                }
            };
            hdfhh_ajax.open("GET", "api/questions/HDFHH", false);
            hdfhh_ajax.send();
            $("#hdfhh_view_area").html(hdfhh_form);

            var hdfhd_ajax = new XMLHttpRequest();
            var hdfhd_form = "";
            hdfhd_ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    hdfhd_form = buildView(JSON.parse(this.response));
                }
            };
            hdfhd_ajax.open("GET", "api/questions/HDFHD", false);
            hdfhd_ajax.send();
            $("#hdfhd_view_area").html(hdfhd_form);

            var hdfth_ajax = new XMLHttpRequest();
            var hdfth_form = "";
            hdfth_ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    hdfth_form = buildView(JSON.parse(this.response));
                }
            };
            hdfth_ajax.open("GET", "api/questions/HDFTH", false);
            hdfth_ajax.send();
            $("#hdfth_view_area").html(hdfth_form);

            var hdfoi_ajax = new XMLHttpRequest();
            var hdfoi_form = "";
            hdfoi_ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    hdfoi_form = buildView(JSON.parse(this.response));
                }
            };
            hdfoi_ajax.open("GET", "api/questions/HDFOI", false);
            hdfoi_ajax.send();
            
            $("#hdfoi_view_area").html(hdfoi_form);
            

            hh_details.done(function(data){

                

                if(data[0]['A1'] == "Others"){
                    var row = "";
                    row += "Others";
                    row += "<div class='form-group'>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>Please specify type of residence</label>";
                                row += "<div>"+data[0]['A1']+"</div>";
                            row += "</div>";
                        row += "</div>";
                    row += "</div>";
                    $("#HDFHHA1").html(row);
                }
                else{
                    $("#HDFHHA1").html(data[0]['A1']);
                }

                $("#HDFHHA2").html(data[0]['A2']);

                $("#HDFHHA3").html(data[0]['A3']);
                
                $("#HDFHHA4").html(data[0]['A4']);

                if(data[0]['A6'] == "Y"){
                    var row = "";
                    row += "Yes";
                    row += "<div class='form-group'>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>If yes, how many?</label>";
                                row += "<div>"+data[0]['A6HOWMANY']+"</div>";
                            row += "</div>";
                        row += "</div>";
                    row += "</div>";
                    $("#HDFHHA6").html(row);
                }
                else{
                    $("#HDFHHA6").html("No");
                }
                

            });

            var hhcd_details = $.ajax({
                url: "api/hhcd/"+hdf_id,
                method: "GET",
                dataType: "json"
            });

            hhcd_details.done(function(data){
                var row = "";
                row += "<ul>";
                for(var x = 0; x < data.length; x++){
                    row += "<li>"+data[x]['DISEASE']+"</li>";
                }
                row += "<ul>";
                $("#HDFHHA5").html(row);
            });

            var hd_details = $.ajax({
                url: "api/hd/"+hdf_id,
                method: "GET",
                dataType: "json"
            });

            hd_details.done(function(data){
                
                if(data[0]['A1'] == "Y"){
                    var row = "";
                    row += "Yes";
                    row += "<div class='form-group'>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>If yes, what is your highest body temperature?</label>";
                                row += "<div>"+data[0]['A1TEMP']+"</div>";
                            row += "</div>";
                        row += "</div>";
                    row += "</div>";
                    $("#HDFHDA1").html(row);
                }
                else{
                    $("#HDFHDA1").html("No");
                }

                $("#HDFHDA2").html(data[0]['A2']);

                var row = "";
                row += "<ul>";
                var disease = JSON.parse(data[0]['A3']);
                for(var x = 0; x < disease.length; x++){
                    row += "<li>"+ disease[x]+"</li>";
                }
                row += "</ul>";
                $("#HDFHDA3").html(row);

                if(data[0]['A4'] == "Y"){

                    var row = "";
                    row += "Yes";
                    row += "<div class='form-group'>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>If yes, please specify the reason of the medical test</label>";
                                row += "<div>"+data[0]['A4REASON']+"</div>";
                            row += "</div>";
                        row += "</div>";
                    row += "</div>";
                    $("#HDFHDA4").html(row);
                }
                else{
                    $("#HDFHDA4").html("No");
                }
                
                if(data[0]['A5'] == "Y"){
                    var row = "";
                    row += "Yes";
                    row += "<div class='form-group'>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>If yes, please specify the symptoms/recurring pain/complaints</label>";
                                row += "<div>"+data[0]['A5SYMPTOMS']+"</div>";
                            row += "</div>";
                        row += "</div>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>If yes, please specify the period of sickness</label>";
                                row += "<div>"+data[0]['A5PERIOD']+"</div>";
                            row += "</div>";
                        row += "</div>";
                    row += "</div>";
                    $("#HDFHDA5").html(row);
                }
                else{
                    $("#HDFHDA5").html("No");
                }
            });

            var th_details = $.ajax({
                url: "api/th/"+hdf_id,
                method: "GET",
                dataType: "json"
            });
    
            th_details.done(function(data){
    
                if(data[0]['A1'] == "Y"){

                    var row = "";
                    row += "Yes";
                    row += "<div class='form-group'>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>If yes, please state the travel dates</label>";
                                row += "<div>"+data[0]['A1TRAVEL_DATES']+"</div>";
                            row += "</div>";
                        row += "</div>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>State the exact place of travel</label>";
                                row += "<div>"+data[0]['A1PLACE']+"</div>";
                            row += "</div>";
                        row += "</div>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>Date of return to PH/Metro Manila</label>";
                                row += "<div>"+data[0]['A1RETURN_DATE']+"</div>";
                            row += "</div>";
                        row += "</div>";
                    row += "</div>";
                    $("#HDFTHA1").html(row);                    
                }
                else{
                    $("#HDFTHA1").html("No");
                }
    
                if(data[0]['A2'] == "Y"){
                    var row = "";
                    row += "Yes";
                    row += "<div class='form-group'>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>If yes, please state the travel dates</label>";
                                row += "<div>"+data[0]['A2TRAVEL_DATES']+"</div>";
                            row += "</div>";
                        row += "</div>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>State the exact place of travel</label>";
                                row += "<div>"+data[0]['A2PLACE']+"</div>";
                            row += "</div>";
                        row += "</div>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>Date of return to PH/Metro Manila</label>";
                                row += "<div>"+data[0]['A2RETURN_DATE']+"</div>";
                            row += "</div>";
                        row += "</div>";
                    row += "</div>";
                    $("#HDFTHA2").html(row);  
                }
                else{
                    $("#HDFTHA2").html("No");
                }
    
                if(data[0]['A3'] == "Y"){
                    var row = "";
                    row += "Yes";
                    row += "<div class='form-group'>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>If yes, please state date of contact and other details</label>";
                                row += "<div>"+data[0]['A3CONTACT_DATE']+"</div>";
                            row += "</div>";
                        row += "</div>";
                    row += "</div>";
                    $("#HDFTHA3").html(row); 
                }
                else{
                    $("#HDFTHA3").html("No");
                }
    
                if(data[0]['A4'] == "Y"){
                    var row = "";
                    row += "Yes";
                    row += "<div class='form-group'>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>If yes, please state the name of the HEALTHCARE facility</label>";
                                row += "<div>"+data[0]['A4NAME']+"</div>";
                            row += "</div>";
                        row += "</div>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>Date visited</label>";
                                row += "<div>"+data[0]['A4VISIT_DATE']+"</div>";
                            row += "</div>";
                        row += "</div>";
                    row += "</div>";
                    
                    row += "</div>";
                    $("#HDFTHA4").html(row); 
                }
                else{
                    $("#HDFTHA4").html("No");
                }
            });
    
            var oi_details = $.ajax({
                url: "api/oi/"+hdf_id,
                method: "GET",
                dataType: "json"
            });
    
            oi_details.done(function(data){
    
                if(data[0]['A1'] == "Y"){
                    var row = "";
                    row += "Yes";
                    row += "<div class='form-group'>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>If yes, please state the name of the details of exposure</label>";
                                row += "<div>"+data[0]['A1DETAILS']+"</div>";
                            row += "</div>";
                        row += "</div>";
                    row += "</div>";
                    $("#HDFOIA1").html(row); 
                }
                else{
                    $("#HDFOIA1").html("No");
                }
    
                if(data[0]['A2'] == "Y"){
                    var row = "";
                    row += "Yes";
                    row += "<div class='form-group'>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>If yes, please state the date of travel/exposure</label>";
                                row += "<div>"+data[0]['A2EXPOSURE_DATE']+"</div>";
                            row += "</div>";
                        row += "</div>";
                    row += "</div>";
                    $("#HDFOIA2").html(row);
                }
                else{
                    $("#HDFOIA2").html("No");
                }
                
                var row = "";
                row += "<ul>";
                var disease = JSON.parse(data[0]['A3']);
                for(var x = 0; x < disease.length; x++){
                    row += "<li>"+disease[x]+"</li>";
                }
                row += "</ul>";
                $("#HDFOIA3").html(row);
    
                if(data[0]['A4'] == "Yes"){
                    var row = "";
                    row += "Yes";
                    row += "<div class='form-group'>";
                        row += "<div class='form-row'>";
                            row += "<div class='col-12'>";
                                row += "<label>If yes, please state the date of travel/exposure</label>";
                                row += "<div>"+data[0]['A4PLACE']+"</div>";
                            row += "</div>";
                        row += "</div>";
                    row += "</div>";
                    $("#HDFOIA4").html(row);
                }
                else{
                    $("#HDFOIA4").html("No");
                }
    
                
                if(data[0]['A5'] == "Yes"){
                    $("#HDFOI_A5").val("Yes");
                    $("#HDFOI_A5").trigger('change');
                    var frontliner = JSON.parse(data[0]['A5FRONTLINER']);
                    var row = "";
                    row += "Yes";
                    row += "<ul>";
                    for(var x = 0; x < frontliner.length; x++){
                        row += "<li>"+frontliner[x]+"</li>";
                    }
                    row += "</ul>";
                    $("#HDFOIA5").html(row);
                }
                else{
                    $("#HDFOIA5").html("No");
                }
    
                $("#HDFOIA6").html(data[0]['A6']);
    
                $("#HDFOIA7").html(data[0]['A7']);
            });

        }
    });

    $("#cancel").on('click', function(){
        $('#cancel_modal_header').css('background-color', '#ffdd80');
        $('#cancel_modal_body').css('background-color', '#ffdd80');
        $('#cancel_modal_footer').css('background-color', '#ffdd80');
        $('#cancel_modal').modal('show');
    });

    $("#confirm_cancel").on('click', function(){
        $('#cancel_modal').modal('hide');
        $("#tbl_div").show();
        $("#form_div").hide();
        $("#hdf_form").removeClass('was-validated');
        $("#hdf_form")[0].reset();
        editted = 0;
    });

    $("#cancel_view").on('click', function(){
        $("#tbl_div").show();
        $("#view_div").hide();

        $("#hdfhh_view_area").html("");

        $("#hdfhd_view_area").html("");

        $("#hdfth_view_area").html("");

        
        $("#hdfoi_view_area").html("");
    });

    var no_hdf = false;
    var submission_day = false;

    var validate_cutoff_ajax = $.ajax({
        url: "api/get_hdf_cutoff_details",
        method: "GET",
        dataType: "json",
        async: false
    });

    validate_cutoff_ajax.done(function(data){
        if(data.length > 0){
            if(data[0]['EMP_FLAG'] == 1){
                submission_day = true;
            }
            else if(data[0]['EMP_FLAG'] == 2){
                var required_emps = $.ajax({
                    url: "api/get_required_emps/"+data[0]['CUTOFFID'],
                    method: "GET",
                    dataType: "json"
                });

                required_emps.done(function(data){
                    for(var x = 0; x < data.length; x++){
                        if(data[x]['EMP_CODE'] == $("#EMP_CODE").val()){
                            submission_day = true;
                        }
                    }
                });
            }
        }
    });

    var has_hdf_ajax = $.ajax({
        url: "api/get_hdf_today",
        method: "GET",
        async: false
    });

    has_hdf_ajax.done(function(data){
        if(data){
            no_hdf = true;
        }
    });
    
    // submit
    $("#submit").on('click', function(){
        if(submission_day && no_hdf){
            var MOBILE_NO = $("#MOBILE_NO").val();
            if(MOBILE_NO.length > 0){
                $("#mobile_err_msg").html("Invalid Mobile Number: Please input 11 digits.");
            }
            else{
                $("#mobile_err_msg").html("This field is required.");
            }

            // validate if at least 1 checkobx is checked in HDFHH
            var x = $(".HDFHH_CHK:checked").length;
            if(x < 1){
                $("#HDFHH_CHK_VALIDATE").show();
                $(".HDFHH_CHK").prop("required", true);
            }
            else{
                $("#HDFHH_CHK_VALIDATE").hide();
                $(".HDFHH_CHK").prop("required", false);
            }

            // validate if at least 1 checkobx is checked in HDFHD
            var HDFHD_DISEASE = $(".HDFHD_CHK:checked").length;
            if(HDFHD_DISEASE < 1){
                $("#HDFHD_CHK_VALIDATE").show();
                $(".HDFHD_CHK").prop("required", true);
            }
            else{
                $("#HDFHD_CHK_VALIDATE").hide();
                $(".HDFHD_CHK").prop("required", false);
            }

            // validate if at least 1 checkobx is checked in HDFOI
            var HDFOI_DISEASE = $(".HDFOI_CHK:checked").length;
            if(HDFOI_DISEASE < 1){
                $("#HDFOI_CHK_VALIDATE").show();
                $(".HDFOI_CHK").prop("required", true);
            }
            else{
                $("#HDFOI_CHK_VALIDATE").hide();
                $(".HDFOI_CHK").prop("required", false);
            }

            if($("#HDFOI_A5").val() == "Yes"){
                var HDFOI_DISEASE = $(".frontline_chck:checked").length;
                if(HDFOI_DISEASE < 1){
                    $("#frontline_chck_validate").show();
                    $(".frontline_chck").prop("required", true);
                }
                else{
                    $("#frontline_chck_validate").hide();
                    $(".frontline_chck").prop("required", false);
                }
            }

            if($("#A1TEMP").val().length > 0){
                $("#A1TEMP").prop("required", false);
            }
            else{
                $("#A1TEMP").prop("required", true);
            }

            $("#hdf_form").addClass('was-validated');
            if($("#hdf_form")[0].checkValidity()){
                //Serialize form as array
                var serializedForm = $("#hdf_form").serializeArray();
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
                        url: 'api/hdf',
                        type: 'POST',
                        data: serializedForm,
                        dataType: "json",
                        cache: 'no-cache',
                        success: function(data) {
                            if(data['late'] == 1){
                                $('#modal_title').html('Well done!');
                                $('#confirm_body').html('You have submitted your health declaration form. A Rush.NET ticket was created for approval.');
                                $('#confirm_header').css('background-color', '#ffff99');
                                $('#confirm_body').css('background-color', '#ffff99');
                                $('#confirm_footer').css('background-color', '#ffff99');
                                $('#hdf_modal').modal('show');
                            }
                            else{
                                $('#modal_title').html('Well done!');
                                $('#confirm_body').html('You have submitted your health declaration form.');
                                $('#confirm_header').css('background-color', '#ccffcc');
                                $('#confirm_body').css('background-color', '#ccffcc');
                                $('#confirm_footer').css('background-color', '#ccffcc');
                                $('#hdf_modal').modal('show');
                            }
                        },
                        fail: function(err){
                            alert('An error has occured. Please contact your system administrator. Error: '+err);
                            console.log(err)
                        }
                    });
                }
                else{
                    $.ajax({
                        url: 'api/update_hdf',
                        type: 'POST',
                        data: serializedForm,
                        cache: 'no-cache',
                        success: function(data) {
                            data = JSON.parse(data);
                            // show modal
                            $('#modal_title').html('Well done!');
                            $('#confirm_body').html('You have updated your health declaration form.');
                            $('#confirm_header').css('background-color', '#ccffcc');
                            $('#confirm_body').css('background-color', '#ccffcc');
                            $('#confirm_footer').css('background-color', '#ccffcc');
                            $('#hdf_modal').modal('show');
                            // $('#hdf_tbl').DataTable().ajax.reload();
                            // $('#hdf_form').trigger("reset");
                            // $("#hdf_form")[0].reset();
                            // $("#hdf_form").removeClass('was-validated');
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
            }
            else{
                $('#error_title').html('You forgot something!');
                $('#error_body').html('Please fill out all the required fields.');
                $('#error_header').css('background-color', '#e68a8a');
                $('#error_body').css('background-color', '#e68a8a');
                $('#error_footer').css('background-color', '#e68a8a');
                $('#error_modal').modal('show');
            }
        }
        else{
            var MOBILE_NO = $("#MOBILE_NO").val();
            if(MOBILE_NO.length > 0){
                $("#mobile_err_msg").html("Invalid Mobile Number: Please input 11 digits.");
            }
            else{
                $("#mobile_err_msg").html("This field is required.");
            }

            // validate if at least 1 checkobx is checked in HDFHH
            var x = $(".HDFHH_CHK:checked").length;
            if(x < 1){
                $("#HDFHH_CHK_VALIDATE").show();
                $(".HDFHH_CHK").prop("required", true);
            }
            else{
                $("#HDFHH_CHK_VALIDATE").hide();
                $(".HDFHH_CHK").prop("required", false);
            }

            // validate if at least 1 checkobx is checked in HDFHD
            var HDFHD_DISEASE = $(".HDFHD_CHK:checked").length;
            if(HDFHD_DISEASE < 1){
                $("#HDFHD_CHK_VALIDATE").show();
                $(".HDFHD_CHK").prop("required", true);
            }
            else{
                $("#HDFHD_CHK_VALIDATE").hide();
                $(".HDFHD_CHK").prop("required", false);
            }

            // validate if at least 1 checkobx is checked in HDFOI
            var HDFOI_DISEASE = $(".HDFOI_CHK:checked").length;
            if(HDFOI_DISEASE < 1){
                $("#HDFOI_CHK_VALIDATE").show();
                $(".HDFOI_CHK").prop("required", true);
            }
            else{
                $("#HDFOI_CHK_VALIDATE").hide();
                $(".HDFOI_CHK").prop("required", false);
            }

            if($("#HDFOI_A5").val() == "Yes"){
                var HDFOI_DISEASE = $(".frontline_chck:checked").length;
                if(HDFOI_DISEASE < 1){
                    $("#frontline_chck_validate").show();
                    $(".frontline_chck").prop("required", true);
                }
                else{
                    $("#frontline_chck_validate").hide();
                    $(".frontline_chck").prop("required", false);
                }
            }

            if($("#A1TEMP").val().length > 0){
                $("#A1TEMP").prop("required", false);
            }
            else{
                $("#A1TEMP").prop("required", true);
            }

            $("#hdf_form").addClass('was-validated');
            if($("#hdf_form")[0].checkValidity()){
                //Serialize form as array
                var serializedForm = $("#hdf_form").serializeArray();
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
                    $('#confirm_body').html('You can only submit HDF once per submission date set by Admin.');
                    $('#confirm_header').css('background-color', '#fcd874');
                    $('#confirm_body').css('background-color', '#fcd874');
                    $('#confirm_footer').css('background-color', '#fcd874');
                    $('#hdf_modal').modal('show');
                }
                else{
                    $.ajax({
                        url: 'api/update_hdf',
                        type: 'POST',
                        data: serializedForm,
                        cache: 'no-cache',
                        success: function(data) {
                            data = JSON.parse(data);
                            // show modal
                            $('#modal_title').html('Well done!');
                            $('#confirm_body').html('You have updated your health declaration form.');
                            $('#confirm_header').css('background-color', '#ccffcc');
                            $('#confirm_body').css('background-color', '#ccffcc');
                            $('#confirm_footer').css('background-color', '#ccffcc');
                            $('#hdf_modal').modal('show');
                            // $('#hdf_tbl').DataTable().ajax.reload();
                            // $('#hdf_form').trigger("reset");
                            // $("#hdf_form")[0].reset();
                            // $("#hdf_form").removeClass('was-validated');
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
            }
            else{
                $('#error_title').html('You forgot something!');
                $('#error_body').html('Please fill out all the required fields.');
                $('#error_header').css('background-color', '#e68a8a');
                $('#error_body').css('background-color', '#e68a8a');
                $('#error_footer').css('background-color', '#e68a8a');
                $('#error_modal').modal('show');
            }
        }
    });
    
});

function buildRow(data){
    var row = "";
    for(var x = 0; x < data.length; x++){
        row += "<div class='form-row'>";
            row += "<div class='col-12'>";
                row += buildInput(data[x]["SEQUENCE"], data[x]["TYPE"], data[x]["QUESTION"], data[x]["POSS_ANSWER"], data[x]["TRANSACTION"]);
            row += "</div>";
        row += "</div>";                                 
    }
    return row;
}

function buildView(data){
    var row = "";
    for(var x = 0; x < data.length; x++){
        row += "<div class='form-group'>";
            row += "<div class='form-row'>";
                row += "<div class='col-12'>";
                    row += "<label for='"+data[x]["TRANSACTION"]+"A"+data[x]["SEQUENCE"]+"'>"+data[x]["QUESTION"]+"</label>";
                row += "</div>";
            row += "</div>";
            row += "<div class='form-row'>";
                row += "<div class='col-12'>";
                    row += "<div id='"+data[x]["TRANSACTION"]+"A"+data[x]["SEQUENCE"]+"'></div>";
                row += "</div>";
            row += "</div>";
        row += "</div>";
        if(data[x]["SEQUENCE"] == 1 && data[x]["TRANSACTION"] == "HDFHD"){
            row += "<div class='form-group'>";
                row += "<div class='form-row'>";
                    row += "<div class='col-12'>";
                        row += getEhcView(); 
                    row += "</div>";
                row += "</div>";
            row += "</div>";
        }
    }
    return row;
}

function buildInput(name, type, question, answer, transaction){
    var input = "";
    switch(type){
        case "1":
            // text
            input += "<div class='form-group'>";
                input += "<input type='hidden' name='"+transaction+"_Q"+name+"' value='"+name+"'>";
                input += "<label for='"+transaction+"_A"+name+"'>"+question+"</label>";
                input += "<input type='text' class='form-control' id='"+transaction+"_A"+name+"' name='"+transaction+"_A"+name+"' required>";
                input += "<div class='invalid-feedback'>";
                    input += "This field is required.";
                input += "</div>";
            input += "</div>";
            break;
        case "2":
            // number
            input += "<div class='form-group'>";
                input += "<input type='hidden' name='"+transaction+"_Q"+name+"' value='"+name+"'>";
                input += "<label for='"+transaction+"_A"+name+"'>"+question+"</label>";
                input += "<input type='number' class='form-control' id='"+transaction+"_A"+name+"' name='"+transaction+"_A"+name+"' required>"
                input += "<div class='invalid-feedback'>";
                    input += "This field is required.";
                input += "</div>";
            input += "</div>";
            break;
        case "3":
            // checkbox
            if(transaction == "HDFHH" && name == 6){
                input += "<div class='form-group'>";
                    input += "<label>"+question+"</label>";
                $.each(JSON.parse(answer), function(index, value) {
                    if(value !== "Other"){
                        input += "<div class='custom-control custom-checkbox'>";
                            input += "<input type='checkbox' class='custom-control-input chronic_ds' id='CHRONIC_"+index+"' name='DISEASE[]' value='"+value+"'>";
                            input += "<label class='custom-control-label' for='CHRONIC_"+index+"'>"+value+"</label>";
                        input += "</div>";
                    }
                    else{
                        input += "<div class='custom-control custom-checkbox'>";
                            input += "<input type='checkbox' class='custom-control-input chronic_ds' id='CHRONIC_OTHER' value='"+value+"'>";
                            input += "<label class='custom-control-label' for='CHRONIC_OTHER'>"+value+"</label>";
                            input += "<input type='text' class='form-control' id='CHRONIC_OTHER_NAME' name='DISEASE[]'  disabled>";
                        input += "</div>";
                    }
                });
                    input += "<div class='invalid-feedback' id='hdfhh_chck_validate'>";
                        input += "This field is required.";
                    input += "</div>";
                input += "</div>";
            }
            else{
                input += "<div class='form-group'>";
                    input += "<input type='hidden' name='"+transaction+"_Q"+name+"' value='"+name+"'>";
                    input += "<label for='"+transaction+"_A"+name+"'>"+question+"</label>";
                $.each(JSON.parse(answer), function(index, value) {
                    if(value == "Other" || value == "Others"){
                        input += "<div class='custom-control custom-checkbox'>";
                            input += "<input type='checkbox' class='custom-control-input "+transaction+"_CHK' id='"+transaction+"_CHK_"+index+"' name='"+transaction+"_A"+name+"[]' value='"+value+"'>";
                            input += "<label class='custom-control-label' for='"+transaction+"_CHK_"+index+"'>"+value+"</label>";
                            input += "<input type='text' class='form-control' id='OTHER_DISEASE_"+transaction+"' name='OTHER_DISEASE_"+transaction+"'  disabled>";
                        input += "</div>";
                    }
                    else{
                        input += "<div class='custom-control custom-checkbox'>";
                            input += "<input type='checkbox' class='custom-control-input "+transaction+"_CHK' id='"+transaction+"_CHK_"+index+"' name='"+transaction+"_A"+name+"[]' value='"+value+"'>";
                            input += "<label class='custom-control-label' for='"+transaction+"_CHK_"+index+"'>"+value+"</label>";
                        input += "</div>";
                    }
                });
                    input += "<div class='invalid-feedback' id='"+transaction+"_CHK_VALIDATE'>";
                        input += "This field is required.";
                    input += "</div>";
                input += "</div>";
            }
            
            
            
            break;
        case "4":
            // dropdown
            input += "<div class='form-group'>";
                input += "<input type='hidden' name='"+transaction+"_Q"+name+"' value='"+name+"'>";
                input += "<label for='"+transaction+"_A"+name+"'>"+question+"</label>";
                input += "<select id='"+transaction+"_A"+name+"' name='"+transaction+"_A"+name+"' class='custom-select' required>";
                    input += "<option disabled selected value=''>Please choose</option>";
                    $.each(JSON.parse(answer), function(index, value) {
                        input += "<option value='"+value+"'>"+value+"</option>";
                    });
                input += "</select>";
                input += "<div class='invalid-feedback'>";
                    input += "This field is required.";
                input += "</div>";
            input += "</div>";
            input += addFollowUp(transaction, name);
            if(transaction == "HDFHD" && name == 1){
                input += "<div class='form-group'>";
                    input += getEhc();
                input += "</div>";
            }
            if(transaction == "HDFTH" && name == 1){
                input += "<div class='form-group'>";
                    input += displayTable();
                input += "</div>";
            }
            break;
        case "5":
            // radio
            input += "<div class='form-group'>";
                input += "<input type='hidden' name='"+transaction+"_Q"+name+"' value='"+name+"'>";
                $.each(JSON.parse(answer), function(index, value) {
                    input += "<div class='custom-control custom-radio'>";
                        input += "<input type='radio' id='"+transaction+"_RADIO_"+index+"' name='"+transaction+"_RADIO_"+index+"' value='"+value+"' class='custom-control-input'>";
                        input += "<label class='custom-control-label' for='"+transaction+"_RADIO_"+index+"'>"+value+"</label>";
                    input += "</div>";
                });
                input += "<div class='invalid-feedback'>";
                    input += "This field is required.";
                input += "</div>";
            input += "</div>";
            break;
        default:
            break;
    }
    return input;
}

function fieldName(num, transaction){
    var name = "";
    switch(transaction){
        case 'HDFHH':
            if(num == 7){
                name = "HOWMANY";
            }
            break;
        case 'HDFHD':
            if(num == 1){
                name = "TEMP";
            }
            if(num == 4){
                name = "REASON";
            }
            break;
        case 'HDFTF':
            break;
        case 'HDFOI':
            if(num == 1){
                name ="EXPOSURE_DATE";
            }
            break;
        default:
            break;
    }
    return name;
}

function getEhc(){
    
    var get_ehc = new XMLHttpRequest();
    var tbl = "";
    var rows = [];
    

    var get_server_date = new XMLHttpRequest();
    var server_date = '';

    get_server_date.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            server_date = this.response;
        }
    };

    get_server_date.open("GET", "api/server_date", false);
    get_server_date.send();

    
    get_ehc.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            rows = JSON.parse(this.response);
        }
    };

    // console.log(server_date);
    
    get_ehc.open("GET", "api/get_ehc_symptoms/"+server_date, false);
    get_ehc.send();
    
    tbl += "<label>Do you have the following sickness/symptoms?</label>";
    tbl += "<table class='table table-bordered table-striped'>";
        tbl += "<thead>";
            tbl += "<tr>";
                tbl += "<th scope='col'>Symptoms</th>";
                tbl += "<th scope='col'>Date</th>";
            tbl += "</tr>";
        tbl += "</thead>";
    tbl += "<tbody>";
    var symps = [];
    for(var x = 0; x < rows.length; x++){
        tbl += "<tr>";
            symps = JSON.parse(rows[x]['A3']);
            tbl += "<td>"+symps+"</td>";
            tbl += "<td>"+rows[x]['EHC_DATE']+"</td>";
        tbl += "</tr>";
    }
    
    tbl += "</tbody>";
    tbl += "</table>";
    
    return tbl;
}

function getEhcView(){
    var get_ehc = new XMLHttpRequest();
    var tbl = "";
    var rows = [];

    get_ehc.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            rows = JSON.parse(this.response);
        }
    };
    var hdf_date = $("input[name='selected_hdf']:checked").closest("td").next().html();
    var hdf_year = hdf_date.split("/")[2];
    var hdf_day = hdf_date.split("/")[1];
    var hdf_month = hdf_date.split("/")[0];
    hdf_date = hdf_year + "-" + hdf_month + "-" + hdf_day;
    get_ehc.open("GET", "api/get_ehc_symptoms/"+hdf_date, false);
    get_ehc.send();
    
    tbl += "<label>Do you have the following sickness/symptoms?</label>";
    tbl += "<table class='table table-bordered table-striped'>";
        tbl += "<thead>";
            tbl += "<tr>";
                tbl += "<th scope='col'>Symptoms</th>";
                tbl += "<th scope='col'>Date</th>";
            tbl += "</tr>";
        tbl += "</thead>";
    tbl += "<tbody>";
    var symps = [];
    for(var x = 0; x < rows.length; x++){
        tbl += "<tr>";
            symps = JSON.parse(rows[x]['A3']);
            tbl += "<td>"+symps+"</td>";
            tbl += "<td>"+rows[x]['EHC_DATE']+"</td>";
        tbl += "</tr>";
    }
    
    tbl += "</tbody>";
    tbl += "</table>";
    
    return tbl;
}

function displayTable(){
    
    var tbl = "";
    var rows = [];
    
    
    tbl += "<table class='table table-sm table-bordered table-striped'>";
        tbl += "<thead>";
            tbl += "<tr>";
                tbl += "<th scope='col' colspan='3'>Countries with confirmed COVID-19 Cases</th>";
            tbl += "</tr>";
        tbl += "</thead>";
    tbl += "<tbody>";
        tbl += "<tr>";
            tbl += "<td>China</td>";
            tbl += "<td>Belarus</td>";
            tbl += "<td>Tunisia</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Hong Kong</td>";
            tbl += "<td>Slovakia</td>";
            tbl += "<td>Jordan</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Macao</td>";
            tbl += "<td>Bulgaria</td>";
            tbl += "<td>Occupied Palestinian Territory</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Japan</td>";
            tbl += "<td>Latvia</td>";
            tbl += "<td>United States of America</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Singapore</td>";
            tbl += "<td>Malta</td>";
            tbl += "<td>Canada</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Malaysia</td>";
            tbl += "<td>North Macedonia</td>";
            tbl += "<td>Brazil</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Australia</td>";
            tbl += "<td>Albania</td>";
            tbl += "<td>Ecuador</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Vietnam</td>";
            tbl += "<td>Bosnia and Herzegovina</td>";
            tbl += "<td>Argentina</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Philippines</td>";
            tbl += "<td>Luxembourg</td>";
            tbl += "<td>Chile</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>New Zealand</td>";
            tbl += "<td>Andorra</td>";
            tbl += "<td>Costa Rica</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Cambodia</td>";
            tbl += "<td>Armenia</td>";
            tbl += "<td>Mexico</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Brunei Darussalam</td>";
            tbl += "<td>Holy See</td>";
            tbl += "<td>Peru</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Mongolia</td>";
            tbl += "<td>Liechtenstein</td>";
            tbl += "<td>Panama</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Italy</td>";
            tbl += "<td>Lithuania</td>";
            tbl += "<td>Columbia</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>France</td>";
            tbl += "<td>Monaco</td>";
            tbl += "<td>Dominican Republic</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Germany</td>";
            tbl += "<td>Republic of Moldova</td>";
            tbl += "<td>Bolivia</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Spain</td>";
            tbl += "<td>Serbia</td>";
            tbl += "<td>Paraguay</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Switzerland</td>";
            tbl += "<td>Ukraine</td>";
            tbl += "<td>Jamaica</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>United Kingdom</td>";
            tbl += "<td>Faroe Islands</td>";
            tbl += "<td>French Guiana</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Netherlands</td>";
            tbl += "<td>Gibraltar</td>";
            tbl += "<td>Martinique</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Sweden</td>";
            tbl += "<td>Guernsey</td>";
            tbl += "<td>Saint Martin</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Belgium</td>";
            tbl += "<td>Thailand</td>";
            tbl += "<td>Saint Bartelemy</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Norway</td>";
            tbl += "<td>India</td>";
            tbl += "<td>Algeria</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Austria</td>";
            tbl += "<td>Indonesia</td>";
            tbl += "<td>Senegal</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Greece</td>";
            tbl += "<td>Maldives</td>";
            tbl += "<td>South Africa</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Iceland</td>";
            tbl += "<td>Bangladesh</td>";
            tbl += "<td>Burkina Faso</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Israel</td>";
            tbl += "<td>Bhutan</td>";
            tbl += "<td>Cameroon</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>San Marino</td>";
            tbl += "<td>Nepal</td>";
            tbl += "<td>Nigeria</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Denmark</td>";
            tbl += "<td>Sri Lanka</td>";
            tbl += "<td>Democratic Republic of Congo</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Czechia</td>";
            tbl += "<td>Iran</td>";
            tbl += "<td>Togo</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Finland</td>";
            tbl += "<td>Bahrain</td>";
            tbl += "<td>International Conveyance (Diamond Princess)</td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Portugal</td>";
            tbl += "<td>Kuwait</td>";
            tbl += "<td></td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Ireland</td>";
            tbl += "<td>Iraq</td>";
            tbl += "<td></td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Slovenia</td>";
            tbl += "<td>Egypt</td>";
            tbl += "<td></td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Romania</td>";
            tbl += "<td>United Arab Emirates</td>";
            tbl += "<td></td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Georgia</td>";
            tbl += "<td>Lebanon</td>";
            tbl += "<td></td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Croatia</td>";
            tbl += "<td>Oman</td>";
            tbl += "<td></td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Poland</td>";
            tbl += "<td>Qatar</td>";
            tbl += "<td></td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Estonia</td>";
            tbl += "<td>Saudi Arabia</td>";
            tbl += "<td></td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Azerbaijan</td>";
            tbl += "<td>Pakistan</td>";
            tbl += "<td></td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Hungary</td>";
            tbl += "<td>Afghanistan</td>";
            tbl += "<td></td>";
        tbl += "</tr>";
        tbl += "<tr>";
            tbl += "<td>Russian Federation</td>";
            tbl += "<td>Morocco</td>";
            tbl += "<td></td>";
        tbl += "</tr>";
    tbl += "</tbody>";
    tbl += "</table>";
    
    return tbl;
}

function addFollowUp(transaction, name){
    var follow_up = "";
    if(transaction == "HDFHH"){
        if(name == 6){
            follow_up += "<div class='form-group' id='A6HOWMANY_ROW'>";
                follow_up += "<label for='A6HOWMANY'>If yes, how many are you?</label>";
                follow_up += "<input type='text' class='form-control' id='A6HOWMANY' name='A6HOWMANY' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            return follow_up;
        }
        else if(name == 1){
            follow_up += "<div class='form-group' id='A1OTHERS_ROW'>";
                follow_up += "<label for='A1OTHERS'>Please specify type of residence</label>";
                follow_up += "<input type='text' class='form-control' id='A1OTHERS' name='A1OTHERS' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            return follow_up;
        }
        
    }
    else if(transaction == "HDFHD"){
        if(name == 1){
            follow_up += "<div class='form-group' id='A1TEMP_ROW'>";
                follow_up += "<label for='A1TEMP'>If yes, what is your highest body temperature?</label>";
                follow_up += "<input type='text' class='form-control' id='A1TEMP' name='A1TEMP' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            return follow_up;
        }
        else if(name == 4){
            follow_up += "<div class='form-group' id='A4REASON_ROW'>";
                follow_up += "<label for='A4REASON'>If yes, please specify the reason of the medical test:</label>";
                follow_up += "<input type='text' class='form-control' id='A4REASON' name='A4REASON' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            return follow_up;
        }
        else if(name == 5){
            follow_up += "<div class='form-group' id='A5SYMPTOMS_ROW'>";
                follow_up += "<label for='A5SYMPTOMS'>If yes, please specify the symptoms/recurring pain/complaints:</label>";
                follow_up += "<input type='text' class='form-control' id='A5SYMPTOMS' name='A5SYMPTOMS' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            follow_up += "<div class='form-group' id='A5PERIOD_ROW'>";
                follow_up += "<label for='A5PERIOD'>If yes, please specify the period of sickness:</label>";
                follow_up += "<input type='text' class='form-control' id='A5PERIOD' name='A5PERIOD' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            return follow_up;
        }
    }
    else if(transaction == "HDFTH"){
        if(name == 1){
            follow_up += "<div class='form-group' id='A1TRAVEL_DATES_ROW'>";
                follow_up += "<label for='A1TRAVEL_DATES'>If yes, please state the travel dates:</label>";
                follow_up += "<input type='text' class='form-control' id='A1TRAVEL_DATES' name='A1TRAVEL_DATES' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            follow_up += "<div class='form-group' id='A1PLACE_ROW'>";
                follow_up += "<label for='A1PLACE'>State the exact place of travel:</label>";
                follow_up += "<input type='text' class='form-control' id='A1PLACE' name='A1PLACE' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            follow_up += "<div class='form-group' id='A1RETURN_DATE_ROW'>";
                follow_up += "<label for='A1RETURN_DATE'>Date of return to PH/Metro Manila:</label>";
                follow_up += "<input type='date' class='form-control' id='A1RETURN_DATE' name='A1RETURN_DATE' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            return follow_up;
        }
        else if(name == 2){
            follow_up += "<div class='form-group' id='A2TRAVEL_DATES_ROW'>";
                follow_up += "<label for='A2TRAVEL_DATES'>If yes, please state travel dates:</label>";
                follow_up += "<input type='text' class='form-control' id='A2TRAVEL_DATES' name='A2TRAVEL_DATES' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            follow_up += "<div class='form-group' id='A2PLACE_ROW'>";
                follow_up += "<label for='A2PLACE'>State the exact place of travel:</label>";
                follow_up += "<input type='text' class='form-control' id='A2PLACE' name='A2PLACE' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            follow_up += "<div class='form-group' id='A2RETURN_DATE_ROW'>";
                follow_up += "<label for='A2RETURN_DATE'>Date of return to PH/Metro Manila:</label>";
                follow_up += "<input type='date' class='form-control' id='A2RETURN_DATE' name='A2RETURN_DATE' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            return follow_up;
        }
        else if(name == 3){
            follow_up += "<div class='form-group' id='A3CONTACT_DATE_ROW'>";
                follow_up += "<label for='A3CONTACT_DATE'>If yes, please state date of contact and other details:</label>";
                follow_up += "<input type='text' class='form-control' id='A3CONTACT_DATE' name='A3CONTACT_DATE' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            return follow_up;
        }
        else if(name == 4){
            follow_up += "<div class='form-group' id='A4NAME_ROW'>";
                follow_up += "<label for='A4NAME'>If yes, please state the name of the HEALTHCARE facility:</label>";
                follow_up += "<input type='text' class='form-control' id='A4NAME' name='A4NAME' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            follow_up += "<div class='form-group' id='A4VISIT_DATE_ROW'>";
                follow_up += "<label for='A4VISIT_DATE'>Date visited</label>";
                follow_up += "<input type='date' class='form-control' id='A4VISIT_DATE' name='A4VISIT_DATE' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            return follow_up;
        }
    }
    else if(transaction == "HDFOI"){
        if(name == 1){
            follow_up += "<div class='form-group' id='A1DETAILS_ROW'>";
                follow_up += "<label for='A1DETAILS'>If yes, please state details of exposure</label>";
                follow_up += "<input type='text' class='form-control' id='A1DETAILS' name='A1DETAILS' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            return follow_up;
        }
        else if(name == 2){
            follow_up += "<div class='form-group' id='A2EXPOSURE_DATE_ROW'>";
                follow_up += "<label for='A2EXPOSURE_DATE'>If yes, please state date of travel/exposure</label>";
                follow_up += "<input type='date' class='form-control' id='A2EXPOSURE_DATE' name='A2EXPOSURE_DATE' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            return follow_up;
        }
        else if(name == 4){
            follow_up += "<div class='form-group' id='A4PLACE_ROW'>";
                follow_up += "<label for='A4PLACE'>If yes, please state the exact place</label>";
                follow_up += "<input type='text' class='form-control' id='A4PLACE' name='A4PLACE' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            return follow_up;
        }
        else if(name == 5){
            follow_up += "<div class='form-group' id='A5FRONTLINER_ROW'>";
                follow_up += "<label for='A5FRONTLINER'>If yes, please indicate what type of frontliner</label>";
                follow_up += "<div class='custom-control custom-checkbox'>";
                    follow_up += "<input type='checkbox' class='custom-control-input frontline_chck' name='A5FRONTLINER[]' id='HEALTH_WORKER' value='Health Worker'>";
                    follow_up += "<label class='custom-control-label' for='HEALTH_WORKER'>Health Worker</label>";
                follow_up += "</div>";
                follow_up += "<div class='custom-control custom-checkbox'>";
                    follow_up += "<input type='checkbox' class='custom-control-input frontline_chck' name='A5FRONTLINER[]' id='PHARMACIST' value='Pharmacist'>";
                    follow_up += "<label class='custom-control-label' for='PHARMACIST'>Pharmacist</label>";
                follow_up += "</div>";
                follow_up += "<div class='custom-control custom-checkbox'>";
                    follow_up += "<input type='checkbox' class='custom-control-input frontline_chck' name='A5FRONTLINER[]' id='POPO' value='Police/Army/BFP'>";
                    follow_up += "<label class='custom-control-label' for='POPO'>Police/Army/BFP</label>";
                follow_up += "</div>";
                follow_up += "<div class='custom-control custom-checkbox'>";
                    follow_up += "<input type='checkbox' class='custom-control-input frontline_chck' name='A5FRONTLINER[]' id='BRGY' value='Barangay Frontliner'>";
                    follow_up += "<label class='custom-control-label' for='BRGY'>Barangay Frontliner</label>";
                follow_up += "</div>";
                follow_up += "<div class='custom-control custom-checkbox'>";
                    follow_up += "<input type='checkbox' class='custom-control-input frontline_chck' name='A5FRONTLINER[]' id='BANK' value='Bank Employees'>";
                    follow_up += "<label class='custom-control-label' for='BANK'>Bank Employees</label>";
                follow_up += "</div>";
                follow_up += "<div class='custom-control custom-checkbox'>";
                    follow_up += "<input type='checkbox' class='custom-control-input frontline_chck' name='A5FRONTLINER[]' id='SUPP' value='Back Office Support(IT, Payroll, etc.)'>";
                    follow_up += "<label class='custom-control-label' for='SUPP'>Back Office Support(IT, Payroll, etc.)</label>";
                follow_up += "</div>";
                follow_up += "<div class='custom-control custom-checkbox'>";
                    follow_up += "<input type='checkbox' class='custom-control-input frontline_chck' name='A5FRONTLINER[]' id='GRAB' value='Logistics/Delivery Service (Grab, Angkas, Lalamove, Transportify, etc.)'>";
                    follow_up += "<label class='custom-control-label' for='GRAB'>Logistics/Delivery Service (Grab, Angkas, Lalamove, Transportify, etc.)</label>";
                follow_up += "</div>";
                follow_up += "<div class='custom-control custom-checkbox'>";
                    follow_up += "<input type='checkbox' class='custom-control-input frontline_chck' name='A5FRONTLINER[]' id='SG' value='Security Guard'>";
                    follow_up += "<label class='custom-control-label' for='SG'>Security Guard</label>";
                follow_up += "</div>";
                follow_up += "<div class='custom-control custom-checkbox'>";
                    follow_up += "<input type='checkbox' class='custom-control-input frontline_chck' id='OTHER_FRONTLINER' name='A5FRONTLINER[]' value='Other'>";
                    follow_up += "<label class='custom-control-label' for='OTHER_FRONTLINER'>Other</label>";
                    follow_up += "<input type='text' class='form-control' id='OTHER_FRONTLINER_VALUE' name='OTHER_FRONTLINER_VALUE'  disabled>";
                follow_up += "</div>";
            follow_up += "</div>";
            follow_up += "<div class='invalid-feedback' id='frontline_chck_validate'>";
                follow_up += "This field is required.";
            follow_up += "</div>";
            return follow_up;
        }
        else if(name == 6){
            follow_up += "<div class='form-group' id='A6OTHERS_ROW'>";
                follow_up += "<label for='A6OTHERS'>If others, please specify</label>";
                follow_up += "<input type='text' class='form-control' id='A6OTHERS' name='A6OTHERS' disabled>";
                follow_up += "<div class='invalid-feedback'>";
                    follow_up += "This field is required.";
                follow_up += "</div>";
            follow_up += "</div>";
            return follow_up;
        }
        else{
            return "";
        }
    }
    else{
        return "";
    }
}

function consentStatement(){
    var input = "";
    input += "<div class='form-group' id='REASON_ROW'>";
        input += "<label for='reason'>Reason for late filing</label>";
            input += "<input type='text' class='form-control' id='REASON' name='REASON' disabled>";
        input += "<div class='invalid-feedback'>";
            input += "This field is required.";
        input += "</div>";
    input += "</div>";
    input += "<div class='form-group'>";
        input += "<label>Employee Declaration</label>";
        input += "<div class='custom-control custom-checkbox'>";
            input += "<input required type='checkbox' class='custom-control-input consent' id='consent' name='consent' value='1'>";
            input += "<label class='custom-control-label' for='consent'>I declare that the information given within this Employee Declaration of Health is true and complete to the best of my knowledge. I allow Federal Land, Inc. to seek further information about my health using the result of this survey for any purpose deemed appropriate and necessary.</label>";
            input += "<div class='invalid-feedback'>Employee Declaration is required</div>";
        input += "</div>";
        
    input += "</div>";
    return input;
}

function fillUpEmpInfo(){
    var EMP_CODE = $("#EMP_CODE").val();
    var emp_info_ajax = new XMLHttpRequest();
    var EMP_INFO = [];
    emp_info_ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            EMP_INFO = JSON.parse(this.response);
        }
    };
    emp_info_ajax.open("GET", "api/get_emp_info/"+EMP_CODE, false);
    emp_info_ajax.send();

    $("input[name='EMP_LNAME']").val(EMP_INFO[0]['EMP_LNAME']);
    $("#VIEW_EMP_LNAME").html(EMP_INFO[0]['EMP_LNAME']);

    $("input[name='EMP_FNAME']").val(EMP_INFO[0]['EMP_FNAME']);
    $("#VIEW_EMP_FNAME").html(EMP_INFO[0]['EMP_FNAME']);

    $("input[name='EMP_AGE']").val(EMP_INFO[0]['AGE']);
    $("#VIEW_EMP_AGE").html(EMP_INFO[0]['AGE']);

    $("select[name='EMP_GENDER']").val(EMP_INFO[0]['GENDER']);
    $("#VIEW_EMP_GENDER").html(EMP_INFO[0]['GENDER']);
    
    $("select[name='CIVIL_STAT']").val(EMP_INFO[0]['CIVIL_STAT']);
    $("#VIEW_CIVIL_STAT").html(EMP_INFO[0]['CIVIL_STAT']);

    $("input[name='PERM_CITY']").val(EMP_INFO[0]['PERM_CITY']);
    $("#VIEW_PERM_CITY").html(EMP_INFO[0]['PERM_CITY']);

    $("input[name='PERM_PROV']").val(EMP_INFO[0]['PERM_PROV']);
    $("#VIEW_PERM_PROV").html(EMP_INFO[0]['PERM_PROV']);

    $("input[name='PRESENT_ADDR1']").val(EMP_INFO[0]['PRESENT_ADDR1']);
    $("#VIEW_PRESENT_ADDR1").html(EMP_INFO[0]['PRESENT_ADDR1']);

    $("input[name='PRESENT_ADDR2']").val(EMP_INFO[0]['PRESENT_ADDR2']);
    $("#VIEW_PRESENT_ADDR2").html(EMP_INFO[0]['PRESENT_ADDR2']);

    $("input[name='PRESENT_CITY']").val(EMP_INFO[0]['PRESENT_CITY']);
    $("#VIEW_PRESENT_CITY").html(EMP_INFO[0]['PRESENT_CITY']);

    $("input[name='PRESENT_PROV']").val(EMP_INFO[0]['PRESENT_PROV']);
    $("#VIEW_PRESENT_PROV").html(EMP_INFO[0]['PRESENT_PROV']);

    $("input[name='TEL_NO']").val(EMP_INFO[0]['TEL_NO']);
    $("#VIEW_TEL_NO").html(EMP_INFO[0]['TEL_NO']);


    $("input[name='MOBILE_NO']").val(EMP_INFO[0]['MOBILE_NO']);
    $("#VIEW_MOBILE_NO").html(EMP_INFO[0]['MOBILE_NO']);

    $("select[name='GRP_CODE']").val(EMP_INFO[0]['GRP_CODE']);
    $("#VIEW_GRP_CODE").html(EMP_INFO[0]['GRP_CODE']);

    $("select[name='COMP_CODE']").val(EMP_INFO[0]['COMP_CODE']);
    $("#VIEW_COMP_CODE").html(EMP_INFO[0]['COMP_CODE']);

    // var comp_ajax = new XMLHttpRequest();
    // comp_ajax.onreadystatechange = function() {
    //     if (this.readyState == 4 && this.status == 200) {
    //         var COMP_NAME = JSON.parse(this.response);
    //         $("select[name='COMP_CODE']").val(COMP_NAME[0]['COMP_NAME']);
    //         $("#VIEW_COMP_CODE").html(EMP_INFO[0]['COMP_CODE']);
    //     }
    // };
    // comp_ajax.open("GET", "api/get_company_desc/"+EMP_INFO[0]['COMP_CODE'], false);
    // comp_ajax.send();


    // var grp_ajax = new XMLHttpRequest();
    // grp_ajax.onreadystatechange = function() {
    //     if (this.readyState == 4 && this.status == 200) {
    //         var GRP_NAME = JSON.parse(this.response);
    //         $("select[name='GRP_CODE']").val(GRP_NAME[0]['GRP_NAME']);
    //         $("#VIEW_GRP_CODE").html(EMP_INFO[0]['GRP_CODE']);
    //     }
    // };
    // grp_ajax.open("GET", "api/get_group_desc/"+EMP_INFO[0]['GRP_CODE'], false);
    // grp_ajax.send();
}

function validateTel(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode > 18) && (charCode < 33 || charCode > 57) && (charCode < 96 || charCode > 111) && (charCode < 186) && (charCode != 110) && (charCode != 190) && (charCode != 8)){
        return false;
    }
    return true;
}

function validatePhone(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode > 18) && (charCode < 96 || charCode > 105) && (charCode < 48 || charCode > 57) && (charCode == 16)){
        return false;
    }
    return true;
}

function isNumber(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    
    if(evt.shiftKey){
        return false;
    }
    else{
        if ((charCode >= 65 && charCode <= 90) || (charCode >= 106 && charCode <= 111) || (charCode >= 123)){
            return false;
        }
    }
    return true;
}

function isTemp(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    
    if(evt.shiftKey){
        return false;
    }
    else{
        if ((charCode >= 65 && charCode <= 90) || (charCode >= 106 && charCode <= 109) || (charCode == 111) || (charCode >= 123 && charCode <= 189) || (charCode >= 191)){
            return false;
        }
    }
    return true;
}