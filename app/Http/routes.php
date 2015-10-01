<?php

Route::resource('/', 'WelcomeController@index');

Route::get('about', 'PagesController@about');
Route::get('contact', 'PagesController@contact');

Route::resource('projects', 'ProjectsController');
