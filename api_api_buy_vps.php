<?php
/** api_api_buy_vps  -  (c)2015 detain@interserver.net InterServer Hosting
* Places a VPS order in our system. These are the same parameters as
* api_validate_buy_vps..   Returns a comma seperated list of invoices if any need
* paid.
* @param sid string the *Session ID* you get from the [login](#login) call
* @param os string file field from [get_vps_templates](#get_vps_templates)
* @param slices int 1 to 16 specifying the scale of the VPS resources you want (a 3 slice has 3x the resources of a 1 slice vps)
* @param platform string platform field from the [get_vps_platforms_array](#get_vps_platforms_array)
* @param controlpanel string none, cpanel, or da for None, cPanel, or DirectAdmin control panel addons, only available with CentOS
* @param period int 1-36, How frequently to be billed in months. Some discounts as given based on the period
* @param location int id field from the [get_vps_locations_array](#get_vps_locations_array)
* @param version string os field from [get_vps_templates](#get_vps_templates)
* @param hostname string Desired Hostname for the VPS
* @param coupon string Optional Coupon to pass
* @param rootpass string Desired Root Password (unused for windows, send a blank string)
*/
ini_set("soap.wsdl_cache_enabled", "0");
$username = $_SERVER['argv'][1];
$password = $_SERVER['argv'][2];
$os = $_SERVER['argv'][3];
$slices = $_SERVER['argv'][4];
$platform = $_SERVER['argv'][5];
$controlpanel = $_SERVER['argv'][6];
$period = $_SERVER['argv'][7];
$location = $_SERVER['argv'][8];
$version = $_SERVER['argv'][9];
$hostname = $_SERVER['argv'][10];
$coupon = $_SERVER['argv'][11];
$rootpass = $_SERVER['argv'][12];

$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
  $show_help = true;
  //break;
} 
if ($_SERVER['argc'] < 13)
  $show_help = true;
if ($show_help == true)
  exit(<<<EOF
api_api_buy_vps

Places a VPS order in our system. These are the same parameters as
* api_validate_buy_vps..   Returns a comma seperated list of invoices if any need
* paid.

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
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
  $sid = $client->api_login($username, $password);
  if (strlen($sid) == 0)
    die("Got A Blank Session");
  $res = $client->api_api_buy_vps($sid, $os, $slices, $platform, $controlpanel, $period, $location, $version, $hostname, $coupon, $rootpass);
  echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
  echo "Exception Occurred!\n";
  echo "Code:{$ex->faultcode}\n";
  echo "String:{$ex->faultstring}\n";
}; 
?>