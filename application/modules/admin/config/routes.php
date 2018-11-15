<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Routes
 */

$route['default_controller']  		  			= 'users/signIn';
$route['admin'] 			  		  			= 'users/signIn';
$route['admin/users/delete/(:num)']   			= 'users/delete/$1';
$route['admin/forums/(:num)']  		  			= 'forums/index/$1';
$route['admin/forums/(:num)/(:num)']  			= 'forums/index/$1/$2';
$route['admin/courses/update_finalized/(:any)'] = 'courses/update_finalized/$1';