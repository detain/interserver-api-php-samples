<?php
/** 
*   api_api_validate_buy_vps  -  (c)2015 detain@interserver.net InterServer Hosting
*
* Checks if the parameters for your order pass validation and let you know if
* there are any errors. It will also give you information on the pricing
* breakdown.
*
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param os string file field from [get_vps_templates](#get_vps_templates)
* @param slices int 1 to 16 specifying the scale of the VPS resources you want (a 3 slice has 3x the resources of a 1 slice vps)
* @param platform string platform field from the [get_vps_platforms_array](#get_vps_platforms_array)
* @param controlpanel string none, cpanel, or da for None, cPanel, or DirectAdmin control panel addons, only availbale with CentOS
* @param period int 1-36, How frequently to be billed in months. Some discounts as given based on the period
* @param location int id field from the [get_vps_locations_array](#get_vps_locations_array)
* @param version string os field from [get_vps_templates](#get_vps_templates)
* @param hostname string Desired Hostname for the VPS
* @param coupon string Optional Coupon to pass
* @param rootpass string Desired Root Password (unused for windows, send a blank string)
*/
ini_set("soap.wsdl_cache_enabled", "0");
$fields = array();
$cmdfields = array();
$values = array();
$show_help = false;
$fields = array('sid', 'os', 'slices', 'platform', 'controlpanel', 'period', 'location', 'version', 'hostname', 'coupon', 'rootpass');
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
$cmdfields = array('
Warning: implode(): Invalid arguments passed in /home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php on line 58

Call Stack:
    0.0012     339968   1. {main}() /home/detain/myadmin/cpaneldirect/trunk/scripts/api/map_api_to_samples.php:0
    7.5262   21604576   2. Smarty->fetch() /home/detain/myadmin/cpaneldirect/trunk/scripts/api/map_api_to_samples.php:435
    7.5266   21671264   3. include('/home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php') /home/detain/myadmin/cpaneldirect/trunk/vendor/Smarty2/libs/Smarty.class.php:1264
    7.5270   21671472   4. implode() /home/detain/myadmin/cpaneldirect/trunk/include/rendering/smarty_templates_c/%%CE^CED^CEDF5139%%api_generator_php.tpl.php:58

');
for ($x = 1; $x < $_SERVER['argc']; $x++) 

	if (in_array($_SERVER['argv'][$x], array('--help', '-h', 'help')))
	{
		$show_help = true;
		break;
	}
	else
		$values[$fields[$x - 1]] = $_SERVER['argv'][$x]; 

	if ($_SERVER['argc'] < 13)
		$show_help = true;
	if ($show_help == true)
		exit(<<<EOF
api_api_validate_buy_vps

Checks if the parameters for your order pass validation and let you know if
* there are any errors. It will also give you information on the pricing
* breakdown.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <os> <slices> <platform> <controlpanel> <period> <location> <version> <hostname> <coupon> <rootpass>

	<username>  Your Login name with the site
	<password>  Your password used to login with the site
	<os>  Must be a string
	<slices>  Must be a int
	<platform>  Must be a string
	<controlpanel>  Must be a string
	<period>  Must be a int
	<location>  Must be a int
	<version>  Must be a string
	<hostname>  Must be a string
	<coupon>  Must be a string
	<rootpass>  Must be a string

EOF
); 

try {
	$client = new SoapClient("https://my.interserver.net/api.php?wsdl"); 
	$sid = $client->api_login($values['username'], $values['password']);
	if (strlen($sid)  == 0) die("Got A Blank Sessoion");
	echo "Got Session ID $sid\n";
	$values['sid'] = $sid;
	$response = $client->api_api_validate_buy_vps($values['sid'], $values['os'], $values['slices'], $values['platform'], $values['controlpanel'], $values['period'], $values['location'], $values['version'], $values['hostname'], $values['coupon'], $values['rootpass']);
	print_r($response);
	echo "Success\n";
 } catch (Exception $ex) {
	echo "Exception Occured!\n";
	echo "Code:{$ex->faultcode}\n";
	echo "String:{$ex->faultstring}\n";
}; 
?>