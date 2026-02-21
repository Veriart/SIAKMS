<?php

return [
    'avatar_column' => 'photo',
    'disk' => env('FILESYSTEM_DISK', 'public'),
    'visibility' => 'public', // or replace by filesystem disk visibility with fallback value
    'show_custom_fields' => false,
    'custom_fields' => [
        'gender' => [
            'type' => 'select',
            'label' => 'Gender',
            'options' => [
                'Laki-laki' => 'Laki-laki',
                'Perempuan' => 'Perempuan',
            ],
        ],
        'religion' => [
            'type' => 'select',
            'label' => 'Religion',
            'options' => [
                'Islam' => 'Islam',
                'Kristen' => 'Kristen',
                'Katolik' => 'Katolik',
                'Hindu' => 'Hindu',
                'Buddha' => 'Buddha',
            ],
        ],
    ]
];
