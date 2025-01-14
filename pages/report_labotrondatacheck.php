
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
        /* color: #F94F05; */
        text-decoration: overline;
        text-decoration: underline;
        /* text-shadow: 2px 2px #F9DA05; */
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
                        <h1>LABOTRON INFORMATION &nbsp; Day : <?=date("d/m/Y")?></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="background-color: #e7e7e7;font-size:20px;text-align: center">
                        <p><font color="red">ข้อมูลที่แสดงคือข้อมูลวันที่ปัจจุบันและย้อนหลัง 1 วัน</font></p>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                    <div class="well">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-size:20px;color:red"><b>มาตรฐานการตรวจร่างกาย Ruamkit</b></label><br>
                                    <label style="font-size:14px">&nbsp;1.อุณหภูมิ ต่ำกว่า 37 °C (องศาเซลเซียส)</label><br>
                                    <label style="font-size:14px">&nbsp;2.ค่าความดันบน&nbsp;: 90-150</label><br>
                                    <label style="font-size:14px">&nbsp;3.ค่าความดันล่าง&nbsp;: 60-95 </label><br>
                                    <label style="font-size:14px">&nbsp;4.อัตราการเต้นหัวใจ : 60-100 ครั้ง</label><br>
                                    <label style="font-size:14px">&nbsp;5.ออกซิเจนในเลือดตั้งแต่ 98%</label><br>
                                    <label style="font-size:14px">&nbsp;6.แอลกอฮอล์ 0 mg% (มิลลิกรัมเปอร์เซนต์) เท่านั้น</label><br>
                                </div>
                                
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group" style="text-align: left">
                                    <label style="font-size:20px;color:red"><b>มาตรฐานดัชนีมวลกาย BMI</b></label><br>
                                    <label style="font-size:14px">&nbsp;1.น้ำหนักน้อย / ผอม | BMI 0-18.0 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input disabled ="" type="text" style="font-size:10px;background-color: #66FAFF;width:60px;height:25px">
                                    </label><br>
                                    <label style="font-size:14px">&nbsp;2.ปกติ (สุขภาพดี) | BMI 18.1-23.0 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input disabled ="" type="text" style="font-size:10px;background-color: #66FF72;width:60px;height:25px">
                                    </label><br>
                                    <label style="font-size:14px">&nbsp;3.ท้วม / โรคอ้วนระดับ 1 | BMI 23.1-25.0 &nbsp;&nbsp;&nbsp;
                                        <input disabled ="" type="text" style="font-size:10px;background-color: #FFA966;width:60px;height:25px">
                                    </label><br>
                                    <label style="font-size:14px">&nbsp;3.อ้วน / โรคอ้วนระดับ 2 | BMI 25.1-30.0 &nbsp;&nbsp;&nbsp;
                                        <input disabled ="" type="text" style="font-size:10px;background-color: #FF6666;width:60px;height:25px">
                                    </label><br>
                                </div>
                                
                            </div>
                                <!-- <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>เงื่อนไขในการให้เบิก</label>
                                        <label>เงื่อนไขในการให้เบิก</label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>เงื่อนไขในการให้เบิก</label>
                                        <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>เงื่อนไขในการให้เบิก</label>
                                        <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                    </div>
                                </div> -->
                        </div>
                    </div>
                </div>
            </div>
                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>
                               
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">

                                    <div class="row">
                                        <div class="col-sm-6"><a href='index2.php'>หน้าแรก</a> / รายละเอียดข้อมูลการตรวจร่างกายจาก Labotron</div>
                                        <!-- <div class="col-sm-6 text-right"><a target="_bank" href='meg_vehiclrinfoamata.php?vehicleinfoid=&meg=add'>เพิ่มข้อมูลรถ</a></div> --> 
                                    </div>
                                
                                </div><br>
                                <!-- /.panel-heading -->
                                <!-- <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>พิมพ์ข้อมูลประวัติอุบัติเหตุ </label><br>   
                                            <input type="button"  name="" id=""onclick="print_accidentpdf()" value="พิมพ์ข้อมูลประวัติอุบัติเหตุ (PDF)" class="btn btn-primary">
                                            <input type="button"  name="" id=""onclick="print_accidentexcel()" value="พิมพ์ข้อมูลประวัติอุบัติเหตุ (EXCEL)" class="btn btn-primary">
                                        </div>
                                </div> -->
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
                                                                    <th style="width: 70px;">ลำดับ</th>
                                                                    <th style="width: 250px;">รหัสพนักงาน</th>
                                                                    <th style="width: 250px;">ชื่อ-นามสกุล</th>
                                                                    <th style="width: 150px;">เลขบัตร ปชช</th>
                                                                    <th style="width: 120px;">น้ำหนัก</th>
                                                                    <th style="width: 100px;">ส่วนสูง</th>
                                                                    <th style="width: 250px;">ดัชนีมวลกาย</th>
                                                                    <th style="width: 75px;">อุณหภูมิ</th>
                                                                    <th style="width: 70px;">ความดันบน</th>
                                                                    <th style="width: 100px;">ความดันล่าง</th>
                                                                    <th style="width: 150px;">อัตราเต้นหัวใจ</th>
                                                                    <th style="width: 70px;">ออกซิเจนในเลือด</th>
                                                                    <th style="width: 70px;">แอลกอฮอล์</th>
                                                                    <th style="width: 200px;">เวลาในการตรวจ</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php

                                                            // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
                                                            // $condiReporttransport2 = "";
                                                            // $condiReporttransport3 = "";

                                                            $i = 1;
                                                            $sql_seData = "SELECT b.nameT,b.TaxID,b.PersonCode,CARDNUMBER,DRIVER_WEIGHT,DRIVER_HEIGHT,DRIVER_BMI,
                                                            DRIVER_TEMPERATURE,DRIVER_SYS,DRIVER_DIA,DRIVER_PULSE,DRIVER_OXYGEN,DRIVER_ALCOHOL,
                                                            CREATEBY,CONVERT(VARCHAR(16),CREATEDATE,103) AS 'CREATEDATE'
                                                                                                                        
                                                            FROM LABOTRONWEBSERVICEDATA a 
                                                            INNER JOIN EMPLOYEEEHR2 b ON b.TaxID = a.CREATEBY
                                                            WHERE CONVERT(DATE,CREATEDATE) BETWEEN CONVERT(DATE,DATEADD(DAY,-1,'01/01/2023')) AND CONVERT(DATE,GETDATE())
                                                            --WHERE CARDNUMBER IN ('5320890008815','1639900241323')
                                                            ORDER BY CONVERT(VARCHAR(16),CREATEDATE,103) DESC";
                                                            $params_seData = array();
                                                            $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
                                                            while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {

                                                                //อุณหภูมิ ไม่เกิน 37
                                                                if ($result_seData['DRIVER_TEMPERATURE'] > '37' || $result_seData['DRIVER_TEMPERATURE'] == '' ) {
                                                                    $colortemp = "background-color: #FF6A66";
                                                                } else {
                                                                    $colortemp = "";
                                                                }
                                                                
                                                                //ค่าความดันบน 60-150
                                                                if ($result_seData['DRIVER_SYS'] < '60' || $result_seData['DRIVER_SYS'] > '150') {
                                                                    $colorsys = "background-color: #FF6A66";
                                                                } else {
                                                                    $colorsys = "";
                                                                }

                                                                //ค่าความดันล่าง 60-95
                                                                if ($result_seData['DRIVER_DIA'] < '60' || $result_seData['DRIVER_DIA'] > '95') {
                                                                    $colordia = "background-color: #FF6A66";
                                                                } else {
                                                                    $colordia = "";
                                                                }

                                                                //อัตตราการเต้นหัวใจ
                                                                if ($result_seData['DRIVER_PULSE'] < '60' || $result_seData['DRIVER_PULSE'] > '100') {
                                                                    $colorpulse = "background-color: #FF6A66";
                                                                } else {
                                                                    $colorpulse = "";
                                                                }

                                                                //ค่าออกซิเจนในเลือด
                                                                if ($result_seData['DRIVER_OXYGEN'] > '98') {
                                                                    $coloroxygen = "background-color: #FF6A66";
                                                                } else {
                                                                    $coloroxygen = "";
                                                                }

                                                                //ค่าแอลกอฮอล์
                                                                if ($result_seData['DRIVER_ALCOHOL'] > '0') {
                                                                    $coloralcohol = "background-color: #FF6A66";
                                                                } else {
                                                                    $coloralcohol = "";
                                                                }

                                                                 //ค่า BMI
                                                                 if ($result_seData['DRIVER_BMI'] > '0' && $result_seData['DRIVER_BMI'] < '18') {
                                                                    $colorbmi = "background-color: #66FAFF";
                                                                } else if ($result_seData['DRIVER_BMI'] > '18' && $result_seData['DRIVER_BMI'] < '23') {
                                                                    $colorbmi = "background-color: #66FF72";
                                                                }else if ($result_seData['DRIVER_BMI'] > '23'  && $result_seData['DRIVER_BMI'] < '25') {
                                                                    $colorbmi = "background-color: #FFA966";
                                                                }else if ($result_seData['DRIVER_BMI'] > '25'  && $result_seData['DRIVER_BMI'] < '30') {
                                                                    $colorbmi = "background-color: #FF6A66";
                                                                }else if ($result_seData['DRIVER_BMI']  == ''){
                                                                    $colorbmi = "";    
                                                                }else{
                                                                    $colorbmi = "background-color: #FF6A66";    
                                                                }

                                                                // echo $result_seData['DRIVER_BMI'];
                                                                // echo '<br>';
                                                                ?>

                                                                <tr>
                                                                    <td style="text-align: center"><?= $i ?>  </td>
                                                                    <td><?=$result_seData['PersonCode']?>          </td>
                                                                    <td><?=$result_seData['nameT']?>          </td>
                                                                    <td><?=$result_seData['CREATEBY']?>     </td>
                                                                    <td><?=$result_seData['DRIVER_WEIGHT']?>  </td>
                                                                    <td><?=$result_seData['DRIVER_HEIGHT'];?> </td>
                                                                    <td style="<?= $colorbmi ?>"><?=$result_seData['DRIVER_BMI'];?>            </td>
                                                                    <td style="<?= $colortemp ?>"><?=number_format($result_seData['DRIVER_TEMPERATURE'],2);?>    </td>
                                                                    <td style="<?= $colorsys ?>"><?=$result_seData['DRIVER_SYS'];?>    </td>
                                                                    <td style="<?= $colordia ?>"><?=$result_seData['DRIVER_DIA'];?>    </td>
                                                                    <td style="<?= $colorpulse   ?>"><?=$result_seData['DRIVER_PULSE'];?>  </td>
                                                                    <td style="<?= $coloroxygen  ?>"><?=$result_seData['DRIVER_OXYGEN']?>  </td>
                                                                    <td style="<?= $coloralcohol ?>"><?=$result_seData['DRIVER_ALCOHOL']?> </td>
                                                                    <td><?=$result_seData['CREATEDATE']?> </td>
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

                                  
                        
    </script>
</html>
<?php
sqlsrv_close($conn);
?>
