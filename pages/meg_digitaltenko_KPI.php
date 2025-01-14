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

                    <!-- modal แสดงข้อมูล TenkoNG รายวัน -->
                    <div class="container" >
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog" style="width: 1500px; height: 170px;">
                            <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"><b>ตารางข้อมูล TenkoNG</b></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row" >
                                        <div class="col-lg-12">
                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                            <div id="datadef">
                                            </div>
                                            <div id="datasr"></div>
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
        
        <!-- Modal -->
       
      
       


        <div class="container" >
          <div class="modal fade" id="myModalinsert" role="dialog">
            <div class="modal-dialog" style="width: 1500px; height: 170px;">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><b>จัดการข้อมูล TenkoNG</b></h4>
                </div>
                        <div class="modal-body">
                        <span id="modal-myvalue"></span> <span id="modal-myvar"></span>
                        <input type="text" hidden id="txt_month" name="txt_month" value=""></input>
                        <input type="text" hidden id="txt_years" name="txt_years" value=""></input>        

                        </div> <!-- END Modal body-->

                        <div class="panel-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills">
                            <li class="active">
                                <a href="#tap_kpi1" data-toggle="tab" aria-expanded="true">บันทึกข้อมูล Tenko NG</a>
                            </li>
                            <li>
                                <a href="#tap_kpi2" data-toggle="tab" onclick="tap_kpi2();" >แก้ไขข้อมูล Tenko NG</a>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <!-- <div class="row">
                                <div class="col-md-12">&nbsp;</div>
                            </div> -->
                            <!-- //////////////////////////ตรวจสอบข้อมูลน้ำมันรายวัน////////////////////////////// -->
                            <div class="tab-pane fade active in" id="tap_kpi1">

                                <br><br>
                                    
                                <!-- ROW1 DATE,DRIVERNAME,CHECKBOX -->
                                <div class="row" >
                                    <!-- Date -->
                                    <div class="col-lg-2">
                                        <input class="form-control dateen" readonly=""  style="background-color: #f080802e"  id="txt_datedata" name="txt_datedata" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่สำหรับบันทึกข้อมูล">
                                    
                                    </div>

                                    <!-- Driver Name -->
                                    <!-- <div class="col-lg-2">
                                        <font style="color: red">* </font><label>พขร.(1) :</label>
                                        <input type="text"  name="txt_copydiagramemployeename1" id="txt_copydiagramemployeename1" class="form-control">
                                    </div> -->
                                    <div class="col-lg-2">
                                        <div class="dropdown bootstrap-select show-tick form-control">
                                            <select name="" id=""></select>
                                            <select   id="txt_drivername" name="txt_drivername" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                <?php
                                                // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                                $params_seName = array(
                                                    array('select_employeehealth', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                                while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seName['nameT'] ?>"><?= $result_seName['nameT'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            
                                        
                                            
                                        </div>
                                    </div>
                                    <!-- TENKO NG -->
                                    <div class="col-lg-2">
                                        <label class="container">
                                            <input type="checkbox" id="tenkong" name ="tenkong" value ="" >&nbsp;&nbsp;&nbsp;Tenko NG
                                            <span class="checkmark"></span>
                                        </label>
                                        <!-- <input type="checkbox" class="" name="checkBox2" checked width="48" height="48"> sss -->
                                    </div>
                                    <!-- Annual leave -->
                                    <div class="col-lg-2">
                                        <label class="container">
                                            <input type="checkbox" id="annualleave" name ="annualleave" value ="" >&nbsp;&nbsp;&nbsp;Annual leave
                                            <span class="checkmark"></span>
                                        </label>
                                        <!-- <input type="checkbox" class="" name="checkBox2" checked width="48" height="48"> sss -->
                                    </div>
                                    <!-- TENKO NG -->
                                    <div class="col-lg-2">
                                        <label class="container">
                                            <input type="checkbox" id="sickleave" name ="sickleave" value ="" >&nbsp;&nbsp;&nbsp;Sick leave
                                            <span class="checkmark"></span>
                                        </label>
                                        <!-- <input type="checkbox" class="" name="checkBox2" checked width="48" height="48"> sss -->
                                    </div>
                                </div>
                                <br>
                                <!-- ROW2 CAUSE AND ACTION -->
                                <div class="row" >
                                    <!-- CAUSE -->
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                            <label>Cause</label>
                                            <input type="text"  class="form-control"  style="width: 600px;height: 40px"  id="txt_cause" name="txt_cause" value="" placeholder="">
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Action</label>
                                            <input type="text"  class="form-control"  style="width: 600px;height: 40px"  id="txt_action" name="txt_action" value="" placeholder="">
                                        </div>
                                    </div>
                                    
                                </div>

                                <!-- button save -->
                                <br>
                                <div class="row" >
                                    <!-- Date -->
                                    <div class="col-lg-6">
                                    <input type="button"   id="btn_save" name="btn_save"  onclick="save_tenkong();" value="บันทึกข้อมูล" class="btn btn-primary">
                                    <label for="" style="color:red;">* ตรวจสอบข้อมูลให้ถูกต้องทุกครั้งก่อนกดบันทึก</label>
                                    </div>
                                </div>    
                                    
                                <!-- 
                                <div class="row">&nbsp;</div>
                                <div class="row">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <button type="button" class="btn btn-primary" onclick="select_companyoilaveragedaychk()">EXCEL <i class="fa fa-file-excel-o"></i></button>
                                    </div>
                                </div> -->

                            </div>
                            <!-- //////////////////ข้อมูลค่าเฉลี่ยน้ำมันรายวัน////////////////////////////// -->
                            <div class="tab-pane fade " id="tap_kpi2">
                                <br><br>
                                <div id="data_def1">
                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example4" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;font-size:14px">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">No</th>
                                                <th style="text-align: center;">TenkoNG ID</th>
                                                <th style="text-align: center;">Date</th>
                                                <th style="text-align: center;">DriverName</th>
                                                <th style="text-align: center;width:10px;height:30px">TenkoNG</th>
                                                <th style="text-align: center;width:10px;height:30px">Annual leave</th>
                                                <th style="text-align: center;width:10px;height:30px">Sick leave</th>
                                                <th style="text-align: center;width:10px;height:30px">Cause</th>
                                                <th style="text-align: center;width:10px;height:30px">Action</th>
                                                <th style="text-align: center;width:10px;height:30px">EDIT</th>
                                                </th>
                                            </tr>
                                        </thead>
                                            <!-- <tbody>
                                                <?php
                                                $i = 1;

                                                // $sql_seTenkoNG = "SELECT TENKONG_ID,DATE_PROCESS,DRIVERNAME,TENKONG
                                                // ,ANNUALLEAVE,SICKLEAVE,CAUSE_DATA,ACTION_DATA 
                                                // FROM DIGITALTENKO_TENKONG
                                                // WHERE REMARK_MONTH ='".$month."' AND REMARK_YEARS='".$years."'
                                                // ORDER BY DATE_PROCESS ASC";
                                                $sql_seTenkoNG = "SELECT TENKONG_ID,DATE_PROCESS,DRIVERNAME,TENKONG
                                                ,ANNUALLEAVE,SICKLEAVE,CAUSE_DATA,ACTION_DATA 
                                                FROM DIGITALTENKO_TENKONG";
                                                $params_seTenkoNG = array();
                                                $query_seTenkoNG = sqlsrv_query($conn, $sql_seTenkoNG, $params_seTenkoNG);
                                                while ($result_seTenkoNG = sqlsrv_fetch_array($query_seTenkoNG, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <tr>
                                                        <td style="text-align: center;"><?= $i ?></td>
                                                        <td style="text-align: center;"><?= $result_seTenkoNG['TENKONG_ID'] ?></td>
                                                        <td><?= $result_seTenkoNG['DATE_PROCESS'] ?></td>
                                                        <td><?= $result_seTenkoNG['DRIVERNAME'] ?></td>
                                                        <td style="text-align: center;"><input type="text" class="form-control" style="width:100px;height:30px" id="txt_tenkong" onchange="update_tenkong('<?=$result_seTenkoNG['TENKONG_ID']?>',this.value,'TENKONG');" value="<?= $result_seTenkoNG['TENKONG'] ?>"></td>
                                                        <td style="text-align: center;"><input type="text" class="form-control" style="width:100px;height:30px" id="txt_tenkong" onchange="update_tenkong('<?=$result_seTenkoNG['TENKONG_ID']?>',this.value,'ANNUALLEAVE');" value="<?= $result_seTenkoNG['ANNUALLEAVE'] ?>"></td>
                                                        <td style="text-align: center;"><input type="text" class="form-control" style="width:100px;height:30px" id="txt_tenkong" onchange="update_tenkong('<?=$result_seTenkoNG['TENKONG_ID']?>',this.value,'SICKLEAVE');" value="<?= $result_seTenkoNG['SICKLEAVE'] ?>"></td>
                                                        <td style="text-align: center;"><input type="text" class="form-control" style="width:100px;height:30px" id="txt_tenkong" onchange="update_tenkong('<?=$result_seTenkoNG['TENKONG_ID']?>',this.value,'CAUSE_DATA');" value="<?= $result_seTenkoNG['CAUSE_DATA'] ?>"></td>
                                                        <td style="text-align: center;"><input type="text" class="form-control" style="width:100px;height:30px" id="txt_tenkong" onchange="update_tenkong('<?=$result_seTenkoNG['TENKONG_ID']?>',this.value,'ACTION_DATA');" value="<?= $result_seTenkoNG['ACTION_DATA'] ?>"></td>
                                                        <td style="text-align: center;"><input type="text" class="btn btn-primary" data-confirm ="กรุณากด 'ตกลง (OK)' เพื่อยืนยันการลบข้อมูล?" name="btnDelete" id="btnDelete" value="ลบข้อมูลไอดีที่:<?=$result_seTenkoNG['TENKONG_ID']?>" ></td>
                                                    </tr>
                                                    <?php
                                                    $i++;

                                                    
                                                }
                                                ?>
                                            </tbody> -->
                                    </table>          
                                </div>
                                <div id="data_sr1"></div>
                                    
                                    

                                <!-- <div class="row">&nbsp;</div>
                                <div class="row">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <button type="button" class="btn btn-primary" onclick="select_companyoilaverageday()">EXCELDAY <i class="fa fa-file-excel-o"></i></button>
                                    </div>
                                </div> -->

                            </div>
                            
                            
                            <!-- ////////////////////ข้อมูลค่าเฉลี่ยน้ำมันรายวัน/เดือน////////////////////// -->
                            


                        </div>
                    </div>
                    <div class="modal-footer">                                            
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>

            </div>
          </div>
        </div>    

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" >
                                    
                                    <div class="col-md-6">
                                        <a href="index2.php">หน้าหลัก</a> / Digital Tenko KPI </a>
                                    </div>
                                    <input type="text" hidden id="txt_createby" name="txt_createby" value="<?=$_SESSION["USERNAME"]?>">         

                                <br>
                                <div class="panel-body">
                                    <div class="row">&nbsp;</div>
                                    <div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>เลือกเดือน</label><br>   
                                                <select id="select_monthtruckkpi" name="select_monthtruckkpi"  class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก เดือนที่จะค้นหา" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
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
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('DriverAttend')">Driver Attend</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('OKDriver')">OK Driver</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_DigitalTenssssskoKPI('DriverAttendPer')">Driver attendance %</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('TotalDriver')">Total Driver</button>
                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                                    <div class="col-lg-12" style="text-align: center;">
                                        <b style="font-size: 18px"></b>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('Requirement')">Requirement</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('AbsenceLeave')">Absence/Leave</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('TenkoNG')">Tenko : NG</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('BloodPressure')">Blood Pressure</button>
                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                                    <div class="col-lg-12" style="text-align: center;">
                                        <b style="font-size: 18px"></b>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('Alcohol')">Alcohol</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('Resttimeless6hrs')">Rest time < 6 hrs</button>
                                        &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #fda491;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('HealthProblem')">Health problem</button>
                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                                    
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


                                //  $(document).ready(function () {
                                //     $(".open-AddBookDialog").click(function () {
                                //         alert('sdsadssdsad');
                                //         // $('#bookId').val($(this).data('id'));
                                //         // $('#addBookDialog').modal('show');
                                //     });
                                //  });
                                function tap_kpi2(){

                                    // alert('kpi2');

                                    var monthnumeric = document.getElementById('select_monthtruckkpi').value;
                                    var years = document.getElementById('select_yeartruckkpi').value;


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

                                    // alert(month);
                                    // alert(years);

                                    $.ajax({
                                        type: 'post',
                                        url: 'meg_data2.php',
                                        data: {
                                            txt_flg: "select_tapkpi2", month: month, years: years
                                        },
                                        success: function (response) {

                                            if (response)
                                            {
                                                document.getElementById("data_sr1").innerHTML = response;
                                                document.getElementById("data_def1").innerHTML = "";

                                            }
                                            $(document).ready(function () {
                                                $('#dataTables-example4').DataTable({
                                                    responsive: true
                                                });
                                            });

                                        }
                                    });
                                }

                                function Senddata(month){

                                    alert(month);
                                }

                                function datetodate()
                                {
                                // alert('sssss');
                                document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;
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
                                
                                $(document).on('click', ':not(form)[data-confirm]', function(e){
                                if(!confirm($(this).data('confirm'))){
                                e.stopImmediatePropagation();
                                e.preventDefault();
                                

                                }else{
                                    
                                    let str = this.value;
                                    var id =  str.substring(16);
                                    // alert(id);

                                    delete_data(id); 
                                }

                                
                            }); 

                            function delete_data(id){
                                // alert(id);

                                $.ajax({
                                    type: 'post',
                                    url: 'meg_data2.php',
                                    data: {

                                        txt_flg: "delete_digitaltenkoNG",
                                        id:id,
                                        date: '',
                                        drivername: '',
                                        tenkong: '',
                                        annualleave: '' ,
                                        sickleave: '',
                                        cause_data: '',
                                        action_data: '',
                                        remark_month:'',
                                        remark_year:'',
                                        createdate:'',
                                        createby: '',
                                        checkcolunm:'',
                                        editobj:''
                                    },
                                    success: function (rs) {

                                        
                                        alert("ลบข้อมูลเรียบร้อย...");
                                        // window.location.reload();
                                        
                                    }

                                    
                                });

                            }   
                            function update_tenkong(id,editobj,checkcolunm){

                            // var dataedit = editableObj.innerHTML;

                            // alert("TEST");
                            // alert(id);
                            // alert(editobj);
                            // alert(checkcolunm);


                            $.ajax({
                                type: 'post',
                                url: 'meg_data2.php',
                                data: {

                                    txt_flg: "update_digitaltenkoNG",
                                    id:id,
                                    date: '',
                                    drivername: '',
                                    tenkong: '',
                                    annualleave: '' ,
                                    sickleave: '',
                                    cause_data: '',
                                    action_data: '',
                                    remark_month:'',
                                    remark_year:'',
                                    createdate:'',
                                    createby: '',
                                    checkcolunm:checkcolunm,
                                    editobj:editobj
                                },
                                success: function (rs) {

                                
                                    alert("บันทึกข้อมูลเรียบร้อย");
                                    // window.location.reload();
                                }
                            });

                            }
                            function save_tenkong(){

                            // alert("savetenkong");
                            // tenkong
                            if($("#tenkong").is(':checked')){
                                tenkong = '1';
                                // alert('1');
                                } else {
                                tenkong = '0';
                                // alert('0');
                            }
                            // annualleave
                            if($("#annualleave").is(':checked')){
                                annualleave = '1';
                                // alert('1');
                                } else {
                                annualleave = '0';
                                // alert('0');
                            }
                            // sickleave
                            if($("#sickleave").is(':checked')){
                                sickleave = '1';
                                // alert('1');
                                } else {
                                sickleave = '0';
                                // alert('0');
                            }

                            var cause = document.getElementById('txt_cause').value;
                            var action = document.getElementById('txt_action').value;
                            var createby = document.getElementById('txt_createby').value;
                            var date = document.getElementById('txt_datedata').value;
                            var drivername = document.getElementById('txt_drivername').value;

                            // var month = document.getElementById('txt_month').value;
                            // var years = document.getElementById('txt_years').value;

                            var monthnumeric = document.getElementById('select_monthtruckkpi').value;
                            var years = document.getElementById('select_yeartruckkpi').value;


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

                            // alert(date)
                            // alert(cause);
                            // alert(action);
                            // alert(createby);
                            // alert(drivername);

                            if (date == '') {
                                alert("กรุณาเลือกวันที่ !!!");
                            }else if(drivername == ''){
                                alert("กรุณาเลือกชื่อพนักงาน !!!");
                            }else if(tenkong == '0' && annualleave == '0' && sickleave == '0'){
                                alert("กรุณาเลือก TenkoNG,Annual Leave,Sick Leave !!!");
                            }else if(cause == ''){
                                alert("กรุณาลงข้อมูล Cause !!!");
                            }else if(action == ''){
                                alert("กรุณาลงข้อมูล Action !!!");
                            }else{
                                // alert("OK");
                                    $.ajax({
                                    type: 'post',
                                    url: 'meg_data2.php',
                                    data: {

                                        txt_flg: "save_digitaltenkoNG",
                                        id:'',
                                        date: date,
                                        drivername: drivername,
                                        tenkong: tenkong,
                                        annualleave: annualleave ,
                                        sickleave: sickleave,
                                        cause_data: cause,
                                        action_data: action,
                                        remark_month:month,
                                        remark_year:years,
                                        createdate:'',
                                        createby: createby
                                    },
                                    success: function (rs) {

                                        // alert(rs);   
                                            document.getElementById('txt_cause').value  = '';
                                            document.getElementById('txt_action').value = '';
                                            document.getElementById('txt_drivername').value = '';
                                            document.getElementById('txt_datedata').value = '';

                                        alert("บันทึกข้อมูลเรียบร้อย");
                                        // window.location.reload();
                                    }
                                });
                            }

                                    
                            }

                           
                            function checking_dataKPI(date){

                                // alert(date);
                                    $.ajax({
                                        type: 'post',
                                        url: 'meg_data2.php',
                                        data: {
                                            txt_flg: "select_checkingKPI", date: date
                                    },
                                    success: function (response) {
                                        if (response){

                                            document.getElementById("datasr").innerHTML = response;
                                            document.getElementById("datadef").innerHTML = "";

                                            $(document).ready(function () {
                                                    $('#dataTables-example').DataTable({
                                                        responsive: true
                                                    });


                                                });
                                            }

                                        }
                                    });

                                }    

                                function print_tenkong(){

                                        var datestart = document.getElementById('txt_datestart').value;
                                        var dateend = document.getElementById('txt_dateend').value;

                                        // alert(position);
                                        window.open('excel_reportdigitaltenkong.php?datestart='+datestart+'&dateend='+dateend, '_blank');
                                 }
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
                                        window.open('excel_reportdigitaltenkokpi.php?monthnumeric=' + monthnumeric+'&month='+month+'&years='+year, '_blank');
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

                                                txt_flg: "save_digitaltenkokpi",
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
                                        window.open('meg_digitaltenko_KPI_graph.php?monthnumeric=' + monthnumeric+'&month='+month+'&years='+yearchk, '_blank');
                                    }
                                    

                                }
                                function select_DigitalTenkoKPI(checkdata)
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
                                            url: 'meg_searchDigitalTenkoKPI.php',
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

                                                    
                                                        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                        // กรณีใช้แบบ input
                                                        $(".dateen").datetimepicker({
                                                            timepicker: false,
                                                            format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                            lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                        });

                                                        // $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', "");
                                                    
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