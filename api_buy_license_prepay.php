<?php
/** api_buy_license_prepay  -  (c)2015 detain@interserver.net InterServer Hosting
* Purchase a License and optionally uses PrePay.  Will return an error if
* use_prepay is true not enough PrePay funds are available.
* @param sid string the *Session ID* you get from the [login](#login) call
* @param ip string ip address you wish to license some software on
* @param type int the package id of the license type you want. use [get_license_types](#get-license-types) to get a list of possible types.
* @param coupon string an optional coupon
* @param use_prepay bool optional, whether or not to use a prepay, if specified as true will return an error if not enough prepay
*/
ini_set("soap.wsdl_cache_enabled", "0");
$username = $_SERVER['argv'][1];
$password = $_SERVER['argv'][2];
$ip = $_SERVER['argv'][3];
$type = $_SERVER['argv'][4];
$coupon = $_SERVER['argv'][5];
$use_prepay = $_SERVER['argv'][6];
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	//break;
} 
if ($_SERVER['argc'] < 7)
	$show_help = true;
if ($show_help == true)
	exit(<<<EOF
api_buy_license_prepay

Purchase a License and optionally uses PrePay.  Will return an error if
* use_prepay is true not enough PrePay funds are available.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <ip> <type> <coupon> <use_prepay>

  <username>  Your Login name with the site
  <password>  Your password used to login with the site
  <ip>  Must be a string
  <type>  Must be a int
  <coupon>  Must be a string
  <use_prepay>  Must be a bool

EOF
); 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
	$sid = $client->api_login($username, $password);
	if (strlen($sid) == 0)
		die("Got A Blank Session");
	$res = $client->api_buy_license_prepay($sid, $ip, $type, $coupon, $use_prepay);
	echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
	echo "Exception Occurred!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>