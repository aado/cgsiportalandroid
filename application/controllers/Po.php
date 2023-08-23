<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*Zniv
 */
class Po extends CI_Controller
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

		$this->CI = & get_instance();

		// Check session
		$this->checkSession();

		// Get user data from resource by session
		$this->_user = $this->Users_model->getUserByField([
			'username' => $this->session->username
		], true);

		$this->sessionid = $this->session->empid;


	}

	public function index()
	{
		$sessionid = $this->session->empid;

		$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

		$lastUriSegment = array_pop($uriSegments);

		$status = '';
		if ($lastUriSegment == 'recievedpo') {
			if($sessionid == '300591'){
				$status = 'Approved';
				$title = 'Recieved';
				$statustag = 1;
			} else {
				$status = 'Pending';
				$title = 'Recieved';
				$statustag = 0;
			}
		} else if ($lastUriSegment == 'returnpo') {
			$status = 'Returned';
			$title = 'Returned';
			if($sessionid == '300591'){
				$statustag = 1;
			} else {
				$statustag = 2;
			}
		} else if ($lastUriSegment == 'cancellpo') {
			$status = 'Cancelled';
			$title = 'Cancelled';
			$statustag = '';
		}

		if($sessionid == '300591'){
			$POVisayas = $this->PO_model->getPO($sessionid,$status,'Vis','1');
			$POLuzon = $this->PO_model->getPO($sessionid,$status,'Luz','1');
		} else {
			if ($lastUriSegment == 'returnpo') {
				$POVisayas = $this->PO_model->getPO($sessionid,$status,'Vis','2');
				$POLuzon = $this->PO_model->getPO($sessionid,$status,'Luz','2');
			} else {
				$POVisayas = $this->PO_model->getPO($sessionid,$status,'Vis','0');
				$POLuzon = $this->PO_model->getPO($sessionid,$status,'Luz','0');
			}
		}

		$this->session->set_userdata('postatus', $lastUriSegment);
		
		$data = [
			'page' => [
				'title' => $title.' PO'
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
			'POVisayas' => $POVisayas,
			'POLuzon' => $POLuzon,
			'getEntryDate' => function($ponumber,$site) {
				$EntryDate = $this->PO_model->getEntryDate($ponumber,$site);
				foreach($EntryDate as $value) {
					return $value['Entry'];
				}
			},
			'getRemarks' => function($ponumber,$site,$postatus) {
				$EntryDate = $this->PO_model->getRemarks($ponumber,$site,$postatus);
				foreach($EntryDate as $value) {
					return $value['PO_Remarks'];
				}
			},
			'status' => $status,
			'lasturl' => $lastUriSegment
		];
		$this->load->view('template/header',$data);
		$this->load->view('po', $data);
		$this->load->view('template/footer');
	}

	public function historypo()
	{
		$sessionid = $this->session->empid;

		if($sessionid == '300591'){
			$POHistory_Visayas = $this->PO_model->POHistory_Visayas($sessionid);
			$POHistory_Luzon = $this->PO_model->POHistory_Luzon($sessionid);

		}
		else{
			$POHistory_Visayas = $this->PO_model->POHistory_Visayas($sessionid);
			$POHistory_Luzon = $this->PO_model->POHistory_Luzon($sessionid);
		}
		
		$data = [
			'page' => [
				'title' => 'History PO'
			],
			'username' => $this->session->username,
			'posi_type' => $this->session->position_type,
			'deep_type' => $this->session->department,
			'departmentname' => $this->session->departmentname,
			'designationID' => $this->session->designationID,
			'idnumber' => $sessionid,
			'fullname' => $this->session->fullname,
			'designation' => $this->session->designationname,
			'leaveinfo' => $this->Leave_model->leaveInfo($sessionid),
			'leavetypes' => $this->Leave_model->getLeaveType(),
			'leaveCount' => function($statusID) {
				$lCount = $this->Leave_model->leaveCount($this->sessionid,$statusID);
				foreach($lCount as $value) {
					return $value['countLeave'];
				}
			},
			'department' => $this->Cgsi_model->getEmpDepartment(),
			'POHistory_Visayas' => $POHistory_Visayas,
			'POHistory_Luzon' => $POHistory_Luzon,
			
		];
		$this->load->view('template/header',$data);
		$this->load->view('po/historypo', $data);
		$this->load->view('template/footer');
	}

	public function podetails($ponumber)
	{
		$sessionid = $this->session->empid;

		$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

			$lastUriSegment = array_pop($uriSegments);

		if($sessionid == '300591'){
			$getPODetails = $this->PO_model->getPODetails($sessionid,$uriSegments[3],$uriSegments[4]);
		} else {
			$getPODetails = $this->PO_model->getPODetails($sessionid,$uriSegments[3],$uriSegments[4]);
			$poItems = $this->PO_model->getPOItems($sessionid,$uriSegments[3],$uriSegments[4]);
		}

		$this->session->set_userdata('po_number', $ponumber);
		
		$data = [
			'page' => [
				'title' => 'PO Details'
			],
			'username' => $this->session->username,
			'posi_type' => $this->session->position_type,
			'deep_type' => $this->session->department,
			'departmentname' => $this->session->departmentname,
			'designationID' => $this->session->designationID,
			'idnumber' => $sessionid,
			'fullname' => $this->session->fullname,
			'designation' => $this->session->designationname,
			'leaveinfo' => $this->Leave_model->leaveInfo($sessionid),
			'leavetypes' => $this->Leave_model->getLeaveType(),
			'leaveCount' => function($statusID) {
				$lCount = $this->Leave_model->leaveCount($this->sessionid,$statusID);
				foreach($lCount as $value) {
					return $value['countLeave'];
				}
			},
			'department' => $this->Cgsi_model->getEmpDepartment(),
			'getPODetails' => $getPODetails,
			'getPOItems' => $poItems,
			'locstatus' => $this->session->postatus
		];
		$this->load->view('template/header',$data);
		$this->load->view('po/podetails', $data);
		$this->load->view('template/footer');
	}

	public function poattachments()
	{
		$sessionid = $this->session->empid;
		$data = [
			'page' => [
				'title' => 'PO Attachments'
			],
			'username' => $this->session->username,
			'posi_type' => $this->session->position_type,
			'deep_type' => $this->session->department,
			'departmentname' => $this->session->departmentname,
			'designationID' => $this->session->designationID,
			'idnumber' => $sessionid,
			'fullname' => $this->session->fullname,
			'designation' => $this->session->designationname,
			'leaveinfo' => $this->Leave_model->leaveInfo($sessionid),
			'leavetypes' => $this->Leave_model->getLeaveType(),
			'leaveCount' => function($statusID) {
				$lCount = $this->Leave_model->leaveCount($this->sessionid,$statusID);
				foreach($lCount as $value) {
					return $value['countLeave'];
				}
			},
			'department' => $this->Cgsi_model->getEmpDepartment(),
			'ponumber' => $this->session->po_number,
			'locstatus' => $this->session->postatus
		];
		$this->load->view('template/header',$data);
		$this->load->view('po/poattachments', $data);
		$this->load->view('template/footer');
	}

	public function savePOStatus() {
		$_POST['PO_StatusTag'] = ($this->session->empid == '300591')? '2': '1';
		$data = $this->PO_model->savePOStatus($_POST);
		if ($data) {
			echo json_encode(array('success'=> true));
		}
	}

	public function getPODetails() {
		$sessionid = $this->session->empid;
		if($sessionid == '300591'){
			$poItems = $this->PO_model->getPOItems($sessionid,$_POST['ponumber'],$_POST['site']);
		} else {
			$poItems = $this->PO_model->getPOItems($sessionid,$_POST['ponumber'],$_POST['site']);
		}
		if ($poItems) {
			echo json_encode(array('success'=> true, 'data' => $poItems));
		}
	}

	public function getPOInfo()
	{
		$sessionid = $this->session->empid;
		if($sessionid == '300591'){
			$getPODetails = $this->PO_model->getPODetails($sessionid,$_POST['ponumber'],$_POST['site']);
		} else {
			$getPODetails = $this->PO_model->getPODetails($sessionid,$_POST['ponumber'],$_POST['site']);
		}
		if ($getPODetails) {
			echo json_encode(array('success'=> true, 'data' => $getPODetails, 'site' => $_POST['site']));
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
