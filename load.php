
<?php

require "connection.php";
require "constants.php";

function ClassAutoload($ClassName){
   $directories = ["forms", "processes", "structure", "tables", "global", "store"];

   foreach($directories AS $dir){
        $FileName = dirname(__FILE__) . DIRECTORY_SEPARATOR . $dir .  DIRECTORY_SEPARATOR . $ClassName . '.php';

        if(file_exists($FileName) AND is_readable($FileName)){
         require $FileName;
        }
   }
}
spl_autoload_register('ClassAutoload');

    $ObjLayouts = new layouts();
    $ObjMenus = new menus();
    $ObjContents = new contents();

   $ObjGlob = new fncs();
$ObjSendMail = new sendmail();
    $ObjAuth-> verification($conn, $ObjGlob, $ObjSendMail, $lang, $conf);




    $Objdbconnect = new dbconnect(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);


    $ObjAuth = new authentication();
   // $ObjAuth->signup($conn);
?>