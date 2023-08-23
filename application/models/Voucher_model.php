<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Users Model Class
 *
 * @package     CGSI Portal
 * @subpackage  Models
 * @category    Users
 * @author      Zniv Zdiv <vinzadz1987@gmail.com>
 * @link        https://github.com/inibah97
 */
class Voucher_model extends CI_Model
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

    public function getVoucher($sessionid, $status, $location, $status_tag) {

		// location, $po_status, $location, $status_tag
		if ($location == 'Vis') {
			$tbl = 'tbl_voucher';
			// $tblhist = 'tbl_pohistory';
		} else {
			$tbl = 'tbll_voucher';
			// $tblhist = 'tbll_pohistory';
		}

		
		$sql = "SELECT * FROM  ".$tbl." v WHERE Voucher_Stat = '".$status."' AND Voucher_StatTAg = '".$status_tag."' ORDER BY v.Voucher_Num ASC";
		

		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function VoucherVisayas_history($sessionid) {
		if($sessionid == '300109'){
		$sql = "SELECT v.Voucher_Num,v.PO_Numbers,v.Payee,vh.Entry_Date,vh.Remarks,v.Voucher_Stat,(CASE
			WHEN vh.V_StatusTag = 2 and vh.V_Status = 'Approved' THEN 'Approved'
			WHEN vh.V_StatusTag = 2 and vh.V_Status = 'Returned' THEN 'Returned'
			WHEN vh.V_StatusTag = 2 and vh.V_Status = 'Rejected' THEN 'Rejected'
			WHEN vh.V_StatusTag = 3 and vh.V_Status = 'Approved' THEN 'Approved by Maam Rose Perez'
			WHEN vh.V_StatusTag = 3 and vh.V_Status = 'Returned' THEN 'Rejected by Maam Rose Perez'
			WHEN vh.V_StatusTag = 3 and vh.V_Status = 'Rejected' THEN 'Rejected by Maam Rose Perez' END )as StatusByReceiver 
		FROM tbl_voucher v
		inner join `tbl_voucherhistory` vh
		on v.Voucher_Num = vh.Voucher_Num 
		where v.Voucher_Stat !='Pending' and vh.V_StatusTag !='1'  
		GROUP BY vh.Voucher_Num
		ORDER BY  `vh`.`Entry_Date` DESC";
	} else{
		$sql = "SELECT v.Voucher_Num,v.PO_Numbers,v.Payee,vh.Entry_Date,vh.Remarks,v.Voucher_Stat,
		(CASE WHEN vh.V_StatusTag = 1 and vh.V_Status = 'Approved' THEN 'For Approval Maam Grace or Maam Perez'
			WHEN vh.V_StatusTag = 1 and vh.V_Status = 'Rejected' THEN 'Rejected'
			WHEN vh.V_StatusTag = 1 and vh.V_Status = 'Returned' THEN 'Returned'
			WHEN vh.V_StatusTag = 2 and vh.V_Status = 'Approved' THEN 'Approved by Maam Grace'
			WHEN vh.V_StatusTag = 2 and vh.V_Status = 'Returned' THEN 'Returned by Maam Grace'
			WHEN vh.V_StatusTag = 2 and vh.V_Status = 'Rejected' THEN 'Rejected by Maam Grace'
			WHEN vh.V_StatusTag = 3 and vh.V_Status = 'Approved' THEN 'Approved by Maam Rose Perez'
			WHEN vh.V_StatusTag = 3 and vh.V_Status = 'Returned' THEN 'Rejected by Maam Rose Perez'
			WHEN vh.V_StatusTag = 3 and vh.V_Status = 'Rejected' THEN 'Rejected by Maam Rose Perez' END )as StatusByReceiver 
		FROM tbl_voucher v
		inner join `tbl_voucherhistory` vh
		on v.Voucher_Num = vh.Voucher_Num 
		where v.Voucher_Stat !='Pending' and vh.V_StatusTag !='1' 
		GROUP BY vh.Voucher_Num
		ORDER BY  `vh`.`Entry_Date` DESC";
	}

		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function VoucherLuzon_history($sessionid) {
		if($sessionid == '300109'){
		$sql = "SELECT v.Voucher_Num,v.PO_Numbers,v.Payee,vh.Entry_Date,vh.Remarks,v.Voucher_Stat,(CASE
			WHEN vh.V_StatusTag = 2 and vh.V_Status = 'Approved' THEN 'Approved'
			WHEN vh.V_StatusTag = 2 and vh.V_Status = 'Returned' THEN 'Returned'
			WHEN vh.V_StatusTag = 2 and vh.V_Status = 'Rejected' THEN 'Rejected'
			WHEN vh.V_StatusTag = 3 and vh.V_Status = 'Approved' THEN 'Approved by Maam Rose Perez'
			WHEN vh.V_StatusTag = 3 and vh.V_Status = 'Returned' THEN 'Rejected by Maam Rose Perez'
			WHEN vh.V_StatusTag = 3 and vh.V_Status = 'Rejected' THEN 'Rejected by Maam Rose Perez' END )as StatusByReceiver 
		FROM tbll_voucher v
		inner join `tbll_voucherhistory` vh
		on v.Voucher_Num = vh.Voucher_Num 
		where v.Voucher_Stat !='Pending' and vh.V_StatusTag !='1'  
		GROUP BY vh.Voucher_Num
		ORDER BY  `vh`.`Entry_Date` DESC";
	} else{
		$sql = "SELECT v.Voucher_Num,v.PO_Numbers,v.Payee,vh.Entry_Date,vh.Remarks,v.Voucher_Stat,
		(CASE WHEN vh.V_StatusTag = 1 and vh.V_Status = 'Approved' THEN 'For Approval Maam Grace or Maam Perez'
			WHEN vh.V_StatusTag = 1 and vh.V_Status = 'Rejected' THEN 'Rejected'
			WHEN vh.V_StatusTag = 1 and vh.V_Status = 'Returned' THEN 'Returned'
			WHEN vh.V_StatusTag = 2 and vh.V_Status = 'Approved' THEN 'Approved by Maam Grace'
			WHEN vh.V_StatusTag = 2 and vh.V_Status = 'Returned' THEN 'Returned by Maam Grace'
			WHEN vh.V_StatusTag = 2 and vh.V_Status = 'Rejected' THEN 'Rejected by Maam Grace'
			WHEN vh.V_StatusTag = 3 and vh.V_Status = 'Approved' THEN 'Approved by Maam Rose Perez'
			WHEN vh.V_StatusTag = 3 and vh.V_Status = 'Returned' THEN 'Rejected by Maam Rose Perez'
			WHEN vh.V_StatusTag = 3 and vh.V_Status = 'Rejected' THEN 'Rejected by Maam Rose Perez' END )as StatusByReceiver 
		FROM tbll_voucher v
		inner join `tbll_voucherhistory` vh
		on v.Voucher_Num = vh.Voucher_Num 
		where v.Voucher_Stat !='Pending' and vh.V_StatusTag !='1' 
		GROUP BY vh.Voucher_Num
		ORDER BY  `vh`.`Entry_Date` DESC";
	}

		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function voucherdetails($sessionid,$voucherno,$lastUriSegment)
	{

		if ($lastUriSegment == 1) {
			$tbl = 'tbl_voucher';
			$tblpod ='tbl_podetails';
			$tblpoh ='tbl_pohistory';

		} else {
			$tbl = 'tbll_voucher';
			$tblpod ='tbll_podetails';
			$tblpoh ='tbll_pohistory';

		}

			$sql = "SELECT tv.*,tp.PO_Number, MAX(th.PO_ApprovedDate) ApprovedDate 
			from ".$tbl." tv
				left join ".$tblpod." tp on tv.Voucher_Num = tp.Voucher_Num
				LEFT JOIN ".$tblpoh." th on tp.PO_Number = th.PO_Number
				where tv.voucher_num='$voucherno'";
		

		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function voucherdetails2($sessionid,$voucherno,$lastUriSegment)
	{

			if ($lastUriSegment == 1) {
			$tbl = 'tbl_v_journaldetails';
			$tblv ='tbl_voucher';
		

		} else {
			$tbl = 'tbll_v_journaldetails';
			$tblv ='tbll_voucher';
		

		}

			$sql = "SELECT v.*,jd.*
			FROM  ".$tbl." jd 				
			inner join ".$tblv." v on jd.Voucher_Num = v.Voucher_Num 
			where v.voucher_num='$voucherno'";
		

		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function voucherviewpodetails($sessionid,$voucherno,$lastUriSegment)
	{
		if ($lastUriSegment == 1) {
			$tbl = 'tbl_voucher';
			$tblpd ='tbl_podetails';
		

		} else {
			$tbl = 'tbll_voucher';
			$tblpd ='tbll_podetails';
		
		}

		$sql = "SELECT tv.*,tp.* from ".$tbl." tv
								left join ".$tblpd." tp on tv.Voucher_Num = tp.Voucher_Num
								where tv.voucher_num='$voucherno'";

 		$query = $this->emsdb->query($sql);
		return $query->result_array();

	}

	public function voucherpoitems($voucherno,$site)
	{

		if($site =='1'){
			$tbl = 'tbl_reqitem';
			$tbl1 = 'tbl_reqdetails';
		}else
		{
			$tbl = 'tbll_reqitem';
			$tbl1 = 'tbll_reqdetails';
		}

		$sql = "SELECT trdt.PO_Number,trt.ItemID,trt.ReqNum,ItemName,ItemUnit,
                        ItemDesc,(case when ItemQty = '0' then '' ELSE ItemQty end ) as ItemQty,
                        ItemCost,Total_Cost
                        FROM ".$tbl." trt 
                        left join ".$tbl1." trdt on trt.ReqNum = trdt.ReqNum
                        where trdt.PO_Number = '$voucherno'";

 		$query = $this->emsdb->query($sql);
		return $query->result_array();

	}
	public function vouchervatsale($voucherno)
	{
		
		$sql = "SELECT trdt.PO_Number,tpd.PO_Supplier,tpd.Address,tpd.CellNo,tpd.Order_Date,tpd.Delivery_Date,tpd.Cancel_Date,tpd.TOP, GROUP_CONCAT(trt.ItemID SEPARATOR ', ') as ItemID,trt.ReqNum,tpd.PO_Status as POStat,
 						GROUP_CONCAT(ItemUnit SEPARATOR ', ') as ItemUnit,
 						GROUP_CONCAT(ItemDesc SEPARATOR ', ') as ItemDesc,
 						GROUP_CONCAT((case when ItemQty = '0' then '' ELSE ItemQty end ) SEPARATOR ', ') as ItemQty,
 						GROUP_CONCAT(ItemCost SEPARATOR ', ') as ItemCost,
 						GROUP_CONCAT(Total_Cost SEPARATOR ', ') as Total_Cost,
 						ROUND(SUM(Total_Cost),2) as TotalAmount,
 						(Case WHEN Vatable = 'Yes'
 							THEN
 							ROUND(SUM(Total_Cost) - SUM(Total_Cost)/9.334, 2) ELSE '0' END) as Vatsale,
 						(Case WHEN Vatable = 'Yes'
 							THEN
 							ROUND(SUM(Total_Cost)/9.334,2) ELSE '0' END) as AddedTax,
 						(Case WHEN Vatable = 'No'
 							THEN
 							ROUND(SUM(Total_Cost)*0.12,2) ELSE '0' END) as NonVAt,
 						(Case WHEN Vatable = 'No'
 							THEN
 							ROUND(SUM(Total_Cost) + SUM(Total_Cost)*0.12, 2) ELSE '0' END) as TotalWNVAt, tpd.Note, tpd.Sup_TIN as TIN
 						FROM tbl_reqitem trt 
 						left join tbl_reqdetails trdt on trt.ReqNum = trdt.ReqNum 
 						left join tbl_podetails tpd on tpd.PO_Number = trdt.PO_Number
 						where trdt.PO_Number = '$voucherno'";

 		$query = $this->emsdb->query($sql);
		return $query->result_array();

	}

	public function get_po_attachments($voucherno, $vouchersite) {
		if ($vouchersite == 1) {
			$tbl = 'tbl_voucher';
			$tblpd ='tbl_podetails';
		} else {
			$tbl = 'tbll_voucher';
			$tblpd ='tbll_podetails';
		}

		$sql = "SELECT tv.*,tp.* from ".$tbl." tv
								left join ".$tblpd." tp on tv.Voucher_Num = tp.Voucher_Num
								where tv.voucher_num='$voucherno'";

 		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function saveVoucherStatus($data) {
		if($data['statustype'] == 1) {
			$status = 'Approved';
		} else if ($data['statustype'] == 2) {
			$status = 'Returned';
		} else {
			$status = 'Rejected';
		}
		$podata = array(
			'Voucher_Num'=>$data['voucherno'],
			'Entry_Date'=>date('Y-m-d H:i:s'),
			'V_Status'=>$status,
			'ApprovedDate'=>date('Y-m-d H:i:s'),
			'Remarks'=>$data['remarks_approved'],
			'V_StatusTag' => $data['Vouch_StatusTag']
		);
		$query = $this->emsdb->insert('tbl_voucherhistory',$podata);
		if ($query) {
			$this->emsdb->where('Voucher_Num', $data['voucherno']);
			$tbl = 'tbl_voucher';
			if ($data['site'] == 2) {
				$tbl = 'tbll_voucher';
			}
			$this->emsdb->update($tbl, array('Voucher_Stat' => $status,'Voucher_StatTAg'=>$data['Vouch_StatusTag']));
			return true;
		}
	}

}
