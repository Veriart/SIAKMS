<?php

return [
    'avatar_column' => 'photo',
    'disk' => env('FILESYSTEM_DISK', 'public'),
    'visibility' => 'public', // or replace by filesystem disk visibility with fallback value
    'show_custom_fields' => true,
    'custom_fields' => [
        'gender' => [
            'type' => 'text',
            'label' => 'Gender',
            
        ]
    ]
];
