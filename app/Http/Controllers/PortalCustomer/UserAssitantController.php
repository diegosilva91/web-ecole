<?php

namespace App\Http\Controllers\PortalCustomer;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserAssitantController extends Controller
{
    public function delete(Request $request, $user_id): JsonResponse
    {
        if (isset($user_id) && isset($request->assistant_id)) {
            $userAssistant = \App\UserAssistant::where(["id" => $request->assistant_id, "user_id" => $user_id])->first();
            if ($userAssistant) {
                $userAssistant->delete();
                $user = User::with('UserAssistant')->find($user_id);
                return response()->json(['user' => $user, 'status' => "delete"]);
            }
            return response()->json([
                'status' => 'error',
                'errors' => 'UserAssistant not found'
            ], 422);
        } else {
            $user = User::with('UserAssistant')->find($user_id);
            return response()->json([
                'user' => $user,
                'status' => 'error',
                'errors' => 'Error eliminando user assistant'
            ], 422);
        }
    }
}
