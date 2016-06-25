<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {

	 public function __construct(){
		parent::__construct();
		
	 }
	 
	 
	 function index(){
		echo 'LOGIN PAGE';
	 }
	 
	function unauth(){
		echo '401: Unauthorized';
	}
	
}
