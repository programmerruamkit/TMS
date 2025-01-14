
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$condiCompany = " AND Company_Code = '" . $_GET['companycode'] . "'";
$sql_seCompany = "{call megCompany_v2(?,?)}";
$params_seCompany = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condiCompany, SQLSRV_PARAM_IN)
);
$query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
$result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);

$condiCustomer = " AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
$sql_seCustomer = "{call megCustomer_v2(?,?)}";
$params_seCustomer = array(
    array('select_customer', SQLSRV_PARAM_IN),
    array($condiCustomer, SQLSRV_PARAM_IN)
);
$query_seCustomer = sqlsrv_query($conn, $sql_seCustomer, $params_seCustomer);
$result_seCustomer = sqlsrv_fetch_array($query_seCustomer, SQLSRV_FETCH_ASSOC);
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

                        <h2 class="page-header"><i class="fa fa-file-text-o"></i>
                            รายงานประวัติวิ่งงาน


                        </h2>
                    </div>

                    <!-- /.col-lg-12 -->
                </div>

                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row" >
                                    <div class="col-lg-6">

                                        รายงานประวัติวิ่งงาน

                                    </div>
                                    <div class="col-lg-6 text-right"></div>
                                </div>
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <div class="row">&nbsp;</div>
                                    <div class="row" >
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">


                                                    <div class="col-lg-2">

                                                        <div class="form-group">
                                                            <label>ค้นหาตามช่วงวันที่</label>
                                                            <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">

                                                        </div>

                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>เลือกพนักงาน:</label>
                                                        <div class="dropdown bootstrap-select show-tick form-control">

                                                            <select   id="txt_drivername" name="txt_drivername" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                <?php
                                                                // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                                $sql_seName = "SELECT PersonCode AS 'EMPLOYEECODE',nameT AS 'DRIVERNAME'
                                                                FROM EMPLOYEEEHR2  WHERE 1=1 
                                                                AND PersonCode  NOT IN('010001','011661','021300','040827','050049'
                                                                ,'060226','070116','090289','030001','100001')
                                                                ORDER BY PersonCode ASC";
                                                                $params_seName = array();
                                                                $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                                                while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <option value="<?= $result_seName['EMPLOYEECODE'] ?>"><?= $result_seName['DRIVERNAME'] ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <input class="form-control" style="display: none"   id="txt_chkdrivername" name="txt_chkdrivername" maxlength="500" value="" >


                                                            <!-- <div class="dropdown-menu open" role="combobox">
                                                                <div class="bs-searchbox">
                                                                    <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
                                                                <div class="bs-actionsbox">
                                                                    <div class="btn-group btn-group-sm btn-block">
                                                                        <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
                                                                        <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
                                                                    </div>
                                                                </div>
                                                                <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
                                                                    <ul class="dropdown-menu inner "></ul>
                                                                </div>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>เลือกทะเบียนรถ:</label>
                                                        <div class="dropdown bootstrap-select show-tick form-control">

                                                            <select   id="txt_regisnumber" name="txt_regisnumber" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ทะเบียนรถ..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                <?php
                                                                // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                                $sql_seRegisnumber = "SELECT VEHICLEREGISNUMBER,THAINAME  FROM VEHICLEINFO
                                                                WHERE ACTIVESTATUS ='1'
                                                                ORDER BY VEHICLEREGISNUMBER ASC";
                                                                $params_seRegisnumber = array();
                                                                $query_seRegisnumber = sqlsrv_query($conn, $sql_seRegisnumber, $params_seRegisnumber);
                                                                while ($result_seRegisnumber = sqlsrv_fetch_array($query_seRegisnumber, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <option value="<?= $result_seRegisnumber['VEHICLEREGISNUMBER'] ?>"><?= $result_seRegisnumber['VEHICLEREGISNUMBER'] ?> (<?=$result_seRegisnumber['THAINAME']?>)</option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <input class="form-control" style="display: none"   id="txt_copydiagramzone" name="txt_copydiagramzone" maxlength="500" value="" >


                                                            <!-- <div class="dropdown-menu open" role="combobox">
                                                                <div class="bs-searchbox">
                                                                    <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
                                                                <div class="bs-actionsbox">
                                                                    <div class="btn-group btn-group-sm btn-block">
                                                                        <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
                                                                        <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
                                                                    </div>
                                                                </div>
                                                                <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
                                                                    <ul class="dropdown-menu inner "></ul>
                                                                </div>
                                                            </div> -->
                                                        </div>
                                                    </div>    
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_reporttransportplanamt();">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-2" style="text-align: right">
                                                        <label>&nbsp;</label><br>
                                                        <a href="#" onclick="excel_reporttransportroutehistory();" class="btn btn-default">พิมพ์รายงานขนส่ง <li class="fa fa-print"></li></a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                    รายงานแผนการขนส่ง AMT
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ลำดับ</th>
                                                                        <th>วันที่</th>
                                                                        <th>ทะเบียน</th>
                                                                        <th>ประเภทรถ</th>
                                                                        <th>ต้นทาง</th>
                                                                        <th>คลัสเตอร์</th>
                                                                        <th>ปลายทาง</th>
                                                                        <th>พขร.1</th>
                                                                        <th>พขร.2</th>
                                                                        <th>เลขไมค์ต้น</th>
                                                                        <th>เลขไมค์ปลาย</th>
                                                                        <th>กิโลเมตรที่วิ่งงาน</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>


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
                                </div>




                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                </div>
                <!-- /.row -->

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
            <script src="../dist/js/jquery.autocomplete.js"></script>
            <script>

                                                            function select_reporttransportplanamt()
                                                            {


                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                var drivername = document.getElementById('txt_drivername').value;
                                                                var thainame = document.getElementById('txt_regisnumber').value;

                                                                
                                                                // alert(datestart);
                                                                // alert(dateend);
                                                                // alert(drivername);
                                                                // alert(thainame);

                                                                if (drivername == '' && thainame == '') {
                                                                    
                                                                   var check ='driverandthaiisnull';

                                                                //    alert(check);
                                                                }else if(drivername == ''){
                                                                    
                                                                    var check ='driverisnull';
                                                                    // alert(check);
                                                                }else if(thainame == ''){
                                                                    
                                                                    var check ='thainameisnull'; 
                                                                    // alert(check); 
                                                                }else{
                                                                   
                                                                    var check ='else';
                                                                    // alert(check);
                                                                }
                                                                
                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data2.php',
                                                                    data: {
                                                                        txt_flg: "select_reporttransportroutehistory", datestart: datestart, dateend: dateend,check: check,drivername: drivername,thainame: thainame
                                                                    },
                                                                    success: function (response) {
                                                                        if (response)
                                                                        {
                                                                            document.getElementById("datasr").innerHTML = response;
                                                                            document.getElementById("datadef").innerHTML = "";
                                                                        }
                                                                        $(document).ready(function () {
                                                                            $('#dataTables-example1').DataTable({
                                                                                responsive: true,
                                                                            });
                                                                        });



                                                                    }
                                                                });


                                                            }
                                                            function excel_reporttransportroutehistory()
                                                            {
                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                var drivername = document.getElementById('txt_drivername').value;
                                                                var thainame = document.getElementById('txt_regisnumber').value;

                                                                if (drivername == '' && thainame == '') {
                                                                    
                                                                    var check ='driverandthaiisnull';
 
                                                                 //    alert(check);
                                                                 }else if(drivername == ''){
                                                                     
                                                                     var check ='driverisnull';
                                                                     // alert(check);
                                                                 }else if(thainame == ''){
                                                                     
                                                                     var check ='thainameisnull'; 
                                                                     // alert(check); 
                                                                 }else{
                                                                    
                                                                     var check ='else';
                                                                     // alert(check);
                                                                 }

                                                                window.open('excel_reporttransportroutehistory.php?datestart=' + datestart + '&dateend=' + dateend+ '&check=' + check+ '&drivername=' + drivername+ '&thainame=' + thainame, '_blank');

                                                            }
                                                            function gdatetodate()
                                                            {
                                                                document.getElementById('txt_gdateend').value = document.getElementById('txt_gdatestart').value;
                                                            }
                                                            function datetodate()
                                                            {
                                                                document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                                                            }
                                                            $(function () {
                                                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                // กรณีใช้แบบ input
                                                                $(".dateen").datetimepicker({
                                                                    timepicker: false,
                                                                    format: 'd/m/Y ', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                    timeFormat: "HH:mm"

                                                                });
                                                            });

                                                            $(document).ready(function () {
                                                                $('#dataTables-example').DataTable({
                                                                    responsive: true,
                                                                });
                                                            });

                                                            // $(document).ready(function () {
                                                            //     $('#dataTables-example1').DataTable({
                                                            //         responsive: true,
                                                            //     });
                                                            // });
            </script>


    </body>

</html>

<?php
sqlsrv_close($conn);
?>
