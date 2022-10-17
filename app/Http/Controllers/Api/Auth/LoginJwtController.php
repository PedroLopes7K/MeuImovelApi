<?php

namespace App\Http\Controllers\Api\Auth;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginJwtController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->all(['email', 'password']);
        Log::info($credentials);

        if (!$token = auth('api')->attempt($credentials)) {
            $message = new ApiMessages('Unauthorized');
            return response()->json($message->getMessage(), 401);
        }

        return response()->json([
            'token' => $token
        ], 200);
    }
}
