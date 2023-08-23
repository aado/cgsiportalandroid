<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Memo_model extends CI_Model
{

    public function __construct()
    {
        // Load the parent construct
        parent::__construct();

        // Load the database libraries
        $this->emsdb = $this->load->database('emsdb', true);

    }

	public function memoList($designationID) {
		$where = 'WHERE tm.memo_status != "2"';
		if ($designationID == '13' || $designationID == '17'  || $designationID == '44') {
			$where = '';
		}
		$sql = "SELECT 
			tm.*,tmt.name
		FROM tbl_memo tm 
		LEFT JOIN tbl_memo_type tmt 
		ON tm.memo_type = tmt.typeid ".$where."";
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function getApprover($memoid) {
		$sql = "SELECT tma.*,u.firstname, u.lastname FROM 
			tbl_memo_approver tma 
		LEFT JOIN users u 
			ON tma.approver_empid = u.emp_id
		WHERE tma.memo_id ='$memoid' ORDER BY tma.created ASC"; 
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function getSeener($memoid,$department) {
		$sql = "SELECT tms.*,u.firstname, u.lastname FROM 
			tbl_memo_seener tms 
		LEFT JOIN users u 
			ON tms.emp_id = u.emp_id
		WHERE tms.memo_id ='$memoid' AND tms.department = '".$department."' ORDER BY tms.seen_date ASC"; 
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function getAllMemoViewer() {
		$sql = "SELECT tms.*,u.firstname, u.lastname,  tdep.departmentname,tdesig.designationID,  tdesig.designationname FROM 
			tbl_memo_seener tms 
		LEFT JOIN users u 
			ON tms.emp_id = u.emp_id
		LEFT JOIN tbl_designation tdesig
			ON u.emp_designation = tdesig.designationID
		LEFT JOIN tbl_department tdep 
			ON tdesig.department = tdep.departmentid ORDER BY tms.seen_date ASC"; 
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function getAllMemoViewerById($memoid, $id, $typeid) {
		if ($id == '300146') {
			if ($typeid == 2) {
					$sql = "SELECT tms.*,u.firstname, u.lastname,  tdep.departmentname,tdesig.designationID,  tdesig.designationname FROM 
					tbl_memo_seener tms 
					LEFT JOIN users u 
						ON tms.emp_id = u.emp_id
					LEFT JOIN tbl_designation tdesig
						ON u.emp_designation = tdesig.designationID
					LEFT JOIN tbl_department tdep 
						ON tdesig.department = tdep.departmentid 
					WHERE tms.memo_id='".$memoid."' and u.emp_status != '3' ORDER BY tms.seen_date ASC"; 
			} else {
				$sql = "SELECT tms.*,u.firstname, u.lastname,  tdep.departmentname,tdesig.designationID,  tdesig.designationname FROM 
				tbl_memo_seener tms 
				LEFT JOIN users u 
					ON tms.emp_id = u.emp_id
				LEFT JOIN tbl_designation tdesig
					ON u.emp_designation = tdesig.designationID
				LEFT JOIN tbl_department tdep 
					ON tdesig.department = tdep.departmentid 
				WHERE tms.memo_id='".$memoid."'  and u.emp_status != '3'  ORDER BY tms.seen_date ASC"; 
			}
		} else {
			$sql = "SELECT tms.*,u.firstname, u.lastname,  tdep.departmentname,tdesig.designationID,  tdesig.designationname FROM 
			tbl_memo_seener tms 
			LEFT JOIN users u 
				ON tms.emp_id = u.emp_id
			LEFT JOIN tbl_designation tdesig
				ON u.emp_designation = tdesig.designationID
			LEFT JOIN tbl_department tdep 
				ON tdesig.department = tdep.departmentid 
			WHERE tms.memo_id='".$memoid."'  and u.emp_status != '3'  ORDER BY tms.seen_date ASC"; 
		}
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	function getAllMemoContri($empid) {
		$excludeid = implode(',', $empid);
			$sql = "SELECT u.emp_id, u.firstname, u.lastname,  tdep.departmentname,tdesig.designationID,  tdesig.designationname
				FROM  users u 
				LEFT JOIN tbl_designation tdesig
					ON u.emp_designation = tdesig.designationID
				LEFT JOIN tbl_department tdep 
					ON tdesig.department = tdep.departmentid
				WHERE u.emp_status != '3' and  u.emp_id  NOT IN (".$excludeid.")"; 
			$query = $this->emsdb->query($sql);
			return $query->result_array();
	}

	// Leave Info
	public function leaveInfo($userid) {
		$sql = 'SELECT total_leave_credit, leave_used, leave_left, leave_additional FROM users WHERE emp_id = '.$userid;
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	// Count Memo
	public function getViewCount($memoid){
		$sql = 'SELECT count(*) memViewCnt FROM tbl_memo_seener WHERE memo_id = '.$memoid;
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function saveMemo($data, $options = [])
    {
		
		$insert = [
			'memo_type' => $data['memotype'],
			'memo_name' => $data['subject'],
			'memo_description' => $data['memobody'],
			'memo_expiry' => $data['expiry']
		];

        foreach ($options as $key => $value) {
            $insert[$key] = $value;
        }

        $this->emsdb->insert('tbl_memo', $insert);
        if($this->emsdb->affected_rows()) {
			return true;
		}
    }

	public function addAmtContri($data)
	{
		$update = [
            'memo_id' => $data['memo_id'],
			'amount' => $data['amount'],
			'emp_id' => $data['emp_id']
        ];

        foreach ($data as $key => $value) {
            $update[$key] = $value;
        }

        $this->emsdb->set($update);
        $this->emsdb->where('memo_id', $data['memo_id']);
		$this->emsdb->where('emp_id', $data['emp_id']);
        $this->emsdb->update('tbl_memo_seener');
		if ($this->emsdb->affected_rows()) {
			return true;
		}
	}

	// View type
	public function viewMemo($data) {
		$sql = 'SELECT * FROM tbl_memo WHERE memo_id = '.$data['memoid'].'';
		$query = $this->emsdb->query($sql);
		if ($query) {
			$sql1 = 'SELECT * FROM tbl_memo_seener WHERE memo_id = '.$data['memoid'].' AND emp_id = '.$data['emp_id'].'';
			$query1 = $this->emsdb->query($sql1);
			if ($query1->num_rows() == 0) {
				$data1 = array(
					'memo_id'=>$data['memoid'],
					'emp_id'=>$data['emp_id'],
					'department' => $data['department']
				);
				$this->emsdb->insert('tbl_memo_seener',$data1);
			}
		}
		return $query->result_array();
	}

		// Approve, Reject Leave 
		public function saveMemoSubmit($data) {
			// print_r($data);
			$reject_reason = $data['rejectreason'];
	
			if (isset($data['memoid']) && isset($data['statustype'])) {
	
				if ($data['statustype'] == 1) {
					$memo_status = 1;
					if ($data['userID'] == '300152') {
						$remarks = 'Verified';
						// $approved = 1;
						$updateApprove = 'verified';
					} else {
						$remarks = 'Approved';
						// $approved = 1;
						$updateApprove = 'approved';
					}
				} else {
					$memo_status = 2;
				}
	
				// approve leave update
				$update_memo_approver = "UPDATE tbl_memo SET memo_status = '".$memo_status."', ".$updateApprove." = 1 WHERE memo_id = '".$data['memoid']."'";
				$queryup = $this->emsdb->query($update_memo_approver);
	
				// insert memo approver
				$insert_memo_approver = "INSERT INTO `tbl_memo_approver`(`approver_empid`,`memo_id`,`memo_status`,`reject_reason`, `memo_remarks`) VALUES (".$data['userID'].",".$data['memoid'].", '$memo_status','$reject_reason','$remarks')";
	
				$queryins = $this->emsdb->query($insert_memo_approver);
				
				if ($queryup && $queryins ) { 
	
					if ($data['statustype'] == 1) {
						$msg = 'Approved';
					} else {
						$msg = 'Rejected';
					}
					echo json_encode(array("m"=>'Successfully '.$msg.' Leave',"id"=>$data['memoid'],'success' => true));
				} else {
					echo json_encode("Something wrong in applying leave.");
				}
			}
		}


	// Memo type
	public function memotype() {
		$sql = 'SELECT * FROM tbl_memo_type';
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function removeMemo($data){
		$this->emsdb-> where('memo_id', $data['memo_id']);
		$this->emsdb->delete('tbl_memo');
		return true;
	}
	

}
