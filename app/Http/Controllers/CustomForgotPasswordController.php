<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class CustomForgotPasswordController extends Controller
{
    // Show the form to request a password reset link
    public function showLinkRequestForm()
    {
        return view('FrontEnd.customer.forgot_password');
    }

    // Handle the sending of the reset link
    public function sendResetLinkEmail(Request $request)
    {
        // Validate email input
        $request->validate(['email' => 'required|email']);

        // Send the reset link via email
        $status = Password::sendResetLink($request->only('email'));

        // Handle success or failure response
        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'A password reset link has been sent to your email.')
            : back()->withErrors(['email' => 'Email could not be found in our records.']);
    }
}
