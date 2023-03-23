<?php

use App\Models\Book;
use App\Models\Loan;
use App\Models\Student;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
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

Route::view('/','index');

Route::post('/login', [UserController::class,'login']);
Route::get('/logout',[UserController::class, 'logout']);

Route::get('/student', function(){
    return view('student');
})->name('student')->middleware('myauth');

Route::get('/student/{something}', function (){
    return redirect('/');
});

Route::post('/student/search', [StudentController::class,'searchStudent'])->name('search_student')->middleware('myauth');

Route::post('/student/insert', [StudentController::class,'insertStudent'])->name('insert_student')->middleware('myauth');

Route::get('/profile/{student}',[StudentController::class, 'show_profile'])->middleware('myauth');

Route::get('/edit_student/{student}', function(Student $student){
    return view('edit-student',['student' => $student]);
})->middleware('myauth');

Route::post('/edit_student/{student}', [StudentController::class, 'save_profile'])->middleware('myauth');

Route::get('/loans', function(){
    $loans = Loan::all();
    return view('loans', ['loans' => $loans]);
})->middleware('myauth');

Route::post('/loans/return',[LoanController::class, 'returnBook'])->middleware('myauth');
Route::get('/loans/{student}', function(Student $student){
    return view('add-loan-student', ['student' => $student]);
})->name('search_loan')->middleware('myauth');

Route::post('/loans/search/{student}',[LoanController::class, 'searchBook'])->name('loans_search_student')->middleware('myauth');

Route::post('/loans/save/{student}',[LoanController::class, 'lendBookFromStudent'])->name('loans_save_student')->middleware('myauth');

Route::get('/all-books', function(){
    $books = Book::all();
    return view('all-books',['books' => $books]);
});

Route::get('/book', function(){
    return view('book');
})->name('book')->middleware('myauth');

Route::get('/book/{something}', function (){
    return redirect('/');
});

Route::post('/book/search', [BookController::class,'searchBook'])->name('search_book')->middleware('myauth');

Route::post('/book/insert', [BookController::class,'insertBook'])->name('insert_book')->middleware('myauth');

Route::get('/book_profile/{book}',[BookController::class, 'show_profile'])->middleware('myauth');