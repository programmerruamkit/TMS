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

//////////////////////////////////////////////////////

if ($_GET['type'] == "officercheck") {
    $checktype = "เจ้าหน้าที่ตรวจสอบข้อมูล";
}else{
    $checktype = "พนักงานลงข้อมูล";
}
//////////////////////////////////////////////////////

$checkArea = substr($_GET['employeecode'],0,2);


$employee1 = " AND a.PersonCode = '" .$_SESSION["USERNAME"] . "'";
$sql_seEmp1 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp1 = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($employee1, SQLSRV_PARAM_IN)
);
$query_seEmp1 = sqlsrv_query($conn, $sql_seEmp1, $params_seEmp1);
$result_seEmp1 = sqlsrv_fetch_array($query_seEmp1, SQLSRV_FETCH_ASSOC);



// echo $result_seComEmpChk['COMCHK'];
// echo "<br>";
// echo date("Y");
// echo "TLEP_EYE:";
// echo $eyecheck;

//  check ปัญหาสายตาและการสวมแว่นสายตาของ ฝั่ง AMT และ RRC (GW)
// $sql_seEyeproblem = "SELECT TOP 1 TLEP_WEARGLASSES
// FROM  [dbo].[SIMULATORHISTORY] 
// WHERE DRIVERCODE = '".$_GET['employeecode']."'
// ORDER BY TLEP_FOLLOWUP DESC";
// $query_seHealthhistory = sqlsrv_query($conn, $sql_seTlepWearglasses, $params_seTlepWearglasses);
// $result_seHealthhistory = sqlsrv_fetch_array($query_seTlepWearglasses, SQLSRV_FETCH_ASSOC);


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

        
            <div id="page-wrapper">
                <p>&nbsp;</p>

                <div id="datade_edit">
                    <div class="row" id="list-data">
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12"  style="font-size: 25px;text-align: center;">เลือกเมนูที่จะลงข้อมูลสำหรับ<br>พนักงานลงข้อมูลการวิ่งงานจริง</div>
                        <div class="col-lg-4"   style="font-size: 16px;text-align: center;">วันที่: <b><?=date("d-m-Y")?></b></div>
                        <div class="col-lg-4"   style="font-size: 16px;text-align: center;">ชื่อ-นามสกุล:<b> <?=$result_seEmp1['nameT']?></b> </div>
                        <div class="col-lg-4"   style="font-size: 16px;text-align: center;">รหัสพนักงาน:<b> <?=$result_seEmp1['PersonCode']?></b> </div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12" style="font-size: 16px;text-align: center;">เอกสารรูปแบบการวิ่งงาน Actual (Driving Pattern)</div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12" style="text-align: center;">
                            <b style="font-size: 16px"></b>
                            &nbsp;<button class="button" style="width:50%;font-size: 20px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchDrivingPattern('GoActual')">วิ่งจริงขาไป <br>เลขไอดี: <?=$_GET['drivinggoplanid']?></button>
                            <br><br><br>
                            &nbsp;<button class="button" style="width:50%;font-size: 20px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchDrivingPattern('BackActual')">วิ่งจริงขากลับ <br>เลขไอดี: <?=$_GET['drivingbackplanid']?></button>
                        </div>
                        <div class="col-lg-12">&nbsp;</div>
                    </div>

                    




                </div>
                <div id="datasr_edit">

                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        &nbsp;

                    </div>
                </div>
                  
                



            </div>

        </div>
            
        <!-- Modal sleepnormal -->
        <!-- <div class="modal fade" id="modal_tenkosleepnormal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" ><b>ช่วงเวลาการพักผ่อน</b></h5>
                            </div>

                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>เวลาเริ่มพักผ่อน  </label>
                                <input type="text" autocomplete="off"   class="form-control datetimeen" id="txt_startsleepnormal" name="txt_startsleepnormal">

                            </div>
                            <div class="col-lg-6">
                                <label>เวลาตื่นพักผ่อน  </label>
                                <input type="text" autocomplete="off"   class="form-control datetimeen" id="txt_endsleepnormal" name="txt_endsleepnormal">

                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="save_timenormalsleep()">บันทึก</button>
                    </div>




                </div>
            </div>
        </div> -->

        
        <!-- this will show our spinner -->
        <!-- <div  id="loading" class="center" >
            <p><img style="" src="../images/Truckload5.gif" /></p>
        </div> -->
        
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
            function backpage(){
                Swal.fire({
                    title: "ต้องการกลับหน้าหลัก?",
                    text: "",
                    icon: "warning",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "ตกลง",
                    cancelButtonText: "ยกเลิก"
                }).then((result) => {

                    if (result.isConfirmed) {
                        location.reload();
                        // Swal.fire({
                        // title: "Deleted!",
                        // text: "Your file has been deleted.",
                        // icon: "success"
                        // });
                    }

                });
                
            }
            // function showLoading() {
            //     $("#loading").show();
            
            // }

            // function hideLoading() {
            //     $("#loading").hide();
            // }

            function select_searchDrivingPattern(checkdata)
            {
                // alert(checkdata);
                // showLoading();
                var drivinggoplanid     = '<?=$_GET['drivinggoplanid']?>';
                var drivingbackplanid   = '<?=$_GET['drivingbackplanid']?>';
                
                if (checkdata == 'GoActual') {

                    window.open('meg_drivingpattern_godriveractual_insert.php?drivinggoplanid=' + drivinggoplanid, '_blank');

                    // alert('Go Actual officer')
                    // window.open('meg_searchDrivingPatternPlanGoActualOfficer.php?drivinggoplanid=' + drivinggoplanid, '_blank');
                    window.location.reload();
  

                }else{
                    
                    window.open('meg_drivingpattern_backdriveractual_insert.php?drivingbackplanid=' + drivingbackplanid, '_blank');
                    
                    // alert('Back Actual officer')
                    // window.open('meg_searchDrivingPatternPlanBackActualOfficer.php?drivingbackplanid=' + drivingbackplanid, '_blank');
                    window.location.reload();
                  
                }
                

            }                                        
            function datetodate()
            {
                document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

            }   
            // document.getElementById('clear').onclick = function() {

            //     var radio = document.querySelector('input[type=radio][name=selfextrasleep]:checked');
            //     radio.checked = false;
            
            // }
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
                $(".dateen_admin").datetimepicker({
                    timepicker: false,
                    format: 'd/m/Y' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                    lang: 'th' // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                    // timeFormat: "HH:mm"

                }
                );
            });

            function confirm_selfcheck(chkstatus,checkClient,empchkgw)
            {
                    // alert('confirm');
                    var officerconfirm = document.getElementById('txt_officerconfirmhidden').value;
                    var selfcheckid = document.getElementById('txt_selfchkid').value;

                    alert(officerconfirm);
                    alert(selfcheckid);
                    
                    $.ajax({
                    type: 'post',
                    url: 'meg_data2.php',
                    data: {
                        txt_flg: "confirm_selfcheck", selfcheckid: selfcheckid, officerconfirm: officerconfirm
                    },
                    success: function (rs) {
                        // alert("ยืนยันข้อมูลเรียบร้อย");
                        // alert(rs);    
                        // window.location.reload();
                        save_selfcheck(chkstatus,checkClient,empchkgw);
                    }
                });
            }
            //เช็คชั่วโมงการพักผ่อน
            //2021-05-28T20:23
            function timesleepselfrestcheck(checkClient)
            {
                 
                // var startsleepchk = document.getElementById('daysleep_reststart').value;
                // var endsleepchk = document.getElementById('daysleep_restend').value;
                // alert(startsleepchk);
                // alert(endsleepchk);
                // alert("time");

                if (checkClient == 'MB') {
                    var startsleepchk = document.getElementById('daysleep_reststart').value;
                    var endsleepchk = document.getElementById('daysleep_restend').value;
                }else{
                    //START REST
                    var startrestchk = document.getElementById('daysleep_reststart').value;
                    var startrestdata1  = startrestchk.replace(" ","T"); // replave " " เป็น "T"
                    var startrestdata2  = startrestdata1.replace("/","-");
                    var startrestdata3  = startrestdata2.replace("/","-"); // replave "/" เป็น "-"
                    var startsleepchk = startrestdata3;
                    
                    //END REST
                    var endrestchk = document.getElementById('daysleep_restend').value;
                    var endrestdata1  = endrestchk.replace(" ","T"); // replave " " เป็น "T"
                    var endrestdata2  = endrestdata1.replace("/","-");// replave "/" เป็น "-"
                    var endrestdata3  = endrestdata2.replace("/","-");
                    var endsleepchk = endrestdata3;
                    
                    // alert(startsleepchk);
                    // alert(endsleepchk);
                }
           
                $.ajax({
                    type: 'post',
                    url: 'meg_data2.php',
                    data: {
                        txt_flg: "select_resttimeselfcheck", startsleep: startsleepchk, endsleep: endsleepchk
                    },
                    success: function (rs) {
                        // alert(rs);
                        
                        document.getElementById('timesleep_rest').value = rs;
                        save_selfcheckbefore('save',checkClient);
                    }
                });
            
            }

            function  save_keydroptimebyofficer(selfchkid,dsreststartchk,employeecode){
                // alert(selfchkid);
                // alert(dsreststartchk);
                // alert(employeecode);

                $.ajax({
                    type: 'post',
                    url: 'meg_data2.php',
                    data: {
                        txt_flg: "update_keydroptimebyofficer", selfchkid: selfchkid, dsreststartchk: dsreststartchk,employeecode,employeecode
                    },
                    success: function (rs) {
                        // alert(rs);
                        
                        // document.getElementById('timesleep_rest').value = rs;
                        // save_selfcheckbefore('save',checkClient);
                    }
                });
            }
            
            //เช็คชั่วโมงการนอนปกติ
            function timesleepselfnormalcheck(checkClient)
            {
                // var startsleepchk = document.getElementById('daysleep_normalstart').value;
                // var endsleepchk = document.getElementById('daysleep_normalend').value;
                // alert(startsleepchk);
                // alert(endsleepchk);
                if (checkClient == 'MB') {
                    var startsleepchk = document.getElementById('daysleep_normalstart').value;
                    var endsleepchk = document.getElementById('daysleep_normalend').value;
                }else{
                    //START NORMAL
                    var startrestchk = document.getElementById('daysleep_normalstart').value;
                    var startrestdata1  = startrestchk.replace(" ","T"); // replave " " เป็น "T"
                    var startrestdata2  = startrestdata1.replace("/","-");
                    var startrestdata3  = startrestdata2.replace("/","-"); // replave "/" เป็น "-"
                    var startsleepchk = startrestdata3;
                    
                    //END NORMAL
                    var endrestchk = document.getElementById('daysleep_normalend').value;
                    var endrestdata1  = endrestchk.replace(" ","T"); // replave " " เป็น "T"
                    var endrestdata2  = endrestdata1.replace("/","-");// replave "/" เป็น "-"
                    var endrestdata3  = endrestdata2.replace("/","-");
                    var endsleepchk = endrestdata3;
                    // alert('normal');
                    // alert(startsleepchk);
                    // alert(endsleepchk);
                }

                if (startsleepchk == '') {
                    
                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้ลงข้อมูลเวลาเริ่มนอน(นอนปกติ)",
                        icon: "warning",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });

                }else if(endsleepchk == ''){

                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้ลงข้อมูลเวลาตื่นนอน(นอนปกติ)",
                        icon: "warning",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });

                }else {

                    // alert('cal normal');
                    
                    $.ajax({
                        type: 'post',
                        url: 'meg_data2.php',
                        data: {
                            txt_flg: "select_resttimeselfcheck", startsleep: startsleepchk, endsleep: endsleepchk
                        },
                        success: function (rs) {
                            
                            // alert(rs);
                            
                            let text = rs;
                            
                            // split เครื่องหมาย : และ เก็บค่านาทีเข้า array
                            let result = text.split(':');
                            let [first,second] = result;
                            // alert(second);
                            
                            // เอาค่าของ array ตำแหน่งที่ 2 มา trim และนับ lenght 
                            let trimtext = second.trim();
                            let chklength = trimtext.length;
                            // alert(chklength);
                    
                        
                            // นับ lenght ของตัวอักษรจากการ trim 
                            // ถ้าตำแหน่งเป็น 1 คือ นาทีเป็น 1 ตำแหน่งเช่่น 0:4,14:4 ให้ replace เครื่องหมาย : เป็น :0
                            if (chklength == '1') {
                                // check len
                                // alert('chklength = 1')  
                                var replacetext = text.replace(":", ":0");
                                // alert(replacetext);

                            }else{
                                // ถ้าตำแหน่ง !=1 ไม่ต้อง replace ค่าของนาที
                                // alert('chklength other')  
                                var replacetext = text;
                                // alert(replacetext); 
                            }

                            // alert(replacetext); 

                            let result1 =  text.substring(0, 2);
                            let replace1 = result1.replace(":", " ");

                            let result2 =  text.substring(3, 5);
                            let replace2 = result2.replace(":", " ");

                            // alert(replace1);
                            // alert(replace2);

                            if (replace1 == 0) {

                                document.getElementById("timesleep_normal").style.backgroundColor = "#94FA67";
                                document.getElementById('timesleep_normal').value = replacetext;
                                // save_timeworking1(selfcheckid,replacetext,'OK');
                                // alert('1');

                            }else if ((replace1 > 0 && replace1 >= 6)) {
                                // alert('2');
                                document.getElementById("timesleep_normal").style.backgroundColor = "#94FA67";
                                document.getElementById('timesleep_normal').value = replacetext;
                                // save_timeworking1(selfcheckid,replacetext,'OK');

                            

                            }else if (replace1 == 6) {
                            

                                // document.getElementById("timeworking1").style.backgroundColor = "#94FA67";
                                // document.getElementById('timeworking1').value = text;
                                // save_timeworking1(selfcheckid,text);

                                if (replace2 <= 0) {
                                    //  #94FA67 สีเขียว
                                    document.getElementById("timesleep_normal").style.backgroundColor = "#94FA67";
                                    document.getElementById('timesleep_normal').value = replacetext;
                                    // save_timeworking1(selfcheckid,replacetext,'OK');
                                    // alert('3');
                                }else{
                                    //  #FA6767 สีเแดง
                                    document.getElementById("timesleep_normal").style.backgroundColor = "#FA6767";
                                    document.getElementById('timesleep_normal').value = replacetext;
                                    // save_timeworking1(selfcheckid,replacetext,'NG');
                                    // alert('4');
                                }
                            

                            }else{
                                //  #FA6767 สีเแดง
                                document.getElementById("timesleep_normal").style.backgroundColor = "#FA6767";
                                document.getElementById('timesleep_normal').value = replacetext;
                                // save_timeworking1(selfcheckid,replacetext,'NG');
                                // alert('5');

                            }

                            // document.getElementById('timesleep_normal').value = rs;
                            
                            // ระบบจะ save selfcheck ด้วย
                            save_selfcheckbefore('save');
                        }
                    });
                }

                


            }
            //เช็คชั่วโมงการนอนเพิ่มเติม
            function timesleepselfextracheck(checkClient)
            {
                // var startsleepchk = document.getElementById('daysleep_extrastart').value;
                // var endsleepchk = document.getElementById('daysleep_extraend').value;
                // alert(startsleepchk);
                // alert(endsleepchk);
                if (checkClient == 'MB') {
                    var startsleepchk = document.getElementById('daysleep_extrastart').value;
                    var endsleepchk = document.getElementById('daysleep_extraend').value;
                }else{
                    //START EXTRA
                    var startrestchk = document.getElementById('daysleep_extrastart').value;
                    var startrestdata1  = startrestchk.replace(" ","T"); // replave " " เป็น "T"
                    var startrestdata2  = startrestdata1.replace("/","-");
                    var startrestdata3  = startrestdata2.replace("/","-"); // replave "/" เป็น "-"
                    var startsleepchk = startrestdata3;
                    
                    //END EXTRA
                    var endrestchk = document.getElementById('daysleep_extraend').value;
                    var endrestdata1  = endrestchk.replace(" ","T"); // replave " " เป็น "T"
                    var endrestdata2  = endrestdata1.replace("/","-");// replave "/" เป็น "-"
                    var endrestdata3  = endrestdata2.replace("/","-");
                    var endsleepchk = endrestdata3;
                    // alert('extra');
                    // alert(startsleepchk);
                    // alert(endsleepchk);
                }

                if (startsleepchk == '') {
                    
                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้ลงข้อมูลเวลาเริ่มพักผ่อน(กะกลางคืน)",
                        icon: "warning",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });

                }else if(endsleepchk == ''){

                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้ลงข้อมูลเวลาตื่นพักผ่อน(กะกลางคืน)",
                        icon: "warning",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });

                }else {

                    $.ajax({
                        type: 'post',
                        url: 'meg_data2.php',
                        data: {
                            txt_flg: "select_resttimeselfcheck", startsleep: startsleepchk, endsleep: endsleepchk
                        },
                        success: function (rs) {
                            
                            document.getElementById('timesleep_extra').value = rs;
                            save_selfcheckbefore('save');
                        }
                    });

                }
                
                


            }

            
            // save สำหรับ change สีการนอน
            // save สำหรับ ปุ่มคำนวณเวลา
            function save_selfcheckbefore(chkstatus,checkClient) 
            {
                    
                    // alert(chkstatus);
                    // alert(checkClient);
                    
                    var datejobstart = document.getElementById('txt_datedriverchk').value;
                    var dateworking  = document.getElementById('txt_dateworkingchk').value;
                    var datepresent  = document.getElementById('txt_datepresentchk').value;
                    var employeecode = document.getElementById('txt_empcode').value;
                    var employeename = document.getElementById('txt_empname').value;
                    var sessionid    = document.getElementById('txt_selfsession').value;
                    // alert(datejobstart);
                    // alert(timejobstart);
                    // alert(sessionid);
                    // เช็คการลงข้อมูลคอลัมย์ที่1
                    var self1yeschk = "";
                    var self1nochk = "";
                    var self2yeschk = "";
                    var self2nochk = "";
                    var self3yeschk = "";
                    var self3nochk = "";
                    var self4yeschk = "";
                    var self4nochk = "";
                    var self5yeschk = "";
                    var self5nochk = "";
                    var selfallyeschk = "";
                    var selfallnochk = "";
                    
                    //ประเมิณอาการเหนื่อยล้า
                    if($("#self1yes").is(':checked') || $("#self1no").is(':checked') ){
                        //alert("yes");
                         if($("#self1yes").is(':checked')){
                            self1yeschk = '1';
                            //alert('มีอาการเหนื่อยล้า');
                            //alert(self1yeschk);
                        } else {
                            self1nochk = '1';
                            //alert(self1nochk);
                            //alert('ไม่มีอาการเหนื่อยล้า');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'อาการเหนื่อยล้า'");

                    }
                    
                    //ประเมิณอาการเจ็บป่วย
                    if($("#self2yes").is(':checked') || $("#self2no").is(':checked') ){
                        //alert("yes");
                         if($("#self2yes").is(':checked')){
                            self2yeschk = '1';
                            //alert('มีอาการเจ็บป่วย');
                        } else {
                            self2nochk = '1';
                            //alert('ไม่มีอาการเจ็บป่วย');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'อาการเจ็บป่วย'");

                    }

                    //ประเมิณอาการง่วงนอน
                    if($("#self3yes").is(':checked') || $("#self3no").is(':checked') ){
                        //alert("yes");
                         if($("#self3yes").is(':checked')){
                            self3yeschk = '1';
                            //alert('มีอาการง่วงนอน');
                        } else {
                            self3nochk = '1';
                            //alert('ไม่มีอาการง่วงนอน');
                        }
                    }else{
                       // alert("ยังไม่ได้ประเมิน 'อาการง่วงนอน'");

                    }

                    //ประเมิณอาการบาดเจ็บ
                    if($("#self4yes").is(':checked') || $("#self4no").is(':checked') ){
                        //("yes");
                         if($("#self4yes").is(':checked')){
                            self4yeschk = '1';
                            //('มีอาการบาดเจ็บ');
                            
                        } else {
                            self4nochk = '1';
                            //alert('ไม่มีอาการบาดเจ็บ');
                           
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'อาการบาดเจ็บ'");

                    }

                    //ประเมิณทานยาที่มีผลต่อการขับขี่
                    if($("#self5yes").is(':checked') || $("#self5no").is(':checked') ){
                        //alert("yes");
                         if($("#self5yes").is(':checked')){
                            self5yeschk = '1';
                            //alert('ทานยาที่มีผลต่อการขับขี่');
                            // alert(self5yeschk);
                            // alert('ทานยา');
                        } else {
                            self5nochk = '1';
                            //alert('ไม่ทานยาที่มีผลต่อการขับขี่');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'ทานยาที่มีผลต่อการขับขี่'");

                    }

                    //ประเมิณสภาพร่างกาย
                    if($("#selfallyes").is(':checked') || $("#selfallno").is(':checked') ){
                        //alert("yes");
                         if($("#selfallyes").is(':checked')){
                            selfallyeschk = '1';
                            //alert('สภาพร่างกายปกติ');
                        } else {
                            selfallnochk = '1';
                            //alert('สภาพร่างกายไม่ปกติ');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'สภาพร่างกาย'");

                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่2 เวลาพักผ่อน 8 ชั่วโมง
                    // var dsreststart = document.getElementById('daysleep_reststart').value;
                    // var dsrestend = document.getElementById('daysleep_restend').value;
                    // var tsrest = document.getElementById('timesleep_rest').value;
                    
                    if (checkClient == 'MB') {
                        var dsreststart = document.getElementById('daysleep_reststart').value;
                        var dsrestend = document.getElementById('daysleep_restend').value;
                        var tsrest = document.getElementById('timesleep_rest').value;
                    }else{
                        // alert('else');
                        //START REST
                        var startrestchk = document.getElementById('daysleep_reststart').value;
                        var startrestdata1  = startrestchk.replace(" ","T"); // replave " " เป็น "T"
                        var startrestdata2  = startrestdata1.replace("/","-");
                        var startrestdata3  = startrestdata2.replace("/","-"); // replave "/" เป็น "-"
                        var dsreststart = startrestdata3;
                        
                        //END REST
                        var endrestchk = document.getElementById('daysleep_restend').value;
                        var endrestdata1  = endrestchk.replace(" ","T"); // replave " " เป็น "T"
                        var endrestdata2  = endrestdata1.replace("/","-");// replave "/" เป็น "-"
                        var endrestdata3  = endrestdata2.replace("/","-");
                        var dsrestend = endrestdata3;
                        
                        var tsrest = document.getElementById('timesleep_rest').value;
                        
                        // alert(dsreststart);
                        // alert(dsrestend);
                    }

                    //date rest start
                    if (dsreststart == '') {
                        dsreststartchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาเริ่มพักผ่อน(8 ชั่วโมง)');
                    }else{
                        dsreststartchk = dsreststart;
                        //alert(dsnormalstartchk);
                    }
                    
                    //date rest end
                    if (dsrestend == '') {
                        dsrestendchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาตื่นพักผ่อน(8 ชั่วโมง)');
                    }else{
                        dsrestendchk = dsrestend;
                        //alert(dsrestendchk);
                    }

                    //time sleep rest 
                    if (tsrest == '') {
                        tsrestchk = "";
                        //alert('ยังไม่ได้ลงระยะเวลาที่พักผ่อน(8 ชั่วโมง)');
                    }else{
                        tsrestchk = tsrest;
                        //alert(tsrestchk);
                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่3 เวลาการนอนปกติ
                    // var dsnormalstart = document.getElementById('daysleep_normalstart').value;
                    // var dsnormalend = document.getElementById('daysleep_normalend').value;
                    // var tsnormal = document.getElementById('timesleep_normal').value;
                    var selfsleepnormalyeschk = "";
                    var selfsleepnormalnochk = "";

                    if (checkClient == 'MB') {
                        var dsnormalstart = document.getElementById('daysleep_normalstart').value;
                        var dsnormalend = document.getElementById('daysleep_normalend').value;
                        var tsnormal = document.getElementById('timesleep_normal').value;
                    }else{
                        // alert('else');
                        //START NORMALSLEEP
                        var startnormalchk = document.getElementById('daysleep_normalstart').value;
                        var startnormaldata1  = startnormalchk.replace(" ","T"); // replave " " เป็น "T"
                        var startnormaldata2  = startnormaldata1.replace("/","-");
                        var startnormaldata3  = startnormaldata2.replace("/","-"); // replave "/" เป็น "-"
                        var dsnormalstart = startnormaldata3;
                        
                        //END NORMALSLEEP
                        var endnormalchk = document.getElementById('daysleep_normalend').value;
                        var endnormaldata1  = endnormalchk.replace(" ","T"); // replave " " เป็น "T"
                        var endnormaldata2  = endnormaldata1.replace("/","-");// replave "/" เป็น "-"
                        var endnormaldata3  = endnormaldata2.replace("/","-");
                        var dsnormalend = endnormaldata3;
                        
                        var tsnormal = document.getElementById('timesleep_normal').value;
                        
                        // alert(dsnormalstart);
                        // alert(dsnormalend);
                    }
                    
                    //date normal start
                    if (dsnormalstart == '') {
                        dsnormalstartchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาเริ่มพักผ่อน(ปกติ)');
                    }else{
                        dsnormalstartchk = dsnormalstart;
                        //alert(dsnormalstartchk);
                    }
                    
                    //date normal end
                    if (dsnormalend == '') {
                        dsnormalendchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาตื่นพักผ่อน(ปกติ)');
                    }else{
                        dsnormalendchk = dsnormalend;
                        //alert(dsnormalendchk);
                    }

                    //time sleep normal 
                    if (tsnormal == '') {
                        tsnormalchk = "";
                        //alert('ยังไม่ได้ลงระยะเวลาที่นอน(ปกติ)');
                    }else{
                        tsnormalchk = tsnormal;
                        //alert(tsnormalchk);
                    }

                    //ประเมินการนอนปกติ
                    if($("#selfnormalsleepyes").is(':checked') || $("#selfnormalsleepno").is(':checked') ){
                        //alert("yes");
                         if($("#selfnormalsleepyes").is(':checked')){
                            selfsleepnormalyeschk = '1';
                            //alert('การนอนปกติ(หลับสนิท)');
                        } else {
                            selfsleepnormalnochk = '1';
                            //alert('การนอนปกติ(หลับไม่สนิท)');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'การนอนปกติ'");

                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่3 เวลาการนอนเพิ่มเติม
                    // var dsextrastart = document.getElementById('daysleep_extrastart').value;
                    // var dsextraend = document.getElementById('daysleep_extraend').value;
                    // var tsextra = document.getElementById('timesleep_extra').value;
                    var selfsleepextrayeschk = "";
                    var selfsleepextranochk = "";
                    
                    if (checkClient == 'MB') {
                        var dsextrastart = document.getElementById('daysleep_extrastart').value;
                        var dsextraend = document.getElementById('daysleep_extraend').value;
                        var tsextra = document.getElementById('timesleep_extra').value;
                    }else{
                        // alert('else');
                        //START NORMALSLEEP
                        var startextrachk = document.getElementById('daysleep_extrastart').value;
                        var startextradata1  = startextrachk.replace(" ","T"); // replave " " เป็น "T"
                        var startextradata2  = startextradata1.replace("/","-");
                        var startextradata3  = startextradata2.replace("/","-"); // replave "/" เป็น "-"
                        var dsextrastart = startextradata3;

                        //END NORMALSLEEP
                        var endextrachk = document.getElementById('daysleep_extraend').value;
                        var endextradata1  = endextrachk.replace(" ","T"); // replave " " เป็น "T"
                        var endextradata2  = endextradata1.replace("/","-");// replave "/" เป็น "-"
                        var endextradata3  = endextradata2.replace("/","-");
                        var dsextraend = endextradata3;
                        
                        var tsextra = document.getElementById('timesleep_extra').value;
                        
                        // alert(dsextrastart);
                        // alert(dsextraend);
                    }

                    //date extra start
                    if (dsextrastart == '') {
                        dsextrastartchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาเริ่มพักผ่อน(กะกลางคืน)');
                    }else{
                        dsextrastartchk = dsextrastart;
                        //alert(dsextrastartchk);
                    }
                    
                    //date extra end
                    if (dsextraend == '') {
                        dsextraendchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาตื่นพักผ่อน(กะกลางคืน)');
                    }else{
                        dsextraendchk = dsextraend;
                        //alert(dsextraendchk);
                    }

                    //time sleep extra 
                    if (tsextra == '') {
                        tsextrachk = "";
                        //alert('ยังไม่ได้ลงระยะเวลาที่นอน(กะกลางคืน)');
                    }else{
                        tsextrachk = tsextra;
                        //alert(tsextrachk);
                    }

                    //ประเมินการนอนเพิ่ม
                    if($("#selfextrasleepyes").is(':checked') || $("#selfextrasleepno").is(':checked') ){
                        //alert("yes");
                         if($("#selfextrasleepyes").is(':checked')){
                            selfsleepextrayeschk = '1';
                            //alert('การนอนกะกลางคืน(หลับสนิท)');
                        } else {
                            selfsleepextranochk = '1';
                            //alert('การนอนกะกลางคืน(หลับไม่สนิท)');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'การนอนกะกลางคืน'");

                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่4
                    var disease = document.getElementById('disease').value;
                    var drugname = document.getElementById('drug_name').value;
                    var drugtime = document.getElementById('drug_time').value;
                    var selfdoctoryeschk = "";
                    var selfdoctornochk = "";
                    //อาการป่วย

                    //date extra start
                    if (disease == '') {
                        diseasechk = "";
                        //alert('ยังไม่ได้ลงข้อมูลโรค');
                    }else{
                        diseasechk = disease;
                        //alert(diseasechk);
                    }

                    //ประเมินการพบหมอ
                    if($("#selfdoctoryes").is(':checked') || $("#selfdoctorno").is(':checked') ){
                        //alert("yes");
                         if($("#selfdoctoryes").is(':checked')){
                            selfdoctoryeschk = '1';
                            //alert('พบหมอ');
                        } else {
                            selfdoctornochk = '1';
                            //alert('ไม่ได้พบหมอ');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'พบหมอ'");

                    }

                    //drug name
                    if (drugname == '') {
                        drugnamechk = "";
                        //alert('ยังไม่ได้ลงข้อมูลชื่อยา');
                    }else{
                        drugnamechk = drugname;
                        //alert(drugnamechk);
                    }

                    // //time sleep extra 
                    drugtimechk = drugtime;
                    //alert(drugtimechk);
                    
                    // if (drugtime == '') {
                    //     drugtimechk = "";
                    //     alert('ยังไม่ได้ลงเวลาทานยา');
                    // }else{
                    //     drugtimechk = drugtime;
                    //     alert(drugtimechk);
                    // }

                    
                    // เช็คการลงข้อมูลคอลัมย์ที่5
                    var selfworryyeschk = "";
                    var selfworrynochk = "";
                    var selfhouseholdyeschk = "";
                    var selfhouseholdnochk = "";

                    //ประเมินเรื่องกังวลใจ / การใช้เวลาช่วงพักผ่อน
                    //เรื่องกังวลใจ
                    if($("#selfworryyes").is(':checked') || $("#selfworryno").is(':checked') ){
                        //alert("yes");
                         if($("#selfworryyes").is(':checked')){
                            selfworryyeschk = '1';
                            //alert('มีเรื่องกังวลใจ');
                        } else {
                            selfworrynochk = '1';
                            //alert('ไม่มีเรื่องกังวลใจ');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'เรื่องกังวลใจ'");

                    }
                    // การใช้เวลาช่วงพักผ่อน
                    if($("#selfhouseholdyes").is(':checked') || $("#selfhouseholdno").is(':checked') ){
                       // alert("yes");
                         if($("#selfhouseholdyes").is(':checked')){
                            selfhouseholdyeschk = '1';
                            //alert('ใช้ช่วงเวลาพักผ่อนในบ้าน');
                        } else {
                            selfhouseholdnochk = '1';
                            //alert('ใช้ช่วงเวลาพักผ่อนนอกบ้าน');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'การใช้ช่วงเวลาพักผ่อน'");

                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่6
                    var tempchk = document.getElementById('temperature').value;
                    var syschk1 = document.getElementById('sys_value1').value;
                    var syschk2 = document.getElementById('sys_value2').value;
                    var syschk3 = document.getElementById('sys_value3').value;
                    var diachk1 = document.getElementById('dia_value1').value;
                    var diachk2 = document.getElementById('dia_value2').value;
                    var diachk3 = document.getElementById('dia_value3').value;
                    var pulsechk1 = document.getElementById('pulse_value1').value;
                    var pulsechk2 = document.getElementById('pulse_value2').value;
                    var pulsechk3 = document.getElementById('pulse_value3').value;
                    var oxygenchk = document.getElementById('oxygen_value').value;
                    
                    //ประเมินอุณภูมิ ความดันบน ความดันล่าง
                    
                    // //ประเมินอุณภูมิ 
                    // if (temp == '') {
                    //     tempchk = "";
                    //     alert('ยังไม่ได้ลงข้อมูลอุณภูมิ');
                    // }else{
                    //     tempchk = temp;
                    //     //alert(tempchk);
                    // }

                    // //ความดันบน ความดันล่าง
                    // if (sys == '') {
                    //     syschk = "";
                    //     alert('ยังไม่ได้ลงข้อมูลความดันบน');
                    // }else{
                    //     syschk = sys;
                    //     //alert(syschk);
                    // }

                    // //ความดันล่าง
                    // if (dia == '') {
                    //     diachk = "";
                    //     alert('ยังไม่ได้ลงข้อมูลความดันล่าง');
                    // }else{
                    //     diachk = dia;
                    //     //alert(diachk);
                    // }
                    
                    // เช็คการลงข้อมูลคอลัมย์ที่7
                    var selfeyeproblemyeschk    = "";
                    var selfeyeproblemnochk     = "";
                    var selfeyeglassesyeschk    = "";
                    var selfeyeglassesnochk     = "";
                    var selfcarryeyeglassesyeschk  = "";
                    var selfcarryeyeglassesnochk   = "";
                    var selfcarryhearingaidyeschk  = "";
                    var selfcarryhearingaidnochk   = "";

                    //ปัญหาสายตา/แว่นสายตา
                    //ปัญหาสายตา
                    if($("#selfeyeproblemyes").is(':checked') || $("#selfeyeproblemno").is(':checked') ){
                        //alert("yes");
                         if($("#selfeyeproblemyes").is(':checked')){
                            selfeyeproblemyeschk = '1';
                            //alert(',มีปัญหาสายตา');
                        } else {
                            selfeyeproblemnochk = '1';
                            //alert('ไม่มีปัญหาสายตา');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'ปัญหาสายตา'");

                    }    
                    // แว่นสายตา
                    if($("#selfeyeglassesyes").is(':checked') || $("#selfeyeglassesno").is(':checked') ){
                       // alert("yes");
                         if($("#selfeyeglassesyes").is(':checked')){
                            selfeyeglassesyeschk = '1';
                            //alert('มีแว่นสายตา');
                        } else {
                            selfeyeglassesnochk = '1';
                            //alert('ไม่มีแว่นสายตา');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'แว่นสายตา'");

                    }
                    // พกพาแว่นสายตา
                    if($("#selfcarryeyeglassesyes").is(':checked') || $("#selfcarryeyeglassesno").is(':checked') ){
                       // alert("yes");
                         if($("#selfcarryeyeglassesyes").is(':checked')){
                            selfcarryeyeglassesyeschk = '1';
                            //alert('มีแว่นสายตา');
                        } else {
                            selfcarryeyeglassesnochk = '1';
                            //alert('ไม่มีแว่นสายตา');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'แว่นสายตา'");

                    }
                    // สวมใส่เครื่องช่วยฟัง
                    if($("#selfcarryhearingaidyes").is(':checked') || $("#selfcarryhearingaidno").is(':checked') ){
                       // alert("yes");
                         if($("#selfcarryhearingaidyes").is(':checked')){
                            selfcarryhearingaidyeschk = '1';
                            //alert('มีแว่นสายตา');
                        } else {
                            selfcarryhearingaidnochk = '1';
                            //alert('ไม่มีแว่นสายตา');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'แว่นสายตา'");

                    }
                    
                    // เช็คการลงข้อมูลคอลัมย์ที่8
                    var alcoholtype = document.getElementById('alcohol_type').value;
                    var alcoholtime = document.getElementById('alcohol_time').value;
                    var alcoholvolume = document.getElementById('alcohol_volume').value;
                    //ประเมินแอลกอฮอล์ เวลาเลิก ปริมาณ

                    // alert(alcoholvolume);

                    //ประเมินแอลกอฮอล์ 
                    if (alcoholtype == '') {
                        alcoholtypechk = "";
                        //alert('ยังไม่ได้ลงข้อมูลแอลกอฮอล์');
                    }else{
                        alcoholtypechk = alcoholtype;
                        //alert(alcoholtypechk);
                    }

                    //เวลาเลิก
                    alcoholtimechk = alcoholtime;
                    //alert(alcoholtimechk);
                    // if (alcoholtime == '') {
                    //     alcoholtimechk = "";
                    //     alert('ยังไม่ได้ลงข้อมูลเวลาเลิก');
                    // }else{
                    //     alcoholtimechk = alcoholtime;
                    //     alert(alcoholtimechk);
                    // }

                    //ปริมาณ
                    if (alcoholvolume == '') {
                        alcoholvolumechk = "";
                        // alert('ยังไม่ได้ลงข้อมูลปริมาณแอลกอฮอล์');
                    }else{
                        alcoholvolumechk = alcoholvolume;
                        // alert(alcoholvolumechk);
                    }

                    

                    var selfchkid = document.getElementById('txt_selfchkid').value
                    //save_selfcheckbefore

                    if (selfchkid != '') {
                        // alert('update');
                        
                        $.ajax({
                        type: 'post',
                        url: 'meg_data2.php',
                        data: {
                            
                            txt_flg: "update_selfcheckdetail",
                            id:selfchkid, 
                            employeecode: employeecode,
                            employeename: employeename, 
                            datejobstart: datejobstart,
                            dateworking: dateworking,
                            datepresent: datepresent,
                            tierdyeschk: self1yeschk,
                            tierdnochk: self1nochk,
                            illnessyeschk: self2yeschk,
                            illnessnochk: self2nochk,
                            drowseyeschk: self3yeschk,
                            drowsenochk: self3nochk,
                            injuryyeschk: self4yeschk,
                            injurynochk: self4nochk,
                            takemedicineyeschk: self5yeschk,
                            takemedicinenochk: self5nochk, 
                            healthyyeschk: selfallyeschk, 
                            healthynochk: selfallnochk,
                            sleepreststart: dsreststartchk,
                            sleeprestend: dsrestendchk,
                            timesleeprest: tsrestchk,
                            sleepnormalstart: dsnormalstartchk,
                            sleepnormalend: dsnormalendchk,
                            timesleepnormal: tsnormalchk,
                            sleepnormalyes: selfsleepnormalyeschk,
                            sleepnormalno: selfsleepnormalnochk,
                            sleepextrastart: dsextrastartchk,
                            sleepextraend: dsextraendchk,
                            timesleepextra: tsextrachk,
                            sleepextrayes: selfsleepextrayeschk,
                            sleepextrano: selfsleepextranochk,
                            disease: diseasechk,
                            seedoctoryes: selfdoctoryeschk,
                            seedoctorno: selfdoctornochk,
                            drugname: drugnamechk,
                            drugtime: drugtimechk,
                            worryyes: selfworryyeschk,
                            worryno: selfworrynochk,
                            householdyes: selfhouseholdyeschk,
                            householdno: selfhouseholdnochk,
                            temperature: tempchk,
                            sysvalue1: syschk1,
                            sysvalue2: syschk2,
                            sysvalue3: syschk3,
                            diavalue1: diachk1,
                            diavalue2: diachk2,
                            diavalue3: diachk3,
                            pulsevalue1: pulsechk1,
                            pulsevalue2: pulsechk2,
                            pulsevalue3: pulsechk3,
                            oxygenvalue:oxygenchk,
                            eyeproblemyes: selfeyeproblemyeschk,
                            eyeproblemno: selfeyeproblemnochk,
                            selfeyeglassesyes: selfeyeglassesyeschk,
                            selfeyeglassesno: selfeyeglassesnochk,
                            selfcarryeyeglassesyes: selfcarryeyeglassesyeschk,
                            selfcarryeyeglassesno: selfcarryeyeglassesnochk,
                            selfcarryhearingaidyes:selfcarryhearingaidyeschk,
                            selfcarryhearingaidno:selfcarryhearingaidnochk,
                            alcoholtype: alcoholtypechk,
                            alcoholtime: alcoholtimechk,
                            alcoholvolume: alcoholvolumechk,
                            activestatus: '1',
                            remark: '',
                            createby: employeecode,
                            createdate: '',
                            modifiedby: '',
                            modifieddate: ''



                        },
                        success: function (rs) {
                            
                            //เจ้าหน้าที่กดเปลี่ยนเวลา วางกุญแจในหน้าการดูรายละเอียด
                            save_keydroptimebyofficer(selfchkid,dsreststartchk,employeecode);

                            // alert("แก้ไขข้อมูลเรียบร้อย");

                            swal.fire({
                                title: "Good Job!",
                                text: "แก้ไขข้อมูลเรียบร้อย",
                                icon: "success",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            // alert(rs);   
                            setTimeout(() => {
                                document.location.reload();
                            }, 1200); 
  
                        }
                    });

                    }else{
                        // alert('save');
                        $.ajax({
                        type: 'post',
                        url: 'meg_data2.php',
                        data: {
                            
                            txt_flg: "save_selfcheckdetail",
                            id:'', 
                            employeecode: employeecode,
                            employeename: employeename, 
                            datejobstart: datejobstart,
                            dateworking: dateworking,
                            datepresent: datepresent,
                            tierdyeschk: self1yeschk,
                            tierdnochk: self1nochk,
                            illnessyeschk: self2yeschk,
                            illnessnochk: self2nochk,
                            drowseyeschk: self3yeschk,
                            drowsenochk: self3nochk,
                            injuryyeschk: self4yeschk,
                            injurynochk: self4nochk,
                            takemedicineyeschk: self5yeschk,
                            takemedicinenochk: self5nochk, 
                            healthyyeschk: selfallyeschk, 
                            healthynochk: selfallnochk,
                            sleepreststart: dsreststartchk,
                            sleeprestend: dsrestendchk,
                            timesleeprest: tsrestchk,
                            sleepnormalstart: dsnormalstartchk,
                            sleepnormalend: dsnormalendchk,
                            timesleepnormal: tsnormalchk,
                            sleepnormalyes: selfsleepnormalyeschk,
                            sleepnormalno: selfsleepnormalnochk,
                            sleepextrastart: dsextrastartchk,
                            sleepextraend: dsextraendchk,
                            timesleepextra: tsextrachk,
                            sleepextrayes: selfsleepextrayeschk,
                            sleepextrano: selfsleepextranochk,
                            disease: diseasechk,
                            seedoctoryes: selfdoctoryeschk,
                            seedoctorno: selfdoctornochk,
                            drugname: drugnamechk,
                            drugtime: drugtimechk,
                            worryyes: selfworryyeschk,
                            worryno: selfworrynochk,
                            householdyes: selfhouseholdyeschk,
                            householdno: selfhouseholdnochk,
                            temperature: tempchk,
                            sysvalue1: syschk1,
                            sysvalue2: syschk2,
                            sysvalue3: syschk3,
                            diavalue1: diachk1,
                            diavalue2: diachk2,
                            diavalue3: diachk3,
                            pulsevalue1: pulsechk1,
                            pulsevalue2: pulsechk2,
                            pulsevalue3: pulsechk3,
                            oxygenvalue:oxygenchk,
                            eyeproblemyes: selfeyeproblemyeschk,
                            eyeproblemno: selfeyeproblemnochk,
                            selfeyeglassesyes: selfeyeglassesyeschk,
                            selfeyeglassesno: selfeyeglassesnochk,
                            selfcarryeyeglassesyes: selfcarryeyeglassesyeschk,
                            selfcarryeyeglassesno: selfcarryeyeglassesnochk,
                            selfcarryhearingaidyes: selfcarryhearingaidyeschk,
                            selfcarryhearingaidno: selfcarryhearingaidnochk,
                            alcoholtype: alcoholtypechk,
                            alcoholtime: alcoholtimechk,
                            alcoholvolume: alcoholvolumechk,
                            activestatus: '1',
                            remark: '',
                            createby: '',
                            createdate: '',
                            modifiedby: '',
                            modifieddate: ''



                        },
                        success: function (rs) {
                             
                            // alert("บันทึกข้อมูลเรียบร้อย");
                                swal.fire({
                                    title: "Good Job!",
                                    text: "บันทึกข้อมูลเรียบร้อย",
                                    icon: "success",
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                });
                                // alert(rs);   
                                setTimeout(() => {
                                    document.location.reload();
                                }, 1200);
                        }
                    });

                    }
                   
                    
                   
            }

            function  save_selfcheckT(a,b,c) {
                alert(a);
            }
            function save_selfcheck(chkstatus,checkClient,empchkgw)
            {
                    // alert(chkstatus);
                    // alert(checkClient);
                    //11111
                    var datejobstart = document.getElementById('txt_datedriverchk').value;
                    var dateworking  = document.getElementById('txt_dateworkingchk').value;
                    var datepresent  = document.getElementById('txt_datepresentchk').value;
                    var employeecode = document.getElementById('txt_empcode').value;
                    var employeename = document.getElementById('txt_empname').value;
                    var sessionid    = document.getElementById('txt_selfsession').value;
                    // alert(datejobstart);
                    // alert(timejobstart);
                    // alert(sessionid);
                    // เช็คการลงข้อมูลคอลัมย์ที่1
                    var self1yeschk = "";
                    var self1nochk = "";
                    var self2yeschk = "";
                    var self2nochk = "";
                    var self3yeschk = "";
                    var self3nochk = "";
                    var self4yeschk = "";
                    var self4nochk = "";
                    var self5yeschk = "";
                    var self5nochk = "";
                    var selfallyeschk = "";
                    var selfallnochk = "";
                    
                    //ประเมิณอาการเหนื่อยล้า
                    if($("#self1yes").is(':checked') || $("#self1no").is(':checked') ){
                        //alert("yes");
                         if($("#self1yes").is(':checked')){
                            self1yeschk = '1';
                            //alert('มีอาการเหนื่อยล้า');
                            //alert(self1yeschk);
                        } else {
                            self1nochk = '1';
                            //alert(self1nochk);
                            //alert('ไม่มีอาการเหนื่อยล้า');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'อาการเหนื่อยล้า'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'อาการเหนื่อยล้า'");
                        }
                        

                    }
                    
                    //ประเมิณอาการเจ็บป่วย
                    if($("#self2yes").is(':checked') || $("#self2no").is(':checked') ){
                        //alert("yes");
                         if($("#self2yes").is(':checked')){
                            self2yeschk = '1';
                            //alert('มีอาการเจ็บป่วย');
                        } else {
                            self2nochk = '1';
                            //alert('ไม่มีอาการเจ็บป่วย');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'อาการเจ็บป่วย'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'อาการเจ็บป่วย'");
                        }
                        

                    }

                    //ประเมิณอาการง่วงนอน
                    if($("#self3yes").is(':checked') || $("#self3no").is(':checked') ){
                        //alert("yes");
                         if($("#self3yes").is(':checked')){
                            self3yeschk = '1';
                            //alert('มีอาการง่วงนอน');
                        } else {
                            self3nochk = '1';
                            //alert('ไม่มีอาการง่วงนอน');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'อาการง่วงนอน'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'อาการง่วงนอน'");
                        }
                        
                    }

                    //ประเมิณอาการบาดเจ็บ
                    if($("#self4yes").is(':checked') || $("#self4no").is(':checked') ){
                        //("yes");
                         if($("#self4yes").is(':checked')){
                            self4yeschk = '1';
                            //('มีอาการบาดเจ็บ');
                            
                        } else {
                            self4nochk = '1';
                            //alert('ไม่มีอาการบาดเจ็บ');
                           
                        }
                    }else{
                        
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'อาการบาดเจ็บ'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'อาการบาดเจ็บ'");
                        }
                        

                    }

                    //ประเมิณทานยาที่มีผลต่อการขับขี่
                    if($("#self5yes").is(':checked') || $("#self5no").is(':checked') ){
                        //alert("yes");
                         if($("#self5yes").is(':checked')){
                            self5yeschk = '1';
                            //alert('ทานยาที่มีผลต่อการขับขี่');
                            // alert(self5yeschk);
                            // alert('ทานยา');
                        } else {
                            self5nochk = '1';
                            //alert('ไม่ทานยาที่มีผลต่อการขับขี่');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'ทานยาที่มีผลต่อการขับขี่'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'ทานยาที่มีผลต่อการขับขี่'");
                        }
                        

                    }

                    //ประเมิณสภาพร่างกาย
                    if($("#selfallyes").is(':checked') || $("#selfallno").is(':checked') ){
                        //alert("yes");
                         if($("#selfallyes").is(':checked')){
                            selfallyeschk = '1';
                            //alert('สภาพร่างกายปกติ');
                        } else {
                            selfallnochk = '1';
                            //alert('สภาพร่างกายไม่ปกติ');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'สภาพร่างกาย'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'สภาพร่างกาย'");
                        }
                        

                    }
                    
                    // เช็คการลงข้อมูลคอลัมย์ที่2 เวลาพักผ่อน 8 ชั่วโมง
                    // var dsreststart = document.getElementById('daysleep_reststart').value;
                    // var dsrestend = document.getElementById('daysleep_restend').value;
                    // var tsrest = document.getElementById('timesleep_rest').value;
                    
                    if (checkClient == 'MB') {
                        var dsreststart = document.getElementById('daysleep_reststart').value;
                        var dsrestend = document.getElementById('daysleep_restend').value;
                        var tsrest = document.getElementById('timesleep_rest').value;
                    }else{
                        // alert('else');
                        //START REST
                        var startrestchk = document.getElementById('daysleep_reststart').value;
                        var startrestdata1  = startrestchk.replace(" ","T"); // replave " " เป็น "T"
                        var startrestdata2  = startrestdata1.replace("/","-");
                        var startrestdata3  = startrestdata2.replace("/","-"); // replave "/" เป็น "-"
                        var dsreststart = startrestdata3;
                        
                        //END REST
                        var endrestchk = document.getElementById('daysleep_restend').value;
                        var endrestdata1  = endrestchk.replace(" ","T"); // replave " " เป็น "T"
                        var endrestdata2  = endrestdata1.replace("/","-");// replave "/" เป็น "-"
                        var endrestdata3  = endrestdata2.replace("/","-");
                        var dsrestend = endrestdata3;
                        
                        var tsrest = document.getElementById('timesleep_rest').value;
                        
                        // alert(dsreststart);
                        // alert(dsrestend);
                    }

                    //date rest start
                    if (dsreststart == '') {
                        dsreststartchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาเริ่มพักผ่อน(8 ชั่วโมง)');
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ลงข้อมูลเวลาเลิกงาน");
                        }else{
                            alert("ยังไม่ได้ลงข้อมูลเวลาเลิกงาน");
                        }
                    }else{
                        dsreststartchk = dsreststart;
                        //alert(dsnormalstartchk);
                    }
                    
                    //date rest end
                    if (dsrestend == '') {
                        dsrestendchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาตื่นพักผ่อน(8 ชั่วโมง)');
                    }else{
                        dsrestendchk = dsrestend;
                        //alert(dsrestendchk);
                    }

                    //time sleep rest 
                    if (tsrest == '') {
                        tsrestchk = "";
                        //alert('ยังไม่ได้ลงระยะเวลาที่พักผ่อน(8 ชั่วโมง)');
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ลงระยะเวลาที่พักผ่อน(8 ชั่วโมง)");
                        }else{
                            alert("ยังไม่ได้ลงระยะเวลาที่พักผ่อน(8 ชั่วโมง)");
                        }
                    }else{
                        tsrestchk = tsrest;
                        //alert(tsrestchk);
                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่3 เวลาการนอนปกติ
                    // var dsnormalstart = document.getElementById('daysleep_normalstart').value;
                    // var dsnormalend = document.getElementById('daysleep_normalend').value;
                    // var tsnormal = document.getElementById('timesleep_normal').value;
                    var selfsleepnormalyeschk = "";
                    var selfsleepnormalnochk = "";

                    if (checkClient == 'MB') {
                        var dsnormalstart = document.getElementById('daysleep_normalstart').value;
                        var dsnormalend = document.getElementById('daysleep_normalend').value;
                        var tsnormal = document.getElementById('timesleep_normal').value;
                    }else{
                        // alert('else');
                        //START NORMALSLEEP
                        var startnormalchk = document.getElementById('daysleep_normalstart').value;
                        var startnormaldata1  = startnormalchk.replace(" ","T"); // replave " " เป็น "T"
                        var startnormaldata2  = startnormaldata1.replace("/","-");
                        var startnormaldata3  = startnormaldata2.replace("/","-"); // replave "/" เป็น "-"
                        var dsnormalstart = startnormaldata3;
                        
                        //END NORMALSLEEP
                        var endnormalchk = document.getElementById('daysleep_normalend').value;
                        var endnormaldata1  = endnormalchk.replace(" ","T"); // replave " " เป็น "T"
                        var endnormaldata2  = endnormaldata1.replace("/","-");// replave "/" เป็น "-"
                        var endnormaldata3  = endnormaldata2.replace("/","-");
                        var dsnormalend = endnormaldata3;
                        
                        var tsnormal = document.getElementById('timesleep_normal').value;
                        
                        // alert(dsnormalstart);
                        // alert(dsnormalend);
                    }
                    
                    //date normal start
                    if (dsnormalstart == '') {
                        dsnormalstartchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาเริ่มพักผ่อน(ปกติ)');
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ลงข้อมูลเวลาเริ่มนอน(ปกติ)");
                        }else{
                            alert("ยังไม่ได้ลงข้อมูลเวลาเริ่มนอน(ปกติ)");
                        }
                    }else{
                        dsnormalstartchk = dsnormalstart;
                        //alert(dsnormalstartchk);
                    }
                    
                    //date normal end
                    if (dsnormalend == '') {
                        dsnormalendchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาตื่นพักผ่อน(ปกติ)');
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ลงข้อมูลเวลาตื่นนอน(ปกติ)");
                        }else{
                            alert("ยังไม่ได้ลงข้อมูลเวลาตื่นนอน(ปกติ)");
                        }
                    }else{
                        dsnormalendchk = dsnormalend;
                        //alert(dsnormalendchk);
                    }

                    //time sleep normal 
                    if (tsnormal == '') {
                        tsnormalchk = "";
                        //alert('ยังไม่ได้ลงระยะเวลาที่นอน(ปกติ)');
                    }else{
                        tsnormalchk = tsnormal;
                        //alert(tsnormalchk);
                    }

                    //ประเมินการนอนปกติ
                    if($("#selfnormalsleepyes").is(':checked') || $("#selfnormalsleepno").is(':checked') ){
                        //alert("yes");
                         if($("#selfnormalsleepyes").is(':checked')){
                            selfsleepnormalyeschk = '1';
                            //alert('การนอนปกติ(หลับสนิท)');
                        } else {
                            selfsleepnormalnochk = '1';
                            //alert('การนอนปกติ(หลับไม่สนิท)');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'การนอนปกติ'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'การนอนปกติ'");
                        }
                        //alert("ยังไม่ได้ประเมิน 'การนอนปกติ'");

                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่3 เวลาการนอนเพิ่มเติม
                    // var dsextrastart = document.getElementById('daysleep_extrastart').value;
                    // var dsextraend = document.getElementById('daysleep_extraend').value;
                    // var tsextra = document.getElementById('timesleep_extra').value;
                    var selfsleepextrayeschk = "";
                    var selfsleepextranochk = "";
                    
                    if (checkClient == 'MB') {
                        var dsextrastart = document.getElementById('daysleep_extrastart').value;
                        var dsextraend = document.getElementById('daysleep_extraend').value;
                        var tsextra = document.getElementById('timesleep_extra').value;
                    }else{
                        // alert('else');
                        //START NORMALSLEEP
                        var startextrachk = document.getElementById('daysleep_extrastart').value;
                        var startextradata1  = startextrachk.replace(" ","T"); // replave " " เป็น "T"
                        var startextradata2  = startextradata1.replace("/","-");
                        var startextradata3  = startextradata2.replace("/","-"); // replave "/" เป็น "-"
                        var dsextrastart = startextradata3;

                        //END NORMALSLEEP
                        var endextrachk = document.getElementById('daysleep_extraend').value;
                        var endextradata1  = endextrachk.replace(" ","T"); // replave " " เป็น "T"
                        var endextradata2  = endextradata1.replace("/","-");// replave "/" เป็น "-"
                        var endextradata3  = endextradata2.replace("/","-");
                        var dsextraend = endextradata3;
                        
                        var tsextra = document.getElementById('timesleep_extra').value;
                        
                        // alert(dsextrastart);
                        // alert(dsextraend);
                    }

                    //date extra start
                    if (dsextrastart == '') {
                        dsextrastartchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาเริ่มพักผ่อน(กะกลางคืน)');
                    }else{
                        dsextrastartchk = dsextrastart;
                        //alert(dsextrastartchk);
                    }
                    
                    //date extra end
                    if (dsextraend == '') {
                        dsextraendchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาตื่นพักผ่อน(กะกลางคืน)');
                    }else{
                        dsextraendchk = dsextraend;
                        //alert(dsextraendchk);
                    }

                    //time sleep extra 
                    if (tsextra == '') {
                        tsextrachk = "";
                        //alert('ยังไม่ได้ลงระยะเวลาที่นอน(กะกลางคืน)');
                    }else{
                        tsextrachk = tsextra;
                        //alert(tsextrachk);
                    }

                    //ประเมินการนอนเพิ่ม
                    if($("#selfextrasleepyes").is(':checked') || $("#selfextrasleepno").is(':checked') ){
                        //alert("yes");
                         if($("#selfextrasleepyes").is(':checked')){
                            selfsleepextrayeschk = '1';
                            //alert('การนอนกะกลางคืน(หลับสนิท)');
                        } else {
                            selfsleepextranochk = '1';
                            //alert('การนอนกะกลางคืน(หลับไม่สนิท)');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'การนอนกะกลางคืน'");

                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่4
                    var disease = document.getElementById('disease').value;
                    var drugname = document.getElementById('drug_name').value;
                    var drugtime = document.getElementById('drug_time').value;
                    var selfdoctoryeschk = "";
                    var selfdoctornochk = "";
                    //อาการป่วย

                    //date extra start
                    if (disease == '') {
                        diseasechk = "";
                        //alert('ยังไม่ได้ลงข้อมูลโรค');
                    }else{
                        diseasechk = disease;
                        //alert(diseasechk);
                    }

                    //ประเมินการพบหมอ
                    if($("#selfdoctoryes").is(':checked') || $("#selfdoctorno").is(':checked') ){
                        //alert("yes");
                         if($("#selfdoctoryes").is(':checked')){
                            selfdoctoryeschk = '1';
                            //alert('พบหมอ');
                        } else {
                            selfdoctornochk = '1';
                            //alert('ไม่ได้พบหมอ');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'พบหมอ'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'พบหมอ'");
                        }
                        //alert("ยังไม่ได้ประเมิน 'พบหมอ'");

                    }

                    //drug name
                    if (drugname == '') {
                        drugnamechk = "";
                        //alert('ยังไม่ได้ลงข้อมูลชื่อยา');
                    }else{
                        drugnamechk = drugname;
                        //alert(drugnamechk);
                    }

                    // //time sleep extra 
                    drugtimechk = drugtime;
                    //alert(drugtimechk);
                    
                    // if (drugtime == '') {
                    //     drugtimechk = "";
                    //     alert('ยังไม่ได้ลงเวลาทานยา');
                    // }else{
                    //     drugtimechk = drugtime;
                    //     alert(drugtimechk);
                    // }

                    
                    // เช็คการลงข้อมูลคอลัมย์ที่5
                    var selfworryyeschk = "";
                    var selfworrynochk = "";
                    var selfhouseholdyeschk = "";
                    var selfhouseholdnochk = "";

                    //ประเมินเรื่องกังวลใจ / การใช้เวลาช่วงพักผ่อน
                    //เรื่องกังวลใจ
                    if($("#selfworryyes").is(':checked') || $("#selfworryno").is(':checked') ){
                        //alert("yes");
                         if($("#selfworryyes").is(':checked')){
                            selfworryyeschk = '1';
                            //alert('มีเรื่องกังวลใจ');
                        } else {
                            selfworrynochk = '1';
                            //alert('ไม่มีเรื่องกังวลใจ');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'เรื่องกังวลใจ'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'เรื่องกังวลใจ'");
                        }
                        

                    }
                    // การใช้เวลาช่วงพักผ่อน
                    if($("#selfhouseholdyes").is(':checked') || $("#selfhouseholdno").is(':checked') ){
                       // alert("yes");
                         if($("#selfhouseholdyes").is(':checked')){
                            selfhouseholdyeschk = '1';
                            //alert('ใช้ช่วงเวลาพักผ่อนในบ้าน');
                        } else {
                            selfhouseholdnochk = '1';
                            //alert('ใช้ช่วงเวลาพักผ่อนนอกบ้าน');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'การใช้ช่วงเวลาพักผ่อน'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'การใช้ช่วงเวลาพักผ่อน'");
                        }
                        

                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่6
                    var tempchk = document.getElementById('temperature').value;
                    var syschk1 = document.getElementById('sys_value1').value;
                    var syschk2 = document.getElementById('sys_value2').value;
                    var syschk3 = document.getElementById('sys_value3').value;
                    var diachk1 = document.getElementById('dia_value1').value;
                    var diachk2 = document.getElementById('dia_value2').value;
                    var diachk3 = document.getElementById('dia_value3').value;
                    var pulsechk1 = document.getElementById('pulse_value1').value;
                    var pulsechk2 = document.getElementById('pulse_value2').value;
                    var pulsechk3 = document.getElementById('pulse_value3').value;
                    var oxygenchk = document.getElementById('oxygen_value').value;
                    
                    //ประเมินอุณภูมิ ความดันบน ความดันล่าง
                    
                    // //ประเมินอุณภูมิ 
                    // if (temp == '') {
                    //     tempchk = "";
                    //     alert('ยังไม่ได้ลงข้อมูลอุณภูมิ');
                    // }else{
                    //     tempchk = temp;
                    //     //alert(tempchk);
                    // }

                    // //ความดันบน ความดันล่าง
                    // if (sys == '') {
                    //     syschk = "";
                    //     alert('ยังไม่ได้ลงข้อมูลความดันบน');
                    // }else{
                    //     syschk = sys;
                    //     //alert(syschk);
                    // }

                    // //ความดันล่าง
                    // if (dia == '') {
                    //     diachk = "";
                    //     alert('ยังไม่ได้ลงข้อมูลความดันล่าง');
                    // }else{
                    //     diachk = dia;
                    //     //alert(diachk);
                    // }
                    
                    // เช็คการลงข้อมูลคอลัมย์ที่7
                    var selfeyeproblemyeschk = "";
                    var selfeyeproblemnochk = "";
                    var selfeyeglassesyeschk = "";
                    var selfeyeglassesnochk = "";
                    var selfcarryeyeglassesyeschk = "";
                    var selfcarryeyeglassesnochk = "";
                    var selfcarryhearingaidyeschk = "";
                    var selfcarryhearingaidnochk = "";

                    //ปัญหาสายตา/แว่นสายตา
                    //ปัญหาสายตา
                    if($("#selfeyeproblemyes").is(':checked') || $("#selfeyeproblemno").is(':checked') ){
                        //alert("yes");
                         if($("#selfeyeproblemyes").is(':checked')){
                            selfeyeproblemyeschk = '1';
                            //alert(',มีปัญหาสายตา');
                        } else {
                            selfeyeproblemnochk = '1';
                            //alert('ไม่มีปัญหาสายตา');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'ปัญหาสายตา'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'ปัญหาสายตา'");
                        }
                        

                    }    
                    // แว่นสายตา
                    if($("#selfeyeglassesyes").is(':checked') || $("#selfeyeglassesno").is(':checked') ){
                       // alert("yes");
                         if($("#selfeyeglassesyes").is(':checked')){
                            selfeyeglassesyeschk = '1';
                            //alert('มีแว่นสายตา');
                        } else {
                            selfeyeglassesnochk = '1';
                            //alert('ไม่มีแว่นสายตา');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'สวมใส่แว่นสายตา'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'สวมใส่แว่นสายตา'");
                        }
                        

                    }
                    // สวมใส่เครื่องช่วยฟัง
                    if($("#selfcarryhearingaidyes").is(':checked') || $("#selfcarryhearingaidno").is(':checked') ){
                       // alert("yes");
                         if($("#selfcarryhearingaidyes").is(':checked')){
                            selfcarryhearingaidyeschk = '1';
                            //alert('มีแว่นสายตา');
                        } else {
                            selfcarryhearingaidnochk = '1';
                            //alert('ไม่มีแว่นสายตา');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'สวมใส่เครื่องช่วยฟัง'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'สวมใส่เครื่องช่วยฟัง'");
                        }
                        

                    }
                    // พกพาแว่นสายตา
                    if($("#selfcarryeyeglassesyes").is(':checked') || $("#selfcarryeyeglassesno").is(':checked') ){
                       // alert("yes");
                         if($("#selfcarryeyeglassesyes").is(':checked')){
                            selfcarryeyeglassesyeschk = '1';
                            //alert('มีแว่นสายตา');
                        } else {
                            selfcarryeyeglassesnochk = '1';
                            //alert('ไม่มีแว่นสายตา');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            // alert("ยังไม่ได้ประเมิน 'พกแว่นสายตา'");
                        }else{
                            // alert("ยังไม่ได้ประเมิน 'พกแว่นสายตา'");
                        }
                        

                    }
                    

                    // เช็คการลงข้อมูลคอลัมย์ที่8
                    var alcoholtype = document.getElementById('alcohol_type').value;
                    var alcoholtime = document.getElementById('alcohol_time').value;
                    var alcoholvolume = document.getElementById('alcohol_volume').value;
                    //ประเมินแอลกอฮอล์ เวลาเลิก ปริมาณ

                    // alert('alcohol volume')
                    // alert(alcoholvolume);
                    //ประเมินแอลกอฮอล์ 
                    if (alcoholtype == '') {
                        alcoholtypechk = "";
                        //alert('ยังไม่ได้ลงข้อมูลแอลกอฮอล์');
                    }else{
                        alcoholtypechk = alcoholtype;
                        //alert(alcoholtypechk);
                    }

                    //เวลาเลิก
                    alcoholtimechk = alcoholtime;
                    

                    //ปริมาณ
                    if (alcoholvolume == '') {
                        alcoholvolumechk = "";
                        // alert('ยังไม่ได้ลงข้อมูลปริมาณแอลกอฮอล์');
                    }else{
                        alcoholvolumechk = alcoholvolume;
                        // alert('alcohol volumechk')
                        // alert(alcoholvolumechk);
                    }

                    var selfchkid = document.getElementById('txt_selfchkid').value

                    alert('save');
                    // if (selfchkid != '') {
                    //     // alert('update');
                        
                    //     $.ajax({
                    //     type: 'post',
                    //     url: 'meg_data2.php',
                    //     data: {
                            
                    //         txt_flg: "update_selfcheckdetail",
                    //         id:selfchkid, 
                    //         employeecode: employeecode,
                    //         employeename: employeename, 
                    //         datejobstart: datejobstart,
                    //         dateworking: dateworking,
                    //         datepresent: datepresent,
                    //         tierdyeschk: self1yeschk,
                    //         tierdnochk: self1nochk,
                    //         illnessyeschk: self2yeschk,
                    //         illnessnochk: self2nochk,
                    //         drowseyeschk: self3yeschk,
                    //         drowsenochk: self3nochk,
                    //         injuryyeschk: self4yeschk,
                    //         injurynochk: self4nochk,
                    //         takemedicineyeschk: self5yeschk,
                    //         takemedicinenochk: self5nochk, 
                    //         healthyyeschk: selfallyeschk, 
                    //         healthynochk: selfallnochk,
                    //         sleepreststart: dsreststartchk,
                    //         sleeprestend: dsrestendchk,
                    //         timesleeprest: tsrestchk,
                    //         sleepnormalstart: dsnormalstartchk,
                    //         sleepnormalend: dsnormalendchk,
                    //         timesleepnormal: tsnormalchk,
                    //         sleepnormalyes: selfsleepnormalyeschk,
                    //         sleepnormalno: selfsleepnormalnochk,
                    //         sleepextrastart: dsextrastartchk,
                    //         sleepextraend: dsextraendchk,
                    //         timesleepextra: tsextrachk,
                    //         sleepextrayes: selfsleepextrayeschk,
                    //         sleepextrano: selfsleepextranochk,
                    //         disease: diseasechk,
                    //         seedoctoryes: selfdoctoryeschk,
                    //         seedoctorno: selfdoctornochk,
                    //         drugname: drugnamechk,
                    //         drugtime: drugtimechk,
                    //         worryyes: selfworryyeschk,
                    //         worryno: selfworrynochk,
                    //         householdyes: selfhouseholdyeschk,
                    //         householdno: selfhouseholdnochk,
                    //         temperature: tempchk,
                    //         sysvalue1: syschk1,
                    //         sysvalue2: syschk2,
                    //         sysvalue3: syschk3,
                    //         diavalue1: diachk1,
                    //         diavalue2: diachk2,
                    //         diavalue3: diachk3,
                    //         pulsevalue1: pulsechk1,
                    //         pulsevalue2: pulsechk2,
                    //         pulsevalue3: pulsechk3,
                    //         oxygenvalue:oxygenchk,
                    //         eyeproblemyes: selfeyeproblemyeschk,
                    //         eyeproblemno: selfeyeproblemnochk,
                    //         selfeyeglassesyes: selfeyeglassesyeschk,
                    //         selfeyeglassesno: selfeyeglassesnochk,
                    //         selfcarryeyeglassesyes: selfcarryeyeglassesyeschk,
                    //         selfcarryeyeglassesno: selfcarryeyeglassesnochk,
                    //         selfcarryhearingaidyes: selfcarryhearingaidyeschk,
                    //         selfcarryhearingaidno: selfcarryhearingaidnochk,
                    //         alcoholtype: alcoholtypechk,
                    //         alcoholtime: alcoholtimechk,
                    //         alcoholvolume: alcoholvolumechk,
                    //         activestatus: '1',
                    //         remark: '',
                    //         createby: employeecode,
                    //         createdate: '',
                    //         modifiedby: sessionid,
                    //         modifieddate: ''



                    //         },
                    //         success: function (rs) {
                                
                    //             // alert("ยืนยันและแก้ไขข้อมูลเรียบร้อย");
                    //             commitupdate_selfcheck(selfchkid);
                    //             swal.fire({
                    //                 title: "Good Job!",
                    //                 text: "ยืนยันและแก้ไขข้อมูลเรียบร้อย",
                    //                 icon: "success",
                    //                 showConfirmButton: false,
                    //                 allowOutsideClick: false,
                    //             });
                    //             // alert(rs);    
                    //             setTimeout(() => {
                    //                 document.location.reload();
                    //             }, 1500);
                    //         }
                    //     });

                    // }else{
                    //     // alert('save');
                    //     swal.fire({
                    //         title: "warning",
                    //         text: "ไม่มีหมายเลข SelfcheckID !!",
                    //         icon: "warning",
                    //         showConfirmButton: true,
                    //         allowOutsideClick: false,
                    //     });

                    // }
                   
                    
                   
                }
                function commitupdate_selfcheck(selfchkid){

                    // alert("commit and update selfcheck");

                    var temp = document.getElementById("temperature").value;
                    var sysvalue1 = document.getElementById("sys_value1").value;
                    var sysvalue2 = document.getElementById("sys_value2").value;
                    var sysvalue3 = document.getElementById("sys_value3").value;
                    var diavalue1 = document.getElementById("dia_value1").value;
                    var diavalue2 = document.getElementById("dia_value2").value;
                    var diavalue3 = document.getElementById("dia_value3").value;
                    var pulsevalue1 = document.getElementById("pulse_value1").value;
                    var pulsevalue2 = document.getElementById("pulse_value2").value;
                    var pulsevalue3 = document.getElementById("pulse_value3").value;
                    var oxygenvalue = document.getElementById("oxygen_value").value;
                    var alcoholvalue = document.getElementById("alcohol_volume").value;

                    // alert(selfcheckid);
                    // alert(temp);
                    // alert(sysvalue1);
                    // alert(sysvalue2);
                    // alert(sysvalue3);
                    // alert(diavalue1);
                    // alert(diavalue2);
                    // alert(diavalue3);
                    // alert(pulsevalue1);
                    // alert(pulsevalue2);
                    // alert(pulsevalue3);
                    // alert(oxygenvalue);
                    
                    if (selfchkid == '') {
                        // alert("ยังไม่มีการแจ้งสุขภาพตนเองของพนักงาน กรุณาตรวจสอบข้อมูล!!");
                        swal.fire({
                            title: "warning",
                            text: "ยังไม่มีการแจ้งสุขภาพตนเองของพนักงาน กรุณาตรวจสอบข้อมูล!!",
                            icon: "warning",
                        });
                    }else{
                        $.ajax({
                            url: 'meg_data2.php',
                            type: 'POST',
                            data: {
                                txt_flg: "commitupdate_selfcheck", 
                                selfcheckid: selfchkid,
                                temp: temp, 
                                sysvalue1: sysvalue1, 
                                sysvalue2: sysvalue2,
                                sysvalue3: sysvalue3,
                                diavalue1: diavalue1,
                                diavalue2: diavalue2,
                                diavalue3: diavalue3,
                                pulsevalue1: pulsevalue1,
                                pulsevalue2: pulsevalue2,
                                pulsevalue3: pulsevalue3,
                                oxygenvalue: oxygenvalue,
                                alcoholvalue: alcoholvalue
                            },
                            success: function () {

                            }
                        }); 
                    }
                }
            

        </script>






    </body>

</html>
<?php
sqlsrv_close($conn);
?>