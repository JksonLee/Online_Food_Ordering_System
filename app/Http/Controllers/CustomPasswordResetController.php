<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

class CustomPasswordResetController extends Controller
{
    // Show form to request reset
    public function showForgotForm()
    {
        return view('FrontEnd.customer.forgot_password');
    }

    // Handle sending reset link
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer) {
            return back()->with('error', 'Email not found.');
        }

        // Create token and save to password_resets table
        $token = Str::random(64);  // Replace str_random() with Str::random()

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        // Send reset link via email
        Mail::send('FrontEnd.mail.password_reset', ['token' => $token], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('success', 'We have emailed your password reset link!');
    }

    // Show reset password form
    public function showResetForm($token)
    {
        return view('FrontEnd.customer.reset_password', ['token' => $token]);
    }

    // Handle resetting the password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Check token and email in the password_resets table
        $reset = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token,
        ])->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'Invalid token or email.']);
        }

        // Update the customer's password
        $customer = Customer::where('email', $request->email)->first();
        $customer->password = Hash::make($request->password);
        $customer->save();

        // Delete the password reset token from the database
        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect()->route('login_in')->with('success', 'Your password has been reset successfully.');
    }
}
