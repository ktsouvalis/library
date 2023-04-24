<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BookController extends Controller
{   
    public function getBooks(){
        // $books = Book::where('user_id',Auth::id())->orderBy('title')->get();
        $books = User::find(Auth::id())->books;
        return view('book', ['all_books' => $books]);
    }

    public function editBook(Book $book){
        if($book->user_id == Auth::id()){
            return view('edit-book',['book' => $book]);
        }
        else{
            return redirect('/')->with('failure', 'Δεν έχετε δικαίωμα πρόσβασης σε αυτόν τον πόρο');
        }
    }

    public function insertBook(Request $request){
      
        $incomingFields = $request->all();
        $given_code = $incomingFields['book_code3'];
          
        //VALIDATION
        if(Book::where('user_id',Auth::id())->where('code',$given_code)->count()){
            $existing_book = Book::where('user_id',Auth::id())->where('code',$given_code)->first();
            return view('book',['dberror3'=>"Υπάρχει ήδη βιβλίο με κωδικό $given_code: $existing_book->title, $existing_book->writer, Εκδόσεις $existing_book->publisher", 'old_data'=>$request,'active_tab'=>'insert']);
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
        catch(QueryException $e){
            return view('book',['dberror3'=>"Κάποιο πρόβλημα προέκυψε κατά την εκτέλεση της εντολής, προσπαθήστε ξανά.", 'old_data'=>$request,'active_tab'=>'insert']);
        }

        return view('book',['record'=>$record,'active_tab'=>'insert']);
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
                if(Book::where('user_id', Auth::id())->where('code',$given_code)->count()){
                        $existing_book = Book::where('user_id', Auth::id())->where('code',$given_code)->first();
                        return view('edit-book',['dberror'=>"Υπάρχει ήδη βιβλίο με κωδικό $given_code: $existing_book->title, $existing_book->writer, Εκδόσεις $existing_book->publisher", 'book' => $book]);
                }
            }
            $book->save();
        }
        else{
            return view('edit-book',['dberror'=>"Δεν υπάρχουν αλλαγές προς αποθήκευση", 'book' => $book]);
        }

        return redirect("/book_profile/$book->id")->with('success','Επιτυχής αποθήκευση');
    }

    public function show_profile(Book $book){
        if($book->user_id == Auth::id()){
            return view('book-profile',['book'=>$book]);
        }
        else{
            return redirect('/')->with('failure', 'Δεν έχετε δικαίωμα πρόσβασης σε αυτόν τον πόρο');
        }
    }

    public function importBooks(Request $request){
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
            $check['code'] = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
            $check['title']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
            $check['writer']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
            $check['publisher']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
            $check['subject']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
            $check['publish_place']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();
            $check['publish_year']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
            $check['no_of_pages']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(8, $row)->getValue();
            $check['acquired_by']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(9, $row)->getValue();
            $check['acquired_year']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(10, $row)->getValue();
            $check['comments']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(11, $row)->getValue();
            
            if($check['code']=='' or $check['code']==null){
                $error = 1; 
                $check['code']="Κενός κωδικός";
            }
            else{
                if(Book::where('user_id', Auth::id())->where('code', $check['code'])->count()){
                    $error = 1;
                    $check['code']="Υπάρχει ήδη ο κωδικός";
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
                'publisher' => 'required'
            ];
            $validator = Validator::make($check, $rule);
            if($validator->fails()){ 
                $error=1;
                $check['publisher']="Κενό πεδίο εκδότη";
                
            }
            $rule = [
                'no_of_pages' => 'numeric'
            ];
            $validator = Validator::make($check, $rule);
            if($validator->fails()){ 
                $error=1;
                $check['no_of_pages']="Πρέπει να είναι αριθμός";
                
            }
            $rule = [
                'publish_year' => 'numeric'
            ];
            $validator = Validator::make($check, $rule);
            if($validator->fails()){ 
                $error=1;
                $check['publish_year']="Πρέπει να είναι αριθμός";
                
            }
            $rule = [
                'acquired_year' => 'numeric'
            ];
            $validator = Validator::make($check, $rule);
            if($validator->fails()){ 
                $error=1;
                $check['acquired_year']="Πρέπει να είναι αριθμός";
                
            }
            array_push($books_array, $check);
            $row++;
            $rowSumValue="";
            for($col=1;$col<=11;$col++){
                $rowSumValue .= $spreadsheet->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();   
            }
        }
        
        if($error){
            return view('book',['books_array'=>$books_array,'active_tab'=>'import', 'asks_to'=>'error']);
        }else{
            return view('book',['books_array'=>$books_array,'active_tab'=>'import', 'asks_to'=>'save']);
        }
       
    }

    public function insertBooks(){
        $filename = "books_file".Auth::id().".xlsx";
        $spreadsheet = IOFactory::load("../storage/app/files/".$filename);
        $books_array=array();
        $row=2;
        do{
            $rowSumValue="";
            for($col=1;$col<=11;$col++){
                $rowSumValue .= $spreadsheet->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
            }
            $book = new Book();
            $book->user_id = Auth::id();
            $book->code = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
            $book->title= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
            $book->writer= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
            $book->publisher= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
            $book->subject= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
            $book->publish_place= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();
            $book->publish_year= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
            $book->no_of_pages= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(8, $row)->getValue();
            $book->acquired_by= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(9, $row)->getValue();
            $book->acquired_year= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(10, $row)->getValue();
            $book->comments= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(11, $row)->getValue();
            $book->available = 1;
            array_push($books_array, $book);
            $row++;
        } while ($rowSumValue != "" || $row>10000);
        array_pop($books_array);
        foreach($books_array as $book){
            try{
                $book->save();
            } 
            catch(QueryException $e){
                return view('book',['dberror2'=>"Κάποιο πρόβλημα προέκυψε, προσπαθήστε ξανά.", 'active_tab'=>'import']);
            }
        }

        $imported = $row - 3;
        return redirect('/book')->with('success', "Η εισαγωγή $imported βιβλίων ολοκληρώθηκε");
    }

    public function deleteBook(Book $book){

        if($book->available){
            Book::find($book->id)->delete();
            return redirect('/book')->with('success', "Το βιβλίο $book->code, $book->title, $book->writer, Εκδόσεις $book->publisher, διαγράφηκε");
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
        $books = Book::where('user_id', $user->id)->get();

        return view('all-books',['books'=>$books, 'school'=>$user]);
    }
}
