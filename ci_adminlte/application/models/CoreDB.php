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
	
	public function sarcpu_query($hostgroup, $sql){
		//print_r($sql);
		if($sql['select'] != null)
			$this->db->select($sql['select']);
		$this->db->from($hostgroup->hostgroup.":u");
		if($sql['where'] != null)
			$this->db->where($sql['where']);
		if($sql['group'] != null)
			$this->db->group_by($sql['group']);
		if($sql['order'] != null)
			$this->db->order_by($sql['order']);
		$res = $this->db->get();
		//print_r($res->result_object());
		if($res->num_rows() > 0)
			return $res->result_object();
		return false;
	}
}

?>