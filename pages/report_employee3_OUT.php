
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
$sql_seLogin = "{call megRoleaccount_v2(?,?)}";
$params_seLogin = array(
    array('select_roleaccount', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
$result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);
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
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
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
        <!-- <input type="text" class="form-control" id="txt_employeecode" name="txt_employeecode" style="display: none"> -->
        
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php
                include '../pages/meg_header.php';
                include '../pages/meg_leftmenu.php';
                ?>
            </nav>
            
            <div class="modal fade" id="modal_dateemployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" >
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <!-- display: none -->
                                <div class="col-lg-12">
                                    <input type="text" class="form-control" id="txt_employeecode_1" name="txt_employeecode_1" style="display: none">
                                    <h5 class="modal-title" id="title_copydiagram"><b>เลือก เดือน/ปี ในการแสดงข้อมูล</b> <font color="red">*ห้ามดึงข้อมูลเกิน 1 เดือน หรือมากกว่า 31 วัน</font></h5>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label>เลือกหัวกระดาษ</label>
                            <select id="select_paperheader" name="select_paperheader" class="form-control">
                                <option value="">เลือกหัวกระดาษ</option>
                                <option value="RKS">RKS</option>
                                <option value="RKR">RKR</option>
                                <option value="RKL">RKL</option>
                                <option value="RCC">RCC</option>
                                <option value="RRC">RRC</option>
                                <option value="RATC">RATC</option>
                            </select>
                        </div>
                        <br><br><br>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label>วันที่เริ่มต้น :</label>
                                    <input type="text" class="form-control dateen"  id="txt_datestart3" name="txt_datestart3" autocomplete="off">
                                </div>


                            </div>

                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label>วันที่สิ้นสุด :</label>
                                    <input type="text" class="form-control dateen"  id="txt_dateend3" name="txt_dateend3" autocomplete="off">
                                </div>


                            </div>

                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-primary" onclick="select_employeecompensationexcel()">EXCEL <i class="fa fa-print"></i></button> -->
                            <button type="button" class="btn btn-primary" onclick="select_employeecompensation()">PDF <i class="fa fa-print"></i></button>
                        </div>

                    </div>
                </div>
            </div>
            <div id="page-wrapper" >
                <div class="row" >
                    <div class="col-lg-12">
                        <h2 class="page-header">
                            <i class="glyphicon glyphicon-user"></i> ข้อมูลพนักงาน(คนออก)



                        </h2>




                    </div>
                    <!-- /.panel-body -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">

                                <?php
                                echo "ข้อมูลพนักงาน(คนออก)";
                                ?>
                            </div>
                            <!-- /.panel-heading -->

                            <div class="panel-body">
                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>รหัสพนักงาน</th>
                                                    <th>ชื่อ-นามสกุล</th>
                                                    <th>วันที่ออกจากงาน</th>
                                                    <th style="text-align: center">ข้อมูลย่อย</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // $condition2 = ($_GET['area'] == 'gateway') ? " AND a.Company_Code IN ('RRC','RATC','RCC')" : " AND a.Company_Code IN ('RKS','RKR','RKL','RTC','RTD','RIT')";
                                                // $condition3 = "";

                                                // $sql_seEmp = "{call megEmployeeEHR_v2(?,?)}";
                                                // $params_seEmp = array(
                                                //     array('select_employeeehr2', SQLSRV_PARAM_IN),
                                                //     array($condition2, SQLSRV_PARAM_IN)
                                                // );

                                                $sql_seEmp = "SELECT DISTINCT PersonID,PersonCode,PersonCardID,FnameT,LnameT,
                                                CONVERT(VARCHAR(21),EndDate,103) AS 'ENDDATE'
                                                FROM [203.150.225.30].[TigerE-HR].dbo.PNT_Person 
                                                WHERE (EndDate IS NOT NULL OR SUBSTRING(PersonCode, 1, 2) ='08')
                                                ORDER BY PersonCode ASC";
                                                $params_seDep = array(
                                                    array('', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
                                                while ($result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?= $result_seEmp['PersonCode'] ?></td>
                                                        <td><?= $result_seEmp['FnameT'] ?>&nbsp;<?=$result_seEmp['LnameT']?></td>
                                                        <td></td>
                                                        <td style="text-align: center">
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                    <i class="fa fa-chevron-down"></i>
                                                                </button>
                                                                <ul class="dropdown-menu slidedown">
                                                                    <li>
                                                                        <a  data-toggle="modal" data-target="#modal_dateemployee" href="#" onclick="modal_employeecompensation('<?= $result_seEmp['PersonCode'] ?>')">
                                                                            รายงานค่าเที่ยวรายบุคคล
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>



                                                    </tr>

                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
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
    <script src="../dist/js/bootstrap-select.js"></script>
    <script>
        
            // function select_companycompensationexcel1()
            // {

            //     save_logprocess('Report', 'Excel รายงานค่าเที่ยว (เบี้ยเลี้ยง/อาหาร)(RCC,RATC)', '<?= $result_seLogin['PersonCode'] ?>');
            //     var datestart = document.getElementById('txt_datestart').value;
            //     var companycode = '';
            //     var employeecode = document.getElementById('txt_employeecode').value;
            //     if (employeecode.substring(0, 2) == '09')
            //     {
            //         companycode = 'RATC';
            //     }
            //     if (employeecode.substring(0, 2) == '04')
            //     {
            //         companycode = 'RCC';
            //     }
            //     if (employeecode.substring(0, 2) == '05')
            //     {
            //         companycode = 'RRC';
            //     }


            //     window.open('excel_reportcompanycompensationgw1.php?companycode=' + companycode + '&datestart=' + datestart + '&employeecode=' + employeecode, '_blank');


            // }
            function select_employeecode(employeecode)
            {
                // alert(employeecode);
                document.getElementById('txt_employeecode').value = employeecode;
            }
            function save_logprocess(category, process, employeecode)
            {
                $.ajax({
                    url: 'meg_data.php',
                    type: 'POST',
                    data: {
                        txt_flg: "save_logprocess", category: category, process: process, employeecode: employeecode
                    },
                    success: function () {


                    }
                });
            }
            function modal_employeecompensation(employeecode)
            {
                // alert(employeecode);
                document.getElementById('txt_employeecode_1').value = employeecode;
            }

            function select_employeecompensation()
            {
                save_logprocess('Report', 'Print รายงานค่าเที่ยว(บุคคล)(AMT)', '<?= $result_seLogin['PersonCode'] ?>');
                
                var datestart = document.getElementById('txt_datestart3').value;
                var dateend = document.getElementById('txt_dateend3').value;

                // รูปแบบ เดือน/วัน/ปี
                // วันที่เริ่มต้น
                let textdatestart = datestart;
                //วัน
                let resultstart1 = textdatestart.substring(0,2);
                // เดือน
                let resultstart2 = textdatestart.substring(3,5);
                // ปี
                let resultstart3 = textdatestart.substring(6,10);

                var date1 = new Date(resultstart2+"/"+resultstart1+"/"+resultstart3);

                ///////////////////////////////////////
                // รูปแบบ เดือน/วัน/ปี
                // วันที่สิ้นสุด
                let textdateend = dateend;
                //วัน
                let resultend1 = textdateend.substring(0,2);
                // เดือน
                let resultend2 = textdateend.substring(3,5);
                // ปี
                let resultend3 = textdateend.substring(6,10);

                var date2 = new Date(resultend2+"/"+resultend1+"/"+resultend3);
                ///////////////////////////////////////

                // var date1 = new Date("01/21/2022");
                // var date2 = new Date("01/31/2022");

                var diffTime = date2.getTime() - date1.getTime();
                var diffDay = diffTime / (1000 * 3600 * 24);

                // alert(date1);
                // alert(date2);
                // alert(diffDay);
                

                var employeecode = document.getElementById('txt_employeecode_1').value;
                // alert(employeecode);
                var paperheader = document.getElementById('select_paperheader').value;

                if (diffDay > "31") {
                    alert("ไม่สามารถเลือกวันเกิน 1 เดือน หรือมากกว่า 31 วันได้!!!")
                }else if (paperheader == ''){
                    alert("กรุณาเลือกหัวกระดาษ !!!")
                }else{

                   
                    window.open('pdf_employeecompensation_out.php?employeecode=' + employeecode + '&datestart=' + datestart+ '&dateend=' + dateend+ '&paperheader=' + paperheader, '_blank');  
                    
                }

                
                


            }
            // function select_employeecompensationexcel()
            // {
            //     save_logprocess('Report', 'Excel รายงานค่าเที่ยว(บุคคล)(AMT)', '<?= $result_seLogin['PersonCode'] ?>');
                
            //     var datestart = document.getElementById('txt_datestart3').value;
            //     var dateend = document.getElementById('txt_dateend3').value;
                
            //     var employeecode = document.getElementById('txt_employeecode').value;
                

            //     // รูปแบบ เดือน/วัน/ปี
            //     // วันที่เริ่มต้น
            //     let textdatestart = datestart;
            //     //วัน
            //     let resultstart1 = textdatestart.substring(0,2);
            //     // เดือน
            //     let resultstart2 = textdatestart.substring(3,5);
            //     // ปี
            //     let resultstart3 = textdatestart.substring(6,10);

            //     var date1 = new Date(resultstart2+"/"+resultstart1+"/"+resultstart3);

            //     ///////////////////////////////////////
            //     // รูปแบบ เดือน/วัน/ปี
            //     // วันที่สิ้นสุด
            //     let textdateend = dateend;
            //     //วัน
            //     let resultend1 = textdateend.substring(0,2);
            //     // เดือน
            //     let resultend2 = textdateend.substring(3,5);
            //     // ปี
            //     let resultend3 = textdateend.substring(6,10);

            //     var date2 = new Date(resultend2+"/"+resultend1+"/"+resultend3);
            //     ///////////////////////////////////////

            //     // var date1 = new Date("01/21/2022");
            //     // var date2 = new Date("01/31/2022");

            //     var diffTime = date2.getTime() - date1.getTime();
            //     var diffDay = diffTime / (1000 * 3600 * 24);

            //     // alert(date1);
            //     // alert(date2);
            //     // alert(diffDay);





            //     if (diffDay > "31") {
            //         alert("ไม่สามารถเลือกวันเกิน 1 เดือน หรือมากกว่า 31 วันได้!!!")
            //     }else{

            //         var chk = employeecode.substring(0, 2);
            //         if (chk == '01' || chk == '02' || chk == '07'){
            //         // alert('amt');  
            //         window.open('excel_reportemployeecompensation_amt.php?employeecode=' + employeecode + '&datestart=' + datestart+ '&dateend=' + dateend, '_blank');  
            //         }else{
            //         // alert('gw'); 
            //         window.open('excel_reportemployeecompensation_gw.php?employeecode=' + employeecode + '&datestart=' + datestart+ '&dateend=' + dateend, '_blank');
            //         }
            //     }

                
            // }
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true,
                    order: [[0, "desc"]]
                });
            });



                                                                            
    </script>


</body>

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

    function delete_roleaccount(val)
    {
        var confirmation = confirm("ต้องการลบข้อมูล ?");

        if (confirmation) {
            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "delete_roleaccount", roleaccountid: val
                },
                success: function () {
                    alert('ลบข้อมูลเรียบร้อยแล้ว');
                    window.location.reload();
                }
            });
        }
    }
    function delete_role(val)
    {
        var confirmation = confirm("ต้องการลบข้อมูล ?");

        if (confirmation) {
            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "delete_role", roleid: val
                },
                success: function () {
                    alert('ลบข้อมูลเรียบร้อยแล้ว');
                    window.location.reload();
                }
            });
        }
    }
    function delete_rolemenu(val)
    {
        var confirmation = confirm("ต้องการลบข้อมูล ?");

        if (confirmation) {
            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "delete_rolemenu", rolemenuid: val
                },
                success: function () {
                    alert('ลบข้อมูลเรียบร้อยแล้ว');
                    window.location.reload();
                }
            });
        }
    }
</script>

</html>
<?php
sqlsrv_close($conn);
?>
