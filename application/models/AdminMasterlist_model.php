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
class AdminMasterlist_model extends CI_Model
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


	// Leave credit list
	public function AdminInfoList($id,$type,$dept,$desigid) {
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

}
