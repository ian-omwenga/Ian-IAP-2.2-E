<?php
require_once "load.php";
    $ObjLayouts->heading();
    $ObjMenus->main_menu();
   // print "<br><br><br><br><br><br><br><br><br>";
    $ObjContents->main_content();
    $ObjContents->sidebar();
    $ObjLayouts->footer();
    ?>