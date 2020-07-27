<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
// $route['default_controller'] = 'welcome';
// $route['404_override'] = '';
// $route['translate_uri_dashes'] = FALSE;
$route['default_controller'] = 'main/index';
$route['dhc'] = 'main/dhc';
$route['hdf'] = 'main/hdf';
$route['da'] = 'daily_activity/daily_activity';
$route['vl'] = 'visitor/index';
$route['rprts'] = 'main/rprts';
$route['login'] = 'main/login';
$route['api/login']['POST'] = 'api/login';
$route['api/logout'] = 'api/logout';
$route['api/submit_ehc'] = 'api/submit_ehc';
$route['api/update_ehc'] = 'api/update_ehc_record';
$route['api/get_all_ehc'] = 'api/get_all_ehc';
$route['api/get_ehc_details/(:any)'] = 'api/get_ehc_details/$1';
$route['api/submit_reason'] = 'api/submit_reason';
$route['api/questions/(:any)'] = 'api/get_questions/$1';
$route['api/server_time'] = 'api/server_time';
$route['api/due_time'] = 'api/due_time';
$route['api/get_submitted_ehc'] = 'api/get_submitted_ehc';
$route['api/get_submitted_hdf'] = 'api/get_submitted_hdf';
$route['api/get_ehc_symptoms/(:any)'] = 'api/get_ehc_symptoms/$1';
$route['api/get_emp_info/(:any)'] = 'api/get_emp_info/$1';
$route['api/get_company_desc/(:any)'] = 'api/get_company_desc/$1';
$route['api/get_group_desc/(:any)'] = 'api/get_group_desc/$1';
$route['api/hdf']['POST'] = 'api/submit_hdf';
$route['api/update_hdf']['POST'] = 'api/update_hdf';
$route['api/hdf']['GET'] = 'api/get_all_hdf';
$route['api/hdf/(:any)']['GET'] = 'api/get_hdf/$1';
$route['api/cutoff']['GET'] = 'api/get_cutoff';
$route['api/hh/(:any)']['GET'] = 'api/get_hh/$1';
$route['api/hhcd/(:any)']['GET'] = 'api/get_hhcd/$1';
$route['api/hd/(:any)']['GET'] = 'api/get_hd/$1';
$route['api/th/(:any)']['GET'] = 'api/get_th/$1';
$route['api/oi/(:any)']['GET'] = 'api/get_oi/$1';
$route['api/get_hdf_cutoff']['GET'] = 'api/get_hdf_cutoff';
$route['api/get_hdf_cutoff_details']['GET'] = 'api/get_hdf_cutoff_details';
$route['api/get_required_emps']['GET'] = 'api/get_required_emps';
$route['api/group']['GET'] = 'api/get_groups';
$route['api/company']['GET'] = 'api/get_company';

$route['api/test'] = 'api/test';

$route['upload_masterfile'] = 'upload/masterfile';

/*
	RESTful Routes
	Added: @emilzxc
	Date: May 5, 2020
*/

$route['vl/add']['POST'] = 'visitor/add_visitor_log';
$route['vl/getquestions1']['GET'] = 'visitor/get_questions1';
$route['vl/getEmployee/(:any)']['GET'] = 'visitor/getEmployee/$1';
$route['vl/getVisitorLogToTable']['GET'] = 'visitor/getVisitorLogToTable';
$route['vl/getCheckOutHost']['GET'] = 'visitor/getVisitorLogChkInChkOut';


/*
    END
	RESTful Routes
	Added: @emilzxc
*/

/**
 * Added: Report Routes for ETS
 * Author: Ben Zarmaynine E. Obra
 * Date: 05-06-2020
 * 
 */

$route['reports']['GET'] = 'ReportController/index';
$route['reports']['POST'] = 'ReportController/index_show';
$route['reports/:any']['GET'] = 'ReportController/show';
$route['reports/:any']['POST'] = 'ReportController/show_item';
$route['reports/:any/export/:any'] = 'ReportController/export';
//end

/**
 * Added: Supporting Routes for Report Modules
 * Author: Ben Zaraynine E. Obra
 * Date: 05-14-20
 */

$route['activity/:any']['GET'] = 'ActivityController/show';

$route['employees']['GET'] = 'EmployeeController/index';

$route['export']['GET'] = 'ExportController/index';

 //end
/**
 * Added: Faker Routes
 * Author Ben Zarmaynine E. Obra
 * Date: 05-10-2020
 */
/*
 $route['faker/employees']['GET'] = 'FakeController/employees';
 $route['faker/activities']['GET'] = 'FakeController/activities';
 $route['faker/participants']['GET'] = 'FakeController/participants';
 $route['faker/visitors']['GET'] = 'FakeController/visitors';
 */

 // Viel 05152020
 $route['administration'] = 'admin/administration';