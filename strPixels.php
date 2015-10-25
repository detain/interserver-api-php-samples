/** 
*   strPixels  -  (c)2015 detain@interserver.net InterServer Hosting
*
* This function uses the array below to calculate the pixel width of a string of
* characters. The widths of each character are based on a 12px Helvetica font. 
* Kerning is not taken into account so RESULTS ARE APPROXIMATE.  The purpose is to
* return a relative size to help in formatting. For example, strPixels('I like
* cake') == 54    strPixels('I LIKE CAKE') == 67
*
* @param string string characters to measure size
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$cmdfields[] = 'string';
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
strPixels

This function uses the array below to calculate the pixel width of a string of
* characters. The widths of each character are based on a 12px Helvetica font. 
* Kerning is not taken into account so RESULTS ARE APPROXIMATE.  The purpose is to
* return a relative size to help in formatting. For example, strPixels('I like
* cake') == 54    strPixels('I LIKE CAKE') == 67

Correct Syntax: {$_SERVER["argv"][0]}  <string>

	<string>  Must be a string

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$response = $client->strPixels($values['string']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
