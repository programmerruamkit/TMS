
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

// if ($_GET['id1'] != "") {
//     $condition1 = " AND a.MENUID = " . $_GET['id1'];
//     $sql_getMenu = "{call megMenu_v2(?,?)}";
//     $params_getMenu = array(
//         array('select_menu', SQLSRV_PARAM_IN),
//         array($condition1, SQLSRV_PARAM_IN)
//     );
//     $query_getMenu = sqlsrv_query($conn, $sql_getMenu, $params_getMenu);
//     $result_getMenu = sqlsrv_fetch_array($query_getMenu, SQLSRV_FETCH_ASSOC);
// }

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$sql_seName = "SELECT nameT AS 'NAME' FROM EMPLOYEEEHR2 WHERE PersonCode ='".$_GET['employeecode']."'";
$params_seName = array();
$query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
$result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC);

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
        <!--<link href="../dist/css/sb-admin-2.css" rel="stylesheet">-->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <link href="../js/bootstrap-datepicker.css" rel="stylesheet">

    </head>
    <style>
    h1 {
        text-align: center;
        text-transform: uppercase;
        color: #F94F05;
        text-decoration: overline;
        text-decoration: underline;
        text-shadow: 2px 2px #F9DA05;
        font-size:40px;
        }
    </style>
    <body>
    
    
        <div id="wrapper">
            <!-- <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

                <div class="navbar-header" >
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">

                            <li><a href="meg_logout.php"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav> -->

            <div id="page-wrapper" >
                <div class="row">
                    <div class="col-md-12" style="background-color: #e7e7e7">
                        <h1>DRIVERRANKING INFORMATION </h1>
                    </div>
                    <div class="col-md-12" style="background-color: #e7e7e7">
                        <input type="text" hidden id="txt_drivercode" value="<?=$_GET['drivercode']?>">
                        <input type="text" hidden id="txt_company"    value="<?=$_GET['company']?>">
                        <input type="text" hidden id="txt_position"   value="<?=$_GET['position']?>">
                        <input type="text" hidden id="txt_monththai"  value="<?=$_GET['monththai']?>">
                        <input type="text" hidden id="txt_montheng"   value="<?=$_GET['montheng']?>">
                        <input type="text" hidden id="txt_yearstartrank" value="<?=$_GET['yearstartrank']?>">
                        <input type="text" hidden id="txt_yearsendrank"  value="<?=$_GET['yearsendrank']?>">
                        <input type="text" hidden id="txt_type" value="<?=$_GET['type']?>">

                    </div>
                    
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                    <div class="well">
                        <div class="row">

                            <!-- <div class="col-lg-2">
                                <label>เลือกพนักงาน:</label>
                                <div class="dropdown bootstrap-select show-tick form-control">

                                    <select   id="txt_drivername" name="txt_drivername" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                        <?php
                                        // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                        $sql_seName = "SELECT PersonCode AS 'EMPLOYEECODE',nameT AS 'DRIVERNAME',
                                        Email AS 'EMAIL',CurrentTel AS 'TEL'
                                        FROM EMPLOYEEEHR2  WHERE 1=1 
                                        AND PositionNameT IN('พนักงานขับรถ/STM-SR')";
                                        $params_seName = array();
                                        $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                        while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?= $result_seName['EMPLOYEECODE'] ?>"><?= $result_seName['DRIVERNAME'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <input class="form-control" style="display: none"   id="txt_copydiagramzone" name="txt_copydiagramzone" maxlength="500" value="" >


                                </div>
                            </div>
                            
                            <div class="col-lg-2">
                                <label>&nbsp;</label>
                                <div class="form-group">
                                    <button type="button" class="btn btn-default" onclick="select_trainingdata();">ค้นหา <li class="fa fa-search"></li></button>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <label>&nbsp;</label><br>
                                <a href="#" onclick="pdf_reporttrainingdata();" class="btn btn-default">รายงานข้อมูลฝึกอบรม<li class="fa fa-print"></li></a>

                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>

                    <!-- <input type="hidden" name= "txt_drivercodeprint" id="txt_drivercodeprint" value="<?=$_GET['drivercode']?>"></input>
                    <input type="hidden" name= "txt_yearstartprint" id="txt_yearstartprint" value="<?=$_GET['yearstart']?>"></input>
                    <input type="hidden" name= "txt_yearendprint" id="txt_yearendprint" value="<?=$_GET['yearend']?>"></input> -->
                    <input type="hidden" name= "txt_user" id="txt_user" value="<?=$_SESSION["USERNAME"] ?>"></input>
                                                              
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">

                                    <div class="row">
                                        <div class="col-sm-6">รายละเอียดข้อมูลแรงค์พนักงาน</div>
                                        <!-- <div class="col-sm-6 text-right"><a target="_bank" href='meg_vehiclrinfoamata.php?vehicleinfoid=&meg=add'>เพิ่มข้อมูลรถ</a></div> --> 
                                    </div>
                                
                                </div><br>
                                <!-- /.panel-heading -->
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>พิมพ์ข้อมูลแรงค์ของพนักงาน </label><br>   
                                            <!-- <input type="button"  name="" id=""onclick="print_accidentpdf()" value="พิมพ์ข้อมูลประวัติอุบัติเหตุ (PDF)" class="btn btn-primary"> -->
                                            <input type="button"  name="" id=""onclick="print_rankexcel()" value="พิมพ์ข้อมูลแรงค์ของพนักงาน (EXCEL)" class="btn btn-primary">
                                        </div>
                                    </div>
                                <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                            <thead>
                                                                <tr>
                                                                    <th>ลำดับ</th>
                                                                    <th style="text-align: center;width:10px">รหัสพนักงาน</th>
                                                                    <th style="text-align: center;width:170px">ชื่อ-สกุล</th>
                                                                    <th style="text-align: center;width:80px">ตำแหน่ง/สายงาน</th>
                                                                    <th style="text-align: center;width:30px">เดือน</th>
                                                                    <th style="text-align: center;width:30px">ปี</th>
                                                                    <th style="text-align: center;width:80px">อุบัติเหตุรถบรรทุก</th>
                                                                    <th style="text-align: center;width:80px">อุบัติเหตุสินค้าเสียหาย</th>
                                                                    <th style="text-align: center;width:90px">ตรวจสอบการทำงาน</th>
                                                                    <th style="text-align: center;width:80px">พฤติกรรมการขับขี่</th>
                                                                    <th style="text-align: center;width:130px">การปฎิบัติงานพนักงานขับรถ</th>
                                                                    <th style="text-align: center;width:80px">ข้อร้องเรียนจากลูกค้า</th>
                                                                    <th style="text-align: center;width:80px">รถบรรทุกพร้อมใช้</th>
                                                                    <th style="text-align: center;width:80px">ปฏิบัติตามระเบียบบริษัทฯ</th>
                                                                    <th style="text-align: center;width:100px">การเข้าร่วมประชุม/กิจกรรม</th>
                                                                    <th style="text-align: center;width:80px">การมาทำงาน</th>
                                                                    <th style="text-align: center;width:80px">คะแนนรวม</th>
                                                                    <th>เกรด</th>
                                                                    
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            $i = 1;

                                                            // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
                                                            // $condiReporttransport2 = "";
                                                            // $condiReporttransport3 = "";
                                                            if ($_GET['type'] == 'person') {

                                                                $sql_seRankData = "SELECT a.RANKID,a.DRIVERCODE,a.DRIVERNAME,b.PositionNameT,a.MONTHTH,a.YEARRANK,
                                                                    a.ACCIDENTTRUCK,a.ACCIDENTPRODUCT,a.WORKCHECKING,a.DRIVERBEHAVIOR,a.OPERATIONDRIVER,
                                                                    a.COMPAINFROMCUS,a.TRUCKREADY,
                                                                    a.COMPANYREGULATION,a.ATTENDANCE,a.COMINGTOWORK,
                                                                    a.ALLPOINT,a.RANKING
                                                                    FROM DRIVERRANKING a
                                                                    INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a. DRIVERCODE
                                                                    WHERE a.DRIVERCODE = '".$_GET['drivercode']."'
                                                                    AND a.MONTHENG ='".$_GET['montheng']."'
                                                                    AND a.YEARRANK BETWEEN '".$_GET['yearstartrank']."' AND '".$_GET['yearsendrank']."'
                                                                    ORDER BY a.YEARRANK,b.PositionNameT,a.DRIVERCODE ASC";
                                                                $params_seRankData = array();
                                                                $query_seRankData = sqlsrv_query($conn, $sql_seRankData, $params_seRankData);
                                                           
                                                            }else if ($_GET['type'] == 'company') {
                                                                if ($_GET['company'] == '00') {
                                                                    $sql_seRankData = "SELECT a.DRIVERCODE,a.DRIVERNAME,b.PositionNameT,a.MONTHTH,a.YEARRANK,
                                                                        a.ACCIDENTTRUCK,a.ACCIDENTPRODUCT,a.WORKCHECKING,a.DRIVERBEHAVIOR,a.OPERATIONDRIVER,
                                                                        a.COMPAINFROMCUS,a.TRUCKREADY,
                                                                        a.COMPANYREGULATION,a.ATTENDANCE,a.COMINGTOWORK,
                                                                        a.ALLPOINT,a.RANKING
                                                                        FROM DRIVERRANKING a
                                                                        INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a. DRIVERCODE
                                                                        WHERE a.MONTHENG ='".$_GET['montheng']."'
                                                                        AND a.YEARRANK BETWEEN '".$_GET['yearstartrank']."' AND '".$_GET['yearsendrank']."'
                                                                        ORDER BY a.YEARRANK,b.PositionNameT,a.DRIVERCODE ASC";
                                                                    $params_seRankData = array();
                                                                    $query_seRankData = sqlsrv_query($conn, $sql_seRankData, $params_seRankData);
                                                                }else {
                                                                    $sql_seRankData = "SELECT a.DRIVERCODE,a.DRIVERNAME,b.PositionNameT,a.MONTHTH,a.YEARRANK,
                                                                        a.ACCIDENTTRUCK,a.ACCIDENTPRODUCT,a.WORKCHECKING,a.DRIVERBEHAVIOR,a.OPERATIONDRIVER,
                                                                        a.COMPAINFROMCUS,a.TRUCKREADY,
                                                                        a.COMPANYREGULATION,a.ATTENDANCE,a.COMINGTOWORK,
                                                                        a.ALLPOINT,a.RANKING
                                                                        FROM DRIVERRANKING a
                                                                        INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a. DRIVERCODE
                                                                        WHERE SUBSTRING(a.DRIVERCODE, 1, 2) ='".$_GET['company']."'
                                                                        AND a.MONTHENG ='".$_GET['montheng']."'
                                                                        AND a.YEARRANK BETWEEN '".$_GET['yearstartrank']."' AND '".$_GET['yearsendrank']."'
                                                                        ORDER BY a.YEARRANK,b.PositionNameT,a.DRIVERCODE ASC";
                                                                    $params_seRankData = array();
                                                                    $query_seRankData = sqlsrv_query($conn, $sql_seRankData, $params_seRankData);
                                                                }
                                                                

                                                            }else if ($_GET['type'] == 'position') {
                                                                if ($_GET['position'] == '000') {
                                                                    $sql_seRankData = "SELECT a.DRIVERCODE,a.DRIVERNAME,b.PositionNameT,a.MONTHTH,a.YEARRANK,
                                                                        a.ACCIDENTTRUCK,a.ACCIDENTPRODUCT,a.WORKCHECKING,a.DRIVERBEHAVIOR,a.OPERATIONDRIVER,
                                                                        a.COMPAINFROMCUS,a.TRUCKREADY,
                                                                        a.COMPANYREGULATION,a.ATTENDANCE,a.COMINGTOWORK,
                                                                        a.ALLPOINT,a.RANKING
                                                                        FROM DRIVERRANKING a
                                                                        INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a. DRIVERCODE
                                                                        WHERE a.MONTHENG ='".$_GET['montheng']."'
                                                                        AND a.YEARRANK BETWEEN '".$_GET['yearstartrank']."' AND '".$_GET['yearsendrank']."'
                                                                        ORDER BY a.YEARRANK,b.PositionNameT,a.DRIVERCODE ASC";
                                                                    $params_seRankData = array();
                                                                    $query_seRankData = sqlsrv_query($conn, $sql_seRankData, $params_seRankData);
                                                                }else{
                                                                    $sql_seRankData = "SELECT a.DRIVERCODE,a.DRIVERNAME,b.PositionNameT,a.MONTHTH,a.YEARRANK,
                                                                        a.ACCIDENTTRUCK,a.ACCIDENTPRODUCT,a.WORKCHECKING,a.DRIVERBEHAVIOR,a.OPERATIONDRIVER,
                                                                        a.COMPAINFROMCUS,a.TRUCKREADY,
                                                                        a.COMPANYREGULATION,a.ATTENDANCE,a.COMINGTOWORK,
                                                                        a.ALLPOINT,a.RANKING
                                                                        FROM DRIVERRANKING a
                                                                        INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a. DRIVERCODE
                                                                        WHERE b.PositionNameT ='".$_GET['position']."'
                                                                        AND a.MONTHENG ='".$_GET['montheng']."'
                                                                        AND a.YEARRANK BETWEEN '".$_GET['yearstartrank']."' AND '".$_GET['yearsendrank']."'
                                                                        ORDER BY a.YEARRANK,b.PositionNameT ASC";
                                                                    $params_seRankData = array();
                                                                    $query_seRankData = sqlsrv_query($conn, $sql_seRankData, $params_seRankData);
                                                                }
                                                                

                                                            }else{

                                                            }
                                                            
                                                            while ($result_seRankData = sqlsrv_fetch_array($query_seRankData, SQLSRV_FETCH_ASSOC)) {

                                                                
                                                                ?>

                                                                <tr>

                                                                    <td style="text-align: center;width:10px"><?= $i ?></td>
                                                                    <td style="text-align: center;width:30px"><?= $result_seRankData['DRIVERCODE'] ?></td>
                                                                    <td style="text-align: center;width:50px"><?= $result_seRankData['DRIVERNAME'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seRankData['PositionNameT'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seRankData['MONTHTH'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seRankData['YEARRANK'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seRankData['ACCIDENTTRUCK'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seRankData['ACCIDENTPRODUCT'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seRankData['WORKCHECKING'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seRankData['DRIVERBEHAVIOR'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seRankData['OPERATIONDRIVER'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seRankData['COMPAINFROMCUS'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seRankData['TRUCKREADY'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seRankData['COMPANYREGULATION'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seRankData['ATTENDANCE'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seRankData['COMINGTOWORK'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seRankData['ALLPOINT'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seRankData['RANKING'] ?></td>
                                                                    <!-- <td style="text-align: center"><input type="button"   data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!" onclick ="confirm_delete('<?=$result_seRankData['RANKID']?>');" name="btnSend" id="btnSend" value="ลบข้อมูล" class="btn btn-danger"></td> -->
                                                                </tr>
                                                                <!-- <tr>
                                                                    <td style="text-align: center"><?= $i ?></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'LOCATION', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['DRIVERCODE'] ?>"></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'PROBLEM', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['DRIVERNAME'] ?>"></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'DETAILMAN', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['PositionNameT'] ?>"></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'DETAILMETHOD', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['MONTHTH'] ?>"></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'DETAILMECHINE', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['YEARRANK'] ?>"></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'DETAILENVIRONMENT', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['ACCIDENTTRUCK'] ?>"></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'REMARK', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['ACCIDENTPRODUCT'] ?>"></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'REMARK', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['WORKCHECKING'] ?>"></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'REMARK', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['DRIVERBEHAVIOR'] ?>"></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'REMARK', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['OPERATIONDRIVER'] ?>"></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'REMARK', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['COMPAINFROMCUS'] ?>"></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'REMARK', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['TRUCKREADY'] ?>"></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'REMARK', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['COMPANYREGULATION'] ?>"></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'REMARK', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['ATTENDANCE'] ?>"></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'REMARK', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['COMINGTOWORK'] ?>"></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'REMARK', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['ALLPOINT'] ?>"></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_price" onchange="edit_accident(this.value, 'REMARK', '<?=$result_seRankData['RANKID']?>')" value="<?= $result_seRankData['RANKING'] ?>"></td>
                                                                    <td style="text-align: center"><input type="button"   data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!" onclick ="confirm_delete('<?=$result_seRankData['RANKID']?>');" name="btnSend" id="btnSend" value="ลบข้อมูล" class="btn btn-danger"></td>
                                                                </tr> -->
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

                                
                                <!-- /.panel -->
                            </div>
                        </div>
                    </div>



                </div>
            </div>

            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../js/jquery.datetimepicker.full.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../js/bootstrap-datepicker.min.js"></script>
            <script src="../js/bootstrap-datepicker.th.min.js"></script>


    </body>
    <script>

                                        function print_accidentpdf()
                                        {

                                            var drivercode = document.getElementById('txt_drivercodeprint').value;
                                            var yearstart = document.getElementById('txt_yearstartprint').value;
                                            var yearend = document.getElementById('txt_yearendprint').value;
                                            
                                            window.open('pdf_digitaltenko_accidentdata.php?drivercode='+ drivercode+'&yearstart='+yearstart+'&yearend='+yearend, '_blank');
                                           
                                        } 

                                        function print_rankexcel()
                                        {
                                            var drivercode    = document.getElementById('txt_drivercode').value;
                                            var company       = document.getElementById('txt_company').value;
                                            var position      = document.getElementById('txt_position').value;
                                            var monththai     = document.getElementById('txt_monththai').value;
                                            var montheng      = document.getElementById('txt_montheng').value;
                                            var yearstart     = document.getElementById('txt_yearstartrank').value;
                                            var yearend       = document.getElementById('txt_yearsendrank').value;
                                            var type          = document.getElementById('txt_type').value;

                                            window.open('excel_reportemployeeranking.php?drivercode=' + drivercode+'&company='+company+'&position='+position+'&monththai='+monththai+'&montheng='+montheng+'&yearstartrank='+yearstart+'&yearsendrank='+yearend+'&type='+type, '_blank');
                                            
                                        } 
                                        function confirm_delete(id){
                                            $(document).on('click', ':not(form)[data-confirm]', function(e){
                                                if(confirm($(this).data('confirm'))){
                                                e.stopImmediatePropagation();
                                                e.preventDefault();
                                                
                                                delete_accident(id);   
                                                }else{

                                                    window.location.reload();      
                                                }

                                            
                                            }); 

                                        }
                                        function edit_accident(value, fieldname, accidentid) {

                                            // alert(value);
                                            // alert(fieldname);
                                            // alert(accidentid);
                                            // alert(IDPLAN);
                                            // alert(IDDRIVER);

                                            var modifyby = document.getElementById('txt_user').value;
                                            //  alert(modifyby);

                                            $.ajax({
                                                url: 'meg_data2.php',
                                                type: 'POST',
                                                data: {
                                                    txt_flg: "update_accident", value: value, fieldname: fieldname, acciid: accidentid,modifyby: modifyby
                                                },
                                                success: function (rs) {

                                                    // window.location.reload();
                                                }
                                            });


                                        }

                                        function delete_accident(id){
                                            
                                            // alert('delete');
                                            // alert(id);

                                            $.ajax({
                                                type: 'post',
                                                url: 'meg_data2.php',
                                                data: {

                                                txt_flg: "delete_accident",
                                                id:id, 
                                                drivername: '',
                                                years: '', 
                                                datetimeacci: '',
                                                locationacci: '',
                                                problemacci: '',
                                                detailman: '',
                                                detailmethod: '',
                                                detailmechine: '',
                                                detailenvironment: '',
                                                remark: '',
                                                type: '',
                                                createby: ''


                                                },
                                                    success: function (rs) {

                                                    alert("ลบข้อมูลเรียบร้อย");
                                                    // // alert(rs);    
                                                    window.location.reload();
                                                }
                                                });
                                            }
                                            

                                        $(document).ready(function () {
                                            $('#dataTables-example').DataTable({
                                                order: [[0, "asc"]],
                                                scrollX: true,
                                                scrollY: '500px',
                                            });
                                        });

                                        $(function () {
                                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                            // กรณีใช้แบบ input
                                            $(".dateen").datetimepicker({
                                                timepicker: true,
                                                dateformat: 'Y-m-d' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                timeFormat: "HH:mm"

                                            }
                                            );
                                        });

                                  
                        
    </script>
</html>
<?php
sqlsrv_close($conn);
?>
