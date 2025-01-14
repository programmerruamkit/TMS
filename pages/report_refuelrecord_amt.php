
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
                        รายงานรายละเอียดการเติมน้ำมัน (AMT)
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
                                    <div id="overlay">
                                        <div class="cv-spinner">
                                            <span class="spinner"></span>
                                        </div>
                                        <style>
                                            #overlay{
                                                position: fixed;
                                                top: 0;
                                                z-index: 100;
                                                width: 100%;
                                                height:100%;
                                                display: none;
                                                background: rgba(0,0,0,0.6);
                                            }
                                            .cv-spinner {
                                                height: 100%;
                                                display: flex;
                                                justify-content: center;
                                                align-items: center;
                                            }
                                            .spinner {
                                                width: 40px;
                                                height: 40px;
                                                border: 4px #ddd solid;
                                                border-top: 4px #2e93e6 solid;
                                                border-radius: 50%;
                                                animation: sp-anime 0.8s infinite linear;
                                            }   
                                            @keyframes sp-anime {100% {transform: rotate(360deg);}}
                                            .is-hide{display:none;}
                                        </style>
                                    </div>
                                    <form action="report_refuelrecord_amt_export.php" method="post" target="_blank">
                                        <u><h3>ข้อมูลประจำวัน</h3></u><br>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่เริ่มต้น</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_datestartoil" name="txt_datestartoil" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodateoil();" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่สิ้นสุด</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_dateendoil" name="txt_dateendoil" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่สิ้นสุด" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>บริษัท</label>
                                            <select id="selcompany" name="selcompany" class="form-control" required>
                                                <option value disabled selected>-เลือกบริษัท-</option>
                                                <option value="ALL">เลือกทั้งหมด</option>
                                                <option value="RKR">RKR | บริษัท ร่วมกิจรุ่งเรือง (1993)</option>
                                                <option value="RKS">RKS | บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส</option>
                                                <option value="RKL">RKL | บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์ </option>
                                                <option value="CENTER">รถส่วนกลาง</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1">
                                            <label>ลูกค้า</label>
                                            <select name="selcustomer" id="selcustomer" data-placeholder="เลือกลูกค้า" class="form-control" required>
                                            <option value disabled selected>-เลือกลูกค้า-</option>
                                            <!-- <option value="ALL">เลือกทั้งหมด</option> -->
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>สายงาน</label>
                                            <select id="lineofwork2" name="lineofwork2" class="form-control select2" >
                                                <option value disabled selected>-เลือกสายงาน-</option>
                                                <option value="CS">CS</option>
                                                <option value="SCCL">STC TL</option>
                                                <option value="KBT">KUBOTA</option>
                                                <option value="SMIP">STM - IP</option>
                                                <option value="TTKN">T.TOHKEN</option>
                                                <option value="SC10">STC 10 W</option>
                                                <option value="TTDK">TGT/DAIKI</option>
                                                <option value="SRTW">STM - TMT SR / TAW</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>เรียงข้อมูลจาก...</label>
                                            <select name="SORTBY" id="SORTBY" class="form-control" required>
                                            <!-- <option value disabled selected>-เรียงข้อมูลตาม...-</option> -->
                                            <option value="DATEPLAN" selected>วันที่แผนงาน</option>
                                            <option value="DATEREFUEL">วันที่เติมน้ำมัน</option>
                                            </select>
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
                                    <form action="report_refuelrecord_amt_export_month.php" method="post" target="_blank">
                                        <hr>
                                        <u><h3>ข้อมูลประจำเดือน</h3></u><br>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่เริ่มต้น</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_datestartoilmonth" name="txt_datestartoilmonth" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodateoilmonth();" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่สิ้นสุด</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_dateendoilmonth" name="txt_dateendoilmonth" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่สิ้นสุด" autocomplete="off">
                                            </div> 
                                        </div>
                                        <div class="col-lg-3">
                                            <label>สายงาน</label>
                                            <select id="selcustomer2" name="selcustomer2" class="form-control select2" >
                                                <option value disabled selected>-เลือกสายงาน-</option>
                                                <option value="CS">CS</option>
                                                <option value="SCCL">STC TL</option>
                                                <option value="KBT">KUBOTA</option>
                                                <option value="SMIP">STM - IP</option>
                                                <option value="TTKN">T.TOHKEN</option>
                                                <option value="SC10">STC 10 W</option>
                                                <option value="TTDK">TGT/DAIKI</option>
                                                <option value="SRTW">STM - TMT SR / TAW</option>
                                            </select>
                                        </div>
                                        <!-- <div class="col-lg-3">
                                            <label>บริษัท</label>
                                            <select id="selcompany2" name="selcompany2" class="form-control" required>
                                                <option value disabled selected>-เลือกบริษัท-</option>
                                                <option value="RKR">RKR | บริษัท ร่วมกิจรุ่งเรือง (1993)</option>
                                                <option value="RKS">RKS | บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส</option>
                                                <option value="RKL">RKL | บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์ </option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>ลูกค้า</label> 
                                            <select name="selcustomer2" id="selcustomer2" data-placeholder="เลือกลูกค้า" class="form-control" required>
                                            <option value disabled selected>-เลือกลูกค้า-</option>
                                            </select>
                                        </div> -->
                                        <!-- <div class="col-lg-2"> -->
                                            <div class="form-group">    
                                                <label>&nbsp;</label><br>                                               
                                                <button type="submit" class="btn btn-success btn-md" name="EXCELMONTH" value="EXCELMONTH"><b>Excel</b> <li class="fa fa-file-excel-o" ></button>
                                                &nbsp;&nbsp;
                                                <!-- <button type="submit" class="btn btn-danger btn-md" name="PDFMONTH" value="PDFMONTH"><b>PDF</b> <li class="fa fa-file-pdf-o" ></button> -->
                                                                                
                                                <button type="submit" class="btn btn-success btn-md" name="EXCELCOVER" value="EXCELCOVER"><b>พิมพ์ใบปะหน้า</b> <li class="fa fa-file-excel-o" ></button>
                                            </div>
                                        <!-- </div> -->
                                        <!-- <div class="col-lg-1">
                                            <div class="form-group">    
                                                <label>&nbsp;</label><br>                                               
                                                <button type="submit" class="btn btn-success btn-md" name="EXCELCOVER" value="EXCELCOVER"><b>พิมพ์ใบปะหน้า</b> <li class="fa fa-file-excel-o" ></button>
                                            </div>
                                        </div> -->
                                    </form> 
                                    <form action="report_refuelrecord_amt_export_vhct.php" method="post" target="_blank">
                                        <hr>
                                        <u><h3>ข้อมูลแยกบริษัท</h3></u><br>
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
                                    <form action="report_refuelrecord_amt_export_outside.php" method="post" target="_blank">
                                        <hr>
                                        <h3><u>ข้อมูลเติมน้ำมันปั๊มนอก</u> <small><font color="red">***ดึงข้อมูลตามวันที่เติมน้ำมัน</font></small></h3><br>
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
                                    <form action="report_refuelrecord_amt_export_avgday.php" method="post" target="_blank">
                                        <hr>
                                        <u><h3>สรุปค่าเฉลี่ยน้ำมันรายเดือน</h3></u><br>
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
                                        <div class="col-lg-2">
                                            <label>สายงาน</label>
                                            <select id="lineofworkmonth" name="lineofworkmonth" class="form-control select2" required>
                                                <option value disabled selected>-เลือกสายงาน-</option>
                                                <option value="CS">CS</option>
                                                <option value="TTDK">TGT</option>
                                                <option value="STM">STM</option>
                                                <option value="SCCL">STC TL</option>
                                                <option value="KBT">KUBOTA</option>
                                                <option value="SC10">STC 10 W</option>
                                                <option value="TTKN">T.TOHKEN</option>
                                                <option value="OTHER">OTHER</option>
                                            </select>
                                        </div>        
                                        <div class="form-group">                        
                                                <label>&nbsp;</label><br>                                               
                                                <button type="button" class="btn btn-primary btn-md" onclick="select_oilmonthavarage();">ค้นหา <li class="fa fa-search"></li></button>
                                                &nbsp;&nbsp;&nbsp;                                             
                                                <button type="submit" class="btn btn-success btn-md" name="EXCELDAY" value="EXCELDAY"><li class="fa fa-file-excel-o"></li> <b>Excel ข้อมูลรายวัน</b></button>
                                                &nbsp;&nbsp;&nbsp;                                             
                                                <button type="submit" class="btn btn-success btn-md" name="EXCELMONTH" value="EXCELMONTH"><li class="fa fa-file-excel-o"></li> <b>Excel สรุปข้อมูลรายเดือน</b></button>
                                        </div> 
                                    </form>                                     
                                    <div class="col-sm-12">
                                        <div id="data_def">
                                            <!-- TABLE -->
                                        </div>
                                        <div id="data_sr"></div>
                                    </div>
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
    
        $(document).ready(function () {
            $('#dataTables_oilmonthavarage').DataTable({
                "ordering": false,
                scrollX: true
            });
        });
        function select_oilmonthavarage(){
            $(document).ajaxSend(function() {
                $("#overlay").fadeIn(300);　
            });
            var lineofworkmonth = $('#lineofworkmonth').val();
            // alert(lineofworkmonth);
            if(lineofworkmonth == ""){
				alert('โปรดเลือกสายงาน');
				document.getElementById("lineofworkmonth").focus();
			}
            $.ajax({
                type: 'post',
                url: 'meg_data2.php',
                data: {
                    txt_flg: "select_oilmonthavarage", 
                    datestartoilmonthavarage: document.getElementById('txt_datestartoilmonthavarage').value, 
                    dateendoilmonthavarage: document.getElementById('txt_dateendoilmonthavarage').value,     
                    lineofworkmonth: document.getElementById('lineofworkmonth').value                                                                                                   
                },
                success: function (response) {
                    if (response){
                        document.getElementById("data_sr").innerHTML = response;
                        document.getElementById("data_def").innerHTML = "";
                        setTimeout(function(){$("#overlay").fadeOut(300);},500);
                    };
                    $(function () {
                        $('[data-toggle="popover"]').popover({
                            html: true,
                            content: function () {
                                return $('#popover-content').html();
                            }
                        });
                    })
                    $(document).ready(function () {
                        $('#dataTables_oilmonthavarage').DataTable({
                            "ordering": false,
                            scrollX: true
                        });
                    });
                }
            });
        }    
        function datetodateoil(){
            document.getElementById('txt_dateendoil').value = document.getElementById('txt_datestartoil').value;
        }
        function datetodateoilmonthavarage(){
            document.getElementById('txt_dateendoilmonthavarage').value = document.getElementById('txt_datestartoilmonthavarage').value;
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
        $(document).ready(function () {
            $('#dataTables-oiltat').DataTable({
                order: [[2, "asc"]],
                scrollX: true
            });
        });
        $(function(){
            var CID_TAB1Object = $('#selcompany');
            var CSID_TAB1Object = $('#selcustomer');
            CID_TAB1Object.on('change', function(){
                var CCID_TAB1Id = $(this).val();
                CSID_TAB1Object.html('<option value="ALL">เลือกทั้งหมด</option>');
                $.get('report_refuelrecord_customer_get.php?customercode=' + CCID_TAB1Id, function(data){
                    var result = JSON.parse(data);
                    $.each(result, function(index, item){
                        CSID_TAB1Object.append(
                            $('<option></option>').val(item.CUSTOMERCODE).html(item.CUSTOMERCODE)
                        );
                    });
                });
            });
        });
        $(function(){
            var CID_TAB2Object = $('#selcompany2');
            var CSID_TAB2Object = $('#selcustomer2');
            CID_TAB2Object.on('change', function(){
                var CCID_TAB2Id = $(this).val();
                CSID_TAB2Object.html('<option value disabled selected>-เลือกลูกค้า-</option>');
                $.get('report_refuelrecord_customer_get.php?customercode=' + CCID_TAB2Id, function(data){
                    var result = JSON.parse(data);
                    $.each(result, function(index, item){
                        CSID_TAB2Object.append(
                            $('<option></option>').val(item.CUSTOMERCODE).html(item.CUSTOMERCODE)
                        );
                    });
                });
            });
        });
        $(function(){
            var CID_TAB3Object = $('#selcompany');
            var CSID_TAB3Object = $('#lineofwork');
            CID_TAB3Object.on('change', function(){
                var CCID_TAB3Id = $(this).val();
                CSID_TAB3Object.html('<option value="ALL">เลือกทั้งหมด</option>');
                $.get('report_refuelrecord_lineofwork_get.php?companycode=' + CCID_TAB3Id, function(data){
                    var result = JSON.parse(data);
                    $.each(result, function(index, item){
                        CSID_TAB3Object.append(
                            $('<option></option>').val(item.SUBPOS).html(item.SUBPOS)
                        );
                    });
                });
            });
        });
        $(function () {
            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            // กรณีใช้แบบ input
            $(".dateen").datetimepicker({
                timepicker: false,
                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            });
        });
        $(function () {
            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            // กรณีใช้แบบ input
            $(".dateen1").datetimepicker({
                // timepicker: true,
                // format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                // lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
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
