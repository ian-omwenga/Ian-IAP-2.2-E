<?php

require "connection.php";
require "constants.php";


function ClassAutoload($ClassName) {
    // Directories to search for class files
    $directories = ["forms", "processes", "structure", "tables", "globals", "store"];

    foreach ($directories as $dir) {
                $FileName = dirname(__FILE__) . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $ClassName . '.php';

        if (file_exists($FileName) && is_readable($FileName)) {
            require_once $FileName; 
        }
    }
}


spl_autoload_register('ClassAutoload');


$ObjLayouts = new layouts();
$ObjMenus = new menus();
$ObjContents = new contents();

$ObjGlob = new functions();  
$ObjSendMail = new sendmail();  

// Instantiate authentication object
$ObjAuth = new authentication();

// Database connection object
$Objdbconnect = new dbconnect(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);


// Call the signup method with all required arguments
$ObjAuth->signup($Objdbconnect, $ObjGlob, $ObjSendMail,  $conf);



?>
