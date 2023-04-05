<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

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

    public function passwordReset(Request $request){
        $incomingFields = $request->all();
        $incomingFields->validate([
            'pass1' => 'min:6|required_with:pass1_confirmation|same:pass1_confirmation',
            'pass1_confirmation' => 'min:6'
        ]);

        $user = User::find(Auth::id());

        $user->password = bcrypt($incomingFields['pass1']);
        $user->save();
    }
}
