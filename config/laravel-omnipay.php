<?php

return [

	// The default gateway to use
	'default' => 'paypal',

	// Add in each gateway here
	'gateways' => [
		'paypal' => [
			'driver'  => 'PayPal_Express',
			'options' => [
				'solutionType'   => '',
				'landingPage'    => '',
				'headerImageUrl' => ''
			]
		],

        'unionpay' => [
            'driver' => 'UnionPay_Express',
            'options' => [
                'merId' => '777290058115007',
                'certPath' => '/path/to/storage/app/unionpay/certs/acp_test_sign.pfx',
                'certPassword' =>'000000',
                'certDir'=>'/path/to/storage/app/unionpay/certs',
                'returnUrl' => 'www.baidu.com',
                'notifyUrl' => 'www.baidu.com'
            ]
        ]
	]

];