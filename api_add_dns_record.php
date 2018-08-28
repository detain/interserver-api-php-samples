<?php
/** api_add_dns_record  -  (c)2015 detain@interserver.net InterServer Hosting
* Adds a single DNS record
* @param sid string the *Session ID* you get from the [login](#login) call
* @param domain_id int The ID of the domain in question.
* @param name string the hostname being set on the dns record.
* @param content string the value of the dns record, or what its set to.
* @param type string dns record type.
* @param ttl int dns record time to live, or update time.
* @param prio int dns record priority
*/
ini_set("soap.wsdl_cache_enabled", "0");
$username = $_SERVER['argv'][1];
$password = $_SERVER['argv'][2];
$domain_id = $_SERVER['argv'][3];
$name = $_SERVER['argv'][4];
$content = $_SERVER['argv'][5];
$type = $_SERVER['argv'][6];
$ttl = $_SERVER['argv'][7];
$prio = $_SERVER['argv'][8];
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
	$show_help = true;
	//break;
} 
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
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
	$sid = $client->api_login($username, $password);
	if (strlen($sid) == 0)
		die("Got A Blank Session");
	$res = $client->api_add_dns_record($sid, $domain_id, $name, $content, $type, $ttl, $prio);
	echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
	echo "Exception Occurred!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>