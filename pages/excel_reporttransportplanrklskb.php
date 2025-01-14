<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "แผนการขนส่งSKB.xls";
} else {
    $strExcelFileName = "แผนการขนส่งSKB" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
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
                    <th> <label style="width: 200px;text-align: center">Vehicletype.</label></th>
                    <th> <label style="width: 200px;text-align: center">Mileage Start.</label></th>
                    <th> <label style="width: 200px;text-align: center">Mileage End.</label></th>
                   

                </tr>
            </thead>
            <tbody>
                                        <?php
                                        $i = 1;
                                        $sumprice = "";
                                        $condBillings1 = " AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) ";
                                        $condBillings2 = " AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'  ";
                                        $condBillings3 = " ";

                                        $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
                                        $params_seBilling = array(
                                            array('select_vehicletransportdocumentdriver_rklskb', SQLSRV_PARAM_IN),
                                            array($condBillings1, SQLSRV_PARAM_IN),
                                            array($condBillings2, SQLSRV_PARAM_IN),
                                            array($condBillings3, SQLSRV_PARAM_IN)
                                        );



                                        $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                        while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                            $sql_seTodetail = "SELECT TOP 1  BILLING1,BILLING2,[ZONE] FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE LOCATION = '".$result_seBilling['JOBEND']."'
                                                                AND COMPANYCODE ='RKL' AND CUSTOMERCODE ='SKB'
                                                                AND VEHICLETYPE ='".$result_seBilling['VEHICLETYPE']."'
                                                                AND CONVERT(DATE,GETDATE()) BETWEEN CONVERT(DATE,STARTDATE) AND CONVERT(DATE,ENDDATE)";
                                            $query_seTodetail = sqlsrv_query($conn, $sql_seTodetail, $params_seTodetail);
                                            $result_seTodetail = sqlsrv_fetch_array($query_seTodetail, SQLSRV_FETCH_ASSOC);  
                                            
                                            /// หาภาคที่จังหวัดนั้นๆอยู่
                                            $sql_ChkZone = "SELECT [ZONE] AS 'ZONE' FROM ZONEFORSKB WHERE PROVINCE = '".$result_seTodetail['ZONE']."'";
                                            $params_ChkZone = array();
                                            $query_ChkZone = sqlsrv_query($conn, $sql_ChkZone, $params_ChkZone);
                                            $result_ChkZone = sqlsrv_fetch_array($query_ChkZone, SQLSRV_FETCH_ASSOC);


                                            $sql_semileagestart = "SELECT MIN(Odom) AS 'MILEAGESTART' FROM 
                                            (SELECT TOP 2 (Odom) FROM [OIL].[dbo].[record]  WHERE LicenNum ='".$result_seBilling['THAINAME']."' 
                                            ORDER BY  ActualStartDate DESC) AS a";
                                            $params_semileagestart = array();
                                            $query_semileagestart = sqlsrv_query($conn, $sql_semileagestart, $params_semileagestart);
                                            $result_semileagestart = sqlsrv_fetch_array($query_semileagestart, SQLSRV_FETCH_ASSOC);

                                            $sql_semileageend = "SELECT MAX(Odom)  AS 'MILEAGEEND' FROM 
                                            (SELECT TOP 2 (Odom) FROM [OIL].[dbo].[record]  WHERE LicenNum ='".$result_seBilling['THAINAME']."'
                                            ORDER BY  ActualStartDate DESC) AS a";
                                            $params_semileageend = array();
                                            $query_semileageend  = sqlsrv_query($conn, $sql_semileageend, $params_semileageend);
                                            $result_semileageend = sqlsrv_fetch_array($query_semileageend, SQLSRV_FETCH_ASSOC);

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
                                            
                                            ?>
                                            <tr>
                                                <td style="text-align: center"><?= $i ?></td>
                                                <td style="text-align: center"><?= $result_seBilling['DATEWORKING'] ?></td>
                                                <td style="text-align: center"><?= $result_seBilling['JOBSTART'] ?></td>
                                                <td style="text-align: left"><?= $result_seTodetail['BILLING1'] ?></td>
                                                <td style="text-align: left"><?= $result_seTodetail['BILLING2'] ?></td>
                                                <td style="text-align: left"><?=$result_ChkZone['ZONE']?></td>
                                                <td style="text-align: center"><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                                                <td style="text-align: center"><?= $result_seBilling['EMPLOYEENAME1'] ?></td>
                                                <td style="text-align: center"><?= $result_seBilling['EMPLOYEENAME2'] ?></td>
                                                <td style="text-align: center"><?= $result_seBilling['THAINAME'].'/'.$result_seBilling['THAINAME2'] ?></td>
                                                <td style="text-align: center"><?= $result_seBilling['TRIPAMOUNT'] ?></td>
                                                <td style="text-align: center"><?= $result_seBilling['VEHICLETYPE'] ?></td>
                                                <td style="text-align: center"><?= $result_semileagestart['MILEAGESTART'] ?></td>
                                                <td style="text-align: center"><?= $result_semileageend['MILEAGEEND'] ?></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
        </table>
    </body>
</html>