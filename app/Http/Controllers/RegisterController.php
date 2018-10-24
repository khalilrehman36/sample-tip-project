<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

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
            'password' => 'required',
            'confirm_password' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();

        $isEmailExist = $this->checkDuplicateEmail($input['email']);
        if(isset($isEmailExist) && count($isEmailExist)> 0){
            return $this->sendError('Email duplicate error', 'Email already exist.');
        }

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] =  $user->createToken('sample')->accessToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User registered successfully.');
    }

    /*
     * Function to check duplicate email.
     * */
    public function checkDuplicateEmail($email){
        if(isset($email)){
            $email = User::where('email', $email)->first();
            return $email;
        }
    }
}
