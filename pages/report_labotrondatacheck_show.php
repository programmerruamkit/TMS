
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

if ($_GET['id1'] != "") {
    $condition1 = " AND a.MENUID = " . $_GET['id1'];
    $sql_getMenu = "{call megMenu_v2(?,?)}";
    $params_getMenu = array(
        array('select_menu', SQLSRV_PARAM_IN),
        array($condition1, SQLSRV_PARAM_IN)
    );
    $query_getMenu = sqlsrv_query($conn, $sql_getMenu, $params_getMenu);
    $result_getMenu = sqlsrv_fetch_array($query_getMenu, SQLSRV_FETCH_ASSOC);
}

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$sql_seAMT = "SELECT STD_ID AS 'AMT_ID',MAXSYS,MINSYS,MAXDIA,MINDIA,MAXPULSE,MINPULSE,TEMP,OXYGEN,ALCOHOL,REMARK
FROM STANDARDTENKODATA
WHERE REMARK ='GW'";
$query_seAMT = sqlsrv_query($conn, $sql_seAMT, $params_seAMT);
$result_seAMT = sqlsrv_fetch_array($query_seAMT, SQLSRV_FETCH_ASSOC);
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
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <!--<link href="../dist/css/sb-admin-2.css" rel="stylesheet">-->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <link href="../js/bootstrap-datepicker.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
        <!-- Zoom CSS -->
        <!-- <link rel="stylesheet" type="text/css" href="css/zoom.css"> -->
    </head>
    <style>
    h1 {
        text-align: center;
        text-transform: uppercase;
        /* color: #F94F05; */
        text-decoration: overline;
        text-decoration: underline;
        /* text-shadow: 2px 2px #F9DA05; */
        font-size:40px;
        }
       
        * {box-sizing: border-box;}
        body {font-family: Verdana, sans-serif;}
        .mySlides {display: none;}
        img {vertical-align: middle;}

        /* Slideshow container */
        .slideshow-container {
        max-width: 1000px;
        position: relative;
        margin: auto;
        }

        /* Caption text */
        .text {
        color: #f2f2f2;
        font-size: 15px;
        padding: 8px 12px;
        position: absolute;
        bottom: 8px;
        width: 100%;
        text-align: center;
        }

        /* Number text (1/3 etc) */
        .numbertext {
        color: #f2f2f2;
        font-size: 12px;
        padding: 8px 12px;
        position: absolute;
        top: 0;
        }

        /* The dots/bullets/indicators */
        .dot {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.6s ease;
        }

        .active {
        background-color: #717171;
        }

        /* Fading animation */
        .slide {
        animation-name: slide;
        animation-duration: 1.5s;
        }

        @keyframes slide {
        from {opacity: .4} 
        to {opacity: 1}
        }

        /* On smaller screens, decrease text size */
        @media only screen and (max-width: 300px) {
        .text {font-size: 11px}
        }

        
        div[data-balloon] {
            float:left;
        }

        div[data-balloon]:hover::after {
            content: attr(data-balloon);
            border: 1px solid black;
            border-radius: 8px;
            background: #eee;
            padding: 4px; 
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

    </style>
    <body>
        <div id="wrapper">
            <!-- <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

                <div class="navbar-header" >
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
            </nav> -->

            <div id="page-wrapper" >
            
                <div class="row">
                    <div class="col-md-12" style="background-color: #e7e7e7">
                        <h1>SMART HEALTH INFORMATION &nbsp; Day : <?=date("d/m/Y")?></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="background-color: #e7e7e7;font-size:20px;text-align: center">
                        <p><font color="red">ข้อมูลที่แสดงคือข้อมูลวันที่ปัจจุบันและย้อนหลัง 15 วัน</font></p>
                    </div>
                </div>
                <div class="row" style="background-color: #e7e7e7">
                    <!-- ตารางค่าความดัน -->
                    <div class="col-md-5" style="background-color: #e7e7e7">
                        <table style="border:1px solid black;">
                            <thead style="border:1px solid black;">
                                <tr>
                                    <th colspan ="3"  width="500px" height="40px"  style="text-align: center;border:1px solid black;background-color: #bfbfbf">ระดับความดันโลหิต</th>
                                    <th rowspan ="2"  width="200px" colspan ="1" style="text-align: center;border:1px solid black;background-color: #bfbfbf">คำแนะนำ</th>
                                
                                </tr>
                                <tr>

                                    <th width="50px"  style="text-align: center;border:1px solid black;background-color: #bfbfbf"></th>
                                    <th width="100px"  style="text-align: center;border:1px solid black;background-color: #bfbfbf">ความดันบน</th>
                                    <th width="100px"  style="text-align: center;border:1px solid black;background-color: #bfbfbf">ความดันล่าง</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- &#10004; -->
                                    <td width="100px" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #C81212;">ระดับอันตราย</td>
                                    <td style="border:1px solid black;font-size: 18px;text-align: left">&nbsp;<input disabled ="" type="text" style="font-size:10px;background-color: #C81212;width:25px;height:25px"> 180 ขึ้นไป </td>
                                    <td style="border:1px solid black;font-size: 18px;text-align: center">110 ขึ้นไป</b></td>
                                    <td style="border:1px solid black;font-size: 16px;text-align: center">พบแพทย์โดยด่วน</td>
                                    
                                </tr>
                                <tr>
                                    <!-- &#10004; -->
                                    <td width="100px" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #EC8662;">สูงมาก และ อันตราย</td>
                                    <td style="border:1px solid black;font-size: 18px;text-align: left">&nbsp;<input disabled ="" type="text" style="font-size:10px;background-color: #EC8662;width:25px;height:25px"> 160-180 </td>
                                    <td style="border:1px solid black;font-size: 18px;text-align: center">100-110</b></td>
                                    <td style="border:1px solid black;font-size: 16px;text-align: center">พบแพทย์</td>
                                    
                                </tr>
                                <tr>
                                    <!-- &#10004; -->
                                    <td width="100px" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #EE7D7D;">สูงมาก</td>
                                    <td style="border:1px solid black;font-size: 18px;text-align: left">&nbsp;<input disabled ="" type="text" style="font-size:10px;background-color: #EE7D7D;width:25px;height:25px"> 180 ขึ้นไป </td>
                                    <td style="border:1px solid black;font-size: 18px;text-align: center">90-100</b></td>
                                    <td style="border:1px solid black;font-size: 16px;text-align: center">พบแพทย์</td>
                                    
                                </tr>
                                <tr>
                                    <!-- &#10004; -->
                                    <td width="100px" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #ECE662;">ค่อนข้างสูง</td>
                                    <td style="border:1px solid black;font-size: 18px;text-align: left">&nbsp;<input disabled ="" type="text" style="font-size:10px;background-color: #ECE662;width:25px;height:25px"> 130-140 </td>
                                    <td style="border:1px solid black;font-size: 18px;text-align: center">85-90</b></td>
                                    <td style="border:1px solid black;font-size: 16px;text-align: center">ปรึกษาแพทย์</td>
                                    
                                </tr>
                                <tr>
                                    <!-- &#10004; -->
                                    <td width="100px" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #6AF152;">ปกติ</td>
                                    <td style="border:1px solid black;font-size: 18px;text-align: left">&nbsp;<input disabled ="" type="text" style="font-size:10px;background-color: #6AF152;width:25px;height:25px"> 120-130 </td>
                                    <td style="border:1px solid black;font-size: 18px;text-align: center">80-85</b></td>
                                    <td style="border:1px solid black;font-size: 16px;text-align: center">ตรวจเช็คสม่ำเสมอ</td>
                                    
                                </tr>
                                <tr>
                                    <!-- &#10004; -->
                                    <td width="100px" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #26B60D;">เหมาะสม</td>
                                    <td style="border:1px solid black;font-size: 18px;text-align: left">&nbsp;<input disabled ="" type="text" style="font-size:10px;background-color: #26B60D;width:25px;height:25px"> 120 </td>
                                    <td style="border:1px solid black;font-size: 18px;text-align: center">80</b></td>
                                    <td style="border:1px solid black;font-size: 16px;text-align: center">ตรวจเช็คสม่ำเสมอ</td>
                                    
                                </tr>
                                <!-- <tr>
                                    <td colspan ="6" style="font-size: 16px;">&nbsp;<b></b></td>
                                </tr>   -->
                            </tbody>
                            
                        </table>
                        
                    </div>
                    <!-- ตารางอัตตราการเต้นของหัวใจ -->
                    <div class="col-md-4" style="background-color: #e7e7e7">
                        <table style="border:1px solid black;">
                            <thead style="border:1px solid black;">
                                <tr>
                                    <th colspan ="2"  width="550px" style="text-align: center;border:1px solid black;background-color: #bfbfbf">มาตรฐานค่าความดันร่วมกิจ</th>
                                
                                </tr>
                                <tr>

                                    <th width="50px"  style="text-align: center;border:1px solid black;background-color: #bfbfbf">ความดันบน</th>
                                    <th width="100px"  style="text-align: center;border:1px solid black;background-color: #bfbfbf">ความดันล่าง</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- &#10004; -->
                                    <td width="100px" style="border:1px solid black;font-size: 28px;text-align: center;"><b><?= $result_seAMT['MAXSYS'] ?></b></td>
                                    <td width="100px" style="border:1px solid black;font-size: 28px;text-align: center;"><b><?= $result_seAMT['MAXDIA'] ?></b></td>
                                </tr>
                                <!-- <tr>
                                    <td colspan ="6" style="font-size: 16px;">&nbsp;<b></b></td>
                                </tr>   -->
                            </tbody>
                            
                        </table>
                        <br>
                        <table style="border:1px solid black;">
                            <thead style="border:1px solid black;">
                                <tr>
                                    <th colspan ="2"  width="500px" style="text-align: center;border:1px solid black;background-color: #bfbfbf">อัตราการเต้นของหัวใจ ครั้ง/นาที</th>
                                    <th rowspan ="2"  width="200px" colspan ="1" style="text-align: center;border:1px solid black;background-color: #bfbfbf">คำแนะนำ</th>
                                
                                </tr>
                                <tr>

                                    <th width="50px"  style="text-align: center;border:1px solid black;background-color: #bfbfbf"></th>
                                    <th width="100px"  style="text-align: center;border:1px solid black;background-color: #bfbfbf">ความดันบน</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- &#10004; -->
                                    <td width="100px" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #C81212;">ภาวะหัวใจเต้นเร็วมาก</td>
                                    <td style="border:1px solid black;font-size: 18px;text-align: left">&nbsp;<input disabled ="" type="text" style="font-size:10px;background-color: #C81212;width:25px;height:25px"> 150 ขึ้นไป </td>
                                    <td style="border:1px solid black;font-size: 16px;text-align: center">พบแพทย์โดยด่วน</td>
                                </tr>
                                <tr>
                                    <!-- &#10004; -->
                                    <td width="100px" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #ECE662;">มีภาวะหัวใจเต้นเร็ว</td>
                                    <td style="border:1px solid black;font-size: 18px;text-align: left">&nbsp;<input disabled ="" type="text" style="font-size:10px;background-color: #ECE662;width:25px;height:25px"> 100-150 </td>
                                    <td style="border:1px solid black;font-size: 16px;text-align: center">ปรึกษาแพทย์</td>
                                </tr>
                                <tr>
                                    <!-- &#10004; -->
                                    <td width="100px" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #6AF152;">ปกติ</td>
                                    <td style="border:1px solid black;font-size: 18px;text-align: left">&nbsp;<input disabled ="" type="text" style="font-size:10px;background-color: #6AF152;width:25px;height:25px"> 60-100 </td>
                                    <td style="border:1px solid black;font-size: 16px;text-align: center">ตรวจเช็คสม่ำเสมอ</td>
                                </tr>
                                <!-- <tr>
                                    <td colspan ="6" style="font-size: 16px;">&nbsp;<b></b></td>
                                </tr>   -->
                            </tbody>
                            
                        </table>
                    </div>
                    <!-- คำแนะนำ -->
                    <div class="col-md-3" style="background-color: #e7e7e7">
                        <div class="slideshow-container" style="">
                            <div class="mySlides slide">
                                <div class="numbertext">1 / 3</div>
                                    <img src="../images/Knowleage1.jpg" style="width:370px;height:210px"  >
                                <div class="text"><a href="https://www.bangpakok3.com/care_blog/view/241" target="_blank">More Information</a></div>
                            </div>
                            <div class="mySlides slide">
                                <div class="numbertext">2 / 3</div>
                                    <img src="../images/Knowleage2.jpg" style="width:370px;height:210px"  >
                                <div class="text"><a href="https://allwellhealthcare.com/normal-blood-pressure-range/" target="_blank">More Information</a></div>
                            </div>
                            <div class="mySlides slide">
                                <div class="numbertext">3 / 3</div>
                                    <img src="../images/Knowleage3.jpg" style="width:370px;height:210px"  >
                                <div class="text"><a href="https://pathlab.co.th/risk-of-unbalance-blood-oxygen-level/" target="_blank">More Information</a></div>
                            </div>
                            </div>
                            <br>
                            <div style="text-align:center">
                                <span class="dot"></span> 
                                <span class="dot"></span> 
                                <span class="dot"></span> 
                            </div>
                        </div>
                    </div>

                <div class="row" >
                    <div class="col-lg-12">
                    <div class="well">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-size:20px;color:red"><b>มาตรฐานการตรวจร่างกาย Ruamkit</b></label><br>
                                    <label style="font-size:14px">&nbsp;1.อุณหภูมิ ต่ำกว่า <font color="green"><?= $result_seAMT['TEMP'] ?> °C (องศาเซลเซียส)</font></label><br>
                                    <label style="font-size:14px">&nbsp;2.ค่าความดันบน&nbsp;: <font color="green"><?= $result_seAMT['MINSYS'] ?>-<?= $result_seAMT['MAXSYS'] ?> (มิลลิเมตรปรอท)</font></label><br>
                                    <label style="font-size:14px">&nbsp;3.ค่าความดันล่าง&nbsp;: <font color="green"><?= $result_seAMT['MINDIA'] ?>-<?= $result_seAMT['MAXDIA'] ?> (มิลลิเมตรปรอท)</font></label><br>
                                    <label style="font-size:14px">&nbsp;4.อัตราการเต้นหัวใจ : <font color="green"><?= $result_seAMT['MINPULSE'] ?>-<?= $result_seAMT['MAXPULSE'] ?> ครั้ง</font></label><br>
                                    <label style="font-size:14px">&nbsp;5.ออกซิเจนในเลือดตั้งแต่ : <font color="green"><?= $result_seAMT['OXYGEN'] ?>%</font></label><br>
                                    <label style="font-size:14px">&nbsp;6.แอลกอฮอล์ :<font color="green"> <?= $result_seAMT['ALCOHOL'] ?> mg% (มิลลิกรัมเปอร์เซนต์) เท่านั้น</font> </label><br>
                                </div>
                                
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group" style="text-align: left">
                                    <label style="font-size:20px;color:red"><b>มาตรฐานดัชนีมวลกาย BMI</b></label><br>
                                    <label style="font-size:14px">&nbsp;1.น้ำหนักน้อย / ผอม | BMI 0-18.0 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <!-- <input disabled ="" type="text" style="font-size:10px;background-color: #66FAFF;width:60px;height:25px"> -->
                                    </label><br>
                                    <label style="font-size:14px">&nbsp;2.ปกติ (สุขภาพดี) | BMI 18.1-23.0 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <!-- <input disabled ="" type="text" style="font-size:10px;background-color: #66FF72;width:60px;height:25px"> -->
                                    </label><br>
                                    <label style="font-size:14px">&nbsp;3.ท้วม / โรคอ้วนระดับ 1 | BMI 23.1-25.0 &nbsp;&nbsp;&nbsp;
                                        <!-- <input disabled ="" type="text" style="font-size:10px;background-color: #FFA966;width:60px;height:25px"> -->
                                    </label><br>
                                    <label style="font-size:14px">&nbsp;3.อ้วน / โรคอ้วนระดับ 2 | BMI 25.1-30.0 &nbsp;&nbsp;&nbsp;
                                        <!-- <input disabled ="" type="text" style="font-size:10px;background-color: #FF6666;width:60px;height:25px"> -->
                                    </label><br>
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
            
                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>
                               
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">

                                    <div class="row">
                                        <div class="col-sm-6"><a href='index2.php'>หน้าแรก</a> / รายละเอียดข้อมูลการตรวจร่างกาย</div>
                                        <!-- <div class="col-sm-6 text-right"><a target="_bank" href='meg_vehiclrinfoamata.php?vehicleinfoid=&meg=add'>เพิ่มข้อมูลรถ</a></div> --> 
                                    </div>
                                
                                </div><br>
                                <!-- /.panel-heading -->
                                <!-- <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>พิมพ์ข้อมูลประวัติอุบัติเหตุ </label><br>   
                                            <input type="button"  name="" id=""onclick="print_accidentpdf()" value="พิมพ์ข้อมูลประวัติอุบัติเหตุ (PDF)" class="btn btn-primary">
                                            <input type="button"  name="" id=""onclick="print_accidentexcel()" value="พิมพ์ข้อมูลประวัติอุบัติเหตุ (EXCEL)" class="btn btn-primary">
                                        </div>
                                </div> -->
                                
                                <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 5px;">ลำดับ</th>
                                                                    <th style="width: 40px;">รหัสพนักงาน</th>
                                                                    <th style="width: 70px;">ชื่อ-นามสกุล</th>
                                                                    <!--<th style="width: 40px;">เลขบัตร ปชช</th>
                                                                    <th style="width: 120px;">น้ำหนัก</th>
                                                                    <th style="width: 100px;">ส่วนสูง</th>
                                                                    <th style="width: 250px;">ดัชนีมวลกาย</th> -->
                                                                    <th style="width: 50px;">อุณหภูมิ</th>
                                                                    <th style="width: 50px;">ความดันบน</th>
                                                                    <th style="width: 50px;">ความดันล่าง</th>
                                                                    <th style="width: 50px;">อัตราเต้นหัวใจ</th>
                                                                    <th style="width: 40px;">ออกซิเจนในเลือด</th>
                                                                    <th style="width: 70px;">แอลกอฮอล์</th>
                                                                    <th style="width: 60px;">เวลาในการตรวจ</th>
                                                                    <th style="width: 50px;">จัดการ</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php

                                                            // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
                                                            // $condiReporttransport2 = "";
                                                            // $condiReporttransport3 = "";

                                                            $i = 1;
                                                            $sql_seData = "SELECT b.nameT,b.TaxID,b.PersonCode,a.LABOTRONDATAID,CARDNUMBER,DRIVER_WEIGHT,DRIVER_HEIGHT,DRIVER_BMI,
                                                            DRIVER_TEMPERATURE,DRIVER_SYS,DRIVER_DIA,DRIVER_PULSE,DRIVER_OXYGEN,DRIVER_ALCOHOL,
                                                            CREATEBY,CONVERT(VARCHAR(16),CREATEDATE,103) AS 'CREATEDATE'
                                                                                                                                                                                                                                                
                                                            FROM LABOTRONWEBSERVICEDATA a 
                                                            LEFT JOIN EMPLOYEEEHR2 b ON b.TaxID = a.CREATEBY
                                                            WHERE CONVERT(DATE,CREATEDATE) BETWEEN CONVERT(DATE,DATEADD(DAY,-15,GETDATE())) AND CONVERT(DATE,GETDATE())
                                                            --AND SUBSTRING(b.PersonCode, 1, 2) NOT IN ('01','02','04','07','08','06','05','09')
                                                            AND ( b.PersonCode IS NULL OR SUBSTRING(b.PersonCode, 1, 2) IN ('10') OR b.PersonCode IN ('060281','060065','060237','060190','050141'))
                                                            ORDER BY CONVERT(VARCHAR(16),CREATEDATE,103) DESC";
                                                            $params_seData = array();
                                                            $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
                                                            while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {

                                                             
                                                                global $pageTitleTEMP,$pageTitleSYS,$pageTitleDIA,$pageTitlePULSE,$pageTitleOXYGEN,$pageTitleALCOHOL;
                                                                

                                                                //อุณหภูมิ ไม่เกิน 37.5
                                                                if ($result_seData['DRIVER_TEMPERATURE'] >  $result_seAMT['TEMP']  || $result_seData['DRIVER_TEMPERATURE'] == '' ) {
                                                                    $colortemp = "background-color: #FF6A66";
                                                                    $pageTitleTemp = "อุณหภูมิร่างกายสูงหรือต่ำเกินมาตรฐาน...";
                                                                } else {
                                                                    $colortemp = "";
                                                                    $pageTitleTemp = "";
                                                                }
                                                                
                                                                
                                                                //ค่าความดันบน 60-150
                                                                if ($result_seData['DRIVER_SYS'] < $result_seAMT['MINSYS'] || $result_seData['DRIVER_SYS'] > $result_seAMT['MAXSYS']) {
                                                                    $colorsys = "background-color: #FF6A66";
                                                                    $pageTitleSYS = "ความดันบนสูงหรือต่ำเกินมาตรฐาน...";
                                                                } else {
                                                                    $colorsys = "";
                                                                    $pageTitleSYS = "";
                                                                }

                                                                //ค่าความดันล่าง 60-95
                                                                if ($result_seData['DRIVER_DIA'] < $result_seAMT['MINDIA'] || $result_seData['DRIVER_DIA'] > $result_seAMT['MAXDIA']) {
                                                                    $colordia = "background-color: #FF6A66";
                                                                    $pageTitleDIA = "ความดันล่างสูงหรือต่ำเกินมาตรฐาน...";
                                                                } else {
                                                                    $colordia = "";
                                                                    $pageTitleDIA = "";
                                                                }

                                                                //อัตตราการเต้นหัวใจ
                                                                if ($result_seData['DRIVER_PULSE'] < $result_seAMT['MINPULSE'] || $result_seData['DRIVER_PULSE'] > $result_seAMT['MAXPULSE']) {
                                                                    $colorpulse = "background-color: #FF6A66";
                                                                    $pageTitlePULSE = "อัตราการเต้นของหัวใจสูงหรือต่ำเกินมาตรฐาน...";
                                                                } else {
                                                                    $colorpulse = "";
                                                                    $pageTitlePULSE = "";
                                                                }

                                                                //ค่าออกซิเจนในเลือด
                                                                if ($result_seData['DRIVER_OXYGEN'] < $result_seAMT['OXYGEN']) {
                                                                    $coloroxygen = "background-color: #FF6A66";
                                                                    $pageTitleOXYGEN = "ออกซิเจนใจเลือดต่ำเกินมาตรฐาน...";
                                                                } else {
                                                                    $coloroxygen = "";
                                                                    $pageTitleOXYGEN = "";
                                                                }

                                                                //ค่าแอลกอฮอล์
                                                                if ($result_seData['DRIVER_ALCOHOL'] > $result_seAMT['ALCOHOL'] || $result_seData['DRIVER_ALCOHOL'] == '') {
                                                                    $coloralcohol = "background-color: #FF6A66";
                                                                    $pageTitleALCOHOL = "แอลกอฮอล์ต้องเป็น 0 เท่านั้น...";
                                                                } else {
                                                                    $coloralcohol = "";
                                                                    $pageTitleALCOHOL = "";
                                                                }

                                                                 //ค่า BMI
                                                                 if ($result_seData['DRIVER_BMI'] > '0' && $result_seData['DRIVER_BMI'] < '18') {
                                                                    $colorbmi = "background-color: #66FAFF";
                                                                } else if ($result_seData['DRIVER_BMI'] > '18' && $result_seData['DRIVER_BMI'] < '23') {
                                                                    $colorbmi = "background-color: #66FF72";
                                                                }else if ($result_seData['DRIVER_BMI'] > '23'  && $result_seData['DRIVER_BMI'] < '25') {
                                                                    $colorbmi = "background-color: #FFA966";
                                                                }else if ($result_seData['DRIVER_BMI'] > '25'  && $result_seData['DRIVER_BMI'] < '30') {
                                                                    $colorbmi = "background-color: #FF6A66";
                                                                }else if ($result_seData['DRIVER_BMI']  == ''){
                                                                    $colorbmi = "";    
                                                                }else{
                                                                    $colorbmi = "background-color: #FF6A66";    
                                                                }

                                                                // echo $result_seData['DRIVER_BMI'];
                                                                // echo '<br>';
                                                                ?>

                                                                <tr>
                                                                    <td style="text-align: center"><?= $i ?>  </td>
                                                                    <td><?=$result_seData['PersonCode']?></td>
                                                                    <td><?=($result_seData['nameT']  == '' ? $result_seData['CARDNUMBER'] : $result_seData['nameT'])?>          </td>
                                                                    <!--<td><?=$result_seData['CREATEBY']?>     </td>
                                                                    <td><?=$result_seData['DRIVER_WEIGHT']?>  </td>
                                                                    <td><?=$result_seData['DRIVER_HEIGHT'];?> </td>
                                                                    <td style="<?= $colorbmi ?>"><?=$result_seData['DRIVER_BMI'];?></td> -->
                                                                    <td title="<?=$pageTitleTemp?>"     style="<?= $colortemp ?>"><?=number_format($result_seData['DRIVER_TEMPERATURE'],2);?>    </td>
                                                                    <td title="<?=$pageTitleSYS?>"      style="<?= $colorsys ?>"><?=$result_seData['DRIVER_SYS'];?>    </td>
                                                                    <td title="<?=$pageTitleDIA?>"      style="<?= $colordia ?>"><?=$result_seData['DRIVER_DIA'];?>    </td>
                                                                    <td title="<?=$pageTitlePULSE?>"    style="<?= $colorpulse   ?>"><?=$result_seData['DRIVER_PULSE'];?>  </td>
                                                                    <td title="<?=$pageTitleOXYGEN?>"   style="<?= $coloroxygen  ?>"><?=$result_seData['DRIVER_OXYGEN']?>  </td>
                                                                    <td title="<?=$pageTitleALCOHOL?>"  style="<?= $coloralcohol ?>"><?=$result_seData['DRIVER_ALCOHOL']?> </td>
                                                                    <td><?=$result_seData['CREATEDATE']?> </td>
                                                                    <td style="text-align: center;">
                                                                        <button onclick="delete_labotrondata('<?= $result_seData['LABOTRONDATAID'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="fa fa-times"></span></button>
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

                                
                                <!-- /.panel -->
                            </div>
                        </div>
                    </div>



                </div>
            </div>

            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../js/jquery.datetimepicker.full.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../js/bootstrap-datepicker.min.js"></script>
            <script src="../js/bootstrap-datepicker.th.min.js"></script>
                                                                
            <!-- Zoom Js -->
            <!-- <script src="js/zoom.js"></script> -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
            
    </body>
    <script>

                                        let slideIndex = 0;
                                        showSlides();

                                        function showSlides() {
                                        let i;
                                        let slides = document.getElementsByClassName("mySlides");
                                        let dots = document.getElementsByClassName("dot");
                                        for (i = 0; i < slides.length; i++) {
                                            slides[i].style.display = "none";  
                                        }
                                        slideIndex++;
                                        if (slideIndex > slides.length) {slideIndex = 1}    
                                        for (i = 0; i < dots.length; i++) {
                                            dots[i].className = dots[i].className.replace(" active", "");
                                        }
                                        slides[slideIndex-1].style.display = "block";  
                                        dots[slideIndex-1].className += " active";
                                        setTimeout(showSlides, 4000); // Change image every 2 seconds
                                        }

                                        
                                        function delete_labotrondata(labotrondataid)
                                        {
                                            // alert('delete');
                                            // alert(labotrondataid);

                                            Swal.fire({
                                                title: 'ต้องการลบข้อมูล?',
                                                text: "กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'ตกลง',
                                                cancelButtonText: 'ยกเลิก'
                                            }).then((result) => {
                                                
                                                if (result.isConfirmed) {
                                                    
                                                    $.ajax({
                                                        type: 'post',
                                                        url: 'meg_data2.php',
                                                        data: {
                                                            txt_flg: "delete_labotrondata", labotrondataid: labotrondataid
                                                        },
                                                        success: function (rs) {
                                                            // alert(rs);
                                                            // alert('ลบข้อมูลเรียบร้อย');
                                                            // location.reload();

                                                            swal.fire({
                                                                title: "Good Job!",
                                                                text: "ลบข้อมูลเรียบร้อย",
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
                                        
                                        
                                        $(document).ready(function () {
                                            $('#dataTables-example').DataTable({
                                                order: [[0, "asc"]],
                                                scrollX: true,
                                                scrollY: '520px',
                                            });
                                        });

                                  
                        
    </script>
</html>
<?php
sqlsrv_close($conn);
?>
