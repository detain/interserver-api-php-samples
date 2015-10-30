<?php
/** 
*   api_get_license_types  -  (c)2015 detain@interserver.net InterServer Hosting
*
* Get a license of the various license types.
*
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$fields = array('');
$cmdfields = array('
Warning: implode(): Invalid arguments passed in /home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php on line 58

Call Stack:
    0.0011     339968   1. {main}() /home/detain/myadmin/cpaneldirect/trunk/scripts/api/map_api_to_samples.php:0
    2.9317   21411040   2. Smarty->fetch() /home/detain/myadmin/cpaneldirect/trunk/scripts/api/map_api_to_samples.php:435
    2.9324   21477480   3. include('/home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php') /home/detain/myadmin/cpaneldirect/trunk/vendor/Smarty2/libs/Smarty.class.php:1264
    2.9325   21477704   4. implode() /home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php:58

');
for ($x = 1; $x < $_SERVER['argc']; $x++) 

	if (in_array($_SERVER['argv'][$x], array('--help', '-h', 'help')))
	{
		$show_help = true;
		break;
	}
	else
		$values[$fields[$x - 1]] = $_SERVER['argv'][$x]; 

	if ($_SERVER['argc'] < 1)
		$show_help = true;
	if ($show_help == true)
		exit(<<<EOF
api_get_license_types

Get a license of the various license types.

Correct Syntax: {$_SERVER["argv"][0]} 


EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$response = $client->api_get_license_types();
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>