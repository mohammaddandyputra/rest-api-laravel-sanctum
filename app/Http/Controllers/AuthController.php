<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        $user = User::all();

        return response()->json([
            'status' => 200,
            'users' => $user,
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validators_error' => $validator->messages(),
            ]);
        }
        else
        {
            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid Credentials'
                ]);
            }
            else
            {
                $token = $user->createToken($user->email)->plainTextToken;

                return response()->json([
                    'status' => 200,
                    'email' => $user->email,
                    'token' => $token,
                    'username' => $user->username,
                ]);
            }
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            // 'phone' => 'required',
            // 'address' => 'required',
            // 'city' => 'required',
            // 'country' => 'required',
            // 'name' => 'required',
            // 'postcode' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validators_error' => $validator->messages(),
            ]);
        }
        
        $user = User::create([
            'username' => $request['username'],
            'email' =>$request['email'],
            'password' => Hash::make($request['password']),
            'phone' => $request['phone'],
            'address' => $request['address'],
            'city' => $request['city'],
            'country' => $request['country'],
            'name' => $request['name'],
            'postcode' => $request['postcode'],
        ]);

        $token = $user->createToken($user->email)->plainTextToken;

        return response()->json([
            'status' => 200,
            'email' => $user->email,
            'token' => $token,
            'username' => $user->username,
        ]);

    }
}
