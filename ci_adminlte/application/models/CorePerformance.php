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
			$data[$hg]=array("hostgroup" => $rs[$hg]->hostgroup, "hostgroup_id" => $rs[$hg]->hostgroup_id);
			$hg++;	
		}
		//print_r($data);
		return $data;
	}
	
	public function hname($rs,$select){
		$num=0;
		if($rs!=null){
			//print_r($rs);
			$res=$this->coredb->hostname_query($rs,$select);
			$rs=$res->result();
			$data['sql']=$rs;
				//print_r($data);
				//echo "<br/>";
		}else{
			$res=$this->coredb->hostname_query("",$select);
			$rs=$res->result();
			$data['sql']=$rs;
		}
		//print_r($data);
		return $data;
	}
	//public function type_normal($setdata){
		
	//}
	public function cpu_usage_daily($dataquery, $startdate, $stopdate, $option){
		//print_r($dataquery);
		list($startY,$startM,$startD) = explode("-",$startdate);
		list($stopY,$stopM,$stopD) = explode("-",$stopdate);
		//print_r($dataquery->OS);
		
		/* OS is RHEL */
		if($dataquery->OS == "RedHat" || $dataquery->OS == "Red Hat"){
			if($option=="Normal"){
				$data['select']="*";
				$data['select_avg']="";
				$data['select_min']="";
				$data['where']="hostname_id='$dataquery->hostname_id' AND time BETWEEN date('$startY-$startM-$startD') AND date('$stopY-$stopM-$stopD')";
				$data['group']="";
				$data['order']="time ASC";
			}
			else if($option=="Average"){
				//$select="'DATE(time),AVG(usr),AVG(nice),AVG(sys),AVG(wio),AVG(steal),AVG(idle),hostname_id'";
				$data['select']="DATE(time)as datetime,hostname_id";
				$data['select_avg']=array("0" => 'usr',
									 "1" => 'nice',
									 "2" => 'sys',
									 "3" => 'wio',
									 "4" => 'steal',
									 "5" => 'idle'
								);
				$data['select_min']="";
				$data['where']="hostname_id='$dataquery->hostname_id' AND time BETWEEN date('$startY-$startM-$startD') AND date('$stopY-$stopM-$stopD')";
				$data['group']=array("DAY(time)", "MONTH(time)");
				$data['order']="'time ASC'";
			}
			else{
				//$select="DATE(time),AVG(usr+nice+sys+wio+steal),MIN(idle),hostname_id";
				$data['select']="DATE(time) as datetime,AVG(usr+nice+sys+wio+steal) as avgcol,hostname_id";
				$data['select_avg']="";//array( "0" => 'usr+nice+sys+wio+steal');
				$data['select_min']=array( "idle" => 'idle');
				$data['where']="hostname_id='$dataquery->hostname_id' AND time BETWEEN date('$startY-$startM-$startD') AND date('$stopY-$stopM-$stopD')";
				$data['group']=array("DAY(time)", "MONTH(time)");
				$data['order']="'time ASC'";
			}
			$result=$this->coredb->sarcpu_query($dataquery, $data);
			//print_r($res);
		}
		// case OS not RHEL ************
		
		else{
			if($option=="Normal"){
				$data['select']="*";
				$data['select_avg']="";
				$data['select_min']="";
				$data['where']="hostname_id='$dataquery->hostname_id' AND time BETWEEN date('$startY-$startM-$startD') AND date('$stopY-$stopM-$stopD')";
				$data['group']="";
				$data['order']="time ASC";
			}
			else if($option=="Average"){
				//$select="'DATE(time),AVG(usr),AVG(nice),AVG(sys),AVG(wio),AVG(steal),AVG(idle),hostname_id'";
				$data['select']="DATE(time)as datetime,hostname_id";
				$data['select_avg']=array("0" => 'usr',
									 "1" => 'sys',
									 "2" => 'wio',
									 "3" => 'idle'
								);
				$data['select_min']="";
				$data['where']="hostname_id='$dataquery->hostname_id' AND time BETWEEN date('$startY-$startM-$startD') AND date('$stopY-$stopM-$stopD')";
				$data['group']=array("DAY(time)", "MONTH(time)");
				$data['order']="'time ASC'";
			}
			else{
				//$select="DATE(time),AVG(usr+nice+sys+wio+steal),MIN(idle),hostname_id";
				$data['select']="DATE(time) as datetime,AVG(usr+sys+wio) as avgcol,hostname_id";
				$data['select_avg']="";//array( "0" => 'usr+nice+sys+wio+steal');
				$data['select_min']=array( "idle" => 'idle');
				$data['where']="hostname_id='$dataquery->hostname_id' AND time BETWEEN date('$startY-$startM-$startD') AND date('$stopY-$stopM-$stopD')";
				$data['group']=array("DAY(time)", "MONTH(time)");
				$data['order']="'time ASC'";
			}
			$result=$this->coredb->sarcpu_query($dataquery, $data);
			//print_r($res);
		}
		//print_r($data['sardata']);
		return $result;
	}
	
	
	public function set_flag_query($data){
		
		$data['select']=$select;
		$data['where']=$where;
		$data['group']=$group;
		$data['order']=$order;
		
		return $data;
	}

}
?>