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
class Cgsi_model extends CI_Model
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
        // $this->db = $this->load->database();

		$this->load->database();

		$serverName = 'CGSISERVER';
		$CGSI_Web_Conn = array('Database'=>'CGSI_web','UID'=>'sa','PWD'=>'cg');
		$this->conn_cgsi_web=sqlsrv_connect($serverName,$CGSI_Web_Conn);

        $CGSI_Conn = array('Database'=>'CGSI','UID'=>'sa','PWD'=>'cg');
		$this->conn_cgsi=sqlsrv_connect($serverName,$CGSI_Conn);
    }

    /**
     * Get user by specific data
     * 
     * @param array $data
     * @param bool  $first Get only the first data
     * @param object
     */

	public function getAllStatus(){
		$this->db->select("*"); 
		$this->db->from("employment_status");
		$query = $this->db->get();
		return $query->result_array();
	}

	// get data for masterlist
    public function getEmpSIL() {

		if($this->conn_cgsi_web && $this->conn_cgsi){
			//Get User Client
			$getClient = $this->getUserClient();
			$separClient = "('" . implode("','", $getClient) . "')";
			
			$sqlCG = "SELECT DISTINCT 
			ei.*, ei.DoB,
			eWHd.*, 
			Datediff(Hour,Date_Hired,GETDATE()) / 8766 as Duration
			FROM Employee_Info ei
			INNER JOIN Employee_WH_Details eWHd
			on ei.Company_ID = eWHd.Company_ID
			WHERE eWHd.Comp_Name IN ".$separClient." AND ei.Status IN ('Active','Maternity','Force Leave') AND eWHD.Date_End = '' ORDER BY eWHd.Date_Hired DESC";

			$mstr = sqlsrv_query( $this->conn_cgsi, $sqlCG );
			if( $mstr === false) {
				die( print_r( sqlsrv_errors(), true) );
			}

			$masterlist = []; 
			while( $row_master = sqlsrv_fetch_array( $mstr, SQLSRV_FETCH_ASSOC) ) {
				array_push($masterlist,$row_master);
			}

			return $masterlist;
		}else{
			echo "Unable to connect<br />";
			die( print_r(sqlsrv_errors(), true));
		}
	}

	function array_is_unique($array) {
		return array_unique($array) == $array;
	 }

	//Get data for RTA
	public function getDataForRTA() {
		if($this->conn_cgsi_web && $this->conn_cgsi){
			//Get User Client
			$getClient = $this->getUserClient();
			$separClient = "('" . implode("','", $getClient) . "')";

			$sqlCG = "SELECT distinct sv.Emp_Refnum, ei.Emp_LName, ei.Emp_FName, ei.Emp_MName, sv.RTA_Status,sv.Company_ID,sv.Category,
			sv.[Reason(s)] as Reason,sv.EffectiveDate,sv.LastPay,sv.OtherInfo,ed.Comp_Name,ed.Date_Hired as DateHired, sv.Entry_Date, sv.Last_Duty as LastDuty 
			from CGSI.dbo.tbl_UpdateStatusforSV sv
			inner join CGSI.dbo.Employee_Info ei on ei.Emp_RefNum = sv.Emp_Refnum and ei.Company_ID = sv.Company_ID
			inner join CGSI.dbo.Employee_WH_Details ed on ed.Emp_RefNum=sv.Emp_Refnum and ed.Company_ID = sv.Company_ID and ed.Comp_Name IN ".$separClient."
			where sv.RTA_Status='For Process' and sv.Sv_CompanyName IN ".$separClient." and ed.Date_End = ''
			order by sv.EffectiveDate DESC";

			$mstr = sqlsrv_query( $this->conn_cgsi, $sqlCG );
			if( $mstr === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			$rta = [];
			while( $row_master = sqlsrv_fetch_array( $mstr, SQLSRV_FETCH_ASSOC) ) {
				$rta[] = $row_master;
			}
			return $rta;
		}else{
			echo "Unable to connect<br />";
			die( print_r(sqlsrv_errors(), true));
		}
	}

	//Get data for RTA
	public function getDataForfLMat() {
		if($this->conn_cgsi_web && $this->conn_cgsi){
			//Get User Client
			$getClient = $this->getUserClient();
			$separClient = "('" . implode("','", $getClient) . "')";

			$sqlCG = "SELECT distinct sv.Emp_Refnum, ei.Emp_LName, ei.Emp_FName, ei.Emp_MName,sv.Company_ID,sv.Category, sv.[Reason(s)] as Reason,EffectiveDate,LastPay,OtherInfo,ed.Comp_Name,ed.Date_Hired as DateHired, sv.M_F_StartDate, sv.M_F_EndDate
			from CGSI.dbo.tbl_UpdateStatusforSV sv
			inner join CGSI.dbo.Employee_Info ei on ei.Emp_RefNum = sv.Emp_Refnum and ei.Company_ID = sv.Company_ID
			inner join CGSI.dbo.Employee_WH_Details ed on ed.Emp_RefNum=sv.Emp_Refnum and ed.Company_ID = sv.Company_ID and ed.Comp_Name IN ".$separClient."
			where sv.Sv_CompanyName IN ".$separClient." and ed.Date_End = ''  and sv.Category = 'Force Leave' and sv.RTA_Status = 'Leave'
			or sv.Sv_CompanyName IN ".$separClient." and ed.Date_End = ''  and sv.Category = 'Maternity' and sv.RTA_Status = 'Leave'
			order by ei.Emp_LName asc";

			$mstr = sqlsrv_query( $this->conn_cgsi, $sqlCG );
			if( $mstr === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			$rta = [];
			while( $row_master = sqlsrv_fetch_array( $mstr, SQLSRV_FETCH_ASSOC) ) {
				$rta[] = $row_master;
			}
			return $rta;
		}else{
			echo "Unable to connect<br />";
			die( print_r(sqlsrv_errors(), true));
		}
	}

	//Get data for RTA InActive
	public function getDataForRTAInactive() {
		if($this->conn_cgsi_web && $this->conn_cgsi){
			//Get User Client
			$getClient = $this->getUserClient();
			$separClient = "('" . implode("','", $getClient) . "')";
			$sqlCG = "SELECT Distinct ei.Emp_RefNum, Ei.Emp_LName as LastName,
				Ei.Emp_FName as FirstName,
				Ei.Emp_MName as MiddleName,
				ei.Gender,
				EWD.Comp_Name as 'Company_Assigned',
				EWD.EmpStatus,
				EWD.Date_End,
				trl.Date_Prepared,
				EWD.Clearance_Date,
				ei.Contact_Num1 as Contact#,
				ei.Applicant_ID
				from CGSI.dbo.vw_Employee_info Ei
				inner join
				CGSI.dbo.Employee_WH_Details EWD on LTRIM(RTRIM(EWD.Emp_RefNum)) = LTRIM(RTRIM(Ei.Emp_RefNum))
				left join
				(select Emp_Refnum, Payroll_Date, Company, Employee_Status from CGSI.dbo.tbl_RTAProcess group by Emp_Refnum, Payroll_Date, Company, Employee_Status) tr on LTRIM(RTRIM(tr.Emp_RefNum)) = LTRIM(RTRIM(EWD.Emp_RefNum)) and LTRIM(RTRIM(tr.Company)) = LTRIM(RTRIM(EWD.Comp_Name)) and tr.Employee_Status = EWD.EmpStatus
				left join
				CGSI.dbo.tbl_RTAprocessLogs trl on convert(varchar(20),trl.Emp_Refnum) = convert(varchar(20),tr.Emp_RefNum) and Convert(varchar(20),trl.Date_Prepared) like '%'+ Left(Convert(varchar(20),tr.Payroll_Date),8)+'%'
				Where ewd.Date_End != '' and EWD.Comp_Name IN ".$separClient." 
				group by Ei.Emp_RefNum, Ei.Emp_LName, Ei.Emp_FName , Ei.Emp_MName , EWD.Comp_Name, EWD.EmpStatus, EWD.Date_End, trl.Date_Prepared, EWD.Clearance_Date, ei.Contact_Num1, ei.Applicant_ID,ei.Gender
				order by ei.Emp_LName";

			$mstr = sqlsrv_query( $this->conn_cgsi, $sqlCG );
			if( $mstr === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			$rta = [];
			while( $row_master = sqlsrv_fetch_array( $mstr, SQLSRV_FETCH_ASSOC) ) {
				$rta[] = $row_master;
			}
			return $rta;
		}else{
			echo "Unable to connect<br />";
			die( print_r(sqlsrv_errors(), true));
		}
	}

	public function getContactInfo($id) {
		if($this->conn_cgsi){
			//Get User
			$sqlContactInfo= "SELECT Contact_Person, Contact_Number, Adress FROM Applicant_FB_Details WHERE Applicant_ID = '".$id."'";
			$stmt = sqlsrv_query( $this->conn_cgsi, $sqlContactInfo );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			$contact = [];
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$contact[] = $row;
			}
			return $contact;
		}else{
			echo "Unable to connect<br />";
			die( print_r(sqlsrv_errors(), true));
		}
	}

	public function getEmpStatus() {
		if($this->conn_cgsi){
			//Get Status
			$sqlStatus = "SELECT Status FROM Employee_Info WHERE Status NOT IN('','Active') GROUP BY Status";
			$stmt = sqlsrv_query( $this->conn_cgsi, $sqlStatus );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			$status = [];
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$status[] = $row['Status'];
			}
			return $status;
		}else{
			echo "Unable to connect<br />";
			die( print_r(sqlsrv_errors(), true));
		}
	}

	public function getEmpDepartment() {
		if($this->conn_cgsi){
			//Get Status
			$sqlStatus = "SELECT Department FROM Employee_WH_Details GROUP BY Department";
			$stmt = sqlsrv_query( $this->conn_cgsi, $sqlStatus );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			$status = [];
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$status[] = $row['Department'];
			}
			return $status;
		}else{
			echo "Unable to connect<br />";
			die( print_r(sqlsrv_errors(), true));
		}
	}

	public function getApplicImage($id) {
		if($this->conn_cgsi){
			//Get User
			$sqlImage= "SELECT DISTINCT AppImage FROM Applicant_Image_Details WHERE Applicant_ID = '".$id."'";
			$stmt = sqlsrv_query( $this->conn_cgsi, $sqlImage );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			$image = [];
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$image[] = base64_encode($row['AppImage']);
			}
			return $image;
		}else{
			echo "Unable to connect<br />";
			die( print_r(sqlsrv_errors(), true));
		}
	}

	public function updateInfo($data) {
		if($this->conn_cgsi && $this->conn_cgsi_web){

			if ($data['update_cat'] == "info") {
			
				$getApplicInfo = "SELECT FullName, Applicant_ID, Contact_Number1, Incharge from Applicant_Info WHERE Referrence_Number = '".$data['refid']."'";
				$gAI = sqlsrv_query( $this->conn_cgsi, $getApplicInfo );

				if( $gAI === false) {
					die( print_r( sqlsrv_errors(), true) );
				}

				$rowAI = sqlsrv_fetch_array( $gAI, SQLSRV_FETCH_ASSOC);

				$getContactPInfoOld = "SELECT Contact_Number +','+ RTRIM(LTRIM(Contact_Person)) +','+ Adress as Info from Applicant_FB_Details where Applicant_ID = '".$rowAI['Applicant_ID']."' ";
				$gPCI = sqlsrv_query( $this->conn_cgsi, $getContactPInfoOld );

				$getWHDetails = "SELECT Date_Hired, Comp_Name from Employee_WH_Details where Emp_RefNum = '".$data['refid']."' and Company_ID = '".$data['compid']."' and Date_End = '' ";
				$gWD = sqlsrv_query( $this->conn_cgsi, $getWHDetails );

				if( $gPCI === false || $gWD == false ) {
					die( print_r( sqlsrv_errors(), true) );
				}

				$PCIO = sqlsrv_fetch_array( $gPCI, SQLSRV_FETCH_ASSOC)['Info'];
				$rowWD = sqlsrv_fetch_array( $gWD, SQLSRV_FETCH_ASSOC);

				$updateEmpInfo = "UPDATE Employee_Info SET Contact_Num1 = '".$data['contact']."', Address_1 = '".$data['address']."'
				WHERE Emp_RefNum='".$data['refid']."' and Applicant_ID = '".$rowAI['Applicant_ID']."'";

				$updateAplInfo = "UPDATE Applicant_Info SET Contact_Number1 = '".$data['contact']."'
				WHERE Referrence_Number='".$data['refid']."' and Applicant_ID = '".$rowAI['Applicant_ID']."'";

				$updateFBDetails= "UPDATE Applicant_FB_Details SET Contact_Number = '".$data['contact_number']."', Adress = '".$data['address']."', Contact_Person = '".$data['contact_person']."'
				WHERE Applicant_ID = '".$rowAI['Applicant_ID']."'";

				$InsertBackLogs = "INSERT into HRIS_backdoor_logs(FullName,Applicant_ID,RefNum,Remarks,DateEntry,Incharge,TabTag)
				values ('".$rowAI['FullName']."','".$rowAI['Applicant_ID']."','".$data['refid']."','".$rowAI['Contact_Number1']." - ".$PCIO."','".date('m/d/Y')."','".$rowAI['Incharge']."','WebM')";
				$iBL = sqlsrv_query( $this->conn_cgsi, $InsertBackLogs );

				$uE = sqlsrv_query( $this->conn_cgsi, $updateEmpInfo );
				$uA = sqlsrv_query( $this->conn_cgsi, $updateAplInfo );
				$ufD = sqlsrv_query( $this->conn_cgsi, $updateFBDetails );

				if( $uE === false || $uA == false || $ufD == false || $iBL === false) {
					die( print_r( sqlsrv_errors(), true) );
				} else {
					return true;
				}
				
		} else {

			if ($data['category'] == 'Force Leave' || $data['category'] == 'Maternity') {
				$status = 'Leave';
			} else {
				$status = 'For Process';
			}

			date_default_timezone_set('Australia/Melbourne');
			$date = date('m/d/Y h:i:s', time());

				$Edate=new DateTime($data['effectivedate']);
				$effect_date = date_format($Edate,"m/d/Y");

				$Ldate=new DateTime($data['lastpay']);
				$lastpay = date_format($Ldate,"m/d/Y");

				// $Lduty=new Date($data['lastduty']);
				// $lastduty = date_format($Lduty,"m/d/Y");

				$effective_date = ($data['date_cat'] == 2)? $effect_date : '';
				$last_pay = ($data['date_cat'] == 2)? $lastpay : '';
				$start_date = ($data['date_cat'] == 2)? '' : $lastpay;

				$insert = "INSERT into tbl_UpdateStatusforSV
				(Emp_Refnum,
				RTA_Status,
				Company_ID,
				Category,
				[Reason(s)],
				EffectiveDate,
				LastPay,
				OtherInfo,
				DateHired,
				SV_Incharge,
				Entry_Date,
				Sv_CompanyName,
				M_F_StartDate, 
				Last_Duty)
				values('".$data['refid']."',
				'".$status."'  ,
				'".$data['compid']."' ,
				'".$data['category']."',
				'".$data['reason']."',
				'".$effective_date."',
				'".$last_pay."',
				'".$data['others']."',
				'".$data['datehired']."',
				'".$data['svincharge']."', 
				'".date('m/d/Y')."', 
				'".$data['svcompany']."',
				'".$start_date."',
				'".$data['lastduty']."')";

				$insert_web = "INSERT into tbl_UpdateStatusfromSVLogs
				(Emp_Refnum,
				Status,
				Company_ID,
				Category,
				[Reason(s)],
				EffectiveDate,
				LastPay,
				OtherInfo,
				DateHired,
				SV_Incharge,
				Entry_Date,
				Sv_CompanyName,
				M_F_StartDate,
				Last_Duty)
				values('".$data['refid']."',
				'".$status."'  ,
				'".$data['compid']."' ,
				'".$data['category']."',
				'".$data['reason']."',
				'".$effective_date."',
				'".$last_pay."',
				'".$data['others']."',
				'".$data['datehired']."',
				'".$data['svincharge']."', 
				'".$date."', 
				'".$data['svcompany']."',
				'".$start_date."',
				'".$data['lastduty']."')";

				$ins = sqlsrv_query( $this->conn_cgsi, $insert );
				$insw = sqlsrv_query( $this->conn_cgsi_web, $insert_web );

				if( $ins === false || $insw === false) {
					die( print_r( sqlsrv_errors(), true) );
				} else {
					$update = "UPDATE Employee_Info 
					SET Status = '".$data['category']."'
					WHERE Emp_Refnum = '".$data['refid']."' and Company_ID = '".$data['compid']."'";
					$updte = sqlsrv_query( $this->conn_cgsi, $update );
					if ( $updte === false ) {
						die( print_r( sqlsrv_errors(), true) );
					}
					return true;
				}

			// }
		}

		}else{
			echo "Unable to connect<br />";
			die( print_r(sqlsrv_errors(), true));
		}
	}

	public function assignDepartment($data) {
		if($this->conn_cgsi){ 
			$update_department = "UPDATE Employee_WH_Details 
				SET Department = '".$data['department']."' 
				WHERE Emp_Refnum = '".$data['refid']."' and Company_ID = '".$data['compid']."'";
				// update CSGI DB
				$u = sqlsrv_query( $this->conn_cgsi, $update_department );
				// check connection
				if( $u === false) {
					die( print_r( sqlsrv_errors(), true) );
				} else {
					return true;
				}
		}
	}

	public function checkExist($table, $data) {
		// print_r($data);
		if($this->conn_cgsi){
			$query = "SELECT * from ".$table." WHERE Emp_Refnum = '".$data."'";
			$gAI = sqlsrv_query( $this->conn_cgsi, $query );
			if($gAI) {
				$rows = sqlsrv_has_rows( $gAI );
				if ($rows === true) {
					return true;
				} else {
					return false;
				}
			}
		}
	}

	// public function getUserClient() {
	// 	$sqlCGWeb = "SELECT * FROM CGSI_Users_Web WHERE Username = '".$this->session->username."'";
	// 	$stmt = sqlsrv_query( $this->conn_cgsi_web, $sqlCGWeb );
	// 	if( $stmt === false) {
	// 		die( print_r( sqlsrv_errors(), true) );
	// 	}
		
	// 	$empID = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)['Emp_ID'];

	// 	// Get Client
	// 	$sqlClientSup = "SELECT ClientName, Emp_ID FROM Client_Supervisors WHERE Emp_ID = '".$empID."'";
	// 	$clientQuery = sqlsrv_query( $this->conn_cgsi, $sqlClientSup );
	// 	if( $clientQuery === false) {
	// 		die( print_r( sqlsrv_errors(), true) );
	// 	}

	// 	$getClient = [];
	// 	while( $row_client = sqlsrv_fetch_array( $clientQuery, SQLSRV_FETCH_ASSOC) ) {
	// 		$getClient[] = $row_client['ClientName'];
	// 	}

	// 	return $getClient;
	// }

}
