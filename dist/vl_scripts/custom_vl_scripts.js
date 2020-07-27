
    /* For Data table of Checkin Check Out */
    var dbtableChckInOut = $('#tableChckInOut').DataTable( {
        responsive: true,
        destroy: true, 
            columnDefs: [ {
            targets: [8],
            data: null,
            render: function ( data, type, row, meta ) {
                if(row['CHECKIN_TIME'] == null && row['CHECKOUT_TIME'] == null){
                    return '<button type="buton" class="btn btn-success" id="btnCheckInCheckOut" onClick="fucntionChkInOut('+row['VISITOR_ID'] +')">CheckIn</button>';
                }else if(row['CHECKIN_TIME'] != null && row['CHECKOUT_TIME_HOST'] != null &  row['CHECKOUT_TIME_HOST'] != null) {
                    return '<button type="buton" class="btn btn-danger" id="btnCheckInCheckOut" onClick="fucntionChkInOut('+row['VISITOR_ID'] +')">CheckOut</button>';
                }else if (row['MEETING_ID'] == ''){
                    dbtableChckInOut.row().remove().draw( false );
                    return 'No action need for confirmation of host employee';
                }else if (row['CHECKIN_TIME'] != null && row['CHECKOUT_TIME'] == null){
                    return '<button type="buton" class="btn btn-danger" id="btnCheckInCheckOut" onClick="fucntionChkInOut('+row['VISITOR_ID'] +')">CheckOut</button>';
                }else{
                    dbtableChckInOut.row().remove().draw( false );
                    return 'No action need for host employee check out';
                }
                
            }
        } ], 
        rowCallback: function( row, data, index ) {
            
        },
        ajax: {
            url: 'visitor/getCheckInCheckOut',
            dataSrc: ''
        },
        columns: [
        { data: 'MEETING_ID' }, 
        { data: 'VISIT_DATE' }, 
        { data: 'CHECKIN_TIME' },
        { data: 'CHECKOUT_TIME' },
        { data: 'FULNAME' },
        { data: 'PERSON_VISIT' },
        { data: 'VISIT_PURP' },
        { data: 'COMP_ADDRESS' },
        { data: ''}]
    });
    /* For End Data table of Checkin Check Out */
    
    /* For Data table of Visitor Log */
    var dbtableVisitorLog = $('#tableVisitorLog').DataTable( {
        responsive: true,
        destroy: true, 
            columnDefs: [ {
            targets: [9],
            data: null,
            render: function ( data, type, row, meta ) {
                return '<button type="buton" class="btn btn-info" id="btnViewLog" onClick="btnViewLogFucntion('+row['VISITOR_ID'] +')"><i class="fa fa-eye" aria-hidden="true"></i></button>';
            }
        },
        {
            targets: [8],
            data: null,
            render: function ( data, type, row, meta ) {
                if(row['STATUS_DENIED'] == 'DENIED'){
                    return 'Denied';
                }else if(row['STATUS_DENIED'] == 'CANCELLED'){
                    return 'Cancelled by Requester';
                }else if(row['STATUS_DENIED'] == 'CONFIRMED'){
                    return 'Confirmed';
                }else if(row['STATUS_DENIED'] == 'DONE'){
                    return 'Done';
                }else if(row['STATUS_DENIED'] == 'On-going'){
                    return 'On-going';
                }else{
                    if(row['MEETING_ID'] == null){
                        return 'FOR CONFIRMATION';
                    }else if (row['MEETING_ID'] != null && row['CHECKIN_TIME'] == null){
                        return 'CONFIRMED';
                    }
                }
            }
        }
        ], 
        ajax: {
            url: 'visitor/getVisitorLog',
            dataSrc: ''
        },
        columns: [
        { data: 'MEETING_ID' }, 
        { data: 'VISIT_DATE' }, 
        { data: 'CHECKIN_TIME' },
        { data: 'CHECKOUT_TIME' },
        { data: 'FULNAME' },
        { data: 'PERSON_VISIT' },
        { data: 'VISIT_PURP' },
        { data: 'LOCATION' },
        { data: 'STATUS_DENIED' },
        { data: ''}]
    });
    /* For End Data table of Visitor log */

   /*  For highlight of row selected Visitor Log */
    $('#tableVisitorLog tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            dbtableVisitorLog.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
           /*  dbtableVisitorLog.row('.selected').remove().draw( false ); */
        }
    } );
    /* End For highlight of row selected Visitor Log */

    /*  For highlight of row selected Checkin Checkout Log */
    $('#tableChckInOut tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            dbtableChckInOut.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
           /*  dbtableVisitorLog.row('.selected').remove().draw( false ); */
        }
    } );
    /* End For highlight of row selected Visitor Log */

    /* For The tagging of check in check out */
    function fucntionChkInOut(id){
        $('#btnCheckInCheckOut').prop( "disabled", true );
        $.ajax({
            url: 'visitor/tagCheckInCheckOut',
            type: 'GET',
            data: {
                id : id
            },
            cache: 'no-cache',
            success: function(data) {
               /*  $('#toast').toast('show'); */
                //$('#tableChckInOut').data.reload();
                $('#ModalMessage').modal('show');
                $('#tableChckInOut').DataTable().ajax.reload();
                $('#tableVisitorLog').DataTable().ajax.reload();
                $('#btnCheckInCheckOut').prop( "disabled", false );
            },
            fail: function(err){
                alert('An error has occured. Please contact your system administrator. Error: '+err);
                $('#btnCheckInCheckOut').prop( "disabled", false );
                console.log(err)
            }
        });
    }
    /* End For The tagging of check in check out  */


    /* For The Visitor Log  */
    function btnViewLogFucntion(id){
        $.ajax({
            url: 'visitor/view_visitor_logs',
            type: 'GET',
            data: {
                id : id
            },
            dataType:'html',
            success: function(data) {
                $("#show_modal").html(data);
                $("#modalBodyEdit").children().prop('disabled',true);
                $('#EditModal').modal('show');
            },
            fail: function(err){
                alert('An error has occured. Please contact your system administrator. Error: '+err);
                console.log(err)
            }
        });
    };
    /* End For The tagging of check in check out  */


    /* For saving visitor log */
    $("#submitAddModal").click(function(){
        var value = $("#fromAddVisitorLogModal").serialize();
        $('#submitAddModal').prop( "disabled", true );
        $.ajax({
            url: 'visitor/add_visitor_log',
            type: 'POST',
            data: value ,
            dataType:'json',
            success: function(data) {
                if(data.success == false){
                    $('.alert').remove();
                    $('#fromAddVisitorLogModal').append('<div class="alert alert-warning alert-dismissible fade show" role="alert" id="modal_message"> <span id="modal_text">'+data.error_message+'</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    $('input[name=csrf_test_name]').val(data.csrf_hash); //update the csrf to the form     
                    $('#submitAddModal').prop( "disabled", false ); 
                    $('#tableVisitorLog').DataTable().ajax.reload();
                }else if (data.success == true){
                    $('#fromAddVisitorLogModal')[0].reset();
                    $('.alert').remove();
                    $('#tableVisitorLog').DataTable().ajax.reload();
                    $('#fromAddVisitorLogModal').append('<div class="alert alert-success alert-dismissible fade show" role="alert" id="modal_message"> <span id="modal_text">Visitor log was successfully added.</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');   
                    $('input[name=csrf_test_name]').val(data.csrf_hash); //update the csrf to the form      
                    $('#submitAddModal').prop( "disabled", false ); 
                    let today = new Date().toISOString().substr(0, 10);
                    document.querySelector("#dateOfVisit").value = today;
                }
            },
            fail: function(err){
                alert('An error has occured. Please contact your system administrator. Error: '+err);
                $('#submitAddModal').prop( "disabled", false ); 
                console.log(err)
            }
        });
    });
    /* End For saving visitor log */

    /* For Editing visitor log */
    function btnSaveEdited(){
       
        var value = $("#fromEditVisitorLogModal").serialize();
        if($("#EditsubmitModal").text() == "Save"){
            $('#EditsubmitModal').prop( "disabled", true ); 
            $.ajax({
                url: 'visitor/update_visitor_logs',
                type: 'POST',
                data: value,
                dataType:'json',
                success: function(data) {
                    if(data.success == false){
                        $('.alert').remove();
                        $('#fromEditVisitorLogModal').append('<div class="alert alert-warning alert-dismissible fade show" role="alert" id="modal_message"> <span id="modal_text">'+data.error_message+'</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        $('input[name=csrf_test_name]').val(data.csrf_hash); //update the csrf to the form    
                        $('#tableVisitorLog').DataTable().ajax.reload();  
                        $('#EditsubmitModal').prop( "disabled", false ); 
                    }else if (data.success == true){
                        $('.alert').remove();
                        $('#fromEditVisitorLogModal').append('<div class="alert alert-success alert-dismissible fade show" role="alert" id="modal_message"> <span id="modal_text">Visitor log was successfully updated.</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');        
                        $('#fromEditVisitorLogModal').find('input, textarea, select').attr('readonly');
                        $("#EditsubmitModal").html("Edit");
                        $('input[name=csrf_test_name]').val(data.csrf_hash); //update the csrf to the form      
                        $('#tableVisitorLog').DataTable().ajax.reload();
                        $('#EditsubmitModal').prop( "disabled", false ); 
                    }
                },
                fail: function(err){
                    alert('An error has occured. Please contact your system administrator. Error: '+err);
                    console.log(err)
                }
            }); 
        }else if ($("#EditsubmitModal").text() == "Edit"){
            $("#EditsubmitModal").html("Save");
            $("#EditModalHeader").html("Edit Visitor Log");
            $('#EditModal').find('input, textarea, select').removeAttr('readonly');
            $('#EditinputCheckIn').prop( "readonly", true );
            $('#EditinputCheckOut').prop( "readonly", true );
            $('#EditdateOfVisit').prop( "readonly", true );
            $("#EditcontrolSelectStatusQ1").removeAttr('readonly');
        }
    }
    /* End For Editing visitor log */


    /* For Search Functionality */
    function search_activities(){
        if ($.fn.DataTable.isDataTable("#tableChckInOut")) {
            $('#tableChckInOut').DataTable().clear().destroy();
        }

        if ($.fn.DataTable.isDataTable("#tableVisitorLog")) {
            $('#tableVisitorLog').DataTable().clear().destroy();
        }
        
        var visitorLogtable = $('#tableVisitorLog').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                'type': 'GET',
                'url': "visitor/search_visitor",
                'data': {
                    vistior_name : $("#inputVisitorName").val(),
                    status : $("#controlSelectStatus").val(),
                    meeting_id : $("#inputMeetingID").val(),
                    person_to_visit : $("#inputPersonToVisitSearch").val(),
                    date : $("#datefilter").val()
                }
            },
            select: {
                style: 'single'
            },
            columnDefs: [ 
                {
                    targets: [8],
                    data: null,
                    render: function ( data, type, row, meta ) {

                        if(row['8'] == 'DENIED'){
                            return 'Denied';
                        }else if(row['8'] == 'CANCELLED'){
                            return 'Cancelled by Requester';
                        }else if(row['8'] == 'CONFIRMED'){
                            return 'Confirmed';
                        }else if(row['8'] == 'DONE'){
                            return 'Done';
                        }else if(row['8'] == 'On-going'){
                            return 'On-going';
                        }else{
                            if(row['0'] == null){
                                return 'FOR CONFIRMATION';
                            }else if (row['0'] != null && row['2'] == null){
                                return 'CONFIRMED';
                            }
                        }
                    }
                },
                {
                targets: [9],
                data: null,
                render: function ( data, type, row, meta ) {
                    return '<button type="buton" class="btn btn-info" id="btnViewLog" onClick="btnViewLogFucntion('+row['VISITOR_ID'] +')"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                }
                }
            ]
        });

        var checkinout_table = $('#tableChckInOut').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                'type': 'GET',
                'url': "visitor/search_CheckOut",
                'data': {
                    vistior_name : $("#inputVisitorName").val(),
                    status : $("#controlSelectStatus").val(),
                    meeting_id : $("#inputMeetingID").val(),
                    person_to_visit : $("#inputPersonToVisitSearch").val(),
                    date : $("#datefilter").val()
                }
            },
            select: {
                style: 'single'
            },
            columnDefs: [ 
            {
                targets: [8],
                data: null,
                render: function ( data, type, row, meta ) {
                    

                    if(row['2'] == null && row['3'] == null){
                        return '<button type="buton" class="btn btn-success" id="btnCheckInCheckOut" onClick="fucntionChkInOut('+row['VISITOR_ID'] +')">CheckIn</button>';
                    }else if(row['2'] != null && row['3'] != null) {
                        checkinout_table.row().remove().draw( true  );
                        return '<button type="buton" class="btn btn-danger" id="btnCheckInCheckOut" onClick="fucntionChkInOut('+row['VISITOR_ID'] +')">CheckOut</button>';
                    }else if (row['0'] == null){
                        checkinout_table.row().remove().draw( false );
                        return 'No action need for confirmation of host employee';
                    }
                    //Change this when the addendum applied
                    else if(row['2'] != null && row['3'] == null){
                        return '<button type="buton" class="btn btn-danger" id="btnCheckInCheckOut" onClick="fucntionChkInOut('+row['VISITOR_ID'] +')">CheckOut</button>';
                    }else{
                        checkinout_table.row().remove().draw( false );
                        return 'No action need';
                    }


                }
            }
            ]
        });
    }
    /* End For Search Functionality */

    /* For Clear button on search Functionality */
    function clear_button(){
    $("#btnClear").click(function(){
        var $select = $('#inputPersonToVisitSearch').selectize();
        var control = $select[0].selectize;
        control.clear();
        $('#formSearch').trigger("reset");
    });
    }
    /*End For Clear button on search Functionality */

    /* For restricting user input to one decimal point  */
    /* function isBodyTemp(txt, evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46) {
          //Check if the text already contains the . character
          if (txt.value.indexOf('.') === -1) {
            return true;
          } else {
            return false;
          }
        } else {
          if (charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
        }
        return true;
         onkeypress="return isBodyTemp(this, event);"
    } */
    $('#inputBodyTemp , #EditinputBodyTemp').keypress(function(event) {
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
    /*  End For restricting user input to one decimal point  */
    
    /* For Calculating time rang of Time To field and Time from fields */
    $('#inputTimeFrom').on('change', function() {
        var timeFrom = $('#inputTimeFrom').val();
        var timeTo = $('#inputTimeTo').val();
        var currentTime = new Date().toTimeString().slice(0,8);
        //var time = currentTime.getHours() + ":" + currentTime.getMinutes();

       if (timeTo <= timeFrom || timeFrom == ''){
            $('#inputTimeToWarning').prop('hidden' , false);
            $('#submitAddModal').prop('disabled' , true);
            $('#text').text('Time to must be less than to the value of time from.');
       }else{
            $('#inputTimeToWarning').prop('hidden' , true);
            $('#submitAddModal').prop('disabled' , false);
            $('#text').text('Time to must be less than to the value of time from.');
       }  

       if(currentTime > timeFrom ){
            $('#inputTimeToWarning').prop('hidden' , false);
            $('#submitAddModal').prop('disabled' , true);
            $('#text').text('Time from must be greater than current system time.');
       }else{
            $('#inputTimeToWarning').prop('hidden' , true);
            $('#submitAddModal').prop('disabled' , false);
       }
    });
    /* End For Calculating time rang of Time To field and Time from fields */
    $('#inputTimeTo').on('change', function() {
        var timeFrom = $('#inputTimeFrom').val();
        var timeTo = $('#inputTimeTo').val();
        var currentTime = new Date().toTimeString().slice(0,8);
       
        if (currentTime >= timeTo ){
            $('#inputTimeToWarning').prop('hidden' , false);
            $('#submitAddModal').prop('disabled' , true);
            $('#text').text('Time to must be greater than current system time.');
        }else if(timeFrom  >= timeTo){
            $('#inputTimeToWarning').prop('hidden' , false);
            $('#submitAddModal').prop('disabled' , true);
            $('#text').text('Time to must be greater than time from.');
        }else{
            $('#inputTimeToWarning').prop('hidden' , true);
            $('#submitAddModal').prop('disabled' , false);
        }

    });

    /* For Alphabet only for name fields */
    function onlyAlphabets(e, t) {
        return (e.charCode > 64 && e.charCode < 91) || (e.charCode > 96 && e.charCode < 123) || e.charCode == 32;   
    }
    /* End For Alphabet only for name fields */

     /* For Alpha numeric only  for name fields */
    function restrictAlphabets(e) {
        var x = e.which || e.keycode;
        if ((x >= 48 && x <= 57))
            return true;
        else
            return false;
    }
    /* End For Alpha numeric only for name fields */

    

    

    