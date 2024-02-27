<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends BaseController
{
    public function __invoke(Request $request){

        // just revoke the token
        $request->user()->token()->revoke();
        return $this->sendResponse();
    }
}
