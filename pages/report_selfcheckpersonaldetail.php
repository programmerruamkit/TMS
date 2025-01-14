
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

$sql_seName = "SELECT nameT AS 'NAME' FROM EMPLOYEEEHR2 WHERE PersonCode ='".$_GET['employeecode']."'";
$params_seName = array();
$query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
$result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC);

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
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
    </head>
    <style>
    h1 {
        text-align: center;
        text-transform: uppercase;
        color: #F94F05;
        text-decoration: overline;
        text-decoration: underline;
        text-shadow: 2px 2px #F9DA05;
        font-size:40px;
    }

    .swal2-popup {
        font-size: 16px !important;
        padding: 17px;
        border: 1px solid #F0E1A1;
        display: block;
        margin: 22px;
        text-align: center;
        color: #61534e;
    }
    </style>
    <body>
    
    
        <div id="wrapper">
            <!-- <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

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
            </nav> -->

            <div id="page-wrapper" >
                <div class="row">
                    <div class="col-lg-12" style="background-color: #e7e7e7">
                        <h1>รายละเอียดข้อมูลการแจ้งสุขภาพตนเอง </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12" style="background-color: #e7e7e7">
                    &nbsp;
                        <p style="text-align: center;font-size: 22px;"><b>วันที่</b> <?=$_GET['datestart']?> <b>ถึง</b> <?=$_GET['dateend']?>  <b>พนักงาน:</b>  <?=$result_seName['NAME']?></p>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                    <div class="well">
                        <div class="row">

                            
                        </div>
                    </div>
                </div>
            </div>
                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>

                    <!-- <input type="hidden" name= "txt_drivercodeprint" id="txt_drivercodeprint" value="<?=$_GET['employeecode']?>"></input>
                    <input type="hidden" name= "txt_yearstartprint" id="txt_yearstartprint" value="<?=$_GET['yearstart']?>"></input>
                    <input type="hidden" name= "txt_yearendprint" id="txt_yearendprint" value="<?=$_GET['yearend']?>"></input>
                    <input type="hidden" name= "txt_user" id="txt_user" value="<?=$_SESSION["USERNAME"] ?>"></input>
                                                               -->
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">

                                    <div class="row">
                                        <div class="col-sm-6"> รายละเอียดข้อมูลการแจ้งสุขภาพตนเอง</div>
                                        <!-- <div class="col-sm-6 text-right"><a target="_bank" href='meg_vehiclrinfoamata.php?vehicleinfoid=&meg=add'>เพิ่มข้อมูลรถ</a></div> --> 
                                    </div>
                                
                                </div><br>
                                <!-- /.panel-heading -->
                                <!-- <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>พิมพ์ข้อมูลประวัติอุบัติเหตุ </label><br>   
                                            <input type="button"  name="" id=""onclick="print_accidentpdf()" value="พิมพ์ข้อมูลประวัติอุบัติเหตุ (PDF)" class="btn btn-primary">
                                            <input type="button"  name="" id=""onclick="print_accidentexcel()" value="พิมพ์ข้อมูลประวัติอุบัติเหตุ (EXCEL)" class="btn btn-primary">
                                        </div>
                                </div> -->
                                <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>SelfCheckID</th>
                                                                    <th>DATEJOBSTART</th>
                                                                    <th>DATEWORKING</th>
                                                                    <th>DATEPRESENT</th>
                                                                    <th>KEYDROPTIME</th>
                                                                    <th>CONFIRMEDBY</th>
                                                                    <th>CONFIRMEDDATE</th>
                                                                    <th>EDIT</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            $i = 1;


                                                            $sql_seSelfCheckData = "SELECT SELFCHECKID,DATEWORKING,DATEJOBSTART,DATEPRESENT,KEYDROPTIME,CONFIRMEDBY,CONVERT(VARCHAR(10),CONFIRMEDDATE,120) AS 'CONFIRMEDDATE' FROM DRIVERSELFCHECK WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
                                                            AND CONVERT(DATE,DATEJOBSTART,103) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                                                            ORDER BY CONVERT(DATE,DATEJOBSTART,103) DESC";
                                                            $params_seSelfCheckData = array();
                                                            $query_seSelfCheckData = sqlsrv_query($conn, $sql_seSelfCheckData, $params_seSelfCheckData);
                                                            while ($result_seSelfCheckData = sqlsrv_fetch_array($query_seSelfCheckData, SQLSRV_FETCH_ASSOC)) {

                                                                $DATERESTSTART1 = str_replace("T"," ",$result_seSelfCheckData['KEYDROPTIME']);
                                                                // $DATERESTSTART = str_replace("-","/",$DATERESTSTART1);
                                                                ?>

                                                                <tr>

                                                                    <td style="text-align: center"><?= $i ?></td>
                                                                    <td style="text-align: center"><?=$result_seSelfCheckData['SELFCHECKID']?></td>
                                                                    <td style="text-align: center"><?=$result_seSelfCheckData['DATEWORKING']?></td>
                                                                    <td style="text-align: center"><?=$result_seSelfCheckData['DATEJOBSTART']?></td>
                                                                    <td style="text-align: center"><?=$result_seSelfCheckData['DATEPRESENT']?></td>
                                                                    <td style="text-align: center"><?=$DATERESTSTART1?></td>
                                                                    <td style="text-align: center"><?=$result_seSelfCheckData['CONFIRMEDBY']?></td>
                                                                    <td style="text-align: center"><?=$result_seSelfCheckData['CONFIRMEDDATE']?></td>
                                                                    
                                                                    <td style="text-align: center"><button  data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!" onclick="confirm_delete('<?= $result_seSelfCheckData['SELFCHECKID'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle btn-danger"><span class="fa fa-trash-o"></span></button></td>
                                                                   
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>




                                                            </tbody>

                                                        </table>

                                                        </div>
                                                        <div id="datasr"></div>
                                                    </div>


                                                    <!-- /.panel-body -->
                                                </div>
                                                <!-- /.panel -->
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
            <script src="../dist/js/jquery.autocomplete.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

    </body>
    <script>

                                       
                                        function confirm_delete(id){
                                            // $(document).on('click', ':not(form)[data-confirm]', function(e){
                                            //     if(confirm($(this).data('confirm'))){
                                            //     e.stopImmediatePropagation();
                                            //     e.preventDefault();
                                                
                                            //     delete_selfcheck(id);   
                                                
                                            //     }else{

                                            //         window.location.reload();      
                                            //     }

                                            
                                            // }); 
                                            Swal.fire({
                                                title: 'ต้องการลบข้อมูล?',
                                                text: "กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'ตกลง',
                                                cancelButtonText: 'ยกเลิก'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    Swal.fire(
                                                    'Deleted!',
                                                    'Your file has been deleted.',
                                                    'success'
                                                    )
                                                    delete_selfcheck(id);   
                                                }else{
                                                    window.location.reload();
                                                }
                                            })

                                        }
                                       

                                        function delete_selfcheck(id){
                                            
                                            
                                            // alert(id);

                                            $.ajax({
                                                type: 'post',
                                                url: 'meg_data2.php',
                                                data: {

                                                txt_flg: "delete_selfcheck",
                                                id:id, 

                                                },
                                                    success: function (rs) {
                                                    
                                                        
                                                    // alert("ลบข้อมูลเรียบร้อย");
                                                     window.location.reload();
                                                    // // // alert(rs);    
                                                   
                                                }
                                                });
                                            }
                                            

                                        $(document).ready(function () {
                                            $('#dataTables-example').DataTable({
                                                order: [[0, "asc"]],
                                                scrollX: true,
                                                scrollY: '500px',
                                            });
                                        });

                                        $(function () {
                                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                            // กรณีใช้แบบ input
                                            $(".dateen").datetimepicker({
                                                timepicker: true,
                                                dateformat: 'Y-m-d' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                timeFormat: "HH:mm"

                                            }
                                            );
                                        });

                                  
                        
    </script>
</html>
<?php
sqlsrv_close($conn);
?>
