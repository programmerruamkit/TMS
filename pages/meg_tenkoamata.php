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

        <style>
            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {
                border-left: 1px solid #ffcb0b;
            }
            .popover-content {
                padding: 9px 14px;
                width: 200px;
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
                    <div id="datade_edit">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <a href="meg_employeewarningamata.php">จัดการรับแจ้ง</a> / ข้อมูลเท็งโก๊ะ
                                    </div>
                                    <div class="panel-body">

                                        <div class="row" >


                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ผู้รับผิดชอบ</label>
                                                    <input type="text"  name="txt_responsibleperson"  id="txt_responsibleperson" class="form-control" onblur="chg_employee(this.value)">
                                                    <input type="text" style="display: none"  name="txt_responsiblepersonid"  id="txt_responsiblepersonid" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วันที่เสร็จสิ้น</label>
                                                    <input class="form-control dateen" type="text" id="txt_frinishdate"  name="txt_frinishdate" readonly="" style="background-color: #f080802e">
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วันที่รับเรื่อง</label>
                                                    <input class="form-control dateen" type="text" id="txt_dateinput" name="txt_dateinput" readonly="" style="background-color: #f080802e">
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>สถานะ</label>
                                                    <select  class="form-control" id="cb_status" name="cb_status">
                                                        <option value="">เลือกสถานะ</option>
                                                        <option value="กำลังดำเนินการ">กำลังดำเนินการ</option>
                                                        <option value="แก้ไขแล้ว">แก้ไขแล้ว</option>
                                                        <option value="แก้ไขไม่ได้">แก้ไขไม่ได้</option>

                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ปัญหา</label>
                                                    <input class="form-control" type="text" id="txt_issue" name="txt_issue">
                                                </div>

                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>เท็งโก๊ะ</label>
                                                    <input class="form-control" type="text" id="txt_tenko" name="txt_tenko">
                                                </div>

                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>การแก้ไข</label>
                                                    <input class="form-control" type="text" id="txt_reformation" name="txt_reformation">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>หมายเหตุ</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_remark" name="txt_remark" ></textarea>
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
                        $conditionEHR2 = " AND a.PersonCode = '" . $_GET['employeeid']."'";
                        $sql_seEHR2 = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEHR2 = array(
                            array('select_employee', SQLSRV_PARAM_IN),
                            array($conditionEHR2, SQLSRV_PARAM_IN)
                        );
                        $query_seEHR2 = sqlsrv_query($conn, $sql_seEHR2, $params_seEHR2);
                        $result_seEHR2 = sqlsrv_fetch_array($query_seEHR2, SQLSRV_FETCH_ASSOC);
                        ?>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        ข้อมูลพนักงาน
                                    </div>
                                    <div class="panel-body" style="background-color: #f8f8f8">
                                        <div class="row" >
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>ชื่อพนักงาน : <?= $result_seEHR2['nameT'] ?></label>
                                                    <input type="text" style="display: none" class="form-control" id="txt_employeeid" name="txt_employeeid"  value="<?= $result_seEHR2['PersonCode'] ?>">
                                                    <input type="text" style="display: none" class="form-control" id="txt_employeename" name="txt_employeename"  value="<?= $result_seEHR2['nameT'] ?>">
                                                    <input type="text" style="display: none" class="form-control" id="txt_companycode" name="txt_companycode"  value="<?= $result_seEHR2['Company_Code'] ?>">
                                                    <input type="text" style="display: none" class="form-control" id="txt_companyname" name="txt_companyname"  value="<?= $result_seEHR2['Company_NameT'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>อายุ : <?= $result_seEHR2['year'] ?> ปี</label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>อายุงาน : <?= $result_seEHR2['yearwork'] ?> ปี</label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>ตำแหน่ง : <?= $result_seEHR2['PositionNameT'] ?></label>
                                                    <input style="display: none" class="form-control" type="text" id="txt_departmentcode" name="txt_departmentcode" value="">
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
                                <input type="button" onclick="save_tenko('');" name="btnSend" id="btnSend" value="บันทึกข้อมูล" class="btn btn-primary">

                            </div>
                        </div>
                    </div>
                    <div id="datasr_edit"></div>
                    <div class="row" >
                        <div class="col-lg-12">
                            &nbsp;

                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $sql_getDate = "{call megStopwork_v2(?)}";
                        $params_getDate = array(
                            array('select_getdate', SQLSRV_PARAM_IN)
                        );
                        $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
                        $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);
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

                    </div>   
                    <div class="row" >
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <font style="font-size: 16px"><b>ประวัติเท็งโก๊ะของพนักงาน : <?= $result_seEHR2['nameT'] ?></b></font>                            
                                </div>
                                <div class="panel-body">
                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                        <div class="row">


                                            <div class="col-sm-12">
                                                <div id="datade">
                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>ชื่อผู้ขับขี่</th>
                                                             
                                                                <th>ปัญหา</th>
                                                                <th>เท็งโก๊ะ</th>
                                                                <th>การแก้ไข</th>
                                                                <th>ผู้รับผิดชอบ</th>
                                                                <th>วันที่สิ้นสุด</th>
                                                                <th>สถานะ</th>
                                                                <th>หมายเหตุ</th>


                                                                <th style="text-align: center">จัดการ</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            $condition1 = " AND a.EMPLOYEEID = '" . $_GET['employeeid']."'";
                                                            $sql_seTenko = "{call megTenko_v2(?,?)}";
                                                            $params_seTenko = array(
                                                                array('select_tenko', SQLSRV_PARAM_IN),
                                                                array($condition1, SQLSRV_PARAM_IN)
                                                            );


                                                            $query_seTenko = sqlsrv_query($conn, $sql_seTenko, $params_seTenko);
                                                            while ($result_seTenko = sqlsrv_fetch_array($query_seTenko, SQLSRV_FETCH_ASSOC)) {

                                                              
                                                                ?>
                                                                <tr class="odd gradeX">
                                                                    <td><?= $i ?></td>
                                                                    <td><?= $result_seTenko['EMPLOYEENAME'] ?></td>
                                                                    <td><?= $result_seTenko['ISSUE'] ?></td>
                                                                    <td><?= $result_seTenko['TENKO'] ?></td>
                                                                    <td><?= $result_seTenko['REFORMATION'] ?></td>
                                                                    <td><?= $result_seEHR['nameT'] ?></td>
                                                                    <td><?= $result_seTenko['FINISHDATE'] ?></td>
                                                                    <td><?= $result_seTenko['STATUS'] ?></td>
                                                                    <td><?= $result_seTenko['REMARK'] ?></td>

                                                                    <td style="text-align: center">
                                                                        <button onclick="showupdate_tenko('<?= $result_seTenko['EMPLOYEETENKOID'] ?>');" title="แก้ไขข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button>
                                                                        <button onclick="delete_tenko('<?= $result_seTenko['EMPLOYEETENKOID'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                                                    </td>

                                                                </tr>
    <?php
    $i++;
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
        
        
        <?php
$job = select_jobautocomplate('megVehicletransportprice_v2', 'select_vehicletransportprice', '');
$emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employee', " AND d.Company_Code IN ('RCC','RATC','RRC')");
$car = select_carautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', " AND ((a.THAINAME  LIKE '%R-%' OR a.THAINAME  LIKE '%RA-%' OR a.THAINAME  LIKE '%RP-%' OR a.THAINAME  LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  OR a.THAINAME  LIKE '%ด่านช้าง%'  OR a.THAINAME  LIKE '%สวนผึ้ง%') OR (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%' OR a.ENGNAME  LIKE '%RP-%' OR a.ENGNAME LIKE '%ดินแดง%'  OR a.ENGNAME LIKE '%อุทัยธานี%'  OR a.ENGNAME LIKE '%คลองเขื่อน%'  OR a.ENGNAME LIKE '%ด่านช้าง%'  OR a.ENGNAME LIKE '%สวนผึ้ง%'))");
$carname = select_carnameautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');

?>
        <script type="text/javascript">
                                                                            var txt_responsibleperson = [<?=$emp?>];
                                                                            $(function () {
                                                                                $("#txt_responsibleperson").autocomplete({
                                                                                    source: [txt_responsibleperson]
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
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>

        <script>
            function chg_employee(val)
            {
               
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "se_responsibleperson", txt_responsibleperson: val
                    },
                    success: function (response) {
                        if (response)
                        {
                            document.getElementById("txt_responsiblepersonid").value = response;
                        }
                    }
                });

            }
        </script>
        <script>
            function chknull_tenko()
            {
                if (document.getElementById('txt_responsibleperson').value == '')
                {
                    alert('ผู้รับผิดชอบเป็นค่าว่าง !!!')
                    document.getElementById('txt_responsibleperson').focus();
                    return false;
                } else if (document.getElementById('txt_frinishdate').value == '')
                {
                    alert('วันที่เสร็จสิ้นเป็นค่าว่าง !!!')
                    document.getElementById('txt_frinishdate').focus();
                    return false;
                } else if (document.getElementById('txt_dateinput').value == '')
                {
                    alert('วันที่รับเรื่องเป็นค่าว่าง !!!')
                    document.getElementById('txt_dateinput').focus();
                    return false;
                } else if (document.getElementById('cb_status').value == '')
                {
                    alert('สถานะเป็นค่าว่าง !!!')
                    document.getElementById('cb_status').focus();
                    return false;
                } else if (document.getElementById('txt_issue').value == '')
                {
                    alert('ปัญหาเป็นค่าว่าง !!!')
                    document.getElementById('txt_issue').focus();
                    return false;
                } else if (document.getElementById('txt_tenko').value == '')
                {
                    alert('เท็งโก๊ะ เป็นค่าว่าง !!!')
                    document.getElementById('txt_tenko').focus();
                    return false;
                } else if (document.getElementById('txt_reformation').value == '')
                {
                    alert('การแก้ไขเป็นค่าว่าง !!!')
                    document.getElementById('txt_reformation').focus();
                    return false;
                } else
                {
                    return true;
                }
            }
            function delete_tenko(val)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");

                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_tenko", employeetenkoid: val
                        },
                        success: function () {
                            alert('ลบข้อมูลเรียบร้อยแล้ว');
                            window.location.reload();


                        }
                    });

                }




            }
            function save_tenko(employeetenkoid)
            {
                
                var employeeid = <?= $_GET['employeeid'] ?>;
                var employeename = document.getElementById('txt_employeename').value;
                var companycode = document.getElementById('txt_companycode').value;
                var companyname = document.getElementById('txt_companyname').value;
                var responsiblepersonid = document.getElementById('txt_responsiblepersonid').value;
                var frinishdate = document.getElementById('txt_frinishdate').value;
                var dateinput = document.getElementById('txt_dateinput').value;
                var status = document.getElementById('cb_status').value;
                var issue = document.getElementById('txt_issue').value;
                var tenko = document.getElementById('txt_tenko').value;
                var reformation = document.getElementById('txt_reformation').value;
                var section = document.getElementById('txt_departmentcode').value;
                var remark = document.getElementById('txt_remark').value;

                if (chknull_tenko())
                {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "save_tenko", employeetenkoid: employeetenkoid, employeeid: employeeid,employeename:employeename,companycode:companycode,
                            companyname:companyname,responsiblepersonid: responsiblepersonid, frinishdate: frinishdate,
                            dateinput: dateinput, status: status, issue: issue, tenko: tenko, reformation: reformation, section: section, remark: remark
                        },
                        success: function (response) {
                            alert(response);
                            window.location.reload();
                        }
                    });
                }
            }

        </script>
        <script>
            function showupdate_tenko(val)
            {
                var employeeid = document.getElementById('txt_employeeid').value;
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "showupdate_tenko", employeeid: employeeid, employeetenkoid: val
                    },
                    success: function (response) {
                        if (response)
                        {
                            document.getElementById("datasr_edit").innerHTML = response;
                            document.getElementById("datade_edit").innerHTML = "";
                        }

                        $(function () {
                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                            // กรณีใช้แบบ input
                            $(".dateen").datetimepicker({
                                timepicker: false,
                                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                            });
                        });
                        var txt_responsibleperson = [<?=$emp?>];
                        $(function () {
                            $("#txt_responsibleperson").autocomplete({
                                source: [txt_responsibleperson]
                            });
                        });
                    }
                });
            }

        </script>
        <script type="text/javascript">
            function datetodate()
            {
                document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;
            }
            function excel_tenko()
            {
                var employeeid = document.getElementById('txt_employeeid').value;
                var datestart = document.getElementById('txt_datestart').value;
                var dateend = document.getElementById('txt_dateend').value;

                window.location.href = 'excel_tenko.php?employeeid=' + employeeid + '&datestart=' + datestart + '&dateend=' + dateend;
            }
            function select_tenko()
            {

                var employeeid = document.getElementById('txt_employeeid').value;
                var datestart = document.getElementById('txt_datestart').value;
                var dateend = document.getElementById('txt_dateend').value;
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_tenko", employeeid: employeeid, datestart: datestart, dateend: dateend
                    },
                    success: function (response) {
                        if (response)
                        {
                            document.getElementById("datasr").innerHTML = response;
                            document.getElementById("datade").innerHTML = "";

                            $(document).ready(function () {
                                $('#dataTables-example').DataTable({
                                    responsive: true
                                });
                            });

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