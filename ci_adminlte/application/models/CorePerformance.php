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
	
	public function cpu_usage_daily($dataquery, $startdate, $stopdate, $option){
		//print_r($dataquery);
		list($startY,$startM,$startD) = explode("-",$startdate);
		list($stopY,$stopM,$stopD) = explode("-",$stopdate);
		//print_r($dataquery->OS);
		if($dataquery->OS == "RedHat" || $dataquery->OS == "Red Hat"){
			if($option=="Normal"){
				$select="*";
				$where="hostname_id='$dataquery->hostname_id' AND time BETWEEN date('$startY-$startM-$startD') AND date('$stopY-$stopM-$stopD')";
				$group="";
				$order="time ASC";
				$sql=$this->set_flag_query($select, $where ,$group, $order);
			}
			else if($option=="Average"){
				$select="'DATE(time),AVG(usr),AVG(nice),AVG(sys),AVG(wio),AVG(steal),AVG(idle),hostname_id'";
				$where="hostname_id='$dataquery->hostname_id' AND time BETWEEN date('$startY-$startM-$startD') AND date('$stopY-$stopM-$stopD')";
				$group=array("DAY(time)", "MONTH(time)");
				$order="'time ASC'";
				$sql=$this->set_flag_query($select, $where ,$group, $order);
			}
			else{
				$select="DATE(time),AVG(usr+nice+sys+wio+steal),MIN(idle),hostname_id";
				$where="hostname_id='$dataquery->hostname_id' AND time BETWEEN date('$startY-$startM-$startD') AND date('$stopY-$stopM-$stopD')";
				$group=array("DAY(time)", "MONTH(time)");
				$order="'time ASC'";
				$sql=$this->set_flag_query($select, $where ,$group, $order);
			}
			//print_r($sql);
			//foreach()
			$res=$this->coredb->sarcpu_query($dataquery, $sql);
			
			//foreach($res as $rs){
				//$rs->next_row();
				//print_r($rs);
				//print_r($rs->num_fields());
			//}
			$data[$dataquery->hostname]=$res;
			return $data;
		}else{
			
			
		}
		
	}
	
	
	public function set_flag_query($select, $where ,$group, $order){
		
		$data['select']=$select;
		$data['where']=$where;
		$data['group']=$group;
		$data['order']=$order;
		
		return $data;
	}

}
?>