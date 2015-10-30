<?php
/** api_get_license_types  -  (c)2015 detain@interserver.net InterServer Hosting
* Get a license of the various license types.
*/
ini_set("soap.wsdl_cache_enabled", "0");
$show_help = false;

if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	break;
}

if ($_SERVER['argc'] < 1)
	$show_help = true;
if ($show_help == true)
	exit(<<<EOF
api_get_license_types

Get a license of the various license types.

Correct Syntax: {$_SERVER["argv"][0]} 


EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$response = $client->api_get_license_types();
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>