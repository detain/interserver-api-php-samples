<?php
/** 
*   api_getTicketList  -  (c)2015 detain@interserver.net InterServer Hosting
*
* Returns a list of any tickets in the system.
*
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param page int 
* @param limit int 
* @param status string 
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$cmdfields[] = 'username';
$cmdfields[] = 'password';
$cmdfields[] = 'page';
$cmdfields[] = 'limit';
$cmdfields[] = 'status';
for ($x = 1; $x < $_SERVER['argc']; $x++) 

	if (in_array($_SERVER['argv'][$x], array('--help', '-h', 'help')))
	{
		$show_help = true;
		break;
	}
	else
		$values[$fields[$x - 1]] = $_SERVER['argv'][$x]; 

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
	$values['sid'] = $sid;
	$response = $client->api_getTicketList($values['sid'], $values['page'], $values['limit'], $values['status']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>