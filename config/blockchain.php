<?php

return [
    'eqbr' => [
        'api_url' => env('EQBR_API_URL', 'https://ag.eqhub.eqbr.com'),
        'api_key' => env('EQBR_API_KEY'),
        'web3_provider' => env('EQBR_WEB3_PROVIDER'),
        'network_id' => env('EQBR_NETWORK_ID'),
        'contract_address' => env('EQBR_CONTRACT_ADDRESS'),
        'enabled' => env('EQBR_ENABLED', true),
    ],
];