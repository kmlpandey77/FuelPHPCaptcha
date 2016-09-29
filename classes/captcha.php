<?php

/**
 * Captcha package for FuelPHP
 * 
 * @package    FuelPHPCaptcha
 * @version    1.0
 * @author     Kamal Pandey
 * @license    MIT License 
 * @link       https://github.com/kmlpandey77/FuelPHPCaptcha
 * 
 * 
 */

namespace Captcha;

class CaptchaException extends \FuelException {}

class Captcha
{
	/**
	 * Default config
	 * @var array
	 */
	protected static $_defaults = array();

	/**
	* Driver config
	* @var array
	*/
	protected $config = array();

	/**
	 * Init
	 */
	public static function _init()
	{
		\Config::load('captcha', true);
	}

	/**
	 * Captcha driver forge.
	 *
	 * @param	array			$config		Config array
	 * @return  Captcha
	 */
	public static function forge($config = array())
	{
		$config = \Arr::merge(static::$_defaults, \Config::get('captcha', array()), $config);

		$class = new static($config);

		return $class;
	}

	/**
	* Driver constructor
	*
	* @param array $config driver config
	*/
	public function __construct(array $config = array())
	{
		$this->config = $config;
	}

	/**
	* Get a config setting.
	*
	* @param string $key the config key
	* @param mixed  $default the default value
	* @return mixed the config setting value
	*/
	public function get_config($key, $default = null)
	{
		return \Arr::get($this->config, $key, $default);
	}

	/**
	* Set a config setting.
	*
	* @param string $key the config key
	* @param mixed $value the new config value
	* @return object $this for chaining
	*/
	public function set_config($key, $value)
	{
		\Arr::set($this->config, $key, $value);

		return $this;
	}

	public function image()
	{
		$response = new \Response();
		$response->set_header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
		$response->set_header('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
		$response->set_header('Pragma', 'no-cache');

		$response->set_header('Content-Language', 'en');
		$response->set_header('Content-Type', 'image/jpeg');

		$image = $this->create();
		$response->body($image);
		
		return $response;
		imagedestroy($image);
	}

	public function create()
	{
		$md5 = md5(rand(0,9999));
		$pass = substr($md5, 10, 5);

		\Session::set($this->get_config('session_name'), $pass);

		$image = ImageCreatetruecolor(80, 20);		

		$clr_white = ImageColorAllocate($image, 250, 250, 250);
		$clr_black = ImageColorAllocate($image, 86, 86, 86);
		
		imagefill($image, 0, 0, $clr_black);
		

		imagestring($image, 15, 20, 3, $pass, $clr_white);

		return imagejpeg($image);
	}


	public static function check($value = null)
	{
		$captcha = self::forge();
		if($value == null)
			$value = \Input::post($captcha->get_config('post_name'));

		return \Session::get($captcha->get_config('session_name')) && \Session::get($captcha->get_config('session_name')) == $value;
			
	}
	
}
