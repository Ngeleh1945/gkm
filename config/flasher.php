<?php

declare(strict_types=1);

namespace Flasher\Laravel\Resources;

return [
    // Default notification library (e.g., 'flasher', 'toastr', 'noty', etc.)
    'default' => 'flasher',


    'translate' => true,

    'inject_assets' => true,

    'flash_bag' => [
        'success' => ['success'],
        'error' => ['error', 'danger'],
        'warning' => ['warning', 'alarm'],
        'info' => ['info', 'notice', 'alert'],
    ],

    'filter' => [
        'limit' => 5,
    ],
];
