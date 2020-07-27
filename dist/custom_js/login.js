$("#validation_div").hide();

$("#login").on('click', function(){
    $("#login_form").addClass('was-validated');
    if($("#login_form")[0].checkValidity()){
        //Serialize form as array
        var serializedForm = $("#login_form").serializeArray();
        //trim values
        for(var i = 0; i < serializedForm.lengthen ;i++){
            serializedForm[i] = $.trim(serializedForm[i]);
        }
        //turn it into a string
        serializedForm = $.param(serializedForm);
        // disable submit button to prevent double submit
        $("#validation_div").hide();
        $("#LOGIN_ID").prop("readonly", true);
        $("#PASSWORD").prop("readonly", true);
        $("#login").prop("disabled", true);
        $("#login").html("Submitting...");
        // submit thru ajax
            $.ajax({
                url: 'api/login',
                type: 'POST',
                data: serializedForm,
                cache: 'no-cache',
                success: function(data) {
                    
                    data = JSON.parse(data);
                    console.log(data['success']);
                    if(data['success']){
                        var url = $("#base_url").val() + "dhc";
                        window.location.replace(url);
                    }
                    else{
                        $("#validation_div").show();
                        $("#validation_div").html("Invalid Login ID or password. Please try again.");
                        $("#LOGIN_ID").prop("readonly", false);
                        $("#PASSWORD").prop("readonly", false);
                        $("#login").prop("disabled", false);
                        $("#login").html("Submit");
                    }
                },
                fail: function(err){
                    alert('An error has occured. Please contact your system administrator. Error: '+err);
                    console.log(err)
                }
            });
    }
});

$("#login_form").on('keypress',function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
        $("#login_form").addClass('was-validated');
        if($("#login_form")[0].checkValidity()){
            //Serialize form as array
            var serializedForm = $("#login_form").serializeArray();
            //trim values
            for(var i = 0; i < serializedForm.lengthen ;i++){
                serializedForm[i] = $.trim(serializedForm[i]);
            }
            //turn it into a string
            serializedForm = $.param(serializedForm);
            // disable submit button to prevent double submit
            $("#validation_div").hide();
            $("#LOGIN_ID").prop("readonly", true);
            $("#PASSWORD").prop("readonly", true);
            $("#login").prop("disabled", true);
            $("#login").html("Submitting...");
            // submit thru ajax
                $.ajax({
                    url: 'api/login',
                    type: 'POST',
                    data: serializedForm,
                    cache: 'no-cache',
                    success: function(data) {
                        
                        data = JSON.parse(data);
                        console.log(data['success']);
                        if(data['success']){
                            var url = $("#base_url").val() + "dhc";
                            window.location.replace(url);
                        }
                        else{
                            $("#validation_div").show();
                            $("#validation_div").html("Invalid Login ID or password. Please try again.");
                            $("#LOGIN_ID").prop("readonly", false);
                            $("#PASSWORD").prop("readonly", false);
                            $("#login").prop("disabled", false);
                            $("#login").html("Submit");
                        }
                    },
                    fail: function(err){
                        alert('An error has occured. Please contact your system administrator. Error: '+err);
                        console.log(err)
                    }
                });
        }
    }
});