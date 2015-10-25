/** 
*   api_viewTicket  -  (c)2015 detain@interserver.net InterServer Hosting
*
* View/Retrieve information about the given ticketID.
*
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param ticketID string 
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$cmdfields[] = 'username';
$cmdfields[] = 'password';
$cmdfields[] = 'ticketID';
for ($x = 1; $x < $_SERVER['argc']; $x++) 

	if (in_array($_SERVER['argv'][$x], array('--help', '-h', 'help')))
	{
		$show_help = true;
		break;
	}
	else
		$values[$fields[$x - 1]] = $_SERVER['argv'][$x]; 

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

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$values['sid'] = $sid;
	$response = $client->api_viewTicket($values['sid'], $values['ticketID']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
