/** 
*   api_quickservers_get_client_invoices  -  (c)2015 detain@interserver.net InterServer Hosting
*
* This Function Applies to the QuickServers services.
* Gets a list of all the invoices.
*
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$cmdfields[] = 'username';
$cmdfields[] = 'password';
for ($x = 1; $x < $_SERVER['argc']; $x++) 

	if (in_array($_SERVER['argv'][$x], array('--help', '-h', 'help')))
	{
		$show_help = true;
		break;
	}
	else
		$values[$fields[$x - 1]] = $_SERVER['argv'][$x]; 

	if ($_SERVER['argc'] < 3)
		$show_help = true;
	if ($show_help == true)
		exit(<<<EOF
api_quickservers_get_client_invoices

This Function Applies to the QuickServers services.
* Gets a list of all the invoices.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password>

	<username>  Your Login name with the site
	<password>  Your password used to login with the site

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$values['sid'] = $sid;
	$response = $client->api_quickservers_get_client_invoices($values['sid']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
