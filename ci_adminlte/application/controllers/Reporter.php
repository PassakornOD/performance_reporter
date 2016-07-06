<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporter extends CI_Controller {
	
	public function __construct(){
		
		parent::__construct();
		$this->load->model('coreperformance','',TRUE);
		
	}
	
	public function index(){
		$num=0;
		$res=$this->coreperformance->hgroup();
		$data['hg_info']=$res;
		foreach($res as $q){
		$data['hn_info']=$this->coreperformance->hname(null,'*');
		}
		//$this->load->view('reporter/index', $data);
		
		
		$this->load->view('reporter/index', $data);
		//$this->load->view('reporter/footer');
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