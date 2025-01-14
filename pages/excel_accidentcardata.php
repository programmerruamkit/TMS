<?php
    date_default_timezone_set("Asia/Bangkok");
    require_once("../class/meg_function.php");
    $conn = connect("RTMS");
    if ($_GET['yearstart'] == "" || $_GET['yearend'] == "") {
        $strExcelFileName = "รายงานข้อมูลรถที่เกิดอุบัติเหตุ.xls";
    } else {
        $strExcelFileName = "รายงานข้อมูลรถที่เกิดอุบัติเหตุ(" .$_GET['drivername']. ') ปี ' . $_GET['yearstart'] . ' ถึง ' . $_GET['yearend'] . ".xls";
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
        <table width="100%" border="1" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
            <thead>
                <tr>
                    <th style="background-color: #999">ลำดับ</th>
                    <th style="background-color: #999">ทะเบียนรถ / ชื่อรถ</th>
                    <th style="background-color: #999">ชื่อพนักงานผู้ขับรถ</th>
                    <th style="background-color: #999">วันที่เวลาที่เกิดอุบัติเหตุ</th>
                    <th style="background-color: #999">สถานที่เกิดอุบัติเหตุ</th>
                    <th style="background-color: #999">ปัญหาจากการเกิดอุบัติเหตุ</th>
                    <th style="background-color: #999">สถานที่ซ่อม</th>
                    <th style="background-color: #999">ชื่ออู่นอก</th>
                    <th style="background-color: #999">อาการที่ส่งซ่อม</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $i = 1;
                $regiscar=$_GET['regiscar'];
                $area=$_GET['area'];

                if(($regiscar!="")&&($area!="")){
                    $sql_seAccidentCarData = "SELECT ACCICAR_ID,RG_CAR,THAINAME,EMP_CODE,EMP_NAME,nameT,
                    DT_ACCI,LC_ACCI,PB_ACCI,RP_INOUT,RP_OUT_GR,RP_OUT_GR_PB,STATUS,
                    CONVERT(VARCHAR(4),DT_ACCI,23) AS 'YEAR',
                    CONVERT(VARCHAR(10),DT_ACCI,103) AS 'DATE',
                    CONVERT(VARCHAR(5),CONVERT(DATETIME,DT_ACCI,0),108) AS 'TIME'
                    FROM ACCIDENTHISTORY_CAR 
                    LEFT JOIN VEHICLEINFO VIF ON VIF.VEHICLEREGISNUMBER = ACCIDENTHISTORY_CAR.RG_CAR 
                    LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.PersonCode = ACCIDENTHISTORY_CAR.EMP_CODE
                    WHERE RG_CAR LIKE '%".$_GET['regiscar']."%' AND AREA = '".$_GET['area']."' AND STATUS = '1'
                    AND CONVERT(VARCHAR(4),DT_ACCI,23) BETWEEN '".$_GET['yearstart']."' AND '".$_GET['yearend']."' 
                    ORDER BY CONVERT(VARCHAR(4),DT_ACCI,23),DT_ACCI ASC";
                }else if(($regiscar=="")&&($area!="")){
                    $sql_seAccidentCarData = "SELECT ACCICAR_ID,RG_CAR,THAINAME,EMP_CODE,EMP_NAME,nameT,
                    DT_ACCI,LC_ACCI,PB_ACCI,RP_INOUT,RP_OUT_GR,RP_OUT_GR_PB,STATUS,
                    CONVERT(VARCHAR(4),DT_ACCI,23) AS 'YEAR',
                    CONVERT(VARCHAR(10),DT_ACCI,103) AS 'DATE',
                    CONVERT(VARCHAR(5),CONVERT(DATETIME,DT_ACCI,0),108) AS 'TIME'
                    FROM ACCIDENTHISTORY_CAR 
                    LEFT JOIN VEHICLEINFO VIF ON VIF.VEHICLEREGISNUMBER = ACCIDENTHISTORY_CAR.RG_CAR 
                    LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.PersonCode = ACCIDENTHISTORY_CAR.EMP_CODE
                    WHERE AREA = '".$_GET['area']."' AND STATUS = '1'
                    AND CONVERT(VARCHAR(4),DT_ACCI,23) BETWEEN '".$_GET['yearstart']."' AND '".$_GET['yearend']."' 
                    ORDER BY CONVERT(VARCHAR(4),DT_ACCI,23),DT_ACCI ASC";
                }else if(($regiscar!="")&&($area=="")){
                    $sql_seAccidentCarData = "SELECT ACCICAR_ID,RG_CAR,THAINAME,EMP_CODE,EMP_NAME,nameT,
                    DT_ACCI,LC_ACCI,PB_ACCI,RP_INOUT,RP_OUT_GR,RP_OUT_GR_PB,STATUS,
                    CONVERT(VARCHAR(4),DT_ACCI,23) AS 'YEAR',
                    CONVERT(VARCHAR(10),DT_ACCI,103) AS 'DATE',
                    CONVERT(VARCHAR(5),CONVERT(DATETIME,DT_ACCI,0),108) AS 'TIME'
                    FROM ACCIDENTHISTORY_CAR 
                    LEFT JOIN VEHICLEINFO VIF ON VIF.VEHICLEREGISNUMBER = ACCIDENTHISTORY_CAR.RG_CAR 
                    LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.PersonCode = ACCIDENTHISTORY_CAR.EMP_CODE
                    WHERE RG_CAR LIKE '%".$_GET['regiscar']."%' AND STATUS = '1'
                    AND CONVERT(VARCHAR(4),DT_ACCI,23) BETWEEN '".$_GET['yearstart']."' AND '".$_GET['yearend']."' 
                    ORDER BY CONVERT(VARCHAR(4),DT_ACCI,23),DT_ACCI ASC";
                }else{                                                            
                    $sql_seAccidentCarData = "SELECT ACCICAR_ID,RG_CAR,THAINAME,EMP_CODE,EMP_NAME,nameT,
                    DT_ACCI,LC_ACCI,PB_ACCI,RP_INOUT,RP_OUT_GR,RP_OUT_GR_PB,STATUS,
                    CONVERT(VARCHAR(4),DT_ACCI,23) AS 'YEAR',
                    CONVERT(VARCHAR(10),DT_ACCI,103) AS 'DATE',
                    CONVERT(VARCHAR(5),CONVERT(DATETIME,DT_ACCI,0),108) AS 'TIME'
                    FROM ACCIDENTHISTORY_CAR 
                    LEFT JOIN VEHICLEINFO VIF ON VIF.VEHICLEREGISNUMBER = ACCIDENTHISTORY_CAR.RG_CAR 
                    LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.PersonCode = ACCIDENTHISTORY_CAR.EMP_CODE
                    WHERE STATUS = '1' AND CONVERT(VARCHAR(4),DT_ACCI,23) BETWEEN '".$_GET['yearstart']."' AND '".$_GET['yearend']."' 
                    ORDER BY CONVERT(VARCHAR(4),DT_ACCI,23),DT_ACCI ASC";
                }
                $params_seAccidentCarData = array();
                $query_seAccidentCarData = sqlsrv_query($conn, $sql_seAccidentCarData, $params_seAccidentCarData);
                while ($result_seAccidentCarData = sqlsrv_fetch_array($query_seAccidentCarData, SQLSRV_FETCH_ASSOC)) {    
                    $RG_CAR=$result_seAccidentCarData['RG_CAR'];
                    $THAINAME=$result_seAccidentCarData['THAINAME'];     
                    if($THAINAME=='-'){
                        $ifregisnamecar=$RG_CAR;
                    }else{
                        $ifregisnamecar=$RG_CAR.' / '.$THAINAME;
                    }   
                    $RP_INOUT=$result_seAccidentCarData['RP_INOUT'];     
                    if($RP_INOUT=='inrepair'){
                        $ifrpinout="ซ่อมใน";
                    }else{
                        $ifrpinout="ซ่อมนอก";
                    }   
                    $EMP_CODE=$result_seAccidentCarData['EMP_CODE'];
                    $EMP_NAME=$result_seAccidentCarData['EMP_NAME'];
                    $nameT=$result_seAccidentCarData['nameT'];      
                    // if($nameT==""){
                    //     $rsname=$EMP_CODE;
                    // }else{
                    //     $rsname=$nameT;
                    // }            
                    if(($nameT=="")&&($EMP_CODE=="")){
                        $rsname=$EMP_NAME;
                    }else if(($nameT=="")&&($EMP_CODE!="")){
                            $rsname=$EMP_CODE.'<br><small>('.$EMP_NAME.')</small>';
                    }else{
                        $rsname=$nameT;
                    }                                      
            ?>
                <tr>
                    <td style="text-align: center"><?= $i ?></td>
                    <td><?= $ifregisnamecar ?></td>
                    <td><?= $rsname ?></td>
                    <td><?= $result_seAccidentCarData['DATE'] ?> <?=$result_seAccidentCarData['TIME']?></td>
                    <td><?= $result_seAccidentCarData['LC_ACCI'] ?></td>
                    <td><?= $result_seAccidentCarData['PB_ACCI'] ?></td>
                    <td><?= $ifrpinout ?></td>
                    <td><?= $result_seAccidentCarData['RP_OUT_GR'] ?></td>
                    <td><?= $result_seAccidentCarData['RP_OUT_GR_PB'] ?></td>
                </tr>
                <?php $i++; } ?>
            </tbody>
        </table>
    </body>
</html>