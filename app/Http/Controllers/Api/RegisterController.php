<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
     /**

     * Register api

     *

     * @return \Illuminate\Http\Response

     */

     public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation Error.',
            'errors' => $validator->errors(),
        ], 422); // 422 : Erreur de validation
    }

    $input = $request->all();
    $input['password'] = bcrypt($input['password']);

    $user = User::create($input);

    $success['token'] = $user->createToken('MyApp')->plainTextToken;
    $success['name'] = $user->name;

    return response()->json([
        'success' => true,
        'message' => 'User registered successfully.',
        'data' => $success,
    ], 201); // 201 : Création réussie
}

 
    
 
     /**
 
      * Login api
 
      *
 
      * @return \Illuminate\Http\Response
 
      */
 
     public function login(Request $request)
 
     {
 
         if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
 
             $user = Auth::user(); 
 
             $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
 
             $success['name'] =  $user->name;
 
             return response()->json([$success, "message"=> 'User login successfully.']);
 
         } 
 
         else{ 
 
             return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
 
         } 
 
     }

     public function logout(Request $request)
    {
        // Révoque tous les tokens associés à l'utilisateur
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });
        $request->session()->invalidate();
    $request->session()->regenerateToken();

        return response()->json(['success' => true]);
    }
}