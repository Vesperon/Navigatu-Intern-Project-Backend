<?php
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


//for X-CSRF-TOKEN header
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()])
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, X-CSRF-TOKEN');

});
//Login API
// Route::post('/auth/login',[AuthController::class, 'login']);
Route::post('/auth/register',[AuthController::class, 'register']);
//Login API


//Inventory APIs
Route::post('/inventory/add',[ItemController::class, 'add'])->middleware('auth:sanctum');

Route::get('/inventory',[ItemController::class, 'readAll']);
Route::get('/inventory/{name}',[ItemController::class, 'readItem']);
Route::put('/inventory/update',[ItemController::class, 'update'])->middleware('auth:sanctum');
Route::post('/inventory/consume',[ItemController::class, 'consume'])->middleware('auth:sanctum');
Route::delete('/inventory/delete/{id}',[ItemController::class, 'delete'])->middleware('auth:sanctum');
//Inventory APIs
//Track APIs
    //Borrow APIs
Route::post('/track/borrow',[BorrowController::class, 'borrow'])->middleware('auth:sanctum');
Route::get('/track/borrowed',[BorrowController::class, 'borrowed']);
Route::delete('/track/borrowed/delete/{id}',[BorrowController::class, 'delete'])->middleware('auth:sanctum');
    //Borrow APIs
    //Return APIs
Route::post('/track/return',[ReturnController::class, 'returned'])->middleware('auth:sanctum');
Route::get('/track/returned',[ReturnController::class, 'returnedItem']);
    //Return APIs
//Inventory APIs
//Logs APIs
Route::get('/logs',[LogsController::class, 'logs']);
//Logs APIs
