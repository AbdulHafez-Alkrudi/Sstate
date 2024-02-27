<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;

class LogoutController extends BaseController
{
    public function __invoke(Request $request){
        $request->user()->token()->revoke();
        return $this->sendResponse();
    }
}
