<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
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
                                <?php
                                session_start();
                                date_default_timezone_set("Asia/Bangkok");
                                require_once("../class/meg_function.php");
                                $conn = connect("RTMS");

                                if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["PASSWORD"])) {
                                    header("location:../../demo/pages/meg_login.php?data=" . $_GET['data']);
                                }
                                ?>
                                <div class="navbar-header" >
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <a class="navbar-brand" href="../../demo/pages/index.html"><font style="color: #666"><img src="http://203.150.29.241:8080/demo/images/logo.png" height="30"> <strong>กลุ่มร่วมกิจรุ่งเรือง</strong></font></a> 
                                </div>
                               
                            </nav>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div class="row">

                                        <div class="col-sm-6">

                                            <form method="post"> <input type="text"  id="txt_quotation" class="form-control" name="txt_quotation" placeholder="เลขที่ใบเสนอราคา" />&nbsp;&nbsp;<input class="btn btn-default" type="submit" onclick="select_quotation()" id="btn_srquotation" name="btn_srquotation" value="ค้นหา" /></form>
                                        </div>
                                        <div class="col-sm-6" align="right">

                                            <input class="btn btn-default" type="button" style="background-color: #ffff0094;border:solid 2px #666"  id="btn_srquotation" name="btn_srquotation" value="" /> * ช่องสำหรับแก้ไขข้อมูล
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            &nbsp;
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-sm-12">

                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline " id="dt_adjust" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                <thead>
                                                    <tr role="row">
                                                        <th >QUOTATIONNUMBER</th>
                                                        <th >ROUTINGCODE</th>
                                                        <th >ROUTINGTHAIDESC</th>
                                                        <th >DESCRIPTIONS</th>
                                                        <th >ID</th>
                                                        <th >PRICETYPEDESC</th>
                                                        <th >VEHICLETYPEDESC</th>
                                                        <th >STANDARDPRICE</th>
                                                        <th >QUANTITY</th>
                                                        <th >MINIMUMQUANTITY</th>
                                                        <th >Q_DESCRIPTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    if ($_POST['btn_srquotation'] != "") {
                                                        $condition1 = $_POST['txt_quotation'];

                                                        $sql_seAdjust = "{call megAdjust_v2(?,?)}";
                                                        $params_seAdjust = array(
                                                            array('select_adjust', SQLSRV_PARAM_IN),
                                                            array($condition1, SQLSRV_PARAM_IN)
                                                        );

                                                        $query_seAdjust = sqlsrv_query($conn, $sql_seAdjust, $params_seAdjust);
                                                        while ($result_seAdjust = sqlsrv_fetch_array($query_seAdjust, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <tr role="row">
                                                                <td><?= $result_seAdjust['QUOTATIONNUMBER'] ?></td>
                                                                <td><?= $result_seAdjust['ROUTINGCODE'] ?></td>
                                                                <td><?= $result_seAdjust['ROUTINGTHAIDESC'] ?></td>
                                                                <td><?= $result_seAdjust['DESCRIPTIONS'] ?></td>
                                                                <td><?= $result_seAdjust['ID'] ?></td>
                                                                <td><?= $result_seAdjust['PRICETYPEDESC'] ?></td>
                                                                <td><?= $result_seAdjust['VEHICLETYPEDESC'] ?></td>
                                                                <td style="background-color: #ffff0094;border:solid 1px #666" contenteditable="true"  onkeyup="save_adjust(this, 'STANDARDPRICE', '<?= $result_seAdjust['ID'] ?>')"><?= $result_seAdjust['STANDARDPRICE'] ?></td>
                                                                <td style="background-color: #ffff0094;border:solid 1px #666" contenteditable="true"  onkeyup="save_adjust(this, 'QUANTITY', '<?= $result_seAdjust['ID'] ?>')"><?= $result_seAdjust['QUANTITY'] ?></td>
                                                                <td style="background-color: #ffff0094;border:solid 1px #666" contenteditable="true"  onkeyup="save_adjust(this, 'MINIMUMQUANTITY', '<?= $result_seAdjust['ID'] ?>')"><?= $result_seAdjust['MINIMUMQUANTITY'] ?></td>
                                                                <td style="background-color: #ffff0094;border:solid 1px #666" contenteditable="true"  onkeyup="save_adjust(this, 'DESCRIPTIONS', '<?= $result_seAdjust['ID'] ?>')" ><?= $result_seAdjust['Q_DESCRIPTION'] ?></td>
                                                            </tr>
                                                            <?php
                                                        }
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
                                                                        $('#dt_adjust').DataTable({
                                                                            responsive: true
                                                                        });
                                                                    });
                                                                    function save_adjust(editableObj, fieldname, ID) {
                                                                        var dataedit;
                                                                        if (editableObj.innerHTML == "")
                                                                        {
                                                                            dataedit = "0";
                                                                        } else if (isNaN(editableObj.innerHTML))
                                                                        {
                                                                            alert("กรอกได้เฉพาะตัวเลข !!!");
                                                                            editableObj.innerHTML = "0";
                                                                            dataedit = "0";
                                                                        } else
                                                                        {
                                                                            dataedit = editableObj.innerHTML;
                                                                        }
                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: 'editableObj=' + dataedit + '&ID=' + ID + '&fieldname=' + fieldname,

                                                                            success: function () {

                                                                            }
                                                                        });
                                                                    }



        </script>
    </body>
</html>