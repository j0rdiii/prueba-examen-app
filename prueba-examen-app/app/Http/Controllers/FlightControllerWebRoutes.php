<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class FlightControllerWebRoutes extends Controller
{
    public function getFlightsFromAPI() {
        $response = Http::get('http://prueba-examen-app.test/api/Flights');
        $jsonData = $response->json();

        $status = $jsonData['status'];
        $message = $jsonData['message'];
        $data = $jsonData['data'];

        dd($status, $message, $data);

        foreach ($data as $key => $value) {
            //dd($key, $value);
            dd($value['name']);
        }
    }

    public function getFlightByIdFromAPI(string $id){
        $response = Http::get("http://prueba-examen-app.test/api/Flights/{$id}");
        $jsonData = $response->json();

        $status = $jsonData['status'];
        $message = $jsonData['message'];
        $data = $jsonData['data'];

        dd($status, $message, $data);
    }

    public function destroyFlightByIdFromApi(string $id) {
        try {
            $response = Http::delete("http://prueba-examen-app.test/api/Flights/{$id}");
            $jsonData = $response->json();

            $status = $jsonData['status'];
            $message = $jsonData['message'];
            $data = $jsonData['data'];

            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], 200);


        } catch (\Exception $e) {
            return response()->json([
            'status' => 'In catch destroy destroyFlightByIdFromApi',
            'message' => $e->getMessage(),
            'data' => 'no data'
            ], 200);
        }
    }

    public function updateFlightByIdFromApi(string $id, Request $request){
        try {
            $queryString=urldecode($request->getQueryString());

            $url="http://prueba-examen-app.test/api/Flights/{$id}?{$queryString}";
            $response = Http::put($url);
            $jsonData = $response->json();

            $status = $jsonData['status'];
            $message = $jsonData['message'];
            $data = $jsonData['data'];

            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data,
                '$request->getQueryString()' => $request->getQueryString(),
                'url' => $url
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
            'status' => 'In catch update updateFlightByIdFromApi',
            'message' => $e->getMessage(),
            'data' => 'no data'
            ], 200);
        }
    }

    public function createFlightWithJsonBodyReqFromApi(){
        try {
            $newFlight = [
                'name' => 'Aeroespatial Flight',
                'airline' => 'Moon',
                'type' => 'Business',
            ];
            $url="http://prueba-examen-app.test/api/Flights";

            $response = Http::post($url, $newFlight);
            $jsonData = $response->json();

            $status = $jsonData['status'];
            $message = $jsonData['message'];
            $data = $jsonData['data'];

            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data,
                'url' => $url
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
            'status' => 'In catch update updateFlightByIdFromApi',
            'message' => $e->getMessage(),
            'data' => 'no data'
            ], 200);
        }
    }

    public function createFlightWithBearerJsonBodyReqFromApi(){
        try {
            //$bearerToken = 'a50da3ba1955ef03bb840e61a0c1b072616580f305a972685b73caa6d910f570';
            $newFlight = [
                'name' => 'Aeroespatial Flight',
                'airline' => 'Moon',
                'type' => 'Business',
            ];
            $url="http://prueba-examen-app.test/api/Flights";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer 79a635a48cd059ec55142f928b6a0e741ff588a18fdd9903e468cc4245881782'
            ])->post($url, $newFlight);
            $jsonData = $response->json();

            $status = $jsonData['status'];
            $message = $jsonData['message'];
            $data = $jsonData['data'];

            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data,
                'url' => $url
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
            'status' => 'In catch create updateFlightByIdFromApi',
            'message' => $e->getMessage(),
            'data' => 'no data'
            ], 200);
        }
    }
}
