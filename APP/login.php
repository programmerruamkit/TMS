<?php $title_page = "Login"; ?>

<?php if (require_once 'master.php') {
     require 'logon/page_login.php';
} else {
    header("refresh: 0; url=/app/page_error.php");
    exit(0);
}
?>