<?php

use App\Controllers\Error;
use App\Controllers\Topics;
use App\Controllers\Votes;

return [
    ''       => [Topics::class, 'index'],
    'create' => [Topics::class, 'create'],
    'edit'   => [Topics::class, 'edit'],
    'delete' => [Topics::class, 'delete'],
    'vote'   => [Votes::class,  'update'],
    'error'  => [Error::class,  'index']
];
