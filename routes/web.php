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

Route::view('/student', 'student')->middleware('myauth')->middleware('register');

Route::post('/insert_student', [StudentController::class,'insertStudent'])->name('insert_student')->middleware('myauth');

Route::get('/download_students', [StudentController::class, 'studentsDl'])->name('download_students')->middleware('myauth')->middleware('register');

Route::get('/student_profile/{student}',[StudentController::class, 'show_profile'])->middleware('myauth')->middleware('register');

Route::get('/edit_student/{student}', [StudentController::class, 'editStudent'])->middleware('myauth')->middleware('register');

Route::post('/edit_student/{student}', [StudentController::class, 'save_profile'])->middleware('myauth');
Route::post('/upload_student_template', [StudentController::class, 'importStudents'])->name('student_template_upload')->middleware('myauth');

Route::post('/insert_students', [StudentController::class, 'insertStudents'])->name('insert_students_from_template')->middleware('myauth');

Route::post('/delete_student/{student}', [StudentController::class, 'deleteStudent'])->middleware('myauth');


// LOANS ROUTES

Route::view('/loans', 'loans')->middleware('myauth')->middleware('register');

Route::post('/return_loan/{loan}',[LoanController::class, 'returnBook'])->name('return_loan')->middleware('myauth');

Route::get('/search_s_loan/{student}', [LoanController::class, 'addLoanStudent'])->name('search_loan_s')->middleware('myauth')->middleware('register');

Route::post('/save_s_loan/{student}',[LoanController::class, 'lendBookFromStudent'])->name('loans_save_student')->middleware('myauth');

Route::get('/search_b_loan/{book}',[LoanController::class, 'addLoanBook'])->name('search_loan_b')->middleware('myauth')->middleware('register');

Route::post('/save_b_loan/{book}',[LoanController::class, 'lendBookFromBook'])->name('loans_save_book')->middleware('myauth');

Route::get('/dl_loans', [LoanController::class, 'loansDl'])->middleware('myauth')->middleware('register');

Route::post('/delete_loan/{loan}',[LoanController::class, 'delete_loan'])->middleware('myauth');


// BOOK ROUTES

Route::view('/book', 'book')->middleware('myauth')->middleware('register');

Route::post('/insert_book', [BookController::class,'insertBook'])->name('insert_book')->middleware('myauth');

Route::get('/dl_books', [BookController::class, 'booksDl'])->middleware('myauth')->middleware('register');

Route::get('/book_profile/{book:url}',[BookController::class, 'show_profile'])->middleware('myauth')->middleware('register');

Route::get('/edit_book/{book}',[BookController::class,'editBook'])->middleware('myauth')->middleware('register');

Route::post('/edit_book/{book}', [BookController::class, 'save_profile'])->middleware('myauth');

Route::post('/upload_book_template', [BookController::class, 'importBooks'])->name('book_template_upload')->middleware('myauth');

Route::post('/insert_books', [BookController::class, 'insertBooks'])->name('insert_books_from_template')->middleware('myauth');

Route::post('/delete_book/{book}', [BookController::class, 'deleteBook'])->middleware('myauth');

Route::get('/all_books/{link}', [BookController::class, 'showBooksInPublic']);

// MISC ROUTES
Route::view('/change_year', 'change-year')->middleware('myauth')->middleware('register');

Route::get('/subm_change_year', [StudentController::class, 'changeYear'])->middleware('myauth')->middleware('register');

Route::get('/stats', [LoanController::class, 'stats'])->middleware('myauth')->middleware('register');

// USER ROUTES
Route::view('/user', 'user')->middleware('isAdmin');

Route::post('/insert_user', [UserController::class,'insertUser'])->name('insert_user')->middleware('isAdmin');

Route::get('/dl_users', [UserController::class, 'usersDl'])->middleware('isAdmin');

Route::get('/user_profile/{user:name}',[UserController::class, 'show_profile'])->middleware('isAdmin');

Route::get('/edit_user/{user}', function(User $user){
    return view('edit-user',['user' => $user]);
})->middleware('isAdmin');

Route::post('/edit_user/{user}', [UserController::class, 'save_profile'])->middleware('isAdmin');
Route::post('/upload_user_template', [UserController::class, 'importUsers'])->name('user_template_upload')->middleware('isAdmin');

Route::post('/insert_users', [UserController::class, 'insertUsers'])->name('insert_users_from_template')->middleware('isAdmin');

Route::post('/login', [UserController::class,'login'])->middleware('guest');

Route::get('/logout',[UserController::class, 'logout'])->middleware('myauth');

Route::view('/change_password', 'password_change_form')->middleware('myauth');

Route::post('/change_password', [UserController::class, 'passwordChange'])->middleware('myauth');

Route::post('/reset_password', [UserController::class, 'passwordReset'])->middleware('isAdmin');

Route::view('/update_bm', 'update-bm')->middleware('myauth');

Route::post('/update_bm/{user}', [StudentController::class, 'update_bm']);

// Route::get('/test', function(){
//     $student = Student::find(81);
//     return $student->hasActiveLoan();
// });

//DB ROUTES

Route::view('/db_reset', 'db-reset')->middleware('myauth');

Route::post('/reset_books/{user}', function(User $user, Request $request){
    if(Auth::user()->id == $user->id){
        // if($user->loans->count())
        //     $user->loans()->delete();
        if($user->books->count()){
            $user->books()->delete(); 
            return back()->with('success', 'Όλα τα βιβλία διαγράφηκαν');
        } 
        else
            return back()->with('warning', 'Δεν υπάρχουν βιβλία για διαγραφή'); 
    }
    return back()->with('error', 'Δεν έχετε δικαίωμα πρόσβασης');
});

Route::post('/reset_students/{user}', function(User $user, Request $request){
    if(Auth::user()->id == $user->id){
        // if($user->loans->count())
        //     $user->loans()->delete();
        if($user->students->count()){
            $user->students()->delete();
            $user->books()->update(['available' => 1]);  
            return back()->with('success', 'Όλοι οι μαθητές διαγράφηκαν');
        }
        else
            return back()->with('warning', 'Δεν υπάρχουν μαθητές για διαγραφή');
    }
    return back()->with('error', 'Δεν έχετε δικαίωμα πρόσβασης');
});

Route::post('/reset_loans/{user}', function(User $user, Request $request){
    if(Auth::user()->id == $user->id){
        if($user->loans->count()){
            $user->loans()->delete();
            $user->books()->update(['available' => 1]); 
            return back()->with('success', 'Όλοι οι δανεισμοί διαγράφηκαν');
        }
        else
            return back()->with('warning', 'Δεν υπάρχουν δανεισμοί για διαγραφή');        
    }
    return back()->with('error', 'Δεν έχετε δικαίωμα πρόσβασης');
});