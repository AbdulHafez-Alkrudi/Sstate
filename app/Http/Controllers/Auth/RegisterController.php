<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegisterController extends BaseController
{
    public function __invoke(Request $request): JsonResponse|array
    {
        $input = $request->all();
        // Validating the data coming from the user:
        $validator = Validator::make($input , [
            'first_name' => 'required' ,
            'last_name'  => 'required' ,
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required'
        ]);
        //
        // if it failed, I'll send error:
        if($validator->fails())
        {
            return $this->sendError($validator->errors());
        }

        // else, I'll hash the password and create access token:

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user['accessToken'] = $user->createToken('Personal Access Token')->accessToken ;

        return $this->sendResponse($user);
    }
}
