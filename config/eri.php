<?php
return [
    'pkcs12_path' => storage_path(env('ERI_PKCS12_PATH', 'app/eri/agencykey.p12')),
    'public_cert_path' => storage_path(env('ERI_PUBLIC_CERT_PATH', 'app/eri/agencykey.crt')),
    'pkcs12_password' => env('ERI_PKCS12_PASSWORD'),
    'user_id' => env('ERI_USER_ID'),
    'password' => env('ERI_PASSWORD'),
    'service_name' => env('ERI_SERVICE_NAME'),
];
