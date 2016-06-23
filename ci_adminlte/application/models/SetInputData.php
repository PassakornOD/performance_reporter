<?php

class SetInputData extends CI_Model{
	
	public function __construct(){
		
		parent::__construct();
		$this->load->library('session');
		$this->load->model('coreperformance','',TRUE);
	}
	
	public function getformpdf(){
		
		
		$check=$this->input->post('hostgroupchk');
		if(isset($check)==1){
			$hostgroup=$this->input->post("hostgroupchk");
			$startdate=$this->input->post("startdate");
			$stopdate=$this->input->post("stopdate");
			$sql_select="hostname_id,hostname,OS,hostgroup.hostgroup,hostgroup.hostgroup_id";
			$list_host=$this->coreperformance->hname($hostgroup,$sql_select);
			$data['hostgroup']=$hostgroup;
			$data['startdate']=$startdate;
			$data['stopdate']=$stopdate;
			$num=0;
			$host_list=$list_host[0];
			//print_r($host_list);
			foreach($host_list as $lists){
				$data[$lists->hostname_id]=$this->coreperformance->cpu_usage_daily($lists, $startdate, $stopdate, "Average");
				//$data['ser']=$this->set_data_chart($data,$lists->hostname_id);
				//redirect('charts/test');
			}	
			return $data;
		}
			//return $data;
	}
	
	public function set_data_chart($alldata, $hostname_id){
		foreach($alldata[$hostname_id] as $q){
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
		print_r($usrdata);
		return $data;
		//$this->session->keep_flashdata('chartdata', $data);
		
	}
	
}

?>