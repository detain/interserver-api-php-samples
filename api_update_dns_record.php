<?php
/** 
*   api_update_dns_record  -  (c)2015 detain@interserver.net InterServer Hosting
*
* Updates a single DNS record
*
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param domain_id int The ID of the domain in question.
* @param record_id int The ID of the record to update
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
$fields = array('sid', 'domain_id', 'record_id', 'name', 'content', 'type', 'ttl', 'prio');
$cmdfields[] = 'username';
$cmdfields[] = 'password';
$cmdfields[] = 'domain_id';
$cmdfields[] = 'record_id';
$cmdfields[] = 'name';
$cmdfields[] = 'content';
$cmdfields[] = 'type';
$cmdfields[] = 'ttl';
$cmdfields[] = 'prio';
$cmdfields = array('
Warning: implode(): Invalid arguments passed in /home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php on line 54

Call Stack:
    0.0011     339968   1. {main}() /home/detain/myadmin/cpaneldirect/trunk/scripts/api/map_api_to_samples.php:0
    7.7703   21645240   2. Smarty->fetch() /home/detain/myadmin/cpaneldirect/trunk/scripts/api/map_api_to_samples.php:435
    7.7707   21707312   3. include('/home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php') /home/detain/myadmin/cpaneldirect/trunk/vendor/Smarty2/libs/Smarty.class.php:1264
    7.7710   21707536   4. implode() /home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php:54

');
for ($x = 1; $x < $_SERVER['argc']; $x++) 

	if (in_array($_SERVER['argv'][$x], array('--help', '-h', 'help')))
	{
		$show_help = true;
		break;
	}
	else
		$values[$fields[$x - 1]] = $_SERVER['argv'][$x]; 

	if ($_SERVER['argc'] < 10)
		$show_help = true;
	if ($show_help == true)
		exit(<<<EOF
api_update_dns_record

Updates a single DNS record

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <domain_id> <record_id> <name> <content> <type> <ttl> <prio>

	<username>  Your Login name with the site
	<password>  Your password used to login with the site
	<domain_id>  Must be a int
	<record_id>  Must be a int
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
	$response = $client->api_update_dns_record($values['sid'], $values['domain_id'], $values['record_id'], $values['name'], $values['content'], $values['type'], $values['ttl'], $values['prio']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>