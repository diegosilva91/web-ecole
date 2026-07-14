<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class MarketingLandingController extends Controller
{
    public function landingCategoriesTech()
    {
        return view('pages.landingLifecoleTech');
    }
}
