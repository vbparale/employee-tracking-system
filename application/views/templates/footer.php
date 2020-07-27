<footer class="text-center border border-grey border-bottom-0 border-left-0 border-right-0 p-2">
    <a href="#!" class="toTop font-weight-bolder text-decoration-none text-dark">^</a><br>
    <small class="font-weight-bold mb-0">Employee Tracking System version <?= APP_VERSION ?></small><br>
    <small>Copyright © 2020 Federal Land Inc.</small><br>
</footer>
<!-- Script Links -->
<script src="dist/js/jquery-3.4.1.min.js"></script>
<script src="dist/js/popper.min.js"></script>
<script src="dist/bootstrap/js/bootstrap.min.js"></script>
<script src="dist/js/jquery.form.validator.min.js"></script> 
<script src="dist/custom_js/login.js"></script>
<script src="dist/custom_js/ets.js"></script>
<script src="dist/custom_js/custom.js"></script>
<!-- End -->

<!-- VIEL 05182020 -->
<script type="text/javascript">
  function hasValue(elem) {
    return $(elem).filter(function() { return $(this).val(); }).length > 0;
}

function validate_password() {
 if (hasValue('#current_pass') <= 0 || hasValue('#new_pass') <= 0 || hasValue('#confirm_pass') <= 0 ) {
    alert('Please fill out the required field to proceed.');
  } else {

      $ajaxData = $.ajax({
      url: "<?= base_url('api/check_password') ?>",
      method: "GET",
      data: {
        password : $("#current_pass").val()
      },
      dataType: "html",
      success:function(data){
        // check current pass if true
        if(data == 'true') {
          if ($("#new_pass").val() == $("#confirm_pass").val()){
             $('#change_pw_form').submit();
          } else {
            // not equal new pass and confirm pass
            alert('New Password you have entered does not matched. ');
          }
        } else {
          alert('Current Password is incorrect. ');
        }
      }

    });
  }
 
}
</script>
<!-- END 05182020 -->

</body>
</html>