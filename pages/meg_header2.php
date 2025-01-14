<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["PASSWORD"])) {
    header("location:meg_login2.php");
}
$condition1 = ($_SESSION["EMPLOYEEID"] != "") ? " AND a.EMPLOYEEID = '" . $_SESSION["EMPLOYEEID"] . "'" : "";
//$condition1 = ($_SESSION["EMPLOYEEID"] != "") ? " AND a.EMPLOYEEID = 238" : "";
$sql_sePremissions = "{call megRoleaccount_v2(?,?)}";
$params_sePremissions = array(
    array('select_permissions', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_sePremissions = sqlsrv_query($conn, $sql_sePremissions, $params_sePremissions);
$result_sePremissions = sqlsrv_fetch_array($query_sePremissions, SQLSRV_FETCH_ASSOC);

$condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);
?>
<div class="navbar-header" >
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="index.php"><font style="color: #666"><img src="../images/logo.png" height="30"> <strong>กลุ่มร่วมกิจรุ่งเรือง</strong></font></a> 
</div>
<ul class="nav navbar-top-links navbar-right">


    <li>
        <font style="color:#337ab7 "><?=$result_seEmployee['nameT']?></font>
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
                <li><a href="" onclick="create_premissions('<?= $result_sePremissions3['ROLEID'] ?>');"><i class="fa fa-user fa-fw"></i> <?= $result_sePremissions3['ROLENAME'] ?></a></li>
                <?php
            }
            ?>
        </ul>
    </li>

    <li>
        <font style="color:#337ab7 "><?= $result_sePremissions["NAME"] ?></font>
    </li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">

            <li><a href="meg_logout2.php"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
            </li>
        </ul>
    </li>




</ul>