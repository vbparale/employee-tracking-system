/**
 * Custom script for Employee Tracking System
 * Added: Ben Zarmaynine E. Obra
 * Date: May 06, 2020
 * 
 */

$(document).ready(function(){

    /**
     * Load event
     */
    if($('.reports').length){

    const uri = $('.reports').attr('data-uri');

    const app = ajaxHTML(uri,'',function(){
        $('#app').html(`<center><div class="loader"></div></center>`);
    });

    app.done(function(data){

        setTimeout(function(){

            $('#app').html(data);
            $('.report_panel').fadeIn(850);

        }, 350);

        $('html, body').animate({
            scrollTop: $("#appResult").offset().top
        }, 2000);        

    });

    app.fail(function(data){

        alert('fail');
    });

    }
        
});


$('.toTop').click(function () {
    $("html, body").animate({
        scrollTop: 0
    }, 600);
    return false;
});

/**
 * Change Event
 */
$('body').on('change','#COMP_CODE,#GRP_CODE',function(){

    let id = $(this).attr('id');
    let group;
    let company;

    switch (id) {
        case 'GRP_CODE':

            group = $(this).val();
            company = $('#COMP_CODE').val();        
            break;

        case 'COMP_CODE':

            company = $(this).val();
            group = $('#GRP_CODE').val();
            break;

        default:
            break;
    }

    let uri = $(this).attr('data-uri');

    let params = {

        company:company,
        group:group
    };

    const changeResult = ajaxSubmit(uri,params,'',"GET");

    changeResult.done(function(data){

        let changeoutput = '';
        changeoutput += '<option value="">Select Employee</option>';
        let resDropDown = data.list
        
        $('#EMP_CODE').empty();
        $('#EMP_CODE').prop('disabled',true);
        $('#EMP_CODE').append('<option value="">loading...</option>');
        for (let index = 0; index < resDropDown.length; index++) {
            changeoutput +=`<option value="${resDropDown[index]['EMP_CODE']}">
                    ${resDropDown[index]['EMP_LNAME']} ${resDropDown[index]['EMP_FNAME']}
                </option>
            `;
        }
        
        setTimeout(function(){

            $('#EMP_CODE').empty();
            $('#EMP_CODE').prop('disabled',false);
            $('#EMP_CODE').append(changeoutput);

        },350);
        
    });

});