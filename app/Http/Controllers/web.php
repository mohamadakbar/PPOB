<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/login', 'Login2Controller@loginForm')->name('login');
Route::post('/login',  'Login2Controller@login');
Route::get('/logout',  'Login2Controller@logout');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/denied', function () {
  return view('denied');
});

Route::get('/cache_check/{id}', function ($id) {

  //Cache::flush();
  if($id=="body"){

    //Form
    $type = Cache::get('formtype');
    $key = Cache::get('param_key');
    $value = Cache::get('param_value');
    //JSON
    $param_body = Cache::get('param_body');
    $param_body = base64_decode($param_body);
    //Return
    return "Formtype:".$type." Param_Key:".$key." Param_Value:".$value." Param_Body:".$param_body;

  }elseif($id=="auth"){

    //Basic
    $type = Cache::get('authtype');
    $uname = Cache::get('uname');
    $passwd = Cache::get('passwd');
    //Key
    $apikey = Cache::get('apikey');
    $apivalue = Cache::get('apivalue');
    //Token
    $token = Cache::get('token');
    //Return
    return "Authtype:".$type." Uname:".$uname." Passwd:".$passwd." Apikey:".$apikey." Apivalue:".$apivalue." Token:".$token;

  }elseif($id=="resp"){

    //Form
    $type = Cache::get('resptype');
    $rcode = Cache::get('resp_code');
    $rdesc = Cache::get('resp_desc');
    //Return
    return "Formtype:".$type." RCode:".$rcode." RDesc:".$rdesc;

  }

});

Route::group(['prefix'=>'adminpanel', 'middleware'=>['auth', 'role:Administrator']], function () {
//Route::group(['prefix'=>'adminpanel'], function () {

  //General Controller
  Route::post('store_formtype', 'GeneralController@store_formtype');
  Route::post('store_authtype', 'GeneralController@store_authtype');
  Route::post('store_resptype', 'GeneralController@store_resptype');

  //Manage User Groups
  Route::resource('groupuser','GroupUsersController');
  Route::any('getgroupuser', 'GroupUsersController@getGroupUsers')->name('get.groupuser');
  Route::any('deletegroupuser/{id}', 'GroupUsersController@deletegroupuser');

  //Manage Users
  Route::resource('manusers','UsersController');
  Route::any('getusers', 'UsersController@getUsers')->name('get.users');
  Route::post('users/store','UsersController@store')->name('manusers.link');
  Route::post('users/update/{id}','UsersController@update')->name('manusers.updates');
  Route::any('users/changepassword/{id}', 'UsersController@changepassword')->name('manusers.password');
  Route::any('deleteuser/{id}', 'UsersController@deleteUser');
  Route::any('username/{name}', 'UsersController@username')->name('manusers.username');
  Route::any('checkhashpassword', 'UsersController@checkhashpassword')->name('manusers.checkpass');

  //Manage Role Users
  Route::resource('roleusers','RoleUsersController');
  Route::any('getroleusers', 'RoleUsersController@getRoleUsers')->name('get.roleusers');
  Route::any('deleteroleuser/{id}', 'RoleUsersController@deleteroleuser');

  //Manage Clients
  Route::resource('client','ClientController');
  Route::any('getclient', 'ClientController@getClient')->name('get.client');
  Route::any('deleteclient/{id}', 'ClientController@deleteclient');
  Route::any('allclients', 'ClientController@show')->name('allclients');
  Route::any('setprice_list/{id}', 'ClientController@setprice_list')->name("client.setprice_list");
  Route::any('getclientprice', 'ClientController@getClientPrice')->name('get.clientprice');
  Route::post('editclientprice', 'ClientController@postEditClientPrice')->name('clientPrice.editPrice');

  //Manage Product Types
  Route::resource('prodtype','ProductTypeController');
  Route::any('getprodtype', 'ProductTypeController@getProdtype')->name('get.prodtype');
  Route::any('allprodtype', 'ProductTypeController@show')->name('allprodtype');
  Route::post('prodtype/store','ProductTypeController@store')->name('prodtype.link');
  Route::post('prodtype/update/{id}','ProductTypeController@update');
  Route::any('deleteprodtype/{id}', 'ProductTypeController@deleteprodtype');

  //Manage Product Categories
  Route::resource('prodcat','ProductCatController');
  Route::any('getprodcat', 'ProductCatController@getProdcat')->name('get.prodcat');
  Route::any('allprodcat', 'ProductCatController@show')->name('allprodcat');
  Route::post('prodcat/store','ProductCatController@store')->name('prodcat.link');
  Route::post('prodcat/update/{id}','ProductCatController@update');
  Route::any('deleteprodcat/{id}', 'ProductCatController@deleteprodcat');

  //Manage Partners
  Route::resource('prodpartner','ProductPartnerController');
  Route::any('getprodpartner', 'ProductPartnerController@getProdpartner')->name('get.prodpartner');
  Route::post('prodpartner/store','ProductPartnerController@store')->name('prodpartner.link');
  Route::post('prodpartner/update/{id}','ProductPartnerController@update')->name('prodpartner.updates');
  Route::any('deletepartner/{id}', 'ProductPartnerController@deletepartner');
  Route::any('allpartners', 'ProductPartnerController@show')->name('allpartners');
  
  //Manage Partners Product
  Route::resource('prodforpartner','ProductForPartnerController');
  Route::any('getlistprodpartner/{id}', 'ProductForPartnerController@getProdForpartner')->name('get.ProdForpartner');
  Route::any('getproductforpartner/{id}', 'ProductForPartnerController@getList')->name('get.getprodforpartnerList');
  Route::any('getproductforpartnerByProductCode', 'ProductForPartnerController@getListByProductCode')->name('get.partnerListByProductCode');
  Route::post('productforpartner/store','ProductForPartnerController@store')->name('productforpartner.link');
  Route::post('productforpartner/update/{id}','ProductForPartnerController@update');
  Route::any('deleteproductforpartner/{id}', 'ProductForPartnerController@deleteproductforpartner');
  Route::post('productforpartner-upload/import_excel/import', 'ProductForPartnerController@import')->name('productforpartnerUpload');


  //Manage Products
  Route::resource('product','ProductController');
  Route::any('getproduct', 'ProductController@getProduct')->name('get.product');
  Route::post('product/store','ProductController@store')->name('product.link');
  Route::post('product/update/{id}','ProductController@update')->name('product.updates');
  Route::any('deleteproduct/{id}', 'ProductController@deleteproduct');
  Route::any('allproduct', 'ProductController@show')->name('allproduct');
  //import excel
  Route::post('product-upload/import_excel/import', 'ProductController@import')->name('productUpload');
  
  //Manage Products List
  Route::resource('product-list','ProductListController');
  Route::any('getproduct-list', 'ProductListController@getProduct')->name('get.productList');
  Route::post('product-list/store','ProductListController@store')->name('productList.link');
  Route::post('product-list/update/{id}','ProductListController@update')->name('productList.updates');
  Route::any('deleteproduct-list/{id}', 'ProductListController@deleteproductList');
  Route::any('allproduct-list', 'ProductListController@show')->name('allproductList');

  //Manage Deposit
  Route::resource('deposit','DepositController');
  Route::any('getdeposit', 'DepositController@getDeposit')->name('get.deposit');
  Route::any('excel', 'DepositController@excel')->name('get.exceldeposit');
  Route::get('/export-excel', 'DepositController@exportExcel');

  //Manage Reporting
  Route::resource('reporting','ReportingController');
  Route::any('getreporting', 'ReportingController@getReporting')->name('get.reporting');
  Route::any('excelreporting', 'ReportingController@excel')->name('get.excelreporting');
  Route::get('/export-excelreport', 'ReportingController@exportReport');

  //Manage Adaptor
  Route::resource('adaptor','AdaptorController');
  Route::any('getadaptor', 'AdaptorController@getAdaptor')->name('get.adaptor');
  Route::post('adaptor/store','AdaptorController@store')->name('adaptor.link');
  Route::post('adaptor/update/{id}','AdaptorController@update')->name('adaptor.updates');
  Route::any('deleteadaptor/{id}', 'AdaptorController@deleteadaptor');
  Route::any('alladaptor', 'ProductController@show')->name('alladaptor');

  //Manage Switching
  Route::resource('switching','SwitchingController');
  Route::any('getswitching', 'SwitchingController@getReporting')->name('get.switching');
  Route::post('switching/store','SwitchingController@store')->name('switching.link');
  Route::get('switch-automation', 'SwitchAutomationController');
  
  //Response code
  Route::resource('sprint-code','SprintCodeController');
  Route::any('getsprintcode', 'SprintCodeController@getSprintcode')->name('get.sprintcode');
  Route::post('sprint-code/update/{id}','SprintCodeController@update')->name('sprintcode.updates');
  Route::post('sprint-code/store','SprintCodeController@store')->name('sprintcode.link');
  Route::any('deleteSprintCode/{id}', 'SprintCodeController@deleteSprintCode');
  
});


// Route::group(['prefix'=>'clientuser', 'middleware'=>['auth', 'role:Approver']], function () {

//   //General Controller
//   Route::post('store_formtype', 'GeneralController@store_formtype');
//   Route::post('store_authtype', 'GeneralController@store_authtype');
//   Route::post('store_resptype', 'GeneralController@store_resptype');

//   //Manage Clients
//   Route::resource('client','ClientController');
//   Route::any('getclient', 'ClientController@getClient')->name('get.client');
//   Route::any('deleteclient/{id}', 'ClientController@deleteclient');

//   //Manage Partners
//   Route::resource('prodvend','ProductPartnerController');
//   Route::any('getprodvend', 'ProductPartnerController@getProdvend')->name('get.prodvend');
//   Route::any('deletevendor/{id}', 'ProductPartnerController@deletevendor');


// });
