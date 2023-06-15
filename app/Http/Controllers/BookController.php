<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BookController extends Controller
{   
    public function editBook(Book $book){
        if($book->user == Auth::user()){
            return view('edit-book',['book' => $book]);
        }
        else{
            return redirect(url('/'))->with('failure', 'Δεν έχετε δικαίωμα πρόσβασης σε αυτόν τον πόρο');
        }
    }

    public function insertBook(Request $request){
      
        $incomingFields = $request->all();
        $given_code = $incomingFields['book_code3'];
        $book = Auth::user()->books->where('code',$given_code);

        //VALIDATION
        if($book->count()){
            $existing_book = $book->first();
            return redirect(url('/book'))
                ->with('failure', "Υπάρχει ήδη βιβλίο με κωδικό $given_code: $existing_book->title, $existing_book->writer, Εκδόσεις $existing_book->publisher")
                ->with('old_data', $incomingFields);
        }
        //VALIDATION PASSED
        
        try{
            $record = Book::create([
                'user_id' => Auth::id(),
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
        catch(Throwable $e){
            return redirect(url('/book'))
                ->with('failure', "Κάποιο πρόβλημα προέκυψε κατά την εκτέλεση της εντολής, προσπαθήστε ξανά.")
                ->with('old_data', $incomingFields);
        }

        return redirect(url('/book'))
            ->with('success', 'Επιτυχής Καταχώρηση!')
            ->with('record',$record);
    }

    public function save_profile(Book $book, Request $request){

        $incomingFields = $request->all();

        $book->user_id = Auth::id();
        $book->code = $incomingFields['book_code'];
        $book->writer= $incomingFields['book_writer'];
        $book->title= $incomingFields['book_title'];
        $book->publisher= $incomingFields['book_publisher'];
        $book->subject= $incomingFields['book_subject'];
        $book->publish_place= $incomingFields['book_publish_place'];
        $book->publish_year= $incomingFields['book_publish_year'];
        $book->no_of_pages= $incomingFields['book_no_of_pages'];
        $book->acquired_by= $incomingFields['book_acquired_by'];
        $book->acquired_year= $incomingFields['book_acquired_year'];
        $book->comments= $incomingFields['book_comments'];

        if($book->isDirty()){
            if($book->isDirty('code')){
                $given_code = $incomingFields['book_code'];
                $existing_books = Auth::user()->books->where('code',$given_code);
                if($existing_books->count()){
                        $existing_book = $existing_books->first();
                        return redirect(url("/edit_book/$book->id"))->with('failure', "Υπάρχει ήδη βιβλίο με κωδικό $given_code: $existing_book->title, $existing_book->writer, Εκδόσεις $existing_book->publisher");
                }
            }
            $book->save();
        }
        else{
            return redirect(url("/edit_book/$book->id"))->with('warning',"Δεν υπάρχουν αλλαγές προς αποθήκευση");
        }

        return redirect(url("/edit_book/$book->id"))->with('success','Επιτυχής αποθήκευση');
    }

    public function show_profile(Book $book){
        if($book->user_id == Auth::id()){
            return view('book-profile',['book'=>$book]);
        }
        else{
            return redirect(url('/'))->with('failure', 'Δεν έχετε δικαίωμα πρόσβασης σε αυτόν τον πόρο');
        }
    }

    public function importBooks(Request $request){
        $rule = [
            'import_books' => 'required|mimes:xlsx'
        ];
        $validator = Validator::make($request->all(), $rule);
        if($validator->fails()){ 
            return redirect(url('/'))->with('failure', 'Μη επιτρεπτός τύπος αρχείου');
            
        }
        $filename = "books_file".Auth::id().".xlsx";
        $path = $request->file('import_books')->storeAs('files', $filename);
        $mime = Storage::mimeType($path);
        $spreadsheet = IOFactory::load("../storage/app/$path");
        $books_array=array();
        
        $row=2;
        $error=0;
        $rowSumValue="1";
        while ($rowSumValue != "" && $row<10000){
            $check=array();
            if($request->all()['template_file']=='itdipeach'){
                $check['code'] = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
                $check['title']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
                $check['writer']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
                $check['publisher']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
                $check['subject']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
                $check['publish_place']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(8, $row)->getValue();
                $check['publish_year']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();
                $check['no_of_pages']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(9, $row)->getValue();
                $check['acquired_by']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(10, $row)->getValue();
                $check['acquired_year']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(11, $row)->getValue();
                $check['comments']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
            }
            else{
                $check['code'] ="";
                $check['title']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
                $check['writer']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
                $check['publisher']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
                $check['subject']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
                $check['publish_place']= "";
                $check['publish_year']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
                $check['no_of_pages']= 0;
                $check['acquired_by']= "";
                $check['acquired_year']= "";
                $check['comments']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(8, $row)->getValue();
            }
        
            if(!($check['code']=='' or $check['code']==null)){
                if(Book::where('user_id', Auth::id())->where('code', $check['code'])->count()){
                    $error = 1;
                    $check['code']="Ο κωδικός χρησιμοποιείται";
                }
            }

            $rule = [
                'title' => 'required'
            ];
            $validator = Validator::make($check, $rule);
            if($validator->fails()){ 
                $error=1;
                $check['title']="Κενό πεδίο τίτλου";
                
            }

            $rule = [
                'writer' => 'required'
            ];
            $validator = Validator::make($check, $rule);
            if($validator->fails()){ 
                $error=1;
                $check['writer']="Κενό πεδίο συγγραφέα";
                
            }

            $rule = [
                'no_of_pages' => 'numeric'
            ];
            $validator = Validator::make($check, $rule);
            if($validator->fails()){ 
                $check['no_of_pages']=0;
                
            }

            array_push($books_array, $check);
            $row++;
            $rowSumValue="";
            for($col=1;$col<=11;$col++){
                $rowSumValue .= $spreadsheet->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();   
            }
        }
        session(['books_array' => $books_array]);
        session(['active_tab' =>'import']);
        if($error){
            return redirect(url('/book'))
                ->with('asks_to','error');
        }else{
            return redirect(url('/book'))
                ->with('asks_to','save');
        }
       
    }

    public function insertBooks(){
        $imported=0;
        foreach(session('books_array') as $one_book){
            $book = new Book();
            $book->user_id = Auth::id();
            $book->code = $one_book['code'];
            $book->title= $one_book['title'];
            $book->writer= $one_book['writer'];
            $book->publisher= $one_book['publisher'];
            $book->subject= $one_book['subject'];
            $book->publish_place= $one_book['publish_place'];
            $book->publish_year= $one_book['publish_year'];
            $book->no_of_pages= $one_book['no_of_pages'];
            $book->acquired_by= $one_book['acquired_by'];
            $book->acquired_year= $one_book['acquired_year'];
            $book->comments= $one_book['comments'];
            $book->available = 1;
            try{
                $imported++;
                $book->save();
            } 
            catch(Throwable $e){
                session()->forget('books_array');
                session()->forget('active_tab');
                return redirect(url('/book'))
                    ->with('failure',"Κάποιο πρόβλημα προέκυψε, προσπαθήστε ξανά." )
                    ->with('active_tab', 'import');
            }
        }
        session()->forget('books_array');
        session()->forget('active_tab');
        return redirect(url('/book'))->with('success', "Η εισαγωγή $imported βιβλίων ολοκληρώθηκε");
    }

    public function deleteBook(Book $book){

        if($book->available){
            Book::find($book->id)->delete();
            return redirect(url('/book'))->with('success', "Το βιβλίο $book->code, $book->title, $book->writer, Εκδόσεις $book->publisher, διαγράφηκε");
        }
    }

    public function booksDl(){
        
        $books = Book::where('user_id',Auth::id())->get();
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        $activeWorksheet->setCellValue('A1', 'Κωδικός Βιβλίου');
        $activeWorksheet->setCellValue('B1', 'Τίτλος Βιβλίου');
        $activeWorksheet->setCellValue('C1', 'Συγγραφέας');
        $activeWorksheet->setCellValue('D1', 'Εκδόσεις');
        $activeWorksheet->setCellValue('E1', 'Θεματική');
        $activeWorksheet->setCellValue('F1', 'Τόπος Έκδοσης');
        $activeWorksheet->setCellValue('G1', 'Χρονολογία Έκδοσης');
        $activeWorksheet->setCellValue('H1', 'Αριθμός Σελίδων');
        $activeWorksheet->setCellValue('I1', 'Τρόπος απόκτησης');
        $activeWorksheet->setCellValue('J1', 'Χρονολογία απόκτησης');
        $activeWorksheet->setCellValue('K1', 'Σχόλια');
        $activeWorksheet->setCellValue('L1', 'Διαθέσιμα την '.date('d/M/Y'));
        $row = 2;
        foreach($books as $book){
            
            $available = ($book->available) ? "Διαθέσιμο" : "Μη Διαθέσιμο";
            
            $activeWorksheet->setCellValue("A".$row,$book->code);
            $activeWorksheet->setCellValue("B".$row, $book->title);
            $activeWorksheet->setCellValue("C".$row, $book->writer);
            $activeWorksheet->setCellValue("D".$row, $book->publisher);
            $activeWorksheet->setCellValue("E".$row, $book->subject);
            $activeWorksheet->setCellValue("F".$row, $book->publish_place);
            $activeWorksheet->setCellValue("G".$row, $book->publish_year);
            $activeWorksheet->setCellValue("H".$row, $book->no_of_pages);
            $activeWorksheet->setCellValue("I".$row, $book->acquired_by);
            $activeWorksheet->setCellValue("J".$row, $book->acquired_date);
            $activeWorksheet->setCellValue("K".$row, $book->comments);
            $activeWorksheet->setCellValue("L".$row, $available);
            $row++;
        }
        
        $writer = new Xlsx($spreadsheet);
        $filename = "booksTo_".date('YMd')."_".Auth::id().".xlsx";
        $writer->save($filename);

        return response()->download("$filename");
    }

    public function showBooksInPublic($link){
        $user = User::where('public_link', $link)->first();
        
        if($user){
            if((Auth::check() and Auth::id()<>$user->id) or !Auth::check()){
                $user->public_visit_counter->public_visits++;
                $user->public_visit_counter->save();   
            }

            $books = Book::where('user_id', $user->id)->get();
            return view('all-books',['books'=>$books, 'school'=>$user]);
        }
        else{
            return redirect(url('/'))->with('failure','Η σελίδα που ζητήσατε δεν υπάρχει');
        }
    }
}
