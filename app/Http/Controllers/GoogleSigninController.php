<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
class GoogleSigninController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        # check is user already exists
        $ifUserExists = User::where('email', $request->email)->first();
        if (!$ifUserExists) {
            Session::put('googleUser', $request->all());
            return response()->json(array(
                'status' => 300,
                'message' => 'User not found!',
                'account' => $request->all()
            ));
        } 
        Auth::login($ifUserExists);
        return response()->json(array(
            'status' => 200,
            'message' => 'Login Successfully!',
            'account' => $ifUserExists
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
