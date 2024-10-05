<?php


date_default_timezone_set("AFRICA/Nairobi");

define('DBTYPE', 'PDO');
define('HOSTNAME', 'localhost');
define('DBPORT', '3308');
define('HOSTUSER', 'root');
define('HOSTPASS', '');
define('DBNAME', 'ics_e');


$_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$base_url = $protocol . $_SERVER['HTTP_HOST'] . '/';

$conf['ver_code_time'] = date("Y-m-d H:i:s", strtotime("+ 1 days"));
$conf['verification_code'] = rand(10000,99999);
$conf['site_initials'] = "ICS 2024";
$conf['site_url'] = "$base_url/". DBNAME;

?>