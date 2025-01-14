<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
// $conn = connect("RTMS");
$conn = connect("RTMS");

if ($_POST['txt_flg'] == "select_emsp1") {
  ?>
  <!-- <?php
  global $drivername;
  $sql_employeedetail = "SELECT (FNAME_THA+' '+LNAME_THA) AS 'NAME',PERSONCODE
  FROM EMPLOYEEEHR2 
  WHERE  PERSONID ='" . $_POST['drivercode'] . "'";
  $query_employeedetail = sqlsrv_query($conn, $sql_employeedetail, $params_employeedetail);
  $result_employeedetail =  sqlsrv_fetch_array($query_employeedetail, SQLSRV_FETCH_ASSOC); 

  ?> -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        <div id="datadef_emsp1">
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example_emsp1" role="grid" aria-describedby="dataTables-example_info" >
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center" >ทะเบียนรถ: <?= $_POST['vehicleregisnumber'] ?> | ชื่อรถ: <?= $_POST['thainame'] ?></th>
                                        <th colspan="4" style="text-align: center" >วันที่: <?= $_POST['datestart'] ?> - <?= $_POST['dateend']?></th>
                                    </tr>
                                    <tr>
                                        <th style="width: 5px;">ลำดับ11</th>
                                        <th style="width: 5px;">ไอดีแจ้งซ่อม</th>
                                        <th style="width: 40px;">วันที่แจ้งซ่อม</th>
                                        <th style="width: 70px;">ผู้แจ้งซ่อม</th>
                                        <th style="width: 50px;">รายการซ่อม</th>
                                        <th style="width: 50px;">ประเภทการซ่อม</th>
                                        <th style="width: 50px;">ช่างผู้รับผิดชอบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
                                // $condiReporttransport2 = "";
                                // $condiReporttransport3 = "";

                                $i = 1;
                                $sql_seData = "SELECT a.REPAIRPLANID,a.VEHICLEREGISNUMBER1,a.VEHICLEREGISNUMBER2,a.VEHICLEMODEL,a.KM,b.[SUBJECT],b.DETAIL,
                                    b.CARINPUTDATE,b.COMPLETEDDATE,b.REPAIRAREA,CONVERT(VARCHAR(16),a.CREATEDATE2,121) AS 'REPAIR_REPORT_DATE',a.CREATEBY AS 'EMP_REPOTRTED'
                                    FROM [RK02].[RTMS].[dbo].REPAIRPLAN a 
                                    INNER JOIN [RK02].[RTMS].[dbo].[REPAIRCAUSE] b ON a.REPAIRPLANID = b.REPAIRPLANID
                                    WHERE (a.VEHICLEREGISNUMBER1 ='".$_POST['vehicleregisnumber']."' OR a.VEHICLEREGISNUMBER2 ='".$_POST['vehicleregisnumber']."')
                                    --AND a.REPAIRPLANID ='47164'
                                    AND CONVERT(DATE,a.CREATEDATE2,103) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
                                    ORDER BY a.CREATEDATE2 ASC";
                                $params_seData = array();
                                $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
                                while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {
                                    
                                    // echo $result_seData['DRIVER_BMI'];
                                    // echo '<br>';

                                    // หารายชื่อช่างในแต่ละแผนงาน
                                    $sql_seTechnician = "SELECT DISTINCT(EMPLOYEENAME) AS 'TECHICIANNAME'
                                        FROM [RK02].[RTMS].[dbo].[REPAIREMPLOYEE]
                                        WHERE [REPAIRPLANID]='".$result_seData['REPAIRPLANID']."' AND REPAIRTYPE ='".$result_seData['SUBJECT']."'";
                                    $params_seTechnician  = array();
                                    $query_seTechnician   = sqlsrv_query($conn, $sql_seTechnician, $params_seTechnician);
                                    
                                    $TECHICIAN = '';

                                    while ($result_seTechnician = sqlsrv_fetch_array($query_seTechnician, SQLSRV_FETCH_ASSOC)) {
                                        $TECHICIAN = $TECHICIAN . $result_seTechnician['TECHICIANNAME'] . ",";
                                    }
                                    
                                    

                                    ?>

                                    <tr>
                                        <td style="text-align: center"><?= $i ?></td>
                                        <td><?=$result_seData['REPAIRPLANID']?></td>
                                        <td><?=$result_seData['REPAIR_REPORT_DATE']?></td>
                                        <td><?=$result_seData['EMP_REPOTRTED']?></td>
                                        <td title="" style=""><?=$result_seData['DETAIL']?></td>
                                        <td title="" style=""><?=$result_seData['SUBJECT']?></td>
                                        <td title="" style=""><?=$TECHICIAN?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                    }
                                ?>




                                </tbody>

                            </table>
                        </div>
                        <div id="datasr_emsp1"></div>
                    </div>


                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </div>
    </div>
<?php
}
if ($_POST['txt_flg'] == "select_emsp2") {
?>
    <!-- <?php
    // global $drivername;
    $sql_companydetail = "SELECT DISTINCT (COMPANYCODE) AS 'COMPANYCODE',COMPANY_NAMETHA AS 'COMPANYNAME'
    FROM EMPLOYEEEHR2
    WHERE COMPANYCODE ='" . $_POST['companycode'] . "'";
    $query_companydetail = sqlsrv_query($conn, $sql_companydetail, $params_companydetail);
    $result_companydetail =  sqlsrv_fetch_array($query_companydetail, SQLSRV_FETCH_ASSOC); 
  
    ?> -->
        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example_emsp2" role="grid" aria-describedby="dataTables-example_info" >
            <thead>
                <tr>
                    <th colspan="3" style="text-align: center" >ทะเบียนรถn: <?= $_POST['vehicleregisnumber'] ?> | ชื่อรถn: <?= $_POST['thainame'] ?></th>
                    <th colspan="3" style="text-align: center" >วันที่n: <?= $_POST['datestart'] ?> - <?= $_POST['dateend']?></th>
                </tr>
                <tr>
                    <th style="width: 5px;">ลำดับ12</th>
                    <th style="width: 40px;">วันที่แจ้งซ่อม</th>
                    <th style="width: 70px;">ผู้แจ้งซ่อม</th>
                    <th style="width: 50px;">รายการซ่อม</th>
                    <th style="width: 50px;">ประเภทการซ่อม</th>
                    <th style="width: 50px;">ช่างผู้รับผิดชอบ</th>
                </tr>
            </thead>
            <tbody>
            <?php

            // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
            // $condiReporttransport2 = "";
            // $condiReporttransport3 = "";

            $i = 1;
            $sql_seData = "SELECT b.nameT,b.TaxID,b.PersonCode,a.LABOTRONDATAID,CARDNUMBER,DRIVER_WEIGHT,DRIVER_HEIGHT,DRIVER_BMI,
            DRIVER_TEMPERATURE,DRIVER_SYS,DRIVER_DIA,DRIVER_PULSE,DRIVER_OXYGEN,DRIVER_ALCOHOL,
            CREATEBY,CONVERT(VARCHAR(16),CREATEDATE,103) AS 'CREATEDATE',CONVERT(VARCHAR(16),CREATEDATE,103) AS 'AC_CREATEDATE'
                                                                                                                                    
            FROM LABOTRONWEBSERVICEDATA a 
            INNER JOIN EMPLOYEEEHR2 b ON b.TaxID = a.CREATEBY
            WHERE CONVERT(DATE,CREATEDATE) BETWEEN CONVERT(DATE,DATEADD(DAY,-1,GETDATE())) AND CONVERT(DATE,GETDATE())
            --WHERE CARDNUMBER IN ('5320890008815','1639900241323')
            AND SUBSTRING(b.PersonCode, 1, 2) IN ('01','02','07','08','06','10')
            ORDER BY CONVERT(VARCHAR(16),CREATEDATE,103) DESC";
            $params_seData = array();
            $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
            while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {

            
                

                // echo $result_seData['DRIVER_BMI'];
                // echo '<br>';
                ?>

                <tr>
                    <td style="text-align: center"><?= $i ?></td>
                    <td><?=$result_seData['PersonCode']?></td>
                    <td><?=$result_seData['nameT']?></td>
                    <td title="<?=$pageTitleTemp?>"     style="<?= $colortemp ?>"><?=number_format($result_seData['DRIVER_TEMPERATURE'],1);?></td>
                    <td title="<?=$pageTitleSYS?>"      style="<?= $colorsys ?>"><?=$result_seData['DRIVER_SYS'];?></td>
                    <td title="<?=$pageTitleDIA?>"      style="<?= $colordia ?>"><?=$result_seData['DRIVER_DIA'];?></td>
                </tr>
                <?php
                $i++;
                }
            ?>




            </tbody>

        </table>
      <?php
}
?>
<?php
sqlsrv_close($conn);
?>
