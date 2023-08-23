<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Home Class
 * @package     CGSI Portal
 * @subpackage  Controllers
 */
class Memo extends CI_Controller
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
		$data = [
			'page' => [
				'title' => 'Memo'
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
			'memotype' => $this->Memo_model->memotype(),
			'memoList' => $this->Memo_model->memoList($this->session->designationID),
			'addMemo' => function() {
				if ($this->session->empid == '300261' || $this->session->empid == '300369') {
					return '<p style="position: absolute;right: 2%;top: 10%;">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMemoModal"><i class="fa fa-plus"></i> Add New Memo</button>
					</p>';
				}
			},
			'viewMemoCnt' => function($memoid) {
				$memoCnt = $this->Memo_model->getViewCount($memoid);
				if ($memoCnt) {
					$countView = '';
					foreach($memoCnt as $value)
					{
						$countView .= $value['memViewCnt'];
					}
				}
				return $countView;
			},
			'approverList' => function($memoid) {	
				$approver = $this->Memo_model->getApprover($memoid);
				if ($approver) {

					foreach($approver as $value)
					{
						$group[$value['memo_id']][] = $value;
					}
					foreach($group as $key => $prover) {
						$approvers = '';
						foreach ($prover as $prov) {
							$approvers .= '<img width="40" class="rounded-circle" src="'.site_url('public/img/idpicture/'.$prov['approver_empid'].'.jpg').'" />
							<b style="font-size: 14px;">'.$prov['firstname'].' '.$prov['lastname'].'</b>
							<span style="display: block;margin-left: 45px;font-size: 11px;">'.$prov['created'].'</span>';
							if ($prov['memo_status'] == 1) {
								$approvers .= '<span style="font-size: 10px;float: left;text-align: justify;margin-left: 45px;font-weight: bold;color: blue;">'.$prov['memo_remarks'].'</span><br/>';
							} else {
								$approvers .= '<span style="font-size: 10px;float: left;text-align: justify;margin-left: 45px;font-weight: bold;color: red;">Rejected</span>';
							}
							if ($prov['memo_status'] == 2) {
								$approvers .= '<span style="font-size: 10px;float: left;text-align: justify;margin-left: 45px;">Rejected: '.$prov['reject_reason'].'</span>';
							}
						}
						return $approvers;
					}

				} else {
					return '<span style="color:red">not yet.</span>';
				}
				
			},
			'departmentSeener' => function() {	
				$approver = $this->Memo_model->getAllMemoViewer();
				if ($approver) {

					foreach($approver as $value)
					{
						$group[$value['memo_id']][] = $value;
					}
					foreach($group as $key => $prover) {
						return $prover;
					}

				} else {
					return '<span style="color:red">not yet.</span>';
				}
				
			}
		];
		$this->load->view('template/header',$data);
		$this->load->view('memo', $data);
		$this->load->view('template/footer');
	}

	// All memo viewer
	public function getAllMemoViewerById() {
		$memoid = $_GET['memoid'];
		$typeid = $_GET['memotype'];
		
		if($this->session->empid == '300146') {
			if ($typeid == 2) {
				$data1 = $this->Memo_model->getAllMemoViewerById($memoid, $this->session->empid, $typeid);
				$empid = array();
				foreach($data1 as $dta) {
					$empid[] = $dta['emp_id'];
				}
				$data2 = $this->Memo_model->getAllMemoContri($empid);
				$data = array_merge($data1, $data2);
			} else {
				$data = $this->Memo_model->getAllMemoViewerById($memoid, $this->session->empid, $typeid);
			}
		} else {
			$data = $this->Memo_model->getAllMemoViewerById($memoid, $this->session->empid, $typeid);
			$empid = array();
			foreach($data as $dta) {
				$empid[] = $dta['emp_id'];	
			}
		}
		echo json_encode(array('data' =>$data));
	}

	// Submit status approve/cancel memo
	public function saveMemoSubmit() {
		// print_r($_POST);
		$_POST['position_type'] = $this->session->position_type;
		$_POST['department'] = $this->session->department;
		$_POST['userID'] = $this->session->empid;
		$_POST['deep_type'] = $this->session->department;
		$data = $this->Memo_model->saveMemoSubmit($_POST);
		if ($data) {
			echo $data;
		}
	}

	// Save memo
	public function saveMemo() {
		$data = $this->Memo_model->saveMemo($_POST);
		if ($data) {
			echo json_encode(array('success'=> true));
		}
	}

	public function addContriAmt() {
		$_POST['emp_id'] = $this->session->empid;
		$data = $this->Memo_model->addAmtContri($_POST);
		if ($data) {
			echo json_encode(array('success'=> true));
		}
	}

	public function viewMemo() {
		$_POST['emp_id'] = $this->session->empid;
		$_POST['department'] = $this->session->department;
		$data = $this->Memo_model->viewMemo($_POST);
		if ($data) {
			echo json_encode(array('success'=> true, 'data' => $data[0]));
		}
	}

	public function removeMemo() {
		$data = $this->Memo_model->removeMemo($_POST);
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
