<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

ini_set('max_execution_time', 300); //300 seconds = 5 minutes
if ($_POST['typetenko'] == 'เท็งโก๊ะระหว่างทาง/หลังเลิกงาน') {
    $condition2 = "";
    $condition3 = "";
    $rdsr = ($_POST['positiondirver'] == '1') ? " AND c.PositionGroup = 'พนักงาน'" : " AND c.PositionGroup = 'เจ้าหน้าที่'";
    $cbsr = "";
    $txtsr = "";
    
    if ($_POST['search'] != "") {
        $txtsr = " AND (b.FnameT LIKE '%" . $_POST['search'] . "%' OR b.LnameT LIKE '%" . $_POST['search'] . "%'
                    OR b.PersonCode LIKE '%" . $_POST['search'] . "%') ";
    }


    $condition2 = $rdsr.$cbsr.$txtsr;
    $condition3;


     $sql_seEmployee = "SELECT a.TENKOMASTERID,CONVERT(VARCHAR(10), a.CREATEDATE, 103) AS 'CREATEDATED',convert(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATEDATET',b.PersonCode AS 'PersonCodeP',(b.FnameT +' '+b.LnameT) AS 'nameTP',c.PositionGroup FROM [dbo].[TENKOMASTER] a
    INNER JOIN [dbo].[EMPLOYEEEHR] b ON a.[TENKOMASTERDIRVERCODE1] = b.PersonCode
    INNER JOIN [dbo].[POSITIONEHR] c ON b.[PositionID] = c.[PositionID]
    INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
    INNER JOIN TENKOAFTER e ON d.TENKOMASTERID = e.TENKOMASTERID
    WHERE 1=1 
    AND (d.TENKOAFTERGREETCHECK IS NULL ) 
    AND (e.TENKOAFTERGREETCHECK IS NULL ) 
    AND a.TENKOMASTERCOMPANY = '" . $_POST['srtype'] . "'" . $condition2 . $condition3." order by a.CREATEDATE DESC";


    $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
    while ($result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC)) {
        ?>
        <div class="col-lg-3">
            <div class="panel" style="background-color: #FFF; color: blue;border-color:blue;">
                <div class="panel-heading">
                    <div class="row">

                        <div class="col-lg-2 text-center">
                            <img src="../images/employee/<?= $result_seEmployee['PersonCodeP'] ?>.jpg" style="width: 80px;height: 80px;">
                        </div>
                        <div class="col-lg-5 text-center">
                            <div class="row">
                                <div class="huge" style="text-align: right" style="text-align: right"><b><font style="font-size: 20px"><?= $result_seEmployee['CREATEDATED'] ?></font></b></div>
                            </div>



                        </div>
                        <div class="col-lg-5 text-center">
                            <div class="row">

                                <div class="huge" style="text-align: right"><b><font style="font-size: 20px"><?= $result_seEmployee['CREATEDATET'] ?></font></b></div>

                            </div>


                        </div>


                    </div>
                </div>
                <div class="panel-footer" style="height: 50px">
                    <span class="pull-left"><font style="font-size: 16px"><?= $result_seEmployee['nameTP'] ?> (<?= $result_seEmployee['PersonCodeP'] ?>)</font></span>
                    <span class="pull-right"> 
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu slidedown">
                                <li>
                                    <a href="#"  onclick="save_tenkomasterofficer('<?= $result_seEmployee['PersonCodeP'] ?>', '<?= $result_seEmployee['TENKOMASTERID'] ?>')">
                                        รายงานตัวตรวจร่างกาย
                                    </a>
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
} else {
    ?>
    <div class="col-md-12 text-right">

        <?php
        if ($_POST['positiondirver'] != "") {

            $sql_seCountnot = "{call megTimeattendanceEHR_v2(?,?)}";
            $params_seCountnot = array(
                array('select_countnotemployeeinout1', SQLSRV_PARAM_IN),
                array($_POST['srtype'], SQLSRV_PARAM_IN)
            );
            $query_seCountnot = sqlsrv_query($conn, $sql_seCountnot, $params_seCountnot);
            $result_seCountnot = sqlsrv_fetch_array($query_seCountnot, SQLSRV_FETCH_ASSOC);
        } else {
            $sql_seCountnot = "{call megTimeattendanceEHR_v2(?,?)}";
            $params_seCountnot = array(
                array('select_countnotemployeeinout2', SQLSRV_PARAM_IN),
                array($_POST['srtype'], SQLSRV_PARAM_IN)
            );
            $query_seCountnot = sqlsrv_query($conn, $sql_seCountnot, $params_seCountnot);
            $result_seCountnot = sqlsrv_fetch_array($query_seCountnot, SQLSRV_FETCH_ASSOC);
        }
        if ($_POST['positiondirver'] != "") {
            $sql_seCount = "{call megTimeattendanceEHR_v2(?,?)}";
            $params_seCount = array(
                array('select_countemployeeinout1', SQLSRV_PARAM_IN),
                array($_POST['srtype'], SQLSRV_PARAM_IN)
            );
            $query_seCount = sqlsrv_query($conn, $sql_seCount, $params_seCount);
            $result_seCount = sqlsrv_fetch_array($query_seCount, SQLSRV_FETCH_ASSOC);
        } else {
            $sql_seCount = "{call megTimeattendanceEHR_v2(?,?)}";
            $params_seCount = array(
                array('select_countemployeeinout2', SQLSRV_PARAM_IN),
                array($_POST['srtype'], SQLSRV_PARAM_IN)
            );
            $query_seCount = sqlsrv_query($conn, $sql_seCount, $params_seCount);
            $result_seCount = sqlsrv_fetch_array($query_seCount, SQLSRV_FETCH_ASSOC);
        }


        $sql_seCountlate = "{call megTimeattendanceEHR_v2(?,?)}";
        $params_seCountlate = array(
            array('select_countlateemployeeinout', SQLSRV_PARAM_IN),
            array($_POST['srtype'], SQLSRV_PARAM_IN)
        );
        $query_seCountlate = sqlsrv_query($conn, $sql_seCountlate, $params_seCountlate);
        $result_seCountlate = sqlsrv_fetch_array($query_seCountlate, SQLSRV_FETCH_ASSOC);
        $result_seCountlate['AMOUNT'];

        $condEmp = "  AND a.PersonCode = '" . $_SESSION["EMPLOYEEID"] . "'";
        $sql_seEmp = "{call megEmployeeEHR_v2(?,?)}";
        $params_seEmp = array(
            array('select_employee', SQLSRV_PARAM_IN),
            array($condEmp, SQLSRV_PARAM_IN)
        );
        $query_seEmp = sqlsrv_query($conn, $sql_seEmployee, $params_seEmp);
        $result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC);
        ?>
        <input class="btn btn-default" type="button" style="background-color: white;border:solid 2px #999;color: #999" id="btn_srquotation" name="btn_srquotation" value="ยังไม่มา (<?= $result_seCountnot['AMOUNT'] ?>)">&emsp;
        <input class="btn btn-default" type="button" style="background-color: white;border:solid 2px blue;color: blue" id="btn_srquotation" name="btn_srquotation" value="ปรกติ (<?= $result_seCount['AMOUNT'] ?>)">&emsp;
        <?php
        if ($_POST['positiondirver'] != "") {
            ?>
            <input class="btn btn-default" type="button" style="background-color: white;border:solid 2px red;color: red" id="btn_srquotation" name="btn_srquotation" value="สาย (0)">
            <?php
        } else {
            ?>
            <input class="btn btn-default" type="button" style="background-color: white;border:solid 2px red;color: red" id="btn_srquotation" name="btn_srquotation" value="สาย (<?= $result_seCountlate['AMOUNT'] ?>)">
            <?php
        }
        ?>  


    </div>
    <div class="col-md-12">&nbsp;</div>
    <?php
    $condition2 = "";
    $condition3 = "";

   
    $rdsr = ($_POST['positiondirver'] == '1') ? " AND d.PositionGroup = 'พนักงาน'" : " AND d.PositionGroup = 'เจ้าหน้าที่'";
    $cbsr = "";
    $txtsr = "";
    if ($_POST['srtype'] != "") {
        $cbsr = " AND c.Company_Code = '" . $_POST['srtype'] . "'";
    }
    if ($_POST['search'] != "") {
        $txtsr = " AND (b.FnameT LIKE '%" . $_POST['search'] . "%' OR b.LnameT LIKE '%" . $_POST['search'] . "%'
                    OR b.PersonCode LIKE '%" . $_POST['search'] . "%') ";
    }


    $condition2 = $rdsr.$cbsr.$txtsr;
    $condition3;
    $sql_seEmployee = "{call megTimeattendanceEHR_v2(?,?,?)}";
    $params_seEmployee = array(
        array('select_employeeinout', SQLSRV_PARAM_IN),
        array($condition2, SQLSRV_PARAM_IN),
        array($condition3, SQLSRV_PARAM_IN)
    );
    $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
    while ($result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC)) {


        if ($result_seEmployee['VEHICLETRANSPORTPLANID'] != "") {

            $conditionTenkomaster = " AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'";
            $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
            $params_seTenkomaster = array(
                array('select_tenkomaster', SQLSRV_PARAM_IN),
                array($conditionTenkomaster, SQLSRV_PARAM_IN)
            );
            $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
            $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

            if ($result_seTenkomaster['TENKOMASTERDIRVERCODE1'] == $result_seEmployee['PersonCode']) {
                $sql_seBeforecheck1 = "{call megEdittenkobefore_v2(?,?,?)}";
                $params_seBeforecheck1 = array(
                    array('select_beforecheck', SQLSRV_PARAM_IN),
                    array($result_seTenkomaster['TENKOMASTERID'], SQLSRV_PARAM_IN),
                    array($result_seTenkomaster['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
                );
                $query_seBeforecheck1 = sqlsrv_query($conn, $sql_seBeforecheck1, $params_seBeforecheck1);
                $result_seBeforecheck1 = sqlsrv_fetch_array($query_seBeforecheck1, SQLSRV_FETCH_ASSOC);

                $sql_seBeforeresult1 = "{call megEdittenkobefore_v2(?,?,?)}";
                $params_seBeforeresult1 = array(
                    array('select_beforeresult', SQLSRV_PARAM_IN),
                    array($result_seTenkomaster['TENKOMASTERID'], SQLSRV_PARAM_IN),
                    array($result_seTenkomaster['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
                );
                $query_seBeforeresult1 = sqlsrv_query($conn, $sql_seBeforeresult1, $params_seBeforeresult1);
                $result_seBeforeresult1 = sqlsrv_fetch_array($query_seBeforeresult1, SQLSRV_FETCH_ASSOC);
            }
            if ($result_seTenkomaster['TENKOMASTERDIRVERCODE2'] == $result_seEmployee['PersonCode']) {
                $sql_seBeforecheck2 = "{call megEdittenkobefore_v2(?,?,?)}";
                $params_seBeforecheck2 = array(
                    array('select_beforecheck', SQLSRV_PARAM_IN),
                    array($result_seTenkomaster['TENKOMASTERID'], SQLSRV_PARAM_IN),
                    array($result_seTenkomaster['TENKOMASTERDIRVERCODE2'], SQLSRV_PARAM_IN)
                );
                $query_seBeforecheck2 = sqlsrv_query($conn, $sql_seBeforecheck2, $params_seBeforecheck2);
                $result_seBeforecheck2 = sqlsrv_fetch_array($query_seBeforecheck2, SQLSRV_FETCH_ASSOC);

                $sql_seBeforeresult2 = "{call megEdittenkobefore_v2(?,?,?)}";
                $params_seBeforeresult2 = array(
                    array('select_beforeresult', SQLSRV_PARAM_IN),
                    array($result_seTenkomaster['TENKOMASTERID'], SQLSRV_PARAM_IN),
                    array($result_seTenkomaster['TENKOMASTERDIRVERCODE2'], SQLSRV_PARAM_IN)
                );
                $query_seBeforeresult2 = sqlsrv_query($conn, $sql_seBeforeresult2, $params_seBeforeresult2);
                $result_seBeforeresult2 = sqlsrv_fetch_array($query_seBeforeresult2, SQLSRV_FETCH_ASSOC);
            }
        } else {
            $conditionTenkomaster = " AND a.TENKOMASTERDIRVERCODE1 = '" . $result_seEmployee['PersonCode'] . "'";
            $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
            $params_seTenkomaster = array(
                array('select_tenkomaster', SQLSRV_PARAM_IN),
                array($conditionTenkomaster, SQLSRV_PARAM_IN)
            );
            $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
            $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

            $sql_seBeforecheck1 = "{call megEdittenkobefore_v2(?,?,?)}";
            $params_seBeforecheck1 = array(
                array('select_beforecheckofficer', SQLSRV_PARAM_IN),
                array($result_seTenkomaster['TENKOMASTERID'], SQLSRV_PARAM_IN),
                array($result_seTenkomaster['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
            );
            $query_seBeforecheck1 = sqlsrv_query($conn, $sql_seBeforecheck1, $params_seBeforecheck1);
            $result_seBeforecheck1 = sqlsrv_fetch_array($query_seBeforecheck1, SQLSRV_FETCH_ASSOC);

            $sql_seBeforeresult1 = "{call megEdittenkobefore_v2(?,?,?)}";
            $params_seBeforeresult1 = array(
                array('select_beforeresultofficer', SQLSRV_PARAM_IN),
                array($result_seTenkomaster['TENKOMASTERID'], SQLSRV_PARAM_IN),
                array($result_seTenkomaster['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
            );
            $query_seBeforeresult1 = sqlsrv_query($conn, $sql_seBeforeresult1, $params_seBeforeresult1);
            $result_seBeforeresult1 = sqlsrv_fetch_array($query_seBeforeresult1, SQLSRV_FETCH_ASSOC);
        }
        ?>
    
        <div class="col-lg-3">
            <div class="panel" style="background-color: #FFF;;

        <?php
        if ($_POST['positiondirver'] != "") {
            if ($result_seEmployee['ST'] == 'OK' || $result_seEmployee['ST'] == 'Late') {
                ?>
                         color: blue;
                         border-color:blue;
                <?php
            } else {
                ?>
                         color: #999;
                         border-color: #999;
                <?php
            }
        } else {
            if ($result_seEmployee['ST'] == 'OK') {
                ?>
                         color: blue;
                         border-color:blue;
                <?php
            } else if ($result_seEmployee['ST'] == 'Late') {
                ?> 
                         color: red;
                         border-color:red; 
                <?php
            } else {
                ?>
                         color: #999;
                         border-color: #999;
                <?php
            }
        }
        ?>  

                 ">
                <div class="panel-heading">
                    <div class="row">

                        <div class="col-lg-2 text-center">
                            <img src="../images/employee/<?= $result_seEmployee['PersonCodeP'] ?>.jpg" style="width: 80px;height: 80px;">
                        </div>
                        <div class="col-lg-5 text-center">
                            <div class="row">
                                <div class="huge" style="text-align: right" style="text-align: right"> <font style="font-size: 16px">เวลาเข้างานวันนี้</font></div>
                            </div>



                        </div>
                        <div class="col-lg-5 text-center">
                            <div class="row">

                                <div class="huge" style="text-align: right"> <font style="font-size: 16px"><?= $result_seEmployee['TimeInout'] ?> นาที&emsp;</font></div>

                            </div>


                        </div>


                    </div>
                </div>
                <div class="panel-footer" style="height: 50px">
                    <span class="pull-left"><font style="font-size: 16px"><?= $result_seEmployee['nameTP'] ?> (<?= $result_seEmployee['PersonCodeP'] ?>)</font></span>
                    <span class="pull-right"> 
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu slidedown">
                                <li>
                                    <a href="#"  onclick="save_tenkomasterofficer('<?= $result_seEmployee['PersonCodeP'] ?>', )">
                                        รายงานตัวตรวจร่างกาย
                                    </a>
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
}
?>
