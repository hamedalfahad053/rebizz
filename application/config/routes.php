<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route_path = APPPATH . 'routes/';
require_once $route_path . 'routes_landing.php';

$route['404_override'] = 'not_found';
$route['translate_uri_dashes'] = FALSE;


//switch($_SERVER['HTTP_HOST']) {
//
//    case 'apps.localhost/rebizz/':
//        $route['default_controller'] = "Auth";
//        $route['(:any)'] = "Auth/$1";
//    break;
//
//    default:
//        $route['default_controller'] = 'Site/Site';
//    break;
//}


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
$route[ADMIN_NAMESPACE_URL.'/Fields']                         = 'System_Fields/System_Fields';
$route[ADMIN_NAMESPACE_URL.'/Fields/(:any)']                  = 'System_Fields/System_Fields/$1';
$route[ADMIN_NAMESPACE_URL.'/Fields/(:any)/(:any)']           = 'System_Fields/System_Fields/$1/$2';
$route[ADMIN_NAMESPACE_URL.'/Fields/(:any)/(:any)/(:any)']    = 'System_Fields/System_Fields/$1/$2/$3';

# System Forms
$route[ADMIN_NAMESPACE_URL.'/Forms']                         = 'System_Forms/System_Forms';
$route[ADMIN_NAMESPACE_URL.'/Forms/(:any)']                  = 'System_Forms/System_Forms/$1';
$route[ADMIN_NAMESPACE_URL.'/Forms/(:any)/(:any)']           = 'System_Forms/System_Forms/$1/$2';
$route[ADMIN_NAMESPACE_URL.'/Forms/(:any)/(:any)/(:any)']    = 'System_Forms/System_Forms/$1/$2/$3';
$route[ADMIN_NAMESPACE_URL.'/Forms/(:any)/(:any)/(:any)/(:any)']    = 'System_Forms/System_Forms/$1/$2/$3/$4';

# System List Data
$route[ADMIN_NAMESPACE_URL.'/List_Data']                  = 'System_Fields/System_ListData';
$route[ADMIN_NAMESPACE_URL.'/List_Data/(:any)']           = 'System_Fields/System_ListData/$1';
$route[ADMIN_NAMESPACE_URL.'/List_Data/(:any)/(:any)']    = 'System_Fields/System_ListData/$1/$2';
$route[ADMIN_NAMESPACE_URL.'/List_Data/(:any)/(:any)/(:any)']    = 'System_Fields/System_ListData/$1/$2/$3';

#  Property Types
$route[ADMIN_NAMESPACE_URL.'/Property_Types']                       = 'System_Property_Types/System_Property_Types';
$route[ADMIN_NAMESPACE_URL.'/Property_Types/(:any)']                = 'System_Property_Types/System_Property_Types/$1';
$route[ADMIN_NAMESPACE_URL.'/Property_Types/(:any)/(:any)']         = 'System_Property_Types/System_Property_Types/$1/$2';
$route[ADMIN_NAMESPACE_URL.'/Property_Types/(:any)/(:any)/(:any)']  = 'System_Property_Types/System_Property_Types/$1/$2/$3';

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

# System Transaction
$route[ADMIN_NAMESPACE_URL.'/Transaction']                  = 'System_Transaction/System_Transaction';
$route[ADMIN_NAMESPACE_URL.'/Transaction/(:any)']           = 'System_Transaction/System_Transaction/$1';
$route[ADMIN_NAMESPACE_URL.'/Transaction/(:any)/(:any)']    = 'System_Transaction/System_Transaction/$1/$2';

# System Evaluation Types
$route[ADMIN_NAMESPACE_URL.'/Evaluation_Types']                  = 'System_Evaluation_Types/System_Evaluation_Types';
$route[ADMIN_NAMESPACE_URL.'/Evaluation_Types/(:any)']           = 'System_Evaluation_Types/System_Evaluation_Types/$1';
$route[ADMIN_NAMESPACE_URL.'/Evaluation_Types/(:any)/(:any)']    = 'System_Evaluation_Types/System_Evaluation_Types/$1/$2';

# System Evaluation Methods
$route[ADMIN_NAMESPACE_URL.'/Evaluation_Methods']                       = 'System_Evaluation_Methods/System_Evaluation_Methods';
$route[ADMIN_NAMESPACE_URL.'/Evaluation_Methods/(:any)']                = 'System_Evaluation_Methods/System_Evaluation_Methods/$1';
$route[ADMIN_NAMESPACE_URL.'/Evaluation_Methods/(:any)/(:any)']         = 'System_Evaluation_Methods/System_Evaluation_Methods/$1/$2';
$route[ADMIN_NAMESPACE_URL.'/Evaluation_Methods/(:any)/(:any)/(:any)']  = 'System_Evaluation_Methods/System_Evaluation_Methods/$1/$2/$3';


# System Calculations
$route[ADMIN_NAMESPACE_URL.'/Calculations']                       = 'System_Calculations/System_Calculations';
$route[ADMIN_NAMESPACE_URL.'/Calculations/(:any)']                = 'System_Calculations/System_Calculations/$1';
$route[ADMIN_NAMESPACE_URL.'/Calculations/(:any)/(:any)']         = 'System_Calculations/System_Calculations/$1/$2';
$route[ADMIN_NAMESPACE_URL.'/Calculations/(:any)/(:any)/(:any)']  = 'System_Calculations/System_Calculations/$1/$2/$3';

/* ################################################################################
 * Admin
*/ ################################################################################





/* ################################################################################
 * Apps
*/ ################################################################################
$route[APP_NAMESPACE_URL]                                           = 'App_Dashboard/App_Dashboard';
$route[APP_NAMESPACE_URL.'/Dashboard']                              = 'App_Dashboard/App_Dashboard';
$route[APP_NAMESPACE_URL.'/Dashboard/(:any)']                       = 'App_Dashboard/App_Dashboard/$1';
$route[APP_NAMESPACE_URL.'/Dashboard/(:any)/(:any)']                = 'App_Dashboard/App_Dashboard/$1/$2';
$route[APP_NAMESPACE_URL.'/Dashboard/(:any)/(:any)/(:any)']         = 'App_Dashboard/App_Dashboard/$1/$2/$3';



# Company Settings
$route[APP_NAMESPACE_URL.'/Settings']                               = 'App_CompanySettings/App_CompanySettings';
$route[APP_NAMESPACE_URL.'/Settings/(:any)']                        = 'App_CompanySettings/App_CompanySettings/$1';
$route[APP_NAMESPACE_URL.'/Settings/(:any)/(:any)']                 = 'App_CompanySettings/App_CompanySettings/$1/$2';
$route[APP_NAMESPACE_URL.'/Settings/(:any)/(:any)/(:any)']          = 'App_CompanySettings/App_CompanySettings/$1/$2/$3';



#  Settings Transaction
$route[APP_NAMESPACE_URL.'/Settings_Transaction']                                 = 'App_CompanySettings/App_Company_Settings_Transactions';
$route[APP_NAMESPACE_URL.'/Settings_Transaction/(:any)']                          = 'App_CompanySettings/App_Company_Settings_Transactions/$1';
$route[APP_NAMESPACE_URL.'/Settings_Transaction/(:any)/(:any)']                   = 'App_CompanySettings/App_Company_Settings_Transactions/$1/$2';
$route[APP_NAMESPACE_URL.'/Settings_Transaction/(:any)/(:any)/(:any)']            = 'App_CompanySettings/App_Company_Settings_Transactions/$1/$2/$3';
$route[APP_NAMESPACE_URL.'/Settings_Transaction/(:any)/(:any)/(:any)/(:any)']     = 'App_CompanySettings/App_Company_Settings_Transactions/$1/$2/$3/$4';



#  Settings Transaction Reports
$route[APP_NAMESPACE_URL.'/Settings_Transaction_Reports']                                 = 'App_CompanySettings/App_Company_Settings_Transaction_Reports';
$route[APP_NAMESPACE_URL.'/Settings_Transaction_Reports/(:any)']                          = 'App_CompanySettings/App_Company_Settings_Transaction_Reports/$1';
$route[APP_NAMESPACE_URL.'/Settings_Transaction_Reports/(:any)/(:any)']                   = 'App_CompanySettings/App_Company_Settings_Transaction_Reports/$1/$2';
$route[APP_NAMESPACE_URL.'/Settings_Transaction_Reports/(:any)/(:any)/(:any)']            = 'App_CompanySettings/App_Company_Settings_Transaction_Reports/$1/$2/$3';
$route[APP_NAMESPACE_URL.'/Settings_Transaction_Reports/(:any)/(:any)/(:any)/(:any)']     = 'App_CompanySettings/App_Company_Settings_Transaction_Reports/$1/$2/$3/$4';



#  Company HRM
$route[APP_NAMESPACE_URL.'/HRM']                                  = 'App_Company_HRM/App_Company_HRM';
$route[APP_NAMESPACE_URL.'/HRM/(:any)']                           = 'App_Company_HRM/App_Company_HRM/$1';
$route[APP_NAMESPACE_URL.'/HRM/(:any)/(:any)']                    = 'App_Company_HRM/App_Company_HRM/$1/$2';
$route[APP_NAMESPACE_URL.'/HRM/(:any)/(:any)/(:any)']             = 'App_Company_HRM/App_Company_HRM/$1/$2/$3';
$route[APP_NAMESPACE_URL.'/HRM/(:any)/(:any)/(:any)/(:any)']      = 'App_Company_HRM/App_Company_HRM/$1/$2/$3/$4';

#  Company Locations
$route[APP_NAMESPACE_URL.'/Locations']                            = 'App_Company_Locations/App_Company_Locations';
$route[APP_NAMESPACE_URL.'/Locations/(:any)']                     = 'App_Company_Locations/App_Company_Locations/$1';
$route[APP_NAMESPACE_URL.'/Locations/(:any)/(:any)']              = 'App_Company_Locations/App_Company_Locations/$1/$2';
$route[APP_NAMESPACE_URL.'/Locations/(:any)/(:any)/(:any)']       = 'App_Company_Locations/App_Company_Locations/$1/$2/$3';

#  Company Users
$route[APP_NAMESPACE_URL.'/Users']                                = 'App_Company_Users/App_Company_Users';
$route[APP_NAMESPACE_URL.'/Users/(:any)']                         = 'App_Company_Users/App_Company_Users/$1';
$route[APP_NAMESPACE_URL.'/Users/(:any)/(:any)']                  = 'App_Company_Users/App_Company_Users/$1/$2';
$route[APP_NAMESPACE_URL.'/Users/(:any)/(:any)/(:any)']           = 'App_Company_Users/App_Company_Users/$1/$2/$3';

#  Company Group Users
$route[APP_NAMESPACE_URL.'/User_Group']                       = 'App_Company_UserGroup/App_Company_UserGroup';
$route[APP_NAMESPACE_URL.'/User_Group/(:any)']                = 'App_Company_UserGroup/App_Company_UserGroup/$1';
$route[APP_NAMESPACE_URL.'/User_Group/(:any)/(:any)']         = 'App_Company_UserGroup/App_Company_UserGroup/$1/$2';
$route[APP_NAMESPACE_URL.'/User_Group/(:any)/(:any)/(:any)']  = 'App_Company_UserGroup/App_Company_UserGroup/$1/$2/$3';

#  Company Forms
$route[APP_NAMESPACE_URL.'/Forms']                                  = 'App_Company_Forms/App_Company_Forms';
$route[APP_NAMESPACE_URL.'/Forms/(:any)']                           = 'App_Company_Forms/App_Company_Forms/$1';
$route[APP_NAMESPACE_URL.'/Forms/(:any)/(:any)']                    = 'App_Company_Forms/App_Company_Forms/$1/$2';
$route[APP_NAMESPACE_URL.'/Forms/(:any)/(:any)/(:any)']             = 'App_Company_Forms/App_Company_Forms/$1/$2/$3';

#  Company Fields
$route[APP_NAMESPACE_URL.'/Fields']                                 = 'App_Company_Fields/App_Company_Fields';
$route[APP_NAMESPACE_URL.'/Fields/(:any)']                          = 'App_Company_Fields/App_Company_Fields/$1';
$route[APP_NAMESPACE_URL.'/Fields/(:any)/(:any)']                   = 'App_Company_Fields/App_Company_Fields/$1/$2';
$route[APP_NAMESPACE_URL.'/Fields/(:any)/(:any)/(:any)']            = 'App_Company_Fields/App_Company_Fields/$1/$2/$3';

#  Company List
$route[APP_NAMESPACE_URL.'/List']                                 = 'App_Company_List/App_Company_List';
$route[APP_NAMESPACE_URL.'/List/(:any)']                          = 'App_Company_List/App_Company_List/$1';
$route[APP_NAMESPACE_URL.'/List/(:any)/(:any)']                   = 'App_Company_List/App_Company_List/$1/$2';
$route[APP_NAMESPACE_URL.'/List/(:any)/(:any)/(:any)']            = 'App_Company_List/App_Company_List/$1/$2/$3';

#  Company  Transactions
$route[APP_NAMESPACE_URL.'/Transactions']                          = 'App_Transactions/App_Transactions';
$route[APP_NAMESPACE_URL.'/Transactions/(:any)']                   = 'App_Transactions/App_Transactions/$1';
$route[APP_NAMESPACE_URL.'/Transactions/(:any)/(:any)']            = 'App_Transactions/App_Transactions/$1/$2';
$route[APP_NAMESPACE_URL.'/Transactions/(:any)/(:any)/(:any)']     = 'App_Transactions/App_Transactions/$1/$2/$3';
$route[APP_NAMESPACE_URL.'/Transactions/(:any)/(:any)/(:any)/(:any)']     = 'App_Transactions/App_Transactions/$1/$2/$3/$4';
$route[APP_NAMESPACE_URL.'/Transactions/(:any)/(:any)/(:any)/(:any)/(:any)']     = 'App_Transactions/App_Transactions/$1/$2/$3/$4/$5';
$route[APP_NAMESPACE_URL.'/Transactions/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)']     = 'App_Transactions/App_Transactions/$1/$2$3/$4/$5/$6';
$route[APP_NAMESPACE_URL.'/Transactions/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)']     = 'App_Transactions/App_Transactions/$1/$2$3/$4/$5/$6/$7';

# Company  Preview
$route[APP_NAMESPACE_URL.'/Preview']                                      = 'App_Transactions/App_Preview';
$route[APP_NAMESPACE_URL.'/Preview/(:any)']                               = 'App_Transactions/App_Preview/$1';
$route[APP_NAMESPACE_URL.'/Preview/(:any)/(:any)']                        = 'App_Transactions/App_Preview/$1/$2';
$route[APP_NAMESPACE_URL.'/Preview/(:any)/(:any)/(:any)']                 = 'App_Transactions/App_Preview/$1/$2/$3';
$route[APP_NAMESPACE_URL.'/Preview/(:any)/(:any)/(:any)/(:any)']          = 'App_Transactions/App_Preview/$1/$2/$3/$4';
$route[APP_NAMESPACE_URL.'/Preview/(:any)/(:any)/(:any)/(:any)/(:any)']   = 'App_Transactions/App_Preview/$1/$2/$3/$4/$5';

# Company Evluation
$route[APP_NAMESPACE_URL.'/Evluation']                                      = 'App_Transactions/App_Evluation';
$route[APP_NAMESPACE_URL.'/Evluation/(:any)']                               = 'App_Transactions/App_Evluation/$1';
$route[APP_NAMESPACE_URL.'/Evluation/(:any)/(:any)']                        = 'App_Transactions/App_Evluation/$1/$2';
$route[APP_NAMESPACE_URL.'/Evluation/(:any)/(:any)/(:any)']                 = 'App_Transactions/App_Evluation/$1/$2/$3';
$route[APP_NAMESPACE_URL.'/Evluation/(:any)/(:any)/(:any)/(:any)']          = 'App_Transactions/App_Evluation/$1/$2/$3/$4';
$route[APP_NAMESPACE_URL.'/Evluation/(:any)/(:any)/(:any)/(:any)/(:any)']   = 'App_Transactions/App_Evluation/$1/$2/$3/$4/$5';

# Company Clients
$route[APP_NAMESPACE_URL.'/Clients']                               = 'App_Company_Clients/Company_Clients';
$route[APP_NAMESPACE_URL.'/Clients/(:any)']                        = 'App_Company_Clients/Company_Clients/$1';
$route[APP_NAMESPACE_URL.'/Clients/(:any)/(:any)']                 = 'App_Company_Clients/Company_Clients/$1/$2';
$route[APP_NAMESPACE_URL.'/Clients/(:any)/(:any)/(:any)']          = 'App_Company_Clients/Company_Clients/$1/$2/$3';
$route[APP_NAMESPACE_URL.'/Clients/(:any)/(:any)/(:any)/(:any)']   = 'App_Company_Clients/Company_Clients/$1/$2/$3/$4';
$route[APP_NAMESPACE_URL.'/Clients/(:any)/(:any)/(:any)/(:any)/(:any)']   = 'App_Company_Clients/Company_Clients/$1/$2/$3/$4/$5';

# Company  Preview RealEstate
$route[APP_NAMESPACE_URL.'/Preview_RealEstate']                          = 'App_RealEstate_Preview/App_Preview_RealEstate';
$route[APP_NAMESPACE_URL.'/Preview_RealEstate/(:any)']                   = 'App_RealEstate_Preview/App_Preview_RealEstate/$1';
$route[APP_NAMESPACE_URL.'/Preview_RealEstate/(:any)/(:any)']            = 'App_RealEstate_Preview/App_Preview_RealEstate/$1/$2';
$route[APP_NAMESPACE_URL.'/Preview_RealEstate/(:any)/(:any)/(:any)']     = 'App_RealEstate_Preview/App_Preview_RealEstate/$1/$2/$3';

# Company  Ajax Controller
$route[APP_NAMESPACE_URL.'/App_Ajax']                          = 'App_Ajax/App_Ajax';
$route[APP_NAMESPACE_URL.'/App_Ajax/(:any)']                   = 'App_Ajax/App_Ajax/$1';
$route[APP_NAMESPACE_URL.'/App_Ajax/(:any)/(:any)']            = 'App_Ajax/App_Ajax/$1/$2';
$route[APP_NAMESPACE_URL.'/App_Ajax/(:any)/(:any)/(:any)']     = 'App_Ajax/App_Ajax/$1/$2/$3';

# Company  Print Evaluation Reports
$route[APP_NAMESPACE_URL.'/Evaluation_Reports']                          = 'App_Print_Evaluation_Reports/App_Print_Evaluation_Reports';
$route[APP_NAMESPACE_URL.'/Evaluation_Reports/(:any)']                   = 'App_Print_Evaluation_Reports/App_Print_Evaluation_Reports/$1';
$route[APP_NAMESPACE_URL.'/Evaluation_Reports/(:any)/(:any)']            = 'App_Print_Evaluation_Reports/App_Print_Evaluation_Reports/$1/$2';
$route[APP_NAMESPACE_URL.'/Evaluation_Reports/(:any)/(:any)/(:any)']     = 'App_Print_Evaluation_Reports/App_Print_Evaluation_Reports/$1/$2/$3';

# Company Map
$route[APP_NAMESPACE_URL.'/Map']                                 = 'App_Company_Map/App_Map';
$route[APP_NAMESPACE_URL.'/Map/(:any)']                          = 'App_Company_Map/App_Map/$1';
$route[APP_NAMESPACE_URL.'/Map/(:any)/(:any)']                   = 'App_Company_Map/App_Map/$1/$2';
$route[APP_NAMESPACE_URL.'/Map/(:any)/(:any)/(:any)']            = 'App_Company_Map/App_Map/$1/$2/$3';
$route[APP_NAMESPACE_URL.'/Map/(:any)/(:any)/(:any)/(:any)']     = 'App_Company_Map/App_Map/$1/$2/$3/$4';


$route[APP_NAMESPACE_URL.'/Online']                              = 'App_Company_Online_Users/App_Company_Online_Users';
/* ################################################################################
 * App_Ajax_Search_Header
*/ ################################################################################
$route[APP_NAMESPACE_URL.'/Search_Ajax/(:any)']  = 'App_Ajax/App_Search_Header/$1';





