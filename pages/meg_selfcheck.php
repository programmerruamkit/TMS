<!DOCTYPE html>
<!DOCTYPE html>
<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

// echo $_SESSION["USERNAME"];
// if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["PASSWORD"])) {
//     header("location:../pages/meg_login.php?data=3");
// }

// $condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
// $sql_seLogin = "{call megRoleaccount_v2(?,?)}";
// $params_seLogin = array(
//     array('select_roleaccount', SQLSRV_PARAM_IN),
//     array($condition1, SQLSRV_PARAM_IN)
// );
// $query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
// $result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);

// $sql_seSystime = "{call megGetdate_v2(?)}";
// $params_seSystime = array(
//     array('select_getdate', SQLSRV_PARAM_IN)
// );
// $query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
// $result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);

$conditionEHR = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
);
$query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
$result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);
?>

<html lang="en">
    <head>
        <link rel="shortcut icon" href="../images/self_check.ico" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>ใบแจ้งสุขภาพตนเอง</title>
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        <!--<link href="../dist/css/sb-admin-2.css" rel="stylesheet">-->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <style>
            .navbar-default {

                border-color: #ffcb0b;
            }

            .popover-content {
                padding: 10px 10px;
                width: 100px;
            }
            .nav>li>a {
                position: relative;
                display: block;
                padding: 14px 30px;

            }


            .styled-select.slate select {
                border: 1px solid #ccc;
                font-size: 16px;
                height: 34px;
                width: 150px;

            }

        </style>

    </head>
    <body>

        <div id="wrapper">

        <!-- <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        <div class="navbar-header" >
            <button type="button"  class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li><a href="meg_logout.php"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
        </ul>
        </nav> -->
        
            <div id="page-wrapper" >
                <div class="row">&nbsp;</div>
                <div class="row" >
                    <div class="col-lg-12" style="text-align: center">
                        <h2 class="page-header"><u>ใบแจ้งสุขภาพตนเอง</u></h2>
                    </div>

                    <!-- /.col-lg-12 -->
                </div>

                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <div class="row" >
                                    <div class="col-lg-6">

                                        รายงานแผนขนส่ง AMT

                                    </div>
                                    <div class="col-lg-6 text-right"></div>
                                </div>
                            </div> -->

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <div class="row">&nbsp;</div>
                                    <!-- <div class="row" >
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>ค้นหาตามช่วงวันที่</label> <font style="color: red">*</font>
                                                            <input class="form-control dateen" readonly=""  style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>ทะเบียนรถ</label> <font style="color: red">*</font>
                                                            <input type="text" class="form-control "    style="" id="txt_thainame" name="txt_thainame" placeholder="ทะเบียนรถ" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_driverchecking()">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>
                                                    </div>

                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- เงื่อนไขในการเบิก -->
                                    <div class="row" >
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label style="font-size:20px;color:red"><b>ข้อมูลพนักงาน</b></label><br>
                                                            <label style="font-size:16px">&nbsp;ชื่อ-นามสกุล: <?=$result_seEHR['nameT']?> </label><br>
                                                            <label style="font-size:16px">&nbsp;รหัสพนักงาน: <?=$result_seEHR['PersonCode']?> </label><br>
                                                            <label style="font-size:16px">&nbsp;บริษัท: <?=$result_seEHR['Company_NameT']?></label><br>
                                                            <!-- <label style="font-size:16px    ">&nbsp;4.จะเบิกได้ 1 ครั้งต่อสัปดาห์ เท่านั้น</label><br> -->
                                                        </div>
                                                    </div>
                                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                    <h4>ลงข้อมูลใบแจ้งสุขภาพประจำวัน</h4>
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>วันที่</th>
                                                                        <th>รหัสพนักงาน</th>
                                                                        <th>ชื่อ-นามสกุล</th>
                                                                        <th>ลงข้อมูล</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                <?php
                                                               //echo  date("d/m/Y");
                                                               $DATE = date("d/m/Y");
                                                               
                                                               $sql_seCheckData = "SELECT SELFCHECKID AS 'CHKID',FORMAT (CREATEDATE, 'dd/MM/yyyy') AS 'CREATEDATE'
                                                               FROM DRIVERSELFCHECK  
                                                               WHERE EMPLOYEECODE ='".$result_seEHR['PersonCode']."' 
                                                               AND FORMAT (CREATEDATE, 'dd/MM/yyyy') = '".$DATE."'";
                                                               $params_seCheckData = array();
                                                               $query_seCheckData = sqlsrv_query($conn, $sql_seCheckData, $params_seCheckData);
                                                               $result_seCheckData = sqlsrv_fetch_array($query_seCheckData, SQLSRV_FETCH_ASSOC);


                                                               
                                                                ?>
                                                                    <td><?=$DATE?></td>
                                                                    <td><?=$_SESSION['USERNAME']?></td>
                                                                    <td><?=$result_seEHR['nameT']?></td>
                                                                    <!-- <td style="text-align: center;" ><button type="button" class="btn btn-info btn-md" name="myBtn" id ="myBtn" data-toggle="modal" data-target="#myModal" onclick="checking_data('<?= $result_seEHR['PersonCode'] ?>','<?=$result_seEHR['nameT']?>','<?= $result_seData['JOBNO'] ?>','<?= $result_seData['THAINAME'] ?>','<?= $result_seData['DATE'] ?>','<?= $result_seData['TIME'] ?>');" >ลงข้อมูล</button></td> -->
                                                                <!-- <?php
                                                                if (($result_Chkdata['VEHICLETRANSPORTPLANID'] != '') && ($_SESSION["USERNAME"] == $result_Chkdata['EMPLOYEECODE'])) {
                                                                ?>
                                                                <td style="text-align: center;" ><button type="button" class="btn btn-primary" name="myBtn" id ="myBtn" data-toggle="" data-target="" onclick="checking_data2('<?= $result_Chkdata['JOBNO'] ?>','<?=$result_Chkdata['VEHICLETRANSPORTPLANID']?>','<?= $result_Chkdata['CREATEBY'] ?>','<?= $result_Chkdata['DATECREATE'] ?>','<?= $result_Chkdata['TIMECREATE'] ?>');" >ตรวจสอบข้อมูล</button></td>
                                                                <?php
                                                                }else {
                                                                ?>
                                                                <td style="text-align: center;" ><button type="button" class="btn btn-primary" name="myBtn" id ="myBtn" data-toggle="" data-target="" onclick="checking_data1('<?= $result_seEHR['PersonCode'] ?>','<?=$result_seEHR['nameT']?>','<?= $result_seData['JOBNO'] ?>','<?= $result_seData['THAINAME'] ?>','<?= $result_seData['DATE'] ?>','<?= $result_seData['TIME'] ?>');" >ลงข้อมูล</button></td>
                                                                <?php
                                                                }
                                                                ?> -->
                                                                
                                                                <?php
                                                                if ($result_seCheckData['CHKID'] == '') {
                                                                ?>
                                                                <td style="text-align: center;" ><button type="button" class="btn btn-primary" name="myBtn" id ="myBtn" data-toggle="" data-target="" onclick="checking_data1('<?= $_SESSION['USERNAME'] ?>','<?=$result_seEHR['nameT']?>','<?= $DATE ?>');" >ลงข้อมูล</button></td>        
                                                                <?php
                                                                }else {
                                                                ?>
                                                                 <td style="text-align: center;" ><button type="button" class="btn btn-primary" name="myBtn" id ="myBtn" data-toggle="" data-target="" onclick="warning('<?=$result_seCheckData['CHKID']?>','<?=$result_seCheckData['CREATEDATE']?>');" >ลงข้อมูล</button></td>        
                                                                <?php
                                                                }
                                                                
                                                                ?>
                                                                
                                                                </tr>
                                                                
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
                                </div>


                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                </div>
                <!-- /.ro   w -->

            </div>
            

                                                          


            <script src="../vendor/jquery/jquery.min.js"></script>
            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../js/jquery.datetimepicker.full.js"></script>
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>

              <?php
              $thainame = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');
              ?>                                                  

                            
            <script>
                        
                        
                        

                        var txt_thainame = [<?= $thainame ?>];
                            $("#txt_thainame").autocomplete({
                            source: [txt_thainame]
                        });


                        
                        
                        function checking_data(employeecode,employeename,jobno,thainame,date,time)
                        {
                            // alert(employeecode);
                            // alert(jobno);
                            // alert(thainame);

                            $.ajax({
                                type: 'post',
                                url: 'meg_data2.php',
                                data: {
                                    txt_flg: "select_selfcheckingdetail", employeecode: employeecode,employeename: employeename,jobno: jobno,thainame: thainame,date: date,time: time
                                },
                                success: function (response) {
                                    if (response){

                                    document.getElementById("datacompdetailsr").innerHTML = response;
                                    // document.getElementById("datacompdetaildef").innerHTML = "";

                                    }




                                }
                            });
                        }
                        function warning(checkid,createdate)
                        {
                            
                         alert("มีข้อมูลการตรวจสอบตนเองของวันที่ "+createdate+" แล้ว เลขไอดีคือ "+checkid);  
                    
                            
                        }
                        function checking_data1(employeecode,employeename,date)
                        {
                            if (employeecode == '') {
                                alert('ไม่สามารถดำเนินการได้ กรุณาตรวจสอบ รหัสพนักงาน หรือ ชื่อ-นามสกุล');
                            }else{
                                $type = 'insert';
                                window.open('meg_selfcheckdetail.php?employeecode=' + employeecode+'&employeename='+employeename+'&datedriverchk='+date+'&dateworkingchk='+" "+'&datepresentchk='+" "+'&type='+$type, '_blank');
                            }
                            
                        }

                        // function checking_data2(jobno,planid,createby,datecreate,timecreate)
                        // {
                        //     window.open('meg_selfcheckdata.php?jobno=' + jobno+'&vehicletransportplanid='+planid+'&createby='+createby+'&datecreate='+datecreate+'&timecreate='+timecreate, '_blank');
                        // }
                        // function save_data (id){

                        //     alert(id);

                        // }    
                        
                        $(function () {
                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                            // กรณีใช้แบบ input
                            $(".dateen").datetimepicker({
                                timepicker: false,
                                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                            });
                        });
                        $(document).ready(function () {
                            $('#dataTables-example').DataTable({
                                responsive: true,
                            });
                        });

            </script>


    </body>

    




</html>
<?php
sqlsrv_close($conn);
?>
