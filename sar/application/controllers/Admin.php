<?php
	class Admin extends CI_Controller 
	{
		public function __contruct(){
			parent:__contruct();
		}
		
		public function index(){
			$this->load->view('admin/index');
		}
	}


?>