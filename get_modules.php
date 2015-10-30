<?php
/** get_modules  -  (c)2015 detain@interserver.net InterServer Hosting
* Returns a list of all the modules available.
*/
ini_set("soap.wsdl_cache_enabled", "0");
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
  $show_help = true;
  break;
} 
if ($_SERVER['argc'] < 1)
  $show_help = true;
if ($show_help == true)
  exit(<<<EOF
get_modules

Returns a list of all the modules available.

Correct Syntax: {$_SERVER["argv"][0]} 


EOF
); 
 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try { 
  $response = $client->get_modules();
  echo '$response = '.var_export($response, true)."\n";
 } catch (Exception $ex) {
  echo "Exception Occured!\nCode:{$ex->faultcode}\nString:{$ex->faultstring}\n";
}; 
?>