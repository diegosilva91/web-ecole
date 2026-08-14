<?php

namespace App\Listeners;

use App\Coupon;
use App\User;
use Illuminate\Support\Str;
use Mi-empresa\Shared\Domain\Event\CustomerWasCreated;

class CreateCouponCustomer
{
    public function handle(CustomerWasCreated $event): void
    {
        $user = $event->user();
        if ($user->type_user === User::CUSTOMER) {
            $username = Str::upper(Str::limit(Str::substr($user->email, 0, strpos($user->email, '@')), 6, '') . Str::random(2));
            $code_coupon = $username . now()->format('dmY');
            Coupon::create([
                'owner_id' => $user->id,
                'type' => 'percent',
                'discount' => 20.00,
                'name' => 'Coupon discount for user ' . $user->email,
                'description' => 'Coupon generate after register user, Valid after complete limit',
                'code' => $code_coupon,
                'is_active' => 1,
                'expire_at' => now()->addYears(40)->endOfYear(),
                'limit' => 5,
                'counter' => 0,
            ]);
        }
    }
}
