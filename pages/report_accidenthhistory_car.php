
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

if ($_GET['id1'] != "") {
    $condition1 = " AND a.MENUID = " . $_GET['id1'];
    $sql_getMenu = "{call megMenu_v2(?,?)}";
    $params_getMenu = array(
        array('select_menu', SQLSRV_PARAM_IN),
        array($condition1, SQLSRV_PARAM_IN)
    );
    $query_getMenu = sqlsrv_query($conn, $sql_getMenu, $params_getMenu);
    $result_getMenu = sqlsrv_fetch_array($query_getMenu, SQLSRV_FETCH_ASSOC);
}

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);
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
                        <h1>CAR ACCIDENT INFORMATION</h1>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                    <div class="well">
                        <div class="row"></div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="row">
                    <div class="col-md-12">&nbsp;</div>
                </div>
                <input type="hidden" name= "txt_regiscar" id="txt_regiscar" value="<?=$_GET['regiscar']?>">
                <input type="hidden" name= "txt_area" id="txt_area" value="<?=$_GET['area']?>">
                <input type="hidden" name= "txt_yearstartprint" id="txt_yearstartprint" value="<?=$_GET['yearstart']?>">
                <input type="hidden" name= "txt_yearendprint" id="txt_yearendprint" value="<?=$_GET['yearend']?>">   
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">
                                <div class="row">
                                    <div class="col-sm-6"><a href='meg_accidenthistory_car.php'>บันทึกข้อมูลรถที่เกิดอุบัติเหตุ</a> / รายละเอียดข้อมูลรถที่เกิดอุบัติเหตุ</div>
                                    <!-- <div class="col-sm-6 text-right"><a target="_bank" href='meg_vehiclrinfoamata.php?vehicleinfoid=&meg=add'>เพิ่มข้อมูลรถ</a></div> --> 
                                </div>                                
                            </div><br>
                            <!-- /.panel-heading -->
                            <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>พิมพ์ข้อมูลประวัติอุบัติเหตุ </label><br>   
                                        <input type="button"  name="" id=""onclick="print_caraccidentpdf()" value="พิมพ์ข้อมูลประวัติอุบัติเหตุ (PDF)" class="btn btn-primary">
                                        <input type="button"  name="" id=""onclick="print_caraccidentexcel()" value="พิมพ์ข้อมูลประวัติอุบัติเหตุ (EXCEL)" class="btn btn-primary">
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div id="datadef">
                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                        <thead>
                                                            <tr>
                                                                <th>ลำดับ</th>
                                                                <th>ทะเบียนรถ / ชื่อรถ</th>
                                                                <th>ชื่อพนักงานผู้ขับรถ</th>
                                                                <th>วันที่เวลาที่เกิดอุบัติเหตุ</th>
                                                                <th>สถานที่เกิดอุบัติเหตุ</th>
                                                                <th>ปัญหาจากการเกิดอุบัติเหตุ</th>
                                                                <th>สถานที่ซ่อม</th>
                                                                <th>ชื่ออู่นอก</th>
                                                                <th>อาการที่ส่งซ่อม</th>
                                                                <th></th>
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
                                                                <td style="text-align: center">
                                                                <a href="meg_accidenthistory_car.php?ACCICAR_ID=<?= $result_seAccidentCarData['ACCICAR_ID'] ?>" type="button" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                                                <a href="javascript:void(0)" type="button" data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!" onclick ="confirm_delete('<?=$result_seAccidentCarData['ACCICAR_ID']?>');" name="btnSend" id="btnSend" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                            </td>
                                                            </tr>
                                                            <?php $i++; } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="datasr"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        function print_caraccidentpdf(){
            var regiscar = document.getElementById('txt_regiscar').value;
            var area = document.getElementById('txt_area').value;
            var yearstart = document.getElementById('txt_yearstartprint').value;
            var yearend = document.getElementById('txt_yearendprint').value;                                            
            window.open('pdf_caraccidentdata.php?regiscar='+ regiscar+'&area='+ area+'&yearstart='+yearstart+'&yearend='+yearend, '_blank');                                           
        } 
        function print_caraccidentexcel(){
            var regiscar = document.getElementById('txt_regiscar').value;
            var area = document.getElementById('txt_area').value;
            var yearstart = document.getElementById('txt_yearstartprint').value;
            var yearend = document.getElementById('txt_yearendprint').value;                                            
            window.open('excel_accidentcardata.php?regiscar='+ regiscar+'&area='+ area+'&yearstart='+yearstart+'&yearend='+yearend, '_blank');
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
        function delete_accident(id){                                            
            // alert('delete');
            // alert(id);
            $.ajax({
                type: 'post',
                url: 'meg_accidenthistory_car_save.php',
                data: {
                    txt_flg: "delete_accident",
                    id:id
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
    </script>
</html>
<?php
sqlsrv_close($conn);
?>
