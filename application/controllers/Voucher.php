<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Home Class
 * @package CGSI Portal
 */
class Voucher extends CI_Controller
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
		$this->load->model(['Voucher_model']);

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

		$status = '';
		if ($lastUriSegment == 'receivedvoucher') {
			if($sessionid == '300109'){
				$status = 'Approved';
				$title = 'Received';
				$statustag = 1;
			} else {
				$status = 'Pending';
				$title = 'Received';
				$statustag = 0;
			}
		} else if ($lastUriSegment == 'returnvoucher') {
			$status = 'Returned';
			$title = 'Returned';
			$statustag =2;
		} else if ($lastUriSegment == 'cancelVoucher') {
			$status = 'Cancelled';
			$title = 'Cancelled';
			$statustag = '';
		}

		if($sessionid == '300109'){
			$VoucherVisayas = $this->Voucher_model->getVoucher($sessionid,$status,'Vis',$statustag);
			$VoucherLuzon = $this->Voucher_model->getVoucher($sessionid,$status,'Luz',$statustag);

		} else {
			$VoucherVisayas = $this->Voucher_model->getVoucher($sessionid,$status,'Vis',$statustag);
			$VoucherLuzon = $this->Voucher_model->getVoucher($sessionid,$status,'Luz',$statustag);
		}

		$this->session->set_userdata('postatus', $lastUriSegment);


		$sessionid = $this->session->empid;
		$leaveList = $this->Leave_model->leaveList($sessionid);
		$sessUser = [
			'userID' => $sessionid,
			'department' => $this->session->department,
			'position_type' =>  $this->session->position_type,
			'designationID' =>  $this->session->designationID,
			'designationname' => $this->session->designationname
		];
		$leaveListDept = $this->Leave_model->leaveListDept($sessUser);
		
		$data = [
			'page' => [
				'title' => 'Voucher'
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
			'locstatus' => $this->session->postatus,
			'leaveCount' => function($statusID) {
				$lCount = $this->Leave_model->leaveCount($this->sessionid,$statusID);
				foreach($lCount as $value) {
					return $value['countLeave'];
				}
			},
			'department' => $this->Cgsi_model->getEmpDepartment(),
			'leaveList' => $leaveList,
			'leaveListDept' => $leaveListDept,
			'VoucherVisayas' => $VoucherVisayas,
			'VoucherLuzon' => $VoucherLuzon,


		];
		$this->load->view('template/header',$data);
		$this->load->view('voucher', $data);
		$this->load->view('template/footer');
	}

	public function voucherdetails($Voucher_Num)
	{

		$sessionid = $this->session->empid;

		$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

		$lastUriSegment = array_pop($uriSegments);

		if($sessionid == '300109'){
			$voucherdetails = $this->Voucher_model->voucherdetails($sessionid,$uriSegments[3],$lastUriSegment);
			$voucherdetails2 = $this->Voucher_model->voucherdetails2($sessionid,$uriSegments[3],$lastUriSegment);
			$voucherviewpodetails =$this->Voucher_model->voucherviewpodetails($sessionid,$uriSegments[3],$lastUriSegment);

		}
		else{
			$voucherdetails = $this->Voucher_model->voucherdetails($sessionid,$uriSegments[3],$lastUriSegment);

			$voucherdetails2 = $this->Voucher_model->voucherdetails2($sessionid,$uriSegments[3],$lastUriSegment);
			$voucherviewpodetails =$this->Voucher_model->voucherviewpodetails($sessionid,$uriSegments[3],$lastUriSegment);
			
		}

		$this->session->set_userdata('voucher_number', $Voucher_Num);
		$this->session->set_userdata('voucher_site', $lastUriSegment);

		$data = [
			'page' => [
				'title' => 'Voucher'
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
			'department' => $this->Cgsi_model->getEmpDepartment(),
			'voucherdetails' => $voucherdetails,
			'voucherdetails2' => $voucherdetails2,
			'voucherviewpodetails' =>$voucherviewpodetails,
			'locstatus' => $this->session->postatus,
			'lastUriSegment' => $lastUriSegment,
			'voucherno' => $Voucher_Num,
			'site' => $this->session->voucher_site,
			'viewpoitems' => function($ponumber) {	
			$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
			$lastUriSegment = array_pop($uriSegments);
			$pd = $this->Voucher_model->voucherpoitems($ponumber,$lastUriSegment);
				if(isset($pd)){
					$group = array();
					foreach($pd as $row){
						$group[$row['PO_Number']][] = $row;	
					}
					$table = '
					<style> 
						table, th, td {
							border-right: 1px solid black;
							border-collapse: collapse;
							border-left: 1px solid black;
							border-bottom: 1px solid black;
							font-family: calibri;
						}
						th {
							border-top:1px solid black;
							border-bottom: 1px solid black;
							text-align: center;
						}
						td{
							border-bottom: 0px solid black;
							padding: 15px;
							font-size: 14px;
						}
					</style>
					<table style="width:100%" id="tablepo" >
						<tr>
						<th> Qty </th>
						<th> Units </th>
						<th> Description</th>
						<th> Unit Cost </th>
						<th>Total Cost</th>
						</tr>
					';
					foreach ($group as $key =>  $g){
						foreach ($g as $pdi) {
								$table .='<tr>
										<td style="text-align:right;"> '.$pdi['ItemQty'].'</td> </td>
										<td> '.$pdi['ItemUnit'].' </td>  
										<td> '.$pdi['ItemDesc'].' </td>
										<td style="text-align:right;"> '.$pdi['ItemCost'].'</td>
										<td style="text-align:right;"> '.$pdi['Total_Cost'].'</td>
									</tr>';
						
						}

							return $table.'</table>';		
					}
				} else {
					return '<span style="color:red">not yet.</span>';
				}
		},
		'vouchervatsale' => function($ponumber) {
				$pd = $this->Voucher_model->vouchervatsale($ponumber);
				if(isset($pd)){

					$vatsale ='';

					foreach($pd as $row){
						if($row['Vatsale'] !=='0')
						{
							$vatsale .='<div class="col" style="text-align:right;font-weight: 700;margin-top: 15px;" >
								<span style="font-size: 12px;"> Vatable >>>>>>>></span> <br>
								<span style="font-size: 12px;"> Value Added Tax >>>>>>>></span> <br>
								<span style="font-size: 12px;">  Total Amount >>>>>>>></span> <br>
							</div>

							<div class="col-2" style="margin-top: 15px;">
								<span style="font-size: 14px;font-weight: 700;"> '.$row['Vatsale'].'   </span><br>
								<span style="font-size: 14px;font-weight: 700;"> '.$row['AddedTax'].'  </span><br>
								<span style="font-size: 14px;font-weight: 700;"> '.$row['TotalAmount'].'  </span><br>
							</div>
						';
							
						}			
						
					
					if($row['NonVAt'] !== '0')
					{
						
						$vatsale .='<div class="row">
							<div class="col-6" >
							</div>
							<div class="col" style="text-align:right;font-weight: 700;" >
								<span font-size: 12px;> NON-VATABLE >>>>>>>></span> <br>
								<span font-size: 12px;> TOTAL AMOUNT >>>>>>>></span> <br>
							</div>
							<div class="col" style="text-align:right;">
								<span style="font-size: 14px;font-weight: 700;"> '.$row['NonVAt'].'   </span><br>
								<span style="font-size: 14px;font-weight: 700;"> '.$row['TotalWNVAt'].'  </span><br>
							</div>
						</div>';
					}	
		} 
			return $vatsale;
		}
	}
		];
		$this->load->view('template/header',$data);
		$this->load->view('voucher/voucherdetails', $data);
		$this->load->view('template/footer');
	}

	public function voucherdetails2($Voucher_Num)
	{

		$sessionid = $this->session->empid;

		$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

		$lastUriSegment = array_pop($uriSegments);

		if($sessionid == '300109'){
			$voucherdetails = $this->Voucher_model->voucherdetails($sessionid,$uriSegments[3],$lastUriSegment);
			$voucherdetails2 = $this->Voucher_model->voucherdetails2($sessionid,$uriSegments[3],$lastUriSegment);
			$voucherviewpodetails =$this->Voucher_model->voucherviewpodetails($sessionid,$uriSegments[3],$lastUriSegment);

		}
		else{
			$voucherdetails = $this->Voucher_model->voucherdetails($sessionid,$uriSegments[3],$lastUriSegment);

			$voucherdetails2 = $this->Voucher_model->voucherdetails2($sessionid,$uriSegments[3],$lastUriSegment);
			$voucherviewpodetails =$this->Voucher_model->voucherviewpodetails($sessionid,$uriSegments[3],$lastUriSegment);
			
		}

		$this->session->set_userdata('voucher_number', $Voucher_Num);
		$this->session->set_userdata('voucher_site', $lastUriSegment);

		$data = [
			'page' => [
				'title' => 'Voucher'
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
			'department' => $this->Cgsi_model->getEmpDepartment(),
			'voucherdetails' => $voucherdetails,
			'voucherdetails2' => $voucherdetails2,
			'voucherviewpodetails' =>$voucherviewpodetails,
			'locstatus' => $this->session->postatus,
			'lastUriSegment' => $lastUriSegment,
			'voucherno' => $Voucher_Num,
			'site' => $this->session->voucher_site,
			'viewpoitems' => function($ponumber) {	
			$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
			$lastUriSegment = array_pop($uriSegments);
			$pd = $this->Voucher_model->voucherpoitems($ponumber,$lastUriSegment);
				if(isset($pd)){
					$group = array();
					foreach($pd as $row){
						$group[$row['PO_Number']][] = $row;	
					}
					$table = '
					<style> 
						table, th, td {
							border-right: 1px solid black;
							border-collapse: collapse;
							border-left: 1px solid black;
							border-bottom: 1px solid black;
							font-family: calibri;
						}
						th {
							border-top:1px solid black;
							border-bottom: 1px solid black;
							text-align: center;
						}
						td{
							border-bottom: 0px solid black;
							padding: 15px;
							font-size: 14px;
						}
					</style>
					<table style="width:100%" id="tablepo" >
						<tr>
						<th> Qty </th>
						<th> Units </th>
						<th> Description</th>
						<th> Unit Cost </th>
						<th>Total Cost</th>
						</tr>
					';
					foreach ($group as $key =>  $g){
						foreach ($g as $pdi) {
								$table .='<tr>
										<td style="text-align:right;"> '.$pdi['ItemQty'].'</td> </td>
										<td> '.$pdi['ItemUnit'].' </td>  
										<td> '.$pdi['ItemDesc'].' </td>
										<td style="text-align:right;"> '.$pdi['ItemCost'].'</td>
										<td style="text-align:right;"> '.$pdi['Total_Cost'].'</td>
									</tr>';
						
						}

							return $table.'</table>';		
					}
				} else {
					return '<span style="color:red">not yet.</span>';
				}
		},
		'vouchervatsale' => function($ponumber) {
				$pd = $this->Voucher_model->vouchervatsale($ponumber);
				if(isset($pd)){

					$vatsale ='';

					foreach($pd as $row){
						if($row['Vatsale'] !=='0')
						{
							$vatsale .='<div class="col" style="text-align:right;font-weight: 700;margin-top: 15px;" >
								<span style="font-size: 12px;"> Vatable >>>>>>>></span> <br>
								<span style="font-size: 12px;"> Value Added Tax >>>>>>>></span> <br>
								<span style="font-size: 12px;">  Total Amount >>>>>>>></span> <br>
							</div>

							<div class="col-2" style="margin-top: 15px;">
								<span style="font-size: 14px;font-weight: 700;"> '.$row['Vatsale'].'   </span><br>
								<span style="font-size: 14px;font-weight: 700;"> '.$row['AddedTax'].'  </span><br>
								<span style="font-size: 14px;font-weight: 700;"> '.$row['TotalAmount'].'  </span><br>
							</div>
						';
							
						}			
						
					
					if($row['NonVAt'] !== '0')
					{
						
						$vatsale .='<div class="row">
							<div class="col-6" >
							</div>
							<div class="col" style="text-align:right;font-weight: 700;" >
								<span font-size: 12px;> NON-VATABLE >>>>>>>></span> <br>
								<span font-size: 12px;> TOTAL AMOUNT >>>>>>>></span> <br>
							</div>
							<div class="col" style="text-align:right;">
								<span style="font-size: 14px;font-weight: 700;"> '.$row['NonVAt'].'   </span><br>
								<span style="font-size: 14px;font-weight: 700;"> '.$row['TotalWNVAt'].'  </span><br>
							</div>
						</div>';
					}	
		} 
			return $vatsale;
		}
	}
		];
		$this->load->view('template/header',$data);
		$this->load->view('voucher/voucherdetails2', $data);
		$this->load->view('template/footer');
	}

	public function voucherattachments()
	{
		$sessionid = $this->session->empid;
		$data = [
			'page' => [
				'title' => 'Voucher Attachments'
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
			'vouchernumber' => $this->session->voucher_number,
			'getpoattachments' => $this->Voucher_model->get_po_attachments($this->session->voucher_number,$this->session->voucher_site),
			'locstatus' => $this->session->postatus,
			'site' => $this->session->voucher_site
		];
		$this->load->view('template/header',$data);
		$this->load->view('voucher/voucherattachments', $data);
		$this->load->view('template/footer');
	}


	public function historyvoucher()
	{


		$sessionid = $this->session->empid;

		if($sessionid == '300109'){
			$VoucherVisayas_history= $this->Voucher_model->VoucherVisayas_history($sessionid);
			$VoucherLuzon_history = $this->Voucher_model->VoucherLuzon_history($sessionid);

		}
		else{
			$VoucherVisayas_history = $this->Voucher_model->VoucherVisayas_history($sessionid);
			$VoucherLuzon_history = $this->Voucher_model->VoucherLuzon_history($sessionid);
		}
		
		$data = [
			'page' => [
				'title' => 'History Voucher'
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
			'VoucherVisayas_history' => $VoucherVisayas_history,
			'VoucherLuzon_history' => $VoucherLuzon_history,
			
		];
		$this->load->view('template/header',$data);
		$this->load->view('voucher/historyvoucher', $data);
		$this->load->view('template/footer');
	}

	public function saveVoucherStatus() {
		$_POST['Vouch_StatusTag'] = ($this->session->empid == '300109')? '2': '1';
		$data = $this->Voucher_model->saveVoucherStatus($_POST);
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
