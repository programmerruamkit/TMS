
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

// $sql_getDate = "{call megStopwork_v2(?)}";
// $params_getDate = array(
//     array('select_getdate', SQLSRV_PARAM_IN)
// );
// $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
// $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

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
                        <h1>ACCIDENT INFORMATION </h1>
                    </div>
                    <div class="col-md-12" style="background-color: #e7e7e7">
                        <h1><?=$result_seName['NAME']?></h1>
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

                    <input type="hidden" name= "txt_drivercodeprint" id="txt_drivercodeprint" value="<?=$_GET['employeecode']?>"></input>
                    <input type="hidden" name= "txt_yearstartprint" id="txt_yearstartprint" value="<?=$_GET['yearstart']?>"></input>
                    <input type="hidden" name= "txt_yearendprint" id="txt_yearendprint" value="<?=$_GET['yearend']?>"></input>
                    <input type="hidden" name= "txt_user" id="txt_user" value="<?=$_SESSION["USERNAME"] ?>"></input>
                                                              
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">

                                    <div class="row">
                                        <div class="col-sm-6"><a href=''>รายละเอียด</a> / รายละเอียดข้อมูลอุบัติเหตุ</div>
                                        <!-- <div class="col-sm-6 text-right"><a target="_bank" href='meg_vehiclrinfoamata.php?vehicleinfoid=&meg=add'>เพิ่มข้อมูลรถ</a></div> --> 
                                    </div>
                                
                                </div><br>
                                <!-- /.panel-heading -->
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>พิมพ์ข้อมูลประวัติอุบัติเหตุ </label><br>   
                                            <input type="button"  name="" id=""onclick="print_accidentpdf()" value="พิมพ์ข้อมูลประวัติอุบัติเหตุ (PDF)" class="btn btn-primary">
                                            <input type="button"  name="" id=""onclick="print_accidentexcel()" value="พิมพ์ข้อมูลประวัติอุบัติเหตุ (EXCEL)" class="btn btn-primary">
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
                                                                    <th>วันที่เวลา</th>
                                                                    <th>ปีที่เกิดอุบัติเหตุ</th>
                                                                    <th>สถานที่เกิดอุบัติเหตุ</th>
                                                                    <th>ปัญหาของอุบัติเหตุ</th>
                                                                    <th>MAN</th>
                                                                    <th>METHOD</th>
                                                                    <th>MECHINE</th>
                                                                    <th>ENVIRONMENT</th>
                                                                    <th>หมายเหตุ</th>
                                                                    <th>ประเภทของอุบัติเหตุ</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            $i = 1;

                                                            // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
                                                            // $condiReporttransport2 = "";
                                                            // $condiReporttransport3 = "";

                                                            $sql_seAccidentData = "SELECT ACCI_ID,DRIVERNAME,DRIVERCODE,YEARS,CONVERT(VARCHAR(10),DATETIMEACCIDENT,103) AS 'DATE',
                                                            CONVERT(VARCHAR(5),CONVERT(DATETIME, DATETIMEACCIDENT, 0), 108) AS 'TIME',CONVERT(VARCHAR,DATETIMEACCIDENT,120) AS 'DATETIME',
                                                            DATETIMEACCIDENT,LOCATIONACCIDENT,PROBLEMACCIDENT,
                                                            DETAILMAN,DETAILMETHOD,DETAILMECHINE,DETAILENVIRONMENT,REMARK,TYPEACCIDENT
                                                            FROM ACCIDENTHISTORY
                                                            WHERE DRIVERCODE = '".$_GET['employeecode']."'
                                                            AND YEARS BETWEEN '".$_GET['yearstart']."' AND '".$_GET['yearend']."'
                                                            ORDER BY YEARS,DATETIMEACCIDENT ASC";
                                                            $params_seAccidentData = array();
                                                            $query_seAccidentData = sqlsrv_query($conn, $sql_seAccidentData, $params_seAccidentData);
                                                            while ($result_seAccidentData = sqlsrv_fetch_array($query_seAccidentData, SQLSRV_FETCH_ASSOC)) {

                                                                
                                                                ?>

                                                                <tr>

                                                                    <td style="text-align: center"><?= $i ?></td>
                                                                    <td style="text-align: center"><?= $result_seAccidentData['DATETIME'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seAccidentData['YEARS'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seAccidentData['LOCATIONACCIDENT'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seAccidentData['PROBLEMACCIDENT'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seAccidentData['DETAILMAN'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seAccidentData['DETAILMETHOD'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seAccidentData['DETAILMECHINE'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seAccidentData['DETAILENVIRONMENT'] ?></td>
                                                                    <td style="text-align: center"><?= $result_seAccidentData['REMARK'] ?></td>
                                                                    <td style="text-align: center"><?=$result_seAccidentData['TYPEACCIDENT']?></td>
                                                                    
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

                                        function print_accidentexcel()
                                        {

                                            var drivercode = document.getElementById('txt_drivercodeprint').value;
                                            var yearstart = document.getElementById('txt_yearstartprint').value;
                                            var yearend = document.getElementById('txt_yearendprint').value;
                                            
                                            window.open('excel_digitaltenko_accidentdata.php?drivercode='+ drivercode+'&yearstart='+yearstart+'&yearend='+yearend, '_blank');
                                           
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
