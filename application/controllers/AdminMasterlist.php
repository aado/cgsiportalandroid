<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Home Class
 * @package     CGSI Portal
 * @subpackage  Controllers
 */
class AdminMasterlist extends CI_Controller
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
		$this->load->model(['Cgsi_model']);
		$this->load->model(['Leave_model']);
		$this->load->model(['Memo_model']);
		$this->load->model(['AdminMasterlist_model']);

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
		$sessUser = [
			'userID' => $sessionid,
			'department' => $this->session->department,
			'position_type' =>  $this->session->position_type,
			'designationID' =>  $this->session->designationID,
			'designationname' => $this->session->designationname
		];
		$data = [
			'page' => [
				'title' => 'Masterlist'
			],
			'username' => $this->session->username,
			'posi_type' => $this->session->position_type,
			'deep_type' => $this->session->department,
			'departmentname' => $this->session->departmentname,
			'designationID' => $this->session->designationID,
			'idnumber' => $sessionid,
			'department' => $this->session->department,
			'fullname' => $this->session->fullname,
			'designation' => $this->session->designationname,
			'department' => $this->Cgsi_model->getEmpDepartment(),
			'AdminList' => $this->AdminMasterlist_model->AdminInfoList($sessionid,$sessUser['position_type'],$sessUser['department'],$sessUser['designationID']),
			
		];
		$this->load->view('template/header',$data);
		$this->load->view('adminmasterlist', $data);
		$this->load->view('template/footer');
	}

	



	/**
	 * Check Session
	 * 
	 * @return void
	 */
	private function checkSession()
	{
		if (!$this->session->has_userdata('username')) {
			redirect('login');
			die;
		}
	}
}
