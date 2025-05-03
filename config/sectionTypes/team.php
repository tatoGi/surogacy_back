<?php

return [
    'id' => 8,
    'type' => 8,
    'folder' => 'team',
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

            'text' => [
                'type' => 'textarea',
                'error_msg' => 'text_is_required',
                'required' => 'required',
            ],
            'position' => [
                'type' => 'text',
                'error_msg' => 'position_is_required',
                'required' => 'required',
            ],

            'active' => [
                'type' => 'checkbox',
                'error_msg' => 'active_is_required',
                'required' => 'required',
            ],

        ],
        'nonTrans' => [

            'image' => [
                'type' => 'image',
            ],



        ],

    ],
];
