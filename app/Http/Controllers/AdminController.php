<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Auth;

class AdminController extends Controller
{
    public function create()
    {
        return view('admin.register');
    }

    public function registerAdmin(Request $request)
    {
      $this->validate($request, [
       'email'=> 'required|unique:users|email|max:255',
       'name'=>  'required',
       'password'=> 'required|min:6|confirmed'
    ]); 
    
    
     Admin::create([
          'name'=>$request->name,
          'email'=>$request->email,
          'password'=>bcrypt($request->password)
    ]);
      return redirect()->intended('/home/admin');
    }

    public function loginAdmin()
    {
        return view('admin.login');
    }

    public function adminAuth(Request $request)
   {
   	    $this->validate($request, [
        'email'=>'required|email',
        'password'=>'required'
   ]);
     $email = $request->email;
     $password = $request->password;
     $remember = $request->remember;

     if(Auth::guard('admin')->attempt(['email'=> $email, 'password'=> $password], $remember)){
       return redirect()->intended('/home/admin');
      } else {
     	return redirect()->back()->with('warning', 'Invalid Email or Password');
      }
    }

  public function home()
  {
    return view('admin');
  }

  public function logout()
  {
    Auth::guard('admin')->logout();

    return redirect('/login/admin'); 
  }

}

