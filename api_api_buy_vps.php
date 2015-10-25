/** 
*   api_api_buy_vps  -  (c)2015 detain@interserver.net InterServer Hosting
*
* Places a VPS order in our system. These are the same parameters as
* api_validate_buy_vps..   Returns a comma seperated list of invoices if any need
* paid.
*
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param os string 
* @param slices int 
* @param platform string 
* @param controlpanel string 
* @param period int 
* @param location int 
* @param version string 
* @param hostname string 
* @param coupon string 
* @param rootpass string 
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$cmdfields[] = 'username';
$cmdfields[] = 'password';
$cmdfields[] = 'os';
$cmdfields[] = 'slices';
$cmdfields[] = 'platform';
$cmdfields[] = 'controlpanel';
$cmdfields[] = 'period';
$cmdfields[] = 'location';
$cmdfields[] = 'version';
$cmdfields[] = 'hostname';
$cmdfields[] = 'coupon';
$cmdfields[] = 'rootpass';
for ($x = 1; $x < $_SERVER['argc']; $x++) 

	if (in_array($_SERVER['argv'][$x], array('--help', '-h', 'help')))
	{
		$show_help = true;
		break;
	}
	else
		$values[$fields[$x - 1]] = $_SERVER['argv'][$x]; 

	if ($_SERVER['argc'] < 13)
		$show_help = true;
	if ($show_help == true)
		exit(<<<EOF
api_api_buy_vps

Places a VPS order in our system. These are the same parameters as
* api_validate_buy_vps..   Returns a comma seperated list of invoices if any need
* paid.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <os> <slices> <platform> <controlpanel> <period> <location> <version> <hostname> <coupon> <rootpass>

	<username>  Your Login name with the site
	<password>  Your password used to login with the site
	<os>  Must be a string
	<slices>  Must be a int
	<platform>  Must be a string
	<controlpanel>  Must be a string
	<period>  Must be a int
	<location>  Must be a int
	<version>  Must be a string
	<hostname>  Must be a string
	<coupon>  Must be a string
	<rootpass>  Must be a string

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$values['sid'] = $sid;
	$response = $client->api_api_buy_vps($values['sid'], $values['os'], $values['slices'], $values['platform'], $values['controlpanel'], $values['period'], $values['location'], $values['version'], $values['hostname'], $values['coupon'], $values['rootpass']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
