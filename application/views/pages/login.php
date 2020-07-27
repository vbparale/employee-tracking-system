<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <link rel="shortcut icon" href="favicon.ico"/>
        <link rel="stylesheet" href="dist/bootstrap/css/bootstrap.min.css">
        <style>
            .box{
                margin-top: 10%;
            }
        </style>
    </head>
    
    <body>
    <div class="row box">
    <div class="col-3" style="margin: auto;">
        <div class="container border p-3" style="border-radius: 5px; background-color: #a3d1c8;">
            <div class="row text-center center-align">
                <div class="col">
                    <h5>Employee Tracking System</h5>
                    <hr>
                </div>
            </div>
                <div class='form-group'>
                <input id="base_url" type="hidden" value='<?php echo base_url(); ?>'>
                    <?php echo form_open('', array( 'id' => 'login_form', 'class' => 'needs-validation', 'novalidate' => true));?>
                    <div class='form-row text-center'>
                        <div class='col-12'>
                            <div class='form-group'>
                                <div class='invalid-feedback' id="validation_div">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='col-12'>
                            <div class='form-group'>
                            <label for='LOGIN_ID'>Login ID:</label>
                            <input type='text' class='form-control' id='LOGIN_ID' name='LOGIN_ID' maxlength="8" required>
                            <div class='invalid-feedback'>
                                This field is required.
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='col-12'>
                            <div class='form-group'>
                            <label for='PASSWORD'>Password:</label>
                            <input type='password' oncopy="return false;" onpaste="return false;" class='form-control' id='PASSWORD' name='PASSWORD' autocomplete="off" maxlength="20" required>
                            <div class='invalid-feedback'>
                                This field is required.
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='form-row text-center'>
                            <div class='col-12'>
                                <div class='form-group'>
                                    <button id='login' type='button' class='btn btn-primary'>Login</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
        </div>
        </div>
    </div>
    </body>
    <script src="dist/js/jquery.min.js"></script>
    <script src="dist/js/popper.min.js"></script>
    <script src="dist/bootstrap/js/bootstrap.min.js"></script>
    <script src="dist/custom_js/login.js"></script>
    </html>