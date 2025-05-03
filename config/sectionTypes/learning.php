<?php

return [
    'id' => 5,
    'type' => 5,
    'folder' => 'learning',
    'fields' => [
        'trans' => [
            'title' => [
                'type' => 'text',
                'data-icon' => '-',
                'error_msg' => 'title_is_required',
                'required' => 'required',
                'max' => '100',
                'min' => '3',

            ],
            'slug' => [
                'type' => 'slug',
                'error_msg' => 'slug_is_required',
                'data-icon' => '-',
                'required' => 'required',
                'max' => '100',
                'min' => '3',

            ],


        ],
        'nonTrans' => [
            'email' => [
                'type' => 'text',
            ],

            'phone' => [
                'type' => 'text',
            ],

        ],

    ],
];
