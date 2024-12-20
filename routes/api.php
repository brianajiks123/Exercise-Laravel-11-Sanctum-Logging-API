<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TodolistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Auth
Route::post("/v1/register", RegisterController::class);
Route::post("/v1/login", LoginController::class);
Route::get('/v1/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post("/v1/logout", LogoutController::class)->middleware('auth:sanctum');

// Todolist
Route::get('/v1/todos', [TodolistController::class, "index"])->middleware('auth:sanctum');
Route::post('/v1/todo', [TodolistController::class, "store"])->middleware('auth:sanctum');
Route::get('/v1/todo/{id}', [TodolistController::class, "show"])->middleware('auth:sanctum');
Route::put('/v1/todo/{id}', [TodolistController::class, "update"])->middleware('auth:sanctum');
Route::delete('/v1/todo/{id}', [TodolistController::class, "destroy"])->middleware('auth:sanctum');
