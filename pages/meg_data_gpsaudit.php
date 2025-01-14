<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");


// SAVE GPS MONITORING 
if ($_POST['txt_flg'] == "save_gpsauditing") {


    $sql_savegpsaudit    = "{call megGpsAuditing(?,?,?,?,?,?,?,?,?,?,
                                                 ?,?,?,?,?,?,?,?,?,?)}"; 
    $params_savegpsaudit = array(
    array('save_gpsauditing', SQLSRV_PARAM_IN),
    array($_POST['trailernumber'], SQLSRV_PARAM_IN),
    array($_POST['problem'], SQLSRV_PARAM_IN),
    array($_POST['drivername'], SQLSRV_PARAM_IN),
    array($_POST['datetimedata'], SQLSRV_PARAM_IN),
    array($_POST['location'], SQLSRV_PARAM_IN),
    array($_POST['rootcause'], SQLSRV_PARAM_IN),
    array($_POST['result'], SQLSRV_PARAM_IN),
    array($_POST['gpscheckstart'], SQLSRV_PARAM_IN),
    array($_POST['gpscheckmiddle'], SQLSRV_PARAM_IN),
    array($_POST['gpscheckfinish'], SQLSRV_PARAM_IN),
    array($_POST['jobno1'], SQLSRV_PARAM_IN),
    array($_POST['planid1'], SQLSRV_PARAM_IN),
    array($_POST['drivername11'], SQLSRV_PARAM_IN),
    array($_POST['drivername21'], SQLSRV_PARAM_IN),
    array($_POST['jobno2'], SQLSRV_PARAM_IN),
    array($_POST['planid2'], SQLSRV_PARAM_IN),
    array($_POST['drivername12'], SQLSRV_PARAM_IN),
    array($_POST['drivername22'], SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN)
    );
  
    $query_savegpsaudit     = sqlsrv_query($conn, $sql_savegpsaudit, $params_savegpsaudit);
    $result_savegpsaudit    = sqlsrv_fetch_array($query_savegpsaudit, SQLSRV_FETCH_ASSOC);
    // echo $result_savedealermaster['RS'];
  
}
if ($_POST['txt_flg'] == "save_gpsauditmaster") {


    $sql_savegpsauditmaster    = "{call megGpsAuditing(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
    $params_savegpsauditmaster = array(
    array('save_gpsauditmaster', SQLSRV_PARAM_IN),
    array($_POST['trailernumber'], SQLSRV_PARAM_IN),
    array($_POST['problem'], SQLSRV_PARAM_IN),
    array($_POST['drivername'], SQLSRV_PARAM_IN),
    array($_POST['datetimedata'], SQLSRV_PARAM_IN),
    array($_POST['location'], SQLSRV_PARAM_IN),
    array($_POST['rootcause'], SQLSRV_PARAM_IN),
    array($_POST['result'], SQLSRV_PARAM_IN),
    array($_POST['gpscheck'], SQLSRV_PARAM_IN),
    array($_POST['jobno'], SQLSRV_PARAM_IN),
    array($_POST['planid'], SQLSRV_PARAM_IN),
    array($_POST['drivername1'], SQLSRV_PARAM_IN),
    array($_POST['drivername2'], SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN)
    );
  
    $query_savegpsauditmaster     = sqlsrv_query($conn, $sql_savegpsauditmaster, $params_savegpsauditmaster);
    $result_savegpsauditmaster    = sqlsrv_fetch_array($query_savegpsauditmaster, SQLSRV_FETCH_ASSOC);
    // echo $result_savedealermaster['RS'];
  
}
// Driving Pattern แผนขากลับ
if ($_POST['txt_flg'] == "delete_gpsauditmaster") {


    $sql_deletegpsauditmaster     = "{call megGpsAuditing(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
    $params_deletegpsauditmaster  = array(
    array('delete_gpsauditmaster', SQLSRV_PARAM_IN),
    array($_POST['trailernumber'], SQLSRV_PARAM_IN),
    array($_POST['problem'], SQLSRV_PARAM_IN),
    array($_POST['drivername'], SQLSRV_PARAM_IN),
    array($_POST['datetimedata'], SQLSRV_PARAM_IN),
    array($_POST['location'], SQLSRV_PARAM_IN),
    array($_POST['rootcause'], SQLSRV_PARAM_IN),
    array($_POST['result'], SQLSRV_PARAM_IN),
    array($_POST['gpscheck'], SQLSRV_PARAM_IN),
    array($_POST['jobno'], SQLSRV_PARAM_IN),
    array($_POST['planid'], SQLSRV_PARAM_IN),
    array($_POST['drivername1'], SQLSRV_PARAM_IN),
    array($_POST['drivername2'], SQLSRV_PARAM_IN),
    array($_POST['createby'], SQLSRV_PARAM_IN)
    );
  
    $query_deletegpsauditmaster = sqlsrv_query($conn, $sql_deletegpsauditmaster, $params_deletegpsauditmaster);
    $result_deletegpsauditmaster = sqlsrv_fetch_array($query_deletegpsauditmaster, SQLSRV_FETCH_ASSOC);
    // echo $result_deletedealermaster['RS'];
  
}
// Driving Pattern แผนขากลับ
if ($_POST['txt_flg'] == "select_gpsauditing") {
?>
    <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example" style="width: 100%;">
    <thead>
        <tr>
            <th><label style="width: 100px">ลำดับ1</label></th>
            <th><label style="width: 100px">บริษัทสังกัด</label></th>
            <th><label style="width: 100px">สายงาน</label></th>           
            <th><label style="width: 100px">ชื่อรถ (ไทย)</label></th>
            <th><label style="width: 100px">ชื่อรถ (อังกฤษ)</label></th> 
            <th><label style="width: 100px">ทะเบียนรถ</label></th>
            <th><label style="width: 100px;text-align: center">GPS <br>Auditing</label></th>
        </tr>
    </thead>
    <tbody>

        <?php
        // $condition1 = " AND (a.THAINAME NOT LIKE '%R-%' OR a.THAINAME NOT LIKE '%RA-%' OR a.THAINAME NOT LIKE '%RP-%'";
        // $condition2 = " OR a.THAINAME NOT LIKE '%คลองเขื่อน%'  OR a.THAINAME NOT LIKE '%ด่านช้าง%'  OR a.THAINAME NOT LIKE '%สวนผึ้ง%' ";
        // $condition3 = " OR a.ENGNAME NOT LIKE '%ดินแดง%' OR a.ENGNAME NOT LIKE '%อุทัยธานี%' OR a.ENGNAME NOT LIKE '%Kerry%'";
        // $condition4 = " OR a.THAINAME NOT LIKE '%เขาชะเมา%' OR a.THAINAME NOT LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME NOT LIKE '%P35%' )";
        $i = 1;
        $condition1 = "AND a.VEHICLEGROUPCODE !='VG-1403-0755' AND a.AFFCOMPANY IN ('".$_POST['companycode']."') ORDER BY a.AFFCOMPANY,a.AFFCUSTOMER,a.VEHICLEINFOID,a.THAINAME ASC";
        $condition2 = "";
        $condition3 = "";
        $condition4 = "";
        $sql_infolist = "{call megVehicleinfo_v2(?,?,?,?,?)}";
        $params_infolist = array(
            array('selectcond_vehicleinfo', SQLSRV_PARAM_IN),
            array($condition1, SQLSRV_PARAM_IN),
            array($condition2, SQLSRV_PARAM_IN),
            array($condition3, SQLSRV_PARAM_IN),
            array($condition4, SQLSRV_PARAM_IN)
        );

        $query_infolist = sqlsrv_query($conn, $sql_infolist, $params_infolist);
        while ($result_infolist = sqlsrv_fetch_array($query_infolist, SQLSRV_FETCH_ASSOC)) {
            ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $result_infolist['AFFCOMPANY'] ?></td>
                <td><?= $result_infolist['AFFCUSTOMER'] ?></td>
                <td><?= $result_infolist['THAINAME'] ?></td>
                <td><?= $result_infolist['ENGNAME'] ?></td>
                <td><?= $result_infolist['VEHICLEREGISNUMBER'] ?></td>
                <td style="text-align: center">
                    <a style="background-color: #e0e0e0;" placeholder ="ลงข้อมูล" href='meg_gpsmonitoringskp.php?vehicleinfoid=<?= $result_infolist['VEHICLEINFOID'] ?>&vehicletransportplanid=<?= $result_infolist['VEHICLETRANSPORTPLANID'] ?>&meg=edit' target="_bank" class='list-group-item'><span class="glyphicon glyphicon-road"></span></a>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
  
<?php
}
// Driving Pattern แผนขากลับ
if ($_POST['txt_flg'] == "select_gpsauditingskp") {
?>
    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
        <thead >
            <tr>
                <th style="width: 5px;">No</th>
                <th style="width: 40px;">Trailer Number</th>
                <th style="width: 70px;">Problem</th>
                <th style="width: 70px;">Driver Name</th>
                <th style="width: 50px;">Time</th>
                <th style="width: 50px;">Location</th>
                <th style="width: 50px;">Root cause</th>
                <th style="width: 50px;">Result</th>
                <th style="width: 40px;">GPS CHECK<br>(START)</th>
                <th style="width: 40px;">GPS CHECK<br>(MIDDLE)</th>
                <th style="width: 40px;">GPS CHECK<br>(FINISH)</th>
                <th style="width: 70px;">PlanID_1</th>
                <th style="width: 70px;">PlanID_2</th>
            </tr>
        </thead>
        <tbody>
        <?php

        // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
        // $condiReporttransport2 = "";
        // $condiReporttransport3 = "";
        // เงื่อนไขเดิม AND SUBSTRING(b.PersonCode, 1, 2) IN ('01','02','07','08','06','10')

        $i = 1;
        $sql_seData = "SELECT TRAILERNUMBER,PROBLEM,DRIVERNAME,DATETIMEAUDIT,LOCATIONAUDIT,ROOTCAUSE,RESULT,
            GPSCHECK_START,GPSCHECK_MIDDLE,GPSCHECK_FINISH,PLANID1,DRIVERNAME11,DRIVERNAME12,PLANID2,DRIVERNAME21,DRIVERNAME22
            FROM [dbo].[GPSAUDITING]
            WHERE CONVERT(DATE,CREATEDATE) BETWEEN CONVERT(DATE,'".$_POST['datestart']."',103) AND CONVERT(DATE,'".$_POST['dateend']."',103)
            AND TRAILERNUMBER ='".$_POST['thainame']."'
            ORDER BY REMARK ASC";
        $params_seData = array();
        $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
        while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {

            
            $DATETIMEAUDIT_CHK = str_replace("T"," ",$result_seData['DATETIMEAUDIT']);
            $DATETIMEAUDIT     = str_replace("-","/",$DATETIMEAUDIT_CHK);

            // echo $result_seData['DRIVER_BMI'];
            // echo '<br>';
            ?>

            <tr>
                <td style="text-align: center"><?= $i ?></td>
                <td style="text-align: center"><?=str_replace("(4L)","",$result_seData['TRAILERNUMBER'])?></td>
                <td style="text-align: center"><?=$result_seData['PROBLEM']?></td>
                <td style="text-align: center"><?=$result_seData['DRIVERNAME']?></td>
                <td style="text-align: center"><?=$DATETIMEAUDIT ?></td>
                <td style="text-align: center"><?=$result_seData['LOCATIONAUDIT']?></td>
                <td style="text-align: center"><?=$result_seData['ROOTCAUSE']?></td>
                <td style="text-align: center"><?=$result_seData['RESULT']?></td>
                <td style="text-align: center"><?=$result_seData['GPSCHECK_START']?></td>
                <td style="text-align: center"><?=$result_seData['GPSCHECK_MIDDLE']?></td>
                <td style="text-align: center"><?=$result_seData['GPSCHECK_FINISH']?></td>
                <td style="text-align: center"><?=$result_seData['PLANID1']?></td>
                <td style="text-align: center"><?=$result_seData['PLANID2']?></td>
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

