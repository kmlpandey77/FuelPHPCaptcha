<?php

Autoloader::add_core_namespace('Captcha');

Autoloader::add_classes(array(
	'Captcha\\Captcha' => __DIR__ . '/classes/captcha.php',
	'Captcha\\CaptchaException' => __DIR__ . '/classes/captcha.php',

));
