<?php

Route::resource('/', 'DashboardController@index');
Route::resource('home', 'DashboardController@index');

Route::get('about', 'PagesController@about');
Route::get('contact', 'PagesController@contact');

Route::resource('users', 'UserController');
Route::resource('projects', 'ProjectsController');
Route::resource('requirements', 'RequirementsController');
Route::resource('context', 'ContextController');
Route::resource('context-ideal-way', 'ContextIdealWayController');

Route::get('review/{id}', 'RequirementsController@review');

Route::post('save-context-ratings', 'ContextController@saveContextRatings');
Route::post('save-ways-of-interaction-voting', 'ContextController@saveWaysOfInteractionVoting');
Route::post('save-remarks', 'ContextController@saveRemarks');
Route::post('remarks-list', 'ContextController@remarksList');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);