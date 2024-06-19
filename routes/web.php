<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/projects', [ProjectsController::class, 'index']);
Route::get('/projects/{project}', [ProjectsController::class, 'show']);
Route::post('/projects', [ProjectsController::class, 'store']);
