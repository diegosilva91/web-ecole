<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class LegalPagesController extends Controller
{
    public function conditions()
    {
        return view('pages.terms-conditions');
    }

    public function cookies()
    {
        return view('pages.terms-cookies');
    }

    public function legal()
    {
        return view('pages.terms-legal');
    }

    public function privacy()
    {
        return view('pages.terms-privacy');
    }

    public function termsGetMember()
    {
        return view('pages.terms-getmember');
    }
}
