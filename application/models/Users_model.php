<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Users Model Class
 *
 * @package     CodeIgniter Simple Login
 * @subpackage  Models
 * @category    Users
 * @author      Muhammad Haibah <inibah97@gmail.com>
 * @link        https://github.com/inibah97
 */
class Users_model extends CI_Model
{
    /**
     * The table used in this model
     * 
     * @var array
     */
    private $_table = [
        'users'
    ];

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
        $this->load->database();
        $this->emsdb = $this->load->database('emsdb', true);
    }

    /**
     * Get user by specific data
     * 
     * @param array $data
     * @param bool  $first Get only the first data
     * @param object
     */
    public function getUserByField($data, $first = false)
    {
        $this->db->where($data);

        if ($first === true) {
            return $this->db->get($this->_table[0])->row();
        } else {
            return $this->db->get($this->_table[0])->result();
        }
    }

    public function getCheckUser($data) {
        $sql = "SELECT tl.*,users.email, users.Birthdate, td.designationID, td.position_type, td.designationname, tdept.departmentname FROM tbl_logins tl LEFT JOIN users
        ON tl.UserID = users.emp_id
                LEFT JOIN tbl_designation td
                    ON tl.designation = td.designationID
                LEFT JOIN tbl_department tdept
                    ON tl.department = tdept.departmentid
                WHERE tl.po_username = '".$data['username']."' and tl.po_password = '".$data['password']."'";
        $query = $this->emsdb->query($sql);
        return $query->result_array();
    }

    public function getProbeEmployee() {
        $sql = "SELECT u.*,td.designationID, td.position_type, td.designationname, tdept.departmentname, TIMESTAMPDIFF(MONTH,u.date_hired,CURDATE()) as mFromDhired FROM users u
                LEFT JOIN tbl_designation td
                    ON u.emp_designation = td.designationID
                LEFT JOIN tbl_department tdept
                    ON u.emp_department = tdept.departmentid
                WHERE u.emp_status != 3 AND u.emp_designation != 17";
        $query = $this->emsdb->query($sql);
        return $query->result_array();
    }

    public function getDirectHeadEmail($data) {
        
        // print_r($data);
        $deep_type = $data['deep_type'];
        $designation = $data['designation'];
        $designationID = $data['designationID'];
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

        foreach ($email_approver->result() as $row)
        {		
            $notification['email'] = $row->email;
        }
        return $notification;
    }


    /**
     * Insert new user to resources
     * 
     * @param  string $username
     * @param  string $password
     * @param  array  $options
     * @return int              database affected rows
     */
    public function insertUser($username, $password, $options = [])
    {
        $insert = [
            'username'   => $username,
            'password'   => password_hash($password, PASSWORD_BCRYPT),
            'created_at' => time(),
            'updated_at' => time()
        ];

        foreach ($options as $key => $value) {
            $insert[$key] = $value;
        }

        $this->db->insert($this->_table[0], $insert);
        return $this->db->affected_rows();
    }

    /**
     * Update user by specific data
     * 
     * @param  int   $id   USERS.ID
     * @param  array $data
     * @return int         Database affected rows
     */
    public function updateUser($id, $data)
    {
        $update = [
            'updated_at' => time(),
            'otp_verified' => 0
        ];

        foreach ($data as $key => $value) {
            $update[$key] = $value;
        }

        $this->db->set($update);
        $this->db->where('userid', $id);
        $this->db->update($this->_table[0]);
        return $this->db->affected_rows();
    }

    public function updateOTP($id, $data) {
        $update = [
            'otp_verified' => 0
        ];

        foreach ($data as $key => $value) {
            $update[$key] = $value;
        }

        $this->emsdb->set($update);
        $this->emsdb->where('emp_id', $id);
        $this->emsdb->update($this->_table[0]);
        return $this->emsdb->affected_rows();
    }
}
