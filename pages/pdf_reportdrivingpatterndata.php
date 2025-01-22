<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
include("../MobileDetect/Mobile_Detect.php");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");


$detect = new Mobile_Detect();
// Check for any mobile device.
if ($detect->isMobile()){
   // mobile content
   $checkClient = 'MB';
}
else {
   // other content for desktops
   $checkClient = 'DT';
}
/////////////////////////////////////////////////////
$employee1 = " AND a.PersonCode = '" .$_SESSION["USERNAME"] . "'";
$sql_seEmp1 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp1 = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($employee1, SQLSRV_PARAM_IN)
);
$query_seEmp1 = sqlsrv_query($conn, $sql_seEmp1, $params_seEmp1);
$result_seEmp1 = sqlsrv_fetch_array($query_seEmp1, SQLSRV_FETCH_ASSOC);

// echo $_SESSION["USERNAME"];
//////////////////////////////////////////////////////

// if ($_GET['type'] == "officercheck") {
//     $checktype = "เจ้าหน้าที่ตรวจสอบข้อมูล";
// }else{
//     $checktype = "พนักงานลงข้อมูล";
// }
// //////////////////////////////////////////////////////

// $checkArea = substr($_GET['employeecode'],0,2);

$sql_seChkDataPlan = "SELECT JOBNO,VEHICLETRANSPORTPLANID,EMPLOYEECODE1,EMPLOYEENAME1,EMPLOYEECODE2,EMPLOYEENAME2,THAINAME,JOBSTART,JOBEND
FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE  CONVERT(DATE,CREATEDATE,103) = CONVERT(DATE,GETDATE(),103)
AND CREATEBY ='".$result_seEmp1['PersonCode']."'";
$params_seChkDataPlan = array();
$query_seChkDataPlan  = sqlsrv_query($conn, $sql_seChkDataPlan, $params_seChkDataPlan);
$result_seChkDataPlan = sqlsrv_fetch_array($query_seChkDataPlan, SQLSRV_FETCH_ASSOC);



$employee2 = " AND a.PersonCode = '" .$result_seChkDataPlan['EMPLOYEECODE2'] . "'";
$sql_seEmp2 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp2 = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($employee2, SQLSRV_PARAM_IN)
);
$query_seEmp2 = sqlsrv_query($conn, $sql_seEmp2, $params_seEmp2);
$result_seEmp2 = sqlsrv_fetch_array($query_seEmp2, SQLSRV_FETCH_ASSOC);

?>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>เอกสารรูปแบบการวิ่งงาน</title>

        
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.min.js"></script>
        <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../dist/js/jquery.autocomplete.js"></script> 
        <link href="../js/bootstrap-datepicker.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
        <!-- <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet"> -->
        <style>
            .navbar-default {

                border-color: #ffcb0b;
            }
            /* #page-wrapper {
                border-left: 1px solid #ffcb0b;
            }
            .popover-content {
                padding: 10px 10px;
                width: 200px;
            } */

            #loading {
                display:none;   
                opacity: 0.5;
                /* border-radius: 50%; */
                /* border-top: 12px ; */
                width: 10px;
                left: 50px;
                right: 850px;
                top:10px;
                bottom: 350px;
                height: 10px;
                
                /* animation: spin 1s linear infinite; */
            }
            .center {
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                margin: auto;
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

            .button1 {
            display: inline-block;
            padding: 15px 25px;
            font-size: 20px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4c8baf;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
            }

            .button1:hover {background-color: #4c8baf}

            .button1:active {
            background-color: #3e568e;
            box-shadow: 0 5px #999;
            transform: translateY(10px);
            }
            /*Self2yes css  */
            /* self2yes > input[type="radio"] {
                display: none;
            }
            self2yes > input[type="radio"] + *::before {
                content: "";
                display: inline-block;
                vertical-align: bottom;
                width: 3rem;
                height: 3rem;
                margin-right: 0.3rem;
                border-radius: 50%;
                border-style: solid;
                border-width: 0.1rem;
                border-color: gray;
            }
            self2yes > input[type="radio"]:checked + *::before {
                background: radial-gradient(teal 0%, teal 40%, transparent 50%, transparent);
                border-color: teal;
            } */

            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                border: 1px solid #000000;
                text-align: left;
                padding: 8px;
            }

            /* tr:nth-child(even) {
                background-color: #dddddd;
            } */

        </style>
    </head>
    <body>

        <!-- <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
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

        <?php 
            // $sql_sePlandata = "SELECT JOBSTART,JOBEND,VEHICLETRANSPORTPLANID FROM VEHICLETRANSPORTPLAN WHERE JOBNO ='".$_GET['jobno']."'";
            // $params_sePlandata = array();
            // $query_sePlandata = sqlsrv_query($conn, $sql_sePlandata, $params_sePlandata);
            // $result_sePlandata = sqlsrv_fetch_array($query_sePlandata, SQLSRV_FETCH_ASSOC);  
            
            
                
            // เช็คข้อมูลล่าสุดของพนักงานในการลงข้อมูลแผนงานขาไป 
            // ถ้า STATUS เป็น inprogess จะไม่สามารถลงข้อมูลใหม่ได้ จนกว่าสถานะจะเป็น complete
        
            $sql_seCheckDataGoPlan = "SELECT TOP 1 DRIVINGPATTERNGO_ID AS 'CHK_ID',DRIVINGPATTERNGO_STATUS AS 'CHK_STATUSGO'  
                FROM [dbo].[DRIVINGPATTERN_GO]
                WHERE CREATEBY_PLANGO ='".$result_seEmp1['PersonCode']."'
                ORDER BY CREATEDATE_PLANGO DESC";
            $params_seCheckDataGoPlan = array();
            $query_seCheckDataGoPlan = sqlsrv_query($conn, $sql_seCheckDataGoPlan, $params_seCheckDataGoPlan);
            $result_seCheckDataGoPlan = sqlsrv_fetch_array($query_seCheckDataGoPlan, SQLSRV_FETCH_ASSOC);

            $sql_seCheckDataReturnPlan = "SELECT TOP 1 DRIVINGPATTERNRETURN_ID AS 'CHK_ID',DRIVINGPATTERNRETURN_STATUS AS 'CHK_STATUSBACK'  
                FROM [dbo].[DRIVINGPATTERN_RETURN]
                WHERE CREATEBY_PLANRETURN ='".$result_seEmp1['PersonCode']."'
                ORDER BY CREATEDATE_PLANRETURN DESC";
            $params_seCheckDataReturnPlan = array();
            $query_seCheckDataReturnPlan = sqlsrv_query($conn, $sql_seCheckDataReturnPlan, $params_seCheckDataReturnPlan);
            $result_seCheckDataReturnPlan = sqlsrv_fetch_array($query_seCheckDataReturnPlan, SQLSRV_FETCH_ASSOC);

        ?>
            <div id="page-wrapper">
                <p>&nbsp;</p>

                <div id="datade_edit">
                    <div class="row" id="list-data">
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12" style="font-size: 30px;text-align: center;">เลือกเมนูที่จะลงข้อมูล</div>
                        <div class="col-lg-4" style="font-size: 30px;text-align: center;">วันที่: <b><?=date("d-m-Y")?></b></div>
                        <div class="col-lg-4" style="font-size: 30px;text-align: center;">ชื่อ-นามสกุล:<b> <?=$result_seEmp1['nameT']?></b></div>
                        <div class="col-lg-4" style="font-size: 30px;text-align: center;">รหัสพนักงาน:<b> <?=$result_seEmp1['PersonCode']?></b></div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12">&nbsp;</div>
                        

                        <?php
                        if ($result_seChkDataPlan['JOBNO'] == '') {
                        ?>  
                            <div class="col-lg-12" style="font-size: 30px;text-align: center;color:red"><b><u>พบข้อผิดพลาดเนื่องจาก</u></b></div>
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-12" style="font-size: 30px;text-align: center;color:red"><b><u>1.ไม่พบข้อมูลการวางแผนงานของพนักงาน</u></b></div>
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-12" style="font-size: 30px;text-align: center;color:red"><b><u>2.พนักงานขับรถคนที่สองไม่สามารถลงข้อมูลเอกสารรูปแบบการวิ่งงานได้</u></b></div>
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-12" style="font-size: 30px;text-align: center;color:red"><b><u>3.พนักงานที่จะลงข้อมูลจะต้องเป็นพนักงานขับรถคนแรกเท่านั้น</u></b></div>
                        <?php
                        }else {
                        ?>
                            <div class = "row" style="height:150px;"></div>
                            <div class="col-lg-12" style="font-size: 30px;text-align: center;">เอกสารรูปแบบการวิ่งงาน Driver (Driving Pattern)</div>
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-12" style="text-align: center;">
                                <b style="font-size: 18px"></b>
                                <?php
                                //  echo $result_seCheckDataGoPlan['CHK_STATUSGO'];   
                                if ($result_seCheckDataGoPlan['CHK_STATUSGO'] == 'inprogess' ) {
                                ?>
                                  &nbsp;<button  class="button" style="width:50%;font-size: 25px;background-color: #f78686;border:solid 2px;color:black"  onclick="alert_goplan('<?=$result_seCheckDataGoPlan['CHK_ID']?>')">แผนขาไป</button>
                                <?php
                                }else{
                                ?>
                                   &nbsp;<button  class="button" style="width:50%;font-size: 25px;background-color: #93f786;border:solid 2px;color:black"  onclick="create_drivingpatternid('GoPlan')">แผนขาไป</button>
                                    
                                <?php
                                }
                                ?>
                                
                            </div>
                            <div class = "col-lg-12" style="height:50px;"></div>
                            <div class="col-lg-12" style="text-align: center;">
                                <b style="font-size: 18px"></b>
                                <?php
                                // echo $result_seCheckDataGoPlan['CHK_STATUS'];   
                                if ($result_seCheckDataReturnPlan['CHK_STATUSBACK'] == 'inprogess'){
                                ?>
                                    &nbsp;<button  class="button" style="width:50%;font-size: 25px;background-color: #f78686;border:solid 2px;color:black"  onclick="alert_backplan('<?=$result_seCheckDataReturnPlan['CHK_ID']?>')">แผนขากลับ</button>
                                    
                                <?php
                                }else{
                                ?>
                                    &nbsp;<button  class="button" style="width:50%;font-size: 25px;background-color: #93f786;border:solid 2px;color:black"  onclick="create_drivingpatternid('BackPlan')">แผนขากลับ</button>
                                <?php
                                }
                                ?>
                                
                            </div>
                        <?php
                        }
                        ?>
                        
                        <div class="col-lg-12">&nbsp;</div>
                    </div>
                </div>

                <!-- START -->
                   

                <!-- END -->


                
                <div id="datasr_edit">

                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        &nbsp;

                    </div>
                </div>
                  
                



            </div>

        </div>
            
        

        
        <!-- this will show our spinner -->
        <div  id="loading" class="center" >
            <p><img style="" src="../images/Truckload5.gif" /></p>
        </div>
        
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script src="../js/bootstrap-datepicker.min.js"></script>
        <script src="../js/bootstrap-datepicker.th.min.js"></script>
        <!-- <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
        <script type="text/javascript">

        

        

            // $(document).ready(function () {
            //     $('#dataTables-exampleshow').DataTable({
            //         responsive: true,
            //     });
            // });


            // function auto_caltimeformobile(){
            //     var checkClient = document.getElementById('txt_clientchk').value;
            //     timesleepselfrestcheck(checkClient);
            //     // alert(checkClient);
                

            // }
            
            // // run the function
            // var chkautofunc = document.getElementById('txt_autocallchk').value;
            // alert(chkautofunc);
            // if(chkautofunc == '1'){
                
            // }else{
            //     document.getElementById('txt_autocallchk').value = '1';
            //     // auto_caltimeformobile();
            // }
            // $(function () {
            //     $('[data-toggle="popover"]').popover({
            //     html: true,
            //         content: function () {
            //             return $('#popover-content').html();
            //         }
            //     });
            // })
            
            function showLoading() {
                $("#loading").show();
            
            }

            function hideLoading() {
                $("#loading").hide();
            }

            function alert_goplan(params) {
                var chkid = params;

                swal.fire({
                    title: "Warning !",
                    html: '<div style="text-align: center;">ข้อมูลรูปแบบการวิ่งงานแผนขาไปล่าสุด ยังไม่ครบสมบูรณ์<br><b>หมายเลขไอดี</b>&nbsp;: '+chkid.bold()+'<br></div>',
                    // text: "ข้อมูลรูปแบบการวิ่งงานล่าสุด ยังไม่ครบถ้วนสมบูรณ์ หมายเลขไอดี",
                    icon: "warning",
                    showConfirmButton: true,
                    allowOutsideClick: false,
                });

                // By Pass Error
                // select_searchDrivingPattern('GoPlan','8','100007')
            }
            function alert_backplan(params) {
                var chkid = params;

                swal.fire({
                    title: "Warning !",
                    html: '<div style="text-align: center;">ข้อมูลรูปแบบการวิ่งงานแผนขากลับล่าสุด ยังไม่ครบสมบูรณ์<br><b>หมายเลขไอดี</b>&nbsp;: '+chkid.bold()+'<br></div>',
                    // text: "ข้อมูลรูปแบบการวิ่งงานล่าสุด ยังไม่ครบถ้วนสมบูรณ์ หมายเลขไอดี",
                    icon: "warning",
                    showConfirmButton: true,
                    allowOutsideClick: false,
                });

                 // By Pass Error
                // select_searchDrivingPattern('BackPlan','8','100007')
            }

            function create_drivingpatternid(checkdata){

                    
                employeecode = '<?=$result_seEmp1['PersonCode']?>';
                // alert(checkdata);

                
                if (checkdata == 'GoPlan') {

                    $.ajax({
                        type: 'post',
                        url: 'meg_data_drivingpattern_driver.php',
                        data: {
                            txt_flg: "create_drivingpatterngoplanid",
                            employeecode:employeecode,
                            condition1:'',
                            condition2:'',
                            condition3:'',
                            condition4:'',
                            condition5:'',
                        },
                        success: function (chkid) {
                            // alert(chkid);
                            select_searchDrivingPattern(checkdata,chkid,employeecode)
                        }
                    }); 

                    // select_searchDrivingPattern(checkdata,chkid,employeecode)
                }else{

                    // select_searchDrivingPattern(checkdata,'16')
                    // alert('back plan');

                    $.ajax({
                        type: 'post',
                        url: 'meg_data_drivingpattern_driver.php',
                        data: {
                            txt_flg: "create_drivingpatternbackplanid",
                            employeecode:employeecode,
                            condition1:'',
                            condition2:'',
                            condition3:'',
                            condition4:'',
                            condition5:'',
                        },
                        success: function (chkid) {
                            // alert(chkid);
                            select_searchDrivingPattern(checkdata,chkid,employeecode)
                        }
                    }); 

                    // select_searchDrivingPattern(checkdata,'2','100007')
                }
                    

                    
            }
            function select_searchDrivingPattern(checkdata,chkid,employeecode){
                // alert(checkdata);
                // showLoading();

                if (checkdata == 'GoPlan') {
                    // alert('Go Plan')
                    
                    window.open('meg_searchDrivingPatternGoPlanDriver.php?drivinggoplanid=' + chkid + '&employeecode1=' + employeecode, '_blank');
                    window.location.reload();

                    // $.ajax({
                    //     type: 'post',
                    //     url: 'meg_searchDrivingPatternGoPlanDriver.php',
                    //     data: {
                    //         truckdata: '',monthnumeric: '',month: '',years:'',goplanid:chkid
                    //     },
                    //     success: function (response) {
                    //         if (response)
                    //         {
                    //             hideLoading();
                    //             swal.fire({
                    //                 title: "Good Job!",
                    //                 text: "โหลดข้อมูลเรียบร้อย",
                    //                 icon: "success",
                    //                 showConfirmButton: true,
                    //                 allowOutsideClick: false,
                    //             });

                    //             document.getElementById("list-data").innerHTML = "";
                    //             document.getElementById("datade_edit").innerHTML = response;
                    //             // $('[data-toggle="popover"]').popover({
                    //             //     html: true,
                    //             //     content: function () {
                    //             //         return $('#popover-content').html();
                    //             //     }

                                    
                    //             // });

                                
                    //         }
                            
                    //         $(function () {
                    //             $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                    //             // กรณีใช้แบบ input
                    //             $(".dateen").datetimepicker({
                    //                 timepicker: true,
                    //                 dateformat: 'Y-m-d' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                    //                 lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                    //                 timeFormat: "HH:mm"

                    //             }
                    //             );
                    //         });


                    //     }
                    // });   

                }else{

                    // alert('Back Plan')
                    window.open('meg_searchDrivingPatternBackPlanDriver.php?drivingbackplanid=' + chkid + '&employeecode1=' + employeecode, '_blank');
                    window.location.reload();

                    // $.ajax({
                    //     type: 'post',
                    //     url: 'meg_searchDrivingPatternBackPlanDriver.php',
                    //     data: {
                    //         truckdata: '',monthnumeric: '',month: '',years:'',backplanid:chkid
                    //     },
                    //     success: function (response) {
                    //         if (response)
                    //         {
                    //             hideLoading();
                    //             swal.fire({
                    //                 title: "Good Job!",
                    //                 text: "โหลดข้อมูลเรียบร้อย",
                    //                 icon: "success",
                    //                 showConfirmButton: true,
                    //                 allowOutsideClick: false,
                    //             });

                    //             document.getElementById("list-data").innerHTML = "";
                    //             document.getElementById("datade_edit").innerHTML = response;
                    //             // $('[data-toggle="popover"]').popover({
                    //             //     html: true,
                    //             //     content: function () {
                    //             //         return $('#popover-content').html();
                    //             //     }

                                    
                    //             // });

                                
                    //         }
                            
                    //         $(function () {
                    //             $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                    //             // กรณีใช้แบบ input
                    //             $(".dateen").datetimepicker({
                    //                 timepicker: true,
                    //                 dateformat: 'Y-m-d' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                    //                 lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                    //                 timeFormat: "HH:mm"

                    //             }
                    //             );
                    //         });


                    //     }
                    // });
       
                }
                
            }   

              
            

            // $(function () {
            //     $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            //     // กรณีใช้แบบ input
            //     $(".dateen").datetimepicker({
            //         timepicker: true,
            //         dateformat: 'Y-m-d' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
            //         lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            //         timeFormat: "HH:mm"

            //     }
            //     );
            // });

            
                
            

        </script>






    </body>

</html>
<?php
sqlsrv_close($conn);
?>