<?php

namespace App\Http\Controllers\Web\Tech;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HealtzController extends Controller
{
    public function healtz(Request $request)
    {
        return response('OK');
    }
}
