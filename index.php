<?php
define('CONFIG_FILE_PATH', __DIR__.'/config.php');
define('MIN_PHP_VERSION','5.2.0');

if( version_compare(PHP_VERSION, MIN_PHP_VERSION, '<'))
	exit('Error: You are running this script with unsupported PHP version! The minimum PHP version requirement is '.MIN_PHP_VERSION.', you have '.phpversion());

if(!ini_get('allow_url_fopen') AND !function_exists('curl_version'))
	exit('Error: You have neither cURL installed nor allow_url_fopen enabled. Please setup one of those.');

if(!file_exists(CONFIG_FILE_PATH))
	exit('Error: config.php is missing! Make a copy of config.sample.php and change the settings.');

require_once ''.CONFIG_FILE_PATH.'';

function getContentURL($url)
{
	$content = null;
	if ( ini_get('allow_url_fopen') )
		$content = file_get_contents($url);

	elseif ( function_exists('curl_version') )
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$content = curl_exec($curl);
		curl_close($curl);
	}

	return $content;
}

$newRow = PHP_EOL;
if( php_sapi_name() != 'cli')
	$newRow = '<br>';

// External IP
$content    = file_get_contents(EXTERNAL_IP_SERVICE);
$ip         = filter_var($content, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);

if(empty($ip))
	exit('Error: Unable to get a valid external IP.');

$recordIDs = implode(',', $config['recordIDs']);

// Cache
if($config['cache']['enabled'])
{
	$pathInfo = pathinfo($config['cache']['filepath']);
	$cacheDir = $pathInfo['dirname'];

	// Cache folder
	if(!file_exists($cacheDir))
	{
		if(!mkdir($cacheDir, 0755, true))
			echo "Warning: Can not create cache folder. Check file permissions or manually create the cache folder.".$newRow;
	}

	if(is_writable($cacheDir))
	{
		$cacheContent = $ip.';'.$recordIDs;

		// Cache file exits
		if(file_exists($config['cache']['filepath']))
		{
			$forceUpdate = false;

			// Cache expire check
			if($config['cache']['expire'] > 0)
			{
				$lastMod = filemtime($config['cache']['filepath']);

				// Cache too old? Force update!
				if ((time() - $lastMod) > $config['cache']['expire'])
					$forceUpdate = true;
			}

			// No need to update? Terminate session
			if(!$forceUpdate AND file_get_contents($config['cache']['filepath']) == $cacheContent)
				exit;
		}
	}
	else
		echo "Warning: Can not write to cache. Check the permissions.".$newRow;
}

// Update!
$query = http_build_query(array(
	'username' => $config['username'],
	'password' => $config['password'],
	'id'       => $recordIDs,
	'ip'       => $ip,
));

$response = getContentURL(UPDATE_IP_URL.'?'.$query);

// Response check
if(empty($response))
	exit('Error: No response form DNS Made Easy Dynamic DNS service.');

elseif( !in_array($response, array( 'success', 'error-record-ip-same')) )
	exit('Error: From DNS Made Easy Dynamic DNS service: "'.$response.'".');

// Update chache
if ( $config['cache']['enabled'] AND file_put_contents($config['cache']['filepath'], $cacheContent) === false)
	echo "Warning: Can not write to cache file. Check file premissions.".$newRow;

// New IP-address message!
if( $response == 'success')
	echo 'Update succesful! New IP is: '.$ip.$newRow;