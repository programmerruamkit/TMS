<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานแผนการขนส่ง.xls";
} else {
    if ($_GET['companycode'] == "RKR" && $_GET['customercode'] == "TTASTSTC") {
      // วันเริ่มต้น
      $t1 = substr($_GET['datestart'],0,2); 
      // echo $t1;
      // วันสิ้นสุด
      $t2 = substr($_GET['dateend'],0,2); 
      // echo $t2;
      // เดือน
      $t3 = substr($_GET['dateend'],3,2); 
      // echo $t3;
      $company = "STC";
      // ชื่อไฟล์
      $strExcelFileName = "RKR_".$t1."-".$t2."_".$t3."_".$company.".xls";
      // echo "<br>";
       $strExcelFileName;
    }else if ($_GET['companycode'] == "RKR" && $_GET['customercode'] == "TTASTCS"){
      // วันเริ่มต้น
      $t1 = substr($_GET['datestart'],0,2); 
      // echo $t1;
      // วันสิ้นสุด
      $t2 = substr($_GET['dateend'],0,2); 
      // echo $t2;
      // เดือน
      $t3 = substr($_GET['dateend'],3,2); 
      // echo $t3;
      $company = "CS";
      // ชื่อไฟล์
      $strExcelFileName = "RKR_".$t1."-".$t2."_".$t3."_".$company.".xls";
      // echo "<br>";
       $strExcelFileName;
    }else if ($_GET['companycode'] == "RKL" && $_GET['customercode'] == "TTASTSTC"){
      // วันเริ่มต้น
      $t1 = substr($_GET['datestart'],0,2); 
      // echo $t1;
      // วันสิ้นสุด
      $t2 = substr($_GET['dateend'],0,2); 
      // echo $t2;
      // เดือน
      $t3 = substr($_GET['dateend'],3,2); 
      // echo $t3;
      $company = "STC";
      // ชื่อไฟล์
      $strExcelFileName = "RKL_".$t1."-".$t2."_".$t3."_".$company.".xls";
      // echo "<br>";
       $strExcelFileName;
    }else if ($_GET['companycode'] == "RKL" && $_GET['customercode'] == "TTASTCS"){
      // วันเริ่มต้น
      $t1 = substr($_GET['datestart'],0,2); 
      // echo $t1;
      // วันสิ้นสุด
      $t2 = substr($_GET['dateend'],0,2); 
      // echo $t2;
      // เดือน
      $t3 = substr($_GET['dateend'],3,2); 
      // echo $t3;
      $company = "CS";
      // ชื่อไฟล์
      $strExcelFileName = "RKL_".$t1."-".$t2."_".$t3."_".$company.".xls";
      // echo "<br>";
       $strExcelFileName;
    }else{

    }
    // $strExcelFileName = "รายงานแผนการขนส่งบริษัท".$_GET['companycode']."ตั้งแต่วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
}


header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
?>
<html>
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <table border="1">
            <thead>
                <tr>
                    <th colspan="8"><label style="width: 50px"></label></th>
                    <th colspan="3"><label style="width: 200px"></label></th>
                    <th colspan="3"><label style="width: 200px">WEIGHT</label></th>
                    <th colspan="3"><label style="width: 200px">PRICE</label></th>
                    <th colspan="3"><label style="width: 200px"></label></th>


                </tr>
                <tr>
                    <th><label style="width: 50px">NO</label></th>
                    <th><label style="width: 200px">DATE</label></th>
                    <th><label style="width: 200px">TRUCKNO</label></th>
                    <th><label style="width: 200px">TYPE</label></th>
                    <th><label style="width: 200px">DRIVER</label></th>
                    <th><label style="width: 200px">FROM</label></th>

                    <th><label style="width: 200px">TO</label></th>
                    <th><label style="width: 200px">ZONE</label></th>
                    <th><label style="width: 200px">SECTION</label></th>
                    <th><label style="width: 200px">DESTINATION</label></th>
                    <th><label style="width: 200px">PRICE</label></th>
                    <th><label style="width: 200px">DELIVERY</label></th>
                    <th><label style="width: 200px">CHARGE</label></th>
                    <th><label style="width: 200px">TOTAL</label></th>

                    <th><label style="width: 200px">QTNPRICE</label></th>
                    <th><label style="width: 200px">JOBPRICE</label></th>
                    <th><label style="width: 200px">TYPE</label></th>
                    <th><label style="width: 200px">REMARK</label></th>
                    <th><label style="width: 200px">TRIP</label></th>
                    <th><label style="width: 200px">MONTH</label></th>


                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)";
                // $condiReporttransport2 = "";
                // $condiReporttransport3 = "";

                $sql_seReporttransport1 = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
                a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART AS 'JOBSTART', a.JOBEND AS 'JOBEND',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
                a.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
                ,CONVERT(VARCHAR(10), b.DATEWORKING, 103) AS 'DATE'
                ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',a.REMARK AS 'REMARK'
                ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'
                ,ROW_NUMBER() OVER (PARTITION BY  CONVERT(VARCHAR(10), b.DATEWORKING, 103) ORDER BY b.DATEWORKING) AS 'ROWNUM2'
                FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
                LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

                WHERE a.ACTIVESTATUS = 1
                AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$_GET['customercode']."'
                AND a.DOCUMENTCODE IS NOT NULL
                AND a.DOCUMENTCODE !=''
                AND a.WEIGHTIN IS NOT NULL
                AND a.WEIGHTIN !=''
                AND a.WEIGHTIN !='0' AND a.WEIGHTIN !='-'
                AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
                AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                -- AND CONVERT(DATE,GETDATE()) BETWEEN CONVERT(DATE,c.STARTDATE,103) AND CONVERT(DATE,c.ENDDATE,103)
                GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1,a.EMPLOYEENAME2,a.JOBSTART, a.JOBEND,b.VEHICLETRANSPORTPRICEID,a.VEHICLETRANSPORTPRICEID,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,a.REMARK,b.DATEWORKING
                ORDER BY b.DATEWORKING ASC";

                $query_seReporttransport = sqlsrv_query($conn,$sql_seReporttransport1, $params_seReporttransport);
                while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {
                  $weightin = $result_seReporttransport['WEISUM']/1000;

                  ///////////////////ZONE LOCATION PRICE/////////////////////
                  $sql_seBillingData = "SELECT  BILLING2 AS 'BILLING'
                  FROM [dbo].[VEHICLETRANSPORTPRICE] 
                  WHERE COMPANYCODE ='".$_GET['companycode']."' 
                  AND [FROM] = '".$result_seReporttransport['JOBSTART']."' AND [TO] ='".$result_seReporttransport['JOBEND']."'
                  AND CONVERT(DATE,GETDATE()) BETWEEN CONVERT(DATE,STARTDATE,103) AND CONVERT(DATE,ENDDATE,103)";
                  $params_seBillingData = array();
                  $query_seBillingData = sqlsrv_query($conn, $sql_seBillingData, $params_seBillingData);
                  $result_seBillingData = sqlsrv_fetch_array($query_seBillingData, SQLSRV_FETCH_ASSOC);

                  ///////////////////ZONE LOCATION PRICE/////////////////////
                  $sql_sePriceData = "SELECT [ZONE] AS 'ZONE',[LOCATION] AS 'LOCATION',PRICE  AS 'PRICE',BILLING1 AS 'BILLING'
                          FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE VEHICLETRANSPORTPRICEID ='".$result_seReporttransport['DOPRICE']."'";
                  $params_sePriceData = array();
                  $query_sePriceData = sqlsrv_query($conn, $sql_sePriceData, $params_sePriceData);
                  $result_sePriceData = sqlsrv_fetch_array($query_sePriceData, SQLSRV_FETCH_ASSOC);


                  ///////////////TOTAL PRICE///////////////////////////////////
                  if ($result_seReporttransport['REMARK'] == 'Charge 10') {
                    $TotalPrice = $result_sePriceData['PRICE']*10;
                    $CD = 'D';
                  }elseif ($result_seReporttransport['REMARK'] == 'Charge 7') {
                    $TotalPrice = $result_sePriceData['PRICE']*7;
                    $CD = 'C';
                  }else {
                    $TotalPrice = $result_sePriceData['PRICE']*$weightin;
                    $CD = 'D';
                  }

                  //////////////////////TOTA: WEIGHTIN//////////////////////////////////////
                  if ($result_seReporttransport['REMARK'] == 'Charge 10') {
                    $TotalWeightin = 10.000;
                  }elseif ($result_seReporttransport['REMARK'] == 'Charge 7') {
                    $TotalWeightin = 7.000;
                  }else {
                    $TotalWeightin = $weightin;
                  }

                  /////////////NO///////////////////////
                  if ($result_seReporttransport['ROWNUM'] > 1  ) {
                    $i--;
                    $NO = '';
                  }else {
                    if ($result_seReporttransport['ROWNUM2'] == 1) {
                      $i = 1;
                      $NO = $i;
                    }else{

                    }
                    $NO = $i;
                  }

                  

                  ///////////////////////////////////////
                 $MM =  substr($result_seReporttransport['DATE'],3,-5);
                    ?>

                    <tr>
                        <td><?= $NO ?></td>
                        <td><?= $result_seReporttransport['DATE'] ?></td>
                        <td><?= $result_seReporttransport['THAINAME'] ?></td>
                        <td><?= $result_seReporttransport['VEHICLETYPE'] ?></td>
                        <td><?= $result_seReporttransport['EMP1'] ?></td>
                        <td>STC Amatanakorn</td>
                        <td><?= $result_seReporttransport['JOBEND'] ?></td>
                        <td><?= $result_sePriceData['LOCATION'] ?></td>
                        <td><?= $result_seBillingData['BILLING'] ?></td>
                        <td><?=$CD?></td>
                        <td><?= $result_sePriceData['PRICE'] ?></td>
                        <td><?= $weightin ?></td>
                        <td><?= number_format($TotalWeightin-$weightin,3)?></td>
                        <td><?= number_format($TotalWeightin,3) ?></td>

                        <td><?= $result_sePriceData['PRICE'] ?></td>
                        <td><?= $TotalPrice ?></td>
                        <td> ไม่ระบุ </td>
                        <td></td>
                        <td></td>
                        <td><?= $MM ?></td>



                    </tr>
                    <?php
                    $i++;
                }
                ?>




            </tbody>
        </table>
    </body>
</html>
