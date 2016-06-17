<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user','',TRUE);
		$this->load->helper(array('form'));
	}

	function index()
	{
		/*if($this->session->userdata('logged_in'))
		{
			$session_data = $this -> session -> userdata('logged_in');
			$data = array(
				'username' => $session_data['username'],
				'group' => $session_data['group'],
				'status' => $session_data['status']
			);			
			if($data['status']=="Deactivated")
			{
				$this->load->view('setpass_view',$data);
			}
			else
			{*/
				$result = $this -> user -> chcuser($data['username'],$data['group']);
				if($result){
					foreach($result as $row)
					{
						$data2 = array(
							'firstname' => $row->e_Name,
							'surname' => $row->e_SurName,
							'citizid' => $row->ID,
							'telno' => $row->TelNO,
							'email' => $row->EMail,
							'username' => $row->Username,
							'status' => $row->Status,
							'group' => $row->Group,
							'addby' => $row->AddBy,
							'tfname'=> $row->t_Name,
							'tsname'=> $row->t_SurName,
							'addr'=> $row->Address
						);
					}
				}
				$result2=$this->user->lastlogin($data['username']);
				if($result2){
					foreach($result2 as $row2)
					{
						$data2['lastlogin'] = $row2->authdate;
					}
				}
				else
					$data2['lastlogin'] = '-';
				//----------------------------Header-----------------------------------
				$this->load->view('home_view', $data);

				//---------------------------Side_view---------------------------------
				if($data['group']=='Student')
					$this->load->view('stuside_view', $data);
				else if($data['group']=='Lecturer')
					$this->load->view('lecside_view', $data);
				else if($data['group']=='Admin')
					$this->load->view('adside_view', $data);
				else
					redirect('login', 'refresh');
				
				//---------------------------Main_view---------------------------------
				$this->load->view('main_view',$data2);
				$this->load->view('endt_view', $data);
			}
			
		//}
		/*else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}*/
	}
	
	function checkdt()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this -> session -> userdata('logged_in');
			$data = array(
				'username' => $session_data['username'],
				'group' => $session_data['group'],
				'status' => $session_data['status']
			);

			$result=$this->user->chcdata($data['username']);
			if($result)
			{
				foreach($result as $row)
				{
					$dtuse = $row->dataUse;
					$hruse = $row->hourUse;
				}
			}
			
			$result2=$this->user->chclm($data['username'],$data['group']);
			if($result2)
			{
				foreach($result2 as $row2)
				{
					$lmdata = $row2->lmData;
					$lmhour = $row2->lmHour;
					$Setlimit = $row2->Setlimit;
				}
				
				if($Setlimit=='01')
				{
					if($lmdata!=0)
					{
						$dtuseper = ($dtuse*100)/$lmdata;
						$dtuseper = number_format($dtuseper, 2, '.', ' ');
						$data['dtuse'] = $dtuse;
						$data['dtuseper'] = $dtuseper;
						$data['lmdata'] = $lmdata;
						$data['type'] = " MB";
					}
					else
					{
						$dtuseper = 0;
						$data['dtuse'] = $dtuse;
						$data['dtuseper'] = $dtuseper;
						$data['lmdata'] = 0;
						$data['type'] = " MB";
					}
				}
				else if($Setlimit=='10')
				{
					if($lmhour!=0)
					{
						$dtuseper = ($hruse*100)/$lmhour;
						$dtuseper = number_format($dtuseper, 2, '.', ' ');
						$data['dtuse'] = $hruse;
						$data['dtuseper'] = $dtuseper;
						$data['lmdata'] = $lmhour;
						$data['type'] = " Hr";
					}
					else
					{
						$dtuseper = 0;
						$data['dtuse'] = $hruse;
						$data['dtuseper'] = $dtuseper;
						$data['lmdata'] = 0;
						$data['type'] = " Hr";
					}
				}
				else
				{
					$dtuseper = 0;
					$data['dtuse'] = $dtuse;
					$data['dtuseper'] = $dtuseper;
					$data['lmdata'] = 0;
					$data['type'] = " MB";
				}
				
			}
			else
				{
					$dtuseper = 0;
					$data['dtuse'] = 0;
					$data['dtuseper'] = 0;
					$data['lmdata'] = 0;
					$data['type'] = " MB";
				}

			$this->load->view('check_view',$data);
			//----------------------------Tale-----------------------------------
			$this->load->view('endt_view', $data);


		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	function adduser()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this -> session -> userdata('logged_in');
			$data = array(
				'username' => $session_data['username'],
				'group' => $session_data['group'],
				'status' => $session_data['status']
			);
			
			if($data['group']=='Lecturer')
			{
				$this->load->helper(array('form'));
			//---------------------------Main_view---------------------------------
				$this->load->view('addu_view',$data);
			}
			else
				redirect('home', 'refresh');
			//----------------------------Tale-----------------------------------
			$this->load->view('endt_view', $data);


		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	function addmultiuser()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this -> session -> userdata('logged_in');
			$data = array(
				'username' => $session_data['username'],
				'group' => $session_data['group'],
				'status' => $session_data['status']
			);

			

			if($data['group']=='Lecturer')
			{

				$this->load->helper(array('form'));
				//---------------------------Main_view---------------------------------
				$this->load->view('addmul_view',$data);

			}
			else
				redirect('home', 'refresh');
			//----------------------------Tale-----------------------------------
			$this->load->view('endt_view', $data);


		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	function addtodb()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this -> session -> userdata('logged_in');
			$data = array(
				'username' => $session_data['username'],
				'group' => $session_data['group'],
				'status' => $session_data['status']
			);
			
			
			$inuser = $this -> input -> post('user');
			
			$cnt = $this -> user -> cntguest();
			if($cnt >= 1)
			{
				if($cnt >= 1000)
					$uname = "Guest".$cnt;
				else if($cnt >= 100)
					$uname = "Guest0".$cnt;
				else if($cnt >= 10)
					$uname = "Guest00".$cnt;
				else
					$uname = "Guest000".$cnt;
			}
			else
				$uname = 'Guest0001';
			
			$result=$this->user->chcuser($uname,'Guest');
			while($result){
				$cnt=$cnt+1;
				if($cnt >= 1000)
					$uname = "Guest".$cnt;
				else if($cnt >= 100)
					$uname = "Guest0".$cnt;
				else if($cnt >= 10)
					$uname = "Guest00".$cnt;
				else
					$uname = "Guest000".$cnt;
				$result=$this->user->chcuser($uname,'Guest');
			}
			
			$user= array(
				'firstname' => $inuser[0],
				'surname' => $inuser[1],
				'id' => $inuser[2],
				'telno' => $inuser[3],
				'email' => $inuser[4],
				'start' => $inuser[5],
				'stop' => $inuser[6],
				'password' => $this -> genpass(),
				'username' => $uname,
				'status' => "Activated",
				'group' => "Guest",
				'addby' => $data['username'],
				'tfname'=> $inuser[7],
				'tsname'=> $inuser[8],
				'addr'=> '-'
				
			);
			echo json_encode($user);
			

			
			$this -> user -> adduser($user);
			$this -> user -> activateusr($user['username'],$user['password']);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	function addmultodb()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this -> session -> userdata('logged_in');
			$data = array(
				'username' => $session_data['username'],
				'group' => $session_data['group'],
				'status' => $session_data['status']
			);
			
			$inuser = $this -> input -> post('data');
			
			$cnt = $this -> user -> cntguest();
			
			for($j=0; $j<count($inuser); $j++)
			{
				if($j>0)
				{
					$cnt=$cnt+1;
					if($cnt >= 1)
					{
						if($cnt >= 1000)
							$uname = "Guest".$cnt;
						else if($cnt >= 100)
							$uname = "Guest0".$cnt;
						else if($cnt >= 10)
							$uname = "Guest00".$cnt;
						else
							$uname = "Guest000".$cnt;
					}
					else
						$uname = "Guest0001";
					
					$result=$this->user->chcuser($uname,'Guest');
					while($result){
						$cnt=$cnt+1;
						if($cnt >= 1000)
							$uname = "Guest".$cnt;
						else if($cnt >= 100)
							$uname = "Guest0".$cnt;
						else if($cnt >= 10)
							$uname = "Guest00".$cnt;
						else
							$uname = "Guest000".$cnt;
						$result=$this->user->chcuser($uname,'Guest');
					}
					
					$user[$j]= array(
							'firstname' => $inuser[$j][0],
							'surname' => $inuser[$j][1],
							'id' => $inuser[$j][4],
							'telno' => $inuser[$j][5],
							'email' => $inuser[$j][6],
							'start' => $inuser[$j][7],
							'stop' => $inuser[$j][8],
							'password' => $this -> genpass(),
							'username' => $uname,
							'status' => "Activated",
							'group' => "Guest",
							'addby' => $data['username'],
							'tfname'=>$inuser[$j][2],
							'tsname'=>$inuser[$j][3],
							'addr'=>'-'

					);

					$this -> user -> adduser($user[$j]);
					$this -> user -> activateusr($user[$j]['username'],$user[$j]['password']);
				}		
				
			}
			echo json_encode($user);

			
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	function genpass()
	{
		$arr_az = range("a","z");
		$arrAZ = range("A","Z");
		$arr09 = range(0,9);

		$arra9 = array_merge($arr09,$arrAZ,$arr_az);
		$stra9 = implode($arra9);

		$stra9 = str_shuffle($stra9);

		$verify_pass = substr($stra9,0,8);

		return $verify_pass;
	}
	
	function condb()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this -> session -> userdata('logged_in');
			$data = array(
				'username' => $session_data['username'],
				'group' => $session_data['group'],
				'status' => $session_data['status']
			);

			$client = new SoapClient("http://www.ce.kmitl.ac.th/webservice_radius/wsdl.xml", array('trace' => 1 ));
			//-----------------------------------------------------------------------
			try {
				$array = $client->__soapCall("getUserInfo",array());
				$ret=$array;
		//		print_r($ret);
				//------------------------Loop for Add User-------------------------------
				$first=1;
				while($first){
					for($i=0;$i<sizeof($ret);$i++)
					{
						
						$Username=$ret[$i][0];
						$Password=$ret[$i][1];
						if(!isset($ret[$i][2])) $TName='-'; else $TName=$ret[$i][2];
						if(!isset($ret[$i][3])) $Ename='-'; else $Ename=$ret[$i][3];
						if(!isset($ret[$i][4])) $TSName='-'; else $TSName=$ret[$i][4];
						if(!isset($ret[$i][5])) $ESname='-'; else $ESname=$ret[$i][5];
						if(!isset($ret[$i][6])) $GP='Student'; else if($ret[$i][6]=='Teacher'||$ret[$i][6]=='Staff'||$ret[$i][6]=='Chair') $GP='Lecturer';else $GP=$ret[$i][6];
						if(!isset($ret[$i][7])) $IDE='-'; else $IDE=$ret[$i][7];;
						if(!isset($ret[$i][8])) $email='-'; else $email=$ret[$i][8];
						if(!isset($ret[$i][9])) $Telno='-'; else $Telno=$ret[$i][9];
						if(!isset($ret[$i][10])) $Addr='-'; else $Addr=$ret[$i][10];
						
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
						{
							$this->user->adduser($user);
						}
					}
					$first=0;
				}
			}
			catch (SoapFault $SoapFault) {
				var_dump($SoapFault);
				echo "<br>Request :<br>", htmlentities($client->__getLastRequest()), "<br>";
				echo "Response :<br>", htmlentities($client->__getLastResponse()), "<br>";
			}

			if($data['group']=='Admin')
			{
			//---------------------------Main_view---------------------------------
				$this->load->view('condb_view',$data);
			}
			else
				redirect('home', 'refresh');
			//----------------------------Tale-----------------------------------
			$this->load->view('endt_view', $data);
			

		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	function chconline()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this -> session -> userdata('logged_in');
			$data = array(
				'username' => $session_data['username'],
				'group' => $session_data['group'],
				'status' => $session_data['status']
			);
			$result = $this -> user -> nowlogin();
			if($result)
			{
				$i=0;
				foreach($result as $row)
				{
					$data['nasip'][$i] = $row->nasipaddress;
					$data['user'][$i] = $row->username;
					$data['start'][$i] = $row->acctstarttime;
					$data['mac'][$i] = $row->callingstationid;
					$i=$i+1;
				}
			}
			else
			{
				$data['nasip'][0]="No Access Point used";
				$data['user'][0]="-";
				$data['start'][0]="-";
				$data['mac'][0]="-";
			}
			
			if($data['group']=='Admin')
			{
			//---------------------------Main_view---------------------------------
				$this->load->view('showlogin_view',$data);
			}
			else
				redirect('home', 'refresh');
			//----------------------------Tale-----------------------------------
			$this->load->view('endt_view', $data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	function limitfn()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this -> session -> userdata('logged_in');
			$data = array(
				'username' => $session_data['username'],
				'group' => $session_data['group'],
				'status' => $session_data['status']
			);

			if($data['group']=='Admin')
			{

				$this->load->view('grouplimit_view',$data);

			}
			else
				redirect('home', 'refresh');
			//----------------------------Tale-----------------------------------
			$this->load->view('endt_view', $data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	function logpdf()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this -> session -> userdata('logged_in');
			$data = array(
				'username' => $session_data['username'],
				'group' => $session_data['group'],
				'status' => $session_data['status']
			);

			if($data['group']=='Admin')
				$this->load->view('logpdf_view',$data);
			else
				redirect('home', 'refresh');
			//----------------------------Tale-----------------------------------
			$this->load->view('endt_view', $data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	function lastlg()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this -> session -> userdata('logged_in');
			$data = array(
				'username' => $session_data['username'],
				'group' => $session_data['group'],
				'status' => $session_data['status']
			);
			$result=$this->user->lastloginall();
//			print_r($result);
			if($result)
			{
				$i=0;
				foreach($result as $row)
				{
					if($i==0)
					{
						$data['user'][$i] = $row->username;
						$data['auth'][$i] = $row->authdate;
						$i=$i+1;
					}
					else
					{
						for($j=0;$j<$i;$j++)
						{
							if($data['user'][$j]==$row->username)
							{
								$data['auth'][$j] = $row->authdate;
								$j=$i+1;
							}
							else if($j==$i-1)
							{
								$data['user'][$i] = $row->username;
								$data['auth'][$i] = $row->authdate;
								$i=$i+1;
								$j=$i+2;
							}
						}	
					}				
				}
			}
			else
			{
				$data['user'][0]="-";
				$data['auth'][0]="-";
			}
			
			if($data['group']=='Admin')
			{
				$this->load->view('loglast_view',$data);
			}
			else
				redirect('home', 'refresh');
			//----------------------------Tale-----------------------------------
			$this->load->view('endt_view', $data);
			
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	function usstat()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this -> session -> userdata('logged_in');
			$data = array(
				'username' => $session_data['username'],
				'group' => $session_data['group'],
				'status' => $session_data['status']
			);
			if(!($this->input->post('startdate')))
			{
				for($i=0;$i<24;$i++)
				{
					if($i<10)
						$time = '0'.$i;
					else
						$time = $i;
					$date = date('Y-m-d');
					$datetime = $date." ".$time;
					$result[$i]=$this->user->usagephr($datetime);
					$data['time'][0][$i]= $result[$i];
					$result2=$this->user->dataphr($datetime);
					$dtin=0;
					$dtout=0;
					$dt=0;
					if($result2)
					{
						foreach($result2 as $row)
						{
							$dtin=$dtin+$row->acctinputoctets;
							$dtout=$dtout+$row->acctoutputoctets;
						}
						$dt=((($dtin+$dtout)/1024)/1024)/1024;
						$dt = number_format($dt, 2, '.', ' ');
					}
					$data['data'][0][$i]=$dt;
				}
				$data['date'][0][0] = $date;
			}
			else
			{
				$date1=$this->input->post('startdate');
				$date2=$this->input->post('stopdate');
				$day1=strtotime($date1);
				$day2=strtotime($date2);
				if($day2==$day1)
				{
					for($i=0;$i<24;$i++)
					{
						if($i<10)
							$time = '0'.$i;
						else
							$time = $i;
						$datetime = $date1." ".$time;
						$result[$i]=$this->user->usagephr($datetime);
						$data['time'][0][$i]= $result[$i];
						$result2=$this->user->dataphr($datetime);
						$dtin=0;
						$dtout=0;
						$dt=0;
						if($result2)
						{
							foreach($result2 as $row)
							{
								$dtin=$dtin+$row->acctinputoctets;
								$dtout=$dtout+$row->acctoutputoctets;
							}
							$dt=((($dtin+$dtout)/1024)/1024)/1024;
							$dt = number_format($dt, 2, '.', ' ');
						}
						$data['data'][0][$i]=$dt;
					}
					$data['date'][0][0] = $date1;
				}
				else if($day2>$day1)
				{
					$day=($day2-$day1)/(60*60*24);
					for($j=0;$j<=$day;$j++)
					{
						$date=strtotime ( '+'.$j.' day' , $day1 );
						$newdate = date ( 'Y-m-j' , $date );
						for($i=0;$i<24;$i++)
						{
							if($i<10)
								$time = '0'.$i;
							else
								$time = $i;
							$datetime = $newdate." ".$time;
							$result[$i]=$this->user->usagephr($datetime);
							$data['time'][$j][$i]= $result[$i];
							$result2=$this->user->dataphr($datetime);
							$dtin=0;
							$dtout=0;
							$dt=0;
							if($result2)
							{
								foreach($result2 as $row)
								{
									$dtin=$dtin+$row->acctinputoctets;
									$dtout=$dtout+$row->acctoutputoctets;
								}
								$dt=((($dtin+$dtout)/1024)/1024)/1024;
								$dt = number_format($dt, 2, '.', ' ');
							}
							$data['data'][$j][$i]=$dt;
						}
						$data['date'][$j][0] = $newdate;
					}	
				}
				else
				{
					$day=($day1-$day2)/(60*60*24);
					for($j=0;$j<=$day;$j++)
					{
						$date=strtotime ( '+'.$j.' day' , $day2 ) ;
						$newdate = date ( 'Y-m-j' , $date );
						for($i=0;$i<24;$i++)
						{
							if($i<10)
								$time = '0'.$i;
							else
								$time = $i;
							$datetime = $newdate." ".$time;
							$result[$i]=$this->user->usagephr($datetime);
							$data['time'][$j][$i]= $result[$i];
							$result2=$this->user->dataphr($datetime);
							$dtin=0;
							$dtout=0;
							$dt=0;
							if($result2)
							{
								foreach($result2 as $row)
								{
									$dtin=$dtin+$row->acctinputoctets;
									$dtout=$dtout+$row->acctoutputoctets;
								}
								$dt=((($dtin+$dtout)/1024)/1024)/1024;
								$dt = number_format($dt, 2, '.', ' ');
							}
							$data['data'][$j][$i]=$dt;
						}
						$data['date'][$j][0] = $newdate;
					}	
				}
			}
			if($data['group']=='Admin')
				$this->load->view('stat_view',$data);			
			else
				redirect('home', 'refresh');
			//----------------------------Tale-----------------------------------
			$this->load->view('endt_view', $data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	function usstat2()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this -> session -> userdata('logged_in');
			$data = array(
				'username' => $session_data['username'],
				'group' => $session_data['group'],
				'status' => $session_data['status']
			);
			if(!($this->input->post('startdate')))
			{
				for($i=0;$i<24;$i++)
				{
					if($i<10)
						$time = '0'.$i;
					else
						$time = $i;
					$date = date('Y-m-d');
					$datetime = $date." ".$time;
					$result[$i]=$this->user->usagephr($datetime);
					$data['time'][0][$i]= $result[$i];
					$result2=$this->user->dataphr($datetime);
					$dtin=0;
					$dtout=0;
					$dt=0;
					if($result2)
					{
						foreach($result2 as $row)
						{
							$dtin=$dtin+$row->acctinputoctets;
							$dtout=$dtout+$row->acctoutputoctets;
						}
						$dt=((($dtin+$dtout)/1024)/1024)/1024;
						$dt = number_format($dt, 2, '.', ' ');
					}
					$data['data'][0][$i]=$dt;
				}
				$data['date'][0][0] = $date;
			}
			else
			{
				$date1=$this->input->post('startdate');
				$date2=$this->input->post('stopdate');
				$day1=strtotime($date1);
				$day2=strtotime($date2);
				if($day2==$day1)
				{
					for($i=0;$i<24;$i++)
					{
						if($i<10)
							$time = '0'.$i;
						else
							$time = $i;
						$datetime = $date1." ".$time;
						$result[$i]=$this->user->usagephr($datetime);
						$data['time'][0][$i]= $result[$i];
						$result2=$this->user->dataphr($datetime);
						$dtin=0;
						$dtout=0;
						$dt=0;
						if($result2)
						{
							foreach($result2 as $row)
							{
								$dtin=$dtin+$row->acctinputoctets;
								$dtout=$dtout+$row->acctoutputoctets;
							}
							$dt=((($dtin+$dtout)/1024)/1024)/1024;
							$dt = number_format($dt, 2, '.', ' ');
						}
						$data['data'][0][$i]=$dt;
					}
					$data['date'][0][0] = $date1;
				}
				else if($day2>$day1)
				{
					$day=($day2-$day1)/(60*60*24);
					for($j=0;$j<=$day;$j++)
					{
						$date=strtotime ( '+'.$j.' day' , $day1 );
						$newdate = date ( 'Y-m-j' , $date );
						for($i=0;$i<24;$i++)
						{
							if($i<10)
								$time = '0'.$i;
							else
								$time = $i;
							$datetime = $newdate." ".$time;
							$result[$i]=$this->user->usagephr($datetime);
							$data['time'][$j][$i]= $result[$i];
							$result2=$this->user->dataphr($datetime);
							$dtin=0;
							$dtout=0;
							$dt=0;
							if($result2)
							{
								foreach($result2 as $row)
								{
									$dtin=$dtin+$row->acctinputoctets;
									$dtout=$dtout+$row->acctoutputoctets;
								}
								$dt=((($dtin+$dtout)/1024)/1024)/1024;
								$dt = number_format($dt, 2, '.', ' ');
							}
							$data['data'][$j][$i]=$dt;
						}
						$data['date'][$j][0] = $newdate;
					}	
				}
				else
				{
					$day=($day1-$day2)/(60*60*24);
					for($j=0;$j<=$day;$j++)
					{
						$date=strtotime ( '+'.$j.' day' , $day2 ) ;
						$newdate = date ( 'Y-m-j' , $date );
						for($i=0;$i<24;$i++)
						{
							if($i<10)
								$time = '0'.$i;
							else
								$time = $i;
							$datetime = $newdate." ".$time;
							$result[$i]=$this->user->usagephr($datetime);
							$data['time'][$j][$i]= $result[$i];
							$result2=$this->user->dataphr($datetime);
							$dtin=0;
							$dtout=0;
							$dt=0;
							if($result2)
							{
								foreach($result2 as $row)
								{
									$dtin=$dtin+$row->acctinputoctets;
									$dtout=$dtout+$row->acctoutputoctets;
								}
								$dt=((($dtin+$dtout)/1024)/1024)/1024;
								$dt = number_format($dt, 2, '.', ' ');
							}
							$data['data'][$j][$i]=$dt;
						}
						$data['date'][$j][0] = $newdate;
					}	
				}
			}
			$data['statict'] = array(
					"00:00-00:59",
					"01:00-01:59",
					"02:00-02:59",
					"03:00-03:59",
					"04:00-04:59",
					"05:00-05:59",
					"06:00-06:59",
					"07:00-07:59",
					"08:00-08:59",
					"09:00-09:59",
					"10:00-10:59",
					"11:00-11:59",
					"12:00-12:59",
					"13:00-13:59",
					"14:00-14:59",
					"15:00-15:59",
					"16:00-16:59",
					"17:00-17:59",
					"18:00-18:59",
					"19:00-19:59",
					"20:00-20:59",
					"21:00-21:59",
					"22:00-22:59",
					"23:00-23:59");

			if($data['group']=='Admin')
				$this->load->view('stat2_view',$data);
			else
				redirect('home', 'refresh');
			//----------------------------Tale-----------------------------------
			$this->load->view('endt_view', $data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	function usstat3()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this -> session -> userdata('logged_in');
			$data = array(
				'username' => $session_data['username'],
				'group' => $session_data['group'],
				'status' => $session_data['status']
			);
			if(!($this->input->post('startdate')))
			{
				for($i=6;$i>=0;$i--)
				{
					$date = date('Y-m-d');
					$day1=strtotime($date);
					$date=strtotime ( '-'.$i.' day' , $day1 );
					$newdate = date ( 'Y-m-j' , $date );
					$result[$i]=$this->user->usagephr($newdate);
					$data['time'][$i]= $result[$i];
					$result2=$this->user->dataphr($newdate);
					$dtin=0;
					$dtout=0;
					$dt=0;
					if($result2)
					{
						foreach($result2 as $row)
						{
							$dtin=$dtin+$row->acctinputoctets;
							$dtout=$dtout+$row->acctoutputoctets;
						}
						$dt=((($dtin+$dtout)/1024)/1024)/1024;
						$dt = number_format($dt, 2, '.', ' ');
					}
					$data['data'][$i]=$dt;
					$data['date'][$i] = $newdate;
				}
				
			}
			else
			{
				$date1=$this->input->post('startdate');
				$date2=$this->input->post('stopdate');
				$day1=strtotime($date1);
				$day2=strtotime($date2);
				if($day2==$day1)
				{
					$result[0]=$this->user->usagephr($date1);
					$data['time'][0]= $result[0];
					$result2=$this->user->dataphr($date1);
					$dtin=0;
					$dtout=0;
					$dt=0;
					if($result2)
					{
						foreach($result2 as $row)
						{
							$dtin=$dtin+$row->acctinputoctets;
							$dtout=$dtout+$row->acctoutputoctets;
						}
						$dt=((($dtin+$dtout)/1024)/1024)/1024;
						$dt = number_format($dt, 2, '.', ' ');
					}
					$data['data'][0]=$dt;
					$data['date'][0]=$date1;
				}
				else if($day2>$day1)
				{
					$day=($day2-$day1)/(60*60*24);
					for($j=0;$j<=$day;$j++)
					{
						$date=strtotime ( '+'.$j.' day' , $day1 );
						$newdate = date ( 'Y-m-j' , $date );
						$result[$j]=$this->user->usagephr($newdate);
						$data['time'][$j]= $result[$j];
						$result2=$this->user->dataphr($newdate);
						$dtin=0;
						$dtout=0;
						$dt=0;
						if($result2)
						{
							foreach($result2 as $row)
							{
								$dtin=$dtin+$row->acctinputoctets;
								$dtout=$dtout+$row->acctoutputoctets;
							}
							$dt=((($dtin+$dtout)/1024)/1024)/1024;
							$dt = number_format($dt, 2, '.', ' ');
						}
						$data['data'][$j]=$dt;					
						$data['date'][$j] = $newdate;
					}	
				}
				else
				{
					$day=($day1-$day2)/(60*60*24);
					for($j=0;$j<=$day;$j++)
					{
						$date=strtotime ( '+'.$j.' day' , $day2 ) ;
						$newdate = date ( 'Y-m-j' , $date );
						$result[$j]=$this->user->usagephr($newdate);
						$data['time'][$j]= $result[$j];
						$result2=$this->user->dataphr($newdate);
						$dtin=0;
						$dtout=0;
						$dt=0;
						if($result2)
						{
							foreach($result2 as $row)
							{
								$dtin=$dtin+$row->acctinputoctets;
								$dtout=$dtout+$row->acctoutputoctets;
							}
							$dt=((($dtin+$dtout)/1024)/1024)/1024;
							$dt = number_format($dt, 2, '.', ' ');
						}
						$data['data'][$j]=$dt;
						$data['date'][$j]=$newdate;
					}	
				}
			}

			if($data['group']=='Admin')
				$this->load->view('stat3_view',$data);
			else
				redirect('home', 'refresh');
			//----------------------------Tale-----------------------------------
			$this->load->view('endt_view', $data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	function logout()
	{
		$this -> session -> unset_userdata('logged_in');
		session_destroy();
		redirect('home', 'refresh');
	}
}

?>