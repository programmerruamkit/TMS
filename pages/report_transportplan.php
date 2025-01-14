
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
$sql_seLogin = "{call megRoleaccount_v2(?,?)}";
$params_seLogin = array(
    array('select_roleaccount', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
$result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$condiCompany = " AND Company_Code = '" . $_GET['companycode'] . "'";
$sql_seCompany = "{call megCompany_v2(?,?)}";
$params_seCompany = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condiCompany, SQLSRV_PARAM_IN)
);
$query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
$result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);

$condiCustomer = " AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
$sql_seCustomer = "{call megCustomer_v2(?,?)}";
$params_seCustomer = array(
    array('select_customer', SQLSRV_PARAM_IN),
    array($condiCustomer, SQLSRV_PARAM_IN)
);
$query_seCustomer = sqlsrv_query($conn, $sql_seCustomer, $params_seCustomer);
$result_seCustomer = sqlsrv_fetch_array($query_seCustomer, SQLSRV_FETCH_ASSOC);
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
        <form method="post" enctype="multipart/form-data">
            <div class="modal fade" id="modal_selectline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 40%">
                    <div class="modal-content" >
                        <div class="modal-header">
                            <h5 class="modal-title" id="title"><b>ส่งแผนงานขนส่ง</b></h5>
                        </div>
                        <div class="modal-body">


                            <div class="row">
                                <div class="col-md-2" >พนักงาน/สายงาน :</div>
                                <div class="col-md-10" ><select id="cb_token" name="cb_token" class="form-control"  title="เลือก พนักงาน/สายงาน..." >
                                        <option value="">เลือกพนักงาน/สายงาน</option>
                                        <?php
                                        $sql_seLinesendplan = "{call megLinesendplan_v2(?,?,?,?)}";
                                        $params_seLinesendplan = array(
                                            array('select_linesendplan', SQLSRV_PARAM_IN),
                                            array('', SQLSRV_PARAM_IN),
                                            array('', SQLSRV_PARAM_IN),
                                            array('', SQLSRV_PARAM_IN)
                                        );
                                        $query_seLinesendplan = sqlsrv_query($conn, $sql_seLinesendplan, $params_seLinesendplan);
                                        while ($result_seLinesendplan = sqlsrv_fetch_array($query_seLinesendplan, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?= $result_seLinesendplan['TOKEN'] ?>"><?= $result_seLinesendplan['NAME'] ?></option>
                                            <?php
                                        }
                                        ?>


                                    </select>
                                </div>
                            </div>
                            <div class="row">&nbsp;</div>
                            <div class="row">
                                <div class="col-md-2" >ข้อความ :</div>
                                <div class="col-md-10" ><textarea class="form-control" autocomplete="off" rows="3" id="txt_message" name="txt_message"></textarea></div>
                            </div>
                            <div class="row">&nbsp;</div>
                            <div class="row">
                                <div class="col-md-2" >ไฟล์รูปภาพ :</div>
                                <div class="col-md-10" ><input type="file" id="fileToUpload" name="fileToUpload" class="form-control"></div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-success" id="submit" name="submit" value="@LINE">
                        </div>
                    </div>

                </div>
            </div>
        </form>
        <?php
        $target_dir = "images/img_transportplan.jpg";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_dir, PATHINFO_EXTENSION));

        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {

                $uploadOk = 1;
            } else {

                $uploadOk = 0;
            }
        }
        if ($uploadOk == 0) {
            
        } else {
            @unlink("img_transportplan/line.jpg");
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir)) {

                $line_api = 'https://notify-api.line.me/api/notify';
                $imageFile = curl_file_create('D:/www/tms-dev/pages/images/img_transportplan.jpg', 'image/jpg', 'img_transportplan.jpg');

                $rs_message = ($_POST['txt_message'] == '') ? 'แผนงานการขนส่ง' : $_POST['txt_message'];

                $message_data = array(
                    'message' => $rs_message,
                    'imageFile' => $imageFile
                );

                $headers = array('Method: POST', 'Content-type: multipart/form-data', 'Authorization: Bearer ' . $_POST['cb_token']);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $line_api);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $message_data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($ch);

                if (curl_error($ch)) {
                    $return_array = array('status' => '000: send fail', 'message' => curl_error($ch));
                } else {
                    $return_array = json_decode($result, true);
                }
                curl_close($ch);
            } else {
                
            }
        }
        ?>
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
                            รายงานแผนการขนส่ง


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
                                        <?php
                                        $meg = 'รายงานแผนขนส่ง';
                                        echo "<a href='report_companyreport.php'>บริษัท</a> / <a href='report_customerreport.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a>  / " . $meg;
                                        $link = "<a href='report_companyreport.php?type=report'>บริษัท</a> / <a href='report_customerreport.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a> ";
                                        $_SESSION["link"] = $link;
                                        ?>
                                    </div>
                                    <div class="col-lg-6 text-right"><?= $result_seCompany['Company_NameT'] ?> / <?= $result_seCustomer['NAMETH'] ?></div>
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
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_reporttransportplan();">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>

                                                    </div>




                                                    <?php
                                                    if ($_GET['companycode'] == 'RKL' && $_GET['customercode'] == 'SKB') {
                                                    ?>
                                                        <div class="col-lg-2" style="text-align: left">
                                                            <div class="form-group">
                                                                <label>เลือกประเภทรถ</label><br>   
                                                                <select   id="txt_vehicletypeskb" name="txt_vehicletypeskb" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ประเภทรถ..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                    <option value =""  selected >- เลือกประเภทรถ -</option>
                                                                    <option value ="ADC-Dealer(SL2)">ADC-Dealer(SL2)</option>
                                                                    <option value ="ADC-Dealer(FB)">ADC-Dealer(FB)</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4" style="text-align: right">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="excel_reporttransportpaln_newskb();" class="btn btn-default">พิมพ์(แบบใหม่) <li class="fa fa-print"></li></a>
                                                            <a href="#" onclick="excel_reporttransportpaln();" class="btn btn-default">พิมพ์(แบบเดิม) <li class="fa fa-print"></li></a>
                                                            <!--<a href="#" onclick="exportplan();" class="btn btn-default">JPG <li class="fa fa-image"></li></a>-->
                                                            <a href="#" onclick="exportplan();" data-toggle="modal"  data-target="#modal_selectline" class="btn btn-success"><b>@LINE</b></a>
                                                            <!--<a href="#" class="btn btn-success"  onclick="PopupCenter('meg_exporttransportplan.php', 'ส่งแผนงานขนส่ง', '1000', '500')"><b>@LINE</b></a>-->
                                                        </div>
                                                    <?php
                                                    }else{
                                                    ?>
                                                            <div class="col-lg-4" style="text-align: right">
                                                                <label>&nbsp;</label><br>
                                                                <a href="#" onclick="excel_reporttransportpaln();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>
                                                                <!--<a href="#" onclick="exportplan();" class="btn btn-default">JPG <li class="fa fa-image"></li></a>-->
                                                                <a href="#" onclick="exportplan();" data-toggle="modal"  data-target="#modal_selectline" class="btn btn-success"><b>@LINE</b></a>
                                                                <!--<a href="#" class="btn btn-success"  onclick="PopupCenter('meg_exporttransportplan.php', 'ส่งแผนงานขนส่ง', '1000', '500')"><b>@LINE</b></a>-->
                                                            </div>
                                                    <?php    
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                    รายงานแผนการขนส่ง
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>

                                                                        <th>NO</th>
                                                                        <th>JOBNO</th>
                                                                        <th>VEHICLE</th>
                                                                        <th>DRIVER(1)</th>
                                                                        <th>DRIVER(2)</th>
                                                                        <th>TIME</th>
                                                                        <th>FROM</th>
                                                                        <th>TO</th>
                                                                        <!-- <th>REMARK</th> -->

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $i = 1;

                                                                    $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103)";
                                                                    $condiReporttransport2 = " AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                                                    $condiReporttransport3 = "";
                                                                    if ($_GET['companycode'] == 'RKS' || $_GET['companycode'] == 'RKL' || $_GET['companycode'] == 'RKR') {
                                                                        $sql_seReporttransport = "{call megVehicletransportplan_v2(?,?,?,?)}";
                                                                        $params_seReporttransport = array(
                                                                            array('select_reportvehicletransportplan', SQLSRV_PARAM_IN),
                                                                            array($condiReporttransport1, SQLSRV_PARAM_IN),
                                                                            array($condiReporttransport2, SQLSRV_PARAM_IN),
                                                                            array($condiReporttransport3, SQLSRV_PARAM_IN)
                                                                        );
                                                                    } else {


                                                                        $sql_seReporttransport = "{call megVehicletransportplan_v2(?,?,?,?)}";
                                                                        $params_seReporttransport = array(
                                                                            array('select_reportvehicletransportplangateway', SQLSRV_PARAM_IN),
                                                                            array($condiReporttransport1, SQLSRV_PARAM_IN),
                                                                            array($condiReporttransport2, SQLSRV_PARAM_IN),
                                                                            array($condiReporttransport3, SQLSRV_PARAM_IN)
                                                                        );
                                                                    }
                                                                    $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
                                                                    while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {

                                                                            // if ($result_seReporttransport['STATUSNUMBER'] == 'X') {
                                                                            //     $remark = 'แผนงานตัดงาน';
                                                                            // }else if($result_seReporttransport['DOCUMENTCODE'] == '' || $result_seReporttransport['DOCUMENTCODE'] == 'NULL' ) {
                                                                            //     $remark = 'แผนงานยังไม่คีย์ค่าตอบแทน';
                                                                            // }else {
                                                                            //     $remark= '';
                                                                            // }
                                                                        
                                                                        ?>

                                                                        <tr>

                                                                            <td style="text-align: center"><?= $i ?></td>
                                                                            <td><?= $result_seReporttransport['BOOKNO'] ?></td>
                                                                            <td><?= $result_seReporttransport['VEHICLENO'] ?></td>
                                                                            <td><?= $result_seReporttransport['DRIVER(1)'] ?></td>
                                                                            <td><?= $result_seReporttransport['DRIVER(2)'] ?></td>
                                                                            <td><?= $result_seReporttransport['JOBTIME'] ?></td>
                                                                            <td><?= $result_seReporttransport['FROM'] ?></td>
                                                                            <td><?= $result_seReporttransport['TO'] ?></td>
                                                                            <!-- <td><?= $remark ?></td> -->



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
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
            <script>
                function save_logprocess(category, process, employeecode)
                                            {
                                                $.ajax({
                                                    url: 'meg_data.php',
                                                    type: 'POST',
                                                    data: {
                                                        txt_flg: "save_logprocess", category: category, process: process, employeecode: employeecode
                                                    },
                                                    success: function () {


                                                    }
                                                });
                                            }
                                                            function PopupCenter(url, title, w, h) {
                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                // Fixes dual-screen position                         Most browsers      Firefox
                                                                var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
                                                                var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

                                                                var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
                                                                var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

                                                                var systemZoom = width / window.screen.availWidth;
                                                                var left = (width - w) / 2 / systemZoom + dualScreenLeft
                                                                var top = (height - h) / 2 / systemZoom + dualScreenTop
                                                                var newWindow = window.open(url + '?datestart=' + datestart + '&dateend=' + dateend + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', title, 'scrollbars=yes, width=' + w / systemZoom + ', height=' + h / systemZoom + ', top=' + top + ', left=' + left);

                                                                // Puts focus on the newWindow
                                                                if (window.focus)
                                                                    newWindow.focus();
                                                            }
                                                            function linesendplan()
                                                            {
                                                                if (document.getElementById('cb_token').value != '')
                                                                {


                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data.php',
                                                                        data: {
                                                                            txt_flg: "send_linesendplan", token: document.getElementById('cb_token').value, message: document.getElementById('txt_message').value
                                                                        },
                                                                        success: function () {

                                                                            //window.location.reload();
                                                                        }
                                                                    });
                                                                } else
                                                                {
                                                                    alert("กรุณาเลือก พนักงาน/สายงาน");
                                                                }

                                                            }
                                                            function select_reporttransportplan()
                                                            {
                                                                save_logprocess('Report', 'Select รายงานแผนการขนส่ง(AMT)', '<?= $result_seLogin['PersonCode'] ?>');

                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;

                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "select_reporttransportplan", datestart: datestart, dateend: dateend, companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>'
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
                                                                //}

                                                            }
                                                            function excel_reporttransportpaln_newskb()
                                                            {
                                                                save_logprocess('Report', 'Excel รายงานแผนการขนส่ง(AMT)', '<?= $result_seLogin['PersonCode'] ?>');
                                                               
                                                                var datestart   = document.getElementById('txt_datestart').value;
                                                                var dateend     = document.getElementById('txt_dateend').value;
                                                                // var vehicletype = document.getElementById('txt_vehicletypeskb').value;
                                                                var vehicletype = $('#txt_vehicletypeskb').val();
                                                                // alert(vehicletype);
                                                                
                                                                if (vehicletype == ''){
                                                                    // alert('กรุณาเลือกประเภทรถ ก่อนดึงข้อมูล !!!');
                                                                    swal.fire({
                                                                        title: "warning",
                                                                        text: "กรุณาเลือกประเภทรถ ก่อนดึงข้อมูล !!!",
                                                                        icon: "warning",
                                                                    });
                                                                }else if (vehicletype == 'ADC-Dealer(SL2)'){
                                                                    window.open('excel_reporttransportplanrklskb_newSL2.php?datestart=' + datestart + '&dateend=' + dateend + '&vehicletype=' + vehicletype + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');    
                                                                }else if (vehicletype == 'ADC-Dealer(FB)'){
                                                                    window.open('excel_reporttransportplanrklskb_newFB.php?datestart=' + datestart + '&dateend=' + dateend + '&vehicletype=' + vehicletype + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');    
                                                                }else{
                                                                    // alert('การดึงข้อมูลผิดพลาด !!!');
                                                                    swal.fire({
                                                                        title: "error",
                                                                        text: "การดึงข้อมูลผิดพลาด !!!",
                                                                        icon: "error",
                                                                    });
                                                                }
                                                               
                                                                
                                                            }
                                                            function excel_reporttransportpaln()
                                                            {
                                                                save_logprocess('Report', 'Excel รายงานแผนการขนส่ง(AMT)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                if ('<?= $_GET['companycode'] ?>' == 'RRC')
                                                                {
                                                                    //if ('<?//= $_GET['customercode'] ?>' == 'TTAST')
                                                                    //{
                                                                    //    window.open('excel_reporttransportplanrrcttast.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');
                                                                    //}
                                                                    //else if('<?//= $_GET['customercode'] ?>' == 'GMT')
                                                                    //{
                                                                        window.open('excel_reporttransportplanrrc.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');
                                                                    //}
                                                                }
                                                                else if ('<?= $_GET['companycode'] ?>' == 'RCC' || '<?= $_GET['companycode'] ?>' == 'RATC')
                                                                {
                                                                    //if ('<?//= $_GET['customercode'] ?>' == 'TTAST')
                                                                    //{
                                                                    //    window.open('excel_reporttransportplanrrcttast.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');
                                                                    //}
                                                                    //else if('<?//= $_GET['customercode'] ?>' == 'GMT')
                                                                    //{
                                                                        window.open('excel_reporttransportplanrcc.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');
                                                                    //}
                                                                }
                                                                else
                                                                {
                                                                    if ('<?= $_GET['companycode'] ?>' == 'RKL')
                                                                    {
                                                                        if ('<?= $_GET['customercode'] ?>' == 'SKB')
                                                                        {
                                                                            window.open('excel_reporttransportplanrklskb.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');
                                                                        }else{
                                                                            window.open('excel_reporttransportplan.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');    
                                                                        }
                                                                    } else
                                                                    {
                                                                        window.open('excel_reporttransportplan.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');
                                                                    }
                                                                }
                                                            }
                                                            function gdatetodate()
                                                            {
                                                                document.getElementById('txt_gdateend').value = document.getElementById('txt_gdatestart').value;
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
                                                            function exportplan()
                                                            {
                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                window.open('meg_exporttransportplan.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');
                                                            }
            </script>


    </body>

</html>

<?php
sqlsrv_close($conn);
?>