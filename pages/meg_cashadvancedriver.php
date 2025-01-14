<!DOCTYPE html>
<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

// echo $_SESSION["USERNAME"];
if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["PASSWORD"])) {
    header("location:../pages/meg_login.php?data=3");
}

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

// echo $result_seEHR['PositionNameE'];
$positionchk   =  $result_seEHR['PositionNameE'];

if ($positionchk == 'Driver') {
    $position = 'Driver';
}else{
    $position = 'Other';
}
// echo $position;


// $condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
// $sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
// $params_seEmployee = array(
//     array('select_employee', SQLSRV_PARAM_IN),
//     array($condition1, SQLSRV_PARAM_IN)
// );
// $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
// $result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);


// $condition2_1 = " AND (CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103))";
// $condition2_2 = "";
// $condition2_3 = "";

// $sql_seVehicletransportplan = "{call megVehicletransportplan_v2(?,?,?,?)}";
// $params_seVehicletransportplan = array(
//     array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
//     array($condition2_1, SQLSRV_PARAM_IN),
//     array($condition2_2, SQLSRV_PARAM_IN),
//     array($condition2_3, SQLSRV_PARAM_IN)
// );
// $query_seVehicletransportplan = sqlsrv_query($conn, $sql_seVehicletransportplan, $params_seVehicletransportplan);
// $result_seVehicletransportplan = sqlsrv_fetch_array($query_seVehicletransportplan, SQLSRV_FETCH_ASSOC);

//เช็ค week ในการเบิกจาก DB
$sql_weekchk = "SELECT TOP 1 FORMAT (DATE_ADV, 'yyyy-MM-dd') AS 'DATEWEEK',
                FORMAT (DATE_ADV, 'dd/MM/yyyy') AS 'DATECHK'
                FROM [dbo].[CLASHADVANCE] WHERE EMPLOYEECODE ='".$_SESSION['USERNAME']."'
                AND ACTIVESTATUS ='1'
                ORDER BY DATE_ADV DESC";
$params_weekchk = array();
$query_weekchk = sqlsrv_query($conn, $sql_weekchk , $params_weekchk );
$result_weekchk = sqlsrv_fetch_array($query_weekchk, SQLSRV_FETCH_ASSOC);

// echo $_SESSION['USERNAME']; echo '<br>';
// echo $result_weekchk['DATEWEEK']; echo '<br>';


$weekchk   =  $result_weekchk['DATEWEEK'];

if ($weekchk == '') {
    $week1 = '00';
}else{
    $week1 = date("W", strtotime($weekchk));
}



//เช็ค week จากวันที่ปัจจุบ้น
// echo date("Y-m-d");
$weekcurrent = date("Y-m-d");echo '<br>';
$week2 = date("W", strtotime($weekcurrent));

// echo '<br>';
// echo $week1;echo '<br>';
// echo $week2;


$sql_passdatechk = "SELECT (SUBSTRING(PassDate, 7, 10)+'-'+SUBSTRING(PassDate, 4, 2)+'-'+SUBSTRING(PassDate, 1, 2)) AS 'PASSDATE',PassDate 
FROM EMPLOYEEEHR2 WHERE PersonCode ='".$_SESSION['USERNAME']."'";
$params_passdatechk = array();
$query_passdatechk = sqlsrv_query($conn, $sql_passdatechk , $params_passdatechk );
$result_passdatechk = sqlsrv_fetch_array($query_passdatechk, SQLSRV_FETCH_ASSOC);

$date1 = $result_passdatechk['PASSDATE']; //pass date
$date2 = date("Y-m-d"); //currentdate

//comparison passdate and currentdate  

if ($date1 < $date2) {
    // echo "ผ่านโปรแล้ว"; // 1
    $pass = '1';
    }
else{
    // echo "ยังไม่ผ่านโปร"; //2
    $pass = '2';
    }

$empchk = substr($_SESSION['USERNAME'],0,2);

// ข้อมูลทดสอบเวลาการเบิก
$today = date("H:i");
// echo "<br>";
 $today2 = date("16:00");  
// echo "<br>";
 $today3 = date("13:30");  
// echo "<br>";
 strtotime($today);
// echo "<br>";
 strtotime($today2);
// echo "<br>";
 strtotime($today3);
// echo "<br>";
 $dayname = date('D');

?>

<html lang="en">
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>กลุ่มร่วมกิจรุ่งเรือง</title>
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
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

            .swal2-popup {
                font-size: 16px !important;
                padding: 17px;
                border: 1px solid #F0E1A1;
                display: block;
                margin: 22px;
                text-align: center;
                color: #61534e;
            }
            
            #loading {
                display:none; 
                opacity: 0.5;
                /* border-radius: 50%; */
                /* border-top: 12px ; */
                width: 10px;
                left: 10px;
                right: 800px;
                top:10px;
                bottom: 450px;
                height: 10px;
                
                /* animation: spin 1s linear infinite; */
            }
            
            .center {
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                margin: auto;
            }
        </style>

    </head>
    <body>

        <div id="wrapper">

        <!-- <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0"> -->

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
        </nav>
        <input type="hidden" id="txt_weekchk" name="txt_weekchk" value="<?=$week1?>">  
            <div id="page-wrapper" >
                <div class="row">&nbsp;</div>
                <div class="row" >
                    <div class="col-lg-2" style="text-align: center">
                        <h2 class="page-header">ระบบเบิกเงินล่วงหน้า</h2>
                    </div>
                    <div class="col-lg-4" style="text-align: center" >
                        <h2 class="page-header"> (<?=$_SESSION["USERNAME"]?>&nbsp;&nbsp;<?=$result_seEHR['nameT']?>)</h2>
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
                                    <div class="row" >
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label>ค้นหาตามช่วงวันที่</label>
                                                            <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_reportclashadvance('<?= $_SESSION['USERNAME'] ?>')">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>

                                                    </div>

                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- เงื่อนไขในการเบิก -->
                                    <div class="row" >
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label style="font-size:20px;color:red"><b>เงื่อนไขในการให้เบิก</b></label><br>
                                                            <label style="font-size:14px">&nbsp;1.เบิก 1,000 บาทขึ่้นไป สำหรับพนักงานที่ผ่านโปรแล้วเท่านั้น</label><br>
                                                            <label style="font-size:14px">&nbsp;2.เบิก 500 บาทสำหรับพนักงานที่ยังไม่ผ่านโปร</label><br>
                                                            <label style="font-size:14px">&nbsp;3.จะเบิกได้ตั้งแต่ จันทร์-พุธ ของแต่ละสัปดาห์ </label><br>
                                                            <label style="font-size:14px">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br>
                                                        </div>
                                                    </div>
                                                        <!-- <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>เงื่อนไขในการให้เบิก</label>
                                                                <label>เงื่อนไขในการให้เบิก</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>เงื่อนไขในการให้เบิก</label>
                                                                <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>เงื่อนไขในการให้เบิก</label>
                                                                <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>
                                                        </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Class ในการแสดงข้อมูลการให้เบิกเงินล่วงหน้า วันจันทร์ - วันพุธ เท่านั้น -->
                                     <?php
                                    if ($dayname =='Mon' || $dayname =='Tue' || $dayname =='Wed') {
                                     ?>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label style="color:red">*</label><label>วันที่ต้องการเบิก</label>
                                                                <!-- onchange="check_advancebefore()" -->
                                                                <input class="form-control dateenweek" readonly=""  style="background-color: #f080802e"  id="txt_datemoney" name="txt_datemoney" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่ต้องการเบิก">
                                                            </div>
                                                        </div>    
                                                        <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <select id="txt_money" name="txt_money" class="form-control" onchange="select_customer(this.value)">
                                                            
                                                            <?php
                                                            if ($pass == '1') {
                                                                ?>
                                                                    <?php
                                                                    // พนักงานฝั่งอมตะ 
                                                                    if ($empchk =='01' || $empchk =='02' || $empchk =='06' || $empchk =='07' ) {
                                                                    ?>
                                                                        <option value="1000">1,000 บาท</option>
                                                                        <option value="500">500 บาท</option> 
                                                                    <?php
                                                                    }else {
                                                                    ?>
                                                                    <!-- พนักงานฝั่งเกตเวย์ และ เจ้าหน้าที่ IT SYSTEM TMS ADMIN  -->
                                                                        <?php
                                                                        if ($position == 'Driver' || $_SESSION["ROLENAME"] == 'ADMIN') {
                                                                        ?>
                                                                            <!-- <option value="4000">4,000 บาท</option> -->
                                                                            <option value="2000">2,000 บาท</option>
                                                                            <option value="1000">1,000 บาท</option>
                                                                        <?php
                                                                        }else{
                                                                        ?>
                                                                            <!-- <option value="4000">4,000 บาท</option> -->
                                                                            <option value="1000">1,000 บาท</option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <option value="500">500 บาท</option>  
                                                                <?php
                                                            }
                                                            ?>
                                                            
                                                        </select>
                                                        </div>
                                                        <!-- <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>จำนวนเงินที่ต้องการเบิก</label>
                                                                <input class="form-control "    onblur="check();" id="txt_money" name="txt_money" value="1000" placeholder="จำนวนเงินที่ต้องการเบิก" autocomplete ="off">
                                                            </div>
                                                        </div> -->
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label style="color:red">*</label><label>เหตุผลในการเบิก</label>
                                                                <input class="form-control"  onblur="check();"  id="txt_reason" name="txt_reason" value="" placeholder="เหตุผลในการเบิก" autocomplete ="off">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-lg-2" style="text-align: center">
                                                            <label>&nbsp;</label><br>
                                                            <?php
                                                        if ($week1 == $week2) {
                                                            ?>
                                                            <a href="#" onclick="add_clashchk('<?=$result_weekchk['DATECHK']?>');" class="btn btn-danger">บันทึกข้อมูล</a>
                                                            <?php
                                                        }else {
                                                            ?>
                                                            <a href="#" onclick="add_clashadv('<?= $_SESSION['USERNAME'] ?>','<?= $result_seEHR['nameT'] ?>');" class="btn btn-success">บันทึกข้อมูล</a>
                                                            <?php
                                                        } 
                                                        ?>
                                                        </div>
                                                        
                                                        <!-- <div class="col-lg-2" style="text-align: left">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="add_clashadv('<?= $_SESSION['USERNAME'] ?>','<?= $result_seEHR['nameT'] ?>');" class="btn btn-success">บันทึกข้อมูล</a>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      <?php
                                    }else{
                                      ?>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group" style="color:red;text-align: center;font-size:30px">
                                                                เบิกเงินล่วงหน้าเฉพาะ
                                                                <!-- onchange="check_advancebefore()" -->
                                                            </div>
                                                            <br>
                                                            <div class="form-group" style="color:red;text-align: center;font-size:30px">
                                                                วันจันทร์-วันพุธ เท่านั้น
                                                                <!-- onchange="check_advancebefore()" -->
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      <?php
                                    }
                                      ?>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                    <h4>ประวัติการเบิก</h4>
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>เลขที่</th>
                                                                        <th>วันที่</th>
                                                                        <th>รหัสพนักงาน</th>
                                                                        <th>ชื่อ-นามสกุล</th>
                                                                        <th>จำนวนเงิน</th>
                                                                        <th>เหตุผล</th>
                                                                        <th>สถานะ</th>
                                                                        <th>หมายเหตุ</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                    $i = 1;

                                                                    $sql_seClashAdv = "SELECT CLASHID,CONVERT(VARCHAR(10), DATE_ADV, 103) AS 'DATE',EMPLOYEECODE,EMPLOYEENAME,PRICE,REASON,STATUS_ADV 
                                                                    FROM [dbo].[CLASHADVANCE]
                                                                    WHERE  CONVERT(DATE,DATE_ADV) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103)
                                                                    AND EMPLOYEECODE ='".$_SESSION['USERNAME']."' 
                                                                    AND ACTIVESTATUS = '1'";

                                                                    $query_seClashAdv = sqlsrv_query($conn, $sql_seClashAdv, $params_seClashAdv);
                                                                    while ($result_seClashAdv = sqlsrv_fetch_array($query_seClashAdv, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr>
                                                                    <td><?= $result_seClashAdv['CLASHID'] ?></td>
                                                                    <td><?= $result_seClashAdv['DATE'] ?></td>
                                                                    <td><?= $result_seClashAdv['EMPLOYEECODE'] ?></td>
                                                                    <td><?= $result_seClashAdv['EMPLOYEENAME'] ?></td>
                                                                    <td><?= $result_seClashAdv['PRICE'] ?></td>
                                                                    <td><?= $result_seClashAdv['REASON'] ?></td><?php
                                                                    if($result_seClashAdv['STATUS_ADV'] =='R'){
                                                                    ?>
                                                                    <td style="background-color: #ffd500">R (กำลังดำเนินการ)</td>                         
                                                                    <?php  
                                                                    }else{
                                                                    ?>
                                                                    <td style="background-color: #07b015">A (อนุมัติ)</td>                 
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <td><?= $result_seClashAdv['REMARK'] ?></td>
                                                                    <td>
                                                                        <!-- <button onclick="pdf_invoicerkstaw('<?= $result_seInvoice['INVOICECODE'] ?>')" title="แก้ไขข้อมูล" type="button" class="btn btn-default btn-circle"><span class="fa fa-pencil-square-o"></span></button> -->
                                                                        <button onclick="delete_adv('<?= $result_seClashAdv['CLASHID'] ?>','<?=$result_seClashAdv['STATUS_ADV']?>');" title="ลบข้อมูล" type="button" class="btn btn-danger btn-circle"><span class="fa fa-trash-o"></span></button>
                                                                    </td>
                                                                </tr>    
                                                                <?php
                                                                    $i++;
                                                                }
                                                                ?>
                                                                </tbody>

                                                            </table>

                                                        </div>
                                                        <div id="datasr"></div>
                                                    </div>

                                                    
                                                    <!-- /.panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                </div>
                <!-- /.row -->

            </div>

        <div class="container">
          <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><b>ข้อมูลการคีย์ค่าตอบแทนของพนักงาน </b></h4>
                </div>
                <div class="modal-body">
                  <div id="datacompdetailsr"></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>

            </div>
          </div>
        </div>                                                    

             <!-- this will show our spinner -->
            <div  id="loading" class="center" >
                <p><img style="" src="../images/truckload5.gif" /></p>
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
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
            <script>

                        function showLoading() {
                            $("#loading").show();
                            
                        }

                        function hideLoading() {
                            $("#loading").hide();
                        }

                        function check()
                        {
                            var elem = document.getElementById('txt_reason').value;
                            if( elem.match(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi) )
                            {
                                alert("ไม่สามารถใช้ตัวอักษรพิเศษได้");
                                document.getElementById('txt_reason').value = "";
                            }

                            // if(elem > '1000'){
                            //     alert("เกินจำนวนที่เบิกได้");
                            //     document.getElementById('txt_money').value = "";
                            // }
                        }

                        function select_reportclashadvance(username)
                        {

                            showLoading();
                            var datestart = document.getElementById('txt_datestart').value;
                            var dateend = document.getElementById('txt_dateend').value;
                           
                            // alert(username); 
                            // alert(datestart);
                            // alert(dateend);
                            
                            $.ajax({
                                type: 'post',
                                url: 'meg_data.php',
                                data: {
                                    txt_flg: "select_reportclashadvance", datestart: datestart, dateend: dateend,username: username
                                },
                                success: function (response) {
                                    hideLoading();
                                    // alert('โหลดข้อมูลเรียบร้อย');
                                    swal.fire({
                                        title: "Good Job!",
                                        text: "โหลดข้อมูลเรียบร้อย",
                                        icon: "success",
                                    });
                                    
                                    if (response)
                                    {
                                        document.getElementById("datasr").innerHTML = response;
                                        document.getElementById("datadef").innerHTML = "";
                                    }
                                    $(document).ready(function () {
                                        $('#dataTables-example').DataTable({
                                            responsive: true,
                                        });
                                    });



                                }
                            });


                        }
                        function add_clashchk(datechk) {
                            // alert('คุณได้เบิกเงินไปแล้วภายในสัปดาห์นี้ วันที่'+" "+datechk );    
                            swal.fire({
                                allowOutsideClick: false,
                                title: "Warning !!",
                                text: "คุณได้เบิกเงินไปแล้วภายในสัปดาห์นี้ วันที่"+" "+datechk,
                                icon: "warning",
                            });
                        }
                        
                        function add_clashadv(employeecode,employeename)
                        {

                            
                            var price = document.getElementById('txt_money').value;
                            var reason = document.getElementById('txt_reason').value;
                            var datemoney = document.getElementById('txt_datemoney').value;

                            // alert(employeecode);
                            // alert(employeename);
                            // alert(price);
                            // alert(reason);
                           
                            
                            if ((datemoney !='')&&(price !='')&&(reason !='')) {
                                    // alert('สามารถบันทึกข้อมูลได้');


                                    $.ajax({
                                    type: 'post',
                                    url: 'meg_data.php',
                                    data: {
                                        txt_flg: "add_adv", employeecode: employeecode,employeename: employeename,price: price,reason: reason,datemoney: datemoney
                                    },
                                    success: function (rs) {
                                        // alert('บันทึกข้อมูลเรียบร้อย');
                                        // location.reload();
                                        swal.fire({
                                            title: "Good Job!",
                                            text: "บันทึกข้อมูลเรียบร้อย",
                                            allowOutsideClick: false,
                                            showConfirmButton: false,
                                            icon: "success"
                                        });
                                        // alert(rs);   
                                        setTimeout(() => {
                                            document.location.reload();
                                        }, 1500);

                                    }
                                });
                            }else{
                                if (datemoney == '') {
                                    // alert('ไม่ได้ใส่วันที่');
                                    swal.fire({
                                        allowOutsideClick: false,
                                        title: "Warning !!",
                                        text: "ไม่ได้ใส่วันที่",
                                        icon: "warning",
                                    });
                                }else if(price == ''){
                                    // alert('ไม่ได้ใส่ราคา');
                                    swal.fire({
                                        allowOutsideClick: false,
                                        title: "Warning !!",
                                        text: "ไม่ได้ใส่ราคา",
                                        icon: "warning",
                                    });
                                }else if(reason == ''){
                                    // alert('ไม่ได้ใส่เหตุผลในการเบิก');
                                    swal.fire({
                                        allowOutsideClick: false,
                                        title: "Warning !!",
                                        text: "ไม่ได้ใส่เหตุผลในการเบิก",
                                        icon: "warning",
                                    });
                                }else{
                                    // alert('โปรดตรวจสอบ วันที่ ราคา และเหตุผลในการเบิก');
                                    swal.fire({
                                        allowOutsideClick: false,
                                        title: "Warning !!",
                                        text: "โปรดตรวจสอบ วันที่ ราคา และเหตุผลในการเบิก",
                                        icon: "warning",
                                    });
                                }
                            }

                                
                            // $.ajax({
                            //     type: 'post',
                            //     url: 'meg_data.php',
                            //     data: {
                            //         txt_flg: "add_adv", employeecode: employeecode,employeename: employeename,price: price,reason: reason,datemoney: datemoney
                            //     },
                            //     success: function (rs) {
                            //         alert('บันทึกข้อมูลเรียบร้อย');
                            //         location.reload();


                            //     }
                            // });

                        }
                        
                        function delete_adv(ID,status)
                        {

                            // alert(status);
                            if (status == 'A'|| status == 'D') {
                                // alert("ถูกอนุมัติแล้วไม่สามารถลบได้ กรุณาติดต่อเจ้าหน้าที่");
                                swal.fire({
                                    allowOutsideClick: false,
                                    title: "Warning !",
                                    text: "ถูกอนุมัติแล้วไม่สามารถลบได้ กรุณาติดต่อเจ้าหน้าที่",
                                    icon: "warning",
                                });
                            }else{

                                Swal.fire({
                                    title: 'ต้องการลบข้อมูล?',
                                    text: "กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    allowOutsideClick: false,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'ตกลง',
                                    cancelButtonText: 'ยกเลิก'
                                }).then((result) => {
                                    
                                    if (result.isConfirmed) {
                                        
                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "delete_adv", ID: ID,employeecode: '',employeename: '',price: '',reason: '',datemoney: ''
                                            },
                                            success: function (rs) {
                                                    // alert('ลบข้อมูลเรียบร้อย');
                                                    // location.reload();
                                                    swal.fire({
                                                        title: "Good Job!",
                                                        text: "ลบข้อมูลเรียบร้อย",
                                                        allowOutsideClick: false,
                                                        showConfirmButton: false,
                                                        icon: "success"
                                                    });
                                                    // alert(rs);   
                                                    setTimeout(() => {
                                                        document.location.reload();
                                                    }, 1500);
                                                }
                                        });



                                    }else{
                                        //else check การลบข้อมูล
                                        // window.location.reload();
                                    }
                                })

                                


                            }
                            

                        }
                        

                        function datetodate()
                        {
                            document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                        }
                        $(function () {
                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                            // กรณีใช้แบบ input
                            $(".dateenweek").datetimepicker({
                                timepicker: false,
                                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                beforeShowDay: noWeekends

                            });
                        });
                        function noWeekends(date) {
                            var day = date.getDay();
                            // ถ้าวันเป็นวันอาทิตย์ (0) หรือวันเสาร์ (6)
                            if (day === 0  || day === 4 || day === 5 || day === 6) {

                                // เลือกไม่ได้
                                return [false, "", "ไม่สามารถเลือกได้ วันที่ไม่อยู่ในเงื่อนไข"];
                            }
                            // เลือกได้ตามปกติ
                            return [true, "", ""];
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
                            });
                        });

            </script>


    </body>

    




</html>
<?php
sqlsrv_close($conn);
?>
