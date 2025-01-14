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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
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

            .swal2-popup {
                font-size: 16px !important;
                padding: 17px;
                border: 1px solid #F0E1A1;
                display: block;
                margin: 22px;
                text-align: center;
                color: #61534e;
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
                    <!-- /.col-lg-12 -->
                    
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
                                    <!-- <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                  ตารางรวมข้อมูลสุขภาพ <b>(ข้อมูลจากระบบตรวจร่างกาย)</b>
                                                </div>
                                                <div class="panel-body">
                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ลำดับที่</th>
                                                                        <th>เลขที่งาน</th>
                                                                        <th>วันที่</th>
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
                                                                // FROM  TENKOBEFORE b
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
                                                                        if($result_seSelfCheckData['TENKOPRESSUREDATA_90160'] > '150'){
                                                                            if ($result_seSelfCheckData['TENKOPRESSUREDATA_90160_2'] > '150' ) {
                                                                                if ($result_seSelfCheckData['TENKOPRESSUREDATA_90160_3'] > '150') {
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
                                                                        if($result_seSelfCheckData['TENKOPRESSUREDATA_60100'] > '95'){
                                                                            if ($result_seSelfCheckData['TENKOPRESSUREDATA_60100_2'] > '95' ) {
                                                                                if ($result_seSelfCheckData['TENKOPRESSUREDATA_60100_3'] > '95') {
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
                                                                        if($result_seSelfCheckData['TENKOPRESSUREDATA_60110'] > '100' || $result_seSelfCheckData['TENKOPRESSUREDATA_60110'] < '60'){
                                                                            if ($result_seSelfCheckData['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seSelfCheckData['TENKOPRESSUREDATA_60110_2'] < '60' ) {
                                                                                if ($result_seSelfCheckData['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seSelfCheckData['TENKOPRESSUREDATA_60110_3'] < '60') {
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


                                                   
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div> -->

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
                                         กราฟข้อมูลการใช้งานโทรศัพท์ของพนักงาน
                                        </h2>
                                    </div>      
                                    <!-- <div class="col-lg-12" style="text-align:center;">
                                        <h2 class=""><i class=""></i>  
                                        <b>Avg.บน</b>&nbsp;&nbsp;  <input type="text"   style ="text-align:center" id="txt_avgsys" value="" disabled="true">
                                        <b>Avg.ล่าง</b>&nbsp;&nbsp; <input type="text"   style ="text-align:center" id="txt_avgdia" value="" disabled="true">
                                        </h2>
                                    </div>  -->
                                    
                                    <div class="col-lg-12">

                                        
                                        <?php
                                        
                                        $sql_seStartDate = "SELECT CONVERT(VARCHAR(25),DATEADD(dd,-(DAY(GETDATE())-1),GETDATE()),105) AS 'STARTDATE'";
                                        $params_seStartDate = array();
                                        $query_seStartDate = sqlsrv_query($conn, $sql_seStartDate, $params_seStartDate);
                                        $result_seStartDate = sqlsrv_fetch_array($query_seStartDate, SQLSRV_FETCH_ASSOC);
                                            
                                        $sql_seEndDate = "SELECT CONVERT(VARCHAR(25),DATEADD(dd,-(DAY(DATEADD(mm,1,GETDATE()))),DATEADD(mm,1,GETDATE())),105) AS 'ENDDATE'";
                                        $params_seEndDate = array();
                                        $query_seEndDate = sqlsrv_query($conn, $sql_seEndDate, $params_seEndDate);
                                        $result_seEndDate = sqlsrv_fetch_array($query_seEndDate, SQLSRV_FETCH_ASSOC);

                                        // echo $result_seStartDate['STARTDATE'];
                                        // echo "<br>";
                                        // echo $result_seEndDate['ENDDATE'];

                                        // ค้นหาวันแรกของเดือนปัจจุบัน
                                        // $sql_seDatestart = "SELECT FORMAT (DATEADD(MONTH, DATEDIFF(MONTH, 0, GETDATE()), 0), 'dd/MM/yyyy') AS 'DS'";
                                        // $params_seDatestart = array();
                                        // $query_seDatestart = sqlsrv_query($conn, $sql_seDatestart, $params_seDatestart);
                                        // $result_seDatestart = sqlsrv_fetch_array($query_seDatestart, SQLSRV_FETCH_ASSOC);

                                        // $sql_seAdddateweek = "{call megGetdate_v2(?,?)}";
                                        // $params_seAdddateweek = array(
                                        //     array('select_dategraph', SQLSRV_PARAM_IN),
                                        //     array($result_seDatestart['DS'], SQLSRV_PARAM_IN)
                                        // );
                                        // $query_seAdddateweek = sqlsrv_query($conn, $sql_seAdddateweek, $params_seAdddateweek);
                                        // $result_seAdddateweek = sqlsrv_fetch_array($query_seAdddateweek, SQLSRV_FETCH_ASSOC);
                                        //echo $result_seAdddateweek['D1'] . '|' . $result_seAdddateweek['D2'] . '|' . $result_seAdddateweek['D3'] . '|' . $result_seAdddateweek['D4'] . '|' . $result_seAdddateweek['D5'] . '|' . $result_seAdddateweek['D6'] . '|' . $result_seAdddateweek['D7'];
                                        
                                        /////////////////QUERY ค้นหาข้อมูล///////////////////////////////////////////////////
                                        //COUNT RANK A
                                        $sql_seCountA = "SELECT COUNT(b.TELCHECKID) AS 'COUNT_A'
                                            FROM VEHICLETRANSPORTPLAN a 
                                            INNER JOIN DRIVERTELCHECK b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                                            WHERE b.EMPLOYEECODE ='".$_GET['employeecode']."'
                                            AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$result_seStartDate['STARTDATE']."',103) AND CONVERT(DATE,'".$result_seEndDate['ENDDATE']."',103)
                                            AND b.RANKDRIVER ='A'";
                                        $params_seCountA = array();
                                        $query_seCountA  = sqlsrv_query($conn, $sql_seCountA, $params_seCountA);
                                        $result_seCountA = sqlsrv_fetch_array($query_seCountA, SQLSRV_FETCH_ASSOC);
                                        
                                        $COUNTA = $result_seCountA['COUNT_A'];
                                        // echo $COUNTA;

                                        //////////////////////////////////////////////////////////////////////
                                       //COUNT RANK B
                                       $sql_seCountB = "SELECT COUNT(b.TELCHECKID) AS 'COUNT_B'
                                        FROM VEHICLETRANSPORTPLAN a 
                                        INNER JOIN DRIVERTELCHECK b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                                        WHERE b.EMPLOYEECODE ='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$result_seStartDate['STARTDATE']."',103) AND CONVERT(DATE,'".$result_seEndDate['ENDDATE']."',103)
                                        AND b.RANKDRIVER ='B'";
                                       $params_seCountB = array();
                                       $query_seCountB  = sqlsrv_query($conn, $sql_seCountB, $params_seCountB);
                                       $result_seCountB = sqlsrv_fetch_array($query_seCountB, SQLSRV_FETCH_ASSOC);
                                       
                                       $COUNTB = $result_seCountB['COUNT_B'];
                                    //    echo $COUNTB;
                                        //////////////////////////////////////////////////////////////////////

                                        //COUNT RANK C
                                       $sql_seCountC = "SELECT COUNT(b.TELCHECKID) AS 'COUNT_C'
                                       FROM VEHICLETRANSPORTPLAN a 
                                       INNER JOIN DRIVERTELCHECK b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                                       WHERE b.EMPLOYEECODE ='".$_GET['employeecode']."'
                                       AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$result_seStartDate['STARTDATE']."',103) AND CONVERT(DATE,'".$result_seEndDate['ENDDATE']."',103)
                                       AND b.RANKDRIVER ='C'";
                                      $params_seCountC = array();
                                      $query_seCountC  = sqlsrv_query($conn, $sql_seCountC, $params_seCountC);
                                      $result_seCountC = sqlsrv_fetch_array($query_seCountC, SQLSRV_FETCH_ASSOC);

                                      $COUNTC = $result_seCountC['COUNT_C'];
                                    //   echo $COUNTC;
                                       //////////////////////////////////////////////////////////////////////

                                       //COUNT RANK D
                                       $sql_seCountD = "SELECT COUNT(b.TELCHECKID) AS 'COUNT_D'
                                        FROM VEHICLETRANSPORTPLAN a 
                                        INNER JOIN DRIVERTELCHECK b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                                        WHERE b.EMPLOYEECODE ='".$_GET['employeecode']."'
                                        AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$result_seStartDate['STARTDATE']."',103) AND CONVERT(DATE,'".$result_seEndDate['ENDDATE']."',103)
                                        AND b.RANKDRIVER ='D'";
                                       $params_seCountD = array();
                                       $query_seCountD  = sqlsrv_query($conn, $sql_seCountD, $params_seCountD);
                                       $result_seCountD = sqlsrv_fetch_array($query_seCountD, SQLSRV_FETCH_ASSOC);
                                       
                                       $COUNTD = $result_seCountD['COUNT_D'];
                                    //    echo $COUNTD;
                                        //////////////////////////////////////////////////////////////////////
                        
                                        ?>
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                        <!-- <script type="text/javascript" src="js/jquery.min.js"></script>
                                        <script type="text/javascript" src="js/Chart.min.js"></script> -->
                                        <script type="text/javascript">

                                                                // document.getElementById("txt_avgsys").value = <?=number_format($SYSAVG,2)?>;
                                                                // document.getElementById("txt_avgdia").value = <?=number_format($DIAAVG,2)?>;
                                                                
                                                                google.charts.load("current", {packages:['corechart']});
                                                                google.charts.setOnLoadCallback(drawChart);
                                                                
                                                                function drawChart() {
                                                                    var data = google.visualization.arrayToDataTable([
                                                                        ["Rank", "Count", { role: "style" } ],
                                                                        ["Rank A", <?=$COUNTA?>,  "#ff3434"],
                                                                        ["Rank B", <?=$COUNTB?>, "#ffad33"],
                                                                        ["Rank C", <?=$COUNTC?>, "#ffff66"],
                                                                        ["Rank D", <?=$COUNTD?>, "#5cd65c"]
                                                                    ]);

                                                                    var view = new google.visualization.DataView(data);
                                                                    view.setColumns([0, 1,
                                                                                    { calc: "stringify",
                                                                                        sourceColumn: 1,
                                                                                        type: "string",
                                                                                        role: "annotation" },
                                                                                    2]);

                                                                    var options = {
                                                                        title: "Employee Cell Phone Use (Rank).",
                                                                        // width: 1500,
                                                                        // height: 600,
                                                                        // bar: {groupWidth: "100%"},
                                                                        legend: { position: "none" },
                                                                    };

                                                                    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                                                                    chart.draw(view, options);
                                                            } 
                                    
                                                                
                                                            
                                        </script>
   
                                    <div id="columnchart_values" style="width: 100%; height: 550px"></div>


                                    </div>
                                    <!-- /.col-lg-8 (nested) -->
                                </div>
                                <!--END ROW ความดันบน ความดันล่าง  -->
                                

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
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>


        <script src="../dist/js/bootstrap-select.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
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
                window.open('meg_driverdatagraphtel_checkprint_gw.php?months=' + months + '&employeecode=' + employeecode, '_blank');

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
                    // alert('ยังไม่ได้เลือกเดือน ในการค้นหา');
                    swal.fire({
                        title: "warning",
                        text: "ยังไม่ได้เลือก ''เดือน'' ในการค้นหา",
                        icon: "warning",
                    });
                }else if(yearchk == ''){
                    // alert('ยังไม่ได้เลือกปี ในการค้นหา');
                    swal.fire({
                        title: "warning",
                        text: "ยังไม่ได้เลือก ''ปี'' ในการค้นหา",
                        icon: "warning",
                    });
                }else{
                    window.open('meg_driverdatagraphtel_check_gw.php?months=' + months + '&employeecode=' + employeecode, '_blank');
                }

                
                
               

            }
            
           
    </script>

    </body>


</html>
