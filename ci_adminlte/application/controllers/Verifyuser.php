<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyUser extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user','',TRUE);
	}

	function index()
	{
		//This method will have the credentials validation
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'username', 'trim|required');
		$this->form_validation->set_rules('txtPassword', 'password', 'trim|required|matches[RePassword]|callback_up_database');
		$this->form_validation->set_rules('RePassword', 'repassword', 'trim|required');

		if($this->form_validation->run() == FALSE)
		{
			//Field validation failed.  User redirected to login page
			redirect('home/logout','refresh');
		}
		else
		{
			//Go to private area
			redirect('home/logout', 'refresh');
		}

	}

	function up_database($password)
	{
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('username');

		//query the database
		$result = $this->user->updatedata($username, $password);


		if($result)
			return true;
		else
			return false;
	}
}
?>