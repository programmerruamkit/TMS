<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");
?>
<html lang="en">
    <head>

    </head>
    <body>

        <?php
        $sql_updEmployee = "{call megTimeattendanceEHR_v2(?)}";
        $params_updEmployee = array(
            array('update_employee', SQLSRV_PARAM_IN)
        );
        $query_updEmployee = sqlsrv_query($conn, $sql_updEmployee, $params_updEmployee);
        ?>
</html>
<?php
sqlsrv_close($conn);
?>
<script langauge="javascript">
    window.open('', '_self');
    self.close();
</script>