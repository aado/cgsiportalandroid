<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Home Class
 * @package     CGSI Portal
 */
class RTAInactive extends CI_Controller
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

		

		// Check session
		$this->checkSession();

		// Get user data from resource by session
		$this->_user = $this->Users_model->getUserByField([
			'username' => $this->session->username
		], true);
	}

	/**
	 * Default for this controller.
	 *
	 * @return void
	 */

	public function index()
	{
		// print_r($this->Cgsi_model->getDataForRTAInactive());
		$data = [
			'page' => [
				'title' => 'RTA(InActive)'
			],
			'username' => $this->session->username,
			'user' => $this->Cgsi_model->getUserInMasterlist(),
			'tortain' => $this->Cgsi_model->getDataForRTAInactive(),
		];
		$this->load->view('template/header',$data);
		$this->load->view('rtainactive', $data);
		$this->load->view('template/footer');
	}

	public function getContactInfo() {
		//get info data from applicant table
		$applicantID = $_GET['applicant_ID'];
		$data = $this->Cgsi_model->getContactInfo($applicantID);
		echo json_encode($data);
	}

	public function updateInfo() {
		//update info data from applicant table
		$data = $this->Cgsi_model->updateInfo($_POST);
		if($data) {
			if($_POST['update_cat'] == 'info') {
				$msg = 'Employee Information updated successfully.';
			} else {
				$msg = 'Status updated successfully.';
			}
			echo json_encode(array('success'=>$data, 'message' => $msg));
		}
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
