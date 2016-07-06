<?php
Class User extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
		$this->load->model('coredb','',TRUE);
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
				$res=$this->coredb->user_query($user_q, $pass_q);
			}
		}
		return $res;
	}
/*	

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