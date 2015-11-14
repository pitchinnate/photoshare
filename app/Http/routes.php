<?php

Route::group(['middleware' => ['auth','admin']], function($group) {
    $group->get('/album/new', 'AlbumController@create');
    $group->post('/album/new', 'AlbumController@save');
    $group->get('/album/{id}/upload', 'AlbumController@upload');
    $group->get('/album/{id}/users', 'AlbumController@users');
    $group->post('/album/{id}/user', 'AlbumController@updateUser');
    $group->get('/album/{id}/notify', 'AlbumController@getNotify');
    $group->post('/album/{id}/notify', 'AlbumController@postNotify');
    $group->post('/photo/upload/{id}', 'PhotoController@upload');
    $group->get('/photo/rotate/{id}/{angle}', 'PhotoController@rotate');
    $group->get('/photo/delete/{id}', 'PhotoController@delete');
    $group->get('/user', 'UserController@index');
    $group->get('/user/invite', 'UserController@invite');
    $group->post('/user/invite', 'UserController@invitePost');
    $group->get('/user/admin/{id}', 'UserController@admin');
});

Route::group(['middleware' => ['auth','access:album']], function($group) {
    $group->get('/album/{id}', 'AlbumController@view');
    $group->get('/album/{id}/{page}', 'AlbumController@view');
});

Route::group(['middleware' => ['auth','access:photo']], function($group) {
    $group->get('/photo/{id}', 'PhotoController@download');
    $group->get('/photo/thumb/{id}', 'PhotoController@thumb');
    $group->get('/photo/view/{id}', 'PhotoController@view');
    $group->get('/photo/view/{id}/{move}', 'PhotoController@view');
});

Route::group(['middleware' => 'auth'], function($group) {
    $group->get('/', 'AlbumController@index');
    $group->get('/home', 'AlbumController@index');
    $group->get('/albums', 'AlbumController@index');
    $group->get('/password/update', 'Auth\PasswordController@getUpdate');
    $group->post('/password/update', 'Auth\PasswordController@postUpdate');
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
Route::get('/user/invited',['as' => 'user.invited','uses'=>'UserController@getInvited']);
Route::post('/user/invited','UserController@postInvited');