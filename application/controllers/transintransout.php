<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Home Class
 * @package  CGSI Portal
 */
class TransinTransout extends CI_Controller
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
		$this->load->model(['Inventory_model']);
		$this->load->model(['Cgsi_model']);
		$this->load->model(['transintransout_model']);

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
				'title' => 'TransIn '
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
			'toreceived' => $this->transintransout_model->toreceived(),
			'itemCount' => function($itemName) {
				$lCount = $this->Inventory_model->itemCount($itemName);
				foreach($lCount as $value) {
					return $value['qty'];
				}
			},
			'transmittalNumber'  => $this-> Inventory_model->TransNo(),
			'transmitted' => $this->Inventory_model->Transmitted(),
		

		];
		// print_r($this->Inventory_model->Transmitted());
		$this->load->view('template/header',$data);
		$this->load->view('transintransout', $data);
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
