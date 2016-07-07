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
	<script src="<?=base_url()?>lib/DataTables/media/js/jquery.dataTables.min.js"></script>
	<script src="<?=base_url()?>lib/tab-content/tabcontent.js"></script>

	<!--Sweet Alert Import-->

	<link rel="stylesheet" type="text/css" href="<?= base_url()?>lib/sweetalert/lib/sweet-alert.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>lib/tab-content/template1/tabcontent.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>lib/DataTables/media/css/jquery.dataTables.min.css">
	<script src="<?= base_url()?>lib/sweetalert/lib/sweet-alert.min.js"></script>


	<title><?= $title?></title>


</head>
<body>


	<div id = "navigation" style="background: #33b5e5; position:absolute; top:0px; width:90%; left:0px;">
		<ul id="trans-nav">
			<li><?php echo anchor('/home', 'Home');?></li>
			<li><?php echo anchor('/create', 'Create');?></li>
		</ul>


	</div>

	<div style="background: #33b5e5; width:10%; position:absolute; top:0; right:0px;">
		<ul id="trans-nav">
			<li><a href="#">My Account
				<ul>
					<li><a href="#">Manage Account</a></li>
					<li><?php echo anchor('/home/logout', 'Logout');?></li>
				</ul>
			</li>
		</ul>
	</div>
<br/><br/><br/>
<div>
<h3 id="myH3">Welcome <?=$this->session->userdata('empFirstName').' '.$this->session->userdata('empLastName').'('.strtoupper($this->session->userdata('userRole')).')'?></h3><hr class="carved"/>
		<?= $content?>
</div>
</body>
</html>
