<?php

class Reporter extends CI_controller {
	
	public function __contruct(){
		
		parent::__contruct();
		
	}
	
	public function index(){
		
		$this->load->view('reporter/header');
		$this->load->view('reporter/index');
		$this->load->view('reporter/footer');
		
	}
	
}

?>