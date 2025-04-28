
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

if ($_GET['vehicleinfoid'] != "") {
    // $conditioninfo = ' AND a.VEHICLEINFOID = ' . $_GET['vehicleinfoid'];
    
    $conditioninfo = "AND a.VEHICLEINFOID = '" . $_GET['vehicleinfoid'] . "'";
    $sql_info = "{call megVehicleinfo_v2(?,?)}";
    $params_info = array(
        array('select_vehicleinfo', SQLSRV_PARAM_IN),
        array($conditioninfo, SQLSRV_PARAM_IN)
    );
    $query_info = sqlsrv_query($conn, $sql_info, $params_info);
    $result_info = sqlsrv_fetch_array($query_info, SQLSRV_FETCH_ASSOC);

    if ($result_info['AFFCOMPANY'] == 'RKS') {
        $comheader = 'บริษัท ร่วมกิจรุ่งเรืองเซอร์วิส จำกัด';
    }else if ($result_info['AFFCOMPANY'] == 'RKR') {
        $comheader = 'บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด';
    }else if ($result_info['AFFCOMPANY'] == 'RKL') {
        $comheader = 'บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์ จำกัด';
    }else if ($result_info['AFFCOMPANY'] == 'RRC') {
        $comheader = 'บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด';
    }else if ($result_info['AFFCOMPANY'] == 'RCC') {
        $comheader = 'บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์ จำกัด';
    }else if ($result_info['AFFCOMPANY'] == 'RATC') {
        $comheader = 'บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต จำกัด';
    }else{
        $comheader = '';
    }


    ///คำนวนหาอายุรถ
    $regisfirstdate = $result_info['VEHICLEREGISTERFIRSTDATE'];

    $day =  substr($result_info['VEHICLEREGISTERFIRSTDATE'],0,2);
    $month =  substr($result_info['VEHICLEREGISTERFIRSTDATE'],3,2);
    $year =  substr($result_info['VEHICLEREGISTERFIRSTDATE'],6);

    $datetruck = $month."/".$day."/".$year;


    $sql_CalculateTruck = "{call megCalculatorDate(?,?)}";
    $params_CalculateTruck = array(
        array('calculate_yeartruck', SQLSRV_PARAM_IN),
        array($datetruck, SQLSRV_PARAM_IN)
    );
    $query_CalculateTruck = sqlsrv_query($conn, $sql_CalculateTruck, $params_CalculateTruck);
    $result_CalculateTruck = sqlsrv_fetch_array($query_CalculateTruck, SQLSRV_FETCH_ASSOC);

    // echo "<br>";
    // echo "<br>";
    // echo $result_CalculateTruck['RS'];
}

// การลงข้อมูล ถ้าเป็น Add ต้องแสดงการลงข้อมูลทั้งหมด
if ($_GET['meg'] == 'add') {
    $chk_control1 = "";
}else {
    $chk_control1 = "display:none";
}

// ตารางค้นหาข้อมูลการซ่อมจาก EMS Phase1 ,EMS Phase2
if ($_GET['meg'] == 'add') {
    $chk_control2 = "display:none";
}else {
    $chk_control2 = "";
}

    // Request URL  จาก SERVER 
    // if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
    //      $url = "https://";   
    // else  
    //      $url = "http://";   
    // // Append the host(domain name, ip) to the URL.   
    // $url.= $_SERVER['HTTP_HOST'];   
    
    // // Append the requested resource location to the URL   
    // $url.= $_SERVER['REQUEST_URI'];    
      
    // echo $url;  
   
    

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
        <!-- <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet"> -->
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <!--<link href="../dist/css/sb-admin-2.css" rel="stylesheet">-->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">

        <link href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css" rel="stylesheet">

        <!-- Zoom CSS -->
        <link rel="stylesheet" type="text/css" href="css/zoom.css">
        <!-- Swal Alert2 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
    </head>
    <style>
        .swal2-popup {
            font-size: 16px !important;
            padding: 17px;
            border: 1px solid #F0E1A1;
            display: block;
            margin: 22px;
            text-align: center;
            color: #61534e;
        }
        body {font-family: Arial, Helvetica, sans-serif;}

        #myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        #myImg:hover {opacity: 0.4;}

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: absolute; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.6); /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        /* Caption of Modal Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation */
        .modal-content, #caption {    
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.7s;
            animation-name: zoom;
            animation-duration: 0.7s;
        }

        @-webkit-keyframes zoom {
            from {-webkit-transform:scale(0)} 
            to {-webkit-transform:scale(1)}
        }

        @keyframes zoom {
            from {transform:scale(0)} 
            to {transform:scale(1)}
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 40px;
            /* right: 20px; */
            right: 420px;
            color: #ffffff;
            font-size: 100px;
            font-weight: bold;
            transition: 0.3s;
        }
        #buttonclose {
            margin: auto;
            display: block;
            width: 100%;
            max-width: 200px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 100px;
        }
        #loading {
            display:none; 
            position: absolute;
            opacity: 0.5;
            /* border-radius: 50%; */
            /* border-top: 12px ; */
            height: 5px;
            width: 5px;
            left: 450px;
            top: 900px;
            /* right: 5px;
            top: 0px;
            bottom: 500px; */
            
            /* animation: spin 1s linear infinite; */
        }

        /* a:hover, a:active {
            background-color: red;
        } */
        
    </style>
    <body>
        <!-- The Modal -->
        <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
            <div class="row" id="buttonclose" >
                <div class="col-lg-12 col-md-6 col-xs-6">
                    <input style="background-color: #918d8d;width:200px;height:40px;color:#ffffff;font-size: 20px;text-align: center;" class="form-control" type="button" onclick="closemodal();" autocomplete="off"  name="btnclose" id="btnclose" value="ปิดรูปภาพ"></input>
                </div>
                <br><br>
                <div id="caption"></div>
            </div>
            
        </div>
        <!-- //////////////////////////////////////// -->
        <div id="wrapper">

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
            </nav>

            <div id="page-wrapper" >
                <div class="row">
                    <div class="col-md-12">&nbsp;</div>
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
                                    <a href='index2.php'>หน้าแรก</a> / <a href='report_vehicleinfoamata.php'>ข้อมูลรถ</a> / <?= $result_info['VEHICLEREGISNUMBER'] ?> 
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12" style="background-color: #fffff;font-size:20px;text-align: center">
                                        <h3><b><?=$comheader?></b></h3>
                                    </div>
                                    <div class="col-lg-12 col-md-12" style="background-color: #fffff;font-size:20px;text-align: center">
                                        <h3><b>รายงานข้อมูลรถบรรทุก</b></h3>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-lg-4" style="background-color: #fffff;font-size:20px;text-align: center">
                                        <h3><b>ฝ่าย : Transportation</b></h3>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-lg-4" style="background-color: #fffff;font-size:20px;text-align: center">
                                        <h3><b>แผนก : SQ</b></h3>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-lg-4" style="background-color: #fffff;font-size:20px;text-align: center">
                                        <h3><b>บริษัท/สายงาน : <?=$result_info['AFFCOMPANY']?> / <?=$result_info['AFFCUSTOMER']?> </b></h3>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row" >
                                        <div  class="col-sm-3 col-md-3 col-lg-3" id="pic1" style="text-align: left">
                                            <!-- <div class="form-group">
                                                <p><img style="height:200px; width:200px;" src="../images/hinoT.png" data-action="zoom" alt="Pic_Truck1"/></p>
                                            </div> -->
                                            <!-- <br> -->
                                            <div class="form-group">
                                                <p style="text-align: center"><img id="myImg" src="../images/truck/<?=$result_info['VEHICLEREGISNUMBER']?>.webp" alt="ทะเบียน : <b>(<?=$result_info['VEHICLEREGISNUMBER'] ?>)</b> <br> ชื่อรถ: <b>(<?=$result_info['THAINAME'] ?>)</b>" width="400" height="360">
                                                </p>
                                            </div>&nbsp;
                                        </div>
                                        <div class="col-lg-3" style="text-align: center">
                                            <div class="form-group">
                                                <label>เลขทะเบียนรถ</label>
                                                <input class="form-control"  id="txt_vehiclenumber" name="txt_vehiclenumber" value="<?= $result_info['VEHICLEREGISNUMBER'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3" style="text-align: center">
                                            <div class="form-group">
                                                <label>ประเภททะเบียน</label>
                                                <input disabled="" class="form-control"  id="txt_registype" name="txt_registype" value="<?= $result_info['REGISTYPE'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3" style="text-align: center">
                                            <div class="form-group" >
                                                <label>ชื่อรถ (ไทย)</label>
                                                <input class="form-control"  id="txt_carnameth" name="txt_carnameth" value="<?= $result_info['THAINAME'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3" style="<?=$chk_control1?>">
                                            <div class="form-group">
                                                <label>ชื่อรถ (อังกฤษ)</label>
                                                <input class="form-control"  id="txt_carnameen" name="txt_carnameen" value="<?= $result_info['ENGNAME'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>*สายงาน</label>
                                                <input class="form-control"  id="txt_truckline" name="txt_truckline" value="<?= $result_info['AFFCUSTOMER'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ประเภทรถ</label>
                                                <select  class="form-control" id="cb_cartype" name="cb_cartype" onchange="show_remark(this.value)">
                                                    <option value="">เลือกประเภทรถ</option>
                                                    <?php
                                                    $sql_seCartype = "{call megVehicletype_v2(?)}";
                                                    $params_seCartype = array(
                                                        array('select_vehicletype', SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                    while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                        $selected2 = "";
                                                        if ($result_info['VEHICLETYPECODE'] == $result_seCartype['VEHICLETYPECODE']) {
                                                            $selected2 = 'selected';
                                                        }
                                                        ?>

                                                        <option value="<?= $result_seCartype['VEHICLETYPECODE'] ?>" <?= $selected2 ?>><?= $result_seCartype['VEHICLETYPEDESC'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ยี่ห้อรถ</label>
                                                <select  class="form-control" id="cb_carbrand" name="cb_carbrand">
                                                    <option value="">เลือกยี่ห้อรถ</option>
                                                    <?php
                                                    $sql_seCarbrand = "{call megVehiclebrand_v2(?)}";
                                                    $params_seCarbrand = array(
                                                        array('select_vehiclebrand', SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seCarbrand = sqlsrv_query($conn, $sql_seCarbrand, $params_seCarbrand);
                                                    while ($result_seCarbrand = sqlsrv_fetch_array($query_seCarbrand, SQLSRV_FETCH_ASSOC)) {
                                                        $selected3 = "";
                                                        if ($result_info['BRANDCODE'] == $result_seCarbrand['BRANDCODE']) {
                                                            $selected3 = 'selected';
                                                        }
                                                        ?>

                                                        <option value="<?= $result_seCarbrand['BRANDCODE'] ?>" <?= $selected3 ?>><?= $result_seCarbrand['BRANDDESC'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>วันที่จดทะเบียนครั้งแรก (วัน/เดือน/ปี)</label>
                                                <input class="form-control datevehicleregisterfirstdate"  id="txt_vehicleregisterfirstdate" name="txt_vehicleregisterfirstdate"  value="<?= $result_info['VEHICLEREGISTERFIRSTDATE'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>อายุรถ</label>
                                                <input disabled="" class="form-control"  id="txt_truckold" name="txt_truckold" value="<?= $result_CalculateTruck['RS']; ?> เดือน">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ซีรีส์/รุ่น</label>
                                                <input class="form-control"  id="txt_series_model" name="txt_series_model" value="<?= $result_info['SERIES'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>GPS</label>
                                                <input class="form-control"  id="txt_gps" name="txt_gps" value="<?= $result_info['GPS'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>บริษัทประกันภัย</label>
                                                <input class="form-control"  id="txt_insurance" name="txt_insurance" value="<?= $result_info['INSURANCE'] ?>">
                                            </div>
                                        </div> 
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>วันที่หมดอายุตามป้ายภาษี</label>
                                                <input class="form-control datetaxexpired"  id="txt_taxexpireddate" name="txt_taxexpireddate"  value="<?= $result_info['TAXEXPIREDDATE'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 ">
                                            <div class="form-group">
                                                <label>น้ำหนักรวมทั้งหมด (กิโลกรัม)</label>
                                                <input class="form-control"  id="txt_totalweight" name="txt_totalweight" onkeyup="checknumber(this.value,'totalweight')" value="<?= $result_info['TOTALWEIGHT'] ?>">
                                            </div>
                                        </div> 
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>สถานะ</label>
                                                <select  class="form-control" id="cb_carstatus" name="cb_carstatus">
                                                    <option value="">เลือกสถานะ</option>
                                                    <?php
                                                    $selected = "SELECTED";

                                                    switch ($result_info['ACTIVESTATUS']) {
                                                        case '1': {
                                                                ?>
                                                                <option value = "0" >ไม่ใช้งาน</option>
                                                                <option value = "1" <?= $selected ?>>ใช้งาน</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '0': {
                                                                ?>
                                                                <option value = "0" <?= $selected ?>>ไม่ใช้งาน</option>
                                                                <option value = "1" >ใช้งาน</option>
                                                                <?php
                                                            }
                                                            break;

                                                        default : {
                                                                ?>
                                                                <option value = "0">ไม่ใช้งาน</option>
                                                                <option value = "1" >ใช้งาน</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>หมายเหตุ</label>
                                                <input class="form-control" autocomplete="off"  id="txt_inforemark" name="txt_inforemark" value="<?= $result_info['REMARK'] ?>"></input>
                                            </div>
                                        </div>
                                        <div class="col-lg-3" style="<?=$chk_control1?>">
                                            <div class="form-group">
                                                <label>กลุ่มรถ</label>
                                                <select  class="form-control" id="cb_cargroup" name="cb_cargroup">
                                                    <option value="">เลือกกลุ่มรถ</option>
                                                    <?php
                                                    $sql_seCargroup = "{call megVehiclegroup_v2(?)}";
                                                    $params_seCargroup = array(
                                                        array('select_vehiclegroup', SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seCargroup = sqlsrv_query($conn, $sql_seCargroup, $params_seCargroup);
                                                    while ($result_seCargroup = sqlsrv_fetch_array($query_seCargroup, SQLSRV_FETCH_ASSOC)) {
                                                        $selected1 = "";
                                                        if ($result_info['VEHICLEGROUPCODE'] == $result_seCargroup['VEHICLEGROUPCODE']) {
                                                            $selected1 = "selected";
                                                        }
                                                        ?>
                                                        <option value="<?= $result_seCargroup['VEHICLEGROUPCODE'] ?>" <?= $selected1 ?>><?= $result_seCargroup['VEHICLEGROUPDESC'] ?></option>
                                                        <?php
                                                    }
                                                    ?>


                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group" style="<?=$chk_control1?>">
                                                <label>เลขตัวถัง</label>
                                                <input class="form-control"  id="txt_chassisnumber" name="txt_chassisnumber" value="<?= $result_info['CHASSISNUMBER'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3" style="<?=$chk_control1?>">
                                            <div class="form-group">
                                                <label>น้ำหนักรถ (กิโลกรัม)</label>
                                                <input class="form-control"  id="txt_weight" name="txt_weight" onkeyup="checknumber(this.value,'truckweight')" value="<?= $result_info['WEIGHT'] ?>">
                                            </div>
                                        </div>   
                                    </div>   
                                    <div class ="row">         
                                        <div class="col-lg-3" style="<?=$chk_control1?>">
                                            <div class="form-group">
                                                <label>วันที่จดทะเบียน</label>
                                                <input class="form-control datevehicleregister"  id="txt_vehicleregisterdate" name="txt_vehicleregisterdate"  value="<?= $result_info['VEHICLEREGISTERDATE'] ?>">
                                            </div>
                                        </div>               
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>เลขเครื่องยนต์</label>
                                                <input class="form-control"  id="txt_machine" name="txt_machine" value="<?= $result_info['MACHINENUMBER'] ?>">
                                            </div>
                                        </div>             
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ประเภทเกียร์รถ</label>
                                                <select  class="form-control" id="cb_geartype" name="cb_geartype">
                                                    <option value="">เลือกประเภทเกียร์รถ</option>

                                                    <?php
                                                    $sql_seGeartype = "{call megVehiclegear_v2(?)}";
                                                    $params_seGeartype = array(
                                                        array('select_vehiclegear', SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seGeartype = sqlsrv_query($conn, $sql_seGeartype, $params_seGeartype);
                                                    while ($result_seGeartype = sqlsrv_fetch_array($query_seGeartype, SQLSRV_FETCH_ASSOC)) {
                                                        $selected4 = "";
                                                        if ($result_info['GEARTYPECODE'] == $result_seGeartype['GEARTYPECODE']) {
                                                            $selected4 = "selected";
                                                        }
                                                        ?>
                                                        <option value="<?= $result_seGeartype['GEARTYPECODE'] ?>"<?= $selected4 ?>><?= $result_seGeartype['GEARTYPEDESC'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ประเภทพลังงาน</label>
                                                <select  class="form-control" id="cb_energy" name="cb_energy">
                                                    <option value="">เลือกประเภทพลังงาน</option>
                                                    <?php
                                                    switch ($result_info['ENERGY']) {
                                                        case 'ดีเซล': {
                                                                ?>
                                                                <option value="ดีเซล" selected="">ดีเซล</option>
                                                                <option value="เบนซิน">เบนซิน</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case 'เบนซิน': {
                                                                ?>
                                                                <option value="ดีเซล">ดีเซล</option>
                                                                <option value="เบนซิน" selected="">เบนซิน</option>
                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value="ดีเซล">ดีเซล</option>
                                                                <option value="เบนซิน">เบนซิน</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>    
                                    </div>
                                      
                                    
                                    
                                        
                                    
                                    <!-- END ROW1 -->
                             
                                    <!-- START ROW2 -->
                                    <!-- <div class="row" >
                                        <br>   
                                    </div> -->
                                    <!-- END ROW2 -->
                                    <!-- START ROW3 -->
                                    <div class="row" style="<?=$chk_control1?>">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>น้ำหนักบรรทุกสูงสุด (กิโลกรัม)</label>
                                                <input class="form-control"  id="txt_maxload" name="txt_maxload" onkeyup="checknumber(this.value,'maximunload')" value="<?= $result_info['MAXIMUMLOAD'] ?>">
                                            </div>
                                        </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>น้ำหนักรวม</label>
                                                    <input class="form-control"  id="txt_totalweight" name="txt_totalweight" onkeyup="checknumber(this.value,'totalweight')" value="<?= $result_info['TOTALWEIGHT'] ?>">
                                                </div>
                                            </div> 
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>แรงม้า</label>
                                                <input class="form-control"  id="txt_horse" name="txt_horse" onkeyup="checknumber(this.value,'horsepower')" value="<?= $result_info['HORSEPOWER'] ?>">
                                            </div>
                                        </div>           
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ประเภทเพลา</label>
                                                <select  class="form-control" id="cb_axle" name="cb_axle">
                                                    <option value="" >เลือกประเภทเพลา</option>

                                                    <?php
                                                    switch ($result_info['AXLETYPE']) {
                                                        case '1': {
                                                                ?>
                                                                <option value="1" selected="">1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '2': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" selected="">2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '3': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" selected="">3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '4': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" selected="">4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '5': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" selected="">5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '6': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" selected="">6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '7': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" selected="">7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '8': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" selected="">8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '9': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" selected="">9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '10': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" selected="">10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10">10</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- END ROW3  -->
                                    <!-- START ROW4 -->
                                    <div class="row" style="<?=$chk_control1?>">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>CC</label>
                                                <input class="form-control"  id="txt_cc" name="txt_cc" onkeyup="checknumber(this.value,'cc')" value="<?= $result_info['CC'] ?>">
                                            </div>
                                        </div> 
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>การใช้งาน (ปี)</label>
                                                <select  class="form-control" id="cb_used" name="cb_used">
                                                    <option value="">เลือกการใช้งาน (ปี)</option>
                                                    <?php
                                                    switch ($result_info['USED']) {
                                                        case '1': {
                                                                ?>
                                                                <option value="1" selected="">1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '2': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" selected="">2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '3': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" selected="">3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="10" >11</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '4': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" selected="">4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="10" >11</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '5': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" selected="">5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '6': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" selected="">6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '7': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" selected="">7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '8': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" selected="">8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '9': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" selected="">9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '10': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" selected="">10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '11': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" selected="">11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '12': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="10" >11</option>
                                                                <option value="12" selected="">12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '13': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" selected="">13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }

                                                            break;
                                                        case '14': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" selected="">14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '15': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" selected="">15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '16': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" selected="">16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '17': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" selected="">17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '18': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" selected="">18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '19': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" selected="">19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '20': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" selected="">20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>             
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ลูกสูบ</label>
                                                <select  class="form-control" id="cb_piston" name="cb_piston">
                                                    <option value="">เลือกลูกสูบ</option>
                                                    <?php
                                                    switch ($result_info['PISTON']) {
                                                        case '1': {
                                                                ?>
                                                                <option value="1" selected="">1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '2': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" selected="">2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '3': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" selected="">3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '4': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" selected="">4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '5': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" selected="">5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '6': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" selected="">6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '7': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" selected="">7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '8': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" selected="">8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '9': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" selected="">9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '10': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" selected="">10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>อุปกรณ์เฉพาะ</label>
                                                <input class="form-control" autocomplete="off"  id="txt_vehiclespecial" name="txt_vehiclespecial" value="<?= $result_info['VEHICLESPECIAL'] ?>"></input>
                                            </div>
                                        </div>   
                                    </div>
                                    <!-- END ROW4 -->
                                    
                                   <!-- START ROW6 -->
                                    <div class="row" style="<?=$chk_control1?>"> 
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>สีรถ</label>
                                                <select  class="form-control" id="cb_carcolor" name="cb_carcolor">
                                                    <option value="">เลือกสีรถ</option>
                                                    <?php
                                                    $sql_seCarcolor = "{call megVehiclecolor_v2(?)}";
                                                    $params_seCarcolor = array(
                                                        array('select_vehiclecolor', SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seCarcolor = sqlsrv_query($conn, $sql_seCarcolor, $params_seCarcolor);
                                                    while ($result_seCarcolor = sqlsrv_fetch_array($query_seCarcolor, SQLSRV_FETCH_ASSOC)) {
                                                        $selected5 = "";
                                                        if ($result_info['COLORCODE'] == $result_seCarcolor['COLORCODE']) {
                                                            $selected5 = 'selected';
                                                        }
                                                        ?>

                                                        <option value="<?= $result_seCarcolor['COLORCODE'] ?>"<?= $selected5 ?>><?= $result_seCarcolor['COLORDESC'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ซื้อรถที่ไหน</label>
                                                <input class="form-control"  id="txt_vehiclebuywhere" name="txt_vehiclebuywhere"  value="<?= $result_info['VEHICLEBUYWHERE'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>วันที่ซื้อ</label>
                                                <input class="form-control datebuy"    id="txt_vehiclebuydate" name="txt_vehiclebuydate"  value="<?= $result_info['VEHICLEBUYDATE'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ราคารถ</label>
                                                <input class="form-control" onkeyup="checknumber(this.value,'vehiclebuyprice')" id="txt_vehiclebuyprice" name="txt_vehiclebuyprice"  value="<?= $result_info['VEHICLEBUYPRICE'] ?>">
                                            </div>
                                        </div> 
                                    </div>                
                                    <!-- END ROW7 -->
                                    <!-- START ROW8 -->
                                    <div class="row" style="<?=$chk_control1?>">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>เงื่อนไขการซื้อ</label>
                                                <select  class="form-control" id="cb_vehiclebuyconditon" name="cb_vehiclebuyconditon">
                                                    <option value="">เลือกเงื่อนไขการซื้อ</option>
                                                    <?php
                                                    switch ($result_info['VEHICLEBUYCONDITION']) {
                                                        case 'สด': {
                                                                ?>
                                                                <option value = "สด" selected="">สด</option>
                                                                <option value = "ผ่อน" >ผ่อน</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case 'ผ่อน': {
                                                                ?>
                                                                <option value = "สด" >สด</option>
                                                                <option value = "ผ่อน" selected="">ผ่อน</option>
                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value = "สด" >สด</option>
                                                                <option value = "ผ่อน" >ผ่อน</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>


                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ต่อโครงสร้างที่ใหน</label>
                                                <input class="form-control"  id="txt_vehiclestructurewhere" name="txt_vehiclestructurewhere"  value="<?= $result_info['VEHICLESTRUCTUREWHERE'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>วันที่ต่อโครงสร้าง</label>
                                                <input class="form-control datevehiclestructure"   id="txt_vehiclestructuredate" name="txt_vehiclestructuredate"  value="<?= $result_info['VEHICLESTRUCTUREDATE'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ราคาการต่อโครงสร้าง</label>
                                                <input class="form-control" onkeyup="checknumber(this.value,'vehiclestructuredprice')" id="txt_vehiclestructuredprice" name="txt_vehiclestructuredprice"  value="<?= $result_info['VEHICLESTRUCTUREPRICE'] ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <!-- END ROW6 -->
                                    
                                    <!-- START ROW9 -->
                                    <div class="row" style="<?=$chk_control1?>">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>บริษัทสังกัด</label>
                                                <input class="form-control" autocomplete="off"  id="txt_affcompany" name="txt_affcompany" value="<?= $result_info['AFFCOMPANY'] ?>"></input>
                                            </div>
                                        </div> 
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ขนาดของรถบรรทุก (กว้างXยาวXสูง)</label>
                                                <input class="form-control"  id="txt_truckdimension" name="txt_truckdimension" value="<?= $result_info['TRUCKDIMENSION'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ขนาดของตู้สินค้า (กว้างXยาวXสูง)</label>
                                                <input class="form-control"  id="txt_cargodimension" name="txt_cargodimension" value="<?= $result_info['CARGODIMENSION'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ความจุของถังน้ำมัน (ลิตร)</label>
                                                <input class="form-control"  id="txt_fueltankcap" name="txt_fueltankcap" value="<?= $result_info['FUELTANKCAP'] ?>">
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ลิมิตความเร็วที่กำหนด (km/hr)</label>
                                                <input class="form-control"  id="txt_speedlimit" name="txt_speedlimit" value="<?= $result_info['SPEEDLIMIT'] ?>">
                                            </div>
                                        </div> 
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>หมายเหตุ</label>
                                                <input class="form-control" autocomplete="off"  id="txt_inforemark" name="txt_inforemark" value="<?= $result_info['REMARK'] ?>"></input>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>สถานะ</label>
                                                <select  class="form-control" id="cb_carstatus" name="cb_carstatus">
                                                    <option value="">เลือกสถานะ</option>
                                                    <?php
                                                    $selected = "SELECTED";

                                                    switch ($result_info['ACTIVESTATUS']) {
                                                        case '1': {
                                                                ?>
                                                                <option value = "0" >ไม่ใช้งาน</option>
                                                                <option value = "1" <?= $selected ?>>ใช้งาน</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '0': {
                                                                ?>
                                                                <option value = "0" <?= $selected ?>>ไม่ใช้งาน</option>
                                                                <option value = "1" >ใช้งาน</option>
                                                                <?php
                                                            }
                                                            break;

                                                        default : {
                                                                ?>
                                                                <option value = "0">ไม่ใช้งาน</option>
                                                                <option value = "1" >ใช้งาน</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>           
                                    </div>
                                    <div style="height:40px"></div>
                                    <!-- END ROW9 -->  
                                    <!-- <br>-->
                                    <div class="col-lg-12" style="text-align: center;">
                                        <?php
                                        $buttonname = ($_GET['meg'] == 'add') ? "บันทึกข้อมูล" : "แก้ไขข้อมูล";
                                        ?>
                                        <input style="background-color: #3CBC8D;width:250px;height:100px;color:#ffffff;font-size: 45px;" type="button" onclick="confirm_data('<?= $_GET['vehicleinfoid'] ?>');" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-success">
                                        <!-- <input style="background-color: #3CBC8D;width:200px;height:40px;color:#ffffff;font-size: 20px;" type="button" onclick="print_data('<?= $_GET['vehicleinfoid'] ?>');" name="btnSend" id="btnSend" value="พิมพ์ข้อมูลรถ" class="btn btn-success"> -->
                                        <!-- <button style="background-color: #1372d1;width:200px;height:40px;color:#ffffff;font-size: 20px;" onclick="pdf_printvehicleinfo('<?= $_GET['vehicleinfoid'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span>พิมพ์ข้อมูล</button> -->
                                    </div>  
                                                  
                                    <!-- /.row (nested) -->
                                </div>
                                <!-- <div class="modal-footer">
                                    <div class="row" >
                                        <div class="col-lg-12" style="text-align: center;">
                                            <?php
                                            $buttonname = ($_GET['meg'] == 'add') ? "บันทึกข้อมูล" : "แก้ไขข้อมูล";
                                            ?>
                                            <input type="button" onclick="save_vehicleinfo('<?= $_GET['vehicleinfoid'] ?>');" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-success">
                                        </div>
                                    </div>
                                </div> -->
                        </div>
                    </div>
                </div>

                
                <!-- TAP ตารางแสดงข้อมูล EMS Phase1-->
                <div class="panel-body" style="<?=$chk_control2?>">
                    <ul class="nav nav-pills" id="emsnav">
                        <li class="active" ><a style="border-style: solid;border-radius: 10px;border-color: #0a4b85;display: inline-block;" href="#truckrepair_emsp1" data-toggle="tab" aria-expanded="true" >ข้อมูลการซ่อมจาก EMS Phase1</a>
                        </li>
                        <li class="" style=""><a style="border-style: solid;border-radius: 10px;border-color: #0a4b85;display: inline-block;" href="#truckrepair_emsp2" data-toggle="tab" >ข้อมูลการซ่อมจาก EMS Phase2</a>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-md-12" >&nbsp;</div>
                    </div> 
                </div>
                <div class="tab-content" style="<?=$chk_control2?>">
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>

                    <div class="tab-pane fade active in" id="truckrepair_emsp1" style="background-color: #ffffff">           
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-lg-12" >
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>ค้นหาตามช่วงวันที่ EMS Phase1</label>
                                        <input class="form-control dateen_emsp1" readonly="" onchange="datetodate_emsp1();" style="background-color: #f080802e"  id="txt_datestart_emsp1" name="txt_datestart_emsp1" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <label>&nbsp;</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control dateen_emsp1"  readonly=""  style="background-color: #f080802e" id="txt_dateend_emsp1" name="txt_dateend_emsp1" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">
                                    </div>
                                </div>
                                
                                
                                <div class="col-lg-12" style="text-align:left;">
                                    <label>&nbsp;</label>
                                    <div class="form-group" >
                                        <button type="button" class="btn btn-default" onclick="select_emsp1();">ค้นหา <li class="fa fa-search"></li></button>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-lg-2" style="text-align: left">
                                <label>&nbsp;</label><br>
                                <a href="#" onclick="excel_reporttransportcover();" class="btn btn-success  ">EXCEL <li class="fa fa-file-excel-o"></li></a>
                                <a href="#" onclick="pdf_reporttransportcover();" class="btn btn-danger">PDF <li class="fa fa-file-pdf-o"></li></a>

                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <div class="row">
                                            <div class="col-sm-6">รายละเอียดข้อมูลการแจ้งซ่อมจาก EMS ทะเบียน : <b>(<?=$result_info['VEHICLEREGISNUMBER'] ?>)</b> | ชื่อรถ: <b>(<?=$result_info['THAINAME'] ?>)</b> </div>
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
                                                            <div id="datadef_emsp1">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example_emsp1" role="grid" aria-describedby="dataTables-example_info" >
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 5px;">ลำดับ1</th>
                                                                        <th style="width: 5px;">ไอดีแจ้งซ่อม</th>
                                                                        <th style="width: 40px;">วันที่แจ้งซ่อม</th>
                                                                        <th style="width: 70px;">ผู้แจ้งซ่อม</th>
                                                                        <th style="width: 50px;">รายการซ่อม</th>
                                                                        <th style="width: 50px;">ประเภทการซ่อม</th>
                                                                        <th style="width: 50px;">ช่างผู้รับผิดชอบ</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="text-align: center"></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td style=""></td>
                                                                        <td style=""></td>
                                                                        <td style=""></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            </div>
                                                            <div id="datasr_emsp1"></div>
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

                    <!-- ตารางข้อมูลการซ่อม BM,PM จาก EMS Phase2 -->
                    <div class="tab-pane fade" id="truckrepair_emsp2" style="background-color: #ffffff">           
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-lg-12" >
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>ค้นหาตามช่วงวันที่ EMS Phase2</label>
                                        <input class="form-control dateen_emsp2" readonly="" onchange="datetodate_emsp2();" style="background-color: #f080802e"  id="txt_datestart_emsp2" name="txt_datestart_emsp2" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                    </div>

                                </div>
                                <div class="col-lg-2">
                                    <label>&nbsp;</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control dateen_emsp2"  readonly=""  style="background-color: #f080802e" id="txt_dateend_emsp2" name="txt_dateend_emsp2" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">
                                    </div>
                                </div>
                            
                                <!-- <div class="col-lg-2">
                                    <label>เลือกพนักงาน:</label>
                                    <div class="dropdown bootstrap-select show-tick form-control">
                                        <select   id="txt_drivercode" name="txt_drivercode" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                            <?php
                                            // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                            $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                            $params_seName = array(
                                                array('select_employeeehr2', SQLSRV_PARAM_IN),
                                                array('', SQLSRV_PARAM_IN)
                                            );
                                            $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                            while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                                ?>
                                                <option value="<?= $result_seName['PersonCode'] ?>"><?= $result_seName['nameT'] ?> (<?= $result_seName['PersonCode'] ?>)</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <input class="form-control" style="display: none"   id="txt_copydiagramzone" name="txt_copydiagramzone" maxlength="500" value="" >
                                    </div>
                                </div> -->
                                
                                <div class="col-lg-1">
                                    <label>&nbsp;</label>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-default" onclick="select_emsp2();">ค้นหา <li class="fa fa-search"></li></button>
                                    </div>

                                </div>
                            </div>

                            <!-- <div class="col-lg-2" style="text-align: left">
                                <label>&nbsp;</label><br>
                                <a href="#" onclick="excel_reporttransportcover();" class="btn btn-success  ">EXCEL <li class="fa fa-file-excel-o"></li></a>
                                <a href="#" onclick="pdf_reporttransportcover();" class="btn btn-danger">PDF <li class="fa fa-file-pdf-o"></li></a>

                            </div> -->
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">

                                        <div class="row">
                                            <div class="col-sm-6">รายละเอียดข้อมูลการแจ้งซ่อมจาก EMS Phase2 ทะเบียน : <b>(<?=$result_info['VEHICLEREGISNUMBER'] ?>)</b> | ชื่อรถ: <b>(<?=$result_info['THAINAME'] ?>)</b></div>
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
                                                            <div id="datadef_emsp2">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example_emsp2" role="grid" aria-describedby="dataTables-example_info" >
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 5px;">ลำดับnew</th>
                                                                        <th style="width: 40px;">วันที่แจ้งซ่อม</th>
                                                                        <th style="width: 70px;">ผู้แจ้งซ่อม</th>
                                                                        <th style="width: 50px;">รายการซ่อม</th>
                                                                        <th style="width: 50px;">ประเภทการซ่อม</th>
                                                                        <th style="width: 50px;">ช่างผู้รับผิดชอบ</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="text-align: center"></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td style=""></td>
                                                                        <td style=""></td>
                                                                        <td style=""></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            </div>
                                                            <div id="datasr_emsp2"></div>
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
            </div>

            <!-- this will show our spinner -->
            <div  id="loading" class="center" >
                <p><img style="" src="../images/truckload5.gif" /></p>
            </div>

            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <!-- <script src="../vendor/metisMenu/metisMenu.min.js"></script> -->
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <!-- <script src="../dist/js/sb-admin-2.js"></script> -->
            <script src="../js/jquery.datetimepicker.full.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../js/bootstrap-datepicker.min.js"></script>
            <script src="../js/bootstrap-datepicker.th.min.js"></script>     
            
            
            <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->
            <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.js"></script>
            <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.dataTables.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
            <!-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script> -->
            <script src="//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json"></script>
            <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.html5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.colVis.min.js"></script>

            <!-- Zoom Js -->
            <!-- <script src="js/zoom.js"></script> -->
            <!-- Swal Alert2 -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

    </body>
    <script>

                                                // Get the modal
                                                var modal = document.getElementById('myModal');

                                                // Get the image and insert it inside the modal - use its "alt" text as a caption
                                                var img = document.getElementById('myImg');
                                                var modalImg = document.getElementById("img01");
                                                var captionText = document.getElementById("caption");
                                                img.onclick = function(){
                                                    modal.style.display = "block";
                                                    modalImg.src = this.src;
                                                    captionText.innerHTML = this.alt;
                                                }

                                                // Get the <span> element that closes the modal
                                                var span = document.getElementsByClassName("close")[0];

                                                // When the user clicks on <span> (x), close the modal
                                                span.onclick = function() { 
                                                    modal.style.display = "none";
                                                }

                                                // วันที่ซื้อ
                                                $('.datebuy').datetimepicker({
                                                    format: "d/m/Y",
                                                    language: "th",
                                                    timepicker: false,
                                                    scrollInput : false,
                                                });                   


                                                // วันที่ต่อโครงสร้าง
                                                $('.datevehiclestructure').datetimepicker({
                                                    format: "d/m/Y",
                                                    language: "th",
                                                    timepicker: false,
                                                    scrollInput : false,
                                                    // todayHighlight: true,
                                                    
                                                });   

                                                // วันที่จดทะเบียน
                                                $('.datevehicleregister').datetimepicker({
                                                    format: "d/m/Y",
                                                    language: "th",
                                                    timepicker: false,
                                                    scrollInput : false,
                                                    // todayHighlight: true,
                                                    
                                                });  

                                                // วันที่จดทะเบียนครั้งแรก
                                                $('.datevehicleregisterfirstdate').datetimepicker({
                                                    format: "d/m/Y",
                                                    language: "th",
                                                    timepicker: false,
                                                    scrollInput : false,
                                                    // todayHighlight: true,
                                                    
                                                }); 

                                                // วันที่หมดอายุตามป้ายภาษี
                                                $('.datetaxexpired').datetimepicker({
                                                    format: "d/m/Y",
                                                    language: "th",
                                                    timepicker: false,
                                                    scrollInput : false,
                                                    // todayHighlight: true,
                                                    
                                                }); 

                                                
                                                // $(document).ready(function () {
                                                //     $('#dataTables-example').DataTable({
                                                //         order: [[0, "desc"]],
                                                //         scrollX: true,
                                                //         scrollY: '500px',
                                                //     });
                                                // });
                                                function closemodal() {
                                                    modal.style.display = "none";
                                                }
                                                function checknumber(value,check)
                                                {
                                                    // alert(value);
                                                    // alert(check);

                                                    var elem = value;
                                                    if(!elem.match(/^([0-9.])+$/i))
                                                    {
                                                        // alert("กรอกได้เฉพาะตัวเลขและตัวอักษรภาษาอังกฤษเท่านั้น");
                                                        swal.fire({
                                                            title: "Warning !",
                                                            text: "กรอกได้เฉพาะตัวเลขเท่านั้น !!!",
                                                            showConfirmButton: true,
                                                            allowOutsideClick: false,
                                                            icon: "warning"
                                                        });

                                                        if(check == 'truckweight'){
                                                            document.getElementById('txt_weight').value = "0";
                                                        }else if(check == 'maximunload'){
                                                            document.getElementById('txt_maxload').value = "0";
                                                        }else if(check == 'totalweight') {
                                                            document.getElementById('txt_totalweight').value = "0";
                                                        }else if(check == 'horsepower') {
                                                            document.getElementById('txt_horse').value = "0";
                                                        }else if(check == 'cc') {
                                                            document.getElementById('txt_cc').value = "0";
                                                        }else if(check == 'vehiclebuyprice') {
                                                            document.getElementById('txt_vehiclebuyprice').value = "0";
                                                        }else if(check == 'vehiclestructuredprice') {
                                                            document.getElementById('txt_vehiclestructuredprice').value = "0";
                                                        }else{
                                                            
                                                        }
                                                        
                                                    }
                                                }
                                                function confirm_data(vehicleinfoid)
                                                {
                                                    // alert('delete');
                                                    // alert(labotrondataid);

                                                    Swal.fire({
                                                        title: 'ต้องการยืนยันข้อมูลหรือไม่?',
                                                        text: "กรุณากด 'ตกลง' เพื่อยืนยันข้อมูล!!!",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'ตกลง',
                                                        cancelButtonText: 'ยกเลิก',
                                                        allowOutsideClick: false,
                                                    }).then((result) => {
                                                        
                                                        if (result.isConfirmed) {
                                                            
                                                            save_vehicleinfo(vehicleinfoid);
                                                            



                                                        }else{
                                                            //else check การลบข้อมูล
                                                            // window.location.reload();
                                                        }
                                                    })
                                                    
                                                }
                                                function save_vehicleinfo(vehicleinfoid)
                                                {
                                                    var vehiclenumber = document.getElementById('txt_vehiclenumber').value;
                                                    var cargroup = document.getElementById('cb_cargroup').value;
                                                    var cartype = document.getElementById('cb_cartype').value;
                                                    var carbrand = document.getElementById('cb_carbrand').value;
                                                    var geartype = document.getElementById('cb_geartype').value;
                                                    var carcolor = document.getElementById('cb_carcolor').value;
                                                    var series_model = document.getElementById('txt_series_model').value;
                                                    var carnameth = document.getElementById('txt_carnameth').value;
                                                    var carnameen = document.getElementById('txt_carnameen').value;
                                                    var truckline = document.getElementById('txt_truckline').value;
                                                    var horse = document.getElementById('txt_horse').value;
                                                    var cc = document.getElementById('txt_cc').value;
                                                    var taxexpireddate = document.getElementById('txt_taxexpireddate').value;
                                                    var machine = document.getElementById('txt_machine').value;
                                                    var chassisnumber = document.getElementById('txt_chassisnumber').value;
                                                    var gps = document.getElementById('txt_gps').value;
                                                    var insurance = document.getElementById('txt_insurance').value;
                                                    var energy = document.getElementById('cb_energy').value;
                                                    var weight = document.getElementById('txt_weight').value;
                                                    var axle = document.getElementById('cb_axle').value;
                                                    var piston = document.getElementById('cb_piston').value;
                                                    var maxload = document.getElementById('txt_maxload').value;
                                                    var totalweight = document.getElementById('txt_totalweight').value;
                                                    var truckdi = document.getElementById('txt_truckdimension').value;
                                                    var cargodi = document.getElementById('txt_cargodimension').value;
                                                    var fueltankcap = document.getElementById('txt_fueltankcap').value;
                                                    var speedlimit = document.getElementById('txt_speedlimit').value;
                                                    var used = document.getElementById('cb_used').value;
                                                    var vehiclebuywhere = document.getElementById('txt_vehiclebuywhere').value;
                                                    var vehiclebuydate = document.getElementById('txt_vehiclebuydate').value;
                                                    var vehiclebuyprice = document.getElementById('txt_vehiclebuyprice').value;
                                                    var vehiclebuyconditon = document.getElementById('cb_vehiclebuyconditon').value;
                                                    var vehiclestructurewhere = document.getElementById('txt_vehiclestructurewhere').value;
                                                    var vehiclestructuredate = document.getElementById('txt_vehiclestructuredate').value;
                                                    var vehiclestructuredprice = document.getElementById('txt_vehiclestructuredprice').value;
                                                    var vehicleregisterdate = document.getElementById('txt_vehicleregisterdate').value;
                                                    var vehicleregisterfirstdate = document.getElementById('txt_vehicleregisterfirstdate').value;
                                                    var vehiclespecial = document.getElementById('txt_vehiclespecial').value;
                                                    var affcompany = document.getElementById('txt_affcompany').value;
                                                    var inforemark = document.getElementById('txt_inforemark').value;
                                                    var carstatus = document.getElementById('cb_carstatus').value;

                                                    if (cartype == 'VT-1412-0689') {
                                                        cartypechk = '8L';
                                                    }else if(cartype == 'VT-1411-0911'){
                                                        cartypechk = '4L';
                                                    }else{
                                                        cartypechk = cartype;
                                                    }    

                                                    // alert(vehicleregisterfirstdate);
                                                        
                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "save_vehicleinfo", 
                                                                vehicleinfoid: vehicleinfoid, 
                                                                vehiclenumber: vehiclenumber, 
                                                                cargroup: cargroup, 
                                                                cartype: cartypechk, 
                                                                carbrand: carbrand, 
                                                                geartype: geartype, 
                                                                carcolor: carcolor, 
                                                                series_model: series_model, 
                                                                carnameth: carnameth, 
                                                                carnameen: carnameen, 
                                                                truckline: truckline, 
                                                                horse: horse, 
                                                                cc: cc, 
                                                                taxexpireddate:taxexpireddate,
                                                                machine: machine, 
                                                                chassisnumber: chassisnumber,
                                                                gps: gps,
                                                                insurance: insurance, 
                                                                energy: energy, 
                                                                weight: weight, 
                                                                axle: axle, 
                                                                piston: piston, 
                                                                maxload: maxload, 
                                                                totalweight:totalweight,
                                                                truckdi: truckdi, 
                                                                cargodi: cargodi, 
                                                                fueltankcap: fueltankcap, 
                                                                speedlimit: speedlimit, 
                                                                used: used, 
                                                                vehiclebuywhere: vehiclebuywhere, 
                                                                vehiclebuydate: vehiclebuydate, 
                                                                vehiclebuyprice: vehiclebuyprice, 
                                                                vehiclebuyconditon: vehiclebuyconditon, 
                                                                vehiclestructurewhere: vehiclestructurewhere, 
                                                                vehiclestructuredate: vehiclestructuredate, 
                                                                vehiclestructuredprice: vehiclestructuredprice, 
                                                                vehicleregisterdate: vehicleregisterdate, 
                                                                vehicleregisterfirstdate:vehicleregisterfirstdate,
                                                                vehiclespecial: vehiclespecial, 
                                                                affcompany: affcompany, 
                                                                inforemark: inforemark, 
                                                                carstatus: carstatus
                                                            },
                                                            success: function (response) {
                                                                alert(response);
                                                                swal.fire({
                                                                    title: "Good Job!",
                                                                    text: "ยืนยันข้อมูลเรียบร้อย",
                                                                    showConfirmButton: false,
                                                                    allowOutsideClick: false,
                                                                    icon: "success"
                                                                });
                                                                // alert(rs);   
                                                                setTimeout(() => {
                                                                    document.location.reload();
                                                                }, 1500);
                                                                // window.location.reload();
                                                            }
                                                        });

                                                    
                                                }
                                                
                                                function select_emsp1() {

                                                    var datestart   = document.getElementById('txt_datestart_emsp1').value;
                                                    var dateend     = document.getElementById('txt_dateend_emsp1').value;
                                                    var vehicleregisnumber = '<?=$result_info['VEHICLEREGISNUMBER'] ?>';
                                                    var thainame = '<?=$result_info['THAINAME'] ?>';
                                                    // var companycode  = document.getElementById('txt_companycode').value;

                                                    // alert(datestart);
                                                    // alert(dateend);
                                                    // alert(companycode);
                                                    // alert(customercode);
                                                    // alert(status);
                                                    // alert(vehicleregisnumber);
                                                    // รูปแบบ เดือน/วัน/ปี

                                                    // วันที่เริ่มต้น
                                                    let textdatestart = datestart;
                                                    //วัน
                                                    let resultstart1 = textdatestart.substring(0,2);
                                                    // เดือน
                                                    let resultstart2 = textdatestart.substring(3,5);
                                                    // ปี
                                                    let resultstart3 = textdatestart.substring(6,10);

                                                    var date1 = new Date(resultstart2+"/"+resultstart1+"/"+resultstart3);

                                                    ///////////////////////////////////////
                                                    // รูปแบบ เดือน/วัน/ปี
                                                    // วันที่สิ้นสุด
                                                    let textdateend = dateend;
                                                    //วัน
                                                    let resultend1 = textdateend.substring(0,2);
                                                    // เดือน
                                                    let resultend2 = textdateend.substring(3,5);
                                                    // ปี
                                                    let resultend3 = textdateend.substring(6,10);

                                                    var date2 = new Date(resultend2+"/"+resultend1+"/"+resultend3);
                                                    ///////////////////////////////////////

                                                    // var date1 = new Date("01/21/2022");
                                                    // var date2 = new Date("01/31/2022");

                                                    var diffTime = date2.getTime() - date1.getTime();
                                                    var diffDay = diffTime / (1000 * 3600 * 24);


                                                    if (datestart == '') {
                                                        
                                                        swal.fire({
                                                            title: "Warning !",
                                                            text: "กรุณาเลือกวันที่เริ่มต้น",
                                                            icon: "warning",
                                                        });
                                                                
                                                    // }else if (diffDay > "31"){

                                                    //     swal.fire({
                                                    //         title: "Warning !",
                                                    //         text: "เลือกข้อมูลสูงสุดได้ 31 วันเท่านั้น",
                                                    //         icon: "warning",
                                                    //     });

                                                    }else{

                                                        showLoading();
                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data_reportVehicleExport.php',
                                                            data: {
                                                                txt_flg: "select_emsp1", datestart: datestart,dateend: dateend,vehicleregisnumber: vehicleregisnumber,thainame: thainame
                                                            },
                                                            success: function (response) {
                                                                
                                                                
                                                                    hideLoading();
                                                                    // alert('โหลดข้อมูลเรียบร้อย');
                                                                    swal.fire({
                                                                        title: "Good Job!",
                                                                        text: "โหลดข้อมูลเรียบร้อย",
                                                                        icon: "success",
                                                                    });
                                                                    
                                                                    if (response)
                                                                    {
                                                                        document.getElementById("datasr_emsp1").innerHTML = response;
                                                                        document.getElementById("datadef_emsp1").innerHTML = "";
                                                                    }
                                                                    $(document).ready(function () {
                                                                        $('#dataTables-example_emsp1').DataTable({
                                                                            // responsive: true,
                                                                            order: [[0, 'asc']],
                                                                            scrollX: true,
                                                                            scrollY: '450px',
                                                                            charset: 'UTF-8',
                                                                            fieldSeparator: ';',
                                                                            bom: true,
                                                                            // dom: 'Bfrtip',
                                                                            lengthMenu: [
                                                                                        [ 10, 15, 20, -1 ],
                                                                                        [ '10 rows', '15 rows', '20 rows', 'Show all' ]
                                                                                    ],
                                                                            layout: {
                                                                                topStart: {
                                                                                        
                                                                                    buttons: [
                                                                                        {
                                                                                            
                                                                                            extend: 'pageLength'
                                                                                        },
                                                                                        'colvis'
                                                                                        ,
                                                                                        {
                                                                                            exportOptions: {
                                                                                                columns: ':visible'
                                                                                            },
                                                                                            extend: 'excelHtml5',
                                                                                            title: 'รายงานข้อมูลการแจ้งซ่อมรถบรรทุก'
                                                                                            
                                                                                        }
                                                                                    ]
                                                                                }
                                                                            }


                                                                        });
                                                                    });
                                                            
                                                            
                                                            
                                                                

                                                                
                                                            }
                                                        });
                                                    }

                                                }
                                                function select_emsp2() {

                                                    swal.fire({
                                                        title: "Pending !!",
                                                        text: "อยู่ระหว่างดำเนินการเชื่อมต่อข้อมูล !!!",
                                                        icon: "warning",
                                                        showConfirmButton: true,
                                                        allowOutsideClick: false
                                                    });

                                                    // var datestart   = document.getElementById('txt_datestart_emsp2').value;
                                                    // var dateend     = document.getElementById('txt_dateend_emsp2').value;
                                                    // var vehicleregisnumber = '<?=$result_info['VEHICLEREGISNUMBER'] ?>';
                                                    // var thainame = '<?=$result_info['THAINAME'] ?>';
                                                    // // var companycode  = document.getElementById('txt_companycode').value;

                                                    // // alert(datestart);
                                                    // // alert(dateend);
                                                    // // alert(companycode);
                                                    // // alert(customercode);
                                                    // // alert(status);
                                                    // // รูปแบบ เดือน/วัน/ปี

                                                    // // วันที่เริ่มต้น
                                                    // let textdatestart = datestart;
                                                    // //วัน
                                                    // let resultstart1 = textdatestart.substring(0,2);
                                                    // // เดือน
                                                    // let resultstart2 = textdatestart.substring(3,5);
                                                    // // ปี
                                                    // let resultstart3 = textdatestart.substring(6,10);

                                                    // var date1 = new Date(resultstart2+"/"+resultstart1+"/"+resultstart3);

                                                    // ///////////////////////////////////////
                                                    // // รูปแบบ เดือน/วัน/ปี
                                                    // // วันที่สิ้นสุด
                                                    // let textdateend = dateend;
                                                    // //วัน
                                                    // let resultend1 = textdateend.substring(0,2);
                                                    // // เดือน
                                                    // let resultend2 = textdateend.substring(3,5);
                                                    // // ปี
                                                    // let resultend3 = textdateend.substring(6,10);

                                                    // var date2 = new Date(resultend2+"/"+resultend1+"/"+resultend3);
                                                    // ///////////////////////////////////////

                                                    // // var date1 = new Date("01/21/2022");
                                                    // // var date2 = new Date("01/31/2022");

                                                    // var diffTime = date2.getTime() - date1.getTime();
                                                    // var diffDay = diffTime / (1000 * 3600 * 24);


                                                    // if (datestart == '') {
                                                        
                                                    //     swal.fire({
                                                    //         title: "Warning !",
                                                    //         text: "กรุณาเลือกวันที่เริ่มต้น",
                                                    //         icon: "warning",
                                                    //     });
                                                                
                                                    // }else if (diffDay > "31"){

                                                    //     swal.fire({
                                                    //         title: "Warning !",
                                                    //         text: "เลือกข้อมูลสูงสุดได้ 31 วันเท่านั้น",
                                                    //         icon: "warning",
                                                    //     });

                                                    // }else{

                                                    //     showLoading();
                                                    //     $.ajax({
                                                    //         type: 'post',
                                                    //         url: 'meg_data_reportVehicleExport.php',
                                                    //         data: {
                                                    //             txt_flg: "select_emsp2", datestart: datestart,dateend: dateend
                                                    //         },
                                                    //         success: function (response) {
                                                                
                                                                
                                                    //                 hideLoading();
                                                    //                 // alert('โหลดข้อมูลเรียบร้อย');
                                                    //                 swal.fire({
                                                    //                     title: "Good Job!",
                                                    //                     text: "โหลดข้อมูลเรียบร้อย",
                                                    //                     icon: "success",
                                                    //                 });
                                                                    
                                                    //                 if (response)
                                                    //                 {
                                                    //                     document.getElementById("datasr_emsp2").innerHTML = response;
                                                    //                     document.getElementById("datadef_emsp2").innerHTML = "";
                                                    //                 }
                                                    //                 $(document).ready(function () {
                                                    //                     $('#dataTables-example_emsp2').DataTable({
                                                    //                         // responsive: true,
                                                    //                         order: [[0, 'asc']],
                                                    //                         scrollX: true,
                                                    //                         scrollY: '450px',
                                                    //                         charset: 'UTF-8',
                                                    //                         fieldSeparator: ';',
                                                    //                         bom: true,
                                                    //                         // dom: 'Bfrtip',
                                                    //                         lengthMenu: [
                                                    //                                     [ 10, 15, 20, -1 ],
                                                    //                                     [ '10 rows', '15 rows', '20 rows', 'Show all' ]
                                                    //                                 ],
                                                    //                         layout: {
                                                    //                             topStart: {
                                                                                        
                                                    //                                 buttons: [
                                                    //                                     {
                                                                                            
                                                    //                                         extend: 'pageLength'
                                                    //                                     },
                                                    //                                     'colvis'
                                                    //                                     ,
                                                    //                                     {
                                                    //                                         exportOptions: {
                                                    //                                             columns: ':visible'
                                                    //                                         },
                                                    //                                         extend: 'excelHtml5',
                                                    //                                         title: 'รายงานข้อมูลการแจ้งซ่อมรถบรรทุก'
                                                                                            
                                                    //                                     }
                                                    //                                 ]
                                                    //                             }
                                                    //                         }


                                                    //                     });
                                                    //                 }); 
                                                    //         }
                                                    //     });
                                                    // }

                                                }
                                                // data table ข้อมูลการแจ้งซ่อมจาก EMS Phase1
                                                $(document).ready(function () {
                                                            
                                                    $('#dataTables-example_emsp1').DataTable({

                                                        // order: [[0, 'asc']],
                                                        // scrollX: true,
                                                        // scrollY: '500px',
                                                        // charset: 'UTF-8',
                                                        // fieldSeparator: ';',
                                                        // bom: true,
                                                        // // dom: 'Bfrtip',
                                                        // lengthMenu: [
                                                        //             [ 10, 15, 20, -1 ],
                                                        //             [ '10 rows', '15 rows', '20 rows', 'Show all' ]
                                                        //         ],
                                                        // layout: {
                                                        //     topStart: {
                                                                    
                                                        //         buttons: [
                                                        //             {
                                                                        
                                                        //                 extend: 'pageLength'
                                                        //             },
                                                        //             'colvis'
                                                        //             ,
                                                        //             {
                                                        //                 exportOptions: {
                                                        //                     columns: ':visible'
                                                        //                 },
                                                        //                 extend: 'excelHtml5'
                                                                        
                                                        //             }
                                                        //         ]
                                                        //     }
                                                        // }


                                                    });
                                                });

                                                // data table ข้อมูลการแจ้งซ่อมจาก EMS Phase2
                                                $(document).ready(function () {
                                                            
                                                    $('#dataTables-example_emsp2').DataTable({

                                                        // order: [[0, 'asc']],
                                                        // scrollX: true,
                                                        // scrollY: '250px',
                                                        // charset: 'UTF-8',
                                                        // fieldSeparator: ';',
                                                        // bom: true,
                                                        // // dom: 'Bfrtip',
                                                        // lengthMenu: [
                                                        //             [ 10, 15, 20, -1 ],
                                                        //             [ '10 rows', '15 rows', '20 rows', 'Show all' ]
                                                        //         ],
                                                        // layout: {
                                                        //     topStart: {
                                                                    
                                                        //         buttons: [
                                                        //             {
                                                                        
                                                        //                 extend: 'pageLength'
                                                        //             },
                                                        //             'colvis'
                                                        //             ,
                                                        //             {
                                                        //                 exportOptions: {
                                                        //                     columns: ':visible'
                                                        //                 },
                                                        //                 extend: 'excelHtml5'
                                                                        
                                                        //             }
                                                        //         ]
                                                        //     }
                                                        // }


                                                    });
                                                });

                                            $(function () {
                                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                // กรณีใช้แบบ input
                                                $(".dateen_emsp1").datetimepicker({
                                                    timepicker: false,
                                                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                    scrollInput : false,

                                                });
                                            });
                                            $(function () {
                                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                // กรณีใช้แบบ input
                                                $(".dateen_emsp2").datetimepicker({
                                                    timepicker: false,
                                                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                    scrollInput : false,


                                                });
                                            });

                                            function showLoading() {
                                                $("#loading").show();
                                                
                                            }

                                            function hideLoading() {
                                                $("#loading").hide();
                                            }

                                            function datetodate_emsp1()
                                            {
                                                document.getElementById('txt_dateend_emsp1').value = document.getElementById('txt_datestart_emsp1').value;

                                            }
                                            function datetodate_emsp2()
                                            {
                                                document.getElementById('txt_dateend_emsp2').value = document.getElementById('txt_datestart_emsp2').value;

                                            } 
                                            function pdf_printvehicleinfo(vehicleinfoid)
                                            {
                                                window.open('pdf_reportvehicleinfoamt.php?vehicleinfoid=' + vehicleinfoid, '_blank');
                                            }
    </script>
</html>
<?php
sqlsrv_close($conn);
?>
