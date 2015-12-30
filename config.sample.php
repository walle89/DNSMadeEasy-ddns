<?php
$config = array(

	// General settings
	'username'  => 'username-or-email',
	'password'  => 'ddns-password',
	'recordIDs' => array(
		'example.com'     => 1007, // Record ID / Dynamic DNS ID
		'www.example.com' => 1008, // Only one domain? Delete this row.
	),

	// Cache
	'cache' => array(
		'enabled'   => true,       // If true, the IP address and Record IDs will be saved to a cache. The cache is used to determine if an dns record update is needed.
	    'expire'    => 7*24*60*60, // Time in seconds when the cache expires and make a force update. Set 0 to disable
	    'filepath'  => __DIR__.'/cache/cache.txt',
	),
);

define('EXTERNAL_IP_SERVICE', 'http://myip.dnsmadeeasy.com');
define('UPDATE_IP_URL', 'https://cp.dnsmadeeasy.com/servlet/updateip');