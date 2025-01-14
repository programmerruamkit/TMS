<?php
ob_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if($_GET['type'] == "repair")
{

$sql = "{call megEditrepair_v2(?,?,?,?)}";
$params = array(
    array($_GET['FLG'], SQLSRV_PARAM_IN),
    array($_GET['CONDITION1'], SQLSRV_PARAM_IN),
    array($_GET['FIELDNAME'], SQLSRV_PARAM_IN),
    array($_GET['EDITTABLEOBJ'], SQLSRV_PARAM_IN)
);
$query = sqlsrv_query($conn, $sql, $params);
?>


<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>กลุ่มร่วมกิจรุ่งเรือง</title>
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">สถานะเปลี่ยนเป็น "กำลังซ่อม" เรียบร้อยแล้ว <i class="fa fa-check"></i></h3>

                        </div>
                        <div class="panel-body">
                            <form role="form">
                                <fieldset>

                                    <!-- Change this to a button or input when using this as a form -->
                                    <a href="" onclick="close()" class="btn btn-lg btn-success btn-block">ปิดหน้าต่าง</a>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
    </body>

</html>
<script>
                                        function close()
                                        {

                                            window.open('', '_self');
                                            self.close();

                                        }
</script>
<?php
}
sqlsrv_close($conn);
?>
