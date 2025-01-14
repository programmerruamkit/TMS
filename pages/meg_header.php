<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["PASSWORD"])) {
    header("location:../pages/meg_login.php");
}


$condition1 = ($_SESSION["EMPLOYEEID"] != "") ? " AND a.EMPLOYEEID = '" . $_SESSION["EMPLOYEEID"] . "'" : "";
$sql_sePremissions = "{call megRoleaccount_v2(?,?)}";
$params_sePremissions = array(
    array('select_permissions', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_sePremissions = sqlsrv_query($conn, $sql_sePremissions, $params_sePremissions);
$result_sePremissions = sqlsrv_fetch_array($query_sePremissions, SQLSRV_FETCH_ASSOC);

// echo $_SESSION["EMPLOYEEID"];
// echo $result_sePremissions['NAME'];
// echo "sadsad";


?>
<style>
.navbar-default {
    background-color: #fff;
}
</style>
<div class="navbar-header" >
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="../pages/index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a> 

                
</div>
<ul class="nav navbar-top-links navbar-right">
   
    <li>
        <font style="color:#337ab7 "><?= $result_sePremissions["NAME"] ?></font>
    </li>
    <li class="dropdown">
        <?php
        if ($_SESSION["ROLENAME"] != "") {
            ?>
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <?= $_SESSION["ROLENAME"] ?>
            </a>
            <?php
        } else {
            ?>
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                เลือกสิทธิ์เข้าใช้งาน <i class="fa fa-caret-down"></i>
            </a>
            <?php
        }
        ?>
        <ul class="dropdown-menu dropdown-user">
            <?php
            $query_sePremissions3 = sqlsrv_query($conn, $sql_sePremissions, $params_sePremissions);
            while ($result_sePremissions3 = sqlsrv_fetch_array($query_sePremissions3, SQLSRV_FETCH_ASSOC)) {
                ?>
                <li><a onclick="create_premissions('<?= $result_sePremissions3['ROLEID'] ?>');"><i class="fa fa-user fa-fw"></i> <?= $result_sePremissions3['ROLENAME'] ?></a></li>
                <?php
            }
            ?>
        </ul>
    </li>

    
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
           
            <li><a href="meg_logout.php"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
            </li>
        </ul>
    </li>

    <li class="dropdown messages-menu">
        <!-- <?php
        $sql_seWarninginsuredA = "{call megVehicleinsured_v2(?)}";
        $params_seWarninginsuredA = array(
            array('get_vehicleinsuredA', SQLSRV_PARAM_IN)
        );

        $query_seWarninginsuredA = sqlsrv_query($conn, $sql_seWarninginsuredA, $params_seWarninginsuredA);
        $result_seWarninginsuredA = sqlsrv_fetch_array($query_seWarninginsuredA, SQLSRV_FETCH_ASSOC);

        $sql_seWarningtaxA = "{call megVehicletax_v2(?)}";
        $params_seWarningtaxA = array(
            array('get_vehicletaxA', SQLSRV_PARAM_IN)
        );

        $query_seWarningtaxA = sqlsrv_query($conn, $sql_seWarningtaxA, $params_seWarningtaxA);
        $result_seWarningtaxA = sqlsrv_fetch_array($query_seWarningtaxA, SQLSRV_FETCH_ASSOC);


        if ($result_seWarninginsuredA || $result_seWarningtaxA) {
            ?>

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>

                <span class="label label-warning">!</span>

            </a>
            <?php
        }
        ?> -->
        <ul class="dropdown-menu dropdown-user">

            <li>

                <a href="report_warningdata.php?type=warningdata">
                    <i class="fa fa-envelope-o"></i> รายการแจ้งเตือน
                </a>
            </li>


        </ul>
    </li>



</ul>


<script>
    function create_premissions(roleid)
    {

        $.ajax({
            type: 'post',
            url: 'meg_data.php',
            data: {
                txt_flg: "create_premissions", roleid: roleid

            },
            success: function () {

                window.location.href = 'index2.php';
            }
        });

    }
</script>
