/** 
*   api_add_dns_record  -  (c)2015 detain@interserver.net InterServer Hosting
*
* Adds a single DNS record
*
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param domain_id int The ID of the domain in question.
* @param name string the hostname being set on the dns record.
* @param content string the value of the dns record, or what its set to.
* @param type string dns record type.
* @param ttl int dns record time to live, or update time.
* @param prio int dns record priority
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$cmdfields[] = 'username';
$cmdfields[] = 'password';
$cmdfields[] = 'domain_id';
$cmdfields[] = 'name';
$cmdfields[] = 'content';
$cmdfields[] = 'type';
$cmdfields[] = 'ttl';
$cmdfields[] = 'prio';
for ($x = 1; $x < $_SERVER['argc']; $x++) 

	if (in_array($_SERVER['argv'][$x], array('--help', '-h', 'help')))
	{
		$show_help = true;
		break;
	}
	else
		$values[$fields[$x - 1]] = $_SERVER['argv'][$x]; 

	if ($_SERVER['argc'] < 9)
		$show_help = true;
	if ($show_help == true)
		exit(<<<EOF
api_add_dns_record

Adds a single DNS record

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <domain_id> <name> <content> <type> <ttl> <prio>

	<username>  Your Login name with the site
	<password>  Your password used to login with the site
	<domain_id>  Must be a int
	<name>  Must be a string
	<content>  Must be a string
	<type>  Must be a string
	<ttl>  Must be a int
	<prio>  Must be a int

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$values['sid'] = $sid;
	$response = $client->api_add_dns_record($values['sid'], $values['domain_id'], $values['name'], $values['content'], $values['type'], $values['ttl'], $values['prio']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 