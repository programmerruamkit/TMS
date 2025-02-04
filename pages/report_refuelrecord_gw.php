
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
$result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);
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
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
    <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
    <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover({
                html: true,
                content: function () {
                    return $('#popover-content').html();
                }
            });
        })
    </script>
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
    </style>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <?php
            include '../pages/meg_header.php';
            include '../pages/meg_leftmenu.php';
            ?>
        </nav>
        <div id="page-wrapper" >
            <div class="row" >
                <div class="col-lg-12">
                    <h2 class="page-header"><i class="fa fa-file-text-o"></i>
                        รายงานรายละเอียดการเติมน้ำมัน (GW)
                    </h2>
                </div>
            </div>
            <div class="row" >
                <div class="col-lg-12">
                    <div class="panel-body">
                        <div class="tab-content"></div> 
                    </div>
                    <div class="row" >
                        <div class="col-lg-12">
                            <div class="well">
                                <div class="row">
                                    <form action="report_refuelrecord_gw_export.php" method="post" target="_blank">
                                        <u><h3>ข้อมูลประจำวัน</h3></u>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่เริ่มต้น</label>
                                                <input class="form-control dateen1" style="background-color: #f080802e"  id="txt_datestartoil" name="txt_datestartoil" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodateoil();" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                            </div>
                                        </div> 
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่สิ้นสุด</label>
                                                <input class="form-control dateen1" style="background-color: #f080802e"  id="txt_dateendoil" name="txt_dateendoil" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่สิ้นสุด" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>บริษัท</label>
                                            <select id="selcompany" name="selcompany" class="form-control" onchange ="selcompanyDiv(this)" required>
                                                <option value disabled selected>-เลือกบริษัท-</option>
                                                <!-- <option value="ALL">เลือกทั้งหมด</option> -->
                                                <option value="RRC">RRC | บริษัท ร่วมกิจ รีไซเคิล แคริเออร์</option>
                                                <option value="RATC">RATC | บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</option>
                                                <option value="RCC">RCC | บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                                <!-- <option value="CENTER">รถส่วนกลาง</option> -->
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>ลูกค้า</label>         
                                            <div id="first" style="display:block">
                                                <select name="selcustomer" id="selcustomer" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value disabled selected>-เลือกลูกค้า-</option>
                                                </select>
                                            </div>
                                            <div id="show_all" style="display:none">
                                                <select name="selcustomer" id="selcustomer" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value="ALL">เลือกทั้งหมด</option>
                                                </select>
                                            </div>
                                            <div id="show_rrc" style="display:none">
                                                <select name="selcustomer" id="selcustomer" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value disabled selected>-เลือกลูกค้า-</option>
                                                    <option value="GMT">GMT</option>
                                                    <option value="TTAST">TTAST</option>
                                                </select>
                                            </div>
                                            <div id="show_ratc" style="display:none">
                                                <select name="selcustomer" id="selcustomer" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value disabled selected>-เลือกลูกค้า-</option>
                                                    <option value="TTT8">TTT (8L)</option>
                                                </select>
                                            </div>
                                            <div id="show_rcc" style="display:none">
                                                <select name="selcustomer" id="selcustomer" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value disabled selected>-เลือกลูกค้า-</option>
                                                    <option value="TTT4">TTT (4L)</option>
                                                    <option value="TTT8">TTT (8L)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-2" > -->
                                            <label>&nbsp;</label><br>
                                            <button type="submit" class="btn btn-success btn-md" name="EXCEL" value="EXCEL"><b>Excel</b> <li class="fa fa-file-excel-o" ></button>
                                            <!-- <a href="report_refuelrecord_export.php" title="Excel" class="btn btn-success" target="_blank"><b>Excel</b> <li class="fa fa-file-excel-o" ></li></a> -->
                                            <!-- &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-danger btn-md" name="PDF" value="PDF"><b>PDF</b> <li class="fa fa-file-pdf-o" ></button> -->
                                            <!-- <a href="report_refuelrecord_pdf.php" title="PDF" class="btn btn-danger" target="_blank"><b>PDF</b> <li class="fa fa-file-pdf-o" ></li></a> -->
                                        <!-- </div> -->
                                    </form>
                                    <form action="report_refuelrecord_gw_export_month.php" method="post" target="_blank">
                                        <hr>
                                        <u><h3>ข้อมูลประจำเดือน</h3></u>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่เริ่มต้น <!-- <font color="red"><small>*07:00</small></font> --> </label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_datestartoilmonth" name="txt_datestartoilmonth" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodateoilmonth();" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่สิ้นสุด <!-- <font color="red"><small>*07:00</small></font> --> </label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_dateendoilmonth" name="txt_dateendoilmonth" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่สิ้นสุด" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>บริษัท</label>
                                            <select id="selcompany2" name="selcompany2" class="form-control" onchange ="selcompanyDiv2(this)" required>
                                                <option value disabled selected>-เลือกบริษัท-</option>
                                                <option value="RRC">RRC | บริษัท ร่วมกิจ รีไซเคิล แคริเออร์</option>
                                                <option value="RATC">RATC | บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</option>
                                                <option value="RCC">RCC | บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                            </select>
                                        </div> 
                                        <div class="col-lg-2">
                                            <label>ลูกค้า</label>         
                                            <div id="first2" style="display:block">
                                                <select name="selcustomer2" id="selcustomer2" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value disabled selected>-เลือกลูกค้า-</option>
                                                </select>
                                            </div>
                                            <div id="show_all2" style="display:none">
                                                <select name="selcustomer2" id="selcustomer2" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value="ALL">เลือกทั้งหมด</option>
                                                </select>
                                            </div>
                                            <div id="show_rrc2" style="display:none">
                                                <select name="selcustomer2" id="selcustomer2" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value disabled selected>-เลือกลูกค้า-</option>
                                                    <option value="GMT">GMT</option>
                                                    <option value="TTAST">TTAST</option>
                                                </select>
                                            </div>
                                            <div id="show_ratc2" style="display:none">
                                                <select name="selcustomer2" id="selcustomer2" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value disabled selected>-เลือกลูกค้า-</option>
                                                    <option value="TTT8">TTT (8L)</option>
                                                </select>
                                            </div>
                                            <div id="show_rcc2" style="display:none">
                                                <select name="selcustomer2" id="selcustomer2" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value disabled selected>-เลือกลูกค้า-</option>
                                                    <option value="TTT4">TTT (4L)</option>
                                                    <option value="TTT8">TTT (8L)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">    
                                            <label>&nbsp;</label><br>                                               
                                            <button type="submit" class="btn btn-success btn-md" name="EXCELMONTH" value="EXCELMONTH"><b>Excel</b> <li class="fa fa-file-excel-o" ></button>
                                            <!-- &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-danger btn-md" name="PDFMONTH" value="PDFMONTH"><b>PDF</b> <li class="fa fa-file-pdf-o" ></button> -->
                                        </div>
                                    </form>
                                    <form action="report_refuelrecord_gw_export_vhct.php" method="post" target="_blank">
                                        <hr>
                                        <u><h3>แยกประเภทรถ</h3></u>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>วันที่เริ่มต้นแผนวิ่งงาน</label>
                                                <input class="form-control dateen1" style="background-color: #f080802e"  id="txt_datestartoilvhct" name="txt_datestartoilvhct" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodateoilvhct();" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>วันที่สิ้นสุดแผนวิ่งงาน</label>
                                                <input class="form-control dateen1" style="background-color: #f080802e"  id="txt_dateendoilvhct" name="txt_dateendoilvhct" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่สิ้นสุด" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group">    
                                            <label>&nbsp;</label><br>                                               
                                            <button type="submit" class="btn btn-success btn-md" name="EXCELVHCT" value="EXCELVHCT"><b>Excel</b> <li class="fa fa-file-excel-o" ></button>
                                            <!-- &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-danger btn-md" name="PDFVHCT" value="PDFVHCT"><b>PDF</b> <li class="fa fa-file-pdf-o" ></button> -->
                                        </div>
                                    </form>                         
                                    <form action="report_refuelrecord_gw_export_outside.php" method="post" target="_blank">
                                        <hr>
                                        <h3><u>ข้อมูลเติมน้ำมันปั๊มนอก</u> <small><font color="red">***ดึงข้อมูลตามวันที่เติมน้ำมัน</font></small></h3>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่เริ่มต้น</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_datestartoiloutside" name="txt_datestartoiloutside" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodateoiloutside();" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่สิ้นสุด</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_dateendoiloutside" name="txt_dateendoiloutside" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่สิ้นสุด" autocomplete="off">
                                            </div> 
                                        </div>
                                        <!-- <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>เลือกเดือน</label>
                                                <?php 
                                                    $mydate=getdate(date("U"));
                                                    $MYYEAR=$mydate["year"];
                                                    $MYIF=$mydate["mon"];
                                                    if($MYIF < 10){
                                                        $MYMONTH='0'.$MYIF;
                                                    }else{
                                                        $MYMONTH=$MYIF;
                                                    }
                                                    $CONVERTYM=$MYYEAR.'-'.$MYMONTH;
                                                ?>
                                                <input class="form-control" type="month" style="background-color: #f080802e"  name="txt_dateoiloutside" value="<?=$CONVERTYM;?>" required>
                                            </div> 
                                        </div> -->
                                        </script>
                                        <!-- <div class="col-lg-2"> -->
                                            <div class="form-group">    
                                                <label>&nbsp;</label><br>                                               
                                                <button type="submit" class="btn btn-success btn-md" name="EXCELOUTSIDE" value="EXCELOUTSIDE"><b>Excel</b> <li class="fa fa-file-excel-o" ></button>
                                            </div>
                                        <!-- </div> -->
                                    </form> 
                                    <!-- <form action="report_refuelrecord_gw_avgday.php" method="post" target="_blank">
                                        <hr>
                                        <h3><u>สรุปค่าเฉลี่ยน้ำมันรายวัน</u> <small><font color="red">***อัพเดทข้อมูลเวลา 23:00 น. ของทุกวัน</font></small></h3>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่เริ่มต้น</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_datestaravarageforday" name="txt_datestaravarageforday" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodatehavarageforday();" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่สิ้นสุด</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_dateendyavarageforday" name="txt_dateendyavarageforday" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่สิ้นสุด" autocomplete="off">
                                            </div> 
                                        </div>
                                        <div class="form-group">                        
                                            <label>&nbsp;</label><br>                                               
                                            <button type="submit" class="btn btn-success btn-md" name="EXCELDAY" value="EXCELDAY"><li class="fa fa-file-excel-o"></li> <b>Excel</b></button>
                                        </div> 
                                    </form>  -->
                                    <form action="report_refuelrecord_gw_export_avgday.php" method="post" target="_blank">
                                        <hr>
                                        <u><h3>สรุปค่าเฉลี่ยน้ำมันรายเดือน</h3></u>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่เริ่มต้น</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_datestartoilmonthavarage" name="txt_datestartoilmonthavarage" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodateoilmonthavarage();" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่สิ้นสุด</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_dateendoilmonthavarage" name="txt_dateendoilmonthavarage" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่สิ้นสุด" autocomplete="off">
                                            </div>  
                                        </div>
                                        <div class="col-lg-3">
                                            <label>กลุ่มข้อมูล</label>
                                            <select id="lineofworkmonth" name="lineofworkmonth" class="form-control select2" required>
                                                <option value disabled selected>---เลือกกลุ่มข้อมูล---</option>
                                                <option value="RRC1">RRC | GMT</option>
                                                <option value="RRC2">RRC | TTAST</option>
                                                <option value="RATC1">RATC | TTT(8L)</option>
                                                <option value="RCC1">RCC | TTT(4L)</option>
                                                <option value="RCC2">RCC | TTT(8L)</option>
                                            </select>
                                        </div>        
                                        <div class="form-group">                        
                                                <label>&nbsp;</label><br>                                               
                                                <!-- <button type="button" class="btn btn-primary btn-md" onclick="select_oilmonthavarage();">ค้นหา <li class="fa fa-search"></li></button>
                                                &nbsp;&nbsp;&nbsp;                                              -->
                                                <button type="submit" class="btn btn-success btn-md" name="EXCELDAY" value="EXCELDAY"><li class="fa fa-file-excel-o"></li> <b>Excel ข้อมูลรายวัน</b></button>
                                                &nbsp;&nbsp;&nbsp;                                             
                                                <button type="submit" class="btn btn-success btn-md" name="EXCELMONTH" value="EXCELMONTH"><li class="fa fa-file-excel-o"></li> <b>Excel สรุปข้อมูลรายเดือน</b></button>
                                        </div> 
                                    </form>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script type="text/javascript">      
        function selcompanyDiv(select){
            if(select.value=='ALL'){
                document.getElementById('show_all').style.display = "block";
                document.getElementById('show_rrc').style.display = "none";
                document.getElementById('show_ratc').style.display = "none";
                document.getElementById('show_rcc').style.display = "none";
                document.getElementById('first').style.display = "none";
            }else if(select.value=='RRC'){
                document.getElementById('show_all').style.display = "none";
                document.getElementById('show_rrc').style.display = "block";
                document.getElementById('show_ratc').style.display = "none";
                document.getElementById('show_rcc').style.display = "none";
                document.getElementById('first').style.display = "none";
            }else if(select.value=='RATC'){
                document.getElementById('show_all').style.display = "none";
                document.getElementById('show_rrc').style.display = "none";
                document.getElementById('show_ratc').style.display = "block";
                document.getElementById('show_rcc').style.display = "none";
                document.getElementById('first').style.display = "none";
            }else if(select.value=='RCC'){
                document.getElementById('show_all').style.display = "none";
                document.getElementById('show_rrc').style.display = "none";
                document.getElementById('show_ratc').style.display = "none";
                document.getElementById('show_rcc').style.display = "block";
                document.getElementById('first').style.display = "none";
            }else if(select.value=='CENTER'){
                document.getElementById('show_all').style.display = "block";
                document.getElementById('show_rrc').style.display = "none";
                document.getElementById('show_ratc').style.display = "none";
                document.getElementById('show_rcc').style.display = "none";
                document.getElementById('first').style.display = "none";
            }
        }
        function selcompanyDiv2(select){
            if(select.value=='ALL'){
                select.selectedIndex = 0;
                document.getElementById('show_all2').style.display = "block";
                document.getElementById('show_rrc2').style.display = "none";
                document.getElementById('show_ratc2').style.display = "none";
                document.getElementById('show_rcc2').style.display = "none";
                document.getElementById('first2').style.display = "none";
            }else if(select.value=='RRC'){
                document.getElementById('show_all2').style.display = "none";
                document.getElementById('show_rrc2').style.display = "block";
                document.getElementById('show_ratc2').style.display = "none";
                document.getElementById('show_rcc2').style.display = "none";
                document.getElementById('first2').style.display = "none";
            }else if(select.value=='RATC'){
                document.getElementById('show_all2').style.display = "none";
                document.getElementById('show_rrc2').style.display = "none";
                document.getElementById('show_ratc2').style.display = "block";
                document.getElementById('show_rcc2').style.display = "none";
                document.getElementById('first2').style.display = "none";
            }else if(select.value=='RCC'){
                document.getElementById('show_all2').style.display = "none";
                document.getElementById('show_rrc2').style.display = "none";
                document.getElementById('show_ratc2').style.display = "none";
                document.getElementById('show_rcc2').style.display = "block";
                document.getElementById('first2').style.display = "none";
            }else if(select.value=='CENTER'){
                document.getElementById('show_all2').style.display = "block";
                document.getElementById('show_rrc2').style.display = "none";
                document.getElementById('show_ratc2').style.display = "none";
                document.getElementById('show_rcc2').style.display = "none";
                document.getElementById('first2').style.display = "none";
            }
        }    
        function datetodateoil(){
            document.getElementById('txt_dateendoil').value = document.getElementById('txt_datestartoil').value;
        }
        function datetodateoilmonth(){
            document.getElementById('txt_dateendoilmonth').value = document.getElementById('txt_datestartoilmonth').value;
        }
        function datetodateoilvhct(){
            document.getElementById('txt_dateendoilvhct').value = document.getElementById('txt_datestartoilvhct').value;
        }
        function datetodateoiloutside(){
            document.getElementById('txt_dateendoiloutside').value = document.getElementById('txt_datestartoiloutside').value;
        }
        function datetodateoilmonthavarage(){
            document.getElementById('txt_dateendoilmonthavarage').value = document.getElementById('txt_datestartoilmonthavarage').value;
        }
        function datetodatehavarageforday(){
            document.getElementById('txt_dateendyavarageforday').value = document.getElementById('txt_datestaravarageforday').value;
        }
        $(document).ready(function () {
            $('#dataTables-oiltat').DataTable({
                order: [[2, "asc"]],
                scrollX: true
            });
        });        
        $(function () {
            $.datetimepicker.setLocale('th');
            $(".dateen").datetimepicker({
                timepicker: false,
                format: 'd/m/Y', 
                lang: 'th', 
            });
            // $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            //     // กรณีใช้แบบ input
            //     $(".dateen").datetimepicker({
            //         timepicker: true,
            //         dateformat: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
            //         lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            //         timeFormat: "HH:mm"
            //     }
            // );
        });
        $(function () {
            $.datetimepicker.setLocale('th');
            $(".dateen1").datetimepicker({
                timepicker: true,
                format: 'd/m/Y H:i', 
                lang: 'th', 
            });
        });
        function select_dailytenkoofficer(){
            var startdate = document.getElementById('txt_datestartoil').value;
            var enddate = document.getElementById('txt_dateendoil').value;
            window.open('report_refuelrecord_excel.php?startdate=' + startdate + '&enddate=' + enddate + area, '_blank');
        }

        function select_pdfdailytenkoofficer(){
            var department = document.getElementById('select_department_month').value;
            var section = document.getElementById('select_section_month').value;
            var area = document.getElementById('select_area_section').value;

            var datestart = document.getElementById('txt_datestart_month').value;

            if (department == '02' && (section == '01' || section == '02')) {
                window.open('pdf_reportcheckin_acc.php?datestart=' + datestart + '&department=' + department + '&section=' + section + '&area=' + area, '_blank');
            } else if (department == '03' && section == '03') {
                window.open('pdf_reportcheckin_sq.php?datestart=' + datestart + '&department=' + department + '&section=' + section + '&area=' + area, '_blank');
            } else {
                window.open('pdf_reportcheckin.php?datestart=' + datestart + '&department=' + department + '&section=' + section + '&area=' + area, '_blank');
            }
        }
        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                responsive: true,
            });
        });
        $(document).ready(function () {
            $('#dataTables-example1').DataTable({
                responsive: true,
            });
        });
    </script>
</body>
</html>
<?php
sqlsrv_close($conn);
?>
