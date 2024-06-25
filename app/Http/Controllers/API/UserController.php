<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\PasswordValidationRules;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use PasswordValidationRules;

    public function checkEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!$user){
            return ResponseFormatter::success([
                'message' => 'Email does not exist in the database',
            ], 'Email can to use register');
        }else{
            return ResponseFormatter::error([
                'message' => 'Failed',
                'error' => 'Email has already been registered'
            ], 'Email is axist', 400);
        }
    }
    
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => $this->passwordRules(),
                'pin_access' => 'required|max:6',
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                if($errors->has('email')){
                    $errors->add('email', 'Email has been registered');
                    return ResponseFormatter::error(['message' => 'Failed', 'error' => $errors->first('email')], 'Registered Failed', 422,);
                }
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'pin_access' => $request->pin_access,
            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Successfully created a new user');


        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication failed', 500);
        }
    }

    public function login(Request $request)
    {
       try {
        $request->validate([
            'email' => 'email|required|string',
            'password' => 'required|string|min:5'
        ]);
        $credential = request(['email', 'password']);
        
        if(!Auth::attempt($credential)){
            return ResponseFormatter::error([
                'message' => 'Your account is not registered already.',
            ],'Authentication failed', 404);
        }

        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password)) {
            throw new \Exception('Invalid Credentials');
        }

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return ResponseFormatter::success([
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'user'=>$user
        ], 'Authenticated');

       } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication failed', 500);
       }
    }

    public function fetch(Request $request)
    {
        return ResponseFormatter::success($request->user(), 'Data Profile user berhasil diambil');
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function changeKey(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'pin_access' => 'required|max:6',
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                if($errors->has('pin_access')){
                    $errors->add('pin_access', 'Pin access not valid');
                    return ResponseFormatter::error(['message' => 'Failed', 'error' => $errors->first('pin_access')], 'Failed Updated Pin Access', 422,);
                }
            }
            
            $user = Auth::user();
            
            $user->pin_access = $request->pin_access;

            $user->save();
            return ResponseFormatter::success($user, 'Pin access updated successfully');

        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication failed', 500);
        }
    }
}
