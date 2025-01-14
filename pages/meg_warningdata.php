<!DOCTYPE html>
<?php
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


        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
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
                <p>&nbsp;</p>
                <form  name="saveform" id="saveform" method="post">
                    <input type="text" id="txt_vehicleinfoid" name="txt_vehicleinfoid" style="display: none" value="<?= $_GET['vehicleinfoid'] ?>">


                    <?php
                    if ($_GET['type'] == "warningdata") {
                        if ($_GET['id1'] != "") {
                            $condition1 = " AND a.WARNINGDATAID='" . $_GET['warningdataid']."'";
                            $sql_getWarningdata = "{call megWarningdata_v2(?,?)}";
                            $params_getWarningdata = array(
                                array('select_warningdata', SQLSRV_PARAM_IN),
                                array($condition1, SQLSRV_PARAM_IN)
                            );
                        }
                        $query_getWarningdata = sqlsrv_query($conn, $sql_getWarningdata, $params_getWarningdata);
                        $result_getWarningdata = sqlsrv_fetch_array($query_getWarningdata, SQLSRV_FETCH_ASSOC);
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        ข้อมูลการแจ้งเตือน
                                    </div>
                                    <div class="panel-body">
                                        <div class="well">
                                        <div class="row" >
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ชื่อข้อมูล</label>
                                                    <select  class="form-control" id="cb_warningdata" name="cb_warningdata">
                                                        <option value="">เลือกข้อมูล</option>
                                                        <?php
                                                        switch ($result_getWarningdata['TYPEWARNING']) {
                                                            case 'ข้อมูลประกันภัย': {
                                                                    ?>
                                                                    <option value="ข้อมูลประกันภัย" selected="">ข้อมูลประกันภัย</option>
                                                                    <option value="ข้อมูลภาษี">ข้อมูลภาษี</option>
                                                                    <?php
                                                                }
                                                                break;
                                                            case 'ข้อมูลภาษี': {
                                                                    ?>
                                                                    <option value="ข้อมูลประกันภัย">ข้อมูลประกันภัย</option>
                                                                    <option value="ข้อมูลภาษี" selected="">ข้อมูลภาษี</option>
                                                                    <?php
                                                                }
                                                                break;

                                                            default : {
                                                                    ?>
                                                                    <option value="ข้อมูลประกันภัย">ข้อมูลประกันภัย</option>
                                                                    <option value="ข้อมูลภาษี">ข้อมูลภาษี</option>
                                                                    <?php
                                                                }
                                                                break;
                                                        }
                                                        ?>

                                                    </select>

                                                </div>
                                            </div>




                                        </div>
                                            
                                        <div class="row" >
                                            <div class = "col-lg-3">
                                                <div class = "form-group">
                                                    <font style = "color: red">* </font><label>อีเมลถึง (TO)</label>
                                                    <input class = "form-control" id = "txt_warningemailto" name = "txt_warningemailto" value = "<?= $result_getWarningdata['EMAILTO'] ?>">
                                                </div>


                                            </div>

                                            <div class = "col-lg-3">
                                                <div class = "form-group">
                                                    <font style = "color: red">* </font><label>อีเมลพิเศษ (Extar)</label>
                                                    <input class = "form-control" id = "txt_warningemailextra" name = "txt_warningemailextra" value = "<?= $result_getWarningdata['EMAILEXTRA'] ?>">
                                                </div>

                                            </div>
                                            <div class = "col-lg-6">
                                                <div class = "form-group">
                                                    <label>อีเมลร่วม (CC)<br></label><br>
                                                    <select class="selectpicker" multiple="" data-actions-box="true" id="cb_warningemailcc" name="cb_warningemailcc" title="" >
                                                        <option value = "">เลือกอีเมลร่วม (CC)</option>  

                                                        <?php
                                                        $sql_seEmpname3 = "{call megStopwork_v2(?,?)}";
                                                        $params_seEmpname3 = array(
                                                            array('select_email', SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seEmpname3 = sqlsrv_query($conn, $sql_seEmpname3, $params_seEmpname3);
                                                        while ($result_seEmpname3 = sqlsrv_fetch_array($query_seEmpname3, SQLSRV_FETCH_ASSOC)) {
                                                            $selected = "";
                                                            if ($result_getWarningdata['EMAILCC'] == $result_seEmpname3['EMAILADDRESS']) {
                                                                $selected = "selected";
                                                            }
                                                            ?>
                                                            <option value="<?= $result_seEmpname3['EMAILADDRESS'] ?>"<?= $selected ?>><?= $result_seEmpname3['NAME'] ?> (<?= $result_seEmpname3['EMAILADDRESS'] ?>)</option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <input class = "form-control" style="display: none" id = "txt_warningemailcc" name = "txt_warningemailcc" value = "<?= $result_getWarningdata['EMAILCC'] ?>">



                                                </div>

                                            </div>




                                        </div>
                                        <div class="row" >
                                            <div class = "col-lg-6">
                                                <div class = "form-group">
                                                    <font style = "color: red">* </font><label>หัวเรื่อง</label>
                                                    <input class = "form-control" id = "txt_warningsubject" name = "txt_warningsubject" value = "<?= $result_getWarningdata['SUBJECT'] ?>" >
                                                </div>

                                            </div>
                                        </div>
                                        <div class = "row" >
                                            <div class = "col-lg-12">
                                                <div class = "form-group">
                                                    <font style = "color: red">* </font><label>รายละเอียด</label>
                                                    <textarea class = "form-control" autocomplete = "off" rows = "6" id = "txt_warningdiscription" name = "txt_warningdiscription"><?= $result_getWarningdata['DISCRIPTION'] ?></textarea>

                                                </div>

                                            </div>
                                        </div>
                                        </div>
                                        <div class="well">
                                        <div class = "row" >

                                            <div class = "col-lg-2">
                                                <div class = "form-group">
                                                    <font style = "color: red">* </font><label>ชื่อผู้ส่ง</label>
                                                    <input class = "form-control" id = "txt_warningfrom" name = "txt_warningfrom" value="easyinfo@ruamkit.co.th" style="background-color: #f080802e" readonly="">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>กำหนดพื้นที่</label>
                                                    <select  class="form-control" id="cb_warningarea" name="cb_warningarea">
                                                        <option value="">เลือกพื้นที่</option>
                                                        <?php
                                                        $sql_seCompany = "{call megCompany_v2(?)}";
                                                        $params_seCompany = array(
                                                            array('select_area', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
                                                        while ($result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC)) {
                                                            $selected = "";
                                                            if ($result_getWarningdata['AREA'] == $result_seCompany['AREA']) {
                                                                $selected = "selected";
                                                            }
                                                            ?>
                                                            <option value="<?= $result_seCompany['AREA'] ?>"<?= $selected ?>><?= $result_seCompany['AREA'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>

                                                </div>

                                            </div>
                                            <div class = "col-lg-2">
                                                <div class = "form-group">
                                                    <font style = "color: red">* </font><label>กำหนดระยะเวลา</label>
                                                    <input class = "form-control" onKeyUp = "if (isNaN(this.value)) {
                                                                    alert('กรุณากรอกตัวเลข');
                                                                    this.value = '';
                                                                }" id = "txt_warningday" name = "txt_warningday" value = "<?= $result_getWarningdata['WARNINGDAY'] ?>">
                                                </div>

                                            </div>
                                            <div class = "col-lg-2">
                                                <div class = "form-group">
                                                    <font style = "color: red">* </font><label>สถานะ</label>
                                                    <select class = "form-control" id = "cb_warningstatus" name = "cb_warningstatus">
                                                        <option value = "">เลือกสถานะ</option>
                                                        <?php
                                                        $selected = "SELECTED";

                                                        switch ($result_getWarningdata['ACTIVESTATUS']) {
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
                                        <div class = "row" >
                                            <div class = "col-lg-6">
                                                <div class = "form-group">
                                                    <label>หมายเหตุ</label>
                                                    <textarea class = "form-control" autocomplete = "off" rows = "3" id = "txt_warningremark" name = "txt_warningremark"><?= $result_getWarningdata['REMARK'] ?></textarea>
                                                </div>

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




                        <?php
                    }
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            $buttonname = ($_GET['meg'] == 'add') ? "บันทึกข้อมูล" : "แก้ไขข้อมูล";

                            if ($_GET['type'] == "warningdata") {
                                ?>
                                <input type="button" onclick="save_warningdata(<?= $_GET['warningdataid'] ?>);" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
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
                    <div class="row">

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>ค้นหาตามช่วงวันที่</label>
                                <input class="form-control dateen"  id="txt_datestart" onchange="datetodate();" readonly="" style="background-color: #f080802e" name="txt_datestart" value="<?= $result_getDate['SYSDATE'] ?>" placeholder="วันที่เริ่มต้น">

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

                                <button type="button" class="btn btn-default" onclick="select_stopwork();">ค้นหา <li class="fa fa-search"></li></button>
                            </div>

                        </div>

                    </div>   

                    <?php
                    if ($_GET['type'] == "warningdata") {
                        ?>
                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <font style="font-size: 16px"><b>รายการข้อมูลการแจ้งเตือน</b></font>                            
                                    </div>
                                    <div class="panel-body">
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                            <div class="row">


                                                <div class="col-sm-12">
                                                    <div id="datade">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>ประเภทข้อมูล</th>
                                                                    <th>ชื่อเรื่อง</th>
                                                                    <th>รายละเอียด</th>
                                                                    <th>ชื่อผู้ส่ง</th>
                                                                    <th>อีเมลถึง</th>
                                                                    <th>อีเมลร่วม</th>
                                                                    <th>อีเมลพิเศษ</th>
                                                                    <th>ระยะเวลาที่เหลือ</th>
                                                                    <th>หมายเหตุ</th>
                                                                    <th>สถานะ</th>
                                                                    <th>จัดการ</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $condition1 = "";
                                                                $sql_seWarningdata = "{call megWarningdata_v2(?,?)}";
                                                                $params_seWarningdata = array(
                                                                    array('select_warningdata', SQLSRV_PARAM_IN),
                                                                    array($condition1, SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seWarningdata = sqlsrv_query($conn, $sql_seWarningdata, $params_seWarningdata);
                                                                while ($result_seWarningdata = sqlsrv_fetch_array($query_seWarningdata, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr class="odd gradeX">
                                                                        <td><?= $result_seWarningdata['TYPEWARNING'] ?></td>
                                                                        <td><?= $result_seWarningdata['SUBJECT'] ?></td>
                                                                        <td><?= $result_seWarningdata['DISCRIPTION'] ?></td>
                                                                        <td><?= $result_seWarningdata['FROMNAME'] ?></td>
                                                                        <td><?= $result_seWarningdata['EMAILTO'] ?></td>
                                                                        <td><?= $result_seWarningdata['EMAILCC'] ?></td>
                                                                        <td><?= $result_seWarningdata['EMAILEXTRA'] ?></td>
                                                                        <td><?= $result_seWarningdata['WARNINGDAY'] ?></td>
                                                                        <td><?= $result_seWarningdata['REMARK'] ?></td>
                                                                        <td><?php echo ($result_seWarningdata['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                        <td style="text-align: center">
                                                                            <a href="meg_warningdata.php?type=<?= $_GET['type'] ?>&meg=edit&warningdataid=<?= $result_seWarningdata['WARNINGDATAID'] ?>" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                            <button onclick="delete_warningdata(<?= $result_seWarningdata['WARNINGDATAID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

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
                        <?php
                    }
                    ?>
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
        <!--<script src="../dist/js/buttons.colVis.min.js"></script>-->


        <script src="../dist/js/bootstrap-select.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>


        <script>

                                                                                $(document).ready(function () {
                                                                                    $('#dataTables-example').DataTable({
                                                                                        responsive: true,
                                                                                        /*dom: 'Bfrtip',
                                                                                         buttons: [
                                                                                         
                                                                                         {
                                                                                         extend: 'excelHtml5',
                                                                                         exportOptions: {
                                                                                         columns: ':visible'
                                                                                         }
                                                                                         },
                                                                                         
                                                                                         'colvis'
                                                                                         ]*/
                                                                                    });
                                                                                });

        </script>
        <script>




            var txt_warningemailto = [
<?php
$Empname2 = "";
$sql_seEmpname2 = "{call megStopwork_v2(?,?)}";
$params_seEmpname2 = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seEmpname2 = sqlsrv_query($conn, $sql_seEmpname2, $params_seEmpname2);
while ($result_seEmpname2 = sqlsrv_fetch_array($query_seEmpname2, SQLSRV_FETCH_ASSOC)) {
    $Empname2 .= "'" . $result_seEmpname2['EMAILADDRESS'] . "',";
}
echo rtrim($Empname2, ",");
?>
            ];

            $(function () {
                $("#txt_warningemailto").autocomplete({
                    source: [txt_warningemailto]
                });


            });





            var txt_warningemailextra = [
<?php
$Empname4 = "";
$sql_seEmpname4 = "{call megStopwork_v2(?,?)}";
$params_seEmpname4 = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seEmpname4 = sqlsrv_query($conn, $sql_seEmpname4, $params_seEmpname4);
while ($result_seEmpname4 = sqlsrv_fetch_array($query_seEmpname4, SQLSRV_FETCH_ASSOC)) {
    $Empname4 .= "'" . $result_seEmpname4['EMAILADDRESS'] . "',";
}
echo rtrim($Empname4, ",");
?>
            ];

            $(function () {
                $("#txt_warningemailextra").autocomplete({
                    source: [txt_warningemailextra]
                });


            });
        </script>


        <script>
            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateen").datetimepicker({
                    timepicker: false,
                    format: 'Y-m-d', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                    lang: 'th'

                });
            });
            function chknull_wainingdata()
            {
                if (document.getElementById('cb_warningdata').value == '')
                {
                    alert('ชื่อข้อมูลเป็นค่าว่าง !!!')
                    document.getElementById('cb_warningdata').focus();
                    return false;
                }
                if (document.getElementById('txt_warningsubject').value == '')
                {
                    alert('ชื่อเรื่องเป็นค่าว่าง !!!')
                    document.getElementById('txt_warningsubject').focus();
                    return false;
                }
                if (document.getElementById('txt_warningdiscription').value == '')
                {
                    alert('รายละเอียดเป็นค่าว่าง !!!')
                    document.getElementById('txt_warningdiscription').focus();
                    return false;
                }
                if (document.getElementById('txt_warningfrom').value == '')
                {
                    alert('ชื่อผู้ส่งเป็นค่าว่าง !!!')
                    document.getElementById('txt_warningfrom').focus();
                    return false;
                }
                if (document.getElementById('cb_warningarea').value == '')
                {
                    alert('กำหนดพื้นที่เป็นค่าว่าง !!!')
                    document.getElementById('cb_warningarea').focus();
                    return false;
                }
                if (document.getElementById('txt_warningemailto').value == '')
                {
                    alert('อีเมลถึงเป็นค่าว่าง !!!')
                    document.getElementById('txt_warningemailto').focus();
                    return false;
                }
                if (document.getElementById('txt_warningemailcc').value == '')
                {
                    alert('อีเมลร่วมเป็นค่าว่าง !!!')
                    document.getElementById('txt_warningemailcc').focus();
                    return false;
                }
                if (document.getElementById('txt_warningemailextra').value == '')
                {
                    alert('อีเมลพิเศษเป็นค่าว่าง !!!')
                    document.getElementById('txt_warningemailextra').focus();
                    return false;
                }

                if (document.getElementById('txt_warningday').value == '')
                {
                    alert('ระยะเวลาที่เหลือเป็นค่าว่าง !!!')
                    document.getElementById('txt_warningday').focus();
                    return false;
                }
                if (document.getElementById('cb_warningstatus').value == '')
                {
                    alert('สถานะเป็นค่าว่าง !!!')
                    document.getElementById('cb_warningstatus').focus();
                    return false;
                } else
                {
                    return true;
                }
            }
            function save_warningdata(warningdataid)
            {

                var warningdata = document.getElementById('cb_warningdata').value;
                var warningsubject = document.getElementById('txt_warningsubject').value;
                var warningdiscription = document.getElementById('txt_warningdiscription').value;
                var warningfrom = document.getElementById('txt_warningfrom').value;
                var warningarea = document.getElementById('cb_warningarea').value;
                var warningemailto = document.getElementById('txt_warningemailto').value;
                var warningemailcc = document.getElementById('txt_warningemailcc').value;
                var warningemailextra = document.getElementById('txt_warningemailextra').value;
                var warningremark = document.getElementById('txt_warningremark').value;
                var warningday = document.getElementById('txt_warningday').value;
                var warningstatus = document.getElementById('cb_warningstatus').value;


                if (chknull_wainingdata())
                {

                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "save_warningdata", warningdataid: warningdataid, warningdata: warningdata, warningsubject: warningsubject, warningdiscription: warningdiscription, warningfrom: warningfrom, warningarea: warningarea, warningemailto: warningemailto, warningemailcc: warningemailcc, warningemailextra: warningemailextra, warningremark: warningremark, warningday: warningday, warningstatus: warningstatus
                        },
                        success: function (response) {
                            alert(response);
                            window.location.reload();
                        }
                    });

                }

            }
            function delete_warningdata(warningdataid)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");

                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_warningdata", warningdataid: warningdataid
                        },
                        success: function () {
                            alert('ลบข้อมูลเรียบร้อยแล้ว');
                            window.location.reload();
                        }
                    });
                }
            }


        </script>
        <script type="text/javascript">
            $('.selectpicker').on('changed.bs.select', function () {
                document.getElementById('txt_warningemailcc').value = $(this).val();

            });
        </script>

    </body>

</html>
<?php
sqlsrv_close($conn);
?>
