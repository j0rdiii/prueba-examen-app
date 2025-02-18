<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flight_all = Flight::all();
        //$flight_all = Flight::paginate(1);
        
        return response()->json([
            'status' => true,
            'message' => 'Flights retrieved successfully',
            'data' => $flight_all,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Flight.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $flight = new Flight;

        $flight->name = $request->name;
        $flight->airline = $request->airline;
        $flight->type = $request->type;

        $flight->save();

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $flight = Flight::find($id);
        
        if (!$flight) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ], 404);
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Record retrieved successfully',
            'data' => $flight,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $flight = Flight::find($id);
        return view('Flight.edit', ['flight'=>$flight]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $flight = Flight::find($id);

        if (!$flight) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ], 404);
        }

        $request->validate([
            'name' => 'required|integer|min:0|max:10',
            'airline' => 'required|integer|min:0|max:10',
            'type' => 'required|integer|min:1',
        ]);

        $flight->update($request->all());


        return response()->json([
            'status' => true,
            'message' => 'Record updated successfully',
            'data' => $flight,
        ], 200);    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $flight = Flight::find($id);

        if (!$flight) {
            return response()->json([
                'status' => false, 
                'message' => 'Record not found',
            ], 404);
        }

        $flight->delete();


        return response()->json([
            'status' => true,
            'message' => 'Record deleted successfully',
        ], 200);
    }

    public function storeBodyReq(Request $request) 
    {
        if (($request->getContentTypeFormat() != "json") ||
            ($request->headers->get('Content-Type') != "application/json")) {

            return response()->json([
                'status' => 'error: Bad Request',
                'message' => 'Content-Type must be application/json',
            ], 400);
        } else {
            $data = json_decode($request->getContent(), true);
            $flight = new Flight;

            $flight->name = $data['name'];
            $flight->airline = $data['airline'];
            $flight->type = $data['type'];
            
            $flight->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Flights created successfully',
                '$request->all()' => $request->all(),
                '$request->collect()' => $request->collect(),
                '$request->getContent()' => $request->getContent(),
                '$request->getHost()' => $request->getHost(),
                '$request->getPort()' => $request->getPort(),
                '$request->getUri()' => $request->getUri(),
                //'$request->getUriForPath()' => getUriForPath($request->getUriForPath()),
                '$request->headers->get(\'Content-Type\')' => $request->headers->get('Content-Type'), 
                '$request->headers->get(\'Content-Length\')' => $request->headers->get('Content-Length'), 
            ]);
        }
    }

    public function storeBodyReqClasse(Request $request) 
    {
        if (($request->getContentTypeFormat() != "json") ||
            ($request->headers->get('Content-Type') != "application/json")) {

            return response()->json([
                'status' => 'error: Bad Request',
                'message' => 'Content-Type must be application/json',
            ], 400);

        } else {

            $user = User::where('email', $request -> email)->first();
            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'messsage' =>['Username or password incorrect'],
                ], 200);
            }
            $currentAccessToken = $request->user()->currentAccessToken();

            $bearerToken = $request->bearerToken();
            //$hashedToken = hash('sha256', $bearerToken);

            //[$id, $hashedToken] = explode('|', $bearerToken, 2);

            return response()->json([
                'status' => 'success',
                'message' => 'Dams created successfully',
                '$request->all()' => $request->all(),
                '$request->bearerToken(),' => $request->bearerToken(),
                //'$id' => $id,
                '$bearerToken' => $bearerToken,
                //'$hashedToken' => $hashedToken,
                '$currentAccessToken' => $currentAccessToken,
            ]);    
        }
    }

    public function storeBodyReqClasse1(Request $request) 
    {
        [$AuthorizationType, $bearerToken] = explode(' ', $request->header('Authorization'));

        if ($AuthorizationType != 'Bearer') {

            return response()->json([
                'status' => 'error: Bad Request',
                'message' => 'Authorization type must be Bearer',
            ], 400);
        }

        if (!$bearerToken) {
            return response()->json([
                'message' => 'Token not provided',
                'status code and meaning' => '401 Unauthorized access',
                '$request->header(\'Authorization\')' => $AuthorizationType
            ], 401);
        }
            
        [$id_personal_access_token, $onlyToken] = explode('|', $bearerToken, 2);

        $tokenInTable = PersonalAccessToken::find($id_personal_access_token);

        if (!$tokenInTable) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        return response()->json([
            'status' => 'success',
            '$AuthotizationType' => $AuthorizationType,
            '$bearerToken' => $bearerToken,
            '$id_personal_access_token' => $id_personal_access_token,
            '$onlyToken' => $onlyToken,
            '$tokenInTable' => $tokenInTable,
            '$tokenInTable->token' => $tokenInTable->token,
        ], 201); 
    }

    public function storeBodyReqClasse2(Request $request) 
    {
        [$AuthorizationType, $bearerToken] = explode(' ', $request->header('Authorization'));

        if ($AuthorizationType != 'Bearer') {
            return response()->json([
                'status' => 'error: Bad Request',
                'message' => 'Authorization type must be Bearer',
            ], 400);
        }

        if (!$bearerToken) {
            return response()->json([
                'message' => 'Token not provided',
                'status code and meaning' => '401 Unauthorized access',
                '$request->header(\'Authorization\')' => $AuthorizationType,
            ], 401);
        }

        [$id_personal_access_token, $onlyToken] = explode('|', $bearerToken, 2);

        $tokenInTable = PersonalAccessToken::find($id_personal_access_token);

        if (!$tokenInTable) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        $tokensMatch = hash_equals(hash('sha256', $onlyToken), $tokenInTable->token);

        if (!$tokensMatch) {
            return response()->json([
                'status' => 'with errors',
                'message' => 'Token not provided',
                'status code and meaning' => '401 Unauthorized access',
                'Bearer Token' => $bearerToken,
                'Token in table' => $tokenInTable->token,
                'Tokens match' => $tokensMatch,
            ], 401);
        }

        $flight = Flight::create([
            'name' => $request->name,
            'airline' => $request->airline,
            'type' => $request->type,
        ]);


        return response()->json([
            'status' => 'success',
            '$AuthorizationType' => $AuthorizationType,
            '$bearerToken' => $bearerToken,
            '$id_personal_access_token' => $id_personal_access_token,
            '$onlyToken' => $onlyToken,
            'tokenInTable' => $tokenInTable,
            'tokenInTable->token' => $tokenInTable->token,
        ], 201);
    }
}
