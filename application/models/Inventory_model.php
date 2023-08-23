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
class Inventory_model extends CI_Model
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

    public function ToBeTransmitted($sessionid) {
        $sql = "SELECT pd.ID, pd.Entry_Date,ri.ItemName,ri.ItemUnit,ri.ItemSize,sum(ri.ItemQty) AS TOTALQTY
            from tbl_podetails pd
            LEFT JOIN tbl_reqdetails rd on pd.PO_Number = rd.PO_Number
            LEFT JOIN tbl_reqitem ri on rd.ReqNum = ri.ReqNum
            where (ri.ItemName LIKE '%COMPUTER %'
            OR RI.ItemName LIKE 'INK'
            OR RI.ItemName LIKE 'INKS'
            OR RI.ItemName LIKE '%LAPTOP%'
            OR RI.ItemName LIKE 'CPU%'
            OR RI.ItemName LIKE 'MONITOR%'
            OR RI.ItemName LIKE 'UPS'
            OR RI.ItemName LIKE 'POWER SUPPLY'
            OR RI.ItemName LIKE 'PRINTER%'
            OR RI.ItemName LIKE 'EPSON%'
            OR RI.ItemName LIKE '%CABLE %'
            OR RI.ItemName LIKE 'COMP. %'
            OR RI.ItemName LIKE '%SWITCH%'
            OR RI.ItemName LIKE '% CELPHONE%'
            OR RI.ItemName LIKE '%FACE RECOGNITION%'
            OR RI.ItemName LIKE 'BIOMETRIC'
            OR RI.ItemName LIKE 'BIOMETRICS'
            OR RI.ItemName LIKE '%DDR%'
            OR RI.ItemName LIKE 'HARD DRIVE%'
            OR RI.ItemName LIKE 'HDD%'
            OR RI.ItemName LIKE '%KEYBOARD%'
            OR RI.ItemName LIKE 'LAN%'
            OR RI.ItemName LIKE '%AVR%'
            OR RI.ItemName LIKE 'SSD%'
            OR RI.ItemName LIKE 'CARTRIDGE%'
            OR RI.ItemName LIKE '%TELEPHONE & SPLITTER%'
            OR RI.ItemName LIKE 'TELEPHONE WIRELESS')
            AND ri.ItemName NOT IN ('COMPREHENSIVE')
            AND  ri.ItemName NOT IN ('COMPLETE WAX' )
            AND ri.ItemUnit !='PAX'
            AND ri.ItemName NOT LIKE '%BUDGET%'
            AND pd.PO_Status = 'Approved' AND pd.PO_StatusTag = '2'
            GROUP BY ri.ItemName";


        $query = $this->emsdb->query($sql);
        return $query->result_array();

    }
	
	public function itemCount($itemName){
        $sql = "SELECT sum(ItemQty) as qty FROM `transmittalslipdetails` WHERE Particulars = '".$itemName."'";
		$query = $this->emsdb->query($sql);
        return $query->result_array();
	}

    public function totalItemCount($item_name) {
        $sql = "SELECT sum(ri.ItemQty) AS TOTALQTY
            from tbl_podetails pd
            LEFT JOIN tbl_reqdetails rd on pd.PO_Number = rd.PO_Number
            LEFT JOIN tbl_reqitem ri on rd.ReqNum = ri.ReqNum
            where RI.ItemName = '".$item_name."'
            AND pd.PO_Status = 'Approved' AND pd.PO_StatusTag = '2'
            GROUP BY ri.ItemName";
        $query = $this->emsdb->query($sql);
        return $query->result_array();

    }


     public function InventoryHistory($sessionid) {
        $sql = "SELECT tsh.transmittal_num,tsh.PulloutNo,tsh.statustag,tsh.datetrans,tsh.Note,tsh.remarks,tsh.Status,ts.PO_Number,concat(ad.f_name,' ', ad.m_name,' ',ad.l_name) as TransmittedTo,ts.DeliveredBy,tsd.ItemQty,tsd.Particulars,tsd.SerialNo,tsh.entrydate,
            concat(tsd.Brand,',',tsd.ToolM) as Description
            FROM transmittalhistory tsh
            inner join transmittalslipdetails tsd on tsh.transmittal_num = tsd.transmittal_Num
            inner join transmittalslip ts on tsh.transmittal_num = ts.transmittal_Num
            inner join tbl_logins ad on ts.TransmittedTo = ad.UserID";
        
        // print_r(sql);
        $query = $this->emsdb->query($sql);
        return $query->result_array();

    }

      public function PulloutHistory($sessionid) {
        $sql = "SELECT pu.PU_CreatedDate,pu.PulloutNo,pu.transNum,concat(ad.f_name,' ', ad.m_name,' ',ad.l_name) as Name,pu.PU_Department,pd.pu_Particulars,pd.pu_ItemQty,pu.PreparedBy  FROM `pullout` pu
inner join pulloutdetails pd on pu.PulloutNo = pd.pulloutno
inner join tbl_logins ad on pu.PU_Name = ad.UserID";
        
        // print_r(sql);
        $query = $this->emsdb->query($sql);
        return $query->result_array();

    }

    public function inventorydetails($itemName){
        $sql = "SELECT pd.Entry_Date,PI.Invoice_Number,pd.Delivery_Date,rd.PO_Number,rd.Requester,
        ri.ItemName,ri.ItemDesc,ri.ItemUnit,ri.ItemSize, ri.itemQty as totalQty,ts.transmittal_Num,
        ts.TransmittedTo,tsd.itemStatus,tsd.ItemQty as Qty,pd.Note
        FROM tbl_podetails pd 
        INNER JOIN tbl_reqdetails rd on pd.PO_Number = rd.PO_Number
        LEFT JOIN tbl_poinvoice PI on pd.PO_Number=pi.PO_Number
        LEFT JOIN transmittalslip ts on pd.PO_Number =ts.PO_Number
        LEFT JOIN transmittalslipdetails tsd on ts.transmittal_Num=tsd.transmittal_Num
        INNER JOIN tbl_reqitem ri on rd.ReqNum=ri.ReqNum
        WHERE ri.ItemName like '".urldecode($itemName)."'";
         $query = $this->emsdb->query($sql);
        return $query->result_array();
    }

     public function inventorylist($itemName,$lastUriSegment){
        //print_r ($lastUriSegment);
        
        if($lastUriSegment == 1){
            $item ='ItemName';

        }

         if($lastUriSegment == 2){
            $item ='ItemDesc';

        }

        $sql = "SELECT pd.Entry_Date,PI.Invoice_Number,pd.Delivery_Date,rd.PO_Number,rd.Requester,
        ri.ItemName,ri.ItemDesc,ri.ItemUnit,ri.ItemSize, ri.itemQty as totalQty,ts.transmittal_Num,
        ts.TransmittedTo,tsd.itemStatus,tsd.ItemQty as Qty,tsd.itemRemarks, ttt.Deliveryreceipt, ttt.Amount
        FROM tbl_podetails pd 
        INNER JOIN tbl_reqdetails rd on pd.PO_Number = rd.PO_Number
        LEFT JOIN tbl_poinvoice PI on pd.PO_Number=pi.PO_Number
        LEFT JOIN transmittalslip ts on pd.PO_Number =ts.PO_Number
        LEFT JOIN transmittalslipdetails tsd on ts.transmittal_Num=tsd.transmittal_Num
        INNER JOIN tbl_reqitem ri on rd.ReqNum=ri.ReqNum
        LEFT JOIN tbl_transin_transout ttt on pd.PO_Number = ttt.PO_Number 
        WHERE ri.".$item." LIKE '".urldecode($itemName)."'";
        
         $query = $this->emsdb->query($sql);
        return $query->result_array();
    }

    public function itemCountbyName($itemName,$lastUriSegment){
        // print_r ($lastUriSegment);
        
        if($lastUriSegment == 1){
            $item ='ItemName';

        }

         if($lastUriSegment == 2){
            $item ='ItemDesc';

        }

    $sql = " SELECT SUM(ri.itemQty) as totalitems
        FROM tbl_podetails pd 
        INNER JOIN tbl_reqdetails rd on pd.PO_Number = rd.PO_Number
        LEFT JOIN tbl_poinvoice PI on pd.PO_Number=pi.PO_Number
        LEFT JOIN transmittalslip ts on pd.PO_Number =ts.PO_Number
        LEFT JOIN transmittalslipdetails tsd on ts.transmittal_Num=tsd.transmittal_Num
        INNER JOIN tbl_reqitem ri on rd.ReqNum=ri.ReqNum
        LEFT JOIN tbl_transin_transout ttt on pd.PO_Number = ttt.PO_Number 
        WHERE ri.".$item." LIKE '".urldecode($itemName)."'";
 $query = $this->emsdb->query($sql);
        return $query->result_array();
        

    }

     public function inventorylists($itemName){
        $sql = "SELECT pd.Entry_Date,PI.Invoice_Number,pd.Delivery_Date,rd.PO_Number,rd.Requester,
        ri.ItemName,ri.ItemDesc,ri.ItemUnit,ri.ItemSize, ri.itemQty as totalQty,ts.transmittal_Num,
        ts.TransmittedTo,tsd.itemStatus,tsd.ItemQty as Qty,tsd.itemRemarks
        FROM tbl_podetails pd 
        INNER JOIN tbl_reqdetails rd on pd.PO_Number = rd.PO_Number
        LEFT JOIN tbl_poinvoice PI on pd.PO_Number=pi.PO_Number
        LEFT JOIN transmittalslip ts on pd.PO_Number =ts.PO_Number
        LEFT JOIN transmittalslipdetails tsd on ts.transmittal_Num=tsd.transmittal_Num
        INNER JOIN tbl_reqitem ri on rd.ReqNum=ri.ReqNum
        WHERE ri.ItemDesc like '".urldecode($ItemDesc)."'";
        
         $query = $this->emsdb->query($sql);
        return $query->result_array();
    }


	public function transmitteditems($sessionid){
		
        $sql = "SELECT pd.Delivery_Date,pi.Invoice_Number as invoice,tsd.transmittal_Num as transnum,tsd.ItemQty as qty,tsd.Particulars as name,tsd.Brand as brand,tsd.ToolM as toolmodel,tsd.SerialNo as SN,concat(ls.f_name,' ', ls.m_name,' ',ls.l_name) as TransmittedTo ,ts.DateTrans,ts.DeliveredBy as db,ts.StatusTag,tsd.itemStatus,tsd.itemRemarks,ts.Note,ts.PO_Number as PO, max(tsh.entrydate) as datetransfered
        from transmittalslipdetails tsd
        inner join transmittalslip ts on tsd.transmittal_Num = ts.transmittal_Num
        left join tbl_podetails pd on ts.PO_Number = pd.PO_Number
        left join tbl_poinvoice pi on ts.PO_Number = pi.PO_Number
        inner join transmittalhistory tsh on ts.transmittal_Num = tsh.transmittal_num
        inner join tbl_logins ls on ts.TransmittedTo = ls.UserID
        WHERE tsd.itemStatus !='Pullout' GROUP by ts.transmittal_Num ";
        
         $query = $this->emsdb->query($sql);
        return $query->result_array();
    }
    public function Pulloutitems($sessionid){
        
        $sql = "SELECT pu.PU_CreatedDate,pu.PulloutNo,pu.transNum,concat(ls.f_name,' ', ls.m_name,' ',ls.l_name) as PU_Name,concat(pu.PU_Department,' ', 'DEPARTMENT') AS Department,pu.PU_status,pu.PU_Note,pu.StatusofStaffClient,pu.PreparedBy,pu.DateTrans,
            pud.pu_ItemQty,pud.pu_Particulars,pud.pu_Brand as bd ,pud.pu_ToolM as tl , pud.pu_SerialNo as s_n ,pud.pu_itemRemarks,pud.pu_itemStatus
            from pullout pu
            inner join pulloutdetails pud on pu.PulloutNo = pud.pulloutno
            inner join tbl_logins ls on pu.PU_Name = ls.UserID
            where pud.pu_itemStatus ='Pullout'
            GROUP by pu.PulloutNo";
        
         $query = $this->emsdb->query($sql);
        return $query->result_array();
    }
     public function Inventory($sessionid){
        
        $sql = "SELECT pd.Entry_Date,ri.ItemName,ri.ItemUnit,ri.ItemSize,sum(ri.ItemQty) AS TOTALQTY,tsd.itemStatus,tsd.itemRemarks
            from tbl_podetails pd
            LEFT JOIN tbl_reqdetails rd on pd.PO_Number = rd.PO_Number
            LEFT JOIN tbl_reqitem ri on rd.ReqNum = ri.ReqNum
            INNER JOIN transmittalslip ts on rd.PO_Number=ts.PO_Number
            INNER JOIN transmittalslipdetails tsd on
            ts.transmittal_Num=tsd.transmittal_Num
            where (ri.ItemName LIKE '%COMPUTER %'
            OR RI.ItemName LIKE 'OFFICE TABLE AND CHAIRS%'
            OR RI.ItemName LIKE 'INK'
            OR RI.ItemName LIKE 'INKS'
            OR RI.ItemName LIKE '%LAPTOP%'
            OR RI.ItemName LIKE 'CPU%'
            OR RI.ItemName LIKE 'MONITOR%'
            OR RI.ItemName LIKE 'UPS'
            OR RI.ItemName LIKE 'POWER SUPPLY'
            OR RI.ItemName LIKE 'PRINTER%'
            OR RI.ItemName LIKE 'EPSON%'
            OR RI.ItemName LIKE '%CABLE %'
            OR RI.ItemName LIKE 'COMP. %'
            OR RI.ItemName LIKE '%SWITCH%'
            OR RI.ItemName LIKE '% CELPHONE%'
            OR RI.ItemName LIKE '%FACE RECOGNITION%'
            OR RI.ItemName LIKE 'BIOMETRIC'
            OR RI.ItemName LIKE 'BIOMETRICS'
            OR RI.ItemName LIKE '%DDR%'
            OR RI.ItemName LIKE 'HARD DRIVE%'
            OR RI.ItemName LIKE 'HDD%'
            OR RI.ItemName LIKE '%KEYBOARD%'
            OR RI.ItemName LIKE 'LAN%'
            OR RI.ItemName LIKE '%AVR%'
            OR RI.ItemName LIKE 'SSD%'
            OR RI.ItemName LIKE 'CARTRIDGE%'
            OR RI.ItemName LIKE '%TELEPHONE & SPLITTER%'
            OR RI.ItemName LIKE 'TELEPHONE WIRELESS')
            AND ri.ItemName NOT IN ('COMPREHENSIVE')
            AND  ri.ItemName NOT IN ('COMPLETE WAX' )
            AND ri.ItemUnit !='PAX'
            and ts.transmittal_Num!=''
            AND pd.PO_Status = 'Approved' AND pd.PO_StatusTag = '2'
            GROUP BY ri.ItemName";
        
         $query = $this->emsdb->query($sql);
        return $query->result_array();
    }

    public function InventoryRecipient($sessionid,$Particulars){
        $sql = "SELECT ts.Delivery_Date,ts.PO_Number,ts.Invoice_Number,concat(lg.f_name,' ', lg.m_name,' ',lg.l_name) as TransmittedTo,ts.transmittal_Num as invtransnum,tsd.Particulars,tsd.ItemQty,rd.Requester,ts.DateTrans,ts.DeliveredBy,tsd.itemRemarks,ts.Note
            FROM transmittalslip ts
            inner join transmittalslipdetails tsd on ts.transmittal_Num=tsd.transmittal_Num
            left join tbl_reqdetails rd on ts.PO_Number = rd.PO_Number
            inner join tbl_logins lg on ts.TransmittedTo = lg.UserID
            where tsd.Particulars like '$Particulars'";


        $query = $this->emsdb->query($sql);
        return $query->result_array();
                                                                                                                                                                                                                                                                                                                              
    }


     public function Officesupplies($sessionid) {
        $sql = "SELECT rd.Entry_Date,ri.ItemDesc,ri.ItemSize,ri.ItemUnit,sum(ri.ItemQty) as totalqty, rd.PO_Number FROM `tbl_reqitem` ri 
        inner join tbl_reqdetails rd on ri.ReqNum = rd.ReqNum
        where ItemName like 'OFFICE SUPPLIES' and ItemDesc!='0' GROUP BY ItemDesc";


        $query = $this->emsdb->query($sql);
        return $query->result_array();

    }

      public function equipments($sessionid) {
        $sql = "SELECT ts.DateTrans,tsd.Particulars,tsd.itemunit,tsd.itemsize,count(tsd.ItemQty) as totalQty,tsd.itemRemarks
        from transmittalslipdetails tsd
        inner join transmittalslip ts on tsd.transmittal_Num=ts.transmittal_Num
        where (tsd.Particulars LIKE '%COMPUTER %'
        OR tsd.Particulars LIKE 'OFFICE TABLE AND CHAIRS%'
        OR tsd.Particulars LIKE '%INK%'
        OR tsd.Particulars LIKE 'INKS'
        OR tsd.Particulars LIKE '%LAPTOP%'
        OR tsd.Particulars LIKE 'CPU%'
        OR tsd.Particulars LIKE 'MONITOR%'
        OR tsd.Particulars LIKE 'UPS'
        OR tsd.Particulars LIKE 'POWER SUPPLY'
        OR tsd.Particulars LIKE '%PRINTER%'
        OR tsd.Particulars LIKE '%CABLE %'
                                    OR tsd.Particulars LIKE 'COMP. %'
                                    OR tsd.Particulars LIKE '%SWITCH%'
                                    OR tsd.Particulars LIKE '% CELPHONE%'
                                    OR tsd.Particulars LIKE '%FACE RECOGNITION%'
                                    OR tsd.Particulars LIKE 'BIOMETRIC'
                                    OR tsd.Particulars LIKE 'BIOMETRICS'
                                    OR tsd.Particulars LIKE '%DDR%'
                                    OR tsd.Particulars LIKE 'HARD DRIVE%'
                                    OR tsd.Particulars LIKE 'HDD%'
                                    OR tsd.Particulars LIKE '%KEYBOARD%'
                                    OR tsd.Particulars LIKE 'LAN%'
                                    OR tsd.Particulars LIKE '%AVR%'
                                    OR tsd.Particulars LIKE 'SSD%'
                                    OR tsd.Particulars LIKE 'CARTRIDGE%'
                                    OR tsd.Particulars LIKE '%TELEPHONE & SPLITTER%'
                                    OR tsd.Particulars LIKE 'TELEPHONE WIRELESS')
                                GROUP by tsd.particulars";


        $query = $this->emsdb->query($sql);
        return $query->result_array();

    }

     public function chemicals($sessionid) {
        $sql = "SELECT rd.Entry_Date,ri.ItemDesc,ri.ItemSize,ri.ItemUnit,sum(ri.ItemQty) as totalqty, rd.PO_Number FROM `tbl_reqitem` ri 
        inner join tbl_reqdetails rd on ri.ReqNum = rd.ReqNum
        where ItemName like 'CHEMICALS' GROUP BY ItemDesc";


        $query = $this->emsdb->query($sql);
        return $query->result_array();

    }

      public function uniforms($sessionid) {
        $sql = "SELECT rd.Entry_Date,ri.ItemDesc,ri.ItemSize,ri.ItemUnit,sum(ri.ItemQty) as totalqty, rd.PO_Number FROM `tbl_reqitem` ri 
        inner join tbl_reqdetails rd on ri.ReqNum = rd.ReqNum
        where ItemName like 'UNIFORMS' GROUP BY ItemDesc";


        $query = $this->emsdb->query($sql);
        return $query->result_array();

    }

      public function cleaningsupp($sessionid) {
        $sql = "SELECT rd.Entry_Date,ri.ItemDesc,ri.ItemSize,ri.ItemUnit,sum(ri.ItemQty) as totalqty, rd.PO_Number FROM `tbl_reqitem` ri 
        inner join tbl_reqdetails rd on ri.ReqNum = rd.ReqNum
        where ItemName like 'CLEANING SUPPLIES' GROUP BY ItemDesc";


        $query = $this->emsdb->query($sql);
        return $query->result_array();

    }
	
	public function EmployeeList($sessionid){
        $sql = "SELECT concat(ls.f_name,' ',if(ls.m_name is not null, concat(' (',ls.m_name,')'), ''),' ',ls.l_name, ' - ', ds.designationname) as Name, ls.UserID,
        dp.departmentname,ds.designationname
        FROM `tbl_logins` ls
        INNER JOIN tbl_department dp on ls.department = dp.departmentid
        INNER JOIN tbl_designation ds on ls.designation = ds.designationID
        INNER JOIN users u on ls.UserID = u.emp_id
        where u.emp_status!='3'";
        
         $query = $this->emsdb->query($sql);
        return $query->result_array();
    }

    public function getEmpName($id){
        $where = "WHERE UserID = '".$id."'";
        $sql = "SELECT concat(ls.f_name,' ', ls.m_name,' ',ls.l_name, ' - ', ds.designationname) as Name, UserID,
        dp.departmentname,ds.designationname
        FROM `tbl_logins` ls 
        INNER JOIN tbl_department dp on ls.department = dp.departmentid
        INNER JOIN tbl_designation ds on ls.designation = ds.designationID ".$where."";
        
         $query = $this->emsdb->query($sql);
        return $query->result_array();
    }

    public function departmentlist(){
        
        $sql = " SELECT * FROM `tbl_department`";
         $query = $this->emsdb->query($sql);
        return $query->result_array();
    }

   

    public function deliveredby(){
        
        $sql = "SELECT td.*,concat(u.firstname,' ', u.middlename,' ',u.lastname) as Name FROM  tbl_deliveryby td LEFT JOIN users u ON td.empid = u.emp_id ";
        
        $query = $this->emsdb->query($sql);
        return $query->result_array();
    }

    public function Transmitted() {
        if($this->conn_cgsi){
            //Connect sql server
			$sql = "SELECT ts.*, tsl.*
			FROM TransmittalSlipNormalize ts
			LEFT JOIN TransmittalSlip tsl on tsl.ID_no = ts.ID_no
			ORDER BY ts.ID_no DESC";
			$stmt = sqlsrv_query( $this->conn_cgsi, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			$trans = [];
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$trans[] = $row;
			}
            // return array_merge($trans, $trans_item);
			return $trans;
		}else{
			echo "Unable to connect<br />";
			die( print_r(sqlsrv_errors(), true));
		}
    }

    public function transmittedNew() {
        //Web Transmitted
        $sql = "SELECT tsd.*, ts.*, tsd.id as tsdetailsid FROM transmittalslip ts INNER JOIN transmittalslipdetails tsd ON ts.transmittal_Num = tsd.transmittal_Num
        where tsd.ItemQty != 0";


        $query = $this->emsdb->query($sql);
        return $query->result_array();
    }

    public function TransNo() {
        if($this->conn_cgsi){
            $sql = "SELECT MAX(transmittal_Num) as maxtransnum FROM `transmittalslip`";
            $query = $this->emsdb->query($sql);
            $tranNumWeb = $query->result_array()[0]['maxtransnum'];
			return $tranNumWeb + 1;
		}else{
			echo "Unable to connect<br />";
			die( print_r(sqlsrv_errors(), true));
		}
    }

    public function PullOutNo() {
        $sql = "SELECT MAX(PulloutNo) as maxpulloutnum FROM `pullout`";
        $query = $this->emsdb->query($sql);
        $PulloutNo = $query->result_array()[0]['maxpulloutnum'];
        return $PulloutNo + 1;
    }

	public function brands() {
        if($this->conn_cgsi){

			$sql = "SELECT Brand FROM [CGSI].[dbo].[TransmittalSlip] WHERE BRAND NOT LIKE '%REPLACEMENT' AND BRAND NOT IN ('2','','1') GROUP BY Brand";
			$stmt = sqlsrv_query( $this->conn_cgsi, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			$trans = [];
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$trans[] = $row;
			}
			return $trans;
		}else{
			echo "Unable to connect<br />";
			die( print_r(sqlsrv_errors(), true));
		}
    }

    public function addTransmittedItems($data) {

        $add_transnum = $_POST['add_transnum'];
        $add_ponumber= $_POST['add_ponumber'];
        $add_to=$_POST['add_to'];
        $add_DateTrans=$_POST['add_DateTrans'];
		$add_deliveredby=$_POST['add_deliveredby'];
		$add_Invoicenum= $_POST['add_Invoicenum'];

        foreach($data['add_ItemQty'] as $index => $add)
        {
            $qty = $add;
            $particulars =$data['add_Particulars'][$index];
            $brand =$data['add_Brand'][$index];
            $toolModel =$data['add_ToolM'][$index];
            $serialno =$data['add_SerialNo'][$index];


			$sql = "INSERT INTO `transmittalslipdetails`(`transmittal_Num`, `ItemQty`, `Particulars`, `Brand`, `ToolM`, `SerialNo`,`itemStatus`, `itemRemarks`) VALUES ('$add_transnum','$qty','$particulars','$brand','$toolModel','$serialno','Transmit','Functional')";
			$q = $this->emsdb->query($sql);

        }

		if ($q) {
			$inserttransslip ="INSERT INTO `transmittalslip`( PO_Number, transmittal_Num, TransmittedTo, DateTrans, DeliveredBy, StatusTag, Status, Remarks,Note,Delivery_Date, Invoice_Number) VALUES ('$add_ponumber','$add_transnum','$add_to',CURRENT_TIMESTAMP,'$add_deliveredby','1','','','','','$add_Invoicenum')"; 
			$q2 = $this->emsdb->query($inserttransslip);

			if($q) {
				$history="INSERT INTO `transmittalhistory`(`transmittal_num`, `PulloutNo`, `statustag`, `status`, `remarks`, `datetrans`, `entrydate`, `Note`,TransmittedTo) VALUES ('$add_transnum','','1','Transmit','Functional',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'','$add_to')";
				$this->emsdb->query($history);
			}
		}

    }

    public function savePullOutItems($data) {

        $pulloutdata = explode('~',$data['pulloutData']);
        $pulloutdetails = explode('~', $data['pulloutDetails']);

        $add_transnum = $pulloutdata[0];
        $add_transto = $pulloutdata[1];
        $add_dtrans = $pulloutdata[2];

        $add_ploutno = $pulloutdetails[0];
        $add_particulrs = $pulloutdetails[1];
        $add_brand = $pulloutdetails[2];
        $add_tolm = $pulloutdetails[3];
        $add_serno = $pulloutdetails[4];
        $id = $pulloutdetails[5];
        $add_prepby = $data['prep_by'];

        $add_ploutqty = $data['pulloutqty'];
        $add_ploremarks = $data['pulloutremarks'];
        
        $sqlhistory = "INSERT INTO `transmittalhistory`( `transmittal_num`, `PulloutNo`, `statustag`, `status`, `remarks`, `datetrans`, `entrydate`, `Note`, `transmittedTo`) VALUES ('$add_transnum',' $add_ploutno','1','Pullout','$add_ploremarks','$add_dtrans',CURRENT_TIMESTAMP,'','$add_transto')";
        $historydata = $this->emsdb->query($sqlhistory);

		$sql = "INSERT INTO `pullout`(`PulloutNo`, `transNum`, `PU_Name`, `PU_Department`, `PU_status`, `PU_Note`,`StatusofStaffClient`, `PreparedBy`,`prev_owner`,`DateTrans`) VALUES ('$add_ploutno','$add_transnum','$add_transto','MIS','Pullout','','Active','$add_prepby','$add_transto','$add_dtrans')";
		$qpdata = $this->emsdb->query($sql);

        $sqldetails = "INSERT INTO `pulloutdetails`(`pulloutno`, `pu_ItemQty`, `pu_particulars`, `pu_Brand`, `pu_ToolM`, `pu_SerialNo`,`pu_itemStatus`, `pu_itemRemarks`,`pu_transnum`) VALUES ('$add_ploutno','$add_ploutqty','$add_particulrs','$add_brand','$add_tolm','$add_serno','Pullout','$add_ploremarks','$add_transnum')";

        if($sql && $sqldetails && $historydata)
        {
            $sqlCount = "SELECT COUNT(ItemQty) as qty FROM transmittalslipdetails where id='$id'";

            $query = $this->emsdb->query($sqlCount);
            $itemqty = $query->result_array()[0]['qty'];
            print_r($itemqty);
            $itemqtyval = ($itemqty - $add_ploutqty);

            $sqlupdate ="UPDATE transmittalslipdetails SET ItemQty='$itemqtyval',itemStatus='Pullout',itemRemarks='$add_ploremarks' WHERE id='$id'";
            $this->emsdb->query($sqlupdate);
        }

		$qpudetails = $this->emsdb->query($sqldetails);

        if($qpdata && $qpudetails && $historydata) {
            return true;
        }

    }


    public function saveTransmitall($data, $options = [], $options2 = [])
    {

		$insert = [
            'PO_Number' => isset($data['PO_Number'])? $data['PO_Number']: 0,
			'transmittal_Num' => isset($data['transmittal_Num'])? $data['transmittal_Num']: 0,
			'TransmittedTo' => $data['TransmittedTo'],
			'DeliveredBy' => $data['DeliveredBy'],
			'Delivery_Date' => $data['Delivery_Date'],
            'Invoice_Number' => $data['invoice_number']
		];

        $transmittal = [
            'transmittal_Num' => isset($data['transmittal_Num'])? $data['transmittal_Num']: '',
            'ItemQty' => isset($data['qty'])? $data['qty']: 0,
            'Particulars' => isset($data['Particulars'])? $data['Particulars']: '',
            'Brand' =>  isset($data['Brands'])? $data['Brands']: '',  
            'ToolM' => isset($data['ToolM'])? $data['ToolM']: '',  
            'SerialNo' => isset($data['SerialNo'])? $data['SerialNo']: '',  
            'itemStatus' => 'Transmit',  
            'itemRemarks' => 'Functional',  
        ];

        foreach ($options as $key => $value) {
            $insert[$key] = $value;
        }

        foreach ($options2 as $key2 => $value2) {
            $transmittal[$key2] = $value2;
        }

        $insert_trans = $this->emsdb->insert('transmittalslip', $insert);
        $insert_slip = $this->emsdb->insert('transmittalslipdetails', $transmittal);
        if($insert_trans || $insert_slip ) {
			return true;
		}
    }
    
	public function getEmployee($userid) {
		$sql = "SELECT u.emp_id, u.firstname, u.middlename, u.lastname, tdep.departmentid, tdep.departmentname,tdesig.designationID,  tdesig.designationname
		FROM users u 
			LEFT JOIN tbl_designation tdesig
			ON u.emp_designation = tdesig.designationID
			LEFT JOIN tbl_department tdep 
			ON tdesig.department = tdep.departmentid
		WHERE u.emp_id = '$userid'";
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}
  
    public function saveReceiptInfo($data, $options = []) {
        $insert_data = array(
			'PO_Number' => $data['PO_Number'],
            'Deliveryreceipt' => $data['delivery_receipt'],
            'Amount' => $data['amount']
		);
        foreach ($options as $key => $value) {
            $insert_data[$key] = $value;
        }
		// $this->emsdb->where('UserID', $data['idnumber']);
		// return $this->emsdb->update('tbl_transin_transout',$insert_data);
        return $this->emsdb->insert('tbl_transin_transout',$insert_data);
    }
}
