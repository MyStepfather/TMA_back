<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\OpozdunController;
use App\Http\Controllers\Api\PresentationController;
use App\Http\Controllers\Api\RequisiteController;
use Illuminate\Support\Facades\Route;

Route::post('/auth', [AuthController::class, 'index']);

Route::post('/card', [CardController::class, 'saveCard']);
Route::get('/cards', [CardController::class, 'getCards']);
Route::patch('/card/{id}', [CardController::class, 'updateCard']);
Route::delete('/card/{id}', [CardController::class, 'deleteCard']);

Route::get('/requisites', [RequisiteController::class, 'getRequisites']);
Route::get('/requisites/companies', [RequisiteController::class, 'getCompanies']);

Route::get('/devices/categories', [DeviceController::class, 'getCategories']);
Route::get('/device/{id}', [DeviceController::class, 'getDevice']);
Route::get('/devices', [DeviceController::class, 'getDevices']);

Route::get('/presentations', [PresentationController::class, 'getPresentations']);
Route::get('/presentations/companies', [PresentationController::class, 'getCompanies']);
Route::get('/presentations/categories', [PresentationController::class, 'getCategories']);
Route::get('/presentation/{id}', [PresentationController::class, 'getPresentation']);

Route::get('/events', [EventController::class, 'getEventsByMonth']);
Route::get('/events/active', [EventController::class, 'getActiveEvents']);

Route::post('/opozdun', [OpozdunController::class, 'createOpozdun']);