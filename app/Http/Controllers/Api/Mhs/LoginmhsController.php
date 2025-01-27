<?php

namespace App\Http\Controllers\Api\Mhs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use App;

class LoginmhsController extends Controller
{

    public function redirectToUjian(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            // Handle case where there is no authenticated user
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $now = Carbon::now();
        // Create a custom claim with the user's email
        $customClaims = [
            'sub' => $user->username, // Your subject identifier
            'iat' => $now->timestamp, // Issued at: assign current time
            'nbf' => $now->timestamp, // Not before: token is valid immediately
            'exp' => $now->addHours(2)->timestamp // Expiration time: 2 hours from now
        ];

        // Generate a token with the custom claims
        $token = JWTAuth::claims($customClaims)->fromUser($user);

        if (!$token) {
            // Handle case where the token couldn't be created
            return response()->json(['error' => 'Could not generate token'], 500);
        }
        // dd(App::environment('production'));
        if (app()->environment('production')) {
            $nimPrefix = substr($user->username, 0, 2);
            // Determine the correct exam system URL based on the NIM prefix
            if (in_array($nimPrefix, ['64'])) {
                $examSystemUrl = 'https://ujiankampusa.bsi.ac.id/authenticate';
            } else {
                $examSystemUrl = 'https://ujiankampusb.bsi.ac.id/authenticate'; // Replace with the correct URL
            }
        } else {
            $examSystemUrl = 'http://127.0.0.1:8001/authenticate';
        }
        // URL sistem ujian online

        // Redirect ke sistem ujian online dengan token sebagai parameter
        return redirect()->away("{$examSystemUrl}?token={$token}");
    }

    // public function redirectToUjian(Request $request)
    // {
    //     $user = auth()->user();

    //     if (!$user) {
    //         return response()->json(['error' => 'User not authenticated'], 401);
    //     }

    //     $customClaims = ['sub' => $user->username];
    //     $token = JWTAuth::claims($customClaims)->fromUser($user);

    //     if (!$token) {
    //         return response()->json(['error' => 'Could not generate token'], 500);
    //     }

    //     return response()->json(['token' => $token]);
    // }

    public function index(Request $request)
    {
        //set validasi
        $validator = Validator::make($request->all(), [
            'username'    => 'required',
            'password' => 'required',
        ]);

        //response error validasi
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get "email" dan "password" dari input
        $credentials = $request->only('username', 'password');

        //check jika "email" dan "password" tidak sesuai
        if (!$token = auth()->guard('api_mhs')->attempt($credentials)) {

            //response login "failed"
            return response()->json([
                'success' => false,
                'message' => 'Username or Password is incorrect'
            ], 401);
        }

        //response login "success" dengan generate "Token"
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api_mhs')->factory()->getTTL() * 60
        ], 200);
    }

    public function getUser()
    {
        //response data "user" yang sedang login
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api_mhs')->user()
        ], 200);
    }

    public function refreshToken(Request $request)
    {
        //refresh "token"
        $refreshToken = JWTAuth::refresh(JWTAuth::getToken());

        //set user dengan "token" baru
        $user = JWTAuth::setToken($refreshToken)->toUser();

        //set header "Authorization" dengan type Bearer + "token" baru
        $request->headers->set('Authorization', 'Bearer ' . $refreshToken);

        //response data "user" dengan "token" baru
        return response()->json([
            'success' => true,
            'user'    => $user,
            'token'   => $refreshToken,
        ], 200);
    }
    public function logout()
    {
        //remove "token" JWT
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        //response "success" logout
        return response()->json([
            'success' => true,
        ], 200);
    }
}
