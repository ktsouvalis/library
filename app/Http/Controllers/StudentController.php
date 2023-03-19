<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class StudentController extends Controller
{
    //
    public function studentActions(Request $request){
        
        if($request['asks_to']=="search"){
            $incomingFields=$request->validate([
                'student_surname1'=>'required_without:student_am1',
                'student_am1'=>'required_without:student_surname1'
            ]);

            $given_surname = isset($incomingFields['student_surname1']) ? $incomingFields['student_surname1'] : '';
            $given_am = isset($incomingFields['student_am1']) ? $incomingFields['student_am1'] : 0;
            $students= ($given_am <> 0) ? Student::where('am', $given_am)->get() : Student::Where('surname', 'LIKE', "$given_surname%")->orderBy('surname')->get();
            
            return view('student',['students'=>$students, 'active_tab'=>'search']);
        }
        elseif($request['asks_to']=="import"){
            
            //IMPORT FROM EXCEL CODE GOES HERE

            return view('student',['result2'=>'ok_tab2','active_tab'=>'import']);
        }
        elseif($request['asks_to']=="insert"){
            
            // $incomingFields=$request->validate(['student_am3'=>'unique:students,am']);
            $incomingFields=$request;
            try{
            $record = Student::create([
                "am"=> $request['student_am3'],
                "surname"=> $request['student_surname3'],
                "name"=> $request['student_name3'],
                "f_name"=> $request['student_fname3'],
                "class"=> $request['student_class3'],
                "sec"=>$request['student_sec3'],
            ]);
            } catch (QueryException $e) {
                return view('student',['constraint_error'=>'error', 'given_am3'=>$request['student_am3'],'active_tab'=>'insert']);
            }
            return view('student',['record'=>$record,'active_tab'=>'insert']);
        }
    }

    public function show_profile(Student $student){
        //
        $loans = Loan::where('student_id',$student->id)->orderBy('date_out')->get();
        
        return view('student-profile',['student'=>$student, 'loans'=>$loans]);
    }
}
