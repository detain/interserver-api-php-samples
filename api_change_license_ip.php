<?php
/** api_change_license_ip  -  (c)2015 detain@interserver.net InterServer Hosting
* Change the IP on an active license.
* @param sid string the *Session ID* you get from the [login](#login) call
* @param oldip string the old ip address
* @param newip string the new ip address
*/
ini_set("soap.wsdl_cache_enabled", "0");
$username = $_SERVER['argv'][1];
$password = $_SERVER['argv'][2];
$oldip = $_SERVER['argv'][3];
$newip = $_SERVER['argv'][4];
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
  $show_help = true;
  break;
} 
if ($_SERVER['argc'] < 5)
  $show_help = true;
if ($show_help == true)
  exit(<<<EOF
api_change_license_ip

Change the IP on an active license.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <oldip> <newip>

  <username>  Your Login name with the site
  <password>  Your password used to login with the site
  <oldip>  Must be a string
  <newip>  Must be a string

EOF
); 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
  $sid = $client->api_login($username, $password);
  if (strlen($sid) == 0)
    die("Got A Blank Sessoion");
  $res = $client->api_change_license_ip($sid, $oldip, $newip);
  echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
  echo "Exception Occured!\n";
  echo "Code:{$ex->faultcode}\n";
  echo "String:{$ex->faultstring}\n";
}; 
?>