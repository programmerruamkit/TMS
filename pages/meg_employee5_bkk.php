<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
$result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);
?>
<html lang="en">
    <head>
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
                padding: 10px 10px;
                width: 200px;
            }
        </style>

    </head>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header" >

                    <a class="navbar-brand" href="index.php"><font style="color: #666"><img src="../images/logo.png" height="30"> <strong>กลุ่มร่วมกิจรุ่งเรือง</strong></font></a> 
                </div>


            </nav>

            <div class="row">
                <div class="modal fade" id="modal_compensation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="width: 60%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h5 class="modal-title" id="title_copydiagram"><b>ค่าตอบแทนจากการทำงานนอกสถานที่</b></h5>
                                    </div>

                                    <div class="col-lg-3">

                                        <input type="text" name="txt_copydiagramdatestart"  readonly="" id="txt_copydiagramdatestart"  class="form-control datedef" value="<?= $result_seSystime['SYSDATE'] ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" id="txt_personcode" name="txt_personcode" style="display: none">
                                        <input type="text" name="txt_copydiagramdateend" onchange="select_compensationdatesr();"  readonly="" id="txt_copydiagramdateend" class="form-control datedef" value="<?= $result_seSystime['SYSDATE'] ?>">
                                    </div>
                                </div>
                            </div> 

                            <div id="data_compensationsr"></div>
                            <div id="data_compensationdatesr"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <form  name="searchform" id="searchform" method="post">
                                <div class="row">&nbsp;</div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control"  id="cb_srtype" name="cb_srtype" onchange="select_employee2();">

                                            <?php
                                            $sql_seComp = "{call megCompany_v2(?,?)}";
                                            $params_seComp = array(
                                                array('select_company', SQLSRV_PARAM_IN),
                                                array('', SQLSRV_PARAM_IN)
                                            );
                                            $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
                                            while ($result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC)) {
                                                ?>
                                                <option value = "<?= $result_seComp['COMPANYCODE'] ?>"><?= $result_seComp['THAINAME'] ?></option> 
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group input-group">

                                            <input type="text"  name="txt_search"  id="txt_search" class="form-control" onkeyup="select_employee2();" onkeypress="select_employee2();">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" id="btnSearch" type="button" onclick="select_employee2();"><i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                        </div>

                                    </div>

                                </div>
                            </form>
                        </div>


                        <div class="panel-body">
                            <div class="row" id="loading"></div>
                            <div class="row" id="list-data">
                                <?php
                                $sql_srEmp = "{call megEmployeeEHR_v2(?,?)}";

                                $condition1 = " AND d.Company_Code = 'RATC'";
                                $params_srEmp = array(
                                    array('select_employeeehr2', SQLSRV_PARAM_IN),
                                    array($condition1, SQLSRV_PARAM_IN)
                                );
                                $query_srEmp = sqlsrv_query($conn, $sql_srEmp, $params_srEmp);
                                while ($result_srEmp = sqlsrv_fetch_array($query_srEmp, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="panel" style="background-color: #FFF;color: #337ab7;border-color: #31708f">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-xs-2" style="padding-right: 0px;padding-left: 5px">
                                                        <img src="../images/employee/<?= $result_srEmp['PersonCode'] ?>.jpg" style="width: 60px;height: 60px;"><font style="font-size: 10px"><?= $result_seEmp['nameT'] ?></font>
                                                        <!--<img src="../images/noimage.jpg" style="width: 60px;height: 60px;">-->
                                                    </div>
                                                    <div class="col-xs-10 text-right" style="padding-right: 5px;padding-left: 0px">
                                                        <div class="huge"></div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-footer">
                                                <span class="pull-left"><font style="font-size: 16px"><?= $result_srEmp['nameT'] ?> (<?= $result_srEmp['PersonCode'] ?>)</font></span>

                                                <span class="pull-right"> 



                                                    <a href='#' data-toggle='modal' onclick="select_compensation('<?= $result_srEmp['PersonCode'] ?>');"  data-target='#modal_compensation' class='list-group-item'><span class="glyphicon glyphicon-plus"></span></a>

                                                </span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>

                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
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
                                                    $('#exampleModal').on('show', function () {
                                                    })
    </script>
    <script type="text/javascript">
        function select_employee2()
        {

            var srtype = document.getElementById("cb_srtype").value;
            var search = document.getElementById("txt_search").value;
            $.ajax({
                type: 'post',
                url: 'meg_searchemployee5.php',
                data: {
                    srtype: srtype, search: search
                },
                success: function (response) {
                    if (response)
                    {

                        document.getElementById("list-data").innerHTML = "";
                        document.getElementById("loading").innerHTML = response;

                    }

                    $(function () {
                        $('[data-toggle="popover"]').popover({
                            html: true,
                            content: function () {
                                return $('#popover-content').html();
                            }
                        });
                    })

                }
            });

        }

        function calculate_stop(id)
        {
          alert(id);
          if(document.getElementById(id).checked == true)
          {
              alert();
          }
         

        }
        function select_compensationdatesr()
        {
            var copydiagramdatestart = document.getElementById("txt_copydiagramdatestart").value;
            var copydiagramdateend = document.getElementById("txt_copydiagramdateend").value;
            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: 'select_compensation', PersonCode: document.getElementById("txt_personcode").value, copydiagramdatestart: copydiagramdatestart, copydiagramdateend: copydiagramdateend
                },
                success: function (response) {

                    if (response)
                    {

                        document.getElementById("data_compensationsr").innerHTML = "";
                        document.getElementById("data_compensationdatesr").innerHTML = response;

                    }

                }
            });

        }
        function select_compensation(PersonCode)
        {
            document.getElementById("txt_personcode").value = PersonCode;
            var copydiagramdatestart = document.getElementById("txt_copydiagramdatestart").value;
            var copydiagramdateend = document.getElementById("txt_copydiagramdateend").value;
            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: 'select_compensation', PersonCode: PersonCode, copydiagramdatestart: copydiagramdatestart, copydiagramdateend: copydiagramdateend
                },
                success: function (response) {

                    if (response)
                    {


                        document.getElementById("data_compensationsr").innerHTML = response;

                    }
                    $(function () {
                        $('[data-toggle="popover"]').popover({
                            html: true,
                            content: function () {
                                return $('#popover-content').html();
                            }
                        });
                    })
                    $(function () {
                        $("[data-toggle=popover]").popover({
                            html: true,
                            content: function () {
                                var content = $(this).attr("data-popover-content");
                                return $(content).children(".popover-body").html();
                            },
                            title: function () {
                                var title = $(this).attr("data-popover-content");
                                return $(title).children(".popover-heading").html();
                            }
                        });
                    });

                }
            });

        }


    </script>
    <script>
        $(function () {

            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            // กรณีใช้แบบ input
            $(".datedef").datetimepicker({
                timepicker: false,
                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

            });
        });
    </script>

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

</html>
<?php
sqlsrv_close($conn);
?>