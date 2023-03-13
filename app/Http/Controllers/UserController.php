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
            return redirect('/')->with('success','You have successfully logged in!');
        }
        else{
            return redirect('/')->with('failure', 'Invalid username or password');
        }
    }

    public function logout(Request $request){
        // $request->session()->flush(); OR
        auth()->logout();
        return redirect('/')->with('success','You have logged out...');
    }
}
