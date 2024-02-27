<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result = [] , $date_name = "data"): JsonResponse
    {
            $response = [
                'status' => 'success' ,
                $date_name => $result
            ];
            return response()->json($response , '200');
    }

    public function sendError($errorMessage = [] , $code = 200): JsonResponse
    {
            $response = [
                'status' => 'failure'
            ];

            if(!empty($errorMessage))
            {
                $response['error_message'] = $errorMessage ;
            }
            return response()->json($response , $code);
    }

}
