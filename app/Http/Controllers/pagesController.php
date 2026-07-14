<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pagesController extends Controller
{
    public function portalLF(Request $request)
    {
        return view('pages.perfil');
    }
}
