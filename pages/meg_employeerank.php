<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");




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
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">


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
                <!-- <li>
                    <font style="color:#337ab7 "><?= $result_seEmployee['nameT'] ?></font>
                </li> -->
                <!-- <li class="dropdown">
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
                </li> -->

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
                                $meg = 'Driver Ranking';




                                echo "<a href='index.php?type=report'>หน้าหลัก</a>  / " . $meg;
                                $link = "<a href='index.php?type=report'>หน้าหลัก</a> ";
                                $_SESSION["link"] = $link;
                                ?>
                            </div>
                            <!-- /.panel-heading -->

                            <!-- <div class="col-lg-6 text-right">
                                <?= $result_seCompany['Company_NameT'] ?>
                            </div> -->
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-md-2" >&nbsp;</div>
                        </div>
                        <div id="datadef">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    Driver Ranking
                                                </div>



                                            </div>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-pills">
                                                <li class="active"><a href="#ranking" data-toggle="tab" aria-expanded="true">ลงข้อมูลแรงค์พนักงาน</a>
                                                </li>
                                                <li><a href="#searching" data-toggle="tab">ค้นหาข้อมูลแรงค์พนักงาน</a>
                                                </li> 
                                                <!--<li><a href="#feedbackdriver" data-toggle="tab">ลงข้อมูล Feedback Driver</a>
                                                </li> -->
                                            </ul>
                                            <div class="tab-content">
                                                <div class="row">
                                                    <div class="col-md-12" >&nbsp;</div>
                                                </div>

                                                <!-- TAP RANKING -->
                                                <div class="tab-pane fade active in" id="ranking">
                                                    <div class="row">
                                                        <input  class="form-control" type="hidden" id="txt_username" name="txt_username" value="<?=$_SESSION["USERNAME"]?>">
                                                        
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>Upload Data</label><br>   
                                                                <input type="button"  name="" id="" onclick="upload_employeerank()" value="Upload Accident Data" class="btn btn-primary">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <!-- START ROW1 -->
                                                    <div class="col-lg-3" >
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" style="background-color: #f0c402;">
                                                                <label><font style="font-size: 16px">ข้อมูลพนักงาน</font></label>
                                                            </div>
                                                            
                                                            <div class="panel-body">
                                                                <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                    <div class = "row">
                                                                        <div class="">
                                                                                <div class="form-group">
                                                                                    <label>รายละเอียดข้อมูลของพนักงาน</label><br><br>
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>พนักงานขับรถ (บันทึกข้อมูล)</u></label><br>
                                                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                                                <select   id="txt_drivernameinsert" name="txt_drivernameinsert" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                    <?php
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
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label>เลือกเดือน (บันทึกข้อมูล)</label><br>   
                                                                                            <select   id="txt_selectmonthinsert" name="txt_selectmonthinsert" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก เดือน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                <option value ="" disabled selected >- เลือกเดือน -</option>
                                                                                                <option value="มกราคม">มกราคม</option>
                                                                                                <option value="กุมภาพันธ์">กุมภาพันธ์</option>
                                                                                                <option value="มีนาคม">มีนาคม</option>
                                                                                                <option value="เมษายน">เมษายน</option>
                                                                                                <option value="พฤษภาคม">พฤษภาคม</option>
                                                                                                <option value="มิถุนายน">มิถุนายน</option>
                                                                                                <option value="กรกฎาคม">กรกฎาคม</option>
                                                                                                <option value="สิงหาคม">สิงหาคม</option>
                                                                                                <option value="กันยายน">กันยายน</option>
                                                                                                <option value="ตุลาคม">ตุลาคม</option>
                                                                                                <option value="พฤศจิกายน">พฤศจิกายน</option>
                                                                                                <option value="ธันวาคม">ธันวาคม</option>     
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label>เลือกปี (บันทึกข้อมูล)</label><br>   
                                                                                            <select   id="txt_selectyearsinsert" name="txt_selectyearsinsert" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปี..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                <option value ="" disabled selected >- เลือกปี -</option>
                                                                                                <?php
                                                                                                for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                                                <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label>เลือกพื้นที่</label><br>   
                                                                                            <select   id="txt_selectarea" name="txt_selectarea" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปี..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                <option value =""  selected >- เลือกพื้นที่ -</option>
                                                                                                <option value ="gw"  >GW</option>
                                                                                                <option value ="amt" >AMT</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                                                                                           
                                                                                    

                                                                                </div>

                                                                                <br><br>
                                                                                
                                                                        </div>
                                                                    </div>
                                                                    <br><br>  
                                                                    <div class = "row">
                                                                        <label ></label>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    
                                                </div>
                                                <!-- END COLUNM1    -->
                                                <!-- START COLUNM2 -->
                                                <div class="col-lg-3" >
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" style="background-color: #f0c402;">
                                                            <label><font style="font-size: 16px">แผนกคุณภาพและความปลอดภัย</font></label>
                                                        </div>
                                                        
                                                        <div class="panel-body">
                                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                <div class = "row">
                                                                    <div class="">
                                                                            <div class="form-group">
                                                                                <label >รายละเอียดแผนกคุณภาพและความปลอดภัย</label><br><br>
                                                                                <div class="col-lg-12">
                                                                                        <label ><u>อุบัติเหตุ (รถบรรทุก)</u></label><br>
                                                                                        <input class="form-control" placeholder="อุบัติเหตุ (รถบรรทุก)..." style="height:40px; width:325px" id="txt_accidenttruck" name="txt_accidenttruck" value=""  min="" max=""  autocomplete="off">
                                                                                </div>
                                                                                <br><br><br><br>
                                                                                <div class="col-lg-12">
                                                                                        <label ><u>อุบัติเหตุ (สินค้าเสียหาย)</u></label><br>
                                                                                        <input class="form-control" placeholder="อุบัติเหตุ (สินค้าเสียหาย)..." style="height:40px; width:325px" id="txt_accidentproduct" name="txt_accidentproduct" value=""  min="" max=""  autocomplete="off">
                                                                                </div>
                                                                                <br><br><br><br>
                                                                                <div class="col-lg-12">
                                                                                        <label ><u>ตรวจสอบ (การทำงาน)</u></label><br>
                                                                                        <input class="form-control" placeholder="ตรวจสอบ (การทำงาน)..." style="height:40px; width:325px" id="txt_workchecking" name="txt_workchecking" value=""  min="" max=""  autocomplete="off">
                                                                                </div>                                                                           
                                                                                <br><br><br><br>
                                                                                <div class="col-lg-12">
                                                                                        <label ><u>พฤติกรรม (การขับขี่)</u></label><br>
                                                                                        <input class="form-control" placeholder="พฤติกรรม (การขับขี่)..." style="height:40px; width:325px" id="txt_drivingbehavior" name="txt_drivingbehavior" value=""  min="" max=""  autocomplete="off">
                                                                                </div>    
                                                                                <br><br><br><br>
                                                                                <div class="col-lg-12">
                                                                                        <label ><u>การปฎิบัติงาน (พนักงานขับรถ)</u></label><br>
                                                                                        <input class="form-control" placeholder="การปฎิบัติงาน (พนักงานขับรถ)..." style="height:40px; width:325px" id="txt_operationdriver" name="txt_operationdriver" value=""  min="" max=""  autocomplete="off">
                                                                                </div> 
                                                                            </div>

                                                                            <br><br>
                                                                            
                                                                    </div>
                                                                </div>
                                                                <br><br>  
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <!-- <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div> -->
                                                                                                
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                
                                                </div>
                                                <!-- END COLUNM2 -->  
                                                <!-- START COLUNM3 -->
                                                <div class="col-lg-3" >
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" style="background-color: #f0c402;">
                                                            <label><font style="font-size: 16px">แผนกการตลาดและวางแผน/แผนกซ่อมบำรุง</font></label>
                                                        </div>
                                                        
                                                        <div class="panel-body">
                                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                <div class = "row">
                                                                    <div class="">
                                                                            <div class="form-group">
                                                                                <label >รายละเอียดแผนกการตลาดและวางแผน/แผนกซ่อมบำรุง</label><br><br>
                                                                                <div class="col-lg-12">
                                                                                        <label ><u>ข้อร้องเรียนจากลูกค้า</u></label><br>
                                                                                        <input class="form-control" placeholder="ข้อร้องเรียนจากลูกค้า..." style="height:40px; width:325px" id="txt_complainfromcus" name="txt_complainfromcus" value=""  min="" max=""  autocomplete="off">
                                                                                </div>
                                                                                <br><br><br><br>
                                                                                <div class="col-lg-12">
                                                                                        <label ><u>รถบรรทุกพร้อมใช้</u></label><br>
                                                                                        <input class="form-control" placeholder="รถบรรทุกพร้อมใช้..." style="height:40px; width:325px" id="txt_truckready" name="txt_truckready" value=""  min="" max=""  autocomplete="off">
                                                                                </div>
                                                                            </div>

                                                                            <br><br>
                                                                            
                                                                    </div>
                                                                </div>
                                                                <br><br>  
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>                      
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                
                                                </div>                                                   
                                                <!-- END COLUNM3 --> 
                                                <!-- START COLUNM4 -->
                                                <div class="col-lg-3" >
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" style="background-color: #f0c402;">
                                                            <label><font style="font-size: 16px">แผนกบุคคล</font></label>
                                                        </div>
                                                        
                                                        <div class="panel-body">
                                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                <div class = "row">
                                                                    <div class="">
                                                                            <div class="form-group">
                                                                                <label >รายละเอียดแผนกบุคคล</label><br><br>
                                                                                <div class="col-lg-12">
                                                                                        <label ><u>ปฏิบัติตามระเบียบบริษัทฯ</u></label><br>
                                                                                        <input class="form-control" placeholder="ปฏิบัติตามระเบียบบริษัทฯ..." style="height:40px; width:325px" id="txt_companyregulation" name="txt_companyregulation" value=""  min="" max=""  autocomplete="off">
                                                                                </div>
                                                                                <br><br><br><br>
                                                                                <div class="col-lg-12">
                                                                                        <label ><u>การเข้าร่วมประชุม/กิจกรรม</u></label><br>
                                                                                        <input class="form-control" placeholder="การเข้าร่วมประชุม/กิจกรรม..." style="height:40px; width:325px" id="txt_attendance" name="txt_attendance" value=""  min="" max=""  autocomplete="off">
                                                                                </div>
                                                                                <br><br><br><br>
                                                                                <div class="col-lg-12">
                                                                                        <label ><u>การมาทำงาน</u></label><br>
                                                                                        <input class="form-control" placeholder="การมาทำงาน..." style="height:40px; width:325px" id="txt_comingtowork" name="txt_comingtowork" value=""  min="" max=""  autocomplete="off">
                                                                                </div>    
                                                                            </div>

                                                                            <br><br>
                                                                            
                                                                    </div>
                                                                </div>
                                                                <br><br>  
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                                                
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                
                                                </div>                                                   
                                                <!-- END COLUNM4 -->  
                                                    <div  class="col-lg-12" style="text-align: center;">
                                                        <button type="button" class="button" name="myBtn" id ="myBtn"   onclick="save_driverranking();">บันทึกข้อมูลแรงค์พนักงาน</button>
                                                    </div>                                                  
                                                            <!-- /.panel-body -->
                                                        </div>
                                                    </div>
                                                
                                                    <div class="tab-pane fade" id="searching">
                                                        
                                                        <br>
                                                        <div class="row" >
                                                            <div class="col-lg-12">
                                                                <!-- <div class="panel panel-default"> -->
                                                                    <!-- <div class="panel-heading">
                                                                        
                                                                    </div> -->

                                                                    <!-- /.panel-heading -->
                                                                    <div class="panel-body">
                                                                        <!-- Tab panes -->
                                                                        <div class="tab-content">

                                                                            <div class="row">&nbsp;</div>
                                                                            <div class="row" >
                                                                                <div class="col-lg-12">
                                                                                    <div class="well">
                                                                                        <h4><b>ข้อมูลแรงค์พนักงานรายบุคคล</b></h4>
                                                                                        <div class="row">

                                                                                            
                                                                                        <div class="col-lg-3">
                                                                                            <label>เลือกพนักงาน:</label>
                                                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                                                <!-- $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', ""); -->
                                                                                                <select   id="txt_drivercodeperson" name="txt_drivercodeperson" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                    <?php
                                                                                                    // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                                                                    $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                                                                                    $params_seName = array(
                                                                                                        array('select_employeeehr2', SQLSRV_PARAM_IN),
                                                                                                        array('', SQLSRV_PARAM_IN)
                                                                                                    );
                                                                                                    $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                                                                                    while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                                                                                        ?>
                                                                                                        <option value="<?= $result_seName['PersonCode'] ?>"><?= $result_seName['nameT'] ?></option>
                                                                                                        <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                                <input class="form-control" style="display: none"   id="txt_copydiagramzone" name="txt_copydiagramzone" maxlength="500" value="" >
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-3">
                                                                                            <div class="form-group">
                                                                                                <label>เลือกเดือน (ค้นหาข้อมูล)</label><br>   
                                                                                                <select   id="txt_selectmonthperson" name="txt_selectmonthperson" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก เดือน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                    <option value ="" disabled selected >- เลือกเดือน -</option>
                                                                                                    <option value="มกราคม">มกราคม</option>
                                                                                                    <option value="กุมภาพันธ์">กุมภาพันธ์</option>
                                                                                                    <option value="มีนาคม">มีนาคม</option>
                                                                                                    <option value="เมษายน">เมษายน</option>
                                                                                                    <option value="พฤษภาคม">พฤษภาคม</option>
                                                                                                    <option value="มิถุนายน">มิถุนายน</option>
                                                                                                    <option value="กรกฎาคม">กรกฎาคม</option>
                                                                                                    <option value="สิงหาคม">สิงหาคม</option>
                                                                                                    <option value="กันยายน">กันยายน</option>
                                                                                                    <option value="ตุลาคม">ตุลาคม</option>
                                                                                                    <option value="พฤศจิกายน">พฤศจิกายน</option>
                                                                                                    <option value="ธันวาคม">ธันวาคม</option>     
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-3">
                                                                                            <div class="form-group">
                                                                                                <label>เลือกปีเริ่มต้น (ค้นหาข้อมูล)</label><br>   
                                                                                                <select   id="txt_selectyearstartperson" name="txt_selectyearstartperson" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปี..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                    <option value ="" disabled selected >- เลือกปี -</option>
                                                                                                    <?php
                                                                                                    for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                                                    <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                                                    <?php } ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-3">
                                                                                            <div class="form-group">
                                                                                                <label>เลือกปีสิ้นสุด (ค้นหาข้อมูล)</label><br>   
                                                                                                <select   id="txt_selectyearendperson" name="txt_selectyearendperson" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปี..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                    <option value ="" disabled selected >- เลือกปี -</option>
                                                                                                    <?php
                                                                                                    for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                                                    <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                                                    <?php } ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                            <!-- <div class="col-lg-2">
                                                                                                <label>&nbsp;</label>
                                                                                                <div class="form-group">
                                                                                                    <button type="button" class="btn btn-default" onclick="select_reporttransportplanstc();">ค้นหา <li class="fa fa-search"></li></button>
                                                                                                </div>

                                                                                            </div> -->




                                                                                            <div class="col-lg-2" style="text-align: left">
                                                                                                <div class="form-group">
                                                                                                    <label>ค้นหาข้อมูลรายบุคคล&nbsp;<i class="fa fa-search" aria-hidden="true"></i></label><br>   
                                                                                                    <input type="button" onclick="search_person()" name="" id="" value="ค้นหาข้อมูลรายบุคคล" class="btn btn-primary">
                                                                                                </div>
                                                                                            </div>
                                                                                            <!-- <div class="col-lg-2" style="text-align: left">
                                                                                                <div class="form-group">
                                                                                                    <label>พิมพ์ข้อมูลใบขับขี่(PDF) &nbsp;<i class="fa fa-file-pdf-o" aria-hidden="true"></i></label><br>   
                                                                                                    <input type="button" onclick="pdf_carlicenseperson()" name="" id="" value="พิมพ์ข้อมูลใบขับขี่(PDF)" class="btn btn-primary">
                                                                                                </div>
                                                                                            </div> -->
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row" >
                                                                                <div class="col-lg-12">
                                                                                    <div class="well">
                                                                                        <h4><b>ข้อมูลแรงค์พนักงานรายบริษัท</b></h4>
                                                                                        <div class="row">

                                                                                                
                                                                                            <div class="col-lg-3">
                                                                                                <div class="form-group">
                                                                                                    <label>เลือกบริษัท</label><br>   
                                                                                                    <select id="txt_selectcompany" name="txt_selectcompany" class="form-control" onchange="select_customer(this.value)">
                                                                                                        <option value="00">เลือกบริษัท</option>
                                                                                                        <option value="11">เลือกทั้งหมด</option>
                                                                                                        <option value="01">บริษัท ร่วมกิจรุ่งเรือง (1993)</option>
                                                                                                        <option value="02">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส</option>
                                                                                                        <option value="04">บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                                                                                        <option value="05">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์</option>
                                                                                                        <option value="06">บริษัท ร่วมกิจรุ่งเรือง ทรัค ดีเทลส์</option>
                                                                                                        <option value="07">บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์</option>
                                                                                                        <option value="08">บริษัท ร่วมกิจรุ่งเรือง เทรนนิ่ง เซ็นเตอร์</option>
                                                                                                        <option value="09">บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</option>
                                                                                                        <option value="10">บริษัท ร่วมกิจ ไอที</option>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                            <!-- <div class="col-lg-2">
                                                                                                <label>&nbsp;</label>
                                                                                                <div class="form-group">
                                                                                                    <button type="button" class="btn btn-default" onclick="select_reporttransportplanstc();">ค้นหา <li class="fa fa-search"></li></button>
                                                                                                </div>

                                                                                            </div> -->
                                                                                            <div class="col-lg-3">
                                                                                                <div class="form-group">
                                                                                                    <label>เลือกเดือน (ค้นหาข้อมูล)</label><br>   
                                                                                                    <select   id="txt_selectmonthcompany" name="txt_selectmonthcompany" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก เดือน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                        <option value ="" disabled selected >- เลือกเดือน -</option>
                                                                                                        <option value="มกราคม">มกราคม</option>
                                                                                                        <option value="กุมภาพันธ์">กุมภาพันธ์</option>
                                                                                                        <option value="มีนาคม">มีนาคม</option>
                                                                                                        <option value="เมษายน">เมษายน</option>
                                                                                                        <option value="พฤษภาคม">พฤษภาคม</option>
                                                                                                        <option value="มิถุนายน">มิถุนายน</option>
                                                                                                        <option value="กรกฎาคม">กรกฎาคม</option>
                                                                                                        <option value="สิงหาคม">สิงหาคม</option>
                                                                                                        <option value="กันยายน">กันยายน</option>
                                                                                                        <option value="ตุลาคม">ตุลาคม</option>
                                                                                                        <option value="พฤศจิกายน">พฤศจิกายน</option>
                                                                                                        <option value="ธันวาคม">ธันวาคม</option>     
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-3">
                                                                                                <div class="form-group">
                                                                                                    <label>เลือกปีเริ่มต้น (ค้นหาข้อมูล)</label><br>   
                                                                                                    <select   id="txt_selectyearsstartcompany" name="txt_selectyearsstartcompany" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปี..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                        <option value ="" disabled selected >- เลือกปี -</option>
                                                                                                        <?php
                                                                                                        for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                                                        <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                                                        <?php } ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>            
                                                                                            <div class="col-lg-3">
                                                                                                <div class="form-group">
                                                                                                    <label>เลือกปีสิ้นสุด (ค้นหาข้อมูล)</label><br>   
                                                                                                    <select   id="txt_selectyearsendcompany" name="txt_selectyearsendcompany" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปี..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                        <option value ="" disabled selected >- เลือกปี -</option>
                                                                                                        <?php
                                                                                                        for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                                                        <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                                                        <?php } ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div> 


                                                                                            <div class="col-lg-2" style="text-align: left">
                                                                                                <div class="form-group">
                                                                                                    <label>ค้นหาข้อมูลรายบริษัท &nbsp;<i class="fa fa-search" aria-hidden="true"></i></label><br>   
                                                                                                    <input type="button" onclick="search_company()" name="" id="" value="ค้นหาข้อมูลรายบริษัท" class="btn btn-primary">
                                                                                                </div>
                                                                                            </div>
                                                                                            <!-- <div class="col-lg-2" style="text-align: left">
                                                                                                <div class="form-group">
                                                                                                    <label>พิมพ์ข้อมูลใบขับขี่(PDF) &nbsp;<i class="fa fa-file-pdf-o" aria-hidden="true"></i></label><br>   
                                                                                                    <input type="button" onclick="pdf_carlicensecompany()" name="" id="" value="พิมพ์ข้อมูลใบขับขี่(PDF)" class="btn btn-primary">
                                                                                                </div>
                                                                                            </div> -->
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row" >
                                                                                <div class="col-lg-12">
                                                                                    <div class="well">
                                                                                        <h4><b>ข้อมูลแรงค์พนักงาน(แยกตามตำแหน่งของพนักงาน)</b></h4>
                                                                                        <div class="row">

                                                                                            
                                                                                            <div class="col-lg-3">
                                                                                                <label>เลือกตำแหน่งพนักงาน:</label>
                                                                                                <div class="dropdown bootstrap-select show-tick form-control">
                                                                                                    <!-- $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', ""); -->
                                                                                                    <select   id="txt_position" name="txt_position" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ตำแหน่งพนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                        <option value="000">เลือกทั้งหมด</option>
                                                                                                        <?php
                                                                                                        // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                                                                        $sql_sePosition = "{call megEmployeeEHR_v2(?,?)}";
                                                                                                        $params_sePosition = array(
                                                                                                            array('select_positionNameT', SQLSRV_PARAM_IN),
                                                                                                            array('', SQLSRV_PARAM_IN)
                                                                                                        );
                                                                                                        $query_sePosition = sqlsrv_query($conn, $sql_sePosition, $params_sePosition);
                                                                                                        while ($result_sePosition = sqlsrv_fetch_array($query_sePosition, SQLSRV_FETCH_ASSOC)) {
                                                                                                            ?>
                                                                                                            <option value="<?= $result_sePosition['PositionID'] ?>"><?= $result_sePosition['PositionName'] ?></option>
                                                                                                            <?php
                                                                                                        }
                                                                                                        ?>
                                                                                                    </select>
                                                                                                    <input class="form-control" style="display: none"   id="txt_copyposition" name="txt_copyposition" maxlength="500" value="" >
                                                                                                </div>
                                                                                            </div>
                                                                                            <!-- <div class="col-lg-2">
                                                                                                <label>&nbsp;</label>
                                                                                                <div class="form-group">
                                                                                                    <button type="button" class="btn btn-default" onclick="select_reporttransportplanstc();">ค้นหา <li class="fa fa-search"></li></button>
                                                                                                </div>

                                                                                            </div> -->
                                                                                            <div class="col-lg-3">
                                                                                                <div class="form-group">
                                                                                                    <label>เลือกเดือน (ค้นหาข้อมูล)</label><br>   
                                                                                                    <select   id="txt_selectmonthposition" name="txt_selectmonthposition" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก เดือน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                        <option value ="" disabled selected >- เลือกเดือน -</option>
                                                                                                        <option value="มกราคม">มกราคม</option>
                                                                                                        <option value="กุมภาพันธ์">กุมภาพันธ์</option>
                                                                                                        <option value="มีนาคม">มีนาคม</option>
                                                                                                        <option value="เมษายน">เมษายน</option>
                                                                                                        <option value="พฤษภาคม">พฤษภาคม</option>
                                                                                                        <option value="มิถุนายน">มิถุนายน</option>
                                                                                                        <option value="กรกฎาคม">กรกฎาคม</option>
                                                                                                        <option value="สิงหาคม">สิงหาคม</option>
                                                                                                        <option value="กันยายน">กันยายน</option>
                                                                                                        <option value="ตุลาคม">ตุลาคม</option>
                                                                                                        <option value="พฤศจิกายน">พฤศจิกายน</option>
                                                                                                        <option value="ธันวาคม">ธันวาคม</option>     
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-3">
                                                                                                <div class="form-group">
                                                                                                    <label>เลือกปีเริ่มต้น (ค้นหาข้อมูล)</label><br>   
                                                                                                    <select   id="txt_selectyearsstartposition" name="txt_selectyearsposition" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปี..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                        <option value ="" disabled selected >- เลือกปี -</option>
                                                                                                        <?php
                                                                                                        for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                                                        <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                                                        <?php } ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-3">
                                                                                                <div class="form-group">
                                                                                                    <label>เลือกปีสิ้นสุด (ค้นหาข้อมูล)</label><br>   
                                                                                                    <select   id="txt_selectyearsendposition" name="txt_selectyearsposition" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปี..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                        <option value ="" disabled selected >- เลือกปี -</option>
                                                                                                        <?php
                                                                                                        for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                                                        <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                                                        <?php } ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>


                                                                                            <div class="col-lg-2" style="text-align: left">
                                                                                                <div class="form-group">
                                                                                                    <label>พิมพ์ข้อมูลตามตำแหน่งพนักงาน &nbsp;<i class="fa fa-search" aria-hidden="true"></i></label><br>   
                                                                                                    <input type="button" onclick="search_position()" name="" id="" value="พิมพ์ข้อมูลตามตำแหน่งพนักงาน" class="btn btn-primary">
                                                                                                </div>
                                                                                            </div>
                                                                                            <!-- <div class="col-lg-2" style="text-align: left">
                                                                                                <div class="form-group">
                                                                                                    <label>พิมพ์ข้อมูลใบขับขี่(PDF) &nbsp;<i class="fa fa-file-pdf-o" aria-hidden="true"></i></label><br>   
                                                                                                    <input type="button" onclick="pdf_carlicenseposition()" name="" id="" value="พิมพ์ข้อมูลใบขับขี่(PDF)" class="btn btn-primary">
                                                                                                </div>
                                                                                            </div> -->
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>                            
                                                                            
                                                                        </div>




                                                                    </div>
                                                                    <!-- /.panel-body -->
                                                                <!-- </div> --> 
                                                                <!-- /.panel default -->
                                                            </div>
                                                        </div>
                                                        <!-- /.row -->
                                                    </div> 
                                                     <!-- END ROW TAP2-->
                                                </div>
                                                <!-- END TAP ALL-->

                                                                                             
                                                

                                            </div>
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel -->
                                </div>

                            </div>
                        </div>
                        <div id="datasr"></div>
                        <!-- /.panel -->
                    </div>
                </div>
            </div>




        <!--<script src="../vendor/jquery/jquery.min.js"></script>-->
            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../js/jquery.datetimepicker.full.js"></script>

            <!-- <script src="../dist/js/jszip.min.js"></script> -->
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>   

    </body>
    
                                                                                                    


            <script type="text/javascript"> 
                                                                                                 
            
            
            function upload_employeerank(){

            var type = 'Upload';
            var file = 'Excel';

            window.open('meg_insertemployeerankdata.php?type='+type+ '&file='+file, '_blank');

            }
            
            function save_driverranking() //save สำหรับ change สีการนอน
            {

                // alert(chkstatus);
                // alert(checkClient);

                var drivername = document.getElementById('txt_drivernameinsert').value;
                var monthth  = document.getElementById('txt_selectmonthinsert').value;
                var years  = document.getElementById('txt_selectyearsinsert').value;
                var area  = document.getElementById('txt_selectarea').value;

                var accidenttruck = document.getElementById('txt_accidenttruck').value;
                var accidentproduct = document.getElementById('txt_accidentproduct').value;
                var workchecking  = document.getElementById('txt_workchecking').value;
                var drivingbehavior    = document.getElementById('txt_drivingbehavior').value;
                var operationdriver = document.getElementById('txt_operationdriver').value;

                var complainfromcus    = document.getElementById('txt_complainfromcus').value;
                var truckready = document.getElementById('txt_truckready').value;

                var companyregulation = document.getElementById('txt_companyregulation').value;
                var attendance = document.getElementById('txt_attendance').value;
                var comingtowork = document.getElementById('txt_comingtowork').value;
                var createby = document.getElementById('txt_username').value;
                
                if (drivername == '') {
                    alert('กรุณาเลือกชื่อพนักงาน');
                }else if (monthth == '') {
                    alert('กรุณาเลือกเดือน');
                }else if (years == '') {
                    alert('กรุณาเลือกปี');
                }else if (area == '') {
                    alert('กรุณาเลือกพื้นที่');
                }else{
                    // accident truck chk
                    if (accidenttruck == '') {
                        accidenttruckchk = parseInt('0', 10);
                    }else{
                        accidenttruckchk = parseInt(accidenttruck, 10);
                    }
                    
                    // accident Product  chk
                    if (accidentproduct == '') {
                        accidentproductchk = parseInt('0', 10);
                    }else{
                        accidentproductchk = parseInt(accidentproduct, 10);
                    }

                    // workchecking  chk
                    if (workchecking == '') {
                        workcheckingchk = parseInt('0', 10);
                    }else{
                        workcheckingchk = parseInt(workchecking, 10);
                    }

                    // drivingbehavior  chk
                    if (drivingbehavior == '') {
                        drivingbehaviorchk = parseInt('0', 10);
                    }else{
                        drivingbehaviorchk = parseInt(drivingbehavior, 10);
                    }

                    // operationdriver  chk
                    if (operationdriver == '') {
                        operationdriverchk = parseInt('0', 10);
                    }else{
                        operationdriverchk = parseInt(operationdriver, 10);
                    }

                    // complainfromcus  chk
                    if (complainfromcus == '') {
                        complainfromcuschk = parseInt('0', 10);
                    }else{
                        complainfromcuschk = parseInt(complainfromcus, 10);
                    }

                    // truckready  chk
                    if (truckready == '') {
                        truckreadychk = parseInt('0', 10);
                    }else{
                        truckreadychk = parseInt(truckready, 10);
                    }

                    // companyregulation  chk
                    if (companyregulation == '') {
                        companyregulationchk = parseInt('0', 10);
                    }else{
                        companyregulationchk = parseInt(companyregulation, 10);
                    }

                    // attendance  chk
                    if (attendance == '') {
                        attendancechk = parseInt('0', 10);
                    }else{
                        attendancechk = parseInt(attendance, 10);
                    }

                    // attendance  chk
                    if (comingtowork == '') {
                        comingtoworkchk = parseInt('0', 10);
                    }else{
                        comingtoworkchk = parseInt(comingtowork, 10);
                    }

                    var allpoint = (accidenttruckchk+accidentproductchk+workcheckingchk+drivingbehaviorchk+operationdriverchk
                    +complainfromcuschk+truckreadychk+companyregulationchk+attendancechk+comingtoworkchk)

                    // alert(allpoint);
                    // alert(timejobstart);
                    // alert(sessionid);
                    // เช็คการลงข้อมูลคอลัมย์ที่1

                    if (allpoint == '100') {
                        rank ='A';
                    }else if((allpoint >= 90)&&(allpoint <= 99)){
                        rank ='B';
                    }else if((allpoint >= 80)&&(allpoint <= 89)){
                        rank ='C';
                    }else if((allpoint >= 70)&&(allpoint <= 79)){
                        rank ='D';
                    }else{
                        rank ='E';
                    }

                    // alert(rank);


                    if (monthth == 'มกราคม') {

                        var monththai = 'มกราคม';
                        var montheng  = 'January';
                        var yearscheck  = '01-'+years;

                        // alert(yearscheck);

                    }else if (monthth == 'กุมภาพันธ์'){

                        var monththai = 'กุมภาพันธ์';
                        var montheng  = 'February';
                        var yearscheck  = '02-'+years;

                    }else if (monthth == 'มีนาคม'){

                        var monththai = 'มีนาคม';
                        var montheng  = 'March';
                        var yearscheck  = '03-'+years;

                    }else if (monthth == 'เมษายน'){

                        var monththai = 'เมษายน';
                        var montheng  = 'April';
                        var yearscheck  = '04-'+years;

                    }else if (monthth == 'พฤษภาคม'){

                        var monththai = 'พฤษภาคม';
                        var montheng  = 'May';
                        var yearscheck  = '05-'+years;

                    }else if (monthth == 'มิถุนายน'){

                        var monththai = 'มิถุนายน';
                        var montheng  = 'June';
                        var yearscheck  = '06-'+years;

                    }else if (monthth == 'กรกฎาคม'){

                        var monththai = 'กรกฎาคม';
                        var montheng  = 'July';
                        var yearscheck  = '07-'+years;

                    }else if (monthth == 'สิงหาคม'){

                        var monththai = 'สิงหาคม';
                        var montheng  = 'August';
                        var yearscheck  = '08-'+years;

                    }else if (monthth == 'กันยายน'){

                        var monththai = 'กันยายน';
                        var montheng  = 'September';
                        var yearscheck  = '09-'+years;

                    }else if (monthth == 'ตุลาคม'){

                        var monththai = 'ตุลาคม';
                        var montheng  = 'October';
                        var yearscheck  = '10-'+years;

                    }else if (monthth == 'พฤศจิกายน'){

                        var monththai = 'พฤศจิกายน';
                        var montheng  = 'November';
                        var yearscheck  = '11-'+years;

                    }else{  

                        var monththai = 'ธันวาคม';
                        var montheng  = 'December';
                        var yearscheck  = '12-'+years;

                    }   


                    $.ajax({
                            type: 'post',
                            url: 'meg_data2.php',
                            data: {

                            txt_flg: "save_driverranking",
                            id:'', 
                            drivername: drivername,
                            monththai: monththai, 
                            montheng: montheng,
                            years: years,
                            yearscheck: yearscheck,
                            area: area,
                            accidenttruckchk: accidenttruckchk,
                            accidentproductchk: accidentproductchk,
                            workcheckingchk: workcheckingchk,
                            drivingbehaviorchk: drivingbehaviorchk,
                            operationdriverchk: operationdriverchk,
                            complainfromcuschk: complainfromcuschk,
                            truckreadychk: truckreadychk,
                            companyregulationchk: companyregulationchk,
                            attendancechk: attendancechk,
                            comingtoworkchk: comingtoworkchk,
                            allpoint: allpoint,
                            rank:rank,
                            createby: createby,
                            createdate: '',
                            modifyby: '',
                            modifydate: ''

                            },
                                success: function (rs) {

                                alert("บันทึกข้อมูลเรียบร้อย");
                                // // alert(rs);    
                                window.location.reload();
                            }
                        });
                
                } 
                // END ELSE

            }         
            function search_person()
            {
                var drivercode = document.getElementById('txt_drivercodeperson').value;
                var monthth = document.getElementById('txt_selectmonthperson').value;
                var yearstart = document.getElementById('txt_selectyearstartperson').value;
                var yearend = document.getElementById('txt_selectyearendperson').value;
                var company = '';
                var position = '';
                
                if (monthth == 'มกราคม') {

                var monththai = 'มกราคม';
                var montheng  = 'January';

                // alert(yearscheck);

                }else if (monthth == 'กุมภาพันธ์'){

                var monththai = 'กุมภาพันธ์';
                var montheng  = 'February';

                }else if (monthth == 'มีนาคม'){

                var monththai = 'มีนาคม';
                var montheng  = 'March';

                }else if (monthth == 'เมษายน'){

                var monththai = 'เมษายน';
                var montheng  = 'April';

                }else if (monthth == 'พฤษภาคม'){

                var monththai = 'พฤษภาคม';
                var montheng  = 'May';

                }else if (monthth == 'มิถุนายน'){

                var monththai = 'มิถุนายน';
                var montheng  = 'June';

                }else if (monthth == 'กรกฎาคม'){

                var monththai = 'กรกฎาคม';
                var montheng  = 'July';

                }else if (monthth == 'สิงหาคม'){

                var monththai = 'สิงหาคม';
                var montheng  = 'August';

                }else if (monthth == 'กันยายน'){

                var monththai = 'กันยายน';
                var montheng  = 'September';

                }else if (monthth == 'ตุลาคม'){

                var monththai = 'ตุลาคม';
                var montheng  = 'October';

                }else if (monthth == 'พฤศจิกายน'){

                var monththai = 'พฤศจิกายน';
                var montheng  = 'November';

                }else{  

                var monththai = 'ธันวาคม';
                var montheng  = 'December';

                }   

                if (drivercode == '') {
                    alert('กรุณาเลือกชื่อพนักงาน');
                }else if (monthth == ''){
                    alert('กรุณาเลือกเดือน');
                }else if (yearstart == ''){
                    alert('กรุณาเลือกปีเริ่มต้น');
                }else if (yearend == ''){
                    alert('กรุณาเลือกปีสิ้นสุด');
                }else{
                    window.open('report_employeerank.php?drivercode=' + drivercode+'&company='+company+'&position='+position+'&monththai='+monththai+'&montheng='+montheng+'&yearstartrank='+yearstart+'&yearsendrank='+yearend +'&type=person', '_blank');
                }
                
                

            }
            function search_company()
            {
                var drivercode = '';
                var monthth = document.getElementById('txt_selectmonthcompany').value;
                var yearstart = document.getElementById('txt_selectyearsstartcompany').value;
                var yearend = document.getElementById('txt_selectyearsendcompany').value;
                var company = document.getElementById('txt_selectcompany').value;
                var position = '';

                if (monthth == 'มกราคม') {

                var monththai = 'มกราคม';
                var montheng  = 'January';

                // alert(yearscheck);

                }else if (monthth == 'กุมภาพันธ์'){

                var monththai = 'กุมภาพันธ์';
                var montheng  = 'February';

                }else if (monthth == 'มีนาคม'){

                var monththai = 'มีนาคม';
                var montheng  = 'March';

                }else if (monthth == 'เมษายน'){

                var monththai = 'เมษายน';
                var montheng  = 'April';

                }else if (monthth == 'พฤษภาคม'){

                var monththai = 'พฤษภาคม';
                var montheng  = 'May';

                }else if (monthth == 'มิถุนายน'){

                var monththai = 'มิถุนายน';
                var montheng  = 'June';

                }else if (monthth == 'กรกฎาคม'){

                var monththai = 'กรกฎาคม';
                var montheng  = 'July';

                }else if (monthth == 'สิงหาคม'){

                var monththai = 'สิงหาคม';
                var montheng  = 'August';

                }else if (monthth == 'กันยายน'){

                var monththai = 'กันยายน';
                var montheng  = 'September';

                }else if (monthth == 'ตุลาคม'){

                var monththai = 'ตุลาคม';
                var montheng  = 'October';

                }else if (monthth == 'พฤศจิกายน'){

                var monththai = 'พฤศจิกายน';
                var montheng  = 'November';

                }else{  

                var monththai = 'ธันวาคม';
                var montheng  = 'December';

                }   

                if (company == '' || company == '00') {
                    alert('กรุณาเลือกบริษัท');
                }else if (monthth == ''){
                    alert('กรุณาเลือกเดือน');
                }else if (yearstart == ''){
                    alert('กรุณาเลือกปีเริ่มต้น');
                }else if (yearend == ''){
                    alert('กรุณาเลือกปีสิ้นสุด');
                }else{
                    window.open('report_employeerank.php?drivercode=' + drivercode+'&company='+company+'&position='+position+'&monththai='+monththai+'&montheng='+montheng+'&yearstartrank='+yearstart+'&yearsendrank='+yearend+'&type=company', '_blank');
                }
                

            }
            function search_position()
            {
                var drivercode = '';
                var monthth = document.getElementById('txt_selectmonthposition').value;
                var yearstart = document.getElementById('txt_selectyearsstartposition').value;
                var yearend= document.getElementById('txt_selectyearsendposition').value;
                var company = '';
                var position = document.getElementById('txt_position').value;

                if (monthth == 'มกราคม') {

                var monththai = 'มกราคม';
                var montheng  = 'January';

                // alert(yearscheck);

                }else if (monthth == 'กุมภาพันธ์'){

                var monththai = 'กุมภาพันธ์';
                var montheng  = 'February';

                }else if (monthth == 'มีนาคม'){

                var monththai = 'มีนาคม';
                var montheng  = 'March';

                }else if (monthth == 'เมษายน'){

                var monththai = 'เมษายน';
                var montheng  = 'April';

                }else if (monthth == 'พฤษภาคม'){

                var monththai = 'พฤษภาคม';
                var montheng  = 'May';

                }else if (monthth == 'มิถุนายน'){

                var monththai = 'มิถุนายน';
                var montheng  = 'June';

                }else if (monthth == 'กรกฎาคม'){

                var monththai = 'กรกฎาคม';
                var montheng  = 'July';

                }else if (monthth == 'สิงหาคม'){

                var monththai = 'สิงหาคม';
                var montheng  = 'August';

                }else if (monthth == 'กันยายน'){

                var monththai = 'กันยายน';
                var montheng  = 'September';

                }else if (monthth == 'ตุลาคม'){

                var monththai = 'ตุลาคม';
                var montheng  = 'October';

                }else if (monthth == 'พฤศจิกายน'){

                var monththai = 'พฤศจิกายน';
                var montheng  = 'November';

                }else{  

                var monththai = 'ธันวาคม';
                var montheng  = 'December';

                }   

                if (position == '') {
                    alert('กรุณาเลือกตำแหน่งพนักงาน');
                }else if (monthth == ''){
                    alert('กรุณาเลือกเดือน');
                }else if (yearstart == ''){
                    alert('กรุณาเลือกปีเริ่มต้น');
                }else if (yearend == ''){
                    alert('กรุณาเลือกปีสิ้นสุด');
                }else{
                    window.open('report_employeerank.php?drivercode=' + drivercode+'&company='+company+'&position='+position+'&monththai='+monththai+'&montheng='+montheng+'&yearstartrank='+yearstart+'&yearsendrank='+yearend+'&type=position', '_blank');
                }
                

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


            </script>
            <!-- <script>
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
            </script> -->

    

</html>
<?php
sqlsrv_close($conn);
?>
