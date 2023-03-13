<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function findStudent(Request $request){
        $incomingFields=$request->validate([
            'student_id'=>'numeric'
        ]);

        $student = Student::find($incomingFields['student_id']);
        $books_loaned = Loan::where('student_id',$incomingFields['student_id'] )->whereNull('date_in')->orderBy('date_out')->get();

        
        return view('/search_student',['student'=>$student, 'books_loaned'=>$books_loaned]);
    }
}
