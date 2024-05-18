<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmailOTPs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Mail\SendOTP;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
class EmailOTPsController extends Controller
{
    
    public function index($email)
    {
        $ifEmailExist = EmailOTPs::where('email', $email)->first();
        $otp = null;
        if(!$ifEmailExist){
            // Check if OTP already exists in session
            if (!session()->has('otp')) {
                $otp = mt_rand(100000, 999999);
                session(['otp' => $otp]); // Store OTP in session
        
                $emailOtp = EmailOTPs::create([
                    'otp' => $otp,
                    'email' => $email
                ]);
        
                // Send OTP email
                Mail::raw("Your OTP is: $otp", function ($message) use ($email) {
                    $message->to($email)->subject('Your OTP Code');
                });
            } else {
                $otp = session('otp'); // Retrieve OTP from session
            }
        }
        return view('emailotp.index', compact('email', 'otp'));
    }

    public function verify(Request $request)  {
        $request->validate([
            'otp' => 'required|numeric'
        ]);
        $otp = $request->otp;
        $email = $request->email;
        $emailOtp = EmailOTPs::where('email', $email)->first();
        if ($emailOtp->otp == $otp) {
            $user = User::where('email', $email)->first();
            if(!$user){
                $user = User::create([
                    'email' => $email,
                    'name' => Session::get('googleUser')['name'],
                    'picture' => !empty(Session::get('googleUser')['picture']) ? Session::get('googleUser')['picture'] : null,
                    'role' => !empty(Session::get('googleUser')['role']) ? Session::get('googleUser')['role'] : 0,
                    'password' => Hash::make(!empty(Session::get('googleUser')['password']) ? Session::get('googleUser')['password'] : 'ExampleString')
                ]);
            }
            EmailOTPs::where('email', $email)->delete();
            Auth::login($user);
            return response()->json([
                'status' => 200, // 'error
                'message' => 'OTP verified successfully'
            ]);
        } else {
            return response()->json([
                'status' => 500, // 'error
                'message' => 'Invalid OTP'
            ]);
        }
    }
}
