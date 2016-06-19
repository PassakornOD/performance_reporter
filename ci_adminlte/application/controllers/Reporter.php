<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporter extends CI_Controller {
	
	public function __construct(){
		
		parent::__construct();
		$this->load->model('coreperformance','',TRUE);
		
	}
	
	public function index(){
		
		$res=$this->coreperformance->hgroup();
		$data['hgs']=$res;
		$hn_t=$this->coreperformance->hname($res);
		$data['hns']=$hn_t;
		//print_r($hn_t);
		$this->load->view('reporter/index', $data);
		//print_r($res);
		//print_r($res[9]);
		//print_r($res_result());
	}
	
	public function cpudaily(){
		
		$this->load->view('reporter/cpudaily');
	}
	
	public function cpumonthly(){
		
		$this->load->view('reporter/cpumonthly');
		
	}
	
	public function memdaily(){
		
		$this->load->view('reporter/memdaily');
		
	}
	
	public function memmonthly(){
		
		$this->load->view('reporter/memmonthly');
		
	}
	
	public function faq(){
		
		$this->load->view('reporter/faq');
		
	}
}

?>