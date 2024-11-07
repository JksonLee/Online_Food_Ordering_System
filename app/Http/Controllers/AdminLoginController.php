<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminLoginController extends Controller
{
     public function showLoginForm()
    {
        return view('FrontEnd.admin.admin');
    }

    public function login(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Find the admin by email
        $admin = Admin::where('email', $request->email)->first();

        // If the admin does not exist or the password does not match
        if (!$admin || $admin->password !== $request->password) {
            return redirect()->back()->with('error', 'Invalid email or password.');
        }

        // Store admin information in session
        session([
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
            'admin_email' => $admin->email
        ]);

        // Redirect to the admin dashboard
        return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully!');
    }

    // Logout function to clear the session
    public function logout()
    {
        session()->forget(['admin_id', 'admin_name', 'admin_email']);
        return redirect()->route('admin.login')->with('success', 'Logged out successfully!');
    }
}
