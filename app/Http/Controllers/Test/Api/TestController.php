<?php

namespace App\Http\Controllers\Test\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Test\VehicleResource;
use App\Models\Vehicle;

class TestController extends Controller
{
    public function testApi(){
       return new VehicleResource(Vehicle::where('chassis_number',request()->chassis_number)->first());
    }

    /**
     * success response method.
     */

    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}
