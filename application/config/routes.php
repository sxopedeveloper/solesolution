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
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */
$route['default_controller'] = 'home';
$route['404_override'] = 'MyCustom404Ctrl';
$route['translate_uri_dashes'] = false;
$route['error'] = "welcome/error";
$route['error_code'] = "welcome/error_code";

/************************************************************************************************************/
/************************************************************************************************************/
/**************************************** FRONTEND DEFINED ROUTES *******************************************/
/************************************************************************************************************/
/************************************************************************************************************/
$route['home'] = 'Home';
$route['privacy'] = 'Home/view_privacy';
$route['terms'] = 'Home/view_terms';
$route['contactusprocess'] = "Home/contact_us";

/************************************************************************************************************/
/************************************************************************************************************/
/***************************************** ADMIN DEFINED ROUTES *********************************************/
/************************************************************************************************************/
/************************************************************************************************************/

$route['admin/signup'] = 'admin/signup';
$route['admin/signup-process'] = 'admin/signup/signup_process';

$route['admin'] = 'admin/login';
$route['loginMe'] = 'admin/login/loginMe';
$route['admin/dashboard'] = 'admin/user';
$route['admin/logout'] = 'admin/user/logout';

$route['admin/forgot-password'] = "admin/login/forgotpassword";
$route['admin/forgot-password-send'] = "admin/login/forgot_password";
$route['admin/reset-password/(:any)'] = "admin/login/reset_password/$1";
$route['admin/reset/(:any)'] = "admin/login/reset/$1";

// Manage User
$route['admin/manage-admin'] = 'admin/ManageAdmin';
$route['admin/manage-admin/add'] = 'admin/ManageAdmin/showform';
$route['admin/manage-admin/edit/(:any)'] = 'admin/ManageAdmin/showform/$1';
$route['admin/manage-admin/view/(:any)'] = 'admin/ManageAdmin/getDetail/$1';
$route['admin/admin-store'] = 'admin/ManageAdmin/store';
$route['admin/manage-admin/delete/(:any)'] = 'admin/ManageAdmin/delete/$1';

// Manage store
$route['admin/manage-store'] = 'admin/ManageStore';
$route['admin/manage-store/chnagestatus/(:any)'] = 'admin/ManageStore/chnagestatus/$1';

//Manage Log
$route['admin/manage-log'] = 'admin/ManageLog';

//Manage Duplicate ASIN
$route['admin/manage-duplicate-asin'] = 'admin/ManageDuplicateASIN';

//Manage Card
// $route['admin/manage-card/add']                             = 'admin/ManageCard/showform';
// $route['admin/manage-card/(:any)']                                 = 'admin/ManageStore/ManageCard/$1';

$route['admin/manage-card'] = 'admin/ManageCard';
$route['admin/manage-card/add'] = 'admin/ManageCard/showform';
$route['admin/manage-card/edit/(:any)'] = 'admin/ManageCard/showform/$1';
$route['admin/manage-card/update/(:any)'] = 'admin/ManageCard/update/$1';
$route['admin/manage-card/view/(:any)'] = 'admin/ManageCard/getDetail/$1';
$route['admin/card-store'] = 'admin/ManageCard/store';
$route['admin/manage-card/delete/(:any)'] = 'admin/ManageCard/delete/$1';

// Manage Inventory
$route['admin/manage-product'] = 'admin/ProductController';
$route['admin/manage-product/add'] = 'admin/ProductController/showform';
$route['admin/manage-product/edit/(:any)'] = 'admin/ProductController/showform/$1';
$route['admin/manage-product/view/(:any)'] = 'admin/ProductController/getDetail/$1';
$route['admin/product-store'] = 'admin/ProductController/store';

$route['admin/manage-product/delete/(:any)'] = 'admin/ProductController/delete/$1';
$route['admin/manage-brand-restricted'] = 'admin/ProductController/brand_restricted';

$route['admin/manage-brand/export/excel'] = 'admin/ProductController/export_excel';
$route['admin/manage-brand/export/pdf'] = 'admin/ProductController/export_pdf';

// Manage User
$route['admin/manage-amazon-order'] = 'admin/AmazonOrderController';
$route['admin/manage-amazon-order/export/excel'] = 'admin/AmazonOrderController/export_excel';
$route['admin/manage-amazon-order/export/pdf'] = 'admin/AmazonOrderController/export_pdf';
$route['admin/get-amazon-order'] = 'admin/AmazonOrderController/getOrderfromAmazon/';
$route['admin/get-order-spapi'] = 'admin/AmazonOrderController/apapi/';
$route['admin/get-orders-list'] = 'admin/AmazonOrderController/getOrderlist/';
$route['admin/get-missing-order'] = 'admin/AmazonOrderController/getMissingOrders/';
$route['admin/get-order-cron'] = 'admin/AmazonOrderController/UpdateorderCron/';
$route['admin/get-amazon-order/(:any)'] = 'admin/AmazonOrderController/getOrderfromAmazon/$1';
$route['admin/manage-amazon-asin'] = 'admin/AmazonOrderController/manage_asin';
$route['admin/manage-amazon-asin/export/pdf'] = 'admin/AmazonOrderController/asin_export_pdf';
$route['admin/manage-amazon-asin/export/excel'] = 'admin/AmazonOrderController/asin_export_excel';
$route['admin/anydesk-credentials'] = 'admin/AmazonOrderController/anydeskData';
$route['admin/import-anydesk-excel'] = 'admin/AmazonOrderController/import_anydesk_excel';
$route['admin/orders-backup'] = 'admin/AmazonOrderController/import_order_backup';
$route['admin/get-missing-order'] = 'admin/AmazonOrderController/getMissingOrders/';

//Notifications routes
$route['admin/manage-notifications'] = 'admin/NotificationController';
$route['admin/notifications-read'] = 'admin/NotificationController/notificationRead';

$route['cron/range-order-notify'] = 'cron/RangeOrderNotify';
$route['cron/dudate'] = 'cron/DueOrder';
$route['cron/getrecord'] = 'cron/DueOrder/getRecord';
$route['cron/getrecordsubmit'] = 'cron/DueOrder/getRecordSubmit';
$route['cron/updateOrder'] = 'cron/DueOrder/updateOrder';

// Manage report
$route['admin/manage-report'] = 'admin/ManageReport';
$route['admin/manage-report/(:any)'] = 'admin/ManageReport/$1';
$route['admin/report/(:any)'] = 'admin/ManageReport/$1';

// Manage record
$route['admin/manage-record'] = 'admin/ManageRecord';
$route['admin/manage-record/delete/(:any)'] = 'admin/ManageRecord/delete/$1';

// General
$route['admin/manage-profile'] = 'admin/ManageAdmin/profile';
$route['admin/update-profile'] = 'admin/ManageAdmin/updateProfile';
$route['admin/change-password'] = 'admin/ManageAdmin/changePassword';
$route['admin/update-password'] = 'admin/ManageAdmin/updatePassword';

//for extention
$route['extention/login'] = 'admin/login/extention_login';
$route['extention/favList'] = 'admin/ExtentionController/favList';
$route['extention/loginCheck'] = 'admin/ExtentionController/loginCheck';

$route['extention/add_fevourite'] = 'admin/ExtentionController/ex_add_fevourite';
$route['extention/delete_fevourite'] = 'admin/ExtentionController/ex_delete_fevourite';
$route['extention/deleteall_fevourite'] = 'admin/ExtentionController/ex_deleteAll_fevourite';
$route['extention/register'] = 'admin/ExtentionController/signup_process';

$route['admin/manage-amazon-order/asin'] = 'admin/AmazonOrderController/jsontoasin';
