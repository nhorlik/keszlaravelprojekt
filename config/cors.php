<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['OPTIONS', 'GET', 'POST', 'PUT', 'DELETE'],
    'allowed_origins' => ['http://localhost:8000'],
    'allowed_headers' => ['*'],
    'supports_credentials' => false,

];
