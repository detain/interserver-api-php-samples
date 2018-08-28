<?php
/** get_vps_slice_types  -  (c)2015 detain@interserver.net InterServer Hosting
* We have several types of Servers available for use with VPS Hosting. You can get
* a list of the types available and  there cost per slice/unit by making a call to
* this function
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
get_vps_slice_types

We have several types of Servers available for use with VPS Hosting. You can get
* a list of the types available and  there cost per slice/unit by making a call to
* this function

Correct Syntax: {$_SERVER["argv"][0]} 


EOF
); 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
	$res = $client->get_vps_slice_types();
	echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
	echo "Exception Occurred!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>