<?php

namespace App\Providers;

use App\Listeners\CreateCouponCustomer;
use App\Listeners\SendEmailForCreateReviews;
use App\Listeners\SendLeadRegisterToAdmin;
use App\Listeners\SendWelcomeEmailToCustomer;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Lifecole\Shared\Domain\Event\CustomerWasCreated;
use Lifecole\Shared\Domain\Event\UserHasFinishedPromotion;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        CustomerWasCreated::class => [
            SendWelcomeEmailToCustomer::class,
            CreateCouponCustomer::class,
            SendLeadRegisterToAdmin::class,
        ],

        UserHasFinishedPromotion::class => [
            SendEmailForCreateReviews::class
        ]
    ];


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }

    /**
    * Determine if events and listeners should be automatically discovered.
    *
    * @return bool
    */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
