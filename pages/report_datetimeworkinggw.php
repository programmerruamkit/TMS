
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

// $condiCompany = " AND Company_Code = '" . $_GET['companycode'] . "'";
// $sql_seCompany = "{call megCompany_v2(?,?)}";
// $params_seCompany = array(
//     array('select_company', SQLSRV_PARAM_IN),
//     array($condiCompany, SQLSRV_PARAM_IN)
// );
// $query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
// $result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);

// $condiCustomer = " AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
// $sql_seCustomer = "{call megCustomer_v2(?,?)}";
// $params_seCustomer = array(
//     array('select_customer', SQLSRV_PARAM_IN),
//     array($condiCustomer, SQLSRV_PARAM_IN)
// );
// $query_seCustomer = sqlsrv_query($conn, $sql_seCustomer, $params_seCustomer);
// $result_seCustomer = sqlsrv_fetch_array($query_seCustomer, SQLSRV_FETCH_ASSOC);
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
                            รายงานเวลาปฏิบัติงาน (GW)


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

                                        รายงานเวลาปฏิบัติงาน (GW)

                                    </div>
                                    <div class="col-lg-6 text-right"></div>
                                </div>
                            </div>
                    
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <div class="row">&nbsp;</div>
                                    <div class="row" >
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">


                                                    <div class="col-lg-2">

                                                        <div class="form-group">
                                                            <label>ค้นหาตามช่วงวันที่</label>
                                                            <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-2">

                                                        <div class="form-group">
                                                            <label>ค้นหาตามช่วงวันที่</label>
                                                            <input class="form-control dateen" readonly=""  style="background-color: #f080802e"  id="txt_dateend" name="txt_dateend" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                        </div>

                                                    </div>

                                                    <!-- <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                                                        </div>
                                                    </div> -->
                                                    <div class="col-lg-2">
                                                      <label>เลือกบริษัท</label>
                                                      <select id="txt_companycode" name="txt_companycode" class="form-control" >
                                                          <option value="">เลือกบริษัท</option>
                                                          <option value="04">บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                                          <option value="05">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์</option>
                                                          <option value="09">บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</option>
                                                          <option value="00">ทั้งหมด</option>

                                                      </select>
                                                    </div>
                                                    <!-- <div class="col-lg-2">
                                                      <label>เลือกช่วงเวลา</label>
                                                      <select id="txt_workingrange" name="txt_workingrange" class="form-control" >
                                                          <option value="00">ทั้งหมด</option>
                                                          <option value="<=14">น้อยกว่าหรือเท่ากับ 14</option>
                                                          <option value=">14">มากกว่า14</option>
                                                    
                                                      </select>
                                                    </div> -->
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_datetimeworkinggw();">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-4" style="text-align: left">
                                                        <label><font color="red">รายงานไม่ต้องกดค้นหา เลือกวันที่,บริษัท และกดพิมพ์รายงาน</font></label>
                                                        <a href="#" onclick="excel_datetimeworkinggw();" class="btn btn-default">พิมพ์รายงานข้อมูลปฎิบัติงาน <li class="fa fa-print"></li></a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                    รายงานเวลาปฏิบัติงาน (GW)
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ลำดับ</th>
                                                                        <th>รหัสแจ้งสุขภาพ</th>
                                                                        <th>รหัสพนักงาน</th>
                                                                        <th>ชื่อ-นามสกุล</th>
                                                                        <th>ต้นทาง</th>
                                                                        <th>ปลายทาง</th>
                                                                        <!-- <th>ต้นทาง(แผนสอง)</th>
                                                                        <th>ปลายทาง(แผนสอง)</th> -->
                                                                        <th>วันที่</th>
                                                                        <th>เวลาเริ่มงาน</th>
                                                                        <th>เวลาเลิกงาน</th>
                                                                        <th>รวมเวลาปฎิบัติงาน</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>


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
                                </div>




                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                </div>
                <!-- /.row -->

                <!-- ////////////////////////////////////////////// -->
                <!-- รายงานเวลาปฎิบัติงานเกิน 14 ชั่วโมง -->
                <div class="row" >
                    <div class="col-lg-12">

                        <h2 class="page-header"><i class="fa fa-file-text-o"></i>
                            รายงานเวลาปฏิบัติงานเกิน 14 ชั่วโมง (GW)


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

                                        รายงานเวลาปฏิบัติงานเกิน 14 ชั่วโมง (GW)

                                    </div>
                                    <div class="col-lg-6 text-right"></div>
                                </div>
                            </div>
                    
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <div class="row">&nbsp;</div>
                                    <div class="row" >
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">


                                                    <div class="col-lg-2">

                                                        <div class="form-group">
                                                            <label>ค้นหาตามช่วงวันที่</label>
                                                            <input class="form-control dateengrater14" readonly=""  style="background-color: #f080802e"  id="txt_datestartgrater14" name="txt_datestartgrater14" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                        </div>

                                                    </div>

                                                    <!-- <div class="col-lg-2">

                                                        <div class="form-group">
                                                            <label>ค้นหาตามช่วงวันที่</label>
                                                            <input class="form-control dateen" readonly=""  style="background-color: #f080802e"  id="txt_dateend" name="txt_dateend" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น" disabled="">
                                                        </div>

                                                    </div> -->

                                                    <!-- <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                                                        </div>
                                                    </div> -->
                                                    <div class="col-lg-3">
                                                        <label>เลือกพนักงาน:</label>
                                                        <div class="dropdown bootstrap-select show-tick form-control">
                                                            <!-- $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', ""); -->
                                                            <select   id="txt_drivernamegrater14" name="txt_drivernamegrater14" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
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
                                                                    <option value="<?= $result_seName['PersonCode'] ?>"><?= $result_seName['nameT'] ?> (<?= $result_seName['PersonCode'] ?>)</option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-lg-2">
                                                      <label>เลือกช่วงเวลา</label>
                                                      <select id="txt_workingrange" name="txt_workingrange" class="form-control" >
                                                          <option value="00">ทั้งหมด</option>
                                                          <option value="<=14">น้อยกว่าหรือเท่ากับ 14</option>
                                                          <option value=">14">มากกว่า14</option>
                                                    
                                                      </select>
                                                    </div> -->
                                                    <div class="col-lg-3">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_workinggrater14hour();">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-4" style="text-align: left">
                                                        <label><font color="red">รายงานไม่ต้องกดค้นหา เลือกวันที่,พนักงาน และกดพิมพ์รายงาน</font></label>
                                                        <a href="#" onclick="excel_workinggrater14hour();" class="btn btn-default">พิมพ์รายงานข้อมูลปฎิบัติงานเกิน 14 ชั่วโมง <li class="fa fa-print"></li></a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                    รายงานเวลาปฏิบัติงานเกิน 14 ชั่วโมง (GW)
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadefgrater14">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example3" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ลำดับ</th>
                                                                        <th>รหัสแจ้งสุขภาพ</th>
                                                                        <th>รหัสพนักงาน</th>
                                                                        <th>ชื่อ-นามสกุล</th>
                                                                        <th>ต้นทาง</th>
                                                                        <th>ปลายทาง</th>
                                                                        <!-- <th>ต้นทาง(แผนสอง)</th>
                                                                        <th>ปลายทาง(แผนสอง)</th> -->
                                                                        <th>วันที่</th>
                                                                        <th>เวลาเริ่มงาน</th>
                                                                        <th>เวลาเลิกงาน</th>
                                                                        <th>รวมเวลาปฎิบัติงาน</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>


                                                                </tbody>

                                                            </table>

                                                        </div>
                                                        <div id="datasrgrater14"></div>
                                                    </div>


                                                    <!-- /.panel-body -->
                                                </div>
                                                <!-- /.panel -->
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
                <!-- /.row -->


            </div>
            <!-- div wrapper -->



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
            <script>

                                                            
                                                            // select_reporttransportplangw
                                                            function select_datetimeworkinggw()
                                                            {


                                                              
                                                                var startdate = document.getElementById('txt_datestart').value;
                                                                var enddate = document.getElementById('txt_dateend').value;
                                                                var companycode = document.getElementById('txt_companycode').value;
                                                                var area = "gw";
                                                                
                                                                // รูปแบบ เดือน/วัน/ปี
                                                                // วันที่เริ่มต้น
                                                                let textdatestart = startdate;
                                                                //วัน
                                                                let resultstart1 = textdatestart.substring(0,2);
                                                                // เดือน
                                                                let resultstart2 = textdatestart.substring(3,5);
                                                                // ปี
                                                                let resultstart3 = textdatestart.substring(6,10);

                                                                var date1 = new Date(resultstart2+"/"+resultstart1+"/"+resultstart3);

                                                                ///////////////////////////////////////
                                                                // รูปแบบ เดือน/วัน/ปี
                                                                // วันที่สิ้นสุด
                                                                let textdateend = enddate;
                                                                //วัน
                                                                let resultend1 = textdateend.substring(0,2);
                                                                // เดือน
                                                                let resultend2 = textdateend.substring(3,5);
                                                                // ปี
                                                                let resultend3 = textdateend.substring(6,10);

                                                                var date2 = new Date(resultend2+"/"+resultend1+"/"+resultend3);
                                                                ///////////////////////////////////////

                                                                // var date1 = new Date("01/21/2022");
                                                                // var date2 = new Date("01/31/2022");

                                                                var diffTime = date2.getTime() - date1.getTime();
                                                                var diffDay = diffTime / (1000 * 3600 * 24);
                                                                // var workingrange = document.getElementById('txt_workingrange').value; 
                                                                
                                                                // alert(startdate);
                                                                // alert(enddate);
                                                                // alert(companycode);
                                                                // alert(area);

                                                                 // alert(workingrange);

                                                                 if (companycode == '') {
                                                                    alert('กรุณาเลือกบริษัทที่ต้องการดึงข้อมูล!!!');
                                                                }else if (diffDay >= "5") {
                                                                    alert('เพื่อไม่กระทบกับการทำงานของระบบโดยรวม\nไม่อนุญาตให้ดึงข้อมูลในตารางข้อมูลเกิน 5 วัน\nแต่ยังสามารถพิพม์รายงานเกิน 5 วันได้ตามปกติ');
                                                                }else{

                                                               
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data2.php',
                                                                            data: {
                                                                                txt_flg: "select_datetimeworking", startdate: startdate,enddate: enddate,companycode: companycode,area:area
                                                                            },
                                                                            success: function (response) {

                                                                                if (response)
                                                                                {
                                                                                    alert('โหลดข้อมูลเรียบร้อยแล้ว!!!');
                                                                                    document.getElementById("datasr").innerHTML = response;
                                                                                    document.getElementById("datadef").innerHTML = "";

                                                                                    // document.getElementById("txt_plan").value = document.getElementById("se_plan").value;
                                                                                    // document.getElementById("txt_driver1").value = document.getElementById("se_driver1").value;
                                                                                    // document.getElementById("txt_driver2").value = document.getElementById("se_driver2").value;
                                                                                }
                                                                                $(document).ready(function () {
                                                                                    $('#dataTables-example1').DataTable({
                                                                                        responsive: true,
                                                                                    });
                                                                                });



                                                                            }
                                                                        });
                                                                 }

                                                            }
                                                            function excel_datetimeworkinggw()
                                                            {
                                                                var startdate = document.getElementById('txt_datestart').value;
                                                                var enddate = document.getElementById('txt_dateend').value;
                                                                var companycode = document.getElementById('txt_companycode').value;

                                                                // alert(startdate);
                                                                // alert(enddate);
                                                                // alert(companycode);

                                                                window.open('excel_reportdatetimeworkinggw.php?startdate=' + startdate +  '&enddate=' + enddate + '&companycode=' + companycode, '_blank');

                                                            }
                                                            
                                                            function datetodate()
                                                            {
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

                                                            $(document).ready(function () {
                                                                $('#dataTables-example').DataTable({
                                                                    responsive: true,
                                                                    
                                                                });
                                                            });
                                                            

                                                            // SCRIPT สำหรับ DIV รายงานเวลาปฎิบัติงานเกิน 14 ชั่วโมง
                                                         
                                                            function select_workinggrater14hour()
                                                            {


                                                              
                                                                var startdate = document.getElementById('txt_datestartgrater14').value;
                                                                // var enddate = document.getElementById('txt_dateend').value;
                                                                var drivercode = document.getElementById('txt_drivernamegrater14').value;

                                                                // var workingrange = document.getElementById('txt_workingrange').value; 
                                                                
                                                                // alert(startdate);
                                                                // alert(enddate);
                                                                // alert(companycode);
                                                                // alert(area);
                                                                
                                                                // alert(workingrange);

                                                                if (drivercode == '') {
                                                                    alert('ชื่อพนักงานเป็นค่าว่าง กรุณาเลือกพนักงาน!!!');
                                                                }else{

                                                               
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data2.php',
                                                                            data: {
                                                                                txt_flg: "select_dateworkinggrater14hour", startdate: startdate,drivercode: drivercode
                                                                            },
                                                                            success: function (response) {

                                                                                if (response)
                                                                                {
                                                                                    alert('โหลดข้อมูลเรียบร้อยแล้ว!!!');
                                                                                    document.getElementById("datasrgrater14").innerHTML = response;
                                                                                    document.getElementById("datadefgrater14").innerHTML = "";

                                                                                    // document.getElementById("txt_plan").value = document.getElementById("se_plan").value;
                                                                                    // document.getElementById("txt_driver1").value = document.getElementById("se_driver1").value;
                                                                                    // document.getElementById("txt_driver2").value = document.getElementById("se_driver2").value;
                                                                                }
                                                                                $(document).ready(function () {
                                                                                    $('#dataTables-example2').DataTable({
                                                                                        responsive: true,
                                                                                    });
                                                                                });



                                                                            }
                                                                        });
                                                                 }

                                                            }
                                                            function excel_workinggrater14hour()
                                                            {
                                                                var startdate = document.getElementById('txt_datestartgrater14').value;
                                                                var drivercode = document.getElementById('txt_drivernamegrater14').value;

                                                                // alert(startdate);
                                                                // alert(enddate);
                                                                // alert(companycode);
                                                                if (drivercode == '') {
                                                                    alert('ชื่อพนักงานเป็นค่าว่าง กรุณาเลือกพนักงาน!!!');
                                                                }else{
                                                                window.open('pdf_workinggrater14hour.php?startdate=' + startdate +'&drivercode=' + drivercode, '_blank');
                                                                }
                                                            }
                                                            
                                                            // function datetodategrater14()
                                                            // {
                                                            //     document.getElementById('txt_dateendgrater14').value = document.getElementById('txt_datestartgrater14').value;

                                                            // }
                                                            $(function () {
                                                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                // กรณีใช้แบบ input
                                                                $(".dateengrater14").datetimepicker({
                                                                    timepicker: false,
                                                                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                                });
                                                            });

                                                            $(document).ready(function () {
                                                                $('#dataTables-example3').DataTable({
                                                                    responsive: true,
                                                                    
                                                                });
                                                            });


                                                    
            </script>


    </body>

</html>

<?php
// session_destroy();
sqlsrv_close($conn);
?>
