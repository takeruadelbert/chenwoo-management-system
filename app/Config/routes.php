<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
//Router::connect('/', array('admin' => true, 'controller' => 'fronts', 'action' => 'display', 'ID', 'index'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

//=======================================================================================================
//front end
//pqp
Router::connect('/index', array('front' => true, 'controller' => 'fronts', 'action' => 'display', 'ID', 'index'));
Router::connect('/about-us', array('front' => true, 'controller' => 'fronts', 'action' => 'display', 'ID', 'aboutus'));

//member-area
Router::connect('/profil', array('member' => true, 'prefix' => 'front', 'controller' => 'fronts', 'action' => 'display', 'ID', 'profil'));
Router::connect('/member/logout', array('controller' => 'accounts', 'action' => 'logout_member'));

//Router::connect('/:lang/:page', array('front' => true, 'controller' => 'fronts', 'action' => 'display'), array("pass" => array('lang', 'page'), "lang" => "[A-Z]{2}"));
//=======================================================================================================
//admin area
Router::connect('/admin/change-password', array('admin' => true, 'controller' => 'accounts', 'action' => 'change_password'));
Router::connect('/admin', array('controller' => 'accounts', 'action' => 'login_admin'));
Router::connect('/', array('controller' => 'accounts', 'action' => 'login_admin'));
Router::connect('/admin/lupa-password', array('controller' => 'accounts', 'action' => 'login_utama_lupa_password'));
Router::connect('/admin/dashboard', array('admin' => true, 'controller' => 'accounts', 'action' => 'dashboard'));
Router::connect('/admin/logout', array('controller' => 'accounts', 'action' => 'logout_admin'));
Router::connect('/admin/cash', array('admin' => true, 'controller' => 'initial_balances', 'action' => 'index'));
Router::connect('/reset-password/*', array('controller' => 'accounts', 'action' => 'reset_password'));

//Router::connect('/admin/debt_list', array('admin' => true, 'controller' => 'transaction_entries', 'action' => 'debt_list'));

Router::connect("/admin/generate-cooperative-balance", array('admin' => true, 'controller' => 'cooperative_transaction_mutations', 'action' => 'generate_balance_before_and_after_transaction'));

//index
Router::connect('/module/*', array('admin' => true, 'controller' => 'modules', 'action' => 'index'));
Router::connect('/module-content/*', array('admin' => true, 'controller' => 'module_contents', 'action' => 'index'));
Router::connect('/account/*', array('admin' => true, 'controller' => 'accounts', 'action' => 'index'));
Router::connect('/admin/earnings', array('admin' => true, 'controller' => 'employee_salaries', 'action' => 'earning_index'));
Router::connect('/admin/transaction_entries/stok', array('admin' => true, 'controller' => 'transaction_entries', 'action' => 'stok'));

//add
Router::connect('/module-add', array('admin' => true, 'controller' => 'modules', 'action' => 'add'));
Router::connect('/module-content-add', array('admin' => true, 'controller' => 'module_contents', 'action' => 'add'));
Router::connect('/account-add', array('admin' => true, 'controller' => 'accounts', 'action' => 'add'));

//edit
Router::connect('/module-edit/*', array('admin' => true, 'controller' => 'modules', 'action' => 'edit'));
Router::connect('/module-content-edit/*', array('admin' => true, 'controller' => 'module_contents', 'action' => 'edit'));
Router::connect('/account-edit/*', array('admin' => true, 'controller' => 'accounts', 'action' => 'edit'));

//Report
Router::connect("/admin/restriction", array("admin" => true, "controller" => "accounts", "action" => "restriction"));

//Setting
Router::connect('/setting', array('admin' => true, 'controller' => 'company_profiles', 'action' => 'edit','1'));

//Convert Material to Product
Router::connect('/products/convert', array('controller' => 'products', 'action' => 'convert_admin'));
Router::connect('/products/stocks', array('controller' => 'products', 'action' => 'stock_admin'));

//detail

//Report
Router::connect('/transaction_entries/report', array('controller' => 'transaction_entries', 'action' => 'report'));
Router::connect('/transaction_entries/daily_weighting', array('controller' => 'transaction_entries', 'action' => 'stock_daily_weighting'));
Router::connect('/packages/daily_packaging', array('controller' => 'packages', 'action' => 'stock_daily_packaging'));
Router::connect('/boxes/daily_packaging', array('controller' => 'boxes', 'action' => 'stock_daily_boxing'));
Router::connect('/transaction_outs/report', array('controller' => 'transaction_outs', 'action' => 'report'));


//api
Router::connect("/api/statuscode",["api"=>true,"controller"=>"accounts","action"=>"status_code"]);
Router::connect("/api/login",["api"=>true,"controller"=>"accounts","action"=>"login"]);
Router::connect("/api/heal",["api"=>true,"controller"=>"accounts","action"=>"heal"]);
Router::connect("/api/loadpackage",["api"=>true,"controller"=>"package_details","action"=>"load_to_container"]);
Router::connect("/api/viewpackage",["api"=>true,"controller"=>"package_details","action"=>"detail"]);
Router::connect("/api/profile",["api"=>true,"controller"=>"accounts","action"=>"profile"]);
Router::connect("/api/restriction",["api"=>true,"controller"=>"accounts","action"=>"restriction"]);
Router::connect("/api/cancel",["api"=>true,"controller"=>"package_details","action"=>"cancel_loading"]);

Router::connect("/api/updatepackage",["api"=>true,"controller"=>"package_details","action"=>"update_package"]);

// generate sql script
Router::connect("/generate-sql-data-sale-product-additional", ['admin' => true, 'controller' => 'sale_product_additionals', 'action' => 'export_mixed_data_sale_product_additional']);

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
