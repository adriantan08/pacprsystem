<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>PAC - Login</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>css/general.css"/>
	<script src="<?=base_url()?>js/jquery-2.1.3.min.js"></script>
	
</head>
<body style="font-family:Arial;">
	<div style="position:fixed; left:40%; top:20%">
		<div style="position:relative; right:20%;"><img style="position:relative; background-color:pink;" src="<?=base_url().'img/pac_logo.png'?>" width=50 /><font style="font-family:'Mistral'; font-size:30px; position:relative; top:-20px;">Palawan Aquacultre Corporation</font></div>
		<h2>Payment Record System</h2>
		<table>
			<tr>
				<td align=center colspan=2><div id="form_msg" style="color:red;"></div><br></td>
			</tr>
			<tr>
				<td>
					Username: 
				</td>
				<td>
					<input type=text id="username" placeholder="Enter your username"/>
				</td>
			</tr>
			<tr>
				<td>
					Password: 
				</td>
				<td>
					<input type=password id="password" placeholder="Enter your password"/>
				</td>
			</tr>
			<tr>
				<td align=center colspan=2><br><button id = "submit" class="flatbutton">Submit</button></td>
			</tr>
		</table>
	</div>

<script>
	//XSS protection
	function encodeHTML(s) {
		return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');
	}
	$('#submit').click(function(){
		var username = encodeHTML(document.getElementById('username').value);
		var password = encodeHTML(document.getElementById('password').value);
		
		if(username == '' || password == ''){
			document.getElementById('form_msg').innerHTML = "Please enter a username and/or password.";
		}
		else{
			$.ajax({
				url: "<?=base_url()?>login/processLogin",
				type:"POST",
				data:{
					u: username,
					p: password
				}
			})
			.done(function(data){
				if(data == 'success')
					window.location.href='<?=base_url()?>home';
				else
					document.getElementById('form_msg').innerHTML = data;
			});
		}
	});
	
</script>
</body>
</html>