<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @package     CGSIPortal
 * Developer - Zniv Zdiv
 * class - PO_model
 */

class PO_model extends CI_Model
{

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

		$this->imsdb =  $this->load->database('imsdb', true);
		// print_r($this->imsdb);
    }

    /**
     * Get user by specific data
     * 
     * @param array $data
     * @param bool  $first Get only the first data
     * @param object
     */

	public function getPO($sessionid, $po_status, $location, $status_tag) {
		if ($location == 'Vis') {
			$tbl = 'tbl_podetails';
		}
		if ($location == 'Luz') {
			$tbl = 'tbll_podetails';
		}
		$sql = "SELECT pd.* FROM ".$tbl." pd WHERE PO_Status = '".$po_status."' AND PO_StatusTag = '".$status_tag."' ORDER BY pd.Entry_Date DESC";
		$query = $this->imsdb->query($sql);	
		return $query->result_array();
	}

	public function getEntryDate($ponumber, $site) {	
		if ($site == 'Vis') {
			$tbl = 'tbl_pohistory';
		} else {
			$tbl = 'tbll_pohistory';
		}
		$sql = "SELECT MAX(Entry_Date) as Entry,PO_Number, PO_Remarks FROM ".$tbl." pd WHERE PO_Status IS NOT NULL AND PO_Number = '".$ponumber."' GROUP BY PO_Number";
		$query = $this->imsdb->query($sql);
		return $query->result_array();
	}

	public function getRemarks($ponumber, $site, $postatus) {	
		if ($site == 'Vis') {
			$tbl = 'tbl_pohistory';
		} else {
			$tbl = 'tbll_pohistory';
		}
		$sql = "SELECT Entry_Date, PO_Remarks FROM ".$tbl." WHERE PO_Number = '".$ponumber."' AND PO_Status='".$postatus."' ORDER BY Entry_Date DESC LIMIT 1";
		$query = $this->imsdb->query($sql);
		return $query->result_array();
	}


	public function POHistory_Visayas($sessionid) {
		if($sessionid == '300591'){
			$sql = "SELECT tp.PO_Number,tp.PO_Supplier,tph.Entry_Date,tp.PO_Status,tph.PO_Remarks,ri.Total_Cost,
		(CASE WHEN tph.PO_StatusTag = 2 and tph.PO_Status = 'Approved' THEN 'Approved'
			WHEN tph.PO_StatusTag = 2 and tph.PO_Status = 'Returned' THEN 'Returned'
			WHEN tph.PO_StatusTag = 2 and tph.PO_Status = 'Rejected' THEN 'Rejected' 
			WHEN tph.PO_StatusTag = 3 and tph.PO_Status = 'Approved' THEN 'Approved by Maam Perez'
			WHEN tph.PO_StatusTag = 3 and tph.PO_Status = 'Returned' THEN 'Returned by Maam Perez'
			WHEN tph.PO_StatusTag = 3 and tph.PO_Status = 'Rejected' THEN 'Rejected by Maam Perez' END )as StatusByReceiver
		FROM tbll_podetails tp 
		inner join 
		( SELECT tpl.PO_Number,tpl.Entry_Date,tpl.PO_Status,tpl.PO_ApprovedDate,tpl.PO_Remarks,tpl.PO_StatusTag FROM tbll_pohistory tpl
			INNER join (SELECT MAX(Entry_Date) as Entry,PO_Number FROM `tbll_pohistory` where PO_StatusTag !='0' GROUP by PO_Number) tple
			on tpl.PO_Number = tple.PO_Number and tpl.Entry_Date = tple.Entry) tph 
		on tp.PO_Number = tph.PO_Number
        left join tbll_podetails pd on tp.PO_Number=pd.PO_Number
		left join tbll_reqdetails rd on tp.PO_Number=rd.PO_Number
		left join tbll_reqitem ri on rd.ReqNum=ri.ReqNum 
        where tp.PO_Status !='Pending' and tp.PO_StatusTag='2'
        and YEAR(tp.Entry_Date) = YEAR(NOW())-1
        GROUP BY tp.PO_Number
        ORDER BY tp.Entry_Date DESC";
		}
		else{
			$sql = "SELECT tp.PO_Number,tp.PO_Supplier,tph.Entry_Date,tp.PO_Status,tph.PO_Remarks,ri.Total_Cost,
		(CASE WHEN tph.PO_StatusTag = 1 and tph.PO_Status = 'Approved' THEN 'For Approval Maam Grace'
			WHEN tph.PO_StatusTag = 1 and tph.PO_Status = 'Rejected' THEN 'Rejected'
			WHEN tph.PO_StatusTag = 1 and tph.PO_Status = 'Returned' THEN 'Returned'
			WHEN tph.PO_StatusTag = 2 and tph.PO_Status = 'Approved' THEN 'Approved by Maam Grace'
			WHEN tph.PO_StatusTag = 2 and tph.PO_Status = 'Returned' THEN 'Returned by Maam Grace'
			WHEN tph.PO_StatusTag = 2 and tph.PO_Status = 'Rejected' THEN 'Rejected by Maam Grace' END )as StatusByReceiver
		FROM tbl_podetails tp 
		inner join 
		( SELECT tpl.PO_Number,tpl.Entry_Date,tpl.PO_Status,tpl.PO_ApprovedDate,tpl.PO_Remarks,tpl.PO_StatusTag FROM tbl_pohistory tpl
			INNER join (SELECT MAX(Entry_Date) as Entry,PO_Number FROM `tbl_pohistory` where PO_StatusTag !='0' GROUP by PO_Number) tple
			on tpl.PO_Number = tple.PO_Number and tpl.Entry_Date = tple.Entry) tph 
		on tp.PO_Number = tph.PO_Number
        left join tbl_podetails pd on tp.PO_Number=pd.PO_Number
		left join tbl_reqdetails rd on tp.PO_Number=rd.PO_Number
		left join tbl_reqitem ri on rd.ReqNum=ri.ReqNum
		where tp.PO_Status!='Pending' and tp.PO_StatusTag!='0' and tp.PO_Number !=''
		and YEAR(tp.Entry_Date) = YEAR(NOW())-1
        GROUP BY tp.PO_Number
        ORDER BY tp.Entry_Date DESC";
		}
		

		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function POHistory_Luzon($sessionid) {
		if($sessionid == '300591'){
			$sql = "SELECT tp.PO_Number,tp.PO_Supplier,tph.Entry_Date,tp.PO_Status,tph.PO_Remarks,ri.Total_Cost,
		(CASE WHEN tph.PO_StatusTag = 2 and tph.PO_Status = 'Approved' THEN 'Approved'
			WHEN tph.PO_StatusTag = 2 and tph.PO_Status = 'Returned' THEN 'Returned'
			WHEN tph.PO_StatusTag = 2 and tph.PO_Status = 'Rejected' THEN 'Rejected' 
			WHEN tph.PO_StatusTag = 3 and tph.PO_Status = 'Approved' THEN 'Approved by Maam Perez'
			WHEN tph.PO_StatusTag = 3 and tph.PO_Status = 'Returned' THEN 'Returned by Maam Perez'
			WHEN tph.PO_StatusTag = 3 and tph.PO_Status = 'Rejected' THEN 'Rejected by Maam Perez' END )as StatusByReceiver
		FROM tbll_podetails tp 
		inner join 
		( SELECT tpl.PO_Number,tpl.Entry_Date,tpl.PO_Status,tpl.PO_ApprovedDate,tpl.PO_Remarks,tpl.PO_StatusTag FROM tbll_pohistory tpl
			INNER join (SELECT MAX(Entry_Date) as Entry,PO_Number FROM `tbll_pohistory` where PO_StatusTag !='0' GROUP by PO_Number) tple
			on tpl.PO_Number = tple.PO_Number and tpl.Entry_Date = tple.Entry) tph 
		on tp.PO_Number = tph.PO_Number
        left join tbll_podetails pd on tp.PO_Number=pd.PO_Number
		left join tbll_reqdetails rd on tp.PO_Number=rd.PO_Number
		left join tbll_reqitem ri on rd.ReqNum=ri.ReqNum 
        where tp.PO_Status !='Pending' and tp.PO_StatusTag='2'
        GROUP BY tp.PO_Number
        ORDER BY tp.Entry_Date DESC";

		}else{
			$sql = "SELECT tp.PO_Number,tp.PO_Supplier,tph.Entry_Date,tp.PO_Status,tph.PO_Remarks,ri.Total_Cost,
		(CASE WHEN tph.PO_StatusTag = 1 and tph.PO_Status = 'Approved' THEN 'For Approval Maam Grace'
			WHEN tph.PO_StatusTag = 1 and tph.PO_Status = 'Rejected' THEN 'Rejected'
			WHEN tph.PO_StatusTag = 1 and tph.PO_Status = 'Returned' THEN 'Returned'
			WHEN tph.PO_StatusTag = 2 and tph.PO_Status = 'Approved' THEN 'Approved by Maam Grace'
			WHEN tph.PO_StatusTag = 2 and tph.PO_Status = 'Returned' THEN 'Returned by Maam Grace'
			WHEN tph.PO_StatusTag = 2 and tph.PO_Status = 'Rejected' THEN 'Rejected by Maam Grace' END )as StatusByReceiver
		FROM tbll_podetails tp 
		inner join 
		( SELECT tpl.PO_Number,tpl.Entry_Date,tpl.PO_Status,tpl.PO_ApprovedDate,tpl.PO_Remarks,tpl.PO_StatusTag FROM tbll_pohistory tpl
			INNER join (SELECT MAX(Entry_Date) as Entry,PO_Number FROM `tbll_pohistory` where PO_StatusTag !='0' GROUP by PO_Number) tple
			on tpl.PO_Number = tple.PO_Number and tpl.Entry_Date = tple.Entry) tph 
		on tp.PO_Number = tph.PO_Number
        left join tbll_podetails pd on tp.PO_Number=pd.PO_Number
		left join tbll_reqdetails rd on tp.PO_Number=rd.PO_Number
		left join tbll_reqitem ri on rd.ReqNum=ri.ReqNum
		where tp.PO_Status!='Pending' and tp.PO_StatusTag!='0' and tp.PO_Number !=''
        GROUP BY PO_Number ASC
        ORDER BY tp.Entry_Date DESC";

		}

		
		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}


	public function getPOHistory($sessionid,$ponumber,$uriSegments) {

		// location
		if ($uriSegments == 1) {
			$tbl = 'tbl_podetails';
			$tblreqi ='tbl_reqitem';
			$tblreqd ='tbl_reqdetails';
			$tblhistory='tbl_pohistory';

		} else {
			$tbl = 'tbll_podetails';
			$tblreqi ='tbll_reqitem';
			$tblreqd ='tbll_reqdetails';
			$tblhistory='tbll_pohistory';

		}
		
		$sql = "SELECT tp.PO_Number,tp.PO_Supplier,tph.Entry_Date,tp.PO_Status,tph.PO_Remarks,ri.Total_Cost,
		(CASE WHEN tph.PO_StatusTag = 1 and tph.PO_Status = 'Approved' THEN 'For Approval Maam Grace'
			WHEN tph.PO_StatusTag = 1 and tph.PO_Status = 'Rejected' THEN 'Rejected'
			WHEN tph.PO_StatusTag = 1 and tph.PO_Status = 'Returned' THEN 'Returned'
			WHEN tph.PO_StatusTag = 2 and tph.PO_Status = 'Approved' THEN 'Approved by Maam Grace'
			WHEN tph.PO_StatusTag = 2 and tph.PO_Status = 'Returned' THEN 'Returned by Maam Grace'
			WHEN tph.PO_StatusTag = 2 and tph.PO_Status = 'Rejected' THEN 'Rejected by Maam Grace' END )as StatusByReceiver
		FROM tbl_podetails ".$tbl." tp 
		inner join 
		( SELECT tpl.PO_Number,tpl.Entry_Date,tpl.PO_Status,tpl.PO_ApprovedDate,tpl.PO_Remarks,tpl.PO_StatusTag FROM tbl_pohistory ".$tblhistory." tpl
			INNER join (SELECT MAX(Entry_Date) as Entry,PO_Number 
				FROM tbl_pohistory ".$tblhistory." 
				where PO_StatusTag !='0' GROUP by PO_Number) tple
			on tpl.PO_Number = tple.PO_Number and tpl.Entry_Date = tple.Entry) tph 
		on tp.PO_Number = tph.PO_Number
        left join ".$tbl." pd on tp.PO_Number=pd.PO_Number
		left join ".$tblreqd." rd on tp.PO_Number=rd.PO_Number
		left join ".$tblreqi."  ri on rd.ReqNum=ri.ReqNum
		where tp.PO_Status!='Pending' and tp.PO_StatusTag!='0' and tp.PO_Number !='' 
		AND YEAR(tp.Entry_Date) = YEAR(NOW())
        GROUP BY tp.PO_Number
        ORDER BY tp.PO_Number DESC";

		$query = $this->emsdb->query($sql);
		return $query->result_array();
	}

	public function getPODetails($sessionid,$ponumber,$uriSegments) {

		// location
		if ($uriSegments == 1) {
			$tbl = 'tbl_reqitem';
			$tblpod ='tbl_podetails';
			$tblreqi ='tbl_reqdetails';
		} else {
			$tbl = 'tbll_reqitem';
			$tblpod ='tbll_podetails';
			$tblreqi ='tbll_reqdetails';
		}

		$sql = "SELECT trdt.PO_Number,tpd.PO_Remarks,tpd.PO_Supplier,tpd.Address,tpd.CellNo,tpd.Order_Date,
		tpd.Delivery_Date,tpd.Cancel_Date,tpd.TOP,tpd.Contact_Person,tpd.Sup_TIN,tpd.PO_Status,tpd.PO_StatusTag,
		tpd.PO_Branch,
		GROUP_CONCAT(trt.ItemID SEPARATOR ', ') as ItemID,trt.ReqNum,
		GROUP_CONCAT(ItemName SEPARATOR ', ') as ItemName,
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
		ROUND(SUM(Total_Cost) + SUM(Total_Cost)*0.12, 2) ELSE '0' END) as TotalWNVAt, tpd.Note
		FROM ".$tbl." trt 
		left join ".$tblreqi." trdt on trt.ReqNum = trdt.ReqNum 
		left join ".$tblpod." tpd on tpd.PO_Number = trdt.PO_Number
		where trdt.PO_Number = '$ponumber'";

		$query = $this->imsdb->query($sql);
		return $query->result_array();
	}

	public function getPOItems($sessionid,$ponumber,$lastUriSegment) {

		// location
		if ($lastUriSegment == 1) {
			$tbl = 'tbl_reqitem';
			$tblpod ='tbl_podetails';
			$tblreqi ='tbl_reqdetails';
		} else {
			$tbl = 'tbll_reqitem';
			$tblpod ='tbll_podetails';
			$tblreqi ='tbll_reqdetails';
		}

		$sql = "SELECT pd.*,rd.ReqNum,rd.PO_Number,ri.* 
		from ".$tblpod." pd inner join ".$tblreqi." rd on pd.PO_Number = rd.PO_Number 
		inner join ".$tbl." ri on rd.ReqNum=ri.ReqNum where pd.PO_Number='$ponumber'";

		$query = $this->imsdb->query($sql);
		return $query->result_array();
	}





	public function savePOStatus($data) {
		if($data['statustype'] == 1) {
			$status = 'Approved';
		} else if ($data['statustype'] == 2) {
			$status = 'Returned';
		} else {
			$status = 'Rejected';
		}
		$podata = array(
			'PO_Number'=>$data['po_no'],
			'Entry_Date'=>date('Y-m-d H:i:s'),
			'PO_Status'=>$status,
			'PO_ApprovedDate'=>date('Y-m-d H:i:s'),
			'PO_Remarks'=>$data['remarks'],
			'PO_StatusTag' => $data['PO_StatusTag']
		);
		$query = $this->emsdb->insert('tbl_pohistory',$podata);
		if ($query) {
			$this->emsdb->where('PO_Number', $data['po_no']);
			$this->emsdb->update('tbl_podetails', array('PO_Status' => $status,'PO_StatusTag'=>$data['PO_StatusTag']));
			return true;
		}
	}
}
