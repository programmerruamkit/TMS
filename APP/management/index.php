<?php

if ($_GET['page'] == '') {
    include_once 'menu.php';
} else if ($_GET['page'] == 'Order'){
    include_once 'frm_add_order.php';
} else if ($_GET['page'] == 'Work'){
    include_once 'frm_edit_work.php';
} else if ($_GET['page'] == 'Report'){
    include_once 'frm_report_manage.php';
} else {
    header("refresh: 0; url=/app/page_error.php");
    exit(0);
}
?>