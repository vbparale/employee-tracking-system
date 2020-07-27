$(document).ready(function(){

    /**
     * Form Transaction Click Event
     */
    $('body').on('click','.generate_report',function(e){
        e.preventDefault();

		const form = $(this).closest("form");
        const action = $(form).attr("action");
        const method = $(form).attr('method');

		const classTitle = $(this).attr('class').split(" ");			
		const btnClass = '.'+classTitle;        
        
        if(form.length == 1){

            let formData = form.serialize();

            let reports = ajaxSubmit(action,formData,btnClass);

            reports.done(function(data){
                
                if (data.success === 'true') {
                    
                    let ResPage = data.view;
                    $('#appResult').html(ResPage);
                    
                    $('html, body').animate({
                        scrollTop: $("#appResult").offset().top
                    }, 1500);
                    
                    $('.form-control').removeClass('border-danger');
                    $('.text-danger').remove();

                    setTimeout(function(){

                        $('#main_collapse').toggle('collapse');
                        $('.card-header h2').fadeOut(1000);
                        $('.collapser').fadeIn(1000);
            
                    },850);                    

                } else if(data.success === 'error'){


                } else {

                    $('.text-danger').remove();
                    $.each(data.messages, function(key,value){

                        let Newelement = $('#'+ key);
                        Newelement.closest('div.form-group');
                        Newelement.removeClass('border-danger');
                        Newelement.addClass(value.length > 0 ? 'border-danger' : 'border-success');
                        Newelement.find('.text-danger').remove();
                        Newelement.after(value);

                    });
                }
            });

            reports.fail(function(data){

                
            });

        }
		        

    });    
});

    /**
     * 
     * clear form
     * 
     */
    $('body').on('click','.clear_form',function(e){
        e.preventDefault();

        if(typeof dar_ssp != 'undefined'){

            dar_ssp.destroy();

        }

        if (typeof ehc_ssp != 'undefined') {
            
            ehc_ssp.destroy();
        }

        const user_parent = $(this).parent("a");
        const url = user_parent.attr("href");
        
        const app = ajaxHTML(url,'.clear_form');

        app.done(function(data){

            $('#app').empty();
            $('#app').html(data);
            $('.report_panel').fadeIn(760);
            $('#appResult').empty();
        });
    
        app.fail(function(data){
    
            alert('fail');
        });        
    });

    $('body').on('click','.collapser',function(e){
        e.preventDefault();

		const classTitle = $(this).attr('class').split(" ");			
		const btnClass = '.'+classTitle; 

        $(btnClass).prop('disabled',true);
        $(btnClass).html('loading...');

        $('#main_collapse').toggle('collapse');

        setTimeout(function(){

            $(btnClass).prop('disabled',false);
            $(btnClass).html('Search New');
            $(btnClass).fadeOut(1000);
            $('.card-header h2').fadeIn(1000);
            $('#appResult').empty();
            
        },650);

    });

    /**
     * Change Event
     */
    $('body').on('change','#report_type',function(){
        
        const select_value = $(this).val();
        let url = $(this).attr('data-uri')

        formData = {

            type:(select_value ? select_value : 'n/a')
        }

        const specials = ajaxSubmit(url,formData,'',"GET");

        specials.done(function(data){

            if (data.success == 'true') {
                
                $('#specials').html(data.page).fadeIn(700);
                $('#appResult').empty();

            } else {

                $('#specials').html('loading..').fadeOut(850);
                $('#dateFields').fadeIn(1000);

            }
            

        });

    });