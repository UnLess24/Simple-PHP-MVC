<?php

namespace App;

use App\Kernel\Route;

Route::get('/', 'MainController@getMain');
Route::get('api/api', 'MainController@getApi');
Route::get('todos', 'TodoController@getTodos');
Route::get('todos/add', 'TodoController@getAddTodo');
Route::post('todos/add', 'TodoController@postAddTodo');
Route::put('todos/change/{id}', 'TodoController@putChangeTodo');
Route::get('users/admin/login', 'UserController@getLoginAdmin');
Route::post('users/admin/login', 'UserController@postLoginAdmin');
Route::get('users/admin/logout', 'UserController@getLogoutAdmin');
Route::get('todos/{id}', 'TodoController@getTodo');
Route::get('users/{id}', 'UserController@getUser');
