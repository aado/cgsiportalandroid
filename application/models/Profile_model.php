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
class Profile_model extends CI_Model
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

    public function getuserDetails($sessionid) {

    	$sql = "SELECT u.*,lg.po_password FROM `users` u
            inner join tbl_logins lg on u.emp_id = lg.UserID
            WHERE u.emp_id='$sessionid'";
		
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

    public function saveChangePassword($data)
    {
		$insert_data = array(
			'po_password' =>  $data['password']//md5($data['password'])
		);
		$this->emsdb->where('UserID', $data['idnumber']);
		return $this->emsdb->update('tbl_logins',$insert_data);
    }

}
