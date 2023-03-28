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
    $students = Student::orderBy('surname')->get();
    return view('student', ['all_students' => $students]);
})->name('student')->middleware('myauth');

Route::post('/student/search', [StudentController::class,'searchStudent'])->name('search_student')->middleware('myauth');

Route::post('/student/insert', [StudentController::class,'insertStudent'])->name('insert_student')->middleware('myauth');

Route::get('/profile/{student}',[StudentController::class, 'show_profile'])->middleware('myauth');

Route::get('/edit_student/{student}', function(Student $student){
    return view('edit-student',['student' => $student]);
})->middleware('myauth');

Route::post('/edit_student/{student}', [StudentController::class, 'save_profile'])->middleware('myauth');

// Route::get('/loans', function(){
//     $loans = Loan::orderBy('date_in', 'asc')->get();
//     return view('loans', ['loans' => $loans]);
// })->middleware('myauth');

Route::get('/loans', function(){ 
    $loans = Loan::join('students', 'loans.student_id', '=', 'students.id')
        ->orderBy('students.class', 'asc')
        ->get(); 
    return view('loans', ['loans' => $loans]); 
})->middleware('myauth');

Route::post('/loans/return',[LoanController::class, 'returnBook'])->middleware('myauth');

Route::get('/loans_s/{student}', function(Student $student){
    return view('add-loan-student', ['student' => $student]);
})->name('search_loan_s')->middleware('myauth');

Route::post('/loans/search_s/{student}',[LoanController::class, 'searchBook'])->name('loans_search_student')->middleware('myauth');

Route::post('/loans/save_s/{student}',[LoanController::class, 'lendBookFromStudent'])->name('loans_save_student')->middleware('myauth');

Route::get('/loans_b/{book}', function(Book $book){
    return view('add-loan-book', ['book' => $book]);
})->name('search_loan_b')->middleware('myauth');

Route::post('/loans/search_b/{book}',[LoanController::class, 'searchStudent'])->name('loans_search_book')->middleware('myauth');

Route::post('/loans/save_b/{book}',[LoanController::class, 'lendBookFromBook'])->name('loans_save_book')->middleware('myauth');

Route::get('/all-books', function(){
    $books = Book::orderBy('title')->get();
    return view('all-books',['books' => $books]);
})->middleware('guest');

Route::get('/book', function(){
    $books = Book::orderBy('title')->get();
    return view('book', ['all_books' => $books]);
})->name('book')->middleware('myauth');

Route::post('/book/search', [BookController::class,'searchBook'])->name('search_book')->middleware('myauth');

Route::post('/book/insert', [BookController::class,'insertBook'])->name('insert_book')->middleware('myauth');

Route::get('/book_profile/{book}',[BookController::class, 'show_profile'])->middleware('myauth');

Route::get('/edit_book/{book}', function(Book $book){
    return view('edit-book',['book' => $book]);
})->middleware('myauth');

Route::post('/edit_book/{book}', [BookController::class, 'save_profile'])->middleware('myauth');

Route::post('/book_upload', [BookController::class, 'importBooks'])->middleware('myauth');