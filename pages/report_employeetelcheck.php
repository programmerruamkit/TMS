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
                            รายงานข้อมูล การใช้งานโทรศัพท์


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

                                     รายงานข้อมูล การใช้งานโทรศัพท์

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
                                                <h4><b>ข้อมูลการใช้งานโทรศัพท์ของพนักงานรายบุคคล</b></h4>
                                                <div class="row">

                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label>ค้นหาตามช่วงวันที่</label>
                                                        <input class="form-control dateen" readonly="" onchange="datetodate_person();" style="background-color: #f080802e"  id="txt_datestartperson" name="txt_datestartperson" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>&nbsp;</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateendperson" name="txt_dateendperson" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">
                                                    </div>
                                                </div>   
                                                <div class="col-lg-3">
                                                    <label>เลือกพนักงาน:</label>
                                                    <div class="dropdown bootstrap-select show-tick form-control">
                                                        <!-- $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', ""); -->
                                                        <select   id="txt_drivercode" name="txt_drivercode" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
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
                                                        <input class="form-control" style="display: none"   id="txt_copydiagramzone" name="txt_copydiagramzone" maxlength="500" value="" >
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
                                                            <label>พิมพ์ข้อมูล(EXCEL) &nbsp;<i class="fa fa-file-excel-o" aria-hidden="true"></i></label><br>   
                                                            <input type="button" onclick="excel_telcheckperson()" name="" id="" value="พิมพ์ข้อมูลโทรศัพท์(EXCEL)" class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2" style="text-align: left">
                                                        <div class="form-group">
                                                            <label>พิมพ์ข้อมูล(PDF) &nbsp;<i class="fa fa-file-pdf-o" aria-hidden="true"></i></label><br>   
                                                            <input type="button" onclick="pdf_telcheckperson()" name="" id="" value="พิมพ์ข้อมูลโทรศัพท์(PDF)" class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <h4><b>ข้อมูลการใช้งานโทรศัพท์ของพนักงานรายบริษัท</b></h4>
                                                <div class="row">

                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label>ค้นหาตามช่วงวันที่</label>
                                                            <input class="form-control dateen" readonly="" onchange="datetodate_company();" style="background-color: #f080802e"  id="txt_datestartcompany" name="txt_datestartcompany" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateendcompany" name="txt_dateendcompany" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">
                                                        </div>
                                                    </div> 
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>เลือกบริษัท</label><br>   
                                                            <select id="select_com" name="select_com" class="form-control" onchange="select_customer(this.value)">
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




                                                    <div class="col-lg-2" style="text-align: left">
                                                        <div class="form-group">
                                                            <label style="font-size: 13px;">พิมพ์ข้อมูลรายบริษัท(EXCEL) &nbsp;<i class="fa fa-file-excel-o" aria-hidden="true"></i></label><br>   
                                                            <input type="button" onclick="excel_telcheckcompany()" name="" id="" value="พิมพ์ข้อมูลรายบริษัท(EXCEL)" class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2" style="text-align: left">
                                                        <div class="form-group">
                                                            <label>พิมพ์ข้อมูลรายบริษัท(PDF) &nbsp;<i class="fa fa-file-pdf-o" aria-hidden="true"></i></label><br>   
                                                            <input type="button" onclick="pdf_telcheckcompany()" name="" id="" value="พิมพ์ข้อมูลรายบริษัท(PDF)" class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="row" >
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <h4><b>ข้อมูลใบขับขี่ของพนักงาน(แยกตามตำแหน่งของพนักงาน)</b></h4>
                                                <div class="row">

                                                    
                                                <div class="col-lg-3">
                                                    <label>เลือกตำแหน่งพนักงาน:</label>
                                                    <div class="dropdown bootstrap-select show-tick form-control">
                                                       
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
                                                




                                                    <div class="col-lg-2" style="text-align: left">
                                                        <div class="form-group">
                                                            <label>พิมพ์ข้อมูลใบขับขี่(EXCEL) &nbsp;<i class="fa fa-file-excel-o" aria-hidden="true"></i></label><br>   
                                                            <input type="button" onclick="excel_carlicenseposition()" name="" id="" value="พิมพ์ข้อมูลใบขับขี่(EXCEL)" class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2" style="text-align: left">
                                                        <div class="form-group">
                                                            <label>พิมพ์ข้อมูลใบขับขี่(PDF) &nbsp;<i class="fa fa-file-pdf-o" aria-hidden="true"></i></label><br>   
                                                            <input type="button" onclick="pdf_carlicenseposition()" name="" id="" value="พิมพ์ข้อมูลใบขับขี่(PDF)" class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  -->
                                    
                                </div>




                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                </div>
                <!-- /.row -->

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
            <script>

                                                            function select_reporttransportplanstc()
                                                            {


                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;

                                                                // alert(datestart);
                                                                // alert(dateend);
                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "select_reporttransportplanstc", datestart: datestart, dateend: dateend
                                                                    },
                                                                    success: function (response) {
                                                                        if (response)
                                                                        {
                                                                            document.getElementById("datasr").innerHTML = response;
                                                                            document.getElementById("datadef").innerHTML = "";
                                                                        }
                                                                        $(document).ready(function () {
                                                                            $('#dataTables-example').DataTable({
                                                                                responsive: true,
                                                                            });
                                                                        });



                                                                    }
                                                                });


                                                            }
                                                            function excel_telcheckperson()
                                                            {
                                                                var drivercode      = document.getElementById('txt_drivercode').value;
                                                                var datestartperson = document.getElementById('txt_datestartperson').value;
                                                                var dateendperson   = document.getElementById('txt_dateendperson').value;

                                                                if (drivercode == '') {
                                                                    alert('กรุณาเลือกชื่อพนักงาน');
                                                                }else{
                                                                    window.open('excel_employeetelcheckperson.php?drivercode=' + drivercode + '&datestartperson=' + datestartperson+ '&dateendperson=' + dateendperson, '_blank');
                                                                }
                                                                // alert(drivercode);
                                                                // alert(dateend);
                                                                

                                                            }
                                                            function pdf_telcheckperson()
                                                            {
                                                                var drivercode = document.getElementById('txt_drivercode').value;
                                                                var datestartperson = document.getElementById('txt_datestartperson').value;
                                                                var dateendperson   = document.getElementById('txt_dateendperson').value;

                                                                if (drivercode == '') {
                                                                    alert('กรุณาเลือกชื่อพนักงาน');
                                                                }else{
                                                                    window.open('pdf_employeetelcheckperson.php?drivercode=' + drivercode + '&datestartperson=' + datestartperson+ '&dateendperson=' + dateendperson, '_blank');
                                                                }
                                                                // alert(drivercode);
                                                                // alert(dateend);
                                                                

                                                            }
                                                            
                                                            function excel_telcheckcompany()
                                                            {
                                                                var companycode = document.getElementById('select_com').value; 
                                                                var datestartcompany = document.getElementById('txt_datestartcompany').value;
                                                                var dateendcompany   = document.getElementById('txt_dateendcompany').value;
                                                                // alert(drivercode);
                                                                // alert(dateend);
                                                                if (companycode == '' || companycode == '00') {
                                                                    alert('กรุณาเลือกบริษัท');
                                                                }else{
                                                                    window.open('excel_employeetelcheckcompany.php?companycode=' + companycode + '&datestartcompany=' + datestartcompany+ '&dateendcompany=' + dateendcompany, '_blank');
                                                                }
                                                                

                                                            }
                                                            function pdf_telcheckcompany()
                                                            {
                                                                var companycode = document.getElementById('select_com').value;
                                                                var datestartcompany = document.getElementById('txt_datestartcompany').value;
                                                                var dateendcompany   = document.getElementById('txt_dateendcompany').value;
                                                                // alert(drivercode);
                                                                // alert(dateend);
                                                                if (companycode == '' || companycode == '00') {
                                                                    alert('กรุณาเลือกบริษัท');
                                                                }else{
                                                                    window.open('pdf_employeetelcheckcompany.php?companycode=' + companycode + '&datestartcompany=' + datestartcompany+ '&dateendcompany=' + dateendcompany, '_blank');
                                                                }
                                                                

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

                                                            function datetodate_person()
                                                                {
                                                                    document.getElementById('txt_dateendperson').value = document.getElementById('txt_datestartperson').value;
                                                                }

                                                            function datetodate_company()
                                                                {
                                                                    document.getElementById('txt_dateendperson').value = document.getElementById('txt_datestartperson').value;
                                                                }
                                                            // function excel_carlicenseposition()
                                                            // {
                                                            //     var position = document.getElementById('txt_position').value;
                                                                
                                                            //     // alert(position);
                                                            //     if (position == '') {
                                                            //         alert('กรุณาเลือกตำแหน่งพนักงาน');
                                                            //     }else{
                                                            //         window.open('excel_employeecarlicenseposition.php?position=' + position, '_blank');
                                                            //     }
                                                            //     // alert(drivercode);
                                                            //     // alert(dateend);
                                                                

                                                            // }
                                                            // function pdf_carlicenseposition()
                                                            // {
                                                            //     var position = document.getElementById('txt_position').value;
                                                            //     // alert(position);
                                                            //     if (position == '') {
                                                            //         alert('กรุณาเลือกตำแหน่งพนักงาน');
                                                            //     }else{
                                                            //         window.open('pdf_employeecarlicenseposition.php?position=' + position, '_blank');
                                                            //     }
                                                            //     // alert(drivercode);
                                                            //     // alert(dateend);
                                                                

                                                            // }

            </script>


    </body>

</html>

<?php
sqlsrv_close($conn);
?>
