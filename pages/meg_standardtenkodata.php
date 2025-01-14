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
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
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
        <!-- <link href="style/style.css" rel="stylesheet" type="text/css"> -->
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
                                $meg = 'มาตรฐานข้อมูลสำหรับการตรวจร่างกาย';




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
                        <div id="datadef">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                 มาตรฐานข้อมูลสำหรับการตรวจร่างกาย
                                                </div>



                                            </div>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body ">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-pills">
                                                <li class="active"><a href="#std_amt" data-toggle="tab" aria-expanded="true">มาตรฐาน (AMT)</a>
                                                </li>
                                                <li class=""><a href="#std_gw" data-toggle="tab">มาตรฐาน (GW)</a>
                                                </li>
                                                <li class=""><a href="#std_general" data-toggle="tab">มาตรฐานทั่วไป</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="row">
                                                    <div class="col-md-12" >&nbsp;</div>
                                                </div>
                                                <div class="row">
                                                    <input  style="display:none" class="form-control" type="" id="txt_username" name="txt_username" value="<?=$_SESSION["USERNAME"]?>">
                                                </div>
                                                <!-- START STANDARD AMT -->
                                                <div class="tab-pane fade active in" id="std_amt">
                                                    <?php
                                                     $sql_seAMT = "SELECT STD_ID AS 'AMT_ID',MAXSYS,MINSYS,MAXDIA,MINDIA,MAXPULSE,MINPULSE,TEMP,OXYGEN,ALCOHOL,REMARK
                                                     FROM STANDARDTENKODATA
                                                     WHERE REMARK ='AMT'";
                                                     $query_seAMT = sqlsrv_query($conn, $sql_seAMT, $params_seAMT);
                                                     $result_seAMT = sqlsrv_fetch_array($query_seAMT, SQLSRV_FETCH_ASSOC);
                                                    ?>
                                                    <br>
                                                        <input style="display:none" type="text" id="txt_amttenkodataid" value="<?=$result_seAMT['AMT_ID']?>"></input>
                                                        <div class="row">
                                                            <div class="col-lg-6" >
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading" style="background-color: #f0c402;">
                                                                        <label><font style="font-size: 16px">ข้อมูลมาตรฐานความดัน และ อัตราการเต้นหัวใจ (AMT)</font></label>
                                                                    </div>
                                                                    
                                                                    <div class="panel-body">
                                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                            <div class = "row">
                                                                                <div class="">
                                                                                        <div class="form-group">
                                                                                            <label >รายละเอียดข้อมูลมาตรฐานความดัน และ อัตราการเต้นหัวใจ</label><br><br>
                                                                                            <div class="scol-lg-4">
                                                                                                <form class="form-inline">
                                                                                                    <label ><u>ค่ามาตรฐานความดันบน</u></label><br>
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าสูงสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_amt(this.value,'maxsys')" placeholder="ค่าสูงสุดมาตรฐานความดันบน..."  title="ค่าสูงสุดมาตรฐานความดันบน..." class="form-control" id="maxsys_amt" name="maxsys_amt" value= "<?= $result_seAMT['MAXSYS'] ?>" autocomplete="off">
                                                                                                    </div>
                                                                                                    &nbsp;&nbsp;
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าต่ำสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_amt(this.value,'minsys')" placeholder="ค่าต่ำสุดมาตรฐานความดันบน..."  title="ค่าต่ำสุดมาตรฐานความดันบน..." class="form-control" id="minsys_amt" name="minsys_amt" value= "<?= $result_seAMT['MINSYS'] ?>" autocomplete="off">
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                            <br>
                                                                                            <div class="scol-lg-4">
                                                                                                <form class="form-inline">
                                                                                                    <label ><u>ค่ามาตรฐานความดันล่าง</u></label><br>
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าสูงสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_amt(this.value,'maxdia')" placeholder="ค่าสูงสุดมาตรฐานความดันล่าง..."  title="ค่าสูงสุดมาตรฐานความดันล่าง..." class="form-control" id="maxdia_amt" name="maxdia_amt" value= "<?= $result_seAMT['MAXDIA'] ?>" autocomplete="off">
                                                                                                    </div>
                                                                                                    &nbsp;&nbsp;
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าต่ำสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_amt(this.value,'mindia')" placeholder="ค่าต่ำสุดมาตรฐานความดันล่าง..."  title="ค่าต่ำสุดมาตรฐานความดันล่าง..." class="form-control" id="mindia_amt" name="mindia_amt" value= "<?= $result_seAMT['MINDIA'] ?>" autocomplete="off">
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                            <br>
                                                                                            <div class="scol-lg-4">
                                                                                                <form class="form-inline">
                                                                                                    <label ><u>ค่ามาตรฐานอัตราการเต้นหัวใจ</u></label><br>
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าสูงสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_amt(this.value,'maxpulse')" placeholder="ค่าสูงสุดมาตรฐานอัตราการเต้นหัวใจ..."  title="ค่าสูงสุดมาตรฐานอัตราการเต้นหัวใจ" class="form-control" id="maxpulse_amt" name="maxpulse_amt" value= "<?= $result_seAMT['MAXPULSE'] ?>" autocomplete="off">
                                                                                                    </div>
                                                                                                    &nbsp;&nbsp;
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าต่ำสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_amt(this.value,'minpulse')" placeholder="ค่าต่ำสุดมาตรฐานอัตราการเต้นหัวใจ..."  title="ค่าต่ำสุดมาตรฐานอัตราการเต้นหัวใจ" class="form-control" id="minpulse_amt" name="minpulse_amt" value= "<?= $result_seAMT['MINPULSE'] ?>" autocomplete="off">
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                            <br><br>
                                                                                        </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    
                                                            </div>
                                                        
                                                        </div>
                                                        <!-- END COLUNM1    -->
                                                        <!-- START COLUNM2 -->
                                                        <div class="col-lg-6" >
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading" style="background-color: #f0c402;">
                                                                    <label><font style="font-size: 16px">ข้อมูลมาตรฐานอื่นๆ</font></label>
                                                                </div>
                                                                
                                                                <div class="panel-body">
                                                                    <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                        <div class = "row">
                                                                            <div class="">
                                                                                    <div class="form-group">
                                                                                        <label >รายละเอียดข้อมูลมาตรฐานอื่นๆ</label><br><br>
                                                                                        <div class="col-lg-12">
                                                                                                <label ><u>มาตรฐาน อุณหภูมิ (°C)</u></label><br>
                                                                                                <input class="form-control " onkeyup="checknumber_amt(this.value,'temp')" placeholder="ค่ามาตรฐาน อุณหภูมิ (°C)..." style="height:40px; width:460px" id="temp_amt" name="temp_amt" value="<?= $result_seAMT['TEMP'] ?>"  min="" max=""  autocomplete="off">
                                                                                        </div>
                                                                                        <br><br><br><br>
                                                                                        <div class="col-lg-12">
                                                                                                <label ><u>มาตรฐาน ออกซิเจนในเลือดตั้งแต่</u></label><br>
                                                                                                <input class="form-control" onkeyup="checknumber_amt(this.value,'oxygen')" placeholder="ค่ามาตรฐาน ออกซิเจนในเลือด..." style="height:40px; width:460px" id="oxygen_amt" name="oxygen_amt" value="<?= $result_seAMT['OXYGEN'] ?>"  min="" max=""  autocomplete="off">
                                                                                        </div>
                                                                                        <br><br><br><br>
                                                                                        <div class="col-lg-12">
                                                                                                <label ><u>มาตรฐาน แอลกอฮอล์</u></label><br>
                                                                                                <input class="form-control" onkeyup="checknumber_amt(this.value,'alcohol')" placeholder="ค่ามาตรฐาน แอลกอฮอล์..." style="height:40px; width:460px" id="alcohol_amt" name="alcohol_amt" value="<?= $result_seAMT['ALCOHOL'] ?>"  min="" max=""  autocomplete="off">
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
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        
                                                        </div>
                                                        <!-- END COLUNM2 --> 
                                                        
                                                        <div  class="col-lg-12" style="text-align: center;">
                                                            <button type="button" class="button" name="myBtn" id ="myBtn"   onclick="save_stdamt();">บันทึกข้อมูลมาตรฐาน (AMT)</button>
                                                        </div>
                                                       
                                                                                                         
                                                            <!-- /.panel-body -->
                                                    </div>
                                                </div>
                                                <!-- END TAP STANDARD AMT-->

                                                <!-- START STANDARD GW -->
                                                <div class="tab-pane" id="std_gw">
                                                    <?php
                                                     $sql_seGW = "SELECT STD_ID AS 'GW_ID',MAXSYS,MINSYS,MAXDIA,MINDIA,MAXPULSE,MINPULSE,TEMP,OXYGEN,ALCOHOL,REMARK
                                                     FROM STANDARDTENKODATA
                                                     WHERE REMARK ='GW'";
                                                     $query_seGW = sqlsrv_query($conn, $sql_seGW, $params_seGW);
                                                     $result_seGW = sqlsrv_fetch_array($query_seGW, SQLSRV_FETCH_ASSOC);
                                                    ?>
                                                      <br>
                                                      <input style="display:none" type="text" id="txt_gwtenkodataid" value="<?=$result_seGW['GW_ID']?>"></input>
                                                      <div class="row">
                                                            <!-- START ROW1 -->
                                                            <div class="col-lg-6" >
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading" style="background-color: #f0c402;">
                                                                        <label><font style="font-size: 16px">ข้อมูลมาตรฐานความดัน และ อัตราการเต้นหัวใจ (GW)</font></label>
                                                                    </div>
                                                                    
                                                                    <div class="panel-body">
                                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                            <div class = "row">
                                                                                <div class="">
                                                                                          <div class="form-group">
                                                                                            <label >รายละเอียดข้อมูลมาตรฐานความดัน และ อัตราการเต้นหัวใจ</label><br><br>
                                                                                            <div class="scol-lg-4">
                                                                                                <form class="form-inline">
                                                                                                    <label ><u>ค่ามาตรฐานความดันบน</u></label><br>
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าสูงสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_gw(this.value,'maxsys')" placeholder="ค่าสูงสุดมาตรฐานความดันบน ..."  title="วันที่และเวลาที่เกิดอุบัติเหตุ" class="form-control" id="maxsys_gw" name="maxsys_gw" value= "<?=$result_seGW['MAXSYS']?>" autocomplete="off">
                                                                                                    </div>
                                                                                                    &nbsp;&nbsp;
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าต่ำสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_gw(this.value,'minsys')" placeholder="ค่าต่ำสุดมาตรฐานความดันบน..."  title="วันที่และเวลาที่เกิดอุบัติเหตุ" class="form-control" id="minsys_gw" name="minsys_gw" value= "<?=$result_seGW['MINSYS']?>" autocomplete="off">
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                            <br>
                                                                                            <div class="scol-lg-4">
                                                                                                <form class="form-inline">
                                                                                                    <label ><u>ค่ามาตรฐานความดันล่าง</u></label><br>
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าสูงสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_gw(this.value,'maxdia')" placeholder="ค่าสูงสุดมาตรฐานความดันล่าง..."  title="ค่าสูงสุดมาตรฐานความดันล่าง" class="form-control" id="maxdia_gw" name="maxdia_gw" value= "<?=$result_seGW['MAXDIA']?>" autocomplete="off">
                                                                                                    </div>
                                                                                                    &nbsp;&nbsp;
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าต่ำสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_gw(this.value,'mindia')" placeholder="ค่าต่ำสุดมาตรฐานความดันล่าง..."  title="ค่าต่ำสุดมาตรฐานความดันล่าง" class="form-control" id="mindia_gw" name="mindia_gw" value= "<?=$result_seGW['MINDIA']?>" autocomplete="off">
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                            <br>
                                                                                            <div class="scol-lg-4">
                                                                                                <form class="form-inline">
                                                                                                    <label ><u>ค่ามาตรฐานอัตราการเต้นหัวใจ</u></label><br>
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าสูงสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_gw(this.value,'maxpulse')" placeholder="ค่าสูงสุดมาตรฐานอัตราการเต้นหัวใจ..."  title="ค่าสูงสุดมาตรฐานอัตราการเต้นหัวใจ" class="form-control" id="maxpulse_gw" name="maxpulse_gw" value= "<?=$result_seGW['MAXPULSE']?>" autocomplete="off">
                                                                                                    </div>
                                                                                                    &nbsp;&nbsp;
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าต่ำสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_gw(this.value,'minpulse')" placeholder="ค่าต่ำสุดมาตรฐานอัตราการเต้นหัวใจ..."  title="ค่าต่ำสุดมาตรฐานอัตราการเต้นหัวใจ" class="form-control" id="minpulse_gw" name="minpulse_gw" value= "<?=$result_seGW['MINPULSE']?>" autocomplete="off">
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                            <br><br>
                                                                                        </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    
                                                            </div>
                                                        
                                                        </div>
                                                        <!-- END COLUNM1    -->
                                                        <!-- START COLUNM2 -->
                                                        <div class="col-lg-6" >
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading" style="background-color: #f0c402;">
                                                                    <label><font style="font-size: 16px">ข้อมูลมาตรฐานอื่นๆ</font></label>
                                                                </div>
                                                                
                                                                <div class="panel-body">
                                                                    <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                        <div class = "row">
                                                                            <div class="">
                                                                                    <div class="form-group">
                                                                                        <label >รายละเอียดข้อมูลมาตรฐานอื่นๆ</label><br><br>
                                                                                        <div class="col-lg-12">
                                                                                                <label ><u>มาตรฐาน อุณหภูมิ (°C)</u></label><br>
                                                                                                <input class="form-control " onkeyup="checknumber_gw(this.value,'temp')" placeholder="ค่ามาตรฐาน อุณหภูมิ (°C)..." style="height:40px; width:460px" id="temp_gw" name="temp_gw" value="<?=$result_seGW['TEMP']?>"  min="" max=""  autocomplete="off">
                                                                                        </div>
                                                                                        <br><br><br><br>
                                                                                        <div class="col-lg-12">
                                                                                                <label ><u>มาตรฐาน ออกซิเจนในเลือดตั้งแต</u></label><br>
                                                                                                <input class="form-control" onkeyup="checknumber_gw(this.value,'oxygen')" placeholder="ค่ามาตรฐาน ออกซิเจนในเลือด..." style="height:40px; width:460px" id="oxygen_gw" name="oxygen_gw" value="<?=$result_seGW['OXYGEN']?>"  min="" max=""  autocomplete="off">
                                                                                        </div>
                                                                                        <br><br><br><br>
                                                                                        <div class="col-lg-12">
                                                                                                <label ><u>มาตรฐาน แอลกอฮอล์</u></label><br>
                                                                                                <input class="form-control" onkeyup="checknumber_gw(this.value,'alcohol')" placeholder="ค่ามาตรฐาน แอลกอฮอล์..." style="height:40px; width:460px" id="alcohol_gw" name="alcohol_gw" value="<?=$result_seGW['ALCOHOL']?>"  min="" max=""  autocomplete="off">
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
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        
                                                        </div>
                                                        <!-- END COLUNM2 -->  
                                                        
                                                        <div  class="col-lg-12" style="text-align: center;">
                                                            <button type="button" class="button" name="myBtn" id ="myBtn"   onclick="save_stdgw();">บันทึกข้อมูลมาตรฐาน (GW)</button>
                                                        </div>
                                                                                                       
                                                            <!-- /.panel-body -->
                                                    </div>
                                                </div>
                                                <!-- END TAP STANDARD GW-->
                                                
                                                <!-- START STANDARD GENERAL -->
                                                <div class="tab-pane" id="std_general">
                                                        <?php
                                                        $sql_seGENERAL = "SELECT STD_ID AS 'GE_ID',MAXSYS,MINSYS,MAXDIA,MINDIA,MAXPULSE,MINPULSE,TEMP,OXYGEN,ALCOHOL,REMARK
                                                        FROM STANDARDTENKODATA
                                                        WHERE REMARK ='GENERAL'";
                                                        $query_seGENERAL = sqlsrv_query($conn, $sql_seGENERAL, $params_seGENERAL);
                                                        $result_seGENERAL = sqlsrv_fetch_array($query_seGENERAL, SQLSRV_FETCH_ASSOC);
                                                        ?>
                                                        <br>
                                                        <input style="display:none" type="text" id="txt_generaltenkodataid" value="<?=$result_seGENERAL['GE_ID']?>"></input>
                                                        <div class="row">
                                                            <!-- START ROW1 -->
                                                            <div class="col-lg-6" >
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading" style="background-color: #f0c402;">
                                                                        <label><font style="font-size: 16px">ข้อมูลมาตรฐานความดัน และ อัตราการเต้นหัวใจ (GENERAL)</font></label>
                                                                    </div>
                                                                    
                                                                    <div class="panel-body">
                                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                            <div class = "row">
                                                                                <div class="">
                                                                                        <div class="form-group">
                                                                                            <label >รายละเอียดข้อมูลมาตรฐานความดัน และ อัตราการเต้นหัวใจ</label><br><br>
                                                                                            <div class="scol-lg-4">
                                                                                                <form class="form-inline">
                                                                                                    <label ><u>ค่ามาตรฐานความดันบน</u></label><br>
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าสูงสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_general(this.value,'maxsys')" placeholder="ค่าสูงสุดมาตรฐานความดันบน ..."  title="วันที่และเวลาที่เกิดอุบัติเหตุ" class="form-control" id="maxsys_general" name="maxsys_general" value= "<?=$result_seGENERAL['MAXSYS']?>" autocomplete="off">
                                                                                                    </div>
                                                                                                    &nbsp;&nbsp;
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าต่ำสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_general(this.value,'minsys')" placeholder="ค่าต่ำสุดมาตรฐานความดันบน..."  title="วันที่และเวลาที่เกิดอุบัติเหตุ" class="form-control" id="minsys_general" name="minsys_general" value= "<?=$result_seGENERAL['MINSYS']?>" autocomplete="off">
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                            <br>
                                                                                            <div class="scol-lg-4">
                                                                                                <form class="form-inline">
                                                                                                    <label ><u>ค่ามาตรฐานความดันล่าง</u></label><br>
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าสูงสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_general(this.value,'maxdia')" placeholder="ค่าสูงสุดมาตรฐานความดันล่าง..."  title="ค่าสูงสุดมาตรฐานความดันล่าง" class="form-control" id="maxdia_general" name="maxdia_general" value= "<?=$result_seGENERAL['MAXDIA']?>" autocomplete="off">
                                                                                                    </div>
                                                                                                    &nbsp;&nbsp;
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าต่ำสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_general(this.value,'mindia')" placeholder="ค่าต่ำสุดมาตรฐานความดันล่าง..."  title="ค่าต่ำสุดมาตรฐานความดันล่าง" class="form-control" id="mindia_general" name="mindia_general" value= "<?=$result_seGENERAL['MINDIA']?>" autocomplete="off">
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                            <br>
                                                                                            <div class="scol-lg-4">
                                                                                                <form class="form-inline">
                                                                                                    <label ><u>ค่ามาตรฐานอัตราการเต้นหัวใจ</u></label><br>
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าสูงสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_general(this.value,'maxpulse')" placeholder="ค่าสูงสุดมาตรฐานอัตราการเต้นหัวใจ..."  title="ค่าสูงสุดมาตรฐานอัตราการเต้นหัวใจ" class="form-control" id="maxpulse_general" name="maxpulse_general" value= "<?=$result_seGENERAL['MAXPULSE']?>" autocomplete="off">
                                                                                                    </div>
                                                                                                    &nbsp;&nbsp;
                                                                                                    <div class="form-group">
                                                                                                        <label >(ค่าต่ำสุด)</label><br>
                                                                                                        <input type="text" style="height:40px; width:300px" onkeyup="checknumber_general(this.value,'minpulse')" placeholder="ค่าต่ำสุดมาตรฐานอัตราการเต้นหัวใจ..."  title="ค่าต่ำสุดมาตรฐานอัตราการเต้นหัวใจ" class="form-control" id="minpulse_general" name="minpulse_general" value= "<?=$result_seGENERAL['MINPULSE']?>" autocomplete="off">
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                            <br><br>
                                                                                        </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    
                                                            </div>
                                                        
                                                        </div>
                                                        <!-- END COLUNM1    -->
                                                        <!-- START COLUNM2 -->
                                                        <div class="col-lg-6" >
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading" style="background-color: #f0c402;">
                                                                    <label><font style="font-size: 16px">ข้อมูลมาตรฐานอื่นๆ</font></label>
                                                                </div>
                                                                
                                                                <div class="panel-body">
                                                                    <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                        <div class = "row">
                                                                            <div class="">
                                                                                    <div class="form-group">
                                                                                        <label >รายละเอียดข้อมูลมาตรฐานอื่นๆ</label><br><br>
                                                                                        <div class="col-lg-12">
                                                                                                <label ><u>มาตรฐาน อุณหภูมิ (°C)</u></label><br>
                                                                                                <input class="form-control " onkeyup="checknumber_general(this.value,'temp')" placeholder="ค่ามาตรฐาน อุณหภูมิ (°C)..." style="height:40px; width:460px" id="temp_general" name="temp_general" value="<?=$result_seGENERAL['TEMP']?>"  min="" max=""  autocomplete="off">
                                                                                        </div>
                                                                                        <br><br><br><br>
                                                                                        <div class="col-lg-12">
                                                                                                <label ><u>มาตรฐาน ออกซิเจนในเลือดตั้งแต่</u></label><br>
                                                                                                <input class="form-control" onkeyup="checknumber_general(this.value,'oxygen')" placeholder="ค่ามาตรฐาน ออกซิเจนในเลือด..." style="height:40px; width:460px" id="oxygen_general" name="oxygen_general" value="<?=$result_seGENERAL['OXYGEN']?>"  min="" max=""  autocomplete="off">
                                                                                        </div>
                                                                                        <br><br><br><br>
                                                                                        <div class="col-lg-12">
                                                                                                <label ><u>มาตรฐาน แอลกอฮอล์</u></label><br>
                                                                                                <input class="form-control" onkeyup="checknumber_general(this.value,'alcohol')" placeholder="ค่ามาตรฐาน แอลกอฮอล์..." style="height:40px; width:460px" id="alcohol_general" name="alcohol_general" value="<?=$result_seGENERAL['ALCOHOL']?>"  min="" max=""  autocomplete="off">
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
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        
                                                        </div>
                                                        <!-- END COLUNM2 -->  
                                                        
                                                        <div  class="col-lg-12" style="text-align: center;">
                                                            <button type="button" class="button" name="myBtn" id ="myBtn"   onclick="save_stdgeneral();">บันทึกข้อมูลมาตรฐาน (GENERAL)</button>
                                                        </div>
                                                                                                      
                                                            <!-- /.panel-body -->
                                                    </div>
                                                </div>
                                                <!-- END TAP STANDARD GENERAL-->

                                                

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




            <script src="../vendor/jquery/jquery.min.js"></script>
            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
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
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

    </body>
    
                                                                                                    


            <script type="text/javascript"> 
                                                                                                 
            
            function checknumber_amt(value,check)
            {
                // alert(value);
                // alert(check);

                var elem = value;
                if(!elem.match(/^([0-9.])+$/i))
                {
                    // alert("กรอกได้เฉพาะตัวเลขและตัวอักษรภาษาอังกฤษเท่านั้น");
                    swal.fire({
                        title: "Warning !",
                        text: "กรอกได้เฉพาะตัวเลขเท่านั้น !!!",
                        showConfirmButton: true,
                        icon: "warning"
                    });

                    if (check == 'maxsys') {
                        document.getElementById('maxsys_amt').value = "";
                    }else if(check == 'minsys'){
                        document.getElementById('minsys_amt').value = "";
                    }else if(check == 'maxdia'){
                        document.getElementById('maxdia_amt').value = "";
                    }else if(check == 'mindia'){
                        document.getElementById('mindia_amt').value = "";
                    }else if(check == 'maxpulse'){
                        document.getElementById('maxpulse_amt').value = "";
                    }else if(check == 'minpulse'){
                        document.getElementById('minpulse_amt').value = "";
                    }else if(check == 'temp'){
                        document.getElementById('temp_amt').value = "";
                    }else if(check == 'oxygen'){
                        document.getElementById('oxygen_amt').value = "";
                    }else if(check == 'alcohol'){
                        document.getElementById('alcohol_amt').value = "";
                    }else{

                    }
                    
                }
            }
            function checknumber_gw(value,check)
            {
                // alert(value);
                // alert(check);

                var elem = value;
                if(!elem.match(/^([0-9.])+$/i))
                {
                    // alert("กรอกได้เฉพาะตัวเลขและตัวอักษรภาษาอังกฤษเท่านั้น");
                    swal.fire({
                        title: "Warning !",
                        text: "กรอกได้เฉพาะตัวเลขเท่านั้น !!!",
                        showConfirmButton: true,
                        icon: "warning"
                    });

                    if (check == 'maxsys') {
                        document.getElementById('maxsys_gw').value = "";
                    }else if(check == 'minsys'){
                        document.getElementById('minsys_gw').value = "";
                    }else if(check == 'maxdia'){
                        document.getElementById('maxdia_gw').value = "";
                    }else if(check == 'mindia'){
                        document.getElementById('mindia_gw').value = "";
                    }else if(check == 'maxpulse'){
                        document.getElementById('maxpulse_gw').value = "";
                    }else if(check == 'minpulse'){
                        document.getElementById('minpulse_gw').value = "";
                    }else if(check == 'temp'){
                        document.getElementById('temp_gw').value = "";
                    }else if(check == 'oxygen'){
                        document.getElementById('oxygen_gw').value = "";
                    }else if(check == 'alcohol'){
                        document.getElementById('alcohol_gw').value = "";
                    }else{

                    }
                    
                }
            }
            function checknumber_general(value,check)
            {
                // alert(value);
                // alert(check);

                var elem = value;
                if(!elem.match(/^([0-9.])+$/i))
                {
                    // alert("กรอกได้เฉพาะตัวเลขและตัวอักษรภาษาอังกฤษเท่านั้น");
                    swal.fire({
                        title: "Warning !",
                        text: "กรอกได้เฉพาะตัวเลขเท่านั้น !!!",
                        showConfirmButton: true,
                        icon: "warning"
                    });

                    if (check == 'maxsys') {
                        document.getElementById('maxsys_general').value = "";
                    }else if(check == 'minsys'){
                        document.getElementById('minsys_general').value = "";
                    }else if(check == 'maxdia'){
                        document.getElementById('maxdia_general').value = "";
                    }else if(check == 'mindia'){
                        document.getElementById('mindia_general').value = "";
                    }else if(check == 'maxpulse'){
                        document.getElementById('maxpulse_general').value = "";
                    }else if(check == 'minpulse'){
                        document.getElementById('minpulse_general').value = "";
                    }else if(check == 'temp'){
                        document.getElementById('temp_general').value = "";
                    }else if(check == 'oxygen'){
                        document.getElementById('oxygen_general').value = "";
                    }else if(check == 'alcohol'){
                        document.getElementById('alcohol_general').value = "";
                    }else{

                    }
                    
                }
            }
            // function check()
            // {
            //     var elem = document.getElementById('test_txt').value;
            //     if(!elem.match(/^([a-z0-9])+$/i))
            //     {
            //         alert("กรอกได้เฉพาะตัวเลขและตัวอักษรภาษาอังกฤษเท่านั้น");
            //         document.getElementById('test_txt').value = "";
            //     }
            // }
            
            function save_stdamt() //save สำหรับ change สีการนอน
            {

                // alert(chkstatus);
                // alert(checkClient);
                var amt_id      = document.getElementById('txt_amttenkodataid').value;
                var maxsys_amt  = document.getElementById('maxsys_amt').value;
                var minsys_amt  = document.getElementById('minsys_amt').value;
                var maxdia_amt  = document.getElementById('maxdia_amt').value;
                var mindia_amt  = document.getElementById('mindia_amt').value;
                var maxpulse_amt   = document.getElementById('maxpulse_amt').value;
                var minpulse_amt   = document.getElementById('minpulse_amt').value;
                var temp_amt       = document.getElementById('temp_amt').value;
                var oxygen_amt     = document.getElementById('oxygen_amt').value;
                var alcohol_amt    = document.getElementById('alcohol_amt').value;
                var remark   = 'AMT';
                var createby = document.getElementById('txt_username').value;
                // alert(amt_id);
                // alert(timejobstart);
                // alert(sessionid);
                // เช็คการลงข้อมูลคอลัมย์ที่1

                if (amt_id == '') {
                    // ถ้า ID == '' จะบันทึกข้อมูล
                    if(maxsys_amt == ''     || minsys_amt == ''    || maxdia_amt == '' || mindia_amt == ''
                    || maxpulse_amt == ''   || minpulse_amt == ''  || temp_amt == ''   || oxygen_amt == '' 
                    || alcohol_amt == ''){
                    
                        swal.fire({
                            title: "warning",
                            text: "กรุณาลงข้อมูลให้ครบถ้วนก่อนบันทึก !!!",
                            icon: "warning",
                        });

                    }else{
                        // alert('save_amt');
                        $.ajax({
                            type: 'post',
                            url: 'meg_data2.php',
                            data: {

                            txt_flg: "save_stdtenkodata",
                            ID:'', 
                            MAXSYS: maxsys_amt,
                            MINSYS: minsys_amt, 
                            MAXDIA: maxdia_amt,
                            MINDIA: mindia_amt,
                            MAXPULSE: maxpulse_amt,
                            MINPULSE: minpulse_amt,
                            TEMP: temp_amt,
                            OXYGEN: oxygen_amt,
                            ALCOHOL: alcohol_amt,
                            REMARK: remark,
                            CREATEBY: createby
                            },
                                success: function (rs) {
                                
                                // alert(rs);
                                swal.fire({
                                    title: "Good Job!",
                                    text: "บันทึกข้อมูลเรียบร้อย !!!",
                                    showConfirmButton: false,
                                    timer: 1400,
                                    icon: "success"
                                });
                                // // alert(rs);   
                                // setTimeout(() => {
                                //     document.location.reload();
                                // }, 1200);

                                // alert("บันทึกข้อมูลเรียบร้อย");
                                // // // alert(rs);    
                                // window.location.reload();
                            }
                        });
                    }
                }else{
                    // else ถ้ามี ID จะ อัพเดท
                    // alert('update_amt');
                    if(maxsys_amt == ''     || minsys_amt == ''    || maxdia_amt == '' || mindia_amt == ''
                    || maxpulse_amt == ''   || minpulse_amt == ''  || temp_amt == ''   || oxygen_amt == '' 
                    || alcohol_amt == ''){
                    
                        swal.fire({
                            title: "warning",
                            text: "กรุณาลงข้อมูลให้ครบถ้วนก่อนอัพเดทข้อมูล !!!",
                            icon: "warning",
                        });

                    }else{
                        $.ajax({
                            type: 'post',
                            url: 'meg_data2.php',
                            data: {

                            txt_flg: "update_stdtenkodata",
                            ID:amt_id, 
                            MAXSYS: maxsys_amt,
                            MINSYS: minsys_amt, 
                            MAXDIA: maxdia_amt,
                            MINDIA: mindia_amt,
                            MAXPULSE: maxpulse_amt,
                            MINPULSE: minpulse_amt,
                            TEMP: temp_amt,
                            OXYGEN: oxygen_amt,
                            ALCOHOL: alcohol_amt,
                            REMARK: remark,
                            CREATEBY: createby
                            },
                                success: function (rs) {
                                
                                // alert(rs);
                                swal.fire({
                                    title: "Good Job!",
                                    text: "อัพเดทข้อมูลเรียบร้อย !!!",
                                    showConfirmButton: false,
                                    timer: 1400,
                                    icon: "success"
                                });
                                // // alert(rs);   
                                // setTimeout(() => {
                                //     document.location.reload();
                                // }, 1200);

                                // alert("บันทึกข้อมูลเรียบร้อย");
                                // // // alert(rs);    
                                // window.location.reload();
                            }
                        });
                    }
                    
                }
                    
            }         

            function save_stdgw() //save สำหรับ change สีการนอน
            {
               
                // alert(chkstatus);
                // alert(checkClient);
                var gw_id      = document.getElementById('txt_gwtenkodataid').value;
                var maxsys_gw  = document.getElementById('maxsys_gw').value;
                var minsys_gw  = document.getElementById('minsys_gw').value;
                var maxdia_gw  = document.getElementById('maxdia_gw').value;
                var mindia_gw  = document.getElementById('mindia_gw').value;
                var maxpulse_gw   = document.getElementById('maxpulse_gw').value;
                var minpulse_gw    = document.getElementById('minpulse_gw').value;
                var temp_gw       = document.getElementById('temp_gw').value;
                var oxygen_gw     = document.getElementById('oxygen_gw').value;
                var alcohol_gw    = document.getElementById('alcohol_gw').value;
                var remark   = 'GW';
                var createby = document.getElementById('txt_username').value;
                // alert(gw_id);
                // alert(datejobstart);
                // alert(timejobstart);
                // alert(sessionid);
                // เช็คการลงข้อมูลคอลัมย์ที่1
                if (gw_id == '') {
                    // ถ้า ID ='' จะบันทึกข้อมูล
                    if(maxsys_gw == ''     || minsys_gw == ''    || maxdia_gw == '' || mindia_gw == ''
                    || maxpulse_gw == ''   || minpulse_gw == ''  || temp_gw == ''   || oxygen_gw == '' 
                    || alcohol_gw == ''){
                    
                        swal.fire({
                            title: "warning",
                            text: "กรุณาลงข้อมูลให้ครบถ้วนก่อนบันทึก !!!",
                            icon: "warning",
                        });

                    

                    }else{
                         // alert("save_gw");
                        $.ajax({
                            type: 'post',
                            url: 'meg_data2.php',
                            data: {
                            txt_flg: "save_stdtenkodata",
                            ID:'', 
                            MAXSYS: maxsys_gw,
                            MINSYS: minsys_gw, 
                            MAXDIA: maxdia_gw,
                            MINDIA: mindia_gw,
                            MAXPULSE: maxpulse_gw,
                            MINPULSE: minpulse_gw,
                            TEMP: temp_gw,
                            OXYGEN: oxygen_gw,
                            ALCOHOL: alcohol_gw,
                            REMARK: remark,
                            CREATEBY: createby
                            },
                                success: function (rs) {
                                
                                // alert(rs);
                                swal.fire({
                                    title: "Good Job!",
                                    text: "บันทึกข้อมูลเรียบร้อย !!!",
                                    showConfirmButton: false,
                                    timer: 1400,
                                    icon: "success"
                                });
                                // // alert(rs);   
                                // setTimeout(() => {
                                    // document.location.reload();
                                // }, 1200);

                                // alert("บันทึกข้อมูลเรียบร้อย");
                                // // // alert(rs);    
                                // window.location.reload();
                            }
                        });
                    }

                }else{
                    // ถ้า ID !='' จะอัพเดทข้อมูล
                        // alert('update gw');
                    if(maxsys_gw == ''     || minsys_gw == ''    || maxdia_gw == '' || mindia_gw == ''
                    || maxpulse_gw == ''   || minpulse_gw == ''  || temp_gw == ''   || oxygen_gw == '' 
                    || alcohol_gw == ''){
                    
                        swal.fire({
                            title: "warning",
                            text: "กรุณาลงข้อมูลให้ครบถ้วนก่อนอัพเดทข้อมล !!!",
                            icon: "warning",
                        });

                    

                    }else{

                        $.ajax({
                            type: 'post',
                            url: 'meg_data2.php',
                            data: {
                            txt_flg: "update_stdtenkodata",
                            ID: gw_id, 
                            MAXSYS: maxsys_gw,
                            MINSYS: minsys_gw, 
                            MAXDIA: maxdia_gw,
                            MINDIA: mindia_gw,
                            MAXPULSE: maxpulse_gw,
                            MINPULSE: minpulse_gw,
                            TEMP: temp_gw,
                            OXYGEN: oxygen_gw,
                            ALCOHOL: alcohol_gw,
                            REMARK: remark,
                            CREATEBY: createby
                            },
                                success: function (rs) {
                                
                                // alert(rs);
                                swal.fire({
                                    title: "Good Job!",
                                    text: "อัพเดทข้อมูลเรียบร้อย !!!",
                                    showConfirmButton: false,
                                    timer: 1400,
                                    icon: "success"
                                });
                                // // alert(rs);   
                                // setTimeout(() => {
                                //     document.location.reload();
                                // }, 1200);

                                // alert("บันทึกข้อมูลเรียบร้อย");
                                // // // alert(rs);    
                                // window.location.reload();
                            }
                        });

                    }
                        
                    
                }
                    
            }    
            function save_stdgeneral() //save สำหรับ change สีการนอน
            {
                
                // alert(chkstatus);
                // alert(checkClient);
                var ge_id      = document.getElementById('txt_generaltenkodataid').value;
                var maxsys_ge  = document.getElementById('maxsys_general').value;
                var minsys_ge  = document.getElementById('minsys_general').value;
                var maxdia_ge  = document.getElementById('maxdia_general').value;
                var mindia_ge  = document.getElementById('mindia_general').value;
                var maxpulse_ge   = document.getElementById('maxpulse_general').value;
                var minpulse_ge    = document.getElementById('minpulse_general').value;
                var temp_ge       = document.getElementById('temp_general').value;
                var oxygen_ge     = document.getElementById('oxygen_general').value;
                var alcohol_ge    = document.getElementById('alcohol_general').value;
                var remark   = 'GENERAL';
                var createby = document.getElementById('txt_username').value;
                
                // alert(ge_id);
                // alert(datejobstart);
                // alert(timejobstart);
                // alert(sessionid);
                // เช็คการลงข้อมูลคอลัมย์ที่1

                if (ge_id == '') {
                    // ถ้า ID ='' จะบันทึกข้อมูล
                    if(maxsys_ge == ''     || minsys_ge == ''    || maxdia_ge == '' || mindia_ge == ''
                    || maxpulse_ge == ''   || minpulse_ge == ''  || temp_ge == ''   || oxygen_ge == '' 
                    || alcohol_ge == ''){
                    
                        swal.fire({
                            title: "warning",
                            text: "กรุณาลงข้อมูลให้ครบถ้วนก่อนบันทึก !!!",
                            icon: "warning",
                        });

                    

                    }else{
                        // alert("save_general");
                        $.ajax({
                            type: 'post',
                            url: 'meg_data2.php',
                            data: {
                            txt_flg: "save_stdtenkodata",
                            ID:'', 
                            MAXSYS: maxsys_ge,
                            MINSYS: minsys_ge, 
                            MAXDIA: maxdia_ge,
                            MINDIA: mindia_ge,
                            MAXPULSE: maxpulse_ge,
                            MINPULSE: minpulse_ge,
                            TEMP: temp_ge,
                            OXYGEN: oxygen_ge,
                            ALCOHOL: alcohol_ge,
                            REMARK: remark,
                            CREATEBY: createby
                            },
                                success: function (rs) {
                                
                                // alert(rs);
                                swal.fire({
                                    title: "Good Job!",
                                    text: "บันทึกข้อมูลเรียบร้อย !!!",
                                    showConfirmButton: false,
                                    timer: 1400,
                                    icon: "success"
                                });
                                // // alert(rs);   
                                // setTimeout(() => {
                                //     document.location.reload();
                                // }, 1200);

                                // alert("บันทึกข้อมูลเรียบร้อย");
                                // // // alert(rs);    
                                // window.location.reload();
                            }
                        });
                    }
                }else{
                    // ถ้า ID !='' จะอัพเดทข้อมูล
                    // alert("update_general");
                    if(maxsys_ge == ''     || minsys_ge == ''    || maxdia_ge == '' || mindia_ge == ''
                    || maxpulse_ge == ''   || minpulse_ge == ''  || temp_ge == ''   || oxygen_ge == '' 
                    || alcohol_ge == ''){
                    
                        swal.fire({
                            title: "warning",
                            text: "กรุณาลงข้อมูลให้ครบถ้วนก่อนอัพเดทข้อมูล !!!",
                            icon: "warning",
                        });

                    

                    }else{
                        
                        $.ajax({
                            type: 'post',
                            url: 'meg_data2.php',
                            data: {
                            txt_flg: "update_stdtenkodata",
                            ID: ge_id, 
                            MAXSYS: maxsys_ge,
                            MINSYS: minsys_ge, 
                            MAXDIA: maxdia_ge,
                            MINDIA: mindia_ge,
                            MAXPULSE: maxpulse_ge,
                            MINPULSE: minpulse_ge,
                            TEMP: temp_ge,
                            OXYGEN: oxygen_ge,
                            ALCOHOL: alcohol_ge,
                            REMARK: remark,
                            CREATEBY: createby
                            },
                                success: function (rs) {
                                
                                // alert(rs);
                                swal.fire({
                                    title: "Good Job!",
                                    text: "อัพเดทข้อมูลเรียบร้อย !!!",
                                    showConfirmButton: false,
                                    timer: 1400,
                                    icon: "success"
                                });
                                // alert(rs);   
                                // setTimeout(() => {
                                //     document.location.reload();
                                // }, 1200);

                                // alert("บันทึกข้อมูลเรียบร้อย");
                                // // // alert(rs);    
                                // window.location.reload();
                            }
                        });
                    }
                    
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
            <script>
                // $(document).ready(function () {
                //     $('#dataTables-example1').DataTable({
                //         responsive: true
                //     });
                //     $('#dataTables-example2').DataTable({
                //         responsive: true
                //     });
                //     $('#dataTables-example').DataTable({
                //         responsive: true
                //     });
                // });
            </script>

    

</html>
<?php
sqlsrv_close($conn);
?>
