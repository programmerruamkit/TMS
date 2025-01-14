<!DOCTYPE html>
<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

// echo $_SESSION["USERNAME"];
// if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["PASSWORD"])) {
//     header("location:../pages/meg_login.php?data=3");
// }

// $condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
// $sql_seLogin = "{call megRoleaccount_v2(?,?)}";
// $params_seLogin = array(
//     array('select_roleaccount', SQLSRV_PARAM_IN),
//     array($condition1, SQLSRV_PARAM_IN)
// );
// $query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
// $result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);

// $sql_seSystime = "{call megGetdate_v2(?)}";
// $params_seSystime = array(
//     array('select_getdate', SQLSRV_PARAM_IN)
// );
// $query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
// $result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);

$conditionEHR = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
);
$query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
$result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);


$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$checkdate = date("d/m/Y");
// echo '<br>';

// AND (EMPLOYEECODE1 = '".$result_seEHR['PersonCode']."' OR EMPLOYEECODE2 ='".$result_seEHR['PersonCode']."')

// รหัสพนักงาน
$employeecode = $result_seEHR['PersonCode'];
// หาแผนงานวันที่ปัจจุบัน
$sql_sePLanning_current = "SELECT ROW_NUMBER() OVER(ORDER BY ROUNDAMOUNT,JOBNO ASC) AS 'ROW', JOBNO,JOBSTART,JOBEND,ROUNDAMOUNT,
CONVERT(VARCHAR(16),DATEWORKING,103) AS 'DATEWORKING',CONVERT(VARCHAR(10),DATEPRESENT,103) AS 'DATEPRESENT', CONVERT(VARCHAR(5), DATEPRESENT, 108) AS 'TIMEPRESENT'
FROM VEHICLETRANSPORTPLAN 
WHERE  CONVERT(DATE,DATEWORKING) =  CONVERT(DATE,GETDATE())
AND (EMPLOYEECODE1 = '".$employeecode."' OR EMPLOYEECODE2 ='".$employeecode."')
ORDER BY ROUNDAMOUNT,JOBNO ASC";
$params_sePLanning_current = array();
$query_sePLanning_current = sqlsrv_query($conn, $sql_sePLanning_current, $params_sePLanning_current);
while($result_sePLanning_current = sqlsrv_fetch_array($query_sePLanning_current, SQLSRV_FETCH_ASSOC)){

    if ($result_sePLanning_current['ROW'] == '1') {
        $check_current          = 'check';
        $dateworking1_current   = $result_sePLanning_current['DATEWORKING'];
        $jobno1_current         = $result_sePLanning_current['JOBNO'];
        // echo '<br>';
        $jobstart1_current      = $result_sePLanning_current['JOBSTART'];
        $jobend1_current        = $result_sePLanning_current['JOBEND'];
        $roundamount1_current   = $result_sePLanning_current['ROUNDAMOUNT'];
        $datetimepresent1_current   = $result_sePLanning_current['DATEPRESENT']." ".$result_sePLanning_current['TIMEPRESENT'];
    }else {
        $jobno2_current         = $result_sePLanning_current['JOBNO'];
        // echo '<br>';
        $jobstart2_current      = $result_sePLanning_current['JOBSTART'];
        $jobend2_current        = $result_sePLanning_current['JOBEND'];
        $roundamount2_current   = $result_sePLanning_current['ROUNDAMOUNT'];
        $datetimepresent2_current   = $result_sePLanning_current['DATEPRESENT']." ".$result_sePLanning_current['TIMEPRESENT'];
    }
}

// หาแผนงานวันที่ย้อนหลัง 1 วัน
$sql_sePLanning_before1 = "SELECT ROW_NUMBER() OVER(ORDER BY ROUNDAMOUNT,JOBNO ASC) AS 'ROW', JOBNO,JOBSTART,JOBEND,ROUNDAMOUNT,
CONVERT(VARCHAR(16),DATEWORKING,103) AS 'DATEWORKING',CONVERT(VARCHAR(10),DATEPRESENT,103) AS 'DATEPRESENT', CONVERT(VARCHAR(5), DATEPRESENT, 108) AS 'TIMEPRESENT'
FROM VEHICLETRANSPORTPLAN 
WHERE  CONVERT(DATE,DATEWORKING) =  CONVERT(DATE,GETDATE()-1)
AND (EMPLOYEECODE1 = '".$employeecode."' OR EMPLOYEECODE2 ='".$employeecode."')
ORDER BY ROUNDAMOUNT,JOBNO ASC";
$params_sePLanning_before1 = array();
$query_sePLanning_before1 = sqlsrv_query($conn, $sql_sePLanning_before1, $params_sePLanning_before1);
while($result_sePLanning_before1 = sqlsrv_fetch_array($query_sePLanning_before1, SQLSRV_FETCH_ASSOC)){

    if ($result_sePLanning_before1['ROW'] == '1') {
        $check_before1          = 'check';
        $dateworking1_before1   = $result_sePLanning_before1['DATEWORKING'];
        $jobno1_before1         = $result_sePLanning_before1['JOBNO'];
        // echo '<br>';
        $jobstart1_before1      = $result_sePLanning_before1['JOBSTART'];
        $jobend1_before1        = $result_sePLanning_before1['JOBEND'];
        $roundamount1_before1   = $result_sePLanning_before1['ROUNDAMOUNT'];
        $datetimepresent1_before1   = $result_sePLanning_before1['DATEPRESENT']." ".$result_sePLanning_before1['TIMEPRESENT'];
    }else {
        $jobno2_before1         = $result_sePLanning_before1['JOBNO'];
        // echo '<br>';
        $jobstart2_before1      = $result_sePLanning_before1['JOBSTART'];
        $jobend2_before1        = $result_sePLanning_before1['JOBEND'];
        $roundamount2_before1   = $result_sePLanning_before1['ROUNDAMOUNT'];
        $datetimepresent2_before1   = $result_sePLanning_before1['DATEPRESENT']." ".$result_sePLanning_before1['TIMEPRESENT'];
    }
}


// หาแผนงานวันที่ย้อนหลัง 2 วัน
$sql_sePLanning_before2 = "SELECT ROW_NUMBER() OVER(ORDER BY ROUNDAMOUNT,JOBNO ASC) AS 'ROW', JOBNO,JOBSTART,JOBEND,ROUNDAMOUNT,
CONVERT(VARCHAR(16),DATEWORKING,103) AS 'DATEWORKING',CONVERT(VARCHAR(10),DATEPRESENT,103) AS 'DATEPRESENT', CONVERT(VARCHAR(5), DATEPRESENT, 108) AS 'TIMEPRESENT'
FROM VEHICLETRANSPORTPLAN 
WHERE  CONVERT(DATE,DATEWORKING) =  CONVERT(DATE,GETDATE()-2)
AND (EMPLOYEECODE1 = '".$employeecode."' OR EMPLOYEECODE2 ='".$employeecode."')
ORDER BY ROUNDAMOUNT,JOBNO ASC";
$params_sePLanning_before2 = array();
$query_sePLanning_before2 = sqlsrv_query($conn, $sql_sePLanning_before2, $params_sePLanning_before2);
while($result_sePLanning_before2 = sqlsrv_fetch_array($query_sePLanning_before2, SQLSRV_FETCH_ASSOC)){

    if ($result_sePLanning_before2['ROW'] == '1') {
        $check_before2          = 'check';
        $dateworking1_before2   = $result_sePLanning_before2['DATEWORKING'];
        $jobno1_before2         = $result_sePLanning_before2['JOBNO'];
        // echo '<br>';
        $jobstart1_before2      = $result_sePLanning_before2['JOBSTART'];
        $jobend1_before2        = $result_sePLanning_before2['JOBEND'];
        $roundamount1_before2   = $result_sePLanning_before2['ROUNDAMOUNT'];
        $datetimepresent1_before2   = $result_sePLanning_before2['DATEPRESENT']." ".$result_sePLanning_before2['TIMEPRESENT'];
    }else {
        $jobno2_before2         = $result_sePLanning_before2['JOBNO'];
        // echo '<br>';
        $jobstart2_before2      = $result_sePLanning_before2['JOBSTART'];
        $jobend2_before2        = $result_sePLanning_before2['JOBEND'];
        $roundamount2_before2   = $result_sePLanning_before2['ROUNDAMOUNT'];
        $datetimepresent2_before2   = $result_sePLanning_before2['DATEPRESENT']." ".$result_sePLanning_before2['TIMEPRESENT'];
    }
}


// หาแผนงานวันที่ย้อนหลัง 3 วัน
$sql_sePLanning_before3 = "SELECT ROW_NUMBER() OVER(ORDER BY ROUNDAMOUNT,JOBNO ASC) AS 'ROW', JOBNO,JOBSTART,JOBEND,ROUNDAMOUNT,
CONVERT(VARCHAR(16),DATEWORKING,103) AS 'DATEWORKING',CONVERT(VARCHAR(10),DATEPRESENT,103) AS 'DATEPRESENT', CONVERT(VARCHAR(5), DATEPRESENT, 108) AS 'TIMEPRESENT'
FROM VEHICLETRANSPORTPLAN 
WHERE  CONVERT(DATE,DATEWORKING) =  CONVERT(DATE,GETDATE()-3)
AND (EMPLOYEECODE1 = '".$employeecode."' OR EMPLOYEECODE2 ='".$employeecode."')
ORDER BY ROUNDAMOUNT,JOBNO ASC";
$params_sePLanning_before3 = array();
$query_sePLanning_before3 = sqlsrv_query($conn, $sql_sePLanning_before3, $params_sePLanning_before3);
while($result_sePLanning_before3 = sqlsrv_fetch_array($query_sePLanning_before3, SQLSRV_FETCH_ASSOC)){

    if ($result_sePLanning_before3['ROW'] == '1') {
        $check_before3          = 'check';
        $dateworking1_before3   = $result_sePLanning_before3['DATEWORKING'];
        $jobno1_before3         = $result_sePLanning_before3['JOBNO'];
        // echo '<br>';
        $jobstart1_before3      = $result_sePLanning_before3['JOBSTART'];
        $jobend1_before3        = $result_sePLanning_before3['JOBEND'];
        $roundamount1_before3   = $result_sePLanning_before3['ROUNDAMOUNT'];
        $datetimepresent1_before3   = $result_sePLanning_before3['DATEPRESENT']." ".$result_sePLanning_before3['TIMEPRESENT'];
    }else {
        $jobno2_before3         = $result_sePLanning_before3['JOBNO'];
        // echo '<br>';
        $jobstart2_before3      = $result_sePLanning_before3['JOBSTART'];
        $jobend2_before3        = $result_sePLanning_before3['JOBEND'];
        $roundamount2_before3   = $result_sePLanning_before3['ROUNDAMOUNT'];
        $datetimepresent2_before3   = $result_sePLanning_before3['DATEPRESENT']." ".$result_sePLanning_before3['TIMEPRESENT'];
    }
}

// หาแผนงานวันที่ย้อนหลัง 4 วัน
$sql_sePLanning_before4 = "SELECT ROW_NUMBER() OVER(ORDER BY ROUNDAMOUNT,JOBNO ASC) AS 'ROW', JOBNO,JOBSTART,JOBEND,ROUNDAMOUNT,
CONVERT(VARCHAR(16),DATEWORKING,103) AS 'DATEWORKING',CONVERT(VARCHAR(10),DATEPRESENT,103) AS 'DATEPRESENT', CONVERT(VARCHAR(5), DATEPRESENT, 108) AS 'TIMEPRESENT'
FROM VEHICLETRANSPORTPLAN 
WHERE  CONVERT(DATE,DATEWORKING) =  CONVERT(DATE,GETDATE()-4)
AND (EMPLOYEECODE1 = '".$employeecode."' OR EMPLOYEECODE2 ='".$employeecode."')
ORDER BY ROUNDAMOUNT,JOBNO ASC";
$params_sePLanning_before4 = array();
$query_sePLanning_before4 = sqlsrv_query($conn, $sql_sePLanning_before4, $params_sePLanning_before4);
while($result_sePLanning_before4 = sqlsrv_fetch_array($query_sePLanning_before4, SQLSRV_FETCH_ASSOC)){

    if ($result_sePLanning_before4['ROW'] == '1') {
        $check_before4          = 'check';
        $dateworking1_before4   = $result_sePLanning_before4['DATEWORKING'];
        $jobno1_before4         = $result_sePLanning_before4['JOBNO'];
        // echo '<br>';
        $jobstart1_before4      = $result_sePLanning_before4['JOBSTART'];
        $jobend1_before4        = $result_sePLanning_before4['JOBEND'];
        $roundamount1_before4   = $result_sePLanning_before4['ROUNDAMOUNT'];
        $datetimepresent2_before4   = $result_sePLanning_before4['DATEPRESENT']." ".$result_sePLanning_before4['TIMEPRESENT'];
    }else {
        $jobno2_before4         = $result_sePLanning_before4['JOBNO'];
        // echo '<br>';
        $jobstart2_before4      = $result_sePLanning_before4['JOBSTART'];
        $jobend2_before4        = $result_sePLanning_before4['JOBEND'];
        $roundamount2_before4   = $result_sePLanning_before4['ROUNDAMOUNT'];
        $datetimepresent2_before4   = $result_sePLanning_before4['DATEPRESENT']." ".$result_sePLanning_before4['TIMEPRESENT'];
    }
}
?>

<html lang="en">
    <head>
        <link rel="shortcut icon" href="../images/self_check.ico" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>ข้อมูลแผนงาน</title>
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        <!--<link href="../dist/css/sb-admin-2.css" rel="stylesheet">-->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <style>
            .navbar-default {

                border-color: #ffcb0b;
            }

            .popover-content {
                padding: 10px 10px;
                width: 100px;
            }
            .nav>li>a {
                position: relative;
                display: block;
                padding: 14px 30px;

            }


            .styled-select.slate select {
                border: 1px solid #ccc;
                font-size: 16px;
                height: 34px;
                width: 150px;

            }

        </style>

    </head>
    <body>

        <div id="wrapper">

        <!-- <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        <div class="navbar-header" >
            <button type="button"  class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li><a href="meg_logout.php"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
        </ul>
        </nav> -->
        
            <div id="page-wrapper" >
                <div class="row">&nbsp;</div>
                <div class="row" >
                    <div class="col-lg-12" style="text-align: center">
                        <h2 class="page-header"><u>ข้อมูลการวิ่งงานประจำวัน</u></h2>
                    </div>

                    <!-- /.col-lg-12 -->
                </div>

                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <div class="row" >
                                    <div class="col-lg-6">

                                        รายงานแผนขนส่ง AMT

                                    </div>
                                    <div class="col-lg-6 text-right"></div>
                                </div>
                            </div> -->

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <div class="row">&nbsp;</div>
                                    <!-- <div class="row" >
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>ค้นหาตามช่วงวันที่</label> <font style="color: red">*</font>
                                                            <input class="form-control dateen" readonly=""  style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>ทะเบียนรถ</label> <font style="color: red">*</font>
                                                            <input type="text" class="form-control "    style="" id="txt_thainame" name="txt_thainame" placeholder="ทะเบียนรถ" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_driverchecking()">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>
                                                    </div>

                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                        <!-- เงื่อนไขในการเบิก -->
                                        <div class="col-lg-6">

                                            <?php
                                            $meg = 'ข้อมูลการวิ่งงาน';




                                            echo "<a href='index.php?type=report'>หน้าหลัก</a>  / " . $meg;
                                            $link = "<a href='index.php?type=report'>หน้าหลัก</a> ";
                                            $_SESSION["link"] = $link;
                                            ?>
                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label style="font-size:20px;color:red"><b>ข้อมูลพนักงาน</b></label><br>
                                                                <label style="font-size:16px">&nbsp;ชื่อ-นามสกุล: <?=$result_seEHR['nameT']?> </label><br>
                                                                <label style="font-size:16px">&nbsp;รหัสพนักงาน: <?=$result_seEHR['PersonCode']?> </label><br>
                                                                <label style="font-size:16px">&nbsp;บริษัท: <?=$result_seEHR['Company_NameT']?></label><br>
                                                                <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                            </div>
                                                        </div>
                                                            
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example" style="width: 100%;">
                                                      
                                                        <thead>
                                                                <tr>
                                                                    <th><label style="width: 100px">วิ่งงานวันที่</label></th>
                                                                    <th><label style="width: 100px">เลขที่งาน</label></th>
                                                                    <th><label style="width: 100px">ต้นทาง</label></th>
                                                                    <th><label style="width: 100px">คลัสเตอร์</label></th>
                                                                    <th><label style="width: 100px">รอบวิ่งงาน</label></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $sql_infolist = "SELECT ROUNDAMOUNT, JOBNO,JOBSTART,JOBEND,
                                                                CONVERT(VARCHAR(16),DATEWORKING,121) AS 'DATEWORKING'
                                                                FROM VEHICLETRANSPORTPLAN 
                                                                WHERE  CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,DATEADD(DAY,-4,GETDATE())) AND CONVERT(DATE,GETDATE())
                                                                AND (EMPLOYEECODE1 = '".$employeecode."' OR EMPLOYEECODE2 ='".$employeecode."')
                                                                ORDER BY JOBNO DESC";
                                                                $params_infolist = array();
                                                                $query_infolist = sqlsrv_query($conn, $sql_infolist, $params_infolist);
                                                                while ($result_infolist = sqlsrv_fetch_array($query_infolist, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= $result_infolist['DATEWORKING'] ?></td>
                                                                        <td><?= $result_infolist['JOBNO'] ?></td>
                                                                        <td><?= $result_infolist['JOBSTART'] ?></td>
                                                                        <td><?= $result_infolist['JOBEND'] ?></td>
                                                                        <td><?= $result_infolist['ROUNDAMOUNT'] ?></td>
                                                                    
                                                                    </tr>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- วิ่งงานวันที่ปัจจุบัน -->
                                        <?php
                                        if($check_current == 'check'){
                                        ?>

                                            <div class="row" >
                                                <div class="col-lg-12">
                                                    <div class="well">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label style="font-size:20px;color:black"><b>ข้อมูลการวิ่งงาน (วันที่ปัจจุบัน)</b></label><br>
                                                                    <label style="font-size:22px;color:blue">&nbsp;<u><b>วิ่งงานวันที่: <?=$dateworking1_current?></b> </u></label><br>
                                                                    <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label style="font-size:20px;color:red"><b>ข้อมูลการวิ่งงาน แผนที่ 1</b></label><br>
                                                                    <label style="font-size:22px;color:blue">&nbsp;<u><b>JOBNO: <?=$jobno1_current?></b> </u></label><br>
                                                                    <label style="font-size:16px">&nbsp;วันที่-เวลา รายงานตัว: <?=$datetimepresent1_current?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ต้นทาง: <?=$jobstart1_current?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ปลายทาง: <?=$jobend1_current?></label><br>
                                                                    <label style="font-size:16px;background-color: #FB510D;">&nbsp;รอบวิ่ง: <?=$roundamount1_current?></label><br>
                                                                    <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label style="font-size:20px;color:red"><b>ข้อมูลการวิ่งงาน แผนที่ 2</b></label><br>
                                                                    <label style="font-size:22px;color:blue">&nbsp;<u><b>JOBNO: <?=$jobno2_current?></b> </u></label><br>
                                                                    <label style="font-size:16px">&nbsp;วันที่-เวลา รายงานตัว: <?=$datetimepresent2_current?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ต้นทาง: <?=$jobstart2_current?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ปลายทาง: <?=$jobend2_current?></label><br>
                                                                    <label style="font-size:16px;background-color: #FB510D;">&nbsp;รอบวิ่ง: <?=$roundamount2_current?></label><br>
                                                                    <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                                </div>
                                                            </div>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <?php
                                        }
                                        ?>

                                        <!-- วิ่งงานย้อนหลัง 1 วันจากวันที่ปัจจุบัน -->
                                        <?php
                                        if($check_before1 == 'check'){
                                        ?>

                                            <div class="row" >
                                                <div class="col-lg-12">
                                                    <div class="well">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label style="font-size:20px;color:black"><b>ข้อมูลการวิ่งงาน</b></label><br>
                                                                    <label style="font-size:22px;color:blue">&nbsp;<u><b>วิ่งงานวันที่: <?=$dateworking1_before1?></b> </u></label><br>
                                                                    <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label style="font-size:20px;color:red"><b>ข้อมูลการวิ่งงาน แผนที่ 1</b></label><br>
                                                                    <label style="font-size:22px;color:blue">&nbsp;<u><b>JOBNO: <?=$jobno1_before1?></b> </u></label><br>
                                                                    <label style="font-size:16px">&nbsp;วันที่-เวลา รายงานตัว: <?=$datetimepresent1_before1?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ต้นทาง: <?=$jobstart1_before1?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ปลายทาง: <?=$jobend1_before1?></label><br>
                                                                    <label style="font-size:16px;background-color: #FB510D;">&nbsp;รอบวิ่ง: <?=$roundamount1_before1?></label><br>
                                                                    <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label style="font-size:20px;color:red"><b>ข้อมูลการวิ่งงาน แผนที่ 2</b></label><br>
                                                                    <label style="font-size:22px;color:blue">&nbsp;<u><b>JOBNO: <?=$jobno2_before1?></b> </u></label><br>
                                                                    <label style="font-size:16px">&nbsp;วันที่-เวลา รายงานตัว: <?=$datetimepresent2_before1?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ต้นทาง: <?=$jobstart2_before1?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ปลายทาง: <?=$jobend2_before1?></label><br>
                                                                    <label style="font-size:16px;background-color: #FB510D;">&nbsp;รอบวิ่ง: <?=$roundamount2_before1?></label><br>
                                                                    <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                                </div>
                                                            </div>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        
                                        <!-- วิ่งงานย้อนหลัง 2 วันจากวันที่ปัจจุบัน -->
                                        <?php   
                                        if($check_before2 == 'check'){
                                        ?>
                                    
                                            <div class="row" >
                                                <div class="col-lg-12">
                                                    <div class="well">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label style="font-size:20px;color:black"><b>ข้อมูลการวิ่งงาน</b></label><br>
                                                                    <label style="font-size:22px;color:blue">&nbsp;<u><b>วิ่งงานวันที่: <?=$dateworking1_before2?></b> </u></label><br>
                                                                    <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label style="font-size:20px;color:red"><b>ข้อมูลการวิ่งงาน แผนที่ 1</b></label><br>
                                                                    <label style="font-size:22px;color:blue">&nbsp;<u><b>JOBNO: <?=$jobno1_before2?></b> </u></label><br>
                                                                    <label style="font-size:16px">&nbsp;วันที่-เวลา รายงานตัว: <?=$datetimepresent1_before2?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ต้นทาง: <?=$jobstart1_before2?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ปลายทาง: <?=$jobend1_before2?></label><br>
                                                                    <label style="font-size:16px;background-color: #FB510D;">&nbsp;รอบวิ่ง: <?=$roundamount1_before2?></label><br>
                                                                    <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label style="font-size:20px;color:red"><b>ข้อมูลการวิ่งงาน แผนที่ 2</b></label><br>
                                                                    <label style="font-size:22px;color:blue">&nbsp;<u><b>JOBNO: <?=$jobno2_before2?></b> </u></label><br>
                                                                    <label style="font-size:16px">&nbsp;วันที่-เวลา รายงานตัว: <?=$datetimepresent2_before2?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ต้นทาง: <?=$jobstart2_before2?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ปลายทาง: <?=$jobend2_before2?></label><br>
                                                                    <label style="font-size:16px;background-color: #FB510D;">&nbsp;รอบวิ่ง: <?=$roundamount2_before2?></label><br>
                                                                    <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                                </div>
                                                            </div>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <!-- วิ่งงานย้อนหลัง 3 วันจากวันที่ปัจจุบัน -->    
                                        <?php
                                        if($check_before3 == 'check'){
                                        ?>
                                    
                                            <div class="row" >
                                                <div class="col-lg-12">
                                                    <div class="well">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label style="font-size:20px;color:black"><b>ข้อมูลการวิ่งงาน</b></label><br>
                                                                    <label style="font-size:22px;color:blue">&nbsp;<u><b>วิ่งงานวันที่: <?=$dateworking1_before3?></b> </u></label><br>
                                                                    <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label style="font-size:20px;color:red"><b>ข้อมูลการวิ่งงาน แผนที่ 1</b></label><br>
                                                                    <label style="font-size:22px;color:blue">&nbsp;<u><b>JOBNO: <?=$jobno1_before3?></b> </u></label><br>
                                                                    <label style="font-size:16px">&nbsp;วันที่-เวลา รายงานตัว: <?=$datetimepresent1_before3?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ต้นทาง: <?=$jobstart1_before3?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ปลายทาง: <?=$jobend1_before3?></label><br>
                                                                    <label style="font-size:16px;background-color: #FB510D;">&nbsp;รอบวิ่ง: <?=$roundamount1_before3?></label><br>
                                                                    <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label style="font-size:20px;color:red"><b>ข้อมูลการวิ่งงาน แผนที่ 2</b></label><br>
                                                                    <label style="font-size:22px;color:blue">&nbsp;<u><b>JOBNO: <?=$jobno2_before3?></b> </u></label><br>
                                                                    <label style="font-size:16px">&nbsp;วันที่-เวลา รายงานตัว: <?=$datetimepresent2_before3?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ต้นทาง: <?=$jobstart2_before3?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ปลายทาง: <?=$jobend2_before3?></label><br>
                                                                    <label style="font-size:16px;background-color: #FB510D;">&nbsp;รอบวิ่ง: <?=$roundamount2_before3?></label><br>
                                                                    <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                                </div>
                                                            </div>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        <?php
                                        }
                                        ?>
                                        
                                        <!-- วิ่งงานย้อนหลัง 4 วันจากวันที่ปัจจุบัน -->    
                                        <?php
                                        if($check_before4 == 'check'){
                                        ?>
                                    
                                            <div class="row" >
                                                <div class="col-lg-12">
                                                    <div class="well">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label style="font-size:20px;color:black"><b>ข้อมูลการวิ่งงาน</b></label><br>
                                                                    <label style="font-size:22px;color:blue">&nbsp;<u><b>วิ่งงานวันที่: <?=$dateworking1_before4?></b> </u></label><br>
                                                                    <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label style="font-size:20px;color:red"><b>ข้อมูลการวิ่งงาน แผนที่ 1</b></label><br>
                                                                    <label style="font-size:22px;color:blue">&nbsp;<u><b>JOBNO: <?=$jobno1_before4?></b> </u></label><br>
                                                                    <label style="font-size:16px">&nbsp;ต้นทาง: <?=$jobstart1_before4?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ปลายทาง: <?=$jobend1_before4?></label><br>
                                                                    <label style="font-size:16px;background-color: #FB510D;">&nbsp;รอบวิ่ง: <?=$roundamount1_before4?></label><br>
                                                                    <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label style="font-size:20px;color:red"><b>ข้อมูลการวิ่งงาน แผนที่ 2</b></label><br>
                                                                    <label style="font-size:22px;color:blue">&nbsp;<u><b>JOBNO: <?=$jobno2_before4?></b> </u></label><br>
                                                                    <label style="font-size:16px">&nbsp;ต้นทาง: <?=$jobstart2_before4?> </label><br>
                                                                    <label style="font-size:16px">&nbsp;ปลายทาง: <?=$jobend2_before4?></label><br>
                                                                    <label style="font-size:16px;background-color: #FB510D;">&nbsp;รอบวิ่ง: <?=$roundamount2_before4?></label><br>
                                                                    <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                                </div>
                                                            </div>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        <?php
                                        }
                                        ?>
                                   
                                    

                                </div>


                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                </div>
                <!-- /.ro   w -->

            </div>
            

                                                          


            <script src="../vendor/jquery/jquery.min.js"></script>
            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../js/jquery.datetimepicker.full.js"></script>
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>

            <!-- Data Table Export File -->
            <!-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
            <script src="//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json"></script> -->
              <?php
              $thainame = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');
              ?>                                                  

                            
            <script>
                        
                        
                        

                        var txt_thainame = [<?= $thainame ?>];
                            $("#txt_thainame").autocomplete({
                            source: [txt_thainame]
                        });


                        
                        // function print_data(params) {
                           
                                    


                        //     $(document).ready(function() {
                        //         $('#example').DataTable( {
                        //             dom: 'Bfrtip',
                        //             buttons: [
                        //                 'print'
                        //             ]
                        //         } );
                        //     } );



                        // }
                        function checking_data(employeecode,employeename,jobno,thainame,date,time)
                        {
                            // alert(employeecode);
                            // alert(jobno);
                            // alert(thainame);

                            $.ajax({
                                type: 'post',
                                url: 'meg_data2.php',
                                data: {
                                    txt_flg: "select_selfcheckingdetail", employeecode: employeecode,employeename: employeename,jobno: jobno,thainame: thainame,date: date,time: time
                                },
                                success: function (response) {
                                    if (response){

                                    document.getElementById("datacompdetailsr").innerHTML = response;
                                    // document.getElementById("datacompdetaildef").innerHTML = "";

                                    }




                                }
                            });
                        }
                        function warning(checkid,createdate)
                        {
                            
                         alert("มีข้อมูลการตรวจสอบตนเองของวันที่ "+createdate+" แล้ว เลขไอดีคือ "+checkid);  
                    
                            
                        }
                        function checking_data1(employeecode,employeename,date)
                        {
                            if (employeecode == '') {
                                alert('ไม่สามารถดำเนินการได้ กรุณาตรวจสอบ รหัสพนักงาน หรือ ชื่อ-นามสกุล');
                            }else{
                                $type = 'insert';
                                window.open('meg_selfcheckdetail.php?employeecode=' + employeecode+'&employeename='+employeename+'&datedriverchk='+date+'&dateworkingchk='+" "+'&datepresentchk='+" "+'&type='+$type, '_blank');
                            }
                            
                        }
                        function checking_data2(employeecode,employeename,date,selfcheckid)
                        {
                            if (employeecode == '') {
                                alert('ไม่สามารถดำเนินการได้ กรุณาตรวจสอบ รหัสพนักงาน หรือ ชื่อ-นามสกุล');
                            }else{
                                $type = 'driverupdate';
                                window.open('meg_selfcheckdetail_driverupdate.php?employeecode=' + employeecode+'&employeename='+employeename+'&datedriverchk='+date+'&dateworkingchk='+" "+'&id='+selfcheckid+'&datepresentchk='+" "+'&type='+$type, '_blank');
                            }
                            
                        }
                        
                        
                        $(function () {
                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                            // กรณีใช้แบบ input
                            $(".dateen").datetimepicker({
                                timepicker: false,
                                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                            });
                        });
                        $(document).ready(function () {
                            $('#dataTables-example').DataTable({
                                responsive: true,
                                charset: 'UTF-8',
                                fieldSeparator: ';',
                                bom: true,
                                dom: 'Bfrtip',
                                order: [[2, 'desc']],
                                buttons: [
                                    'copy', 'csv', 'excel', 'pdf', 'print'
                                ]
                            });
                        });


                        

            </script>


    </body>

    




</html>
<?php
sqlsrv_close($conn);
?>
