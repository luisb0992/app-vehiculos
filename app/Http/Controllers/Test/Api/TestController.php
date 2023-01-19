<?php

namespace App\Http\Controllers\Test\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Test\VehicleResource;
use App\Models\Vehicle;

class TestController extends Controller
{
    public function testApi(){
        $vehicle = Vehicle::where('chassis_number',request()->chasis)->first();
        if($vehicle){
            return new VehicleResource($vehicle);
        }else{
            return response()->json(['data' => ['vehiculo' => ['status' => 'ERROR']]]);
        }
    }

}
