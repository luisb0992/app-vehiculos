<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    /**
     * Obtiene los datos de un vehiculo por su numero de chasis
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function searchVehicle(Request $request): JsonResponse
    {
        $token = env('VITE_API_TOKEN');
        $host = env('VITE_API_HOST');
        $baseUrl = env('VITE_API_BASE_URL');
        $info = env('VITE_API_INFO');
        $endpoint = $host . $baseUrl . $info;

        // uppercase the chassis number
        $chassis = strtoupper($request->chassis_number);

        $resp = Http::withToken($token)
            ->send('POST', $endpoint, ['body' => '{"chasis": "' . $chassis . '"}']);

        return response()->json($resp->json(), $resp->status());
    }
}
