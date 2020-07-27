<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <link rel="shortcut icon" href="favicon.ico"/>
        <link rel="stylesheet" href="dist/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url('dist/custom_css/ets.css') ?>" />
        
        <style>
            body {
                height: 100%;
            }
        </style>
    </head>
    <body>
        <!-- A grey horizontal navbar that becomes vertical on small screens -->
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <a class="navbar-brand" href="<?php echo base_url(); ?>">Employee Tracking System</a>
            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

                    <?php if(isset($this->session->module['EHC'])):?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $dhc ?>" href="dhc">Employee Daily Health Check</a>
                    </li>
                    <?php endif; ?>

                    <?php if(isset($this->session->module['HDF'])):?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $hdf ?>" href="hdf">Health Declaration Form</a>
                    </li>
                    <?php endif; ?>

                    <?php if(isset($this->session->module['DA'])):?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $da ?>" href="da">Daily Activity</a>
                    </li>
                    <?php endif; ?>

                    <?php if(isset($this->session->module['VL'])):?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $vl ?>" href="vl">Visitor's Log</a>
                    </li>
                    <?php endif; ?>
                    
                    <?php if(isset($this->session->module['RP'])):?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $rprts ?>" href="rprts">Reports</a>
                    </li>
                    <?php endif; ?>

                    <?php if(isset($this->session->module['HDFCO']) || isset($this->session->module['UM'])):?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $admin ?>" href="administration">Administration</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hi, <?php echo $_SESSION['EMP_FNAME'] ?></button>
                        <div class="dropdown-menu dropdown-menu-right">
                             <a class="dropdown-item" id="change_pass_btn" href="#" data-toggle="modal" data-target="#change_password"><span class="fa fa-edit"></span> Change Password</a>
                            <a class="dropdown-item" href="api/logout">Logout</a>
                        </div>
                    </div>
                </form>
            </div>

        </nav>

 <!-- CHANGE PASSWORD Modal // VIEL 05182020 -->
<div class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <?php echo form_open('api/change_password', array( 'id' => 'change_pw_form', 'class' => 'needs-validation', 'novalidate' => true));?>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="col-md-12">
           
            <label for="area">Current Password</label>
            <input type="password" class="form-control" id="current_pass" name="current_pass" placeholder="Current Password" required>
        </div>
        <hr>
        <div class="col-md-12">
            <label for="area">New Password</label>
            <input type="password" class="form-control" id="new_pass" name="new_pass" placeholder="New Password"  placeholder="Password" value="" onpaste="return false" required>
        </div>
        <div class="col-md-12">
            <label for="area">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_pass" name="confirm_pass" placeholder="Confirm Password" placeholder="Password" value="" onpaste="return false" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="validate_password()" class="btn btn-primary">Save</button>
        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
 <?php echo form_close();?>
  </div>
</div>
<!-- End of CHANGE PASSWORD Modal 05182020 -->