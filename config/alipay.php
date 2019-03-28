<?php
return [


		//应用ID,您的APPID。
		'app_id' => "2016092500596037",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEAshDSPxgq4dERpttWGAcsu3z6ZiYlOdw616uwURfZkxksW8bYAS+ReXG5nw2IIyFshpEayOTxqSB+wsbIagRe2cxVvLZDe59QusVTEpiW5ew9a8bdO55kFdWNVTjdJK5rTsy/9puZPWkmXc4wvp9/8udiHW/y95kkJrLKLQkeizBc/PiT50VOtaoPvBiQPxrV8C+cLYdaikvKkSSOa5he6ahMwfHRxfEdJmepC051LFNQzH7Eh2FKBvHjyMRNh71jPu7RGsRO9MZteuGxqzc3fScLduS9kiuONAhkZlMJx5/vItEG3vs5ipzN73u5KJ+OFc58p6RmJGOokAVW/n2iLQIDAQABAoIBAQCrnN6khGw/urkicN2mxrNr9uV1MWpLO19SoFuLrEq7JFXGFfv0GJ5Bx0M4cVg1U28+ufZwi4YElBbXLbHVy2SG0BIJkDe1mzO47ZhEod88tNP1XXG2lc6r5GcULXukcJ1nEpon2Ip1zzN00NXVwe8Ucb/z0wL9chCPY1zKzrErPtOvD+MZXwBeR638DnlqGFOPZMzERIrCF7bWDJ6IkWk4rvc/TD5WnSaFRdPhuTmFwiKHbEwMgf3nhxu07xD/thO1rKRkl0GJ5Ip6Hp7Bj5zGk/iMXzDQuw3RSYeytvoC5sNyK4eyffuloJjEaWcmhY18IOqijcRLfoIEr4SUU0QZAoGBANe1YQCyQcXm5uUIpRv4GdYcw2A1Jf15RNRieqcrpu92yTDbuLZGAbOiS/aUnxNjQYIsElJO6rpI3UfDg7kI251Rqf/ZzcVqm02tEfQnEinCEZORdiSjBPNTC6OTHQn60hIAACPx5enI3OG703y72TJlbtm1geFm47j6gZ5LEpBLAoGBANNTdhJa2lT63A00LLS6GqHgeOMlnYoTzC4l5SHs4TUsXRIQxCMmAfyh9jGFZKu1ncAYGWzb8IIy94ksbyiAovgYw9L5sf3Att9hvGll5jSTHAWKoMs9v5staiZSLso4C5UiK+9krKcR1Eqy9qHdjX5aI4rnuZTCzlcmvvr4HDxnAoGAEHatgqoYTwyCjvSL9YiIIEltuAgWcDQzRqqFhgDU6u38CRicDn1lX9qBRb6uLYKj21WVyGZxj+pDyVho01STvnwfJ4HuLKUoWVNeTW41+q3vPX4asE0o8ZFjEAcIblyQcAND/3pU+/Tytt/pElocB7aqMT+jPBroQpQMFJLSReUCgYBG77ovmR227upU6FGlbN8pvX72yJakVdbxGrladPh37+dh/AzKu6RpGDjbEKrlVLaaV7yZJQ8LtW4QNsEteFi8LRv2wuhzhHAedeFYA+ONfGAooAsvjg+2WD1MlcOtD7kbm3fiCQpHnp2DYaWWWhd39Wv+4aATBn1bFd9/wS9BOwKBgQC2qhAcGfdz7jDVHPAhDJzqj5ZtbS0EES25V943Llaj141OZc7A6MS1Jlo7SFpDcMFHGOMedPfsGbDhUJv8sRvt+jki5loLm02Po10qTsjBrXBR8Ngsw2jP8EkIorlrxTr3QHiR/lYiM7syfqRVZVOhJ3hJ5O4ARZ6VQvHlC9wavg==",
		
		//异步通知地址
		'notify_url' => "http://工程公网访问地址/alipay.trade.wap.pay-PHP-UTF-8/notify_url.php",
		
		//同步跳转
		'return_url' => "http://mitsein.com/alipay.trade.wap.pay-PHP-UTF-8/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzXcR03lHdkBkiSmcVN/varO6M72U41YRSa4ECsbWMUpuX5+abf9+qD3HPhGwWhZNYL2hr7tAplbrn7hmRt+gmKf3Xl9Kwaq/u56v72skVWrNpBkRp004ytGvrbNxgVv++6p/mae3Zl2UAaxtV3MMnkVKmV2D/pHlnq0RXu/0C5M+8GIxHM0apoLY2aB25H0n4T1kcTQa65225d+E7ithrkn/1n46eCCD1n57/tBthoq3YxQ0pcCAMKItM/Z6Wy/ss84y/0CanHhKqUjKP/jub8LVyihj7yu3/Nu8TrybuTJnzaWewxh1VdnFeFSDRXgjWyQvWvgDJ1JUOkgWC6gvmwIDAQAB",
];