<?php

use App\Http\Controllers\agentdetailsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// -------------------------------------------CustomerController-----------------------------------------//////

Route::post('/loginAuth', [App\Http\Controllers\CustomerController::class, 'loginAuth'])->name('loginAuth');
Route::post('/forgotPassword', [App\Http\Controllers\CustomerController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('/resetPassword', [App\Http\Controllers\CustomerController::class, 'resetPassword'])->name('resetPassword');
Route::post('/change_password', [App\Http\Controllers\CustomerController::class, 'change_password'])->name('change_password');

///-----------------------------------------------------AgentdetailsController--------------------------------------------------------///

Route::post('/saveAgentDetails', [App\Http\Controllers\agentdetailsController::class, 'saveAgentDetails'])->name('saveAgentDetails');
Route::post('/checkEmail', [App\Http\Controllers\agentdetailsController::class, 'checkEmail'])->name('checkEmail');
Route::post('/checkMobileno', [App\Http\Controllers\agentdetailsController::class, 'checkMobileno'])->name('checkMobileno');

//---------------------------------------------------------------Practise-------------------------------------------//

Route::post('/insertData', [App\Http\Controllers\agentdetailsController::class, 'insertData'])->name('insertData');
Route::put('/updateData', [App\Http\Controllers\agentdetailsController::class, 'updateData'])->name('updateData');
Route::delete('/deleteData', [App\Http\Controllers\agentdetailsController::class, 'deleteData'])->name('deleteData');
Route::get('/getAgentdetails',[App\Http\Controllers\agentdetailsController::class,'getAgentdetails'])->name('getAgentdetails');


Route::post('/generatePdf',[App\Http\Controllers\agentdetailsController::class,'generatePdf'])->name('generatePdf');
Route::post('/saveImageData',[App\Http\Controllers\agentdetailsController::class,'saveImageData'])->name('saveImageData');
Route::get('/getData',[App\Http\Controllers\CustomerController::class,'getData'])->name('getData');