<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Payment Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your payments are operating in.
    | Set to 'sandbox' for testing and 'production' for live payments.
    |
    */
    'environment' => env('PAYMENT_ENVIRONMENT', 'sandbox'),

    /*
    |--------------------------------------------------------------------------
    | Sandbox Mode
    |--------------------------------------------------------------------------
    |
    | When enabled, all payments will be simulated and no real transactions
    | will be processed. This is useful for development and testing.
    |
    */
    'sandbox_mode' => env('PAYMENT_SANDBOX_MODE', true),

    /*
    |--------------------------------------------------------------------------
    | Webhook Configuration
    |--------------------------------------------------------------------------
    |
    | Configure webhook endpoints for payment gateway callbacks
    |
    */
    'webhooks' => [
        'enabled' => env('PAYMENT_WEBHOOKS_ENABLED', true),
        'secret' => env('PAYMENT_WEBHOOK_SECRET', 'webhook_secret_key'),
        'tolerance' => 300, // seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Reconciliation Settings
    |--------------------------------------------------------------------------
    |
    | Settings for automated payment reconciliation
    |
    */
    'reconciliation' => [
        'enabled' => env('PAYMENT_RECONCILIATION_ENABLED', true),
        'auto_match' => true,
        'tolerance_amount' => 0.01, // Allow 1 cent difference
    ],

    /*
    |--------------------------------------------------------------------------
    | Stripe Configuration
    |--------------------------------------------------------------------------
    */
    'stripe' => [
        'public' => env('STRIPE_PUBLIC_KEY'),
        'secret' => env('STRIPE_SECRET_KEY'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        'sandbox' => [
            'public' => env('STRIPE_TEST_PUBLIC_KEY'),
            'secret' => env('STRIPE_TEST_SECRET_KEY'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Methods
    |--------------------------------------------------------------------------
    |
    | Configure available payment methods
    |
    */
    'payment_methods' => [
        'virtual' => [
            'enabled' => true,
            'name' => 'Virtual Card (Demo)',
            'description' => 'Test payment method for development and testing',
            'sandbox_only' => true,
        ],
        'stripe' => [
            'enabled' => env('STRIPE_SECRET_KEY') ? true : false,
            'name' => 'Credit/Debit Card',
            'description' => 'Powered by Stripe',
            'sandbox_only' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Transaction Logging
    |--------------------------------------------------------------------------
    |
    | Enable detailed transaction logging for debugging and reconciliation
    |
    */
    'logging' => [
        'enabled' => true,
        'channel' => 'single',
        'level' => env('PAYMENT_LOG_LEVEL', 'info'),
    ],
];
