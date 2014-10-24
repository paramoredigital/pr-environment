<?php  if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 * @package ExpressionEngine
 * @author ExpressionEngine Dev Team
 * @copyright Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license http://expressionengine.com/user_guide/license.html
 * @link http://expressionengine.com
 * @since Version 2.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * PR Environment Plugin
 * @package ExpressionEngine
 * @subpackage Addons
 * @category Plugin
 * @author Ben Wilkins
 * @link http://paramoredigital.com
 */

$plugin_info = array(
  'pi_name'        => 'PR Environment',
  'pi_version'     => '1.0',
  'pi_author'      => 'Ben Wilkins',
  'pi_author_url'  => 'http://paramoredigital.com',
  'pi_description' => 'Allows you to add environment-specific template code',
  'pi_usage'       => Env::usage()
);

class Env
{

	/**
	 * @var string
	 */
	public $return_data;

	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var string
	 */
	const DELIMITER = '|';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->config = ee()->config->item('pr_env');
		$this->return_data = ($this->does_match_environment())
		  ? ee()->TMPL->tagdata
		  : '';
	}

	/**
	 * @return string
	 */
	public function get()
	{
		$env = $this->server_ip_address();

		foreach ($this->config as $name => $ip) {
			if (in_array($this->server_ip_address(), explode(self::DELIMITER, $ip))) {
				$env = $name;
			}
		}

		return $env;
	}

	/**
	 * @return bool
	 */
	private function does_match_environment()
	{
		return (in_array($this->server_ip_address(), $this->environment_ip_addresses()));
	}

	/**
	 * @return string
	 */
	private static function server_ip_address()
	{
		return $_SERVER['SERVER_ADDR'];
	}

	/**
	 * @return array
	 */
	private function environment_ip_addresses()
	{
		$name = ee()->TMPL->fetch_param('name');

		return (isset($this->config[$name]))
		  ? explode(self::DELIMITER, $this->config[$name])
		  : explode(self::DELIMITER, ee()->TMPL->fetch_param('ip'));
	}

	// ----------------------------------------------------------------

	/**
	 * Plugin Usage
	 */
	public static function usage()
	{
		ob_start();
		?>

		Parameters:
		===============

		"name":
		Specify the environment name. This should be set in EE's config by specifying a name and associated IP address(es). Multiple IP's can be set by a pipe delimiter.

		"ip": Specify an IP address instead of an environment name.

		Methods:
		===============
		"get": Gets the current environment name. If an environment name is not configured for the current IP address, it will return the IP address.

		Examples:
		===============
		config.php:
		$conf['pr_env']['local'] = '127.0.0.1';

		template:
		{exp:env name="local"} [code] {/exp:env}
		{exp:env ip="127.0.0.1"} [code] {/exp:env}
		{exp:env:get}
		<?php
		$buffer = ob_get_contents();
		ob_end_clean();

		return $buffer;
	}
}


/* End of file pi.env.php */
/* Location: /system/expressionengine/third_party/env/pi.env.php */