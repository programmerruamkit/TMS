
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
            Action Plan For TGT Present


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

                  <b>  Action Plan For TGT Present</b> &nbsp;&nbsp;&nbsp;
                      <a href="#" onclick="excel_reporttransportactiontgt();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>
                </div>
              </div>
            </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
              <!-- Tab panes -->
              <div class="tab-content">

                <div class="row">&nbsp;</div>

                <div class="row">
                  <div class="col-lg-12">
                    <div class="panel panel-default">
                      <!-- <div class="panel-heading" style="background-color: #e7e7e7">
                      Action Plan For TGT Present <a href="#" onclick="excel_reporttransportpalnstm();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>

                    </div> -->
                    <!-- /.panel-heading -->
                    <table   style="border-collapse: collapse;margin-top:8px;font-size:16px" width="100%"  >

                      <tr>
                        <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:left"><b>Month</b></td>
                        <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Jan</b></td>
                        <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Feb</b></td>
                        <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Mar</b></td>
                        <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Apr</b></td>
                        <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>May</b></td>
                        <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Jun</b></td>
                        <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Jul</b></td>
                        <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Aug</b></td>
                        <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Sep</b></td>
                        <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Oct</b></td>
                        <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Nov</b></td>
                        <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Dec</b></td>
                        <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Total</b></td>
                      </tr>

                      <!-- /////////////////////////////////////PLAN//////////////////////////////////////////////// -->

                      <tr style="border-collapse: collapse;margin-top:8px;font-size:16px" width="100%">
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><b>Plan (trip)</b></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                      </tr>

                      <!-- /////////////////////////////////////ACTUAL////////////////////////////////////////// -->
                      <?php
                      $sql_monthJan = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE  DATEPART(MONTH, DATEINPUT) IN ('1')
                      AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
                      $params_monthJan = array();
                      $query_monthJan = sqlsrv_query($conn, $sql_monthJan, $params_monthJan);
                      $result_monthJan = sqlsrv_fetch_array($query_monthJan, SQLSRV_FETCH_ASSOC);

                      $sql_monthFeb = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE  DATEPART(MONTH, DATEINPUT) IN ('2')
                      AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
                      $params_monthFeb = array();
                      $query_monthFeb = sqlsrv_query($conn, $sql_monthFeb, $params_monthFeb);
                      $result_monthFeb = sqlsrv_fetch_array($query_monthFeb, SQLSRV_FETCH_ASSOC);

                      $sql_monthMar = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE  DATEPART(MONTH, DATEINPUT) IN ('3')
                      AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
                      $params_monthMar = array();
                      $query_monthMar  = sqlsrv_query($conn, $sql_monthMar, $params_monthMar);
                      $result_monthMar  = sqlsrv_fetch_array($query_monthMar, SQLSRV_FETCH_ASSOC);

                      $sql_monthApr = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE  DATEPART(MONTH, DATEINPUT) IN ('4')
                      AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
                      $params_monthApr = array();
                      $query_monthApr = sqlsrv_query($conn, $sql_monthApr, $params_monthApr);
                      $result_monthApr = sqlsrv_fetch_array($query_monthApr, SQLSRV_FETCH_ASSOC);

                      $sql_monthMay = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE  DATEPART(MONTH, DATEINPUT) IN ('5')
                      AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
                      $params_monthMay = array();
                      $query_monthMay = sqlsrv_query($conn, $sql_monthMay, $params_monthMay);
                      $result_monthMay = sqlsrv_fetch_array($query_monthMay, SQLSRV_FETCH_ASSOC);

                      $sql_monthJun = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE  DATEPART(MONTH, DATEINPUT) IN ('6')
                      AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
                      $params_monthJun = array();
                      $query_monthJun = sqlsrv_query($conn, $sql_monthJun, $params_monthJun);
                      $result_monthJun = sqlsrv_fetch_array($query_monthJun, SQLSRV_FETCH_ASSOC);

                      $sql_monthJul = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE  DATEPART(MONTH, DATEINPUT) IN ('7')
                      AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
                      $params_monthJul= array();
                      $query_monthJul = sqlsrv_query($conn, $sql_monthJul, $params_monthJul);
                      $result_monthJul = sqlsrv_fetch_array($query_monthJul, SQLSRV_FETCH_ASSOC);

                      $sql_monthAug = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE  DATEPART(MONTH, DATEINPUT) IN ('8')
                      AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
                      $params_monthAug = array();
                      $query_monthAug = sqlsrv_query($conn, $sql_monthAug, $params_monthAug);
                      $result_monthAug = sqlsrv_fetch_array($query_monthAug, SQLSRV_FETCH_ASSOC);

                      $sql_monthSep = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE  DATEPART(MONTH, DATEINPUT) IN ('9')
                      AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
                      $params_monthSep = array();
                      $query_monthSep = sqlsrv_query($conn, $sql_monthSep, $params_monthSep);
                      $result_monthSep = sqlsrv_fetch_array($query_monthSep, SQLSRV_FETCH_ASSOC);

                      $sql_monthOct = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE  DATEPART(MONTH, DATEINPUT) IN ('10')
                      AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
                      $params_monthOct = array();
                      $query_monthOct = sqlsrv_query($conn, $sql_monthOct, $params_monthOct);
                      $result_monthOct = sqlsrv_fetch_array($query_monthOct, SQLSRV_FETCH_ASSOC);

                      $sql_monthNov = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE  DATEPART(MONTH, DATEINPUT) IN ('11')
                      AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
                      $params_monthNov = array();
                      $query_monthNov = sqlsrv_query($conn, $sql_monthNov, $params_monthNov);
                      $result_monthNov = sqlsrv_fetch_array($query_monthNov, SQLSRV_FETCH_ASSOC);

                      $sql_monthDec = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE  DATEPART(MONTH, DATEINPUT) IN ('12')
                      AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
                      $params_monthDec = array();
                      $query_monthDec = sqlsrv_query($conn, $sql_monthDec, $params_monthDec);
                      $result_monthDec = sqlsrv_fetch_array($query_monthDec, SQLSRV_FETCH_ASSOC);

                      $sum = ($result_monthJan['COUNT']+$result_monthFeb['COUNT']+$result_monthMar['COUNT']+
                      $result_monthApr['COUNT']+$result_monthMay['COUNT']+$result_monthJun['COUNT']+
                      $result_monthJul['COUNT']+$result_monthAug['COUNT']+$result_monthSep['COUNT']+
                      $result_monthOct['COUNT']+$result_monthNov['COUNT']+$result_monthDec['COUNT'])


                      ?>
                       <?php
                        $sumtotal = str_replace('.00', '', number_format($sum, 2));
                        ?>
                      <tr style="border-collapse: collapse;margin-top:8px;font-size:16px" width="100%">
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><b>Actual (trip)</b></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthJan['COUNT']  == ''  ? '0' : $result_monthJan['COUNT'])?></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthFeb['COUNT']  == ''  ? '0' : $result_monthFeb['COUNT'])?></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthMar['COUNT']  == ''  ? '0' : $result_monthMar['COUNT'])?></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthApr['COUNT']  == ''  ? '0' : $result_monthApr['COUNT'])?></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthMay['COUNT']  == ''  ? '0' : $result_monthMay['COUNT'])?></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthJun['COUNT']  == ''  ? '0' : $result_monthJun['COUNT'])?></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthJul['COUNT']  == ''  ? '0' : $result_monthJul['COUNT'])?></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthAug['COUNT']  == ''  ? '0' : $result_monthAug['COUNT'])?></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthSep['COUNT']  == ''  ? '0' : $result_monthSep['COUNT'])?></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthOct['COUNT']  == ''  ? '0' : $result_monthOct['COUNT'])?></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthNov['COUNT']  == ''  ? '0' : $result_monthNov['COUNT'])?></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthDec['COUNT']  == ''  ? '0' : $result_monthDec['COUNT'])?></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$sumtotal?></td>
                      </tr>

                      <!-- ////////////////////////////////Target (100%)///////////////////////////////////////////////////// -->

                      <tr style="border-collapse: collapse;margin-top:8px;font-size:16px" width="100%">
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><b>Target (100%)</b></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
                      </tr>

                      <!-- ////////////////////////////////Result (%)///////////////////////////////////////////////////////// -->

                      <tr style="border-collapse: collapse;margin-top:8px;font-size:16px" width="100%">
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><b>Result (%)</b></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
                      </tr>

                    </table>

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
  <script>


  function excel_reporttransportactiontgt()
  {
    // alert("test");
   window.open('excel_reporttransportaction-tgt.php', '_blank');

  }

  </script>


</body>

</html>

<?php
sqlsrv_close($conn);
?>
