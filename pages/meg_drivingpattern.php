
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

// echo $_SESSION["USERNAME"];
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
        <!-- <link href="../dist/css/bootstrap-select.css" rel="stylesheet"> -->

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
    </head>
<style>
   .button {
        background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
    }
    .glyphicon {
        font-size: 20px;
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
    <body>
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
                <!-- <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">

                            <li><a href="meg_logout.php"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
                            </li>
                        </ul>
                    </li>
                </ul> -->
            </nav>

            <!-- <div id="page-wrapper" > -->
                <!-- <div class="row">
                    <div class="col-lg-12">&nbsp;</div>
                </div> -->

                <!-- <div class="tab-content"> -->
                    <!-- <div class="row">
                        <div class="col-lg-12">&nbsp;</div>
                    </div> -->


                    <!-- /.row -->
                    <div class="row">

                        <div class="row">
                            <div class="col-lg-12">&nbsp;</div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-lg-6">&nbsp;</div>
                            <div class="col-lg-6" style="text-align:right;">
                                <button class="button" style="background-color: #4CAF50;" onclick="add_vehicleinfo();">เพิ่มข้อมูลรถ</button>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="panel-body">
                                <div class="col-lg-12" >
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>ค้นหาตามช่วงวันที่</label>
                                            <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-default" onclick="select_drivingpattern();">ค้นหา <li class="fa fa-search"></li></button>
                                        </div>
                                    </div>
                                    <div class="col-lg-5" style="text-align: left;">
                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <h4><font color="red">(ข้อมูลที่แสดงบนตารางคือข้อมูลวันที่ย้อนหลัง 3 วันจนถึงวันที่ปัจจุบัน)</font></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="col-lg-12">
                            <div class="panel panel-default">

                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <div class="row">
                                        
                                        <div class="col-sm-6"><a href='index2.php'>หน้าแรก</a> / ข้อมูลรถพื้นที่อมตะ สำหรับลงข้อมูล SKP </div>
                                        <!-- <div class="col-sm-6 text-right"><a target="_bank" href='meg_vehicleinfoamata.php?vehicleinfoid=&meg=add'>เพิ่มข้อมูลรถ</a></div> -->
                                       
                                    </div>
                                </div>
                              

                                <div class="panel-body">
                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                        <div id="datadef">       
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example" style="width: 100%;">
                                                        <thead>
                                                            <tr>   
                                                                <th><label style="width: 100px">เลขที่แผนงาน</label></th>
                                                                <th><label style="width: 100px">พนักงานคนที่1</label></th>
                                                                <th><label style="width: 100px">บริษัทสังกัด</label></th>
                                                                <th><label style="width: 100px">สายงานสังกัด</label></th>
                                                                <th><label style="width: 100px">ชื่อรถ (ไทย)</label></th>
                                                                <th><label style="width: 100px">เลขทะเบียนรถ</label></th>
                                                                <th><label style="width: 100px;text-align: center">Driving <br>Pattern</label></th>
                                                                <th><label style="width: 100px;text-align: center">สถานะ <br>ขาไป</label></th>
                                                                <th><label style="width: 100px;text-align: center">สถานะ <br>ขากลับ</label></th>
                                                                <th><label style="width: 100px;text-align: center">วันที่วิ่งงาน</label></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            // $condition1 = " AND (a.THAINAME NOT LIKE '%R-%' OR a.THAINAME NOT LIKE '%RA-%' OR a.THAINAME NOT LIKE '%RP-%'";
                                                            // $condition2 = " OR a.THAINAME NOT LIKE '%คลองเขื่อน%'  OR a.THAINAME NOT LIKE '%ด่านช้าง%'  OR a.THAINAME NOT LIKE '%สวนผึ้ง%' ";
                                                            // $condition3 = " OR a.ENGNAME NOT LIKE '%ดินแดง%' OR a.ENGNAME NOT LIKE '%อุทัยธานี%' OR a.ENGNAME NOT LIKE '%Kerry%'";
                                                            // $condition4 = " OR a.THAINAME NOT LIKE '%เขาชะเมา%' OR a.THAINAME NOT LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME NOT LIKE '%P35%' )";

                                                            $condition1 = "AND c.VEHICLEGROUPCODE !='VG-1403-0755' AND c.AFFCOMPANY IN ('RRC','RCC','RATC') 
                                                                           AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,DATEADD(DAY,-3,GETDATE())) AND CONVERT(DATE,GETDATE())
                                                                           AND a.EMPLOYEECODE1 ='".$_SESSION["USERNAME"]."'
                                                                           ORDER BY a.DATEWORKING,c.AFFCOMPANY,c.AFFCUSTOMER,a.THAINAME ASC";
                                                            $condition2 = "";
                                                            $condition3 = "";
                                                            $condition4 = "";
                                                            $condition5 = "";
                                                            $sql_infolist = "{call megDrivingPatternDriver(?,?,?,?,?,?,?)}";
                                                            $params_infolist = array(
                                                                array('select_vehicleinfo_drivingpattern', SQLSRV_PARAM_IN),
                                                                array('', SQLSRV_PARAM_IN),
                                                                array($condition1, SQLSRV_PARAM_IN),
                                                                array($condition2, SQLSRV_PARAM_IN),
                                                                array($condition3, SQLSRV_PARAM_IN),
                                                                array($condition4, SQLSRV_PARAM_IN),
                                                                array($condition5, SQLSRV_PARAM_IN)
                                                            );

                                                            $query_infolist = sqlsrv_query($conn, $sql_infolist, $params_infolist);
                                                            while ($result_infolist = sqlsrv_fetch_array($query_infolist, SQLSRV_FETCH_ASSOC)) {

                                                                // สถานะแผนขาไป
                                                                if ($result_infolist['DRIVINGPATTERNGO_STATUS'] == 'inprogess') {
                                                                    $bgcolorgo ="background-color: #f5f2a6";
                                                                    $statustextgo = "อยู่ระหว่างดำเนินการ";
                                                                }else{
                                                                    $bgcolorgo ="background-color: #b3f5a6";
                                                                    $statustextgo = "ดำเนินการเรียบร้อย";
                                                                }

                                                                // สถานะแผนขากลับ
                                                                if ($result_infolist['DRIVINGPATTERNRETURN_STATUS'] == 'inprogess') {
                                                                    $bgcolorback ="background-color: #f5f2a6";
                                                                    $statustextback = "อยู่ระหว่างดำเนินการ";
                                                                }else{
                                                                    $bgcolorback ="background-color: #b3f5a6";
                                                                    $statustextback = "ดำเนินการเรียบร้อย";
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <td><?= $result_infolist['VEHICLETRANSPORTPLANID'] ?></td>
                                                                    <td><?= $result_infolist['EMPLOYEENAME1'] ?></td>
                                                                    <td><?= $result_infolist['AFFCOMPANY'] ?></td>
                                                                    <td><?= $result_infolist['AFFCUSTOMER'] ?></td>
                                                                    <td><?= str_replace("(4L)","",$result_infolist['THAINAME']) ?></td>
                                                                    <td><?= $result_infolist['VEHICLEREGISNUMBER'] ?></td>
                                                                    <td style="text-align: center">
                                                                        <a style="background-color: #e0e0e0;" href='meg_drivingpattern_officer.php?drivinggoplanid=<?= $result_infolist['DRIVINGPATTERNGO_ID'] ?>&drivingbackplanid=<?= $result_infolist['DRIVINGPATTERNRETURN_ID'] ?>' target="_bank" class='list-group-item'><span class="glyphicon glyphicon-list-alt"></span></a>
                                                                    </td>
                                                                    <td style="text-align: center;<?=$bgcolorgo?>"><?= $statustextgo ?></td>
                                                                    <td style="text-align: center;<?=$bgcolorback?>"><?= $statustextback ?></td>
                                                                    <td><?= $result_infolist['DATEWORKING'] ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="datasr"></div>                    
                                    </div>
                                </div>

                                
                               
                            </div>
                        </div>
                    </div>



                <!-- </div> -->
            <!-- </div> -->

            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../js/jquery.datetimepicker.full.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>
            <script src="../dist/js/bootstrap-select.js"></script>

            <!-- <script src="js/zoom.js"></script> -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    </body>
    <script>


                                        

                                        function datetodate()
                                        {
                                            document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                                        }

                                        function select_drivingpattern() {
                                            
                                            var datestart = document.getElementById('txt_datestart').value;
                                            var dateend = document.getElementById('txt_dateend').value;
                                            var employeecode = '<?=$_SESSION["USERNAME"]?>';

                                            if (datestart == '') {
                                                
                                                swal.fire({
                                                    title: "Warning !",
                                                    text: "กรุณาเลือกวันที่เริ่มต้น",
                                                    icon: "warning",
                                                });
                                                        
                                            }else if(dateend == ''){

                                                swal.fire({
                                                    title: "Warning !",
                                                    text: "กรุณาเลือกวันที่สิ้นสุด",
                                                    icon: "warning",
                                                });

                                            }else{

                                                $.ajax({
                                                    type: 'post',
                                                    url: 'meg_data_drivingpattern_driver.php',
                                                    data: {
                                                        txt_flg: "select_drivingpatternskp", datestart: datestart, dateend: dateend,employeecode: employeecode
                                                    },
                                                    success: function (response) {
                                                        
                                                        // hideLoading();
                                                        // alert('โหลดข้อมูลเรียบร้อย');
                                                        
                                                        
                                                        
                                                        document.getElementById("datasr").innerHTML = response;
                                                        document.getElementById("datadef").innerHTML = "";
                                                        
                                                        swal.fire({
                                                            title: "Good Job!",
                                                            text: "โหลดข้อมูลเรียบร้อย",
                                                            icon: "success",
                                                            showConfirmButton: true,
                                                            allowOutsideClick: false
                                                        });

                                                        $(document).ready(function () {
                                                            $('#dataTables-example1').DataTable({
                                                                order: [[0, "desc"]],
                                                                scrollX: true,
                                                                scrollY: '300px',
                                                            });
                                                        });

                                                        
                                                            
                                                    }
                                                });    


                                            }


                                            }                   
                                            
                                
                                            

                                        $(document).ready(function () {
                                            $('#dataTables-example').DataTable({
                                                order: [[0, "desc"]],
                                                scrollX: true,
                                                scrollY: '550px',
                                            });
                                        });

                                        $(function () {
                                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                            // กรณีใช้แบบ input
                                            $(".dateen").datetimepicker({
                                                timepicker: false,
                                                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                            });
                                        });

                                        // function delete_vehicleinfo(vehicleinfoid)
                                        // {
                                        //     var confirmation = confirm("ต้องการลบข้อมูล ?");

                                        //     if (confirmation) {
                                        //         $.ajax({
                                        //             type: 'post',
                                        //             url: 'meg_data.php',
                                        //             data: {
                                        //                 txt_flg: "delete_vehicleinfo", vehicleinfoid: vehicleinfoid
                                        //             },
                                        //             success: function () {
                                        //                 alert('ลบข้อมูลเรียบร้อยแล้ว');
                                        //                 window.location.reload();
                                        //             }
                                        //         });
                                        //     }
                                        // }

                                        // function add_vehicleinfo()
                                        // {

                                        //     window.open('meg_vehicleinfoamata.php?vehicleinfoid=&meg=add', '_blank');
                                        //     // href='meg_vehicleinfoamata.php?vehicleinfoid=&meg=add'

                                            
                                        // }
    </script>
</html>
<?php
sqlsrv_close($conn);
?>
