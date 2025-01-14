
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
                        <div class="panel-body">
                            <div class="col-lg-12" style="text-align: center;font-size: 35px;">
                                <label>GPS Auditing</label>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-md-3" >
                                        <label>บริษัท</label>
                                        <select class="form-control"  id="cb_company" name="cb_company" >
                                            <option value = "" disabled selected>เลือกบริษัท</option>
                                            <option value = "RCC">บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์ จำกัด (RCC)</option>
                                            <option value = "RATC">บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต จำกัด (RATC)</option>
                                            <option value = "RRC">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด (RRC)</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <button class="btn btn-primary"  onclick="select_gpsauditing();">ค้นหา <li class="fa fa-search"></li></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                        <div id="datadef">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example" style="width: 100%;">
                                                        <thead>
                                                            <tr>

                                                                <th><label style="width: 100px">ลำดับ</label></th>
                                                                <th><label style="width: 100px">บริษัทสังกัด</label></th>
                                                                <th><label style="width: 100px">สายงาน</label></th>           
                                                                <th><label style="width: 100px">ชื่อรถ (ไทย)</label></th>
                                                                <th><label style="width: 100px">ชื่อรถ (อังกฤษ)</label></th> 
                                                                <th><label style="width: 100px">ทะเบียนรถ</label></th>
                                                                <th><label style="width: 100px;text-align: center">GPS <br>Auditing</label></th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            // $condition1 = " AND (a.THAINAME NOT LIKE '%R-%' OR a.THAINAME NOT LIKE '%RA-%' OR a.THAINAME NOT LIKE '%RP-%'";
                                                            // $condition2 = " OR a.THAINAME NOT LIKE '%คลองเขื่อน%'  OR a.THAINAME NOT LIKE '%ด่านช้าง%'  OR a.THAINAME NOT LIKE '%สวนผึ้ง%' ";
                                                            // $condition3 = " OR a.ENGNAME NOT LIKE '%ดินแดง%' OR a.ENGNAME NOT LIKE '%อุทัยธานี%' OR a.ENGNAME NOT LIKE '%Kerry%'";
                                                            // $condition4 = " OR a.THAINAME NOT LIKE '%เขาชะเมา%' OR a.THAINAME NOT LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME NOT LIKE '%P35%' )";
                                                            $i = 1;
                                                            $condition1 = "AND a.VEHICLEGROUPCODE !='VG-1403-0755' AND a.AFFCOMPANY IN ('RRC','RCC','RATC') ORDER BY a.AFFCOMPANY,a.AFFCUSTOMER,a.VEHICLEINFOID,a.THAINAME ASC";
                                                            $condition2 = "";
                                                            $condition3 = "";
                                                            $condition4 = "";
                                                            $sql_infolist = "{call megVehicleinfo_v2(?,?,?,?,?)}";
                                                            $params_infolist = array(
                                                                array('selectcond_vehicleinfo', SQLSRV_PARAM_IN),
                                                                array($condition1, SQLSRV_PARAM_IN),
                                                                array($condition2, SQLSRV_PARAM_IN),
                                                                array($condition3, SQLSRV_PARAM_IN),
                                                                array($condition4, SQLSRV_PARAM_IN)
                                                            );

                                                            $query_infolist = sqlsrv_query($conn, $sql_infolist, $params_infolist);
                                                            while ($result_infolist = sqlsrv_fetch_array($query_infolist, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr>
                                                                    <td><?= $i ?></td>
                                                                    <td><?= $result_infolist['AFFCOMPANY'] ?></td>
                                                                    <td><?= $result_infolist['AFFCUSTOMER'] ?></td>
                                                                    <td><?= $result_infolist['THAINAME'] ?></td>
                                                                    <td><?= $result_infolist['ENGNAME'] ?></td>
                                                                    <td><?= $result_infolist['VEHICLEREGISNUMBER'] ?></td>
                                                                    <td style="text-align: center">
                                                                        <a style="background-color: #e0e0e0;" placeholder ="ลงข้อมูล" href='meg_gpsauditingskp.php?vehicleinfoid=<?= $result_infolist['VEHICLEINFOID'] ?>&vehicletransportplanid=<?= $result_infolist['VEHICLETRANSPORTPLANID'] ?>&meg=edit' target="_bank" class='list-group-item'><span class="glyphicon glyphicon-road"></span></a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $i++;
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


    </body>
    <script>


                                        function select_gpsauditing(){

                                            // showLoading();
                                            var companycode = $("#cb_company").val();

                                            $.ajax({
                                                url: 'meg_data_gpsaudit.php',
                                                type: 'POST',
                                                data: {
                                                    txt_flg: "select_gpsauditing", companycode: companycode
                                                },
                                                success: function (rs) {
                                                    // hideLoading();
                                                    document.getElementById("datadef").innerHTML = "";
                                                    document.getElementById("datasr").innerHTML = rs;

                                                    // save_logprocess('Tenko', 'Select Company', '<?= $result_seLogin['PersonCode'] ?>');

                                                    // swal.fire({
                                                    //     title: "Good Job!",
                                                    //     text: "โหลดข้อมูลเรียบร้อยแล้ว !!",
                                                    //     icon: "success",
                                                    //     showConfirmButton: true,
                                                    // });


                                                    $(document).ready(function () {
                                                        $('#dataTables-example1').DataTable({
                                                            order: [[0, "desc"]],
                                                            scrollX: true,
                                                            scrollY: '500px',
                                                        });
                                                    });

                                                    // $('#dataTables-example2').DataTable({
                                                    //     responsive: true
                                                    // });
                                                    // $('#dataTables-example3').DataTable({
                                                    //     responsive: true
                                                    // });
                                                    // $('#dataTables-example4').DataTable({
                                                    //     responsive: true
                                                    // });

                                                    $(function () {
                                                        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                        // กรณีใช้แบบ input
                                                        $(".dateen").datetimepicker({
                                                            timepicker: false,
                                                            format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                            lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                            minDate: 0,

                                                        });
                                                    });
                                                }
                                                
                                            });




                                        }

                                        $(document).ready(function () {
                                            $('#dataTables-example').DataTable({
                                                order: [[0, "desc"]],
                                                scrollX: true,
                                                scrollY: '500px',
                                            });
                                        });

                                        function delete_vehicleinfo(vehicleinfoid)
                                        {
                                            var confirmation = confirm("ต้องการลบข้อมูล ?");

                                            if (confirmation) {
                                                $.ajax({
                                                    type: 'post',
                                                    url: 'meg_data.php',
                                                    data: {
                                                        txt_flg: "delete_vehicleinfo", vehicleinfoid: vehicleinfoid
                                                    },
                                                    success: function () {
                                                        alert('ลบข้อมูลเรียบร้อยแล้ว');
                                                        window.location.reload();
                                                    }
                                                });
                                            }
                                        }

                                        function add_vehicleinfo()
                                        {

                                            window.open('meg_vehicleinfoamata.php?vehicleinfoid=&meg=add', '_blank');
                                            // href='meg_vehicleinfoamata.php?vehicleinfoid=&meg=add'

                                            
                                        }
    </script>
</html>
<?php
sqlsrv_close($conn);
?>
