<?php
/** api_get_prepay_paypal_fill_url  -  (c)2015 detain@interserver.net InterServer Hosting
* Gets a PayPal URL to fill a PrePay.
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param module string the module the prepay is for. use [get_modules](#get_modules) to get a list of modules
* @param prepay_id int the ID of the PrePay
* @param amount float the amount to pay on the prepay.
*/
ini_set("soap.wsdl_cache_enabled", "0");
$values['username'] = $_SERVER['argv'][0];
$values['password'] = $_SERVER['argv'][1];
$values['module'] = $_SERVER['argv'][2];
$values['prepay_id'] = $_SERVER['argv'][3];
$values['amount'] = $_SERVER['argv'][4];
$show_help = false;

if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	break;
}

if ($_SERVER['argc'] < 6)
	$show_help = true;
if ($show_help == true)
	exit(<<<EOF
api_get_prepay_paypal_fill_url

Gets a PayPal URL to fill a PrePay.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <module> <prepay_id> <amount>

	<username>  Your Login name with the site
	<password>  Your password used to login with the site
	<module>  Must be a string
	<prepay_id>  Must be a int
	<amount>  Must be a float

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$response = $client->api_get_prepay_paypal_fill_url($sid, $module, $prepay_id, $amount);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>