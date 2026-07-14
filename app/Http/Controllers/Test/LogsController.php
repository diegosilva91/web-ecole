<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;

class LogsController extends Controller
{
    public function request(Request $request)
    {
        try {
            Log::info($request);
        } catch (\Throwable $e) {
            dd($e);
        }

        return response()->json(['Hello']);
    }

    public function message(Request $request)
    {
        try {
            Log::info('Mensaje de información');
        } catch (\Throwable $e) {
            dd($e);
        }

        return response()->json(['Hello']);
    }
}
