<?php
/** api_getTicketList  -  (c)2015 detain@interserver.net InterServer Hosting
* Returns a list of any tickets in the system.
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param page int page number of tickets to list
* @param limit int how many tickets to show per page
* @param status string null for no status limi t or limit to a speicifc status
*/
ini_set("soap.wsdl_cache_enabled", "0");
$values['username'] = $_SERVER['argv'][0];
$values['password'] = $_SERVER['argv'][1];
$values['page'] = $_SERVER['argv'][2];
$values['limit'] = $_SERVER['argv'][3];
$values['status'] = $_SERVER['argv'][4];
$show_help = false;

if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	break;
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

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$response = $client->api_getTicketList($sid, $page, $limit, $status);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>