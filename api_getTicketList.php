<?php
/** api_getTicketList  -  (c)2015 detain@interserver.net InterServer Hosting
* Returns a list of any tickets in the system.
* @param sid string the *Session ID* you get from the [login](#login) call
* @param page int page number of tickets to list
* @param limit int how many tickets to show per page
* @param status string null for no status limit or limit to a specific status
*/
ini_set("soap.wsdl_cache_enabled", "0");
$username = $_SERVER['argv'][1];
$password = $_SERVER['argv'][2];
$page = $_SERVER['argv'][3];
$limit = $_SERVER['argv'][4];
$status = $_SERVER['argv'][5];
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	//break;
} 
if ($_SERVER['argc'] < 6)
	$show_help = true;
if ($show_help == true)
	exit(<<<EOF
api_getTicketList

Returns a list of any tickets in the system.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <page> <limit> <status>

  <username>  Your Login name with the site
  <password>  Your password used to login with the site
  <page>  Must be a int
  <limit>  Must be a int
  <status>  Must be a string

EOF
); 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
	$sid = $client->api_login($username, $password);
	if (strlen($sid) == 0)
		die("Got A Blank Session");
	$res = $client->api_getTicketList($sid, $page, $limit, $status);
	echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
	echo "Exception Occurred!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>