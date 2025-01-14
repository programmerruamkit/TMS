
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
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
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
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
            .popover-content {
                padding: 10px 10px;
                width: 200px;
            }
        </style>

    </head>

    <body>

        <input class="form-control"  id="txt_personCode" name="txt_personCode" value="" style="display: none">
        <div class="modal fade" id="modal_showtenkodate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 40%">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="title"><b>เท็งโกะ</b></h5>
                    </div>
                    <div class="modal-body">
                        <div class="row" >
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <font style="color: red">* </font><label>วันที่เท็งโกะ</label>

                                    <input class="form-control dateen"  id="txt_tenkodate" name="txt_tenkodate" value="" >
                                </div>

                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="save_tenkomasterofficer()">รายงานตัวตรวจร่างกาย</button>
                    </div>
                </div>

            </div>
        </div>
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php
                include '../pages/meg_header.php';
                include '../pages/meg_leftmenu.php';
                ?>
            </nav>

            <div id="page-wrapper" >

                <div class="row" >
                    <div class="col-lg-12">

                        <h2 class="page-header"><i class="glyphicon glyphicon-user"></i>  

                            ข้อมูลพนักงาน



                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-2">
                        <select class="form-control"  id="cb_srtype" name="cb_srtype" onchange="select_employee()">
                            <option value="-">เลือกบริษัท</option>
                            <?php
                            $area = "";
                            if ($_GET['area'] == 'amata') {
                                $area = " AND Company_Code IN ('RKS','RKR','RKL','RIT','RTD','RTC','RKB')";
                            } else if ($_GET['area'] == 'gateway') {
                                $area = " AND Company_Code IN ('RATC','RCC','RRC')";
                            }

                            $sql_seComp = "{call megCompany_v2(?,?)}";
                            $params_seComp = array(
                                array('select_company', SQLSRV_PARAM_IN),
                                array($area, SQLSRV_PARAM_IN)
                            );
                            $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
                            while ($result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC)) {
                                ?>
                                <option value = "<?= $result_seComp['Company_Code'] ?>"><?= $result_seComp['Company_NameT'] ?></option> 
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-10">&nbsp;</div>
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">

                                ข้อมูลพนักงาน
                            </div>
                            <!-- /.panel-heading -->

                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                    <div id="selectemployeedef">
                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>รหัสพนักงาน</th>
                                                    <th>ชื่อ-นามสกุล</th>
                                                    <th>เบอร์โทรศัพท์</th>
                                                    <th>อีเมลล์</th>
                                                    <th style="text-align: center">ข้อมูลย่อย</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="selectemployeesr"></div>

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
            <script src="../js/jquery.datetimepicker.full.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>

            <script>
                            $(document).ready(function () {
                                $('#dataTables-example').DataTable({
                                    responsive: true,
                                    order: [[0, "desc"]]
                                });
                            });
            </script>


    </body>

    <script>
        function show_tenkodate(personCode)
        {
            document.getElementById("txt_personCode").value = personCode;
        }
        function select_employee()
        {


            var srtype = document.getElementById("cb_srtype").value;
            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "show_employee7", companycode: srtype
                },
                success: function (rs) {
                    document.getElementById("selectemployeedef").innerHTML = "";
                    document.getElementById("selectemployeesr").innerHTML = rs;
                    $('#dataTables-example').DataTable({
                        responsive: true,
                        order: [[0, "desc"]]
                    });
                }


            });

        }
        function save_tenkomasterofficer()
        {

            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "save_tenkomasterofficer", tenkomasterid: document.getElementById("txt_tenkodate").value, vehicletransportplanid: document.getElementById("txt_personCode").value, changeka: '',
                    remark1: '', remark2: '', status: '1', officer: '<?= $result_seEmp["nameT"] ?>'



                },
                success: function () {

              
                    window.open('meg_tenkodocument.php?employeecode1=' + document.getElementById("txt_personCode").value + '&companycode=' + document.getElementById("cb_srtype").value + '&tenkomasterid=undefined&tenkodate=' + document.getElementById("txt_tenkodate").value, '_blank');

                }
            });

        }
       
        $(function () {
            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            // กรณีใช้แบบ input
            $(".dateen").datetimepicker({
               
                format: 'Y-m-d', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                lang: 'th'

            });
        });
    </script>

</html>
<?php
sqlsrv_close($conn);
?>