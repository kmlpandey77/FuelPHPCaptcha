# Captcha for FuelPHP package

## Installation

Download the package and extract it into `fuel/packages/captcha/`

Add `captcha` on always_load in `app/config/config.php` or use `Package::load('captcha')`

## Basic Usage

### Forging a Captcha Instance
To get a Captcha instance:
```php
Captcha::forge();
```
### Captcha::forge()->check();
Checks to see if the user entered the correct captcha key

### Captcha::forge()->image();
Returns a Captcha Image response object

## Captcha_Route
You will want to add a path to a controller action which returns
```php
class Controller_Captcha extends Controller_Template
{

	public function action_index()
	{
		return Captcha::forge()->image();
	}

}

//End of captcha.php
```

## Use in views
```html
<img src="<?php echo Uri::create('captcha'); ?>" alt="captcha">
<input type="test" name="captcha">
```
