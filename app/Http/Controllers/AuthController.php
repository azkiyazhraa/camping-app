<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getRegisterView()
    {
        return view('auth.register');
    }

    public function getLoginView()
    {
        return view('auth.login');
    }

    public function dashboard()
    {
        $members = User::where('is_admin', 0)->get();
        $borrowers = Borrowing::where('status', 'borrowed')->get();
        $tools = Tool::count();
        return view('dashboard.index', compact('members', 'borrowers', 'tools'));
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate->errors()->first())->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            return redirect()->route('login')->with('success', 'User created successfully.');
        }

        return redirect()->back()->with('error', 'Failed to create user.');
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate->errors()->first())->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && Auth::user()->is_admin == 1) {
            return redirect()->route('dashboard');
        } else if (Auth::attempt($credentials) && Auth::user()->is_admin == 0) {
            return redirect()->route('home');
        }

        return redirect()->back()->with('error', 'Login failed.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
