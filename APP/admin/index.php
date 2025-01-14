<?php

if($_GET['page'] == ''){
    include_once 'menu.php';
}else if($_GET['page'] == 'Type'){
    include_once 'frm_add_type.php';
}else if($_GET['page'] == 'Regis'){
    include_once 'frm_add_register.php';
}else{
    header("refresh: 0; url=/app/page_error.php");
    exit(0);
}

?>