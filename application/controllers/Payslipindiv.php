<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Twilio\Rest\Client;


// $twilio = new Client($sid, $token);

/**
 * Home Class
 *
 * @package     CodeIgniter Simple Login
 * @subpackage  Controllers
 * @category    Home
 */
class Payslipindiv extends CI_Controller
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
		$this->load->library('email');

		// Load the models
		$this->load->model(['Users_model']);
		$this->load->model(['Cgsi_model']);
		$this->load->model(['Leave_model']);
		$this->load->model(['Payslip_model']);

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
		$leaveList = $this->Leave_model->leaveList($sessionid);
		$sessUser = [
			'userID' => $sessionid,
			'department' => $this->session->department,
			'position_type' =>  $this->session->position_type,
			'designationID' =>  $this->session->designationID,
			'designationname' => $this->session->designationname
		];
		
		$data = [
			'page' => [
				'title' => 'Payslip'
			],
			'username' => $this->session->username,
			'posi_type' => $this->session->position_type,
			'deep_type' => $this->session->department,
			'departmentname' => $this->session->departmentname,
			'designationID' => $this->session->designationID,
			'idnumber' => $sessionid,
			'email' => $this->session->email,
			'fullname' => $this->session->fullname,
			'designation' => $this->session->designationname,
			'leaveinfo' => $this->Leave_model->leaveInfo($sessionid),
			'leavetypes' => $this->Leave_model->getLeaveType(),
			'department' => $this->Cgsi_model->getEmpDepartment(),
			'payslipList' => $this->Payslip_model->payslipList(),
			'verified' => $this->Payslip_model->checkIfVerified($sessionid)
		];
		$this->load->view('template/header',$data);
		$this->load->view('payslipindiv', $data);
		$this->load->view('template/footer');
	}

	public function viewPayslip() {
		$payslipID = $_GET['payslip_id'];
		$data = $this->Payslip_model->viewPayslip($payslipID);
		echo json_encode($data[0]);
	}

	public function approvedRejectLeave() {
		//get info data from applicant table
		$applicantID = $_GET['applicant_ID'];
		$data = $this->Cgsi_model->getApplicImage($applicantID);
		echo json_encode($data);
	}

	public function savePayslip() {
		$data = $this->Payslip_model->savePayslip($_POST);
		if ($data) {
			echo json_encode(array('success'=> true));
		}
	}

	public function checkVerify() {
		$data = $this->Payslip_model->checkVerification($_POST);
		if ($data) {
			echo json_encode(array('success'=> true));
		}
	}

	public function sendVerifCode() {
		$data = $this->Payslip_model->saveVerification($_POST);
		if ($data) {
			echo json_encode(array('success'=> true));
		}
	}

	public function removePayslip() {
		$data = $this->Payslip_model->removePayslip($_POST);
		if ($data) {
			echo json_encode(array('success'=> true));
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
