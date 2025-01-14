
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

$condCus = " AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "' ";
$sql_seCustomer = "{call megCustomer_v2(?,?)}";
$params_seCustomer = array(
    array('select_customerall', SQLSRV_PARAM_IN),
    array($condCus, SQLSRV_PARAM_IN)
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
                            รายงานปิดงบประมาณรายวัน


                        </h2>
                    </div>

                    <!-- /.col-lg-12 -->
                </div>

                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">


                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Tab panes -->
                                <div class="tab-content">




                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">

                                                    <?php
                                                    $meg = 'Summary detail';
                                                    echo "<a href='report_dailybudget.php'>Summary</a> / " . $result_seCustomer['NAMETH'];
                                                    $link = "<a href='report_dailybudget.php'>Summary</a>";
                                                    $_SESSION["link"] = $link;
                                                    ?>

                                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                      <a href="#" onclick="excel_reportdailybudgetdetailspallet();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>
                                                      <input type="text" name="" id="txt_datestartpallet" value="<?=$_GET['datestart']?>" style="display:none">
                                                      <input type="text" name="" id="txt_dateendpallet" value="<?=$_GET['dateend']?>" style="display:none">
                                                      <input type="text" name="" id="select_compallet" value="<?=$_GET['companycode']?>" style="display:none">
                                                      <input type="text" name="" id="select_cuspallet" value="<?=$_GET['customercode']?>" style="display:none">

                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <!-- /.panel-heading -->


                                                        <div class="row">

                                                            <div class="col-md-12" >
                                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                                    <div id="datadef">
                                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th >NO</th>
                                                                                    <th >JOBNO</th>
                                                                                    <th >TRUCK NO</th>
                                                                                    <th >DRIVER</th>
                                                                                    <th >COMPANY</th>
                                                                                    <th >CUSTOMER</th>
                                                                                    <th >JOBEND</th>
                                                                                    <th >AMOUNT</th>
                                                                                    <th >SALEPRICE</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                $i = 1;
                                                                                $tripamount = 0;
                                                                                $SUMSALEPRICESTM = 0;
                                                                                $SUMWORKINCENSTM = 0;
                                                                                // $SUMFUELLITSTM = 0;
                                                                                // $SUMFUELBATHSTM = 0;
                                                                                $SUMFUELINCENSTM = 0;
                                                                                $condiReporttransport1 = " AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)";
                                                                                $condiReporttransport2 = " AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                                                                $condiReporttransport3 = " AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE_PALLET IS NOT NULL AND a.DOCUMENTCODE_PALLET != ''";
                                                                                $sql_seReporttransport = "{call megVehicletransportplan_v2(?,?,?,?)}";
                                                                                $params_seReporttransport = array(
                                                                                    array('select_reportdailybudgetpallet', SQLSRV_PARAM_IN),
                                                                                    array($condiReporttransport1, SQLSRV_PARAM_IN),
                                                                                    array($condiReporttransport2, SQLSRV_PARAM_IN),
                                                                                    array($condiReporttransport3, SQLSRV_PARAM_IN)
                                                                                );
                                                                                $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
                                                                                while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {

                                                                                    $ACTUALPRICE  = $result_seReporttransport['TRIPAMOUNT_PALLET'] *10;

                                                                                    ?>

                                                                                    <tr>
                                                                                        <td style="text-align: center"><label  style="width: 100px"><?= $i ?></label></td>
                                                                                        <td ><label  style="width: 200px"><?= $result_seReporttransport['JOBNO'] ?></label></td>
                                                                                        <td ><label  style="width: 200px"><?= $result_seReporttransport['THAINAME'] ?></label></td>
                                                                                        <td ><label  style="width: 200px"><?= $result_seReporttransport['EMPLOYEENAME1'] ?></label></td>
                                                                                        <td ><label  style="width: 200px"><?= $result_seReporttransport['COMPANYCODE'] ?></label></td>
                                                                                        <td ><label  style="width: 200px"><?= $result_seReporttransport['CUSTOMERCODE'] ?></label></td>
                                                                                        <td ><label  style="width: 200px"><?= $result_seReporttransport['JOBEND'] ?></label></td>
                                                                                        <td ><label  style="width: 200px"><?= $result_seReporttransport['TRIPAMOUNT_PALLET'] ?></label></td>
                                                                                        <td ><label  style="width: 200px"><?=number_format($ACTUALPRICE,2) ?></td><!-- TOTAL -->
                                                                                    </tr>
                                                                                    <?php
                                                                                    $i++;
                                                                                    $AMOUNT = $AMOUNT + $result_seReporttransport['TRIPAMOUNT_PALLET'];
                                                                                    $SUMACTUALPRICE = $SUMACTUALPRICE+$ACTUALPRICE;
                                                                                    } //END LOOP WHILE


                                                                                    ?>
                                                                            </tbody>

                                                                            <!-- //////////////////////////////FOOTER/////////////////////////////////////////// -->
                                                                              <tfoot>
                                                                                <tr>
                                                                                    <!-- SUM TRIP AMOUNT-->
                                                                                    <td ><label  style="width: 200px;"><u></u></label></td>
                                                                                     <!-- SUM WEIGHTINTON-->
                                                                                    <td ><label  style="width: 200px;"><u></u></label></td>

                                                                                    <td ><label  style="width: 200px;"><u></u></label></td>

                                                                                    <td ><label  style="width: 200px;"><u></u></label></td>

                                                                                    <td ><label  style="width: 200px;"><u></u></label></td>
                                                                                    <td ><label  style="width: 200px;"></label></td>
                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><?=number_format($AMOUNT,2)?></label></td>
                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><?=number_format($SUMACTUALPRICE,2)?></label></td>
                                                                            </tfoot>

                                                                        </table>

                                                                    </div>
                                                                    <div id="datasr"></div>
                                                                </div>
                                                            </div>

                                                            <!-- /.panel-body -->

                                                        </div>


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
            <script>                                        function shows_dailybudget(trip, ton, saleprice, fuell, fuelbth, tolleff, insentive, repair, total, dep, eva, profit)
                                                                                        {
                                                                                            var company = document.getElementById('select_com').value;
                                                                                            var customer = document.getElementById('select_cus').value;
                                                                                            document.getElementById("lb_company").innerHTML = company;
                                                                                            document.getElementById("lb_customer").innerHTML = customer;
                                                                                            document.getElementById("lb_trip").innerHTML = trip;
                                                                                            document.getElementById("lb_ton").innerHTML = ton;
                                                                                            document.getElementById("lb_saleprice").innerHTML = saleprice;
                                                                                            document.getElementById("lb_fuell").innerHTML = fuell;
                                                                                            document.getElementById("lb_fuelbth").innerHTML = fuelbth;
                                                                                            document.getElementById("lb_tolleff").innerHTML = tolleff;
                                                                                            document.getElementById("lb_insentive").innerHTML = insentive;
                                                                                            document.getElementById("lb_repair").innerHTML = repair;
                                                                                            document.getElementById("lb_total").innerHTML = total;
                                                                                            document.getElementById("lb_dep").innerHTML = dep;
                                                                                            document.getElementById("lb_eva").innerHTML = eva;
                                                                                            document.getElementById("lb_profit").innerHTML = profit;
                                                                                        }
                                                                                        function select_customer(companycode)
                                                                                        {


                                                                                            $.ajax({
                                                                                                type: 'post',
                                                                                                url: 'meg_data.php',
                                                                                                data: {
                                                                                                    txt_flg: "select_customercompensation", companycode: companycode
                                                                                                },
                                                                                                success: function (response) {
                                                                                                    if (response) {

                                                                                                        document.getElementById("datacompsr").innerHTML = response;
                                                                                                        document.getElementById("datacompdef").innerHTML = "";

                                                                                                    }




                                                                                                }
                                                                                            });



                                                                                        }

                                                                                        // function report_dailybudgetsummary()
                                                                                        // {
                                                                                        //
                                                                                        //     var datestart = document.getElementById('txt_datestart2').value;
                                                                                        //     var dateend = document.getElementById('txt_dateend2').value;
                                                                                        //     var companycode = document.getElementById('select_com2').value;
                                                                                        //     var customercode = document.getElementById('select_cus2').value;
                                                                                        //
                                                                                        //     $.ajax({
                                                                                        //         type: 'post',
                                                                                        //         url: 'meg_data.php',
                                                                                        //         data: {
                                                                                        //             txt_flg: "select_reportdailybudgetsummary", companycode: companycode, datestart: datestart, dateend: dateend
                                                                                        //         },
                                                                                        //         success: function (response) {
                                                                                        //             if (response)
                                                                                        //             {
                                                                                        //                 document.getElementById("datasumsr").innerHTML = response;
                                                                                        //                 document.getElementById("datasumdef").innerHTML = "";
                                                                                        //             }
                                                                                        //             $(document).ready(function () {
                                                                                        //                 $('#dataTables-examplesummary2').DataTable({
                                                                                        //                     responsive: true,
                                                                                        //                 });
                                                                                        //             });
                                                                                        //
                                                                                        //
                                                                                        //
                                                                                        //         }
                                                                                        //     });
                                                                                        //     //}
                                                                                        //
                                                                                        // }
                                                                                        function excel_reportdailybudgetdetails()
                                                                                        {
                                                                                            var datestart = document.getElementById('txt_datestart2').value;
                                                                                            var dateend = document.getElementById('txt_dateend2').value;
                                                                                            var companycode = document.getElementById('select_com2').value;
                                                                                            var customercode = document.getElementById('select_cus2').value;

                                                                                            // alert(datestart);
                                                                                            // alert(dateend);
                                                                                            // alert(companycode);
                                                                                            // alert(customercode);
                                                                                            window.open('excel_reportdailybudgetdetails.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=' + companycode+ '&customercode=' + customercode, '_blank');


                                                                                        }

                                                                                        function excel_reportdailybudgetdetailspallet()
                                                                                        {
                                                                                            var datestart = document.getElementById('txt_datestartpallet').value;
                                                                                            var dateend = document.getElementById('txt_dateendpallet').value;
                                                                                            var companycode = document.getElementById('select_compallet').value;
                                                                                            var customercode = document.getElementById('select_cuspallet').value;

                                                                                            // alert(datestart);
                                                                                            // alert(dateend);
                                                                                            // alert(companycode);
                                                                                            // alert(customercode);
                                                                                            window.open('excel_reportdailybudgetdetailspallet.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=' + companycode+ '&customercode=' + customercode, '_blank');


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
                                                                                                order: [[0, "desc"]],
                                                                                                scrollX: true,
                                                                                                scrollY: '500px',
                                                                                            });
                                                                                        });
                                                                                        $(document).ready(function () {
                                                                                            $('#dataTables-examplesummary').DataTable({
                                                                                                responsive: true,
                                                                                            });
                                                                                        });
                                                                                        $(document).ready(function () {
                                                                                            $('#dataTables-examplesummary2').DataTable({
                                                                                                responsive: true,
                                                                                            });
                                                                                        });

            </script>


    </body>

</html>

<?php
sqlsrv_close($conn);
?>
