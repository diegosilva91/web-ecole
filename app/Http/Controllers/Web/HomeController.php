<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Mi-empresa\Api\Domain\Repository\HomeRepository;

class HomeController extends Controller
{
    public function redirectHome()
    {
        return redirect()->action('Web\HomeController@home')->setStatusCode(301);
    }

    public function home(HomeRepository $homeRepository)
    {
        return view('pages.home', ['topBannerHome' => $homeRepository->getTopBannerHome()->getData()]);
    }
}
