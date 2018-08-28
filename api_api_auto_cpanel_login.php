<?php
/** api_api_auto_cpanel_login  -  (c)2015 detain@interserver.net InterServer Hosting
* Logs into cpanel for the given website id and returns a unique logged-in url. 
* The status will be "ok" if successful, or "error" if there was any problems
* status_text will contain a description of the problem if any.
* @param sid string the *Session ID* you get from the [login](#login) call
* @param id int id of website
*/
ini_set("soap.wsdl_cache_enabled", "0");
$username = $_SERVER['argv'][1];
$password = $_SERVER['argv'][2];
$id = $_SERVER['argv'][3];
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	//break;
} 
if ($_SERVER['argc'] < 4)
	$show_help = true;
if ($show_help == true)
	exit(<<<EOF
api_api_auto_cpanel_login

Logs into cpanel for the given website id and returns a unique logged-in url. 
* The status will be "ok" if successful, or "error" if there was any problems
* status_text will contain a description of the problem if any.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <id>

  <username>  Your Login name with the site
  <password>  Your password used to login with the site
  <id>  Must be a int

EOF
); 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
	$sid = $client->api_login($username, $password);
	if (strlen($sid) == 0)
		die("Got A Blank Session");
	$res = $client->api_api_auto_cpanel_login($sid, $id);
	echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
	echo "Exception Occurred!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>