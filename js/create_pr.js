function publishPr(base_url){
	
	var prNum = sanitize(document.getElementById('prNum').value);
	var prDate = sanitize(document.getElementById('prDate').value);
	var prPayee = sanitize(document.getElementById('prPayee').value);
	var prAmount = sanitize(document.getElementById('prAmount').value);
	var prForm = sanitize($('input[name="prForm"]:checked').val());
	var prPurpose = sanitize($('input[name="prPurpose"]:checked').val());
	var prDisbClass = sanitize($('input[name="prDisbClass"]:checked').val());
	var prDisbYield = sanitize($('input[name="prDisbYield"]:checked').val());
	var prPoJoNo = sanitize(document.getElementById('prPoJoNo').value);
	var prRcvReportNo = sanitize(document.getElementById('prRcvReportNo').value);
	var prInvoiceNo = sanitize(document.getElementById('prInvoiceNo').value);
	var prOthers = sanitize(document.getElementById('prOthers').value);
	var prDetails = sanitize(document.getElementById('prDetails').value);
	
	
	//convert new line of Details text area to what HTML can understand
	prDetails = prDetails.replace(/\r?\n/g, '<br/>');
	
	var mainArr = [];
	mainArr.push({
			prDate:prDate,
			prNum:prNum,
			prPayee:prPayee,
			prAmount:prAmount,
			prForm:prForm,
			prPurpose:prPurpose,
			prDisbClass:prDisbClass,
			prDisbYield:prDisbYield,
			prPoJoNo:prPoJoNo,
			prRcvReportNo:prRcvReportNo,
			prInvoiceNo:prInvoiceNo,
			prOthers:prOthers,
			prDetails:prDetails
			
	});
	
	$.ajax({
		url:base_url+"api/create",
		method:"POST",
		async: true,
		data:{
			postData:JSON.stringify(mainArr)
		},
		success: function(data){}
	})
	.done(function(data){
		swal("Success!","","success");
	});
}