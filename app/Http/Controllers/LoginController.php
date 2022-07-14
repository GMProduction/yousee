<?php

namespace App\Http\Controllers;

use App\Helper\CustomController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class LoginController extends CustomController
{
    public function index(){

        if (\request()->isMethod('POST')){
            $field = \request()->validate(
                [
                    'username' => 'required|string',
                    'password' => 'required|string',
                ]
            );
//            $user = User::where('username', $field['username'])->first();
//            if ($user && Hash::check($field['password'], $user->password)){
//                return redirect('/admin');
//            }
            if ($this->isAuth($field)) {
                if (\auth()->user()->isActive == false){
                    Auth::logout();
                    return Redirect::back()->withErrors(['username' => 'User non aktif'])->with(['username' => request('username')]);
                }
                $role = \auth()->user()->role;
                if ($role == 'pimpinan'){
                    $role = 'admin';
                }
                $redirect = "/$role";

//            return response()->json();

                return redirect($redirect);
            }
            return Redirect::back()->withErrors(['pasword' => 'Password mismach.'])->with(['username' => request('username')]);

        }
        return view('auth.login');
    }
    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
