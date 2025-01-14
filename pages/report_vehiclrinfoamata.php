
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

    </head>

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

                                    <div class="row">
                                        <div class="col-sm-6"><a href='index2.php'>หน้าแรก</a> / ข้อมูลรถพื้นที่อมตะ</div>
                                        <div class="col-sm-6 text-right"><a target="_bank" href='meg_vehiclrinfoamata.php?vehicleinfoid=&meg=add'>เพิ่มข้อมูลรถ</a></div>
                                    </div>
                                    



                                </div>
                                <!-- /.panel-heading -->

                                <div class="panel-body">

                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                        <div class="row">


                                            <div class="col-sm-12">
                                                <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example" style="width: 100%;">
                                                    <thead>
                                                        <tr>

                                                            <th><label style="width: 100px;text-align: center">ลบ</label></th>
                                                            <th><label style="width: 100px;text-align: center">แก้ไข</label></th>
                                                            <th><label style="width: 100px">เลขทะเบียนรถ</label></th>
                                                            <th><label style="width: 100px">กลุ่มรถ</label></th>
                                                            <th><label style="width: 100px">ประเภทรถ</label></th>
                                                            <th><label style="width: 100px">ยี่ห้อรถ</label></th>
                                                            <th><label style="width: 100px">ประเภทเกียร์รถ</label></th>
                                                            <th><label style="width: 100px">สีรถ</label></th>
                                                            <th><label style="width: 100px">ซีรีส์/รุ่น</label></th>
                                                            <th><label style="width: 100px">ชื่อรถ (ไทย)</label></th>
                                                            <th><label style="width: 100px">ชื่อรถ (อังกฤษ)</label></th>
                                                            <th><label style="width: 100px">แรงม้า</label></th>
                                                            <th><label style="width: 100px">CC</label></th>
                                                            <th><label style="width: 100px">เลขเครื่องยนต์</label></th>
                                                            <th><label style="width: 100px">เลขตัวถัง</label></th>
                                                            <th><label style="width: 100px">ประเภทพลังงาน</label></th>
                                                            <th><label style="width: 100px">น้ำหนักรถ (กิโลกรัม)</label></th>
                                                            <th><label style="width: 100px">ประเภทเพลา</label></th>
                                                            <th><label style="width: 100px">ลูกสูบ</label></th>
                                                            <th><label style="width: 100px">น้ำหนักบรรทุกสูงสุด</label></th>
                                                            <th><label style="width: 100px">วันที่เพิ่มข้อมูล</label></th>
                                                            <th><label style="width: 100px">การใช้งาน (ปี)</label></th>
                                                            <th><label style="width: 100px">ซื้อรถที่ใหน</label></th>
                                                            <th><label style="width: 100px">วันที่ซื้อ</label></th>
                                                            <th><label style="width: 100px">ราคารถ</label></th>
                                                            <th><label style="width: 100px">เงื่อนไขการซื้อ</label></th>
                                                            <th><label style="width: 100px">ต่อโครงสร้างที่ใหน</label></th>
                                                            <th><label style="width: 100px">วันที่ต่อโครงสร้าง</label></th>
                                                            <th><label style="width: 100px">ราคา</label></th>
                                                            <th><label style="width: 100px">วันที่จดทะเบียนครั้งแรก</label></th>
                                                            <th><label style="width: 100px">อุปกรณ์เฉพาะ</label></th>
                                                            <th><label style="width: 100px">สถานะ</label></th>
                                                            <th><label style="width: 100px">หมายเหตุ</label></th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        $condition1 = " AND (a.THAINAME NOT LIKE '%R-%' OR a.THAINAME NOT LIKE '%RA-%' OR a.THAINAME NOT LIKE '%RP-%'";
                                                        $condition2 = " OR a.THAINAME NOT LIKE '%คลองเขื่อน%'  OR a.THAINAME NOT LIKE '%ด่านช้าง%'  OR a.THAINAME NOT LIKE '%สวนผึ้ง%' ";
                                                        $condition3 = " OR a.ENGNAME NOT LIKE '%ดินแดง%' OR a.ENGNAME NOT LIKE '%อุทัยธานี%' OR a.ENGNAME NOT LIKE '%Kerry%'";
                                                        $condition4 = " OR a.THAINAME NOT LIKE '%เขาชะเมา%' OR a.THAINAME NOT LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME NOT LIKE '%P35%' )";
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

                                                                <td style="text-align: center">
                                                                    <button style="text-align: center" onclick="delete_vehicleinfo(<?= $result_infolist['VEHICLEINFOID'] ?>);" title="ลบข้อมูล" type="button" class="list-group-item"><span class="glyphicon glyphicon-remove"></span></button>
                                                                </td>
                                                                <td style="text-align: center">
                                                                    <a href='meg_vehiclrinfoamata.php?vehicleinfoid=<?= $result_infolist['VEHICLEINFOID'] ?>&meg=edit' target="_bank" class='list-group-item'><span class="glyphicon glyphicon-wrench"></span></a>
                                                                </td>
                                                                <td><?= $result_infolist['VEHICLEREGISNUMBER'] ?></td>
                                                                <td><?= $result_infolist['VEHICLEGROUPDESC'] ?></td>
                                                                <td><?= $result_infolist['VEHICLETYPECODE'] ?></td>
                                                                <td><?= $result_infolist['BRANDDESC'] ?></td>
                                                                <td><?= $result_infolist['GEARTYPEDESC'] ?></td>
                                                                <td><?= $result_infolist['COLORDESC'] ?></td>
                                                                <td><?= $result_infolist['SERIES'] ?></td>
                                                                <td><?= $result_infolist['THAINAME'] ?></td>
                                                                <td><?= $result_infolist['ENGNAME'] ?></td>
                                                                <td><?= $result_infolist['HORSEPOWER'] ?></td>
                                                                <td><?= $result_infolist['CC'] ?></td>
                                                                <td><?= $result_infolist['MACHINENUMBER'] ?></td>
                                                                <td><?= $result_infolist['CHASSISNUMBER'] ?></td>
                                                                <td><?= $result_infolist['ENERGY'] ?></td>
                                                                <td><?= $result_infolist['WEIGHT'] ?></td>
                                                                <td><?= $result_infolist['AXLETYPE'] ?></td>
                                                                <td><?= $result_infolist['PISTON'] ?></td>
                                                                <td><?= $result_infolist['MAXIMUMLOAD'] ?></td>
                                                                <td><?= $result_infolist['DATEOFREGISTRATION'] ?></td>
                                                                <td><?= $result_infolist['USED'] ?></td>


                                                                <td><?= $result_infolist['VEHICLEBUYWHERE'] ?></td>
                                                                <td><?= $result_infolist['VEHICLEBUYDATE'] ?></td>
                                                                <td><?= $result_infolist['VEHICLEBUYPRICE'] ?></td>
                                                                <td><?= $result_infolist['VEHICLEBUYCONDITION'] ?></td>
                                                                <td><?= $result_infolist['VEHICLESTRUCTUREWHERE'] ?></td>
                                                                <td><?= $result_infolist['VEHICLESTRUCTUREDATE'] ?></td>
                                                                <td><?= $result_infolist['VEHICLESTRUCTUREPRICE'] ?></td>
                                                                <td><?= $result_infolist['VEHICLEREGISTERDATE'] ?></td>
                                                                <td><?= $result_infolist['VEHICLESPECIAL'] ?></td>



                                                                <td><?php echo ($result_infolist['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                <td><?= $result_infolist['REMARK'] ?></td>



                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>

                                                    </tbody>


                                                </table>


                                            </div>

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


    </body>
    <script>


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
    </script>
</html>
<?php
sqlsrv_close($conn);
?>
