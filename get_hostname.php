<?php
/** 
*   get_hostname  -  (c)2015 detain@interserver.net InterServer Hosting
*
* Resolves an IP Address and returns the hostname it points to.
*
* @param ip string IP Address
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$cmdfields[] = 'ip';
for ($x = 1; $x < $_SERVER['argc']; $x++) 

	if (in_array($_SERVER['argv'][$x], array('--help', '-h', 'help')))
	{
		$show_help = true;
		break;
	}
	else
		$values[$fields[$x - 1]] = $_SERVER['argv'][$x]; 

	if ($_SERVER['argc'] < 2)
		$show_help = true;
	if ($show_help == true)
		exit(<<<EOF
get_hostname

Resolves an IP Address and returns the hostname it points to.

Correct Syntax: {$_SERVER["argv"][0]}  <ip>

	<ip>  Must be a string

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$response = $client->get_hostname($values['ip']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>