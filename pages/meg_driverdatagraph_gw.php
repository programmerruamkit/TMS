<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


$sql_seEmpName = "SELECT  nameT,PersonCode FROM EMPLOYEEEHR2
WHERE PersonCode ='".$_GET['employeecode']."'";
$params_seEmpName = array();
$query_seEmpName = sqlsrv_query($conn, $sql_seEmpName, $params_seEmpName);
$result_seEmpName = sqlsrv_fetch_array($query_seEmpName, SQLSRV_FETCH_ASSOC);


$strDate = date("Y/m/d");
function DateThai($strDate)
{
$strMonth= date("n",strtotime($strDate));
$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$strMonthThai=$strMonthCut[$strMonth];
return "$strMonthThai";
}

// echo $strDate = date("Y/m/d");
// echo "ThaiCreate.Com Time now : ".DateThai($strDate);
$month =  date("Y"); // month ส่งให้เลือกเดือน

$checkfirstdate = date("01/"."m/Y");


$currentyearshow =  date("Y");

// echo $currentyearshow;
/// Query เก่ายึดแผนงานด้วย
// $sql_seDay4 = "SELECT a.EMPLOYEECODE,a.EMPLOYEENAME,a.DATEJOBSTART,a.TEMPERATURE,a.SYSVALUE,a.DIAVALUE,a.CREATEDATE AS 'SELFCHECKCREATE'
// ,b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
// ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
// ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
// ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
// ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
// FROM DRIVERSELFCHECK a
// INNER JOIN TENKOBEFORE b ON a.EMPLOYEECODE = b.TENKOMASTERDIRVERCODE
// INNER JOIN VEHICLETRANSPORTPLAN c ON c.TENKOMASTERID = b.TENKOMASTERID
// WHERE EMPLOYEECODE='".$_GET['employeecode']."'
// AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D4']."',103)
// AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D4']."',103)";
// $params_seDay4 = array();
// $query_seDay4 = sqlsrv_query($conn, $sql_seDay4, $params_seDay4);
// $result_seDay4 = sqlsrv_fetch_array($query_seDay4, SQLSRV_FETCH_ASSOC);

// ข้อมูลมาตรฐาน การตรวจร่างกาย
$sql_seTenkoSTD = "SELECT STD_ID,MAXSYS,MINSYS,MAXDIA,MINDIA,MAXPULSE,MINPULSE,TEMP,OXYGEN,ALCOHOL,REMARK
FROM STANDARDTENKODATA
WHERE REMARK ='GW'";
$query_seTenkoSTD = sqlsrv_query($conn, $sql_seTenkoSTD, $params_seTenkoSTD);
$result_seTenkoSTD = sqlsrv_fetch_array($query_seTenkoSTD, SQLSRV_FETCH_ASSOC);

// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo $result_seTenkoSTD['MAXSYS'];
// echo "<br>";
// echo $result_seTenkoSTD['MAXDIA'];
// echo "<br>";
// echo $result_seTenkoSTD['MAXPULSE'];
// echo "<br>";
// echo $result_seTenkoSTD['TEMP'];
// echo "<br>";
// echo $result_seTenkoSTD['OXYGEN'];
// echo "<br>";
// echo $result_seTenkoSTD['ALCOHOL'];

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
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="../vendor/jquery/jquery.min.js"></script>



        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">

        <style>

            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {

                border-left: 1px solid #ffcb0b;
            }
            .sidebar ul li a.active {
                background-color: #ffffff;
            }
            body {

                background-color: #fff;
            }
        </style>
        <style>

        </style>
    </head>

    <body>

        <div id="wrapper">


            <div id="page-wrapper" style="color: #666">
                <div class="row" >
                    <div class="col-lg-12">

                        <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>
                        กราฟสรุปรวมข้อมูลสุขภาพพนักงาน ประจำเดือน:&nbsp;<b><?=DateThai($strDate)?> / <?=$currentyearshow?></b>&nbsp;&nbsp;พนักงาน:&nbsp;<b><?=$result_seEmpName['nameT']?></b>
                        <input type="hidden" id="txt_empcode" name="txt_empcode" value="<?=$_GET['employeecode']?>" ></imput>
                        <input type="hidden" id="txt_firstdate" name="txt_firstdate" value="<?= $checkfirstdate ?>" ></imput>
                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row" >
                    <div class="panel-body">
                        <div class="col-lg-2">
                            <label>ค้นหาข้อมูลกราฟข้อมูลสุขภาพ</label>
                            <select id="select_month" name="select_month" class="form-control" >
                                <option value="">เลือกเดือน</option>
                                <!-- อันเดิม -->
                                <!-- <option value="01/01/<?=$month?>">มกราคม</option> -->
                                <option value="01/01/">มกราคม</option>
                                <option value="01/02/">กุมภาพันธ์</option>
                                <option value="01/03/">มีนาคม</option>
                                <option value="01/04/">เมษายน</option>
                                <option value="01/05/">พฤษภาคม</option>
                                <option value="01/06/">มิถุนายน</option>
                                <option value="01/07/">กรกฎาคม</option>
                                <option value="01/08/">สิงหาคม</option>
                                <option value="01/09/">กันยายน</option>
                                <option value="01/10/">ตุลาคม</option>
                                <option value="01/11/">พฤศจิกายน</option>
                                <option value="01/12/">ธันวาคม</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>เลือกปี (ค้นหา)</label><br>
                                <select   id="txt_yearsearchstart" name="txt_yearsearchstart" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือกปี (ค้นหา)..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                    <option value ="" disabled selected >- เลือกปี -</option>
                                    <?php
                                    for ($y = 1993; $y <= 2100; $y++) { ?>
                                    <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <label>&nbsp;</label>
                            <div class="form-group">
                                <button type="button" class="btn btn-default" onclick="select_graph();">ค้นหาข้อมูล <li class="fa fa-search"></li></button>
                            </div>

                        </div>


                    </div>
                </div>
                <br>
                <!-- START ROW1 -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> กราฟข้อมูลสุขภาพพนักงาน

                            </div> -->
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                            <!-- START ROW ตารางแสดงข้อมูล -->
                            <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                  ตารางรวมข้อมูลสุขภาพ <b>(ข้อมูลจากระบบตรวจร่างกาย)</b>
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ลำดับที่</th>
                                                                        <th>วันที่</th>
                                                                        <th>เลขที่งาน</th>
                                                                        <th>ความดันบน</th>
                                                                        <th>ความดันล่าง</th>
                                                                        <th>อุณหภูมิ</th>
                                                                        <th>แอลกอฮอล์</th>
                                                                        <th>อัตราการเต้นของหัวใจ</th>
                                                                        <th>ออกซิเจนในเลือด</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                $i = 1;

                                                                $sql_seStartDate = "SELECT CONVERT(VARCHAR(25),DATEADD(dd,-(DAY(GETDATE())-1),GETDATE()),105) AS 'STARTDATE'";
                                                                $params_seStartDate = array();
                                                                $query_seStartDate = sqlsrv_query($conn, $sql_seStartDate, $params_seStartDate);
                                                                $result_seStartDate = sqlsrv_fetch_array($query_seStartDate, SQLSRV_FETCH_ASSOC);

                                                                $sql_seEndDate = "SELECT CONVERT(VARCHAR(25),DATEADD(dd,-(DAY(DATEADD(mm,1,GETDATE()))),DATEADD(mm,1,GETDATE())),105) AS 'ENDDATE'";
                                                                $params_seEndDate = array();
                                                                $query_seEndDate = sqlsrv_query($conn, $sql_seEndDate, $params_seEndDate);
                                                                $result_seEndDate = sqlsrv_fetch_array($query_seEndDate, SQLSRV_FETCH_ASSOC);

                                                                // $sql_seCountData = "SELECT COUNT(b.TENKOMASTERID) AS 'COUNT'
                                                                //นับวันที่ ที่ไม่ซ้ำกัน
                                                                $sql_seCountData = "SELECT COUNT(DISTINCT CONVERT(VARCHAR(10),CREATEDATE,120))  AS 'COUNT'
                                                                FROM  TENKOBEFORE b
                                                                WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                                                AND CONVERT(DATE,b.CREATEDATE) BETWEEN CONVERT(DATE,'".$result_seStartDate['STARTDATE']."',103) AND CONVERT(DATE,'".$result_seEndDate['ENDDATE']."',103)
                                                                AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                                                OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                                                OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                                                OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                                                OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                                                OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')";
                                                                $params_seCountData = array();
                                                                $query_seCountData = sqlsrv_query($conn, $sql_seCountData, $params_seCountData);
                                                                $result_seCountData = sqlsrv_fetch_array($query_seCountData, SQLSRV_FETCH_ASSOC);

                                                                // echo $result_seCountData['COUNT'];


                                                                // $sql_seSelfCheckData = "SELECT CONVERT(VARCHAR(10),b.CREATEDATE,103) AS 'TENKOCREATEDATE'
                                                                // ,b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                                                // ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                                                // ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                                                // ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                                                // ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                                                // FROM  TENKOBEFORE b
                                                                $sql_seSelfCheckData = "SELECT CONVERT(VARCHAR(10),b.CREATEDATE,103) AS 'TENKOCREATEDATE'
                                                                ,b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                                                ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                                                ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                                                ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                                                ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA,d.VEHICLETRANSPORTPLANID,d.JOBNO
                                                                FROM TENKOBEFORE b
                                                                INNER JOIN TENKOMASTER c ON c.TENKOMASTERID = b.TENKOMASTERID
                                                                LEFT JOIN VEHICLETRANSPORTPLAN d ON c.VEHICLETRANSPORTPLANID = d.VEHICLETRANSPORTPLANID
                                                                WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                                                AND CONVERT(DATE,b.CREATEDATE) BETWEEN CONVERT(DATE,'".$result_seStartDate['STARTDATE']."',103) AND CONVERT(DATE,'".$result_seEndDate['ENDDATE']."',103)
                                                                AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                                                OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                                                OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                                                OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                                                OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                                                OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                                                AND d.VEHICLETRANSPORTPLANID != ''
                                                                ORDER BY b.CREATEDATE ASC";
                                                                $params_seSelfCheckData = array();
                                                                $query_seSelfCheckData = sqlsrv_query($conn, $sql_seSelfCheckData, $params_seSelfCheckData);
                                                                while ($result_seSelfCheckData = sqlsrv_fetch_array($query_seSelfCheckData, SQLSRV_FETCH_ASSOC)) {


                                                                        // SYS ค่าความดันบน
                                                                        if($result_seSelfCheckData['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                                                            if ($result_seSelfCheckData['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                                                if ($result_seSelfCheckData['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                                                    $SYS = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                                                }else {
                                                                                    $SYS = $result_seSelfCheckData['TENKOPRESSUREDATA_90160_3'];
                                                                                }

                                                                            }else {
                                                                                $SYS = $result_seSelfCheckData['TENKOPRESSUREDATA_90160_2'];
                                                                            }

                                                                        }else{
                                                                                $SYS = $result_seSelfCheckData['TENKOPRESSUREDATA_90160'] ;

                                                                        }
                                                                     /////////////////////////////////////////////////////////////////
                                                                        //DIA ค่าความดันล่าง
                                                                        if($result_seSelfCheckData['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                                                            if ($result_seSelfCheckData['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                                                if ($result_seSelfCheckData['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                                                    $DIA = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                                                }else {
                                                                                    $DIA = $result_seSelfCheckData['TENKOPRESSUREDATA_60100_3'];
                                                                                }

                                                                            }else {
                                                                                $DIA = $result_seSelfCheckData['TENKOPRESSUREDATA_60100_2'];
                                                                            }

                                                                        }else{
                                                                                $DIA = $result_seSelfCheckData['TENKOPRESSUREDATA_60100'] ;
                                                                        }
                                                                      /////////////////////////////////////////////////////////////////
                                                                        //PULSEDAY1
                                                                        if($result_seSelfCheckData['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seSelfCheckData['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                                                            if ($result_seSelfCheckData['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seSelfCheckData['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                                                if ($result_seSelfCheckData['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seSelfCheckData['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                                                    $PULSE = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                                                }else {
                                                                                    $PULSE = $result_seSelfCheckData['TENKOPRESSUREDATA_60110_3'];
                                                                                }

                                                                            }else {
                                                                                $PULSE = $result_seSelfCheckData['TENKOPRESSUREDATA_60110_2'];
                                                                            }

                                                                        }else{
                                                                                $PULSE = $result_seSelfCheckData['TENKOPRESSUREDATA_60110'] ;
                                                                        }
                                                                        //////////////////////////////////////////////////////////////////////
                                                                ?>

                                                                <tr>
                                                                    <td style="text-align:left;width: 5%" ><?= $i ?></td>
                                                                    <td style="text-align:left;width: 8%" ><?= $result_seSelfCheckData['JOBNO'] ?></td>
                                                                    <td style="text-align:left;width: 10%" ><?= $result_seSelfCheckData['TENKOCREATEDATE'] ?></td>
                                                                    <td style="text-align:center;width: 10%" ><?= $SYS ?></td>
                                                                    <td style="text-align:center;width: 10%" ><?= $DIA ?></td>
                                                                    <td style="text-align:center;width: 10%" ><?= $result_seSelfCheckData['TENKOTEMPERATUREDATA'] ?></td>
                                                                    <td style="text-align:center;width: 10%" ><?= $result_seSelfCheckData['TENKOALCOHOLDATA'] ?></td>
                                                                    <td style="text-align:center;width: 10%" ><?= $PULSE ?></td>
                                                                    <td style="text-align:center;width: 10%" ><?= $result_seSelfCheckData['TENKOOXYGENDATA'] ?></td>
                                                                 </tr>

                                                                 <?php
                                                                    $i++;
                                                                }
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div id="datasr"></div>
                                                    </div>


                                                    <!-- /.panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12" style="text-align: right;">
                                        <label>&nbsp;</label>
                                        <!-- <div class="form-group">
                                            <button type="button" class="btn btn-default" onclick="select_graphtest();">ทดสอบกราฟ <li class="fa fa-search"></li></button>
                                        </div> -->

                                        <div style="align: right;">

                                                <button type="button" name="check_graph" id="check_graph" onclick ="check_graph();" class="btn btn-success btn-lg">Export Graph To PDF</button>

                                        </div>
                                    </div>
                            <!-- START ROW ความดันค่าบน ค่าล่าง-->
                                <div class="row">
                                    <div class="col-lg-12 " style="text-align:center;">
                                        <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>
                                        กราฟข้อมูลค่าความดันค่าบน-ค่าล่างของพนักงาน
                                        </h2>
                                    </div>
                                    <div class="col-lg-12" style="text-align:center;">
                                        <h2 class=""><i class=""></i>
                                        <b>Avg.บน</b>&nbsp;&nbsp;  <input type="text"   style ="text-align:center" id="txt_avgsys" value="" disabled="true">
                                        <b>Avg.ล่าง</b>&nbsp;&nbsp; <input type="text"   style ="text-align:center" id="txt_avgdia" value="" disabled="true">
                                        </h2>
                                    </div>

                                    <div class="col-lg-12">


                                        <?php
                                        // ค้นหาวันแรกของเดือนปัจจุบัน
                                        $sql_seDatestart = "SELECT FORMAT (DATEADD(MONTH, DATEDIFF(MONTH, 0, GETDATE()), 0), 'dd/MM/yyyy') AS 'DS'";
                                        $params_seDatestart = array();
                                        $query_seDatestart = sqlsrv_query($conn, $sql_seDatestart, $params_seDatestart);
                                        $result_seDatestart = sqlsrv_fetch_array($query_seDatestart, SQLSRV_FETCH_ASSOC);

                                        $sql_seAdddateweek = "{call megGetdate_v2(?,?)}";
                                        $params_seAdddateweek = array(
                                            array('select_dategraph', SQLSRV_PARAM_IN),
                                            array($result_seDatestart['DS'], SQLSRV_PARAM_IN)
                                        );
                                        $query_seAdddateweek = sqlsrv_query($conn, $sql_seAdddateweek, $params_seAdddateweek);
                                        $result_seAdddateweek = sqlsrv_fetch_array($query_seAdddateweek, SQLSRV_FETCH_ASSOC);
                                        //echo $result_seAdddateweek['D1'] . '|' . $result_seAdddateweek['D2'] . '|' . $result_seAdddateweek['D3'] . '|' . $result_seAdddateweek['D4'] . '|' . $result_seAdddateweek['D5'] . '|' . $result_seAdddateweek['D6'] . '|' . $result_seAdddateweek['D7'];

                                        /////////////////QUERY ค้นหาข้อมูล///////////////////////////////////////////////////
                                        //DAY1
                                        $sql_seDay1 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D1']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay1 = array();
                                        $query_seDay1 = sqlsrv_query($conn, $sql_seDay1, $params_seDay1);
                                        $result_seDay1 = sqlsrv_fetch_array($query_seDay1, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY1
                                        if($result_seDay1['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay1['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay1['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY1 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY1 = $result_seDay1['TENKOPRESSUREDATA_90160_3'] ;
                                                }

                                            }else {
                                                    $SYSDAY1 = $result_seDay1['TENKOPRESSUREDATA_90160_2'] ;

                                            }

                                        }else{

                                                    $SYSDAY1 = $result_seDay1['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY1
                                        if($result_seDay1['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay1['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay1['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY1 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {

                                                    $DIADAY1 = $result_seDay1['TENKOPRESSUREDATA_60100_3'];

                                                }

                                            }else {

                                                    $DIADAY1 = $result_seDay1['TENKOPRESSUREDATA_60100_2'];

                                            }

                                        }else{

                                                    $DIADAY1 = $result_seDay1['TENKOPRESSUREDATA_60100'] ;

                                        }
                                        //PULSEDAY1
                                        if($result_seDay1['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay1['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay1['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay1['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay1['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay1['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY1 = '0'; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {

                                                    $PULSEDAY1 = $result_seDay1['TENKOPRESSUREDATA_60110_3'];

                                                }

                                            }else {

                                                    $PULSEDAY1 = $result_seDay1['TENKOPRESSUREDATA_60110_2'];

                                            }

                                        }else{

                                                    $PULSEDAY1 = $result_seDay1['TENKOPRESSUREDATA_60110'];

                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY2
                                        $sql_seDay2 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D2']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay2 = array();
                                        $query_seDay2 = sqlsrv_query($conn, $sql_seDay2, $params_seDay2);
                                        $result_seDay2 = sqlsrv_fetch_array($query_seDay2, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY2
                                        if($result_seDay2['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay2['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay2['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY2 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY2 = $result_seDay2['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY2 = $result_seDay2['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY2 = $result_seDay2['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY2
                                        if($result_seDay2['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay2['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay2['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY2 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY2 = $result_seDay2['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY2 = $result_seDay2['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY2 = $result_seDay2['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY2
                                        if($result_seDay2['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay2['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay2['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay2['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay2['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay2['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY2 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY2 = $result_seDay2['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY2 = $result_seDay2['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY2 = $result_seDay2['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY3
                                        $sql_seDay3 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D3']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay3 = array();
                                        $query_seDay3 = sqlsrv_query($conn, $sql_seDay3, $params_seDay3);
                                        $result_seDay3 = sqlsrv_fetch_array($query_seDay3, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY3
                                        if($result_seDay3['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay3['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay3['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY3 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY3 = $result_seDay3['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY3 = $result_seDay3['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY3 = $result_seDay3['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY3
                                        if($result_seDay3['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay3['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay3['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY3 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY3 = $result_seDay3['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY3 = $result_seDay3['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY3 = $result_seDay3['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY3
                                        if($result_seDay3['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay3['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay3['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay3['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay3['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay3['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY3 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY3 = $result_seDay3['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY3 = $result_seDay3['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY3 = $result_seDay3['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY4
                                        $sql_seDay4 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D4']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay4 = array();
                                        $query_seDay4 = sqlsrv_query($conn, $sql_seDay4, $params_seDay4);
                                        $result_seDay4 = sqlsrv_fetch_array($query_seDay4, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY4
                                        if($result_seDay4['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay4['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay4['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY4 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY4 = $result_seDay4['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY4 = $result_seDay4['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY4 = $result_seDay4['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY4
                                        if($result_seDay4['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay4['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay4['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY4 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY4 = $result_seDay4['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY4 = $result_seDay4['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY4 = $result_seDay4['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY4
                                        if($result_seDay4['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay4['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay4['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay4['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay4['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay4['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY4 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY4 = $result_seDay4['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY4 = $result_seDay4['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY4 = $result_seDay4['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY5
                                        $sql_seDay5 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D5']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay5 = array();
                                        $query_seDay5 = sqlsrv_query($conn, $sql_seDay5, $params_seDay5);
                                        $result_seDay5 = sqlsrv_fetch_array($query_seDay5, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY5
                                        if($result_seDay5['TENKOPRESSUREDATA_90160'] >= $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay5['TENKOPRESSUREDATA_90160_2'] >= $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay5['TENKOPRESSUREDATA_90160_3'] >= $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY5 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY5 = $result_seDay5['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY5 = $result_seDay5['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY5 = $result_seDay5['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY5
                                        if($result_seDay5['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay5['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay5['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY5 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY5 = $result_seDay5['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY5 = $result_seDay5['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY5 = $result_seDay5['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY5
                                        if($result_seDay5['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay5['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay5['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay5['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay5['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay5['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY5 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY5 = $result_seDay5['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY5 = $result_seDay5['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY5 = $result_seDay5['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY6
                                        $sql_seDay6 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D6']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay6 = array();
                                        $query_seDay6 = sqlsrv_query($conn, $sql_seDay6, $params_seDay6);
                                        $result_seDay6 = sqlsrv_fetch_array($query_seDay6, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY6
                                        if($result_seDay6['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay6['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay6['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY6 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY6 = $result_seDay6['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY6 = $result_seDay6['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY6 = $result_seDay6['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY6
                                        if($result_seDay6['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay6['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay6['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY6 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY6 = $result_seDay6['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY6 = $result_seDay6['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY6 = $result_seDay6['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY6
                                        if($result_seDay6['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay6['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay6['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay6['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay6['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay6['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY6 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY6 = $result_seDay6['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY6 = $result_seDay6['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY6 = $result_seDay6['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY7
                                        $sql_seDay7 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D7']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay7 = array();
                                        $query_seDay7 = sqlsrv_query($conn, $sql_seDay7, $params_seDay7);
                                        $result_seDay7 = sqlsrv_fetch_array($query_seDay7, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY7
                                        if($result_seDay7['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay7['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay7['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY7 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY7 = $result_seDay7['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY7 = $result_seDay7['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY7 = $result_seDay7['TENKOPRESSUREDATA_90160'];
                                        }
                                        //DIADAY7
                                        if($result_seDay7['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay7['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay7['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY7 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY7 = $result_seDay7['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY7 = $result_seDay7['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY7 = $result_seDay7['TENKOPRESSUREDATA_60100'] ;
                                                // $DIADAY71 = $result_seDay7['TENKOPRESSUREDATA_60100'] ;
                                                // if ($DIADAY71 == '') {
                                                //     $DIADAY7 = '0';
                                                // }else {
                                                //     $DIADAY7 = $DIADAY71;
                                                // }
                                        }
                                        //PULSEDAY7
                                        if($result_seDay7['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay7['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay7['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay7['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay7['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay7['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY7 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY7 = $result_seDay7['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY7 = $result_seDay7['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY7 = $result_seDay7['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY8
                                        $sql_seDay8 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D8']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay8 = array();
                                        $query_seDay8 = sqlsrv_query($conn, $sql_seDay8, $params_seDay8);
                                        $result_seDay8 = sqlsrv_fetch_array($query_seDay8, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY2
                                        if($result_seDay8['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay8['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay8['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY8 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY8 = $result_seDay8['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY8 = $result_seDay8['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY8 = $result_seDay8['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY8
                                        if($result_seDay8['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay8['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay8['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY8 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY8 = $result_seDay8['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY8 = $result_seDay8['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY8 = $result_seDay8['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY8
                                        if($result_seDay8['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay8['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay8['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay8['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay8['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay8['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY8 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY8 = $result_seDay8['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY8 = $result_seDay8['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY8 = $result_seDay8['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY9
                                        $sql_seDay9 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D9']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay9 = array();
                                        $query_seDay9 = sqlsrv_query($conn, $sql_seDay9, $params_seDay9);
                                        $result_seDay9 = sqlsrv_fetch_array($query_seDay9, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY9
                                        if($result_seDay9['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay9['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay9['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY9 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY9 = $result_seDay9['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY9 = $result_seDay9['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY9 = $result_seDay9['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY9
                                        if($result_seDay9['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay9['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay9['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY9 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY9 = $result_seDay9['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY9 = $result_seDay9['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY9 = $result_seDay9['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY9
                                        if($result_seDay9['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay9['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay9['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay9['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay9['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay9['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY9 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY9 = $result_seDay9['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY9 = $result_seDay9['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY9 = $result_seDay9['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY10
                                        $sql_seDay10 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D10']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay10 = array();
                                        $query_seDay10 = sqlsrv_query($conn, $sql_seDay10, $params_seDay10);
                                        $result_seDay10 = sqlsrv_fetch_array($query_seDay10, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY10
                                        if($result_seDay10['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay10['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay10['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY10 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY10 = $result_seDay10['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY10 = $result_seDay10['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY10 = $result_seDay10['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY10
                                        if($result_seDay10['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay10['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay10['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY10 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY10 = $result_seDay10['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY10 = $result_seDay10['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY10 = $result_seDay10['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY10
                                        if($result_seDay10['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay10['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay10['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay10['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay10['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay10['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY10 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY10 = $result_seDay10['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY10 = $result_seDay10['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY10 = $result_seDay10['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY11
                                        $sql_seDay11 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D11']."',103)
                                        AND (TENKOTEMPERATUREDATA != NULL OR TENKOTEMPERATUREDATA != ''
                                        OR TENKOPRESSUREDATA_90160 != NULL OR TENKOPRESSUREDATA_90160 != ''
                                        OR TENKOPRESSUREDATA_60100 != NULL OR TENKOPRESSUREDATA_60100 != ''
                                        OR TENKOPRESSUREDATA_60110 != NULL OR TENKOPRESSUREDATA_60110 != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay11 = array();
                                        $query_seDay11 = sqlsrv_query($conn, $sql_seDay11, $params_seDay11);
                                        $result_seDay11 = sqlsrv_fetch_array($query_seDay11, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY11
                                        if($result_seDay11['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay11['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay11['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY11 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY11 = $result_seDay11['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY11 = $result_seDay11['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY11 = $result_seDay11['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY11
                                        if($result_seDay11['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay11['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay11['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY11 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY11 = $result_seDay11['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY11 = $result_seDay11['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY11 = $result_seDay11['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY11
                                        if($result_seDay11['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay11['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay11['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay11['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay11['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay11['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY11 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY11 = $result_seDay11['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY11 = $result_seDay11['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY11 = $result_seDay11['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY12
                                        $sql_seDay12 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D12']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay12 = array();
                                        $query_seDay12 = sqlsrv_query($conn, $sql_seDay12, $params_seDay12);
                                        $result_seDay12 = sqlsrv_fetch_array($query_seDay12, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY2
                                        if($result_seDay12['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay12['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay12['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY2 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY12 = $result_seDay12['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY12 = $result_seDay12['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY12 = $result_seDay12['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY12
                                        if($result_seDay12['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay12['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay12['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY12 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY12 = $result_seDay12['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY12 = $result_seDay12['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY12 = $result_seDay12['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY12
                                        if($result_seDay12['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay12['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay12['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay12['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay12['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay12['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY12 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY12 = $result_seDay12['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY12 = $result_seDay12['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY12 = $result_seDay12['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY13
                                        $sql_seDay13 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D13']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay13 = array();
                                        $query_seDay13 = sqlsrv_query($conn, $sql_seDay13, $params_seDay13);
                                        $result_seDay13 = sqlsrv_fetch_array($query_seDay13, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY13
                                        if($result_seDay13['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay13['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay13['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY13 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY13 = $result_seDay13['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY13 = $result_seDay13['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY13 = $result_seDay13['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY13
                                        if($result_seDay13['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay13['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay13['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY13 = ''; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY13 = $result_seDay13['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY13 = $result_seDay13['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY13 = $result_seDay13['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY13
                                        if($result_seDay13['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay13['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay13['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay13['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay13['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay13['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY13 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY13 = $result_seDay13['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY13 = $result_seDay13['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY13 = $result_seDay13['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY14
                                        $sql_seDay14 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D14']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay14 = array();
                                        $query_seDay14 = sqlsrv_query($conn, $sql_seDay14, $params_seDay14);
                                        $result_seDay14 = sqlsrv_fetch_array($query_seDay14, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY14
                                        if($result_seDay14['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay14['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay14['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY14 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY14 = $result_seDay14['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY14 = $result_seDay14['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY14 = $result_seDay14['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY14
                                        if($result_seDay14['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay14['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay14['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY14 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY14 = $result_seDay14['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY14 = $result_seDay14['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY14 = $result_seDay14['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY14
                                        if($result_seDay14['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay14['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay14['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay14['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay14['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay14['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY14 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY14 = $result_seDay14['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY14 = $result_seDay14['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY14 = $result_seDay14['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY15
                                        $sql_seDay15 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D15']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay15 = array();
                                        $query_seDay15 = sqlsrv_query($conn, $sql_seDay15, $params_seDay15);
                                        $result_seDay15 = sqlsrv_fetch_array($query_seDay15, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY15
                                        if($result_seDay15['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay15['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay15['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY15 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY15 = $result_seDay15['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY15 = $result_seDay15['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY15 = $result_seDay15['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY15
                                        if($result_seDay15['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay15['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay15['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY15 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY15 = $result_seDay15['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY15 = $result_seDay15['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY15 = $result_seDay15['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY15
                                        if($result_seDay15['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay15['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay15['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay15['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay15['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay15['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY15 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY15 = $result_seDay15['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY15 = $result_seDay15['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY15 = $result_seDay15['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY16
                                        $sql_seDay16 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D16']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay16 = array();
                                        $query_seDay16 = sqlsrv_query($conn, $sql_seDay16, $params_seDay16);
                                        $result_seDay16 = sqlsrv_fetch_array($query_seDay16, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY16
                                        if($result_seDay16['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay16['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay16['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY16 = ''; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY16 = $result_seDay16['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY16 = $result_seDay16['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY16 = $result_seDay16['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY16
                                        if($result_seDay16['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay16['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay16['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY16 = ''; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY16 = $result_seDay16['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY16 = $result_seDay16['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY16 = $result_seDay16['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY16
                                        if($result_seDay16['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay16['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay16['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay16['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay16['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay16['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY16 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY16 = $result_seDay16['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY16 = $result_seDay16['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY16 = $result_seDay16['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY17
                                        $sql_seDay17 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D17']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay17 = array();
                                        $query_seDay17 = sqlsrv_query($conn, $sql_seDay17, $params_seDay17);
                                        $result_seDay17 = sqlsrv_fetch_array($query_seDay17, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY17
                                        if($result_seDay17['TENKOPRESSUREDATA_90160'] >= $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay17['TENKOPRESSUREDATA_90160_2'] >= $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay17['TENKOPRESSUREDATA_90160_3'] >= $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY17 = ''; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY17 = $result_seDay17['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY17 = $result_seDay17['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY17 = $result_seDay17['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY17
                                        if($result_seDay17['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay17['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay17['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY17 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY17 = $result_seDay17['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY17 = $result_seDay17['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY17 = $result_seDay17['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY17
                                        if($result_seDay17['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay17['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay17['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay17['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay17['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay17['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY17 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY17 = $result_seDay17['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY17 = $result_seDay17['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY17 = $result_seDay17['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY18
                                        $sql_seDay18 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D18']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay18 = array();
                                        $query_seDay18 = sqlsrv_query($conn, $sql_seDay18, $params_seDay18);
                                        $result_seDay18 = sqlsrv_fetch_array($query_seDay18, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY18
                                        if($result_seDay18['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay18['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay18['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY18 = ''; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY18 = $result_seDay18['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY18 = $result_seDay18['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY18 = $result_seDay18['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY18
                                        if($result_seDay18['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay18['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay18['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY18 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY18 = $result_seDay18['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY18 = $result_seDay18['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY18 = $result_seDay18['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY18
                                        if($result_seDay18['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay18['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay18['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay18['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay18['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay18['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY18 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY18 = $result_seDay18['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY18 = $result_seDay18['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY18 = $result_seDay18['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY19
                                        $sql_seDay19 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D19']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay19 = array();
                                        $query_seDay19 = sqlsrv_query($conn, $sql_seDay19, $params_seDay19);
                                        $result_seDay19 = sqlsrv_fetch_array($query_seDay19, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY19
                                        if($result_seDay19['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay19['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay19['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY19 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY19 = $result_seDay19['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY19 = $result_seDay19['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY19 = $result_seDay19['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY19
                                        if($result_seDay19['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay19['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay19['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY19 = ''; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY19 = $result_seDay19['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY19 = $result_seDay19['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY19 = $result_seDay19['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY19
                                        if($result_seDay19['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay19['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay19['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay19['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay19['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay19['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY19 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY19 = $result_seDay19['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY19 = $result_seDay19['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY19 = $result_seDay19['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY20
                                        $sql_seDay20 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D20']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay20 = array();
                                        $query_seDay20 = sqlsrv_query($conn, $sql_seDay20, $params_seDay20);
                                        $result_seDay20 = sqlsrv_fetch_array($query_seDay20, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY20
                                        if($result_seDay20['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay20['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay20['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY20 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY20 = $result_seDay20['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY20 = $result_seDay20['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY20 = $result_seDay20['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY20
                                        if($result_seDay20['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay20['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay20['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY20 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY20 = $result_seDay20['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY20 = $result_seDay20['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY20 = $result_seDay20['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY20
                                        if($result_seDay20['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay20['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay20['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay20['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay20['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay20['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY20 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY20 = $result_seDay20['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY20 = $result_seDay20['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY20 = $result_seDay20['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY21
                                        $sql_seDay21 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D21']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay21 = array();
                                        $query_seDay21 = sqlsrv_query($conn, $sql_seDay21, $params_seDay21);
                                        $result_seDay21 = sqlsrv_fetch_array($query_seDay21, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY21
                                        if($result_seDay21['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay21['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay21['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY21 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY21 = $result_seDay21['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY21 = $result_seDay21['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY21 = $result_seDay21['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY21
                                        if($result_seDay21['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay21['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay21['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY21 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY21 = $result_seDay21['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY21 = $result_seDay21['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY21 = $result_seDay21['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY21
                                        if($result_seDay21['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay21['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay21['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay21['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay21['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay21['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY21 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY21 = $result_seDay21['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY21 = $result_seDay21['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY21 = $result_seDay21['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY22
                                        $sql_seDay22 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D22']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay22 = array();
                                        $query_seDay22 = sqlsrv_query($conn, $sql_seDay22, $params_seDay22);
                                        $result_seDay22 = sqlsrv_fetch_array($query_seDay22, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY22
                                        if($result_seDay22['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay22['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay22['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY22 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY22 = $result_seDay22['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY22 = $result_seDay22['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY22 = $result_seDay22['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY22
                                        if($result_seDay22['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay22['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay22['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY22 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY22 = $result_seDay22['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY22 = $result_seDay22['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY22 = $result_seDay22['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY22
                                        if($result_seDay22['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay22['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay22['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay22['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay22['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay22['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY22 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY22 = $result_seDay22['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY22 = $result_seDay22['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY22 = $result_seDay22['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY23
                                        $sql_seDay23 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D23']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay23 = array();
                                        $query_seDay23 = sqlsrv_query($conn, $sql_seDay23, $params_seDay23);
                                        $result_seDay23 = sqlsrv_fetch_array($query_seDay23, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY2
                                        if($result_seDay23['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay23['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay23['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY23 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY23 = $result_seDay23['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY23 = $result_seDay23['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY23 = $result_seDay23['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY23
                                        if($result_seDay23['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay23['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay23['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY23 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY23 = $result_seDay23['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY23 = $result_seDay23['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY23 = $result_seDay23['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY23
                                        if($result_seDay23['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay23['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay23['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay23['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay23['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay23['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY23 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY23 = $result_seDay23['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY23 = $result_seDay23['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY23 = $result_seDay23['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY24
                                        $sql_seDay24 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D24']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay24 = array();
                                        $query_seDay24 = sqlsrv_query($conn, $sql_seDay24, $params_seDay24);
                                        $result_seDay24 = sqlsrv_fetch_array($query_seDay24, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY24
                                        if($result_seDay24['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay24['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay24['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY24 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY24 = $result_seDay24['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY24 = $result_seDay24['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY24 = $result_seDay24['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY24
                                        if($result_seDay24['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay24['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay24['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY24 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY24 = $result_seDay24['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY24 = $result_seDay24['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY24 = $result_seDay24['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY24
                                        if($result_seDay24['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay24['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay24['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay24['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay24['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay24['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY24 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY24 = $result_seDay24['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY24 = $result_seDay24['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY24 = $result_seDay24['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY25
                                        $sql_seDay25 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D25']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay25 = array();
                                        $query_seDay25 = sqlsrv_query($conn, $sql_seDay25, $params_seDay25);
                                        $result_seDay25 = sqlsrv_fetch_array($query_seDay25, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY25
                                        if($result_seDay25['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay25['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay25['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY25 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY25 = $result_seDay25['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY25 = $result_seDay25['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY25 = $result_seDay25['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY25
                                        if($result_seDay25['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay25['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay25['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY25 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY25 = $result_seDay25['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY25 = $result_seDay25['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY25 = $result_seDay25['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY25
                                        if($result_seDay25['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay25['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay25['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay25['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay25['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay25['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY25 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY25 = $result_seDay25['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY25 = $result_seDay25['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY25 = $result_seDay25['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY26
                                        $sql_seDay26 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D26']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay26 = array();
                                        $query_seDay26 = sqlsrv_query($conn, $sql_seDay26, $params_seDay26);
                                        $result_seDay26 = sqlsrv_fetch_array($query_seDay26, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY26
                                        if($result_seDay26['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay26['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay26['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY26 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY26 = $result_seDay26['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY26 = $result_seDay26['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY26 = $result_seDay26['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY26
                                        if($result_seDay26['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay26['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay26['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY26 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY26 = $result_seDay26['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY26 = $result_seDay26['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY26 = $result_seDay26['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY26
                                        if($result_seDay26['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay26['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay26['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay26['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay26['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay26['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY26 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY26 = $result_seDay26['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY26 = $result_seDay26['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY26 = $result_seDay26['TENKOPRESSUREDATA_60110'] ;
                                        }

                                        //////////////////////////////////////////////////////////////////////

                                        //DAY27
                                        $sql_seDay27 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D27']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay27 = array();
                                        $query_seDay27 = sqlsrv_query($conn, $sql_seDay27, $params_seDay27);
                                        $result_seDay27 = sqlsrv_fetch_array($query_seDay27, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY27
                                        if($result_seDay27['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay27['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay27['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY27 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY27 = $result_seDay27['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY27 = $result_seDay27['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY27 = $result_seDay27['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY27
                                        if($result_seDay27['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay27['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay27['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY27 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY27 = $result_seDay27['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY27 = $result_seDay27['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY27 = $result_seDay27['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY27
                                        if($result_seDay27['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay27['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay27['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay27['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay27['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay27['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY27 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY27 = $result_seDay27['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY27 = $result_seDay27['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY27 = $result_seDay27['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY28
                                        $sql_seDay28 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D28']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay28 = array();
                                        $query_seDay28 = sqlsrv_query($conn, $sql_seDay28, $params_seDay28);
                                        $result_seDay28 = sqlsrv_fetch_array($query_seDay28, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY28
                                        if($result_seDay28['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay28['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay28['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY28 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY28 = $result_seDay28['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY28 = $result_seDay28['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY28 = $result_seDay28['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY28
                                        if($result_seDay28['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay28['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay28['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY28 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY28 = $result_seDay28['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY28 = $result_seDay28['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY28 = $result_seDay28['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY28
                                        if($result_seDay28['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay28['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay28['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay28['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay28['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay28['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY28 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY28 = $result_seDay28['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY28 = $result_seDay28['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY28 = $result_seDay28['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY29
                                        $sql_seDay29 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D29']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay29 = array();
                                        $query_seDay29 = sqlsrv_query($conn, $sql_seDay29, $params_seDay29);
                                        $result_seDay29 = sqlsrv_fetch_array($query_seDay29, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY29
                                        if($result_seDay29['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay29['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay29['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY29 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY29 = $result_seDay29['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY29 = $result_seDay29['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY29 = $result_seDay29['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY29
                                        if($result_seDay29['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay29['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay29['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY29 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY29 = $result_seDay29['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY29 = $result_seDay29['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY29 = $result_seDay29['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY29
                                        if($result_seDay29['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay29['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay29['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay29['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay29['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay29['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY29 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY29 = $result_seDay29['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY29 = $result_seDay29['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY29 = $result_seDay29['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY30
                                        $sql_seDay30 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D30']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay30 = array();
                                        $query_seDay30 = sqlsrv_query($conn, $sql_seDay30, $params_seDay30);
                                        $result_seDay30 = sqlsrv_fetch_array($query_seDay30, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY30
                                        if($result_seDay30['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay30['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay30['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY30 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY30 = $result_seDay30['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY30 = $result_seDay30['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY30 = $result_seDay30['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY30
                                        if($result_seDay30['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay30['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay30['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY30 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY30 = $result_seDay30['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY30 = $result_seDay30['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY30 = $result_seDay30['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY30
                                        if($result_seDay30['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay30['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay30['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay30['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay30['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay30['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY30 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY30 = $result_seDay30['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY30 = $result_seDay30['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY30 = $result_seDay30['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////
                                        //DAY31
                                        $sql_seDay31 = "SELECT
                                        b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                                        ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                                        ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                                        ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                                        ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
                                        FROM  TENKOBEFORE b
                                        WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D31']."',103)
                                        AND (b.TENKOTEMPERATUREDATA != NULL  OR  b.TENKOTEMPERATUREDATA != ''
                                        OR b.TENKOPRESSUREDATA_90160 != NULL OR b.TENKOPRESSUREDATA_90160 != ''
                                        OR b.TENKOPRESSUREDATA_60100 != NULL OR b.TENKOPRESSUREDATA_60100 != ''
                                        OR b.TENKOPRESSUREDATA_60110 != NULL OR b.TENKOPRESSUREDATA_60110 != ''
                                        OR b.TENKOALCOHOLDATA != NULL OR b.TENKOALCOHOLDATA != ''
                                        OR b.TENKOOXYGENDATA != NULL  OR b.TENKOOXYGENDATA != '')
                                        ORDER BY b.CREATEDATE DESC";
                                        $params_seDay31 = array();
                                        $query_seDay31 = sqlsrv_query($conn, $sql_seDay31, $params_seDay31);
                                        $result_seDay31 = sqlsrv_fetch_array($query_seDay31, SQLSRV_FETCH_ASSOC);
                                        // SYSDAY31
                                        if($result_seDay31['TENKOPRESSUREDATA_90160'] > $result_seTenkoSTD['MAXSYS']){
                                            if ($result_seDay31['TENKOPRESSUREDATA_90160_2'] > $result_seTenkoSTD['MAXSYS'] ) {
                                                if ($result_seDay31['TENKOPRESSUREDATA_90160_3'] > $result_seTenkoSTD['MAXSYS']) {
                                                    $SYSDAY31 = '0'; // ความดันบนครั้งที่ 3 เกิน
                                                }else {
                                                    $SYSDAY31 = $result_seDay31['TENKOPRESSUREDATA_90160_3'];
                                                }

                                            }else {
                                                $SYSDAY31 = $result_seDay31['TENKOPRESSUREDATA_90160_2'];
                                            }

                                        }else{
                                                $SYSDAY31 = $result_seDay31['TENKOPRESSUREDATA_90160'] ;
                                        }
                                        //DIADAY31
                                        if($result_seDay31['TENKOPRESSUREDATA_60100'] > $result_seTenkoSTD['MAXDIA']){
                                            if ($result_seDay31['TENKOPRESSUREDATA_60100_2'] > $result_seTenkoSTD['MAXDIA'] ) {
                                                if ($result_seDay31['TENKOPRESSUREDATA_60100_3'] > $result_seTenkoSTD['MAXDIA']) {
                                                    $DIADAY31 = '0'; // ความดันล่างครั้งที่ 3 เกิน
                                                }else {
                                                    $DIADAY31 = $result_seDay31['TENKOPRESSUREDATA_60100_3'];
                                                }

                                            }else {
                                                $DIADAY31 = $result_seDay31['TENKOPRESSUREDATA_60100_2'];
                                            }

                                        }else{
                                                $DIADAY31 = $result_seDay31['TENKOPRESSUREDATA_60100'] ;
                                        }
                                        //PULSEDAY31
                                        if($result_seDay31['TENKOPRESSUREDATA_60110'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay31['TENKOPRESSUREDATA_60110'] < $result_seTenkoSTD['MINPULSE']){
                                            if ($result_seDay31['TENKOPRESSUREDATA_60110_2'] > $result_seTenkoSTD['MAXPULSE']  || $result_seDay31['TENKOPRESSUREDATA_60110_2'] < $result_seTenkoSTD['MINPULSE'] ) {
                                                if ($result_seDay20['TENKOPRESSUREDATA_60110_3'] > $result_seTenkoSTD['MAXPULSE'] || $result_seDay31['TENKOPRESSUREDATA_60110_3'] < $result_seTenkoSTD['MINPULSE']) {
                                                    $PULSEDAY31 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
                                                }else {
                                                    $PULSEDAY31 = $result_seDay31['TENKOPRESSUREDATA_60110_3'];
                                                }

                                            }else {
                                                $PULSEDAY31 = $result_seDay31['TENKOPRESSUREDATA_60110_2'];
                                            }

                                        }else{
                                                $PULSEDAY31 = $result_seDay31['TENKOPRESSUREDATA_60110'] ;
                                        }
                                        //////////////////////////////////////////////////////////////////////

                                         $SYSAVG = ($SYSDAY1    + $SYSDAY2  + $SYSDAY3  + $SYSDAY4  + $SYSDAY5
                                                    + $SYSDAY6  + $SYSDAY7  + $SYSDAY8  + $SYSDAY9  + $SYSDAY10
                                                    + $SYSDAY11 + $SYSDAY12 + $SYSDAY13 + $SYSDAY14 + $SYSDAY15
                                                    + $SYSDAY16 + $SYSDAY17 + $SYSDAY18 + $SYSDAY19 + $SYSDAY20
                                                    + $SYSDAY21 + $SYSDAY22 + $SYSDAY23 + $SYSDAY24 + $SYSDAY25
                                                    + $SYSDAY26 + $SYSDAY27 + $SYSDAY28 + $SYSDAY29 + $SYSDAY30
                                                    + $SYSDAY31 )/$result_seCountData['COUNT'];


                                        $DIAAVG = ($DIADAY1     + $DIADAY2  + $DIADAY3  + $DIADAY4  + $DIADAY5
                                                    + $DIADAY6  + $DIADAY7  + $DIADAY8  + $DIADAY9  + $DIADAY10
                                                    + $DIADAY11 + $DIADAY12 + $DIADAY13 + $DIADAY14 + $DIADAY15
                                                    + $DIADAY16 + $DIADAY17 + $DIADAY18 + $DIADAY19 + $DIADAY20
                                                    + $DIADAY21 + $DIADAY22 + $DIADAY23 + $DIADAY24 + $DIADAY25
                                                    + $DIADAY26 + $DIADAY27 + $DIADAY28 + $DIADAY29 + $DIADAY30
                                                    + $DIADAY31 )/$result_seCountData['COUNT'];


                                        $TEMPAVG = ($result_seDay1['TENKOTEMPERATUREDATA'] + $result_seDay2['TENKOTEMPERATUREDATA'] +$result_seDay3['TENKOTEMPERATUREDATA'] + $result_seDay4['TENKOTEMPERATUREDATA'] + $result_seDay5['TENKOTEMPERATUREDATA']
                                                    + $result_seDay6['TENKOTEMPERATUREDATA'] + $result_seDay7['TENKOTEMPERATUREDATA'] +$result_seDay8['TENKOTEMPERATUREDATA'] + $result_seDay9['TENKOTEMPERATUREDATA'] + $result_seDay10['TENKOTEMPERATUREDATA']
                                                    + $result_seDay11['TENKOTEMPERATUREDATA'] + $result_seDay12['TENKOTEMPERATUREDATA'] +$result_seDay13['TENKOTEMPERATUREDATA'] + $result_seDay14['TENKOTEMPERATUREDATA'] + $result_seDay15['TENKOTEMPERATUREDATA']
                                                    + $result_seDay16['TENKOTEMPERATUREDATA'] + $result_seDay17['TENKOTEMPERATUREDATA'] +$result_seDay18['TENKOTEMPERATUREDATA'] + $result_seDay19['TENKOTEMPERATUREDATA'] + $result_seDay20['TENKOTEMPERATUREDATA']
                                                    + $result_seDay21['TENKOTEMPERATUREDATA'] + $result_seDay22['TENKOTEMPERATUREDATA'] +$result_seDay23['TENKOTEMPERATUREDATA'] + $result_seDay24['TENKOTEMPERATUREDATA'] + $result_seDay25['TENKOTEMPERATUREDATA']
                                                    + $result_seDay26['TENKOTEMPERATUREDATA'] + $result_seDay27['TENKOTEMPERATUREDATA'] +$result_seDay28['TENKOTEMPERATUREDATA'] + $result_seDay29['TENKOTEMPERATUREDATA'] + $result_seDay30['TENKOTEMPERATUREDATA']
                                                    + $result_seDay31['TENKOTEMPERATUREDATA']  )/$result_seCountData['COUNT'];

                                        $ALCOAVG = ($result_seDay1['TENKOALCOHOLDATA'] + $result_seDay2['TENKOALCOHOLDATA'] +$result_seDay3['TENKOALCOHOLDATA'] + $result_seDay4['TENKOALCOHOLDATA'] + $result_seDay5['TENKOALCOHOLDATA']
                                                    + $result_seDay6['TENKOALCOHOLDATA'] + $result_seDay7['TENKOALCOHOLDATA'] +$result_seDay8['TENKOALCOHOLDATA'] + $result_seDay9['TENKOALCOHOLDATA'] + $result_seDay10['TENKOALCOHOLDATA']
                                                    + $result_seDay11['TENKOALCOHOLDATA'] + $result_seDay12['TENKOALCOHOLDATA'] +$result_seDay13['TENKOALCOHOLDATA'] + $result_seDay14['TENKOALCOHOLDATA'] + $result_seDay15['TENKOALCOHOLDATA']
                                                    + $result_seDay16['TENKOALCOHOLDATA'] + $result_seDay17['TENKOALCOHOLDATA'] +$result_seDay18['TENKOALCOHOLDATA'] + $result_seDay19['TENKOALCOHOLDATA'] + $result_seDay20['TENKOALCOHOLDATA']
                                                    + $result_seDay21['TENKOALCOHOLDATA'] + $result_seDay22['TENKOALCOHOLDATA'] +$result_seDay23['TENKOALCOHOLDATA'] + $result_seDay24['TENKOALCOHOLDATA'] + $result_seDay25['TENKOALCOHOLDATA']
                                                    + $result_seDay26['TENKOALCOHOLDATA'] + $result_seDay27['TENKOALCOHOLDATA'] +$result_seDay28['TENKOALCOHOLDATA'] + $result_seDay29['TENKOALCOHOLDATA'] + $result_seDay30['TENKOALCOHOLDATA']
                                                    + $result_seDay31['TENKOALCOHOLDATA']  )/$result_seCountData['COUNT'];



                                        $PULSEAVG = ($PULSEDAY1   + $PULSEDAY2  + $PULSEDAY3  + $PULSEDAY4  + $PULSEDAY5
                                                    + $PULSEDAY6  + $PULSEDAY7  + $PULSEDAY8  + $PULSEDAY9  + $PULSEDAY10
                                                    + $PULSEDAY11 + $PULSEDAY12 + $PULSEDAY13 + $PULSEDAY14 + $PULSEDAY15
                                                    + $PULSEDAY16 + $PULSEDAY17 + $PULSEDAY18 + $PULSEDAY19 + $PULSEDAY20
                                                    + $PULSEDAY21 + $PULSEDAY22 + $PULSEDAY23 + $PULSEDAY24 + $PULSEDAY25
                                                    + $PULSEDAY26 + $PULSEDAY27 + $PULSEDAY28 + $PULSEDAY29 + $PULSEDAY30
                                                    + $PULSEDAY31 )/$result_seCountData['COUNT'];

                                        $OXYGENAVG = ($result_seDay1['TENKOOXYGENDATA'] + $result_seDay2['TENKOOXYGENDATA'] +$result_seDay3['TENKOOXYGENDATA'] + $result_seDay4['TENKOOXYGENDATA'] + $result_seDay5['TENKOOXYGENDATA']
                                                    + $result_seDay6['TENKOOXYGENDATA'] + $result_seDay7['TENKOOXYGENDATA'] +$result_seDay8['TENKOOXYGENDATA'] + $result_seDay9['TENKOOXYGENDATA'] + $result_seDay10['TENKOOXYGENDATA']
                                                    + $result_seDay11['TENKOOXYGENDATA'] + $result_seDay12['TENKOOXYGENDATA'] +$result_seDay13['TENKOOXYGENDATA'] + $result_seDay14['TENKOOXYGENDATA'] + $result_seDay15['TENKOOXYGENDATA']
                                                    + $result_seDay16['TENKOOXYGENDATA'] + $result_seDay17['TENKOOXYGENDATA'] +$result_seDay18['TENKOOXYGENDATA'] + $result_seDay19['TENKOOXYGENDATA'] + $result_seDay20['TENKOOXYGENDATA']
                                                    + $result_seDay21['TENKOOXYGENDATA'] + $result_seDay22['TENKOOXYGENDATA'] +$result_seDay23['TENKOOXYGENDATA'] + $result_seDay24['TENKOOXYGENDATA'] + $result_seDay25['TENKOOXYGENDATA']
                                                    + $result_seDay26['TENKOOXYGENDATA'] + $result_seDay27['TENKOOXYGENDATA'] +$result_seDay28['TENKOOXYGENDATA'] + $result_seDay29['TENKOOXYGENDATA'] + $result_seDay30['TENKOOXYGENDATA']
                                                    + $result_seDay31['TENKOOXYGENDATA']  )/$result_seCountData['COUNT'];


                                        ?>
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                        <!-- <script type="text/javascript" src="js/jquery.min.js"></script>
                                        <script type="text/javascript" src="js/Chart.min.js"></script> -->
                                        <script type="text/javascript">

                                                                document.getElementById("txt_avgsys").value = <?=number_format($SYSAVG,2)?>;
                                                                document.getElementById("txt_avgdia").value = <?=number_format($DIAAVG,2)?>;

                                                                google.charts.load('current', {'packages': ['corechart']});
                                                                google.charts.setOnLoadCallback(drawChart);


                                                                function drawChart() {

                                                                        var data = google.visualization.arrayToDataTable([
                                                                        ['Day', 'SYS (ความดันบน)', 'DIA (ความดันล่าง)','MaxStd.บน(<?=$result_seTenkoSTD['MAXSYS']?>)','MinStd.บน(<?=$result_seTenkoSTD['MINSYS']?>)','MaxStd.ล่าง(<?=$result_seTenkoSTD['MAXDIA']?>)','MinStd.ล่าง(<?=$result_seTenkoSTD['MINDIA']?>)'],
                                                                        ['<?= $result_seAdddateweek['D1'] ?>', <?=$SYSDAY1?>, <?=$DIADAY1?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D2'] ?>', <?=$SYSDAY2?>, <?=$DIADAY2?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D3'] ?>', <?=$SYSDAY3?>, <?=$DIADAY3?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D4'] ?>', <?=$SYSDAY4?>, <?=$DIADAY4?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D5'] ?>', <?=$SYSDAY5?>, <?=$DIADAY5?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D6'] ?>', <?=$SYSDAY6?>, <?=$DIADAY6?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D7'] ?>', <?=$SYSDAY7?>, <?=$DIADAY7?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D8'] ?>', <?=$SYSDAY8?>, <?=$DIADAY8?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D9'] ?>', <?=$SYSDAY9?>, <?=$DIADAY9?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D10'] ?>', <?=$SYSDAY10?>, <?=$DIADAY10?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D11'] ?>', <?=$SYSDAY11?>, <?=$DIADAY11?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D12'] ?>', <?=$SYSDAY12?>, <?=$DIADAY12?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D13'] ?>', <?=$SYSDAY13?>, <?=$DIADAY13?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D14'] ?>', <?=$SYSDAY14?>, <?=$DIADAY14?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D15'] ?>', <?=$SYSDAY15?>, <?=$DIADAY15?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D16'] ?>', <?=$SYSDAY16?>, <?=$DIADAY16?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D17'] ?>', <?=$SYSDAY17?>, <?=$DIADAY17?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D18'] ?>', <?=$SYSDAY18?>, <?=$DIADAY18?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D19'] ?>', <?=$SYSDAY19?>, <?=$DIADAY19?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D20'] ?>', <?=$SYSDAY20?>, <?=$DIADAY20?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D21'] ?>', <?=$SYSDAY21?>, <?=$DIADAY21?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D22'] ?>', <?=$SYSDAY22?>, <?=$DIADAY22?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D23'] ?>', <?=$SYSDAY23?>, <?=$DIADAY23?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D24'] ?>', <?=$SYSDAY24?>, <?=$DIADAY24?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D25'] ?>', <?=$SYSDAY25?>, <?=$DIADAY25?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D26'] ?>', <?=$SYSDAY26?>, <?=$DIADAY26?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D27'] ?>', <?=$SYSDAY27?>, <?=$DIADAY27?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D28'] ?>', <?=$SYSDAY28?>, <?=$DIADAY28?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D29'] ?>', <?=$SYSDAY29?>, <?=$DIADAY29?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D30'] ?>', <?=$SYSDAY30?>, <?=$DIADAY30?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ],
                                                                        ['<?= $result_seAdddateweek['D31'] ?>', <?=$SYSDAY31?>, <?=$DIADAY31?>,<?=$result_seTenkoSTD['MAXSYS']?>,<?=$result_seTenkoSTD['MINSYS']?>,<?=$result_seTenkoSTD['MAXDIA']?>,<?=$result_seTenkoSTD['MINDIA']?> ]
                                                                    ]);

                                                                    var view = new google.visualization.DataView(data);
                                                                    view.setColumns([0, 1,
                                                                            { calc: "stringify",
                                                                                sourceColumn: 1,
                                                                                type: "string",
                                                                                role: "annotation" },
                                                                            2,
                                                                            { calc: "stringify",
                                                                                    sourceColumn: 2,
                                                                                    type: "string",
                                                                                    role: "annotation" },
                                                                            3,

                                                                            4,

                                                                            5,

                                                                            6

                                                                            ]);



                                                                    var options = {
                                                                        title: '',
                                                                        curveType: '',
                                                                        legend: {position: 'right'},
                                                                        series: {
                                                                                    0: { lineWidth: 5,pointShape:'circle',pointSize: 10, },
                                                                                    1: { lineWidth: 5,pointShape:'circle',pointSize: 10, },
                                                                                    2: { lineWidth: 5,color: '#030100'  },
                                                                                    3: { lineWidth: 5,color: '#030100'  },
                                                                                    4: { lineWidth: 5,lineDashStyle: [2, 2, 20, 2, 20, 2],color: '#a8a6a5'  },
                                                                                    5: { lineWidth: 5,lineDashStyle: [2, 2, 20, 2, 20, 2],color: '#a8a6a5'  },
                                                                                    6: { lineWidth: 5,lineDashStyle: [2, 2, 20, 2, 20, 2]  }
                                                                                },
                                                                        lineWidth: 5,
                                                                        tooltip: {

                                                                                } ,
                                                                        colors: ['#3498DB', '#FF0000', '#068A21', '#000000','#00FFEE','#FF6A00']


                                                                    };


                                                                    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                                                                    chart.draw(view, options);

                                                                }



                                        </script>

                                     <div id="curve_chart" style="width: 100%; height: 500px"></div>


                                    </div>
                                    <!-- /.col-lg-8 (nested) -->
                                </div>
                                <!--END ROW ความดันบน ความดันล่าง  -->

                                <!--  START ROW อุณหภูมิ -->
                                <div class="row">
                                    <div class="col-lg-12" style="text-align:center;">
                                        <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>
                                        กราฟข้อมูลค่าอุณหภูมิของพนักงาน
                                        </h2>
                                    </div>
                                    <div class="col-lg-12" style="text-align:center;">
                                        <h2 class=""><i class=""></i>
                                        <b>Avg.อุณหภูมิ</b>&nbsp;&nbsp;  <input type="text"   style ="text-align:center" id="txt_temp" value="" disabled="true">
                                        </h2>
                                    </div>
                                    <div class="col-lg-12">


                                        <?php

                                        // Tag for query


                                        ?>
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                        <!-- <script type="text/javascript" src="js/jquery.min.js"></script>
                                        <script type="text/javascript" src="js/Chart.min.js"></script> -->
                                        <script type="text/javascript">

                                                            document.getElementById("txt_temp").value = <?=number_format($TEMPAVG,2)?>;


                                                            google.charts.load('current', {'packages': ['corechart']});
                                                            google.charts.setOnLoadCallback(drawChart);

                                                            function drawChart() {

                                                                var data = google.visualization.arrayToDataTable([
                                                                    ['Day', 'อุณหภูมิ', 'ค่ามาตรฐาน(<?=$result_seTenkoSTD['TEMP']?>)','Avg.อุณหภูมิ'],
                                                                    ['<?= $result_seAdddateweek['D1'] ?>', <?=$result_seDay1['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D2'] ?>', <?=$result_seDay2['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?> ],
                                                                    ['<?= $result_seAdddateweek['D3'] ?>', <?=$result_seDay3['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D4'] ?>', <?=$result_seDay4['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D5'] ?>', <?=$result_seDay5['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D6'] ?>', <?=$result_seDay6['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D7'] ?>', <?=$result_seDay7['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D8'] ?>', <?=$result_seDay8['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D9'] ?>', <?=$result_seDay9['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D10'] ?>', <?=$result_seDay10['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D11'] ?>', <?=$result_seDay11['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D12'] ?>', <?=$result_seDay12['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D13'] ?>', <?=$result_seDay13['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D14'] ?>', <?=$result_seDay14['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D15'] ?>', <?=$result_seDay15['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D16'] ?>', <?=$result_seDay16['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D17'] ?>', <?=$result_seDay17['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D18'] ?>', <?=$result_seDay18['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D19'] ?>', <?=$result_seDay19['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D20'] ?>', <?=$result_seDay20['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D21'] ?>', <?=$result_seDay21['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D22'] ?>', <?=$result_seDay22['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D23'] ?>', <?=$result_seDay23['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D24'] ?>', <?=$result_seDay24['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D25'] ?>', <?=$result_seDay25['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D26'] ?>', <?=$result_seDay26['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D27'] ?>', <?=$result_seDay27['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D28'] ?>', <?=$result_seDay28['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D29'] ?>', <?=$result_seDay29['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D30'] ?>', <?=$result_seDay30['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D31'] ?>', <?=$result_seDay31['TENKOTEMPERATUREDATA']?>, <?=$result_seTenkoSTD['TEMP']?>,<?=$TEMPAVG?>  ]
                                                                ]);

                                                                var view = new google.visualization.DataView(data);
                                                                view.setColumns([0, 1,
                                                                        { calc: "stringify",
                                                                            sourceColumn: 1,
                                                                            type: "string",
                                                                            role: "annotation" },
                                                                        2,

                                                                        3,

                                                                        ]);



                                                                var options = {
                                                                    title: '',
                                                                    curveType: '',
                                                                    legend: {position: 'right'},
                                                                    series: {
                                                                                0: { lineWidth: 5,pointShape:'circle',pointSize: 10, },
                                                                                1: { lineWidth: 10,color: '#030100'    },
                                                                                2: { lineWidth: 6,lineDashStyle: [2, 2, 20, 2, 20, 2]  }
                                                                            },
                                                                    lineWidth: 5,
                                                                    tooltip: {

                                                                            } ,
                                                                    colors: ['#3498DB', '#239B56','#00FFEE']


                                                                };


                                                                var chart = new google.visualization.LineChart(document.getElementById('curve_charttemp'));
                                                                chart.draw(view, options);

                                                            }
                                        </script>

                                        <div id="curve_charttemp" style="width: 100%; height: 500px"></div>


                                    </div>
                                    <!-- /.col-lg-8 (nested) -->
                                </div>
                                <!--  END ROW อุณหภูมิ  -->

                                <!-- START ROW แอลกอฮอล์ -->
                                <div class="row">
                                    <div class="col-lg-12" style="text-align:center;">
                                        <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>
                                        กราฟข้อมูลค่าแอลกอฮอล์ของพนักงาน
                                        </h2>
                                    </div>
                                    <div class="col-lg-12" style="text-align:center;">
                                        <h2 class=""><i class=""></i>
                                        <b>Avg.แอลกอฮอล์</b>&nbsp;&nbsp;  <input type="text"   style ="text-align:center" id="txt_alcohol" value="" disabled="true">
                                        </h2>
                                    </div>
                                    <div class="col-lg-12">
                                        <?php

                                        // Tag for query


                                        ?>
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                        <!-- <script type="text/javascript" src="js/jquery.min.js"></script>
                                        <script type="text/javascript" src="js/Chart.min.js"></script> -->
                                        <script type="text/javascript">

                                                            document.getElementById("txt_alcohol").value = <?=number_format($ALCOAVG,2)?>;

                                                            google.charts.load('current', {'packages': ['corechart']});
                                                            google.charts.setOnLoadCallback(drawChart);

                                                            function drawChart() {

                                                                var data = google.visualization.arrayToDataTable([
                                                                    ['Day', 'แอลกอฮอล์', 'ค่ามาตรฐาน(<?=$result_seTenkoSTD['ALCOHOL']?>)','Avg.แอลกอฮอล์'],
                                                                    ['<?= $result_seAdddateweek['D1'] ?>', <?=$result_seDay1['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D2'] ?>', <?=$result_seDay2['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?> ],
                                                                    ['<?= $result_seAdddateweek['D3'] ?>', <?=$result_seDay3['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D4'] ?>', <?=$result_seDay4['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D5'] ?>', <?=$result_seDay5['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D6'] ?>', <?=$result_seDay6['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D7'] ?>', <?=$result_seDay7['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D8'] ?>', <?=$result_seDay8['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D9'] ?>', <?=$result_seDay9['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D10'] ?>', <?=$result_seDay10['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D11'] ?>', <?=$result_seDay11['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D12'] ?>', <?=$result_seDay12['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D13'] ?>', <?=$result_seDay13['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D14'] ?>', <?=$result_seDay14['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D15'] ?>', <?=$result_seDay15['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D16'] ?>', <?=$result_seDay16['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D17'] ?>', <?=$result_seDay17['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D18'] ?>', <?=$result_seDay18['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D19'] ?>', <?=$result_seDay19['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D20'] ?>', <?=$result_seDay20['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D21'] ?>', <?=$result_seDay21['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D22'] ?>', <?=$result_seDay22['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D23'] ?>', <?=$result_seDay23['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D24'] ?>', <?=$result_seDay24['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D25'] ?>', <?=$result_seDay25['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D26'] ?>', <?=$result_seDay26['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D27'] ?>', <?=$result_seDay27['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D28'] ?>', <?=$result_seDay28['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D29'] ?>', <?=$result_seDay29['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D30'] ?>', <?=$result_seDay30['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D31'] ?>', <?=$result_seDay31['TENKOALCOHOLDATA']?>, <?=$result_seTenkoSTD['ALCOHOL']?>,<?=$ALCOAVG?>  ]
                                                                ]);

                                                                var view = new google.visualization.DataView(data);
                                                                view.setColumns([0, 1,
                                                                        { calc: "stringify",
                                                                            sourceColumn: 1,
                                                                            type: "string",
                                                                            role: "annotation" },
                                                                        2,

                                                                        3,
                                                                        ]);



                                                                var options = {
                                                                    title: '',
                                                                    curveType: '',
                                                                    legend: {position: 'right'},
                                                                    series: {
                                                                                0: { lineWidth: 5,pointShape:'circle',pointSize: 10, },
                                                                                1: { lineWidth: 8,color: '#030100'      },
                                                                                2: { lineWidth: 4,lineDashStyle: [2, 2, 20, 2, 20, 2]  }

                                                                            },
                                                                    lineWidth: 5,
                                                                    tooltip: {

                                                                            } ,
                                                                    colors: ['#3498DB', '#239B56','#00FFEE']


                                                                };


                                                                var chart = new google.visualization.LineChart(document.getElementById('curve_chartalco'));
                                                                chart.draw(view, options);

                                                            }
                                        </script>

                                    <div id="curve_chartalco" style="width: 100%; height: 500px"></div>


                                    </div>
                                    <!-- /.col-lg-8 (nested) -->
                                    </div>
                                <!-- END ROW แอลกอฮอล์ -->

                                <!-- START ROW HEARTRATE -->
                                <div class="row">
                                    <div class="col-lg-12" style="text-align:center;">
                                        <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>
                                        กราฟข้อมูลค่าอัตราการเต้นของหัวใจของพนักงาน
                                        </h2>
                                    </div>
                                    <div class="col-lg-12" style="text-align:center;">
                                        <h2 class=""><i class=""></i>
                                        <b>Avg.อัตราการเต้นของหัวใจ</b>&nbsp;&nbsp;  <input type="text"   style ="text-align:center" id="txt_pulse" value="" disabled="true">
                                        </h2>
                                    </div>
                                    <div class="col-lg-12">
                                        <?php


                                        // Tag for query

                                        ?>
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                        <!-- <script type="text/javascript" src="js/jquery.min.js"></script>
                                        <script type="text/javascript" src="js/Chart.min.js"></script> -->
                                        <script type="text/javascript">

                                                            document.getElementById("txt_pulse").value = <?=number_format($PULSEAVG,2)?>;

                                                            google.charts.load('current', {'packages': ['corechart']});
                                                            google.charts.setOnLoadCallback(drawChart);

                                                            function drawChart() {

                                                                var data = google.visualization.arrayToDataTable([
                                                                    ['Day', 'อัตราการเต้นของหัวใจ', 'ค่ามาตรฐาน(<?=$result_seTenkoSTD['MAXPULSE']?>)','Avg.อัตราการเต้นของหัวใจ'],
                                                                    ['<?= $result_seAdddateweek['D1'] ?>', <?=$PULSEDAY1?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>],
                                                                    ['<?= $result_seAdddateweek['D2'] ?>', <?=$PULSEDAY2?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?> ],
                                                                    ['<?= $result_seAdddateweek['D3'] ?>', <?=$PULSEDAY3?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D4'] ?>', <?=$PULSEDAY4?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D5'] ?>', <?=$PULSEDAY5?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D6'] ?>', <?=$PULSEDAY6?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D7'] ?>', <?=$PULSEDAY7?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D8'] ?>', <?=$PULSEDAY8?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D9'] ?>', <?=$PULSEDAY9?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D10'] ?>', <?=$PULSEDAY10?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D11'] ?>', <?=$PULSEDAY11?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D12'] ?>', <?=$PULSEDAY12?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D13'] ?>', <?=$PULSEDAY13?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D14'] ?>', <?=$PULSEDAY14?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D15'] ?>', <?=$PULSEDAY15?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D16'] ?>', <?=$PULSEDAY16?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D17'] ?>', <?=$PULSEDAY17?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D18'] ?>', <?=$PULSEDAY18?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D19'] ?>', <?=$PULSEDAY19?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D20'] ?>', <?=$PULSEDAY20?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D21'] ?>', <?=$PULSEDAY21?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D22'] ?>', <?=$PULSEDAY22?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D23'] ?>', <?=$PULSEDAY23?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D24'] ?>', <?=$PULSEDAY24?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D25'] ?>', <?=$PULSEDAY25?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D26'] ?>', <?=$PULSEDAY26?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D27'] ?>', <?=$PULSEDAY27?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D28'] ?>', <?=$PULSEDAY28?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D29'] ?>', <?=$PULSEDAY29?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D30'] ?>', <?=$PULSEDAY30?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D31'] ?>', <?=$PULSEDAY31?>, <?=$result_seTenkoSTD['MAXPULSE']?>,<?=$PULSEAVG?>  ]
                                                                ]);

                                                                var view = new google.visualization.DataView(data);
                                                                view.setColumns([0, 1,
                                                                        { calc: "stringify",
                                                                            sourceColumn: 1,
                                                                            type: "string",
                                                                            role: "annotation" },
                                                                        2,

                                                                        3,

                                                                        ]);



                                                                var options = {
                                                                    title: '',
                                                                    curveType: '',
                                                                    legend: {position: 'right'},
                                                                    series: {
                                                                                0: { lineWidth: 5,pointShape:'circle',pointSize: 10, },
                                                                                1: { lineWidth: 10,color: '#030100'      },
                                                                                2: { lineWidth: 5,lineDashStyle: [2, 2, 20, 2, 20, 2]  }
                                                                            },
                                                                    lineWidth: 5,
                                                                    tooltip: {

                                                                            } ,
                                                                    colors: ['#3498DB', '#239B56','#00FFEE']


                                                                };


                                                                var chart = new google.visualization.LineChart(document.getElementById('curve_chartheartrate'));
                                                                chart.draw(view, options);

                                                            }
                                        </script>

                                        <div id="curve_chartheartrate" style="width: 100%; height: 500px"></div>


                                    </div>
                                    <!-- /.col-lg-8 (nested) -->
                                </div>

                                <!-- END ROW HEARTRATE -->

                                <!-- START ROW OXYGEN -->
                                <div class="row">
                                    <div class="col-lg-12" style="text-align:center;">
                                        <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>
                                        กราฟข้อมูลค่าออกซิเจนในเลือดของพนักงาน
                                        </h2>
                                    </div>
                                    <div class="col-lg-12" style="text-align:center;">
                                        <h2 class=""><i class=""></i>
                                        <b>Avg.ออกซิเจน</b>&nbsp;&nbsp;  <input type="text"   style ="text-align:center" id="txt_oxygen" value="" disabled="true">
                                        </h2>
                                    </div>
                                    <div class="col-lg-12">
                                        <?php

                                        //Tag For query

                                        ?>
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                        <!-- <script type="text/javascript" src="js/jquery.min.js"></script>
                                        <script type="text/javascript" src="js/Chart.min.js"></script> -->
                                        <script type="text/javascript">

                                                            document.getElementById("txt_oxygen").value = <?=number_format($OXYGENAVG,2)?>;

                                                            google.charts.load('current', {'packages': ['corechart']});
                                                            google.charts.setOnLoadCallback(drawChart);

                                                            function drawChart() {

                                                                var data = google.visualization.arrayToDataTable([
                                                                    ['Day', 'ค่าออกซิเจนในเลือด', 'ค่ามาตรฐาน(<?=$result_seTenkoSTD['OXYGEN']?>)','Avg.ออกซิเจน'],
                                                                    ['<?= $result_seAdddateweek['D1'] ?>', <?=$result_seDay1['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D2'] ?>', <?=$result_seDay2['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D3'] ?>', <?=$result_seDay3['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D4'] ?>', <?=$result_seDay4['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D5'] ?>', <?=$result_seDay5['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D6'] ?>', <?=$result_seDay6['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D7'] ?>', <?=$result_seDay7['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D8'] ?>', <?=$result_seDay8['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D9'] ?>', <?=$result_seDay9['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D10'] ?>', <?=$result_seDay10['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D11'] ?>', <?=$result_seDay11['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D12'] ?>', <?=$result_seDay12['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D13'] ?>', <?=$result_seDay13['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D14'] ?>', <?=$result_seDay14['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D15'] ?>', <?=$result_seDay15['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D16'] ?>', <?=$result_seDay16['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D17'] ?>', <?=$result_seDay17['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D18'] ?>', <?=$result_seDay18['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D19'] ?>', <?=$result_seDay19['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D20'] ?>', <?=$result_seDay20['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D21'] ?>', <?=$result_seDay21['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D22'] ?>', <?=$result_seDay22['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D23'] ?>', <?=$result_seDay23['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D24'] ?>', <?=$result_seDay24['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D25'] ?>', <?=$result_seDay25['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D26'] ?>', <?=$result_seDay26['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D27'] ?>', <?=$result_seDay27['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D28'] ?>', <?=$result_seDay28['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D29'] ?>', <?=$result_seDay29['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D30'] ?>', <?=$result_seDay30['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ],
                                                                    ['<?= $result_seAdddateweek['D31'] ?>', <?=$result_seDay31['TENKOOXYGENDATA']?>, <?=$result_seTenkoSTD['OXYGEN']?>, <?=$OXYGENAVG?>  ]
                                                                ]);

                                                                var view = new google.visualization.DataView(data);
                                                                view.setColumns([0, 1,
                                                                        { calc: "stringify",
                                                                            sourceColumn: 1,
                                                                            type: "string",
                                                                            role: "annotation" },
                                                                        2,

                                                                        3,
                                                                        ]);



                                                                var options = {
                                                                    title: '',
                                                                    curveType: '',
                                                                    legend: {position: 'right'},
                                                                    series: {
                                                                                0: { lineWidth: 5,pointShape:'circle',pointSize: 10, },
                                                                                1: { lineWidth: 8,color: '#030100'      },
                                                                                2: { lineWidth: 4,lineDashStyle: [2, 2, 20, 2, 20, 2]  }

                                                                            },
                                                                    lineWidth: 5,
                                                                    tooltip: {

                                                                            } ,
                                                                    colors: ['#3498DB', '#239B56','#00FFEE']


                                                                };


                                                                var chart = new google.visualization.LineChart(document.getElementById('curve_chartoxygen'));
                                                                chart.draw(view, options);

                                                            }
                                        </script>

                                    <div id="curve_chartoxygen" style="width: 100%; height: 500px"></div>


                                    </div>
                                    <!-- /.col-lg-8 (nested) -->
                                    </div>
                                <!-- END ROW OXYGEN -->

                            </div>
                            <!-- /.panel-body -->
                        </div>

                    </div>
                </div>
                <!-- END ROW1 -->







            </div>
        </div>

        <!-- Bootstrap Core JavaScript -->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <!-- Morris Charts JavaScript -->
        <!-- <script src="../vendor/raphael/raphael.min.js"></script>
        <script src="../vendor/morrisjs/morris.js"></script>                                                     -->
         <!-- Chart.js JavaScript -->
         <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
        <!-- Custom Theme JavaScript -->
        <!-- <script src="../dist/js/sb-admin-2.js"></script> -->
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>




        <script src="../dist/js/bootstrap-select.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>


        <script>
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true,
                });
            });


            function check_graph()
            {
                var months = document.getElementById('txt_firstdate').value;
                var employeecode = document.getElementById('txt_empcode').value;

                // alert(months);
                // alert(employeecode);
                window.open('meg_driverdatagraph_checkprint_gw.php?months=' + months + '&employeecode=' + employeecode, '_blank');

            }


            function select_graph()
            {
                var monthchk        = document.getElementById('select_month').value;
                var yearchk         = document.getElementById('txt_yearsearchstart').value;
                var employeecode    = document.getElementById('txt_empcode').value;

                var months = monthchk.concat(yearchk);

                // alert(months);
                // alert(employeecode);
                if (monthchk == '') {
                    alert('ยังไม่ได้เลือกเดือน ในการค้นหา');
                }else if(yearchk == ''){
                    alert('ยังไม่ได้เลือกปี ในการค้นหา');
                }else{
                    window.open('meg_driverdatagraph_check_gw.php?months=' + months + '&employeecode=' + employeecode, '_blank');
                }


            }


    </script>

    </body>


</html>
