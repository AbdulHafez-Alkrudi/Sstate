<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController
{
    public function __invoke(Request $request)
    {
        $input = $request->all();
        // Validating the data coming from the user
        $validator = Validator::make($input , [
           'email' => 'required|email',
           'password' => 'required'
        ]);
        // checking if the user entered correct email and password
        if(Auth::attempt(['email' => $input['email'] , 'password'=>$input['password']]))
        {
            // getting the user who authenticated successfully
            $user = Auth::user();

            // creating a token to send it to the frontend
            $user['accessToken'] = $user->createToken('Personal Access Token')->accessToken;
            return $this->sendResponse($user);
        }
        // sending an error message
        return $this->sendError(['error' => 'unauthorized']);
    }
}
