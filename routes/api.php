<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//route events
Route::get('/events', [\App\Http\Controllers\EventController::class, 'index']);
Route::get('/events/{id}', [\App\Http\Controllers\EventController::class, 'show']);
Route::post('/events', [\App\Http\Controllers\EventController::class, 'store']);
Route::put('/events/{id}', [\App\Http\Controllers\EventController::class, 'update']);
Route::delete('/events/{id}', [\App\Http\Controllers\EventController::class, 'destroy']);

//route ticket types
Route::get('/ticket-types',[\App\Http\Controllers\TicketTypeController::class,'index']);
Route::get('/ticket-types/{id}',[\App\Http\Controllers\TicketTypeController::class,'show']);
Route::post('/ticket-types',[\App\Http\Controllers\TicketTypeController::class,'store']);
Route::put('/ticket-types/{id}',[\App\Http\Controllers\TicketTypeController::class,'update']);
Route::delete('/ticket-types/{id}',[\App\Http\Controllers\TicketTypeController::class,'destroy']);

//route tickets
Route::get('/tickets',[\App\Http\Controllers\TicketController::class,'index']);
Route::get('/tickets/{id}',[\App\Http\Controllers\TicketController::class,'show']);
Route::post('/tickets',[\App\Http\Controllers\TicketController::class,'store']);
Route::put('/tickets/{id}',[\App\Http\Controllers\TicketController::class,'update']);
Route::delete('/tickets/{id}',[\App\Http\Controllers\TicketController::class,'destroy']);

//route users
Route::get('/users',[\App\Http\Controllers\UserController::class,'index']);
Route::get('/users/{id}',[\App\Http\Controllers\UserController::class,'show']);
Route::post('/users',[\App\Http\Controllers\UserController::class, 'store']);
Route::put('/users/{id}',[\App\Http\Controllers\UserController::class,'update']);
Route::delete('/users/{id}',[\App\Http\Controllers\UserController::class,'destroy']);

