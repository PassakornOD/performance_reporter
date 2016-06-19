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
	
		return $data;
		
	}
	
	public function hname($rs){
		$num=0;
		foreach($rs as $q){
			print_r($q['hgroup']);
			//echo "<br/>";
			$i=0;
			$res=$this->coredb->hostname_query($q['hgroup_id']);
			$rs=$res->result();
			$data=$rs;
			//while($row=$res->num_rows()> $i){
				//$data[$num[$i]]=$rs[$i];
			//}
		}
		//print_r($data);
		return $data;
	}
}
?>