<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

// Update_Time_Data('update'); // อัพเดทฐานข้อมูล ทุกครั้งที่เปิดหน้านี้

// $condEmp = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEmp = "SELECT a.PersonCode,(a.FnameT+' '+a.LnameT) AS nameT
    FROM  [dbo].[EMPLOYEEEHR2] a
    WHERE a.PersonCode IN('".$_SESSION["USERNAME"]."')";
$params_seEmp = array();
$query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
$result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC);




// echo $_SESSION["USERNAME"];
?>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta charset="utf-8">
        <!-- auto refresh screen for update truck status -->
        <!-- <meta http-equiv="refresh" content="1800" >   -->
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
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
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <style>
            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {
                border-left: 1px solid #ffcb0b;
            }
            .popover-content {
                padding: 10px 10px;
                width: 200px;
            }
            .nav>li>a {
                position: relative;
                display: block;
                padding: 14px 30px;
            }
            .button {
            display: inline-block;
            padding: 15px 25px;
            font-size: 24px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
            }

            .button:hover {background-color: #3e8e41}

            .button:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(10px);
            }

            .button1 {
            display: inline-block;
            padding: 15px 25px;
            font-size: 20px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4c8baf;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
            }

            .button1:hover {background-color: #4c8baf}

            .button1:active {
            background-color: #3e568e;
            box-shadow: 0 5px #999;
            transform: translateY(10px);
            }
            </style>
        </head>
        <body>
            <div id="wrapper">
                <!-- Navigation -->
                
                <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <?php
                    if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["PASSWORD"])) {
                        header("location:meg_login.php?data=" . $_GET['data']);
                    }
                    ?>
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">

                                    <li><a href="meg_logout.php"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>



                    <div class="row">

                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" >
                                    
                                    <div class="col-md-6">
                                        <a href="index2.php">หน้าหลัก</a> / Truck readiness check </a>
                                    </div>


                                <br>
                                <div class="panel-body">
                                    <div class="row">&nbsp;</div>
                                    <div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>เลือกเดือน</label><br>   
                                                <select id="select_monthtruckkpi" name="select_monthtruckkpi" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก เดือนที่จะค้นหา" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                    <option value="">เลือกเดือน</option>
                                                    <option value="01">มกราคม</option>
                                                    <option value="02">กุมภาพันธ์</option>
                                                    <option value="03">มีนาคม</option>
                                                    <option value="04">เมษายน</option>
                                                    <option value="05">พฤษภาคม</option>
                                                    <option value="06">มิถุนายน</option>
                                                    <option value="07">กรกฎาคม</option>
                                                    <option value="08">สิงหาคม</option>
                                                    <option value="09">กันยายน</option>
                                                    <option value="10">ตุลาคม</option>
                                                    <option value="11">พฤศจิกายน</option>
                                                    <option value="12">ธันวาคม</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>เลือกปี</label><br>   
                                                <select id="select_yeartruckkpi" name="select_yeartruckkpi" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปีที่จะค้นหา" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                    <!-- <option value="">เลือกปี</option>
                                                    <?php
                                                    $sql_seMonthst = "SELECT DISTINCT CREATEYEAR+543 AS 'YEAR'  
                                                    FROM [dbo].[HEALTHHISTORY]";
                                                    $params_seMonthst = array();
                                                    $query_seMonthst = sqlsrv_query($conn, $sql_seMonthst, $params_seMonthst);
                                                    while ($result_seMonthst = sqlsrv_fetch_array($query_seMonthst, SQLSRV_FETCH_ASSOC)) {
                                                        ?>
                                                        <option value="<?= $result_seMonthst['YEAR']-543 ?>"><?= $result_seMonthst['YEAR'] ?></option>
                
                                                        <?php
                                                    }
                                                    ?> -->
                                                    <?php
                                                    for ($y = 1993; $y <= 2100; $y++) { ?>
                                                    <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y+543?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-1" >
                                            <div class="form-group">
                                                <label>พิมพ์ข้อมูล KPI</label><br>
                                                <button type="button" class="btn btn-primary btn-md" name="btn_printexceltenkokpi" id ="btn_printexceltenkokpi" onclick="print_tenkokpi();"  >พิมพ์ข้อมูล KPI</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-2" >
                                            <div class="form-group">
                                                <label>ดูข้อมูลกราฟ KPI</label><br>
                                                <button type="button" class="btn btn-primary btn-md" name="btn_printexceltenkokpi" id ="btn_printexceltenkokpi" onclick="search_graph();"  >ดูข้อมูลกราฟ KPI</button>
                                            </div>
                                        </div>
                                    </div>
                                    

                                </div>
                                    <div class="row" id="loading"></div>
                                    <div class="row" id="list-data">
                                    <div class="col-lg-12">&nbsp;</div>
                                    <div class="col-lg-12" style="font-size: 40px;">เลือกเมนูที่จะลงข้อมูล:</div>
                                    <div class="col-lg-12">&nbsp;</div>
                                    <div class="col-lg-12">&nbsp;</div>
                                    <div class="col-lg-12" style="text-align: center;">
                                        <b style="font-size: 18px"></b>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('TotalTruck')">Total Truck</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('SpareTruck')">Spare Truck</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('Requirement')">Requirement</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('TruckAtt')">Truck  attend</button>
                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                                    <div class="col-lg-12" style="text-align: center;">
                                        <b style="font-size: 18px"></b>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('TruckAttper')">Truck attendance %</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchTruckReadiness('TruckOK')">Truck OK</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('Truck_NG')">NG</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('WheelandTcon')">Wheel & tire condition</button>
                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                                    <div class="col-lg-12" style="text-align: center;">
                                        <b style="font-size: 18px"></b>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('SpareWheel')">Spare wheel</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('WarningLight')">Warning light at dashboard</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('DrainWater')">Drain water from air tank</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('SafetyEqup')">Safety equipment</button>
                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                                    <div class="col-lg-12" style="text-align: center;">
                                        <b style="font-size: 18px"></b>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('EngineNoise')">Engine noise</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('BrakeSystem')">Brake system</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('LightingSystem')">Lighting system</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('WiperSystem')">Wiper system</button>
                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                                    <div class="col-lg-12" style="text-align: center;">
                                        <b style="font-size: 18px"></b>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('AirHose')">Air hose for semi-trailer</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_searchTruckReadiness('Camera')">Camera</button>
                                    </div>                
                                    <div class="col-lg-12">&nbsp;</div>
                                    <div class="col-lg-12">&nbsp;</div>
                                        <div class="col-lg-12">&nbsp;</div>
                                    </div>
                                </div>

                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

            </div>
            
  <?php
	function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear $strHour:$strMinute";
	}
	$strDate = date('Y-m-d H:i');
	// echo "ThaiCreate.Com Time now : ".DateThai($strDate);
    // echo "<br>";
    // echo date('Y-m-d H:i');
?>
         
        <!-- Modal แสดงข้อมูลการคีย์ข้อมูลคีย์ล็อคเกอร์ -->
        <!-- สถานะรถพร้อมใช้งาน และหยุดรถ -->
        <div class="container">
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title"><b>ข้อมูลรถประจำวันที่: <u><?=DateThai($strDate)?></u></b></h3>
                        </div>
                        <div class="modal-body">
                            <div id="datacompdetailsr"></div>
                                <!-- ROW1 สถานะเหตุผลที่เบิกกุญแจ-->
                                <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:50%">สถานะเหตุผลที่เบิกกุญแจ</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody> 
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><h4>เหตุผลที่เบิกกุญแจ<font style="color: red">*จำเป็น</font></h4></td>
                                                    <td >
                                                        <div class="dropdown bootstrap-select show-tick form-control" style="background-color: #e4e6e3" >
                                                            <select  id="select_reason" name="select_reason"  class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก เหตุผลที่เบิกกุญแจ" data-hide-disabled="true" data-actions-box="false" data-virtual-scroll="false" tabindex="-98" >
                                                                <!-- <option value="พร้อมใช้งาน">จอดที่ Yard</option> -->
                                                                <option value="ตรวจรถ">ตรวจรถ</option>
                                                                <option value="ล้างรถ">ล้างรถ</option>
                                                                <!-- <option value="รถวิ่งงาน">วิ่งงาน</option> -->
                                                            </select>
                                                        </div>
                                                    </td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ENDROW1 สถานะเหตุผลที่เบิกกุญแจ-->
                                <!-- ROW2 วันที่เบิก-วันที่คืน-->
                                <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:50%">วันที่เบิก-วันที่คืน</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><h4>วันที่/เวลา เบิกกุญแจ<font style="color: red">*จำเป็น</font></h4></td>
                                                    <td ><input class="form-control dateen"   id="txt_datepickup" name="txt_datepickup" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่และเวลาเบิกกุญแจ"></td>
                                                </div>
                                            </div>
                                        </tr>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">   
                                            </div>
                                        </tr>
                                        <!-- <tr>
                                            <div class="col-lg-6" style="background-color: #ffffff">
                                                <div class="row">
                                                    <td ><h4>วันที่/เวลา คืนกุญแจ</h4></td>
                                                    <td ><input class="form-control dateen"   id="txt_datereturn" name="txt_datereturn" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่และเวลาคืนกุญแจ"></td>
                                                </div>
                                            </div>
                                        </tr> -->
                                        
                                    </tbody>
                                </table>
                                <!-- ENDROW2 วันที่เบิก-วันที่คืน-->
                                <!-- ROW3 ผู้ที่เบิกกุญแจ ยึดตามการ loging เข้าใช้งาน keylogger-->
                                <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:50%">ผู้ที่เบิกกุญแจ (ดึงข้อมูลอัตโนมัติตามการ Login เข้าระบบ)</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><h4>ผู้ที่เบิกกุญแจ<font style="color: red">*จำเป็น</font></h4></td> 
                                                    <td ><h4><input type="text" disabled="" class="form-control" id="txt_keypicker" name="txt_keypicker" value="<?=$result_seEmp["nameT"]?>"></h4></td>
                                                </div>
                                            </div>
                                        </tr>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">   
                                            </div>
                                        </tr>
                                        <tr>
                                            <!-- <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><h4>ผู้ที่คืนกุญแจ</h4></td>
                                                    <td>
                                                        <input type="text"  name="txt_keyreturnperson" id="txt_keyreturnperson" class="form-control">
                                                    </td>
                                                </div>
                                            </div> -->
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ENDROW3 ผู้ที่เบิกกุญแจ-->
                                 <!-- ROW4 รายละเอียด-->
                                 <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:50%">รายละเอียด</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><input style="background-color: #ffffff" type="text" id="txt_detail" name="txt_detail" class="form-control"></td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ENDROW4 รายละเอียด-->
                                 <!-- ROW5 หมายเหตุ-->
                                 <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:100%">หมายเหตุ</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><input  style="background-color: #ffffff" type="text" id="txt_remark" name="txt_remark" class="form-control"></td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ENDROW5 หมายเหตุ-->
                                <!-- ROW6 ปุ่มบันทึก-->
                                <!-- <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:100%">บันทึกข้อมูล</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><button type="button" class="btn btn-primary" onclick="save_keylogger();" >บันทึกข้อมูล &nbsp;<li class="fa fa-save"></li></button></td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table> -->
                                
                                <div class="col-lg-12" style="text-align: center;">
                                    <div class="row">
                                        <td ><button type="button" class="button" onclick="save_keylocker();" >บันทึกข้อมูล &nbsp;<li class="fa fa-save"></li></button></td>
                                    </div>
                                </div>
                                <!-- ENDROW6 ปุ่มบันทึก-->
                                <!-- ROW7 Data จากหน้า Megdata2-->
                               
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <input type="text" name="txt_regisnumber" id="txt_regisnumber" value="" style="display:none">
                                                <input type="text" name="txt_regisid" id="txt_regisid" value="" style="display:none">
                                                <input type="text" name="txt_createby" id="txt_createby" value="<?=$_SESSION["USERNAME"]?>" style="display:none">
                                            </div>
                                        </div>
                             
                                <!-- ENDROW7 Data จากหน้า Megdata2-->
                                <br><br>
                        </div> 

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div> 
                    </div>

                </div>
            </div>
        </div>

        <!--  Modal สำหรับรถที่มีแผนงานแต่ยังไม่ถึงเวลา สำหรับลงข้อมูลตรวจรถก่อนวิ่งงาน-->
        <div class="container">
            <div class="modal fade" id="myModalDrivercheckbf" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title"><b>ข้อมูลรถประจำวันที่44: <u><?=DateThai($strDate)?></u></b></h3>
                        </div>
                        <div class="modal-body">
                            <div id="datacompdetaildriverchksr"></div>
                                <input type="text"  disabled ="" name="txt_regisdriverchkbf" id="txt_regisdriverchkbf" class="form-control" style="">
                                
                                <!-- ROW4 ผู้ที่ตรวจรถหลังวิ่งงาน-->
                                <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:50%">ผู้ที่ตรวจรถหลังวิ่งงาน</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><h4>ผู้ที่ตรวจรถหลังวิ่งงาน<font style="color: red">*จำเป็น</font></h4></td>
                                                    <!-- เช็คว่ามีข้อมูลวันที่คืนกุญแจหรือไม่ ถ้ามีดึงข้อมูลมาจากตาราง Key Locker 
                                                        ถ้าไม่มียึดตาม การ Login เข้าใช้งานระบบ -->
                                                    <td>
                                                        <input type="text"   name="txt_drivercheckbf" id="txt_drivercheckbf" class="form-control">
                                                    </td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ENDROW4 ผู้ที่ตรวจรถหลังวิ่งงาน-->
                                 <!-- ROW5 รายละเอียด-->
                                 <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:50%">รายละเอียด</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><input style="background-color: #ffffff" type="text" id="txt_detaildriverchkbf" name="txt_detaildriverchkbf" class="form-control"></td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ENDROW5 รายละเอียด-->
                                 <!-- ROW6 หมายเหตุ-->
                                 <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:100%">หมายเหตุ</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><input  style="background-color: #ffffff" type="text" id="txt_remarkdriverchkbf" name="txt_remarkdriverchkbf" class="form-control"></td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-lg-12" style="text-align: center;">
                                    <div class="row">
                                        <td ><button type="button" class="button" onclick="save_drivercheckbf();" >บันทึกข้อมูล &nbsp;<li class="fa fa-save"></li></button></td>
                                    </div>
                                </div>
                                <!-- ENDROW6 ปุ่มบันทึก-->
                                <br><br>
                        </div> 

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div> 
                    </div>

                </div>
            </div>
        </div>   
        <!-- Mobal สำหรับรถสถานะวิ่งงาน -->
        <!-- สถานะรถเป็นวิ่งงาน -->
        <div class="container">
            <div class="modal fade" id="myModalWorking" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title"><b>ข้อมูลรถประจำวันที่: <u><?=DateThai($strDate)?></u></b></h3>
                        </div>
                        <div class="modal-body">
                            <div id="datacompdetailworkingsr"></div>
                                <input type="text"  disabled ="" name="txt_jobnoworking" id="txt_jobnoworking" class="form-control" style="display:none">
                                <input type="text"  disabled ="" name="txt_createbyclose" id="txt_createbyclose" value="<?=$_SESSION["USERNAME"]?>" style="display:none">
                                
                                <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    
                                    <tbody> 
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><h4>เลขที่งาน <font style="color: red">*จำเป็น</font></h4></td>
                                                    <td >
                                                        <div class="dropdown bootstrap-select show-tick form-control" style="background-color: #e4e6e3" >
                                                            <input type="text"  disabled ="" name="txt_jobnoworkingshow" id="txt_jobnoworkingshow" class="form-control">     
                                                        </div>
                                                    </td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ROW1 สถานะเหตุผลที่เบิกกุญแจ-->
                                <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:50%">สถานะเหตุผลที่เบิกกุญแจ/คืนกุญแจ</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody> 
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><h4>เหตุผลที่เบิกกุญแจ/คืนกุญแจ<font style="color: red">*จำเป็น</font></h4></td>
                                                    <td >
                                                        <div class="dropdown bootstrap-select show-tick form-control" style="background-color: #e4e6e3" >
                                                            <select  id="select_reasonclose" name="select_reasonclose"  class="selectpicker form-control" data-container="body" data-live-search="false" title="เลือก เหตุผลที่คืนกุญแจ" data-hide-disabled="true" data-actions-box="false" data-virtual-scroll="false" tabindex="-98" >
                                                                <option value="พร้อมใช้งาน">คืนกุญแจ</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ENDROW1 สถานะเหตุผลที่เบิกกุญแจ-->
                                <!-- ROW2 วันที่เบิก-วันที่คืน-->
                                <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:50%">วันที่เบิก-วันที่คืน</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" style="background-color: #ffffff">
                                                <div class="row">
                                                    <td ><h4>วันที่/เวลา คืนกุญแจ<font style="color: red">*จำเป็น</font></h4></td>
                                                    <td ><input class="form-control dateen"   id="txt_datereturnclose" name="txt_datereturnclose" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่และเวลาคืนกุญแจ"></td>
                                                </div>
                                                <!-- <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike"> -->
                                            </div>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                <!-- ENDROW2 วันที่เบิก-วันที่คืน-->
                                <!-- ROW3 ผู้ที่คืนกุญแจ -->
                                <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:50%">ผู้ที่คืนกุญแจ</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><h4>ผู้ที่คืนกุญแจ<font style="color: red">*จำเป็น</font></h4></td>
                                                    <!-- เช็คว่ามีข้อมูลวันที่คืนกุญแจหรือไม่ ถ้ามีดึงข้อมูลมาจากตาราง Key Locker 
                                                        ถ้าไม่มียึดตาม การ Login เข้าใช้งานระบบ -->
                                                    <td>
                                                        <input type="text"  name="txt_copydiagramemployeename1" id="txt_copydiagramemployeename1" class="form-control">
                                                    </td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ENDROW3 ผู้ที่คืนกุญแจ-->
                                <!-- ROW4 ผู้ที่ตรวจรถหลังวิ่งงาน-->
                                <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:50%">ผู้ที่ตรวจรถหลังวิ่งงาน</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><h4>ผู้ที่ตรวจรถหลังวิ่งงาน<font style="color: red">*จำเป็น</font></h4></td>
                                                    <!-- เช็คว่ามีข้อมูลวันที่คืนกุญแจหรือไม่ ถ้ามีดึงข้อมูลมาจากตาราง Key Locker 
                                                        ถ้าไม่มียึดตาม การ Login เข้าใช้งานระบบ -->
                                                    <td>
                                                        <input type="text"  onchange="save_drivercheckaf(this.value,'after')" name="txt_drivercheckaf" id="txt_drivercheckaf" class="form-control">
                                                    </td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ENDROW4 ผู้ที่ตรวจรถหลังวิ่งงาน-->
                                 <!-- ROW5 รายละเอียด-->
                                 <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:50%">รายละเอียด</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><input style="background-color: #ffffff" type="text" id="txt_detailclose" name="txt_detailclose" class="form-control"></td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ENDROW5 รายละเอียด-->
                                 <!-- ROW6 หมายเหตุ-->
                                 <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:100%">หมายเหตุ</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><input  style="background-color: #ffffff" type="text" id="txt_remarkclose" name="txt_remarkclose" class="form-control"></td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-lg-12" style="text-align: center;">
                                    <div class="row">
                                        <td ><button type="button" class="button" onclick="save_keylockerclose();" >บันทึกข้อมูล &nbsp;<li class="fa fa-save"></li></button></td>
                                    </div>
                                </div>
                                <!-- ENDROW6 ปุ่มบันทึก-->
                                <!-- ROW7 Data จากหน้า Megdata2-->
                               
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <input type="text" name="txt_regisnumber" id="txt_regisnumber" value="" style="display:none">
                                                <input type="text" name="txt_regisid" id="txt_regisid" value="" style="display:none">
                                                <input type="text" name="txt_createby" id="txt_createby" value="<?=$_SESSION["USERNAME"]?>" style="display:none">
                                            </div>
                                        </div>
                             
                                <!-- ENDROW7 Data จากหน้า Megdata2-->
                                <br><br>
                        </div> 

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div> 
                    </div>

                </div>
            </div>
        </div> 
        <!-- Mobal สำหรับรถสถานะรถซ่อม ล้างรถ ตรวจรถ -->
        <div class="container">
            <div class="modal fade" id="myModalRepairWashCheck" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title"><b>ข้อมูลรถประจำวันที่: <u><?=DateThai($strDate)?></u></b></h3>
                        </div>
                        <div class="modal-body">
                            <div id="datacompdetailrepairwashchecksr"></div>
                                <input type="text"  disabled ="" name="txt_createbyrwc" id="txt_createbyrwc" value="<?=$_SESSION["USERNAME"]?>" style="display:none">
                                <input type="text"  disabled ="" name="txt_jobnowrc" id="txt_jobnowrc" class="form-control" style="display:none">
                                <!-- ROW1 สถานะเหตุผลที่เบิกกุญแจ-->
                                <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:50%">สถานะเหตุผลที่เบิกกุญแจ/คืนกุญแจ</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody> 
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><h4>เหตุผลที่เบิกกุญแจ/คืนกุญแจ<font style="color: red">*จำเป็น</font></h4></td>
                                                    <td >
                                                        <div class="dropdown bootstrap-select show-tick form-control" style="background-color: #e4e6e3" >
                                                            <select  id="select_reasonrwc" name="select_reasonrwc"  class="selectpicker form-control" data-container="body" data-live-search="false" title="เลือก เหตุผลที่เบิกกุญแจ/คืนกุญแจ" data-hide-disabled="true" data-actions-box="false" data-virtual-scroll="false" tabindex="-98" >
                                                                <option value="พร้อมใช้งาน">คืนกุญแจ</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ENDROW1 สถานะเหตุผลที่เบิกกุญแจ-->
                                <!-- ROW2 วันที่เบิก-วันที่คืน-->
                                <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:50%">วันที่เบิก-วันที่คืน</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" style="background-color: #ffffff">
                                                <div class="row">
                                                    <td ><h4>วันที่/เวลา คืนกุญแจ<font style="color: red">*จำเป็น</font></h4></td>
                                                    <td ><input class="form-control dateen"   id="txt_datereturnrwc" name="txt_datereturnrwc" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่และเวลาคืนกุญแจ"></td>
                                                </div>
                                                <!-- <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike"> -->
                                            </div>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                <!-- ENDROW2 วันที่เบิก-วันที่คืน-->
                                <!-- ROW3 ผู้ที่เบิกกุญแจ ยึดตามการ loging เข้าใช้งาน keylogger-->
                                <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:50%">ผู้ที่คืนกุญแจ</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><h4>ผู้ที่คืนกุญแจ<font style="color: red">*จำเป็น</font></h4></td>
                                                    <!-- เช็คว่ามีข้อมูลวันที่คืนกุญแจหรือไม่ ถ้ามีดึงข้อมูลมาจากตาราง Key Locker 
                                                        ถ้าไม่มียึดตาม การ Login เข้าใช้งานระบบ -->
                                                    <td>
                                                        <input type="text"  name="txt_copydiagramemployeename1rwc" id="txt_copydiagramemployeename1rwc" class="form-control">
                                                    </td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ENDROW3 ผู้ที่เบิกกุญแจ-->
                                 <!-- ROW4 รายละเอียด-->
                                 <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:50%">รายละเอียด</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><input style="background-color: #ffffff" type="text" id="txt_detailrwc" name="txt_detailrwc" class="form-control"></td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ENDROW4 รายละเอียด-->
                                 <!-- ROW5 หมายเหตุ-->
                                 <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <tr>
                                                    <th style="width:100%">หมายเหตุ</th>
                                                </tr>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <div class="col-lg-6" >
                                                <div class="row">
                                                    <td ><input  style="background-color: #ffffff" type="text" id="txt_remarkrwc" name="txt_remarkrwc" class="form-control"></td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-lg-12" style="text-align: center;">
                                    <div class="row">
                                        <td ><button type="button" class="button" onclick="save_keylockerrwc();" >บันทึกข้อมูล &nbsp;<li class="fa fa-save"></li></button></td>
                                    </div>
                                </div>
                                <!-- ENDROW6 ปุ่มบันทึก-->
                                <!-- ROW7 Data จากหน้า Megdata2-->
                               
                                        <div class="col-lg-12" >
                                            <div class="row">
                                                <input type="text" name="txt_regisnumber" id="txt_regisnumber" value="" style="display:none">
                                                <input type="text" name="txt_regisid" id="txt_regisid" value="" style="display:none">
                                                <input type="text" name="txt_createby" id="txt_createby" value="<?=$_SESSION["USERNAME"]?>" style="display:none">
                                            </div>
                                        </div>
                             
                                <!-- ENDROW7 Data จากหน้า Megdata2-->
                                <br><br>
                        </div> 

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div> 
                    </div>

                </div>
            </div>
        </div>

        
        
        <!-- modal ข้อมูลการวิ่งงาน -->
        <div class="container" >
          <div class="modal fade" id="myModalshowdataplan" role="dialog">
            <div class="modal-dialog" style="width: 1500px; height: 170px;">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><b>ตารางข้อมูลการวิ่งงาน</b></h4>
                </div>
                    <div class="modal-body">
                        <div class="row" >
                            <div class="col-lg-12">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                <div id="dataplandef">
                                </div>
                                <div id="dataplansr"></div>
                            </div>                              
                            </div>
                        </div>
                </div>
                    <div class="modal-footer">                                            
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- modal ข้อมูลการซ่อมรถ -->
        <div class="container" >
          <div class="modal fade" id="myModalshowdatarepair" role="dialog">
            <div class="modal-dialog" style="width: 1500px; height: 170px;">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><b>ตารางข้อมูลการซ่อมรถ</b></h4>
                </div>
                    <div class="modal-body">
                        <div class="row" >
                            <div class="col-lg-12">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                <div id="datarepairdef">
                                </div>
                                <div id="datarepairsr"></div>
                            </div>                              
                            </div>
                        </div>
                </div>
                    <div class="modal-footer">                                            
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>

            </div>
          </div>
        </div>
        </body>

        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>
        <script src="../dist/js/bootstrap-select.js"></script>

        <?php
        // $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeeehr2', " ");
        ?>
        <script type="text/javascript">

                                // var txt_drivercheckbf = [<?= $emp ?>];
                                //     $("#txt_drivercheckbf").autocomplete({
                                //     source: [txt_drivercheckbf]
                                // });

                               
                                function print_tenkokpi(){

                                    var monthnumeric = document.getElementById('select_monthtruckkpi').value;
                                    var year = document.getElementById('select_yeartruckkpi').value;


                                    if (monthnumeric == '01') {
                                        var month = 'Jan';
                                    }else if(monthnumeric == '02'){
                                        var month = 'Feb';
                                    }else if(monthnumeric  == '03'){
                                        var month = 'Mar';
                                    }else if(monthnumeric  == '04'){
                                        var month = 'Apr';
                                    }else if(monthnumeric == '05'){
                                        var month = 'May';
                                    }else if(monthnumeric == '06'){
                                        var month = 'Jun';
                                    }else if(monthnumeric == '07'){
                                        var month = 'Jul';
                                    }else if(monthnumeric == '08'){
                                        var month = 'Aug';
                                    }else if(monthnumeric == '09'){
                                        var month = 'Sep';
                                    }else if(monthnumeric == '10'){
                                        var month = 'Oct';
                                    }else if(monthnumeric == '11'){
                                        var month = 'Nov';
                                    }else if(monthnumeric == '12'){
                                        var month = 'Dec';
                                    }else{
                                        var month = 'Not Select';
                                    }

                                    if (monthnumeric == '') {
                                        alert('กรุณาเลือกเดือน');
                                    }else if(year == ''){
                                        alert('กรุณาเลือกปึ');
                                    }else{
                                        window.open('excel_reportdigitaltenkotruckredinesskpi.php?monthnumeric=' + monthnumeric+'&month='+month+'&years='+year, '_blank');
                                    }

                                }

                                function save_data(date,value,remark,remark_month,remark_year){
                                    // auto save onchange
                                    // alert("save data");
                                    // alert(date);
                                    // alert(value);
                                    // alert(remark);
                                    // alert(remark_month);
                                    // alert(remark_year);

                                    var createby = document.getElementById('txt_createby').value;
                                    // alert(createby);


                                    $.ajax({
                                            type: 'post',
                                            url: 'meg_data2.php',
                                            data: {

                                                txt_flg: "save_digitaltenko_truckreadiness_kpi",
                                                id:'',
                                                date: date,
                                                value: value,
                                                remark: remark,
                                                remark_month: remark_month,
                                                remark_year: remark_year ,
                                                createdate: '',
                                                createby: createby
                                            },
                                            success: function (rs) {

                                                // alert(rs);
                                                // alert("บันทึกข้อมูลเรียบร้อย");
                                                // window.location.reload();
                                            }
                                        });
                                }

                                function search_graph(){
                                    var monthnumeric = document.getElementById('select_monthtruckkpi').value;
                                    var yearchk = document.getElementById('select_yeartruckkpi').value;

                                    if (monthnumeric == '01') {
                                        var month = 'Jan';
                                    }else if(monthnumeric == '02'){
                                        var month = 'Feb';
                                    }else if(monthnumeric == '03'){
                                        var month = 'Mar';
                                    }else if(monthnumeric == '04'){
                                        var month = 'Apr';
                                    }else if(monthnumeric == '05'){
                                        var month = 'May';
                                    }else if(monthnumeric == '06'){
                                        var month = 'Jun';
                                    }else if(monthnumeric == '07'){
                                        var month = 'Jul';
                                    }else if(monthnumeric =='08'){
                                        var month = 'Aug';
                                    }else if(monthnumeric == '09'){
                                        var month = 'Sep';
                                    }else if(monthnumeric == '10'){
                                        var month = 'Oct';
                                    }else if(monthnumeric == '11'){
                                        var month = 'Nov';
                                    }else if(monthnumeric == '12'){
                                        var month = 'Dec';
                                    }else{
                                        var month = 'Not Select';
                                    }

                                    if (monthnumeric == '') {
                                        alert('กรุณาเลือกเดือน');
                                    }else if(yearchk == ''){
                                        alert('กรุณาเลือกปึ');
                                    }else{
                                        window.open('meg_digitaltenko_TruckReadiness_KPI_graph.php?monthnumeric=' + monthnumeric+'&month='+month+'&years='+yearchk, '_blank');
                                    }
                                    

                                }
                                function select_searchTruckReadiness(checkdata)
                                {
                                    // alert(checkdata);


                                    var truckdata =  checkdata;   
                                    var monthnumeric = document.getElementById('select_monthtruckkpi').value;
                                    var yearchk = document.getElementById('select_yeartruckkpi').value;
                                    
                                    if (monthnumeric == '01') {
                                        var month = 'Jan';
                                    }else if(monthnumeric == '02'){
                                        var month = 'Feb';
                                    }else if(monthnumeric  == '03'){
                                        var month = 'Mar';
                                    }else if(monthnumeric  == '04'){
                                        var month = 'Apr';
                                    }else if(monthnumeric == '05'){
                                        var month = 'May';
                                    }else if(monthnumeric == '06'){
                                        var month = 'Jun';
                                    }else if(monthnumeric == '07'){
                                        var month = 'Jul';
                                    }else if(monthnumeric == '08'){
                                        var month = 'Aug';
                                    }else if(monthnumeric == '09'){
                                        var month = 'Sep';
                                    }else if(monthnumeric == '10'){
                                        var month = 'Oct';
                                    }else if(monthnumeric == '11'){
                                        var month = 'Nov';
                                    }else if(monthnumeric == '12'){
                                        var month = 'Dec';
                                    }else{
                                        alert("ยังไม่ได้เลือกข้อมูลเดือน!!!");
                                        var month = 'NG';
                                    }

                                    if (yearchk == '') {
                                        alert("ยังไม่ได้เลือกข้อมูลปี!!!");
                                        var years = 'NG';
                                    }else{
                                        var years = yearchk;
                                    }

                                    // alert(month);
                                    // alert(years);

                                    if (years == 'NG' || month == 'NG') {
                                        alert("กรุณาเลือกข้อมูลให้ถูกต้อง!!");
                                    }else{
                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_searchTruckReadiness.php',
                                            data: {
                                                truckdata: truckdata,monthnumeric: monthnumeric,month: month,years:years
                                            },
                                            success: function (response) {
                                                if (response)
                                                {
                                                
                                                    document.getElementById("list-data").innerHTML = "";
                                                    document.getElementById("loading").innerHTML = response;
                                                    $('[data-toggle="popover"]').popover({
                                                        html: true,
                                                        content: function () {
                                                            return $('#popover-content').html();
                                                        }
                                                    });
                                                }



                                            }
                                        });
                                    }

                                    

                                }
       
            $(function () {
                $('[data-toggle="popover"]').popover({
                html: true,
                    content: function () {
                        return $('#popover-content').html();
                    }
                });
            })

        $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateen").datetimepicker({
                        timepicker: true,
                        dateformat: 'Y-m-d', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                        lang: 'th',
                        timeFormat: "HH:mm:ss"

                });
        });
           
        

        </script>

    </html>

    <?php
    sqlsrv_close($conn);
    ?>