<?php
/** strPixels  -  (c)2015 detain@interserver.net InterServer Hosting
* This function uses the array below to calculate the pixel width of a string of
* characters. The widths of each character are based on a 12px Helvetica font. 
* Kerning is not taken into account so RESULTS ARE APPROXIMATE.  The purpose is to
* return a relative size to help in formatting. For example, strPixels('I like
* cake') == 54    strPixels('I LIKE CAKE') == 67
* @param string string characters to measure size
*/
ini_set("soap.wsdl_cache_enabled", "0");
$string = $_SERVER['argv'][0];
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
 
$client = new SoapClient("https://my.interserver.net/api.php?wsdl");
try { 
  $response = $client->strPixels($string);
  echo '$response = '.var_export($response, true)."\n";
 } catch (Exception $ex) {
  echo "Exception Occured!\nCode:{$ex->faultcode}\nString:{$ex->faultstring}\n";
}; 
?>