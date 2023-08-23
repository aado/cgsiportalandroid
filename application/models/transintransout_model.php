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
class TransinTransout_model extends CI_Model
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

        $serverName = 'CGSISERVER';
		$connectionInfo = array('Database'=>'CGSI','UID'=>'sa','PWD'=>'cg');
		$conn=sqlsrv_connect($serverName,$connectionInfo);

		if($conn){
			// print_r('connected');
			$this->conn_cgsi = $conn;
		}

    }

    /**
     * Get user by specific data
     * 
     * @param array $data
     * @param bool  $first Get only the first data
     * @param object
     */

    public function toreceived() {
        $sql = "SELECT pd.PO_Supplier,tt.*,ri.ItemName,ri.ItemUnit,ri.ItemDesc,ri.ItemSize,ri.ItemQty
            FROM tbl_transin_transout tt
            INNER JOIN tbl_reqdetails rd on tt.PO_Number=rd.PO_Number
            inner join tbl_reqitem ri on rd.ReqNum=ri.ReqNum
            LEFT JOIN tbl_podetails pd on tt.PO_Number = pd.PO_Number
            GROUP by ri.ItemDesc";

        $query = $this->emsdb->query($sql);
        return $query->result_array();

    }
	
	

}
