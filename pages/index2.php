
<?php

if ($_GET['type'] == 'menu' || $_GET['type'] == 'submenu') {
    if ($_GET['meg'] == 'add' || $_GET['meg'] == 'edit') {
        include 'meg_menu.php';
    } else {
        include 'report_menu.php';
    }
} else if ($_GET['type'] == 'rolemenu' || $_GET['type'] == 'role' || $_GET['type'] == 'reqaccount' || $_GET['type'] == 'roleaccount' || $_GET['type'] == 'roleemployee') {

    if ($_GET['meg'] == 'add' || $_GET['meg'] == 'edit') {
        include 'meg_permisstions.php';
    } else {
        include 'report_permisstions.php';
    }
} else if ($_GET['type'] == 'warningdata') {

    if ($_GET['meg'] == 'add' || $_GET['meg'] == 'edit') {
        include 'meg_warningdata.php';
    } else {
        include 'report_warningdata.php';
    }
} else {
    include 'meg_main.php';
}
?>

