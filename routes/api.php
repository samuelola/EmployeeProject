<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ProjectController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::apiResource('employees', EmployeeController::class);
Route::apiResource('projects', ProjectController::class);
Route::post('/restore_employee/{id}',[EmployeeController::class,'restoreData']);