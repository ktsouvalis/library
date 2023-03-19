<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function studentActions(Request $request){
        
        if($request['asks_to']=="search"){
            $incomingFields=$request->validate([
                'student_surname'=>'required_without:student_id',
                'student_id'=>'required_without:student_surname'
            ]);

            $given_surname = isset($incomingFields['student_surname']) ? $incomingFields['student_surname'] : '';
            $given_id = isset($incomingFields['student_id']) ? $incomingFields['student_id'] : 0;
            $students= ($given_id <> 0) ? Student::where('id', $given_id)->get() : Student::Where('surname', 'LIKE', "$given_surname%")->orderBy('surname')->get();
            
            return view('student',['students'=>$students, 'active_tab'=>'search']);
        }
        elseif($request['asks_to']=="import"){
            
            //IMPORT FROM EXCEL CODE GOES HERE

            return view('student',['result2'=>'ok_tab2','active_tab'=>'import']);
        }
        elseif($request['asks_to']=="insert"){
            
            //INSERT STUDENT RECORD CODE GOES HERE

            return view('student',['result3'=>'ok_tab3','active_tab'=>'insert']);
        }
    }

    public function show_profile(Student $student){
        //
        $loans = Loan::where('student_id',$student->id)->orderBy('date_out')->get();
        
        return view('student-profile',['student'=>$student, 'loans'=>$loans]);
    }
}
