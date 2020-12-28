<?php
defined('BASEPATH') OR exit('No direct script access allowed');


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
 * Ajax
*/ ################################################################################
$route['Ajax/(:any)']                = 'Ajax/Ajax/$1';
$route['Ajax/(:any)/(:any)']         = 'Ajax/Ajax/$1/$2';
$route['Ajax/(:any)/(:any)/(:any)']  = 'Ajax/Ajax/$1/$2/$3';



/* ################################################################################
 * Auth
*/ ################################################################################
$route['Auth/(:any)']                = 'Auth/Auth/$1';
$route['Auth/(:any)/(:any)']         = 'Auth/Auth/$1/$2';
$route['Auth/(:any)/(:any)/(:any)']  = 'Auth/Auth/$1/$2/$3';



/* ################################################################################
 * Admin
*/ ################################################################################

# Dashboard
$route[ADMIN_NAMESPACE_URL.'/Dashboard']        = 'System_Dashboard/System_Dashboard';

# System
$route[ADMIN_NAMESPACE_URL.'/System']                       = 'System_management/System_management';
$route[ADMIN_NAMESPACE_URL.'/System/(:any)']                = 'System_management/System_management/$1';
$route[ADMIN_NAMESPACE_URL.'/System/(:any)/(:any)']         = 'System_management/System_management/$1/$2';
$route[ADMIN_NAMESPACE_URL.'/System/(:any)/(:any)/(:any)']  = 'System_management/System_management/$1/$2/$3';


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

# Permissions
$route[ADMIN_NAMESPACE_URL.'/Permissions']                       = 'System_Permissions/System_Permissions';
$route[ADMIN_NAMESPACE_URL.'/Permissions/(:any)']                = 'System_Permissions/System_Permissions/$1';
$route[ADMIN_NAMESPACE_URL.'/Permissions/(:any)/(:any)']         = 'System_Permissions/System_Permissions/$1/$2';
$route[ADMIN_NAMESPACE_URL.'/Permissions/(:any)/(:any)/(:any)']  = 'System_Permissions/System_Permissions/$1/$2/$3';

# Company
$route[ADMIN_NAMESPACE_URL.'/Company']                       = 'System_Company/System_Company';
$route[ADMIN_NAMESPACE_URL.'/Company/(:any)']                = 'System_Company/System_Company/$1';
$route[ADMIN_NAMESPACE_URL.'/Company/(:any)/(:any)']         = 'System_Company/System_Company/$1/$2';
$route[ADMIN_NAMESPACE_URL.'/Company/(:any)/(:any)/(:any)']  = 'System_Company/System_Company/$1/$2/$3';


/* ################################################################################
 * Admin
*/ ################################################################################


/* ################################################################################
 * Apps
*/ ################################################################################
$route[APP_NAMESPACE_URL]                                           = 'App_Dashboard/App_Dashboard';
$route[APP_NAMESPACE_URL.'/Dashboard']                              = 'App_Dashboard/App_Dashboard';
$route[APP_NAMESPACE_URL.'/Dashboard/(:any)']                      = 'App_Dashboard/App_Dashboard/$1';
$route[APP_NAMESPACE_URL.'/Dashboard/(:any)/(:any)']                = 'App_Dashboard/App_Dashboard/$1/$2';
$route[APP_NAMESPACE_URL.'/Dashboard/(:any)/(:any)/(:any)']         = 'App_Dashboard/App_Dashboard/$1/$2/$3';

# Company Settings
$route[APP_NAMESPACE_URL.'/Company_Settings']                       = 'App_CompanySettings/App_CompanySettings';
$route[APP_NAMESPACE_URL.'/Company_Settings/(:any)']               = 'App_CompanySettings/App_CompanySettings/$1';
$route[APP_NAMESPACE_URL.'/Company_Settings/(:any)/(:any)']         = 'App_CompanySettings/App_CompanySettings/$1/$2';
$route[APP_NAMESPACE_URL.'/Company_Settings/(:any)/(:any)/(:any)']  = 'App_CompanySettings/App_CompanySettings/$1/$2/$3';

#  Company Locations
$route[APP_NAMESPACE_URL.'/Company_Locations']                       = 'App_Company_Locations/App_Company_Locations';
$route[APP_NAMESPACE_URL.'/Company_Locations/(:any)']               = 'App_Company_Locations/App_Company_Locations/$1';
$route[APP_NAMESPACE_URL.'/Company_Locations/(:any)/(:any)']         = 'App_Company_Locations/App_Company_Locations/$1/$2';
$route[APP_NAMESPACE_URL.'/Company_Locations/(:any)/(:any)/(:any)']  = 'App_Company_Locations/App_Company_Locations/$1/$2/$3';

#  Company Users
$route[APP_NAMESPACE_URL.'/Company_Users']                           = 'App_Company_Users/App_Company_Users';
$route[APP_NAMESPACE_URL.'/Company_Users/(:any)']                   = 'App_Company_Users/App_Company_Users/$1';
$route[APP_NAMESPACE_URL.'/Company_Users/(:any)/(:any)']             = 'App_Company_Users/App_Company_Users/$1/$2';
$route[APP_NAMESPACE_URL.'/Company_Users/(:any)/(:any)/(:any)']      = 'App_Company_Users/App_Company_Users/$1/$2/$3';

#  Company Group Users
$route[APP_NAMESPACE_URL.'/Company_UserGroup']                       = 'App_Company_UserGroup/App_Company_UserGroup';
$route[APP_NAMESPACE_URL.'/Company_UserGroup/(:any)']               = 'App_Company_UserGroup/App_Company_UserGroup/$1';
$route[APP_NAMESPACE_URL.'/Company_UserGroup/(:any)/(:any)']         = 'App_Company_UserGroup/App_Company_UserGroup/$1/$2';
$route[APP_NAMESPACE_URL.'/Company_UserGroup/(:any)/(:any)/(:any)']  = 'App_Company_UserGroup/App_Company_UserGroup/$1/$2/$3';

#  Company Forms
$route[APP_NAMESPACE_URL.'/Company_Forms']                       = 'App_Company_Forms/App_Company_Forms';
$route[APP_NAMESPACE_URL.'/Company_Forms/(:any)']               = 'App_Company_Forms/App_Company_Forms/$1';
$route[APP_NAMESPACE_URL.'/Company_Forms/(:any)/(:any)']         = 'App_Company_Forms/App_Company_Forms/$1/$2';
$route[APP_NAMESPACE_URL.'/Company_Forms/(:any)/(:any)/(:any)']  = 'App_Company_Forms/App_Company_Forms/$1/$2/$3';

#  Company Fields
$route[APP_NAMESPACE_URL.'/Company_Fields']                       = 'App_Company_Fields/App_Company_Fields';
$route[APP_NAMESPACE_URL.'/Company_Fields/(:any)']               = 'App_Company_Fields/App_Company_Fields/$1';
$route[APP_NAMESPACE_URL.'/Company_Fields/(:any)/(:any)']         = 'App_Company_Fields/App_Company_Fields/$1/$2';
$route[APP_NAMESPACE_URL.'/Company_Fields/(:any)/(:any)/(:any)']  = 'App_Company_Fields/App_Company_Fields/$1/$2/$3';

# Company Clients
$route[APP_NAMESPACE_URL.'/Client']              = 'App_Company_Clients/Company_Clients';
$route[APP_NAMESPACE_URL.'/Client/(:any)']       = 'App_Company_Clients/Company_Clients/$1';

/* ################################################################################
 * Site
*/ ################################################################################