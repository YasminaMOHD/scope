<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AgentsController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Agent_LeadController;
use App\Http\Controllers\CampaginesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [MenuController::class, 'index'])->name('admin.index')->middleware(['auth']);
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Route::get('/lead', [MenuController::class,'lead'])->name('lead');
    // Route::get('/agent', [MenuController::class,'agent'])->name('agent');
    // Route::get('/compaigen', [MenuController::class,'compaigen'])->name('compaigen');
    Route::get('/excel', [MenuController::class,'excel'])->name('excel');
    // Route::get('/project', [MenuController::class,'project'])->name('project');
    Route::get('/secuirety', [MenuController::class,'secuirety'])->name('secuirety');
    Route::resource('/agent', AgentsController::class);
    Route::resource('/agent_lead', Agent_LeadController::class);
    Route::resource('/campaigen', CampaginesController::class);
    Route::resource('/project', ProjectsController::class);
    Route::resource('/landing', LandingController::class);
});
Route::prefix('super-admin')->name('superAdmin.')->middleware('auth')->group(function () {
    Route::resource('/role', RoleController::class);
    Route::resource('/status', StatusController::class);
});
Route::resource('/lead', LeadController::class);

Route::resource('/lead', LeadController::class);
Route::resource('/inventory', InventoryController::class);
Route::get('/Lead_Trash',[LeadController::class , 'trash'])->name('lead.trash');
Route::get('/Lead_restote/{id}',[LeadController::class , 'restore'])->name('lead.restore');
Route::post('/lead_desc/{id}',[LeadController::class , 'leadDesc'])->name('lead.desc');
Route::get('/lead_desc/update',[LeadController::class , 'leadDescUpdate'])->name('lead.desc.update');
Route::get('/lead_desc/delete',[LeadController::class , 'leadDescdel'])->name('lead.desc.delete');
Route::get('/lead_desc/reminder',[LeadController::class , 'reminder'])->name('lead.desc.reminder');
Route::post('/lead_import',[LeadController::class , 'import'])->name('lead.import');
Route::get('/send-reminder',[LeadController::class , 'sendReminder'])->name('lead.sendReminder');
Route::get('/search/{status?}/{lead?}', [LeadController::class, 'search'])->name('lead.search');
Route::post('/assign/{lead}', [LeadController::class, 'assign'])->name('lead.assign');
Route::post('/admin/confirm_change',[SecurityController::class , 'change'])->name('updatepassword');
Route::post('/admin/change_password',[SecurityController::class , 'update'])->name('change_password');
Route::get('/admin/filter-data',[MenuController::class , 'filter'])->name('filter');
Route::fallback(function(){
    return view('error.404');
});
// Route::get('/lead/destroy-all',[LeadController::class , 'destroyAll'])->name('destroyall');

