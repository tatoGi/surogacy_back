<?php

return [
    'id' => 3,
    'type' => 3,
    'folder' => 'text_page',
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
            'desc' => [
                'type' => 'text',
                'error_msg' => 'title_is_required',
                'data-icon' => '-',
                'required' => 'required',
                'max' => '100',
                'min' => '3',

            ],
            'text' => [
                'type' => 'textarea',
                'error_msg' => 'title_is_required',

            ],

            'active' => [
                'type' => 'checkbox',
            ],
        ],
        'nonTrans' => [

            'images' => [
                'type' => 'images',
            ],
        ],
    ],
];