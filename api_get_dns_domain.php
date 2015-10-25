/** 
*   api_get_dns_domain  -  (c)2015 detain@interserver.net InterServer Hosting
*
* Gets the DNS entry for a given Domain ID
*
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param domain_id int The ID of the domain in question.
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$cmdfields[] = 'username';
$cmdfields[] = 'password';
$cmdfields[] = 'domain_id';
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
api_get_dns_domain

Gets the DNS entry for a given Domain ID

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <domain_id>

	<username>  Your Login name with the site
	<password>  Your password used to login with the site
	<domain_id>  Must be a int

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$values['sid'] = $sid;
	$response = $client->api_get_dns_domain($values['sid'], $values['domain_id']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
