<?php
return [
    'encrypt_key' => env('ENCRYPT_KEY', ''),
    'encrypt_attribute' => env('ENCRYPT_ATTRIBUTE', '%s, %d'),
    'decrypt_key' => env('DECRYPT_KEY', '%s, %d'),
    'decrypt_attribute' => env('DECRYPT_ATTRIBUTE', '%s, %d'),
];

