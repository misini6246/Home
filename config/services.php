<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'web' => [
        'title' => '【今瑜e药网】 网上药品批发-重庆医药批发-药品采购-选择药易购方便快捷又安心“互联网药品交易许可证” 渝ICP备13004090号',
        'description' => '【今瑜e药网】',
        'keywords' => '药品价格,药品销售,采购药品,药品查询,网上药品批发,重庆药品批发，药物目录,OTC,医药公司,医院,药店,药品说明书,适应症，药厂，制药',
        'name' => '今瑜e药网'
    ],
];
