<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Genpdf extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('coreperformance','',TRUE);
		//$this->load->model('setinputdata','',TRUE);
		$this->load->model('charts','',TRUE);
		$this->load->library('Pdf');
	}
	
	public function index(){
		$res_data="";
		$data['hg_q']=$this->coreperformance->hgroup();
		$this->load->view('pdf/genpdf', $data);
		if($this->input->post("btchk")){
			$res_data=$this->getformpdf();
			//print_r($res_data);
			$this->session->set_userdata('datacharts', $res_data);
			redirect('charts/get_data');
		}
		else{
			//$this->load->view('pdf/genpdf',$data);
		}
		//print_r($res_data);
		//echo "ssss";
		//redirect('charts/get_data/var');
		
	}
	public function getformpdf(){
		
		$type_flag="Average";
		$check=$this->input->post('hostgroupchk');
		if(isset($check)==1){
			$hostgroup=$this->input->post("hostgroupchk");
			$startdate=$this->input->post("startdate");
			$stopdate=$this->input->post("stopdate");
			$data['startdate']=$startdate;
			$data['stopdate']=$stopdate;
			$sql_select="hostname_id,hostname,OS,hostgroup.hostgroup,hostgroup.hostgroup_id";
			$data['list_group']=$hostgroup;
			//$this->load->view('auth/charts');
			foreach($hostgroup as $group){
				$list_host=$this->coreperformance->hname($group,$sql_select);
				$data['list_name']=$list_host['sql'];
				//print_r($list_host['sql'][0]);
				//$num=0;
				//foreach($list_host['sql'] as $lists){
					//$data[$lists->hostname_id]=$this->coreperformance->cpu_usage_daily($lists, $startdate, $stopdate, $type_flag);
					//print_r($data[$lists->hostname_id]['sql']);
					//$data_chart=$this->set_format($data[$lists->hostname_id]);
					//echo "<br/>";
					//$this->charts->daily_charts($data_chart, $type_flag);
					//print_r($data[$lists->hostname_id]);
					//echo "<br/>";
				//}	
			}
			//print_r($data[$lists->hostname_id]['sardata']);
			//echo $num;
			//return $data;
		}
			return $data;
	}
	public function set_format($data_q){
	//print_r($data_q['hostname']);
		foreach($data_q as $q){
			//print_r($q);
			$datedata = $q->datetime.", ";
			//$data['timedata'] .= "";
			$usrdata = $q->usr.", ";
			$sysdata = $q->sys.", ";
			$wiodata = $q->wio.", ";
			$idledata = $q->idle.", ";
		}
		$data['datedata'] = $datedata;
		$data['usrdata'] = $usrdata;
		$data['sysdata'] = $sysdata;
		$data['wiodata'] = $wiodata;
		$data['idledata'] = $idledata;
		//print_r($data);
		return $data;
		
	}

}
?>