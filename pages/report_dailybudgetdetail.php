
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
        <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">
        
        <!-- data table css -->
        <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">

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

        <div class="modal fade" id="modal_dailybudget" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title_copyjob">Summary</h5>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        Summary
                                    </div>
                                    <!-- /.panel-heading -->

                                    <div class="panel-body">

                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                            <div id="datasummarydef">

                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-examplesummary" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr>


                                                            <th >COMPANY</th>
                                                            <th >CUSTOMER</th>
                                                            <th >TRIP</th>
                                                            <th >TON</th>
                                                            <th >SALE PRICE</th>
                                                            <th >FUEL(L)</th>
                                                            <th >FUEL(Bth)</th>
                                                            <th >TOLLFEE</th>
                                                            <th >WORKING INCENTIVE</th>
                                                            <th >REPAIR</th>
                                                            <th >TOTAL</th>
                                                            <th >DEP</th>
                                                            <th >EVA</th>
                                                            <th >PROFIT%</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><label id="lb_company"></label></td>
                                                            <td><label id="lb_customer"></label></td>
                                                            <td><label id="lb_trip"></label></td>
                                                            <td><label id="lb_ton"></label></td>
                                                            <td><label id="lb_saleprice"></label></td>
                                                            <td><label id="lb_fuell"></label></td>
                                                            <td><label id="lb_fuelbth"></label></td>
                                                            <td><label id="lb_tolleff"></label></td>
                                                            <td><label id="lb_insentive"></label></td>
                                                            <td><label id="lb_repair"></label></td>
                                                            <td><label id="lb_total"></label></td>
                                                            <td><label id="lb_dep"></label></td>
                                                            <td><label id="lb_eva"></label></td>
                                                            <td><label id="lb_profit"></label></td>
                                                        </tr>
                                                    </tbody>



                                                </table>
                                            </div>
                                            <div id="datasummarysr"></div>
                                        </div>


                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel -->
                                </div>
                            </div>
                        </div>
                        <div class="row">&nbsp;</div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        <!-- <button type="button" class="btn btn-primary" onclick="excel_reportdailybudgetdetails()">พิมพ์ <li class="fa fa-print"></li></button> -->
                    </div>
                </div>
            </div>
        </div>
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
                                                      <!-- <a href="#" onclick="excel_reportdailybudgetdetails();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a> -->
                                                      <input type="text" name="" id="txt_datestart2" value="<?=$_GET['datestart']?>" style="display:none">
                                                      <input type="text" name="" id="txt_dateend2" value="<?=$_GET['dateend']?>" style="display:none">
                                                      <input type="text" name="" id="select_com2" value="<?=$_GET['companycode']?>" style="display:none">
                                                      <input type="text" name="" id="select_cus2" value="<?=$_GET['customercode']?>" style="display:none">

                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <!-- /.panel-heading -->

                                                <!-- <div class="panel-body">
                                                    <div class="tab-content">
                                                        <div class="row">
                                                            <div class="col-md-12" >&nbsp;</div>
                                                        </div>
                                                        <div class="row" >
                                                            <div class="col-lg-12">
                                                                <div class="well">
                                                                    <div class="row">

                                                                        <div class="col-lg-2">
                                                                            <label>&nbsp;</label>
                                                                            <select id="select_com" name="select_com" class="form-control" onchange="select_customer(this.value)">
                                                                                <option value="">เลือกบริษัท</option>
                                                                                <option value="RKR">ร่วมกิจรุ่งเรือง (1993)</option>
                                                                                <option value="RKS">ร่วมกิจรุ่งเรือง เซอร์วิส</option>
                                                                                <option value="RCC">ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                                                                <option value="RRC">ร่วมกิจรีไซเคิล แคริเออร์</option>
                                                                                <option value="RKL">ร่วมกิจรุ่งเรือง โลจิสติคส์</option>
                                                                                <option value="RATC">ร่วมกิจออโตโมทีฟ ทรานสปอร์ต</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <label>&nbsp;</label>
                                                                            <div id="datacompdef">
                                                                                <select id="select_cus" name="select_cus" class="form-control">
                                                                                    <option value="">เลือกลูกค้า</option>

                                                                                </select>
                                                                            </div>
                                                                            <div id="datacompsr"></div>

                                                                        </div>
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
                                                                                <button type="button" class="btn btn-default" onclick="report_dailybudget();">ค้นหา <li class="fa fa-search"></li></button>
                                                                            </div>

                                                                        </div>






                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                      </div>
                                                    </div> -->
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
                                                                                    <th >TRIP</th>
                                                                                    <th >TON</th>
                                                                                    <th >SALE PRICE</th>
                                                                                    <th >DROP</th>
                                                                                    <th >FUEL(L)</th>
                                                                                    <th >FUEL(Bth)</th>
                                                                                    <th >TOLLFEE</th>
                                                                                    <th >WORKING INCENTIVE</th>
                                                                                    <th >FUEL INCENTIVE</th>
                                                                                    <th >REPAIR</th>
                                                                                    <th >TOTAL</th>
                                                                                    <th >DEP</th>
                                                                                    <th >EVA</th>
                                                                                    <th >PROFIT%</th>


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
                                                                                $condiReporttransport1 = " AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)";
                                                                                $condiReporttransport2 = " AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                                                                $condiReporttransport3 = " AND a.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''";
                                                                                $sql_seReporttransport = "{call megVehicletransportplan_v2(?,?,?,?)}";
                                                                                $params_seReporttransport = array(
                                                                                    array('select_reportdailybudget', SQLSRV_PARAM_IN),
                                                                                    array($condiReporttransport1, SQLSRV_PARAM_IN),
                                                                                    array($condiReporttransport2, SQLSRV_PARAM_IN),
                                                                                    array($condiReporttransport3, SQLSRV_PARAM_IN)
                                                                                );
                                                                                $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
                                                                                while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {

                                                                                  if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'STM') {
                                                                                    $sql_seTripamount = "SELECT LEFT(a.ROUNDAMOUNT,PATINDEX('%[^0-9]%',a.ROUNDAMOUNT)-1) AS 'TRIPAMOUNT' FROM [dbo].[VEHICLETRANSPORTPLAN] a
                                                                                                         WHERE a.ROUNDAMOUNT IS NOT NULL AND a.VEHICLETRANSPORTPLANID = '" . $result_seReporttransport['VEHICLETRANSPORTPLANID'] . "'";
                                                                                    $query_seTripamount = sqlsrv_query($conn, $sql_seTripamount, $params_seTripamount);
                                                                                    $result_seTripamount = sqlsrv_fetch_array($query_seTripamount, SQLSRV_FETCH_ASSOC);
                                                                                  }else {
                                                                                    // code...
                                                                                  }

                                                                                  ///////////////////////////DENSO-คิดราคาหาร 2 /////////////////////////////////
                                                                                  if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'DENSO-THAI') {

                                                                                    $sql_seDensoPrice = "SELECT a.JOBNO,a.JOBSTART AS 'JOBSTART',a.JOBEND AS 'JOBEND',a.ACTUALPRICE AS 'PRICE'
                                                                                                  FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
                                                                                                  AND VEHICLETRANSPORTPLANID = '".$result_seReporttransport['VEHICLETRANSPORTPLANID']."'
                                                                                                  AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)
                                                                                                  AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'DENSO-THAI'
                                                                                                  AND a.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''";
                                                                                    $query_seDensoPrice = sqlsrv_query($conn, $sql_seDensoPrice, $params_seDensoPrice);
                                                                                    $result_seDensoPrice = sqlsrv_fetch_array($query_seDensoPrice, SQLSRV_FETCH_ASSOC);

                                                                                    if (($result_seDensoPrice['JOBSTART'] ==  'EXP-E1' && $result_seDensoPrice['JOBEND'] == 'Normal1') ||
                                                                                        ($result_seDensoPrice['JOBSTART'] ==  'EXP-E1(N)' && $result_seDensoPrice['JOBEND'] == 'Normal1') ||
                                                                                        ($result_seDensoPrice['JOBSTART'] ==  'EXP-E1' && $result_seDensoPrice['JOBEND'] == 'Normal5') ||
                                                                                        ($result_seDensoPrice['JOBSTART'] ==  'EXP-E1(N)' && $result_seDensoPrice['JOBEND'] == 'Normal5') ||
                                                                                        ($result_seDensoPrice['JOBSTART'] ==  'EXP-E1' && $result_seDensoPrice['JOBEND'] == 'Normal8') ||
                                                                                        ($result_seDensoPrice['JOBSTART'] ==  'EXP-E1(N)' && $result_seDensoPrice['JOBEND'] == 'Normal8') ||

                                                                                        ($result_seDensoPrice['JOBSTART'] ==  'EXP-P1' && $result_seDensoPrice['JOBEND'] == 'Normal1') ||
                                                                                        ($result_seDensoPrice['JOBSTART'] ==  'EXP-P1(N)' && $result_seDensoPrice['JOBEND'] == 'Normal1') ||
                                                                                        ($result_seDensoPrice['JOBSTART'] ==  'EXP-P1' && $result_seDensoPrice['JOBEND'] == 'Normal2') ||
                                                                                        ($result_seDensoPrice['JOBSTART'] ==  'EXP-P1(N)' && $result_seDensoPrice['JOBEND'] == 'Normal2') ||
                                                                                        ($result_seDensoPrice['JOBSTART'] ==  'EXP-P1' && $result_seDensoPrice['JOBEND'] == 'Normal3') ||
                                                                                        ($result_seDensoPrice['JOBSTART'] ==  'EXP-P1(N)' && $result_seDensoPrice['JOBEND'] == 'Normal3') ) {
                                                                                         $DENSOPRICE = $result_seDensoPrice['PRICE'] / 2;
                                                                                    } else {
                                                                                         $DENSOPRICE = $result_seDensoPrice['PRICE'];
                                                                                    }



                                                                                  }else {
                                                                                    // code...
                                                                                  }
                                                                                  //////////////////////////////////////////////////////////////////////////////////////////

                                                                                  $sql_seDensoPriceSum = "SELECT SUM(a.PRICEAC) AS 'SUMDENSOPRICE'
                                                                                                    FROM (SELECT a.JOBNO,a.JOBSTART AS 'JOBSTART',a.JOBEND AS 'JOBEND',
                                                                                                    CASE
                                                                                                    WHEN (a.JOBSTART = 'EXP-E1' AND a.JOBEND = 'Normal1') THEN a.ACTUALPRICE / 2
                                                                                                    WHEN (a.JOBSTART = 'EXP-E1(N)' AND a.JOBEND = 'Normal1') THEN a.ACTUALPRICE / 2
                                                                                                    WHEN (a.JOBSTART = 'EXP-E1' AND a.JOBEND = 'Normal5') THEN a.ACTUALPRICE / 2
                                                                                                    WHEN (a.JOBSTART = 'EXP-E1(N)' AND a.JOBEND = 'Normal5') THEN a.ACTUALPRICE / 2
                                                                                                    WHEN (a.JOBSTART = 'EXP-E1' AND a.JOBEND = 'Normal8') THEN a.ACTUALPRICE / 2
                                                                                                    WHEN (a.JOBSTART = 'EXP-E1(N)' AND a.JOBEND = 'Normal8') THEN a.ACTUALPRICE / 2

                                                                                                    WHEN (a.JOBSTART = 'EXP-P1' AND a.JOBEND = 'Normal1') THEN a.ACTUALPRICE / 2
                                                                                                    WHEN (a.JOBSTART = 'EXP-P1(N)' AND a.JOBEND = 'Normal1') THEN a.ACTUALPRICE / 2
                                                                                                    WHEN (a.JOBSTART = 'EXP-P1' AND a.JOBEND = 'Normal2') THEN a.ACTUALPRICE / 2
                                                                                                    WHEN (a.JOBSTART = 'EXP-P1(N)' AND a.JOBEND = 'Norma2') THEN a.ACTUALPRICE / 2
                                                                                                    WHEN (a.JOBSTART = 'EXP-P1' AND a.JOBEND = 'Normal3') THEN a.ACTUALPRICE / 2
                                                                                                    WHEN (a.JOBSTART = 'EXP-P1(N)' AND a.JOBEND = 'Normal3') THEN a.ACTUALPRICE / 2
                                                                                                    ELSE a.ACTUALPRICE
                                                                                                    END AS 'PRICEAC',
                                                                                                    a.ACTUALPRICE AS 'PRICE'
                                                                                                    FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
                                                                                                    AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)
                                                                                                    AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'DENSO-THAI'
                                                                                                    AND a.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != '') a";
                                                                                  $query_seDensoPriceSum = sqlsrv_query($conn, $sql_seDensoPriceSum, $params_seDensoPriceSum);
                                                                                  $result_seDensoPriceSum = sqlsrv_fetch_array($query_seDensoPriceSum, SQLSRV_FETCH_ASSOC);







                                                                                 /////////////////////////////////////////////////////////////////////////////////

                                                                                    $sql_seTon = "SELECT SUM(CONVERT(DECIMAL(10,3),a.WEIGHTIN)) / 1000 AS 'SUMWEIGHTIN' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                                                                                  INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID WHERE a.WEIGHTIN IS NOT NULL AND a.WEIGHTIN != ''
                                                                                                  AND a.VEHICLETRANSPORTPLANID = '" . $result_seReporttransport['VEHICLETRANSPORTPLANID'] . "'";
                                                                                    $query_seTon = sqlsrv_query($conn, $sql_seTon, $params_seTon);
                                                                                    $result_seTon = sqlsrv_fetch_array($query_seTon, SQLSRV_FETCH_ASSOC);

                                                                                    if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'STM') {
                                                                                      $sql_seActualprice = "SELECT  b.ACTUALPRICE AS 'PRICE1'
                                                                                          FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                                                                          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID WHERE b.ACTUALPRICE IS NOT NULL
                                                                                          AND a.VEHICLETRANSPORTPLANID = '" . $result_seReporttransport['VEHICLETRANSPORTPLANID'] . "'
                                                                                          GROUP BY b.ACTUALPRICE";
                                                                                      $query_seActualprice = sqlsrv_query($conn, $sql_seActualprice, $params_seActualprice);
                                                                                      $result_seActualprice = sqlsrv_fetch_array($query_seActualprice, SQLSRV_FETCH_ASSOC);
                                                                                    }else {
                                                                                      $sql_seActualprice = "SELECT b.ACTUALPRICE AS 'PRICE1'
                                                                                          FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                                                                          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID WHERE b.ACTUALPRICE IS NOT NULL
                                                                                          AND a.VEHICLETRANSPORTPLANID = '" . $result_seReporttransport['VEHICLETRANSPORTPLANID'] . "'
                                                                                          GROUP BY b.ACTUALPRICE";
                                                                                      $query_seActualprice = sqlsrv_query($conn, $sql_seActualprice, $params_seActualprice);
                                                                                      $result_seActualprice = sqlsrv_fetch_array($query_seActualprice, SQLSRV_FETCH_ASSOC);
                                                                                    }


                                                                                    $sql_seActualpriceTGT = "SELECT b.ACTUALPRICE AS 'PRICE'
                                                                                        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                                                                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID WHERE b.ACTUALPRICE IS NOT NULL
                                                                                        AND a.VEHICLETRANSPORTPLANID = '" . $result_seReporttransport['VEHICLETRANSPORTPLANID'] . "'
                                                                                        GROUP BY b.ACTUALPRICE";
                                                                                    $query_seActualpriceTGT = sqlsrv_query($conn, $sql_seActualpriceTGT, $params_seActualpriceTGT);
                                                                                    $result_seActualpriceTGT = sqlsrv_fetch_array($query_seActualpriceTGT, SQLSRV_FETCH_ASSOC);

                                                                                    $sql_sumActualprice = "SELECT SUM(CAST(ACTUALPRICE AS DECIMAL(18,2))) AS 'SUMPRICE',SUM(CAST(C3 AS DECIMAL(18,2))) AS 'FUELINCEN'
                                                                                        FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
                                                                                        AND ACTUALPRICE IS NOT NULL
                                                                                        AND ACTUALPRICE != ''
                                                                                        AND C3 IS NOT NULL
                                                                                        AND C3 != ''
                                                                                        AND a.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                                                                                        AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)
                                                                                        AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "' ";
                                                                                    $query_sumActualprice = sqlsrv_query($conn, $sql_sumActualprice, $params_sumActualprice);
                                                                                    $result_sumActualprice = sqlsrv_fetch_array($query_sumActualprice, SQLSRV_FETCH_ASSOC);

                                                                                    $sql_sumActualpriceother = "SELECT SUM(CAST(ACTUALPRICE AS DECIMAL(18,2))) AS 'SUMPRICEOTHER'
                                                                                        FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
                                                                                        AND ACTUALPRICE IS NOT NULL
                                                                                        AND ACTUALPRICE != ''
                                                                                        AND a.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                                                                                        AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)
                                                                                        AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "' ";
                                                                                    $query_sumActualpriceother = sqlsrv_query($conn, $sql_sumActualpriceother, $params_sumActualpriceother);
                                                                                    $result_sumActualpriceother = sqlsrv_fetch_array($query_sumActualpriceother, SQLSRV_FETCH_ASSOC);


                                                                                    $sql_sumActualpricerkr = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICE)) AS 'SUMACTUALPRICE'
                                                                                    FROM (SELECT  a.ACTUALPRICE,a.VEHICLETRANSPORTPLANID
                                                                                    FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                                                                    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                                                                                    WHERE 1 = 1
                                                                                    AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)
                                                                                    AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'
                                                                                    AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                                                                                    GROUP BY a.VEHICLETRANSPORTPLANID,a.ACTUALPRICE) a";
                                                                                    $query_sumActualpricerkr = sqlsrv_query($conn, $sql_sumActualpricerkr, $params_sumActualpricerkr);
                                                                                    $result_sumActualpricerkr = sqlsrv_fetch_array($query_sumActualpricerkr, SQLSRV_FETCH_ASSOC);

                                                                                    $sql_sumActualpricerks = "SELECT SUM(CONVERT(INT,ACTUALPRICE))  AS 'SUMACTUALPRICE'
                                                                                                  FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
                                                                                                  AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)
                                                                                                  AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $result_seCus['CUSTOMERCODE'] . "' ";
                                                                                    $query_sumActualpricerks = sqlsrv_query($conn, $sql_sumActualpricerks, $params_sumActualpricerks);
                                                                                    $result_sumActualpricerks = sqlsrv_fetch_array($query_sumActualpricerks, SQLSRV_FETCH_ASSOC);

                                                                                    ///////////////////SALEPRICE ของ RKR,RKl//////////////////////////////////
                                                                                   //  $sql_sumActualpricehead= "SELECT SUM(DISTINCT CONVERT(DECIMAL(10,3),a.ACTUALPRICEHEAD)) AS 'SUMACTUALPRICE',SUM(DISTINCT CONVERT(DECIMAL(10,3),b.ACTUALPRICE)) AS 'SUMACTUALPRICESKB'
                                                                                   //                ,SUM(DISTINCT CONVERT(INT,b.ACTUALPRICE)) AS 'SUMACTUALPRICETTAST'
                                                                                   //                FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                                                                   //                INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
                                                                                   //                WHERE 1 = 1
                                                                                   //                AND b.VEHICLETRANSPORTPLANID='".$result_seReporttransport['VEHICLETRANSPORTPLANID']."'";
                                                                                   // $query_sumActualpricehead = sqlsrv_query($conn, $sql_sumActualpricehead, $params_sumActualpricehead);
                                                                                   // $result_sumActualpricehead = sqlsrv_fetch_array($query_sumActualpricehead, SQLSRV_FETCH_ASSOC);

                                                                                   if ($_GET['companycode'] == 'RKR' || $_GET['companycode'] == 'RKL') {
                                                                                       if ($_GET['customercode'] == 'TTASTSTC') {
                                                                                         $sql_sumActualpricehead= "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICEHEAD)) AS 'SUMACTUALPRICE'
                                                                                            FROM (SELECT  a.ACTUALPRICEHEAD,a.VEHICLETRANSPORTPLANID
                                                                                            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                                                                            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                                                                                            WHERE 1 = 1
                                                                                            AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)
                                                                                            AND a.COMPANYCODE = '".$_GET['companycode']."' AND a.CUSTOMERCODE = 'TTASTSTC'
                                                                                            AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                                                                                            AND b.VEHICLETRANSPORTPLANID ='" . $result_seReporttransport['VEHICLETRANSPORTPLANID'] . "'
                                                                                            GROUP BY a.VEHICLETRANSPORTPLANID,a.ACTUALPRICEHEAD,a.JOBEND) a";
                                                                                        $query_sumActualpricehead = sqlsrv_query($conn, $sql_sumActualpricehead, $params_sumActualpricehead);
                                                                                        $result_sumActualpricehead = sqlsrv_fetch_array($query_sumActualpricehead, SQLSRV_FETCH_ASSOC);

                                                                                        // ค่า DROP สายงาน TTAST-STC เท่านั้น
                                                                                        $sql_sumCrossprice = "SELECT (a.ROWNUM * 100) AS 'CROSSPRICE'
                                                                                          FROM (SELECT TOP 1 a.DESTINATION AS 'DESTINATION',a.VEHICLETRANSPORTPLANID,
                                                                                          ROW_NUMBER() OVER(PARTITION BY a.DESTINATION ORDER BY a.VEHICLETRANSPORTPLANID ASC) AS 'ROWNUM'
                                                                                          FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                                                                          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                                                                                          WHERE 1 = 1
                                                                                          AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['datestart'] . "',103)
                                                                                          AND a.COMPANYCODE = '".$_GET['companycode']."' AND a.CUSTOMERCODE = 'TTASTSTC'
                                                                                          AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                                                                                          AND a.CUSTOMERCODE !='TTASTCS'
                                                                                          AND a.DESTINATION ='C'
                                                                                          AND b.VEHICLETRANSPORTPLANID ='" . $result_seReporttransport['VEHICLETRANSPORTPLANID'] . "'
                                                                                          GROUP BY a.VEHICLETRANSPORTPLANID,a.DESTINATION
                                                                                          ORDER BY ROWNUM DESC) a ";
                                                                                        $query_sumCrossprice = sqlsrv_query($conn, $sql_sumCrossprice, $params_sumCrossprice);
                                                                                        $result_sumCrossprice = sqlsrv_fetch_array($query_sumCrossprice, SQLSRV_FETCH_ASSOC);

                                                                                      }else  if ($_GET['customercode'] == 'TTASTCS'){
                                                                                        $sql_sumActualpricehead= "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICEHEAD)) AS 'SUMACTUALPRICE'
                                                                                           FROM (SELECT  a.ACTUALPRICEHEAD,a.VEHICLETRANSPORTPLANID
                                                                                           FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                                                                           INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                                                                                           WHERE 1 = 1
                                                                                           AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)
                                                                                           AND a.COMPANYCODE = '".$_GET['companycode']."' AND a.CUSTOMERCODE = 'TTASTCS'
                                                                                           AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                                                                                           AND b.VEHICLETRANSPORTPLANID ='" . $result_seReporttransport['VEHICLETRANSPORTPLANID'] . "'
                                                                                           GROUP BY a.VEHICLETRANSPORTPLANID,a.ACTUALPRICEHEAD,a.JOBEND) a";
                                                                                       $query_sumActualpricehead = sqlsrv_query($conn, $sql_sumActualpricehead, $params_sumActualpricehead);
                                                                                       $result_sumActualpricehead = sqlsrv_fetch_array($query_sumActualpricehead, SQLSRV_FETCH_ASSOC);
                                                                                     }else  if ($_GET['customercode'] == 'TTAST'){
                                                                                         $sql_sumActualpricehead= "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICEHEAD)) AS 'SUMACTUALPRICE'
                                                                                            FROM (SELECT  a.ACTUALPRICEHEAD,a.VEHICLETRANSPORTPLANID
                                                                                            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                                                                            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b. VEHICLETRANSPORTPLANID
                                                                                            WHERE 1 = 1
                                                                                            AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)
                                                                                            AND a.COMPANYCODE = '".$_GET['companycode']."' AND a.CUSTOMERCODE = 'TTAST'
                                                                                            AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE != ''
                                                                                            AND b.VEHICLETRANSPORTPLANID ='" . $result_seReporttransport['VEHICLETRANSPORTPLANID'] . "'
                                                                                            GROUP BY a.VEHICLETRANSPORTPLANID,a.ACTUALPRICEHEAD,a.JOBEND) a";
                                                                                        $query_sumActualpricehead = sqlsrv_query($conn, $sql_sumActualpricehead, $params_sumActualpricehead);
                                                                                        $result_sumActualpricehead = sqlsrv_fetch_array($query_sumActualpricehead, SQLSRV_FETCH_ASSOC);
                                                                                        }else {
                                                                                         $sql_sumActualpricehead= "SELECT SUM(DISTINCT CONVERT(DECIMAL(10,3),a.ACTUALPRICEHEAD)) AS 'SUMACTUALPRICE',SUM(DISTINCT CONVERT(DECIMAL(10,3),b.ACTUALPRICE)) AS 'SUMACTUALPRICESKB'
                                                                                                        ,SUM(DISTINCT CONVERT(INT,b.ACTUALPRICE)) AS 'SUMACTUALPRICETTAST'
                                                                                                        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                                                                                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
                                                                                                        WHERE 1 = 1
                                                                                                        AND b.VEHICLETRANSPORTPLANID='".$result_seReporttransport['VEHICLETRANSPORTPLANID']."'";
                                                                                          $query_sumActualpricehead = sqlsrv_query($conn, $sql_sumActualpricehead, $params_sumActualpricehead);
                                                                                          $result_sumActualpricehead = sqlsrv_fetch_array($query_sumActualpricehead, SQLSRV_FETCH_ASSOC);
                                                                                       }
                                                                                   }else {

                                                                                   }
                                                                                  // $result_sumActualpricehead = sqlsrv_fetch_array($query_sumActualpricehead, SQLSRV_FETCH_ASSOC);

                                                                                  /////////SALEPRICE SKB///////////
                                                                                  $sql_sumActualpriceskb= "SELECT SUM(CONVERT(DECIMAL(10,3),ACTUALPRICE)) AS 'SUMACTUALPRICESKB'
                                                                                                  FROM  [dbo].[VEHICLETRANSPORTPLAN]
                                                                                                  WHERE 1 = 1
                                                                                                  AND VEHICLETRANSPORTPLANID='".$result_seReporttransport['VEHICLETRANSPORTPLANID']."'";
                                                                                  $query_sumActualpriceskb = sqlsrv_query($conn, $sql_sumActualpriceskb, $params_sumActualpriceskb);
                                                                                  $result_sumActualpriceskb = sqlsrv_fetch_array($query_sumActualpriceskb, SQLSRV_FETCH_ASSOC);




                                                                                  //////////////////////////////////////////////////////////////////////////////////////////////

                                                                                    if ($_GET['customercode'] =='SKB') {
                                                                                      // echo "SKB";
                                                                                    }else {
                                                                                      $sql_sumActualpriceSTM = "SELECT SUM(CONVERT(INT,ACTUALPRICE))  AS 'ACTUALPRICE'
                                                                                          FROM [dbo].[VEHICLETRANSPORTPLAN] a WHERE 1 = 1
                                                                                          AND ACTUALPRICE IS NOT NULL
                                                                                          AND ACTUALPRICE != '' AND DOCUMENTCODE !='' AND DOCUMENTCODE IS NOT NULL
                                                                                          AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)
                                                                                          AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "' ";
                                                                                      $query_sumActualpriceSTM = sqlsrv_query($conn, $sql_sumActualpriceSTM, $params_sumActualpriceSTM);
                                                                                      $result_sumActualpriceSTM = sqlsrv_fetch_array($query_sumActualpriceSTM, SQLSRV_FETCH_ASSOC);
                                                                                    }


                                                                                  $sql_seExpressway = "SELECT SUM(CONVERT(INT,PAY_EXPRESSWAY15))+
                                                                                  SUM(CONVERT(INT,PAY_EXPRESSWAY25))+
                                                                                  SUM(CONVERT(INT,PAY_EXPRESSWAY45))+
                                                                                  SUM(CONVERT(INT,PAY_EXPRESSWAY45RETURN))+
                                                                                  SUM(CONVERT(INT,PAY_EXPRESSWAY50))+
                                                                                  SUM(CONVERT(INT,PAY_EXPRESSWAY50RETURN))+
                                                                                  SUM(CONVERT(INT,PAY_EXPRESSWAY55))+
                                                                                  SUM(CONVERT(INT,PAY_EXPRESSWAY65))+
                                                                                  SUM(CONVERT(INT,PAY_EXPRESSWAY65RETURN))+
                                                                                  SUM(CONVERT(INT,PAY_EXPRESSWAY75))+
                                                                                  SUM(CONVERT(INT,PAY_EXPRESSWAY100))+
                                                                                  SUM(CONVERT(INT,PAY_EXPRESSWAY105RETURN))+
                                                                                  SUM(CONVERT(INT,PAY_EXPRESSWAY195)) AS 'SUMEXPRESSWAY'
                                                                                  FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                                                                  INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                                                                                  WHERE a.VEHICLETRANSPORTPLANID = '" . $result_seReporttransport['VEHICLETRANSPORTPLANID'] . "'";
                                                                                  $query_seExpressway = sqlsrv_query($conn, $sql_seExpressway, $params_seExpressway);
                                                                                  $result_seExpressway = sqlsrv_fetch_array($query_seExpressway, SQLSRV_FETCH_ASSOC);

                                                                                  $sql_sePayother = "SELECT
                                                                                  CASE
                                                                                      WHEN a.PAY_OTHER IS NULL THEN '0'
                                                                                      ELSE  SUM(CONVERT(INT,a.PAY_OTHER))

                                                                                  END AS 'PAYOTHER'
                                                                                  FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                                                                  INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                                                                                  WHERE a.VEHICLETRANSPORTPLANID ='" . $result_seReporttransport['VEHICLETRANSPORTPLANID'] . "'
                                                                                  GROUP BY PAY_OTHER";
                                                                                  $query_sePayother = sqlsrv_query($conn, $sql_sePayother, $params_sePayother);
                                                                                  $result_sePayother = sqlsrv_fetch_array($query_sePayother, SQLSRV_FETCH_ASSOC);

                                                                                  /////PAYOTHER ในตาราง////////
                                                                                  if ($_GET['companycode'] == 'RKR' || $_GET['companycode'] == 'RKL' ) {
                                                                                      $PAYOTHER = $result_sePayother['PAYOTHER'];
                                                                                  }else {
                                                                                      $PAYOTHER = $result_sePayother['PAYOTHER'] + $result_seExpressway['SUMEXPRESSWAY'];
                                                                                  }




                                                                                    $sql_seRepair = "SELECT SUM(CONVERT(INT,a.PAY_REPAIR)) AS 'SUMREPAIR' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                                                                    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID WHERE a.ACTUALPRICE IS NOT NULL
                                                                                    AND a.VEHICLETRANSPORTPLANID = '" . $result_seReporttransport['VEHICLETRANSPORTPLANID'] . "'";
                                                                                    $query_seRepair = sqlsrv_query($conn, $sql_seRepair, $params_seRepair);
                                                                                    $result_seRepair = sqlsrv_fetch_array($query_seRepair, SQLSRV_FETCH_ASSOC);

                                                                                    $sql_seSystime = "{call megGetdate_v2(?)}";
                                                                                    $params_seSystime = array(
                                                                                        array('select_getdate', SQLSRV_PARAM_IN)
                                                                                    );
                                                                                    $query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
                                                                                    $result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);
                                                                                    $mm = "";
                                                                                    switch ((int) substr($result_seSystime['GETDATE'], 4, 2)) {
                                                                                        case '1': {
                                                                                                $mm = "มกราคม";
                                                                                            }
                                                                                            break;
                                                                                        case '2': {
                                                                                                $mm = "กุมภาพันธ์";
                                                                                            }
                                                                                            break;
                                                                                        case '3': {
                                                                                                $mm = "มีนาคม";
                                                                                            }
                                                                                            break;
                                                                                        case '4': {
                                                                                                $mm = "เมษายน";
                                                                                            }
                                                                                            break;
                                                                                        case '5': {
                                                                                                $mm = "พฤษภาคม";
                                                                                            }
                                                                                            break;
                                                                                        case '6': {
                                                                                                $mm = "มิถุนายน";
                                                                                            }
                                                                                            break;
                                                                                        case '7': {
                                                                                                $mm = "กรกฎาคม";
                                                                                            }
                                                                                            break;
                                                                                        case '8': {
                                                                                                $mm = "สิงหาคม";
                                                                                            }
                                                                                            break;
                                                                                        case '9': {
                                                                                                $mm = "กันยายน";
                                                                                            }
                                                                                            break;
                                                                                        case '10': {
                                                                                                $mm = "ตุลาคม";
                                                                                            }
                                                                                            break;
                                                                                        case '11': {
                                                                                                $mm = "พฤศจิกายน";
                                                                                            }
                                                                                            break;
                                                                                        default : {
                                                                                                $mm = "ธันวาคม";
                                                                                            }
                                                                                            break;
                                                                                    }
                                                                                    $condOilprice1 = " AND COMPANYCODE = '" . $result_seReporttransport['COMPANYCODE'] . "' AND YEAR = '" . substr($result_seSystime['GETDATE'], 0, 4) . "' AND MONTH = '" . $mm . "'";
                                                                                    $condOilprice2 = "";
                                                                                    $condOilprice3 = "";
                                                                                    $sql_seOilprice = "{call megOilprice_v2(?,?,?,?)}";
                                                                                    $params_seOilprice = array(
                                                                                        array('select_oilprice', SQLSRV_PARAM_IN),
                                                                                        array($condOilprice1, SQLSRV_PARAM_IN),
                                                                                        array($condOilprice2, SQLSRV_PARAM_IN),
                                                                                        array($condOilprice3, SQLSRV_PARAM_IN)
                                                                                    );
                                                                                    $query_seOilprice = sqlsrv_query($conn, $sql_seOilprice, $params_seOilprice);
                                                                                    $result_seOilprice = sqlsrv_fetch_array($query_seOilprice, SQLSRV_FETCH_ASSOC);


                                                                                    ////////////////////////////////////FUEL INCENTIVE STM//////////////////////////////////////////////
                                                                                    $sql_mileagestart= "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGESTART',MILEAGETYPE FROM [dbo].[MILEAGE]
                                                                                                       WHERE JOBNO='" . $result_seReporttransport['JOBNO'] . "'
                                                                                                       AND MILEAGETYPE = 'MILEAGESTART'
                                                                                                       ORDER BY CREATEDATE DESC";
                                                                                    $query_mileagestart = sqlsrv_query($conn, $sql_mileagestart, $params_mileagestart);
                                                                                    $result_mileagestart = sqlsrv_fetch_array($query_mileagestart, SQLSRV_FETCH_ASSOC);


                                                                                    /////////////////////////////////////////////////////////////////////////////////////////////////
                                                                                    $sql_mileageend= "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGEEND',MILEAGETYPE FROM [dbo].[MILEAGE]
                                                                                                       WHERE JOBNO='" . $result_seReporttransport['JOBNO'] . "'
                                                                                                       AND MILEAGETYPE = 'MILEAGEEND'
                                                                                                       ORDER BY CREATEDATE DESC";
                                                                                    $query_mileageend = sqlsrv_query($conn, $sql_mileageend, $params_mileageend);
                                                                                    $result_mileageend = sqlsrv_fetch_array($query_mileageend, SQLSRV_FETCH_ASSOC);


                                                                                    $mileage  = ($result_mileageend['MILEAGEEND'] - $result_mileagestart['MILEAGESTART'] );
                                                                                    $FUELSTM1 = ($mileage / 2.75);
                                                                                    $FUELSTM2 = ($FUELSTM1 - 3.47);
                                                                                    $FUELSTMALL = ($FUELSTM2 * $result_seOilprice['PRICE']);


                                                                                    $FUELBTHSTM = ($result_seOilprice['PRICE'] * 3.47);

                                                                                    $WORKINCENSTM = ($result_seReporttransport['E1']);



                                                                                      ////////////////////////// TOTAL ในตาราง////////////////////////////////////////////
                                                                                    // if ($result_seReporttransport['COMPANYCODE'] == 'RKS' && $result_seReporttransport['CUSTOMERCODE'] == 'STM') {
                                                                                    //   $TOTAL = $FUELBTHSTM+$WORKINCENSTM+$result_seRepair['PAY_REPAIR'];
                                                                                    // }else if (($result_seReporttransport['COMPANYCODE'] == 'RKR' || $result_seReporttransport['COMPANYCODE'] == 'RKL') && $result_seReporttransport['CUSTOMERCODE'] == 'TTAST'){
                                                                                    //   $TOTAL = ($result_seOilprice['PRICE'] * $result_seReporttransport['O4'])+$result_seExpressway['SUMEXPRESSWAY']+$result_seReporttransport['E1']+$result_seReporttransport['C3']+$result_seRepair['PAY_REPAIR'];
                                                                                    // }else {
                                                                                    //   $TOTAL = ($result_seOilprice['PRICE'] * $result_seReporttransport['O4'])+$result_seExpressway['SUMEXPRESSWAY']+$result_seReporttransport['E1']+$result_seReporttransport['C3']+$result_seRepair['PAY_REPAIR'];
                                                                                    // }

                                                                                    if ($result_seReporttransport['COMPANYCODE'] == 'RKS' && $result_seReporttransport['CUSTOMERCODE'] == 'STM') {
                                                                                       $TOTAL = $FUELBTHSTM+$WORKINCENSTM+$result_seRepair['PAY_REPAIR']+$PAYOTHER;
                                                                                    }else if (($result_seReporttransport['COMPANYCODE'] == 'RKR' || $result_seReporttransport['COMPANYCODE'] == 'RKL')) {
                                                                                      if ($result_seReporttransport['CUSTOMERCODE'] == 'TTAST') {
                                                                                        $TOTAL = ($result_seOilprice['PRICE'] * $result_seReporttransport['O4'])+$result_seExpressway['SUMEXPRESSWAY']+$result_seReporttransport['E1']+$result_seReporttransport['C3']+$result_seRepair['PAY_REPAIR']+$PAYOTHER;
                                                                                      }else if($result_seReporttransport['CUSTOMERCODE'] == 'SKB'){
                                                                                        $TOTAL = ($result_seOilprice['PRICE'] * $result_seReporttransport['O4'])+$result_seExpressway['SUMEXPRESSWAY']+$result_seReporttransport['E1']+$result_seReporttransport['E2']+$result_seReporttransport['C3']+$result_seRepair['PAY_REPAIR']+$PAYOTHER;
                                                                                      }else {
                                                                                        $TOTAL = ($result_seOilprice['PRICE'] * $result_seReporttransport['O4'])+$result_seExpressway['SUMEXPRESSWAY']+$result_seReporttransport['E1']+$result_seReporttransport['C3']+$result_seRepair['PAY_REPAIR']+$PAYOTHER;
                                                                                      }
                                                                                    }else {
                                                                                        $TOTAL = ($result_seOilprice['PRICE'] * $result_seReporttransport['O4'])+$result_seExpressway['SUMEXPRESSWAY']+$result_seReporttransport['E1']+$result_seReporttransport['C3']+$result_seRepair['PAY_REPAIR']+$PAYOTHER;
                                                                                    }



                                                                                       ////////////////////////// EVA ในตาราง////////////////////////////////////////////
                                                                                       if ($_GET['companycode'] == 'RKS') {
                                                                                         if ($_GET['customercode'] == 'TGT') {
                                                                                           $EVA = ($TOTAL < $result_seActualpriceTGT['PRICE']) ? OK : NG;
                                                                                         }else if ($_GET['customercode'] == 'STM') {
                                                                                           $EVA = ($TOTAL < ($result_seActualprice['PRICE1'] * $result_seTripamount['TRIPAMOUNT'])) ? OK : NG;
                                                                                         }else if ($_GET['customercode'] == 'DENSO-THAI') {
                                                                                           $EVA = ($TOTAL < ($DENSOPRICE)) ? OK : NG;
                                                                                         }else {
                                                                                           $EVA = ($TOTAL < $result_seActualprice['PRICE1']) ? OK : NG;
                                                                                         }
                                                                                       }else if ($_GET['companycode'] == 'RKR' || $_GET['companycode'] == 'RKL') {
                                                                                         if ($_GET['customercode'] == 'SKB') {
                                                                                           $EVA = ($TOTAL < $result_sumActualpriceskb['SUMACTUALPRICESKB']) ? OK : NG;
                                                                                         }else if ($_GET['customercode'] == 'TTAST') {
                                                                                           $EVA = ( $TOTAL < $result_sumActualpricehead['SUMACTUALPRICETTAST'] ) ? OK : NG;
                                                                                         }else if ($_GET['customercode'] == 'TTAT') {
                                                                                           $EVA = ( $TOTAL < $result_sumActualpricehead['SUMACTUALPRICETTAST'] ) ? OK : NG;
                                                                                         }else if ($_GET['customercode'] == 'HINO') {
                                                                                           $EVA = ( $TOTAL < $result_sumActualpricehead['SUMACTUALPRICETTAST'] ) ? OK : NG;
                                                                                         }else if ($_GET['customercode'] == 'SUTT') {
                                                                                           $EVA = ( $TOTAL < $result_sumActualpricehead['SUMACTUALPRICETTAST'] ) ? OK : NG;
                                                                                         }else if ($_GET['customercode'] == 'DAIKI') {
                                                                                           $EVA = ( $TOTAL < $result_sumActualpricehead['SUMACTUALPRICETTAST'] ) ? OK : NG;
                                                                                         }else if ($_GET['customercode'] == 'TTTC') {
                                                                                           $EVA = ( $TOTAL < $result_sumActualpricehead['SUMACTUALPRICETTAST'] ) ? OK : NG;
                                                                                         }else if ($_GET['customercode'] == 'TGT') {
                                                                                           $EVA = ( $TOTAL < $result_sumActualpricehead['SUMACTUALPRICETTAST'] ) ? OK : NG;
                                                                                         }else if ($_GET['customercode'] == 'NITTSUSHOJI') {
                                                                                           $EVA = ( $TOTAL < $result_sumActualpricehead['SUMACTUALPRICETTAST'] ) ? OK : NG;
                                                                                         }else if ($_GET['customercode'] == 'TSAT') {
                                                                                           $EVA = ( $TOTAL < $result_sumActualpricehead['SUMACTUALPRICETTAST'] ) ? OK : NG;
                                                                                         }else if ($_GET['customercode'] == 'PARAGON') {
                                                                                           $EVA = ( $TOTAL < $result_sumActualpricehead['SUMACTUALPRICE'] ) ? OK : NG;
                                                                                         }else {
                                                                                           $EVA = ($TOTAL < $result_sumActualpricehead['SUMACTUALPRICE']) ? OK : NG;
                                                                                         }
                                                                                       }else {
                                                                                         $EVA = 'ไม่มีข้อมูล EVA';
                                                                                       }
                                                                                    // if ($result_seReporttransport['COMPANYCODE'] == 'RKS') {
                                                                                    //
                                                                                    //   if ($result_seReporttransport['CUSTOMERCODE'] == 'TGT') {
                                                                                    //       $EVA = ($TOTAL < $result_seActualpriceTGT['PRICE']) ? OK : NG;
                                                                                    //
                                                                                    //   }else if ($result_seReporttransport['CUSTOMERCODE'] == 'STM') {
                                                                                    //       $EVA = ($TOTAL < ($result_seActualprice['PRICE1'] * $result_seTripamount['TRIPAMOUNT'])) ? OK : NG;
                                                                                    //
                                                                                    //   }else {
                                                                                    //       $EVA = ($TOTAL < $result_seActualprice['PRICE1']) ? OK : NG;
                                                                                    //   }
                                                                                    // }else if ($result_seReporttransport['CUSTOMERCODE'] == 'SKB'){
                                                                                    //
                                                                                    //       $EVA = ($TOTAL < $result_sumActualpriceskb['SUMACTUALPRICESKB']) ? OK : NG;
                                                                                    //
                                                                                    // }else if (($result_seReporttransport['COMPANYCODE'] == 'RKR' || $result_seReporttransport['COMPANYCODE'] == 'RKL') && $result_seReporttransport['CUSTOMERCODE'] == 'TTAST'){
                                                                                    //
                                                                                    //       $EVA = ( $TOTAL < $result_sumActualpricehead['SUMACTUALPRICETTAST'] ) ? OK : NG;
                                                                                    // }else {
                                                                                    //       $EVA = ($TOTAL < $result_sumActualpricehead['SUMACTUALPRICE']) ? OK : NG;
                                                                                    // }

                                                                                    ////////////////////////// PROFIT ในตาราง////////////////////////////////////////////

                                                                                     $SALEPRICESTM = ($result_seActualprice['PRICE1'] * $result_seTripamount['TRIPAMOUNT']);
                                                                                     if ($_GET['companycode'] == 'RKS') {
                                                                                       if ($_GET['customercode'] == 'TGT') {
                                                                                         $PROFIT = (($result_seActualpriceTGT['PRICE']-$TOTAL)*100)/($result_seActualpriceTGT['PRICE']);
                                                                                       }else if ($_GET['customercode'] == 'STM') {
                                                                                         $PROFIT = (($SALEPRICESTM-$TOTAL)*100)/($SALEPRICESTM);
                                                                                       }else if ($_GET['customercode'] == 'DENSO-THAI') {
                                                                                         $PROFIT = (($DENSOPRICE-$TOTAL)*100)/($DENSOPRICE);
                                                                                       }else {
                                                                                         $PROFIT = (($result_seActualprice['PRICE1']-$TOTAL)*100)/($result_seActualprice['PRICE1']);
                                                                                       }
                                                                                     }else if ($_GET['companycode'] == 'RKR' || $_GET['companycode'] == 'RKL') {
                                                                                       if ($_GET['customercode'] == 'SKB') {
                                                                                         $PROFIT = (($result_sumActualpriceskb['SUMACTUALPRICESKB']-$TOTAL)*100)/($result_sumActualpriceskb['SUMACTUALPRICESKB']);
                                                                                       }else if ($_GET['customercode'] == 'TTAST') {
                                                                                         $PROFIT = (($result_sumActualpricehead['SUMACTUALPRICETTAST']-$TOTAL)*100)/($result_sumActualpricehead['SUMACTUALPRICETTAST']);
                                                                                       }else if ($_GET['customercode'] == 'TTAT') {
                                                                                         $PROFIT = (($result_sumActualpricehead['SUMACTUALPRICETTAST']-$TOTAL)*100)/($result_sumActualpricehead['SUMACTUALPRICETTAST']);
                                                                                       }else if ($_GET['customercode'] == 'HINO') {
                                                                                         $PROFIT = (($result_sumActualpricehead['SUMACTUALPRICETTAST']-$TOTAL)*100)/($result_sumActualpricehead['SUMACTUALPRICETTAST']);
                                                                                       }else if ($_GET['customercode'] == 'SUTT') {
                                                                                         $PROFIT = (($result_sumActualpricehead['SUMACTUALPRICETTAST']-$TOTAL)*100)/($result_sumActualpricehead['SUMACTUALPRICETTAST']);
                                                                                       }else if ($_GET['customercode'] == 'DAIKI') {
                                                                                         $PROFIT = (($result_sumActualpricehead['SUMACTUALPRICETTAST']-$TOTAL)*100)/($result_sumActualpricehead['SUMACTUALPRICETTAST']);
                                                                                       }else if ($_GET['customercode'] == 'TTTC') {
                                                                                         $PROFIT = (($result_sumActualpricehead['SUMACTUALPRICETTAST']-$TOTAL)*100)/($result_sumActualpricehead['SUMACTUALPRICETTAST']);
                                                                                       }else if ($_GET['customercode'] == 'TGT') {
                                                                                          $PROFIT = (($result_sumActualpricehead['SUMACTUALPRICETTAST']-$TOTAL)*100)/($result_sumActualpricehead['SUMACTUALPRICETTAST']);
                                                                                       }else if ($_GET['customercode'] == 'NITTSUSHOJI') {
                                                                                          $PROFIT = (($result_sumActualpricehead['SUMACTUALPRICETTAST']-$TOTAL)*100)/($result_sumActualpricehead['SUMACTUALPRICETTAST']);
                                                                                       }else if ($_GET['customercode'] == 'TSAT') {
                                                                                          $PROFIT = (($result_sumActualpricehead['SUMACTUALPRICETTAST']-$TOTAL)*100)/($result_sumActualpricehead['SUMACTUALPRICETTAST']);
                                                                                       }else if ($_GET['customercode'] == 'PARAGON') {
                                                                                          $PROFIT = (($result_sumActualpricehead['SUMACTUALPRICE']-$TOTAL)*100)/($result_sumActualpricehead['SUMACTUALPRICE']);
                                                                                       }else {
                                                                                          $PROFIT = (($result_sumActualpricehead['SUMACTUALPRICE']-$TOTAL)*100)/($result_sumActualpricehead['SUMACTUALPRICE']);
                                                                                       }
                                                                                     }else {
                                                                                        $PROFIT = 'ไม่มีข้อมูล  PROFIT';
                                                                                     }
                                                                                     // if ($_GET['companycode'] == 'RKS') {
                                                                                     //   if ($_GET['customercode'] == 'TGT') {
                                                                                     //     $PROFIT = (($result_seActualpriceTGT['PRICE']-$TOTAL)*100)/($result_seActualpriceTGT['PRICE']);
                                                                                     //   }else if ($_GET['customercode'] == 'STM') {
                                                                                     //     $PROFIT = (($SALEPRICESTM-$TOTAL)*100)/($SALEPRICESTM);
                                                                                     //   }else {
                                                                                     //     $PROFIT = (($result_seActualprice['PRICE1']-$TOTAL)*100)/($result_seActualprice['PRICE1']);
                                                                                     //   }
                                                                                     // }if ($_GET['companycode'] == 'RKR' || $_GET['companycode'] == 'RKL') {
                                                                                     //   if ($_GET['customercode'] == 'SKB') {
                                                                                     //     $PROFIT = (($result_sumActualpriceskb['SUMACTUALPRICESKB']-$TOTAL)*100)/($result_sumActualpriceskb['SUMACTUALPRICESKB']);
                                                                                     //   }else if ($_GET['customercode'] == 'TTAST') {
                                                                                     //     $PROFIT = (($result_sumActualpricehead['SUMACTUALPRICETTAST']-$TOTAL)*100)/($result_sumActualpricehead['SUMACTUALPRICETTAST']);
                                                                                     //   }else if ($_GET['customercode'] == 'TTAT') {
                                                                                     //     $PROFIT = (($result_sumActualpricehead['SUMACTUALPRICETTAST']-$TOTAL)*100)/($result_sumActualpricehead['SUMACTUALPRICETTAST']);
                                                                                     //   }else {
                                                                                     //     $PROFIT = (($result_sumActualpricehead['SUMACTUALPRICE']-$TOTAL)*100)/($result_sumActualpricehead['SUMACTUALPRICE']);
                                                                                     //   }
                                                                                     // }else {
                                                                                     //    $PROFIT = 'ไม่มีข้อมูล  PROFIT';
                                                                                     // }

                                                                                    // if ($result_seReporttransport['COMPANYCODE'] == 'RKS') {
                                                                                    //     if ($result_seReporttransport['CUSTOMERCODE'] == 'TGT') {
                                                                                    //       $PROFIT = (($result_seActualpriceTGT['PRICE']-$TOTAL)*100)/($result_seActualpriceTGT['PRICE']);
                                                                                    //     }else if ($result_seReporttransport['CUSTOMERCODE'] == 'STM'){
                                                                                    //       $PROFIT = (($SALEPRICESTM-$TOTAL)*100)/($SALEPRICESTM);
                                                                                    //     }else {
                                                                                    //       $PROFIT = (($result_seActualprice['PRICE1']-$TOTAL)*100)/($result_seActualprice['PRICE1']);
                                                                                    //     }
                                                                                    // }else if ($result_seReporttransport['COMPANYCODE'] != 'RKS' && $result_seReporttransport['CUSTOMERCODE'] == 'SKB' ) {
                                                                                    //       $PROFIT = (($result_sumActualpriceskb['SUMACTUALPRICESKB']-$TOTAL)*100)/($result_sumActualpriceskb['SUMACTUALPRICESKB']);
                                                                                    // }else if ($result_seReporttransport['COMPANYCODE'] = 'RKR' && $result_seReporttransport['CUSTOMERCODE'] == 'TTAST' ){
                                                                                    //       $PROFIT = (($result_sumActualpricehead['SUMACTUALPRICETTAST']-$TOTAL)*100)/($result_sumActualpricehead['SUMACTUALPRICETTAST']);
                                                                                    // }else {
                                                                                    //       $PROFIT = (($result_sumActualpricehead['SUMACTUALPRICE']-$TOTAL)*100)/($result_sumActualpricehead['SUMACTUALPRICE']);
                                                                                    // }

                                                                                    ?>

                                                                                    <tr>

                                                                                        <td style="text-align: center"><label  style="width: 100px"><?= $i ?></label></td>
                                                                                        <td ><label  style="width: 200px"><?= $result_seReporttransport['JOBNO'] ?></label></td>
                                                                                        <td ><label  style="width: 200px"><?= $result_seReporttransport['THAINAME'] ?></label></td>
                                                                                        <td ><label  style="width: 200px"><?= $result_seReporttransport['EMPLOYEENAME1'] ?></label></td>
                                                                                        <td ><label  style="width: 200px"><?= $result_seReporttransport['COMPANYCODE'] ?></label></td>
                                                                                        <?php
                                                                                        if ($_GET['customercode'] == 'DENSO-THAI') {
                                                                                        ?>
                                                                                        <td ><label  style="width: 200px"><?= $result_seReporttransport['CUSTOMERCODE'] ?>(<?=$result_seReporttransport['JOBSTART']?>)</label></td>
                                                                                        <?php
                                                                                        }else {
                                                                                          ?>
                                                                                          <td ><label  style="width: 200px"><?= $result_seReporttransport['CUSTOMERCODE'] ?></label></td>
                                                                                          <?php
                                                                                        }
                                                                                         ?>
                                                                                        <?php
                                                                                        if ($result_seReporttransport['COMPANYCODE'] == 'RKS') {
                                                                                          if ($_GET['customercode'] == 'STM') {
                                                                                            ?>
                                                                                            <td ><label  style="width: 200px"><?=$result_seTripamount['TRIPAMOUNT']?></label></td>
                                                                                            <?php
                                                                                          }else {
                                                                                           ?>
                                                                                           <td ><label  style="width: 200px">1</label></td>
                                                                                           <?php
                                                                                          }
                                                                                        ?>
                                                                                        <?php
                                                                                        } else {
                                                                                        ?>
                                                                                          <td ><label  style="width: 200px">1</label></td>
                                                                                        <?php
                                                                                        }
                                                                                         ?>

                                                                                         <?php
                                                                                         if ($result_seReporttransport['COMPANYCODE'] == 'RKS') { /* น้ำหนัก WEIGHTINTON*/
                                                                                         ?>
                                                                                         <td ><label  style="width: 200px">-</label></td>
                                                                                         <?php
                                                                                         }else {
                                                                                         ?>
                                                                                         <td ><label  style="width: 200px"><?= number_format($result_seTon['SUMWEIGHTIN'],3)  ?></label></td>
                                                                                         <?php
                                                                                         }

                                                                                          ?>

                                                                                          <!-- SALE PRICE ในตาราง-->
                                                                                          <?php
                                                                                          if ($_GET['companycode'] == 'RKS') {
                                                                                            if ($_GET['customercode'] == 'TGT') {
                                                                                              ?>
                                                                                              <td ><label  style="width: 200px"><?= $result_seActualpriceTGT['PRICE'] ?></label></td> <!-- SALE PRICE TGT ในตาราง-->
                                                                                              <?php
                                                                                            }else if ($_GET['customercode'] == 'STM') {
                                                                                              ?>
                                                                                              <td ><label  style="width: 200px"><?= ($result_seActualprice['PRICE1'] * $result_seTripamount['TRIPAMOUNT']) ?></label></td> <!-- SALE PRICE STM ในตาราง-->
                                                                                              <?php
                                                                                            }else if ($_GET['customercode'] == 'DENSO-THAI'){
                                                                                              ?>
                                                                                              <td ><label  style="width: 200px"><?=$DENSOPRICE?></label></td> <!-- SALE PRICE OTHER ในตาราง-->
                                                                                              <?php
                                                                                            }else {
                                                                                              ?>
                                                                                              <td ><label  style="width: 200px"><?= $result_seActualprice['PRICE1']  ?></label></td> <!-- SALE PRICE OTHER ในตาราง-->
                                                                                              <?php
                                                                                            }
                                                                                            ?>
                                                                                            <?php
                                                                                          }else if ($_GET['companycode'] == 'RKR' || $_GET['companycode'] == 'RKL') {
                                                                                              if ($_GET['customercode'] == 'SKB') {
                                                                                                ?>
                                                                                                <td ><label  style="width: 200px"><?= number_format($result_sumActualpriceskb['SUMACTUALPRICESKB'],2) ?></label></td> <!-- SALE PRICE  RKL SKBในตาราง-->
                                                                                                <?php
                                                                                              }else if ($_GET['customercode'] == 'TTAST') {
                                                                                                ?>
                                                                                                <td ><label  style="width: 200px"><?= number_format($result_sumActualpricehead['SUMACTUALPRICETTAST'],2) ?></label></td> <!-- SALE PRICE  RKR RKL TTAST(TRIP)ในตาราง-->
                                                                                                <?php
                                                                                              }else if ($_GET['customercode'] == 'TTAT') {
                                                                                                ?>
                                                                                                  <td ><label  style="width: 200px"><?= number_format($result_sumActualpricehead['SUMACTUALPRICETTAST'],2) ?></label></td> <!-- SALE PRICE  RKR RKLในตาราง-->
                                                                                                <?php
                                                                                              }else if ($_GET['customercode'] == 'HINO') {
                                                                                                ?>
                                                                                                  <td ><label  style="width: 200px"><?= number_format($result_sumActualpricehead['SUMACTUALPRICETTAST'],2) ?></label></td> <!-- SALE PRICE  RKR RKLในตาราง-->
                                                                                                <?php
                                                                                              }else if ($_GET['customercode'] == 'SUTT') {
                                                                                                ?>
                                                                                                  <td ><label  style="width: 200px"><?= number_format($result_sumActualpricehead['SUMACTUALPRICETTAST'],2) ?></label></td> <!-- SALE PRICE  RKR RKLในตาราง-->
                                                                                                <?php
                                                                                              }else if ($_GET['customercode'] == 'TTTC') {
                                                                                                ?>
                                                                                                  <td ><label  style="width: 200px"><?= number_format($result_sumActualpricehead['SUMACTUALPRICETTAST'],2) ?></label></td> <!-- SALE PRICE  RKR RKLในตาราง-->
                                                                                                <?php
                                                                                              }else if ($_GET['customercode'] == 'TGT') {
                                                                                                ?>
                                                                                                  <td ><label  style="width: 200px"><?= number_format($result_sumActualpricehead['SUMACTUALPRICETTAST'],2) ?></label></td> <!-- SALE PRICE  RKR RKLในตาราง-->
                                                                                                <?php
                                                                                              }else if ($_GET['customercode'] == 'NITTSUSHOJI') {
                                                                                                ?>
                                                                                                  <td ><label  style="width: 200px"><?= number_format($result_sumActualpricehead['SUMACTUALPRICETTAST'],2) ?></label></td> <!-- SALE PRICE  RKR RKLในตาราง-->
                                                                                                <?php
                                                                                              }else if ($_GET['customercode'] == 'TSAT') {
                                                                                                ?>
                                                                                                  <td ><label  style="width: 200px"><?= number_format($result_sumActualpricehead['SUMACTUALPRICETTAST'],2) ?></label></td> <!-- SALE PRICE  RKR RKLในตาราง-->
                                                                                                <?php
                                                                                              }else if ($_GET['customercode'] == 'PARAGON') {
                                                                                                ?>
                                                                                                  <td ><label  style="width: 200px"><?= number_format($result_sumActualpricehead['SUMACTUALPRICE'],2) ?></label></td> <!-- SALE PRICE  RKR RKLในตาราง-->
                                                                                                <?php
                                                                                              }else {
                                                                                                ?>
                                                                                                <td ><label  style="width: 200px"><?= number_format($result_sumActualpricehead['SUMACTUALPRICE'],2) ?></label></td> <!-- SALE PRICE  RKR RKLในตาราง-->
                                                                                                <?php
                                                                                              }
                                                                                          }else {
                                                                                            ?>
                                                                                            <td ><label  style="width: 200px">ไม่มีข้อมูลราคา</label></td> <!-- SALE PRICE  RKR RKLในตาราง-->
                                                                                            <?php
                                                                                          }
                                                                                          ?>


                                                                                        <!-- ค่า DROP ในตาราง-->
                                                                                        <?php
                                                                                        if ($_GET['companycode']  == 'RKR' && $_GET['companycode']  == 'RKR') {
                                                                                          if ($_GET['customercode']  == 'TTASTSTC') {
                                                                                        ?>
                                                                                          <td ><label  style="width: 200px"><?=$result_sumCrossprice['CROSSPRICE']?></label></td> <!-- ค่าควบของสายงาน TTAST-STC เท่านั้น -->
                                                                                        <?php
                                                                                          }else {
                                                                                        ?>
                                                                                          <td ><label  style="width: 200px"></label></td>
                                                                                        <?php
                                                                                          }
                                                                                        }else {
                                                                                        ?>
                                                                                          <td ><label  style="width: 200px"></label></td>
                                                                                        <?php
                                                                                        }
                                                                                        ?>


                                                                                        <!-- ///////////////////////////////////FUEL (L) ในตาราง///////////////////////// -->

                                                                                        <?php
                                                                                        $FUELLITSTM = 3.47;
                                                                                        if ($_GET['companycode']  == 'RKS' && $_GET['customercode']  == 'STM') {
                                                                                        ?>
                                                                                        <td ><label  style="width: 200px"><?=$FUELLITSTM?></label></td> <!-- จำนวนน้ำมันที่เติม FUEL(L)	STM-->
                                                                                        <?php
                                                                                        }else {
                                                                                        ?>
                                                                                        <td ><label  style="width: 200px"><?= $result_seReporttransport['O4'] ?></label></td> <!-- จำนวนน้ำมันที่เติม FUEL(L)	-->
                                                                                        <?php
                                                                                        }
                                                                                         ?>

                                                                                         <!-- /////////////////////////////////////////////////////////////////////// -->

                                                                                         <!--////////////////////////////FUEL(Bth) ในตาราง///////////////////////////////  -->
                                                                                        <?php
                                                                                        if ($_GET['companycode']  == 'RKS' && $_GET['customercode']  == 'STM') {
                                                                                        ?>
                                                                                        <td ><label  style="width: 200px"><?= number_format($FUELBTHSTM,2) ?></label></td><!-- FUEL(Bth)  STM-->
                                                                                        <?php
                                                                                        }else {
                                                                                        ?>
                                                                                        <td ><label  style="width: 200px"><?= number_format($result_seOilprice['PRICE'] * $result_seReporttransport['O4'],2) ?></label></td><!-- FUEL(Bth) -->
                                                                                        <?php
                                                                                        }
                                                                                         ?>

                                                                                         <!-- ///////////////////////////////////////////////////////////////////////////////////////// -->

                                                                                         <!--////////////////////////////////////////TOLLFEE ในตาราง/////////////////////////////////////  -->
                                                                                        <td ><label  style="width: 200px"><?= $PAYOTHER ?></label></td><!--TOLLFEE -->
                                                                                        <!-- ///////////////////////////////////////////////////////////////////////////////////////// -->

                                                                                        <!--////////////////////////////WORKING INCENTIVE ในตาราง///////////////////////////////  -->
                                                                                        <?php
                                                                                        if ($result_seReporttransport['COMPANYCODE'] == 'RKS' && $result_seReporttransport['CUSTOMERCODE'] == 'STM') {
                                                                                        ?>
                                                                                        <td ><label  style="width: 200px"><?= ($result_seReporttransport['E1']  ) ?></label></td><!--WORKING INCENTIVE STM -->

                                                                                        <?php
                                                                                        }else if ($result_seReporttransport['COMPANYCODE'] == 'RKL' && $result_seReporttransport['CUSTOMERCODE'] == 'SKB'){
                                                                                          ?>
                                                                                            <td ><label  style="width: 200px"><?= $result_seReporttransport['E1']+$result_seReporttransport['E2'] ?></label></td><!--WORKING INCENTIVE -->
                                                                                          <?php
                                                                                        }else {
                                                                                          ?>
                                                                                            <td ><label  style="width: 200px"><?= $result_seReporttransport['E1'] ?></label></td><!--WORKING INCENTIVE -->
                                                                                          <?php
                                                                                        }
                                                                                         ?>

                                                                                         <!--//////////////////////////////FUEL INCENTIVE ///////////////////////////////////////////-->
                                                                                        <?php
                                                                                        if ($result_seReporttransport['COMPANYCODE'] == 'RKS' && $result_seReporttransport['CUSTOMERCODE'] == 'STM') {
                                                                                            ?>

                                                                                            <!-- <td ><label  style="width: 200px"><//?= number_format($FUELSTMALL,2) ?></label></td>--> <!--FUEL INCENTIVE -->
                                                                                            <td ><label  style="width: 200px"></label></td> <!--FUEL INCENTIVE -->

                                                                                        <?php
                                                                                      }else {
                                                                                        ?>
                                                                                        <td ><label  style="width: 200px"><?= $result_seReporttransport['C3'] ?></label></td><!--FUEL INCENTIVE -->
                                                                                        <?php
                                                                                       }
                                                                                         ?>
                                                                                          <!-- ///////////////////////////////////////////////////////////////////////////////////////// -->


                                                                                        <td ><label  style="width: 200px"><?= $result_seRepair['PAY_REPAIR'] ?></label></td><!-- REPAIR-->
                                                                                        <td ><label  style="width: 200px"><?= number_format( $TOTAL,2) ?></label></td><!-- TOTAL -->
                                                                                        <td ><label  style="width: 200px"><?=$sumprice?></label></td>
                                                                                        <td ><label  style="width: 200px"><?= $EVA ?></label></td> <!-- EVA -->
                                                                                        <td ><label  style="width: 200px"><?=number_format($PROFIT,2).'%'?></label></td><!-- PROFIT% -->



                                                                                    </tr>
                                                                                    <?php
                                                                                    $i++;

                                                                                    $tripamount++;
                                                                                    $SUMSALEPRICESTM = ($SUMSALEPRICESTM + $SALEPRICESTM);
                                                                                    $SUMCROSSPRICE = ($SUMCROSSPRICE + $result_sumCrossprice['CROSSPRICE']);
                                                                                    $SUMWORKINCENSTM = ($SUMWORKINCENSTM + $WORKINCENSTM);
                                                                                    $SUMFUELLITSTM = ($FUELLITSTM * ($i-1));
                                                                                    $SUMFUELBATHSTM = ($FUELBTHSTM * ($i-1));
                                                                                    $SUMFUELINCENSTM = ($SUMFUELINCENSTM + $FUELSTMALL);

                                                                                    $sum_tripamount = $sum_tripamount + $result_seTripamount['TRIPAMOUNT'];
                                                                                    $sum_weightin = $sum_weightin + $result_seTon['SUMWEIGHTIN'];
                                                                                       
                                                                                    if ($_GET['companycode'] == 'RKR' || $_GET['companycode'] == 'RKL') {
                                                                                      if ($_GET['customercode'] == 'SKB') {
                                                                                        $sum_actualprice = $sum_actualprice + $result_sumActualpriceskb['SUMACTUALPRICESKB'];
                                                                                      }else if ($_GET['customercode'] == 'TTAST') {
                                                                                        $sum_actualprice = $sum_actualprice + $result_sumActualpricehead['SUMACTUALPRICETTAST'];
                                                                                      }else if ($_GET['customercode'] == 'TTAT') {
                                                                                        $sum_actualprice = $sum_actualprice + $result_sumActualpricehead['SUMACTUALPRICETTAST'];
                                                                                      }else if ($_GET['customercode'] == 'HINO') {
                                                                                        $sum_actualprice = $sum_actualprice + $result_sumActualpricehead['SUMACTUALPRICETTAST'];
                                                                                      }else if ($_GET['customercode'] == 'SUTT') {
                                                                                        $sum_actualprice = $sum_actualprice + $result_sumActualpricehead['SUMACTUALPRICETTAST'];
                                                                                      }else if ($_GET['customercode'] == 'TTTC') {
                                                                                        $sum_actualprice = $sum_actualprice + $result_sumActualpricehead['SUMACTUALPRICETTAST'];
                                                                                      }else if ($_GET['customercode'] == 'TGT') {
                                                                                        $sum_actualprice = $sum_actualprice + $result_sumActualpricehead['SUMACTUALPRICETTAST'];
                                                                                      }else if ($_GET['customercode'] == 'NITTSUSHOJI') {
                                                                                        $sum_actualprice = $sum_actualprice + $result_sumActualpricehead['SUMACTUALPRICETTAST'];
                                                                                      }else if ($_GET['customercode'] == 'TSAT') {
                                                                                        $sum_actualprice = $sum_actualprice + $result_sumActualpricehead['SUMACTUALPRICETTAST'];
                                                                                      }else {
                                                                                        $sum_actualprice = $sum_actualprice + $result_sumActualpricehead['SUMACTUALPRICE'];
                                                                                      }
                                                                                    }else {
                                                                                        $sum_actualprice = $sum_actualprice + $result_sumActualpricehead['SUMACTUALPRICE'];
                                                                                    }
                                                                                    // if ($result_seReporttransport['CUSTOMERCODE'] == 'SKB') {
                                                                                    //   $sum_actualprice = $sum_actualprice + $result_sumActualpriceskb['SUMACTUALPRICESKB'];
                                                                                    // }else if (($result_seReporttransport['COMPANYCODE'] == 'RKR' || $result_seReporttransport['COMPANYCODE'] == 'RKL') && $result_seReporttransport['CUSTOMERCODE'] == 'TTAST'){
                                                                                    //   $sum_actualprice = $sum_actualprice + $result_sumActualpricehead['SUMACTUALPRICETTAST'];
                                                                                    // }else {
                                                                                    //   $sum_actualprice = $sum_actualprice + $result_sumActualpricehead['SUMACTUALPRICE'];
                                                                                    // }

                                                                                    $sum_o4 = $sum_o4 + $result_seReporttransport['O4'];
                                                                                    $sum_o4price = $sum_o4price + ($result_seOilprice['PRICE'] * $result_seReporttransport['O4']);

                                                                                    ///////////SUMEXPRESSPAY//////////
                                                                                    if ($_GET['companycode'] == 'RKR' || $_GET['companycode'] == 'RKL' ) {

                                                                                      $sum_expressway = $sum_expressway + $result_sePayother['PAYOTHER'];
                                                                                    }else {
                                                                                      $sum_expressway1 = $sum_expressway1 + $result_seExpressway['SUMEXPRESSWAY'];
                                                                                      $sum_expressway = $sum_expressway1 + $result_sePayother['PAYOTHER'];
                                                                                    }

                                                                                    // ค่าเที่ยวของสายงาน SKB นับคนที่ 1 + คนที่ 2
                                                                                    if ($_GET['companycode'] == 'RKL' && $_GET['customercode'] == 'SKB') {
                                                                                      $sum_e1 = $sum_e1 + ($result_seReporttransport['E1']+$result_seReporttransport['E2']);
                                                                                    }else {
                                                                                      $sum_e1 = $sum_e1 + $result_seReporttransport['E1'];
                                                                                    }


                                                                                    $sum_repair = $sum_repair + $result_seRepair['PAY_REPAIR'];
                                                                                    $sum_total = $sum_total + $TOTAL;

                                                                                    // $TOTALSUM = $sum_o4price+$sum_expressway+$sum_e1+$result_sumActualprice['FUELINCEN'];
                                                                                    if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'STM') {
                                                                                        $TOTALSUM = $sum_o4price+$sum_expressway+$sum_e1;
                                                                                    }else {
                                                                                        $TOTALSUM = $sum_o4price+$sum_expressway+$sum_e1+$result_sumActualprice['FUELINCEN'];
                                                                                    }

                                                                                    // echo $TOTALSUM;

                                                                                    if ($_GET['companycode'] == 'RKS') {
                                                                                      if ($_GET['customercode'] == 'STM') {
                                                                                          $EVAsum = ($sum_total < $SUMSALEPRICESTM) ? OK : NG;
                                                                                      }else if($_GET['customercode'] == 'DENSO-THAI'){
                                                                                          $EVAsum = ($sum_total < $result_seDensoPriceSum['SUMDENSOPRICE']) ? OK : NG;
                                                                                      }else {
                                                                                          $EVAsum = ($sum_total < $result_sumActualprice['SUMPRICE']) ? OK : NG;
                                                                                      }
                                                                                    }else if($_GET['companycode'] == 'RKR' || $_GET['companycode'] == 'RKL' ) {
                                                                                      if ($_GET['customercode'] == 'DAIKI') {
                                                                                        $EVAsum = ($sum_total < $result_sumActualpricerkr['SUMACTUALPRICE']) ? OK : NG;
                                                                                      }else if ($_GET['customercode'] == 'PARAGON') {
                                                                                        $EVAsum = ($sum_total < $result_sumActualpricerkr['SUMACTUALPRICE']) ? OK : NG;
                                                                                      }else if ($_GET['customercode'] == 'NITTSUSHOJI') {
                                                                                        $EVAsum = ($sum_total < $result_sumActualpriceother['SUMPRICEOTHER']) ? OK : NG;
                                                                                      }else if ($_GET['customercode'] == 'TSAT') {
                                                                                        $EVAsum = ($sum_total < $result_sumActualpriceother['SUMPRICEOTHER']) ? OK : NG;
                                                                                      }else {
                                                                                        $EVAsum = ($sum_total < $result_sumActualprice['SUMPRICE']) ? OK : NGF;
                                                                                      }

                                                                                    }else {
                                                                                          $EVAsum = ($sum_total < $result_sumActualprice['SUMPRICE']) ? OK : NG;
                                                                                    }


                                                                                    // if ($_GET['customercode'] == 'STM') {
                                                                                    //   $EVAsum = ($sum_total < $SUMSALEPRICESTM) ? OK : NG;
                                                                                    // }else if ($_GET['customercode'] == 'DENSO-THAI') {
                                                                                    //   $EVAsum = ($sum_total < $result_seDensoPriceSum['SUMDENSOPRICE']) ? OK : NG;
                                                                                    // }else {
                                                                                    //   $EVAsum = ($sum_total < $result_sumActualprice['SUMPRICE']) ? OK : NG55;
                                                                                    // }

                                                                                    // echo $sum_total;
                                                                                    // echo $SUMSALEPRICESTM;


                                                                                    if ($_GET['companycode'] == 'RKS') {
                                                                                      if ($_GET['customercode'] == 'STM') {
                                                                                          $PROFITSUM = (($SUMSALEPRICESTM-$sum_total)*100)/($SUMSALEPRICESTM); /*<!-- PROFIT% ของ RKS-->*/
                                                                                      }else if ($_GET['customercode'] == 'DENSO-THAI') {
                                                                                          $PROFITSUM = (($result_seDensoPriceSum['SUMDENSOPRICE']-$sum_total)*100)/($result_seDensoPriceSum['SUMDENSOPRICE']); /*<!-- PROFIT% ของ RKS-->*/
                                                                                      }else {
                                                                                          $PROFITSUM = (($result_sumActualpriceSTM['ACTUALPRICE']-$sum_total)*100)/($result_sumActualpriceSTM['ACTUALPRICE']); /*<!-- PROFIT% ของ RKS-->*/
                                                                                      }

                                                                                    }else {

                                                                                        $PROFITSUM = (($sum_actualprice-$sum_total)*100)/($sum_actualprice);  /*<!-- PROFIT% ของ RKR,RKL-->*/
                                                                                        // echo $PROFITSUM;
                                                                                    }

                                                                              } //END LOOP WHILE
                                                                                ?>
                                                                            </tbody>

                                                                            <!-- //////////////////////////////Footer/////////////////////////////////////////// -->
                                                                              <tfoot>
                                                                                <tr>
                                                                                    <td colspan="6"></td>
                                                                                    <!-- SUM TRIP AMOUNT-->
                                                                                    <?php
                                                                                    if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'STM') {
                                                                                      ?>
                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?=number_format($sum_tripamount)?></u></label></</td> <!-- จำนวนรอบ TRIPAMOUNT STM -->
                                                                                      <?php
                                                                                    }else {
                                                                                    ?>
                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($tripamount) ?></u></label></</td> <!-- จำนวนรอบ TRIPAMOUNT-->
                                                                                    <?php
                                                                                    }
                                                                                     ?>
                                                                                     <!-- ///////////////////////////////////////////////////////////////-->

                                                                                     <!-- SUM WEIGHTINTON-->
                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sum_weightin,2) ?></u></label></td> <!-- ผลรวมน้ำหนัก  WEIGHTINTON-->
                                                                                    <!-- ///////////////////////////////////////////////////////////////-->

                                                                                    <!-- SUM SALE PRICE-->
                                                                                    <?php
                                                                                    if ($_GET['companycode'] == 'RKS') {
                                                                                      if ($_GET['customercode'] == 'STM') {
                                                                                        ?>
                                                                                      <td ><label  style="width: 200px;background-color: #2fbc50"><u><?=number_format($SUMSALEPRICESTM,2)?></u></label></td> <!-- SALE PRICE ของ RKS-->
                                                                                        <?php
                                                                                      }else if ($_GET['customercode'] == 'DENSO-THAI'){
                                                                                        ?>
                                                                                        <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($result_seDensoPriceSum['SUMDENSOPRICE'],2)?></u></label></td> <!-- SALE PRICE ของ RKS-->
                                                                                      <?php
                                                                                      }else {
                                                                                        ?>
                                                                                        <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($result_sumActualpriceSTM['ACTUALPRICE'],2) ?></u></label></td> <!-- SALE PRICE ของ RKS-->
                                                                                      <?php
                                                                                      }
                                                                                     ?>

                                                                                     <?php
                                                                                    }else {
                                                                                     ?>
                                                                                     <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sum_actualprice,2)?></u></label></td> <!-- SALE PRICE ของ RKR,RKL-->
                                                                                    <?php
                                                                                    }
                                                                                     ?>
                                                                                     <!-- ///////////////////////////////////////////////////////////////-->

                                                                                     <!-- ค่า DROP สายงาน TTAST-STC เท่านั้น-->
                                                                                    <?php
                                                                                    if ($_GET['companycode'] == 'RKR' || $_GET['companycode'] == 'RKL') {
                                                                                      if ($_GET['customercode'] == 'TTASTSTC') {
                                                                                        ?>
                                                                                      <td ><label  style="width: 200px;background-color: #2fbc50"><u><?=number_format($SUMCROSSPRICE,2)?></u></label></td> <!-- SALE PRICE ของ RKS-->
                                                                                        <?php
                                                                                      }else if ($_GET['customercode'] == 'DENSO-THAI'){
                                                                                        ?>
                                                                                        <td ><label  style="width: 200px;background-color: #2fbc50"></label></td> <!-- SALE PRICE ของ RKS-->
                                                                                      <?php
                                                                                      }else {
                                                                                        ?>
                                                                                        <td ><label  style="width: 200px;background-color: #2fbc50"></label></td> <!-- SALE PRICE ของ RKS-->
                                                                                      <?php
                                                                                      }
                                                                                     ?>

                                                                                     <?php
                                                                                    }else {
                                                                                     ?>
                                                                                     <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sum_actualprice,2)?></u></label></td> <!-- SALE PRICE ของ RKR,RKL-->
                                                                                    <?php
                                                                                    }
                                                                                     ?>
                                                                                     <!-- ///////////////////////////////////////////////////////////////-->

                                                                                     <!-- ผลรวมน้ำมันที่เติม  FUEL(L)-->
                                                                                     <?php
                                                                                     if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'STM') {
                                                                                       ?>
                                                                                       <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format ($SUMFUELLITSTM,2) ?></u></label></td><!-- ผลรวมน้ำมันที่เติม  FUEL(L)-->
                                                                                       <?php
                                                                                     }else {
                                                                                        ?>
                                                                                        <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sum_o4,2) ?></u></label></td><!-- ผลรวมน้ำมันที่เติม  FUEL(L)-->
                                                                                        <?php
                                                                                     }
                                                                                      ?>

                                                                                    <!-- ผลรวมราคาน้ำมัน  FUEL(Bth)-->
                                                                                    <?php
                                                                                    if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'STM') {
                                                                                      ?>
                                                                                      <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= $SUMFUELBATHSTM?></u></label></td><!-- ผลรวมราคาน้ำมัน  FUEL(Bth) STM-->
                                                                                      <?php
                                                                                    }else {
                                                                                       ?>
                                                                                       <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sum_o4price,2) ?></u></label></td><!-- ผลรวมราคาน้ำมัน  FUEL(Bth)-->
                                                                                       <?php
                                                                                    }
                                                                                     ?>


                                                                                    <!-- ผลรวมค่าทางด่วน-->
                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sum_expressway) ?></u></label></td> <!-- ผลรวมค่าทางด่วน-->


                                                                                    <!-- SUM WORKING INCENTIVE -->
                                                                                    <?php
                                                                                    if ($_GET['customercode'] == 'STM') {
                                                                                    ?>
                                                                                      <td ><label  style="width: 200px;background-color: #2fbc50"><u><?=number_format($SUMWORKINCENSTM,2)?></u></label></td> <!-- SUM WORKING INCENTIVE -->
                                                                                    <?php
                                                                                    }else {
                                                                                    ?>
                                                                                      <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sum_e1) ?></u></label></td> <!-- SUM WORKING INCENTIVE -->
                                                                                    <?php
                                                                                    }
                                                                                     ?>

                                                                                    <!-- ///////////////////////////////////////////////////////////////-->

                                                                                    <!--  SUM FUEL INCENTIVE -->
                                                                                    <?php
                                                                                    if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'STM') {
                                                                                    ?>
                                                                                    <!-- <td ><label  style="width: 200px;background-color: #2fbc50"><u><//?=number_format($SUMFUELINCENSTM,2)?></u></label></td> --> <!--  SUM FUEL INCENTIVE -->
                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u>00.00</u></label></td>  <!--  SUM FUEL INCENTIVE -->
                                                                                    <?php
                                                                                  }else {
                                                                                    ?>
                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?=number_format($result_sumActualprice['FUELINCEN'],2)?></u></label></td>  <!--  SUM FUEL INCENTIVE -->
                                                                                    <?php
                                                                                  }
                                                                                     ?>
                                                                                    <!-- ///////////////////////////////////////////////////////////////-->

                                                                                    <!-- SUM REPAIR -->
                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sum_repair) ?></u></label></td> <!-- SUM REPAIR -->
                                                                                    <!-- ///////////////////////////////////////////////////////////////-->

                                                                                    <!-- SUM TOTAL -->
                                                                                    <?php
                                                                                    if ($_GET['companycode'] == 'RKS') {
                                                                                      if ($_GET['customercode'] == 'STM') {
                                                                                        ?>
                                                                                        <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sum_total,2) ?></u></label></td> <!-- SUM STM -->
                                                                                        <?php
                                                                                      }else {
                                                                                         ?>
                                                                                         <td ><label  style="width: 200px;background-color: #2fbc50"><u><?= number_format($sum_total,2) ?></u></label></td> <!-- SUM TOTAL -->
                                                                                         <?php
                                                                                      }
                                                                                      ?>

                                                                                      <?php
                                                                                    }else {
                                                                                      ?>
                                                                                      <td ><label  style="width: 200px;background-color: #2fbc50"><u><?=number_format($TOTALSUM,2)?></u></label></td> <!-- SUM TOTAL-->
                                                                                      <?php
                                                                                    }
                                                                                     ?>
                                                                                       <!-- ///////////////////////////////////////////////////////////////-->
                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50">-</label></td> <!-- SUM DEP -->
                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><?=$EVAsum?></label></td> <!-- SUM EVA-->
                                                                                    <td ><label  style="width: 200px;background-color: #2fbc50"><?=number_format($PROFITSUM,2). '%'?></label></td> <!-- SUM PROFIT%-->
                                                                                </tr>
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

           
            <!-- Data Table Export File -->
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
            <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
            <!-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script> -->
            <script src="//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json"></script>

            <script>                                                                  function shows_dailybudget(trip, ton, saleprice, fuell, fuelbth, tolleff, insentive, repair, total, dep, eva, profit)
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
                                                                                                order: [[0, 'asc']],
                                                                                                scrollX: true,
                                                                                                scrollY: '500px',
                                                                                                charset: 'UTF-8',
                                                                                                fieldSeparator: ';',
                                                                                                bom: true,
                                                                                                dom: 'Bfrtip',
                                                                                                lengthMenu: [
                                                                                                    [ 10, 15, 20, -1 ],
                                                                                                    [ '10 rows', '15 rows', '20 rows', 'Show all' ]
                                                                                                ],
                                                                                                buttons: [
                                                                                                  { extend: 'pageLength'},
                                                                                                  { extend: 'csvHtml5', footer: true },
                                                                                                  { extend: 'excelHtml5', footer: true }
                                                                                                  // 'pageLength','csv', 'excel'
                                                                                                ]
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
