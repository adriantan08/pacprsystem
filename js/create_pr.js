function publishPr(base_url, action, intent){
	
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
	var prExpCode = sanitize(document.getElementById('truePrCode').value);
	var prDetails = sanitize(document.getElementById('prDetails').value);
	var prReceiptImg = document.getElementById('imagefile').value;
	
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
			prExpCode:prExpCode,
			prDetails:prDetails,
			prStatus:action,
			prReceiptImg: prReceiptImg
	});
	
	$.ajax({
		url:base_url+"api/create/"+intent,
		method:"POST",
		async: true,
		data:{
			postData:JSON.stringify(mainArr)
		},
		success: function(data){}
	})
	.done(function(data){
		
		
		if(intent == 'create')
			var msg = 'You have successfully created a record.';
		else if(intent == 'update')
			var msg = 'You have updated your record.';
		swal({   
			title: "Success!",   
			text: msg,   
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

function removeImage(imgId, buttonId){
		
		//temporarily changed prototype to cater to removing element by id from parent's child nodes
		Element.prototype.remove = function() {
			this.parentElement.removeChild(this);
		}
		NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
			for(var i = this.length - 1; i >= 0; i--) {
				if(this[i] && this[i].parentElement) {
					this[i].parentElement.removeChild(this[i]);
				}
			}
		}
		
		document.getElementById(imgId).remove();
		document.getElementById(buttonId).remove();
		var id = imgId.split('-')[1];
		if(typeof uploadDataHandler[id] !== 'undefined')
			uploadDataHandler.splice(id,1);
		
		
	}
