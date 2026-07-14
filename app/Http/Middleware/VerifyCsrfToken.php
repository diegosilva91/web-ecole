<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/es/payment-log',
        '/register/google',
        '/api/register/google',
        '/api/stripe/webhooks/subscriptions',
        '/api/stripe/webhooks/payment-intents',
        '/api/stripe/webhooks/invoices',
        '/api/stripe/webhooks',
        '/api/recommender-courses/webhooks',
    ];
}
