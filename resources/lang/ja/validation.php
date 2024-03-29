<?php

return [

    /*
    |--------------------------------------------------------------------------
    | バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | 以下の言語行はバリデタークラスにより使用されるデフォルトのエラー
    | メッセージです。サイズルールのようにいくつかのバリデーションを
    | 持っているものもあります。メッセージはご自由に調整してください。
    |
    */

    'accepted'             => ':attributeを承認してください。',
    'accepted_if' => ':otherが:valueの場合、:attributeを承認してください。',
    'active_url'           => ':attributeが有効なURLではありません。',
    'after'                => ':attributeには、:dateより後の日付を指定してください。',
    'after_or_equal'       => ':attributeには、:date以降の日付を指定してください。',
    'alpha'                => ':attributeはアルファベットのみがご利用できます。',
    'alpha_dash'           => ':attributeはアルファベットとダッシュ(-)及び下線(_)がご利用できます。',
    'alpha_num'            => ':attributeはアルファベット数字がご利用できます。',
    'array'                => ':attributeは配列でなくてはなりません。',
    'before'               => ':attributeには、:dateより前の日付をご利用ください。',
    'before_or_equal'      => ':attributeには、:date以前の日付をご利用ください。',
    'between'              => [
        'numeric' => ':attributeは、:minから:maxの間で指定してください。',
        'file'    => ':attributeは、:min kBから、:max kBの間で指定してください。',
        'string'  => ':attributeは、:min文字から、:max文字の間で指定してください。',
        'array'   => ':attributeは、:min個から:max個の間で指定してください。',
    ],
    'boolean'              => ':attributeは、trueかfalseを指定してください。',
    'confirmed'            => ':attributeと、確認フィールドとが、一致していません。',
    'current_password'     => 'パスワードが正しくありません。',
    'date'                 => ':attributeには有効な日付を指定してください。',
    'date_equals'          => ':attributeには、:dateと同じ日付けを指定してください。',
    'date_format'          => ':attributeは:format形式で指定してください。',
    'different'            => ':attributeと:otherには、異なった内容を指定してください。',
    'digits'               => ':attributeは:digits桁で指定してください。',
    'digits_between'       => ':attributeは:min桁から:max桁の間で指定してください。',
    'dimensions'           => ':attributeの図形サイズが正しくありません。',
    'distinct'             => ':attributeには異なった値を指定してください。',
    'email'                => ':attributeには、有効なメールアドレスを指定してください。',
    'ends_with'            => ':attributeには、:valuesのどれかで終わる値を指定してください。',
    'exists'               => '選択された:attributeは正しくありません。',
    'file'                 => ':attributeにはファイルを指定してください。',
    'filled'               => ':attributeに値を指定してください。',
    'gt'                   => [
        'numeric' => ':attributeには、:valueより大きな値を指定してください。',
        'file'    => ':attributeには、:value kBより大きなファイルを指定してください。',
        'string'  => ':attributeは、:value文字より長く指定してください。',
        'array'   => ':attributeには、:value個より多くのアイテムを指定してください。',
    ],
    'gte'                  => [
        'numeric' => ':attributeには、:value以上の値を指定してください。',
        'file'    => ':attributeには、:value kB以上のファイルを指定してください。',
        'string'  => ':attributeは、:value文字以上で指定してください。',
        'array'   => ':attributeには、:value個以上のアイテムを指定してください。',
    ],
    'image'                => ':attributeには画像ファイルを指定してください。',
    'in'                   => '選択された:attributeは正しくありません。',
    'in_array'             => ':attributeには:otherの値を指定してください。',
    'integer'              => ':attributeは整数で指定してください。',
    'ip'                   => ':attributeには、有効なIPアドレスを指定してください。',
    'ipv4'                 => ':attributeには、有効なIPv4アドレスを指定してください。',
    'ipv6'                 => ':attributeには、有効なIPv6アドレスを指定してください。',
    'json'                 => ':attributeには、有効なJSON文字列を指定してください。',
    'lt'                   => [
        'numeric' => ':attributeには、:valueより小さな値を指定してください。',
        'file'    => ':attributeには、:value kBより小さなファイルを指定してください。',
        'string'  => ':attributeは、:value文字より短く指定してください。',
        'array'   => ':attributeには、:value個より少ないアイテムを指定してください。',
    ],
    'lte'                  => [
        'numeric' => ':attributeには、:value以下の値を指定してください。',
        'file'    => ':attributeには、:value kB以下のファイルを指定してください。',
        'string'  => ':attributeは、:value文字以下で指定してください。',
        'array'   => ':attributeには、:value個以下のアイテムを指定してください。',
    ],
    'max'                  => [
        'numeric' => ':attributeには、:max以下の数字を指定してください。',
        'file'    => ':attributeには、:max kB以下のファイルを指定してください。',
        'string'  => ':attributeは、:max文字以下で指定してください。',
        'array'   => ':attributeは:max個以下指定してください。',
    ],
    'mimes'                => ':attributeには:valuesタイプのファイルを指定してください。',
    'mimetypes'            => ':attributeには:valuesタイプのファイルを指定してください。',
    'min'                  => [
        'numeric' => ':attributeには、:min以上の数字を指定してください。',
        'file'    => ':attributeには、:min kB以上のファイルを指定してください。',
        'string'  => ':attributeは、:min文字以上で指定してください。',
        'array'   => ':attributeは:min個以上指定してください。',
    ],
    'multiple_of' => ':attributeには、:valueの倍数を指定してください。',
    'not_in'               => '選択された:attributeは正しくありません。',
    'not_regex'            => ':attributeの形式が正しくありません。',
    'numeric'              => ':attributeには、数字を指定してください。',
    'password'             => '正しいパスワードを指定してください。',
    'present'              => ':attributeが存在していません。',
    'regex'                => ':attributeに正しい形式を指定してください。',
    'required'             => ':attributeは必ず指定してください。',
    'required_if'          => ':otherが:valueの場合、:attributeも指定してください。',
    'required_unless'      => ':otherが:valuesでない場合、:attributeを指定してください。',
    'required_with'        => ':valuesを指定する場合は、:attributeも指定してください。',
    'required_with_all'    => ':valuesを指定する場合は、:attributeも指定してください。',
    'required_without'     => ':valuesを指定しない場合は、:attributeを指定してください。',
    'required_without_all' => ':valuesのどれも指定しない場合は、:attributeを指定してください。',
    'prohibited'           => ':attributeは入力禁止です。',
    'prohibited_if' => ':otherが:valueの場合、:attributeは入力禁止です。',
    'prohibited_unless'    => ':otherが:valueでない場合、:attributeは入力禁止です。',
    'prohibits'            => 'attributeは:otherの入力を禁じています。',
    'same'                 => ':attributeと:otherには同じ値を指定してください。',
    'size'                 => [
        'numeric' => ':attributeは:sizeを指定してください。',
        'file'    => ':attributeのファイルは、:sizeキロバイトでなくてはなりません。',
        'string'  => ':attributeは:size文字で指定してください。',
        'array'   => ':attributeは:size個指定してください。',
    ],
    'starts_with'          => ':attributeには、:valuesのどれかで始まる値を指定してください。',
    'string'               => ':attributeは文字列を指定してください。',
    'timezone'             => ':attributeには、有効なゾーンを指定してください。',
    'unique'               => ':attributeの値は既に存在しています。',
    'uploaded'             => ':attributeのアップロードに失敗しました。',
    'url'                  => ':attributeに正しい形式を指定してください。',
    'uuid'                 => ':attributeに有効なUUIDを指定してください。',

    /*
    |--------------------------------------------------------------------------
    | Custom バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | "属性.ルール"の規約でキーを指定することでカスタムバリデーション
    | メッセージを定義できます。指定した属性ルールに対する特定の
    | カスタム言語行を手早く指定できます。
    |
    */

    'custom' => [
        '属性名' => [
            'ルール名' => 'カスタムメッセージ',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション属性名
    |--------------------------------------------------------------------------
    |
    | 以下の言語行は、例えば"email"の代わりに「メールアドレス」のように、
    | 読み手にフレンドリーな表現でプレースホルダーを置き換えるために指定する
    | 言語行です。これはメッセージをよりきれいに表示するために役に立ちます。
    |
    */
    
    'attributes' => [
        'name' => '名前',
        'category' => 'カテゴリ',
        'serving' => '何人前',
        'ingredient-0' => '食材1',
        'ingredient-1' => '食材2',
        'ingredient-2' => '食材3',
        'ingredient-3' => '食材4',
        'ingredient-4' => '食材5',
        'ingredient-5' => '食材6',
        'ingredient-6' => '食材7',
        'ingredient-7' => '食材8',
        'ingredient-8' => '食材9',
        'ingredient-9' => '食材10',
        'ingredient-10' => '食材11',
        'ingredient-11' => '食材12',
        'ingredient-12' => '食材13',
        'ingredient-13' => '食材14',
        'ingredient-14' => '食材15',
        'ingredient-15' => '食材16',
        'ingredient-16' => '食材17',
        'ingredient-17' => '食材18',
        'ingredient-18' => '食材19',
        'ingredient-19' => '食材20',
        'ingredient-20' => '食材21',
        'ingredient-21' => '食材22',
        'ingredient-22' => '食材23',
        'ingredient-23' => '食材24',
        'ingredient-24' => '食材25',
        'ingredient-25' => '食材26',
        'ingredient-26' => '食材27',
        'ingredient-27' => '食材28',
        'ingredient-28' => '食材29',
        'ingredient-29' => '食材30',
        'ingredient-30' => '食材31',
        'ingredient-31' => '食材32',
        'ingredient-32' => '食材33',
        'ingredient-33' => '食材34',
        'ingredient-34' => '食材35',
        'ingredient-35' => '食材36',
        'ingredient-36' => '食材37',
        'ingredient-37' => '食材38',
        'ingredient-38' => '食材39',
        'ingredient-39' => '食材40',
        'ingredient-40' => '食材41',
        'ingredient-41' => '食材42',
        'ingredient-42' => '食材43',
        'ingredient-43' => '食材44',
        'ingredient-44' => '食材45',
        'ingredient-45' => '食材46',
        'ingredient-46' => '食材47',
        'ingredient-47' => '食材48',
        'ingredient-48' => '食材49',
        'ingredient-49' => '食材50',
        'amount-0' => '分量1',
        'amount-1' => '分量2',
        'amount-2' => '分量3',
        'amount-3' => '分量4',
        'amount-4' => '分量5',
        'amount-5' => '分量6',
        'amount-6' => '分量7',
        'amount-7' => '分量8',
        'amount-8' => '分量9',
        'amount-9' => '分量10',
        'amount-10' => '分量11',
        'amount-11' => '分量12',
        'amount-12' => '分量13',
        'amount-13' => '分量14',
        'amount-14' => '分量15',
        'amount-15' => '分量16',
        'amount-16' => '分量17',
        'amount-17' => '分量18',
        'amount-18' => '分量19',
        'amount-19' => '分量20',
        'image' => '画像',
        'link' => '参考リンク',
        'process-0' => '手順1',
        'process-1' => '手順2',
        'process-2' => '手順3',
        'process-3' => '手順4',
        'process-4' => '手順5',
        'process-5' => '手順6',
        'process-6' => '手順7',
        'process-7' => '手順8',
        'detail-0' => '詳細1',
        'detail-1' => '詳細2',
        'detail-2' => '詳細3',
        'detail-3' => '詳細4',
        'detail-4' => '詳細5',
        'detail-5' => '詳細6',
        'detail-6' => '詳細7',
        'detail-7' => '詳細8',
        'ideal-amount-0' => '理想在庫1',
        'ideal-amount-1' => '理想在庫2',
        'ideal-amount-2' => '理想在庫3',
        'ideal-amount-3' => '理想在庫4',
        'ideal-amount-4' => '理想在庫5',
        'ideal-amount-5' => '理想在庫6',
        'ideal-amount-6' => '理想在庫7',
        'ideal-amount-7' => '理想在庫8',
        'ideal-amount-8' => '理想在庫9',
        'ideal-amount-9' => '理想在庫10',
        'ideal-amount-10' => '理想在庫11',
        'ideal-amount-11' => '理想在庫12',
        'ideal-amount-12' => '理想在庫13',
        'ideal-amount-13' => '理想在庫14',
        'ideal-amount-14' => '理想在庫15',
        'ideal-amount-15' => '理想在庫16',
        'ideal-amount-16' => '理想在庫17',
        'ideal-amount-17' => '理想在庫18',
        'ideal-amount-18' => '理想在庫19',
        'ideal-amount-19' => '理想在庫20',
        'ideal-amount-20' => '理想在庫21',
        'ideal-amount-21' => '理想在庫22',
        'ideal-amount-22' => '理想在庫23',
        'ideal-amount-23' => '理想在庫24',
        'ideal-amount-24' => '理想在庫25',
        'ideal-amount-25' => '理想在庫26',
        'ideal-amount-26' => '理想在庫27',
        'ideal-amount-27' => '理想在庫28',
        'ideal-amount-28' => '理想在庫29',
        'ideal-amount-29' => '理想在庫30',
        'ideal-amount-30' => '理想在庫31',
        'ideal-amount-31' => '理想在庫32',
        'ideal-amount-32' => '理想在庫33',
        'ideal-amount-33' => '理想在庫34',
        'ideal-amount-34' => '理想在庫35',
        'ideal-amount-35' => '理想在庫36',
        'ideal-amount-36' => '理想在庫37',
        'ideal-amount-37' => '理想在庫38',
        'ideal-amount-38' => '理想在庫39',
        'ideal-amount-39' => '理想在庫40',
        'ideal-amount-40' => '理想在庫41',
        'ideal-amount-41' => '理想在庫42',
        'ideal-amount-42' => '理想在庫43',
        'ideal-amount-43' => '理想在庫44',
        'ideal-amount-44' => '理想在庫45',
        'ideal-amount-45' => '理想在庫46',
        'ideal-amount-46' => '理想在庫47',
        'ideal-amount-47' => '理想在庫48',
        'ideal-amount-48' => '理想在庫49',
        'ideal-amount-49' => '理想在庫50',
        'real-amount-0' => '実在庫1',
        'real-amount-1' => '実在庫2',
        'real-amount-2' => '実在庫3',
        'real-amount-3' => '実在庫4',
        'real-amount-4' => '実在庫5',
        'real-amount-5' => '実在庫6',
        'real-amount-6' => '実在庫7',
        'real-amount-7' => '実在庫8',
        'real-amount-8' => '実在庫9',
        'real-amount-9' => '実在庫10',
        'real-amount-10' => '実在庫11',
        'real-amount-11' => '実在庫12',
        'real-amount-12' => '実在庫13',
        'real-amount-13' => '実在庫14',
        'real-amount-14' => '実在庫15',
        'real-amount-15' => '実在庫16',
        'real-amount-16' => '実在庫17',
        'real-amount-17' => '実在庫18',
        'real-amount-18' => '実在庫19',
        'real-amount-19' => '実在庫20',
        'real-amount-20' => '実在庫21',
        'real-amount-21' => '実在庫22',
        'real-amount-22' => '実在庫23',
        'real-amount-23' => '実在庫24',
        'real-amount-24' => '実在庫25',
        'real-amount-25' => '実在庫26',
        'real-amount-26' => '実在庫27',
        'real-amount-27' => '実在庫28',
        'real-amount-28' => '実在庫29',
        'real-amount-29' => '実在庫30',
        'real-amount-30' => '実在庫31',
        'real-amount-31' => '実在庫32',
        'real-amount-32' => '実在庫33',
        'real-amount-33' => '実在庫34',
        'real-amount-34' => '実在庫35',
        'real-amount-35' => '実在庫36',
        'real-amount-36' => '実在庫37',
        'real-amount-37' => '実在庫38',
        'real-amount-38' => '実在庫39',
        'real-amount-39' => '実在庫40',
        'real-amount-40' => '実在庫41',
        'real-amount-41' => '実在庫42',
        'real-amount-42' => '実在庫43',
        'real-amount-43' => '実在庫44',
        'real-amount-44' => '実在庫45',
        'real-amount-45' => '実在庫46',
        'real-amount-46' => '実在庫47',
        'real-amount-47' => '実在庫48',
        'real-amount-48' => '実在庫49',
        'real-amount-49' => '実在庫',
        // 'waste-amount-*' => '廃棄数',
        'restock-amount-0' => '補充数量・コメント1',
        'restock-amount-1' => '補充数量・コメント2',
        'restock-amount-2' => '補充数量・コメント3',
        'restock-amount-3' => '補充数量・コメント4',
        'restock-amount-4' => '補充数量・コメント5',
        'restock-amount-5' => '補充数量・コメント6',
        'restock-amount-6' => '補充数量・コメント7',
        'restock-amount-7' => '補充数量・コメント8',
        'restock-amount-8' => '補充数量・コメント9',
        'restock-amount-9' => '補充数量・コメント10',
        'restock-amount-10' => '補充数量・コメント11',
        'restock-amount-11' => '補充数量・コメント12',
        'restock-amount-12' => '補充数量・コメント13',
        'restock-amount-13' => '補充数量・コメント14',
        'restock-amount-14' => '補充数量・コメント15',
        'restock-amount-15' => '補充数量・コメント16',
        'restock-amount-16' => '補充数量・コメント17',
        'restock-amount-17' => '補充数量・コメント18',
        'restock-amount-18' => '補充数量・コメント19',
        'restock-amount-19' => '補充数量・コメント20',
        'restock-amount-20' => '補充数量・コメント21',
        'restock-amount-21' => '補充数量・コメント22',
        'restock-amount-22' => '補充数量・コメント23',
        'restock-amount-23' => '補充数量・コメント24',
        'restock-amount-24' => '補充数量・コメント25',
        'restock-amount-25' => '補充数量・コメント26',
        'restock-amount-26' => '補充数量・コメント27',
        'restock-amount-27' => '補充数量・コメント28',
        'restock-amount-28' => '補充数量・コメント29',
        'restock-amount-29' => '補充数量・コメント30',
        'restock-amount-30' => '補充数量・コメント31',
        'restock-amount-31' => '補充数量・コメント32',
        'restock-amount-32' => '補充数量・コメント33',
        'restock-amount-33' => '補充数量・コメント34',
        'restock-amount-34' => '補充数量・コメント35',
        'restock-amount-35' => '補充数量・コメント36',
        'restock-amount-36' => '補充数量・コメント37',
        'restock-amount-37' => '補充数量・コメント38',
        'restock-amount-38' => '補充数量・コメント39',
        'restock-amount-39' => '補充数量・コメント40',
        'restock-amount-40' => '補充数量・コメント41',
        'restock-amount-41' => '補充数量・コメント42',
        'restock-amount-42' => '補充数量・コメント43',
        'restock-amount-43' => '補充数量・コメント44',
        'restock-amount-44' => '補充数量・コメント45',
        'restock-amount-45' => '補充数量・コメント46',
        'restock-amount-46' => '補充数量・コメント47',
        'restock-amount-47' => '補充数量・コメント48',
        'restock-amount-48' => '補充数量・コメント49',
        'restock-amount-49' => '補充数量・コメント50',
        'color-.*' => '色',
        'order-.*' => 'レコード順',
    ],


];
