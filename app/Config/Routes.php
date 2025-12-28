<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/', 'Home::index');

// Jobs
$routes->get('jobs', 'Jobs::index');
$routes->get('jobs/details', 'Jobs::details');
$routes->get('jobs/details/(:any)', 'Jobs::details/$1');

// Companies
$routes->get('companies', 'Companies::index');
$routes->get('companies/details/(:num)', 'Companies::details/$1');
$routes->get('company', 'Company::index'); // Company Dashboard
$routes->get('company/post-job', 'Company::postJob');
$routes->post('company/save-job', 'Company::saveJob');
$routes->get('company/applications', 'Company::applications');
$routes->get('company/accept-application/(:num)', 'Company::acceptApplication/$1');
$routes->get('company/reject-application/(:num)', 'Company::rejectApplication/$1');

// Applications
$routes->post('applications/apply', 'Applications::apply');

// Admin
$routes->get('admin', 'Admin::index');
$routes->get('admin/login', 'Admin::login');
$routes->post('admin/auth', 'Admin::auth');
$routes->get('admin/logout', 'Admin::logout');
$routes->get('admin/requests', 'Admin::requests');
$routes->get('admin/users', 'Admin::users');
$routes->get('admin/settings', 'Admin::settings');
$routes->get('admin/approve/(:num)', 'Admin::approveCompany/$1');
$routes->get('admin/reject/(:num)', 'Admin::rejectCompany/$1');
$routes->get('admin/delete-user/(:num)', 'Admin::deleteUser/$1');
$routes->get('admin/delete-request/(:num)', 'Admin::deleteRequest/$1');
// Profile
$routes->get('profile', 'Profile::index');
$routes->get('profile/(:num)', 'Profile::index/$1');
$routes->post('profile/update', 'Profile::update');
$routes->post('profile/change-password', 'Profile::changePassword');
// Auth
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/attemptLogin', 'Auth::attemptLogin');
$routes->get('auth/signup', 'Auth::signup');
$routes->post('auth/attemptSignup', 'Auth::attemptSignup');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('auth/pending', 'Auth::pending');
