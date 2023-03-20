<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    //
    public function studentActions(Request $request){

        if($request['asks_to']=="search"){

            $incomingFields = $request->all();
            $rules = [
                'student_surname1'=>'required_without:student_am1',
                'student_am1'=>'required_without:student_surname1'
            ];
            $validator = Validator::make($incomingFields, $rules);
            if($validator->fails()){
                return view('student',['empty_fields'=>'error', 'active_tab'=>'search']);
            }

            $given_am = isset($incomingFields['student_am1']) ? $incomingFields['student_am1'] : 0;
            $given_surname = $incomingFields['student_surname1'];
            
            $students= ($given_am <> 0) ? Student::where('am', $given_am)->get() : Student::Where('surname', 'LIKE', "$given_surname%")->orderBy('surname')->get();
           
            return view('student',['students'=>$students, 'active_tab'=>'search']);
        }
        elseif($request['asks_to']=="import"){
            
            //IMPORT FROM EXCEL CODE GOES HERE

            return view('student',['result2'=>'ok_tab2','active_tab'=>'import']);
        }
        elseif($request['asks_to']=="insert"){

            $incomingFields = $request->all();
            $rules = [
                'student_am3'=>'unique:students,am'
            ];
            $validator = Validator::make($incomingFields, $rules);
            if($validator->fails()){
                return view('student',['constraint_error'=>'error', 'old_data'=>$request,'active_tab'=>'insert']);
            }

            $record = Student::create([
                'am' => $incomingFields['student_am3'],
                'surname' => $incomingFields['student_surname3'],
                'name' => $incomingFields['student_name3'],
                'f_name' => $incomingFields['student_fname3'],
                'class' => $incomingFields['student_class3']
            ]);

            return view('student',['record'=>$record,'active_tab'=>'insert']);
        }
    }

    public function show_profile(Student $student){
        //
        $loans = Loan::where('student_id',$student->id)->orderBy('date_out')->get();
        
        return view('student-profile',['student'=>$student, 'loans'=>$loans]);
    }
}
