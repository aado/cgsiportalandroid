<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Home Class
 * @package     CGSI Portal
 */
class Timekeeping extends CI_Controller
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

		// print_r($leaveListDept);
		
		$data = [
			'page' => [
				'title' => 'Timekeeping'
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
			'leaveList' => $leaveList,
			'leaveListDept' => $leaveListDept,
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
								$rejectReason = '<span style="font-size: 11px;margin-left: 45px;">REASON: '.$prov['reject_reason'].'</span>';
							} else {
								$color = 'blue';
							}
							$approvers .= '<img width="40" class="rounded-circle" src="'.site_url('public/img/idpicture/'.$prov['approver_emp_id'].'.jpg').'" />
							<b style="font-size: 14px;">'.$prov['firstname'].' '.$prov['lastname'].'</b>
							<span style="display: block;margin-left: 45px;font-size: 11px;">'.$prov['designationname'].'&nbsp;|&nbsp;<span style="color: '.$color.'; font-weight: bold">'.$prov['leave_remarks'].' </span>&nbsp;|&nbsp; '.$prov['date_created'].'</span>
							'.$rejectReason.'';
						}
						return $approvers;
					}

				} else {
					return '<span style="color:red">not yet.</span>';
				}
				
			},
			'approvedDenied' => function($leaveid) {
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
								$approvers = '<span style="display: block"><button type="button" class="btn btn-primary btn-sm" style="margin-bottom: 2px" data-toggle="modal" data-target="#approvedDenied" onclick="confirmLeave(1,'.$leaveid.')"><i class="fa fa-check">Approved</i> </button> <button type="button" class="btn btn-danger btn-sm" onclick="confirmLeave(2,'.$leaveid.')" data-toggle="modal" data-target="#approvedDenied" ><i class="fa fa-times"> Reject</i> </button></span>';
							}
						}
						return $approvers.'<div class="modal fade" id="approvedDenied" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-sm" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Confirm Leave ?</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-12">
									 Are you sure you want to <span id="lblConfirm"></span> this leave.
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</div>
					</div>';
					}

				} else {
					return '<span style="display: block"><button type="button" class="btn btn-primary btn-sm" style="margin-bottom: 2px" data-toggle="modal" data-target="#approvedDenied" onclick="confirmLeave(1,'.$leaveid.')"><i class="fa fa-check">Approved</i> </button> <button type="button" class="btn btn-danger btn-sm" onclick="confirmLeave(2,'.$leaveid.')" data-toggle="modal" data-target="#approvedDenied" ><i class="fa fa-times"> Reject</i> </button></span>';
				}
			}
		];
		$this->load->view('template/header',$data);
		$this->load->view('timekeeping', $data);
		$this->load->view('template/footer');
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
		$data = $this->Leave_model->saveLeave($_POST);
		if ($data) {
			echo json_encode(array('success'=> true));
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
