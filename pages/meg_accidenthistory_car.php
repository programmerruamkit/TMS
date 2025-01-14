<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);

$condition1 = ($_SESSION["EMPLOYEEID"] != "") ? " AND a.EMPLOYEEID = '" . $_SESSION["EMPLOYEEID"] . "'" : "";
//$condition1 = ($_SESSION["EMPLOYEEID"] != "") ? " AND a.EMPLOYEEID = 238" : "";
$sql_sePremissions = "{call megRoleaccount_v2(?,?)}";
$params_sePremissions = array(
    array('select_permissions', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_sePremissions = sqlsrv_query($conn, $sql_sePremissions, $params_sePremissions);
$result_sePremissions = sqlsrv_fetch_array($query_sePremissions, SQLSRV_FETCH_ASSOC);

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
        <!-- <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet"> -->
        <!-- <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet"> -->
        <!-- <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet"> -->
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">


        <!-- <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet"> -->
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        
        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.min.js"></script>
        <link href="style/style.css" rel="stylesheet" type="text/css">

        <style>

            .navbar-default {

            border-color: #ffcb0b;
            }
            #page-wrapper {
            border-left: 1px solid #ffcb0b;
            }
            .container {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            }

            /* Hide the browser's default checkbox */
            .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
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

        </style>
    </head>

    <body >
        <div class="modal fade" id="modal_selecttenko" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-modal-parent="#modal_copydiagram">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">

                    <div id="select_selecttenko"></div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_confrimvehicletransportplan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 80%">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="title"><b>ยืนยันรายการวิ่ง</b></h5>
                    </div>
                    <div class="modal-body">


                        <div id="data_confrimdriving"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">

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
                    <font style="color:#337ab7 "><?= $result_seEmployee['nameT'] ?></font>
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
                        $sql_sePremissions = "{call megRoleaccount_v2(?,?)}";
                        $params_sePremissions = array(
                            array('select_permissions', SQLSRV_PARAM_IN),
                            array($condition1, SQLSRV_PARAM_IN)
                        );
                        $query_sePremissions = sqlsrv_query($conn, $sql_sePremissions, $params_sePremissions);
                        while ($result_sePremissions = sqlsrv_fetch_array($query_sePremissions, SQLSRV_FETCH_ASSOC)) {
                            ?>
                            <li><a href="" onclick="create_premissions('<?= $result_sePremissions['ROLEID'] ?>');"><i class="fa fa-user fa-fw"></i> <?= $result_sePremissions['ROLENAME'] ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <!-- <li>
                        <font style="color:#337ab7 "><?= $result_sePremissions["NAME"] ?></font>
                    </li> -->
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
                    <div class="panel-heading" style="background-color: #e7e7e7">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                $meg = 'ลงข้อมูลอุบัติเหตุรถ';
                                echo "<a href='index.php?type=report'>หน้าหลัก</a>  / " . $meg;
                                $link = "<a href='index.php?type=report'>หน้าหลัก</a> ";
                                $_SESSION["link"] = $link;
                                ?>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="col-lg-6 text-right">
                                <?= $result_seCompany['Company_NameT'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2" >&nbsp;</div>
                        </div>
                        <div class="row">
                            <input class="form-control" type="hidden" id="createby" name="createby" value="<?=$_SESSION["USERNAME"]?>">
                            <div class="col-lg-2">
                                <label>เลือกทะเบียนรถ / ชื่อรถ:</label>
                                <div class="dropdown bootstrap-select show-tick form-control">
                                    <select id="regiscarsearch" name="regiscarsearch" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือกทะเบียนรถ / ชื่อรถ..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                        <?php   
                                            $sql_seCarSearch = "SELECT DISTINCT VEHICLEREGISNUMBER,THAINAME FROM VEHICLEINFO";
                                            $query_seCarSearch = sqlsrv_query($conn, $sql_seCarSearch);
                                            while ($result_seCarSearch = sqlsrv_fetch_array($query_seCarSearch, SQLSRV_FETCH_ASSOC)) {
                                                $VEHICLEREGISNUMBER=$result_seCarSearch['VEHICLEREGISNUMBER'];
                                                $THAINAME=$result_seCarSearch['THAINAME'];
                                                if($THAINAME=='-'){
                                                    $ifregisnamecar=$VEHICLEREGISNUMBER;
                                                }else{
                                                    $ifregisnamecar=$VEHICLEREGISNUMBER.' / '.$THAINAME;
                                                }
                                        ?>
                                            <option value="<?= $VEHICLEREGISNUMBER ?>"><?= $ifregisnamecar ?></option>
                                        <?php } ?>
                                    </select>                                                            
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <label>พื้นที่:</label>
                                <div class="dropdown bootstrap-select show-tick form-control">
                                    <select id="areasearch" name="areasearch" class="selectpicker form-control" title="เลือกพื้นที่...">
                                        <option value="AMT">AMT</option>
                                        <option value="GW">GW</option>
                                    </select>                                                            
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>เลือกปีเริ่มต้น (ค้นหา)</label><br>   
                                    <select id="yearstart" name="yearstart" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือกปีเริ่มต้น..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                        <option value ="" disabled selected >- เลือกปี -</option>
                                        <?php
                                        for ($y = 1993; $y <= 2100; $y++) { ?>
                                        <option value ="<?=$y?>" <?=(1993==$y? 'selected' : '')?> > <?=$y?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>เลือกปีสิ้นสุด (ค้นหา)</label><br>   
                                    <select id="yearend" name="yearend" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือกปีสิ้นสุด..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                        <option value ="" disabled selected >- เลือกปี -</option>
                                        <?php
                                        for ($y = 1993; $y <= 2100; $y++) { ?>
                                        <option value ="<?=$y?>" <?=(date("Y")==$y? 'selected' : '')?> > <?=$y?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>ค้นหาข้อมูลประวัติรถที่เกิดอุบัติเหตุ </label><br>   
                                    <input type="button"  name="" id="" onclick="search_accident_car()" value="ค้นหาข้อมูลประวัติรถที่เกิดอุบัติเหตุ" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                บันทึกข้อมูลรถที่เกิดอุบัติเหตุ
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <!-- Nav tabs -->
                                        <!-- <ul class="nav nav-pills">
                                            <li class="active"><a href="#accident" data-toggle="tab" aria-expanded="true">ลงข้อมูลอุบัติเหตุ</a>
                                            </li>
                                            <li><a href="#simulator" data-toggle="tab">ลงข้อมูล SIMULATOR</a>
                                            </li>
                                            <li><a href="#feedbackdriver" data-toggle="tab">ลงข้อมูล Feedback Driver</a>
                                            </li>
                                        </ul> -->                                        
                                        <?php
                                            $strACCICAR_ID = null;
                                            if (isset($_GET["ACCICAR_ID"])) {
                                                $strACCICAR_ID = $_GET["ACCICAR_ID"];
                                            }
                                            // echo $strACCICAR_ID;
                                            $sql_accicar = "SELECT *,CONVERT(VARCHAR(16),DT_ACCI,20) CON_DT_ACCI FROM ACCIDENTHISTORY_CAR WHERE ACCICAR_ID = '".$strACCICAR_ID."' ";
                                            $query_accicar = sqlsrv_query($conn, $sql_accicar);
                                            $result_accicar = sqlsrv_fetch_array($query_accicar, SQLSRV_FETCH_ASSOC);
                                        ?>
                                        <input type="hidden" name="accicar_id" id="accicar_id" value="<?php echo $result_accicar["ACCICAR_ID"];?>">
                                        <div class="tab-content">
                                            <div class="row">
                                                <div class="col-md-12" >&nbsp;</div>
                                            </div>
                                            <div class="tab-pane fade active in" id="accident">
                                                <div class="row">
                                                    <!-- <div class="col-lg-12" > -->
                                                        <!-- <div class="panel panel-default"> -->
                                                            <!-- <div class="panel-heading" style="background-color: #f0c402;"> -->
                                                                <!-- <label><font style="font-size: 16px">บันทึกข้อมูลรถที่เกิดอุบัติเหตุ</font></label> -->
                                                            <!-- </div> -->
                                                            <div class="panel-body">
                                                                <div class="alert alert-info" style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <div class="col-lg-2">
                                                                                <label><u>เลือกทะเบียนรถ / ชื่อรถ</u></label><br>
                                                                                <div class="dropdown bootstrap-select show-tick form-control">
                                                                                    <select id="regiscar" name="regiscar" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือกทะเบียนรถ / ชื่อรถ..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                        <?php   
                                                                                            $sql_seCar = "SELECT DISTINCT VEHICLEREGISNUMBER,THAINAME FROM VEHICLEINFO";
                                                                                            $query_seCar = sqlsrv_query($conn, $sql_seCar);
                                                                                            while ($result_seCar = sqlsrv_fetch_array($query_seCar, SQLSRV_FETCH_ASSOC)) {
                                                                                                $VEHICLEREGISNUMBER=$result_seCar['VEHICLEREGISNUMBER'];
                                                                                                $THAINAME=$result_seCar['THAINAME'];
                                                                                                if($THAINAME=='-'){
                                                                                                    $ifregisnamecar=$VEHICLEREGISNUMBER;
                                                                                                }else{
                                                                                                    $ifregisnamecar=$VEHICLEREGISNUMBER.' / '.$THAINAME;
                                                                                                }
                                                                                        ?>
                                                                                            <option value="<?= $VEHICLEREGISNUMBER ?>" <?php if($result_accicar["RG_CAR"]==$VEHICLEREGISNUMBER){echo "selected";};?>><?= $ifregisnamecar ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-1">
                                                                                <label><u>เลือกพื้นที่</u></label><br>
                                                                                <div class="dropdown bootstrap-select show-tick form-control">
                                                                                    <select id="area" name="area" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือกพื้นที่..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                        <option value="AMT" <?php if($result_accicar["AREA"]=="AMT"){echo "selected";};?>>AMT</option>
                                                                                        <option value="GW" <?php if($result_accicar["AREA"]=="GW"){echo "selected";};?>>GW</option>
                                                                                    </select> 
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-2">
                                                                                <label><u>พนักงานขับรถ</u></label><br>
                                                                                <div class="dropdown bootstrap-select show-tick form-control">
                                                                                    <select id="employee" name="employee" onchange="showDiv(this)" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือกพนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                    <option value="พนักงานลาออกแล้ว" <?php if($result_accicar["EMP_CODE"]=="พนักงานลาออกแล้ว"){echo "selected";};?>>---พนักงานลาออกแล้ว---</option>
                                                                                        <?php   
                                                                                            $sql_seName = "SELECT * FROM EMPLOYEEEHR2 ORDER BY PersonCode ASC";
                                                                                            $query_seName = sqlsrv_query($conn, $sql_seName);
                                                                                            while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                                                                        ?>
                                                                                            <option value="<?= $result_seName['PersonCode'] ?>" <?php if($result_accicar["EMP_CODE"]==$result_seName['PersonCode']){echo "selected";};?>><?= $result_seName['nameT'] ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>                                                                             
                                                                            <div class="col-lg-2" id="EMP_NAME_DIV" <?php if($result_accicar["EMP_CODE"]=="พนักงานลาออกแล้ว"){ echo 'style="display:block;"'; }else{ echo 'style="display:none;"';};?>>
                                                                                <label><u>ชื่อพนักงาน</u></label><br>
                                                                                <input id="employee_name" name="employee_name" class="form-control" placeholder="ชื่อพนักงาน..." title="ชื่อพนักงาน" value="<?=$result_accicar["EMP_NAME"];?>"  min="" max=""  autocomplete="off">
                                                                            </div> 
                                                                            <div class="col-lg-2">
                                                                                <label><u>วันที่ / เวลาเกิดอุบัติเหตุ</u></label><br>
                                                                                <input id="daycaraccident" name="daycaraccident" class="form-control dateen" placeholder="ลงข้อมูลวันที่ / เวลาเกิดอุบัติเหตุ..."  title="วันที่/เวลาเกิดอุบัติเหตุ" value="<?=$result_accicar["CON_DT_ACCI"];?>"  min="" max=""  autocomplete="off">
                                                                            </div>
                                                                            <div class="col-lg-2">
                                                                                <label><u>สถานที่เกิดอุบัติเหตุ</u></label><br>
                                                                                <input id="locationcaraccident" name="locationcaraccident" class="form-control" placeholder="ลงข้อมูลสถานที่เกิดอุบัติเหตุ..."  title="สถานที่เกิดอุบัติเหตุ" value="<?=$result_accicar["LC_ACCI"];?>"  min="" max=""  autocomplete="off">
                                                                            </div>
                                                                        </div> 
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <div class="col-lg-6">
                                                                                <label><u>ปัญหาจากการเกิดอุบัติเหตุ</u></label><br>
                                                                                <input id="problemcaraccident" name="problemcaraccident" class="form-control" placeholder="ลงข้อมูลปัญหาจากการเกิดอุบัติเหตุ..." title="ปัญหาจากการเกิดอุบัติเหตุ" value="<?=$result_accicar["PB_ACCI"];?>"  min="" max=""  autocomplete="off">
                                                                            </div>  
                                                                            <div class="col-lg-1">
                                                                                <label>&nbsp;</label><br>
                                                                            </div>
                                                                            <div class="col-lg-3">
                                                                                <label><u>สถานที่ซ่อม</u></label><br>
                                                                                <label><input type="radio" name="repairby" id="repairby" class="radioexam" value="inrepair" <?php if($result_accicar["RP_INOUT"]=="inrepair"){echo "checked";};?>>ซ่อมใน</label>
                                                                                <label><input type="radio" name="repairby" id="repairby" class="radioexam" value="outrepair" <?php if($result_accicar["RP_INOUT"]=="outrepair"){echo "checked";};?>>ซ่อมนอก</label>
                                                                            </div>  
                                                                            <div class="col-lg-2">
                                                                                <label>&nbsp;</label><br>
                                                                            </div>
                                                                        </div> 
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <div class="outrepair <?php if($strACCICAR_ID!=""){ if($result_accicar["RP_INOUT"]=="inrepair"){ echo "selectt"; }else if($result_accicar["RP_INOUT"]=="outrepair"){ echo ""; } }else{ echo "selectt"; }?> ">
                                                                                <div class="col-lg-4">
                                                                                    <label><u>ชื่ออู่นอก</u></label><br>
                                                                                    <input class="form-control" placeholder="ชื่ออู่นอก..." title="ชื่ออู่นอก" id="garageout" name="garageout" value="<?=$result_accicar["RP_OUT_GR"];?>">
                                                                                </div>
                                                                                <div class="col-lg-8">
                                                                                    <label><u>อาการที่ส่งซ่อม</u></label><br>
                                                                                    <input class="form-control" placeholder="อาการที่ส่งซ่อม..." title="อาการที่ส่งซ่อม" id="problemrepair" name="problemrepair" value="<?=$result_accicar["RP_OUT_GR_PB"];?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>                                                                      
                                                                </div>
                                                            </div>                                                                
                                                        <!-- </div> -->
                                                    <!-- </div> -->
                                                    <div  class="col-lg-12" style="text-align: center;">
                                                    <?php if($strACCICAR_ID==""){ ?>
                                                        <button type="button" class="button" name="myBtn" id ="myBtn" onclick="save_accident_car();">บันทึกข้อมูลอุบัติเหตุ</button>
                                                    <?php }else if($strACCICAR_ID!=""){ ?>
                                                        <button type="button" class="button" name="myBtn" id ="myBtn" onclick="update_accident_car();">อัพเดทข้อมูลอุบัติเหตุ</button>
                                                    <?php } ?>
                                                    </div>                           
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <style type="text/css">
                .selectt {
                    display: none;
                }
                .radioexam{
                    width:30px;
                    height:1.5em;
                }
                
                label {
                    margin-right: 10px;
                }
            </style>

            <script src="../vendor/jquery/jquery.min.js"></script>
            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <!-- <script src="../vendor/metisMenu/metisMenu.min.js"></script> -->
            <!-- <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script> -->
            <!-- <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script> -->
            <!-- <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script> -->
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../js/jquery.datetimepicker.full.js"></script>

            <!-- <script src="../dist/js/jszip.min.js"></script> -->
            <!-- <script src="../dist/js/dataTables.buttons.min.js"></script> -->
            <!-- <script src="../dist/js/buttons.html5.min.js"></script> -->
            <!-- <script src="../dist/js/buttons.print.min.js"></script> -->
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>   
    </body>
    <script type="text/javascript"> 
    
        function showDiv(select) {
            if (select.value == "พนักงานลาออกแล้ว") {
                document.getElementById('EMP_NAME_DIV').style.display = "block";
                // document.getElementById('vehiclelist_num').value = "";
            } else {
                document.getElementById('EMP_NAME_DIV').style.display = "none";
                // document.getElementById('vehiclelist').value = "";
            }
        }
        
        $(document).ready(function() {
            $('input[type="radio"]').click(function() {
                var inputValue = $(this).attr("value");
                var targetBox = $("." + inputValue);
                $(".selectt").not(targetBox).hide();
                $(targetBox).show();
            });
        });                                                                                                
        function search_accident_car(){
            var regiscar = document.getElementById('regiscarsearch').value;
            var area = document.getElementById('areasearch').value;
            var yearstart = document.getElementById('yearstart').value;
            var yearend = document.getElementById('yearend').value;
            location.href='report_accidenthhistory_car.php?regiscar=' + regiscar+'&area=' + area+'&yearstart='+yearstart+'&yearend='+yearend;
            // window.open('report_accidenthhistory_car.php?regiscar=' + regiscar+'&area=' + area+'&yearstart='+yearstart+'&yearend='+yearend, '_blank');
        }
        function save_accident_car(){
            var regiscar = document.getElementById('regiscar').value;
            var area = document.getElementById('area').value;
            var employee = document.getElementById('employee').value;
            var employee_name = document.getElementById('employee_name').value;
            var daycaraccident = document.getElementById('daycaraccident').value;
            var locationcaraccident = document.getElementById('locationcaraccident').value;
            var problemcaraccident = document.getElementById('problemcaraccident').value;
			var repairby = $("input[type='radio']:checked").val();
            var garageout = document.getElementById('garageout').value;
            var problemrepair = document.getElementById('problemrepair').value;
            var createby = document.getElementById('createby').value;
            $.ajax({
                    type: 'post',
                    url: 'meg_accidenthistory_car_save.php',
                    data: {
                    txt_flg: "save_accident_car",
                    regiscar: regiscar,
                    area: area,
                    employee: employee, 
                    employee_name: employee_name,
                    daycaraccident: daycaraccident,
                    locationcaraccident: locationcaraccident,
                    problemcaraccident: problemcaraccident,
                    repairby: repairby,
                    garageout: garageout,
                    problemrepair: problemrepair,
                    createby: createby
                },  
                    success: function (rs) {
                    alert("บันทึกข้อมูลเรียบร้อย");
                    // alert(rs);    
                    window.location.reload();
                }
            });
        } 
        function update_accident_car(){            
            var accicar_id = document.getElementById('accicar_id').value;
            var regiscar = document.getElementById('regiscar').value;
            var area = document.getElementById('area').value;
            var employee = document.getElementById('employee').value;
            var employee_name = document.getElementById('employee_name').value;
            var daycaraccident = document.getElementById('daycaraccident').value;
            var locationcaraccident = document.getElementById('locationcaraccident').value;
            var problemcaraccident = document.getElementById('problemcaraccident').value;
			var repairby = $("input[type='radio']:checked").val();
            var garageout = document.getElementById('garageout').value;
            var problemrepair = document.getElementById('problemrepair').value;
            // alert(accicar_id)            
            // alert(regiscar)
            // alert(area)
            // alert(employee)
            // alert(daycaraccident)
            // alert(locationcaraccident)
            // alert(problemcaraccident)
            // alert(repairby)
            // alert(garageout)
            // alert(problemrepair)
            $.ajax({
                    type: 'post',
                    url: 'meg_accidenthistory_car_save.php',
                    data: {
                    txt_flg: "update_accident_car",
                    accicar_id: accicar_id,
                    regiscar: regiscar,
                    area: area,
                    employee: employee, 
                    employee_name: employee_name,
                    daycaraccident: daycaraccident,
                    locationcaraccident: locationcaraccident,
                    problemcaraccident: problemcaraccident,
                    repairby: repairby,
                    garageout: garageout,
                    problemrepair: problemrepair
                },  
                    success: function (rs) {
                    alert("บันทึกข้อมูลเรียบร้อย");
                    // alert(rs);    
                    // window.location.reload();
                    location.assign('meg_accidenthistory_car.php');
                }
            });
        }  
        $(function () {
            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            // กรณีใช้แบบ input
            $(".dateen").datetimepicker({
                timepicker: true,
                dateformat: 'Y-m-d' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                timeFormat: "HH:mm"
            }
            );
        });
        $(function () {
            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            // กรณีใช้แบบ input
            $(".dateensimu").datetimepicker({
                timepicker: false,
                format: 'Y-m-d', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            });
        });            
        $(document).ready(function () {
            $('#dataTables-example1').DataTable({
                responsive: true
            });
            $('#dataTables-example2').DataTable({
                responsive: true
            });
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>
</html>
<?php sqlsrv_close($conn); ?>
