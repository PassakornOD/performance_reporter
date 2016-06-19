<?php

class Coredb extends CI_Model{
	
	public function __construct(){
		
		parent::__construct();
		
	}
	
	public function User_query($username, $password){
		//$this->db->select();
		//$this->db->from('user');
		//$this->db->where('username', $username);
		//$this->db->where('password', $password);
		//$this->db->limit(1);
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
	
	public function hostname_query($where){
		$this->db->select('*');
		$this->db->from('hostname');
		$this->db->where('hostgroup_id=',$where);
		$this->db->order_by('hostgroup_id', 'ASC');
		$res = $this->db->get();
	
		return $res;
	}
}

?>