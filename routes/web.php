<?php

use App\Http\Controllers\CitizenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ajax routes
Route::get('/get-blocks/{state_id}', [CitizenController::class, 'getBlocks']);
Route::get('/get-panchayats/{block_id}', [CitizenController::class, 'getPanchayats']);
Route::get('/get-villages/{panchayat_id}', [CitizenController::class, 'getVillages']);
Route::get('/citizens-list', [CitizenController::class, 'list']);

Route::resource('citizens', CitizenController::class);