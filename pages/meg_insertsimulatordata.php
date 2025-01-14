<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
include_once('/PHPExcel-1.8/Classes/PHPExcel.php');
$db = connect("RTMS");

$output = '';
if (isset($_POST["import"])) {
    $tmp = explode(".", $_FILES["excel"]["name"]);
    $extension = end($tmp);

    $allowed_extension = array("xls", "xlsx", "csv"); //นามสกุลไฟล์ ที่อนุญาต
    if (in_array($extension, $allowed_extension)) //ตรวจสอบนามสกุลไฟล์
    {
        $file = $_FILES["excel"]["tmp_name"]; // ที่มาของไฟล์ excel
        include("/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php"); // เพิ่ม PHPExcel Library 
        include_once('/PHPExcel-1.8/Classes/PHPExcel.php');
        $objPHPExcel = PHPExcel_IOFactory::load($file); // สร้างวัตถุของไลบรารี PHPExcel โดยใช้วิธี load () และในวิธีการโหลดกำหนดเส้นทางของไฟล์ที่เลือก

        // $output .= "<table class='table table-striped table-hover '>";
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();
            for ($row = 2; $row <= $highestRow; $row++) { //สามารถปรับ $row เพื่อเลือกแถวที่บัทึกลงฐานข้อมูลได้เลย ถ้าไม่ปรับมันจะเอาข้อมูลทั้งหมดที่เห็นในตารางลงฐานข้อมูลนะครับ
                $output .= "<tr>";
                $drivercode = ($worksheet->getCellByColumnAndRow(0, $row)->getValue()); //รหัสพนักงาน
                $drivername = ($worksheet->getCellByColumnAndRow(1, $row)->getValue()); //ชื่อพนักงาน
                $yearssimu = ($worksheet->getCellByColumnAndRow(2, $row)->getValue()); //ปีที่ลงข้อมูล
                $tlep_firstdate = ($worksheet->getCellByColumnAndRow(3, $row)->getValue()); //วันที่ทำ TLEP วันแรก
                $tlep_followup = ($worksheet->getCellByColumnAndRow(4, $row)->getValue()); //ผ่าน TLEP ล่าสุด Follow Up
                $simudata = ($worksheet->getCellByColumnAndRow(5, $row)->getValue()); //SIMU DATA
                $createby = ($worksheet->getCellByColumnAndRow(6, $row)->getValue()); //CREATE BY
                $createdate = ($worksheet->getCellByColumnAndRow(7, $row)->getValue()); //CREATE DATE

                $query = "INSERT INTO [dbo].[SIMULATORHISTORY] (DRIVERCODE, DRIVERNAME,YEARSSIMU,TLEP_FIRSTDATE,TLEP_FOLLOWUP,SIMUDATA,CREATEBY,CREATEDATE)  
                VALUES ('$drivercode', '$drivername','$yearssimu','$tlep_firstdate','$tlep_followup','$simudata','$createby','$createdate')"; //INSERT DATA

                $result = sqlsrv_query($db, $query);

                // echo $drivercode; echo '<br>';
                // echo $drivername; echo '<br>';
                // echo $yearssimu; echo '<br>';
                // echo $tlep_pass; echo '<br>';
                // echo $simudata; echo '<br>';
                // echo $createby; echo '<br>';
                // echo $createdate; echo '<br>';

                // $output .= '<td>' . $drivercode . '</td>';
                // $output .= '<td>' . $drivername . '</td>';
                // $output .= '<td>' . $yearssimu . '</td>';
                // $output .= '<td>' . $tlep_pass . '</td>';
                // $output .= '<td>' . $simudata . '</td>';
                // $output .= '<td>' . $createby . '</td>';
                // $output .= '<td>' . $createdate . '</td>';
                // $output .= '</tr>';
            }
        }

        // $output .= '</table>';
        if ($result) {
            $output =  '<div class="alert alert-success" role="alert">
            บันทึกข้อมูลสำเร็จ
          </div>';
        } else {
            $output =  '<div class="alert alert-danger" role="alert">
            บันทึกข้อมูลไม่สำเร็จ
          </div>';
        }
    } else {
        $output = '<div class="alert alert-danger" role="alert">
        ไฟล์ไม่ถูกต้อง
      </div>';
    }
}

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
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">


        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        
        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.min.js"></script>
        <link href="style/style.css" rel="stylesheet" type="text/css">

        <style>

            .navbar-default {

            border-color: #ffcb0b;
            }
            #page-wrapper {
            border-left: 1px solid #ffcb0b;
            }
            .container {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            }

            /* Hide the browser's default checkbox */
            .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
            }

            .button {
            display: inline-block;
            padding: 15px 25px;
            font-size: 24px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
            }

            .button:hover {background-color: #3e8e41}

            .button:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(10px);
            }

        </style>
    </head>

    <body >
        <div class="modal fade" id="modal_selecttenko" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-modal-parent="#modal_copydiagram">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">

                    <div id="select_selecttenko"></div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="modal_confrimvehicletransportplan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 80%">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="title"><b>ยืนยันรายการวิ่ง</b></h5>
                    </div>
                    <div class="modal-body">


                        <div id="data_confrimdriving"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">

            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../pages/index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <font style="color:#337ab7 "><?= $result_seEmployee['nameT'] ?></font>
                </li>
                <li class="dropdown">
                    <?php
                    if ($_SESSION["ROLENAME"] != "") {
                        ?>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <?= $_SESSION["ROLENAME"] ?>
                        </a>
                        <?php
                    } else {
                        ?>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            เลือกสิทธิ์เข้าใช้งาน <i class="fa fa-caret-down"></i>
                        </a>
                        <?php
                    }
                    ?>
                    <ul class="dropdown-menu dropdown-user">
                        <?php
                        $query_sePremissions3 = sqlsrv_query($conn, $sql_sePremissions, $params_sePremissions);
                        while ($result_sePremissions3 = sqlsrv_fetch_array($query_sePremissions3, SQLSRV_FETCH_ASSOC)) {
                            ?>
                            <li><a href="" onclick="create_premissions('<?= $result_sePremissions3['ROLEID'] ?>');"><i class="fa fa-user fa-fw"></i> <?= $result_sePremissions3['ROLENAME'] ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>

                <li>
                    <font style="color:#337ab7 "><?= $result_sePremissions["NAME"] ?></font>
                </li>
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
        </nav>


                        


        <div class="row">

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #e7e7e7">
                        <!-- <div class="row">

                            <div class="col-lg-6">

                                <?php
                                $meg = 'อัพโหลดข้อมูล SIMULATOR';


                                echo "<a href='index.php?type=report'>หน้าหลัก</a>  / " . $meg;
                                $link = "<a href='index.php?type=report'>หน้าหลัก</a> ";
                                $_SESSION["link"] = $link;
                                ?>
                            </div>
                           

                            <div class="col-lg-6 text-right">
                                <?= $result_seCompany['Company_NameT'] ?>
                            </div>
                        </div> -->
                    </div>
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-md-2" >&nbsp;</div>
                        </div>
                        <div id="datadef">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    อัพโหลดข้อมูล SIMULATOR <font color="red">* กรุณาตรวจสอบข้อมูลก่อนอัพโหลดข้อมูลใหม่</font>
                                                </div>



                                            </div>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <!-- Nav tabs -->
                                            <!-- <ul class="nav nav-pills">
                                                <li class="active"><a href="#accident" data-toggle="tab" aria-expanded="true">ลงข้อมูลอุบัติเหตุ</a>
                                                </li>
                                                <li><a href="#simulator" data-toggle="tab">ลงข้อมูล SIMULATOR</a>
                                                </li>
                                            </ul> -->
                                            <div class="tab-content">
                                                <div class="row">
                                                        <div class="col-md-12" >
                                                        <form method="post" enctype="multipart/form-data">
                                                            <div class="col-md-3">
                                                                <input type="file" name="excel" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                                                <!-- <button type="submit" name="import" class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">เพิ่ม</button> -->
                                                            </div>
                                                            <div class="col-md-3">
                                                                <button style="height: 35px;width: 100px" type="submit" name="import" class="btn btn-info" type="button" id="inputGroupFileAddon04">เพิ่มข้อมูล</button><font color="red">นามสกุลไฟล์ ที่อนุญาต <b>"xls", "xlsx", "csv"</b></font>
                                                            </div>
                                                            
                                                        </form>
                                                        <br />
                                                        <br />
                                                        <?php
                                                        echo $output;
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12" >&nbsp;</div>
                                                </div>
                                                <div class="tab-pane fade active in" id="accident">
                                                    <div class="row">
                                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                                <div id="datadef">
                                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                        <thead>
                                                                            <tr style="">									
                                                                                <th>ลำดับ</th>
                                                                                <th>รหัสพนักงาน</th>
                                                                                <th>ชื่อพนักงาน</th>
                                                                                <th>อายุพนักงาน</th>
                                                                                <th>TLEP ครั้งแรก</th>
                                                                                <th>TLEP Follow Up</th>
                                                                                <th>T-LEP Years</th>
                                                                                <th>Driving Simulator </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php
                                                                            $i= 1;
                                                                            
                                                                            $sql_seSimulatorData = "SELECT SIMUID,DRIVERCODE,DRIVERNAME,TLEP_FIRSTDATE,TLEP_FOLLOWUP,SIMUDATA
                                                                                FROM SIMULATORHISTORY
                                                                                ORDER BY YEARSSIMU ASC";
                                                                            $params_seSimulatorData = array();
                                                                            $query_seSimulatorData = sqlsrv_query($conn, $sql_seSimulatorData, $params_seSimulatorData);
                                                                            while ($result_seSimulatorData = sqlsrv_fetch_array($query_seSimulatorData, SQLSRV_FETCH_ASSOC)) {

                                                                            $sql_seDriverAge = "SELECT BirthDate103,[yearb],monthb,dayb FROM EMPLOYEEEHR2
                                                                                WHERE PersonCode ='".$result_seSimulatorData['DRIVERCODE']."'";
                                                                            $params_seDriverAge = array();
                                                                            $query_seDriverAge  = sqlsrv_query($conn, $sql_seDriverAge , $params_seDriverAge);
                                                                            $result_seDriverAge  = sqlsrv_fetch_array($query_seDriverAge , SQLSRV_FETCH_ASSOC);
                                                                           
                                                                            
                                                                            //หาระยะเวลา กี่วัน กี่เดือน จากการทำ TLEP FOLLOW UP รูปแบบข้อมูล Y-m-d
                                                                            $followup_date = $result_seSimulatorData['TLEP_FOLLOWUP'];     
                                                                            $today = date("Y-m-d");   //จุดต้องเปลี่ยน

                                                                            // echo "<br>";
                                                                            // echo $today;
                                                                            // echo "<br>";

                                                                            list($byear, $bmonth, $bday)= explode("-",$followup_date);       
                                                                            list($tyear, $tmonth, $tday)= explode("-",$today);                

                                                                            $mfollowup_date = mktime(0, 0, 0, $bmonth, $bday, $byear); 
                                                                            $mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
                                                                            $mage = ($mnow - $mfollowup_date);

                                                                            // echo "วันเกิด $followup_date"."<br>\n";

                                                                            // echo "วันที่ปัจจุบัน $today"."<br>\n";

                                                                            // echo "รับค่า $mage"."<br>\n";

                                                                            $u_y=date("Y", $mage)-1970;
                                                                            $u_m=date("m",$mage);
                                                                            $u_d=date("d",$mage)-1;

                                                                            // echo"<br><br>$u_y   ปี    $u_m เดือน      $u_d  วัน<br><br>";

                                                                            // $sql_seTlepY = "SELECT DATEDIFF(year,'".$result_seSimulatorData['TLEP_FOLLOWUP']."', GETDATE()) AS 'YEARDIFF'
                                                                            //     FROM  [dbo].[SIMULATORHISTORY] 
                                                                            //     WHERE DRIVERCODE = '".$result_seSimulatorData['DRIVERCODE']."'
                                                                            //     --AND YEARSSIMU =  YEAR(GETDATE())";
                                                                            // $params_seTlepY = array();
                                                                            // $query_seTlepY  = sqlsrv_query($conn, $sql_seTlepY , $params_seTlepY);
                                                                            // $result_seTlepY  = sqlsrv_fetch_array($query_seTlepY , SQLSRV_FETCH_ASSOC);

                                                                            // $sql_seTlepM = "SELECT DATEDIFF(month,'".$result_seSimulatorData['TLEP_FOLLOWUP']."', GETDATE()) AS 'MONTHDIFF'
                                                                            //     FROM  [dbo].[SIMULATORHISTORY] 
                                                                            //     WHERE DRIVERCODE = '".$result_seSimulatorData['DRIVERCODE']."'
                                                                            //     --AND YEARSSIMU =  YEAR(GETDATE())";
                                                                            // $params_seTlepM = array();
                                                                            // $query_seTlepM  = sqlsrv_query($conn, $sql_seTlepM , $params_seTlepM);
                                                                            // $result_seTlepM  = sqlsrv_fetch_array($query_seTlepM , SQLSRV_FETCH_ASSOC);
                                                                                                                            

                                                                            ?>

                                                                                <tr>
                                                                                    <td style="text-align: center"><?= $i ?></td>
                                                                                    <td><?= $result_seSimulatorData['DRIVERCODE'] ?></td>
                                                                                    <td><?= $result_seSimulatorData['DRIVERNAME'] ?></td>
                                                                                    <td><b><?= $result_seDriverAge['yearb'] ?></b> Year <b><?= $result_seDriverAge['monthb']?></b> Month </td>
                                                                                    <td><?= $result_seSimulatorData['TLEP_FIRSTDATE'] ?></td>
                                                                                    <td><?= $result_seSimulatorData['TLEP_FOLLOWUP'] ?></td>
                                                                                    <td><b><?= $u_y ?></b> Year   <b><?= $u_m ?></b> Month</td>
                                                                                    <td><?= $result_seSimulatorData['SIMUDATA'] ?></td>
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
                                                    <br>
                                                    
                                             
                                            </div>
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel -->
                                </div>

                            </div>
                        </div>
                        <div id="datasr"></div>
                        <!-- /.panel -->
                    </div>
                </div>
            </div>




        <!--<script src="../vendor/jquery/jquery.min.js"></script>-->
            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../js/jquery.datetimepicker.full.js"></script>

            <script src="../dist/js/jszip.min.js"></script>
            <script src="../dist/js/dataTables.buttons.min.js"></script>
            <script src="../dist/js/buttons.html5.min.js"></script>
            <script src="../dist/js/buttons.print.min.js"></script>
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>   

    </body>
    
                                                                                                    


            <script type="text/javascript"> 
                                                                                                 
            function search_accident(){

            var drivername = document.getElementById('txt_drivernamesearch').value;
            var yearstart = document.getElementById('txt_yearsearchstart').value;
            var yearend = document.getElementById('txt_yearsearchend').value;

            window.open('report_accidenthhistory.php?employeename=' + drivername+'&yearstart='+yearstart+'&yearend='+yearend, '_blank');

            }
            function upload_excelaccident(){

            var type = 'Upload';
            var file = 'Excel';

            window.open('meg_insertaccidentdata.php?type='+type+ '&file='+file, '_blank');

            }
            function upload_excelsimulator(){

            var type = 'Upload Simulator ';
            var file = 'Excel';

            window.open('meg_insertsimulatordata.php?type='+type+ '&file='+file, '_blank');

            }
            function save_accident() //save สำหรับ change สีการนอน
            {

                // alert(chkstatus);
                // alert(checkClient);

                var drivername = document.getElementById('txt_drivernameinsert').value;
                var years  = document.getElementById('txt_selectyearsinsert').value;
                var datetimeacci = document.getElementById('txt_dayaccident').value;
                var locationacci = document.getElementById('txt_locationaccident').value;
                var problemacci  = document.getElementById('txt_problemaccident').value;
                var detailman    = document.getElementById('txt_detailman').value;
                var detailmethod = document.getElementById('txt_detailmethod').value;
                var detailmechine    = document.getElementById('txt_detailmechine').value;
                var detailenvironment = document.getElementById('txt_detailenviroment').value;
                var remark = document.getElementById('txt_remark').value;
                var type = document.getElementById('txt_type').value;
                var createby = document.getElementById('txt_username').value;
                // alert(datejobstart);
                // alert(timejobstart);
                // alert(sessionid);
                // เช็คการลงข้อมูลคอลัมย์ที่1




            $.ajax({
                    type: 'post',
                    url: 'meg_data2.php',
                    data: {

                    txt_flg: "save_accident",
                    id:'', 
                    drivername: drivername,
                    years: years, 
                    datetimeacci: datetimeacci,
                    locationacci: locationacci,
                    problemacci: problemacci,
                    detailman: detailman,
                    detailmethod: detailmethod,
                    detailmechine: detailmechine,
                    detailenvironment: detailenvironment,
                    remark: remark,
                    type: type,
                    createby: createby


                    },
                        success: function (rs) {

                        alert("บันทึกข้อมูลเรียบร้อย");
                        // // alert(rs);    
                        window.location.reload();
                    }
                });

            }         

            function search_simulator(){

                var drivercode = document.getElementById('txt_drivercodesearchsimu').value;
                var yearstart = document.getElementById('txt_yearsearchstartsimu').value;
                var yearend = document.getElementById('txt_yearsearchendsimu').value;

                window.open('report_simulatorhistory.php?employecode=' + drivercode+'&yearstart='+yearstart+'&yearend='+yearend, '_blank');

            }

            function save_simulator() //save สำหรับ change สีการนอน
            {

                // alert(chkstatus);
                // alert(checkClient);

                var drivercode = document.getElementById('txt_drivercodeinsertsimu').value;
                var yearssimu  = document.getElementById('txt_selectyearsinsertsimu').value;
                var tleppass = document.getElementById('txt_tleppass').value;
                var simudata = document.getElementById('txt_simudata').value;
                var createby = document.getElementById('txt_usernamesimu').value;
                
                alert(createby);
                // alert(timejobstart);
                // alert(sessionid);
                // เช็คการลงข้อมูลคอลัมย์ที่1




                $.ajax({
                    type: 'post',
                    url: 'meg_data2.php',
                    data: {

                    txt_flg: "save_simulator",
                    id:'', 
                    drivercode: drivercode,
                    yearssimu: yearssimu, 
                    tleppass: tleppass,
                    simudata: simudata,
                    createby: createby


                    },
                    success: function (response) {
                        if (response) {

                            alert("บันทึกข้อมูลเรียบร้อย");
                            
                        }
                        
                        // // alert(rs);    
                        // window.location.reload();
                       

                    }
                });

            }                                                                                       
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

            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateensimu").datetimepicker({
                    timepicker: false,
                    format: 'Y-m-d', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                });
            });


            </script>
            <script>
                $(document).ready(function () {
                    $('#dataTables-example1').DataTable({
                        responsive: true
                    });
                    $('#dataTables-example2').DataTable({
                        responsive: true
                    });
                });
            </script>

    

</html>
<?php
sqlsrv_close($conn);
?>
