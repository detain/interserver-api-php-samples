<?php
/** api_make_payment  -  (c)2015 detain@interserver.net InterServer Hosting
* Makes a payment for an invoice on a module.
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param module string the module of the service being paid on
* @param invoice int the invoice id you want to make a payment on
*/
ini_set("soap.wsdl_cache_enabled", "0");
$values['username'] = $_SERVER['argv'][0];
$values['password'] = $_SERVER['argv'][1];
$values['module'] = $_SERVER['argv'][2];
$values['invoice'] = $_SERVER['argv'][3];
$show_help = false;

if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	break;
}

if ($_SERVER['argc'] < 5)
	$show_help = true;
if ($show_help == true)
	exit(<<<EOF
api_make_payment

Makes a payment for an invoice on a module.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <module> <invoice>

	<username>  Your Login name with the site
	<password>  Your password used to login with the site
	<module>  Must be a string
	<invoice>  Must be a int

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$response = $client->api_make_payment($sid, $module, $invoice);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>