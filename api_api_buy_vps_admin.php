<?php
/** 
*   api_api_buy_vps_admin  -  (c)2015 detain@interserver.net InterServer Hosting
*
* Purchase a VPS (admins only).   Returns a comma seperated list of invoices if
* any need paid.  Same as client function but allows specifying which server to
* install to if there are resources available on the specified server.
*
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param os string 
* @param slices int 
* @param platform string 
* @param controlpanel string 
* @param period int 
* @param location int 
* @param version int 
* @param hostname string 
* @param coupon string 
* @param rootpass string 
* @param server int 
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
$cmdfields[] = 'server';
for ($x = 1; $x < $_SERVER['argc']; $x++) 

	if (in_array($_SERVER['argv'][$x], array('--help', '-h', 'help')))
	{
		$show_help = true;
		break;
	}
	else
		$values[$fields[$x - 1]] = $_SERVER['argv'][$x]; 

	if ($_SERVER['argc'] < 14)
		$show_help = true;
	if ($show_help == true)
		exit(<<<EOF
api_api_buy_vps_admin

Purchase a VPS (admins only).   Returns a comma seperated list of invoices if
* any need paid.  Same as client function but allows specifying which server to
* install to if there are resources available on the specified server.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <os> <slices> <platform> <controlpanel> <period> <location> <version> <hostname> <coupon> <rootpass> <server>

	<username>  Your Login name with the site
	<password>  Your password used to login with the site
	<os>  Must be a string
	<slices>  Must be a int
	<platform>  Must be a string
	<controlpanel>  Must be a string
	<period>  Must be a int
	<location>  Must be a int
	<version>  Must be a int
	<hostname>  Must be a string
	<coupon>  Must be a string
	<rootpass>  Must be a string
	<server>  Must be a int

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$values['sid'] = $sid;
	$response = $client->api_api_buy_vps_admin($values['sid'], $values['os'], $values['slices'], $values['platform'], $values['controlpanel'], $values['period'], $values['location'], $values['version'], $values['hostname'], $values['coupon'], $values['rootpass'], $values['server']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>