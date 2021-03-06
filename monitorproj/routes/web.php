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
/*
Route::get('/', function (){
	return view('welcome');
});
*/
/*
Route::get('/', function(){
	return view('layouts.admin');
});
*/
// /*
Route::get('/',function(){
	return view('main');
	// return view('dashboard');
})
// ->middleware('authadmin')
;
Route::get('/port-statistics', function(){
	return view('port-statistics');
});

Route::get('/flow-statistics', function(){
	return view('flow-statistics');
});

// /*
Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return view('main');
})
->name('admin.dashboard')
;
// */

///*
Route::get('/main',function(){
	return view('main');
});
//*/

// */

/*
// For User or Customer
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
		Route::get('/user/dashboard')
});


// For Admin
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
	Route::get('/admin/dashboard', function(){
		return view('main');
	})->name('admin.dashboard');		
});
*/
Route::get('/connected-devices', function(){
	return view('connected-devices');
})->middleware('authadmin');
Route::get('/capabilities-configurations', function(){
	return view('capabilities-configurations');
})->name('admin.caps-confs')->middleware('authadmin');
Route::post('/portstats', [TableController::class, 'addPort'])->name('port.addPort');
Route::get('/portstats', [TableController::class, 'getAllPortStats'])->name('port.getAllPortStats')
->middleware('authadmin')
;
Route::get('/portstat/delete-all', [TableController::class, 'deleteAllPortStats'])->name('port.deleteall')->middleware('authadmin');

Route::post('/flowstats', [TableController::class, 'addFlow'])->name('flow.addFlow');
Route::get('/flowstats', [TableController::class, 'getAllFlowStats'])->name('flow.getAllFlowStats')->middleware('authadmin');
Route::get('/flowstat/delete-all', [TableController::class, 'deleteAllFlowStats'])->name('port.deleteall')->middleware('authadmin');



Route::post('/events', [TableController::class, 'addEvent'])->name('event.addEvent');
Route::get('/events', [TableController::class, 'getAllEvents'])->name('event.getAllEvents')->middleware('authadmin');
Route::get('/event/delete-all', [TableController::class, 'deleteAllEvents'])->name('event.deleteall')->middleware('authadmin');

Route::post('/swdesc', [TableController::class, 'addSwitchDescription'])->name('switch.addDescription');

Route::post('/swportsdesc', [TableController::class, 'addSwitchPortDescription'])->name('switch.addPortDescription');

Route::post('/swtables', [TableController::class, 'addSwitchTable'])->name('switch.addTable');

Route::post('/swfeatures', [TableController::class, 'addSwitchFeature'])->name('switch.addFeature');

Route::post('/swflows', [TableController::class, 'addSwitchFlow'])->name('switch.addFlow');

Route::post('/swids', [TableController::class, 'addSwitchID'])->name('switch.addID');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


