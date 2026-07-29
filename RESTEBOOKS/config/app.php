<?php

return [
    'name' => $_ENV['APP_NAME'] ?? 'RESTEBOOKS',
    'env' => $_ENV['APP_ENV'] ?? 'local',
    'url' => $_ENV['APP_URL'] ?? 'http://localhost:8000',
    'key' => $_ENV['APP_KEY'] ?? 'insecure_default_change_me',

    'jwt_secret' => $_ENV['JWT_SECRET'] ?? 'insecure_default_change_me',
    'jwt_ttl' => 60 * 60 * 24, // 24 hours

    'subscription_price_ngn' => (int) ($_ENV['SUBSCRIPTION_PRICE_NGN'] ?? 1000),
    'subscription_duration_days' => (int) ($_ENV['SUBSCRIPTION_DURATION_DAYS'] ?? 30),

    'paystack' => [
        'public_key' => $_ENV['PAYSTACK_PUBLIC_KEY'] ?? 'pk_test_stub',
        'secret_key' => $_ENV['PAYSTACK_SECRET_KEY'] ?? 'sk_test_stub',
        // 'live' calls the real Paystack API. 'stub' fakes a successful
        // payment locally so the whole flow can be demoed/tested without
        // real keys. Flip this in .env once real keys are added.
        'mode' => $_ENV['PAYSTACK_MODE'] ?? 'stub',
    ],
];
