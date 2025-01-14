<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
?>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <?php
        for ($i = 0; $i < count($_POST["chkDel"]); $i++) {
            if ($_POST["chkDel"][$i] != "") {


                $sql = "DELETE FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE VEHICLETRANSPORTPLANID = '" . $_POST["chkDel"][$i] . "' ";
                $params = array();
                $query = sqlsrv_query($conn, $sql, $params);
				
				$sql2 = "DELETE FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] WHERE VEHICLETRANSPORTPLANID = '" . $_POST["chkDel"][$i] . "' ";
                $params2 = array();
                $query2 = sqlsrv_query($conn, $sql2, $params2);
            }
        }
        header( "location:".$_POST['url'] );
        ?>
    </body>
</html>


 <input type="text" id="type" name="type" value="" style="<?=$_GET['type']?>">
                                                        <input type="text" id="meg" name="meg" value="" style="<?=$_GET['meg']?>">
                                                        <input type="text" id="companycode" name="companycode" value="" style="<?=$_GET['companycode']?>">
                                                        <input type="text" id="customercode" name="customercode" value="" style="<?=$_GET['customercode']?>">
                                                        <input type="text" id="worktype" name="worktype" value="" style="<?=$_GET['worktype']?>">
                                                        <input type="text" id="carrytype" name="carrytype" value="" style="<?=$_GET['carrytype']?>">