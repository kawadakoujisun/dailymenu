<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    
    'required' => ' :attribute は必須です。',
    'date'     => ' :attribute が正しい日付ではありません。',          // 未確認
    'unique'   => '既に存在している :attribute です。',
    'max' => [
        'file'   => ' :attribute は :max KB以下にしてください。',      // 未確認
        'string' => ' :attribute は :max 文字以下にしてください。',
    ],
    
    'uploaded' => ' :attribute をアップロードできませんでした。サイズは' . \Config::get('contents.ContentsDef.IMAGE_FILE_SIZE_MAX') . 'KB以下でなければなりませんが、それより大きい場合はそれが原因かもしれません。',
    'mimes'    => ' :attribute のフォーマットは :values にしてください。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'date'                => '日にち',
        'name'                => '料理名',
        'description'         => '説明',
        'selected_image_file' => '写真',
        
        'resize_image_width'  => '横',
        'resize_image_height' => '縦',
        
        'email'    => 'メールアドレス',
        'password' => 'パスワード'
    ],

];
