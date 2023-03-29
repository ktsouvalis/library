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
    }

    public function searchBook(Student $student, Request $request){
        $incomingFields = $request->all();
        $given_code = $incomingFields['book_code'];

        //VALIDATION
        $rule1 = [
            'book_code' => Rule::exists('books','code')
        ];
        if(Validator::make($incomingFields,$rule1)->fails()){
            return view('add-loan-student',['dberror'=>"Δεν υπάρχει στη βάση σας βιβλίο με κωδικό $given_code", 'student' => $student]);
        }
        else{
            $rule2 = [
                'book_code' => Rule::exists('books', 'code')->where('available', 1)
            ];
            if(Validator::make($incomingFields,$rule2)->fails()){
                $book = Book::where('code',$given_code)->first();
                return view('add-loan-student',['dberror'=>"Το βιβλίο $given_code ($book->title, $book->writer, εκδόσεις $book->publisher) δεν είναι διαθέσιμο προς δανεισμό", 'student' => $student]);
            }
        }
        // END VALIDATION

        return view('add-loan-student',['book' => Book::where('code','=',$incomingFields['book_code'])->first(), 'student' => $student]);
    }

    public function lendBookFromStudent(Student $student, Request $request){
        $book = Book::find($request['book_id']);
        
        try{
            Loan::create([
            'book_id' => $book->id,
            'student_id' => $student->id,
            'date_out' => date('y/m/d'),
        ]);
        }
        catch(QueryException $e){
            return redirect("/profile/$student->id")->with('failure','Ο δανεισμός δεν καταχωρήθηκε, προσπαθήστε ξανά');
        }


        $book->available = 0;
        $book->save();

        return redirect("/profile/$student->id")->with('success','Ο δανεισμός καταχωρήθηκε επιτυχώς');
    }

    public function searchStudent(Book $book, Request $request){
        $incomingFields = $request->all();
        
        $given_surname = $incomingFields['student_surname'];
        
        $students= Student::Where('surname', 'LIKE', "%$given_surname%")->orderBy('surname')->get(); 
        if(!$students->count()){
            return redirect("/loans_b/$book->id")->with('failure','Δε βρέθηκε μαθητής με αυτά τα στοιχεία');
        }

        return view('add-loan-book',['students' => $students, 'book' => $book]);
    }

    public function lendBookFromBook(Book $book, Request $request){
        $incomingFields = $request->all();

        try{
            Loan::create([
            'book_id' => $book->id,
            'student_id' => $incomingFields['student_id'],
            'date_out' => date('y/m/d'),
        ]);
        }
        catch(QueryException $e){
            return redirect("/book_profile/$book->id")->with('failure','Ο δανεισμός δεν καταχωρήθηκε, προσπαθήστε ξανά');
        }

        $book->available = 0;
        $book->save();
        
        return redirect("/book_profile/$book->id")->with('success','Ο δανεισμός καταχωρήθηκε επιτυχώς');
    }
}