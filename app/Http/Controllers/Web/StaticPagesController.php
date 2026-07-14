<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class StaticPagesController extends Controller
{
    public function faq()
    {
        return view('pages.faq');
    }

    public function aboutUs()
    {
        return view('pages.about');
    }
}
