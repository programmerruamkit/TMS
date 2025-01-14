
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
        <link href="../js/bootstrap-datepicker.css" rel="stylesheet">
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

            #loading {
                display:none; 
                opacity: 0.5;
                /* border-radius: 50%; */
                /* border-top: 12px ; */
                width: 10px;
                left: 10px;
                right: 800px;
                top:5px;
                bottom: 400px;
                height: 100px;
                
                /* animation: spin 1s linear infinite; */
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
                            รายงานแผนการขนส่ง (RRC)


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

                                        รายงานแผนขนส่ง (RRC)

                                    </div>
                                    <div class="col-lg-6 text-right"><br><br></div>
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
                                                        <label>เลือกวันหยุด(ถ้ามี)</label>
                                                        <div class="form-group">
                                                            <input  type="text" class="form-control dateholiday"  readonly=""  style="background-color: #f080802e" id="txt_holiday" name="txt_holiday" placeholder="วันหยุด" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                      <label>&nbsp;</label>
                                                      <select id="txt_customercode" name="txt_customercode" class="form-control" onchange="check_customer(this.value)" >
                                                          <option value="">เลือกลูกค้า</option>
                                                          <?php
                                                            $sql_seCus = "SELECT DISTINCT CUSTOMERCODE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE CUSTOMERCODE IS NOT NULL AND CUSTOMERCODE != '' AND COMPANYCODE = 'RRC'";
                                                            $query_seCus = sqlsrv_query($conn, $sql_seCus, $params_seCus);
                                                            while ($result_seCus = sqlsrv_fetch_array($query_seCus, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <option value="<?= $result_seCus['CUSTOMERCODE'] ?>" ><?= $result_seCus['CUSTOMERCODE'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                      </select>
                                                    </div><div class="col-lg-2">
                                                      <label>&nbsp;</label>
                                                      <input  disabled="" style="" class="form-control" type="" placeholder ="ระบุวันที่ทำงาน (TTAST)" id="txt_ttastday" name="txt_ttastday" value="" onkeyup="checknumber(this.value,'txtday')">
                                                    </div>
                                                    <!-- <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_reporttransportplanamt();">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>
                                                    </div> -->

                                                    <div class="col-lg-2" style="text-align: right">
                                                        <label>&nbsp;</label><br>
                                                        <a href="#" onclick="excel_reporttransportpalngw();" class="btn btn-default">พิมพ์รายงานขนส่ง <li class="fa fa-print"></li></a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="display:none">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                    รายงานแผนการขนส่ง RRC
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                <tr>
                                                                    <th>NO</th>
                                                                    <th>JOBDATE</th>
                                                                    <th>DRIVER(1)</th>
                                                                    <th>TRUCKNO</th>
                                                                    <th>MATERIALTYPE</th>
                                                                    <th>BOOOKNO</th>
                                                                    <th>FROM</th>
                                                                    <th>TO</th>
                                                                    <th>DO</th>
                                                                    <th>WEIGHTIN</th>
                                                                    <th>WEIGHTOUT</th>
                                                                    <th>PRICE</th>
                                                                    <th>INCENTIVE</th>
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

            </div>

            <!-- this will show our spinner -->
            <div  id="loading" class="center" >
                <p><img style="" src="../images/truckload5.gif" /></p>
            </div>                                                

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

            <script src="../vendor/jquery/jquery.min.js"></script>
            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>

            <script src="../js/jquery.datetimepicker.full.js"></script>

            <script src="../js/bootstrap-datepicker.min.js"></script>
            <script src="../js/bootstrap-datepicker.th.min.js"></script>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
            <script>

                                                            function check_customer(value){
                                                                if (value == 'TTAST') {
                                                                    document.getElementById("txt_ttastday").disabled = false;
                                                                }else{
                                                                    document.getElementById("txt_ttastday").disabled = true;
                                                                }
                                                            }
                                                            function checknumber(value,check)
                                                            {
                                                                // alert(value);
                                                                // alert(check);

                                                                var elem = value;
                                                                if(!elem.match(/^([0-9])+$/i))
                                                                {
                                                                    // alert("กรอกได้เฉพาะตัวเลขและตัวอักษรภาษาอังกฤษเท่านั้น");
                                                                    swal.fire({
                                                                        title: "Warning !",
                                                                        text: "กรอกได้เฉพาะตัวเลขเท่านั้น !!!",
                                                                        showConfirmButton: true,
                                                                        icon: "warning"
                                                                    });

                                                                    document.getElementById("txt_ttastday").value = '';
                                                                    
                                                                }
                                                            }
                                                            function showLoading() {
                                                                $("#loading").show();
                                                                
                                                            }

                                                            function hideLoading() {
                                                                $("#loading").hide();
                                                            }

                                                            function select_reporttransportplanamt()
                                                            {

                                                                // loadData();
                                                                showLoading();

                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                var customercode = document.getElementById('txt_customercode').value;
                                                                var ttastday = document.getElementById('txt_ttastday').value;
                                                                // alert(datestart);
                                                                // alert(dateend);
                                                                // alert(companycode);

                                                                if (customercode == '') {

                                                                    swal.fire({
                                                                        title: "Warning !",
                                                                        text: "ยังไม่ได้ระบุลูกค้า !!!",
                                                                        showConfirmButton: true,
                                                                        icon: "warning"
                                                                    });

                                                                }else if(customercode == 'TTAST' && ttastday == ''){

                                                                    swal.fire({
                                                                        title: "Warning !",
                                                                        text: "ยังไม่ได้ระบุวันที่ทำงาน (TTAST) !!!",
                                                                        showConfirmButton: true,
                                                                        icon: "warning"
                                                                    });
                                                                    
                                                                }else{
                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data.php',
                                                                        data: {
                                                                            txt_flg: "select_reporttransportplangwrrc", datestart: datestart, dateend: dateend,customercode: customercode
                                                                        },
                                                                        success: function (response) {
                                                                            if (response)
                                                                            {
                                                                                hideLoading();
                                                                                swal.fire({
                                                                                    title: "Good Job!",
                                                                                    text: "โหลดข้อมูลเรียบร้อย",
                                                                                    icon: "success",
                                                                                });
                                                                                document.getElementById("datasr").innerHTML = response;
                                                                                document.getElementById("datadef").innerHTML = "";
                                                                                
                                                                            }
                                                                            $(document).ready(function () {
                                                                                $('#dataTables-example3').DataTable({
                                                                                    responsive: true,
                                                                                });
                                                                            });



                                                                        }
                                                                    });
                                                                }

                                                                


                                                            }
                                                            function excel_reporttransportpalngw()
                                                            {
                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                var customercode = document.getElementById('txt_customercode').value;
                                                                var ttastday = document.getElementById('txt_ttastday').value;
                                                                var holiday = document.getElementById('txt_holiday').value;

                                                                if (customercode == '') {

                                                                    swal.fire({
                                                                        title: "Warning !",
                                                                        text: "ยังไม่ได้ระบุลูกค้า !!!",
                                                                        showConfirmButton: true,
                                                                        icon: "warning"
                                                                    });

                                                                }else if(customercode == 'TTAST' && ttastday == ''){

                                                                    swal.fire({
                                                                        title: "Warning !",
                                                                        text: "ยังไม่ได้ระบุวันที่ทำงาน (TTAST) !!!",
                                                                        showConfirmButton: true,
                                                                        icon: "warning"
                                                                    });

                                                                }else{
                                                                    
                                                                    if (customercode != 'TTAST') {
                                                                        window.open('excel_reporttransportplangwrrc.php?datestart=' + datestart + '&dateend=' + dateend+ '&customercode=' + customercode+ '&holiday=' + holiday, '_blank');
                                                                    }else {
                                                                        // alert('Pending Developing');
                                                                        window.open('excel_reporttransportplangwrrcttast.php?datestart=' + datestart + '&dateend=' + dateend+ '&customercode=' + customercode+ '&ttastday=' + ttastday, '_blank');
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

                                                            $('.dateholiday').datepicker({
                                                                format: "dd/mm/yyyy",
                                                                language: "th",
                                                                multidate: true
                                                            });

                                                            $(document).ready(function () {
                                                                $('#dataTables-example1').DataTable({
                                                                    responsive: true,
                                                                });
                                                            });

                                                            $(document).ready(function () {
                                                                $('#dataTables-example').DataTable({
                                                                    responsive: true,
                                                                });
                                                            });

            </script>


    </body>

</html>

<?php
sqlsrv_close($conn);
?>
