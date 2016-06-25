
/*
	Handles approving of PR;
		1. base_url - used as reference for redirect later since this is a .js fileCreatedDate
		2. approvalType - Admin Sec Head, Validator, etc
		3. status - flag for For Review or Approve
		4. prNum - prNum.
*/
function approvePr(base_url, approvalType, status,prNum){
	
	$.ajax({
		url:base_url+"api/approve",
		method:"POST",
		async: true,
		data:{
			approvalType:approvalType,
			prNum:prNum,
			status:status
		},
		success: function(data){}
	})
	.done(function(data){
		swal({   
			title: "Action done!",   
			text: '',   
			type: "success",  
			showCancelButton: false,   
			confirmButtonColor: "#33b5e5",   
			confirmButtonText: "Return to Home",   
			closeOnConfirm: false }, 
			function(){
				window.location.href=base_url+'home';
			});
	});
}