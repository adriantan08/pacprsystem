<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>css/general.css"/>
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>css/jquery-ui.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>css/jquery-ui.theme.min.css"/>
	
	<script src="<?=base_url()?>js/jquery-2.1.3.min.js"></script>
	<script src="<?=base_url()?>js/jquery-ui.min.js"></script>
	
	<!--Sweet Alert Import-->
	
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>lib/sweetalert/lib/sweet-alert.css">
	<script src="<?= base_url()?>lib/sweetalert/lib/sweet-alert.min.js"></script> 
	
	<title><?= $title?></title>

	
</head>
<body>


	<div id = "navigation" style="background: #33b5e5; position:absolute; top:0px; width:80%; left:0px;"> 
		<ul id="trans-nav">
			<li><?php echo anchor('/home', 'Home');?></li>
			<li><?php echo anchor('/create', 'Create');?></li>
		</ul>
	
		
	</div>
	
	<div style="background: #33b5e5; width:20%; position:absolute; top:0; right:0px;">
		<ul id="trans-nav">
			<li><a href="#">Welcome, Working Fund Custodian!
				<ul>
					<li><a href="#">Manage Account</a></li>
					<li><?php echo anchor('/home/logout', 'Logout');?></li>
				</ul>
			</li>
		</ul>
	</div>
<br/><br/><br/>
<table style="height:100%;">
<tr>
	<td valign=top style="white-space:nowrap;">
		<div id="left">
			<h3>Payment Request System</h3>
			<hr class="carved"/>
				<div>
					Goods purchase - 6/12/2016<br/><br/>
					<a href="<?=base_url()?>index.php/view/1wdwedewd">View</a>
				</div>
				<hr class="carved"/>
				<div>
					Laptops - 6/13/2016<br/><br/>
					<a href="<?=base_url()?>index.php/home/view_adminsechead/weded">View</a>
				</div>
		</div>
	</td>
	
	<td valign=top>
		<?= $content?>
	</td>
</tr>
</body>
</html>