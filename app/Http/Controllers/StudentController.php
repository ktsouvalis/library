<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StudentController extends Controller
{
    // public function searchStudent(Request $request){
        
    //     $incomingFields = $request->all();
        
    //     $given_surname = $incomingFields['student_surname1'];
        
    //     $students= Student::where('user_id', Auth::id())->where('surname', 'LIKE', "%$given_surname%")->orderBy('surname')->get();
        
    //     return view('student',['students'=>$students, 'active_tab'=>'search']);
    // }

    public function insertStudent(Request $request){
        
        //VALIDATION
        $incomingFields = $request->all();
        $given_am = $incomingFields['student_am3'];

        if(Student::where('user_id', Auth::id())->where('am', $given_am)->count()){
            $existing_student = Student::where('user_id', Auth::id())->where('am',$given_am)->first();
            return view('student',['dberror'=>"Υπάρχει ήδη μαθητής με αριθμό μητρώου $given_am: $existing_student->surname $existing_student->name, $existing_student->class", 'old_data'=>$request,'active_tab'=>'insert']);
        }
        //VALIDATION PASSED
        try{
            $record = Student::create([
                'user_id' => Auth::id(),
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
        $student->user_id = Auth::id();
        $student->am = $incomingFields['student_am'];
        $student->surname = $incomingFields['student_surname'];
        $student->name = $incomingFields['student_name'];
        $student->f_name = $incomingFields['student_fname'];
        $student->class = $incomingFields['student_class'];

        if($student->isDirty()){
            if($student->isDirty('am')){
                $given_am = $incomingFields['student_am'];

                if(Student::where('user_id', Auth::id())->where('am', $given_am)->count()){
                    $existing_student = Student::where('user_id', Auth::id())->where('am','=',$given_am)->first();
                    return view('edit-student',['dberror'=>"Υπάρχει ήδη μαθητής με αριθμό μητρώου $given_am: $existing_student->surname $existing_student->name, $existing_student->class", 'student' => $student]);

                }
            }
            $student->save();
        }
        else{
            return view('edit-student',['dberror'=>"Δεν υπάρχουν αλλαγές προς αποθήκευση", 'student' => $student]);
        }
        return redirect("/student_profile/$student->id")->with('success','Επιτυχής αποθήκευση');
    }

    public function show_profile(Student $student){
        if($student->user_id == Auth::id()){        
            return view('student-profile',['student'=>$student]);
        }
        else{
            return redirect('/')->with('failure', 'Δεν έχετε δικαίωμα πρόσβασης σε αυτόν τον πόρο');
        }
    }

    public function importStudents(Request $request){
        $filename = "students_file_".Auth::id().".xlsx"; 
        $path = $request->file('import_students')->storeAs('files', $filename);
        $mime = Storage::mimeType($path);
        $spreadsheet = IOFactory::load("../storage/app/$path");
        $students_array=array();
        $row=2;
        $error=0;
        $rowSumValue="1";
        while ($rowSumValue != "" && $row<10000){
            $check=array();
            $check['am'] = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
            $check['surname']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
            $check['name']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
            $check['f_name']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
            $check['class']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
            $rule = [
                'am' => 'required'
            ];
            $validator = Validator::make($check, $rule);
            if($validator->fails()){
                $error=1;                
                $check['am']="Κενό πεδίο";
            }
            $rule = [
                'surname' => 'required'
            ];
            $validator = Validator::make($check, $rule);
            if($validator->fails()){ 
                $error=1;
                $check['surname']="Κενό πεδίο";
            }
            $rule = [
                'name' => 'required',
            ];
            $validator = Validator::make($check, $rule);
            if($validator->fails()){ 
                $error=1;
                $check['name']="Κενό πεδίο";
            }
            $rule = [
                'f_name' => 'required'
            ];
            $validator = Validator::make($check, $rule);
            if($validator->fails()){ 
                $error=1;
                $check['f_name']="Κενό πεδίο";
            }
            $rule = [
                'class' => 'required',
            ];
            $validator = Validator::make($check, $rule);
            if($validator->fails()){ 
                $error=1;
                $check['class']="Πρέπει να είναι αριθμός";               
            }
            array_push($students_array, $check);
            $row++;
            $rowSumValue="";
            for($col=1;$col<=5;$col++){
                $rowSumValue .= $spreadsheet->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();   
            }
        }
        
        if($error){
            return view('student',['students_array'=>$students_array,'active_tab'=>'import', 'asks_to'=>'error']);
        }
        else{
            return view('student',['students_array'=>$students_array,'active_tab'=>'import', 'asks_to'=>'save']);
        }
    }

    public function insertStudents(){
        $filename = "students_file_".Auth::id().".xlsx";
        $spreadsheet = IOFactory::load("../storage/app/files/$filename");
        $students_array=array();
        $row=2;
        do{
            $rowSumValue="";
            for($col=1;$col<=5;$col++){
                $rowSumValue .= $spreadsheet->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Loan::where('user_id', Auth::id())->delete();
            Student::where('user_id', Auth::id())->delete();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $student = new Student();
            $student->user_id = Auth::id();
            $student->am = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
            $student->surname= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
            $student->name= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
            $student->f_name= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
            $student->class= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
            array_push($students_array, $student);
            $row++;
        } while ($rowSumValue != "" || $row>10000);
        array_pop($students_array);
        foreach($students_array as $student){
            try{
                $student->save();
            } 
            catch(QueryException $e){
                return view('student',['dberror'=>"Κάποιο πρόβλημα προέκυψε, προσπαθήστε ξανά.", 'active_tab'=>'import']);
            }
        }

        $imported = $row -3;
        return redirect('/student')->with('success', "Η εισαγωγή $imported μαθητών ολοκληρώθηκε");
    }

    public function studentsDl(){
        
        $students = Student::where('user_id', Auth::id())->get();
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        
        $activeWorksheet->setCellValue('A1', 'Αριθμός Μητρώου');
        $activeWorksheet->setCellValue('B1', 'Επώνυμο');
        $activeWorksheet->setCellValue('C1', 'Όνομα');
        $activeWorksheet->setCellValue('D1', 'Πατρώνυμο');
        $activeWorksheet->setCellValue('E1', 'Τάξη');
        $row = 2;
        foreach($students as $student){
            
            $activeWorksheet->setCellValue("A".$row,$student->am);
            $activeWorksheet->setCellValue("B".$row, $student->surname);
            $activeWorksheet->setCellValue("C".$row, $student->name);
            $activeWorksheet->setCellValue("D".$row, $student->f_name);
            $activeWorksheet->setCellValue("E".$row, $student->class);
            $row++;
        }
        
        $writer = new Xlsx($spreadsheet);
        $filename = "studentsTo_".date('YMd')."_".Auth::id().".xlsx";
        $writer->save($filename);

        return response()->download("$filename");
    }
}
