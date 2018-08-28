<?php
/** get_locked_ips  -  (c)2015 detain@interserver.net InterServer Hosting
* This will return a list of all IP addresses used for fraud.   Its probably of no
* real use to anyone, butI use it to block IP addresses and similar things. 
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
get_locked_ips

This will return a list of all IP addresses used for fraud.   Its probably of no
* real use to anyone, butI use it to block IP addresses and similar things. 

Correct Syntax: {$_SERVER["argv"][0]} 


EOF
); 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
	$res = $client->get_locked_ips();
	echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
	echo "Exception Occurred!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>