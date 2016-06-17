<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setlimit extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user','',TRUE);
	}

	function setlm()
	{
		$setdb=$this->input->post('optradio');
	
		if($setdb=='01')
		{
			$val=$this->input->post('set1');
			if($this->input->post('type')=='MB')
			{
				$this->user->setlm('Student',$val,'0',$setdb);
			}	
			else
			{
				$val = $val*1024;
				$this->user->setlm('Student',$val,'0',$setdb);
			}
		}
		else if($setdb=='10')
		{
			$val2=$this->input->post('set2');
			$this->user->setlm('Student','0',$val2,$setdb);
		}	
		else
			$this->user->setlm('Student','0','0',$setdb);
		
		redirect('home/limitfn','refresh');
	}
}




?>