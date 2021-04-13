<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
Route::get('/users',function(){
    return 'Hi users';
});
*/

/*
//Required Parameter
Route::get('users/{name}',function($name){
    return 'Hi '. $name;
});
*/

//Optional Parameter with alphabetical constraint on user name
Route::get('/users/{name?}',function($name = null){
    return 'Hi ' . $name;    
})->where('name','[a-zA-Z]+');

//Optional parameter with numerical constraint on product id
Route::get('/products/{id?}',function($id = null){
    return 'Product id is ' . $id;
})->where('id','[0-9]+');

Route::match(['get','post'], '/students', function(Request $req){
    return 'Requested method is ' . $req->method();
});

//generalized form of the previous example
Route::any('/posts', function(Request $req){
    return 'Requested method is ' . $req->method();
});