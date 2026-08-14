<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Mi-empresa\Shared\Domain\Event\CustomerWasCreated;
use Socialite;

class SocialController extends Controller
{
    public function Callback($provider)
    {
        $userSocial = Socialite::driver($provider)->stateless()->user();
        $users = User::where(['email' => $userSocial->getEmail()])->first();
        Session::put('user', $users);
        if ($users) {
            if (!optional($users->customer())->exists()) {
                $users->customer()->create([
                    'provider_id' => $userSocial->getId(),
                    'provider' => $provider
                ]);
            }
            Auth::login($users);
            return redirect('/');
        } else {
            $user = User::create([
                'name' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'image' => $userSocial->getAvatar(),
                'provider_id' => $userSocial->getId(),
                'provider' => $provider,
                'type_user' => User::CUSTOMER,
            ]);
            $user->customer()->create([
                'provider_id' => $userSocial->getId(),
                'provider' => $provider
            ]);
            Auth::login($user);

            try {
                event(new CustomerWasCreated($user));
            } catch (\Exception $error) {
                Log::error($error);
            }

            return redirect()->route('home');
        }
    }

    public function redirect($provider)
    {
        // Socialite will pick response data automatic
        //$user = Socialite::driver($provider)->stateless()->user();
        //return response()->json($user);
        return Socialite::driver($provider)->redirect();
    }
}
