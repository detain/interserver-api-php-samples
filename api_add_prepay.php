<?php
/** 
*   api_add_prepay  -  (c)2015 detain@interserver.net InterServer Hosting
*
* Adds a PrePay into the system under the given module.    PrePays are a credit on
* your account by prefilling  your account with funds.   These are stored in a
* PrePay.    PrePay funds can be automaticaly used as needed or set to only be
* usable by direct action
*
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param module string the module the prepay is for. use [get_modules](#get_modules) to get a list of modules
* @param amount float the dollar amount of prepay total
* @param automatic_use bool wether or not the prepay will get used automatically by billing system.
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$fields = array('sid', 'module', 'amount', 'automatic_use');
$cmdfields[] = 'username';
$cmdfields[] = 'password';
$cmdfields[] = 'module';
$cmdfields[] = 'amount';
$cmdfields[] = 'automatic_use';
$cmdfields = array('
Warning: implode(): Invalid arguments passed in /home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php on line 54

Call Stack:
    0.0011     339968   1. {main}() /home/detain/myadmin/cpaneldirect/trunk/scripts/api/map_api_to_samples.php:0
    2.9317   21383488   2. Smarty->fetch() /home/detain/myadmin/cpaneldirect/trunk/scripts/api/map_api_to_samples.php:435
    2.9321   21445584   3. include('/home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php') /home/detain/myadmin/cpaneldirect/trunk/vendor/Smarty2/libs/Smarty.class.php:1264
    2.9323   21445808   4. implode() /home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php:54

');
for ($x = 1; $x < $_SERVER['argc']; $x++) 

	if (in_array($_SERVER['argv'][$x], array('--help', '-h', 'help')))
	{
		$show_help = true;
		break;
	}
	else
		$values[$fields[$x - 1]] = $_SERVER['argv'][$x]; 

	if ($_SERVER['argc'] < 6)
		$show_help = true;
	if ($show_help == true)
		exit(<<<EOF
api_add_prepay

Adds a PrePay into the system under the given module.    PrePays are a credit on
* your account by prefilling  your account with funds.   These are stored in a
* PrePay.    PrePay funds can be automaticaly used as needed or set to only be
* usable by direct action

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <module> <amount> <automatic_use>

	<username>  Your Login name with the site
	<password>  Your password used to login with the site
	<module>  Must be a string
	<amount>  Must be a float
	<automatic_use>  Must be a bool

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$values['sid'] = $sid;
	$response = $client->api_add_prepay($values['sid'], $values['module'], $values['amount'], $values['automatic_use']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>