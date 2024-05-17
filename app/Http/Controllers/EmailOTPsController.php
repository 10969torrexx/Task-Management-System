<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmailOTPs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class EmailOTPsController extends Controller
{
    //
      /**
     * Display a listing of the resource.
        */
        public function index($email)
        {
            $otp = mt_rand(100000, 999999);
            $emailOtp = EmailOTPs::create([
                'otp' => $otp,
                'email' => $email
            ]);
            return view('emailotp.index', compact('email', 'otp'));
        }
}
