<?php
/** api_cancel_license  -  (c)2015 detain@interserver.net InterServer Hosting
* Cancel a License.
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param id int License Order ID
*/
ini_set("soap.wsdl_cache_enabled", "0");
$values['username'] = $_SERVER['argv'][0];
$values['password'] = $_SERVER['argv'][1];
$values['id'] = $_SERVER['argv'][2];
$show_help = false;

if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	break;
}

if ($_SERVER['argc'] < 4)
	$show_help = true;
if ($show_help == true)
	exit(<<<EOF
api_cancel_license

Cancel a License.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <id>

	<username>  Your Login name with the site
	<password>  Your password used to login with the site
	<id>  Must be a int

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$response = $client->api_cancel_license($sid, $id);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>