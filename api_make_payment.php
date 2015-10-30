<?php
/** 
*   api_make_payment  -  (c)2015 detain@interserver.net InterServer Hosting
*
* Makes a payment for an invoice on a module.
*
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param module string the module of the service being paid on
* @param invoice int the invoice id you want to make a payment on
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$fields = array('sid', 'module', 'invoice');
$cmdfields[] = 'username';
$cmdfields[] = 'password';
$cmdfields[] = 'module';
$cmdfields[] = 'invoice';
$cmdfields = array('
Warning: implode(): Invalid arguments passed in /home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php on line 58

Call Stack:
    0.0011     339968   1. {main}() /home/detain/myadmin/cpaneldirect/trunk/scripts/api/map_api_to_samples.php:0
    2.9838   21441000   2. Smarty->fetch() /home/detain/myadmin/cpaneldirect/trunk/scripts/api/map_api_to_samples.php:435
    2.9843   21507440   3. include('/home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php') /home/detain/myadmin/cpaneldirect/trunk/vendor/Smarty2/libs/Smarty.class.php:1264
    2.9844   21507664   4. implode() /home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php:58

');
for ($x = 1; $x < $_SERVER['argc']; $x++) 

	if (in_array($_SERVER['argv'][$x], array('--help', '-h', 'help')))
	{
		$show_help = true;
		break;
	}
	else
		$values[$fields[$x - 1]] = $_SERVER['argv'][$x]; 

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
	$values['sid'] = $sid;
	$response = $client->api_make_payment($values['sid'], $values['module'], $values['invoice']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>