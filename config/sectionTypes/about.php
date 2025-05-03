<?php

return [
    'id' => 6,
    'type' => 6,
    'folder' => 'about',
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
            'text' => [
                'type' => 'textarea',
                'error_msg' => 'text_is_required',
                'required' => 'required',
            ],

            'active' => [
                'type' => 'checkbox',
                'error_msg' => 'active_is_required',
                'required' => 'required',
            ],

        ],
        'nonTrans' => [

            'images' => [
                'type' => 'images',
            ],



        ],

    ],
];
