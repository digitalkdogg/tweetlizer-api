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

//Route::group([
//    'namespace' => 'Customers', //namespace App\Http\Controllers\Customers;
//    'middleware' => 'auth:api', // this is for check user is logged in or authenticated user
//    'prefix' => 'customers' // you can use custom prefix for your rote {{host}}/api/customers/

//], function ($router) {
    // add and delete customer groups
//    Route::get('/', [CustomerController::class, 'index']); // {{host}}/api/customers/  this is called to index method in CustomerController.php
//    Route::post('/create', [CustomerController::class, 'create']); // {{host}}/api/customers/create this is called to create method in CustomerController.php
//    Route::post('/show/{id}', [CustomerController::class, 'show']); // {{host}}/api/customers/show/10 this is called to show method in CustomerController.php parsing id to get single data
//    Route::post('/delete/{id}', [CustomerController::class, 'delete']); // {{host}}/api/customers/delete/10 this is called to delete method in CustomerController.php for delete single data
//});

Route::get('/test', function () {
    $data = ['message' => 'No new orders!','kevin'=>'bollman'];

    return response($data, 200)->header('Content-Type', 'application/json');
    //return response('Test API', 200)
    //   ->header('Content-Type', 'application/json');
});