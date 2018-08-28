<?php
/** api_add_dns_domain  -  (c)2015 detain@interserver.net InterServer Hosting
* Adds a new domain into our system.  The status will be "ok" if it added, or
* "error" if there was any problems status_text will contain a description of the
* problem if any.
* @param sid string the *Session ID* you get from the [login](#login) call
* @param domain string domain name to host
* @param ip string ip address to assign it to.
*/
ini_set("soap.wsdl_cache_enabled", "0");
$username = $_SERVER['argv'][1];
$password = $_SERVER['argv'][2];
$domain = $_SERVER['argv'][3];
$ip = $_SERVER['argv'][4];
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	//break;
} 
if ($_SERVER['argc'] < 5)
	$show_help = true;
if ($show_help == true)
	exit(<<<EOF
api_add_dns_domain

Adds a new domain into our system.  The status will be "ok" if it added, or
* "error" if there was any problems status_text will contain a description of the
* problem if any.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <domain> <ip>

  <username>  Your Login name with the site
  <password>  Your password used to login with the site
  <domain>  Must be a string
  <ip>  Must be a string

EOF
); 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
	$sid = $client->api_login($username, $password);
	if (strlen($sid) == 0)
		die("Got A Blank Session");
	$res = $client->api_add_dns_domain($sid, $domain, $ip);
	echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
	echo "Exception Occurred!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>