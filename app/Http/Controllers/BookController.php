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
        $incomingFields = $request->all();
        $file = $incomingFields['import_books'];
        
        $path = Storage::putFile('files', $file);
        $mime = Storage::mimeType($path);
        $spreadsheet = IOFactory::load("../storage/app/$path");
        // echo $spreadsheet->getActiveSheet()->getCell('B2');
    }
}
