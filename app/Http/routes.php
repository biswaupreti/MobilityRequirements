<?php

Route::resource('/', 'DashboardController@index');
Route::resource('home', 'DashboardController@index');

Route::get('about', 'PagesController@about');
Route::get('contact', 'PagesController@contact');

Route::resource('users', 'UserController');
Route::resource('projects', 'ProjectsController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);