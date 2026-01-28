<?php

return [
    'stripe' => [
        'public' => env('STRIPE_PUBLIC_KEY'),
        'secret' => env('STRIPE_SECRET_KEY'),
    ],

    'payment_methods' => [
        'virtual' => [
            'enabled' => true,
            'name' => 'Virtual Card (Demo)',
            'description' => 'Test payment method for development and testing',
        ],
        'stripe' => [
            'enabled' => env('STRIPE_SECRET_KEY') ? true : false,
            'name' => 'Credit/Debit Card',
            'description' => 'Powered by Stripe',
        ],
    ],
];
