<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user','',TRUE);
		$this->load->library("session");
	}
	 
	public function index()
	{
		if($this->session->userdata("user") != null && $this->session->userdata("pass")!= null){
			$data=$this->session->userdata($ar);
			$this->load->view('reporter/index',$data);
		}
		else{
			$res=$this->user->ChkSession();
			if($res){
				//print_r($res->result());
				$rs=$res->result_array();
				foreach ($rs as $q){
					$ar=array(
								'user' => $q['username'],
								'perm' => $q['permission']
							);
					$this->session->set_userdata($ar);
					$data['user_sess']=$this->session->userdata("user");
					$data['perm_sess']=$this->session->userdata("perm");
				}
				//$this->load->view('reporter/index');
				 redirect("reporter");
			}
			else{
				$this->load->helper(array('form'));
				//$this->load->view('auth/charts');
				$this->load->view('auth/login');
			}
			
		}
		
	}
	 
	public function del_session(){
		
		$this->session->sess_destroy();
		redirect('/', "refresh");
		exit();
	}
	
}
 
?>