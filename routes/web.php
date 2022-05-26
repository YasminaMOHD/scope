<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/lead/destroy-all',[LeadController::class , 'destroyAll'])->name('destroyall');

