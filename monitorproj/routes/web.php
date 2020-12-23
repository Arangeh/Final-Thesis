<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableController;

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

Route::post('/portstats', [TableController::class, 'addPort'])->name('port.addPort');
Route::get('/portstats', [TableController::class, 'getAllPortStats'])->name('port.getAllPortStats');
Route::get('/portstat/delete-all', [TableController::class, 'deleteAllPortStats'])->name('port.deleteall');

Route::post('/flowstats', [TableController::class, 'addFlow'])->name('flow.addFlow');
Route::get('/flowstats', [TableController::class, 'getAllFlowStats'])->name('flow.getAllFlowStats');
Route::get('/flowstat/delete-all', [TableController::class, 'deleteAllFlowStats'])->name('port.deleteall');
