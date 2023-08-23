<?php
defined('BASEPATH') or exit('No direct script access allowed');

// $sid = "ACXXXXXX"; // Your Account SID from https://console.twilio.com
// $token = "YYYYYY"; // Your Auth Token from https://console.twilio.com

use Twilio\Rest\Client;

/**
 * Users Model Class
 *
 * @package     CGSI Portal
 * @subpackage  Models
 * @category    Leave model
 * @author      Zniv Zdiv <vinzadz1987@gmail.com>
 */
class Leave_model extends CI_Model
{
    /**
     * The table used in this model
     * 
     * @var array
     */
    // private $_table = [
    //     'CGSI_Users_Web'
    // ];

	// private $db;

    /**
     * Construct functions
     * 
     * @return void
     */
    public function __construct()
    {
        // Load the parent construct
        parent::__construct();

        // Load the database libraries
        $this->emsdb = $this->load->database('emsdb', true);

    }

    /**
     * Get user by specific data
     * 
     * @param array $data
     * @param bool  $first Get only the first data
     * @param object
     */

	protected function sendSMS($data) {
	// Your Account SID and Auth Token from twilio.com/console
		$sid = 'AC85de4e4a421de7b5e0161a697c367f01';
		$token = '27ca11cc3607c866b17c55e0f8b43a19';
		$client = new Client($sid, $token);
		
		// Use the client to do fun stuff like send text messages!
		return $client->messages->create(
			// the number you'd like to send the message to
			$data['phone'],
			array(
				// A Twilio phone number you purchased at twilio.com/console
				// "from" => "CGSI",
				// the body of the text message you'd like to send
				'body' => $data['text'],
				"messagingServiceSid" => "MGdd19e363e6634579a5f71e15788653a0"
			)
		);
	}

	public function leaveList($userid) {
		$sql = "SELECT 
			empL.*, u.firstname, u.lastname, lt.name leave_type_name,tdep.departmentid, tdep.departmentname,tdesig.designationID,  tdesig.designationname,
			lstat.status_name lstat_leave_status, u.contact_number, u.address, u.total_leave_credit, u.leave_used, u.leave_left
		FROM emp_leave empL 
		LEFT JOIN users u 
			ON empL.emp_id = u.emp_id 
			LEFT JOIN leave_types lt
			ON empL.leave_type = lt.type_id
			LEFT JOIN tbl_designation tdesig
			ON u.emp_designation = tdesig.designationID
			LEFT JOIN tbl_department tdep 
			ON tdesig.department = tdep.departmentid
			LEFT JOIN tbl_leave_status lstat
			ON empL.leave_status = lstat.id
		WHERE u.emp_id = '$userid' ORDER BY empL.date_created ASC";
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	// Leave list per head
	public function leaveListDept($data) {
		$desig = $data['position_type'];
		$dept = $data['department'];

		$designame4 = explode(" ", $data["designationname"])[0];

		$leave_status_q = '';

		if ($desig == 1) { // Intermediate Head
			$designame = explode(" ", $data["designationname"])[1];
			if ($dept == 1) { // MIS Department
				$leave_status_q = 'WHERE empL.appr_inter_head IN(0,2,3) AND empL.appr_dept_head IN(0,2,3) AND u.emp_status NOT IN (3) AND u.emp_department="'.$dept.'"';
			} else if ($dept == 2 || $dept == 5){ //Recruitment Department
				if ($data['designationID'] == 61) {
				$leave_status_q = 'WHERE empL.appr_inter_head IN(0,2,3) AND tdesig.position_type NOT IN(4) AND u.emp_status NOT IN (3) AND u.emp_department="'.$dept.'" AND u.area = 4';
				} else {
					$leave_status_q = 'WHERE empL.appr_inter_head IN(0,2,3) AND tdesig.position_type NOT IN(4) AND u.emp_status NOT IN (3) AND tdesig.designationID NOT IN (61) AND u.emp_department="'.$dept.'"';	
				}
			} else if ($dept == 14 ){ //Recruitment Department
				$leave_status_q = 'WHERE empL.appr_inter_head IN(0,2,3) AND tdesig.position_type NOT IN(4) AND u.emp_department="'.$dept.'" AND tdesig.designationID NOT IN (26) AND u.emp_status NOT IN (3) AND tdesig.designationname LIKE "%'.explode(" ", $data["designationname"])[0].'%"';
			} else {
				$leave_status_q = 'WHERE empL.appr_inter_head IN(0,2,3) AND tdesig.position_type NOT IN(4) AND u.emp_department="'.$dept.'" AND tdesig.designationID NOT IN (26) AND u.emp_status NOT IN (3) AND empL.emp_id NOT IN (300581) AND tdesig.designationname LIKE "%'.$designame.'%"';
			}
		} else if($desig == 2) { // HR Manager
			$leave_status_q = 'WHERE empL.appr_inter_head = "2" AND empL.appr_dept_head = "2" AND empL.appr_hr_manager IN(0,2,3) AND tdesig.designationID NOT IN (17)';	
		} else if($desig == 3) { // PRESIDENT
			$leave_status_q = 'WHERE empL.appr_inter_head = "2" AND empL.appr_dept_head = "2" AND empL.appr_hr_manager = "2" AND empL.appr_president IN(0,2,3) AND empL.appr_hr_manager != 0';
		} else if ($desig == 4) { // HR Head
			if ($dept == 6) {
				if ($data['designationID'] == 12) {
					$leave_status_q = 'WHERE empL.appr_inter_head = "2" AND empL.appr_dept_head IN(0,2,3) AND tdesig.designationID NOT IN (17,26,13) AND u.emp_department="'.$dept.'"';
				} else {
					$leave_status_q = 'WHERE empL.appr_inter_head = "2" AND empL.appr_dept_head IN(0,2,3) AND tdesig.designationID NOT IN (17,12,26) AND u.emp_department="'.$dept.'"';
				}
			} else if($dept == 14 || $dept == 9) {
				$leave_status_q = 'WHERE empL.appr_inter_head = "2" AND empL.appr_dept_head IN(0,2,3) AND tdesig.designationID NOT IN (17) AND u.emp_department IN (9,14)';
			} else {
				$leave_status_q = 'WHERE empL.appr_inter_head = "2" AND empL.appr_dept_head IN(0,2,3) AND tdesig.designationID NOT IN (17) AND u.emp_department="'.$dept.'"';
			}
		} 

		$sql = "SELECT 
			empL.*, u.firstname, u.lastname, lt.name leave_type_name,tdep.departmentid, tdep.departmentname,tdesig.designationID,  tdesig.designationname,tdesig.position_type,
			lstat.status_name lstat_leave_status, u.contact_number, u.address, u.total_leave_credit, u.leave_used, u.leave_left, u.emp_department, u.emp_status
		FROM emp_leave empL 
		LEFT JOIN users u 
			ON empL.emp_id = u.emp_id 
		LEFT JOIN leave_types lt
			ON empL.leave_type = lt.type_id
		LEFT JOIN tbl_designation tdesig
			ON u.emp_designation = tdesig.designationID
		LEFT JOIN tbl_department tdep 
			ON tdesig.department = tdep.departmentid
		LEFT JOIN tbl_leave_status lstat
			ON empL.leave_status = lstat.id
			".$leave_status_q."";
			// ORDER BY empL.leave_status DESC
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	// Leave list all approved
	public function leaveListDeptAll($data) {
		$desig = $data['position_type'];
		$dept = $data['department'];

		$leave_status_q = 'WHERE empL.leave_status = 2';

		$sql = "SELECT 
			empL.*, u.firstname, u.lastname, lt.name leave_type_name,tdep.departmentid, tdep.departmentname,tdesig.designationID,  tdesig.designationname,tdesig.position_type,
			lstat.status_name lstat_leave_status, u.contact_number, u.address, u.total_leave_credit, u.leave_used, u.leave_left, u.emp_department, u.emp_status
		FROM emp_leave empL 
		LEFT JOIN users u 
			ON empL.emp_id = u.emp_id 
		LEFT JOIN leave_types lt
			ON empL.leave_type = lt.type_id
		LEFT JOIN tbl_designation tdesig
			ON u.emp_designation = tdesig.designationID
		LEFT JOIN tbl_department tdep 
			ON tdesig.department = tdep.departmentid
		LEFT JOIN tbl_leave_status lstat
			ON empL.leave_status = lstat.id
			".$leave_status_q." ORDER BY empL.date_created ASC";
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function getApprover($leaveid) {
		$sql = "SELECT tla.*,u.firstname, u.lastname, tls.*, td.departmentname, tdesig.designationname FROM 
			tbl_leave_approver tla 
		LEFT JOIN users u 
			ON tla.approver_emp_id = u.emp_id
		LEFT JOIN tbl_leave_status tls
			ON tla.leave_status = tls.id
		LEFT JOIN tbl_department td
			ON u.emp_department = td.departmentid
		LEFT JOIN tbl_designation tdesig
			ON u.emp_designation = tdesig.designationID
		WHERE tla.emp_leave_id ='$leaveid' ORDER BY tla.date_created ASC"; 
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	// Leave Info
	public function leaveInfo($userid) {
		$sql = 'SELECT total_leave_credit, leave_used, leave_left, leave_additional FROM users WHERE emp_id = '.$userid;
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	// Holiday
	public function getHoliday() {
		$sql = "SELECT * FROM tbl_holiday";
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	// Leave credit list
	public function leaveInfoList($id,$type,$dept,$desigid) {
		$where = '';
		if ($type == 1) {
			if ($desigid == 6) { // Billing section
				$where = 'WHERE users.emp_department = "'.$dept.'" and tdesig.position_type IN(0,1) and emp_designation != 26 and emp_designation IN(5,6)';
			} else if ($desigid == 59) { // Collection Section
				$where = 'WHERE users.emp_department = "'.$dept.'" and tdesig.position_type IN(0,1) and emp_designation != 26 and emp_designation IN(47,59)';
			} else {
				if ($desigid !== '44') {
					$where = 'WHERE users.emp_department = "'.$dept.'" and tdesig.position_type IN(0,1) and emp_designation != 26';
				}
			}
		} else if ($type == 4) {
			if ($desigid !== '44') {
				$where = 'WHERE users.emp_department = "'.$dept.'" and tdesig.position_type IN(0,1,4) and emp_designation != 26';
			}
		} else {
			$where = 'WHERE users.emp_id ='.$id.'';
		}
		$sql = "SELECT users.*, td.departmentname, tdesig.designationname
			FROM users
		LEFT JOIN tbl_department td
			ON users.emp_department = td.departmentid 
		LEFT JOIN tbl_designation tdesig
			ON users.emp_designation = tdesig.designationID ".$where."";
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	// Leave Count
	public function leaveCount($userid,$leavestatus) {
		if($leavestatus == 0) {
			$sql = "SELECT COUNT(empL.emp_id) AS countLeave, lstat.status_name lstat_leave_status
			FROM emp_leave empL 
			LEFT JOIN users u 
				ON empL.emp_id = u.emp_id 
				LEFT JOIN leave_types lt
				ON empL.leave_type = lt.type_id
				LEFT JOIN tbl_designation tdesig
				ON u.emp_designation = tdesig.designationID
				LEFT JOIN tbl_department tdep 
				ON tdesig.department = tdep.departmentid
				LEFT JOIN tbl_leave_status lstat
				ON empL.leave_status = lstat.id
			WHERE u.emp_id = '$userid' ORDER BY empL.date_created DESC";
		} else {
			$sql = "SELECT COUNT(empL.emp_id) AS countLeave, lstat.status_name lstat_leave_status
			FROM emp_leave empL 
			LEFT JOIN users u 
				ON empL.emp_id = u.emp_id 
				LEFT JOIN leave_types lt
				ON empL.leave_type = lt.type_id
				LEFT JOIN tbl_designation tdesig
				ON u.emp_designation = tdesig.designationID
				LEFT JOIN tbl_department tdep 
				ON tdesig.department = tdep.departmentid
				LEFT JOIN tbl_leave_status lstat
				ON empL.leave_status = lstat.id
			WHERE u.emp_id = '$userid' AND leave_status = '$leavestatus' ORDER BY empL.date_created DESC";
		}
		
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	// Leave Types
	public function getLeaveType(){
		$this->emsdb->select("*"); 
		$this->emsdb->from("leave_types");
		$this->emsdb->where_not_in("type_id",[7,11]);
		$query = $this->emsdb->get();
		return $query->result_array();
	}

	// Leave Types
	public function getImageAttachment($id){
		// print_r($id);
		$this->emsdb->select("*"); 
		$this->emsdb->from("emp_leave");
		$this->emsdb->where("id",$id);
		$query = $this->emsdb->get();
		return $query->result_array();
	}

	public function saveLeave($data, $options = [])
    {
		// print_r($data);
		$posi_type = isset($data['posi_type'])? $data['posi_type']: 1;
		$deep_type = $data['deep_type'];
		$designationID = $data['designationID'];
		$userID = $data['emp_id'];
		$temp_leave_day = isset($data['tempLeaveDay'])?'':$data['tempLeaveDay'];
		if ($data['application_type'] == 1 ) {
			$dWithoutPay = $data['dWithoutPay'];
			$temp_leave_day = $data['tempLeaveDay'];	
		}
		$designation = isset($data['designation'])? $data['designation']:'';
		$image_name = isset($data['image_name'])? $data['image_name']:'';
		$attachment = isset($data['attachment_encode'])? $data['attachment_encode']:'';
		 // filing leave auto approve for DEPARTMENT HEAD
		 if($posi_type == 1) {
            if ($deep_type == 1) { // MIS Department
                $approver_id = $userID;
                $appr_inter_head = 2;
                $appr_dept_head = 2;
                $appr_hr_manager = 0;
                $appr_president = 0;
                $leave_remarks = 'Noted';  
                $leave_status = 1;
            } else {
                $approver_id = $userID;
                $appr_inter_head = 2;
                $appr_dept_head = 0;
                $appr_hr_manager = 0;
                $appr_president = 0;
                $leave_remarks = 'Noted';
                $leave_status = 1;
            }
        } else if ($posi_type == 2) { // HR Manager
            $approver_id = $userID;
            $appr_inter_head = 2;
            $appr_dept_head = 2;
            $appr_hr_manager = 2;
            $appr_president = 0;
            $leave_remarks = 'Verified';
            $leave_status = 1;
        } else if ($posi_type == 3) { // President
            $approver_id = $userID;
            $appr_inter_head = 2;
            $appr_dept_head = 2;
            $appr_hr_manager = 2;
            $appr_president = 2;
            $leave_remarks = 'Approved';
            $leave_status = 2;
        } else if ($posi_type == 4) { // HR Head
            $approver_id = $userID;
            $appr_inter_head = 2;
            $appr_dept_head = 2;
            $appr_president = 0;
            $appr_hr_manager = 0;
            $leave_remarks = 'Noted';
            $leave_status = 1;
        } else {
            if ($designationID == 19 || $designationID == 46 || $userID == '300581') {
                $approver_id = '';
                $appr_inter_head = 2;
                $appr_dept_head = 0;
                $appr_hr_manager = 0;
                $appr_president = 0;
                $leave_remarks = '';
                $leave_status = 1;
            } else if($designationID == 26) {
            	$approver_id = '';
                $appr_inter_head = 2;
                $appr_dept_head = 2;
                $appr_hr_manager = 0;
                $appr_president = 0;
                $leave_remarks = '';
                $leave_status = 1;
            } else {
                $approver_id = '';
                $appr_inter_head = 0;
                $appr_dept_head = 0;
                $appr_hr_manager = 0;
                $appr_president = 0;
                $leave_remarks = '';
                $leave_status = 1;
            }
        }
		if ($data['application_type'] == 2) {
			$insert = [
				'emp_id' => $data['emp_id'],
				'leave_type' => $data['unleavetype'],
				'application_type' => $data['application_type'],
				'apply_date' => date("Y-m-d", strtotime($data['undate_filed'])),
				'date_from' => date("Y-m-d", strtotime($data['undatefrom'])),
				'date_to' => date("Y-m-d", strtotime($data['undatefrom'])),
				'reason' => $data['under_Reason'],
				'undertime_out' => $data['under_time_out'],
				'leave_status' => $leave_status,
				'approver_id' => $approver_id,
				'appr_inter_head' => $appr_inter_head,
				'appr_dept_head' => $appr_dept_head,
				'appr_hr_manager' => $appr_hr_manager,
				'appr_president' => $appr_president,
				'without_pay_days' => '',
				'temp_leave_day' => '',
				'attachment' => '',
			];
		} else if ($data['application_type'] == 3) {
			$insert = [
				'emp_id' => $data['emp_id'],
				'leave_type' => $data['halfleavetype'],
				'application_type' => $data['application_type'],
				'apply_date' => date("Y-m-d", strtotime($data['halfdatefrom'])),
				'date_from' => date("Y-m-d", strtotime($data['halfdatefrom'])),
				'date_to' => date("Y-m-d", strtotime($data['halfdatefrom'])),
				'reason' => $data['half_Reason'],
				'undertime_out' => '',
				'leave_status' => $leave_status,
				'approver_id' => $approver_id,
				'appr_inter_head' => $appr_inter_head,
				'appr_dept_head' => $appr_dept_head,
				'appr_hr_manager' => $appr_hr_manager,
				'appr_president' => $appr_president,
				'without_pay_days' => '',
				'temp_leave_day' => '',
				'attachment' => '',
				'halfday' => $data['halfdaytype']
			];
		} else {
			if ($data['dWithoutPay'] !== '') {
				$object = json_decode($data['dWithoutPay'], JSON_FORCE_OBJECT);
				$wop = implode(",", $object);
			} else {
				$wop = '';
			}
			$insert = [
				'emp_id' => $data['emp_id'],
				'leave_type' => $data['leavetype'],
				'application_type' => $data['application_type'],
				'apply_date' => date("Y-m-d", strtotime($data['date_filed'])),
				'date_from' => date("Y-m-d", strtotime($data['datefrom'])),
				'date_to' => date("Y-m-d", strtotime($data['dateto'])),
				'reason' => $data['Reason'],
				'undertime' => '',
				'leave_status' => $leave_status,
				'approver_id' => $approver_id,
				'appr_inter_head' => $appr_inter_head,
				'appr_dept_head' => $appr_dept_head,
				'appr_hr_manager' => $appr_hr_manager,
				'appr_president' => $appr_president,
				'without_pay_days' => $wop,
				'temp_leave_day' => $temp_leave_day,
				'attachment' => $image_name
			];
		}

        foreach ($options as $key => $value) {
            $insert[$key] = $value;
        }

        $this->emsdb->insert('emp_leave', $insert);
		// auto approve department head
		if( $posi_type == 1 || $posi_type == 2 || $posi_type == 3 || $posi_type == 4) {
			// insert leave approver
			$autoApprove = [
				'emp_leave_id' => $this->emsdb->insert_id(),
				'approver_emp_id' =>  $userID,
				'leave_remarks' => $leave_remarks,
				'leave_status' => '2'
			];
			$this->emsdb->insert('tbl_leave_approver', $autoApprove);
		}
        if($this->emsdb->affected_rows()) {
			if ($posi_type == 0) {
				// get email approver
				if ($deep_type == 1 || $deep_type == 2 || $deep_type == 15 || $deep_type == 5) { // MIS Department approver
					$email_approver = $this->emsdb->query("SELECT u.*, d.position_type FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID  WHERE u.emp_department = ".$deep_type." and d.position_type = 1");
				} else if ($deep_type == 9) { // Accounting Department approver
					$desigexplode = explode(' ', $designation)[0];
					if ($designationID == 19 || $designationID == 46) {
						$email_approver = $this->emsdb->query("SELECT u.*, d.position_type FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID  WHERE u.emp_department = ".$deep_type." and d.position_type = 4");
					} else {
						$email_approver = $this->emsdb->query("SELECT u.*, d.position_type FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID  WHERE u.emp_department = ".$deep_type." and d.position_type = 1 AND d.designationname LIKE '%{$desigexplode}%'");
					}
				} else if ($deep_type == 14) { // Accounting Department approver
					$desigexplode = explode(' ', $designation)[0];
					$email_approver = $this->emsdb->query("SELECT u.*, d.position_type FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID  WHERE u.emp_department = ".$deep_type." and d.position_type = 1 AND d.designationname LIKE '%{$desigexplode}%'");
				} else {
					$email_approver = $this->emsdb->query("SELECT u.*, d.position_type, d.designationname FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID  WHERE u.emp_department = ".$deep_type." and d.position_type = 1 AND d.designationname LIKE '%{$designation}%'");
				}
			} else if ($posi_type == 1) {
				if ($deep_type == 1) { // MIS Department approver
					$email_approver = $this->emsdb->query("SELECT u.*, d.position_type FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID WHERE d.position_type = 2");
				} else { // HR Department approver
					$email_approver = $this->emsdb->query("SELECT u.*, d.position_type FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID WHERE u.emp_department = ".$deep_type." and d.position_type = 4");
				}
			} else if ($posi_type == 2) {
					$email_approver = $this->emsdb->query("SELECT u.*, d.position_type FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID WHERE u.emp_department = ".$deep_type." and d.position_type = 4");
			} else if ($posi_type == 4) {
				$email_approver = $this->emsdb->query("SELECT u.*, d.position_type FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID WHERE d.position_type = 2");
			}
			// get info to recieve email	
			$emp_info = $this->emsdb->query("SELECT u.*, d.designationname, dept.departmentname
				FROM users u 
					LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID  
					LEFT JOIN tbl_department dept ON u.emp_department = dept.departmentid
					WHERE u.emp_id = ".$data['emp_id']."");
			$notification = array();
			// print_r($email_approver);
			foreach ($email_approver->result() as $row)
			{		
				$notification['email'] = $row->email;
				$notification['contact_number'] = $row->contact_number;
				$notification['noofleave'] = $temp_leave_day;
				$reason = '';
				if ($data['application_type'] == 1) {
					$reason = $data['Reason'];
				} else if ($data['application_type'] == 2) {
					$reason = $data['under_Reason'];
				} else {
					$reason = $data['half_Reason'];
				}
				$notification['reason'] = $reason;
				foreach ($emp_info->result() as $emp) {
					$notification['name'] = $emp->firstname.' '.$emp->middlename.' '.$emp->lastname;
					$notification['designation'] = $emp->designationname;
					$notification['department'] = $emp->departmentname;
				}
			}
			// ,
			// 				This is to notify you that one of your employees has requested leave.
			// 				Best wishes,
			// 			 	CGSI Portal
			// Name: '.$notification['name'].'
			// 			 	Department: '.$notification['department'].'
			// 			 	Designation: '.$notification['designation'].'
			// 			 	No of Leave: '.$notification['noofleave'].' day/s
			// 				Reason: '.$notification['reason'].'

			// $data = [
			// 			'phone' => $notification['contact_number'],//'+639216937799',
			// 			'text' => 'CGSI Portal: This is to notify you that one of your employees has requested leave. Name: '.$notification['name'].', Department: '.$notification['department'].''
			// 		];
			// $this->sendSMS($data);


			return array("data"=>$notification,'success' => true);
		}
    }

	// Approve, Reject Leave 
	public function saveLeaveSubmit($data) {
		// print_r($data);
		$reject_reason = $data['rejectreason'];
		$posi_type = isset($data['position_type'])?$data['position_type']:1;
		$deep_type = isset($data['deep_type'])? $data['deep_type']: 1;
		$designation = isset($data['desigid'])? $data['desigid']: 1;
		$designationID = isset($data['designationID'])? $data['designationID']: 1;
		$temp_leave_day = isset($data['temp_leave_day'])? $data['temp_leave_day']: '';

		if (isset($data['leaveid']) && isset($data['leavetype'])) {

			// filter leave apporover
			$up_inter = '';
			if ($data['position_type'] == 1) {
				if ($data['deep_type'] == 1) { // MIS Department
					if ($data['leavetype'] == 1) { // approve
						$up_inter = ',appr_inter_head = 2, appr_dept_head = 2';
						$leave_remarks = 'Noted';
						$leave_status_empl = 1;
						$leave_status_appr = 2;
					} 
					if ($data['leavetype'] == 2) {  //cancel
						$up_inter = ',appr_inter_head = 3, appr_dept_head = 3';
						$leave_remarks = 'Rejected';
						$leave_status_empl = 3;
						$leave_status_appr = 3;
					} 
				} else { // ALL DEPARTMENT EXCEPT MIS
					if ($data['leavetype'] == 1) { // approve
						$up_inter = ', appr_inter_head = 2';
						$leave_remarks = 'Noted';
						$leave_status_empl = 1;
						$leave_status_appr = 2;
					}
					if ($data['leavetype'] == 2) {  //cancel
						$up_inter = ', appr_inter_head = 3';
						$leave_remarks = 'Rejected';
						$leave_status_empl = 3;
						$leave_status_appr = 3;
					}
				}
			} else if($data['position_type'] == 2 ) { // HR Manager
				if ($data['leavetype'] == 1) { // approve
					$up_inter = ', appr_hr_manager = 2';
					$leave_remarks = 'Verified';
					$leave_status_empl = 1;
					$leave_status_appr = 2;
				} 
				if ($data['leavetype'] == 2) {  //cancel
					$up_inter = ',appr_hr_manager = 3';
					$leave_remarks = 'Rejected';
					$leave_status = 3;
					$leave_status_empl = 3;
					$leave_status_appr = 3;
				} 
			} else if($data['position_type'] == 3 ) {
				if ($data['leavetype'] == 1) { // approve
					$up_inter = ', appr_president = 2';
					$leave_remarks = 'Approved';
					$leave_status_empl = 2;
					$leave_status_appr = 2;
				} 
				if ($data['leavetype'] == 2) {  //cancel
					$up_inter = ',appr_president = 3';
					$leave_remarks = 'Rejected';
					$leave_status = 3;
					$leave_status_empl = 3;
					$leave_status_appr = 3;
				} 
			} else if($data['position_type'] == 4 ) {
				if ($data['leavetype'] == 1) { // approve
					$up_inter = ',appr_inter_head = 2, appr_dept_head = 2';
					$leave_remarks = 'Noted';
					$leave_status_empl = 1;
					$leave_status_appr = 2;
				}
				if ($data['leavetype'] == 2) {  //cancel
					$up_inter = ', appr_dept_head = 3';
					$leave_remarks = 'Rejected';
					$leave_status_empl = 3;
					$leave_status_appr = 3;
				}
			} 

			// approve leave update
			$update_leave_approver = "UPDATE emp_leave SET leave_status = '$leave_status_empl' ".$up_inter." WHERE id = '".$data['leaveid']."'";
			$queryup = $this->emsdb->query($update_leave_approver);

			// insert leave approver
			$insert_leave_approver = "INSERT INTO `tbl_leave_approver`(`emp_leave_id`,`approver_emp_id`,`leave_remarks`,`leave_status`,`reject_reason`) VALUES (".$data['leaveid'].",".$data['userID'].", '$leave_remarks','$leave_status_appr','$reject_reason')";

			$queryins = $this->emsdb->query($insert_leave_approver);
			
			if ($queryup && $queryins ) { 

				if($data['position_type'] == 3 ) {

					if ($data['leavetype'] == 1) { // approve

						$temp_leave_day = $this->emsdb->query("SELECT id, temp_leave_day FROM emp_leave WHERE id = ".$data['leaveid'])->row()->temp_leave_day;

						$creditInfo = $this->emsdb->query("SELECT total_leave_credit, leave_left FROM users WHERE emp_id = ".$data['empid']." limit 1")->row();

						$leave_left = ($creditInfo->leave_left - $temp_leave_day);
						$leave_used = ($creditInfo->total_leave_credit - $leave_left);

						// insert leave used in users
						$update_leave_used = "UPDATE users SET leave_used = '$leave_used', leave_left = '$leave_left' WHERE emp_id = ".$data['empid']." LIMIT 1";
						$queryup = $this->emsdb->query($update_leave_used);

					}

				}


				// SEND EMAIL TO APPROVER
				// get info to recieve email	
				$getdesignation = $this->emsdb->query("SELECT u.*, d.designationname, dept.departmentname
				FROM users u 
					LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID  
					LEFT JOIN tbl_department dept ON u.emp_department = dept.departmentid
					WHERE u.emp_id = ".$data['userID']."");
					$designationID = $getdesignation->result()[0]->emp_designation;
					$designation = $getdesignation->result()[0]->designationname;

				if ($posi_type == 0) {
					// get email approver
					if ($deep_type == 1 || $deep_type == 2 || $deep_type == 15 || $deep_type == 5) { // MIS Department approver
						$email_approver = $this->emsdb->query("SELECT u.*, d.position_type FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID  WHERE u.emp_department = ".$deep_type." and d.position_type = 1");
					} else if ($deep_type == 9) { // Accounting Department approver
						$desigexplode = explode(' ', $designation)[0];
						if ($designationID == 19 || $designationID == 46) {
							$email_approver = $this->emsdb->query("SELECT u.*, d.position_type FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID  WHERE u.emp_department = ".$deep_type." and d.position_type = 4");
						} else {
							$email_approver = $this->emsdb->query("SELECT u.*, d.position_type FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID  WHERE u.emp_department = ".$deep_type." and d.position_type = 1 AND d.designationname LIKE '%{$desigexplode}%'");
						}
					} else if ($deep_type == 14) { // Accounting Department approver
						$desigexplode = explode(' ', $designation)[0];
						$email_approver = $this->emsdb->query("SELECT u.*, d.position_type FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID  WHERE u.emp_department = ".$deep_type." and d.position_type = 1 AND d.designationname LIKE '%{$desigexplode}%'");
					} else {
						$email_approver = $this->emsdb->query("SELECT u.*, d.position_type, d.designationname FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID  WHERE u.emp_department = ".$deep_type." and d.position_type = 1 AND d.designationname LIKE '%{$designation}%'");
					}
				} else if ($posi_type == 1) {
					if ($deep_type == 1) { // MIS Department approver
						$email_approver = $this->emsdb->query("SELECT u.*, d.position_type FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID WHERE d.position_type = 2");
					} else { // HR Department approver
						$email_approver = $this->emsdb->query("SELECT u.*, d.position_type FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID WHERE u.emp_department = ".$deep_type." and d.position_type = 4");
					}
				} else if ($posi_type == 2) {
					$email_approver = $this->emsdb->query("SELECT u.*, d.position_type FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID WHERE u.emp_department = ".$deep_type." and d.position_type = 4");
				} else if ($posi_type == 4) {
					$email_approver = $this->emsdb->query("SELECT u.*, d.position_type FROM users u LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID WHERE d.position_type = 2");
				}

				$getEmployeeInfo = $this->emsdb->query("SELECT el.*
				FROM emp_leave el 
				WHERE el.id = ".$data['leaveid']."");
				$leaveEmployeeID = $getEmployeeInfo->result()[0]->emp_id;

				// get info to recieve email	
				$emp_info = $this->emsdb->query("SELECT u.*, d.designationname, dept.departmentname
					FROM users u 
						LEFT JOIN tbl_designation d ON u.emp_designation = d.designationID  
						LEFT JOIN tbl_department dept ON u.emp_department = dept.departmentid
						WHERE u.emp_id = ".$leaveEmployeeID."");

				// get info to recieve email	
				$leave_info = $this->emsdb->query("SELECT el.*
					FROM emp_leave el 
					WHERE el.id = ".$data['leaveid']."");


				foreach ($email_approver->result() as $row)
				{		
					$notification['email'] = $row->email;
					$notification['noofleave'] = $temp_leave_day;
					$reason = '';
					foreach ($leave_info->result() as $leaveinfo) {
						$notification['reason'] = $leaveinfo->reason;
					}
					foreach ($emp_info->result() as $emp) {
						$notification['name'] = $emp->firstname.' '.$emp->middlename.' '.$emp->lastname;
						$notification['designation'] = $emp->designationname;
						$notification['department'] = $emp->departmentname;
					}
				}

				if ($data['leavetype'] == 1) {
					$msg = 'Approved';
				} else {
					$msg = 'Rejected';
				}
				echo json_encode(array("m"=>'Successfully '.$msg.' Leave',"id"=>$data['leaveid'],'notification' => $notification,'success' => true));
			} else {
				echo json_encode("Something wrong in applying leave.");
			}
		}
	}

	public function removeLeave($data){
		$this->emsdb-> where('id', $data['leaveid']);
		$this->emsdb->delete('emp_leave');
		return true;
	}
	

}
