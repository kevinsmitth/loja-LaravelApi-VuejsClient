<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function admin()
    {
        //dd(Auth::guard('web')->user());

        if (Auth::guard('web')->check() === true) {
            return view('admin.index');
        }
        
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        auth('web')->attempt($credentials);


        return redirect()->route('admin');

    }
}
