<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/about', 'About::index'); 
$routes->get('/services', 'Services::index'); 
$routes->match(['get', 'post'], '/contact', 'Contact::index'); 
$routes->get('/register', 'Register::index'); 
$routes->post('/register', 'Register::create');
// route for login page
$routes->get('/login', 'Home::login');
$routes->post('/login', 'Home::login');

// route for dashboard page
$routes->get('/dashboard', 'Home::dashboard');

// route for logout
$routes->post('/logout', 'Home::logout');
$routes->get('/account/(:num)', 'Home::viewAccount/$1');

// Routes for Creating an Account
$routes->get('/account/create', 'Home::createAccount');
$routes->post('/account/store', 'Home::storeAccount');

// Routes for Editing and Deleting an Account
$routes->get('/account/edit/(:num)', 'Home::editAccount/$1');
$routes->post('/account/update/(:num)', 'Home::updateAccount/$1');
$routes->get('/account/delete/(:num)', 'Home::deleteAccount/$1');