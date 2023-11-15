<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Home Class
 * @package     CGSI Portal
 */
class Profile extends CI_Controller
{
	/**
	 * User data
	 * 
	 * @var object
	 */
	private $_user;

	/**
	 * Construct functions
	 * 
	 * @return void
	 */

	 
	public $CI = NULL;

	public function __construct()
	{
		// Load the parent construct
		parent::__construct();

		// Load the libraries
		$this->load->library(['session']);

		// Load the helpers
		$this->load->helper(['url']);

		// Load the models
		$this->load->model(['Users_model']);
		$this->load->model(['PO_model']);
		$this->load->model(['Leave_model']);
		$this->load->model(['Cgsi_model']);
		$this->load->model(['Profile_model']);

		$this->CI = & get_instance();

		// Check session
		$this->checkSession();

		// Get user data from resource by session
		$this->_user = $this->Users_model->getUserByField([
			'username' => $this->session->username
		], true);

		$this->sessionid = $this->session->empid;


	}


	/**
	 * Default for this controller.
	 *
	 * @return void
	 */

	public function index()
	{
		$sessionid = $this->session->empid;

		$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

		$lastUriSegment = array_pop($uriSegments);

		$getuserDetails = $this->Profile_model->getuserDetails($sessionid);

		// print_r($getuserDetails);
		
		$data = [
			'page' => [
				'title' => 'Profile'
			],
			'username' => $this->session->username,
			'posi_type' => $this->session->position_type,
			'deep_type' => $this->session->department,
			'departmentname' => $this->session->departmentname,
			'designationID' => $this->session->designationID,
			'idnumber' => $sessionid,
			'fullname' => $this->session->fullname,
			'designation' => $this->session->designationname,
			'department' => $this->Cgsi_model->getEmpDepartment(),
			'getuserDetails' =>$getuserDetails,
			'pass_tag' => $this->session->pass_tag
		
		];
		$this->load->view('template/header',$data);
		$this->load->view('profile', $data);
		$this->load->view('template/footer');
	}

	public function getuserDetails()
	{
		$sessionid = $this->session->empid;

		$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

		$lastUriSegment = array_pop($uriSegments);

		$getuserDetails = $this->Profile_model->getuserDetails($sessionid);

		print_r($getuserDetails);
		
		$data = [
			'page' => [
				'title' => 'Profile'
			],
			'username' => $this->session->username,
			'posi_type' => $this->session->position_type,
			'deep_type' => $this->session->department,
			'departmentname' => $this->session->departmentname,
			'designationID' => $this->session->designationID,
			'idnumber' => $sessionid,
			'fullname' => $this->session->fullname,
			'designation' => $this->session->designationname,
			'department' => $this->Cgsi_model->getEmpDepartment(),
			'getuserDetails' =>$getuserDetails,

		
		];
		$this->load->view('template/header',$data);
		$this->load->view('profile', $data);
		$this->load->view('template/footer');

	}

	public function saveChangePassword() {
		$data = $this->Profile_model->saveChangePassword($_POST);
		if ($data) {
			return true;
		}
	}

	
	// Check Session
	private function checkSession()
	{
		if (!$this->session->has_userdata('username')) {
			redirect('login');
			die;
		}
	}
}
