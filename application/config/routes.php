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

// Users
$route['user'] = "user/index";
$route['user/brief'] = "user/getUserBriefInfo";
$route['user/library'] = "user/userLibrary";

// Models
$route['models'] = "models/index";
$route['models/(:num)'] = "models/index/$1";
$route['models/random'] = "models/getRandomModels";
$route['models/random/(:num)'] = "models/getRandomModels/$1";

// Resources
$route['experiences'] = "resources/index/userExperiences";
$route['experiences/(:num)'] = "resources/index/userExperiences/(:num)";
$route['activities'] = "resources/index/activities";
$route['activities/(:num)'] = "resources/index/activities/(:num)";
$route['news'] = "resources/index/news";
$route['news/(:num)'] = "resources/index/news/(:num)";
$route['events'] = "resources/index/events";
$route['events/(:num)'] = "resources/index/events/(:num)";

// All other not registerd routes
$route['(:any)'] = "home/notFound";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
