<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //

    use AuthenticatesUsers;
    protected $username = 'username';
    protected $redirectTo = '/admin/dashboard';
    protected $guard='web';

    public function getLogin(){

    	if(Auth::guard('web')->check()){

    		return redirect()->route('dashboard.show');
    	}
    	return view('admins.login');
    }

    public function postLogin(Request $request){

        $request->validate([

            'username'=>'required',
            'password'=>'required'
        ]);


    	$auth=Auth::guard('web')->attempt(['username'=>$request->username, 'password'=>$request->password, 'active'=>1]);
    	if($auth){

    		return redirect()->route('dashboard.show');
    	}

    	return redirect()->route('login.show')->with('errors', 'Invalid credentials');

    }

    public function getLogout(){

    	Auth::guard('web')->logout();

    	return redirect()->route('login.show');
    }
}
