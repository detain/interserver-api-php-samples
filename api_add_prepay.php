<?php
/** api_add_prepay  -  (c)2015 detain@interserver.net InterServer Hosting
* Adds a PrePay into the system under the given module.    PrePays are a credit on
* your account by prefilling  your account with funds.   These are stored in a
* PrePay.    PrePay funds can be automatically used as needed or set to only be
* usable by direct action
* @param sid string the *Session ID* you get from the [login](#login) call
* @param module string the module the prepay is for. use [get_modules](#get_modules) to get a list of modules
* @param amount float the dollar amount of prepay total
* @param automatic_use bool whether or not the prepay will get used automatically by billing system.
*/
ini_set("soap.wsdl_cache_enabled", "0");
$username = $_SERVER['argv'][1];
$password = $_SERVER['argv'][2];
$module = $_SERVER['argv'][3];
$amount = $_SERVER['argv'][4];
$automatic_use = $_SERVER['argv'][5];
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	//break;
} 
if ($_SERVER['argc'] < 6)
	$show_help = true;
if ($show_help == true)
	exit(<<<EOF
api_add_prepay

Adds a PrePay into the system under the given module.    PrePays are a credit on
* your account by prefilling  your account with funds.   These are stored in a
* PrePay.    PrePay funds can be automatically used as needed or set to only be
* usable by direct action

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <module> <amount> <automatic_use>

  <username>  Your Login name with the site
  <password>  Your password used to login with the site
  <module>  Must be a string
  <amount>  Must be a float
  <automatic_use>  Must be a bool

EOF
); 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
	$sid = $client->api_login($username, $password);
	if (strlen($sid) == 0)
		die("Got A Blank Session");
	$res = $client->api_add_prepay($sid, $module, $amount, $automatic_use);
	echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
	echo "Exception Occurred!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>