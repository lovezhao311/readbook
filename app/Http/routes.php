<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/





//后台
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function()
{  	
	Route::get('/' , ['as'=>'login_user','uses'=>'IndexController@index']);
	Route::get('/index/main' , ['as'=>'login_user','uses'=>'IndexController@main']);
	Route::get('/alert',function(){		
		return view('admin.common.alert')->with(Session::all());
	});
	#公共
	Route::group(['prefix'=>'common' , 'namespace'=>'Common'] , function(){		
		Route::controller('login' , 'LoginController');
		Route::controller('left' , 'LeftController');	
		//验证码
		Route::get('captcha/{type}' , function($type='default')
		{
			return Captcha::create($type);
		});
	});	

	#权限管理
	Route::group(['prefix'=>'rbac' , 'namespace'=>'Rbac' ,  'middleware'=>'authLogin'] , function(){
		Route::resource('roles' , 'RolesController');
		Route::resource('permission' , 'PermissionController');
		Route::resource('manage' , 'ManageController');		
		Route::resource('navigation' , 'NavigationController');	
	});
	
	
});




