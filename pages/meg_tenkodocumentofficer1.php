<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

// $condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
// $sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
// $params_seEmployee = array(
//     array('select_employeeehr2', SQLSRV_PARAM_IN),
//     array($condition1, SQLSRV_PARAM_IN)
// );
// $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
// $result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);


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
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
        <style>
            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {
                border-left: 1px solid #ffcb0b;
            }
            .chat-panel .panel-body {
                height: 100%;
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
        </head>
        <body>
            <input type="text" id="txt_tenkobeforeid" name="txt_tenkobeforeid" style="display: none">

                <div id="wrapper">
                    <!-- Navigation -->
                    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                        <?php
                        include '../pages/meg_header.php';
                        include '../pages/meg_leftmenu.php';
                        ?>
                    </nav>

                    <div id="page-wrapper">








                        <div class="row" >
                            <div class="col-lg-12">

                                <h5 class="page-header">

                                    เอกสารเท็งโกะ


                                </h5>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <?php
                        // $sql_seChkemployee = "SELECT b.FnameT AS 'FnameTP',b.LnameT AS 'LnameTP',b.PersonCode AS 'PersonCodeP',b.PersonCode,
                        //     (b.FnameT +' '+b.LnameT) AS 'nameTP',c.Company_Code,d.PositionGroup FROM dbo.TIMEINOUT a
                        //     RIGHT JOIN dbo.EMPLOYEEEHR b ON a.PersonCode = b.PersonCode
                        //     INNER JOIN dbo.COMPANYEHR c on b.CompanyID = c.ID_Company
                        //     INNER JOIN dbo.POSITIONEHR d ON b.PositionID = d.PositionID
                        //     AND 1=1  WHERE b.PersonCode = '" . $_GET['employeecode1'] . "'";

                        // $query_seChkemployee = sqlsrv_query($conn, $sql_seChkemployee, $params_seChkemployee);
                        // $result_seChkemployee = sqlsrv_fetch_array($query_seChkemployee, SQLSRV_FETCH_ASSOC);


                        $conditionTenkomasterofficer = " AND a.TENKOMASTERDIRVERCODE1 = '" . $_GET['employeecode1'] . "' AND  CONVERT(DATE,CREATEDATE) = CONVERT(DATE,GETDATE())";
                        $sql_seTenkomasterofficer = "{call megEdittenkomaster_v2(?,?)}";
                        $params_seTenkomasterofficer = array(
                            array('select_tenkomaster', SQLSRV_PARAM_IN),
                            array($conditionTenkomasterofficer, SQLSRV_PARAM_IN)
                        );
                        $query_seTenkomasterofficer = sqlsrv_query($conn, $sql_seTenkomasterofficer, $params_seTenkomasterofficer);
                        $result_seTenkomasterofficer = sqlsrv_fetch_array($query_seTenkomasterofficer, SQLSRV_FETCH_ASSOC);
                 

                        $conditionTenkobeforeofficer = " AND a.TENKOMASTERID = '" . $result_seTenkomasterofficer['TENKOMASTERID'] . "'";
                        $sql_seTenkobeforeofficer = "{call megEdittenkobefore_v2(?,?,?)}";
                        $params_seTenkobeforeofficer = array(
                            array('select_tenkobefore', SQLSRV_PARAM_IN),
                            array($conditionTenkobeforeofficer, SQLSRV_PARAM_IN),
                            array('', SQLSRV_PARAM_IN)
                        );
                        $query_seTenkobeforeofficer = sqlsrv_query($conn, $sql_seTenkobeforeofficer, $params_seTenkobeforeofficer);
                        $result_seTenkobeforeofficer = sqlsrv_fetch_array($query_seTenkobeforeofficer, SQLSRV_FETCH_ASSOC);

                       

                        $conditionDir1officer = "  AND a.PersonCode = '" . $_GET['employeecode1'] . "'";
                        $sql_seDir1officer = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seDir1officer = array(
                            array('select_employeeehr2', SQLSRV_PARAM_IN),
                            array($conditionDir1officer, SQLSRV_PARAM_IN)
                        );
                        $query_seDir1officer = sqlsrv_query($conn, $sql_seDir1officer, $params_seDir1officer);
                        $result_seDir1officer = sqlsrv_fetch_array($query_seDir1officer, SQLSRV_FETCH_ASSOC);

                        // echo $result_seDir1officer['TaxID'];
                        // ข้อมูลจาก LABOTRON ที่จะ Auto Insert data
                        // Auto Officer
                        $sql_seLabotronData = "SELECT TOP 1 CARDNUMBER,CAST(DRIVER_TEMPERATURE AS DECIMAL(15, 2)) AS 'TEMP',DRIVER_SYS AS 'SYS',DRIVER_DIA AS 'DIA',
                        DRIVER_PULSE AS 'PULSE',DRIVER_OXYGEN AS 'OXYGEN',
                        CASE
                            WHEN DRIVER_ALCOHOL = '0.0' THEN '0'
                            ELSE DRIVER_ALCOHOL
                        END AS 'ALCOHOL'  
                        FROM LABOTRONWEBSERVICEDATA 
                        WHERE CARDNUMBER='".$result_seDir1officer['TaxID']."'
                        AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,GETDATE())
                        ORDER BY CREATEDATE DESC";
                        $query_seLabotronData = sqlsrv_query($conn, $sql_seLabotronData, $params_seLabotronData);
                        $result_seLabotronData = sqlsrv_fetch_array($query_seLabotronData, SQLSRV_FETCH_ASSOC);
                        
                        // echo $result_seCarData1['TaxID'];
                        // echo "<br>";
                        // echo $result_seLabotronData1['TEMP'];
                        // echo "<br>";
                        // echo $result_seTenkobeforeofficer['TENKOTEMPERATUREDATA'];
                       
                        // check box TEMP
                        if ($result_seTenkobeforeofficer['TENKOTEMPERATUREDATA'] == '') {
                            $TEMP_OFFICER = $result_seLabotronData['TEMP'];
                            // echo $TEMP1;
                                
                        }else {
                            $TEMP_OFFICER = $result_seTenkobeforeofficer['TENKOTEMPERATUREDATA'];
                            // echo $TEMP1;
                            
                        }

                        // check box SYS
                        if ($result_seTenkobeforeofficer['TENKOPRESSUREDATA_90160'] == '') {
                            $SYS_OFFICER = $result_seLabotronData['SYS']; 
                        }else {
                            $SYS_OFFICER = $result_seTenkobeforeofficer['TENKOPRESSUREDATA_90160'];
                        }
                        
                        // check box DIA
                        if ($result_seTenkobeforeofficer['TENKOPRESSUREDATA_60100'] == '') {
                            $DIA_OFFICER = $result_seLabotronData['DIA']; 
                        }else {
                            $DIA_OFFICER = $result_seTenkobeforeofficer['TENKOPRESSUREDATA_60100'];
                        }

                        // check box Pulse
                        if ($result_seTenkobeforeofficer['TENKOPRESSUREDATA_60110'] == '') {
                            $PULSE_OFFICER = $result_seLabotronData['PULSE']; 
                        }else {
                            $PULSE_OFFICER = $result_seTenkobeforeofficer['TENKOPRESSUREDATA_60110'];
                        }
                        
                        // check box Oxygen
                        if ($result_seTenkobeforeofficer['TENKOOXYGENDATA'] == '') {
                            $OXYGEN_OFFICER = $result_seLabotronData['OXYGEN']; 
                        }else {
                            $OXYGEN_OFFICER = $result_seTenkobeforeofficer['TENKOOXYGENDATA'];
                        }
                        
                        // check box Alcohol
                        if ($result_seTenkobeforeofficer['TENKOALCOHOLDATA'] == '') {
                            $ALCOHOL_OFFICER = $result_seLabotronData['ALCOHOL']; 
                        }else {
                            $ALCOHOL_OFFICER = $result_seTenkobeforeofficer['TENKOALCOHOLDATA'];
                        }

                        // CheckBox เงื่อนไขข้อมูลตรวจร่างกาย
                        // edit_tenkobeforetxt4 = เช็คอุณภูมิ
                        // edit_tenkobeforetxt5 = เช็คความดันบน
                        // edit_tenkobeforetxt6 = เช็คความดันล่าง
                        // edit_tenkobeforetxt20 = อัตราการเต้นของหัวใจ
                        // edit_tenkobeforetxt8 = ออกซิเจนในเลือด
                        echo "<script type='text/javascript'> 
                                window.onload = function() {
                                    edit_tenkobeforetxtofficer1();
                                    edit_tenkobeforetxtofficer2();
                                    edit_tenkobeforetxtofficer4();
                                    edit_tenkobeforetxtofficer5();
                                }; 
                            </script>";

                        
                       
                        $checkofficer11 = ($result_seTenkobeforeofficer['TENKOTEMPERATURECHECK'] == '1') ? "checked" : "";
                        $checkofficer12 = ($result_seTenkobeforeofficer['TENKOPRESSURECHECK'] == '1') ? "checked" : "";
                        $checkofficer13 = ($result_seTenkobeforeofficer['TENKOALCOHOLCHECK'] == '1') ? "checked" : "";
                        $checkofficer14 = ($result_seTenkobeforeofficer['TENKOOXYGENCHECK'] == '1') ? "checked" : "";


                        $rsofficer111 = ($result_seTenkobeforeofficer['TENKOTEMPERATURERESULT'] == '1') ? "checked" : "";
                        $rsofficer121 = ($result_seTenkobeforeofficer['TENKOPRESSURERESULT'] == '1') ? "checked" : "";
                        $rsofficer131 = ($result_seTenkobeforeofficer['TENKOALCOHOLRESULT'] == '1') ? "checked" : "";
                        $rsofficer141 = ($result_seTenkobeforeofficer['TENKOOXYGENRESULT'] == '1') ? "checked" : "";

                        $rsofficer110 = ($result_seTenkobeforeofficer['TENKOTEMPERATURERESULT'] == '0') ? "checked" : "";
                        $rsofficer120 = ($result_seTenkobeforeofficer['TENKOPRESSURERESULT'] == '0') ? "checked" : "";
                        $rsofficer130 = ($result_seTenkobeforeofficer['TENKOALCOHOLRESULT'] == '0') ? "checked" : "";
                        $rsofficer140 = ($result_seTenkobeforeofficer['TENKOOXYGENRESULT'] == '0') ? "checked" : "";


                       
                        $sql_seOfficecheck1 = "{call megEdittenkobefore_v2(?,?,?)}";
                        $params_seOfficecheck1 = array(
                            array('select_beforecheckofficer', SQLSRV_PARAM_IN),
                            array($result_seTenkomasterofficer['TENKOMASTERID'], SQLSRV_PARAM_IN),
                            array($result_seTenkomasterofficer['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
                        );
                        $query_seOfficecheck1 = sqlsrv_query($conn, $sql_seOfficecheck1, $params_seOfficecheck1);
                        $result_seOfficecheck1 = sqlsrv_fetch_array($query_seOfficecheck1, SQLSRV_FETCH_ASSOC);

                        $sql_seOfficeresult1 = "{call megEdittenkobefore_v2(?,?,?)}";
                        $params_seOfficeresult1 = array(
                            array('select_beforeresultofficer', SQLSRV_PARAM_IN),
                            array($result_seTenkomasterofficer['TENKOMASTERID'], SQLSRV_PARAM_IN),
                            array($result_seTenkomasterofficer['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
                        );
                        $query_seOfficeresult1 = sqlsrv_query($conn, $sql_seOfficeresult1, $params_seOfficeresult1);
                        $result_seOfficeresult1 = sqlsrv_fetch_array($query_seOfficeresult1, SQLSRV_FETCH_ASSOC);


                        // echo $result_seOfficecheck1['TENKOBEFORECHECK'];
                        // echo "<br>";
                        // echo $result_seOfficeresult1['TENKOBEFORERESULT'];
                    

                        ?>
                        <div class="row" >
                            <div class="col-lg-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <b>ค้นหาข้อมูลการตรวจร่างกาย</b>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row" >
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>ค้นหาตามช่วงวันที่</label>
                                                    <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>&nbsp;</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">
                                                </div>
                                              </div>
                                              <div class="col-lg-2">
                                                <label>พิมพ์รายงาน</label>
                                                <div class="form-group">
                                                    <a href="#" style = "width: 100px;height:40px;font-size: 25px;" onclick="pdf_tenkoofficer();" class="btn btn-primary">PDF <li class="fa fa-file-pdf-o"></li></a>
                                                </div>
                                              </div>
                                        </div>
                                        <!-- END ROW -->
                                        <input type="hidden" id ="txt_empcode" name ="txt_empcode" value = "<?=$_GET['employeecode1']?>"></input>
                                        <br>
                                        <br>
                                        <br>
                                        <br>    
                                    </div>
                                </div>
                            
                            </div> 
                            <!-- END COLUNM1 -->
                            <div class="col-lg-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <!-- <b><?= $result_seDir1officer["nameT"] ?></b> -->
                                        <b>สถานะการตรวจร่างกาย</b>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" style="text-align: center;"><input style ="width: 100%;height:40px;font-size: 25px;" type="button" onclick="commit('<?=$result_seTenkomasterofficer['TENKOMASTERID']?>',<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>,'<?=$_GET['employeecode1']?>')" class="btn btn-success" value="บันทึกข้อมูล"></th>

                                                        </tr>
                                                        <tr>
                                                            <th style="text-align: center;width: 50%">ตรวจสอบ</th>
                                                            <th style="text-align: center;width: 50%">ผลตรวจ</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            

                                                            <td style="text-align: center">
                                                                <?php
                                                                if ($result_seOfficecheck1['TENKOBEFORECHECK'] == "1") {
                                                                    ?>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_officecheckok" style="color: green"></span>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_officecheckno" style="display: none;color: red"></span>
                                                                    <?php
                                                                } else {
                                                                    ?>

                                                                    <span class="glyphicon glyphicon-remove" id="icon_officecheckno" style="color: red"></span>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_officecheckok" style="display: none;color: green"></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="text-align: center">
                                                                <?php
                                                                if ($result_seOfficeresult1['TENKOBEFORERESULT'] == "1") {
                                                                    ?>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_officeresultok" style="color: green"></span>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_officeresultno" style="display: none;color: red"></span>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_officeresultno" style="color: red"></span>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_officeresultok" style="display: none;color: green"></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>



                                </div>
                                <!-- /.col-lg-4 -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel-heading">
                                        <b>ข้อมูลตรวจร่างกายจากระบบ Labotron 7 วันย้อนหลัง</b>
                                </div>
                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example_tenko" role="grid" aria-describedby="dataTables-example_info" >
                                    <thead>
                                        <tr>
                                            <th style="background-color: #bfbfbf">ลำดับ</th>
                                            <th style="background-color: #bfbfbf">วันที่/เวลา</th>
                                            <th style="background-color: #bfbfbf">ค่าบน</th>
                                            <th style="background-color: #bfbfbf">ค่าล่าง</th>
                                            <th style="background-color: #bfbfbf">หัวใจ</th>
                                            <th style="background-color: #bfbfbf">อุณหภูมิ</th>
                                            <th style="background-color: #bfbfbf">ออกซิเจน</th>
                                            <th style="background-color: #bfbfbf">แอลกอฮอล์</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
                                    // $condiReporttransport2 = "";
                                    // $condiReporttransport3 = "";

                                    $i = 1;

                                    // check Area หาค่ามาตรฐานข้อมูลตรวจร่างกาย
                                    $checkArea = substr($_GET['employeecode1'],0,2);

                                    if ($checkArea == '01' || $checkArea == '02' || $checkArea == '07'|| $checkArea == '08'|| $checkArea == '10') {
                                        $areashow = '(AMT)';
                                        $sql_seTenkoSTD = "SELECT STD_ID,MAXSYS,MINSYS,MAXDIA,MINDIA,MAXPULSE,MINPULSE,TEMP,OXYGEN,ALCOHOL,REMARK
                                        FROM STANDARDTENKODATA
                                        WHERE REMARK ='AMT'";
                                    }else{
                                        $areashow = '(GW)';
                                        $sql_seTenkoSTD = "SELECT STD_ID,MAXSYS,MINSYS,MAXDIA,MINDIA,MAXPULSE,MINPULSE,TEMP,OXYGEN,ALCOHOL,REMARK
                                        FROM STANDARDTENKODATA
                                        WHERE REMARK ='GW'";
                                    }
                                    
                                    $query_seTenkoSTD = sqlsrv_query($conn, $sql_seTenkoSTD, $params_seTenkoSTD);
                                    $result_seTenkoSTD = sqlsrv_fetch_array($query_seTenkoSTD, SQLSRV_FETCH_ASSOC);
                                    
                                    $sql_seDriverData1 = "SELECT a.PersonID,a.nameT,a.CarLicenceID,a.PositionNameT,a.yearw,a.monthw,a.dayw,a.TaxID,
                                        FORMAT (b.ExpireCar_Start, 'dd/MM/yyyy') 'STARTDATE',
                                        FORMAT (b.ExpireCar_End, 'dd/MM/yyyy') AS 'ENDDATE' ,
                                        DATEDIFF(month, FORMAT (b.ExpireCar_End, 'yyyy/MM/dd '), FORMAT (GETDATE(), 'yyyy/MM/dd ')) AS 'MONTHDIFF'
                                        FROM [dbo].[EMPLOYEEEHR2] a
                                        INNER JOIN [dbo].[EMPLOYEEDETAILEHR] b ON a.PersonID = b.PersonID
                                        WHERE PersonCode ='".$_GET['employeecode1']."'";
                                    $query_seDriverData1 = sqlsrv_query($conn, $sql_seDriverData1, $params_seDriverData1);
                                    $result_seDriverData1 = sqlsrv_fetch_array($query_seDriverData1, SQLSRV_FETCH_ASSOC);

                                    $sql_seData = "SELECT b.nameT,b.TaxID,b.PersonCode,CARDNUMBER,DRIVER_WEIGHT,DRIVER_HEIGHT,DRIVER_BMI,
                                    CONVERT( NUMERIC(10,2), DRIVER_TEMPERATURE) AS 'DRIVER_TEMPERATURE',
                                    DRIVER_SYS,DRIVER_DIA,DRIVER_PULSE,DRIVER_OXYGEN,
                                    CASE
                                        WHEN DRIVER_ALCOHOL = '0.0' THEN '0'
                                        ELSE DRIVER_ALCOHOL
                                    END AS 'DRIVER_ALCOHOL',
                                    CREATEBY,CONVERT(VARCHAR(16),CREATEDATE,103) AS 'CREATEDATE'
                                                                                                
                                    FROM LABOTRONWEBSERVICEDATA a 
                                    INNER JOIN EMPLOYEEEHR2 b ON b.TaxID = a.CREATEBY
                                    WHERE CONVERT(DATE,CREATEDATE) BETWEEN CONVERT(DATE,DATEADD(DAY,-7,GETDATE())) AND CONVERT(DATE,GETDATE())
                                    AND CARDNUMBER ='".$result_seDriverData1['TaxID']."'
                                    --WHERE CARDNUMBER IN ('5320890008815','1639900241323')
                                    ORDER BY CONVERT(VARCHAR(16),CREATEDATE,103) DESC";
                                    $params_seData = array();
                                    $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
                                    while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {

                                        
                                        global $pageTitleTEMP,$pageTitleSYS,$pageTitleDIA,$pageTitlePULSE,$pageTitleOXYGEN,$pageTitleALCOHOL;
                                        

                                        //อุณหภูมิ ไม่เกิน 37.5
                                        if ($result_seData['DRIVER_TEMPERATURE'] >  $result_seTenkoSTD['TEMP']  || $result_seData['DRIVER_TEMPERATURE'] == '' ) {
                                            $colortemp = "background-color: #FF6A66";
                                            $pageTitleTemp = "อุณหภูมิร่างกายสูงหรือต่ำเกินมาตรฐาน...";
                                        } else {
                                            $colortemp = "";
                                            $pageTitleTemp = "";
                                        }
                                        
                                        
                                        //ค่าความดันบน 60-150
                                        if ($result_seData['DRIVER_SYS'] < $result_seTenkoSTD['MINSYS'] || $result_seData['DRIVER_SYS'] > $result_seTenkoSTD['MAXSYS']) {
                                            $colorsys = "background-color: #FF6A66";
                                            $pageTitleSYS = "ความดันบนสูงหรือต่ำเกินมาตรฐาน...";
                                        } else {
                                            $colorsys = "";
                                            $pageTitleSYS = "";
                                        }

                                        //ค่าความดันล่าง 60-95
                                        if ($result_seData['DRIVER_DIA'] < $result_seTenkoSTD['MINDIA'] || $result_seData['DRIVER_DIA'] > $result_seTenkoSTD['MAXDIA']) {
                                            $colordia = "background-color: #FF6A66";
                                            $pageTitleDIA = "ความดันล่างสูงหรือต่ำเกินมาตรฐาน...";
                                        } else {
                                            $colordia = "";
                                            $pageTitleDIA = "";
                                        }

                                        //อัตตราการเต้นหัวใจ
                                        if ($result_seData['DRIVER_PULSE'] < $result_seTenkoSTD['MINPULSE'] || $result_seData['DRIVER_PULSE'] > $result_seTenkoSTD['MAXPULSE']) {
                                            $colorpulse = "background-color: #FF6A66";
                                            $pageTitlePULSE = "อัตราการเต้นของหัวใจสูงหรือต่ำเกินมาตรฐาน...";
                                        } else {
                                            $colorpulse = "";
                                            $pageTitlePULSE = "";
                                        }

                                        //ค่าออกซิเจนในเลือด
                                        if ($result_seData['DRIVER_OXYGEN'] < $result_seTenkoSTD['OXYGEN']) {
                                            $coloroxygen = "background-color: #FF6A66";
                                            $pageTitleOXYGEN = "ออกซิเจนใจเลือดต่ำเกินมาตรฐาน...";
                                        } else {
                                            $coloroxygen = "";
                                            $pageTitleOXYGEN = "";
                                        }

                                        //ค่าแอลกอฮอล์
                                        if ($result_seData['DRIVER_ALCOHOL'] > $result_seTenkoSTD['ALCOHOL'] || $result_seData['DRIVER_ALCOHOL'] == '') {
                                            $coloralcohol = "background-color: #FF6A66";
                                            $pageTitleALCOHOL = "แอลกอฮอล์ต้องเป็น 0 เท่านั้น...";
                                        } else {
                                            $coloralcohol = "";
                                            $pageTitleALCOHOL = "";
                                        }

                                         

                                        // echo $result_seData['DRIVER_BMI'];
                                        // echo '<br>';
                                        ?>

                                        <tr>
                                            <td style="text-align: center"><?= $i ?> </td>
                                            <td><?=$result_seData['CREATEDATE']?> </td>
                                            <td title="<?=$pageTitleSYS?>"      style="<?= $colorsys ?>"><?=$result_seData['DRIVER_SYS'];?>    </td>
                                            <td title="<?=$pageTitleDIA?>"      style="<?= $colordia ?>"><?=$result_seData['DRIVER_DIA'];?>    </td>
                                            <td title="<?=$pageTitlePULSE?>"    style="<?= $colorpulse   ?>"><?=$result_seData['DRIVER_PULSE'];?>  </td>
                                            <td title="<?=$pageTitleTemp?>"     style="<?= $colortemp ?>"><?=number_format($result_seData['DRIVER_TEMPERATURE'],2);?>    </td>
                                            <td title="<?=$pageTitleOXYGEN?>"   style="<?= $coloroxygen  ?>"><?=$result_seData['DRIVER_OXYGEN']?>  </td>
                                            <td title="<?=$pageTitleALCOHOL?>"  style="<?= $coloralcohol ?>"><?=$result_seData['DRIVER_ALCOHOL']?> </td>
                                        </tr>
                                        <?php
                                        $i++;
                                        }
                                    ?>




                                    </tbody>

                                </table> 
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">

                                        <div class="row" >

                                            <div class="col-lg-6">
                                                เท็งโกะสำหรับเจ้าหน้าที่ หมายเลขไอดี : <?=$result_seTenkomasterofficer['TENKOMASTERID']?>
                                            </div>
                                            <!-- <?php
                                            $emp = ($_GET['employeecode1'] != "") ? $_GET['employeecode1'] : $_GET['employeecode2'];
                                            if ($emp != "") {
                                                ?>
                                                <div class="col-lg-6 text-right">
                                                    <a href="pdf_reportemployeeofficer4_1.php?employeecode=<?= $emp ?>&tenkomasterid=<?= $result_seTenkomasterofficer['TENKOMASTERID'] ?>"  target ="_blank" class="btn btn-default">พิมพ์เอกสารเท็งโกะ 1 <li class="fa fa-print"></li></a>
                                                </div>
                                                <?php
                                            }
                                            ?> -->

                                        </div>

                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <!-- Nav tabs -->

                                            <h4 style="color:red"><u>ข้อมูลอัตโนมัติมาจากระบบ LABOTRON (ถ้ามีข้อมูล)</u></h4>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <p>&nbsp;</p>

                                            <div class="tab-pane fade in active" id="tenko1">
                                                <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                    <thead>
                                                        <tr>
                                                            <th  colspan="9" ><font style="color: green">พนักงาน : <?= $result_seDir1officer['nameT'] ?></font></th>
                                                            <!-- <th width="65">เจ้าหน้าที่</th>
                                                            <th width="144" ><?= $result_seEmployee["nameT"] ?></th>
                                                            <th width="40">พขร.</th>
                                                            <th width="144" ><?= $result_seEmpehr['nameT'] ?></th> -->
                                                        </tr>
                                                        <tr>
                                                            <th width="40" rowspan="2"  style="width: 40px;text-align: center">ข้อ</th>
                                                            <th width="280" rowspan="2" style="width: 200px;text-align: center">หัวข้อ</th>
                                                            <th width="92" rowspan="2" style="width: 20px;text-align: center">ช่องตรวจสอบ</th>
                                                            <th colspan="2" rowspan="2" style="width: 400px;text-align: center">เกณฑ์การตัดสิน</th>
                                                            <th colspan="2" style="width: 80px;text-align: center">ผล</th>
                                                            <th colspan="4" style="text-align: center" rowspan="2">รายเอียดและการแนะนำ</th>
                                                        </tr>
                                                        <tr>
                                                            <th width="40" style="width: 40px;text-align: center" >ปกติ</th>
                                                            <th width="49" style="width: 40px;text-align: center" >ผิดปกติ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                        <tr>
                                                            <td style="text-align: center">1</td>
                                                            <td>ตรวจเช็คอุณหภูมิ</td>
                                                            <td style="text-align: center"><input disabled="" <?= $checkofficer11 ?> type="checkbox" id="chk_officer11" name="chk_officer11"  style="transform: scale(2)"/></td>
                                                            <td>ต่ำกว่า <b><?=$result_seTenkoSTD['TEMP']?></b> องศา</td>
                                                            <!-- $result_seTenkobeforeofficer['TENKOTEMPERATUREDATA'] -->
                                                            <td><input type="text" class="form-control" id="txt_rsofficer11" name="txt_rsofficer11" value="<?= $TEMP_OFFICER ?>" onchange="edit_tenkobeforetxtofficer1(this.value, 'TENKOTEMPERATUREDATA', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')"></td>
                                                            <td style="text-align: center"><input disabled="" <?= $rsofficer111 ?> type="checkbox"  style="transform: scale(2)" id="chk_rsofficer111" name="chk_rsofficer111" /></td>
                                                            <td style="text-align: center"><input disabled="" <?= $rsofficer110 ?> type="checkbox" style="transform: scale(2)" id="chk_rsofficer110" name="chk_rsofficer110" /></td>
                                                            <td colspan="4"><input type="text" id="txt_remark1" name="txt_remark1" class="form-control" onchange="edit_tenkobeforetxtremarkofficer(this.value, 'TENKOTEMPERATUREREMARK', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')" value="<?= $result_seTenkobeforeofficer['TENKOTEMPERATUREREMARK'] ?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="3" style="text-align: center">2</td>
                                                            <td rowspan="3">วัดความดัน</td>
                                                            <!-- $result_seTenkobeforeofficer['TENKOPRESSUREDATA_90160'] -->
                                                            <td rowspan="3" style="text-align: center"><input disabled="" <?= $checkofficer12 ?> type="checkbox" id="chk_officer12" name="chk_officer12" style="transform: scale(2)"/></td>
                                                            <td>บน : <b><?=$result_seTenkoSTD['MINSYS']?>-<?=$result_seTenkoSTD['MAXSYS']?></b></td>
                                                            <td><input type="text" class="form-control" id="txt_rsofficer121" name="txt_rsofficer121" value="<?= $SYS_OFFICER ?>" onchange="edit_tenkobeforetxtofficer2(this.value, 'TENKOPRESSUREDATA_90160', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')"></td>

                                                            <td rowspan="3" style="text-align: center"><input disabled="" <?= $rsofficer121 ?> type="checkbox" style="transform: scale(2)" id="chk_rsofficer121" name="chk_rsofficer121" /></td>
                                                            <td rowspan="3" style="text-align: center"><input disabled="" <?= $rsofficer120 ?> type="checkbox" style="transform: scale(2)" id="chk_rsofficer120" name="chk_rsofficer120" /></td>
                                                            <td colspan="4"><input type="text" id="txt_remark2" name="txt_remark2" class="form-control" onchange="edit_tenkobeforetxtremarkofficer(this.value, 'TENKOPRESSUREREMARK', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')" value="<?= $result_seTenkobeforeofficer['TENKOPRESSUREREMARK'] ?>"></td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>ล่าง : <b><?=$result_seTenkoSTD['MINDIA']?>-<?=$result_seTenkoSTD['MAXDIA']?></b></td>
                                                            <!-- $result_seTenkobeforeofficer['TENKOPRESSUREDATA_60100'] -->
                                                            <td><input type="text" class="form-control" id="txt_rsofficer122" name="txt_rsofficer122" value="<?= $DIA_OFFICER ?>" onchange="edit_tenkobeforetxtofficer2(this.value, 'TENKOPRESSUREDATA_60100', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')"></td>

                                                        </tr>
                                                         <tr>
                                                            <td>อัตราการเต้นหัวใจ : <b><?=$result_seTenkoSTD['MINPULSE']?>-<?=$result_seTenkoSTD['MAXPULSE']?></td>
                                                            <!-- $result_seTenkobeforeofficer['TENKOPRESSUREDATA_60110'] -->
                                                            <td><input type="text" class="form-control" id="txt_rsofficer123" name="txt_rsofficer123" value="<?= $PULSE_OFFICER ?>" onchange="edit_tenkobeforetxtofficer2(this.value, 'TENKOPRESSUREDATA_60110', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')"></td>

                                                        </tr>
                                                        
                                                        <tr>
                                                            <td style="text-align: center">3</td>
                                                            <td>ตรวจเช็คแอลกอฮอล์</td>
                                                            <!-- $result_seTenkobeforeofficer['TENKOALCOHOLDATA'] -->
                                                            <td style="text-align: center"><input disabled="" type="checkbox" <?= $checkofficer13 ?> id="chk_officer13" name="chk_officer13"  style="transform: scale(2)"/></td>
                                                            <td>แอลกอฮอล์ <b><?=$result_seTenkoSTD['ALCOHOL']?>mg%</b> </td>
                                                            <td><input type="text" class="form-control" id="txt_rsofficer13" name="txt_rsofficer13" value="<?= $ALCOHOL_OFFICER ?>" onchange="edit_tenkobeforetxtofficer4(this.value, 'TENKOALCOHOLDATA', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')"></td>

                                                            <td style="text-align: center"><input disabled="" type="checkbox" <?= $rsofficer131 ?>  style="transform: scale(2)" id="chk_rsofficer131" name="chk_rsofficer131" /></td>
                                                            <td style="text-align: center"><input disabled="" type="checkbox" <?= $rsofficer130 ?>  style="transform: scale(2)" id="chk_rsofficer130" name="chk_rsofficer130" /></td>
                                                            <td colspan="4"><input type="text" id="txt_remark3" name="txt_remark3" class="form-control" onchange="edit_tenkobeforetxtremarkofficer(this.value, 'TENKOALCOHOLREMARK', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')" value="<?= $result_seTenkobeforeofficer['TENKOALCOHOLREMARK'] ?>"></td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: center">4</td>
                                                            <td>ตรวจเช็คออกซิเจนเลือด</td>
                                                            <td style="text-align: center"><input disabled="" <?= $checkofficer14 ?> type="checkbox" id="chk_officer14"  name="chk_officer14"  style="transform: scale(2)"/></td>
                                                            <td>มีค่าตั้งแต่ <b><?=$result_seTenkoSTD['OXYGEN']?>%</b></td>
                                                            <td><input type="text" class="form-control" id="txt_rsofficer14" name="txt_rsofficer14" value="<?= $OXYGEN_OFFICER ?>" onchange="edit_tenkobeforetxtofficer5(this.value, 'TENKOOXYGENDATA', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')"></td>

                                                            <td style="text-align: center"><input disabled="" type="checkbox" <?= $rsofficer141 ?>  style="transform: scale(2)" id="chk_rsofficer141" name="chk_rsofficer141" /></td>
                                                            <td style="text-align: center"><input disabled="" type="checkbox" <?= $rsofficer140 ?>  style="transform: scale(2)" id="chk_rsofficer140" name="chk_rsofficer140" /></td>
                                                            <td colspan="4"><input type="text" id="txt_remark4" name="txt_remark4" class="form-control" onchange="edit_tenkobeforetxtremarkofficer(this.value, 'TENKOOXYGENREMARK', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')" value="<?= $result_seTenkobeforeofficer['TENKOOXYGENREMARK'] ?>"></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>


                                        </div>
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>

                        </div>



                    </div>

                </div>
               


                <!--<script src="../vendor/jquery/jquery.min.js"></script>-->
                <script src="../vendor/jquery/jquery.min.js"></script>
                <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
                <script src="../vendor/metisMenu/metisMenu.min.js"></script>
                <script src="../dist/js/sb-admin-2.js"></script>
                <script src="../js/jquery.datetimepicker.full.js"></script>
                <script src="../dist/js/jquery.autocomplete.js"></script>
                <script src="../dist/js/bootstrap-select.js"></script>
                <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
                <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
                <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
            </body>

                <script>
                    function pdf_tenkoofficer(){
                        var employeecode = document.getElementById('txt_empcode').value;
                        var datestart = document.getElementById('txt_datestart').value;
                        var dateend = document.getElementById('txt_dateend').value;

                        if (datestart == '') {
                            swal.fire({
                                title: "Warning !",
                                text: "กรุณาระบุวันที่เริ่มต้น !!!",
                                showConfirmButton: true,
                                icon: "warning"
                            });
                        }else{
                            window.open('pdf_reporttenkoofficer.php?employeecode=' + employeecode+ '&datestart=' + datestart+ '&dateend=' + dateend, '_blank');
                        }
                        

                    }

                    function commit(tenkomasterid,tenkobeforeid,empcode){

                        rs_checkoffice();
                        var temp_officer    = $("#txt_rsofficer11").val();
                        var sys_officer     = $("#txt_rsofficer121").val();
                        var dia_officer     = $("#txt_rsofficer122").val();
                        var pulse_officer   = $("#txt_rsofficer123").val();
                        var alcohol_officer = $("#txt_rsofficer13").val();
                        var oxygen_officer  = $("#txt_rsofficer14").val();
                        
                        // alert(tenkomasterid);
                        // alert(tenkobeforeid);
                        // alert(empcode);
                        // alert(temp_officer);
                        // alert(sys_officer);
                        // alert(dia_officer);
                        // alert(pulse_officer);
                        // alert(alcohol_officer);
                        // alert(oxygen_officer);
                        
                        $.ajax({
                            url: 'meg_data2.php',
                            type: 'POST',
                            data: {
                                txt_flg: "save_tenkobeforeofficer", 
                                tenkomasterid: tenkomasterid,  
                                tenkobeforeid: tenkobeforeid, 
                                employeecode: empcode, 
                                tempval: temp_officer, 
                                sysval: sys_officer, 
                                diaval: dia_officer, 
                                pulseval: pulse_officer,
                                alcoholval: alcohol_officer,
                                oxygenval: oxygen_officer
                            },
                            success: function (rs) {
                                // alert(rs);
                                swal.fire({
                                    title: "Good Job!",
                                    text: "บันทึกข้อมูลเรียบร้อย",
                                    showConfirmButton: false,
                                    icon: "success",
                                    timer: 1300,  
                                });
                                // alert(rs);   
                                // window.location.reload();
                            }
                        });

                    }

                    function edit_tenkobeforetxtremarkofficer(editableObj, fieldname, ID)
                    {
                        $.ajax({
                            url: 'meg_data.php',
                            type: 'POST',
                            data: {
                                txt_flg: "edit_tenkobeforeofficer1", editableObj: editableObj, ID: ID, fieldname: fieldname
                            },
                            success: function () {
                                
                            }
                        });
                    }
                    function edit_tenkobeforetxtofficer1(editableObj, fieldname, ID)
                    {
                        

                        $.ajax({
                            url: 'meg_data.php',
                            type: 'POST',
                            data: {
                                txt_flg: "edit_tenkobeforeofficer1", editableObj: editableObj, ID: ID, fieldname: fieldname
                            },
                            success: function () {
                                
                                //อุณหภูมิ
                                if (document.getElementById("txt_rsofficer11").value != "")
                                {
                                    if (document.getElementById("txt_rsofficer11").value < 37)
                                    {
                                        // ผลตรวจอุณภูมิ ผ่าน
                                        document.getElementById("chk_rsofficer111").checked = true;
                                        document.getElementById("chk_rsofficer110").checked = false;
                                        edit_tenkobeforechk('1', 'TENKOTEMPERATURERESULT', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);

                                    } else
                                    {
                                        // ผลตรวจอุณภูมิ ไม่ผ่าน
                                        document.getElementById("chk_rsofficer110").checked = true;
                                        document.getElementById("chk_rsofficer111").checked = false;
                                        edit_tenkobeforechk('0', 'TENKOTEMPERATURERESULT', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);
                                    }
                                     //อุณภูมิ != '' ผลตรวจ จะผ่าน
                                    document.getElementById("chk_officer11").checked = true;
                                    edit_tenkobeforechk('1', 'TENKOTEMPERATURECHECK', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);
                                 
                                } else {
                                    //อุณภูมิ = '' 
                                    // ตรวจสอบ ไม่ผ่าน
                                    document.getElementById("chk_officer11").checked = false;
                                    edit_tenkobeforechk('0', 'TENKOTEMPERATURECHECK', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);

                                    // ผลตรวจไม่ผ่าน
                                    document.getElementById("chk_rsofficer110").checked = true;
                                    document.getElementById("chk_rsofficer111").checked = false;
                                    edit_tenkobeforechk('0', 'TENKOTEMPERATURERESULT', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);
                                }
                                /////////////////////////////////////////////////////////////////////////
                                

                            }
                        });

                    }
                    function edit_tenkobeforetxtofficer2(editableObj, fieldname, ID)
                    {

                        // alert('Check1');
                        $.ajax({
                            url: 'meg_data.php',
                            type: 'POST',
                            data: {
                                txt_flg: "edit_tenkobeforeofficer1", editableObj: editableObj, ID: ID, fieldname: fieldname
                            },
                            success: function () {

                                // ความดันบน-ล่าง ,อัตราเต้นหัวใจ
                                if (document.getElementById("txt_rsofficer121").value != "")
                                {
                                    if ((document.getElementById("txt_rsofficer121").value >= 90 && document.getElementById("txt_rsofficer121").value <= 140) && 
                                            (document.getElementById("txt_rsofficer122").value >= 60 && document.getElementById("txt_rsofficer122").value <= 95) &&
                                            (document.getElementById("txt_rsofficer123").value >= 60 && document.getElementById("txt_rsofficer123").value <= 100))
                                    {

                                        // ผลตรวจความดันบน-ล่าง ,อัตราเต้นหัวใจ ผ่าน
                                        document.getElementById("chk_rsofficer121").checked = true;
                                        document.getElementById("chk_rsofficer120").checked = false;
                                        edit_tenkobeforechk('1', 'TENKOPRESSURERESULT', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);

                                       
                                    } else
                                    {
                                        // ผลตรวจความดันบน-ล่าง ,อัตราเต้นหัวใจ ไม่ผ่าน
                                        document.getElementById("chk_rsofficer120").checked = true;
                                        document.getElementById("chk_rsofficer121").checked = false;
                                        edit_tenkobeforechk('0', 'TENKOPRESSURERESULT', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);

                                    }

                                    // ความดันบน-ล่าง ,อัตราเต้นหัวใจ != ''
                                    // ตรวจสอบความดันบน-ล่าง ,อัตราเต้นหัวใจ ผ่าน
                                    document.getElementById("chk_officer12").checked = true;
                                    edit_tenkobeforechk('1', 'TENKOPRESSURECHECK', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);
                                } else
                                {
                                    // ความดันบน-ล่าง ,อัตราเต้นหัวใจ = ''
                                    // ตรวจสอบความดันบน-ล่าง ,อัตราเต้นหัวใจ ไม่ผ่าน
                                    document.getElementById("chk_officer12").checked = false;
                                    edit_tenkobeforechk('0', 'TENKOPRESSURECHECK', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);

                                    // ผลตรวจความดันบน-ล่าง ,อัตราเต้นหัวใจ ไม่ผ่าน
                                    document.getElementById("chk_rsofficer120").checked = true;
                                    document.getElementById("chk_rsofficer121").checked = false;
                                    edit_tenkobeforechk('0', 'TENKOPRESSURERESULT', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);
                                }

                            }
                        });

                    }
                    
                    
                    function edit_tenkobeforetxtofficer4(editableObj, fieldname, ID)
                    {

                        $.ajax({
                            url: 'meg_data.php',
                            type: 'POST',
                            data: {
                                txt_flg: "edit_tenkobeforeofficer1", editableObj: editableObj, ID: ID, fieldname: fieldname
                            },
                            success: function () {

                                // แอลกอฮอล์
                                if (document.getElementById("txt_rsofficer13").value != "")
                                {
                                    if (document.getElementById("txt_rsofficer13").value > 0)
                                    {
                                        // ผลตรวจแอลกอฮอล์ ไม่ผ่าน
                                        document.getElementById("chk_rsofficer130").checked = true;
                                        document.getElementById("chk_rsofficer131").checked = false;
                                        edit_tenkobeforechk('0', 'TENKOALCOHOLRESULT', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);
                                    } else
                                    {
                                        // ผลตรวจแอลกอฮอล์ ผ่าน
                                        document.getElementById("chk_rsofficer131").checked = true;
                                        document.getElementById("chk_rsofficer130").checked = false;
                                        edit_tenkobeforechk('1', 'TENKOALCOHOLRESULT', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);
                                    }
                                    // แอลกอฮอล์ != '' 
                                    // ตรวจสอบ ผ่าน
                                    document.getElementById("chk_officer13").checked = true;
                                    edit_tenkobeforechk('1', 'TENKOALCOHOLCHECK', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);
                                } else
                                {
                                    // แอลกอฮอล์ = '' 
                                    // ตรวจสอบแอลกอฮอล์ ไม่ผ่าน
                                    document.getElementById("chk_officer13").checked = false;
                                    edit_tenkobeforechk('', 'TENKOALCOHOLCHECK', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);

                                    // ตรวจสอบแอลกอฮอล์ ไม่ผ่าน
                                    document.getElementById("chk_rsofficer130").checked = true;
                                    document.getElementById("chk_rsofficer131").checked = false;
                                    edit_tenkobeforechk('0', 'TENKOALCOHOLRESULT', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);
                                }

                            }
                        });

                    }
                    function edit_tenkobeforetxtofficer5(editableObj, fieldname, ID)
                    {

                        $.ajax({
                            url: 'meg_data.php',
                            type: 'POST',
                            data: {
                                txt_flg: "edit_tenkobeforeofficer1", editableObj: editableObj, ID: ID, fieldname: fieldname
                            },
                            success: function () {

                                // ออกซิเจน
                                if (document.getElementById("txt_rsofficer14").value != "")
                                {
                                    if (document.getElementById("txt_rsofficer14").value >= 98)
                                    {
                                        // ผลตรวจออกซิเจน ผ่าน
                                        document.getElementById("chk_rsofficer141").checked = true;
                                        document.getElementById("chk_rsofficer140").checked = false;
                                        edit_tenkobeforechk('1', 'TENKOOXYGENRESULT', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);
                                    } else
                                    {   
                                        // ผลตรวจออกซิเจน ไม่ผ่าน
                                        document.getElementById("chk_rsofficer140").checked = true;
                                        document.getElementById("chk_rsofficer141").checked = false;
                                        edit_tenkobeforechk('0', 'TENKOOXYGENRESULT', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);
                                    }

                                    // ออกซิเจน != ''
                                    // ตรวจสอบออกซิเจน ผ่าน
                                    document.getElementById("chk_officer14").checked = true;
                                    edit_tenkobeforechk('1', 'TENKOOXYGENCHECK', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);
                                } else
                                {
                                    // ออกซิเจน = '' 
                                    // ตรวจสอบออกซิเจน ไม่ผ่าน
                                    document.getElementById("chk_officer14").checked = false;
                                    edit_tenkobeforechk('0', 'TENKOOXYGENCHECK', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);

                                    // ผลตรวจออกซิเจน ไม่ผ่าน
                                    document.getElementById("chk_rsofficer140").checked = true;
                                    document.getElementById("chk_rsofficer141").checked = false;
                                    edit_tenkobeforechk('0', 'TENKOOXYGENRESULT', <?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>);
                                }

                            }
                        });

                    }
                    
                    function rs_checkoffice()
                    {
                        if (document.getElementById('txt_rsofficer11').value != "" && document.getElementById('txt_rsofficer121').value != "" && document.getElementById('txt_rsofficer122').value != "" && document.getElementById('txt_rsofficer13').value != "" && document.getElementById('txt_rsofficer14').value != "")
                        {
                            if ((document.getElementById('txt_rsofficer11').value > 0 && document.getElementById('txt_rsofficer11').value < 37) && 
                                    (document.getElementById('txt_rsofficer121').value >= 90 && document.getElementById('txt_rsofficer121').value <= 150) && 
                                    (document.getElementById('txt_rsofficer122').value >= 60 && document.getElementById('txt_rsofficer122').value <= 95) && 
                                    (document.getElementById("txt_rsofficer123").value >= 60 && document.getElementById("txt_rsofficer123").value <= 100) &&
                                    (document.getElementById('txt_rsofficer13').value == 0) && (document.getElementById('txt_rsofficer14').value > 0))
                            {

                                document.getElementById('icon_officecheckok').style.display = "";
                                document.getElementById('icon_officecheckno').style.display = "none";
                                document.getElementById('icon_officeresultok').style.display = "";
                                document.getElementById('icon_officeresultno').style.display = "none";
                            } else
                            {

                                document.getElementById('icon_officecheckok').style.display = "";
                                document.getElementById('icon_officecheckno').style.display = "none";
                                document.getElementById('icon_officeresultok').style.display = "none";
                                document.getElementById('icon_officeresultno').style.display = "";
                            }
                        } else
                        {

                            document.getElementById('icon_officecheckok').style.display = "none";
                            document.getElementById('icon_officecheckno').style.display = "";
                            document.getElementById('icon_officeresultok').style.display = "none";
                            document.getElementById('icon_officeresultno').style.display = "";
                        }



                    }
                    function edit_tenkobeforechk(editableObj, fieldname, ID)
                    {

                        // alert(editableObj);
                        // alert(fieldname);
                        // alert(ID);
                        //editTenkobefore('edit_tenkobefore', $result_seTenkobefore['TENKOBEFOREID'], 'TENKORESTDATA', $result_seChktenkorest['TENKORESTDATA']);
                        //editTenkobefore('edit_tenkobefore', $result_seTenkobefore['TENKOBEFOREID'], 'TENKORESTRESULT', 1);




                    <?php
                    if ($result_sePlain['COMPANYCODE'] == 'RCC' || $result_sePlain['COMPANYCODE'] == 'RRC' || $result_sePlain['COMPANYCODE'] == 'RATC') {
                        ?>
                            $.ajax({
                                url: 'meg_data.php',
                                type: 'POST',
                                data: {
                                    txt_flg: "edit_tenkobeforeofficer1", editableObj: '<?= $result_seChktenkorest['TENKORESTDATA'] ?>', ID: '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>', fieldname: 'TENKORESTDATA'
                                },
                                success: function () {



                                }
                            });


                            $.ajax({
                                url: 'meg_data.php',
                                type: 'POST',
                                data: {
                                    txt_flg: "edit_tenkobeforeofficer1", editableObj: '1', ID: '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>', fieldname: 'TENKORESTDATA'
                                },
                                success: function () {



                                }
                            });
                        <?php
                    }
                    ?>

                        $.ajax({
                            url: 'meg_data.php',
                            type: 'POST',
                            data: {
                                txt_flg: "edit_tenkobeforeofficer1", editableObj: editableObj, ID: ID, fieldname: fieldname
                            },
                            success: function () {



                            }
                        });
                    }

                    
                    function datetodate()
                    {
                        document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                    }
                    $(function () {
                        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                        // กรณีใช้แบบ input
                        $(".dateen").datetimepicker({
                            timepicker: false,
                            format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                            lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                        });
                    });

                    $(function () {
                        $('[data-toggle="popover"]').popover({
                                html: true,
                                content: function () {
                                    return $('#popover-content').html();
                                }
                            });
                        }
                    )

                    $(document).ready(function () {
                        $('#dataTables-example_tenko').DataTable({
                            responsive: true,
                            order: [[0, "asc"]],
                        });
                    });

                </script>
           
        </html>


        <?php
        sqlsrv_close($conn);
        ?>
