<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


$sql_empcode = "SELECT TOP 1 PersonCode AS 'EMPCODE' FROM EMPLOYEEEHR2
WHERE (FnameT+' '+LnameT) = RTRIM('" . $_GET['employeename'] . "') AND EndDate IS NULL";
$params_empcode = array();
$query_empcode = sqlsrv_query($conn, $sql_empcode, $params_empcode);
$result_empcode = sqlsrv_fetch_array($query_empcode, SQLSRV_FETCH_ASSOC);


$sql_sedata = "SELECT  TOP 1 ID,DIABETES,HIGHTBLOODPRESSURE,LOWBLOODPRESSURE,
    HEARTDISEASE, EPILEPPSY, BRAINSURGERY, SHORTSIGHT,SHORTSIGHT_R,SHORTSIGHT_L,LONGSIGHT,LONGSIGHT_R,LONGSIGHT_L,
    OBLIQUESIGHT,OBLIQUESIGHT_R,OBLIQUESIGHT_L,COLORBLIND_OK,COLORBLIND_NG,OTHERDISEASE1,OTHERDISEASE2,OTHERDISEASE3,
    OTHERDISEASE4,OTHERDISEASE5,OTHERDISEASE6,CREATEDATE
    FROM [dbo].[HEALTHHISTORY]
    WHERE EMPLOYEECODE ='" . $result_empcode['EMPCODE'] . "'
    AND CREATEYEAR ='" . $_GET['createyear'] . "'
    AND ACTIVESTATUS ='1'
    ORDER BY CREATEDATE DESC";
$params_sedata = array();
$query_sedata = sqlsrv_query($conn, $sql_sedata, $params_sedata);
$result_sedata = sqlsrv_fetch_array($query_sedata, SQLSRV_FETCH_ASSOC);

// echo $result_sedata['ID'];

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
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.min.js"></script>
        <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../dist/js/jquery.autocomplete.js"></script> 
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
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

            /* Create a custom checkbox */
            .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #8e8e8e;
            }

            /* On mouse-over, add a grey background color */
            .container:hover input ~ .checkmark {
            background-color: #ccc;
            }

            /* When the checkbox is checked, add a blue background */
            .container input:checked ~ .checkmark {
            background-color: #05ad16;
            }

            /* Create the checkmark/indicator (hidden when not checked) */
            .checkmark:after {
            content: "";
            position: absolute;
            display: none;
            }

            /* Show the checkmark when checked */
            .container input:checked ~ .checkmark:after {
            display: block;
            }

            /* Style the checkmark/indicator */
            .container .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
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
    </head>
    <body>

        <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
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
        </nav>


            <div id="page-wrapper">
                <p>&nbsp;</p>

                <div id="datade_edit">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8" >
                                            <h4>หมายเลขรหัส: <?=$result_sedata['ID']?></h4>
                                            <h4>รายละเอียดข้อมูลสุขภาพปี: <?=$_GET['createyear']+543?></h4> 
                                            <h4>ชื่อพนักงาน: <?=$_GET['employeename']?></h4>
                                        </div>
                                    </div>
                                </div>
                                <input  class="form-control" type="hidden" id="txt_id" name="txt_id" value="<?=$result_sedata['ID']?>">
                                <input  class="form-control" type="hidden" id="txt_username" name="txt_username" value="<?=$_SESSION["USERNAME"]?>">
                                <input  class="form-control" type="hidden" id="txt_empname" name="txt_empname" value="<?=$_GET["employeename"]?>">
                                <div id="datadef_edit">
                                    <div class="panel-body">
                                        <!-- START ROW1 -->
                                        <div class="row" >
                                            <div class="col-lg-4" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f8f8f8;">
                                                        <label><font style="font-size: 16px">5 โรคเสี่ยง</font></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class = "row">
                                                                <div class="col-lg-12">
                                                                <?php
                                                                if ($result_sedata['DIABETES'] == '1') {
                                                                 ?>
                                                                    <label class="container">เบาหวาน
                                                                        <input type="checkbox" id="diabetes" name ="diabetes" value ="" checked>
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                 <?php
                                                                }else{
                                                                 ?>
                                                                     <label class="container">เบาหวาน
                                                                        <input type="checkbox" id="diabetes" name ="diabetes" value ="">
                                                                        <span class="checkmark"></span>
                                                                    </label>   
                                                                 <?php
                                                                }
                                                                ?>
                                                                    
                                                                </div>  
                                                            </div>
                                                            <div class = "row">
                                                                <div class="col-lg-12">
                                                                <?php
                                                                if ($result_sedata['HIGHTBLOODPRESSURE'] == '1') {
                                                                ?>
                                                                   <label class="container">ความดันโลหิตสูง
                                                                        <input type="checkbox" id="hbp" name="hbp" value ="" checked>
                                                                        <span class="checkmark"></span>
                                                                    </label>     
                                                                <?php
                                                                }else{
                                                                ?>
                                                                    <label class="container">ความดันโลหิตสูง
                                                                        <input type="checkbox" id="hbp" name="hbp" value ="">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                <?php
                                                                }
                                                                ?>
                                                                    
                                                                </div>  
                                                            </div>
                                                            <div class = "row">
                                                                <div class="col-lg-12">
                                                                <?php
                                                                if ($result_sedata['LOWBLOODPRESSURE'] == '1') {
                                                                ?>
                                                                   <label class="container">ความดันโลหิตต่ำ
                                                                        <input type="checkbox" id="lbp" name="lbp" value ="" checked>
                                                                        <span class="checkmark"></span>
                                                                    </label>     
                                                                <?php
                                                                }else{
                                                                ?>
                                                                    <label class="container">ความดันโลหิตต่ำ
                                                                        <input type="checkbox" id="lbp" name="lbp" value ="">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                <?php
                                                                }
                                                                ?>
                                                                    
                                                                </div>  
                                                            </div>
                                                            <div class = "row">
                                                                <div class="col-lg-12">
                                                                    <?php
                                                                    if ($result_sedata['HEARTDISEASE'] == '1') {
                                                                    ?>
                                                                        <label class="container">โรคหัวใจ
                                                                            <input type="checkbox" id="heartdisease" name="heartdisease" value ="" checked>
                                                                            <span class="checkmark"></span>
                                                                        </label>    
                                                                    <?php
                                                                    }else{
                                                                    ?>
                                                                        <label class="container">โรคหัวใจ
                                                                            <input type="checkbox" id="heartdisease" name="heartdisease" value ="">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>  
                                                            </div>
                                                            <div class = "row">
                                                                <div class="col-lg-12">
                                                                <?php
                                                                if ($result_sedata['EPILEPPSY'] == '1') {
                                                                ?>
                                                                    <label class="container">ลมชัก/ลมบ้าหมู
                                                                        <input type="checkbox" id="epilepsy" name="epilepsy" value ="" checked>
                                                                        <span class="checkmark"></span>
                                                                    </label>         
                                                                <?php
                                                                }else{
                                                                ?>
                                                                    <label class="container">ลมชัก/ลมบ้าหมู
                                                                        <input type="checkbox" id="epilepsy" name="epilepsy" value ="">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                <?php
                                                                }
                                                                ?>
                                                                    
                                                                </div>  
                                                            </div>
                                                            <div class = "row">
                                                                <div class="col-lg-12">
                                                                <?php
                                                                if ($result_sedata['BRAINSURGERY'] == '1') {
                                                                ?>
                                                                    <label class="container">ผ่าตัดสมอง
                                                                        <input type="checkbox" id="brainsurgery" name="brainsurgery" value ="" checked>
                                                                        <span class="checkmark"></span>
                                                                    </label>        
                                                                <?php
                                                                }else{
                                                                ?>
                                                                    <label class="container">ผ่าตัดสมอง
                                                                        <input type="checkbox" id="brainsurgery" name="brainsurgery" value ="">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                <?php
                                                                }
                                                                ?>
                                                                    
                                                                </div>  
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
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <!-- END COLUNM1 -->
                                    
                                            <!-- START COLUNM2 -->
                                            <div class="col-lg-4" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f8f8f8;">
                                                        <label><font style="font-size: 16px">สายตา</font></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class = "row">
                                                                <div class="col-lg-5">
                                                                <?php
                                                                if ($result_sedata['SHORTSIGHT'] == '1') {
                                                                ?>
                                                                    <label class="container">สายตาสั้น 
                                                                        <input type="checkbox" id="short_sight" name="short_sight" value= "" checked>
                                                                        <span class="checkmark"></span>
                                                                    </label>      
                                                                <?php
                                                                }else{
                                                                ?>
                                                                    <label class="container">สายตาสั้น 
                                                                        <input type="checkbox" id="short_sight" name="short_sight" value= "">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                <?php
                                                                }
                                                                ?>
                                                                    
                                                                </div>  
                                                            </div>
                                                            <div class = "row">
                                                                <div class="scol-lg-4">
                                                                    <form class="form-inline">
                                                                        <div class="form-group">
                                                                            <label >(R)</label>
                                                                            <input type="text" class="form-control" id="short_sightr" name="short_sightr" value= "<?=$result_sedata['SHORTSIGHT_R']?>" autocomplete="off">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label >(L)</label>
                                                                            <input type="text" class="form-control" id="short_sightl" name="short_sightl" value= "<?=$result_sedata['SHORTSIGHT_L']?>" autocomplete="off">
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <div class="col-lg-5">
                                                                <?php
                                                                if ($result_sedata['LONGSIGHT'] == '1') {
                                                                ?>
                                                                    <label class="container">สายตายาว
                                                                        <input type="checkbox" id="long_sight" name="long_sight" value= "" checked>
                                                                        <span class="checkmark"></span>
                                                                    </label>       
                                                                <?php
                                                                }else{
                                                                ?>
                                                                    <label class="container">สายตายาว
                                                                        <input type="checkbox" id="long_sight" name="long_sight" value= "">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                <?php
                                                                }
                                                                ?>
                                                                    
                                                                </div>  
                                                            </div>
                                                            <div class = "row">
                                                                <div class="scol-lg-4">
                                                                    <form class="form-inline">
                                                                        <div class="form-group">
                                                                            <label >(R)</label>
                                                                            <input type="text" class="form-control" id="long_sightr" name="long_sightr" value= "<?=$result_sedata['LONGSIGHT_R']?>" autocomplete="off">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label >(L)</label>
                                                                            <input type="text" class="form-control" id="long_sightl" name="long_sightl" value= "<?=$result_sedata['LONGSIGHT_L']?>" autocomplete="off">
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <div class="col-lg-6">
                                                                <?php
                                                                if ($result_sedata['OBLIQUESIGHT'] == '1') {
                                                                ?>
                                                                    <label class="container">สายตาเอียง
                                                                        <input type="checkbox" id="oblique_sight" name="oblique_sight" value= "" checked>
                                                                        <span class="checkmark"></span>
                                                                    </label>      
                                                                <?php
                                                                }else{
                                                                ?>
                                                                    <label class="container">สายตาเอียง
                                                                        <input type="checkbox" id="oblique_sight" name="oblique_sight" value= "">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                <?php
                                                                }
                                                                ?>
                                                                    
                                                                </div>  
                                                            </div>
                                                            <div class = "row">
                                                                <div class="scol-lg-6">
                                                                    <form class="form-inline">
                                                                        <div class="form-group">
                                                                            <label >(R)</label>
                                                                            <input type="text" class="form-control" id="oblique_sightr" name="oblique_sightr" value= "<?=$result_sedata['OBLIQUESIGHT_R']?>" autocomplete="off">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label >(L)</label>
                                                                            <input type="text" class="form-control" id="oblique_sightl" name="oblique_sightl" value= "<?=$result_sedata['OBLIQUESIGHT_L']?>" autocomplete="off">
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <div class="col-lg-6">
                                                                    <label class="form-group" style="text-align: left"><font style="font-size: 22px">ตาบอดสี</font>
                                                                        <!-- <input type="checkbox" disabled id="color_blind" name="color_blind" value= ""> -->
                                                                        <!-- <span class="checkmark"></span> -->
                                                                    </label>
                                                                </div>  
                                                            </div>
                                                            <div class = "row">
                                                                <div class="col-lg-5">
                                                                <?php
                                                                if ($result_sedata['COLORBLIND_OK'] == '1') {
                                                                ?>
                                                                    <label class="container">ปกติ
                                                                            <input type="checkbox" id="color_blindok" name="color_blindok" value= "" checked>
                                                                            <span class="checkmark"></span>
                                                                    </label>      
                                                                <?php
                                                                }else{
                                                                ?>
                                                                    <label class="container">ปกติ
                                                                            <input type="checkbox" id="color_blindok" name="color_blindok" value= "">
                                                                            <span class="checkmark"></span>
                                                                    </label>
                                                                <?php
                                                                }
                                                                ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-5">
                                                                <?php
                                                                if ($result_sedata['COLORBLIND_NG'] == '1') {
                                                                ?>
                                                                    <label class="container">ผิดปกติ
                                                                            <input type="checkbox" id="color_blindng" name="color_blindng" value= "" checked>
                                                                            <span class="checkmark"></span>
                                                                    </label>      
                                                                <?php
                                                                }else{
                                                                ?>
                                                                    <label class="container">ผิดปกติ
                                                                            <input type="checkbox" id="color_blindng" name="color_blindng" value= "">
                                                                            <span class="checkmark"></span>
                                                                    </label>
                                                                <?php
                                                                }
                                                                ?>
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            
                                            </div>
                                         <!-- END COLUNM3 -->   

                                            <!-- START COLUNM3 -->
                                                <div class="col-lg-4" >
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" style="background-color: #f8f8f8;">
                                                            <label><font style="font-size: 16px">โรคอื่นๆ</font></label>
                                                        </div>
                                                    <!-- /.panel-heading -->
                                                        <div class="panel-body">
                                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                <div class = "row">
                                                                    <div class="scol-lg-4">
                                                                        <form class="form-inline">
                                                                            <div class="form-group">
                                                                                <label >(1)</label>
                                                                                <input type="text" class="form-control" id="other_disease1" name = "other_disease1" value="<?=$result_sedata['OTHERDISEASE1']?>" size="55" autocomplete="off">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="scol-lg-4">
                                                                        <form class="form-inline">
                                                                            <div class="form-group">
                                                                                <label >(2)</label>
                                                                                <input type="text" class="form-control" id="other_disease2" name = "other_disease2" value="<?=$result_sedata['OTHERDISEASE2']?>" size="55" autocomplete="off">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="scol-lg-4">
                                                                        <form class="form-inline">
                                                                            <div class="form-group">
                                                                                <label >(3)</label>
                                                                                <input type="text" class="form-control" id="other_disease3" name = "other_disease3" value="<?=$result_sedata['OTHERDISEASE3']?>" size="55" autocomplete="off">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="scol-lg-4">
                                                                        <form class="form-inline">
                                                                            <div class="form-group">
                                                                                <label >(4)</label>
                                                                                <input type="text" class="form-control" id="other_disease4" name = "other_disease4" value="<?=$result_sedata['OTHERDISEASE4']?>" size="55" autocomplete="off">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="scol-lg-4">
                                                                        <form class="form-inline">
                                                                            <div class="form-group">
                                                                                <label >(5)</label>
                                                                                <input type="text" class="form-control" id="other_disease5" name = "other_disease5" value="<?=$result_sedata['OTHERDISEASE5']?>" size="55" autocomplete="off">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="scol-lg-4">
                                                                        <form class="form-inline">
                                                                            <div class="form-group">
                                                                                <label >(6)</label>
                                                                                <input type="text" class="form-control" id="other_disease6" name = "other_disease6" value="<?=$result_sedata['OTHERDISEASE6']?>" size="55" autocomplete="off">
                                                                            </div>
                                                                        </form>
                                                                    </div>
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
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div> 
                                            <!-- /.panel default-->
                                        </div>
                                        <!-- END COLUNM3 -->
                                         

                                        

                                        <div class="row">
                                            <div class="col-lg-2">
                                                <input type="button"  data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการแก้ไขข้อมูล!!!" onclick ="confirm_edit();" name="btnSend" id="btnSend" value="แก้ไขข้อมูลสุขภาพ" class="btn btn-primary">
                                            </div>
                                            <div class="col-lg-2">
                                                <input type="button"   data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!" onclick ="confirm_delete();" name="btnSend" id="btnSend" value="ลบข้อมูลสุขภาพ" class="btn btn-danger">
                                            </div>
                                            
                                        </div>

                                        <!-- /.row (nested) -->
                                    </div>

                                </div>
                                <div id="datasr_edit"></div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>




                </div>
                <div id="datasr_edit">

                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        &nbsp;

                    </div>
                </div>
                  
                



            </div>

        </div>

        

        

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
        <script type="text/javascript">

                                                                
            // function confirm_delete(){
            //     $(document).on('click', ':not(form)[data-confirm]', function(e){
            //     if(confirm($(this).data('confirm'))){
            //     e.stopImmediatePropagation();
            //     e.preventDefault();
                
            //      delete_health();   
            //     }else{

            //         window.location.reload();      
            //     }

                   
            // }); 

            // }                                                        
              
            function confirm_delete(){
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
                        // Swal.fire(
                        // 'Update!',
                        // 'Your data has been update.',
                        // 'success'
                        // )
                        delete_health();     
                    }else{
                        window.location.reload();
                    }
                })

            

            } 

            function delete_health(){
           
            var id = document.getElementById('txt_id').value;
            var employeename = document.getElementById('txt_empname').value;
            var username = document.getElementById('txt_username').value;
            
            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    
                    txt_flg: "delete_healthhistory", 
                    id:id,
                    employeename:employeename,
                    diabetes: '', 
                    hightbloodpressure:'',
                    lowbloodpressure: '', 
                    heartdisease:'', 
                    epilepsy: '',
                    brainsurgery: '',
                    shortsight: '',
                    short_sightr:'',
                    short_sightl: '',
                    longsight: '',
                    long_sightr: '',
                    long_sightl: '',
                    obliquesight: '',
                    oblique_sightr: '', 
                    oblique_sightl: '', 
                    color_blindok: '',
                    color_blindng: '',
                    other_disease1: '',
                    other_disease2: '',
                    other_disease3: '',
                    other_disease4: '',
                    other_disease5: '',
                    other_disease6: '',
                    createby:username
                },
                success: function (rs) {
                    
                    // alert("ลบข้อมูลเรียบร้อย!!!");
                    swal.fire({
                        title: "Success!",
                        text: "ลบข้อมูลเรียบร้อย!!!",
                        icon: "success",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                    });
                    setTimeout(function(){
                        self.close();
                    },1500);
                    // window.close();
                    // window.location.reload();
                }
            });   
            }

            function confirm_edit(){
                Swal.fire({
                    title: 'ต้องการแก้ไขข้อมูล?',
                    text: "กรุณากด 'ตกลง' เพื่อยืนยันการแก้ไขข้อมูล!!!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ตกลง',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Swal.fire(
                        // 'Update!',
                        // 'Your data has been update.',
                        // 'success'
                        // )
                        edit_health();     
                    }else{
                        window.location.reload();
                    }
                })

            } 

            function edit_health()
            {
                    // alert("กรุณากด'ตกลง'เพื่อแก้ไขข้อมูลสุขภาพ");
                    var id = document.getElementById('txt_id').value;
                    var username = document.getElementById('txt_username').value;
                    var employeename = document.getElementById('txt_empname').value;
                    var diabeteschk = "";
                    var hbpchk = "";
                    var lbpchk = "";
                    var heartdiseasechk = "";
                    var epilepsychk = "";
                    var brainsurgerychk = "";
                    var short_sightchk = "";
                    var long_sightchk = "";
                    var oblique_sightchk = "";
                    // var color_blindchk = "";
                    var color_blindokchk = "";
                    var color_blindngchk = "";
                    
                   
                    //เบาหวาน
                    if($("#diabetes").is(':checked')){

                        diabeteschk = '1';
                        //alert('1');
                    } else {
                        diabeteschk = '0';
                        //alert('0');
                    }

                    //ความดันโลหิตสูง
                    if($("#hbp").is(':checked')){

                        hbpchk = '1';
                        //alert('1');
                    } else {
                        hbpchk = '0';
                        //alert('0');
                    }
                    
                    //ความดันโลหิตต่ำ
                    if($("#lbp").is(':checked')){

                        lbpchk = '1';
                        //alert('1');
                    } else {
                        lbpchk = '0';
                        //alert('0');
                    }

                    //โรคหัวใจ
                    if($("#heartdisease").is(':checked')){

                        heartdiseasechk = '1';
                        //alert('1');
                    } else {
                        heartdiseasechk = '0';
                        //alert('0');
                    }

                    //ลมชัก/ลมบ้าหมู
                    if($("#epilepsy").is(':checked')){

                        epilepsychk = '1';
                        //alert('1');
                    } else {
                        epilepsychk = '0';
                        // alert('0');
                    }

                    //ผ่าตัดสมอง
                    if($("#brainsurgery").is(':checked')){

                        brainsurgerychk = '1';
                        // alert('1');
                    } else {
                        brainsurgerychk = '0';
                        // alert('0');
                    }

                    //สายตาสั้น
                    if($("#short_sight").is(':checked')){
                        
                        short_sightchk = '1';
                        var short_sightr = document.getElementById('short_sightr').value;
                        var short_sightl = document.getElementById('short_sightl').value;
                        //alert(short_sightr);
                        //alert(short_sightl);
                        //alert('1');
                    } else {
                        short_sightchk = '0';
                        //alert('0');
                    }

                    //สายตายาว
                    if($("#long_sight").is(':checked')){

                        long_sightchk = '1';
                        var long_sightr = document.getElementById('long_sightr').value;
                        var long_sightl = document.getElementById('long_sightl').value;
                       // alert(long_sightr);
                        //alert(long_sightl);
                        //alert('1');
                    } else {
                        long_sightchk = '0';
                        //alert('0');
                    }

                    //สายตาเอียง
                    if($("#oblique_sight").is(':checked')){

                        oblique_sightchk = '1';
                        var oblique_sightr = document.getElementById('oblique_sightr').value;
                        var oblique_sightl = document.getElementById('oblique_sightl').value;
                       // alert(oblique_sightr);
                       // alert(oblique_sightl);
                       // alert('1');
                    } else {
                        oblique_sightchk = '0';
                        //alert('0');
                    }

                    // //ตาบอดสี
                    // if($("#color_blind").is(':checked')){

                    //     color_blindchk = '1';
                    //     //alert('1');
                    // } else {
                    //     color_blindchk = '0';
                    //     //alert('0');
                    // }

                    //ตาบอดสีปกติ
                    if($("#color_blindok").is(':checked')){

                        color_blindokchk = '1';
                        //alert('1');
                    } else {
                        color_blindokchk = '0';
                        //alert('0');
                    }

                    //ตาบอดสีไม่ปกติ
                    if($("#color_blindng").is(':checked')){

                        color_blindngchk = '1';
                        //alert('1');
                    } else {
                        color_blindngchk = '0';
                        //alert('0');
                    }
                    
                    //โรคอื่นๆ
                    var other_disease1 = document.getElementById('other_disease1').value;
                    var other_disease2 = document.getElementById('other_disease2').value;
                    var other_disease3 = document.getElementById('other_disease3').value;
                    var other_disease4 = document.getElementById('other_disease4').value;
                    var other_disease5 = document.getElementById('other_disease5').value;
                    var other_disease6 = document.getElementById('other_disease6').value;

                    // alert(other_disease1);
                    // alert(other_disease2);
                    // alert(other_disease3);
                    // alert(other_disease4);
                    // alert(other_disease5);
                    // alert(other_disease6);


                    
                    
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            
                            txt_flg: "edit_healthhistory", 
                            id:id,
                            employeename:employeename,
                            diabetes: diabeteschk, 
                            hightbloodpressure:hbpchk,
                            lowbloodpressure: lbpchk, 
                            heartdisease:heartdiseasechk , 
                            epilepsy: epilepsychk,
                            brainsurgery: brainsurgerychk,
                            shortsight: short_sightchk,
                            short_sightr: short_sightr,
                            short_sightl: short_sightl,
                            longsight: long_sightchk,
                            long_sightr: long_sightr,
                            long_sightl: long_sightl,
                            obliquesight: oblique_sightchk,
                            oblique_sightr: oblique_sightr, 
                            oblique_sightl: oblique_sightl, 
                            color_blindok: color_blindokchk,
                            color_blindng: color_blindngchk,
                            other_disease1: other_disease1,
                            other_disease2: other_disease2,
                            other_disease3: other_disease3,
                            other_disease4: other_disease4,
                            other_disease5: other_disease5,
                            other_disease6: other_disease6,
                            createby:username
                        },
                        success: function (rs) {
                            
                            // alert("แก้ไขข้อมูลเรียบร้อย!!!");
                            swal.fire({
                                title: "Success!",
                                text: "แก้ไขข้อมูลเรียบร้อย!!!",
                                icon: "success",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            setTimeout(function(){
                                window.location.reload();
                            },1500);
                            
                        }
                        // window.location.reload();
                    });
                   
                
            }

        </script>






    </body>

</html>
<?php
sqlsrv_close($conn);
?>