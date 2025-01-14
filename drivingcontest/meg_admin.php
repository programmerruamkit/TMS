<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
?>  
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>กลุ่มร่วมกิจรุ่งเรือง</title>
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet" />
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />  
    </head>

    <body>
        <div id="wrapper">

            <div id="page-wrapper">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">

                            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

                                <div class="navbar-header" >
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <a class="navbar-brand" href="#"><font style="color: #666"><img src="http://203.150.29.241:8080/demo/images/logo.png" height="30" /> <strong>กลุ่มร่วมกิจรุ่งเรือง</strong></font></a> 
                                </div>

                            </nav>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            &nbsp;
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-sm-12">

                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline " id="dt_drivercontest" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                <thead>
                                                    <tr role="row">
                                                        <th >ลำดับ</th>
                                                        <th >ชื่อ</th>
                                                        <th >นามสกุล</th>
                                                        <th >อายุ</th>
                                                        <th >ระดับการศึกษา</th>
                                                        <th >ตำแหน่ง</th>
                                                        <th >อีเมล</th>
                                                        <th >เบอร์โทรศัพท์</th>
                                                        <th >บริษัท</th>
                                                        <th >ธุรกิจ</th>
                                                        <th >รายละเอียดธุรกิจ</th>
                                                        <th >ประวัติการเข้าร่วม</th>
                                                        <th >รายละเอียดประวัติการเข้าร่วม</th>
                                                        <th >ข้อเสนอแนะ</th>
                                                        <th style="text-align: center">ลบ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $i = 1;
                                                    $sql_seDrivingcontest = "{call megDriverregister(?,?)}";
                                                    $params_seDrivingcontest = array(
                                                        array('select_register', SQLSRV_PARAM_IN),
                                                        array('', SQLSRV_PARAM_IN)
                                                    );

                                                    $query_seDrivingcontest = sqlsrv_query($conn, $sql_seDrivingcontest, $params_seDrivingcontest);
                                                    while ($result_seDrivingcontest = sqlsrv_fetch_array($query_seDrivingcontest, SQLSRV_FETCH_ASSOC)) {
                                                        ?>
                                                        <tr role="row">
                                                            <td><?= $i ?></td>
                                                            <td contenteditable="true" onkeyup="save_drivingadmin(this, 'DRIVINGREGISTER_FNAME', '<?= $result_seDrivingcontest['DRIVINGREGISTER_ID'] ?>')"><?= $result_seDrivingcontest['DRIVINGREGISTER_FNAME'] ?></td>
                                                            <td contenteditable="true" onkeyup="save_drivingadmin(this, 'DRIVINGREGISTER_LNAME', '<?= $result_seDrivingcontest['DRIVINGREGISTER_ID'] ?>')"><?= $result_seDrivingcontest['DRIVINGREGISTER_LNAME'] ?></td>
                                                            <td contenteditable="true" onkeyup="save_drivingadmin(this, 'DRIVINGREGISTER_AGE', '<?= $result_seDrivingcontest['DRIVINGREGISTER_ID'] ?>')"><?= $result_seDrivingcontest['DRIVINGREGISTER_AGE'] ?></td>
                                                            <td contenteditable="true" onkeyup="save_drivingadmin(this, 'DRIVINGREGISTER_EDUCATION', '<?= $result_seDrivingcontest['DRIVINGREGISTER_ID'] ?>')"><?= $result_seDrivingcontest['DRIVINGREGISTER_EDUCATION'] ?></td>
                                                            <td contenteditable="true" onkeyup="save_drivingadmin(this, 'DRIVINGREGISTER_POSUTION', '<?= $result_seDrivingcontest['DRIVINGREGISTER_ID'] ?>')"><?= $result_seDrivingcontest['DRIVINGREGISTER_POSUTION'] ?></td>
                                                            <td contenteditable="true" onkeyup="save_drivingadmin(this, 'DRIVINGREGISTER_EMAIL', '<?= $result_seDrivingcontest['DRIVINGREGISTER_ID'] ?>')"><?= $result_seDrivingcontest['DRIVINGREGISTER_EMAIL'] ?></td>
                                                            <td contenteditable="true" onkeyup="save_drivingadmin(this, 'DRIVINGREGISTER_TEL', '<?= $result_seDrivingcontest['DRIVINGREGISTER_ID'] ?>')"><?= $result_seDrivingcontest['DRIVINGREGISTER_TEL'] ?></td>
                                                            <td contenteditable="true" onkeyup="save_drivingadmin(this, 'DRIVINGREGISTER_COMPANY', '<?= $result_seDrivingcontest['DRIVINGREGISTER_ID'] ?>')"><?= $result_seDrivingcontest['DRIVINGREGISTER_COMPANY'] ?></td>
                                                            <td contenteditable="true" onkeyup="save_drivingadmin(this, 'DRIVINGREGISTER_BUSINESSTYPE', '<?= $result_seDrivingcontest['DRIVINGREGISTER_ID'] ?>')"><?= $result_seDrivingcontest['DRIVINGREGISTER_BUSINESSTYPE'] ?></td>
                                                            <td contenteditable="true" onkeyup="save_drivingadmin(this, 'DRIVINGREGISTER_BUSINESSTYPETEXT', '<?= $result_seDrivingcontest['DRIVINGREGISTER_ID'] ?>')"><?= $result_seDrivingcontest['DRIVINGREGISTER_BUSINESSTYPETEXT'] ?></td>
                                                            <td contenteditable="true" onkeyup="save_drivingadmin(this, 'DRIVINGREGISTE_HISTORY', '<?= $result_seDrivingcontest['DRIVINGREGISTER_ID'] ?>')"><?= $result_seDrivingcontest['DRIVINGREGISTE_HISTORY'] ?></td>
                                                            <td contenteditable="true" onkeyup="save_drivingadmin(this, 'DRIVINGREGISTE_HISTORYTEXT', '<?= $result_seDrivingcontest['DRIVINGREGISTER_ID'] ?>')"><?= $result_seDrivingcontest['DRIVINGREGISTE_HISTORYTEXT'] ?></td>
                                                            <td contenteditable="true" onkeyup="save_drivingadmin(this, 'REMARK', '<?= $result_seDrivingcontest['DRIVINGREGISTER_ID'] ?>')"><?= $result_seDrivingcontest['REMARK'] ?></td>
                                                            <td style="text-align: center"><a href="#" onclick="del_drivingadmin(<?= $result_seDrivingcontest['DRIVINGREGISTER_ID'] ?>)"> <span class="glyphicon glyphicon-remove"></span></a></td>

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
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-1.12.2.min.js" integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
        <script src="http://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>

        <script>
                                                                $(document).ready(function () {
                                                                    $('#dt_drivercontest').DataTable({
                                                                        responsive: true
                                                                    });
                                                                });
                                                                function confirmdel()
                                                                {
                                                                    if (confirm("ยืนยันการลบข้อมูล ?")) {
                                                                        alert("ลบข้อมูลเรียบร้อยแล้ว");
                                                                        return true;
                                                                    } else {
                                                                        return false;
                                                                    }


                                                                }
                                                                function save_drivingadmin(editableObj, fieldname, ID) {

                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: 'save_drivingadmin', editableObj: editableObj.innerHTML, ID: ID, fieldname: fieldname
                                                                        },
                                                                        success: function () {

                                                                        }
                                                                    });
                                                                }
                                                                function del_drivingadmin(ID) {
                                                                    if (confirmdel()) {
                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: {
                                                                                txt_flg: 'del_drivingadmin', ID: ID
                                                                            },
                                                                            success: function () {

                                                                                location.reload();
                                                                            }
                                                                        });
                                                                    }
                                                                }




        </script>
    </body>
</html>