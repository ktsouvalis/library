<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UserController extends Controller
{
    //
    public function login(Request $request){
        $incomingFields=$request->validate([//the html names of the fields
            'name'=>'required',
            'password'=>'required'
        ]);
        if(auth()->attempt(['name'=>$incomingFields['name'], 'password'=>$incomingFields['password']])){
            $request->session()->regenerate();
            return redirect('/')->with('success','Συνδεθήκατε επιτυχώς');
        }
        else{
            return redirect('/')->with('failure', 'Λάθος όνομα χρήστη ή κωδικός πρόσβασης');
        }
    }

    public function logout(Request $request){
        // $request->session()->flush(); OR
        auth()->logout();
        return redirect('/')->with('success','Αποσυνδεθήκατε...');
    }

    public function passwordChange(Request $request){
        $incomingFields = $request->all();
        $rules = [
            'pass1' => 'min:6|required_with:pass1_confirmation|same:pass1_confirmation',
            'pass1_confirmation' => 'min:6'
        ];
        $validator = Validator::make($incomingFields, $rules);
        if($validator->fails()){
            return redirect('/password_reset')->with('failure', 'Οι κωδικοί πρέπει να ταιριάζουν και να είναι 6+ χαρακτήρες');
        }
        $user = User::find(Auth::id());

        $user->password = bcrypt($incomingFields['pass1']);
        $user->save();

        return redirect('/')->with('success', 'Ο νέος σας κωδικός αποθηκεύτηκε επιτυχώς');
    }

    public function passwordReset(Request $request){
        $incomingFields = $request->all();
        $user_id=$incomingFields['user_id'];
        $user = User::find($user_id);
        $user->password = bcrypt('123456');
        $user->save();
        
        return back()->with('success',"Ο κωδικός του χρήστη $user->name άλλαξε επιτυχώς");
    }

    public function importUsers(Request $request){
        $rule = [
            'import_users' => 'required|mimes:xlsx'
        ];
        $validator = Validator::make($request->all(), $rule);
        if($validator->fails()){ 
            return redirect('/')->with('failure', 'Μη επιτρεπτός τύπος αρχείου');
            
        }
        $filename = "users_file_".Auth::id().".xlsx"; 
        $path = $request->file('import_users')->storeAs('files', $filename);
        $mime = Storage::mimeType($path);
        $spreadsheet = IOFactory::load("../storage/app/$path");
        $users_array=array();
        $row=2;
        $error=0;
        $rowSumValue="1";
        while ($rowSumValue != "" && $row<10000){
            $check=array();
            $check['name'] = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
            $check['display_name']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
            $check['email']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
            $check['password']= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();

            if($check['name']=='' or $check['name']==null){
                $error = 1; 
                $check['name']="Κενό πεδίο";
            }
            else{
                if(User::where('name', $check['name'])->count()){
                    $error = 1;
                    $check['name']="Υπάρχει ήδη το username";
                }
            }

            $rule = [
                'display_name' => 'required'
            ];
            $validator = Validator::make($check, $rule);
            if($validator->fails()){ 
                $error=1;
                $check['display_name']="Κενό πεδίο";
            }
            
            if($check['email']=='' or $check['email']==null){
                $error = 1; 
                $check['email']="Κενό πεδίο";
            }
            else{
                if(User::where('email', $check['email'])->count()){
                    $error = 1;
                    $check['email']="Υπάρχει ήδη το email";
                }
            }

            $rule = [
                'password' => 'required'
            ];
            $validator = Validator::make($check, $rule);
            if($validator->fails()){ 
                $error=1;
                $check['password']="Κενό πεδίο";
            }
           
            array_push($users_array, $check);
            $row++;
            $rowSumValue="";
            for($col=1;$col<=5;$col++){
                $rowSumValue .= $spreadsheet->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();   
            }
        }
        
        if($error){
            return view('user',['users_array'=>$users_array,'active_tab'=>'import', 'asks_to'=>'error']);
        }
        else{
            session(['ysers' => $users_array]);
            return view('user',['users_array'=>$users_array,'active_tab'=>'import', 'asks_to'=>'save']);
        }
    }

    public function insertUsers(){
        $users_array = session('ysers');
        $imported=0;
        foreach($users_array as $one_user){
            $user = new User();
            $user->name = $one_user['name'];
            $user->display_name = $one_user['display_name'];
            $user->email = $one_user['email'];
            $user->password = bcrypt($one_user['password']);
            $user->public_link = md5($one_user['display_name']);
            try{
                $imported++;
                $user->save();
            } 
            catch(QueryException $e){
                return view('user',['dberror2'=>"Κάποιο πρόβλημα προέκυψε, προσπαθήστε ξανά.", 'active_tab'=>'import']);
            }
        }
        session()->forget('ysers');
        return redirect('/user')->with('success', "Η εισαγωγή $imported χρηστών ολοκληρώθηκε");
    }

    public function insertUser(Request $request){
        
        //VALIDATION
        $incomingFields = $request->all();
        $given_name = $incomingFields['user_name3'];
        $given_email = $incomingFields['user_email3'];

        if(User::where('name', $given_name)->count()){
            $existing_user = User::where('name', $given_name)->first();
            return view('user',['dberror3'=>"Υπάρχει ήδη μαθητής με όνομα χρήστη $given_name: $existing_user->name, $existing_user->display_name, $existing_user->email", 'old_data'=>$request,'active_tab'=>'insert']);
        }
        else{
            if(User::where('email', $given_email)->count()){
                $existing_user = User::where('email', $given_email)->first();
                return view('user',['dberror3'=>"Υπάρχει ήδη μαθητής με email $given_email: $existing_user->name, $existing_user->display_name, $existing_user->email", 'old_data'=>$request,'active_tab'=>'insert']);
            }
        }
        //VALIDATION PASSED
        try{
            $record = User::create([
                'name' => $incomingFields['user_name3'],
                'display_name' => $incomingFields['user_display_name3'],
                'email' => $incomingFields['user_email3'],
                'password' => bcrypt($incomingFields['user_password3']),
                'public_link' => md5($incomingFields['user_display_name3'])
            ]);
        } 
        catch(QueryException $e){
            return view('user',['dberror'=>"Κάποιο πρόβλημα προέκυψε κατά την εκτέλεση της εντολής, προσπαθήστε ξανά.", 'old_data'=>$request,'active_tab'=>'insert']);
        }

        return view('user',['record'=>$record,'active_tab'=>'insert']);
    }

    public function save_profile(User $user, Request $request){

        $incomingFields = $request->all();
       
        $user->name = $incomingFields['user_name'];
        $user->display_name = $incomingFields['user_display_name'];
        $user->email = $incomingFields['user_email'];

        if($user->isDirty()){
            if($user->isDirty('name')){
                $given_name = $incomingFields['user_name'];

                if(User::where('name', $given_name)->count()){
                    $existing_user =User::where('name',$given_name)->first();
                    return view('edit-user',['dberror'=>"Υπάρχει ήδη χρήστης με username $given_name: $existing_user->name, $existing_user->display_name, $existing_user->email", 'user' => $user]);

                }
            }
            else{
                if($user->isDirty('email')){
                    $given_email = $incomingFields['user_email'];

                    if(User::where('email', $given_email)->count()){
                        $existing_user =User::where('email',$given_email)->first();
                        return view('edit-user',['dberror'=>"Υπάρχει ήδη χρήστης με email $given_email: $existing_user->name, $existing_user->display_name, $existing_user->email", 'user' => $user]);

                    }
                }
            }
            if($user->isDirty('display_name')){
                $user->public_link = md5($incomingFields['user_display_name']);
            }
            $user->save();
        }
        else{
            return view('edit-user',['dberror'=>"Δεν υπάρχουν αλλαγές προς αποθήκευση", 'user' => $user]);
        }
        return redirect("/user_profile/$user->id")->with('success','Επιτυχής αποθήκευση');
    }

    public function show_profile(User $user){
            return view('user-profile',['user'=>$user]);
    }

    public function usersDl(){
        
        $users = User::all();
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        
        $activeWorksheet->setCellValue('A1', 'Username');
        $activeWorksheet->setCellValue('B1', 'DisplayName');
        $activeWorksheet->setCellValue('C1', 'email');
        
        $row = 2;
        foreach($users as $user){
            
            $activeWorksheet->setCellValue("A".$row, $user->name);
            $activeWorksheet->setCellValue("B".$row, $user->display_name);
            $activeWorksheet->setCellValue("C".$row, $user->email);
            
            $row++;
        }
        
        $writer = new Xlsx($spreadsheet);
        $filename = "usersTo_".date('YMd')."_".Auth::id().".xlsx";
        $writer->save($filename);

        return response()->download("$filename");
    }
}
