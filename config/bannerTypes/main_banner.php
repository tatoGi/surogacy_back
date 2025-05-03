<?php

return [
    'id' => 1,
    'type' => 1,
    'name' => 'main_banner',
    'fields' => [
        'trans' => [
            'title' => [
                'type' => 'text',
                'required' => 'required',
                'validation' => 'required|max:100',
                'placeholder' => 'sdf',
            ],
            'active' => [
                'type' => 'checkbox',
                'required' => 'required',
                'validation' => 'required',
            ],
        ],
        'nonTrans' => [
            'images' => [
                'type' => 'images',

            ],
            'date' => [
                'type' => 'date',
                'required' => 'required',
                'validation' => 'required|max:20',
                'placeholder' => 'sdf',
            ],
        ],

    ],

];
