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

// Llamadas API
$route['api/login']['POST']          = 'Login/loginUser';
$route['api/logout']['POST']         = 'Login/logoutUser';
$route['api/forgotPassword']['POST'] = 'Login/forgotPassword';

$route['api/getPromotions']['GET']  = 'Promotion/getAllPromotions';
$route['api/getPromotion/(:num)']['GET']  = 'Promotion/getPromotionById/$1';
$route['api/createPromotion']['POST'] = 'Promotion/createPromotion';
$route['api/modifyPromotion/(:num)']['POST'] = 'Promotion/modifyPromotion/$1';
$route['api/deletePromotion/(:num)']['POST'] = 'Promotion/deletePromotion/$1';

$route['api/getUser']['GET']            = 'User/getUser';
$route['api/getUser/(:num)']['GET']     = 'User/getUser/$1';
$route['api/getUsers']['GET']           = 'User/getAllUsers';
$route['api/createUser']['POST']        = 'User/createUser';
$route['api/modifyUser/(:num)']['POST'] = 'User/modifyUser/$1';
$route['api/deleteUser/(:num)']['POST'] = 'User/deleteUser/$1';

$route['api/getLevelAccessList']['GET'] = 'User/getAllLevelAccess';

$route['api/changeProfileData']['POST'] = 'User/modifyUser';
$route['api/changePassword']['POST']    = 'User/changePassword';

$route['api/getContactInformation']['GET'] = 'Contact/getContactInformation';
$route['api/updateContactInfo']['POST'] = 'Contact/updateContactInfo';
$route['api/updateContactForm']['POST'] = 'Contact/updateContactForm';

$route['api/sendMessage']['POST'] = 'Main/sendMessage';

$route['api/(.+)'] = 'Main/apiRequestNotFound';

// Rutas del Panel de Administración
$route['panel']['GET']              = 'Main/panel';
$route['panel/home']['GET']         = 'Panel/getIndexPage';
$route['panel/profile']['GET']      = 'Panel/getProfilePage';
$route['panel/promotions']['GET']   = 'Panel/getPromotionsPage';
$route['panel/userAdmin']['GET']    = 'Panel/getUserAdminPage';
$route['panel/settings']['GET']     = 'Panel/getSettingsPage';
$route['panel/(.+)']                = 'Main/panelPageNotFound';

$route['(.+)'] = 'Main/pageNotFound';

// Opciones de Codeigniter
$route['default_controller'] = 'Main';
$route['404_override'] = 'Main/pageNotFound';
$route['translate_uri_dashes'] = FALSE;
