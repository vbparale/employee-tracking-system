<link rel="stylesheet" href="dist/custom_css/multiselect.css"/>
<link rel="stylesheet" type="text/css" href="dist/fontawesome/css/all.min.css">
<link rel="stylesheet" href="dist/custom_css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="dist/dataTables/dataTables.bootstrap4.min.css">
<style type="text/css">
  table.dataTable tbody tr.selected {
    color: #007bff !important;
    background-color: #eeeeee !important;
}
</style>



<div class="col-md-12 col-lg-12" style="padding: 20px;">
    <div class="container box p-3 ">
        <h3>Administration</h3><hr>

		<ul class="nav nav-tabs" id="myTab" role="tablist">
      <?php
        $active = '';
        if(isset($this->session->module['UM'])) {
            $active = 'active';
      ?>

		  <li class="nav-item">
		    <a class="nav-link <?= $active ?>" id="users_tab" data-toggle="tab" href="#users_div" role="tab" >User Maintenance</a>
		  </li>
      <?php } ?>


      <?php
        if(isset($this->session->module['HDFCO']) && $active != 'active') {
          $active = 'active';
        } else {
          $active = '';
        }
      ?>

      <?php if(isset($this->session->module['HDFCO'])):?>
		  <li class="nav-item <?= $active ?>">
		    <a class="nav-link" id="hdf_tab" data-toggle="tab" href="#hdf_div" role="tab" >HDF Cut-Off</a>
		  </li>
      <?php endif; ?>

		</ul>

    
		<div class="tab-content" id="myTabContent">
			<!-- USER MAINTENANCE DIV -->
      <?php
        $show = '';
        if(isset($this->session->module['UM'])) {
            $show = 'show active';
        }
      ?>

		  <div class="tab-pane fade <?= $show ?>" id="users_div" role="tabpanel">
		  	<?= $this->load->view('pages/part/user_maintenance_part', '', TRUE) ?>
		  </div>

		  <!-- HDF CUTOFF DIV -->
      <?php

        if(isset($this->session->module['HDFCO']) && $show != 'show active') {
          $show = 'show active';
        } else {
          $show = '';
        }
      ?>

		  <div class="tab-pane fade <?= $show ?>" id="hdf_div" role="tabpanel">
        <?= $this->load->view('pages/part/hdf_maintenance_part', '', TRUE) ?>
		  </div>

		</div>
	    </div>
    </div>
</div>

<!-- Defaults -->
<script src="dist/js/jquery.min.js"></script>
<script src="dist/js/popper.min.js"></script>
<script src="dist/bootstrap/js/bootstrap.min.js"></script>
<script src="dist/js/jquery.form.validator.min.js"></script> 

<!-- For datatable -->
<script type="text/javascript" src="dist/DataTables/datatables.min.js"></script>
<script type="text/javascript" src="dist/DataTables/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var da_table = $('#users_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "admin/get_users_info_list",
            "type" : "GET",
            select: {
                style: 'single'
            }
           
        });

      $("#edit_btn").hide();
	    $('#users_table tbody').on( 'click', 'tr', function () {
	        if ( $(this).hasClass('selected') ) {
	            $(this).removeClass('selected');
	            $("#edit_btn").hide();
	        }
	        else {
	            da_table.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	            $("#edit_btn").fadeIn();
	        }
	   } );

      $('#edit_btn').click( function () {
          var dataArr = '';
          $.each($("#users_table tr.selected"),function(){ 
              dataArr = $(this).find('td').eq(1).text(); 
          });
          console.log(dataArr);
          $ajaxData = $.ajax({
            url: "<?= base_url('admin/edit_user_data_part') ?>",
            method: "GET",
            data: {
              emp_code : dataArr
            },
            dataType: "html",
            success:function(data){
              $("#show_modal").html(data);
              $('#edit_user_profile').modal('show');
            }

          });
      } );
    
    // RAMIL 
    $("#select_users").hide();
    $("#edit_select_users").hide();
    
    var cutoff_table = $('#cutoff_table').DataTable({
        "ajax": {
            "url": "admin/get_hdf_cutoff",
            "type": "GET"
        },
        "columns": [
            {"data": "CUTOFFID"},
            {"data": "EMP_FLAG"},
            {"data": "SUBMISSION_DATE"},
            {"data": "CUTOFF_TIME"}
        ],
        select: {
          style: 'single'
        },
        columnDefs: [
          {
              targets: [0, 1, 2, 3],
              className: "text-center"
          },
          {
            targets: 1,
            render: function(data, type){
                if(type === 'display'){
                  if(data == 1){
                    data = "All Employees";
                  }
                  else{
                    data = "Specific Employees";
                  }
                }
                return data;
            }
          }
      ]
    });

    $("#edit_hdf_btn").hide();

    $('#cutoff_table tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            $("#edit_hdf_btn").hide();
        }
        else {
          cutoff_table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            $("#edit_hdf_btn").fadeIn();
        }
    });
    

    var employees = $.ajax({
      url: "admin/get_users_info_list",
      method: "GET",
      dataType: "json"
    });

    $("#add_hdf_btn").on('click', function(){
      employees.done(function(data){
        var users = data['data'];
        $('#emp_code').empty();
        $('#emp_code').append('<option value="" disabled selected>--Please Choose--</option>');
        $.each(users, function (i) {
          $('#emp_code').append($('<option>', { 
              value: users[i][1],
              text : users[i][2] + ", " + users[i][3] 
          }));
        });
      });
    });

    $("#emp_flag").on('change', function(){
      if($(this).val() == 1){
        $("#select_users").hide();
        $("#emp_code").prop('disabled', true);
        $("#emp_code").prop('required', false);
      }
      else{
        $("#select_users").show();
        $("#emp_code").prop('disabled', false);
        $("#emp_code").prop('required', true);
      }
    });

    $("#save_cutoff_btn").on('click', function(){
      if (hasValue('#submission_date') == false || hasValue('#cutoff_time') == false  || hasValue('#emp_flag') == false) {
          $("#cutoff_form_error").empty();
          $("#cutoff_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
      }
      else{
        var server_date = "";
        var get_server_date = $.ajax({
            url: "api/server_date/",
            method: "GET",
            async: false
        });

        get_server_date.done(function(data){
            server_date = data;
        });
        if(server_date == $("#submission_date").val()){
          var server_time = "";
          var get_server_time = $.ajax({
              url: "api/server_time/",
              method: "GET",
              async: false
          });

          get_server_time.done(function(data){
              server_time = data;
          });
          var cutoff_time = $("#cutoff_time").val();
          if(cutoff_time < server_time){
            $("#cutoff_form_error").empty();
            $("#cutoff_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Current time is already past the cutoff time selected.</div>');
          }
          else{
            if($("#emp_flag").val() == 2){
              if($("#emp_code").val().length < 1){
                $("#cutoff_form_error").empty();
                $("#cutoff_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
              }
              else{
                var datastring = $("#cutoff_form").serialize();
                $ajaxData = $.ajax({
                  url: "<?= base_url('admin/add_hdf_cutoff') ?>",
                  method: "POST",
                  data: datastring,
                  success:function(data){
                    if(data){
                      alert("HDF Cutoff has been added.");
                      location.reload();
                    }
                    else{
                      alert("Cutoff with same submission date is already existing. Please select a new date.");
                      location.reload();
                    }
                  }
                });
              }
            }
            else{
              var datastring = $("#cutoff_form").serialize();
              $ajaxData = $.ajax({
                url: "<?= base_url('admin/add_hdf_cutoff') ?>",
                method: "POST",
                data: datastring,
                success:function(data){
                  if(data){
                    alert("HDF Cutoff has been added.");
                    location.reload();
                  }
                  else{
                    alert("Cutoff with same submission date is already existing. Please select a new date.");
                    location.reload();
                  }
                }
              });
            }
          }
        }
        else{
          if($("#emp_flag").val() == 2){
              if($("#emp_code").val().length < 1){
                $("#cutoff_form_error").empty();
                $("#cutoff_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
              }
              else{
                var datastring = $("#cutoff_form").serialize();
                $ajaxData = $.ajax({
                  url: "<?= base_url('admin/add_hdf_cutoff') ?>",
                  method: "POST",
                  data: datastring,
                  success:function(data){
                    if(data){
                      alert("HDF Cutoff has been added.");
                      location.reload();
                    }
                    else{
                      alert("Cutoff with same submission date is already existing. Please select a new date.");
                      location.reload();
                    }
                  }
                });
              }
            }
            else{
              var datastring = $("#cutoff_form").serialize();
              $ajaxData = $.ajax({
                url: "<?= base_url('admin/add_hdf_cutoff') ?>",
                method: "POST",
                data: datastring,
                success:function(data){
                  if(data){
                    alert("HDF Cutoff has been added.");
                    location.reload();
                  }
                  else{
                    alert("Cutoff with same submission date is already existing. Please select a new date.");
                    location.reload();
                  }
                }
              });
            }
        }
      }
    });

    $('#edit_hdf_btn').on('click',function () {
        var dataArr = '';
        $.each($("#cutoff_table tr.selected"),function(){ 
            dataArr = $(this).find('td').eq(0).text(); 
        });
        console.log(dataArr);
        $ajaxData = $.ajax({
          url: "<?= base_url('admin/edit_cutoff_part') ?>",
          method: "GET",
          data: {
            cutoffid : dataArr
          },
          dataType: "json",
          success:function(data){
            console.log(data)
            var submission_date = new Date(data[0]['SUBMISSION_DATE']);

            var server_date = "";
            var get_server_date = $.ajax({
                url: "api/server_date/",
                method: "GET",
                async: false
            });

            get_server_date.done(function(data){
                server_date = data;
            });
            
            if(data[0]['ANS_FLAG'] == 1 || data[0]['SUBMISSION_DATE'] < server_date){
              alert("You can't edit this record.");
            }
            else{
              $('#edit_cutoff').modal('show');

              $("#cutoffid").val(data[0]['CUTOFFID']);
              $("#edit_submission_date").val(data[0]['SUBMISSION_DATE']);
              $("#edit_cutoff_time").val(data[0]['CUTOFF_TIME']);
              
              if(data[0]['EMP_FLAG'] == 1){
                $("#edit_emp_flag").val(data[0]['EMP_FLAG']);
                $("#edit_emp_flag").trigger('change');
              }
              else{
                $("#edit_emp_flag").val(data[0]['EMP_FLAG']);
                $("#edit_emp_flag").trigger('change');
                var ctemp = $.ajax({
                  url: "admin/get_hdf_ctemp",
                  method: "GET",
                  dataType: "json",
                  data: {
                    cutoffid: dataArr
                  }
                });

                
                ctemp.done(function(data){
                  console.log(data)
                  $.each(data, function(i){
                    
                    $("#edit_emp_code option[value='" + data[i]['EMP_CODE'] + "']").prop("selected", true);
                  });
                });
              }
              employees.done(function(data){
                var users = data['data'];
                $('#edit_emp_code').empty();
                $('#edit_emp_code').append('<option value="" disabled selected>--Please Choose--</option>');
                $.each(users, function (i) {
                  $('#edit_emp_code').append($('<option>', { 
                      value: users[i][1],
                      text : users[i][2] + ", " + users[i][3] 
                  }));
                });
              });
              
            }
            
          }

        });
    });

    $("#update_cutoff_btn").on('click', function(){
      if (hasValue('#edit_submission_date') == false || hasValue('#edit_cutoff_time') == false  || hasValue('#edit_emp_flag') == false) {
          $("#cutoff_form_error").empty();
          $("#cutoff_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
      }
      else{
        var server_date = "";
        var get_server_date = $.ajax({
            url: "api/server_date/",
            method: "GET",
            async: false
        });

        get_server_date.done(function(data){
            server_date = data;
        });
        if(server_date == $("#edit_submission_date").val()){
          console.log('same date')
          var server_time = "";
          var get_server_time = $.ajax({
              url: "api/server_time/",
              method: "GET",
              async: false
          });

          get_server_time.done(function(data){
              server_time = data;
          });
          var cutoff_time = $("#edit_cutoff_time").val();
          if(cutoff_time < server_time){
            console.log('past time')
            $("#edit_cutoff_form_error").empty();
            $("#edit_cutoff_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Current time is already past the cutoff time selected.</div>');
          }
          else{
            if($("#edit_emp_flag").val() == 2){
              if($("#edit_emp_code").val().length < 1){
                $("#edit_cutoff_form_error").empty();
                $("#edit_cutoff_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
              }
              else{
                var datastring = $("#edit_cutoff_form").serialize();
                console.log(datastring);
                $ajaxData = $.ajax({
                  url: "<?= base_url('admin/update_hdf_cutoff') ?>",
                  method: "POST",
                  data: datastring,
                  success:function(data){
                    // if(data){
                      alert("HDF Cutoff has been updated.");
                      location.reload();
                    // }
                    // else{
                    //   alert("Cutoff with same submission date is already existing. Please select a new date.");
                    //   location.reload();
                    // }
                  }
                });
              }
            }
            else{
              var datastring = $("#edit_cutoff_form").serialize();
              $ajaxData = $.ajax({
                url: "<?= base_url('admin/update_hdf_cutoff') ?>",
                method: "POST",
                data: datastring,
                success:function(data){
                  // if(data){
                    alert("HDF Cutoff has been updated.");
                    location.reload();
                  // }
                  // else{
                  //   alert("Cutoff with same submission date is already existing. Please select a new date.");
                  //   location.reload();
                  // }
                }
              });
            }
          }
        }
        else{
          if($("#edit_emp_flag").val() == 2){
            if($("#edit_emp_code").val().length < 1){
              $("#edit_cutoff_form_error").empty();
              $("#edit_cutoff_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
            }
            else{
              var datastring = $("#edit_cutoff_form").serialize();
              console.log(datastring);
              $ajaxData = $.ajax({
                url: "<?= base_url('admin/update_hdf_cutoff') ?>",
                method: "POST",
                data: datastring,
                success:function(data){
                  // if(data){
                    alert("HDF Cutoff has been updated.");
                    location.reload();
                  // }
                  // else{
                  //   alert("Cutoff with same submission date is already existing. Please select a new date.");
                  //   location.reload();
                  // }
                }
              });
            }
          }
          else{
            var datastring = $("#edit_cutoff_form").serialize();
            $ajaxData = $.ajax({
              url: "<?= base_url('admin/update_hdf_cutoff') ?>",
              method: "POST",
              data: datastring,
              success:function(data){
                // if(data){
                  alert("HDF Cutoff has been updated.");
                  location.reload();
                // }
                // else{
                //   alert("Cutoff with same submission date is already existing. Please select a new date.");
                //   location.reload();
                // }
              }
            });
          }
        }
        
        
      }
    });

    $("#edit_emp_flag").on('change', function(){
      if($(this).val() == 1){
        $("#edit_select_users").hide();
        $("#edit_emp_code").prop('disabled', true);
      }
      else{
        $("#edit_select_users").show();
        $("#edit_emp_code").prop('disabled', false);
      }
    })
    // RAMIL ^


    });

    
</script>

<script type="text/javascript">
	function search_user() {
       if ($.fn.DataTable.isDataTable("#users_table")) {
          $('#users_table').DataTable().clear().destroy();
        }

        var da_table = $('#users_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                'type': 'GET',
                'url': "admin/get_users_info_list",
                'data': {
                    company : $("#company").val(),
                    group : $("#group").val(),
                    firstname : $("#firstname").val(),
                    lastname : $("#lastname").val(),
                    access_group : $("#access_group").val(),
                    status : $("#status").val()
                }
            },
            select: {
                style: 'single'
            }

        });

 
    }

    function clear_form() {
        $('#firstname').val("");
        $('#lastname').val("");
        $('#company').val("");
        $('#group').val("");
        $('#access_group').val("");
        $('#status').val("");

    }

    function hasValue(elem) {
        return $(elem).filter(function() { return $(this).val(); }).length > 0;
    }


    function save_user_profile() {
       
      if (hasValue('#login_id') == false || hasValue('#password') == false  || hasValue('#user_role') == false  ||  hasValue('#email_address') == false   || hasValue('#mobile') == false ) {
            $("#um_form_error").empty();
            $("#um_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
        } else {

          var datastring = $("#add_user_form").serialize();
          console.log(datastring);
          $ajaxData = $.ajax({
            url: "<?= base_url('admin/add_user_profile_ajax') ?>",
            method: "GET",
            data: datastring,
            success:function(data){
              if(data == 'true') {
                alert('User Profile has been added.');
                location.reload();
              }
            }

          });
      }

    }




    
    $("#information_div").hide();
    $("#add_user_profile").on('change', '#employee_name', function () {
        $ajaxData = $.ajax({
          url: "<?= base_url('admin/get_user_data_ajax') ?>",
          method: "GET",
          data: {
          	'emp_code' : $('#employee_name').val()
          },
          success:function(data){
          	console.log(data);
           $("#information_div").fadeIn();
           var obj = JSON.parse(data);
           $("#add_user_profile #employee_number").val($('#employee_name').val());
           $("#add_user_profile #lastname").val(obj.EMP_LNAME);
           $("#add_user_profile #firstname").val(obj.EMP_FNAME);
           $("#add_user_profile #middlename").val(obj.EMP_MNAME);
           $("#add_user_profile #gender").val(obj.GENDER);
           $("#add_user_profile #birthday").val(obj.BIRTHDATE);
           $("#add_user_profile #age").val(obj.AGE);
           $("#add_user_profile #mobile").val(obj.MOBILE_NO);
           $("#add_user_profile #telephone").val(obj.TEL_NO);
           $("#add_user_profile #present_address").val(obj.PRESENT_ADDR1 + ' ' +obj.PRESENT_ADDR2+ ' ' +obj.PRESENT_CITY+ ' ' +obj.PRESENT_PROV);
           $("#add_user_profile #provincial_address").val(obj.PERM_CITY + ' ' +obj.PERM_PROV);
           $("#add_user_profile #location").val(obj.LOCATION_NAME);
           $("#add_user_profile #company").val(obj.COMP_NAME);
           $("#add_user_profile #department").val(obj.DEPT_NAME);
            $("#add_user_profile #group").val(obj.GRP_NAME);
          $("#add_user_profile #date_hired").val(obj.DATE_HIRED);
          $("#add_user_profile #date_eoc").val(obj.DATE_EOC);
          $("#add_user_profile #employee_status").val(obj.EMPSTAT_DESC);
          $("#add_user_profile #level").val(obj.RANK_DESC);
          $("#add_user_profile #team_schedule").val(obj.SCHEDULE);


          }

        });
    });

    function show_hide_password() {
      var $pwd = $(".pwd");
      if ($pwd.attr('type') === 'password') {
          $pwd.attr('type', 'text');
      } else {
          $pwd.attr('type', 'password');
      }
    
    }

    function update_user_profile() {
       
      if ( hasValue('#eemail_address') == false   || hasValue('#emobile') == false ) {
            $("#update_um_form_error").empty();
            $("#update_um_form_error").append('<div class="alert alert-danger" role="alert"><span class="fa fa-exclamation-triangle"></span> Please fill out all the required information.</div>');
        } else {
           $("#edit_user_form").submit();
        }
    }


</script>