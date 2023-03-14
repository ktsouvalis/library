<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;

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

Route::get('/', function () {
    return view('index');
}); // ->name('login'); NEEDED WHEN MIDDLEWARE('AUTH') IS USED

Route::post('/login', [UserController::class,'login']);
Route::get('/logout',[UserController::class, 'logout']);

Route::get('/search_student', function(){
    return view('search-student');
});//->middleware('auth');

Route::post('/search_student', [StudentController::class,'findStudent']);

Route::post('/return_book',[LoanController::class, 'return_book'])->middleware('auth');

Route::get('/profile/{student}',[StudentController::class, 'show_profile'])->middleware('auth');