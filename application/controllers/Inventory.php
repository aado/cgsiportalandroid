<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Home Class
 *
 * @package     CGSI Portal
 */
class Inventory extends CI_Controller
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
		if($sessionid == '300390' || $sessionid == '300544' || $sessionid == '300591'){
			$ToBeTransmitted = $this-> Inventory_model->ToBeTransmitted($sessionid);
			$Inventory = $this-> Inventory_model->Inventory($sessionid);
			$EmployeeList = $this-> Inventory_model->EmployeeList($sessionid);
			$InventoryHistory = $this-> Inventory_model->InventoryHistory($sessionid);
			
		}

		if($sessionid == '300319' || $sessionid == '300544' || $sessionid == '300591'){
			$Inventory = $this-> Inventory_model->Inventory($sessionid);
			$EmployeeList = $this-> Inventory_model->EmployeeList($sessionid);
			$InventoryHistory = $this-> Inventory_model->InventoryHistory($sessionid);
		}

		else{
			//$ToBeTransmitted = $this-> Inventory_model->ToBeTransmitted($sessionid);
		}

		$Inventory = $this-> Inventory_model->Inventory($sessionid);
		$data = [
			'page' => [
				'title' => 'Inventory'
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
			'ToBeTransmitted' => $this-> Inventory_model->ToBeTransmitted($sessionid),
			// 'TransmittedItems' => $this-> Inventory_model->TransmittedItems($sessionid),
			'history' => $this-> Inventory_model->InventoryHistory($sessionid),
			'Inventory' => $this-> Inventory_model->Inventory($sessionid),
			'locstatus' => $this->session->inventorystatus,
			'EmployeeList' => $this-> Inventory_model->EmployeeList($sessionid),
			'itemCount' => function($itemName) {
				$lCount = $this->Inventory_model->itemCount($itemName);
				foreach($lCount as $value) {
					return $value['qty'];
				}
			},

			'transmittalNumber'  => $this-> Inventory_model->TransNo(),
			'transmitted' => $this->Inventory_model->Transmitted()

		];
		// print_r($this->Inventory_model->Transmitted());
		$this->load->view('template/header',$data);
		$this->load->view('Inventory', $data);
		$this->load->view('template/footer');
	}

	public function transmittal()
	{
		$sessionid = $this->session->empid;
		$sessUser = [
			'userID' => $sessionid,
			'department' => $this->session->department,
			'position_type' =>  $this->session->position_type,
			'designationID' =>  $this->session->designationID,
			'designationname' => $this->session->designationname
		];
		if($sessionid == '300390' || $sessionid == '300544' || $sessionid == '300591'){
			$ToBeTransmitted = $this-> Inventory_model->ToBeTransmitted($sessionid);
			$TransmittedItems = $this-> Inventory_model->transmitteditems($sessionid);
			$Pulloutitems = $this-> Inventory_model->Pulloutitems($sessionid);
			$Inventory = $this-> Inventory_model->Inventory($sessionid);
			$EmployeeList = $this-> Inventory_model->EmployeeList($sessionid);
			
		}

		if($sessionid == '300319' || $sessionid == '300544' || $sessionid == '300591'){
			$Inventory = $this-> Inventory_model->Inventory($sessionid);
			$EmployeeList = $this-> Inventory_model->EmployeeList($sessionid);
			
		}

		$this->session->set_userdata('locstatus', 'transmittal');

		$data = [
			'page' => [
				'title' => 'Transmittal'
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
			'ToBeTransmitted' => $this-> Inventory_model->ToBeTransmitted($sessionid),
			'TransmittedItems' => $this-> Inventory_model->TransmittedItems($sessionid),
			'Pulloutitems' => $this-> Inventory_model->Pulloutitems($sessionid),
			'Inventory' => $this-> Inventory_model->Inventory($sessionid),
			'transmittedNew' =>  $this-> Inventory_model->transmittedNew(),
			'EmployeeList' => $this-> Inventory_model->EmployeeList($sessionid),
			'itemCount' => function($itemName) {
				$lCount = $this->Inventory_model->itemCount($itemName);
				foreach($lCount as $value) {
					return $value['qty'];
				}
			},
			'getEmployee' => function($empid) {
				$employee = $this->Inventory_model->getEmployee($empid);
				$employee_name = '';
				foreach($employee as $emp) {
					$employee_name .= '<img width="40" class="rounded-circle" src="'.site_url('public/img/idpicture/'.$emp['emp_id'].'.jpg').'" /><b style="font-size: 14px; color: #fff; margin-left: 6px">'.$emp['firstname'].' '.$emp['middlename'].' '.$emp['lastname'].'</b>
							<span style="font-size: 11px; color: #fff">'.$emp['designationname'].'</span>';
				}
				return $employee_name;
			},
			'transmittalNumber'  => $this-> Inventory_model->TransNo(),
			'transmitted' => $this->Inventory_model->Transmitted(),
			'deliveredby'  => $this-> Inventory_model->deliveredby(),
			'history' => $this-> Inventory_model->InventoryHistory($sessionid),
			'lastPulloutNo' => $this-> Inventory_model->PullOutNo(),

		];

		$this->load->view('template/header',$data);
		$this->load->view('inventory/transmittal', $data);
		$this->load->view('template/footer');
	}

	public function addItems() {
		$success = $this->Inventory_model->addTransmittedItems($_POST);
		header("Location: ".base_url()."transmittal", TRUE, 301);
	}

	public function savePullout() {
		$_POST['prep_by'] = $this->session->empid;
		$savePullout = $this->Inventory_model->savePullOutItems($_POST);
		print_r($_POST);
		if($savePullout) {
			$this->session->set_userdata('add_message', true);
			header("Location: ".base_url()."pullout", TRUE, 301);
		}
	}

	public function InventoryHistory()
	{
		$sessionid = $this->session->empid;
		$sessUser = [
			'userID' => $sessionid,
			'department' => $this->session->department,
			'position_type' =>  $this->session->position_type,
			'designationID' =>  $this->session->designationID,
			'designationname' => $this->session->designationname
		];
		if($sessionid == '300390' || $sessionid == '300544' || $sessionid == '300591' ){
			$ToBeTransmitted = $this-> Inventory_model->ToBeTransmitted($sessionid);
			$TransmittedItems = $this-> Inventory_model->transmitteditems($sessionid);
			$Pulloutitems = $this-> Inventory_model->Pulloutitems($sessionid);
			$Inventory = $this-> Inventory_model->Inventory($sessionid);
			$EmployeeList = $this-> Inventory_model->EmployeeList($sessionid);
			
			
		}

		if($sessionid == '300319' || $sessionid == '300544' || $sessionid == '300591'){
			$Inventory = $this-> Inventory_model->Inventory($sessionid);
			$EmployeeList = $this-> Inventory_model->EmployeeList($sessionid);
			$InventoryHistory = $this-> Inventory_model->InventoryHistory($sessionid);
		}

		else{
			//$ToBeTransmitted = $this-> Inventory_model->ToBeTransmitted($sessionid);
		}

		//$Invhistory = $this-> Inventory_model->InventoryHistory();

		$data = [
			'page' => [
				'title' => 'History'
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
			'ToBeTransmitted' => $this-> Inventory_model->ToBeTransmitted($sessionid),
			'TransmittedItems' => $this-> Inventory_model->TransmittedItems($sessionid),
			'Pulloutitems' => $this-> Inventory_model->Pulloutitems($sessionid),
			'Inventory' => $this-> Inventory_model->Inventory($sessionid),
			'locstatus' => $this->session->inventorystatus,
			'InventoryHistory' => $this-> Inventory_model->InventoryHistory($sessionid),
			'EmployeeList' => $this-> Inventory_model->EmployeeList($sessionid),
			'itemCount' => function($itemName) {
				$lCount = $this->Inventory_model->itemCount($itemName);
				foreach($lCount as $value) {
					return $value['qty'];
				}
			},
			'transmittalNumber'  => $this-> Inventory_model->TransNo(),
			'transmitted' => $this->Inventory_model->Transmitted(),
			'deliveredby'  => $this-> Inventory_model->deliveredby(),

		];
		$this->load->view('template/header',$data);
		$this->load->view('inventory/transmittal', $data);
		$this->load->view('template/footer');
	}

	public function pullout()
	{
		$sessionid = $this->session->empid;
		$sessUser = [
			'userID' => $sessionid,
			'department' => $this->session->department,
			'position_type' =>  $this->session->position_type,
			'designationID' =>  $this->session->designationID,
			'designationname' => $this->session->designationname
		];
		if($sessionid == '300390' || $sessionid == '300544' || $sessionid == '300591' ){
			$ToBeTransmitted = $this-> Inventory_model->ToBeTransmitted($sessionid);
			$TransmittedItems = $this-> Inventory_model->transmitteditems($sessionid);
			$Pulloutitems = $this-> Inventory_model->Pulloutitems($sessionid);
			$Inventory = $this-> Inventory_model->Inventory($sessionid);
			$EmployeeList = $this-> Inventory_model->EmployeeList($sessionid);
			
		}

		$data = [
			'page' => [
				'title' => 'Pullout'
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
			'ToBeTransmitted' => $this-> Inventory_model->ToBeTransmitted($sessionid),
			'TransmittedItems' => $this-> Inventory_model->TransmittedItems($sessionid),
			'Pulloutitems' => $this-> Inventory_model->Pulloutitems($sessionid),
			'Inventory' => $this-> Inventory_model->Inventory($sessionid),
			'locstatus' => $this->session->inventorystatus,
			'EmployeeList' => $this-> Inventory_model->EmployeeList($sessionid),
			'itemCount' => function($itemName) {
				$lCount = $this->Inventory_model->itemCount($itemName);
				foreach($lCount as $value) {
					return $value['qty'];
				}
			},
			'transmittalNumber'  => $this-> Inventory_model->TransNo(),
			'lastPulloutNo' => $this-> Inventory_model->PullOutNo(),
			'transmitted' => $this->Inventory_model->Transmitted(),
			'deliveredby'  => $this-> Inventory_model->deliveredby(),
			'departmentlist' => $this-> Inventory_model->departmentlist(),
			'PulloutHistory' => $this-> Inventory_model->PulloutHistory($sessionid),


		];
		$this->load->view('template/header',$data);
		$this->load->view('inventory/pullout', $data);
		$this->load->view('template/footer');
	}

	public function inventories()
	{
		$sessionid = $this->session->empid;
		$sessUser = [
			'userID' => $sessionid,
			'department' => $this->session->department,
			'position_type' =>  $this->session->position_type,
			'designationID' =>  $this->session->designationID,
			'designationname' => $this->session->designationname
		];
			$equipments = '';
			$Officesupplies = '';
		 	$chemicals ='';
		 	$uniforms = '';
		 	$cleaningsupp = '';

		if($sessionid == '300319' || $sessionid == '300544' || $sessionid == '300591'){
		 	$Officesupplies = $this-> Inventory_model->Officesupplies($sessionid);
		 	$chemicals = $this-> Inventory_model->chemicals($sessionid);
		 	$uniforms = $this-> Inventory_model->uniforms($sessionid);
		 	$cleaningsupp = $this-> Inventory_model->cleaningsupp($sessionid);
			$EmployeeList = $this-> Inventory_model->EmployeeList($sessionid);
			
	 	}
	 	if($sessionid == '300390' || $sessionid == '300368' || $sessionid == '300146') 
	 	{
	 		$equipments = $this-> Inventory_model->equipments($sessionid);
	 	}

		// else{
		// 	//$ToBeTransmitted = $this-> Inventory_model->ToBeTransmitted($sessionid);
		// }

		$data = [
			'page' => [
				'title' => 'Inventory'
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
			'ToBeTransmitted' => $this-> Inventory_model->ToBeTransmitted($sessionid),
			'TransmittedItems' => $this-> Inventory_model->TransmittedItems($sessionid),
			'Pulloutitems' => $this-> Inventory_model->Pulloutitems($sessionid),
			'Officesupplies' => $Officesupplies,
			'chemicals' => $chemicals,
			'uniforms' => $uniforms,
			'cleaningsupp' => $cleaningsupp,
			'equipment' => $equipments,
			'Inventory' => $this-> Inventory_model->Inventory($sessionid),
			'locstatus' => $this->session->inventorystatus,
			'EmployeeList' => $this-> Inventory_model->EmployeeList($sessionid),
			'itemCount' => function($itemName) {
				$lCount = $this->Inventory_model->itemCount($itemName);
				foreach($lCount as $value) {
					return $value['qty'];
				}
			},
				'itemCountbyName' => function($itemName) {
				// $lCount = $this->Inventory_model->itemCount($itemName);
					$lCount = $this-> Inventory_model->itemCountbyName($itemName,2);
				foreach($lCount as $value) {
					return $value['totalitems'];

				}
				return false;
				// return $itemName;

			},
			'transmittalNumber'  => $this-> Inventory_model->TransNo(),
			'transmitted' => $this->Inventory_model->Transmitted(),

		];
		$this->load->view('template/header',$data);
		$this->load->view('inventory/Inventories', $data);
		$this->load->view('template/footer');
	}
	

	public function inventorylist($itemName,$lastUriSegment){
		

		$sessionid = $this->session->empid;

		$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

		$lastUriSegment = array_pop($uriSegments);
		
			$sessUser = [
			'userID' => $sessionid,
			'department' => $this->session->department,
			'position_type' =>  $this->session->position_type,
			'designationID' =>  $this->session->designationID,
			'designationname' => $this->session->designationname
		];
		 if($sessionid == '300390' || $sessionid == '300544' || $sessionid == '300591'){
			$inventorylist = $this-> Inventory_model->inventorylist($itemName,$lastUriSegment);
		}
		 else{
			$inventorylist = $this-> Inventory_model->inventorylist($itemName,$lastUriSegment);
		 }
		$data = [
			'page' => [
				'title' => 'Inventory'
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
			'ToBeTransmitted' => $this-> Inventory_model->ToBeTransmitted($sessionid),
			'locstatus' => 'inventories',
			'itemCount' => function($itemName) {
				$lCount = $this->Inventory_model->itemCount($itemName);
				foreach($lCount as $value) {
					return $value['qty'];
				}
			},
			'EmployeeList' => $this-> Inventory_model->EmployeeList($sessionid),
			'transmittalNumber'  => $this-> Inventory_model->TransNo(),
			'deliveredby'  => $this-> Inventory_model->deliveredby(),
			'brands'  => $this-> Inventory_model->brands(),
			'inventorylist' => $inventorylist,

		];
		$this->load->view('template/header',$data);
		$this->load->view('Inventory/inventorylist', $data);
		$this->load->view('template/footer');
	}
	
	public function inventorydetails($itemName){

		$sessionid = $this->session->empid;
		// 	$sessUser = [
		// 	'userID' => $sessionid,
		// 	'department' => $this->session->department,
		// 	'position_type' =>  $this->session->position_type,
		// 	'designationID' =>  $this->session->designationID,
		// 	'designationname' => $this->session->designationname
		// ];
		// if($sessionid == '300390'){
			//  $ToBeTransmitted = $this-> Inventory_model->ToBeTransmitted($sessionid);
			$inventorydetails = $this-> Inventory_model->inventorydetails($itemName);
			
		// }
		// else{
			// $ToBeTransmitted = $this-> Inventory_model->ToBeTransmitted($sessionid);
		// }

		$data = [
			'page' => [
				'title' => 'Inventory'
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
			// 'ToBeTransmitted' => $this-> Inventory_model->ToBeTransmitted($sessionid),
			'locstatus' => $this->session->locstatus,
			'itemCount' => function($itemName) {
				$lCount = $this->Inventory_model->itemCount($itemName);
				foreach($lCount as $value) {
					return $value['qty'];
				}
			},
			'totalItemCount' => function($itemName) {
				$lCount = $this->Inventory_model->totalItemCount($itemName);
				foreach($lCount as $value) {
					return $value['TOTALQTY'];
				}
			},
			'getEmpName' => function($id) {
				$lCount = $this->Inventory_model->getEmpName($id);
				foreach($lCount as $value) {
					return $value['Name'];
				}
			},
			'EmployeeList' => $this-> Inventory_model->EmployeeList($sessionid),
			'transmittalNumber'  => $this-> Inventory_model->TransNo(),
			'deliveredby'  => $this-> Inventory_model->deliveredby(),
			'inventorydetails' => $inventorydetails,
			'brands'  => $this-> Inventory_model->brands(),
		];
		$this->load->view('template/header',$data);
		$this->load->view('Inventory/inventorydetails', $data);
		$this->load->view('template/footer');
	}

	public function pulloutdetails($itemName){
		//print_r($itemName);

		$sessionid = $this->session->empid;
			$sessUser = [
			'userID' => $sessionid,
			'department' => $this->session->department,
			'position_type' =>  $this->session->position_type,
			'designationID' =>  $this->session->designationID,
			'designationname' => $this->session->designationname
		];
		if($sessionid == '300390' || $sessionid == '300544' || $sessionid == '300591'){
			$ToBeTransmitted = $this-> Inventory_model->ToBeTransmitted($sessionid);
			$inventorydetails = $this-> Inventory_model->inventorydetails($itemName);
		}
		else{
			//$ToBeTransmitted = $this-> Inventory_model->ToBeTransmitted($sessionid);
		}

		$data = [
			'page' => [
				'title' => 'Inventory'
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
			'ToBeTransmitted' => $this-> Inventory_model->ToBeTransmitted($sessionid),
			'itemCount' => function($itemName) {
				$lCount = $this->Inventory_model->itemCount($itemName);
				foreach($lCount as $value) {
					return $value['qty'];
				}
			},
			'inventorydetails' => $this-> Inventory_model->inventorydetails($itemName),

		];
		$this->load->view('template/header',$data);
		$this->load->view('Inventory/inventorydetails', $data);
		$this->load->view('template/footer');
	}


	public function InventoryRecipient($itemName){
		//print_r($itemName);

		$sessionid = $this->session->empid;
			$sessUser = [
			'userID' => $sessionid,
			'department' => $this->session->department,
			'position_type' =>  $this->session->position_type,
			'designationID' =>  $this->session->designationID,
			'designationname' => $this->session->designationname
		];
		if($sessionid == '300390' || $sessionid == '300544' || $sessionid == '300591'){
			//$ToBeTransmitted = $this-> Inventory_model->ToBeTransmitted($sessionid);
			$InventoryRecipient = $this-> Inventory_model->InventoryRecipient($itemName);
		}
		else{
			//$ToBeTransmitted = $this-> Inventory_model->ToBeTransmitted($sessionid);
		}

		$data = [
			'page' => [
				'title' => 'Inventory'
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
			'ToBeTransmitted' => $this-> Inventory_model->ToBeTransmitted($sessionid),
			'itemCount' => function($itemName) {
				$lCount = $this->Inventory_model->itemCount($itemName);
				foreach($lCount as $value) {
					return $value['qty'];
				}
			},
			'InventoryRecipient' => $this-> Inventory_model->InventoryRecipient($itemName),

		];
		$this->load->view('template/header',$data);
		$this->load->view('Inventory', $data);
		$this->load->view('template/footer');
	}

	public function saveTransmitall() {
		$data = $this->Inventory_model->saveTransmitall($_POST);
		if ($data) {
			echo json_encode(array('success'=> true));
		}
	}

	public function saveReceiptInfo() {
		$data = $this->Inventory_model->saveReceiptInfo($_POST);
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
