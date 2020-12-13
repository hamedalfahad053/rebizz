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


$route_path = APPPATH . 'routes/';
require_once $route_path . 'routes_landing.php';

$route['404_override'] = 'not_found';
$route['translate_uri_dashes'] = FALSE;



/* ################################################################################
 * Site
*/ ################################################################################
$route['Site']= 'Site/Site';
$route['Site/(:any)'] = 'Site/Site/$1';

/* ################################################################################
 * Site
*/ ################################################################################






/* ################################################################################
 * Admin
*/ ################################################################################

# Dashboard
$route[ADMIN_NAMESPACE_URL.'/Dashboard']        = 'System_Dashboard/System_Dashboard';

# System
$route[ADMIN_NAMESPACE_URL.'/System_Management']                       = 'System_management/System_management';
$route[ADMIN_NAMESPACE_URL.'/System_Management/(:any)']                = 'System_management/System_management/$1';
$route[ADMIN_NAMESPACE_URL.'/System_Management/(:any)/(:any)']         = 'System_management/System_management/$1/$2';
$route[ADMIN_NAMESPACE_URL.'/System_Management/(:any)/(:any)/(:any)']  = 'System_management/System_management/$1/$2/$3';


# System Fields
$route[ADMIN_NAMESPACE_URL.'/Fields']                  = 'System_Fields/System_Fields';
$route[ADMIN_NAMESPACE_URL.'/Fields/(:any)']           = 'System_Fields/System_Fields/$1';
$route[ADMIN_NAMESPACE_URL.'/Fields/(:any)/(:any)']    = 'System_Fields/System_Fields/$1/$2';

$route[ADMIN_NAMESPACE_URL.'/List_Data']                  = 'System_Fields/System_ListData';
$route[ADMIN_NAMESPACE_URL.'/List_Data/(:any)']           = 'System_Fields/System_ListData/$1';
$route[ADMIN_NAMESPACE_URL.'/List_Data/(:any)/(:any)']    = 'System_Fields/System_ListData/$1/$2';

# Language
$route[ADMIN_NAMESPACE_URL.'/Language']         = 'System_Language/System_Language';
$route[ADMIN_NAMESPACE_URL.'/Language/(:any)']  = 'System_Language/System_Language/$1';

# Group_Users
$route[ADMIN_NAMESPACE_URL.'/Group_Users']        = 'System_GroupUsers/System_Group_Users';
$route[ADMIN_NAMESPACE_URL.'/Group_Users/(:any)'] = 'System_GroupUsers/System_Group_Users/$1';

# Users
$route[ADMIN_NAMESPACE_URL.'/Users']              = 'System_Users/System_Users';
$route[ADMIN_NAMESPACE_URL.'/Users/(:any)']       = 'System_Users/System_Users/$1';

# Company
$route[ADMIN_NAMESPACE_URL.'/Company']              = 'System_Company/System_Company';
$route[ADMIN_NAMESPACE_URL.'/Company/(:any)']       = 'System_Company/System_Company/$1';

/* ################################################################################
 * Admin
*/ ################################################################################


/* ################################################################################
 * Apps
*/ ################################################################################


/* ################################################################################
 * Site
*/ ################################################################################