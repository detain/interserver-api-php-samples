<?php
/** api_login  -  (c)2015 detain@interserver.net InterServer Hosting
* This function creates a session in our system which you will need to pass to
* most functions for authentication.
* @param username string the username (email address) you signed up with.
* @param password string the password you use to login to the web account, or alternatively the API key.
*/
ini_set("soap.wsdl_cache_enabled", "0");
$username = $_SERVER['argv'][1];
$password = $_SERVER['argv'][2];
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	//break;
} 
if ($_SERVER['argc'] < 3)
	$show_help = true;
if ($show_help == true)
	exit(<<<EOF
api_login

This function creates a session in our system which you will need to pass to
* most functions for authentication.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password>

  <username>  Must be a string
  <password>  Must be a string

EOF
); 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
	$res = $client->api_login($username, $password);
	echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
	echo "Exception Occurred!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>