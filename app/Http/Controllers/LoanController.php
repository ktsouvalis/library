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
            'book_code' => Rule::exists('books', 'code')->where('available', 1)
        ];
        $given_code = $incomingFields['book_code'];
        $validator = Validator::make($incomingFields, $rules);
        if($validator->fails()){
            return view('add-loan-student',['dberror'=>"Το βιβλίο $given_code δεν υπάρχει ή δεν είναι διαθέσιμο προς δανεισμό", 'student' => $student]);
        }
        // END VALIDATION

        return view('add-loan-student',['book' => Book::where('code','=',$incomingFields['book_code'])->first(), 'student' => $student]);
    }

    public function lendBookFromStudent(Student $student, Request $request){
        // $book = Book::where('code','=', $request['book_code'])->first();
        $book = Book::find($request['book_id']);
        Loan::create([
            'book_id' => $book->id,
            'student_id' => $student->id,
            'date_out' => date('y/m/d'),
        ]);

        $book->available = 0;
        $book->save();

        return redirect("/profile/$student->id")->with('success','Ο δανεισμός καταχωρήθηκε επιτυχώς');
    }
}