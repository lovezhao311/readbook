<?php
return [
    'action_begin' => [
        \app\admin\behavior\Verify::class,
    ],
    'handle_success' => [
        \app\admin\behavior\Log::class,
    ],
];
