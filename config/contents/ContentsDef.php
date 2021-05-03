<?php

return [
    'ITEM_NUM_IN_PAGE' => '7',  // 1ページのアイテム数
    
    'rankingOrderArray' => [
        'REQUEST_COUNT'     => 'リクエスト数ランキング',
        'APPEARANCE_COUNT'  => '登場回数ランキング',
        'RECENT_APPEARANCE' => '最近登場した順',
    ],
    
    'IMAGE_FILE_SIZE_MAX' => '2048',  // 写真のサイズの最大値(KB)  // 'IMAGE_FILE_SIZE_MAX'と'requestValidateValueArray'に2048という記述あり。

    'requestValidateValueArray' => [
        'date'                => 'required | date | unique:dates',
        'name'                => 'required | max:127',
        'description'         => 'required | max:511',
        'selected_image_file' => 'mimes:jpeg,jpg,gif,png,bmp | max:2048',  // requiredが必要なときは足して  // 'IMAGE_FILE_SIZE_MAX'と'requestValidateValueArray'に2048という記述あり。
    ],
    
    'STORAGE_TMP_UPLOADS_DIR' => 'public/tmp_uploads',  // 画像ファイルのリサイズを行う際の一時的なファイル置き場。storage/app以下のパス。
];