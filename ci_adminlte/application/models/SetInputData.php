<?php

class SetInputData extends CI_Model{
	
	public function __construct(){
		
		parent::__construct();
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
				
				//print_r($lists->OS);
				//print_r($lists);
				//print_r($num);
				$data[$lists->hostname_id]=$this->coreperformance->cpu_usage_daily($lists, $startdate, $stopdate, "Average");	
				
			}	
				print_r($data['506']);
				$this
				echo "<br/>";
				echo "<br/>";
				echo "<br/>";
			//print_r($num);	
				
			//print_r($hostgroup);
			//print_r($startdate);
			//print_r($stopdate);
			//print_r($list_host[0][0]->hostname);
			return $data;
		}
			//return $data;
	}
	
}

?>