<?php
/** api_vps_queue_restart  -  (c)2015 detain@interserver.net InterServer Hosting
* restart a vps
* @param sid string the *Session ID* you get from the [api_login](#api_login) call
* @param id int defaults to false, if specifeid tries usign that di instead of the one passed
*/
ini_set("soap.wsdl_cache_enabled", "0");
$username = $_SERVER['argv'][0];
$password = $_SERVER['argv'][1];
$id = $_SERVER['argv'][2];
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
api_vps_queue_restart

restart a vps

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
  $res = $client->api_vps_queue_restart($sid, $id);
  echo '$res = '.var_export($res, true)."\n";
 } catch (Exception $ex) {
  echo "Exception Occured!\n";
  echo "Code:{$ex->faultcode}\n";
  echo "String:{$ex->faultstring}\n";
}; 
?>