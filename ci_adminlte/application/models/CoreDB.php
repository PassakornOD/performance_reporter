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
		$index=0;
		$query_res=false;
		//print_r($sql['select_avg'][0]);
		if($sql['select'] != null)
			$this->db->select($sql['select']);
		if($sql['select_avg'] != null)
			for($i=0;$i<count($sql['select_avg']);$i++){
				//print_r($sql['select_avg'][$i]);
				$this->db->select_avg($sql['select_avg'][$i]);
				//print_r($i);
			}
		if($sql['select_min'] != null)
			//print($sql['select_min']['idle']);
			$this->db->select_min($sql['select_min']['idle']);
		$this->db->from($hostgroup->hostgroup.":u");
		if($sql['where'] != null)
			$this->db->where($sql['where']);
		if($sql['group'] != null)
			$this->db->group_by($sql['group']);
		if($sql['order'] != null)
			$this->db->order_by($sql['order']);
		$res=$this->db->get();
		$rs=$res->result();
		foreach($rs as $q){
			$query_res[$q->datetime]=$q;
		}
		//print_r($query_res);
		if($query_res != null){
			return $query_res;
		}
			
		return false;
	}
}

?>