<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function searchStudent(Request $request){
        
        $incomingFields = $request->all();
        
        $given_surname = $incomingFields['student_surname1'];
        
        $students= Student::Where('surname', 'LIKE', "%$given_surname%")->orderBy('surname')->get();
        
        return view('student',['students'=>$students, 'active_tab'=>'search']);
    }

    public function insertStudent(Request $request){
        
        //VALIDATION
        $incomingFields = $request->all();
        $rules = [
            'student_am3'=>'unique:students,am'
        ];
        $given_am = $incomingFields['student_am3'];
        $validator = Validator::make($incomingFields, $rules);
        if($validator->fails()){
            $existing_student = Student::where('am','=',$given_am)->first();
            return view('student',['dberror'=>"Υπάρχει ήδη μαθητής με αριθμό μητρώου $given_am: $existing_student->surname $existing_student->name, $existing_student->class", 'old_data'=>$request,'active_tab'=>'insert']);
        }

        //VALIDATION PASSED
        try{
            $record = Student::create([
                'am' => $incomingFields['student_am3'],
                'surname' => $incomingFields['student_surname3'],
                'name' => $incomingFields['student_name3'],
                'f_name' => $incomingFields['student_fname3'],
                'class' => $incomingFields['student_class3']
            ]);
        } 
        catch(QueryException $e){
            return view('student',['dberror'=>"Κάποιο πρόβλημα προέκυψε κατά την εκτέλεση της εντολής, προσπαθήστε ξανά.", 'old_data'=>$request,'active_tab'=>'insert']);
        }

        return view('student',['record'=>$record,'active_tab'=>'insert']);
    }

    public function save_profile(Student $student, Request $request){

        $incomingFields = $request->all();

        $student->am = $incomingFields['student_am'];
        $student->surname = $incomingFields['student_surname'];
        $student->name = $incomingFields['student_name'];
        $student->f_name = $incomingFields['student_fname'];
        $student->class = $incomingFields['student_class'];

        if($student->isDirty()){
            if($student->isDirty('am')){
                $rules = [
                    'student_am'=>'unique:students,am'
                ];
                $given_am = $incomingFields['student_am'];
                $validator = Validator::make($incomingFields, $rules);
                if($validator->fails()){
                    $existing_student = Student::where('am','=',$given_am)->first();
                    return view('edit-student',['dberror'=>"Υπάρχει ήδη μαθητής με αριθμό μητρώου $given_am: $existing_student->surname $existing_student->name, $existing_student->class", 'student' => $student]);
                }
            }
            $student->save();
        }
        else{
            return view('edit-student',['dberror'=>"Δεν υπάρχουν αλλαγές προς αποθήκευση", 'student' => $student]);
        }

        return redirect("/profile/$student->id")->with('success','Επιτυχής αποθήκευση');
    }

    public function show_profile(Student $student){        
        return view('student-profile',['student'=>$student]);
    }
}
