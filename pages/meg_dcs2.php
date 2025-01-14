<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 3000);
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
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>กลุ่มร่วมกิจรุ่งเรือง</title>
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
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

            <div id="page-wrapper">

                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">
                                <a href="index2.php">หน้าหลัก</a> / DCS 2

                            </div>
                            <div class="panel-body">

                                <form action="meg_dcs2.php" method="post" enctype="multipart/form-data" id="upload_excel">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>Import File (.csv)</label>
                                                <input name="file" id="file" type="file" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label><br>
                                                <input type="submit" id="submit" name="submit" value="Import" class="btn btn-default">

                                            </div>

                                        </div>
                                        <div class="col-lg-8">&nbsp;</div>

                                    </div>

                                </form>
                                <div class="row">
                                    <div class="col-lg-4">จำนวนข้อมูลนำเข้า(File) : <b><label id="lbl_cnt"></label></b> รายการ</div> 
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-4"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4"><input type="button" class="btn btn-success" value="Commit" onclick="commit_dcs2()"></div> 
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-4"></div>
                                </div>
                                <div class="row">

                                    <div class="col-lg-4">จำนวนข้อมูลนำเข้า(DB) : <b><label id="lbl_cntsus"></label></b> รายการ</div>
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-4"></div>
                                </div>




                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>



                <div class="row" >
                    <div class="col-lg-12">
                        &nbsp;

                    </div>
                </div>


                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">
                                <font style="font-size: 16px"><b>รายการข้อมูล : DCS 2</b></font>                            
                            </div>
                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div class="row">
                                        <div class="col-lg-8 ">&nbsp;</div>
                                        <div class="col-lg-4 text-right">
                                            <div class="form-group">
                                                เดือน :
                                                <input type="text" id="txt_mmyyyy" name="txt_mmyyyy" value="<?= $result_seSystime['MMYYYY'] ?>" class="form-control dateen" style="background-color: #f080802e" readonly="">
                                                <input type="button" class="btn btn-default" value="ค้นหา" onclick="select_dcs2()">
                                            </div>

                                        </div>

                                    </div>


                                    <div class="row">&nbsp;</div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="datadef">
                                                <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example11" style="width: 100%;">
                                                    <thead >
                                                        <tr>
                                                            <th>ลำดับ</th>
                                                            <th>PLANNINGTERMYEARFROM</th>
                                                            <th>PLANNINGTERMCDFROM</th>
                                                            <th>PLANNINGTERMYEARTO</th>
                                                            <th>PLANNINGTERMCDTO</th>
                                                            <th>RTEGRPCD</th>
                                                            <th>RTEDATES</th>
                                                            <th>RUNSEQ</th>
                                                            <th>LOGPTTO</th>
                                                            <th>RCVCOMPCD</th>
                                                            <th>RCVCOMPPLANTCD</th>
                                                            <th>RCVCOMPDOCKCD</th>
                                                            <th>LOGPTFROM</th>
                                                            <th>SUPPCD</th>
                                                            <th>SUPPPLANTCD</th>
                                                            <th>SUPPDOCKCD</th>
                                                            <th>LOGPTCDFROM</th>
                                                            <th>PLANTCDFROM</th>
                                                            <th>DOCKCDFROM</th>
                                                            <th>LOGPTCDTO</th>
                                                            <th>PLANTCDTO</th>
                                                            <th>DOCKCDTO</th>
                                                            <th>PHYPTFROM</th>
                                                            <th>PHYLOGPTCDFROM</th>
                                                            <th>PHYPLANTCDFROM</th>
                                                            <th>PHYDOCKCDFROM</th>
                                                            <th>PHYPTTO</th>
                                                            <th>PHYLOGPTCDTO</th>
                                                            <th>PHYPLANTCDTO</th>
                                                            <th>PHYDOCKCDTO</th>
                                                            <th>PARTEMPKBTYPECD</th>
                                                            <th>ORDDATE</th>
                                                            <th>ORDSEQS</th>
                                                            <th>LOADMATRIXUNLOADSTRDATE</th>
                                                            <th>LOADMATRIXUNLOADSTRTIME</th>
                                                            <th>LOADMATRIXUNLOADENDDATE</th>
                                                            <th>LOADMATRIXUNLOADENDIME</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        $con2 = " AND RIGHT(CONVERT(NVARCHAR(10),CONVERT(DATE,GETDATE()),103),7)=RIGHT(CONVERT(NVARCHAR(10),CONVERT(DATE,ORDDATE,103),103),7) ";
                                                        $sql_seDcs2 = "{call megDcs2_v2(?,?)}";
                                                        $params_seDcs2 = array(
                                                            array('select_dcs2', SQLSRV_PARAM_IN),
                                                            array($con2, SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seDcs2 = sqlsrv_query($conn, $sql_seDcs2, $params_seDcs2);
                                                        while ($result_seDcs2 = sqlsrv_fetch_array($query_seDcs2, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <tr>
                                                                <td style="text-align: center"><?= $i ?></td>

                                                                <td><?= $result_seDcs2['PLANNINGTERMYEARFROM'] ?></td> 
                                                                <td><?= $result_seDcs2['PLANNINGTERMCDFROM'] ?></td> 
                                                                <td><?= $result_seDcs2['PLANNINGTERMYEARTO'] ?></td> 
                                                                <td><?= $result_seDcs2['PLANNINGTERMCDTO'] ?></td> 
                                                                <td><?= $result_seDcs2['RTEGRPCD'] ?></td> 
                                                                <td><?= $result_seDcs2['RTEDATES'] ?></td> 
                                                                <td><?= $result_seDcs2['RUNSEQ'] ?></td> 
                                                                <td><?= $result_seDcs2['LOGPTTO'] ?></td> 
                                                                <td><?= $result_seDcs2['RCVCOMPCD'] ?></td> 
                                                                <td><?= $result_seDcs2['RCVCOMPPLANTCD'] ?></td> 
                                                                <td><?= $result_seDcs2['RCVCOMPDOCKCD'] ?></td> 
                                                                <td><?= $result_seDcs2['LOGPTFROM'] ?></td> 
                                                                <td><?= $result_seDcs2['SUPPCD'] ?></td> 
                                                                <td><?= $result_seDcs2['SUPPPLANTCD'] ?></td> 
                                                                <td><?= $result_seDcs2['SUPPDOCKCD'] ?></td> 
                                                                <td><?= $result_seDcs2['LOGPTCDFROM'] ?></td> 
                                                                <td><?= $result_seDcs2['PLANTCDFROM'] ?></td> 
                                                                <td><?= $result_seDcs2['DOCKCDFROM'] ?></td> 
                                                                <td><?= $result_seDcs2['LOGPTCDTO'] ?></td> 
                                                                <td><?= $result_seDcs2['PLANTCDTO'] ?></td> 
                                                                <td><?= $result_seDcs2['DOCKCDTO'] ?></td> 
                                                                <td><?= $result_seDcs2['PHYPTFROM'] ?></td> 
                                                                <td><?= $result_seDcs2['PHYLOGPTCDFROM'] ?></td> 
                                                                <td><?= $result_seDcs2['PHYPLANTCDFROM'] ?></td> 
                                                                <td><?= $result_seDcs2['PHYDOCKCDFROM'] ?></td> 
                                                                <td><?= $result_seDcs2['PHYPTTO'] ?></td> 
                                                                <td><?= $result_seDcs2['PHYLOGPTCDTO'] ?></td> 
                                                                <td><?= $result_seDcs2['PHYPLANTCDTO'] ?></td> 
                                                                <td><?= $result_seDcs2['PHYDOCKCDTO'] ?></td> 
                                                                <td><?= $result_seDcs2['PARTEMPKBTYPECD'] ?></td> 
                                                                <td><?= $result_seDcs2['ORDDATE'] ?></td> 
                                                                <td><?= $result_seDcs2['ORDSEQS'] ?></td> 
                                                                <td><?= $result_seDcs2['LOADMATRIXUNLOADSTRDATE'] ?></td> 
                                                                <td><?= $result_seDcs2['LOADMATRIXUNLOADSTRTIME'] ?></td> 
                                                                <td><?= $result_seDcs2['LOADMATRIXUNLOADENDDATE'] ?></td> 
                                                                <td><?= $result_seDcs2['LOADMATRIXUNLOADENDIME'] ?></td> 
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
        <script src="../dist/js/bootstrap-select.js"></script>


    </body>
    <?php
    if (isset($_POST["submit"])) {
        $filename = $_FILES["file"]["tmp_name"];
        $cnt = 1;
        delDcs2();
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {



                $rs = insDcs2(
                        'insert_dcs2',
                        '',
                        $emapData[0],
                        $emapData[1],
                        $emapData[2],
                        $emapData[3],
                        $emapData[4],
                        $emapData[5],
                        $emapData[6],
                        $emapData[7],
                        $emapData[8],
                        $emapData[9],
                        $emapData[10],
                        $emapData[11],
                        $emapData[12],
                        $emapData[13],
                        $emapData[14],
                        $emapData[15],
                        $emapData[16],
                        $emapData[17],
                        $emapData[18],
                        $emapData[19],
                        $emapData[20],
                        $emapData[21],
                        $emapData[22],
                        $emapData[23],
                        $emapData[24],
                        $emapData[25],
                        $emapData[26],
                        $emapData[27],
                        $emapData[28],
                        $emapData[29],
                        $emapData[30],
                        $emapData[31],
                        $emapData[32],
                        $emapData[33],
                        $emapData[34],
                        $emapData[35]
                );

                switch ($rs) {
                    case 'complete': {
                            echo "บันทึกข้อมูลเรียบร้อย...";
                        }
                        break;
                    case 'error': {
                            echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล !!!";
                        }
                        break;
                    default : {
                            echo $rs;
                        }
                        break;
                }

                $cnt++;
            }
            fclose($file);
        } else {
            ?>
            <script>
                                                    alert('กรุณาเลือกไฟล์ !');
            </script>
            <?php
        }

        $sql = "SELECT COUNT(*) AS 'CNT' FROM dbo.DCS2 WHERE 
        CONVERT(DATE,CONVERT(NVARCHAR(10),RTRIM(ORDDATE),103),103) >= CONVERT(DATE,CONVERT(NVARCHAR(10),(SELECT CONVERT(NVARCHAR(10),MIN(CONVERT(DATE,ORDDATE,103)),103) FROM [RTMS].dbo.DCS2_TEMP),103),103)
        AND 
        CONVERT(DATE,CONVERT(NVARCHAR(10),RTRIM(ORDDATE),103),103) <= CONVERT(DATE,CONVERT(NVARCHAR(10),(SELECT CONVERT(NVARCHAR(10),MAX(CONVERT(DATE,ORDDATE,103)),103) FROM [RTMS].dbo.DCS2_TEMP),103),103)
        ";
        $params = array();
        $query = sqlsrv_query($conn, $sql, $params);
        $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    }
    ?>
    <script>
        document.getElementById("lbl_cnt").innerHTML = '0';
        document.getElementById("lbl_cntsus").innerHTML = '0';
        if ('<?= $cnt ?>' == '')
        {
            document.getElementById("lbl_cnt").innerHTML = '0';
            document.getElementById("lbl_cntsus").innerHTML = '0';

        } else
        {
            document.getElementById("lbl_cnt").innerHTML = '<?= $cnt - 2 ?>';



        }

        function commit_dcs2()
        {
            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "commit_dcs2"
                },
                success: function () {

                    select_dcs2();
                }
            });
        }
        function select_dcs2()
        {

            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "select_dcs2", mmyyyy: document.getElementById('txt_mmyyyy').value
                },
                success: function (rs) {

                    document.getElementById("datasr").innerHTML = rs;
                    document.getElementById("datadef").innerHTML = "";


                    document.getElementById("lbl_cntsus").innerHTML = '<?= $result['CNT'] ?>';


                    $(document).ready(function () {
                        $('#dataTables-example').DataTable({
                            order: [[0, "asc"]],
                            scrollX: true,
                            scrollY: '500px',
                        });
                    });

                }
            });
        }

        $(function () {
            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            // กรณีใช้แบบ input
            $(".dateen").datetimepicker({
                timepicker: false,
                format: 'm/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


            });
        });

        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                order: [[0, "asc"]],
                scrollX: true,
                scrollY: '500px',
            });
        });
    </script>

</html>


<?php
sqlsrv_close($conn);
?>