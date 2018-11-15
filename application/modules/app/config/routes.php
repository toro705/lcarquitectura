<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * App Routes
 */

$route['default_controller'] 										= 'users/signin';
$route['app/user/profile']  										= 'users/profile';
$route['app/user/signin']  											= 'users/signin';
$route['app/user/signin/(:any)']  									= 'users/signin/$1';
$route['app/user/signout']  										= 'users/signout';
$route['app/user/passwordrecover']  								= 'users/passwordrecover';
$route['app/user/passwordrestore/(:any)'] 							= 'users/passwordrestore/$1';
$route['app/user/fileupload/(:num)'] 								= 'users/fileupload/$1';
$route['app/user/signinasuser/(:num)/(:any)']  						= 'users/signInAsUser/$1/$2';

$route['app/lesson/(:num)']  										= 'lessons/index/$1';
$route['app/lesson/answers/(:num)']									= 'lessons/answers/$1';
$route['app/lesson/result/(:num)']									= 'lessons/result/$1';

$route['app/forum/(:num)']   										= 'forums/index/$1';
$route['app/forum/question_new']   									= 'forums/question_new';
$route['app/forum/question_views']   								= 'forums/question_views';
$route['app/forum/(:num)/question/(:num)']   						= 'forums/question/$1/$2';

$route['app/dashboard/(:num)'] 										= 'dashboards/index/$1';

$route['app/courses']  		 										= 'courses/index';
$route['app/course/(:num)']  										= 'courses/detail/$1';
$route['app/course/certificate/(:num)'] 							= 'courses/certificate/$1';
$route['app/course/finalized/(:num)'] 								= 'courses/finalized/$1';
$route['app/course/certificates'] 									= 'courses/certificates';
$route['app/course/certificateDownload/(:num)'] 					= 'courses/certificateDownload/$1';
$route['app/course/certificatedownload/(:num)'] 					= 'courses/certificate_download/$1';

$route['app/photographer/(:num)']  		 							= 'site/photographer/$1';
$route['app/works']  		 										= 'site/works';
