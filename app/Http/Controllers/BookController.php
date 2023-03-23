<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function searchBook(Request $request){
        
        $incomingFields = $request->all();
        
        $given_title = $incomingFields['book_title1'];
        
        $books= Book::where('title', 'LIKE', "%$given_title%")->orderBy('title')->get();
        
        return view('book',['books'=>$books, 'active_tab'=>'search']);
    }

    public function insertBook(Request $request){
        
        //VALIDATION
        $incomingFields = $request->all();
        $rules = [
            'book_code3'=>'unique:books,code'
        ];
        $given_code = $incomingFields['book_code3'];
        $validator = Validator::make($incomingFields, $rules);
        if($validator->fails()){
            return view('book',['dberror'=>"Υπάρχει ήδη βιβλίο με κωδικό $given_code", 'old_data'=>$request,'active_tab'=>'insert']);
        }

        //VALIDATION PASSED
        try{
            $record = Book::create([
                'code' => $incomingFields['book_code3'],
                'writer' => $incomingFields['book_writer3'],
                'title' => $incomingFields['book_title3'],
                'publisher' => $incomingFields['book_publisher3'],
                'subject' => $incomingFields['book_subject3'],
                'publish_place' => $incomingFields['book_publish_place3'],
                'publish_year' => $incomingFields['book_publish_year3'],
                'no_of_pages' => $incomingFields['book_no_of_pages3'],
                'acquired_by' => $incomingFields['book_acquired_by3'],
                'acquired_year' => $incomingFields['book_acquired_year3'],
                'comments' => $incomingFields['book_comments3'],
                'available' => 1
            ]);
        } 
        catch(QueryException $e){
            return view('book',['dberror'=>"Κάποιο πρόβλημα προέκυψε κατά την εκτέλεση της εντολής, προσπαθήστε ξανά.", 'old_data'=>$request,'active_tab'=>'insert']);
        }

        return view('book',['record'=>$record,'active_tab'=>'insert']);
    }

    public function save_profile(Student $student, Request $request){

        $incomingFields = $request->all();
        $saved = False;

        $student->am = $incomingFields['student_am'];
        $student->surname = $incomingFields['student_surname'];
        $student->name = $incomingFields['student_name'];
        $student->f_name = $incomingFields['student_fname'];
        $student->class = $incomingFields['student_class'];

        if($student->isDirty()){
            if($student->isDirty('am')){
                $rules = [
                    'student_am'=>'unique:students,am'
                ];
                $given_am = $incomingFields['student_am'];
                $validator = Validator::make($incomingFields, $rules);
                if($validator->fails()){
                    return view('edit-student',['dberror'=>"Υπάρχει ήδη μαθητής με τον Α.Μ. $given_am", 'student' => $student]);
                }
            }
            $student->save();
            $saved = True;
        }

       return view('edit-student',['saved' => $saved, 'student' => $student]);
    }

    public function show_profile(Book $book){

        $loans = Loan::where('book_id',$book->id)->orderBy('date_out')->get();
        
        return view('book-profile',['book'=>$book, 'loans'=>$loans]);
    }
}
