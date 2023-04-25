<?php

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
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


// STUDENT ROUTES


Route::get('/student',[StudentController::class,'getStudents'])->name('student')->middleware('myauth');

Route::post('/student/insert', [StudentController::class,'insertStudent'])->name('insert_student')->middleware('myauth');

Route::get('/students_dl', [StudentController::class, 'studentsDl'])->middleware('myauth');

Route::get('/student_profile/{student}',[StudentController::class, 'show_profile'])->middleware('myauth');

Route::get('/edit_student/{student}', [StudentController::class, 'editStudent'])->middleware('myauth');

Route::post('/edit_student/{student}', [StudentController::class, 'save_profile'])->middleware('myauth');
Route::post('/student_template_upload', [StudentController::class, 'importStudents'])->name('student_template_upload')->middleware('myauth');

Route::post('/students_insertion', [StudentController::class, 'insertStudents'])->name('insert_students_from_template')->middleware('myauth');


// LOANS ROUTES

Route::get('/loans', [LoanController::class, 'getLoans'])->middleware('myauth');

Route::post('/loans/return',[LoanController::class, 'returnBook'])->middleware('myauth');

Route::get('loans_s/{student}', [LoanController::class, 'addLoanStudent'])->name('search_loan_s')->middleware('myauth');

Route::post('/loans/save_s/{student}',[LoanController::class, 'lendBookFromStudent'])->name('loans_save_student')->middleware('myauth');

Route::get('/loans_b/{book}',[LoanController::class, 'addLoanBook'])->name('search_loan_b')->middleware('myauth');

Route::post('/loans/search_b/{book}',[LoanController::class, 'searchStudent'])->name('loans_search_book')->middleware('myauth');

Route::post('/loans/save_b/{book}',[LoanController::class, 'lendBookFromBook'])->name('loans_save_book')->middleware('myauth');

Route::get('/loans_dl', [LoanController::class, 'loansDl'])->middleware('myauth');


// BOOK ROUTES

Route::get('/book',[BookController::class, 'getBooks'])->name('book')->middleware('myauth');

Route::post('/book/insert', [BookController::class,'insertBook'])->name('insert_book')->middleware('myauth');

Route::get('/books_dl', [BookController::class, 'booksDl'])->middleware('myauth');

Route::get('/book_profile/{book}',[BookController::class, 'show_profile'])->middleware('myauth');

Route::get('/edit_book/{book}',[BookController::class,'editBook'])->middleware('myauth');

Route::post('/edit_book/{book}', [BookController::class, 'save_profile'])->middleware('myauth');

Route::post('/book_template_upload', [BookController::class, 'importBooks'])->name('book_template_upload')->middleware('myauth');

Route::post('/books_insertion', [BookController::class, 'insertBooks'])->name('insert_books_from_template')->middleware('myauth');

Route::post('/delete_book/{book}', [BookController::class, 'deleteBook'])->middleware('myauth');

Route::get('/all_books/{link}', [BookController::class, 'showBooksInPublic']);

// MISC ROUTES
Route::get('/change_year', function(){
    return view('change-year');
})->middleware('myauth');

Route::get('/subm_change_year', [StudentController::class, 'changeYear'])->middleware('myauth');

Route::get('/stats', [LoanController::class, 'stats'])->middleware('myauth');

// USER ROUTES
Route::get('/user', function(){
    return view('user');
})->middleware('isAdmin');

Route::post('/user/insert', [UserController::class,'insertUser'])->name('insert_user')->middleware('isAdmin');

Route::get('/users_dl', [UserController::class, 'usersDl'])->middleware('isAdmin');

Route::get('/user_profile/{user}',[UserController::class, 'show_profile'])->middleware('isAdmin');

Route::get('/edit_user/{user}', function(User $user){
    return view('edit-user',['user' => $user]);
})->middleware('isAdmin');

Route::post('/edit_user/{user}', [UserController::class, 'save_profile'])->middleware('isAdmin');
Route::post('/user_template_upload', [UserController::class, 'importUsers'])->name('user_template_upload')->middleware('isAdmin');

Route::post('/users_insertion', [UserController::class, 'insertUsers'])->name('insert_users_from_template')->middleware('isAdmin');

Route::post('/login', [UserController::class,'login'])->middleware('guest');

Route::get('/logout',[UserController::class, 'logout'])->middleware('myauth');

Route::get('/password_change', function(){
    return view('password_change_form');
})->middleware('myauth');

Route::post('/password_change', [UserController::class, 'passwordChange'])->middleware('myauth');

Route::post('/password_reset', [UserController::class, 'passwordReset'])->middleware('isAdmin');