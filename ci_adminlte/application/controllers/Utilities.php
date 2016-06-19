<?php

class Utilities extends CI_controller{
	
	public function __construct(){
		
		parent::__construct();
		
	}
	
	public function index(){
		
		$this->load->view('utility/cpu_utilization');
		
	}
	
	public function cpu(){
		
		$this->load->view('utility/cpu_utilization');
		
	}
	
	public function memory(){
		
		$this->load->view('utility/mem_utilization');
		
	}
}

?>