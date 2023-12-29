<?php

return [
    'default_provider' => env('FLAGS_DEFAULT_PROVIDER', 'default'),

    'providers' => [
        'default' => \App\Raketech\Adapter\RestCountriesProviderAdapter::class,
    ]
];
