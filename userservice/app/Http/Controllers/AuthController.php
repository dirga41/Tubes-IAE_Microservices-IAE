<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register(Request $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return response()->json($user);
    }

    public function login(Request $request) {
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json($user);
        }
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function getUser($id) {
        return response()->json(User::find($id));
    }

    public function registerForm() {
        return view('auth.register');
    }

    public function registerSubmit(Request $request) {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return redirect('/login');
    }

    public function loginForm() {
        return view('auth.login');
    }

    public function loginSubmit(Request $request) {
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Session::put('user', $user);
            return redirect('/dashboard');
        }
        return back()->with('error', 'Invalid credentials');
    }

    public function dashboard() {
        $user = Session::get('user');
        return view('dashboard', compact('user'));
    }
}
