<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */
   
    'supportsCredentials' => false,
    'allowedOrigins' => [
        'https://cloud.pansea.vvverb.com',
        'https://api.pansea.vvverb.com',
        'https://cloud.pansea.com',
        'https://api.pansea.com',
        'http://cloud.pansea.test',
        'http://api.pansea.test',
    ],
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['*'],
    'exposedHeaders' => ['Authorization'],
    'maxAge' => 0,

];
