<?php

return [
    'provider' => env('PAYMENT_PROVIDER', 'mock'), // mock ou pagarme
    'pagarme_key' => env('PAGARME_API_KEY'),
    'pagarme_base' => env('PAGARME_API_BASE', 'https://api.pagar.me/core/v5/'),
];
