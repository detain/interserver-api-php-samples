<?php
/** get_hostname  -  (c)2015 detain@interserver.net InterServer Hosting
* Resolves an IP Address and returns the hostname it points to.
* @param ip string IP Address
*/
ini_set("soap.wsdl_cache_enabled", "0");
$values['ip'] = $_SERVER['argv'][0];
$show_help = false;

if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	break;
}

if ($_SERVER['argc'] < 2)
	$show_help = true;
if ($show_help == true)
	exit(<<<EOF
get_hostname

Resolves an IP Address and returns the hostname it points to.

Correct Syntax: {$_SERVER["argv"][0]}  <ip>

	<ip>  Must be a string

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$response = $client->get_hostname($ip);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>