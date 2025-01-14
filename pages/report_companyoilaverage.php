
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
        <input type="text" class="form-control" id="txt_companycode" name="txt_companycode" style="display: none">
        <div id="wrapper">
            <div class="modal fade" id="modal_checkcompany" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 80%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="modal-title" id="title_copydiagram"><b>ตรวจสอบรายงานเบิกน้ำมัน</b></h5>
                                </div>

                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-2">
                                    <label><font style="color: red">*</font>ลูกค้า :</label>
                                    <div id="data_customerdef">
                                        <select id="select_cus" name="select_cus" class="form-control">

                                            <option value="">เลือกลูกค้า</option>

                                        </select>
                                    </div>
                                    <div id="data_customersr"></div>
                                </div>
                                <div class="col-lg-2">
                                    <label><font style="color: red">*</font>วันที่เริ่มต้น :</label>
                                    <input type="text" class="form-control dateen" onchange="datetodate2()" id="txt_datestart2" name="txt_datestart2" autocomplete="off">
                                </div>
                                <div class="col-lg-2">
                                    <label><font style="color: red">*</font>วันที่สิ้นสุด :</label>
                                    <input type="text" class="form-control dateen" id="txt_dateend2" name="txt_dateend2" autocomplete="off">
                                </div>

                                <div class="col-lg-2 text-left">
                                    <label>&emsp;</label><br>
                                    <button type="button" class="btn btn-default" onclick="select_checkcompanydate();">ค้นหา <li class="fa fa-search"></li></button>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-12">&nbsp;</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="datadef">
                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>


                                                    <th colspan="11" style="text-align: center;">
                                                        &nbsp;
                                                    </th>
                                                    <th colspan="2" style="text-align: center;">
                                                        <b>รวมสุทธิ</b>
                                                    </th>
                                                    <th rowspan="2" style="text-align: center;">
                                                        <b>ยอดที่จ่ายจริง</b>
                                                    </th>



                                                </tr>

                                                <tr>

                                                    <th style="text-align: center;" >ลำดับ</th>
                                                    <th style="text-align: center;">ทะเบียนรถ</th>
                                                    <th style="text-align: center;">ลูกค้า</th>
                                                    <th style="text-align: center;">JOBNO</th>
                                                    <th style="text-align: center;">ต้นทาง</th>
                                                    <th style="text-align: center;">ปลายทาง</th>

                                                    <th style="text-align: center;">รหัสพนักงาน</th>
                                                    <th style="text-align: center;">ชื่อ-สกุล</th>
                                                    <th style="text-align: center;">จำนวนเที่ยว</th>
                                                    <th style="text-align: center;">กิโลเมตร</th>
                                                    <th style="text-align: center;">น้ำมัน(ลิตร)</th>

                                                    <th style="text-align: center;">เงินบวก</th>
                                                    <th style="text-align: center;">เงินลบ</th>

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
                        <div class="modal-footer">

                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        </div>

                    </div>
                </div>
            </div>


            <div class="modal fade" id="modal_datecompany" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 45%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="modal-title" id="title_copydiagram"><b>เลือกช่วงวันที่ในการแสดงข้อมูล</b></h5>
                                </div>

                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">

                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-pills">
                                                <li class="active">
                                                    <a href="#tap_comp3" data-toggle="tab" aria-expanded="true">ตรวจสอบข้อมูลน้ำมันรายวัน</a>
                                                </li>
                                                <li>
                                                    <a href="#tap_comp4" data-toggle="tab">ข้อมูลค่าเฉลี่ยน้ำมันรายวัน</a>
                                                </li>
                                                <!-- <li>
                                                    <a href="#tap_comp2" data-toggle="tab">ข้อมูลค่าเฉลี่ยน้ำมันรายสัปดาห์</a>
                                                </li>

                                                <li >
                                                    <a href="#tap_comp1" data-toggle="tab" >ข้อมูลค่าเฉลี่ยน้ำมันรายวัน/เดือน</a>
                                                </li> -->

                                            </ul>
                                            <div class="tab-content">
                                                <div class="row">
                                                    <div class="col-md-12">&nbsp;</div>
                                                </div>
                                                <!-- //////////////////////////ตรวจสอบข้อมูลน้ำมันรายวัน////////////////////////////// -->
                                                <div class="tab-pane fade active in" id="tap_comp3">

                                                      <br><br>
                                                        <div class="col-lg-6">
                                                            <label>วันที่เริ่มต้น :</label>
                                                            <input type="text" class="form-control dateen" onchange="datetodatedaychk()" id="txt_datestartdaychk" name="txt_datestartdaychk" autocomplete="off">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label>วันที่สิ้นสุด :</label>
                                                            <input type="text" class="form-control dateen" id="txt_dateenddaychk" name="txt_dateenddaychk" autocomplete="off">
                                                        </div>
                                                        <div class="col-lg-6">
                                                          <label><font style="color: red">*</font>เลือกตำแหน่ง</label>
                                                          <select id="select_position" name="select_position" class="form-control" >
                                                              <option value="">เลือกตำแหน่ง</option>
                                                              <option value="TGT">TGT</option>
                                                              <option value="KUBOTA">KUBOTA</option>
                                                              <option value="TTASTSTC">TTAST-STC</option>
                                                              <option value="TTASTCS">TTAST-CS</option>
                                                              <option value="STM">STM-IP</option>
                                                              <option value="TMTTAW">STM-SR/TAW</option>
                                                              <option value="DENSO-THAI">DENSO-THAI</option>
                                                          </select>
                                                        </div>
                                                        <!-- <div class="col-lg-6">
                                                            <label><font style="color: red">*</font>ลูกค้า :</label>
                                                            <div id="data_customerdef1">
                                                                <select id="select_cus1" name="select_cus1" class="form-control">

                                                                    <option value="">เลือกลูกค้า</option>

                                                                </select>
                                                            </div>
                                                            <div id="data_customersr1"></div>
                                                        </div> -->

                                                    <div class="row">&nbsp;</div>
                                                    <div class="row">&nbsp;</div>
                                                    <div class="row">
                                                        <div class="col-lg-12 text-right">
                                                            <button type="button" class="btn btn-primary" onclick="select_companyoilaveragedaychk()">EXCEL <i class="fa fa-file-excel-o"></i></button>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- //////////////////ข้อมูลค่าเฉลี่ยน้ำมันรายวัน////////////////////////////// -->
                                                <div class="tab-pane fade " id="tap_comp4">

                                                      <br><br>
                                                        <div class="col-lg-6">
                                                            <label>วันที่เริ่มต้น :</label>
                                                            <input type="text" class="form-control dateen" onchange="datetodateday()" id="txt_datestartday" name="txt_datestartday" autocomplete="off">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label>วันที่สิ้นสุด :</label>
                                                            <input type="text" class="form-control dateen" id="txt_dateendday" name="txt_dateendday" autocomplete="off">
                                                        </div>
                                                        <div class="col-lg-6">
                                                          <label><font style="color: red">*</font>เลือกตำแหน่ง</label>
                                                          <select id="select_position1" name="select_position1" class="form-control" >
                                                              <option value="">เลือกตำแหน่ง</option>
                                                              <option value="TGT">TGT</option>
                                                              <option value="KUBOTA">KUBOTA</option>
                                                              <option value="TTASTSTC">TTAST-STC</option>
                                                              <option value="TTASTCS">TTAST-CS</option>
                                                              <option value="STM">STM-IP</option>
                                                              <option value="TMTTAW">STM-SR/TAW</option>
                                                              <option value="DENSO-THAI">DENSO-THAI</option>
                                                              <option value="other">อื่นๆ</option>
                                                          </select>
                                                        </div>

                                                    <div class="row">&nbsp;</div>
                                                    <div class="row">&nbsp;</div>
                                                    <div class="row">
                                                        <div class="col-lg-12 text-right">
                                                            <button type="button" class="btn btn-primary" onclick="select_companyoilaverageday()">EXCELDAY <i class="fa fa-file-excel-o"></i></button>
                                                            <!-- <button type="button" class="btn btn-danger" onclick="clear_oilkm()">CLEAR_KM<i class="fa fa-recycle"></i></button> -->
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- //////////////////ข้อมูลค่าเฉลี่ยน้ำมันรายสัปดาห์////////////////////////////// -->
                                                <div class="tab-pane fad" id="tap_comp2">
                                                    <div class="row">

                                                        <div class="col-lg-6">
                                                            <label>วันที่เริ่มต้น :</label>
                                                            <input type="text" class="form-control dateenweek"  onchange="add_dateweek(this.value)"  id="txt_datestartweek" name="txt_datestartweek" autocomplete="off">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label>วันที่สิ้นสุด :</label>
                                                            <input type="text" class="form-control dateen" style="background-color: #f080802e"  disabled="" id="txt_dateendweek" name="txt_dateendweek" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="row">&nbsp;</div>
                                                    <div class="row">

                                                        <div class="col-lg-12 text-right">
                                                            <button type="button" class="btn btn-primary" onclick="select_companyoilaverageweek()">PDF <i class="fa fa-print"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- ////////////////////ข้อมูลค่าเฉลี่ยน้ำมันรายวัน/เดือน////////////////////// -->
                                                <div class="tab-pane fade " id="tap_comp1">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label>วันที่เริ่มต้น :</label>
                                                            <input type="text" class="form-control dateen" onchange="datetodate()" id="txt_datestart" name="txt_datestart" autocomplete="off">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label>วันที่สิ้นสุด :</label>
                                                            <input type="text" class="form-control dateen" id="txt_dateend" name="txt_dateend" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="row">&nbsp;</div>
                                                    <div class="row">

                                                        <div class="col-lg-12 text-right">
                                                            <button type="button" class="btn btn-primary" onclick="select_companyoilaverage()">PDF <i class="fa fa-print"></i></button>
                                                        </div>
                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel -->
                                </div>

                            </div>






                            <!-- /.panel -->
                        </div>


                        <div class="modal-footer">

                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        </div>

                    </div>
                </div>
            </div>
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

                        <h2 class="page-header"><i class="fa fa-truck"></i>
                            บริษัท

                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">

                                <?php
                                echo "บริษัท";
                                $link = "<a href='report_companyamata.php?type=report'>บริษัท</a>";
                                $_SESSION["link"] = $link;
                                ?>
                            </div>
                            <!-- /.panel-heading -->

                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>ชื่อบริษัท</th>

                                                <th style="text-align: center">ข้อมูลย่อย</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $condition2 = ($_GET['area'] == 'gateway') ? " AND Company_Code IN ('RRC','RATC','RCC')" : " AND Company_Code IN ('RKS','RKR','RKL','RTC','RTD','RIT')";


                                            $sql_seComp = "{call megCompany_v2(?,?)}";
                                            $params_seComp = array(
                                                array('select_company', SQLSRV_PARAM_IN),
                                                array($condition2, SQLSRV_PARAM_IN)
                                            );


                                            $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
                                            while ($result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC)) {
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td><?= $result_seComp['Company_NameT'] ?></td>
                                                    <td style="text-align: center"><div class="btn-group">
                                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <ul class="dropdown-menu slidedown" >
                                                                <li>
                                                                    <a href="#" data-toggle="modal" data-target="#modal_checkcompany" onclick="modal_companycompensation('<?= $result_seComp['Company_Code'] ?>')">
                                                                        ตรวจสอบรายงานเบิกน้ำมัน
                                                                    </a>
                                                                </li>
                                                                <li class="divider"></li>
                                                                <li>
                                                                    <a href="#" data-toggle="modal" data-target="#modal_datecompany" onclick="modal_companycompensation('<?= $result_seComp['Company_Code'] ?>')" >
                                                                        รายงานเบิกน้ำมัน
                                                                    </a>
                                                                </li>




                                                            </ul>
                                                        </div></td>



                                                </tr>

                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
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
        <script>
                                                                    function add_dateweek(datestart)
                                                                    {


                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_adddateweek", datestart: datestart
                                                                            },
                                                                            success: function (rs) {

                                                                                var res = rs.split("|");
                                                                                document.getElementById("txt_dateendweek").value = res[0];




                                                                            }
                                                                        });
                                                                    }
                                                                    function noWeekends(date) {
                                                                        var day = date.getDay();
                                                                        // ถ้าวันเป็นวันอาทิตย์ (0) หรือวันเสาร์ (6)
                                                                        if (day === 2 || day === 3 || day === 4 || day === 5 || day === 6 || day === 0) {

                                                                            // เลือกไม่ได้
                                                                            return [false, "", "วันนี้เป็นวันหยุด"];
                                                                        }
                                                                        // เลือกได้ตามปกติ
                                                                        return [true, "", ""];
                                                                    }
                                                                    $(function () {
                                                                        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                        // กรณีใช้แบบ input
                                                                        $(".dateenweek").datetimepicker({
                                                                            timepicker: false,
                                                                            format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                            lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                            beforeShowDay: noWeekends

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
                                                                    function select_checkcompanydate()
                                                                    {
                                                                        // alert(planid);

                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_checkcompanydate",
                                                                                companycode: document.getElementById('txt_companycode').value,
                                                                                datestart: document.getElementById('txt_datestart2').value,
                                                                                dateend: document.getElementById('txt_dateend2').value,
                                                                                customercode: document.getElementById('select_cus').value

                                                                            },
                                                                            success: function (response) {
                                                                                if (response) {

                                                                                    document.getElementById("datasr").innerHTML = response;
                                                                                    document.getElementById("datadef").innerHTML = "";

                                                                                }
                                                                                $(document).ready(function () {
                                                                                    $('#dataTables-example1').DataTable({
                                                                                        responsive: true
                                                                                    });
                                                                                });



                                                                            }
                                                                        });
                                                                    }
                                                                    function select_companyoilaverage()
                                                                    {
                                                                        var datestart = document.getElementById('txt_datestart').value;
                                                                        var dateend = document.getElementById('txt_dateend').value;
                                                                        var companycode = document.getElementById('txt_companycode').value;

                                                                        window.open('pdf_companyoilaverage.php?companycode=' + companycode + '&datestart=' + datestart + '&dateend=' + dateend, '_blank');
                                                                    }
                                                                    function select_companyoilaverageday()
                                                                    {

                                                                      clear_oilkm();
                                                                      var datestart = document.getElementById('txt_datestartday').value;
                                                                      var dateend = document.getElementById('txt_dateendday').value;
                                                                      var companycode = document.getElementById('txt_companycode').value;
                                                                      // var customercode = document.getElementById('select_cus11').value;
                                                                      var customercode = document.getElementById('select_position1').value;
                                                                      
                                                                    //   if(companycode == 'RKS'){
                                                                    //     if (customercode == 'TMTTAW') {
                                                                            
                                                                    //     }else{

                                                                    //     }
                                                                    //   }else{

                                                                    //   }
                                                                      window.open('excel_reportoilday_chk.php?companycode=' + companycode +'&customercode=' + customercode +'&datestart=' + datestart + '&dateend=' + dateend, '_blank');

                                                                      // alert(datestart);
                                                                      // alert(dateend);
                                                                      // alert(companycode);
                                                                      // alert(customercode);

                                                                    }
                                                                    function clear_oilkm(companycode)
                                                                    {

                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "clear_oilkm", companycode: companycode
                                                                            },
                                                                            success: function (rs) {
                                                                              // alert("เครียข้อมูลเรียบร้อย");
                                                                            }
                                                                        });


                                                                    }
                                                                    function select_companyoilaveragedaychk()
                                                                    {

                                                                        var datestart = document.getElementById('txt_datestartdaychk').value;
                                                                        var dateend = document.getElementById('txt_dateenddaychk').value;
                                                                        var companycode = document.getElementById('txt_companycode').value;
                                                                        var position = document.getElementById('select_position').value;

                                                                        if (companycode == 'RKS') {
                                                                          if (position =='TGT') {
                                                                              window.open('excel_reportoildaytgtchk.php?companycode=' + companycode +'&position=' + position +'&datestart=' + datestart + '&dateend=' + dateend, '_blank');
                                                                          }else if (position =='DENSO-THAI') {
                                                                              window.open('excel_reportoildaydenso_thaichk.php?companycode=' + companycode +'&position=' + position +'&datestart=' + datestart + '&dateend=' + dateend, '_blank');
                                                                          }else if (position =='STM') {
                                                                              window.open('excel_reportoildaystmchk.php?companycode=' + companycode +'&position=' + position +'&datestart=' + datestart + '&dateend=' + dateend, '_blank');
                                                                          }else if (position =='TMTTAW') {
                                                                              window.open('excel_reportoildaytmttawchk.php?companycode=' + companycode +'&position=' + position +'&datestart=' + datestart + '&dateend=' + dateend, '_blank');
                                                                          }else {

                                                                          }
                                                                        }else if (companycode == 'RKR') {
                                                                          if (position =='TTASTCS') {
                                                                              window.open('excel_reportoildayrkr_ttastcs_chk.php?companycode=' + companycode +'&position=' + position +'&datestart=' + datestart + '&dateend=' + dateend, '_blank');

                                                                          }else if (position =='TTASTSTC') {
                                                                              window.open('excel_reportoildayrkr_stc_chk.php?companycode=' + companycode +'&position=' + position +'&datestart=' + datestart + '&dateend=' + dateend, '_blank');
                                                                          }else {

                                                                          }

                                                                        }else if (companycode == 'RKL') {
                                                                          if (position =='TTASTCS') {
                                                                              window.open('excel_reportoildayrkl_ttastcs_chk.php?companycode=' + companycode +'&position=' + position +'&datestart=' + datestart + '&dateend=' + dateend, '_blank');
                                                                          }else if (position =='TTASTSTC') {
                                                                              window.open('excel_reportoildayrkl_stc_chk.php?companycode=' + companycode +'&position=' + position +'&datestart=' + datestart + '&dateend=' + dateend, '_blank');
                                                                          }else if (position =='KUBOTA') {
                                                                              window.open('excel_reportoildayrkl_skb_chk.php?companycode=' + companycode +'&position=' + position +'&datestart=' + datestart + '&dateend=' + dateend, '_blank');
                                                                          }else {

                                                                          }

                                                                        }else {

                                                                        }

                                                                    }

                                                                    function select_companyoilaverageweek()
                                                                    {
                                                                        var datestart = document.getElementById('txt_datestartweek').value;
                                                                        var dateend = document.getElementById('txt_dateendweek').value;
                                                                        var companycode = document.getElementById('txt_companycode').value;
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_adddateweek", datestart: datestart
                                                                            },
                                                                            success: function (rs) {

                                                                                var res = rs.split("|");
                                                                                window.open('pdf_companyoilaverageweek.php?companycode=' + companycode + '&datestart=' + datestart + '&dateend=' + dateend
                                                                                        + '&res1=' + res[1] + '&res2=' + res[2] + '&res3=' + res[3] + '&res4=' + res[4] + '&res5=' + res[5]
                                                                                        + '&res6=' + res[6] + '&res7=' + res[7], '_blank');


                                                                            }
                                                                        });






                                                                    }
                                                                    function datetodate()
                                                                    {
                                                                        document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                                                                    }
                                                                    function datetodatedaychk()
                                                                    {
                                                                        document.getElementById('txt_dateenddaychk').value = document.getElementById('txt_datestartdaychk').value;

                                                                    }
                                                                    function datetodateday()
                                                                    {
                                                                        document.getElementById('txt_dateendday').value = document.getElementById('txt_datestartday').value;

                                                                    }
                                                                    function datetodate2()
                                                                    {
                                                                        document.getElementById('txt_dateend2').value = document.getElementById('txt_datestart2').value;

                                                                    }
                                                                    function modal_companycompensation(companycode)
                                                                    {
                                                                        document.getElementById('txt_companycode').value = companycode;

                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_customeroilaverage", companycode: companycode
                                                                            },
                                                                            success: function (rs) {
                                                                                document.getElementById("data_customersr").innerHTML = rs;
                                                                                document.getElementById("data_customerdef").innerHTML = "";
                                                                                modal_customerdaychk(companycode);
                                                                                modal_customerday(companycode);
                                                                            }
                                                                        });


                                                                    }
                                                                    function modal_customerdaychk(companycode)
                                                                    {
                                                                        document.getElementById('txt_companycode').value = companycode;

                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_customeroildaychk", companycode: companycode
                                                                            },
                                                                            success: function (rs) {
                                                                                document.getElementById("data_customersr1").innerHTML = rs;
                                                                                document.getElementById("data_customerdef1").innerHTML = "";


                                                                            }
                                                                        });


                                                                    }
                                                                    function modal_customerday(companycode)
                                                                    {
                                                                        document.getElementById('txt_companycode').value = companycode;

                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_customeroilday", companycode: companycode
                                                                            },
                                                                            success: function (rs) {
                                                                                document.getElementById("data_customersr11").innerHTML = rs;
                                                                                document.getElementById("data_customerdef11").innerHTML = "";


                                                                            }
                                                                        });


                                                                    }
                                                                    function select_customer(companycode)
                                                                    {


                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_customercompensation", companycode:companycode
                                                                            },
                                                                            success: function (response) {
                                                                                if (response){

                                                                                  document.getElementById("datacompsr").innerHTML = response;
                                                                                  document.getElementById("datacompdef").innerHTML = "";

                                                                                }


                                                                            }
                                                                        });



                                                                    }
                                                                    $(document).ready(function () {
                                                                        $('#dataTables-example').DataTable({
                                                                            responsive: true
                                                                        });
                                                                    });
                                                                    $(document).ready(function () {
                                                                        $('#dataTables-example1').DataTable({
                                                                            responsive: true
                                                                        });
                                                                    });
        </script>


    </body>

</html>
<?php
sqlsrv_close($conn);
?>
