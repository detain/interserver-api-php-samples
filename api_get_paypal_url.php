<?php
/** api_get_paypal_url  -  (c)2015 detain@interserver.net InterServer Hosting
* Get the PayPal payment URL for an invoice on a given module.
* @param module string the module the invoice is for. use [get_modules](#get_modules) to get a list of modules
* @param invoice int the invoice id, or a comma separated list of invoice ids to get a payment url for.
*/
ini_set("soap.wsdl_cache_enabled", "0");
$module = $_SERVER['argv'][1];
$invoice = $_SERVER['argv'][2];
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	//break;
} 
if ($_SERVER['argc'] < 3)
	$show_help = true;
if ($show_help == true)
	exit(<<<EOF
api_get_paypal_url

Get the PayPal payment URL for an invoice on a given module.

Correct Syntax: {$_SERVER["argv"][0]}  <module> <invoice>

  <module>  Must be a string
  <invoice>  Must be a int

EOF
); 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
	$res = $client->api_get_paypal_url($module, $invoice);
	echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
	echo "Exception Occurred!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>