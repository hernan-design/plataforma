<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION'),
    ],

    'stripe' => [
        'model'  => App\Usuario::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'twitter' => [
        'client_id'     => 'l9wS3zKeA72KMburG4S0WZkBK',
        'client_secret' => 'R3v2y2fTGBYrsLwm3uQaKG9LasNng8aTt7hVSO6T1yWFfGH4rs',
        'redirect'      => 'http://localhost/plataforma/public/auth/twitter/callback',
    ],

    'facebook' => [
        'client_id' => '394349060716779',
        'client_secret' => 'd11c43a06a40c8e583bf66e129f26d03',
        'redirect' => 'http://localhost/plataforma/public/auth/facebook/callback',
    ],
   
    'linkedin' => [
        'client_id' => '77ez4jgez6p7gq',
        'client_secret' => 'gdfsUfd3QnwKO2NW',
        'redirect' => 'http://localhost/plataforma/public/auth/linkedin/callback'
    ]
];
