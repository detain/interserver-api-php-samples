<?php
/** api_ticketPost  -  (c)2015 detain@interserver.net InterServer Hosting
* This commands adds the content parameter as a response/reply to an existing
* ticket specified by ticketID.
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param ticketID string the id of the ticket to add a response to. you can use [api_getTicketList](#api_getTicketList) to get a list of your tickets 
* @param content string the message to add to the ticket
*/
ini_set("soap.wsdl_cache_enabled", "0");
$values['username'] = $_SERVER['argv'][0];
$values['password'] = $_SERVER['argv'][1];
$values['ticketID'] = $_SERVER['argv'][2];
$values['content'] = $_SERVER['argv'][3];
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

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$response = $client->api_ticketPost($sid, $ticketID, $content);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>