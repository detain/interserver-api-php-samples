<?php
/** api_openTicket  -  (c)2015 detain@interserver.net InterServer Hosting
* This command creates a new ticket in our system.
* @param sid string the *Session ID* you get from the [login](#login) call
* @param user_email string client email address
* @param user_ip string client ip address
* @param subject string subject of the ticket
* @param product string the product/service if any this is in reference to.
* @param body string full content/description for the ticket
* @param box_auth_value string encryption string?
*/
ini_set("soap.wsdl_cache_enabled", "0");
$username = $_SERVER['argv'][1];
$password = $_SERVER['argv'][2];
$user_email = $_SERVER['argv'][3];
$user_ip = $_SERVER['argv'][4];
$subject = $_SERVER['argv'][5];
$product = $_SERVER['argv'][6];
$body = $_SERVER['argv'][7];
$box_auth_value = $_SERVER['argv'][8];
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	//break;
} 
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
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
	$sid = $client->api_login($username, $password);
	if (strlen($sid) == 0)
		die("Got A Blank Session");
	$res = $client->api_openTicket($sid, $user_email, $user_ip, $subject, $product, $body, $box_auth_value);
	echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
	echo "Exception Occurred!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>