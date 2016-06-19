<?php
Class User extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
		$this -> load -> helper('date');
		$this->load->library("session");
	
    }
	
	public function ChkSession(){
		$res="";
		if($this->input->post("btn") != null){
			if($this->input->post("username")== null && $this->input->post("password")== null){
				$res=false;
			}
			else{
				$user_q=$this->input->post("username");
				$pass_q=$this->input->post("password");
				$this->load->model('coredb','',TRUE);
				$res=$this->coredb->user_query($user_q, $pass_q);
			}
		}
		return $res;
	}
/*	
	public function login($username, $password)
	{
		$this->db->select('username,password');
		$this->db->from('raduser');
		$this->db->where('Username', $username);
		$this->db->where('Password', $password);
		$this->db->limit(1);
		$ar=array('username' => $username, 'password' => $password);
		$this->db->from('user')->where($ar);
		$query = $this->db->get();
		
 
	if($query -> num_rows() == 1)
		return $query->result();
	else
		return false;
   }
   
   function cntguest()
   {
	   $group = 'Guest';
	   $this -> db -> select('Username');
	   $this -> db -> from('raduser');
	   $this -> db -> where('Group',$group);
	   return $this -> db -> count_all_results();
   }
   
   function adduser($user)
   {
		$data = array(
			'Username' => $user['username'],
			'Password' => $user['password'],
			'Group' => $user['group'],
			'ID' => $user['id'],
			'e_Name' => $user['firstname'],
			'e_SurName' => $user['surname'],
			'AddBy' => $user['addby'],
			'TelNO' => $user['telno'],
			'EMail' => $user['email'],
			'Status' => $user['status'],
			't_Name' => $user['tfname'],
			't_SurName' => $user['tsname'],
			'Address' => $user['addr'],
			'StartDate' => $user['start'],
			'StopDate' => $user['stop']
		);	
	   $this -> db -> insert('raduser',$data);
	   
   }
 
	function updatedata($user,$pass)
	{
		$data = array(
			'Password' => $pass,
			'Status' => "Activated"
		);
		$this -> db -> where('Username',$user);
		$this -> db -> update('raduser',$data);
		
		$this -> db -> select('*');
		$this -> db -> from('raduser');
		$this -> db -> where('Username', $user);
		$this -> db -> where('Password', $pass);
		$this -> db -> limit(1);
 
		$query = $this -> db -> get();
		$this -> activateusr($user,$pass);
		if($query -> num_rows() == 1)
			return true;
		else
			return false;
	}
	
	function activateusr($user,$pass)
	{
		$data = array(
			'id' => NULL,
			'username' => $user,
			'attribute' => 'Cleartext-Password',
			'op' => ':=',
			'value' => $pass
		);
		$this -> db -> insert('radcheck',$data);
	}
	
	function chcuser($user)
	{
		$this -> db -> select('Username,Password,Group,ID,e_Name,e_SurName,AddBy,TelNO,EMail,Status,t_Name,t_SurName,Address');
		$this -> db -> from('raduser');
		$this -> db -> where('Username',$user);

		$query = $this -> db -> get();
		
		if($query -> num_rows() == 1)
			return $query->result();
		else
			return false;
	}
	function lastlogin($user)
	{
		$this -> db -> select('authdate');
		$this -> db -> from('radpostauth');
		$this -> db -> where('username',$user);
		$this -> db -> order_by('username','desc');
		$query = $this -> db -> get();
		if($query -> num_rows() >= 1)
			return $query->result();
		else
			return 0;		
	}
	function lastloginall()
	{
		$this -> db -> select('username');
		$this -> db -> select_max('authdate');
		$this -> db -> from('radpostauth');
		$this -> db -> group_by('username'); 
		$this -> db -> order_by('max(authdate)','desc');
		$query = $this -> db -> get();
		if($query -> num_rows() >= 1)
			return $query->result();
		else
			return 0;		
	}
	function chclm($user,$grp)
	{
		$this -> db -> select('lmData,lmHour,Setlimit');
		$this -> db -> from('radlimit');
		$this -> db -> where('Group',$grp);
		$query = $this -> db -> get();
		
		if($query -> num_rows() == 1)
			return $query->result();
		else
			return false;
	}
	function upduser($user)
	{
		$data = array(
			'Username' => $user['username'],
			'Password' => $user['password'],
			'Group' => $user['group'],
			'ID' => $user['id'],
			'e_Name' => $user['firstname'],
			'e_SurName' => $user['surname'],
			'AddBy' => $user['addby'],
			'TelNO' => $user['telno'],
			'EMail' => $user['email'],
			'Status' => $user['status'],
			't_Name' => $user['tfname'],
			't_SurName' => $user['tsname'],
			'Address' => $user['addr']
		);
		$this -> db -> where('Username',$user['username']);
		$this -> db -> update('raduser',$data);
	}
	
	function nowlogin()
	{
		$this -> db -> select('username,nasipaddress,acctstarttime,callingstationid');
		$this -> db -> from('radacct');
		$this -> db -> where('acctstoptime',NULL);
		$query = $this -> db -> get();
		
		if($query -> num_rows() >= 1)
			return $query->result();
		else
			return 0;		
	}
	
	function chcdata($user)
	{
		$this -> db -> select('dataUse,hourUse');
		$this -> db -> from('raduser');
		$this -> db -> where('username',$user);
		
		$query = $this -> db -> get();
		
		if($query -> num_rows() >= 1)
			return $query->result();
		else
			return 0;			
	}
	
	function usagephr($datetime)
	{
		$this -> db -> distinct();
		$this -> db -> select('username');
		$this -> db -> from('radacct');
		$this -> db -> like('acctstarttime', $datetime, 'after'); 	
		$query = $this -> db -> count_all_results();
		
		if($query)
			return $query;
		else
			return 0;			
	}
	function dataphr($datetime)
	{
		$this -> db -> select('acctinputoctets,acctoutputoctets');
		$this -> db -> from('radacct');
		$this -> db -> like('acctstarttime', $datetime, 'after'); 
		$this -> db -> where('acctstoptime IS NOT NULL', null, false);
		$query = $this -> db -> get();
		
		if($query -> num_rows()>=1)
			return $query->result();
		else
			return 0;			
	}
	
	function setlm($group,$dtlm,$hrlm,$setlm)
	{
		$data = array(
			'lmData' => $dtlm,
			'lmHour' => $hrlm,
			'Setlimit' => $setlm
		);
		$this -> db -> where('Group',$group);
		$this -> db -> update('radlimit',$data);
	}
	
	function logpdf()
	{
		$this -> db -> select('username,callingstationid,nasipaddress,acctstarttime,acctstoptime,acctinputoctets,acctoutputoctets');
		$this -> db -> from('radacct');
		$this -> db -> order_by('radacctid','asc');
		
		$query = $this -> db -> get();
		
		if($query -> num_rows() >= 1)
			return $query->result();
		else
			return 0;			
	}
	*/
}
?>