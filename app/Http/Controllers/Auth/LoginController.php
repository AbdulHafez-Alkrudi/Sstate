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

        $validator = Validator::make($input , [
           'email' => 'required|email',
           'password' => 'required'
        ]);

        if(Auth::attempt(['email' => $input['email'] , 'password'=>$input['password']]))
        {
            $user = Auth::user();
            $user['accessToken'] = $user->createToken('Personal Access Token')->accessToken;
            return $this->sendResponse($user);
        }

        return $this->sendError(['error' => 'unauthorized']);
    }
}
