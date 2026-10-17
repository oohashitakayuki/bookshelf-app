<?php

return [

    'required' => ':attributeは必須です。',
    'email' => ':attributeには有効なメールアドレスを入力してください。',
    'min' => [
        'string' => ':attributeは:min文字以上で入力してください。',
    ],
    'max' => [
        'string' => ':attributeは:max文字以内で入力してください。',
    ],
    'unique' => 'この:attributeは既に使われています。',
    'confirmed' => ':attributeと:attribute確認が一致しません。',

    'custom' => [
        'name' => [
            'required' => 'お名前を入力してください。',
            'max' => 'お名前は255文字以内で入力してください。',
        ],
        'email' => [
            'required' => 'メールアドレスを入力してください。',
            'email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください。',
            'max' => 'メールアドレスは255文字以内で入力してください。',
            'unique' => 'このメールアドレスは既に使われています。',
        ],
        'password' => [
            'required' => 'パスワードを入力してください。',
            'min' => 'パスワードは8文字以上で入力してください。',
            'confirmed' => 'パスワードとパスワード確認が一致しません。'
        ],
    ],

    'attributes' => [
        'name' => 'お名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => 'パスワード確認',
    ],
];
