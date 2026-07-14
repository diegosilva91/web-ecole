<?php

namespace App\Http\Controllers\Web\Customers;

use App\Http\Controllers\Controller;
use App\User;
use App\UserAssistant;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateProfileCustomerController extends Controller
{
    public function update(Request $request, $id)
    {
        $user = \App\User::with('UserAssistant')->where("id", Auth::id())->first();
        $customer =  \App\Customer::where("user_id", Auth::id())->first();
        $userAssistant = \App\UserAssistant::where("user_id", $user->id)->get();
        if (isset($request->name)) {
            $user->name = is_null($request->name) ? $user->name : $request->name;
        }
        if (isset($request->password)) {
            $user->password = is_null($request->password) ? $user->password : Hash::make($request->password);
        }
        if (isset($request->email)) {
            $user->email = is_null($request->email) ? $user->email : $request->email;
        }
        if (isset($request->last_name)) {
            $user->last_name = is_null($request->last_name) ? $user->last_name : $request->last_name;
        }
        if (isset($request->username)) {
            $user->username = is_null($request->username) ? $user->username : $request->username;
        }
        if (isset($request->phone)) {
            $user->phone = is_null($request->phone) ? $user->phone : $request->phone;
        }
        if (isset($request->birth)) {
            $user->birth = is_null($request->birth) ? $user->birth : $request->birth;
        }
        if (isset($request->notification_promotions)) {
            $user->notification_promotions = is_null($request->notification_promotions) ? $user->notification_promotions : $request->notification_promotions;
            $customer->notification_promotions = is_null($request->notification_promotions) ? $user->customer : $request->notification_promotions;
        }

        foreach ($userAssistant as $key => $assistant) {
            if (isset($request->assistant_name[ $key ])) {
                $assistant->name = $request->assistant_name[ $key ];
            }

            if (isset($request->assistant_age[ $key ])) {
                $assistant->age = (int) $request->assistant_age[ $key ];
            }

            if (isset($request->updated_at)) {
                $assistant->updated_at = $request->updated_at;
            }

            $assistant->save();
        }

        if (isset($request->assistant_name) && isset($request->assistant_age)) {
            if (count($request->assistant_name) > 0 && count($userAssistant) <= 0) {
                for ($i = 0; $i < count($request->assistant_name); $i++) {
                    if (isset($request->assistant_name[ $i ])) {
                        $userAssistant[] = UserAssistant::create([
                            'user_id' => $id,
                            'name' => $request->assistant_name[ $i ],
                            'age' => (int) $request->assistant_age[ $i ] ?: 0,
                        ]);
                    }
                }
            }
            if (count($request->assistant_name) > count($userAssistant)) {
                for ($i = count($userAssistant); $i < count($request->assistant_name); $i++) {
                    if (isset($request->assistant_name[ $i ])) {
                        $userAssistant[] = UserAssistant::create([
                            'user_id' => $id,
                            'name' => $request->assistant_name[ $i ],
                            'age' => (int) $request->assistant_age[ $i ] ?: 0,
                        ]);
                    }
                }
            }
        }

        if (        isset($request->assistant_name_other) &&
            isset($request->assistant_age_other)
        ) {
            $addUserAssistant = \App\UserAssistant::create([
                "user_id" => $user->id,
            ]);
            if (isset($request->assistant_name_other)) {
                $addUserAssistant->name = $request->assistant_name_other;
            }
            if (isset($request->assistant_age_other)) {
                $addUserAssistant->age = $request->assistant_age_other;
            }
            $addUserAssistant->save();
        }

        if (isset($request->updated_at)) {
            $user->updated_at = $request->updated_at;
        }
        $user->save();
        $customer->save();
        $user = User::with('UserAssistant')->find(Auth::id());

        return response()->json($user);
    }
}
