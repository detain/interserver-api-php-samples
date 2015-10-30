<?php
/** api_webhosting_get_client_unpaid_invoices  -  (c)2015 detain@interserver.net InterServer Hosting
* This Function Applies to the Webhosting services.
* This function returns a list of all the unpaid invoices matching the module
* passed..
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
*/
ini_set("soap.wsdl_cache_enabled", "0");
$username = $_SERVER['argv'][0];
$password = $_SERVER['argv'][1];
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
  $show_help = true;
  break;
} 
if ($_SERVER['argc'] < 3)
  $show_help = true;
if ($show_help == true)
  exit(<<<EOF
api_webhosting_get_client_unpaid_invoices

This Function Applies to the Webhosting services.
* This function returns a list of all the unpaid invoices matching the module
* passed..

Correct Syntax: {$_SERVER["argv"][0]}  <username> <password>

  <username>  Your Login name with the site
  <password>  Your password used to login with the site

EOF
); 
 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try { 
  $sid = $client->api_login($username, $password);
  if (strlen($sid) == 0)
    die("Got A Blank Sessoion");
  $response = $client->api_webhosting_get_client_unpaid_invoices($sid);
  echo '$response = '.var_export($response, true)."\n";
 } catch (Exception $ex) {
  echo "Exception Occured!\nCode:{$ex->faultcode}\nString:{$ex->faultstring}\n";
}; 
?>