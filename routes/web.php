<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalenderController;

Route::get('/calendar-event', [CalenderController::class, 'index']);
Route::post('/calendar-crud-ajax', [CalenderController::class, 'calendarEvents']);