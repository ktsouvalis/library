<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
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
    public function returnBook(Request $request, Loan $loan){
        $loan->date_in = date('y/m/d');
        $loan->save();
        $book = Book::find($loan->book->id);
        $book->available = 1;
        $book->save();
        $student = Student::find($loan->student->id);
        
        return back()->with('success','Η επιστροφή καταχωρήθηκε επιτυχώς');
    }

    public function addLoanStudent(Student $student){
        if($student->user_id == Auth::id() and $student->class <> '0'){
            return view('add-loan-student', ['student' => $student, 'books' => Auth::user()->books]);
        }
        else{
            return redirect('/')->with('failure', 'Δεν έχετε δικαίωμα πρόσβασης σε αυτόν τον πόρο');  
        }
    }

    public function addLoanBook(Book $book){
        if($book->user_id == Auth::id()){
            return view('add-loan-book', ['book' => $book, 'students' => Auth::user()->students->where('class','<>','0')]);
        }
        else{
            return redirect('/')->with('failure', 'Δεν έχετε δικαίωμα πρόσβασης σε αυτόν τον πόρο');
        }
    }
    public function lendBookFromStudent(Student $student, Request $request){
        
        $book = Book::find($request['book_id']);
        
        try{
            Loan::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'student_id' => $student->id,
            'date_out' => date('y/m/d'),
        ]);
        }
        catch(Throwable $e){
            return redirect("/student_profile/$student->id")->with('failure','Ο δανεισμός δεν καταχωρήθηκε, προσπαθήστε ξανά');
        }

        $book->available = 0;
        $book->save();

        return redirect("/student_profile/$student->id")->with('success','Ο δανεισμός καταχωρήθηκε επιτυχώς');
        
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
        catch(Throwable $e){
            return redirect("/book_profile/$book->id")->with('failure','Ο δανεισμός δεν καταχωρήθηκε, προσπαθήστε ξανά');
        }

        $book->available = 0;
        $book->save();
        
        return redirect("/book_profile/$book->id")->with('success','Ο δανεισμός καταχωρήθηκε επιτυχώς');
    }

    public function loansDl(){
        
        $loans = Auth::user()->loans;
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

    public function stats(){
    
        $top5books = Auth::user()->loans
            ->groupBy('book_id')
            ->map(function($row){
                    return $row->count();
            })
            ->sortByDesc(function($count, $book_id){
                    return $count;
            })
            ->take(5);

        $top5students = Auth::user()->loans
            ->groupBy('student_id')
            ->map(function($row){
                    return $row->count();
            })
            ->sortByDesc(function($count, $student_id){
                    return $count;
            })
            ->take(5);

        $to_show=array('top5books'=>$top5books, 'top5students'=>$top5students);

        return view('stats', ['to_show' => $to_show]);
    }
}