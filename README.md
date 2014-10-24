# Overview

This plugin allows you to add environment-specific template code.

# Usage
## Parameters:

__"name":__ Specify the environment name. This should be set in EE's config by specifying a name and associated IP address(es). Multiple IP's can be set by a pipe delimiter.

__"ip":__ Specify an IP address instead of an environment name.

## Methods:
__"get":__ Gets the current environment name. If an environment name is not configured for the current IP address, it will return the IP address.

## Examples:
_config.php:_
	$conf['pr_env']['local'] = '127.0.0.1';

_template:_
	{exp:env name="local"} [code] {/exp:env}
	{exp:env ip="127.0.0.1"} [code] {/exp:env}
	{exp:env:get}
