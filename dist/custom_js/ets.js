let returnVal = false;

let ajaxHTML = function(url,element=null,func1=null,formData=null,method="GET"){
	
	let stateElement = $(element);

	let ajaxData = $.ajax({

		url: url,
		method: method,
		dataType: "html",
		data: formData,
		beforeSend:(func1 ? func1() : XHRbeforeSend(stateElement)),
		success:function(data){

			XHRSuccess(data,stateElement);
		},
		complete:function(data){

			XHRComplete(data,stateElement);
		},
		error:function(data){

			XHRError(data,stateElement);
		},

	});

	return ajaxData;

}

const ajaxSubmit = function(url,data=null,element=null,method="POST"){

	const stateElement = $(element);

	const ajaxData = $.ajax({

		url: url,
		method: method,
		data: data,
		dataType: "json",
		beforeSend:XHRbeforeSend(stateElement),
		success:function(data){

			XHRSuccess(data,stateElement);
		},
		complete:function(data){

			XHRComplete(data,stateElement);
		},
		error:function(data){

			XHRError(data,stateElement);
		},

	});

	return ajaxData;


}

function init_table(table_element,ssp=null,titleText="Employee Tracking System Reports",method="GET"){
	
	if (ssp) {
		
		let dataTable = $(table_element).DataTable({
			destroy:true,
			processing: true,
			serverSide: true,
			responsive: true,
			ajax: {
				url:ssp.url,
				type:method
			},		
			columnDefs:(ssp.columns.length > 1 ? ssp.columns : [ssp.columns]),			
			scrollY:'100vh',
			scrollX:true,
			scrollCollapse:true,
			initComplete:function(settings, data){
				let records = data.recordsTotal;

				if (records === 0) {
					
					$('.export_excel,.export_pdf').prop('disabled',true);
				}				
			}
		});
		
		return dataTable;
	} else {

		let dataTable = $(table_element).DataTable({

			responsive: true

		});		
	}

	

}

function messageBox(key,target,message){

	if (key == 'error') {

		setTimeout(function(){
			$(target).addClass('alert alert-danger').html(message).fadeIn(1000); 
		}, 500);
		setTimeout(function(){
			$(target).fadeOut(1000);
		}, 3000);

	} else {

		let closeButton = '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
		message_button = closeButton+message;
		setTimeout(function(){

			$(target).addClass('alert alert-info').html(message_button).fadeIn(1000);

		},500);
		setTimeout(function(){
			$(target).fadeOut(1000);
		}, 5000);		

	}
}

let defaultValue = function(value){

	let data = false;

	let array_checker = Array.isArray(value);

	if (array_checker) {

		let filtered = value.filter(function (el) {

		  return el != null;

		});

		data = filtered;
	}

	return data;
}


let listArray = function(listData){

	$.map(listData, function(el){ 

		returnVal = el.value

		return returnVal;

	});
	
}

function XHRbeforeSend(element=null){

	if(element){

		element.text('loading...');
		element.val('loading...');
		element.prop('disabled',true);		
	}
}

function XHRSuccess(xhr,element=null){

	if (element) {
		let buttonText = 'Submit';
		if (xhr.btn_val) {
			
			buttonText = xhr.btn_val;
		}
		element.text(buttonText);
		element.val(buttonText);		
	}
}

function XHRComplete(xhr,element=null){

    if (element) {
		
		element.prop('disabled',false); 
	}   
}

function XHRError(xhr,element=null){
	
	if (element) {
		
		console.log(xhr);
		$('#app').html('<h2 class="text-danger">Error Attained while making transaction, Please refresh the page and try again</h2>');		
	}
}
