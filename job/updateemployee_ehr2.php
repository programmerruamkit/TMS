<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
ini_set('post_max_size','20M');
ini_set('upload_max_filesize','2M');
$conn = connect("RTMS");
?>
<html lang="en">
    <head>

    </head>
    <body>

        <?php
        $sql_updEmployee = "{call megEmployeeEHR_v2(?)}";
        $params_updEmployee = array(
            array('update_employee2', SQLSRV_PARAM_IN)
        );
        $query_updEmployee = sqlsrv_query($conn, $sql_updEmployee, $params_updEmployee);
		
		//$sql_bbkDatabase = "{call megBackupdb(?)}";
        //$params_bbkDatabase = array(
		//	array('', SQLSRV_PARAM_IN)
		//);
        //$query_bbkDatabase = sqlsrv_query($conn, $sql_bbkDatabase, $params_bbkDatabase);
        ?>
</html>
<?php
sqlsrv_close($conn);
?>
<script langauge="javascript">
    window.open('', '_self');
    self.close();
</script>