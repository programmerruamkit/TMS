<?php

if($_GET['page'] == ''){
    include_once 'menu.php';
}else if($_GET['page'] == 'Manage'){
    include_once 'frm_manage_equipment.php';
}else if($_GET['page'] == 'Data'){
    include_once 'frm_search_equipment.php';
}else{
    header("refresh: 0; url=/app/page_error.php");
    exit(0);
}

?>
