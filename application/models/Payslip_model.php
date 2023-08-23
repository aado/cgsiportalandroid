<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Payslip_model extends CI_Model
{

    public function __construct()
    {
        // Load the parent construct
        parent::__construct()
        ;

        // Load the database libraries
        $this->emsdb = $this->load->database('emsdb', true);

    }

	public function payslipList() {
		$sql = "SELECT *
		FROM tbl_payslip ORDER BY created DESC";
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function viewPayslip($payslipid) {
		$sql = "SELECT * FROM tbl_payslip 
		WHERE payslip_id ='$payslipid' ORDER BY created DESC"; 
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	// Leave Info
	public function sendPayslipEmail() {
		$sql = 'SELECT firstname, lastname, emp_id, email FROM users WHERE emp_id IN(300544,300591)';
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

	public function savePayslip($data, $options = [])
    {
		$insert = [
			'payroll_period' => $data['payroll_period'],
			'payroll_cutoff' => $data['payroll_cutoff'],
			'payslipData' => $data['payslipData']
		];

        foreach ($options as $key => $value) {
            $insert[$key] = $value;
        }

        $this->emsdb->insert('tbl_payslip', $insert);
        if($this->emsdb->affected_rows()) {
			return true;
		}
    }

	public function saveVerification($data, $options = [])
    {
		$insert = [
			'verification_code' => $data['code'],
			'empid' => $data['empid']
		];

        foreach ($options as $key => $value) {
            $insert[$key] = $value;
        }

        $this->emsdb->insert('tbl_verification', $insert);
        if($this->emsdb->affected_rows()) {
			return true;
		}
    }

	public function checkVerification($data) {
		$sql = 'SELECT DISTINCT * FROM tbl_verification WHERE empid = '.$data["idnumber"].' AND verification_code = '.$data['otp'];
		$query = $this->emsdb->query($sql);
		if ($query->num_rows() > 0) {
			$update = [
				'otp_verified' => 1,
			];
			$this->emsdb->set($update);
			$this->emsdb->where('emp_id', $data['idnumber']);
			$this->emsdb->update('users');
			if ($this->emsdb->affected_rows()) {
				return true;
			}
		} 
		$query->result_array();
	}

	public function checkIfVerified($empid) {
		$sql = 'SELECT otp_verified FROM users WHERE emp_id = '.$empid;
		$query = $this->emsdb->query($sql);
		return $query->result_array()[0];
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


	// Memo type
	public function memotype() {
		$sql = 'SELECT * FROM tbl_memo_type';
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function removePayslip($data){
		$this->emsdb-> where('payslip_id', $data['payslip_id']);
		$this->emsdb->delete('tbl_payslip');
		return true;
	}
	

}
