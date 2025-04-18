
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
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <link href="../js/bootstrap-datepicker.css" rel="stylesheet">

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
                    <div class="col-md-12" style="background-color: #e7e7e7">
                        <h1>SIMULATOR INFORMATION</h1>
                    </div>
                    <div class="col-md-12" style="background-color: #e7e7e7">
                        <h1><?=$result_seName['NAME']?></h1>
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

                    <input type="hidden" name= "txt_drivercodeprintsimu" id="txt_drivercodeprintsimu" value="<?=$_GET['employeecode']?>"></input>
                    <input type="hidden" name= "txt_yearstartprintsimu" id="txt_yearstartprintsimu" value="<?=$_GET['yearstart']?>"></input>
                    <input type="hidden" name= "txt_yearendprintsimu" id="txt_yearendprintsimu" value="<?=$_GET['yearend']?>"></input>
                    <input type="hidden" name= "txt_user" id="txt_user" value="<?=$_SESSION["USERNAME"] ?>"></input>
                                                              
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">

                                    <div class="row">
                                        <div class="col-sm-6"><a href='meg_simulatorhistory.php'>บันทึกข้อมูล simulator</a> / รายละเอียดข้อมูล simulator</div>
                                        <!-- <div class="col-sm-6 text-right"><a target="_bank" href='meg_vehiclrinfoamata.php?vehicleinfoid=&meg=add'>เพิ่มข้อมูลรถ</a></div> --> 
                                    </div>
                                
                                </div><br>
                                <!-- /.panel-heading -->
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>พิมพ์ข้อมูล simulator</label><br>   
                                            <!-- <input type="button"  name="" id=""onclick="print_accidentpdf()" value="พิมพ์ข้อมูลประวัติอุบัติเหตุ (PDF)" class="btn btn-primary"> -->
                                            <input type="button"  name="" id=""onclick="print_simulatorexcel()" value="พิมพ์ข้อมูล simulator (EXCEL)" class="btn btn-primary">
                                        </div>
                                    </div>
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
                                                                    <th>ลำดับ</th>
                                                                    <th>รหัสพนักงาน</th>
                                                                    <th>ชื่อพนักงาน</th>
                                                                    <th>อายุพนักงาน</th>
                                                                    <th>ผ่าน TLEP ครั้งแรก</th>
                                                                    <th>ผ่าน TLEP ล่าสุด</th>
                                                                    <th>T-LEP Years</th>
                                                                    <th>จุดอ่อนข้อที่ 1 </th>
                                                                    <th>จุดอ่อนข้อที่ 2 </th>
                                                                    <th>จุดอ่อนข้อที่ 3 </th>
                                                                    <th>สวมแว่นสายตา</th>
                                                                    <th>จัดการ</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            $i = 1;

                                                            // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
                                                            // $condiReporttransport2 = "";
                                                            // $condiReporttransport3 = "";

                                                            $sql_seSimulatorData = "SELECT a.SIMUID,a.DRIVERCODE,a.DRIVERNAME,a.YEARSSIMU,a.TLEP_FIRSTDATE,a.TLEP_FOLLOWUP,
                                                            a.SIMUDATA1,a.SIMUDATA2,a.SIMUDATA3,a.TLEP_WEARGLASSES,b.BirthDate103,b.[yearb],b.monthb,b.dayb,
                                                            CAST(DATEDIFF(yy, TLEP_FOLLOWUP, GETDATE()) AS varchar(4)) +' Year ' AS 'TLEP_YEAR',
                                                            CAST(DATEDIFF(mm, DATEADD(yy, DATEDIFF(yy, TLEP_FOLLOWUP, GETDATE()), TLEP_FOLLOWUP), GETDATE()) AS varchar(2)) +' Month ' AS 'TLEP_MONTH'
                                                            FROM SIMULATORHISTORY a
                                                            INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a.DRIVERCODE
                                                            WHERE a.DRIVERCODE = '".$_GET['employeecode']."'
                                                            AND a.YEARSSIMU BETWEEN '".$_GET['yearstart']."' AND '".$_GET['yearend']."'
                                                            ORDER BY a.TLEP_FOLLOWUP DESC";
                                                            $params_seSimulatorData = array();
                                                            $query_seSimulatorData = sqlsrv_query($conn, $sql_seSimulatorData, $params_seSimulatorData);
                                                            while ($result_seSimulatorData = sqlsrv_fetch_array($query_seSimulatorData, SQLSRV_FETCH_ASSOC)) {

                                                               
                                                                ?>

                                                                <tr>
                                                                    <td style="text-align: center"><?= $i ?></td>
                                                                    <td><?= $result_seSimulatorData['DRIVERCODE'] ?></td>
                                                                    <td><?= $result_seSimulatorData['DRIVERNAME'] ?></td>
                                                                    <td><?= $result_seSimulatorData['yearb'] ?> Y <?= $result_seSimulatorData['monthb']?> M</td>
                                                                    <td><?= $result_seSimulatorData['TLEP_FIRSTDATE'] ?></td>
                                                                    <td><?= $result_seSimulatorData['TLEP_FOLLOWUP'] ?></td>
                                                                    <!-- <td><input class="form-control dateensimu" placeholder="วันที่ TLEP ครั้งแรก"  title="วันที่ TLEP ครั้งแรก" onchange="edit_simulator(this.value, 'DATESIMUFIRST', '<?=$result_seSimulatorData['SIMUID']?>')"  style="height:40px; width:200px" id="txt_dayaccident" name="txt_dayaccident" value="<?= $result_seSimulatorData['TLEP_FIRSTDATE'] ?>"  min="" max=""  autocomplete="off"></td>
                                                                    <td><input class="form-control dateensimu" placeholder="วันที่ TLEP ล่าสุด"    title="วันที่ TLEP ล่าสุด"  onchange="edit_simulator(this.value, 'DATESIMUFOLLOW', '<?=$result_seSimulatorData['SIMUID']?>')"  style="height:40px; width:200px" id="txt_dayaccident" name="txt_dayaccident" value="<?= $result_seSimulatorData['TLEP_FOLLOWUP'] ?>"  min="" max=""  autocomplete="off"></td> -->
                                                                    <td><?= $result_seSimulatorData['TLEP_YEAR'] ?><br><?= $result_seSimulatorData['TLEP_MONTH'] ?></td>
                                                                    <td><?= $result_seSimulatorData['SIMUDATA1'] ?></td>
                                                                    <td><?= $result_seSimulatorData['SIMUDATA2'] ?></td>
                                                                    <td><?= $result_seSimulatorData['SIMUDATA3'] ?></td>
                                                                    <td><?= $result_seSimulatorData['TLEP_WEARGLASSES']  == '1' ? 'สวมแว่น' : 'ไม่สวมแว่น' ?></td>
                                                                    <!-- <td><input class="form-control" placeholder="Driving Simulator"    title="Driving Simulator"  onchange="edit_simulator(this.value, 'SIMUDATA', '<?=$result_seSimulatorData['SIMUID']?>')"  style="height:40px; width:200px" id="txt_dayaccident" name="txt_dayaccident" value="<?= $result_seSimulatorData['SIMUDATA'] ?>"  min="" max=""  autocomplete="off"></td> -->
                                                                    <td style="text-align: center"><input type="button"   data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!" onclick ="confirm_delete('<?=$result_seSimulatorData['SIMUID']?>');" name="btnSend" id="btnSend" value="ลบข้อมูล" class="btn btn-danger"></td>
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


    </body>
    <script>

                                        // function print_accidentpdf()
                                        // {

                                        //     var drivername = document.getElementById('txt_drivernameprint').value;
                                        //     var yearstart = document.getElementById('txt_yearstartprint').value;
                                        //     var yearend = document.getElementById('txt_yearendprint').value;
                                            
                                        //     window.open('pdf_digitaltenko_accidentdata.php?drivername='+ drivername+'&yearstart='+yearstart+'&yearend='+yearend, '_blank');
                                           
                                        // } 

                                        function print_simulatorexcel()
                                        {

                                            var drivercode = document.getElementById('txt_drivercodeprintsimu').value;
                                            var yearstart = document.getElementById('txt_yearstartprintsimu').value;
                                            var yearend = document.getElementById('txt_yearendprintsimu').value;
                                            
                                            window.open('excel_simulatordata.php?employeecode='+ drivercode+'&yearstart='+yearstart+'&yearend='+yearend, '_blank');
                                           
                                        } 
                                        $(document).ready(function () {
                                            $('#dataTables-example').DataTable({
                                                order: [[0, "asc"]],
                                                scrollX: true,
                                                scrollY: '500px',
                                            });
                                        });

                                  
                                        function confirm_delete(id){
                                            $(document).on('click', ':not(form)[data-confirm]', function(e){
                                                if(confirm($(this).data('confirm'))){
                                                e.stopImmediatePropagation();
                                                e.preventDefault();
                                                
                                                delete_simulator(id);   
                                                }else{

                                                    window.location.reload();      
                                                }

                                            
                                            }); 

                                        } 
                                        function edit_simulator(value, fieldname, simulatorid) {

                                            // alert(value);
                                            // alert(fieldname);
                                            // alert(simulatorid);
                                            // alert(IDPLAN);
                                            // alert(IDDRIVER);

                                            var modifyby = document.getElementById('txt_user').value;
                                            // //  alert(modifyby);

                                            $.ajax({
                                                url: 'meg_data2.php',
                                                type: 'POST',
                                                data: {
                                                    txt_flg: "update_simulator", value: value, fieldname: fieldname, simuid: simulatorid,modifyby: modifyby
                                                },
                                                success: function (rs) {

                                                    // window.location.reload();
                                                }
                                            });


                                        }
                                        function delete_simulator(id){
                                            
                                            // alert('delete');
                                            // alert(id);

                                            $.ajax({
                                                    type: 'post',
                                                    url: 'meg_data2.php',
                                                    data: {

                                                    txt_flg: "delete_simulator",
                                                    id:id, 
                                                    drivername: '',
                                                    years: '', 
                                                    type: '',
                                                    score: '',
                                                    remark: '',
                                                    createby: ''


                                                    },
                                                    success: function (response) {
                                                        if (response) {

                                                            alert("บันทึกข้อมูลเรียบร้อย");
                                                             window.location.reload();
                                                        }
                                                        
                                                        // // alert(rs);    
                                                       
                                                    

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
