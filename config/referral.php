<?php

return [
    'model' => Davidnadejdin\LaravelReferral\Models\Referral::class,

    'code_length' => 5,

    'auto_create' => false,

    // cookie, query
    'driver' => 'cookie',

    'key' => 'referral',
];
