<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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

        $rules = [
            'book_code'=>'required_without:book_title',
            'book_title'=>'required_without:book_code'
        ];
        $validator = Validator::make($incomingFields, $rules);
        if($validator->fails()){
            return view('add-loan-student',['dberror'=>"Πρέπει να συμπληρώσετε τουλάχιστον ένα από τα δύο πεδία", 'student' => $student]);
        }
        $given_title = isset($incomingFields['book_title']) ? $incomingFields['book_title'] : '';
        $given_code = isset($incomingFields['book_code']) ? $incomingFields['book_code'] : 0;
        if($given_code<>0){
            if(!Book::where('user_id', Auth::id())->where('code',$given_code)->count()){
                return view('add-loan-student',['dberror'=>"Δεν υπάρχει στη βάση σας βιβλίο με κωδικό $given_code", 'student' => $student]);
            }
            $books = Book::where('user_id', Auth::id())->where('code', $given_code)->get();
        }
        else{
            $books = Book::where('user_id', Auth::id())->where('title', 'LIKE', "%$given_title%")->orderBy('title')->get();
            if(!$books->count()){
                return view('add-loan-student',['dberror'=>"Δεν υπάρχει στη βάση σας βιβλίο με παρόμοιο τίτλο", 'student' => $student]);
            }
        }

        return view('add-loan-student',['books' => $books, 'student' => $student]);
    }

    public function lendBookFromStudent(Student $student, Request $request){
        if(isset($request['book_id'])){
            $book = Book::find($request['book_id']);
            
            try{
                Loan::create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
                'student_id' => $student->id,
                'date_out' => date('y/m/d'),
            ]);
            }
            catch(QueryException $e){
                return redirect("/student_profile/$student->id")->with('failure','Ο δανεισμός δεν καταχωρήθηκε, προσπαθήστε ξανά');
            }

            $book->available = 0;
            $book->save();

            return redirect("/student_profile/$student->id")->with('success','Ο δανεισμός καταχωρήθηκε επιτυχώς');
        }
        else{
            return view('add-loan-student',['dberror'=>"Δεν επιλέξατε κάποιο βιβλίο", 'student' => $student]);
        }
    }

    public function searchStudent(Book $book, Request $request){
        $incomingFields = $request->all();
        $given_surname = $incomingFields['student_surname'];
        $students= Student::where('user_id', Auth::id())->Where('surname', 'LIKE', "%$given_surname%")->orderBy('surname')->get(); 
        if(!$students->count()){
            return redirect("/loans_b/$book->id")->with('failure','Δε βρέθηκε μαθητής με αυτά τα στοιχεία');
        }

        return view('add-loan-book',['students' => $students, 'book' => $book]);
    }

    public function lendBookFromBook(Book $book, Request $request){
        $incomingFields = $request->all();

        try{
            Loan::create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
                'student_id' => $incomingFields['student_id'],
                'date_out' => date('y/m/d')
        ]);
        }
        catch(QueryException $e){
            return redirect("/book_profile/$book->id")->with('failure','Ο δανεισμός δεν καταχωρήθηκε, προσπαθήστε ξανά');
        }

        $book->available = 0;
        $book->save();
        
        return redirect("/book_profile/$book->id")->with('success','Ο δανεισμός καταχωρήθηκε επιτυχώς');
    }

    public function loansDl(){
        
        $loans = Loan::where('user_id', Auth::id())->get();
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        
        $activeWorksheet->setCellValue('A1', 'Κωδικός Βιβλίου');
        $activeWorksheet->setCellValue('B1', 'Τίτλος Βιβλίου');
        $activeWorksheet->setCellValue('C1', 'Συγγραφέας');
        $activeWorksheet->setCellValue('D1', 'Εκδόσεις');
        $activeWorksheet->setCellValue('E1', 'Επώνυμο μαθητή');
        $activeWorksheet->setCellValue('F1', 'Όνομα μαθητή');
        $activeWorksheet->setCellValue('G1', 'Τάξη');
        $activeWorksheet->setCellValue('H1', 'Ημερομηνία δανεισμού');
        $activeWorksheet->setCellValue('I1', 'Ημερομηνία επιστροφής');
        $row = 2;
        foreach($loans as $loan){
            
            $date_in = ($loan->date_in == null) ? "Δεν έχει επιστραφεί έως ".date('d/M/Y') : $loan->date_in;
            
            $activeWorksheet->setCellValue("A".$row,$loan->book->code);
            $activeWorksheet->setCellValue("B".$row, $loan->book->title);
            $activeWorksheet->setCellValue("C".$row, $loan->book->writer);
            $activeWorksheet->setCellValue("D".$row, $loan->book->publisher);
            $activeWorksheet->setCellValue("E".$row, $loan->student->surname);
            $activeWorksheet->setCellValue("F".$row, $loan->student->name);
            $activeWorksheet->setCellValue("G".$row, $loan->student->class);
            $activeWorksheet->setCellValue("H".$row, $loan->date_out);
            $activeWorksheet->setCellValue("I".$row, $date_in);
            $row++;
        }
        
        $writer = new Xlsx($spreadsheet);
        $filename = "loansTo_".date('YMd')."_".Auth::id().".xlsx";
        $writer->save($filename);

        return response()->download("$filename");
    }
}