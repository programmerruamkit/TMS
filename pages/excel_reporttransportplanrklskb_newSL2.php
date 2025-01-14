<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "เอกสารแนบการวางบิล(ADC-Dealer(SL2)).xls";
} else {
    $strExcelFileName = "เอกสารแนบการวางบิล(ADC-Dealer(SL2))" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
}

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

// header("Content-Type: application/vnd.ms-excel");
// header("Content-Disposition: inline; filename=\"$strExcelFileName\"");

?>
<html>                                                                                                              
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        
        <table style="width: 100%;">
            <thead>
                <tr>
                    <td colspan="17" style="text-align:center;font-size:16px"><b>เอกสารแนบการวางบิล</b></td>
                </tr>
                <tr>
                    <td colspan="17" style="text-align:center;font-size:16px"><b><?= $_GET['datestart']?> - <?= $_GET['dateend']?></b></td>
                </tr>
            </thead>
                <tr>
                    <td colspan="17"    style="font-size:12px"><br></td>
                </tr>
            <tbody>
                <tr>
                        <td colspan="12"    style="font-size:14px">ADC,KDC TO DEALER ( 2 LEVEL TRAILER )</td>
                        <td colspan="5"     style="text-align:right;font-size:14px">No.1</td>
                </tr>
            </tbody>
        </table>

        <!-- <tr>
            <td colspan="12" style="text-align:right;">ADC,KDC TO DEALER ( 2 LEVEL TRAILER )</td>
            <td colspan="15" style="text-align:right;">ADC,KDC TO DEALER ( 2 LEVEL TRAILER )</td>
        </tr> -->
        <table border="1" id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
            <thead>
                <tr>
                    <th> <label style="width: 50px;text-align: center">No.</label></th>
                    <th> <label style="width: 200px;text-align: center">Date.</label></th>
                    <th> <label style="width: 200px;text-align: center">Origin.</label></th>
                    <th> <label style="width: 200px;text-align: left">Destination.</label></th>
                    <th> <label style="width: 200px;text-align: left">Zone.</label></th>
                    <th> <label style="width: 200px;text-align: left">Sector.</label></th>
                    <th> <label style="width: 200px;text-align: center">Document Number.</label></th>
                    <th> <label style="width: 200px;text-align: center">Driver 1.</label></th>
                    <th> <label style="width: 200px;text-align: center">Driver 2.</label></th>
                    <th> <label style="width: 200px;text-align: center">Truck.</label></th>
                    <th> <label style="width: 200px;text-align: center">Unit.</label></th>
                    <th> <label style="width: 200px;text-align: center">Total Distance.<br>(Km.)</label></th>
                    <th> <label style="width: 200px;text-align: center">Price<br>(Baht/Trip).</label></th>
                    <th> <label style="width: 200px;text-align: center">Express Way<br>(Baht/Trip).</label></th>
                    <th> <label style="width: 200px;text-align: center">Fix cost</label></th>
                    <th> <label style="width: 200px;text-align: center">Total</label></th>
                    <th> <label style="width: 200px;text-align: center">Remark</label></th>
                   

                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                // $condBillings1 = " AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) ";
                // $condBillings2 = " AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'  ";
                // $condBillings3 = " ";

                $sql_seBilling = "SELECT ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY c.[ZONE],b.VEHICLETRANSPORTPLANID ASC) AS 'RUNNUMBER', 
                    ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID,c.[ZONE] ORDER BY c.[ZONE],b.VEHICLETRANSPORTPLANID ASC) AS 'RUNNUMBER_BILLING1', 
                    b.JOBNO,b.VEHICLETRANSPORTPLANID,b.VEHICLETYPE,CONVERT(VARCHAR(30), b.DATEWORKING, 106)  AS 'DATEWORKING_106',
                    CONVERT(VARCHAR(30), b.DATEWORKING, 103)  AS 'DATEWORKING_103',
                    b.JOBSTART,a.JOBEND,c.[ZONE],c.BILLING1,c.BILLING2,b.THAINAME,b.THAINAME2,a.EMPLOYEENAME1, a.EMPLOYEENAME2,a.DOCUMENTCODE,a.TRIPAMOUNT
                    FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                    INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON a.VEHICLETRANSPORTPRICEID = c.VEHICLETRANSPORTPRICEID
                    WHERE a.ACTIVESTATUS = 1
                    AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                    AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'SKB'  
                    AND b.VEHICLETYPE ='ADC-Dealer(SL2)'
                    AND (a.DOCUMENTCODE IS NOT NULL OR a.DOCUMENTCODE != '')------------------------------------*+
                    --GROUP BY b.JOBNO,b.VEHICLETRANSPORTPLANID,b.VEHICLETYPE,CONVERT(VARCHAR(30), b.DATEWORKING, 106) ,
                    --b.JOBSTART,a.JOBEND,b.THAINAME,b.THAINAME2,a.EMPLOYEENAME1, a.EMPLOYEENAME2,a.DOCUMENTCODE,a.TRIPAMOUNT
                    ORDER BY JOBNO ASC";
                $params_seBilling = array();
                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                    
                    // $sql_seTodetail = "SELECT TOP 1  BILLING1,BILLING2,[ZONE] FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE LOCATION = '".$result_seBilling['JOBEND']."'
                    //                 AND COMPANYCODE ='RKL' AND CUSTOMERCODE ='SKB'
                    //                 AND VEHICLETYPE ='".$result_seBilling['VEHICLETYPE']."'
                    //                 AND CONVERT(DATE,GETDATE()) BETWEEN CONVERT(DATE,STARTDATE) AND CONVERT(DATE,ENDDATE)";
                    // $query_seTodetail   = sqlsrv_query($conn, $sql_seTodetail, $params_seTodetail);
                    // $result_seTodetail  = sqlsrv_fetch_array($query_seTodetail, SQLSRV_FETCH_ASSOC);  
                    
                    /// หาภาคที่จังหวัดนั้นๆอยู่
                    $sql_ChkZone = "SELECT [ZONE] AS 'ZONE' FROM ZONEFORSKB WHERE PROVINCE = '".$result_seBilling['ZONE']."'";
                    $params_ChkZone = array();
                    $query_ChkZone  = sqlsrv_query($conn, $sql_ChkZone, $params_ChkZone);
                    $result_ChkZone = sqlsrv_fetch_array($query_ChkZone, SQLSRV_FETCH_ASSOC);


                    $sql_seDistance = "SELECT CONVERT(INT,MILEAGEEND-MILEAGESTART) AS 'SUMMILEAGE'
                        FROM MILEAGE_SUMMARY WHERE JOBNO ='".$result_seBilling['JOBNO']."'";
                    $params_seDistance  = array();
                    $query_seDistance   = sqlsrv_query($conn, $sql_seDistance, $params_seDistance);
                    $result_seDistance  = sqlsrv_fetch_array($query_seDistance, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seOtherdata = "SELECT PAY_OTHER,PAY_CONDITION
                        FROM VEHICLETRANSPORTDOCUMENTDIRVER WHERE VEHICLETRANSPORTPLANID ='".$result_seBilling['VEHICLETRANSPORTPLANID']."'
                        AND (PAY_OTHER IS NOT NULL OR PAY_OTHER !='' OR PAY_CONDITION IS NOT NULL OR PAY_CONDITION !='')";
                    $params_seOtherdata  = array();
                    $query_seOtherdata   = sqlsrv_query($conn, $sql_seOtherdata, $params_seOtherdata);
                    $result_seOtherdata  = sqlsrv_fetch_array($query_seOtherdata, SQLSRV_FETCH_ASSOC);

                    // $sql_semileagestart = "SELECT TOP 1 MILEAGENUMBER  AS 'MILEAGESTART'
                    //     FROM MILEAGE  
                    //     WHERE JOBNO ='".$result_seBilling['JOBNO']."'
                    //     AND MILEAGETYPE ='MILEAGESTART' 
                    //     ORDER BY CREATEDATE DESC";
                    // $params_semileagestart = array();
                    // $query_semileagestart = sqlsrv_query($conn, $sql_semileagestart, $params_semileagestart);
                    // $result_semileagestart = sqlsrv_fetch_array($query_semileagestart, SQLSRV_FETCH_ASSOC);

                    // $sql_semileageend = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGEEND'
                    //     FROM MILEAGE  
                    //     WHERE JOBNO ='".$result_seBilling['JOBNO']."'
                    //     AND MILEAGETYPE ='MILEAGEEND' 
                    //     ORDER BY CREATEDATE DESC";
                    // $params_semileageend = array();
                    // $query_semileageend  = sqlsrv_query($conn, $sql_semileageend, $params_semileageend);
                    // $result_semileageend = sqlsrv_fetch_array($query_semileageend, SQLSRV_FETCH_ASSOC);
                    
                    // เช็ค ROWNUM > 1 
                    // ถ้า > 1 จะใส่ค่าว่าง
                    if($result_seBilling['RUNNUMBER'] > 1 ){
                        $i--;
                        $NO         = '';
                        $DATE       = '';
                        $JOBSTART   = '';
                        // $BILLING1   = '';
                        $DRIVER1    = '';
                        $DRIVER2    = '';
                        $TRUCK      = '';
                        $DISTANCE   = '';
                        $EXPRESSWAY = '';
                        $REMARK     = '';
                    }else {
                        $NO         = $i;
                        $DATE       = $result_seBilling['DATEWORKING_103'];
                        $JOBSTART   = $result_seBilling['JOBSTART'];
                        // $BILLING1   = $result_seTodetail['BILLING1'];
                        $DRIVER1    = $result_seBilling['EMPLOYEENAME1'];
                        $DRIVER2    = $result_seBilling['EMPLOYEENAME2'];
                        $TRUCK      = $result_seBilling['THAINAME'].'/'.$result_seBilling['THAINAME2'];
                        $DISTANCE   = $result_seDistance['SUMMILEAGE'];
                        $EXPRESSWAY = $result_seOtherdata['PAY_OTHER'];
                        $REMARK     = $result_seOtherdata['PAY_CONDITION'];
                    }
                    
                    // RUNNUMBER_BILLING1 ที่จะให้แสดงต้นทาง
                    // ถ้า > 1 จะใส่ค่าว่าง
                    if($result_seBilling['RUNNUMBER_BILLING1'] >  1 ){
                        $BILLING1   = '';
                    }else {
                        $BILLING1   = $result_seBilling['BILLING1'];
                    }
            
              
                    ?>
                    <tr>
                        <td style="text-align: center"><?= $NO ?></td>
                        <td style="text-align: center"><?= $DATE ?></td>
                        <td style="text-align: center"><?= $JOBSTART ?></td>
                        <td style="text-align: left"><?= $BILLING1 ?></td>
                        <td style="text-align: left"><?= $result_seBilling['BILLING2'] ?></td>
                        <td style="text-align: left"><?= $result_ChkZone['ZONE'] ?></td>
                        <td style="text-align: center"><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                        <td style="text-align: center"><?= $DRIVER1 ?></td>
                        <td style="text-align: center"><?= $DRIVER2 ?></td>
                        <td style="text-align: center"><?= $TRUCK ?></td>
                        <td style="text-align: center"><?= $result_seBilling['TRIPAMOUNT'] ?></td>
                        <td style="text-align: center"><?= $DISTANCE == '' ? '' : number_format($DISTANCE) ?></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"><?= $EXPRESSWAY == '' ? '' : number_format($EXPRESSWAY,2) ?></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"><?=$REMARK?></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </body>
</html>