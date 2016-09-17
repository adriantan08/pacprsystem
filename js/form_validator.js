/*
*	Main function to clean input strings!
*/
function sanitize(str){
	var s = str;
    s = String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');

	return s;
}

//I need to implement hit validation to ensure we still run validation check for all
//Basic Info tab fields, and prevent any unwanted checking that messes up bool variable.
//For all data validation, we need to only have 1 variable that causes hit to be true so at the end of
//validation, we refer to this to know if there was once field that's causing validation to fail

//Used for input fields
var errStyleInput = "1px solid red";
var revertStyleInput="1px solid #a9a9a9";


//Used for radio button
var errStyleRadio = "1px solid red";
var revertStyleRadio = "0px";

var hit = false;
function runValidation(){
	var bool = false;
	
	bool = validateIsElementEmpty("prDate");
	bool = validateIsElementEmpty("prNum");
	bool = validateIsElementEmpty("prPayee");
	bool = validateIsElementEmpty("prAmount");
	
	bool = validateRadio("prForm");
	bool = validateRadio("prPurpose");
	bool = validateRadio("prDisbClass");
	bool = validateRadio("prDisbYield");
	
	//9-17-2016 Removing validation as requested.
	//bool = validateIsElementEmpty("prPoJoNo");
	//bool = validateIsElementEmpty("prRcvReportNo");
	//bool = validateIsElementEmpty("prInvoiceNo");
	bool = validateIsElementEmpty("prOthers");
	bool = validateIsElementEmpty("prDetails");
	
	bool = validateMinCharTextfield(25, "prOthers");
	
	if(!bool){
		hit = true;
	}
	
	if(!hit){
		return true;
	}
	else{
		hit = false; //revert hit value for next iteration
		return false;
	}
	
/*************************************************************************************************************************/	
	
}


function revertElementStyle(id){
	document.getElementById(id).style.borderBottom=revertStyleInput;
}

function validateIsElementEmpty(id){
	
	var val = document.getElementById(id).value;
	if(val == ""){
		document.getElementById(id).style.borderBottom=errStyleInput;
		hit = true;
		return false;
	}
	else{
		document.getElementById(id).style.borderBottom=revertStyleInput;
	}
	
	return true;
}

function validateMinCharTextfield(charCount, id){
	
	var val = document.getElementById(id).value;
	
	if(val.length < charCount){
		document.getElementById(id).style.borderBottom=errStyleInput;
		hit = true;
		return false;
	}
	else{
		document.getElementById(id).style.borderBottom=revertStyleInput;
	}
	
	return true;
}

function revertRadioStyle(name){
	var nodes = document.getElementsByName(name);
	for(var i=0; i<nodes.length; i++)
			nodes[i].style.outlineS=revertStyleRadio;
}

function validateRadio(name){
	var nodes = document.getElementsByName(name);
	if($('input[name="'+name+'"]:checked').size()<=0){
		for(var i=0; i<nodes.length; i++)
			nodes[i].style.outline=errStyleRadio;
		hit = true;
		return false;
	}
	else{
		for(var i=0; i<nodes.length; i++)
			nodes[i].style.outline=revertStyleRadio;
	}
	
	return true;
}

function isAlphaOrParen(str) {
  return /^[a-zA-Z()]+$/.test(str);
}
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}


function isNumeric(num){
    return !isNaN(num)
}

function validateAntedate(startDate, endDate){
	var d1 = document.getElementById(startDate).value;
	var d2 = document.getElementById(endDate).value;
	
	//check if field values are 00000
	if(d1 == '0000-00-00' || d2 == '0000-00-00'){
		document.getElementById(startDate).style.border=errStyle;
		document.getElementById(endDate).style.border=errStyle;
		return false;
	}
		
	if(Date.parse(d1) > Date.parse(d2)){
		document.getElementById(startDate).style.border=errStyle;
		document.getElementById(endDate).style.border=errStyle;
		
		return false;
		
	}
	
	return true;
}


function validateDateTime(myDate){
	var d = document.getElementById(myDate).value;
	if(Date.parse(d)){
		return true;
	}
	else{ 
		//alert("Incorrect DateTime: "+d);
		return false;
	}
}


/*
	7-31-2015 A custom get unique values in array that will return all unique values in array format
*/
Array.prototype.getUnique = function(){
			   var u = {}, a = [];
			   for(var i = 0, l = this.length; i < l; ++i){
				  if(u.hasOwnProperty(this[i])) {
					 continue;
				  }
				  a.push(this[i]);
				  u[this[i]] = 1;
			   }
			   return a;
			}
Array.max = function( array ){
    return Math.max.apply( Math, array );
};


