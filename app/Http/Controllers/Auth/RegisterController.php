<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mi-empresa\Shared\Domain\Event\CustomerWasCreated;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;

    protected string $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function registerSpanish(RegisterRequest $request): JsonResponse|Redirector|RedirectResponse|Application
    {
        $response = $this->register($request);
        return $request->wantsJson()
            ? new JsonResponse($response, 200)
            : redirect($this->redirectPath());
    }

    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
    {
        return Validator::make($data, RegisterRequest::$rules);
    }

    protected function create(array $data): Model|User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        if (isset($data['phone'])) {
            $user->phone = $data['phone'];
        }
        $user->type_user = User::CUSTOMER;
        $user->save();

        try {
            event(new CustomerWasCreated($user));
        } catch (\Exception $error) {
            Log::error($error);
        }

        return $user;
    }

    protected function registered(Request $request, $user): JsonResponse
    {
        return response()->json(['user' => User::find(Auth::id()), 'status' => 'success']);
    }
}
