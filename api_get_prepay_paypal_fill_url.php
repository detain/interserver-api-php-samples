<?php
/** 
*   api_get_prepay_paypal_fill_url  -  (c)2015 detain@interserver.net InterServer Hosting
*
* Gets a PayPal URL to fill a PrePay.
*
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param module string the module the prepay is for. use [get_modules](#get_modules) to get a list of modules
* @param prepay_id int the ID of the PrePay
* @param amount float the amount to pay on the prepay.
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$fields = array('sid', 'module', 'prepay_id', 'amount');
$cmdfields[] = 'username';
$cmdfields[] = 'password';
$cmdfields[] = 'module';
$cmdfields[] = 'prepay_id';
$cmdfields[] = 'amount';
$cmdfields = array('
Warning: implode(): Invalid arguments passed in /home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php on line 54

Call Stack:
    0.0011     339968   1. {main}() /home/detain/myadmin/cpaneldirect/trunk/scripts/api/map_api_to_samples.php:0
    2.9960   21453896   2. Smarty->fetch() /home/detain/myadmin/cpaneldirect/trunk/scripts/api/map_api_to_samples.php:435
    2.9964   21515968   3. include('/home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php') /home/detain/myadmin/cpaneldirect/trunk/vendor/Smarty2/libs/Smarty.class.php:1264
    2.9965   21516192   4. implode() /home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php:54

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
	$values['sid'] = $sid;
	$response = $client->api_get_prepay_paypal_fill_url($values['sid'], $values['module'], $values['prepay_id'], $values['amount']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>