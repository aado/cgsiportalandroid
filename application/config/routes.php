<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/** Custom Route for Auth Controller */
$route['login'] = 'auth/index';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';
$route['contactInfo'] = 'masterlist/getContactInfo';
$route['updateEmpInfo'] = 'masterlist/updateInfo';
$route['getApplicImage'] = 'masterlist/getApplicImage';
$route['assignDepartment'] = 'masterlist/assignDepartment';

$route['saveChangePassword'] = 'profile/saveChangePassword';

$route['cgsi_tenurity_checker'] = 'auth/tenure_checker';

// Leave Routes
$route['leave'] = 'Leave';
$route['holiday'] = 'leave/holiday';
$route['leavetype'] = 'leave/leavetype';
$route['saveLeaveUndertime'] = 'leave/saveLeaveUndertime';
$route['removeLeave'] = 'leave/removeLeave';
$route['approvedRejectLeave'] = 'leave/approvedRejectLeave';
$route['saveLeaveSubmit'] = 'leave/saveLeaveSubmit';

// Payslip Routes
$route['payslip'] = 'Payslip';
$route['viewPayslip'] = 'payslip/viewPayslip';
$route['savePayslip'] = 'payslip/savePayslip';
$route['removePayslip'] = 'payslip/removePayslip';
$route['payslipindiv'] = 'PayslipIndiv';
$route['sendVerifCode'] = 'PayslipIndiv/sendVerifCode';
$route['checkVerify'] = 'PayslipIndiv/checkVerify';
$route['sendPayslipEmail'] = 'payslip/sendPayslipEmail';

// Memo routes
$route['addContriAmt'] = 'memo/addContriAmt';
$route['getAllMemoViewerById'] = 'memo/getAllMemoViewerById';
$route['saveMemo'] = 'memo/saveMemo';
$route['viewMemo'] = 'memo/viewMemo';
$route['removeMemo'] = 'memo/removeMemo';
$route['saveMemoSubmit'] = 'memo/saveMemoSubmit';
$route['getAmount'] = 'memo/getAmount';

// PO Routes
$route['po'] = 'po';
$route['recievedpo'] = 'po';
$route['returnpo'] = 'po';
$route['cancellpo'] = 'po';
$route['historypo'] = 'po/historypo';
$route['podetails/(:num)/(:num)'] = 'po/podetails/$1/$1';
$route['poattachments'] = 'po/poattachments';
$route['savePOStatus'] = 'po/savePOStatus';
$route['getPODetails'] = 'po/getPODetails';
$route['getPOInfo'] = 'po/getPOInfo';


// Voucher
$route['voucher'] = 'voucher';
$route['receivedvoucher'] = 'voucher';
$route['returnvoucher'] = 'voucher';
$route['cancelVoucher'] = 'voucher';
$route['historyvoucher'] = 'voucher/historyvoucher';
$route['voucherattachments'] = 'voucher/voucherattachments';
$route['voucherdetails/(:num)/(:num)'] = 'voucher/voucherdetails/$1/$1';
$route['voucherdetails2/(:num)/(:num)'] = 'voucher/voucherdetails2/$1/$1';
$route['saveVoucherStatus'] = 'voucher/saveVoucherStatus';

// Inventory
$route['transmittal'] = 'inventory/transmittal';
$route['pullout'] = 'inventory/pullout';
$route['inventories'] = 'inventory/inventories';
$route['inventorylist/(:any)/(:any)'] = 'inventory/inventorylist/$1/$1';
$route['inventorydetails/(:any)'] = 'inventory/inventorydetails/$1';
$route['saveTransmitall'] = 'inventory/saveTransmitall';
$route['saveReceiptInfo'] = 'inventory/saveReceiptInfo';
$route['addItems'] = 'inventory/addItems';
$route['savePullout'] = 'inventory/savePullout';

// Profile
$route['profile'] = 'profile';

// Transin and transout
$route['transintransout'] = 'transintransout';


// Requisition
$route['Requisition'] = 'requisition';

//Probetionary checker
$route['getdirecthead'] = 'Auth/get_direct_head';

// Admin Masterlist
$route['adminmasterlist'] = 'AdminMasterlist';

