<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Home Class
 *
 * @package     CGSI Portal
 * @subpackage  Controllers
 */
class Leave extends CI_Controller
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
		$leaveListDept = $this->Leave_model->leaveListDept($sessUser);
		$leaveListDeptAll = $this->Leave_model->leaveListDeptAll($sessUser);
		$data = [
			'page' => [
				'title' => 'Leave'
			],
			'username' => $this->session->username,
			'posi_type' => $this->session->position_type,
			'deep_type' => $this->session->department,
			'departmentname' => $this->session->departmentname,
			'designationID' => $this->session->designationID,
			'idnumber' => $sessionid,
			'birthdate' => $this->session->birthdate,
			'fullname' => html_entity_decode(htmlentities($this->session->fullname)),
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
			'leaveList' => $leaveList,
			'leaveCreditList' => $this->Leave_model->leaveInfoList($sessionid,$sessUser['position_type'],$sessUser['department'],$sessUser['designationID']),
			'leaveListDept' => $leaveListDept,
			'leaveListDeptAll' => $leaveListDeptAll,
			'approverList' => function($leaveid) {	
				$approver = $this->Leave_model->getApprover($leaveid);
				if ($approver) {

					foreach($approver as $value)
					{
						$group[$value['emp_leave_id']][] = $value;
					}
					foreach($group as $key => $prover) {
						$approvers = '';
						$rejectReason = '';
						foreach ($prover as $prov) {
							if ($prov['leave_remarks'] == 'Rejected') {
								$color = 'red';
								$rejectReason = '<div style="font-size: 11px;margin-left: 45px; text-align: left"><b>REASON:</b> '.$prov['reject_reason'].'</div>';
							} else {
								$color = 'blue';
							}
							$approvers .= '<img width="40" class="rounded-circle" src="'.site_url('public/img/idpicture/'.$prov['approver_emp_id'].'.jpg').'" />
							<b style="font-size: 14px; position: absolute">'.$prov['firstname'].' '.$prov['lastname'].'</b>
							<span style="display: block;margin-left: 45px;font-size: 11px;">'.$prov['designationname'].'&nbsp;|&nbsp;<span style="color: '.$color.'; font-weight: bold">'.$prov['leave_remarks'].' </span>&nbsp;|&nbsp; '.$prov['date_created'].'</span>
							'.$rejectReason.'';
						}
						return '<span style="display:block">'.$approvers.'</span>';
					}

				} else {
					return '<span style="color:red">not yet.</span>';
				}
				
			},
			'approvedDenied' => function($leaveid, $empid, $desigid, $designame, $templeave, $applic_type) {
				$approver = $this->Leave_model->getApprover($leaveid);
				if ($approver) {

					foreach($approver as $value)
					{
						$group[$value['emp_leave_id']][] = $value;
					}
					foreach($group as $key => $prover) {
						$approvers = '';
						foreach ($prover as $prov) {
							if ($prov['approver_emp_id'] == $this->session->empid && $prov['emp_leave_id'] == $leaveid) {
								$approvers = '';
							} else {
								$approvers = '<span style="display: block"><button type="button" id="confirmLeave'.$leaveid.'" class="btn btn-primary btn-sm" style="margin-bottom: 2px" data-toggle="modal" data-target="#confirmStatus" onclick="confirmLeave(1,'.$leaveid.','.$empid.','.$templeave.','.$applic_type.')"><i class="fa fa-check">Approved</i> </button> <button type="button" class="btn btn-danger btn-sm" id="confirmLeave'.$leaveid.'" onclick="confirmLeave(2,'.$leaveid.','.$empid.','.$templeave.','.$applic_type.')" data-toggle="modal" data-target="#confirmStatus" ><i class="fa fa-times"> Reject</i> </button></span>';
							}
						}
						return $approvers;
					}

				} else {
					return '<span style="display: block"><button type="button"  id="confirmLeave'.$leaveid.'" class="btn btn-primary btn-sm" style="margin-bottom: 2px" data-toggle="modal" data-target="#confirmStatus" onclick="confirmLeave(1,'.$leaveid.','.$empid.','.$templeave.','.$applic_type.')"><i class="fa fa-check">Approved</i> </button> <button type="button" class="btn btn-danger btn-sm" id="confirmLeave'.$leaveid.'" onclick="confirmLeave(2,'.$leaveid.','.$empid.','.$templeave.','.$applic_type.')" data-toggle="modal" data-target="#confirmStatus" ><i class="fa fa-times"> Reject</i> </button></span>';
				}
			},
			'creditAdditional' => function($datehired) {
				$dH = strtotime($datehired);
				$yrnow = date('Y');
				$year = date("Y", $dH);
				if ($year != 0000) {
					$totyear = $yrnow - $year;
				} else {
					$totyear = 0;
				}
				if ($totyear == 1) {
					// return $totyear .' - 5';
					return 0;
				} else if ($totyear == 2) {
					// return $totyear .' - 8';
					return 0;
				} else if ($totyear >= 3) {
					$leave_add = $totyear - 3;
					if ($leave_add > 15) {
						return 7;
					} else {
						return $totyear - 3;
					}
				}
			},
			'leaveTotal' => function($datehired) {
				$dH = strtotime($datehired);
				$yrnow = date('Y');
				$year = date("Y", $dH);
				if ($year != 0000) {
					$totyear = $yrnow - $year;
				} else {
					$totyear = 0;
				}
				if ($totyear == 1) {
					return 5;
				} else if ($totyear == 2) {
					return 8;
				} else if ($totyear >= 3) {
					$leave_add = $totyear - 3;
					$totalLeave = ($leave_add + 8);
					if ($totalLeave > 15) {
						return 15;
						// return $totyear .' - 8 - 15';
					} else {
						return $totalLeave;
					}
				}
			},
			'leaveLeft' => function($datehired, $used) {
				$dH = strtotime($datehired);
				$yrnow = date('Y');
				$year = date("Y", $dH);
				if ($year != 0000) {
					$totyear = $yrnow - $year;
				} else {
					$totyear = 0;
				}
				if ($totyear == 1) {
					return 5;
				} else if ($totyear == 2) {
					return 8;
				} else if ($totyear >= 3) {
					$leave_add = $totyear - 3;
					$totalLeave = ($leave_add + 8);
					if ($totalLeave > 15) {
						return 15 - $used;
					} else {
						return $totalLeave - $used;
					}
				}
			},
		];
		$this->load->view('template/header',$data);
		$this->load->view('leave', $data);
		$this->load->view('template/footer');
	}


	public function holiday()
	{
		$sessionid = $this->session->empid;
		$data = [
			'page' => [
				'title' => 'Leave'
			],
			'username' => $this->session->username,
			'posi_type' => $this->session->position_type,
			'deep_type' => $this->session->department,
			'departmentname' => $this->session->departmentname,
			'designationID' => $this->session->designationID,
			'idnumber' => $sessionid,
			'birthdate' => $this->session->birthdate,
			'fullname' => html_entity_decode(htmlentities($this->session->fullname)),
			'designation' => $this->session->designationname,
			'department' => $this->Cgsi_model->getEmpDepartment(),
			'holiday' => $this->Leave_model->getHoliday()
		];
		$this->load->view('template/header',$data);
		$this->load->view('Leave/holiday', $data);
		$this->load->view('template/footer');
	}

	public function leavetype()
	{
		$sessionid = $this->session->empid;
		$data = [
			'page' => [
				'title' => 'Leave'
			],
			'username' => $this->session->username,
			'posi_type' => $this->session->position_type,
			'deep_type' => $this->session->department,
			'departmentname' => $this->session->departmentname,
			'designationID' => $this->session->designationID,
			'idnumber' => $sessionid,
			'birthdate' => $this->session->birthdate,
			'fullname' => html_entity_decode(htmlentities($this->session->fullname)),
			'designation' => $this->session->designationname,
			'department' => $this->Cgsi_model->getEmpDepartment()
		];
		$this->load->view('template/header',$data);
		$this->load->view('Leave/leavetypes', $data);
		$this->load->view('template/footer');
	}

	function compareByName($a, $b) {
		return strcmp($a["name"], $b["name"]);
	}

	public function getApprover($leavid) {
		return $leavid;
    }

	public function getContactInfo() {
		//get info data from applicant table
		$applicantID = $_GET['applicant_ID'];
		$data = $this->Cgsi_model->getContactInfo($applicantID);
		echo json_encode($data);
	}

	public function approvedRejectLeave() {
		//get info data from applicant table
		$applicantID = $_GET['applicant_ID'];
		$data = $this->Cgsi_model->getApplicImage($applicantID);
		echo json_encode($data);
	}

	public function saveLeaveUndertime() {
		if(isset($_FILES['file'])) {
			$_POST['image_name'] = strtotime(date("Y-m-d H:i:s")).$_FILES['file']['name'];
			$data = $_POST;
		} else {
			$data = $_POST;
		}
		$data = $this->Leave_model->saveLeave($_POST);
		if ($data) {
			if(isset($_FILES['file'])) {
				if ( 0 < $_FILES['file']['error'] ) {
					echo 'Error: ' . $_FILES['file']['error'] . '<br>';
				}
				else {
					if (!file_exists("uploads/leave_images/".$_POST['emp_id'])) {
						mkdir("uploads/leave_images/".$_POST['emp_id'], 0777, true);
					}
					move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/leave_images/'.$_POST['emp_id'].'/' .strtotime(date("Y-m-d H:i:s")).$_FILES['file']['name']);
				}
			}
			echo json_encode($data);
		}
	}

	public function saveLeaveSubmit() {
		$_POST['position_type'] = $this->session->position_type;
		$_POST['department'] = $this->session->department;
		$_POST['userID'] = $this->session->empid;
		$_POST['deep_type'] = $this->session->department;
		$data = $this->Leave_model->saveLeaveSubmit($_POST);
		if ($data) {
			echo $data;
		}
	}

	public function removeLeave() {
		$data = $this->Leave_model->removeLeave($_POST);
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
