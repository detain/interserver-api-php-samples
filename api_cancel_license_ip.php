<?php
/** api_cancel_license_ip  -  (c)2015 detain@interserver.net InterServer Hosting
* Cancel a License by IP and Type.
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param ip string IP Address to cancel
* @param type int Package ID. use [api_get_license_types](#api_get_license_types) to get a list of possible types.
*/
ini_set("soap.wsdl_cache_enabled", "0");
$values['username'] = $_SERVER['argv'][0];
$values['password'] = $_SERVER['argv'][1];
$values['ip'] = $_SERVER['argv'][2];
$values['type'] = $_SERVER['argv'][3];
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
api_cancel_license_ip

Cancel a License by IP and Type.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <ip> <type>

	<username>  Your Login name with the site
	<password>  Your password used to login with the site
	<ip>  Must be a string
	<type>  Must be a int

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$response = $client->api_cancel_license_ip($sid, $ip, $type);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>