<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login extends CI_Controller {
 
 function __construct()
 {
	parent::__construct();
//	$this->load->model('user','',TRUE);
 }
 
 function index()
 {
//	  $result = $this->user->login('54011388','Test1234');
//	  print_r($result);
   $this->load->helper(array('form'));
   $this->load->view('auth/login');
   

 }
 
}
 
?>