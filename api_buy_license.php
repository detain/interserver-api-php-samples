<?php
/** 
*   api_buy_license  -  (c)2015 detain@interserver.net InterServer Hosting
*
* Purchase a License.  Returns an invoice ID.
*
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param ip string ip address you wish to license some software on
* @param type int the package id of the license type you want. use [api_get_license_types](#api_get_license_types) to get a list of possible types.
* @param coupon string an optional coupon
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$cmdfields[] = 'username';
$cmdfields[] = 'password';
$cmdfields[] = 'ip';
$cmdfields[] = 'type';
$cmdfields[] = 'coupon';
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
api_buy_license

Purchase a License.  Returns an invoice ID.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <ip> <type> <coupon>

	<username>  Your Login name with the site
	<password>  Your password used to login with the site
	<ip>  Must be a string
	<type>  Must be a int
	<coupon>  Must be a string

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$values['sid'] = $sid;
	$response = $client->api_buy_license($values['sid'], $values['ip'], $values['type'], $values['coupon']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>