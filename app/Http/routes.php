<?php

Route::group(['middleware' => ['auth','admin']], function($group) {
    $group->get('/album/new', 'AlbumController@create');
    $group->post('/album/new', 'AlbumController@save');
    
    $group->get('/album/{id}/upload', 'AlbumController@upload');
    $group->get('/album/{id}/users', 'AlbumController@users');
    $group->post('/album/{id}/user', 'AlbumController@updateUser');
    $group->post('/photo/upload', 'PhotoController@upload');
});

Route::group(['middleware' => ['auth','access:album']], function($group) {
    $group->get('/album/{id}', 'AlbumController@view');
});

Route::group(['middleware' => ['auth','access:photo']], function($group) {
    $group->get('/photo/{id}', 'PhotoController@download');
    $group->get('/photo/view/{id}', 'PhotoController@view');
});

Route::group(['middleware' => 'auth'], function($group) {
    $group->get('/', 'AlbumController@index');
    $group->get('/home', 'AlbumController@index');
    $group->get('/albums', 'AlbumController@index');
});

Route::get('/auth/logout','Auth\AuthController@getLogout');
Route::get('/auth/login','Auth\AuthController@getLogin');
Route::post('/auth/login','Auth\AuthController@postLogin');
Route::get('/auth/register','Auth\AuthController@getRegister');
Route::post('/auth/register','Auth\AuthController@postRegister');
Route::get('/register','Auth\AuthController@getRegister');
Route::get('/password/email','Auth\PasswordController@getEmail');
Route::post('/password/email','Auth\PasswordController@postEmail');
Route::get('/password/reset/{token}','Auth\PasswordController@getReset');
Route::post('/password/reset','Auth\PasswordController@postReset');