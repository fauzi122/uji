<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;

class LoginController extends Controller
{

    public function redirectToUjian()
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
            $examSystemUrl = 'https://question.bsi.ac.id/authenticate';
        } else {
            $examSystemUrl = 'http://127.0.0.1:8001/authenticate';
        }
        // URL sistem ujian online

        // Redirect ke sistem ujian online dengan token sebagai parameter
        return redirect()->away("{$examSystemUrl}?token={$token}");
    }

    public function index(Request $request)
    {
        // set validasi
        $validator = Validator::make($request->all(), [
            'username'    => 'required',
            'password' => 'required',
        ]);

        // response error validasi
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // get "username" dan "password" dari input
        $credentials = $request->only('username', 'password');

        // check jika "username" dan "password" tidak sesuai
        if (!$token = auth()->guard('api_admin')->attempt($credentials)) {

            // response login "failed"
            return response()->json([
                'success' => false,
                'message' => 'username or Password is incorrect'
            ], 401);
        }

        // generate refresh token
        $refreshToken = JWTAuth::fromUser(auth()->guard('api_admin')->user());

        // response login "success" dengan generate "Token" dan "refresh token"
        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => auth('api_admin')->factory()->getTTL() * 60
        ], 200);
    }


    public function getUser()
    {
        //response data "user" yang sedang login
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api_admin')->user()
        ], 200);
    }

    public function refreshToken(Request $request)
    {
        try {
            $token = $request->bearerToken();

            if (!$token) {
                return response()->json([
                    'message' => 'Token not provided'
                ], 401);
            }

            $newToken = JWTAuth::refresh($token);

            // Update header Authorization with the new token
            $request->headers->set('Authorization', 'Bearer ' . $newToken);

            return response()->json([
                'access_token' => $newToken,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token invalid'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to refresh token'], 500);
        }
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
