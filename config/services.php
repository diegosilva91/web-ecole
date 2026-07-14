<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook'=>[
        'client_id'=>'536987020311917',
        'client_secret'=>'8af9dd4adec0c413a04d92cd2e3595b8',
        'redirect'=>env('APP_URL').'/auth/facebook/callback'
    ],

    'google' => [
        'client_id' => '721480707563-n9gnn08j8alarsigi95rtpid2e7c3e1u.apps.googleusercontent.com',
        'client_secret' => 'oI2xk6i08UW3eET_a2oPLPEt',
        'redirect' => env('APP_URL').'/auth/google/callback',
        // The URL to redirect to after the OAuth process.
        'redirect_uri' => env('GOOGLE_REDIRECT_URI'),

        // The URL that listens to Google webhook notifications (Part 3).
        'webhook_uri' => env('GOOGLE_WEBHOOK_URI'),

        // Let the user know what we will be using from his Google account.
        'scopes' => [
            // Getting access to the user's email.
//            \Google_Service_Oauth2::USERINFO_EMAIL,

            // Managing the user's calendars and events.
//            \Google_Service_Calendar::CALENDAR,
        ],

        // Enables automatic token refresh.
        'approval_prompt' => 'force',
        'access_type' => 'offline',

        // Enables incremental scopes (useful if in the future we need access to another type of data).
        'include_granted_scopes' => true,
    ],
];
