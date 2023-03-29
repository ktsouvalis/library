<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function searchBook(Request $request){
        
        $incomingFields = $request->all();

        $rules = [
            'book_code1'=>'required_without:book_title1',
            'book_title1'=>'required_without:book_code1'
        ];
        $validator = Validator::make($incomingFields, $rules);
        if($validator->fails()){
            return view('book',['uierror'=>"Πρέπει να συμπληρώσετε τουλάχιστον ένα από τα δύο πεδία", 'active_tab'=>'search']);
        }
        
        $given_title = isset($incomingFields['book_title1']) ? $incomingFields['book_title1'] : '';
        $given_code = isset($incomingFields['book_code1']) ? $incomingFields['book_code1'] : 0;
        $books= ($given_code <> 0) ? Book::where('code', $given_code)->get() : Book::Where('title', 'LIKE', "%$given_title%")->orderBy('title')->get();
        
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
            $existing_book = Book::where('code',$given_code)->first();
            return view('book',['dberror'=>"Υπάρχει ήδη βιβλίο με κωδικό $given_code: $existing_book->title, $existing_book->writer, Εκδόσεις $existing_book->publisher", 'old_data'=>$request,'active_tab'=>'insert']);
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

    public function save_profile(Book $book, Request $request){

        $incomingFields = $request->all();

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
                $rules = [
                    'book_code'=>'unique:books,code'
                ];
                $given_code = $incomingFields['book_code'];
                $validator = Validator::make($incomingFields, $rules);
                if($validator->fails()){
                    $existing_book = Book::where('code',$given_code)->first();
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
        
        return view('book-profile',['book'=>$book]);
    }

    public function importBooks(Request $request){
        $path = $request->file('import_books')->store('files');
        $mime = Storage::mimeType($path);
        $spreadsheet = IOFactory::load("../storage/app/$path");
        $books_array=array();
        $row=2;
        do{
            $rowSumValue="";
            for($col=1;$col<=11;$col++){
                $rowSumValue .= $spreadsheet->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
            }
            $book = new Book();
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
            array_push($books_array, $book);
            $row++;
        } while ($rowSumValue != "" || $row>10000);
        return view('book',['books_array'=>$books_array,'active_tab'=>'import', 'asks_to'=>'save']);
    }

    public function insertBooks(Request $request){
        print_r($request['books_array']);
    }
}
