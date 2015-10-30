<?php
/** api_ssl_cancel_service  -  (c)2015 detain@interserver.net InterServer Hosting
* This Function Applies to the SSL Certificates services.
* Cancels a service for the passed module matching the passed id.  Canceling a
* service will also cancel any addons for that service at the same time.
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param id int the Order ID / Service ID you wish to cancel
*/
ini_set("soap.wsdl_cache_enabled", "0");
$username = $_SERVER['argv'][1];
$password = $_SERVER['argv'][2];
$id = $_SERVER['argv'][3];
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
  $show_help = true;
  break;
} 
if ($_SERVER['argc'] < 4)
  $show_help = true;
if ($show_help == true)
  exit(<<<EOF
api_ssl_cancel_service

This Function Applies to the SSL Certificates services.
* Cancels a service for the passed module matching the passed id.  Canceling a
* service will also cancel any addons for that service at the same time.

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password> <id>

  <username>  Your Login name with the site
  <password>  Your password used to login with the site
  <id>  Must be a int

EOF
); 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try  { 
  $sid = $client->api_login($username, $password);
  if (strlen($sid) == 0)
    die("Got A Blank Sessoion");
  $res = $client->api_ssl_cancel_service($sid, $id);
  echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
  echo "Exception Occured!\n";
  echo "Code:{$ex->faultcode}\n";
  echo "String:{$ex->faultstring}\n";
}; 
?>