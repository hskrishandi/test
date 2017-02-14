<?php  if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['404_override'] = 'home/notFound';

/**
 * Following are new route rules for RESTful API.
 *
 * @author Leon
 */
// Auth
$route['auth/login'] = "auth/login";
$route['auth/logout'] = "auth/logout";
$route['auth/register'] = "auth/register";
$route['auth/reset'] = "auth/reset";
$route['auth/activate/(:any)'] = "auth/activate/$1";

// Users
$route['account'] = "account/index";
$route['account/brief'] = "account/getUserBriefInfo";
$route['account/library'] = "account/userLibrary";

// Models
$route['models'] = "models/index";
$route['models/(:num)'] = "models/index/$1";
$route['models/random'] = "models/getRandomModels";
$route['models/simulation'] = "v1/modelsim/simulate";
$route['models/simulation/status'] = "v1/modelsim/simulationStatus";
$route['models/simulation/data/(:any)/(:any)'] = "v1/modelsim/getData/$1/$2";
$route['experiences'] = "models/getUserExperiences";

// Activities
$route['activities'] = "activities/index";
$route['activities/(:num)'] = "activities/index/$1";

// Events
$route['events'] = "events/index";
$route['events/(:num)'] = "events/index/$1";
$route['events/upcoming'] = "events/getUpcomingEvents";
$route['events/past'] = "events/getPastEvents";

// News
$route['news'] = "news/index";
$route['news/(:num)'] = "news/index/$1";

// Articles
$route['articles'] = "articles/index";
$route['articles/(:num)'] = "articles/index/$1";

// Device models
// TODO: handle post
$route['deviceModels'] = "deviceModels/getDeviceModels";

// Tools
// TODO: handle post
$route['tools'] = "tools/getTools";


// All other not registerd routes
$route['(:any)'] = "home/notFound";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
