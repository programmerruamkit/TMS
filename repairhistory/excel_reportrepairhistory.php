<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
error_reporting(E_ERROR | E_PARSE);
$conn = connect("RTMS");

    $strExcelFileName = "ReportRepair.xls";

  //
  // header("Content-Type: application/vnd.ms-excel");
  // header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
  // header("Pragma:no-cache");

  header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
  header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
  header("Pragma:no-cache");
?>
<html>
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
      <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
          <thead>
                <tr>
                    <th style="text-align: center">NO</th>
                    <th style="text-align: center">NICKNM</th>
                    <th style="text-align: center">วันที่</th>
                    <th style="text-align: center">REGNO</th>
                    <th style="text-align: center">JOBNO</th>
                    <th style="text-align: center">TYPNAME</th>
                    <th style="text-align: center">รายละเอียด</th>
                    <th style="text-align: center">ปริมาณ</th>
                    <th style="text-align: center">ราคาต่อหน่วย</th>
                    <th style="text-align: center">รวมเป็นเงิน</th>
                    <th style="text-align: center">SERVICEFEE</th>
                    <th style="text-align: center">NAME</th>
                </tr>
          </thead>
          <tbody>
            <?php
            $i = 1;
            //DESC1 =รายละเอียด ,QTYBOD=ปริมาณ,NETPRC=ราคาต่อหน่วย,TOTPRC=รวมเป็นเงิน
          $REGNO = ($_GET['vehiclenumber'] == "")?"":" AND c.REGNO LIKE '" . $_GET['vehiclenumber'] . "'";
          $NAME = ($_GET['name'] == "")?"":" AND g.NAME LIKE '" . $_GET['name'] . "'";
          $DESC1 = ($_GET['desc1'] == "")? "":" AND e.DESC1 LIKE '%" . $_GET['desc1'] . "%'";
          $sql_seRepairData = "SELECT DISTINCT f.NICKNM,CONVERT(VARCHAR(10),a.TAXDATE,103)  AS 'DATE', c.REGNO, a.JOBNO ,
          b.TYPNAME, e.DESC1 AS 'DESC1', d.QTYBOD AS 'QTYBOD',
          d.NETPRC AS 'NETPRC', d.TOTPRC AS 'TOTPRC',a.TSV_TOT + a.OUTJTOT AS 'SERVICEFEE',g.NAME
          FROM [203.150.29.241\SQLEXPRESS,1434].[ELASTIC].[dbo].L_JOBORDER a
          INNER JOIN [203.150.29.241\SQLEXPRESS,1434].[ELASTIC].[dbo].L_SVTYPE b ON b.TYPCOD = a.REPTYPE
          INNER JOIN [203.150.29.241\SQLEXPRESS,1434].[ELASTIC].[dbo].L_SVMAST c ON a.STRNO = c.STRNO
          INNER JOIN [203.150.29.241\SQLEXPRESS,1434].[ELASTIC].[dbo].L_SV_ORDTN d ON a.JOBNO = d.JOBNO
          INNER JOIN [203.150.29.241\SQLEXPRESS,1434].[ELASTIC].[dbo].L_INVENTOR e ON d.PARTNO = e.PARTNO
          INNER JOIN [203.150.29.241\SQLEXPRESS,1434].[ELASTIC].[dbo].CUSTMAST f ON a.CUSCOD = f.CUSCOD
          INNER JOIN [203.150.29.241\SQLEXPRESS,1434].[ELASTIC].[dbo]. OFFICER g ON a.REPCOD = g.CODE
          WHERE 1=1

          AND CONVERT(DATE,a.TAXDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)" . $REGNO . $NAME . $DESC1;
            $params_seRepairData = array();
            $query_seRepairData = sqlsrv_query($conn, $sql_seRepairData, $params_seRepairData);
            while ($result_seRepairData = sqlsrv_fetch_array($query_seRepairData, SQLSRV_FETCH_ASSOC)) {



                ?>
                                <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td style="text-align: center"><?=$result_seRepairData['NICKNM']?></td>
                                    <td style="text-align: center"><?=$result_seRepairData['DATE']?></td>
                                    <td style="text-align: center"><?=$result_seRepairData['REGNO']?></td>
                                    <td style="text-align: center"><?=$result_seRepairData['JOBNO']?></td>
                                    <td style="text-align: center"><?=$result_seRepairData['TYPNAME']?></td>
                                    <td style="text-align: center"><?=$result_seRepairData['DESC1']?></td>
                                    <td style="text-align: center"><?=$result_seRepairData['QTYBOD']?></td>
                                    <td style="text-align: center"><?=$result_seRepairData['NETPRC']?></td>
                                    <td style="text-align: center"><?=$result_seRepairData['TOTPRC']?></td>
                                    <td style="text-align: center"><?=$result_seRepairData['SERVICEFEE']?></td>
                                    <td style="text-align: center"><?=$result_seRepairData['NAME']?></td>


                                </tr>
                <?php
                $i++;
            }
            ?>

          </tbody>
      </table>
    </body>
</html>
