<?php
/** api_buy_license  -  (c)2015 detain@interserver.net InterServer Hosting
* Purchase a License.  Returns an invoice ID.
* @param sid string the *Session ID* you get from the [login](#login) call
* @param ip string ip address you wish to license some software on
* @param type int the package id of the license type you want. use [get_license_types](#get-license-types) to get a list of possible types.
* @param coupon string an optional coupon
*/
ini_set("soap.wsdl_cache_enabled", "0");
$username = $_SERVER['argv'][1];
$password = $_SERVER['argv'][2];
$ip = $_SERVER['argv'][3];
$type = $_SERVER['argv'][4];
$coupon = $_SERVER['argv'][5];
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	//break;
} 
if ($_SERVER['argc'] < 6)
	$show_help = true;
if ($show_help == true)
	exit(<<<EOF
api_buy_license

Purchase a License.  Returns an invoice ID.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <ip> <type> <coupon>

  <username>  Your Login name with the site
  <password>  Your password used to login with the site
  <ip>  Must be a string
  <type>  Must be a int
  <coupon>  Must be a string

EOF
); 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
	$sid = $client->api_login($username, $password);
	if (strlen($sid) == 0)
		die("Got A Blank Session");
	$res = $client->api_buy_license($sid, $ip, $type, $coupon);
	echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
	echo "Exception Occurred!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>