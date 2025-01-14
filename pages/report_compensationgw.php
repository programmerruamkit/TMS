
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdatetime', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

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
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
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

            <!-- Navigation -->
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
                            รายงานค่าเที่ยว (GW)


                        </h2>
                    </div>

                    <!-- /.col-lg-12 -->
                </div>

                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row" >
                                    <div class="col-lg-6">

                                        รายงานค่าเที่ยว (RCC,RATC)

                                    </div>
                                    <div class="col-lg-6 text-right"></div>
                                </div>
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <ul class="nav nav-pills">
                                    <li class="active"><a href="#compensation_day" data-toggle="tab">รายงานค่าเที่ยว (รายวัน)</a>
                                    </li>
                                    <li><a href="#compensation_month" data-toggle="tab">รายงานค่าเที่ยว (รายเดือน)</a>
                                    </li>
                                    <!-- <li><a href="#compensation_person" data-toggle="tab">รายงานค่าเที่ยว (รายบุคคล)</a>
                                    </li>
                                    <li><a href="#compensation_all" data-toggle="tab">รายงานค่าเที่ยว (ภาพรวมบริษัท)</a>
                                    </li> -->


                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="compensation_day">
                                        <div class="row">&nbsp;</div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    
                                                    <label class="col-lg-12" style="text-align: center;font-size: 24px;"><b>ดึงข้อมูลค่าเที่ยวรายวัน</b></label>
                                                    <br><br>
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>ค้นหาตามช่วงวันที่ (รายวัน)</label>
                                                                <input class="form-control dateen_day" readonly="" onchange="datetodate_day();" style="background-color: #f080802e"  id="txt_datestart_day" name="txt_datestart_day" value="<?= $result_getDate['SYSDATE_TIME']; ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control dateen_day"    style="background-color: #f080802e" id="txt_dateend_day" name="txt_dateend_day" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE_TIME']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label>&nbsp;</label>
                                                            <select id="txt_companycode_day" name="txt_companycode_day" class="form-control" onchange="select_customer_day(this.value)">
                                                                <option value="">เลือกบริษัท</option>
                                                                <option value="RCC">บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                                                <option value="RATC">บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label>&nbsp;</label>
                                                            <div id="datacompdef_day">
                                                                <select id="txt_data_day" name="txt_data_day" class="form-control" >
                                                                    <option value="">เลือกข้อมูล...</option>
                                                                    <!-- <option value="พนักงานขนส่งยานยนต์/RCC 4 LOAD">พนักงาน RCC 4 LOAD</option>
                                                                    <option value="พนักงานขนส่งยานยนต์/RCC 8 LOAD">พนักงาน RCC 8 LOAD</option>
                                                                    <option value="พนักงานขนส่งยานยนต์/RATC 4 LOAD">พนักงาน RATC 4 LOAD</option>
                                                                    <option value="พนักงานขนส่งยานยนต์/RATC 8 LOAD">พนักงาน RATC 8 LOAD</option> -->
                                                                </select>
                                                            </div>
                                                            <div id="datacompsr_day"></div>
                                                        </div>
                                                       



                                                        <div class="col-lg-2" style="text-align: left">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="excel_compensation_day();" class="btn btn-default">พิมพ์รายงาน(รายวัน) <li class="fa fa-print"></li></a>

                                                        </div>
                                     
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="compensation_month">
                                        <div class="row">&nbsp;</div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    
                                                    <label class="col-lg-12" style="text-align: center;font-size: 24px;"><b>ดึงข้อมูลค่าเที่ยวรายเดือน</b></label>
                                                    <br><br>
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>ค้นหาตามช่วงวันที่ (รายเดือน)</label>
                                                                <input class="form-control dateen_month" readonly="" onchange="datetodate_month();" style="background-color: #f080802e"  id="txt_datestart_month" name="txt_datestart_month" value="<?= $result_getDate['SYSDATE_TIME']; ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control dateen_month"    style="background-color: #f080802e" id="txt_dateend_month" name="txt_dateend_month" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE_TIME']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label>&nbsp;</label>
                                                            <select id="txt_companycode_month" name="txt_companycode_month" class="form-control" onchange="select_customer_month(this.value)">
                                                                <option value="">เลือกบริษัท</option>
                                                                <option value="RCC">บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                                                <option value="RATC">บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label>&nbsp;</label>
                                                            <div id="datacompdef_month">
                                                                <select id="txt_data_month" name="txt_data_month" class="form-control" >
                                                                    <option value="">เลือกข้อมูล...</option>
                                                                    <!-- <option value="พนักงานขนส่งยานยนต์/RCC 4 LOAD">พนักงาน RCC 4 LOAD</option>
                                                                    <option value="พนักงานขนส่งยานยนต์/RCC 8 LOAD">พนักงาน RCC 8 LOAD</option>
                                                                    <option value="พนักงานขนส่งยานยนต์/RATC 4 LOAD">พนักงาน RATC 4 LOAD</option>
                                                                    <option value="พนักงานขนส่งยานยนต์/RATC 8 LOAD">พนักงาน RATC 8 LOAD</option> -->
                                                                </select>
                                                            </div>
                                                            <div id="datacompsr_month"></div>
                                                        </div>
                                                       



                                                        <div class="col-lg-2" style="text-align: left">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="excel_compensation_month();" class="btn btn-default">พิมพ์รายงาน(รายเดือน) <li class="fa fa-print"></li></a>

                                                        </div>
                                     
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="compensation_person">
                                        <div class="row">&nbsp;</div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <label class="col-lg-12" style="text-align: center;font-size: 24px;"><b>ดึงข้อมูลค่าเที่ยวรายบุคคล</b></label>
                                                    <br><br>
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>ค้นหาตามช่วงวันที่ (รายบุคคล)</label>
                                                                <input class="form-control dateen_person" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE_TIME']; ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control dateen_person"  readonly=""  style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE_TIME']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <select id="txt_companycode" name="txt_companycode" class="form-control" >
                                                                <option value="">เลือกบริษัท</option>
                                                                <option value="RCC">บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                                                <option value="RATC">บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</option>
                                                            </select>
                                                        </div>
                                                       
                                                        <!-- <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                
                                                                <button type="button" class="btn btn-default" onclick="select_compensationperson();">ค้นหา <li class="fa fa-search"></li></button>
                                                            </div>

                                                        </div> -->
                                                       



                                                        <div class="col-lg-2" style="text-align: left">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="excel_compensationperson();" class="btn btn-default">พิมพ์รายงาน(บุคคล) <li class="fa fa-print"></li></a>

                                                        </div>
                                     
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        รายงานค่าเที่ยว (รายบุคคล) <font style="color:red;">*ข้อมูลที่แสดงคือข้อมูลโดยย่อ รายละเอียดกรุณา ดาวน์โหลดรายงาน Excel</font> 
                                                    </div>
                                                    

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="datadef">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width:  10%">ลำดับ</th>
                                                                            <th>วันที่</th>
                                                                            <th>ชื่อ-สกุล</th>
                                                                            <th>ต้นทาง</th>
                                                                            <th>ปลายทาง</th>
                                                                            <th>ทะเบียนรถ</th>
                                                                            <th>ค่าเที่ยวปกติ</th>
                                                                            <th>OT วันหยุด</th>
                                                                            <th>OT 1.5 เท่า</th>
                                                                            <th>รายได้อื่นๆ</th>
                                                                            <th>รวม</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div id="datasr"></div>
                                                        </div>


                                                        
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div> -->


                                    </div>
                                    <div class="tab-pane fade" id="compensation_all">
                                        <div class="row">&nbsp;</div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <label class="col-lg-12" style="text-align: center;font-size: 24px;"><b>ดึงข้อมูลค่าเที่ยวภาพรวมบริษัท</b></label>
                                                    <br><br>
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>ค้นหาตามช่วงวันที่ (รายบริษัท)</label>
                                                                <input class="form-control dateen_company" readonly="" onchange="datetodate2();" style="background-color: #f080802e"  id="txt_datestart2" name="txt_datestart2" value="<?= $result_getDate['SYSDATE_TIME']; ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label><br>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control dateen_company"  readonly=""  style="background-color: #f080802e" id="txt_dateend2" name="txt_dateend2" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE_TIME']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <select id="txt_companycode2" name="txt_companycode2" class="form-control" >
                                                                <option value="">เลือกบริษัท</option>
                                                                <option value="RCC">บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                                                <option value="RATC">บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</option>
                                                            </select>
                                                        </div>
                                                        
                                                       
                                                        <!-- <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-default" onclick="select_compensationall();">ค้นหา <li class="fa fa-search"></li></button>
                                                            </div>
                                                        </div>   -->
                                                        


                                                        <div class="col-lg-2" style="text-align: left">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="excel_compensationall();" class="btn btn-default">พิมพ์รายงาน(ภาพรวมบริษัท) <li class="fa fa-print"></li></a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                    รายงานค่าเที่ยว (ภาพรวมบริษัท) <font style="color:red;">*ข้อมูลที่แสดงคือข้อมูลโดยย่อ รายละเอียดกรุณา ดาวน์โหลดรายงาน Excel</font> 
                                                    </div>
                                                   

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="datadef2">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example2" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width:  10%">ลำดับ</th>
                                                                            <th>วันที่</th>
                                                                            <th>ชื่อ-สกุล</th>
                                                                            <th>จำนวนเที่ยว</th>
                                                                            <th>รวมค่าเที่ยว</th>
                                                                            <th>หมายเหตุ</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div id="datasr2"></div>
                                                        </div>


                                                        
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div> -->


                                    </div>

                                </div>




                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                </div>
                <!-- /.row -->

                <!-- รายงานค่าเที่ยว RRC -->
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row" >
                                    <div class="col-lg-6">

                                        รายงานค่าเที่ยว (RRC)

                                    </div>
                                    <div class="col-lg-6 text-right"></div>
                                </div>
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <ul class="nav nav-pills">
                                    <li class="active"><a href="#compensation_rrc" data-toggle="tab">รายงานค่าเที่ยว (RRC)</a>
                                    </li>
                                    <!-- <li><a href="#compensation_all" data-toggle="tab">รายงานค่าเที่ยว (ภาพรวมบริษัท)</a>
                                    </li> -->


                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="compensation_rrc">
                                        <div class="row">&nbsp;</div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <div class="row">


                                                        <div class="col-lg-2">

                                                            <div class="form-group">
                                                                <label>ค้นหาตามช่วงวันที่ (RRC)</label>
                                                                <input class="form-control dateen" readonly="" onchange="datetodaterrc();" style="background-color: #f080802e"  id="txt_datestartrrc" name="txt_datestartrrc" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateendrrc" name="txt_dateendrrc" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <select id="txt_companycoderrc" name="txt_companycoderrc" class="form-control" >
                                                                <option value="">เลือกข้อมูล</option>
                                                                <option value="GMT">พนักงาน GMT</option>
                                                                <option value="TTAST">พนักงาน TTAST</option>
                                                                <option value="OTHER">ตำแหน่งอื่นๆ</option>
                                                            </select>
                                                        </div>
                                                       
                                                        <!-- <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                
                                                                <button type="button" class="btn btn-default" onclick="select_compensationperson();">ค้นหา <li class="fa fa-search"></li></button>
                                                            </div>

                                                        </div> -->
                                                       



                                                        <div class="col-lg-2" style="text-align: left">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="excel_compensationrrc();" class="btn btn-default">พิมพ์รายงานค่าเที่ยว(RRC) <li class="fa fa-print"></li></a>

                                                        </div>
                                     
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- Tap 2 -->

                                </div>




                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
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
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
            <script>
                                                                function select_customer_day(companycode)
                                                                {
                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data2.php',
                                                                        data: {
                                                                            txt_flg: "select_customercompensation_rrcratc_day", companycode:companycode
                                                                        },
                                                                        success: function (response) {
                                                                            if (response){

                                                                                document.getElementById("datacompsr_day").innerHTML = response;
                                                                                document.getElementById("datacompdef_day").innerHTML = "";

                                                                            }




                                                                        }
                                                                    });

                                                                }
                                                                function select_customer_month(companycode)
                                                                {
                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data2.php',
                                                                        data: {
                                                                            txt_flg: "select_customercompensation_rrcratc_month", companycode:companycode
                                                                        },
                                                                        success: function (response) {
                                                                            if (response){

                                                                                document.getElementById("datacompsr_month").innerHTML = response;
                                                                                document.getElementById("datacompdef_month").innerHTML = "";

                                                                            }




                                                                        }
                                                                    });

                                                                }
                                                                // function select_compensationperson()
                                                                // {


                                                                //     var datestart = document.getElementById('txt_datestart').value;
                                                                //     var dateend = document.getElementById('txt_dateend').value;
                                                                //     var companycode = document.getElementById('txt_companycode').value;
                                                                //     // alert(datestart);
                                                                //     // alert(datestart);
                                                                //     // alert(companycode);

                                                                   
                                                                //     $.ajax({
                                                                //         type: 'post',
                                                                //         url: 'meg_data2.php',
                                                                //         data: {
                                                                //             txt_flg: "select_compensationperson", datestart: datestart, dateend: dateend, companycode: companycode
                                                                //         },
                                                                //         success: function (response) {
                                                                //             if (response)
                                                                //             {

                                                                //                 document.getElementById("datasr").innerHTML = response;
                                                                //                 document.getElementById("datadef").innerHTML = "";
                                                                //             }
                                                                //             $(document).ready(function () {
                                                                //                 $('#dataTables-example').DataTable({
                                                                //                     responsive: true
                                                                //                 });
                                                                //             });



                                                                //         }
                                                                //     });
                                                                   

                                                                // }
                                                                // function select_compensationall()
                                                                // {


                                                                //     var datestart = document.getElementById('txt_datestart2').value;
                                                                //     var dateend = document.getElementById('txt_dateend2').value;
                                                                //     var companycode = document.getElementById('txt_companycode2').value;
                                                                   
                                                                //         alert(datestart);
                                                                //         alert(datestart);
                                                                //         alert(companycode);
                                                                //         $.ajax({
                                                                //             type: 'post',
                                                                //             url: 'meg_data.php',
                                                                //             data: {
                                                                //                 txt_flg: "select_foodcompensation2", datestart: datestart, dateend: dateend, employeecode: employeecode
                                                                //             },
                                                                //             success: function (response) {
                                                                //                 if (response)
                                                                //                 {
                                                                //                     document.getElementById("datasr2").innerHTML = response;
                                                                //                     document.getElementById("datadef2").innerHTML = "";
                                                                //                 }
                                                                //                 $(document).ready(function () {
                                                                //                     $('#dataTables-example2').DataTable({
                                                                //                         responsive: true
                                                                //                     });
                                                                //                 });



                                                                //             }
                                                                //         });
                                                                    

                                                                // }

                                                                // ค่าเที่ยวรายเดือนสายงาน RCC,RATC  
                                                                function excel_compensation_day()
                                                                {
                                                                    var datestart = document.getElementById('txt_datestart_day').value;
                                                                    var dateend = document.getElementById('txt_dateend_day').value;
                                                                    var companycode = document.getElementById('txt_companycode_day').value;
                                                                    var datasearch = document.getElementById('txt_data_day').value;
                                                                    // alert('ALL');
                                                                    if (companycode == '') {
                                                                        // alert('กรุณาเลือกบริษัท !!!');
                                                                        swal.fire({
                                                                            title: "Warning !!!",
                                                                            text: "กรุณาเลือกบริษัท !!!",
                                                                            icon: "warning",
                                                                            showConfirmButton: true,
                                                                            
                                                                        });

                                                                    }else if(datasearch == ''){
                                                                        // alert('กรุณาเลือกข้อมูล !!!');
                                                                        swal.fire({
                                                                            title: "Warning !!!",
                                                                            text: "กรุณาเลือกข้อมูล !!!",
                                                                            icon: "warning",
                                                                            showConfirmButton: true,
                                                                            
                                                                        });
                                                                    }else{
                                                                        window.open('excel_reportcompensationrccratc_day.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=' + companycode + '&datasearch=' + datasearch, '_blank');
                                                                    }
                                                                   

                                                                }  

                                                                // ค่าเที่ยวรายวันสายงาน RCC,RATC  
                                                                function excel_compensation_month()
                                                                {
                                                                    var datestart = document.getElementById('txt_datestart_month').value;
                                                                    var dateend = document.getElementById('txt_dateend_month').value;
                                                                    var companycode = document.getElementById('txt_companycode_month').value;
                                                                    var datasearch = document.getElementById('txt_data_month').value;
                                                                    // alert('ALL');
                                                                    if (companycode == '') {
                                                                        // alert('กรุณาเลือกบริษัท !!!');
                                                                        swal.fire({
                                                                            title: "Warning !!!",
                                                                            text: "กรุณาเลือกบริษัท !!!",
                                                                            icon: "warning",
                                                                            showConfirmButton: true,
                                                                            
                                                                        });
                                                                    }else if(datasearch == ''){
                                                                        // alert('กรุณาเลือกข้อมูล !!!');
                                                                        swal.fire({
                                                                            title: "Warning !!!",
                                                                            text: "กรุณาเลือกข้อมูล !!!",
                                                                            icon: "warning",
                                                                            showConfirmButton: true,
                                                                            
                                                                        });
                                                                    }else{
                                                                        window.open('excel_reportcompensationrccratc_month.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=' + companycode + '&datasearch=' + datasearch, '_blank');
                                                                    }
                                                                   

                                                                }  

                                                                function excel_compensationperson()
                                                                {
                                                                    var datestart = document.getElementById('txt_datestart').value;
                                                                    var dateend = document.getElementById('txt_dateend').value;
                                                                    var companycode = document.getElementById('txt_companycode').value;
                                                                    // alert('PERSON');
                                                                    if (companycode == '') {
                                                                        // alert('กรุณาเลือกบริษัท !!!');
                                                                        swal.fire({
                                                                            title: "Warning !!!",
                                                                            text: "กรุณาเลือกบริษัท !!!",
                                                                            icon: "warning",
                                                                            showConfirmButton: true,
                                                                            
                                                                        });
                                                                    }else{
                                                                        window.open('excel_reportcompensationpersongw.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=' + companycode, '_blank');
                                                                    }    
                                                                    

                                                                }
                                                                function excel_compensationall()
                                                                {
                                                                    var datestart = document.getElementById('txt_datestart2').value;
                                                                    var dateend = document.getElementById('txt_dateend2').value;
                                                                    var companycode = document.getElementById('txt_companycode2').value;
                                                                    // alert('ALL');

                                                                    if (companycode == '') {
                                                                        // alert('กรุณาเลือกบริษัท !!!');
                                                                        swal.fire({
                                                                            title: "Warning !!!",
                                                                            text: "กรุณาเลือกบริษัท !!!",
                                                                            icon: "warning",
                                                                            showConfirmButton: true,
                                                                            
                                                                        });
                                                                    }else{
                                                                        window.open('excel_reportcompensationallgw.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=' + companycode, '_blank');
                                                                    }
                                                                }
                                                                function excel_compensationrrc()
                                                                {
                                                                    var datestart = document.getElementById('txt_datestartrrc').value;
                                                                    var dateend = document.getElementById('txt_dateendrrc').value;
                                                                    var companycode = document.getElementById('txt_companycoderrc').value;
                                                                    // alert('PERSON');

                                                                    if (companycode == '') {
                                                                        // alert('กรุณาเลือกบริษัท !!!');
                                                                        swal.fire({
                                                                            title: "Warning !!!",
                                                                            text: "กรุณาเลือกบริษัท !!!",
                                                                            icon: "warning",
                                                                            showConfirmButton: true,
                                                                            
                                                                        });
                                                                    }else{
                                                                        window.open('excel_reportcompensationrrc.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=' + companycode, '_blank');
                                                                    }
                                                                    

                                                                }

                                                                function datetodate_day()
                                                                {
                                                                    document.getElementById('txt_dateend_day').value = document.getElementById('txt_datestart_day').value;
                                                                }
                                                                function datetodate_month()
                                                                {
                                                                    document.getElementById('txt_dateend_month').value = document.getElementById('txt_datestart_month').value;
                                                                }
                                                                function datetodate()
                                                                {
                                                                    document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                                                                }
                                                                function gdatetodate2()
                                                                {
                                                                    document.getElementById('txt_gdateend2').value = document.getElementById('txt_gdatestart2').value;
                                                                }
                                                                function datetodate2()
                                                                {
                                                                    document.getElementById('txt_dateend2').value = document.getElementById('txt_datestart2').value;

                                                                }
                                                                function datetodaterrc()
                                                                {
                                                                    document.getElementById('txt_dateendrrc').value = document.getElementById('txt_datestartrrc').value;

                                                                }

                                                                // date start ,date end ข้อมูลค่าเที่ยวรายวัน
                                                                $(function () {
                                                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                    // กรณีใช้แบบ input
                                                                    $(".dateen_day").datetimepicker({
                                                                        timepicker: true,
                                                                        format: 'd/m/Y H:i', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                                                                    });

                                                                    // jQuery('.dateen_day').datetimepicker({
                                                                    //     format:'d/m/Y H:i',
                                                                    //     lang:'th',
                                                                    // });
                                                                });

                                                                // date start ,date end ข้อมูลค่าเที่ยวรายเดือน
                                                                $(function () {
                                                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                    // กรณีใช้แบบ input
                                                                    $(".dateen_month").datetimepicker({
                                                                        timepicker: true,
                                                                        format: 'd/m/Y H:i', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                                                                    });
                                                                });

                                                                // date start ,date end ข้อมูลค่าเที่ยวรายบุคคล
                                                                $(function () {
                                                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                    // กรณีใช้แบบ input
                                                                    $(".dateen_person").datetimepicker({
                                                                        timepicker: true,
                                                                        format: 'd/m/Y H:i', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                                                                    });
                                                                });

                                                                // date start ,date end ข้อมูลค่าเที่ยวรายบุคคล
                                                                $(function () {
                                                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                    // กรณีใช้แบบ input
                                                                    $(".dateen_company").datetimepicker({
                                                                        timepicker: true,
                                                                        format: 'd/m/Y H:i', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

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

                                                                $(document).ready(function () {
                                                                    $('#dataTables-example').DataTable({
                                                                        responsive: true,
                                                                    });
                                                                });
                                                                $(document).ready(function () {
                                                                    $('#dataTables-example2').DataTable({
                                                                        responsive: true,
                                                                    });
                                                                });

            </script>


    </body>

</html>

<?php
sqlsrv_close($conn);
?>
