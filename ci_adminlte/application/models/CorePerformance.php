<?php

class CorePerformance extends CI_Model{
	
	public function __construct(){
		
		parent::__construct();
		$this->load->model('coredb','',TRUE);
		
	}
	
	public function hgroup(){
		
		$hgs="";
		$perm=$this->session->userdata("perm");
		$res=$this->coredb->hostgroup_query($perm);
		$rs=$res->result();
		$hg=0;
		while($row=$res->num_rows()>$hg){
			$data[$hg]=array("hgroup" => $rs[$hg]->hostgroup, "hgroup_id" => $rs[$hg]->hostgroup_id);
			$hg++;	
		}
		//print_r($data);
		return $data;
	}
	
	public function hname($rs,$select){
		$num=0;
		if($rs!=null){
			foreach($rs as $q){
				//print_r($q);
				$res=$this->coredb->hostname_query($q,$select);
				$rs=$res->result();
				$data[$num++]=$rs;
				//print_r($data);
				//echo "<br/>";
			}
		}else{
			$res=$this->coredb->hostname_query("",$select);
			$rs=$res->result();
			$data=$rs;
		}
		//print_r($data);
		return $data;
	}
	
	public function cpu_usage_daily($hostgroup, $hostname, $hostname_id, $os, $startdate, $stopdate, $option){
		if($os=="RedHat" || $os == "Red Hat"){
			print_r($hostgroup);
			$this->coredb->sarcpu_query($hostgroup, $hostname, $hostname_id, $startdate, $stopdate, $option);
		}
		else{
			
		}
		
	}
}
?>