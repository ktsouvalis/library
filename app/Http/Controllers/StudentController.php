<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function findStudent(Request $request){
        // $incomingFields=$request->validate([
        //     'student_id'=>'numeric'
        // ]);
        $incomingFields=$request->validate([
            'student_surname'=>'required_without:student_id',
            'student_id'=>'required_without:student_surname'
        ]);

        // $student = Student::find($incomingFields['student_id']);

        $given_surname = isset($incomingFields['student_surname']) ? $incomingFields['student_surname'] : '';
        $given_id = isset($incomingFields['student_id']) ? $incomingFields['student_id'] : 0;
        $students= ($given_id <> 0) ? Student::where('id', $given_id)->get() : Student::Where('surname', 'LIKE', "$given_surname%")->orderBy('surname')->get();
        
        // $students = Student::where('id', $given_id)->orWhere('surname', 'LIKE', "$given_surname%" )->get();
        
        
        return view('student',['students'=>$students, "active_tab"=>"search"]);
    }

    public function show_profile(Student $student){
        //
        $loans = Loan::where('student_id',$student->id)->orderBy('date_out')->get();
        
        return view('student-profile',['student'=>$student, 'loans'=>$loans]);
    }
}
