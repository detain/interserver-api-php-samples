/** 
*   api_get_prepay_remaining  -  (c)2015 detain@interserver.net InterServer Hosting
*
* Get the PrePay amount available for a given module.
*
* @param module string the module you want to check your prepay amounts on
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$cmdfields[] = 'module';
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
api_get_prepay_remaining

Get the PrePay amount available for a given module.

Correct Syntax: {$_SERVER["argv"][0]}  <module>

	<module>  Must be a string

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$response = $client->api_get_prepay_remaining($values['module']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
