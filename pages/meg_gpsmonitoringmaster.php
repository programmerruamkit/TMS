
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
require_once("../class/meg_function.php");
$conn = connect("RTMS");

// $condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
// $sql_seLogin = "{call megRoleaccount_v2(?,?)}";
// $params_seLogin = array(
//     array('select_roleaccount', SQLSRV_PARAM_IN),
//     array($condition1, SQLSRV_PARAM_IN)
// );
// $query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
// $result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);

$employeechk = " AND a.PersonCode = '" .$_SESSION["USERNAME"] . "'";
$sql_seEmpchk = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmpchk = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($employeechk, SQLSRV_PARAM_IN)
);
$query_seEmpchk = sqlsrv_query($conn, $sql_seEmpchk, $params_seEmpchk);
$result_seEmpchk = sqlsrv_fetch_array($query_seEmpchk, SQLSRV_FETCH_ASSOC);

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

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
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

    </head>

    <body>
        <!-- <input type="text" class="form-control" id="txt_employeecode" name="txt_employeecode" style="display: none"> -->
        <input style="display:none" type="text" class="form-control" id="txt_employeecode" name="txt_employeecode"  value="<?=$result_seEmpchk['PersonCode']?>">
        
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
                        <h2 class="page-header">
                            <i class="fa fa-database"></i>GPS MONITORING
                        </h2>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label>เพิ่มข้อมูลการตรวจสอบ</label>
                        <div class="form-group">
                            <input type="text" class="form-control"    style="background-color: #fffff;height:45px;"  id="txt_gpsmonitormasterdata" name="txt_gpsmonitormasterdata" placeholder="เพิ่มข้อมูลการตรวจสอบ" value="">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>&nbsp;</label><br>   
                            <input type="button" style="width:128px;height:45px;" onclick="save_gpsmonitormaster()" name="" id="" value="บันทึกข้อมูล" class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">

                                <?php
                                echo "ข้อมูล GPS Monitor";
                                ?>
                            </div>
                            <!-- /.panel-heading -->
                            
                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ข้อมูล GPS Monitor</th>
                                                <th>จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i=1;
                                            $sql_seDetails = "SELECT ITEMS,GPSMONITORINGID FROM [dbo].[GPSMONITORINGMASTER] 
                                                            WHERE ACTIVESTATUS ='1'         
                                                            ORDER BY GPSMONITORINGID ASC";
                                            $params_seDetails = array();


                                            $query_seDetails = sqlsrv_query($conn, $sql_seDetails, $params_seDetails);
                                            while ($result_seDetails = sqlsrv_fetch_array($query_seDetails, SQLSRV_FETCH_ASSOC)) {
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td><?= $i ?></td>
                                                    <td><?= $result_seDetails['ITEMS'] ?></td>
                                                    <td style="text-align: center;"><input type="button"    onclick ="confirm_delete('<?=$result_seDetails['GPSMONITORINGID']?>');"       name="btnSend" id="btnSend" value="ลบข้อมูล" class="btn btn-danger"></td>
                                                </tr>

                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
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

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>
    <script src="../js/jquery.datetimepicker.full.js"></script>

    <!-- Swal ALert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script>
                    
        function confirm_delete(id){
            Swal.fire({
                title: 'ต้องการลบข้อมูล?',
                text: "กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Swal.fire(
                    // 'Deleted!',
                    // 'Your file has been deleted.',
                    // 'success'
                    // )
                    // alert(id);
                    delete_gpsmonitor(id);   
                }else{
                    // window.location.reload();
                }
            })

            // $(document).on('click', ':not(form)[data-confirm]', function(e){
            //     if(confirm($(this).data('confirm'))){
            //     e.stopImmediatePropagation();
            //     e.preventDefault();
                
            //     delete_organization(id);   
            //     }else{

            //         window.location.reload();      
            //     }

            
            // }); 

        }
        


        function save_gpsmonitormaster()
        {
           
            // alert(employeecode1);
            // alert(tenkomasterid);
            // alert(companycode);
            
            var gpsmonitormaster = document.getElementById('txt_gpsmonitormasterdata').value;
            var username = document.getElementById('txt_employeecode').value;
            
            if (gpsmonitormaster == '') {

                swal.fire({
                    title: "Warning!",
                    text: "ยังไม่ได้ลงข้อมูล !!!",
                    icon: "warning",
                    showConfirmButton: true,
                    allowOutsideClick: false,
                });

            }else{

                $.ajax({
                    type: 'post',
                    url: 'meg_data_gpsmonitoring.php',
                    data: {
                        txt_flg: "save_gpsmonitroingmaster",
                        trailernumber:'',
                        problem:gpsmonitormaster,
                        drivername:'',
                        datetimedata:'',
                        location:'',
                        rootcause:'',
                        result:'',
                        gpscheck:'',
                        jobno:'',
                        planid:'',
                        drivername1:'',
                        drivername2:'',
                        createby:username
                    },
                    success: function (rs) {
                        // alert(rs);

                        swal.fire({
                            title: "Good Job!",
                            text: "เพิ่มข้อมูลเรียบร้อยแล้ว!!!",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            timer: 1500,
                        });
                        window.location.reload();
                        
                    }
                }); 

                // $.ajax({
                //     type: 'post',
                //     url: 'meg_data_drivingpattern_driver.php',
                //     data: {
                //         txt_flg: "save_dealermaster", materialtype: materialtype,
                //     },
                //     success: function (rs) {

                //         // alert(rs);
                //         swal.fire({
                //             title: "Good Job!",
                //             text: "เพิ่มชนิดเหล็กเรียบร้อยแล้ว!!!",
                //             icon: "success",
                //             showConfirmButton: true,
                //             allowOutsideClick: false,
                //             timer: 1500,
                //         });
                //         window.location.reload();

                //     }
                // });
            }
            

            // save_logprocess('Report', 'Excel รายงานค่าเที่ยว (เบี้ยเลี้ยง/อาหาร)(RCC,RATC)', '<?= $result_seLogin['PersonCode'] ?>');

        }
        function delete_gpsmonitor(id){
                                            
            // alert('delete');
            // alert(id);

            $.ajax({
                type: 'post',
                url: 'meg_data_gpsmonitoring.php',
                data: {

                txt_flg: "delete_gpsmonitoringmaster",
                trailernumber:'',
                problem:'',
                drivername:'',
                datetimedata:'',
                location:'',
                rootcause:'',
                result:'',
                gpscheck:'',
                jobno:'',
                planid:id,
                drivername1:'',
                drivername2:'',
                createby:''

                },
                success: function (response) {

                    // alert(response);
                    if (response) {

                        // alert("ลบข้อมูลเรียบร้อย");
                        swal.fire({
                            title: "Good Job!",
                            text: "ลบข้อมูลเรียบร้อยแล้ว!!!",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            icon: "success",
                            timer: 1500,    
                        });
                        window.location.reload();
                    }
                    
                    // // alert(rs);    
                }
            });

        }

        // function save_logprocess(category, process, employeecode)
        // {
        //     $.ajax({
        //         url: 'meg_data.php',
        //         type: 'POST',
        //         data: {
        //             txt_flg: "save_logprocess", category: category, process: process, employeecode: employeecode
        //         },
        //         success: function () {

                    

        //         }
        //     });
        // }


        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                responsive: true,
                order: [[0, "asc"]]
            });
        });

    </script>


</body>



</html>
<?php
sqlsrv_close($conn);
?>
