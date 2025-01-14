
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

// if ($_GET['id1'] != "") {
//     $condition1 = " AND a.MENUID = " . $_GET['id1'];
//     $sql_getMenu = "{call megMenu_v2(?,?)}";
//     $params_getMenu = array(
//         array('select_menu', SQLSRV_PARAM_IN),
//         array($condition1, SQLSRV_PARAM_IN)
//     );
//     $query_getMenu = sqlsrv_query($conn, $sql_getMenu, $params_getMenu);
//     $result_getMenu = sqlsrv_fetch_array($query_getMenu, SQLSRV_FETCH_ASSOC);
// }

// $sql_getDate = "{call megStopwork_v2(?)}";
// $params_getDate = array(
//     array('select_getdate', SQLSRV_PARAM_IN)
// );
// $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
// $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

// $sql_seName = "SELECT nameT AS 'NAME' FROM EMPLOYEEEHR2 WHERE PersonCode ='".$_GET['employeecode']."'";
// $params_seName = array();
// $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
// $result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC);

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
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <link href="../js/bootstrap-datepicker.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
    </head>
    <style>
    h1 {
        text-align: center;
        text-transform: uppercase;
        color: #000000;
        text-decoration: overline;
        text-decoration: underline;
        text-shadow: 2px 2px #9e9d9d;
        font-size:40px;
        }
        
        .frame {
        width: 90%;
        margin: 40px auto;
        text-align: center;
        }
        button {
        margin: 20px;
        }
        .custom-btn {
        width: 130px;
        height: 40px;
        color: #fff;
        border-radius: 5px;
        padding: 10px 25px;
        font-family: 'Lato', sans-serif;
        font-weight: 500;
        background: transparent;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        display: inline-block;
        box-shadow:inset 2px 2px 2px 0px rgba(255,255,255,.5),
        7px 7px 20px 0px rgba(0,0,0,.1),
        4px 4px 5px 0px rgba(0,0,0,.1);
        outline: none;
        }
        
    /* 11 */
    .btn-11 {
    border: none;
    background: rgb(251,33,117);
        background: linear-gradient(0deg, rgba(251,33,117,1) 0%, rgba(234,76,137,1) 100%);
        color: #fff;
        overflow: hidden;
    }
    .btn-11:hover {
        text-decoration: none;
        color: #fff;
    }
    .btn-11:before {
        position: absolute;
        content: '';
        display: inline-block;
        top: -180px;
        left: 0;
        width: 30px;
        height: 100%;
        background-color: #fff;
        animation: shiny-btn1 3s ease-in-out infinite;
    }
    .btn-11:hover{
    opacity: .7;
    }
    .btn-11:active{
    box-shadow:  4px 4px 6px 0 rgba(255,255,255,.3),
                -4px -4px 6px 0 rgba(116, 125, 136, .2), 
        inset -4px -4px 6px 0 rgba(255,255,255,.2),
        inset 4px 4px 6px 0 rgba(0, 0, 0, .2);
    }


    @-webkit-keyframes shiny-btn1 {
        0% { -webkit-transform: scale(0) rotate(45deg); opacity: 0; }
        80% { -webkit-transform: scale(0) rotate(45deg); opacity: 0.5; }
        81% { -webkit-transform: scale(4) rotate(45deg); opacity: 1; }
        100% { -webkit-transform: scale(50) rotate(45deg); opacity: 0; }
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
            <div class="modal fade" id="modal_addjobstartmaster" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 30%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5 class="modal-title" id="title_copydiagram"><b>เพิ่มข้อมูลพื้นฐาน</b></h5>
                                </div>

                            </div>
                        </div>
                        <div id="modaladdjobstartmastersr"></div>

                    </div>
                </div>
            </div>

            <div id="page-wrapper" >
                <div class="row">
                    <div class="col-md-12" style="background-color: #e7e7e7">
                        <h1>จัดการข้อมูลมาสเตอร์ต้นทาง RCC & RATC</h1>
                    </div>
                    <!-- <div class="col-md-12" style="background-color: #e7e7e7">
                        <h1><?=$result_seName['NAME']?></h1>
                    </div> -->
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="well">
                            <div class="row" style="text-align: center;font-size: 30px">
                                <b><p style="color:red"></p></b>
                            </div>
                    </div>
                </div>
            </div>
                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="text-align: right">
                            <!-- <button type="button" style= "height:40px;width:150px" class="btn btn-primary btn-md" name="myBtn" id ="myBtn" onclick="insert_data('<?=$empcheck?>','<?=$result_seYears['YEARS']?>','<?=$result_seYears['YEARS']?>')">เพิ่มข้อมูลพนักงาน</button> -->
                            <button style="margin-right: 15px;"  type="button" data-toggle="modal" data-target="#modal_addjobstartmaster" onclick="modaladdjobstartmaster('<?= $_GET['companycode'] ?>', '<?= $_GET['customercode'] ?>')" id="addmasterdata" name="addmasterdata" class="btn btn-outline btn-default"><li class="fa fa-plus-circle"></li> เพิ่มข้อมูลพื้นฐาน</button>
                        </div>
                        
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>
                    <!-- <input type="" name= "txt_drivercodeprintsimu" id="txt_drivercodeprintsimu" value="<?=$_GET['employeecode']?>"></input>
                    <input type="" name= "txt_yearstartprintsimu" id="txt_yearstartprintsimu" value="<?=$_GET['yearstart']?>"></input>
                    <input type="" name= "txt_yearendprintsimu" id="txt_yearendprintsimu" value="<?=$_GET['yearend']?>"></input>-->
                    <input type="hidden" name= "txt_user" id="txt_user" value="<?=$_SESSION["USERNAME"] ?>"></input> 
                                                              
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                
                                    <div class="row">
                                        <div class="col-sm-6"><a href='index2.php'>หน้าแรก</a> / รายละเอียดข้อมูลมาสเตอร์ต้นทาง RCC & RATC</div>
                                        <!-- <div class="col-sm-6 text-right"><a target="_bank" href='meg_vehiclrinfoamata.php?vehicleinfoid=&meg=add'>เพิ่มข้อมูลรถ</a></div> --> 
                                    </div>
                                
                                </div><br>
                                <!-- /.panel-heading -->
                                <!-- <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>พิมพ์ข้อมูล simulator</label><br>   
                                            
                                            <input type="button"  name="" id=""onclick="print_simulatorexcel()" value="พิมพ์ข้อมูล simulator (EXCEL)" class="btn btn-primary">
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
                                                                    <!-- <th>NO</th> -->
                                                                    <th>JOBSTART_ID</th>
                                                                    <th>JOBSTART</th>
                                                                    <th>ACTIVESTATUS</th>
                                                                    <th>EDIT</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            $i = 1;

                                                            // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
                                                            // $condiReporttransport2 = "";
                                                            // $condiReporttransport3 = "";

                                                            // ระบบจริงจะใช้ INNER JOIN
                                                            $sql_seJobstartMaster = "SELECT JOBSTARTID,JOBSTART,ACTIVESTATUS FROM [dbo].[JOBSTARTMASTER_RCCRATC]";
                                                            $params_seJobstartMaster = array();
                                                            $query_seJobstartMaster = sqlsrv_query($conn, $sql_seJobstartMaster, $params_seJobstartMaster);
                                                            while ($result_seJobstartMaster = sqlsrv_fetch_array($query_seJobstartMaster, SQLSRV_FETCH_ASSOC)) {
                                                        
                                                                ?>

                                                                <tr>
                                                                        <!-- <td style="text-align: center;"><?= $i ?></td> -->
                                                                        <td style="text-align: left;"><?= $result_seJobstartMaster['JOBSTARTID'] ?></td>
                                                                        <td style="text-align: left;"><?= $result_seJobstartMaster['JOBSTART'] ?></td>
                                                                        <td style="text-align: left;"><?= $result_seJobstartMaster['ACTIVESTATUS'] ?></td>
                                                                        <td style="text-align: left;"><input type="button"   onclick ="confirm_delete('<?=$result_seJobstartMaster['JOBSTARTID']?>');"       name="btnSend" id="btnSend" value="ลบข้อมูล" class="btn btn-danger"></td>
                                                                        <!-- <td style="text-align: center;"><input type="button"   data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!" onclick ="confirm_delete('<?=$result_seOrganizationData['ORGANIZATIONID']?>');"       name="btnSend" id="btnSend" value="ลบข้อมูล" class="btn btn-danger"></td>     -->
                                                                
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
            <script src="../js/jquery.datetimepicker.full.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../js/bootstrap-datepicker.min.js"></script>
            <script src="../js/bootstrap-datepicker.th.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>


    </body>
    <script>

                                        
                                        function modaladdjobstartmaster()
                                        {
                                            $.ajax({
                                                type: 'post',
                                                url: 'meg_data_transportprice_newrccratc.php',
                                                data: {
                                                    txt_flg: "modal_addjobstartmaster", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', worktype: '<?= $_GET['worktype'] ?>'
                                                },
                                                success: function (rs) {
                                                    document.getElementById("modaladdjobstartmastersr").innerHTML = rs;
                                                }


                                            });
                                        }
                                        function add_jobstartmaster(activestatus){

                                            // alert(vehicledesccode);
                                            // alert(companycode);
                                            // alert(customercode);
                                            // alert(worktype);
                                            // alert(activestatus);
                                            let jobstart = $("#txt_jobstart").val();
                                            // alert(cluster);
                                            if (jobstart == '') {
                                                swal.fire({
                                                    title: "Warning!",
                                                    text: "ข้อมูลต้นทางเป็นค่าว่าง!!",
                                                    icon: "warning",
                                                    showConfirmButton: true,
                                                });
                                            }else{
                                                $.ajax({
                                                    type: 'post',
                                                    url: 'meg_data_transportprice_newrccratc.php',
                                                    data: {

                                                        txt_flg: "save_jobstartmaster", vehicledesccode: '', worktype: '', companycode: '', customercode: '', activestatus: activestatus, data1: document.getElementById("txt_jobstart").value, data2: '', data3: '', data4: '', data5: ''

                                                    },
                                                    success: function (rs) {
                                                        // alert(rs);
                                                        swal.fire({
                                                            title: "Good Job!",
                                                            text: "บันทึกข้อมูลเรียบร้อย",
                                                            icon: "success",
                                                            showConfirmButton: false,
                                                        });
                                                        setTimeout(function(){
                                                            window.location.reload();
                                                        }, 1200);
                                                    }
                                                }); 
                                            }
                                        }
                                        
                                        $(document).ready(function () {
                                            $('#dataTables-example').DataTable({
                                                order: [[0, "asc"]],
                                                scrollX: true,
                                                scrollY: '500px',
                                            });
                                        });

                                  
                                        function confirm_delete(jobstartid){
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
                                                    // Swal.fire(
                                                    // 'Deleted!',
                                                    // 'Your file has been deleted.',
                                                    // 'success'
                                                    // )
                                                    delete_jobstartmaster(jobstartid); 
                                                    // window.location.reload();  
                                                }else{
                                                    window.location.reload();
                                                }
                                            })

                                        } 
                                        function delete_jobstartmaster(jobstartid){
                                            
                                            // alert('delete');
                                            // alert(id);

                                            $.ajax({
                                                type: 'post',
                                                url: 'meg_data_transportprice_newrccratc.php',
                                                data: {

                                                txt_flg: "delete_jobstartmaster",jobstartid: jobstartid
                                                },
                                                success: function (response) {
                                                    
                                                    swal.fire({
                                                        title: "Deleted!",
                                                        text: "ลบข้อมูลเรียบร้อย",
                                                        icon: "success",
                                                        showConfirmButton: false,
                                                    });
                                                    setTimeout(function(){
                                                        window.location.reload();
                                                    }, 1200);
                                                    }
                                            });
                                        }    

                                        $(function () {
                                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                            // กรณีใช้แบบ input
                                            $(".dateensimu").datetimepicker({
                                                timepicker: false,
                                                format: 'Y-m-d', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                            });
                                        });
                                        
    </script>   
</html>
<?php
sqlsrv_close($conn);
?>
