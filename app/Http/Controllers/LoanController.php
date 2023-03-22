<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    //
    public function returnBook(Request $request){
        $loan = Loan::find($request['loan_id']);
        $loan->date_in = date('y/m/d');
        $loan->save();
        $book = Book::find($loan->book->id);
        $book->available = 1;
        $book->save();
        $student = Student::find($loan->student->id);

        return back()->with('success','Η επιστροφή καταχωρήθηκε επιτυχώς');
        //return redirect("/profile/$student->id")->with('success','Η επιστροφή καταχωρήθηκε επιτυχώς');
    }

    public function searchBook(Student $student, Request $request){
        $incomingFields = $request->all();
        //VALIDATION
        $rules = [
            'book_id' => Rule::exists('books', 'id')->where('available', 1)
        ];
        $given_id = $incomingFields['book_id'];
        $validator = Validator::make($incomingFields, $rules);
        if($validator->fails()){
            return view('add-loan-student',['dberror'=>"Το βιβλίο $given_id δεν υπάρχει ή δεν είναι διαθέσιμο προς δανεισμό", 'student' => $student]);
        }
        // END VALIDATION

        return view('add-loan-student',['book' => Book::find($incomingFields['book_id']), 'student' => $student]);
    }

    public function lendBookFromStudent(Student $student, Request $request){

        Loan::create([
            'book_id' => $incomingFields = $request['book_id'],
            'student_id' => $student->id,
            'date_out' => date('y/m/d'),
        ]);

        $book = Book::find($request['book_id']);
        $book->available=0;
        $book->save();
        $saved = True;

        return redirect("/profile/$student->id")->with('success','Ο δανεισμός καταχωρήθηκε επιτυχώς');
    }
}
