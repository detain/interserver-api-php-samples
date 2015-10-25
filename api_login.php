/** 
*   api_login  -  (c)2015 detain@interserver.net InterServer Hosting
*
* This function creates a session in our system which you will need to pass to
* most functions for authentication.
*
* @param username string the username (email address) you signed up with.
* @param password string the password you use to login to the web account, or alternatively the API key.
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
api_login

This function creates a session in our system which you will need to pass to
* most functions for authentication.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password>

	<username>  Must be a string
	<password>  Must be a string

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$response = $client->api_login($values['username'], $values['password']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
