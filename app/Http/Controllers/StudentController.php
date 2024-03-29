<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Loan;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StudentController extends Controller
{
    public function editStudent(Student $student){
        if($student->user_id == Auth::id() and $student->class <> '0'){
            return view('edit-student',['student' => $student]);
        }
        else{
            return redirect(url('/'))->with('failure', 'Δεν έχετε δικαίωμα πρόσβασης σε αυτόν τον πόρο');
        }
    }
    public function insertStudent(Request $request){
        
        //VALIDATION
        $incomingFields = $request->all();
        $given_am = $incomingFields['student_am3'];
        $given_bm = $incomingFields['student_bm3'];

        if(Auth::user()->students->where('am', $given_am)->where('bm', $given_bm)->count()){
            $existing_student = Auth::user()->students->where('am',$given_am)->where('bm', $given_bm)->first();

            return redirect(url('/student'))
                ->with('failure', "Υπάρχει ήδη μαθητής με αριθμό μητρώου $given_am στο βιβλίο $given_bm: $existing_student->surname $existing_student->name, $existing_student->class")
                ->with('old_data', $incomingFields);
        }
        //VALIDATION PASSED
        
        $record = new Student();
        $record->user_id = Auth::id();
        $record->am = $given_am;
        $record->bm = $given_bm;
        $record->surname = $incomingFields['student_surname3'];
        $record->name = $incomingFields['student_name3'];
        $record->f_name = $incomingFields['student_fname3'];
        $record->class = $incomingFields['student_class3'];
        try{
            $record->save();
        } 
        catch(Throwable $e){
            return redirect(url('/student'))
                ->with('failure', "Κάποιο πρόβλημα προέκυψε κατά την εκτέλεση της εντολής, προσπαθήστε ξανά.")
                ->with('old_data', $incomingFields);
        }

        return redirect(url('/student'))
                ->with('success', "Επιτυχής καταχώρηση")
                ->with('record', $record);
    }

    public function save_profile(Student $student, Request $request){

        $incomingFields = $request->all();
        $student->user_id = Auth::id();
        $student->am = $incomingFields['student_am'];
        $student->bm = $incomingFields['student_bm'];
        $student->surname = $incomingFields['student_surname'];
        $student->name = $incomingFields['student_name'];
        $student->f_name = $incomingFields['student_fname'];
        $student->class = $incomingFields['student_class'];

        if($student->isDirty()){
            if($student->isDirty('am') or $student->isDirty('bm')){
                $given_am = $incomingFields['student_am'];
                $given_bm = $incomingFields['student_bm'];
                if(Auth::user()->students->where('am', $given_am)->where('bm', $given_bm)->count()){
                    $existing_student = Auth::user()->students->where('am',$given_am)->where('bm', $given_bm)->first();
                    return redirect("/edit_student/$student->id")->with('failure', "Υπάρχει ήδη μαθητής με αριθμό μητρώου $given_am στο βιβλίο $given_bm: $existing_student->surname $existing_student->name, $existing_student->class");
                }
            }
            $student->save();
        }
        else{
            return redirect(url("/edit_student/$student->id"))->with('warning', "Δεν υπάρχουν αλλαγές προς αποθήκευση");
        }

        return redirect(url("/student_profile/$student->id"))->with('success','Επιτυχής αποθήκευση');
    }

    public function show_profile(Student $student){
        if($student->user_id == Auth::id()){        
            return view('student-profile',['student'=>$student]);
        }
        else{
            return redirect(url('/'))->with('failure', 'Δεν έχετε δικαίωμα πρόσβασης σε αυτόν τον πόρο');
        }
    }

    public function importStudents(Request $request){
        $rule = [
            'import_students' => 'required|mimes:xlsx'
        ];
        $validator = Validator::make($request->all(), $rule);
        if($validator->fails()){ 
            return redirect(url('/'))->with('failure', 'Μη επιτρεπτός τύπος αρχείου');
            
        }
        $filename = "students_file_".Auth::id().".xlsx"; 
        $path = $request->file('import_students')->storeAs('files', $filename);
        $mime = Storage::mimeType($path);
        $spreadsheet = IOFactory::load("../storage/app/$path");
        $students_array=array();
        $sheetCount = $spreadsheet->getSheetCount();
        $error=0;
        for ($i = 0; $i < $sheetCount; $i++){ 
            $sheet = $spreadsheet->getSheet($i);
            $row=17;
            
            $rowSumValue="1";
            while ($rowSumValue != "" && $row<10000){
                $check=array();
                $check['am'] = $sheet->getCellByColumnAndRow(2, $row)->getValue();
                $check['bm']= $sheet->getCellByColumnAndRow(3, $row)->getValue();
                $check['surname']= $sheet->getCellByColumnAndRow(4, $row)->getValue();
                $check['name']= $sheet->getCellByColumnAndRow(6, $row)->getValue();
                $check['f_name']= $sheet->getCellByColumnAndRow(7, $row)->getValue();
                $check['class']= $sheet->getCellByColumnAndRow(5, 14)->getValue();

                $rule = [
                    'am' => 'required'
                ];
                $validator = Validator::make($check, $rule);
                if($validator->fails()){ 
                    $error=1;
                    $check['am']="Κενό πεδίο";
                }

                $rule = [
                    'bm' => 'required'
                ];
                $validator = Validator::make($check, $rule);
                if($validator->fails()){ 
                    $error=1;
                    $check['bm']="Κενό πεδίο";
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
                array_push($students_array, $check);
                $row++;
                $rowSumValue="";
                $rowSumValue = $sheet->getCellByColumnAndRow(1, $row)->getValue();   
            }
        }
        if($error){
            return view('student',['students_array'=>$students_array,'active_tab'=>'import', 'asks_to'=>'error']);
        }
        else{
            session(['studs' => $students_array]);
            return view('student',['students_array'=>$students_array,'active_tab'=>'import', 'asks_to'=>'save']);
        }
    }

    public function insertStudents(){
        $students_array = session('studs');
        $imported=0;
        foreach($students_array as $one_student){
            try{
                $imported++;
                Student::updateOrCreate(
                    [
                        'am' => $one_student['am'],
                        'bm' => $one_student['bm'],
                        'user_id' => Auth::id()
                    ],
                    [
                        'surname' => $one_student['surname'],
                        'name' => $one_student['name'],
                        'f_name'=> $one_student['f_name'],
                        'class'=> $one_student['class']
                    ]
                );
            } 
            catch(Throwable $e){
                session()->forget('studs');
                return redirect(url('/student'))->with('failure', "Κάποιο πρόβλημα προέκυψε, προσπαθήστε ξανά.");
            }
        }
        session()->forget('studs');
        return redirect(url('/student'))->with('success', "Η εισαγωγή $imported μαθητών ολοκληρώθηκε");
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

    public function changeYear(){
        $students = Student::where('user_id',Auth::id())->orderBy('class','DESC')->get();
        foreach ($students as $student){
            
            if(is_Numeric(substr($student->class,-1))){
                $sec = substr($student->class,-1);
                $class = substr($student->class, 0, -1);
            }
            else{
                $sec="";
                $class= $student->class;
            }
            if($class=='ΣΤ'){
                $student->class = '0';
            }
            else{
                if($class =='E' or $class=='Ε'){
                    $student->class = 'ΣΤ'.$sec;
                }
                else{
                    if($class=='Δ'){
                        $student->class = 'Ε'.$sec;
                    }
                    else{
                        if($class=='Γ'){
                            $student->class = 'Δ'.$sec;
                        }
                        else{
                            if($class=='Β' or $class=='B' ){
                                $student->class = 'Γ'.$sec;
                            }
                            else{
                                if($class=='A' or $class=='Α'){
                                    $student->class = 'Β'.$sec;
                                }    
                            }
                        }
                    }
                }
            }
            $student->save();
        }
        return redirect(url('/student'))->with('success', 'Η αλλαγή τάξης κάθε μαθητή ολοκληρώθηκε επιτυχώς');
    }

    public function deleteStudent(Student $student){

        if(!$student->hasActiveLoan()){
            Student::find($student->id)->delete();
            return redirect(url('/student'))->with('success', "Ο μαθητής $student->surname $student->name, με Α.Μ. $student->am ($student->bm), διαγράφηκε");
        }
    }

    public function update_bm(Request $request, User $user){
        foreach($request->all() as $key => $value){
            if(substr($key,0,7)=='student'){
                $student = Student::find($value);
                $student->bm = $request->all()['bm'];
                $student->save();    
            }
        }
        return redirect(url('/'))->with('success', 'Η ενημέρωση των βιβλίων μητρώου έγινε επιτυχώς και μπορείτε να συνεχίσετε με τη χρήση της εφαρμογής');
    }
}
