<?php

use App\Controllers\Error;
use App\Controllers\Topics;

return [
    ''        => [Topics::class, 'index'],
    'create' => [Topics::class, 'create'],
    'edit'   => [Topics::class, 'edit'],
    'delete' => [Topics::class, 'delete'],
    'error'  => [Error::class, 'index']
];
