<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user','',TRUE);
	}

	function index()
	{
		//This method will have the credentials validation
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');

		if($this->form_validation->run() == FALSE)
		{
			//Field validation failed.  User redirected to login page
			$this->load->view('login_view');
		}
		else
		{
			//Go to private area
			redirect('home/index', 'refresh');
		}

	}

	function check_database($password)
	{
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('username');

		//query the database
		$result = $this->user->login($username, $password);

		if($result)
		{
			$sess_array = array();
			foreach($result as $row)
			{
				$sess_array = array(
					'username' => $row->Username,
					'group' => $row->Group,
					'status' => $row->Status
				);
			$this->session->set_userdata('logged_in', $sess_array);
			}
			return TRUE;
		}
		else
		{
			$this->get1user($username);
			$newpass = $this->un_htmlspecialchars($password);
			$newpass2 = sha1(strtolower($username).$newpass);
			$result2=$this->user->login($username,$newpass2);
			if($result2)
			{
				$sess_array = array();
				foreach($result2 as $row)
				{
					$sess_array = array(
						'username' => $row->Username,
						'group' => $row->Group,
						'status' => $row->Status
					);
					$this->session->set_userdata('logged_in', $sess_array);
				}
				return TRUE;
			}
			else
			{
				$this->form_validation->set_message('check_database', 'Invalid username or password');
				return false;
			}
		}
	}
 
	function un_htmlspecialchars($string)
	{	//ฟังก์ชันการแปลอักขระพิเศษ
		$translation = array_flip(get_html_translation_table(HTML_SPECIALCHARS, ENT_QUOTES)) + array('&#039;' => '\'', '&nbsp;' => ' ');
		return strtr($string, $translation);
	}
 
	function get1user($user)
	{
		$client = new SoapClient("http://www.ce.kmitl.ac.th/webservice_radius/wsdl.xml", array('trace' => 1 ));
		//-----------------------------------------------------------------------
		try {
			$array = $client->__soapCall("get1UserInfo",array($user));
			$ret=$array;
			if($ret[0][0]!=NULL)
			{
				$Username=$ret[0][0];
				$Password=$ret[0][1];
				if(!isset($ret[0][2])) $TName='-'; else $TName=$ret[0][2];
				if(!isset($ret[0][3])) $Ename='-'; else $Ename=$ret[0][3];
				if(!isset($ret[0][4])) $TSName='-'; else $TSName=$ret[0][4];
				if(!isset($ret[0][5])) $ESname='-'; else $ESname=$ret[0][5];
				if(!isset($ret[0][6])) $GP='Student'; else if($ret[0][6]=='Teacher'||$ret[0][6]=='Staff'||$ret[0][6]=='Chair') $GP='Lecturer';else $GP=$ret[0][6];
				if(!isset($ret[0][7])) $IDE='-'; else $IDE=$ret[0][7];;
				if(!isset($ret[0][8])) $email='-'; else $email=$ret[0][8];
				if(!isset($ret[0][9])) $Telno='-'; else $Telno=$ret[0][9];
				if(!isset($ret[0][10])) $Addr='-'; else $Addr=$ret[0][10];
				
				$user= array(
					'firstname' => $Ename,
					'surname' => $ESname,
					'id' => $IDE,
					'telno' => $Telno,
					'email' => $email,
					'password' => $Password,
					'username' => $Username,
					'status' => "Deactivated",
					'group' => $GP,
					'addby' => 'Admin',
					'tfname'=> $TName,
					'tsname'=> $TSName,
					'addr'=> $Addr,
					'start' => '',
					'stop' => ''
				);
				$result=$this->user->chcuser($Username);
				if($result)
				{
					foreach($result as $row)
					{
						$pwd = $row->Password;
						$sts = $row->Status;
					}
					if(($Password!=$pwd)&&($sts=='Deactivated'))
						$this->user->upduser($user);
				}
				else
					$this->user->adduser($user);
			}
		}
		catch (SoapFault $SoapFault) {
			var_dump($SoapFault);
			echo "<br>Request :<br>", htmlentities($client->__getLastRequest()), "<br>";
			echo "Response :<br>", htmlentities($client->__getLastResponse()), "<br>";
		}
	}
}
?>