
    $(document).ready(function() {
        var da_table = $('#daily_activity_table').DataTable({
            "processing": true,
            "serverSide": true,
            "searching":true,
            "order": [],
            "ajax": 'daily_activity/daily_activities_list',
            "type" : "GET",
            "data" : {
                requestor : ''
            },
            select: {
                style: 'single'
            },
            columnDefs: [ {
               targets: [7],
               data: null,
               render: function ( data, type, row, meta ) {
                  if(row[7] == '') {
                      return 'FOR CONFIRMATION';
                  } else {
                      return row[7];
                  }
               }
             }, 
             {
                 targets: [-1],
                 data: null,
                 render: function ( data, type, row, meta ) {
                    if(data[8] == 'BLANK') {
                      return "";
                    } else {
                      return '<button type="button" id="view_btn" onclick="view_participants('+row[0]+');" class="btn btn-outline-primary btn-block"><span class="fas fa-eye mr-1"></span>View</button>';
                    
                    }
                  
                 }
              } ]


        });

        // SINGLE SELECT ON DA TABLE
        $("#edit_btn").hide();
        $("#cancel_btn").hide();
        $('#daily_activity_table tbody').on( 'click', 'tr', function () {

          if ( $(this).hasClass('selected') ) {
              $(this).removeClass('selected');
              $("#edit_btn").hide();
              $("#cancel_btn").hide();
          } else {
             $("#daily_activity_table tr.selected").removeClass('selected');
            $(this).addClass('selected');

            // check if logged_user is requestor
            var dataArr = '';
            var status = '';
            $.each($("#daily_activity_table tr.selected"),function(){ 
                dataArr = $(this).find('td').eq(0).text();
                status = $(this).find('td').eq(7).text(); 
                if(status == 'CANCELLED') {
                  $("#edit_btn").hide();
                  $("#cancel_btn").hide();
                }
            });
            console.log(status);
            $ajaxData = $.ajax({
              url: 'daily_activity/validate_if_requestor',
              method: "GET",
              data: {
                activity_id : dataArr
              },
              dataType: "html",
              success:function(data){
                if(data == 'true') {
                  if(status != 'CANCELLED') {
                    $("#edit_btn").show();
                    $("#cancel_btn").show();
                  }
                  
                } else {
                  $(this).removeClass('selected');
                  $("#edit_btn").hide();
                  $("#cancel_btn").hide();
                }
              }

            });


          }
           
           
        });


        $('#edit_btn').click( function () {
            var dataArr = '';
            $.each($("#daily_activity_table tr.selected"),function(){ 
                dataArr = $(this).find('td').eq(0).text(); 
            });

            $ajaxData = $.ajax({
              url: 'daily_activity/edit_activity_part',
              method: "GET",
              data: {
                activity_id : dataArr
              },
              dataType: "html",
              success:function(data){
                $("#show_modal").html(data);
                $('#edit_daily_activity').modal('show');
              }

            });
        } );

        $('#cancel_btn').click( function () {
            var dataArr = '';
            $.each($("#daily_activity_table tr.selected"),function(){ 
                dataArr = $(this).find('td').eq(0).text(); 
            });

            $ajaxData = $.ajax({
              url: 'daily_activity/cancel_activity_part',
              method: "GET",
              data: {
                activity_id : dataArr
              },
              dataType: "html",
              success:function(data){
                $("#show_modal").html(data);
                $('#cancel_daily_activity').modal('show');
              }

            });
        } );

        var table = $('#pending_confirmation_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "daily_activity/pending_confirmation_list"
           
        });
     
        $("#confirm_deny_btns").hide();
        $('#pending_confirmation_table tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');
            $("#confirm_deny_btns").show();
        } );
     
        $('#confirm_btn').click( function () {
           
            var count = table.rows('.selected').data().length;
            if(count > 0) {
                var dataArr = [];
                $.each($("#pending_confirmation_table tr.selected"),function(){ 
                    dataArr.push($(this).find('td').eq(0).text()); 
                });
                $ajaxData = $.ajax({
                  url: 'daily_activity/confirm_pending_activities',
                  method: "GET",
                  data: {
                    participant_ids : dataArr
                  },
                  success:function(data){
                    //if(data == 'true') {
                        alert(data);
                        $('#pending_confirmation_table').DataTable().ajax.reload();
                   // }
                  }

                });
            } else {
               alert('Please select row(s).');
            }
            
        } );

        $('#denied_btn').click( function () {
           
          var count = table.rows('.selected').data().length;
          if(count > 0) {
              var dataArr = [];
              $.each($("#pending_confirmation_table tr.selected"),function(){ 
                  dataArr.push($(this).find('td').eq(0).text()); 
              });
              $ajaxData = $.ajax({
                url: 'daily_activity/deny_pending_activities',
                method: "GET",
                data: {
                  participant_ids : dataArr
                },
                success:function(data){
                  alert(data);
                  $('#pending_confirmation_table').DataTable().ajax.reload();
                  
                }

              });
          } else {
            alert('Please select row(s).');
          }

        } );



    } );




    $('.auto-select').selectize({
      sortField: 'text'
    });

$(function() {
    $('.multiselect-ui').selectize({
      plugins: ['remove_button'],
      delimiter: ',',
      persist: true
  });

    $('.multiselect-ui-2').selectize({
      plugins: ['remove_button'],
      delimiter: ',',
      persist: true
  });

});


    $("#host_emp_div").hide();
    $("#add_daily_activity").on('change', '#a_activity_type', function () {
         if($(this).val() == 'Meeting with Visitor/s') {
            // If meeting with visitors, open modal
            // $("#visitors_log").modal('show');
            $("#host_emp_div").show();
        } else {
            $("#host_emp_div").hide();
        }
    });

  $("#add_daily_activity").on('change', '#prtcpnts', function () {
      $.each($(".multiselect-ui option:selected"), function(){   
      $('#host_emp')[0].selectize.removeItem($(this).val());     // OK  
      });
      
   });

  $("#add_daily_activity").on('change', '#host_emp', function () {
       $.each($(".multiselect-ui option:selected"), function(){    
        if ($(this).val() == $("#host_emp").val()) {
          $('#prtcpnts')[0].selectize.removeItem($(this).val()); 
        } 
      });
      
   });

  function if_allowed_participant() {
   
    $.each($(".edit-multiselect-ui option:selected"), function(){    
        if ($(this).val() == $("#e_host_emp").val()) {
          console.log('pumasok');
          $('#e_participants')[0].selectize.removeItem($("#e_host_emp").val()); 
        } 
      });
  }

  // hide sub-questions field on initial load
    $('#divSicknessOther').hide();
    $('#divSicknessDate').hide();
    $('#divTravel').hide();
    $('#divTravel2').hide();
    $('#divTravel3').hide();
    
    $('#q1_answer').on('change',function() {
        if ($(this).val().includes("12")){ // others
            $('#divSicknessOther').show();
        }else{
            $('#divSicknessOther').hide();
        }

        console.log($(this).val().indexOf("11") > -1);
        if($(this).val().includes("11")) { //None
          $('#divSicknessDate').hide();
          $('#q1_answer')[0].selectize.removeItem("1");
          $('#q1_answer')[0].selectize.removeItem("2");
          $('#q1_answer')[0].selectize.removeItem("3");
          $('#q1_answer')[0].selectize.removeItem("4");
          $('#q1_answer')[0].selectize.removeItem("5");
          $('#q1_answer')[0].selectize.removeItem("6");
          $('#q1_answer')[0].selectize.removeItem("7");
          $('#q1_answer')[0].selectize.removeItem("8");
          $('#q1_answer')[0].selectize.removeItem("9");
          $('#q1_answer')[0].selectize.removeItem("10");
          $('#q1_answer')[0].selectize.removeItem("12");
          $('#q1_answer')[0].selectize.addItem("11");

        } else {
          $('#q1_answer')[0].selectize.removeItem("11");
          $('#divSicknessDate').show();
        }
        
    });

     $('#q2_answer').on('change',function() {
        if ($(this).val() == "1"){ // if YES
            $('#divTravel').show();
            $('#divTravel2').show();
            $('#divTravel3').show();
        }else{
            $('#divTravel').hide();
            $('#divTravel2').hide();
            $('#divTravel3').hide();
        }
    });


    function hasValue(elem) {
        return $(elem).filter(function() { return $(this).val(); }).length > 0;
    }

    function isEmail(email) {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }

    function gimmeYesterday(toAdd) {
        if (!toAdd || toAdd == '' || isNaN(toAdd)) return;
        var d = new Date();
        console.log(d);
        d.setDate(d.getDate() - parseInt(toAdd));
        var yesterDAY = (d.getMonth() +1) + "/" + d.getDate() + "/" + d.getFullYear();
        return yesterDAY;
    }

    function save_daily_activity() {

        if (hasValue('#activity_date') == false || hasValue('#time_from') == false || hasValue('#time_to') == false || 
        hasValue('#a_activity_type')== false || hasValue('#location') == false  ) {
            $("#da_form_error").empty();
            $("#da_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
        } else {

          // check if activity date is more than 1 day
          if(Date.parse(gimmeYesterday(1)) < Date.parse($("#activity_date").val())) {
             // check if time_to is > time_from
            if($("#time_to").val() > $("#time_from").val()) {
              // check if meeting with visitors - should have host emp
               if($("#a_activity_type").val() == 'Meeting with Visitor/s') {
                  if(hasValue('#host_emp') == false) {
                    $("#da_form_error").empty();
                    $("#da_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
                  } else {

                    submit_daily_activity();
                  }
               } else {
                submit_daily_activity();
               }
              
              
            } else {
              $("#da_form_error").empty();
              $("#da_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> "Time To" should be greater than "Time From"</div>');
            }
          } else {
              $("#da_form_error").empty();
              $("#da_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Activity Date should not be less than 1 day from date today.</div>');
            }
         

            

        }


    }

    function submit_daily_activity() {
      $("#da_form_error").empty();
      var datastring = $("#add_da_form").serialize();

      // CHECK IF DATETIME RANGE ALREADY HAS SCHEDULE
      $ajaxData = $.ajax({
        url: 'daily_activity/validate_activity_schedule',
        method: "GET",
        data: datastring,
        success:function(data){
          // IF FALSE, PROCEED TO SUBMIT
          console.log("validate: " + data);
          if(data == 'false') {
            $("#btn_save_activity").prop("disabled", true);

              $ajaxData = $.ajax({
              url: 'daily_activity/add_daily_activity_ajax',
              method: "GET",
              data: datastring,
              success:function(data){
                console.log(data);
                if($.isNumeric(data)) {
                    $("#add_daily_activity").modal('toggle');
                    alert('Activity has been added.');
                    if($("#a_activity_type").val() == 'Meeting with Visitor/s') {
                      var date_visit = $("#activity_date").val();
                      var host_emp = $("#host_emp").val();
                      console.log(host_emp);
                      // If meeting with visitors, open modal
                      $("#visitors_log").modal('show');
                      // pass activity_id to visitors
                      $("#v_activity_id").val(data);
                      $("#delete_activity_id").val(data);
                      // pass date visit date to visitors
                      $("#date_visit").val(date_visit);
                      // pass host_emp value to person visiting
                      $("#person_visiting").val(host_emp);
                      $("#input_person_visiting").val(host_emp);
                       
                    } else {
                      location.reload(true);
                    }
                } else {
                    alert(data);
                }
              } 

            });
          } else if(data == 'requestor') {
            $("#da_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> You have already an activity within the specified date and time range.</div>');
            
          } else if(data == 'host') {
            $("#da_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Host Employee has already an activity within the specified date and time range.</div>');
          
          }
        
        }

      });

     
      
    }

    function clear_form() {
        $('#requestor').val("");
        $('#activity_type').val("");
        $('#status').val("");
        $('#start_dt').val("");
        $('#end_dt').val("");

        var $select = $('#participants').selectize();
        var control = $select[0].selectize;
        control.clear();

        var $select = $('#requestor').selectize();
        var control = $select[0].selectize;
        control.clear();
    }

    function save_add_form() {

         if (hasValue('#visitor_fname') == false  || hasValue('#visitor_lname') == false  ||  hasValue('#company') == false   || hasValue('#company_address') == false  || hasValue('#email') == false  || hasValue('#mobile') == false || hasValue('#residential_address') == false  || hasValue('#person_visiting') == false  || hasValue('#purpose') == false  || $("#q1_answer").val().length == 0  || $("#q2_answer").val().length == 0 ) {
            $("#vl_form_error").empty();
            $("#vl_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
        } else {
          if(isEmail($("#email").val())) {
              var CurrentDate = new Date();
              if($("#q1_answer").val().indexOf("11") === -1 && hasValue('#inputStartEndDate') == false){ // IF NONE (sickness) is not selected
                console.log($("#inputStartEndDate").val());
                $("#vl_form_error").empty();
                $("#vl_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');

              } else if($("#q2_answer").val().indexOf("2") === -1 && (hasValue('#inputTravelDate') == false || hasValue('#inputTravelLoc') == false || hasValue('#inputDatOfReturn') == false)){ // IF NO is not selected
                    $("#vl_form_error").empty();
                    $("#vl_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
              }else if(CurrentDate < Date.parse($("#inputTravelDate").val()) || CurrentDate < Date.parse($("#inputDatOfReturn").val())) {
                    $("#vl_form_error").empty();
                    $("#vl_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Travel dates should be past dated.</div>');
                  
              } else if($("#q1_answer").val().indexOf("12") > -1 && (hasValue('#inputOtherSickness') == false)){ // IF OTHERS is selected
                  $("#vl_form_error").empty();
                  $("#vl_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
            } else {
               multiple_visitors_submit();

              }

          } else {
            $("#vl_form_error").empty();
            $("#vl_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Invalid Email Address format.</div>');
          }

        }
    }

    function multiple_visitors_submit(){
      $("#vl_form_error").empty();
      var datastring = $("#add_visitors_form").serialize();
      var v_activity_id = $("#v_activity_id").val();
      var date_visit = $("#date_visit").val();
      var person_visiting = $("#person_visiting").val();

      console.log(datastring);
      $ajaxData = $.ajax({
        url:'daily_activity/add_visitors_log_ajax',
        method: "GET",
        data: datastring,
        success:function(data){
          alert('Visitor has been added.');
          $("#add_visitors_form").trigger('reset');
          var $select = $('#q1_answer').selectize();
          var control = $select[0].selectize;
          control.clear();

          $("#v_activity_id").val(v_activity_id);
          $("#date_visit").val(date_visit);
          $("#person_visiting").val(person_visiting);
          $("#input_person_visiting").val(person_visiting);
          $('#divSicknessOther').hide();
          $('#divSicknessDate').hide();
          $('#divTravel').hide();
          $('#divTravel2').hide();
          $('#divTravel3').hide();
        }
      });
    }

    function save_visitors_form(){
      
    if ( hasValue('#visitor_fname') == false  || hasValue('#visitor_lname') == false  || 
       hasValue('#company') == false   || hasValue('#company_address') == false  || hasValue('#email') == false  || hasValue('#mobile') == false || hasValue('#residential_address') == false  || hasValue('#person_visiting') == false  || hasValue('#purpose') == false 
       || $("#q1_answer").val().length == 0  || $("#q2_answer").val().length == 0 ) {
          $("#vl_form_error").empty();
          $("#vl_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');

    } else {
      if(isEmail($("#email").val())) {
          console.log($.trim($("#mobile").val()).length);
            var CurrentDate = new Date();
            if($("#q1_answer").val().indexOf("11") === -1 && hasValue('#inputStartEndDate') == false){ // IF NONE (sickness) is not selected
              console.log($("#inputStartEndDate").val());
              $("#vl_form_error").empty();
              $("#vl_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');

            } else if($("#q2_answer").val().indexOf("2") === -1 && (hasValue('#inputTravelDate') == false || hasValue('#inputTravelLoc') == false || hasValue('#inputDatOfReturn') == false)){ // IF NO is not selected
                  $("#vl_form_error").empty();
                  $("#vl_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
            }else if(CurrentDate < Date.parse($("#inputTravelDate").val()) || CurrentDate < Date.parse($("#inputDatOfReturn").val())) {
                  $("#vl_form_error").empty();
                  $("#vl_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Travel dates should be past dated.</div>');
                
            } else if($("#q1_answer").val().indexOf("12") > -1 && (hasValue('#inputOtherSickness') == false)){ // IF OTHERS is selected
                  $("#vl_form_error").empty();
                  $("#vl_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
            } else {
              single_visitors_submit();

            }

        } else {
          $("#vl_form_error").empty();
          $("#vl_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Invalid Email Address format.</div>');
        }

      }

    }

    function single_visitors_submit() {
      $("#vl_form_error").empty();
      $("#btn_save_visitors").prop("disabled", true);
      var datastring = $("#add_visitors_form").serialize();
      console.log(datastring);
      $ajaxData = $.ajax({
        url:'daily_activity/add_visitors_log_ajax',
        method: "GET",
        data: datastring,
        success:function(data){
          alert('Visitor has been added.');
          $('#visitors_log').modal('hide');
          location.reload();
        }
      });
    }

    $("#search_form_error").empty();
    function search_activities() {
      if($("#start_dt").val() > $("#end_dt").val()) {
        $("#search_form_error").empty();
        $("#search_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Invalid Date Range.</div>');
      } else {
         if ($.fn.DataTable.isDataTable("#daily_activity_table")) {
            $('#daily_activity_table').DataTable().clear().destroy();
          }
          $("#search_form_error").empty();
          var da_table = $('#daily_activity_table').DataTable({
              "processing": true,
              "serverSide": true,
              "searching":true,
              "order": [],
              "ajax": {
                  'type': 'GET',
                  'url': 'daily_activity/daily_activities_list',
                  'data': {
                      requestor : $("#requestor").val(),
                      participant : $("#participants").val(),
                      activity_type : $("#activity_type").val(),
                      status : $("#status").val(),
                      start_dt : $("#start_dt").val(),
                      end_dt : $("#end_dt").val()
                  }
              },
              select: {
                  style: 'single'
              },
              columnDefs: [ {
                 targets: [7],
                 data: null,
                 render: function ( data, type, row, meta ) {
                    if(row[7] == '') {
                        return 'FOR CONFIRMATION';
                    } else {
                        return row[7];
                    }
                 }
               }, 
               {
                   targets: [-1],
                   data: null,
                   render: function ( data, type, row, meta ) {
                      if(data[8] == 'BLANK') {
                        return "";
                      } else {
                        return '<button type="button" id="view_btn" onclick="view_participants('+row[0]+');" class="btn btn-outline-primary btn-block"><span class="fas fa-eye mr-1"></span>View</button>';
                      
                      }
                    
                   }
                } ]

          });

      }


 
    }







    function view_participants(activity_id) {
        $ajaxData = $.ajax({
          url: 'daily_activity/view_participants',
          method: "GET",
          data: {
            activity_id : activity_id
          },
          dataType: "html",
          success:function(data){
            $("#show_modal").html(data);
            $('#view_participants').modal('show');
          }

        });
    }



    function update_daily_activity(activity_id) {

      if (hasValue('#e_activity_date') == false || hasValue('#e_time_from') == false || hasValue('#e_time_to') == false || 
        hasValue('#e_activity_type')== false || hasValue('#e_location') == false  ) {
            $("#eda_form_error").empty();
            $("#eda_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
        } else {

          // check if activity date is more than today
          if(Date.parse(GetTodayDate()) < Date.parse($("#e_activity_date").val())) {
             // check if time_to is > time_from
            if($("#e_time_to").val() > $("#e_time_from").val()) {
              var now = new Date();
              var time_formatted =  now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
              var nowTIME= new Date(GetTodayDate() +" "+ time_formatted);
              var editedTIME = new Date($("#e_activity_date").val() +" "+ $("#e_time_from").val());
            console.log(nowTIME + "    " +editedTIME);
              if(nowTIME < editedTIME) {
              // check if meeting with visitors - should have host emp
               if($("#a_activity_type").val() == 'Meeting with Visitor/s') {
                  if(hasValue('#e_host_emp') == false) {
                    $("#eda_form_error").empty();
                    $("#eda_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
                  } else {
                   
                    update_daily_activity_submit();
                  }
               } else {
                  update_daily_activity_submit();
               }
             } else {
                $("#eda_form_error").empty();
                $("#eda_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Cannot update activity time prior the system time.</div>');
             }
              
              
            } else {
              $("#eda_form_error").empty();
              $("#eda_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> "Time To" should be greater than "Time From"</div>');
            }
          } else {
              $("#eda_form_error").empty();
              $("#eda_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Activity Date should not be prior from date today.</div>');
            }

        }

    }

function update_daily_activity_submit() {
  $("#eda_form_error").empty();
  var datastring = $("#edit_da_form").serialize();
   // CHECK IF DATETIME RANGE ALREADY HAS SCHEDULE
   $ajaxData = $.ajax({
    url: 'daily_activity/validate_edit_activity_schedule',
    method: "GET",
    data: datastring,
    success:function(data){
      // IF FALSE, PROCEED TO SUBMIT
      console.log("validate: " + data);
      if(data == 'false') {
         $("#edit_da_form").submit();
      } else if(data == 'requestor') {
        $("#eda_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> You have already an activity within the specified date and time range.</div>');
        
      } else if(data == 'host') {
        $("#eda_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Host Employee has already an activity within the specified date and time range.</div>');
      
      }
    
    }

  });

 
}

function e_activity_change(val) {
    console.log(val );
    if(val == 'Meeting with Visitor/s') {
      // If meeting with visitors, show host emp
      $("#e_host_emp_div").show();
    } else {
      $("#e_host_emp").val("");
      $("#e_host_emp_div").hide();
    }
  }

function GetTodayDate() {
   var tdate = new Date();
   var dd = tdate.getDate(); //yields day
   var MM = tdate.getMonth(); //yields month
   var yyyy = tdate.getFullYear(); //yields year
   var currentDate= (MM+1) + "-" + dd + "-" + yyyy;

   return currentDate;
}

function number_or_special_char(event) {
    var regex = new RegExp("^[0-9*#+?<>@()-=]+$");
      var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
      if (!regex.test(key)) {
          event.preventDefault();
          return true;
      }
}

function reload_page() {
  location.reload(true);
}

    
