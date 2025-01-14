<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

ini_set('max_execution_time', 300); //300 seconds = 5 minutes
?>

<div class="col-md-12">&nbsp;</div>
<?php
$condi1 = "";
$condi2 = "";
if ($_POST['search'] != "") {
    $condi1 = " AND a.COMPANYCODE = '" . $_POST['srtype'] . "' AND a.EMPLOYEECODE1 LIKE '%" . $_POST['search'] . "%' OR a.EMPLOYEENAME1 LIKE '%" . $_POST['search'] . "%'";
    $condi2 = " OR a.EMPLOYEECODE2 LIKE '%" . $_POST['search'] . "%' OR a.EMPLOYEENAME2 LIKE '%" . $_POST['search'] . "%'";
} else {
    $condi1 = " AND a.COMPANYCODE = '" . $_POST['srtype'] . "'";
    $condi2 = "";
}
$sql_seEmployee = "{call megTimeattendanceEHR_v2(?,?,?)}";
$params_seEmployee = array(
    array('select_employeeops', SQLSRV_PARAM_IN),
    array($condi1, SQLSRV_PARAM_IN),
    array($condi2, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
while ($result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC)) {
    ?>
    <div class="col-lg-3">
        <div class="panel" 

             <?php
             if ($result_seEmployee['ACTUALPRICE'] == '') {
                 ?>
                 style="background-color: #FFF; color: red;
                 border-color:red;"
                 <?php
             } else {
                 ?>
                 style="background-color: #FFF; color: blue;
                 border-color:blue;"
                 <?php
             }
             ?>
             >
            <div class="panel-heading">

                <div class="row">

                    <div class="col-lg-2 text-center">
                        <img src="../images/employee/<?= $result_seEmployee['EMPLOYEECODE1'] ?>.jpg" style="width: 80px;height: 80px;">
                    </div>
                    <div class="col-lg-5 text-center">

                        <div class="row">
                            <div class="huge" style="text-align: right"> <font style="font-size: 16px">วันที่วิ่งงาน</font></div>
                        </div>
                        <div class="row">
                            <div class="huge" style="text-align: right"> <font style="font-size: 16px">เวลาวิ่งงาน</font></div>
                        </div>


                        <div class="row">
                            <div class="huge" style="text-align: right"> 

                                <img src="../images/warning.gif" width="30"> 

                                <font style="font-size: 16px;color: green">มีแผนงานวิ่ง</font></div>
                        </div>




                    </div>
                    <div class="col-lg-5 text-center">
                        <div class="row">

                            <div class="huge" style="text-align: right"> <font style="font-size: 16px"><?= $result_seEmployee['DATE_VLIN'] ?>&emsp;</font></div>

                        </div>
                        <div class="row">

                            <div class="huge" style="text-align: right"> <font style="font-size: 16px"><?= $result_seEmployee['TIMEVLIN'] ?> นาที&emsp;</font></div>

                        </div>


                    </div>


                </div>
                <div class="row">

                    <div class="col-lg-12 text-left"><div class="huge"> <font style="font-size: 16px;"><?= $result_seEmployee['JOBNO'] ?></font></div></div>
                </div>
            </div>
            <div class="panel-footer" style="height: 50px">
                <span class="pull-left"><font style="font-size: 16px"><?= $result_seEmployee['EMPLOYEENAME1'] ?> (<?= $result_seEmployee['EMPLOYEECODE1'] ?>)</font></span>

                <span class="pull-right"> 

                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu slidedown">
                            <li>
                                <?php
                                $condiemp1 = " AND a.EMPLOYEECODE1 = '" . $result_seEmployee['EMPLOYEECODE1'] . "'";
                                $sql_seEmployee1 = "{call megTimeattendanceEHR_v2(?,?,?)}";
                                $params_seEmployee1 = array(
                                    array("select_employeeops1", SQLSRV_PARAM_IN),
                                    array($condiemp1, SQLSRV_PARAM_IN),
                                    array("", SQLSRV_PARAM_IN)
                                );
                                $query_seEmployee1 = sqlsrv_query($conn, $sql_seEmployee1, $params_seEmployee1);
                                $result_seEmployee1 = sqlsrv_fetch_array($query_seEmployee1, SQLSRV_FETCH_ASSOC);

                                $condOps1 = " AND a.VEHICLETRANSPORTPLANID = '" . $result_seEmployee1['VEHICLETRANSPORTPLANID'] . "'";
                                $condOps2 = "";
                                $condOps3 = "";
                                $sql_seOps = "{call megVehicletransportplan_v2(?,?,?,?)}";
                                $params_seOps = array(
                                    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                    array($condOps1, SQLSRV_PARAM_IN),
                                    array($condOps2, SQLSRV_PARAM_IN),
                                    array($condOps3, SQLSRV_PARAM_IN)
                                );

                                $query_seOps = sqlsrv_query($conn, $sql_seOps, $params_seOps);
                                $result_seOps = sqlsrv_fetch_array($query_seOps, SQLSRV_FETCH_ASSOC);
                                if ($result_seOps['ACTUALPRICE'] != "") {
                                    ?>

                                    <a href="#"  onclick='save_tenkomaster(<?= $result_seEmployee1['VEHICLETRANSPORTPLANID'] ?>)'>
                                        รายงานตัวตรวจร่างกาย
                                    </a>
                                    <?php
                                }
                                else
                                {
                                    ?>

                                    <a href="#" >
                                        ไม่สามารถรายงานตัวตรวจร่างกายได้
                                    </a>
                                    <?php
                                }
                                ?>
                            </li>


                        </ul>
                    </div>
                </span>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <?php
}
?>
<script>

</script>