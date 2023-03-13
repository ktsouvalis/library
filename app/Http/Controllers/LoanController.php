<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Student;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    //
    public function return_book(Request $request){
        $loan = Loan::find($request['loan_id']);
        $loan->date_in = date('y/m/d');
        $loan->save();
        $book = Book::find($loan->book->id);
        $book->available = 1;
        $book->save();
        $student = Student::find($loan->student->id);

        return redirect("/profile/$student->id")->with('success','Η επιστροφή καταχωρήθηκε επιτυχώς');
    }
}
