
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_getEmp = "{call megEmployee_v2(?,?)}";
$params_getEmp = array(
    array('se', SQLSRV_PARAM_IN),
    array($_GET['employeeid'], SQLSRV_PARAM_IN)
);
$query_getEmp = sqlsrv_query($conn, $sql_getEmp, $params_getEmp);
$result_getEmp = sqlsrv_fetch_array($query_getEmp, SQLSRV_FETCH_ASSOC);

$sql_getComp = "{call megEmployeecompany_v2(?,?)}";
$params_getComp = array(
    array('se', SQLSRV_PARAM_IN),
    array($_GET['employeecompanyid'], SQLSRV_PARAM_IN)
);
$query_getComp = sqlsrv_query($conn, $sql_getComp, $params_getComp);
$result_getComp = sqlsrv_fetch_array($query_getComp, SQLSRV_FETCH_ASSOC);

$sql_getCard = "{call megEmployeecard_v2(?,?)}";
$params_getCard = array(
    array('se', SQLSRV_PARAM_IN),
    array($_GET['employeecardid'], SQLSRV_PARAM_IN)
);
$query_getCard = sqlsrv_query($conn, $sql_getCard, $params_getCard);
$result_getCard = sqlsrv_fetch_array($query_getCard, SQLSRV_FETCH_ASSOC);

$sql_getTraining = "{call megTraining_v2(?,?)}";
$params_getTraining = array(
    array('se', SQLSRV_PARAM_IN),
    array($_GET['employeetrainingid'], SQLSRV_PARAM_IN)
);
$query_getTraining = sqlsrv_query($conn, $sql_getTraining, $params_getTraining);
$result_getTraining = sqlsrv_fetch_array($query_getTraining, SQLSRV_FETCH_ASSOC);

$sql_getAddress = "{call megAddress_v2(?,?)}";
$params_getAddress = array(
    array('se', SQLSRV_PARAM_IN),
    array($_GET['employeeaddressid'], SQLSRV_PARAM_IN)
);
$query_getAddress = sqlsrv_query($conn, $sql_getAddress, $params_getAddress);
$result_getAddress = sqlsrv_fetch_array($query_getAddress, SQLSRV_FETCH_ASSOC);
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
        <script>
            $(function () {
                $('[data-toggle="popover"]').popover({
                    html: true,
                    content: function () {
                        return $('#popover-content').html();
                    }
                });
            })
        </script>
        <style>

            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {

                border-left: 1px solid #ffcb0b;
            }
        </style>

    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php
                include '../pages/meg_header.php';
                include '../pages/meg_leftmenu.php';
                ?>
            </nav>

            <div id="page-wrapper" >
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header" ><i class="glyphicon glyphicon-user"></i> 
                            <?= ($_GET['type'] == 'company' || $_GET['type'] == 'card' || $_GET['type'] == 'training') ? $result_getEmp['NAME'] : "ข้อมูลพนักงาน " ?>
                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">
                                <?php
                                if ($_GET['type'] == "company") {

                                    echo "<a href='report_employee.php?type=employee'>ข้อมูลพนักงาน</a> / " . $result_getComp['THAINAME'];
                                    $link = "<a href='report_employee.php?type=employee'>ข้อมูลพนักงาน</a> / <a href='report_employee.php?type=company&employeeid=" . $_GET['employeeid'] . "'>" . $result_getComp['THAINAME'] . "</a>";
                                    $_SESSION["link"] = $link;
                                } else if ($_GET['type'] == "card") {

                                    echo "<a href='report_employee.php?type=employee'>ข้อมูลพนักงาน</a> / " . $result_getCard['CARDTYPEDESC'];
                                    $link = "<a href='report_employee.php?type=employee'>ข้อมูลพนักงาน</a> / <a href='report_employee.php?type=card&employeeid=" . $_GET['employeeid'] . "'>" . $result_getCard['CARDTYPEDESC'] . "</a>";
                                    $_SESSION["link"] = $link;
                                } else if ($_GET['type'] == "training") {

                                    echo "<a href='report_employee.php?type=employee'>ข้อมูลพนักงาน</a> / " . $result_getTraining['COURSETYPEDESC'];
                                    $link = "<a href='report_employee.php?type=employee'>ข้อมูลพนักงาน</a> / <a href='report_employee.php?type=training&employeeid=" . $_GET['employeeid'] . "'>" . $result_getTraining['COURSETYPEDESC'] . "</a>";
                                    $_SESSION["link"] = $link;
                                } else if ($_GET['type'] == "address") {

                                    echo "<a href='report_employee.php?type=employee'>ข้อมูลพนักงาน</a> / " . $result_getAddress['ADDRESSTYPEDESC'];
                                    $link = "<a href='report_employee.php?type=employee'>ข้อมูลพนักงาน</a> / <a href='report_employee.php?type=address&employeeid=" . $_GET['employeeid'] . "'>" . $result_getAddress['ADDRESSTYPEDESC'] . "</a>";
                                    $_SESSION["link"] = $link;
                                } 
                                else if ($_GET['type'] == "password"){

                                    echo "แก้ไขข้อมูล";
                                    $link = "<a href='meg_permisstions.php?type=password'>แก้ไขข้อมูล</a>";
                                    $_SESSION["link"] = $link;
                                }else {

                                    echo "ข้อมูลพนักงาน";
                                    $link = "<a href='report_employee.php?type=employee'>ข้อมูลพนักงาน</a>";
                                    $_SESSION["link"] = $link;
                                }
                                ?>
                            </div>
                            <!-- /.panel-heading -->

                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">


                                    <!--<div class="row"><div class="col-sm-6"><div class="dataTables_length" id="dataTables-example_length"><label>Show <select name="dataTables-example_length" aria-controls="dataTables-example" class="form-control input-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-sm-6"><div id="dataTables-example_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="dataTables-example"></label></div></div></div><div class="row"><div class="col-sm-12">-->
                                    <?php
                                    if ($_GET['type'] == "employee") {
                                        ?>
                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>รหัสพนักงาน</th>
                                                    <th>ชื่อ-นามสกุล</th>
                                                    <th>เบอร์โทรศัพท์</th>
                                                    <th>อีเมลล์</th>
                                                    <th style="text-align: center">ข้อมูลย่อย</th>

                                                    <th style="text-align: center"><a href="meg_employee.php?meg=add"><li class="fa fa-plus-square"></li> เพิ่มพนักงาน</a></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_seEmp = "{call megEmployee_v2(?)}";
                                                $params_seEmp = array(
                                                    array('se', SQLSRV_PARAM_IN)
                                                );
                                                $query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
                                                while ($result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?= $result_seEmp['EMPLOYEECODE'] ?></td>
                                                        <td><?= $result_seEmp['NAME'] ?></td>
                                                        <td><?= $result_seEmp['MOBILENUMBER2'] ?></td>
                                                        <td><?= $result_seEmp['EMAILADDRESS'] ?></td>
                                                        <td style="text-align: center">
                                                            <button type="button" data-toggle="popover" class="btn btn-default btn-circle" onfocus="select_popover('<?= $result_seEmp['EMPLOYEEID'] ?>')"><i class="fa fa-list"></i></button>
                                                            <div id="dataajax"></div>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <a href="meg_employee.php?employeeid=<?= $result_seEmp['EMPLOYEEID'] ?>&meg=edit" title="แก้ไขข้อมูลพนักงาน" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                        </td>

                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                    } else if ($_GET['type'] == "company") {
                                        ?>
                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ชื่อบริษัท</th>
                                                    <th>ชื่อสายงาน</th>
                                                    <th>ชื่อฝ่ายงาน</th>
                                                    <th>ชื่อตำแหน่ง</th>
                                                    <th>หมายเหตุ</th>
                                                    <th>สถานะ</th>
                                                    <th style="text-align: center"><a href="meg_employee.php?type=<?= $_GET['type'] ?>&employeeid=<?= $_GET['employeeid'] ?>&meg=add"><li class="fa fa-plus-square"></li> เพิ่มบริษัท</a></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_seComp = "{call megEmployeecompany_v2(?,?)}";
                                                $params_seComp = array(
                                                    array('se', SQLSRV_PARAM_IN),
                                                    array($_GET['employeeid'], SQLSRV_PARAM_IN)
                                                );
                                                $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
                                                while ($result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?= $result_seComp['THAINAME'] ?></td>
                                                        <td><?= $result_seComp['DEVISIONNAME'] ?></td>
                                                        <td><?= $result_seComp['DEPARTMENTNAME'] ?></td>
                                                        <td><?= $result_seComp['POSITIONDESC'] ?></td>
                                                        <td><?= $result_seComp['REMARK'] ?></td>
                                                        <td><?php echo ($result_seComp['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                        <td style="text-align: center">
                                                            <a href="meg_employee.php?type=<?= $_GET['type'] ?>&employeeid=<?= $_GET['employeeid'] ?>&employeecompanyid=<?= $result_seComp['EMPLOYEECOMPANYID'] ?>&meg=edit" title="แก้ไขข้อมูลบริษัท" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                            <?php
                                                            //if ($result_seComp['ACTIVESTATUS'] == "1") {
                                                            ?>

                                                                                                                                                                                                                                               <!-- <a href="#"  class="btn btn-success btn-circle" title="ยกเลิกข้อมูลบริษัท"><span class="glyphicon glyphicon-pause"></span></a>-->
                                                            <?php
                                                            //} else {
                                                            ?>
                                                                                                                                                                                                                                            <!--<a href="#"  class="btn btn-danger btn-circle" title="เปิดใช้งานข้อมูลบริษัท"><span class="glyphicon glyphicon-stop"></span></a>-->
                                                            <?php
                                                            //    }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                    } else if ($_GET['type'] == "card") {
                                        ?>
                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ประเภทบัตร</th>
                                                    <th>เลขที่บัตร</th>
                                                    <th>วันที่ออกบัตร</th>
                                                    <th>วันบัตรหมดอายุ</th>
                                                    <th>รายละเอียดข้อความ</th>
                                                    <th>สถานะ</th>
                                                    <th style="text-align: center"><a href="meg_employee.php?type=<?= $_GET['type'] ?>&employeeid=<?= $_GET['employeeid'] ?>&meg=add"><li class="fa fa-plus-square"></li> เพิ่มบัตร</a></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_seCard = "{call megEmployeecard_v2(?,?)}";
                                                $params_seCard = array(
                                                    array('se', SQLSRV_PARAM_IN),
                                                    array($_GET['employeeid'], SQLSRV_PARAM_IN)
                                                );

                                                $query_seCard = sqlsrv_query($conn, $sql_seCard, $params_seCard);
                                                while ($result_seCard = sqlsrv_fetch_array($query_seCard, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?= $result_seCard['CARDTYPEDESC'] ?></td>
                                                        <td><?= $result_seCard['CARDNUMBER'] ?></td>
                                                        <td><?= $result_seCard['ISSUEDATE'] ?></td>
                                                        <td><?= $result_seCard['EXPIREDATE'] ?></td>
                                                        <td><?= $result_seCard['ALERTMESSAGE'] ?></td>
                                                        <td><?php echo ($result_seCard['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                        <td style="text-align: center">
                                                            <a href="meg_employee.php?type=<?= $_GET['type'] ?>&employeeid=<?= $_GET['employeeid'] ?>&employeecardid=<?= $result_seCard['EMPLOYEECARDID'] ?>&meg=edit" title="แก้ไขข้อมูลบัตร" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>

                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                    } else if ($_GET['type'] == "training") {
                                        ?>

                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ชื่อคอร์ส</th>
                                                    <th>ชื่อสถาบัน</th>
                                                    <th>ใบรับรอง</th>
                                                    <th>ปีใบรับรอง</th>
                                                    <th>ราคา</th>
                                                    <th>หมายเหตุ</th>
                                                    <th>สถานะ</th>
                                                    <th style="text-align: center"><a href="meg_employee.php?type=<?= $_GET['type'] ?>&employeeid=<?= $_GET['employeeid'] ?>&meg=add"><li class="fa fa-plus-square"></li> เพิ่มอบรม</a></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_seTraining = "{call megTraining_v2(?,?)}";
                                                $params_seTraining = array(
                                                    array('se', SQLSRV_PARAM_IN),
                                                    array($_GET['employeeid'], SQLSRV_PARAM_IN)
                                                );

                                                $query_seTraining = sqlsrv_query($conn, $sql_seTraining, $params_seTraining);
                                                while ($result_seTraining = sqlsrv_fetch_array($query_seTraining, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?= $result_seTraining['COURSETYPEDESC'] ?></td>
                                                        <td><?= $result_seTraining['INSTITUTION'] ?></td>
                                                        <td><?= $result_seTraining['AUTHENTICATE'] ?></td>
                                                        <td><?= $result_seTraining['AUTHENTICATEYEAR'] ?></td>
                                                        <td><?= $result_seTraining['COSTVALUES'] ?></td>
                                                        <td><?= $result_seTraining['REMARK'] ?></td>
                                                        <td><?php echo ($result_seTraining['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                        <td style="text-align: center">
                                                            <a href="meg_employee.php?type=<?= $_GET['type'] ?>&employeeid=<?= $_GET['employeeid'] ?>&employeetrainingid=<?= $result_seTraining['EMPLOYEETRAININGID'] ?>&meg=edit" title="แก้ไขข้อมูลอบรม" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>

                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                    } else if ($_GET['type'] == "address") {
                                        ?>

                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ประเภทที่อยู่</th>
                                                    <th>ตำบล</th>
                                                    <th>อำเภอ</th>
                                                    <th>จังหวัด</th>
                                                    <th>รหัสไปรษณีย์</th>
                                                    <th>เบอร์โทร</th>
                                                    <th>สถานะ</th>
                                                    <th style="text-align: center"><a href="meg_employee.php?type=<?= $_GET['type'] ?>&employeeid=<?= $_GET['employeeid'] ?>&meg=add"><li class="fa fa-plus-square"></li> เพิ่มที่อยู่</a></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_seAddress = "{call megAddress_v2(?,?)}";
                                                $params_seAddress = array(
                                                    array('se', SQLSRV_PARAM_IN),
                                                    array($_GET['employeeid'], SQLSRV_PARAM_IN)
                                                );

                                                $query_seAddress = sqlsrv_query($conn, $sql_seAddress, $params_seAddress);
                                                while ($result_seAddress = sqlsrv_fetch_array($query_seAddress, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?= $result_seAddress['ADDRESSTYPEDESC'] ?></td>
                                                        <td><?= $result_seAddress['DISTRICT_NAME'] ?></td>
                                                        <td><?= $result_seAddress['AMPHUR_NAME'] ?></td>
                                                        <td><?= $result_seAddress['PROVINCE_NAME'] ?></td>
                                                        <td><?= $result_seAddress['ZIPCODE'] ?></td>
                                                        <td><?= $result_seAddress['PHONE'] ?></td>
                                                        <td><?php echo ($result_seAddress['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                        <td style="text-align: center">
                                                            <a href="meg_employee.php?type=<?= $_GET['type'] ?>&employeeid=<?= $_GET['employeeid'] ?>&employeeaddressid=<?= $result_seAddress['EMPLOYEEADDRESSID'] ?>&meg=edit" title="แก้ไขข้อมูลที่อยู่" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>

                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                    }
                                    ?>

                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                    </div>
                </div>
            </div>
            <script src="../vendor/jquery/jquery.min.js"></script>
            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>

            <script>
                                                                $(document).ready(function () {
                                                                    $('#dataTables-example').DataTable({
                                                                        responsive: true,
                                                                        order: [[0, "desc"]]
                                                                    });
                                                                });
            </script>

            <script type="text/javascript">
                function select_popover(employeeid)
                {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "select_popover", employeeid: employeeid
                        },
                        success: function (response) {
                            if (response)
                            {
                                document.getElementById("dataajax").innerHTML = response;
                               
                            }



                        }
                    });
                }
            </script>
    </body>

</html>
<?php
sqlsrv_close($conn);
?>