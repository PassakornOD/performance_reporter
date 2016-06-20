<?php

class Coredb extends CI_Model{
	
	public function __construct(){
		
		parent::__construct();
		
	}
	
	public function User_query($username, $password){
		$pass=sha1($password);
		$res = $this->db->get_where('user',array('username' => $username, 'password' => $pass));
		if($res->num_rows() == 1){
			//print_r($res->result());
			return $res;
		}
		else{
			return false;
		}
	}
	
	public function hostgroup_query($perm){
		
		if($perm == 0){
			$this->db->select('hostgroup_id, hostgroup');
			$this->db->from('hostgroup');
			$this->db->order_by('hostgroup', 'ASC');
			$res = $this->db->get();
		}
		else if($perm == 1){
			$this->db->select('hostgroup_id, hostgroup');
			$this->db->from('hostgroup');
			$this->db->where('owner=','sta1');
			$this->db->order_by('hostgroup', 'ASC');
			$res = $this->db->get();
		}
		else if($perm == 2){
			$this->db->select('hostgroup_id, hostgroup');
			$this->db->from('hostgroup');
			$this->db->where('owner=','sta2');
			$this->db->order_by('hostgroup', 'ASC');
			$res = $this->db->get();
		}
		else if($perm == 4){
			$this->db->select('hostgroup_id, hostgroup');
			$this->db->from('hostgroup');
			$this->db->where('owner=','sta1');
			$this->db->or_where('owner=','sta2');
			$this->db->order_by('hostgroup', 'ASC');
			$res = $this->db->get();
		}
		else{
			$this->db->select('hostgroup_id, hostgroup');
			$this->db->from('hostgroup');
			$this->db->where('owner=','vas');
			$this->db->order_by('hostgroup', 'ASC');
			$res = $this->db->get();
		}
		
		return $res;
	}
	
	public function hostname_query($where,$select){
		/*$this->db->select('*');
		$this->db->from('hostname');
		$this->db->where('hostgroup_id=',$where);
		$this->db->order_by('hostgroup_id', 'ASC');
		$res = $this->db->get();
		*/
		//print_r($where);
		$this->db->select($select);
		$this->db->from('hostname');
		$this->db->join('hostgroup', 'hostname.hostgroup_id = hostgroup.hostgroup_id');
		if($where != null){
			$this->db->where('hostgroup=',$where);
		}
		$res = $this->db->get();
		//print_r($res->result());
		return $res;
	}
	
	public function sarcpu_query($hostgroup, $hostname, $hostname_id, $startdate, $stopdate, $option){
		list($startY,$startM,$startD) = explode("-",$startdate);
		list($stopY,$stopM,$stopD) = explode("-",$stopdate);
		if($option=="Normal"){
			$select="*";
		}
		else if($option=="Average"){
			$select="DATE(time),AVG(usr),AVG(nice),AVG(sys),AVG(wio),AVG(steal),AVG(idle),hostname_id";
			$group=array("DAY(time)", "MONTH(time)");
		}
		else{
			$select="DATE(time),AVG(usr+nice+sys+wio+steal),MIN(idle),hostname_id";
			$group=array("DAY(time)", "MONTH(time)");
		}
		$where="hostname_id='$hostname_id' AND time BETWEEN date('$startY-$startM-$startD') AND date('$stopY-$stopM-$stopD')";
		$order="time ASC";
		
		
		
		$this->db->select($select);
		$this->db->from($hostgroup.":u");
		$this->db->where($where);
		if($option != "Normal"){
			$this->db->group_by($group);
		}
		$this->db->order_by($order);
		$res = $this->db->get();
		//print_r($res->result());
		
	}
}

?>