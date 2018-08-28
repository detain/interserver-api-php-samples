<?php
/** get_vps_platforms_array  -  (c)2015 detain@interserver.net InterServer Hosting
* Use this function to get a list of the various platforms available for ordering.
* The platform field in the return value is also needed to pass to the buy_vps
* functions.
*/
ini_set("soap.wsdl_cache_enabled", "0");
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	//break;
} 
if ($_SERVER['argc'] < 1)
	$show_help = true;
if ($show_help == true)
	exit(<<<EOF
get_vps_platforms_array

Use this function to get a list of the various platforms available for ordering.
* The platform field in the return value is also needed to pass to the buy_vps
* functions.

Correct Syntax: {$_SERVER["argv"][0]} 


EOF
); 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
	$res = $client->get_vps_platforms_array();
	echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
	echo "Exception Occurred!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>