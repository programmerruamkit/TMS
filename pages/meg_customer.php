<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
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
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
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

            <div id="page-wrapper">
                <div class="row" >
                    <div class="col-lg-12">

                        <h2 class="page-header">
                            <i class="fa fa-user"></i>  
                            จัดการลูกค้า


                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">
                                <?php
                                $meg = ($_GET['meg'] == 'add') ? 'เพิ่มข้อมูล' : 'แก้ไขข้อมูล';
                                echo $meg;
                                ?>
                            </div>
                            <div class="panel-body">
                                <?php
                                if ($_GET['customerid'] != "") {
                                    $condition1 = " AND a.CUSTOMERID=" . $_GET['customerid'];
                                    $sql_getCustomer = "{call megCustomer_v2(?,?)}";
                                    $params_getCustomer = array(
                                        array('select_customer', SQLSRV_PARAM_IN),
                                        array($condition1, SQLSRV_PARAM_IN)
                                    );
                                }
                                $query_getCustomer = sqlsrv_query($conn, $sql_getCustomer, $params_getCustomer);
                                $result_getCustomer = sqlsrv_fetch_array($query_getCustomer, SQLSRV_FETCH_ASSOC);
                                $result_getCustomer['NAMETH'];
                                ?>
                                <div class="row" >
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <font style="color: red">* </font><label>รหัสลูกค้า</label>
                                            <select class="form-control" id="cb_customercode" name="cb_customercode">
                                                <option value = "" >เลือกรหัสลูกค้า</option>
                                                <?php
                                               
                                                $condition1 = " AND a.CUSTOMERID=" . $_GET['customerid'];
                                                $sql_seVehicledesc = "{call megVehicledesc_v2(?,?)}";
                                                $params_seVehicledesc = array(
                                                    array('select_vehiclecustomer', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seVehicledesc = sqlsrv_query($conn, $sql_seVehicledesc, $params_seVehicledesc);
                                                while ($result_seVehicledesc = sqlsrv_fetch_array($query_seVehicledesc, SQLSRV_FETCH_ASSOC)){
                                                     $selected = "";
                                                            if ($result_seVehicledesc["CUSTOMERCODE"] == $result_getCustomer['CUSTOMERCODE']) {
                                                                $selected = "SELECTED";
                                                            }
                                                    ?>
                                                <option value = "<?=$result_seVehicledesc['CUSTOMERCODE']?>" <?=$selected?>><?=$result_seVehicledesc['CUSTOMERCODE']?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class = "col-lg-3">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>ชื่อ (ไทย)</label>
                                            <input class="form-control" type="text" id="txt_nameth" name="txt_nameth" value="<?= $result_getCustomer['NAMETH'] ?>">

                                        </div>
                                    </div>
                                    <div class = "col-lg-3">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>Name (Eng)</label>
                                            <input class="form-control" type="text" id="txt_nameeng" name="txt_nameeng" value="<?= $result_getCustomer['NAMEENG'] ?>">

                                        </div>
                                    </div>
                                    <div class = "col-lg-2">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>ประเภทธุรกิจ</label>
                                            <input class="form-control" type="text" id="txt_businesstype" name="txt_businesstype" value="<?= $result_getCustomer['BUSINESSTYPE'] ?>">

                                        </div>
                                    </div>
                                    <div class = "col-lg-2">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>ประเภทบริษัท</label>
                                            <input class="form-control" type="text" id="txt_companytype" name="txt_companytype" value="<?= $result_getCustomer['COMPANYTYPE'] ?>">

                                        </div>
                                    </div>
                                </div>
                                <div class="row" >
                                    <div class = "col-lg-2">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>สถานะบริษัท</label>
                                            <input class="form-control" type="text" id="txt_companystatus" name="txt_companystatus" value="<?= $result_getCustomer['COMPANYSTATUS'] ?>">

                                        </div>
                                    </div>
                                    <div class = "col-lg-2">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>รหัสการเสียภาษี</label>
                                            <input class="form-control" type="text" id="txt_taxcode" name="txt_taxcode" value="<?= $result_getCustomer['TAXCODE'] ?>">

                                        </div>
                                    </div>
                                    <div class = "col-lg-2">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>สัญชาติ</label>
                                            <input class="form-control" type="text" id="txt_nationality" name="txt_nationality" value="<?= $result_getCustomer['NATIONALITY'] ?>">

                                        </div>
                                    </div>
                                    <div class = "col-lg-2">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>เชื่อชาติ</label>
                                            <input class="form-control" type="text" id="txt_race" name="txt_race" value="<?= $result_getCustomer['RACE'] ?>">

                                        </div>
                                    </div>
                                    <div class = "col-lg-2">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>วันที่จดทะเบียน</label>
                                            <input class="form-control dateen" type="text" style="background-color: #f080802e" id="txt_registrationdate" name="txt_registrationdate" value="<?= $result_getCustomer['REGISTRATIONDATE'] ?>">

                                        </div>
                                    </div>

                                    <div class = "col-lg-2">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>ทุนการจดทะเบียน</label>
                                            <input class="form-control" type="text" id="txt_capital" name="txt_capital" onKeyUp="if (isNaN(this.value)) {
                                                        alert('กรุณากรอกตัวเลข');
                                                        this.value = '';
                                                    }" value="<?= $result_getCustomer['CAPITAL'] ?>">

                                        </div>
                                    </div>
                                </div>
                                <div class="row" >
                                    <div class = "col-lg-2">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>เบอร์โทรศักพท์</label>
                                            <input class="form-control" type="text" id="txt_phone" name="txt_phone" onKeyUp="if (isNaN(this.value)) {
                                                        alert('กรุณากรอกตัวเลข');
                                                        this.value = '';
                                                    }" value="<?= $result_getCustomer['PHONE'] ?>">

                                        </div>
                                    </div>
                                    <div class = "col-lg-2">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>เบอร์แฟกซ์</label>
                                            <input class="form-control" type="text" id="txt_fax" name="txt_fax" onKeyUp="if (isNaN(this.value)) {
                                                        alert('กรุณากรอกตัวเลข');
                                                        this.value = '';
                                                    }" value="<?= $result_getCustomer['FAX'] ?>">

                                        </div>
                                    </div>
                                    <div class = "col-lg-2">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>อีเมลที่1</label>
                                            <input class="form-control" type="text" id="txt_email1" name="txt_email1" value="<?= $result_getCustomer['EMAILADDRESS1'] ?>">

                                        </div>
                                    </div>
                                    <div class = "col-lg-2">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>อีเมลที่2</label>
                                            <input class="form-control" type="text" id="txt_email2" name="txt_email2" value="<?= $result_getCustomer['EMAILADDRESS2'] ?>">

                                        </div>
                                    </div>
                                    <div class = "col-lg-2">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>เว็บไซต์</label>
                                            <input class="form-control" type="text" id="txt_website" name="txt_website" value="<?= $result_getCustomer['WEBSITE'] ?>">

                                        </div>
                                    </div>
                                    <div class = "col-lg-2">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>เกรด</label>
                                            <input class="form-control" type="text" id="txt_grade" name="txt_grade" value="<?= $result_getCustomer['GRADE'] ?>">

                                        </div>
                                    </div>



                                </div>

                                <div class="row" >
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>หมายเหตุ</label>
                                            <textarea class="form-control" autocomplete="off" rows="3" id="txt_customerremark" name="txt_customerremark" ><?= $result_getCustomer['REMARK'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class = "col-lg-2">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>สถานะ</label>

                                            <select class="form-control" id="cb_customerstatus" name="cb_customerstatus">
                                                <option value = "" >เลือกสถานะ</option>
                                                <?php
                                                $selected = "SELECTED";

                                                switch ($result_getCustomer['ACTIVESTATUS']) {
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
                                                            <option value="1" >ใช้งาน</option>
                                                            <?php
                                                        }
                                                        break;

                                                    default : {
                                                            ?>
                                                            <option value = "0">ไม่ใช้งาน</option>
                                                            <option value="1" >ใช้งาน</option>
                                                            <?php
                                                        }
                                                        break;
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $buttonname = ($_GET['meg'] == 'add') ? "บันทึกข้อมูล" : "แก้ไขข้อมูล";

                        if ($_GET['type'] == "customer") {
                            ?>
                            <input type="button" onclick="save_customer(<?= $_GET['customerid'] ?>);" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                            <?php
                        }
                        ?>


                    </div>
                </div>

                <div class="row" >
                    <div class="col-lg-12">
                        &nbsp;

                    </div>
                </div>
                <!--<div class="row">
                <?php
//$sql_getDate = "{call megStopwork_v2(?)}";
// $params_getDate = array(
//     array('select_getdate', SQLSRV_PARAM_IN)
//);
// $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
// $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);
                ?>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>ค้นหาตามช่วงวันที่</label>
                                <input class="form-control dateen"  id="txt_datestart" readonly="" onchange="datetodate();" style="background-color: #f080802e" name="txt_datestart" value="<?= $result_getDate['SYSDATE'] ?>" placeholder="วันที่เริ่มต้น">

                            </div>

                        </div>
                        <div class="col-lg-2">
                            <label>&nbsp;</label>
                            <div class="form-group">
                                <input type="text" class="form-control dateen" id="txt_dateend" readonly="" style="background-color: #f080802e" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE'] ?>">

                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label>&nbsp;</label>
                            <div class="form-group">

                                <button type="button" class="btn btn-default" onclick="select_tenko();">ค้นหา <li class="fa fa-search"></li></button>&emsp;<button type="button" onclick="excel_tenko()" class="btn btn-default">Excel <li class="fa fa-file-excel-o"></li></button>
                            </div>

                        </div>

                    </div>   -->

                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">
                                <font style="font-size: 16px"><b>ข้อมูล : ลูกค้า</b></font>                            
                            </div>
                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="datade">
                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัสลูกค้า</th>
                                                            <th>ชื่อ(ไทย)</th>
                                                            <th>Name(Eng)</th>
                                                            <th>ประเภทธุรกิจ</th>
                                                            <th>ประเภทบริษัท</th>

                                                            <th>สถานะบริษัท</th>
                                                            <th>รหัสการเสียภาษี</th>
                                                            <th>สัญชาติ</th>
                                                            <th>เชื่อชาติ</th>
                                                            <th>วันที่จดทะเบียน</th>

                                                            <th>ทุนการจดทะเบียน</th>
                                                            <th>เบอร์โทรศักพท์</th>
                                                            <th>เบอร์แฟกซ์</th>
                                                            <th>อีเมลที่1</th>

                                                            <th>อีเมลที่2</th>
                                                            <th>เว็บไซต์</th>
                                                            <th>เกรด</th>
                                                            <th>หมายเหตุ</th>
                                                            <th>สถานะ</th>
                                                            <th>จัดการ</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql_seCustomer = "{call megCustomer_v2(?,?)}";
                                                        $params_seCustomer = array(
                                                            array('select_customer', SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCustomer = sqlsrv_query($conn, $sql_seCustomer, $params_seCustomer);
                                                        while ($result_seCustomer = sqlsrv_fetch_array($query_seCustomer, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <tr class="odd gradeX">
                                                                <td><?= $result_seCustomer['CUSTOMERCODE'] ?></td>
                                                                <td><?= $result_seCustomer['NAMETH'] ?></td>
                                                                <td><?= $result_seCustomer['NAMEENG'] ?></td>
                                                                <td><?= $result_seCustomer['BUSINESSTYPE'] ?></td>
                                                                <td><?= $result_seCustomer['COMPANYTYPE'] ?></td>

                                                                <td><?= $result_seCustomer['COMPANYSTATUS'] ?></td>
                                                                <td><?= $result_seCustomer['TAXCODE'] ?></td>
                                                                <td><?= $result_seCustomer['NATIONALITY'] ?></td>
                                                                <td><?= $result_seCustomer['RACE'] ?></td>

                                                                <td><?= $result_seCustomer['REGISTRATIONDATE'] ?></td>
                                                                <td><?= $result_seCustomer['CAPITAL'] ?></td>
                                                                <td><?= $result_seCustomer['PHONE'] ?></td>
                                                                <td><?= $result_seCustomer['FAX'] ?></td>
                                                                <td><?= $result_seCustomer['EMAILADDRESS1'] ?></td>

                                                                <td><?= $result_seCustomer['EMAILADDRESS2'] ?></td>
                                                                <td><?= $result_seCustomer['WEBSITE'] ?></td>
                                                                <td><?= $result_seCustomer['GRADE'] ?></td>
                                                                <td><?= $result_seCustomer['REMARK'] ?></td>
                                                                <td><?php echo ($result_seCustomer['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                <td>
                                                                    <a href="meg_customer.php?type=<?= $_GET['type'] ?>&meg=edit&customerid=<?= $result_seCustomer['CUSTOMERID'] ?>" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                    <button onclick="delete_customer(<?= $result_seCustomer['CUSTOMERID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                                                </td>            
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="datasr"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </form>


            </div>

        </div>

        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/raphael/raphael.min.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script src="../dist/js/jszip.min.js"></script>
        <script src="../dist/js/dataTables.buttons.min.js"></script>
        <script src="../dist/js/buttons.html5.min.js"></script>
        <script src="../dist/js/buttons.print.min.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>

    </body>

    <script>
                                                                    $(document).ready(function () {
                                                                        $('#dataTables-example').DataTable({
                                                                            responsive: true
                                                                        });
                                                                    });
    </script>
    <script>
        $(function () {
            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            // กรณีใช้แบบ input
            $(".dateen").datetimepicker({
                timepicker: false,
                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


            });
        });
    </script>
    <script>

        function chknull_customer()
        {
            if (document.getElementById('cb_customercode').value == '')
            {
                alert('รหัสลูกค้า เป็นค่าว่าง !!!')
                document.getElementById('cb_customercode').focus();
                return false;
            } else if (document.getElementById('txt_nameth').value == '')
            {
                alert('ชื่อ(ไทย) เป็นค่าว่าง !!!')
                document.getElementById('txt_nameth').focus();
                return false;
            } else if (document.getElementById('txt_nameeng').value == '')
            {
                alert('Name(Eng) เป็นค่าว่าง !!!')
                document.getElementById('txt_nameeng').focus();
                return false;
            } else if (document.getElementById('txt_businesstype').value == '')
            {
                alert('ประเภทธุรกิจ เป็นค่าว่าง !!!')
                document.getElementById('txt_businesstype').focus();
                return false;
            } else if (document.getElementById('txt_companytype').value == '')
            {
                alert('ประเภทบริษัท เป็นค่าว่าง !!!')
                document.getElementById('txt_companytype').focus();
                return false;
            } else if (document.getElementById('txt_companystatus').value == '')
            {
                alert('สถานะบริษัท เป็นค่าว่าง !!!')
                document.getElementById('txt_companystatus').focus();
                return false;
            } else if (document.getElementById('txt_taxcode').value == '')
            {
                alert('รหัสการเสียภาษี เป็นค่าว่าง !!!')
                document.getElementById('txt_taxcode').focus();
                return false;
            } else if (document.getElementById('txt_nationality').value == '')
            {
                alert('สัญชาติ เป็นค่าว่าง !!!')
                document.getElementById('txt_nationality').focus();
                return false;
            } else if (document.getElementById('txt_race').value == '')
            {
                alert('เชื่อชาติ เป็นค่าว่าง !!!')
                document.getElementById('txt_race').focus();
                return false;
            } else if (document.getElementById('txt_registrationdate').value == '')
            {
                alert('วันที่จดทะเบียน เป็นค่าว่าง !!!')
                document.getElementById('txt_registrationdate').focus();
                return false;
            } else if (document.getElementById('txt_capital').value == '')
            {
                alert('ทุนการจดทะเบียน เป็นค่าว่าง !!!')
                document.getElementById('txt_capital').focus();
                return false;
            } else if (document.getElementById('txt_phone').value == '')
            {
                alert('เบอร์โทรศักพท์ เป็นค่าว่าง !!!')
                document.getElementById('txt_phone').focus();
                return false;
            } else if (document.getElementById('txt_fax').value == '')
            {
                alert('เบอร์แฟกซ์ เป็นค่าว่าง !!!')
                document.getElementById('txt_fax').focus();
                return false;
            } else if (document.getElementById('txt_email1').value == '')
            {
                alert('อีเมลที่1 เป็นค่าว่าง !!!')
                document.getElementById('txt_email1').focus();
                return false;
            } else if (document.getElementById('txt_email2').value == '')
            {
                alert('อีเมลที่2 เป็นค่าว่าง !!!')
                document.getElementById('txt_email2').focus();
                return false;
            } else if (document.getElementById('txt_website').value == '')
            {
                alert('เว็บไซต์ เป็นค่าว่าง !!!')
                document.getElementById('txt_website').focus();
                return false;
            } else if (document.getElementById('txt_grade').value == '')
            {
                alert('เกรด เป็นค่าว่าง !!!')
                document.getElementById('txt_grade').focus();
                return false;
            } else if (document.getElementById('cb_customerstatus').value == '')
            {
                alert('สถานะ เป็นค่าว่าง !!!')
                document.getElementById('cb_customerstatus').focus();
                return false;
            } else
            {
                return true;
            }
        }
        function save_customer(customerid)
        {
            var customercode = document.getElementById('cb_customercode').value;
            var nameth = document.getElementById('txt_nameth').value;
            var nameeng = document.getElementById('txt_nameeng').value;
            var businesstype = document.getElementById('txt_businesstype').value;
            var companytype = document.getElementById('txt_companytype').value;
            var companystatus = document.getElementById('txt_companystatus').value;
            var taxcode = document.getElementById('txt_taxcode').value;
            var nationality = document.getElementById('txt_nationality').value;
            var race = document.getElementById('txt_race').value;
            var registrationdate = document.getElementById('txt_registrationdate').value;
            var capital = document.getElementById('txt_capital').value;
            var phone = document.getElementById('txt_phone').value;
            var fax = document.getElementById('txt_fax').value;
            var email1 = document.getElementById('txt_email1').value;
            var email2 = document.getElementById('txt_email2').value;
            var website = document.getElementById('txt_website').value;
            var grade = document.getElementById('txt_grade').value;
            var customerremark = document.getElementById('txt_customerremark').value;
            var customerstatus = document.getElementById('cb_customerstatus').value;
            if (chknull_customer())
            {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "save_customer", customerid: customerid, customercode: customercode, nameth: nameth, nameeng: nameeng, businesstype: businesstype, companytype: companytype, companystatus: companystatus, taxcode: taxcode, nationality: nationality, race: race, registrationdate: registrationdate, capital: capital, phone: phone, fax: fax, email1: email1, email2: email2, website: website, grade: grade, customerremark: customerremark, customerstatus: customerstatus
                    },
                    success: function (response) {
                        alert(response);
                        window.location.reload();
                    }
                });
            }
        }
        function delete_customer(customerid)
        {
            var confirmation = confirm("ต้องการลบข้อมูล ?");

            if (confirmation) {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "delete_customer", customerid: customerid
                    },
                    success: function () {
                        alert('ลบข้อมูลเรียบร้อยแล้ว');
                        window.location.reload();
                    }
                });
            }
        }



        var txt_nationality = [
<?php
$nationality = "";
$sql_seNationality = "{call megCountry_v2(?,?)}";
$params_seNationality = array(
    array('select_country', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seNationality = sqlsrv_query($conn, $sql_seNationality, $params_seNationality);
while ($result_seNationality = sqlsrv_fetch_array($query_seNationality, SQLSRV_FETCH_ASSOC)) {
    $nationality .= "'" . $result_seNationality['COUNTRYNAME'] . "',";
}
echo rtrim($nationality, ",");
?>
        ];
        $(function () {
            $("#txt_nationality").autocomplete({
                source: [txt_nationality]
            });
        });

        var txt_race = [
<?php
$race = "";
$sql_seRace = "{call megCountry_v2(?,?)}";
$params_seRace = array(
    array('select_country', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seRace = sqlsrv_query($conn, $sql_seRace, $params_seRace);
while ($result_seRace = sqlsrv_fetch_array($query_seRace, SQLSRV_FETCH_ASSOC)) {
    $race .= "'" . $result_seRace['COUNTRYNAME'] . "',";
}
echo rtrim($race, ",");
?>
        ];
        $(function () {
            $("#txt_race").autocomplete({
                source: [txt_race]
            });
        });

    </script>
</html>


<?php
sqlsrv_close($conn);
?>