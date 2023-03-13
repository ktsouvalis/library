<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
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

        return redirect('/search_student')->with('success','Η επιστροφή καταχωρήθηκε επιτυχώς');
    }
}
