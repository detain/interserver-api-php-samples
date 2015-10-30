<?php
/** api_get_prepay_remaining  -  (c)2015 detain@interserver.net InterServer Hosting
* Get the PrePay amount available for a given module.
* @param module string the module you want to check your prepay amounts on
*/
ini_set("soap.wsdl_cache_enabled", "0");
$module = $_SERVER['argv'][0];
$show_help = false; 
if (in_array('--help', $_SERVER['argv']))
{
  $show_help = true;
  break;
} 
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
 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try { 
  $response = $client->api_get_prepay_remaining($module);
  echo '$response = '.var_export($response, true)."\n";
 } catch (Exception $ex) {
  echo "Exception Occured!\nCode:{$ex->faultcode}\nString:{$ex->faultstring}\n";
}; 
?>