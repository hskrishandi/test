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
$route['auth/activate/(:any)'] = "auth/activate/$1";
$route['auth/password/reset'] = "auth/resetPassword";
$route['auth/password/update'] = "auth/updatePassword";

// Users
$route['account'] = "account/index";
$route['account/brief'] = "account/getUserBriefInfo";
$route['account/update'] = "account/updateAccountInfo";
$route['account/library'] = "account/userLibrary";

// Contact us
$route['contacts'] = "contacts/createContact";

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

// organizations
$route['organizations']= "organizations/getOrganizations";

// Discussion
$route['discussions'] = "discussions/index";
$route['discussions/(:num)'] = "discussions/index/$1";
$route['discussions/my'] = "discussions/discussionsByUser";


// Temp solution for old txtsim request
// Simulation
$route['simulation'] = "v1/txtsim/index";
$route['txtsim/runNetlistSIM'] = "v1/txtsim/runNetlistSIM";
$route['txtsim/runRAWSIM'] = "v1/txtsim/runRAWSIM";
$route['txtsim/simulationStatus'] = "v1/txtsim/simulationStatus";
$route['txtsim/simulationStop'] = "v1/txtsim/simulationStop";
$route['txtsim/getModelCard'] = "v1/txtsim/getModelCard";
$route['txtsim/convNetlistToRAW'] = "v1/txtsim/convNetlistToRAW";
$route['txtsim/saveasRAW'] = "v1/txtsim/saveasRAW";
$route['txtsim/saveasNetlist'] = "v1/txtsim/saveasNetlist";
$route['txtsim/savePNG'] = "v1/txtsim/savePNG";
$route['txtsim/loadRAW'] = "v1/txtsim/loadRAW";
$route['txtsim/loadNetlist'] = "v1/txtsim/loadNetlist";
$route['txtsim/CSVDownload'] = "v1/txtsim/CSVDownload";

$route['modelsim/modelLibrary/(:any)'] = "v1/modelsim/modelLibrary/$1";
$route['modelsim/modelDetails/(:num)'] = "v1/modelsim/modelDetails/$1";
$route['modelsim/modelCardinfo2/(:any)'] = "v1/modelsim/modelCardinfo2/$1";
$route['modelsim/modelInstanceParams/(:num)'] = "v1/modelsim/modelInstanceParams/$1";

$route['modelsim/getExampleFilenames/(:num)'] = "v1/modelsim/getExampleFilenames/$1";
$route['modelsim/readExampleFiles/(:num)/(:any)'] = "v1/modelsim/readExampleFiles/$1/$2";
$route['modelsim/benchmarking/(:any)/(:num)'] = "v1/modelsim/benchmarking/$1/$2";
$route['modelsim/paramSet/(:any)/(:num)'] = "v1/modelsim/paramSet/$1/$2";
$route['modelsim/clientParamSet/(:any)/(:num)/(:any)'] = "v1/modelsim/clientParamSet/$1/$2/$3";
$route['modelsim/clientPlotData/(:any)'] = "v1/modelsim/clientPlotData/$1";

/**
 * Aninitio Project
 */
$route['abinitio/simulation'] = "abinitio/simulation";

/**
 * Realcas
 */
$route['realcas'] = "realcas/realcas";
$route['realcas/modelLibrary/(:any)'] = "realcas/realcas/modelLibrary/$1";
$route['realcas/benchmarking/(:any)/(:any)'] = "realcas/realcas/benchmarking/$1/$2";
$route['realcas/paramSet/(:any)'] = "realcas/realcas/paramSet/$1";
$route['realcas/modelDetails/(:any)'] = "realcas/realcas/modelDetails/$1";
$route['realcas/runNetlistSIM'] = "realcas/realcas/runNetlistSIM";
$route['realcas/simulationStatus'] = "realcas/realcas/simulationStatus";
$route['realcas/simulationStop'] = "realcas/realcas/simulationStop";
$route['realcas/saveasNetlist'] = "realcas/realcas/saveasNetlist";
$route['realcas/loadNetlist'] = "realcas/realcas/loadNetlist";

// Manuals
$route['manuals/imos'] = "manuals/imos";
$route['manuals/realcas'] = "manuals/realcas";

// All other not registerd routes
$route['(:any)'] = "home/notFound";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
