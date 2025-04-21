<?php

return [
    'id' => 2,
    'type' => 2,
    'name' => 'Team_Banner',
    'fields' => [
        'trans' => [
            'title' => [
                'type' => 'text',
                'data-icon' => '-',
                'reqired' => 'required',
                'max' => '100',
                'min' => '3',
                'name' => 'title',
                'translateble' => true,

            ],
            'position' => [
                'type' => 'text',
                'error_msg' => 'position_is_required',
                'max' => '100',
                'min' => '3',
            ],
            'desc' => [
                'type' => 'text',
                'error_msg' => 'description_is_required',
                'max' => '100',
                'min' => '3',

            ],
            'active' => [
                'type' => 'checkbox',
            ],
            'alt_text' => [
                'type' => 'alt_text',
            ],

        ],

        'nonTrans' => [
'images' => [
                'type' => 'image',

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
