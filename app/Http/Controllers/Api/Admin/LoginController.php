<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
// use Tymon\JWTAuth\Exceptions\TokenExpiredException;
// use Tymon\JWTAuth\Exceptions\TokenInvalidException;
// use Tymon\JWTAuth\Exceptions\JWTException;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function redirectToUjian()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $now = Carbon::now();
        $data = [
            'username' => $user->username,
            'timestamp' => $now->timestamp,
            'exp' => $now->addHours(2)->timestamp, // Expire setelah 2 jam
        ];

        // Kunci enkripsi rahasia (harus sama dengan aplikasi tujuan)
        $encryption_key = env('APP_ENCRYPTION_KEY');

        // Inisialisasi IV (Initialization Vector) 16 byte
        $iv = random_bytes(16);

        // Enkripsi data menggunakan AES-256-CBC
        $encryptedData = openssl_encrypt(json_encode($data), 'AES-256-CBC', $encryption_key, 0, $iv);

        // Gabungkan IV dan data terenkripsi, lalu encode ke base64
        $token = base64_encode($iv . $encryptedData);

        // Tentukan URL berdasarkan environment
        if (app()->environment('production')) {
            $examSystemUrl = 'https://ujiankampust.bsi.ac.id/authenticate';
            // $examSystemUrl = 'https://question.bsi.ac.id/authenticate';
        } else {
            // $examSystemUrl = 'https://ujiankampust.bsi.ac.id/authenticate';
            $examSystemUrl = 'http://127.0.0.1:8001/authenticate';
        }

        // Gunakan urlencode untuk memastikan token aman di URL
        return redirect()->away("{$examSystemUrl}?token=" . urlencode($token));
    }
    public function redirectToSays()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $now = Carbon::now();
        $data = [
            'username' => $user->username,
            'timestamp' => $now->timestamp,
            'exp' => $now->addHours(2)->timestamp, // Expire setelah 2 jam
        ];

        // Kunci enkripsi rahasia (harus sama dengan aplikasi tujuan)
        $encryption_key = env('APP_ENCRYPTION_KEY');

        // Inisialisasi IV (Initialization Vector) 16 byte
        $iv = random_bytes(16);

        // Enkripsi data menggunakan AES-256-CBC
        $encryptedData = openssl_encrypt(json_encode($data), 'AES-256-CBC', $encryption_key, 0, $iv);

        // Gabungkan IV dan data terenkripsi, lalu encode ke base64
        $token = base64_encode($iv . $encryptedData);

        // Tentukan URL berdasarkan environment
        if (app()->environment('production')) {
            // $examSystemUrl = 'https://ujiankampust.bsi.ac.id/authenticate';
            $examSystemUrl = 'https://saysv2.bsi.ac.id/authenticate';
        } else {
            $examSystemUrl = 'https://saysv2.bsi.ac.id/authenticate';

            // $examSystemUrl = 'https://ujiankampust.bsi.ac.id/authenticate';
            // $examSystemUrl = 'http://127.0.0.1:8001/authenticate';
        }

        // Gunakan urlencode untuk memastikan token aman di URL
        return redirect()->away("{$examSystemUrl}?token=" . urlencode($token));
    }
    public function redirectToSaysxxx(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            // Handle case where there is no authenticated user
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $now = Carbon::now();
        // Create a custom claim with the user's email
        $customClaims = [
            // $iat = Carbon::now()->timestamp;
            'sub' => $user->username, // Your subject identifier
            'iat' => Carbon::now()->timestamp, // Issued at: assign current time
            'nbf' => Carbon::now()->timestamp, // Not before: token is valid immediately
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
            $examSystemUrl = 'https://ujiankampusa.bsi.ac.id/authenticate';
        } else {
            // $examSystemUrl = 'http://127.0.0.1:8001/authenticate';
            $examSystemUrl = 'https://saysv2.bsi.ac.id/authenticate';
        }
        // URL sistem ujian online

        // Redirect ke sistem ujian online dengan token sebagai parameter
        return redirect()->away("{$examSystemUrl}?token={$token}");
    }
    // public function redirectToUjian()
    // {
    //     $user = auth()->user();

    //     if (!$user) {
    //         // Handle case where there is no authenticated user
    //         return response()->json(['error' => 'User not authenticated'], 401);
    //     }

    //     $now = Carbon::now();
    //     // Create a custom claim with the user's email
    //     $customClaims = [
    //         'sub' => $user->username, // Your subject identifier
    //         'iat' => $now->timestamp, // Issued at: assign current time
    //         'nbf' => $now->timestamp, // Not before: token is valid immediately
    //         'exp' => $now->addHours(2)->timestamp // Expiration time: 2 hours from now
    //     ];

    //     // Generate a token with the custom claims
    //     $token = JWTAuth::claims($customClaims)->fromUser($user);

    //     if (!$token) {
    //         // Handle case where the token couldn't be created
    //         return response()->json(['error' => 'Could not generate token'], 500);
    //     }
    //     // dd(App::environment('production'));
    //     if (app()->environment('production')) {
    //         $examSystemUrl = 'https://question.bsi.ac.id/authenticate';
    //     } else {
    //         $examSystemUrl = 'http://127.0.0.1:8002/authenticate';
    //     }
    //     // URL sistem ujian online

    //     // Redirect ke sistem ujian online dengan token sebagai parameter
    //     return redirect()->away("{$examSystemUrl}?token={$token}");
    // }

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
