<?php
/** api_viewTicket  -  (c)2015 detain@interserver.net InterServer Hosting
* View/Retrieve information about the given ticketID.
* @param sid string the *Session ID* you get from the [login](#login) call
* @param ticketID string the id of the ticket to retrieve. you can use [getTicketList](#getticketlist) to get a list of your tickets
*/
ini_set("soap.wsdl_cache_enabled", "0");
$username = $_SERVER['argv'][1];
$password = $_SERVER['argv'][2];
$ticketID = $_SERVER['argv'][3];
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
api_viewTicket

View/Retrieve information about the given ticketID.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <ticketID>

  <username>  Your Login name with the site
  <password>  Your password used to login with the site
  <ticketID>  Must be a string

EOF
); 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
	$sid = $client->api_login($username, $password);
	if (strlen($sid) == 0)
		die("Got A Blank Session");
	$res = $client->api_viewTicket($sid, $ticketID);
	echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
	echo "Exception Occurred!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>