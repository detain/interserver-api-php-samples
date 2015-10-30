<?php
/** get_modules  -  (c)2015 detain@interserver.net InterServer Hosting
* Returns a list of all the modules available.
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
get_modules

Returns a list of all the modules available.

Correct Syntax: {$_SERVER["argv"][0]} 


EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$response = $client->get_modules();
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>