<?php

use App\Models\Student;
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

// Route::get('/', function () {
//     return view('index');
// }); //->name('login'); //NEEDED WHEN MIDDLEWARE('AUTH') IS USED

Route::view('/','index');

Route::post('/login', [UserController::class,'login']);
Route::get('/logout',[UserController::class, 'logout']);

Route::get('/student', function(){
    return view('student');
})->middleware('myauth');

Route::post('/student', [StudentController::class,'studentActions']);

Route::post('/return_book',[LoanController::class, 'return_book'])->middleware('myauth');

Route::get('/profile/{student}',[StudentController::class, 'show_profile'])->middleware('myauth');

Route::get('/edit_student/{student}', function(Student $student){
    return view('edit-student',['student' => $student]);
})->middleware('myauth');

Route::post('/edit_student/{student}', [StudentController::class, 'save_profile'])->middleware('myauth');