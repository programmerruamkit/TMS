<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");


$conn = connect("RTMS");

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
  array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$strExcelFileName = "ReportSummary_Incentive".$result_getDate['SYSDATE'].".xls";
//
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");









?>
<style>
input.largerCheckbox {
  width: 20px;
  height: 20px;
}
</style>

<!-- ////////////////////////////////////////////////10W/STC///////////////////////////////////////////////// -->

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
  <br>
  <table  style="border-collapse: collapse;margin-top:8px;font-size:14px" width="30%"  >
    <label><b>Summary Incentive For <?=$_GET['customercode']?></b></label>
    <tr>
          <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Date</b></td>
          <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Month</td>
          <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Year</td>
          <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Customer</b></td>
          <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Issued by</b></td>
          <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Checked by</b></td>
      <tr>
        <?php
        $date  = $_GET['datestart'];
        $dateplit = explode("/", $date);
        // echo $dateplit[0]; echo '<br>';
        // echo $dateplit[1]; echo '<br>';
        // echo $dateplit[2]; echo '<br>';
        $year=(date("Y")+543);
        // echo $year;
        // echo $jobendsplit[3]; echo '<br>';



         ?>
          <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><?=$dateplit[0];?></td>
          <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><?=$dateplit[1];?></td>
          <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><?=  $year=(date("Y")+543);?></td>
          <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><?=$_GET['customercode']?></td>
          <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"></td>
          <td     style="width: 5%; border:1px solid #000;padding:4px;text-align:center"></td>
    </tr>


        </table>
        <br><br><br>

        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
            <thead>
              <tr>
              <?php
              if ($_GET['companycode'] == 'RKS') {
                if ($_GET['customercode'] == 'TGT') {
                  ?>
                  <th>NO</th>
                  <th>TRUCKNO</th>
                  <th>FIRST-DRIVER</th>
                  <th>SECOND-DRIVER</th>
                  <th>JOBSTART</th>
                  <th>JOBEND</th>
                  <th>MILEAGE(ไมล์ต้น-ไม่ล์ปลาย)</th>
                  <th>DOCUMENTCODE</th>
                  <?php
                }else {
                   ?>
                   <th>NO</th>
                   <th>TRUCKNO</th>
                   <th>FIRST-DRIVER</th>
                   <th>SECOND-DRIVER</th>
                   <th>JOBSTART</th>
                   <th>JOBEND</th>
                   <th>DOCUMENTCODE</th>
                   <?php
                }
              }else {
                 ?>
                   <th>NO</th>
                   <th>TRUCKNO</th>
                   <th>FIRST-DRIVER</th>
                   <th>SECOND-DRIVER</th>
                   <th>JOBSTART</th>
                   <th>JOBEND</th>
                   <th>DOCUMENTCODE</th>
                 <?php
              }
               ?>

                </tr>
            </thead>
            <tbody>

                <?php
                $i1 = 1;
                $countgt = 1;
                $countOther = 1;
                $countplantgt = 0;
                $countplanOther = 0;


                $condiseSummaryIncentive1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)";
                $condiseSummaryIncentive2 = " AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND a.EMPLOYEENAME1 !='ทดสอบ ทดสอบ' AND a.STATUSNUMBER !='0'
                                              GROUP BY a.JOBNO,a.CUSTOMERCODE,a.COMPANYCODE,b.VEHICLETRANSPORTPLANID ORDER BY a.JOBNO ASC";
                $condiseSummaryIncentive3 = "";

                $sql_seSummaryIncentive = " SELECT DISTINCT a.JOBNO AS 'JOBNO',a.COMPANYCODE,a.CUSTOMERCODE,COUNT(a.JOBNO) AS 'COUNT' ,b.VEHICLETRANSPORTPLANID AS 'PLANID'
                          FROM [dbo].[VEHICLETRANSPORTPLAN]  a
                          INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
                          WHERE 1=1  AND a.STATUSNUMBER !='0' " . $condiseSummaryIncentive1 . $condiseSummaryIncentive2 . $condiseSummaryIncentive3;
                $params_seSummaryIncentive = array();
                $query_seSummaryIncentive = sqlsrv_query($conn, $sql_seSummaryIncentive, $params_seSummaryIncentive);
                while ($result_seSummaryIncentive = sqlsrv_fetch_array($query_seSummaryIncentive, SQLSRV_FETCH_ASSOC)) {

                    if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'TGT') {
                        $sql_seDataTGT = "SELECT DISTINCT  TOP 1 b.JOBNO ,b.THAINAME,a.EMPLOYEENAME1 AS 'DRIVER(1)',a.EMPLOYEENAME2 AS 'DRIVER(2)',a.JOBSTART,a.JOBEND,b.DOCUMENTCODE,COUNT(b.JOBNO) AS 'COUNT'
                                    FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID

                                    WHERE  b.EMPLOYEENAME1 !='ทดสอบ ทดสอบ'

                                    AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "'
                                    AND b.JOBNO='" . $result_seSummaryIncentive['JOBNO'] . "'
                                    GROUP BY b.JOBNO ,b.THAINAME,a.EMPLOYEENAME1,a.EMPLOYEENAME2,a.JOBSTART,a.JOBEND,b.DOCUMENTCODE";
                        $params_seDataTGT = array();
                        $query_seDataTGT = sqlsrv_query($conn, $sql_seDataTGT, $params_seDataTGT);
                        $result_seDataTGT = sqlsrv_fetch_array($query_seDataTGT, SQLSRV_FETCH_ASSOC);

                        $sql_seMileagestart = "SELECT DISTINCT TOP 1 JOBNO,MILEAGENUMBER AS 'MILEAGENUMBERSTART',MILEAGETYPE FROM [dbo].[MILEAGE]
                                      WHERE JOBNO='" . $result_seDataTGT['JOBNO'] . "'
                                      AND MILEAGETYPE = 'MILEAGESTART'
                                      AND MILEAGENUMBER != '0'
                                      AND MILEAGENUMBER IS NOT NULL
                                      ORDER BY MILEAGENUMBER DESC
                                      ";
                        $params_seMileagestart = array();
                        $query_seMileagestart = sqlsrv_query($conn, $sql_seMileagestart, $params_seMileagestart);
                        $result_seMileagestart = sqlsrv_fetch_array($query_seMileagestart, SQLSRV_FETCH_ASSOC);

                        $sql_seMileageend = "SELECT DISTINCT TOP 1 JOBNO,MILEAGENUMBER AS 'MILEAGENUMBEREND',MILEAGETYPE FROM [dbo].[MILEAGE]
                                      WHERE JOBNO='" . $result_seDataTGT['JOBNO'] . "'
                                      AND MILEAGETYPE = 'MILEAGEEND'
                                      AND MILEAGENUMBER != '0'
                                      AND MILEAGENUMBER IS NOT NULL
                                      ORDER BY MILEAGENUMBER DESC
                                      ";
                        $params_seMileageend = array();
                        $query_seMileageend = sqlsrv_query($conn, $sql_seMileageend, $params_seMileageend);
                        $result_seMileageend = sqlsrv_fetch_array($query_seMileageend, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>

                            <?php
                            if ($result_seMileagestart['MILEAGENUMBERSTART'] == '' && $result_seMileageend['MILEAGENUMBEREND'] == '') {

                                ?>
                                <td style="text-align: center;background-color: #f06951"><?= $i1 ?></td>
                                <td  style="background-color: #f06951;text-align: center"><?= $result_seDataTGT['THAINAME'] ?></td>
                                <td  style="background-color: #f06951;text-align: left"><?= $result_seDataTGT['DRIVER(1)'] ?></td>
                                <td  style="background-color: #f06951;text-align: left"><?= $result_seDataTGT['DRIVER(2)'] ?></td>
                                <td  style="background-color: #f06951;text-align: left"><?= $result_seDataTGT['JOBSTART'] ?></td>
                                <td  style="background-color: #f06951;text-align: left"><?= $result_seDataTGT['JOBEND'] ?></td>
                                <td  style="background-color: #f06951;text-align: center"><?= $result_seMileagestart['MILEAGENUMBERSTART'] ?> - <?= $result_seMileageend['MILEAGENUMBEREND'] ?> </td>
                                <td  style="background-color: #f06951;text-align: center"><?= $result_seDataTGT['DOCUMENTCODE'] ?></td>
                                <!-- <td  style="background-color: #f06951;text-align: center"><?= $result_seSummaryIncentive['PLANID'] ?></td> -->

                                <?php
                            } else {
                                ?>
                                <td style="text-align: center"><?= $i1 ?></td>
                                <td style="text-align: center"><?= $result_seDataTGT['THAINAME'] ?></td>
                                <td style="text-align: left"><?= $result_seDataTGT['DRIVER(1)'] ?></td>
                                <td style="text-align: left"><?= $result_seDataTGT['DRIVER(2)'] ?></td>
                                <td style="text-align: left"><?= $result_seDataTGT['JOBSTART'] ?></td>
                                <td style="text-align: left"><?= $result_seDataTGT['JOBEND'] ?></td>
                                <td style="text-align: center"><?= $result_seMileagestart['MILEAGENUMBERSTART'] ?> - <?= $result_seMileageend['MILEAGENUMBEREND'] ?> </td>
                                <td style="text-align: center"><?= $result_seDataTGT['DOCUMENTCODE'] ?></td>
                                <!-- <td  style="background-color: #f06951;text-align: center"><?= $result_seSummaryIncentive['PLANID'] ?></td> -->

                                <?php
                            }
                            ?>

                        </tr>
                        <?php
                    } else {
                        $sql_seData = "SELECT DISTINCT  TOP 1 b.JOBNO ,b.THAINAME,a.EMPLOYEENAME1 AS 'DRIVER(1)',a.EMPLOYEENAME2 AS 'DRIVER(2)',a.JOBSTART,a.JOBEND,b.DOCUMENTCODE
                                    FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID

                                    WHERE  b.EMPLOYEENAME1 !='ทดสอบ ทดสอบ'

                                    AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "'
                                    AND b.JOBNO='" . $result_seSummaryIncentive['JOBNO'] . "' ";
                        $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
                        $result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>

                            <?php
                            if ($result_seData['DOCUMENTCODE'] == '') {
                                $counUnsecessOther = $counUnsecessOther + $countOther;
                                ?>
                                <td style="text-align: center;background-color: #f06951"><?= $i1 ?></td>
                                <td  style="background-color: #f06951;text-align: center"><?= $result_seData['THAINAME'] ?></td>
                                <td  style="background-color: #f06951;text-align: left"><?= $result_seData['DRIVER(1)'] ?></td>
                                <td  style="background-color: #f06951;text-align: left"><?= $result_seData['DRIVER(2)'] ?></td>
                                <td  style="background-color: #f06951;text-align: center"><?= $result_seData['JOBSTART'] ?></td>
                                <td  style="background-color: #f06951;text-align: center"><?= $result_seData['JOBEND'] ?></td>
                                <td  style="background-color: #f06951;text-align: center"><?= $result_seData['DOCUMENTCODE'] ?></td>

                                <?php
                            } else {
                                ?>
                                <td style="text-align: center"><?= $i1 ?></td>
                                <td style="text-align: center"><?= $result_seData['THAINAME'] ?></td>
                                <td style="text-align: left"><?= $result_seData['DRIVER(1)'] ?></td>
                                <td style="text-align: left"><?= $result_seData['DRIVER(2)'] ?></td>
                                <td style="text-align: center"><?= $result_seData['JOBSTART'] ?></td>
                                <td style="text-align: center"><?= $result_seData['JOBEND'] ?></td>
                                <td style="text-align: center"><?= $result_seData['DOCUMENTCODE'] ?></td>


                                <?php
                            }
                            ?>

                        </tr>
                        <?php
                    }
                    ?>
                    <?php

                }
                ?>

            </tbody>

        </table>
    </body>
    </html>
