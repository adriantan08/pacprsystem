<link rel="stylesheet" href="<?=base_url()?>css/bootstrap.min.css">
<link rel="stylesheet" href="<?=base_url()?>lib/jqueryupload/css/jquery.fileupload.css">

<style type="text/css">
	.supportingDocumentSection td{
		position:relative; left:5%;
	}
	.mylabel{
		font-weight:600;
	}
	.input-edit{
		border: 0;
		outline: 0;
		background: transparent;
		border-bottom: 1px solid #a9a9a9;
	}
	.input-read{
		border: 0;
		outline: 0;
		background: transparent;
	}
	input:focus{
		outline:none;
	}
	textarea{
		
	}
	
.myTable{
	background-color:white; 
	border-collapse: collapse; 
	width:100%;
}
.myTable tbody tr td{
	font:inherit;
	border-bottom: 0.1em solid #BDBDBD;
	padding:10px;
}

.myTable tr:last-child td{
	border-bottom:0;
}

#targetImg{
	max-width:600px;
	
}

</style>

<div style="position:relative; top:5%; left:3%;"><br>
<table>
<tr>
<td valign=top>
	<table>
	<tr>
	<td>
		<font style="font-size:18px;"><b>PR# <?=$prDetails['pr_id']?></b></font>
		<br>Last Modified: <?=$prDetails['changed_on']?><br><br>
	</td>
	<td>
	<?php
	if($prDetails['pr_status'] == SUBMITTED_STATUS || 
		$prDetails['pr_status'] == POSTED_STATUS ||
		$prDetails['pr_status'] == VERIFIED_STATUS
		){
		echo '<div style="position:relative; left:50px; font-size:17px;"><i><b>Pending review</b></i></div>';
	}
	else if($prDetails['pr_status'] == 40){
		echo '<div style="position:relative; left:50px; font-size:17px; color:green;"><b>Approved</b></div>';
	}
	else{
	?>
		<span>
			<button style="position:relative; left:10px;" class="flatbutton" id="editButton">Edit</button>
			<span id="finishEditDiv" style="visibility:hidden;">
			<button style="position:relative; left:20px; background-color:green;" class="flatbutton" id="draft" name="submitButton">Draft</button>
			<button style="position:relative; left:20px; background-color:green;" class="flatbutton" id="submit" name="submitButton">Submit for Approval</button>
			</span>
		</span>
		
	<?php	
		
	}
	?>
	</td>
	</tr>
	</table>
<table class="myTable" >
	<tr >
		<td colspan=2 align=right>
			<font class="mylabel">Date:</font>
			<input class="input-read" name="editable" type=text disabled id="prDate" value="<?=$prDetails['pr_date']?>" /> 
		</td>
	</tr>
	<tr>
		<td>
			<font class="mylabel">PR#: </font>
		</td>
		<td>
			<input type=number min="0" id="prNum" class="input-read" disabled value="<?=$prDetails['pr_id']?>" />
		</td>
	</tr>
	<tr>
		<td>
			<font class="mylabel">Payee: </font>
		</td>
		<td>
			<input type=text id="prPayee" name="editable" class="input-read" disabled value="<?=$prDetails['payee']?>"/>
			
		</td>
	</tr>
	<tr>
		<td>
			<font class="mylabel">Amount: </font>
		</td>
		<td>
			<div id="amountPlaceholderRead">P <?=number_format($prDetails['amount'], 2,'.',',')?></div>
			<div id="amountPlaceholderEdit" style="display:none;" >P <input type=number id="prAmount" min="0"  name="editable" class="input-read" disabled value="<?=$prDetails['amount']?>"/></div>
		</td>
	</tr>
	<tr>
		<td>
			<font class="mylabel">Form: </font>
		</td>
		<td>
			<span>
			<input type="radio" name="prForm" value="cash" disabled
			<?php if($prDetails['payment_form']=='cash') echo 'checked';?>/> Cash
			
			<input type="radio" name="prForm" value="check" disabled
			<?php if($prDetails['payment_form']=='check') echo 'checked';?>/> Check
			
			<input type="radio" name="prForm" value="none" disabled
			<?php if($prDetails['payment_form']=='none') echo 'checked';?>/> None
			</span>
		</td>
	</tr>
	<tr>
		<td>
			<font class="mylabel">Purpose: </font>
		</td>
		<td>
			<span>
			<input type="radio" name="prPurpose" value="disbursement" disabled
			<?php if($prDetails['purpose']=='disbursement') echo 'checked';?>/> Disbursement
			<input type="radio" name="prPurpose" value="liquidation" disabled
			<?php if($prDetails['purpose']=='liquidation') echo 'checked';?>/> Liquidation
			<input type="radio" name="prPurpose" value="recordonly" disabled
			<?php if($prDetails['purpose']=='recordonly') echo 'checked';?>/> Record Only
			</span>
		</td>
	</tr>
	<tr>
		<td>
			<font class="mylabel">Disb'mnt Class:</font>
		</td>
		<td>
			<span>
			<input type="radio" name="prDisbClass" value="spent" disabled
			<?php if($prDetails['dist_class']=='spent') echo 'checked';?>/> Spent
			<input type="radio" name="prDisbClass" value="unspent" disabled
			<?php if($prDetails['dist_class']=='unspent') echo 'checked';?>/> Unspent
			</span>
		</td>
	</tr>
	<tr>
		<td>
			<font class="mylabel">Disb'mnt Yield:</font>
		</td>
		<td>
			<span>
			<input type="radio" name="prDisbYield" value="consumable" disabled
			<?php if($prDetails['dist_yield']=='consumable') echo 'checked';?>/> Consumable
			<input type="radio" name="prDisbYield" value="asset" disabled
			<?php if($prDetails['dist_yield']=='asset') echo 'checked';?>/> Asset
			</span>
		</td>
	</tr>
	<tr><td colspan=2><b>Supporting Documents</b></td></tr>
	
	<tr>
		<td>
			<font class="mylabel">P.O./J.O. No.: </font>
		</td>
		<td>
			<input type=text id="prPoJoNo" name="editable" class="input-read" disabled value ="<?=$prDetails['po_jo_no']?>"/>
			
		</td>
	</tr>
	<tr>
		<td>
			<font class="mylabel">Receiving Report No.: </font>
		</td>
		<td>
			<input type=text id="prRcvReportNo" name="editable" class="input-read" disabled value="<?=$prDetails['rr_no']?>"/>
			
		</td>
	</tr>
	<tr class="supportingDocumentSection">
		<td>
			<font class="mylabel">Invoice No.:</font>
		</td>
		<td>
			<span>
				<input type=text id="prInvoiceNo" name="editable" class="input-read" disabled value="<?=$prDetails['inv_no']?>"/>
				
				<!--&nbsp&nbsp WFR No.
				<input type=text id="prWfrNo"/>-->
			</span>
		</td>
	</tr>
	<tr class="supportingDocumentSection">
		<td>
			<font class="mylabel">Others (min. 25 chars)::</font>
		</td>
		<td>
			<input type=text id="prOthers" name="editable" class="input-read" disabled value="<?=$prDetails['others']?>"/>
		</td>
	</tr>
	<tr>
		<td valign=top>
			<font class="mylabel">Details:</font>
		</td>
		<td>
			<textarea disabled style="text-align:left;" id="prDetails" rows=10 cols=40><?=str_replace('<br/>','&#10;',$prDetails['details'])?></textarea>
		</td>
	</tr>
	

</table>
</td>
<td valign=top style="position:relative; left:10%;">
	
	<span id="image_div">
	<h2>Upload Receipts</h2>
	
    <!-- The fileinput-button span is used to style the file input field as button -->
    <span class="btn btn-success fileinput-button" id="selectUploadButton" style="visibility:hidden;">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Select file</span>
		
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
	<div id="uploadDiv"></div>
    <br>
    <br>
    <!-- The global progress bar -->
    <div id="progress" class="progress" style="width:300px;"> 
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files">
	<div id="targetImg"></div>
	
	<div id="existingImagesDiv">
	<?php
		if($prDetails['receipt_img'] !== 'none'){
			/*if there's at least one image, exploding will always result into an array i.e. IMG1||IMG2||
			
			we just have to always check if current array value is no blank
			*/
			
			$imgArr = explode("||", $prDetails['receipt_img']);
			//for goodness sake, we still want to catch if it's array
			if(is_array($imgArr)){
				for($i=0; $i<count($imgArr); $i++){
					if($imgArr[$i] !== ""){
						$imgDomId = "image-".$i;
						$buttonDomId = "removebutton-".$i;
						echo '<a href="'.IMG_DIR.$imgArr[$i].'" target="_blank"><img name="existingImages" id="'.$imgDomId.'" width=300px src = "'.IMG_DIR.$imgArr[$i].'" data-filename="'.$imgArr[$i].'"/></a><br/><br/>';
						
						echo '<button class="flatbutton" style="background-color:red; visibility:hidden;" name="removeImageButtons" id = "'.$buttonDomId.'" onclick="removeExistingImage('."'".$imgDomId."'".','."'".$buttonDomId."'".');"> Remove</button><br/><br/>';
					}
				}
			}
			
		}
	?>
	</div>
	</div>
	<div id="result"></div>
    <br>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Information</h3>
        </div>
        <div class="panel-body">
            <ul>
               <li>Maximum upload limit of <strong>2MB.</strong></li>
			   <li>Supported image formats: jpg, png, gif</li>
			   
            </ul>
        </div>
    </div>
	
</span>
</td>
<td valign=top style="border-left:1px; position:relative; left:20%;">
	<?php
		echo $this->load->view('comments_view', null, true);
	?>
</td>
</tr></table>

</div><br/><br/>
<input type=hidden id="imagefile" value="none"/>
<script src="<?=base_url()?>js/create_pr.js"></script>
<script src="<?=base_url()?>js/form_validator.js"></script>

<!------JQUERY UPLOAD IMPORT-------
*
*
-->
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?=base_url()?>lib/jqueryupload/js/vendor/jquery.ui.widget.js"></script>

<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?=base_url()?>lib/jqueryupload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?=base_url()?>lib/jqueryupload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?=base_url()?>lib/jqueryupload/js/jquery.fileupload-process.js"></script>
<script src="<?=base_url()?>lib/jqueryupload/js/jquery.fileupload-validate.js"></script>
<!------JQUERY UPLOAD IMPORT--------->


<script>
/*********************************************************************************************************
		THE HANDLER FOR JQUERY UPLOAD
**********************************************************************************************************/
/*jslint unparam: true */
/*global window, $ */
var uploadDataHandler = [];
var imageCtr = 0;
$(function () {
    'use strict';
    var url ='<?=base_url()?>api/uploadreceipt';
    $('#fileupload').fileupload({
        url: url,
        dataType:'json',
		method:'POST',
		
		maxFileSize: 2000000, // 2 MB
		
		add: function (e, data) {
			var fileType = data.files[0].name.split('.').pop().toLowerCase(), allowdtypes = 'jpeg,jpg,png,gif';
			
			var fileSize = data.files[0].size;
			if (allowdtypes.indexOf(fileType) < 0) {
				swal("Unsupported data format",'Processing ' + data.files[0].name + ' failed.',"error");
				return false;
			}
			if(fileSize > 2000000){
				swal("File is too big.",'Processing ' + data.files[0].name + ' failed.',"error");
				return false;
			}
			
			
				//Assume that an iteration will occure here in case user adds multiple files in one attempt
				var elemImg = document.createElement('img');
				var elemButton = document.createElement('button');
				
				elemImg.id = 'image-'+imageCtr;
				elemImg.style.width = '300px';
				
				$('#targetImg').append(elemImg);
				
				$('#targetImg').append(document.createElement('br'));
				$('#targetImg').append(document.createElement('br'));
				
				elemButton.id = 'imageRemoveId-'+imageCtr;
				elemButton.name = 'imageRemoveButton';
				elemButton.addEventListener("click", function(){removeImage(elemImg.id, elemButton.id);});
				elemButton.className = 'flatbutton';
				
				elemButton.innerHTML = 'Remove';
				elemButton.style.backgroundColor="red";
				$('#targetImg').append(elemButton);
				$('#targetImg').append(document.createElement('br'));
				$('#targetImg').append(document.createElement('br'));
				
				//Wait until read object finishes getting img from local, then use it as src attribute of the recently created img
				var reader = new FileReader();
				reader.onload = function(e) {
					elemImg.src = e.target.result;
				}
				reader.readAsDataURL(data.files[0]);
				/*passed data to global var uploadDataHandler so we can call data.submit() later on when drafting / submitting
					also included the prNum value as additional form data before passing to uploadDataHandler
				*/
				
				uploadDataHandler[imageCtr] = data;
				
				imageCtr++;
		},
		done: function (e, data) {
			var r = data.result["serverResponse"];
			if(r.indexOf("support") != -1)
				swal("Data Upload Failed!",r,"error");
			//else
			//	swal("Data Upload Completed!",r,"success");
        },
		progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
			
        },
		processfail:function(e, data){
			var file = data.files[data.index];
			//file.error here displays the particular error code/response
			swal(file.error,'Processing ' + data.files[data.index].name + ' failed.', 'error');
			
		},
		processdone:function(e, data){
			
		}
	
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
/*********************************************************************************************************
		THE HANDLER FOR JQUERY UPLOAD
**********************************************************************************************************/
</script>

<script>
	$( "#prDate").datepicker("setDate", new Date());
	
	//Once edit has been clicked, we make the fields editable
	$("#editButton").click(function(){
		var nodes = document.getElementsByName("editable");
		
		for(var i=0; i<nodes.length; i++){
			/*	a WORKAROUND to enable support for comma's in amount. 1 div to show text, and 1 div to show 
				input element with number format already
			*/
			if(nodes[i].id =='prAmount'){
				document.getElementById('amountPlaceholderRead').style.display = 'none';
				document.getElementById('amountPlaceholderEdit').style.display = 'block';
			}
			nodes[i].className = "input-edit";
			nodes[i].disabled = false;
		}
		var nodes = document.getElementsByName("prForm");
		for(var i=0; i < nodes.length; i++)
			nodes[i].disabled=false;
		
		var nodes = document.getElementsByName("prPurpose");
		for(var i=0; i < nodes.length; i++)
			nodes[i].disabled=false;
		
		var nodes = document.getElementsByName("prDisbClass");
		for(var i=0; i < nodes.length; i++)
			nodes[i].disabled=false;
		
		var nodes = document.getElementsByName("prDisbYield");
		for(var i=0; i < nodes.length; i++)
			nodes[i].disabled=false;
		
		document.getElementById('prDetails').disabled = false;
		document.getElementById('finishEditDiv').style.visibility = 'visible';
		document.getElementById('selectUploadButton').style.visibility = 'visible';
		
		//this will reveal all removeImageButtons if there's any images initially uploaded
		if(document.getElementsByName("removeImageButtons") !== 'undefined')
			var nodes = document.getElementsByName("removeImageButtons");
			for(var i=0; i < nodes.length; i++)
				nodes[i].style.visibility="visible";
		
		//swal("You may now start editing!","","info");
	});
	
	
	
	$("button[name='submitButton']").click(function(){
		var action = null;
		
		//lock the button while validation is running to prevent re-enrty.
		$(this).prop('disabled', true);
		if($(this).attr('id') == 'draft')
			action = <?=DRAFT_STATUS?>;
		else if($(this).attr('id') == 'submit')
			action = <?=SUBMITTED_STATUS?>;
			
		var check = runValidation();
		
		//this should be check. we just bypassed. revert when moving to prod
		if(check){
			var imgStrings = "";
			var allUploadsSuccess = true;
			var imgCtr = 0;
			
			//Reset the value of DOM (id = imagefile) placeholder
			document.getElementById('imagefile').value = "none";
			
			//this loop is responsible to submit() all uploadHandlers to upload all images to the server
			for(var key in uploadDataHandler){
				
				//temporary set ajax calls to async to allow us to wait until all uploads finish before initiating publishing. We have to wait for upload to finish since we will need the final value of placeholder input (imagefile) DOM to get uploaded image and associate to the PR.
				$.ajaxSetup({ async: false });
				if(uploadDataHandler.hasOwnProperty(key)){
					var uploadObject = uploadDataHandler[key]; 
					
					//always get prNum in case changes the prNum
					uploadObject.formData= {
						prNum : document.getElementById('prNum').value,
						imgNum : imgCtr
					};
					imgCtr++;
					uploadObject.submit().done(function(e){
						var response = e;
						
						if(response['serverResponse'] == 'success'){
							//foreach success upload, we append (double piped) the image name generated in the hidden input field use as placeholder.
							
							if(document.getElementById('imagefile').value == "none")
								document.getElementById('imagefile').value = response['image']+"||";
							else
								document.getElementById('imagefile').value += response['image']+"||";
							
						}
						else{
							allUploadsSuccess = false;
						}
					});
					
				}
			}
			/*FINALLY, we also have to get the existing images previously uploaded!*/
			if(document.getElementById('imagefile').value == "none")
				document.getElementById('imagefile').value = getExistingImages();
			else
				document.getElementById('imagefile').value += getExistingImages();
			
			if(allUploadsSuccess){
				publishPr("<?=base_url()?>", action,'update');
				
			}
			else{
				swal("Something went wrong during upload","","error");
			}
			
		}
		else{
			//revert clicked button back to enabled to allow another revision
			$(this).prop('disabled', false);
			swal("Validation failed.","Please review your entry.","error");
		}
	});
	
	//this function removes the image and the button that goes with it.
	//This is purely used for existing images since we are just manipulating/fixing the DOMs
	function removeExistingImage(imgId, buttonId){
		
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
	}
	
	
	
	//this function gets all existing images retained by the user so it gets included in the update. 
	function getExistingImages(){
		var imagesString = "";
		
		if(document.getElementsByName("existingImages") !== 'undefined')
			var nodes = document.getElementsByName("existingImages");
			for(var i=0; i < nodes.length; i++)
				imagesString += nodes[i].getAttribute('data-filename')+"||";
	
		return imagesString;
	}
	
	
	$("#prPayee").autocomplete({
		source: JSON.parse('<?=$this->Crud_model->getDistinctPayees()?>'),
		//source: [{label:"Label1", value:"Value1"}],
		minLength: 0,
		position: {
			my : "right top",
			at: "right bottom"
		},
		//action here to dictate where to go once an entry has been selected
		select: function(event, ui) {
			
		},
		
	});
	
</script>