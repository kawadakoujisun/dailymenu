<?php

return [
    'ITEM_NUM_IN_PAGE' => '7',  // 1ページのアイテム数
    
    'rankingOrderArray' => [
        'REQUEST_COUNT'     => 'リクエスト数ランキング',
        'APPEARANCE_COUNT'  => '登場回数ランキング',
        'RECENT_APPEARANCE' => '最近登場した順',
    ],
    
    'requestValidateValueArray' => [
        'date'                => 'required | date | unique:dates',
        'name'                => 'required | max:127',
        'description'         => 'required | max:511',
        'selected_image_file' => 'mimes:jpeg,jpg,gif,png,bmp | max:2048',  // requiredが必要なときは足して
    ],
];