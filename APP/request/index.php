<?php

if($_GET['page'] == ''){
    include_once 'menu.php';
}else if($_GET['page'] == 'Add'){
    include_once 'frm_add_request.php';
}else if($_GET['page'] == 'Edit'){
    include_once 'frm_edit_request.php';
}else if($_GET['page'] == 'Report'){
    include_once 'frm_report_request.php';
}else{
    header("refresh: 0; url=$oop->apphome/page_error.php");
    exit(0);
}

?>
