<?php
/** 
*   api_openTicket  -  (c)2015 detain@interserver.net InterServer Hosting
*
* This command creates a new ticket in our system.  
*
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param user_email string client email address
* @param user_ip string client ip address
* @param subject string subject of the ticket
* @param product string the product/service if any this is in reference to.  
* @param body string full content/description for the ticket
* @param box_auth_value string encryption string?
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$fields = array('sid', 'user_email', 'user_ip', 'subject', 'product', 'body', 'box_auth_value');
$cmdfields[] = 'username';
$cmdfields[] = 'password';
$cmdfields[] = 'user_email';
$cmdfields[] = 'user_ip';
$cmdfields[] = 'subject';
$cmdfields[] = 'product';
$cmdfields[] = 'body';
$cmdfields[] = 'box_auth_value';
$cmdfields = array('
Warning: implode(): Invalid arguments passed in /home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php on line 54

Call Stack:
    0.0011     339968   1. {main}() /home/detain/myadmin/cpaneldirect/trunk/scripts/api/map_api_to_samples.php:0
    3.0243   21498000   2. Smarty->fetch() /home/detain/myadmin/cpaneldirect/trunk/scripts/api/map_api_to_samples.php:435
    3.0247   21560072   3. include('/home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php') /home/detain/myadmin/cpaneldirect/trunk/vendor/Smarty2/libs/Smarty.class.php:1264
    3.0249   21560296   4. implode() /home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php:54

');
for ($x = 1; $x < $_SERVER['argc']; $x++) 

	if (in_array($_SERVER['argv'][$x], array('--help', '-h', 'help')))
	{
		$show_help = true;
		break;
	}
	else
		$values[$fields[$x - 1]] = $_SERVER['argv'][$x]; 

	if ($_SERVER['argc'] < 9)
		$show_help = true;
	if ($show_help == true)
		exit(<<<EOF
api_openTicket

This command creates a new ticket in our system.  

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <user_email> <user_ip> <subject> <product> <body> <box_auth_value>

	<username>  Your Login name with the site
	<password>  Your password used to login with the site
	<user_email>  Must be a string
	<user_ip>  Must be a string
	<subject>  Must be a string
	<product>  Must be a string
	<body>  Must be a string
	<box_auth_value>  Must be a string

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$values['sid'] = $sid;
	$response = $client->api_openTicket($values['sid'], $values['user_email'], $values['user_ip'], $values['subject'], $values['product'], $values['body'], $values['box_auth_value']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>