<link rel="stylesheet" href="<?=base_url()?>css/bootstrap.min.css">
<link rel="stylesheet" href="<?=base_url()?>lib/jqueryupload/css/jquery.fileupload.css">

<style type="text/css">
.form-style-1 {
    margin:10px auto;
    max-width: 400px;
    padding: 10px 12px 10px 20px;
    font: 12px "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
.form-style-1 li {
    padding: 0;
    display: block;
    list-style: none;
    margin: 10px 0 0 0;
}
.form-style-1 label{
    margin:0 0 3px 0;
    padding:0px;
    display:block;
    font-weight: bold;
}
.form-style-1 input[type=text],
.form-style-1 input[type=date],
.form-style-1 input[type=datetime],
.form-style-1 input[type=number],
.form-style-1 input[type=search],
.form-style-1 input[type=time],
.form-style-1 input[type=url],
.form-style-1 input[type=email],
textarea,
select{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    border:1px solid #BEBEBE;
    padding: 7px;
    margin:0px;
    -webkit-transition: all 0.30s ease-in-out;
    -moz-transition: all 0.30s ease-in-out;
    -ms-transition: all 0.30s ease-in-out;
    -o-transition: all 0.30s ease-in-out;
    outline: none;
}
.form-style-1 input[type=text]:focus,
.form-style-1 input[type=date]:focus,
.form-style-1 input[type=datetime]:focus,
.form-style-1 input[type=number]:focus,
.form-style-1 input[type=search]:focus,
.form-style-1 input[type=time]:focus,
.form-style-1 input[type=url]:focus,
.form-style-1 input[type=email]:focus,
.form-style-1 textarea:focus,
.form-style-1 select:focus{
    -moz-box-shadow: 0 0 8px #88D5E9;
    -webkit-box-shadow: 0 0 8px #88D5E9;
    box-shadow: 0 0 8px #88D5E9;
    border: 1px solid #88D5E9;
}
.form-style-1 .field-divided{
    width: 49%;
}

.form-style-1 .field-long{
    width: 100%;
		height: 80%;
}
.form-style-1 .field-select{
    width: 100%;
}
.form-style-1 .field-textarea{
    height: 100px;
}
.form-style-1 input[type=submit], .form-style-1 input[type=button]{
    background: #4B99AD;
    padding: 8px 15px 8px 15px;
    border: none;
    color: #fff;
}
.form-style-1 input[type=submit]:hover, .form-style-1 input[type=button]:hover{
    background: #4691A4;
    box-shadow:none;
    -moz-box-shadow:none;
    -webkit-box-shadow:none;
}
.form-style-1 .required{
    color:red;
}

#targetImg{
	max-width:600px;
	
}
</style>

<!--<<<<<<< HEAD
<div style="position:relative; top:5%; left:5%; width:40%;">
<h3>Create a Payment Record</h3>
<table  style="width:100%;" cellspacing=20px >
	<tr >
		<td colspan=2 align=right>
			<font class="label">Date:</font> <input type=text id="prDate"/>
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">PR#: </font>
		</td>
		<td>
			<input type=number id="prNum" min="0"/>
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Payee: </font>
		</td>
		<td>
			<input type=text id="prPayee"/>
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Amount: </font>
		</td>
		<td>
			P<input type=number id="prAmount" min="0"/>
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Form: </font>
		</td>
		<td>
			<span>
			<input type="radio" name="prForm" value="cash"/> Cash
			<input type="radio" name="prForm" value="check"/> Check
			<input type="radio" name="prForm" value="none"/> None
			</span>
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Purpose: </font>
		</td>
		<td>
			<span>
			<input type="radio" name="prPurpose" value="disbursement"/> Disbursement
			<input type="radio" name="prPurpose" value="liquidation"/> Liquidation
			<input type="radio" name="prPurpose" value="recordonly"/> Record Only
			</span>
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Disb'mnt Class:</font>
		</td>
		<td>
			<span>
			<input type="radio" name="prDisbClass" value="spent"/> Spent
			<input type="radio" name="prDisbClass" value="unspent"/> Unspent
			</span>
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Disb'mnt Yield:</font>
		</td>
		<td>
			<span>
			<input type="radio" name="prDisbYield" value="consumable"/> Consumable
			<input type="radio" name="prDisbYield" value="asset"/> Asset
			</span>
		</td>
	</tr>
	<tr><td colspan=2><b>Supporting Documents:</b></td></tr>
	
	<tr class="supportingDocumentSection">
		<td>
			<font class="label">P.O./J.O. No.:</font>
		</td>
		<td>
			<input type=text id="prPoJoNo"/>
		</td>
	</tr>
	<tr class="supportingDocumentSection">
		<td>
			<font class="label">Receiving Report No.:</font>
		</td>
		<td>
			<input type=text id="prRcvReportNo"/>
		</td>
	</tr>
	<tr class="supportingDocumentSection">
		<td>
			<font class="label">Invoice No.:</font>
		</td>
		<td>
			<span>
				<input type=text id="prInvoiceNo"/>
				
			</span>
		</td>
	</tr>
	<tr class="supportingDocumentSection">
		<td>
			<font class="label">Others:</font>
		</td>
		<td>
			<input type=text id="prOthers"/>
		</td>
	</tr>
	<tr>
		<td valign=top>
			<font class="label">Details:</font>
		</td>
		<td>
			<textarea id="prDetails" rows=10 cols=40></textarea>
		</td>
	</tr>
	
	<tr>
		<td colspan=2 align=center>
			<button style="background-color:green" class="flatbutton" name="submitButton" id="draft">Draft</button>
			<button style="background-color:green" class="flatbutton" name="submitButton" id="submit">Submit for Approval</button>
			<button style="width:100px;" class="flatbutton" id="cancel">Cancel</button>
		</td>
	</tr>
</table>
</div><br/><br/>
=======-->
<table style="position:relative; left:10%;" >
<tr>
<td style="position:relative; left:0%;">
	<div style="min-width:600px;">
	<ul class="form-style-1">
		<li><label>PR Date <span class="required">*</span></label>
		<input type="text" id="prDate" name="field1" class="field-divided"/>
		</li>
		<li>
			<label>PR # <span class="required">*</span></label>
			<input type="number" id="prNum" name="field2" class="field-long" />
		</li>
		<li>
			<label>Payee <span class="required">*</span></label>
			<input type="text" id="prPayee" name="field3" class="field-long" />
		</li>
		<li>
			<label>Amount (Php) <span class="required">*</span></label>
			<input type="number" id="prAmount" name="field4" class="field-long" />
		</li>
		<li>
			<label>Form: <span class="required">*</span></label>
			<span>
				<input type="radio" name="prForm" value="cash"/> Cash
				<input type="radio" name="prForm" value="check"/> Check
				<input type="radio" name="prForm" value="none"/> None
				</span>
		</li>
		<li>
			<label>Purpose: <span class="required">*</span></label>
			<span>
				<input type="radio" name="prPurpose" value="disbursement"/> Disbursement
				<input type="radio" name="prPurpose" value="liquidation"/> Liquidation
				<input type="radio" name="prPurpose" value="recordonly"/> Record Only
				</span>
		</li>
		<li>
			<label>Disbursement Class: <span class="required">*</span></label>
			<span>
				<input type="radio" name="prDisbClass" value="spent"/> Spent
				<input type="radio" name="prDisbClass" value="unspent"/> Unspent
				</span>
		</li>
		<li>
			<label>Disbursement Yield: <span class="required">*</span></label>
			<span>
				<input type="radio" name="prDisbYield" value="consumable"/> Consumable
				<input type="radio" name="prDisbYield" value="asset"/> Asset
				</span>
		</li>
		<li>
			<label>Supporting Documents: </label>
		</li>
		<li>
			<label>PO/JO No.: </label>
			<input type=text id="prPoJoNo"/>
		</li>
		<li>
			<label>Receiving Report No.: </label>
			<input type=text id="prRcvReportNo"/>
		</li>
		<li>
			<label>Invoice No.: </label>
			<input type=text id="prInvoiceNo"/>
		</li>
		<li>
			<label>Others: </label>
			<input type=text id="prOthers"/>
		</li>
		<li>
			<label>Details: </label>
			<textarea id="prDetails" rows=10 cols=40 class="field-textarea"></textarea>
		</li>
		<li>
		
		<button style="background-color:green" class="flatbutton" name="submitButton" id="draft">Draft</button>
		<button style="background-color:green" class="flatbutton" name="submitButton" id="submit">Submit for Approval</button>
		
		<button style="width:100px;" class="flatbutton" id="cancel">Cancel</button>
		</li>
	</ul>
	</div>
</td>
<td valign=top> 
<span id="image_div">
	<h2>Upload Receipts</h2>
	
    <!-- The fileinput-button span is used to style the file input field as button -->
    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Select file</span>
		
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span><br><br>
	<div id="uploadDiv"></div>
    <br>
    <br>
    <!-- The global progress bar -->
    <div id="progress" class="progress" style="width:300px;"> 
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"><div id="targetImg"></div></div>
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
</tr>
</table>

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
/*jslint unparam: true */
/*global window, $ */
//Declaring this as objects, to support multiple image upload
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
</script>

<script>

	$( "#prDate").datepicker("setDate", new Date());
	$( "#prDate").datepicker({ dateFormat: 'yy/mm/dd'});

	$("button[name='submitButton']").click(function(){
		var action = null;
		if($(this).attr('id') == 'draft')
			action = <?=DRAFT_STATUS?>;
		else if($(this).attr('id') == 'submit')
			action = <?=SUBMITTED_STATUS?>;
			
		var check = runValidation();
		
		//this should be !check. we just bypassed. revert when moving to prod
		if(!check){
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
			if(allUploadsSuccess){
				publishPr("<?=base_url()?>", action,'create');
				
			}
			else{
				swal("Something went wrong during upload","","error");
			}
			
		}
		
	});
	
	
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
	
	$("#prPayee").autocomplete({
		source: JSON.parse('<?=$this->crud_model->getDistinctPayees()?>'),
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
