<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function GetUserAuth($user_id): JsonResponse
    {
        return response()->json(Auth::user());
//        return response()->json(['message'=>'UnAuthorized','user_id'=>Auth::id()],419);
    }
}
