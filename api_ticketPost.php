<?php
/** api_ticketPost  -  (c)2015 detain@interserver.net InterServer Hosting
* This commands adds the content parameter as a response/reply to an existing
* ticket specified by ticketID.
* @param sid string the *Session ID* you get from the [login](#login) call
* @param ticketID string the id of the ticket to add a response to. you can use [getTicketList](#getticketlist) to get a list of your tickets
* @param content string the message to add to the ticket
*/
ini_set("soap.wsdl_cache_enabled", "0");
$username = $_SERVER['argv'][1];
$password = $_SERVER['argv'][2];
$ticketID = $_SERVER['argv'][3];
$content = $_SERVER['argv'][4];
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	//break;
} 
if ($_SERVER['argc'] < 5)
	$show_help = true;
if ($show_help == true)
	exit(<<<EOF
api_ticketPost

This commands adds the content parameter as a response/reply to an existing
* ticket specified by ticketID.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <ticketID> <content>

  <username>  Your Login name with the site
  <password>  Your password used to login with the site
  <ticketID>  Must be a string
  <content>  Must be a string

EOF
); 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
	$sid = $client->api_login($username, $password);
	if (strlen($sid) == 0)
		die("Got A Blank Session");
	$res = $client->api_ticketPost($sid, $ticketID, $content);
	echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
	echo "Exception Occurred!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>