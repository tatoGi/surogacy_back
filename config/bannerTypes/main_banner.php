<?php

return [
    'id' => 1,
    'type' => 1,
    'name' => 'main_banner',
    'fields' => [

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