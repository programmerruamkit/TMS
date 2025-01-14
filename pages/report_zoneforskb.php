
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
require_once("../class/meg_function.php");
$conn = connect("RTMS");

// $sql_getDate = "{call megStopwork_v2(?)}";
// $params_getDate = array(
//     array('select_getdate', SQLSRV_PARAM_IN)
// );
// $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
// $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

// $condiCompany = " AND Company_Code = '" . $_GET['companycode'] . "'";
// $sql_seCompany = "{call megCompany_v2(?,?)}";
// $params_seCompany = array(
//     array('select_company', SQLSRV_PARAM_IN),
//     array($condiCompany, SQLSRV_PARAM_IN)
// );
// $query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
// $result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);

// $condiCustomer = " AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
// $sql_seCustomer = "{call megCustomer_v2(?,?)}";
// $params_seCustomer = array(
//     array('select_customer', SQLSRV_PARAM_IN),
//     array($condiCustomer, SQLSRV_PARAM_IN)
// );
// $query_seCustomer = sqlsrv_query($conn, $sql_seCustomer, $params_seCustomer);
// $result_seCustomer = sqlsrv_fetch_array($query_seCustomer, SQLSRV_FETCH_ASSOC);
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
        <!-- modal ข้อมูล ภาคที่จะแก้ไข-->

        <div class="container" >
          <div class="modal fade" id="myModalshowzoneskb" role="dialog">
            <div class="modal-dialog" style="width: 700px; height: 200px;">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><b>จัดการข้อมูลภาค</b></h4>
                </div>
                    <div class="modal-body">
                        <div class="row" >
                            <div class="col-lg-12">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                <div id="datazonedef">
                                </div>
                                <div id="datazonesr"></div>
                            </div>                              
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">                                            
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
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

                        <h2 class="page-header"><i class="fa fa-file-text-o"></i>
                            ข้อมูลภาคสายงานคูโบต้า


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

                                        ข้อมูลภาคสายงานคูโบต้า

                                    </div>
                                    <div class="col-lg-6 text-right"></div>
                                </div>
                            </div>
                            <input type="text" hidden id="txt_createby" name="txt_createby" value="<?=$_SESSION["USERNAME"]?>">
                            <input type="text" hidden id="txt_modifyby" name="txt_modifyby" value="<?=$_SESSION["USERNAME"]?>">
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <div class="row">&nbsp;</div>
                                    <div class="row" >
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <label >เพิ่มข้อมูลจังหวัด <font style="color:red;">*จำเป็นต้องเพิ่ม</font></label>
                                                        <div class="form-group">
                                                            <input class="form-control" style=""   id="txt_insertprovince" name="txt_insertprovince" maxlength="500" value="" >
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label>เพิ่มข้อมูลภาค <font style="color:red;">*จำเป็นต้องเพิ่ม</font></label>
                                                        <div class="form-group">
                                                            <input class="form-control" style=""   id="txt_insertzone" name="txt_insertzone" maxlength="500" value="" >
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <td> <button type="button" class="btn btn-primary" name="myBtn" id ="myBtn"   onclick="insert_zoneskb();">เพิ่มข้อมูล</button></td>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">


                                                    <div class="col-lg-3">

                                                        <div class="form-group">
                                                            <label>ภาคที่ต้องการค้นหา</label>
                                                            <div class="dropdown bootstrap-select show-tick form-control">

                                                                <select   id="txt_searchzone" name="txt_searchzone" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ภาคที่ต้องการค้นหา..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                    <?php
                                                                    // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                                    $sql_seZone = "SELECT DISTINCT [ZONE] FROM ZONEFORSKB
                                                                    ORDER BY [ZONE] ASC";
                                                                    $params_seZone = array();
                                                                    $query_seZone = sqlsrv_query($conn, $sql_seZone, $params_seZone);
                                                                    while ($result_seZone = sqlsrv_fetch_array($query_seZone, SQLSRV_FETCH_ASSOC)) {
                                                                        ?>
                                                                        <option value="<?= $result_seZone['ZONE'] ?>"><?= $result_seZone['ZONE'] ?></option>
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

                                                    </div>
                                                    
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_zoneforskb();">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>

                                                    </div>




                                                    <div class="col-lg-6" style="text-align: right">
                                                        <label>&nbsp;</label><br>
                                                        <a href="#" onclick="excel_zoneforskb();" class="btn btn-default">พิมพ์ข้อมูลภาคสายงานคูโบต้า <li class="fa fa-print"></li></a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                    ตารางแสดงข้อมูลภาคสายงานคูโบต้า
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                  <tr>
                                                                    <th>ลำดับ</th>
                                                                    <th>จังหวัด</th>
                                                                    <th>ภาค</th>
                                                                    <th>แก้ไข</th>
                                                                  </tr>
                                                                </thead>
                                                                <tbody>
                                                                  <?php
                                                                  $i = 1;
                                                                  $sql_seZoneData = "SELECT ZONESKB_ID,PROVINCE,[ZONE] FROM ZONEFORSKB ORDER BY PROVINCE";
                                                                  $params_seZoneData = array();
                                                                  $query_seZoneData = sqlsrv_query($conn, $sql_seZoneData, $params_seZoneData);
                                                                  while ($result_seZoneData = sqlsrv_fetch_array($query_seZoneData, SQLSRV_FETCH_ASSOC)) {
                                                                      ?>

                                                                      <tr>
                                                                        <td><?= $i ?></td>
                                                                        <td><?= $result_seZoneData['PROVINCE']?></td>
                                                                        <td><?= $result_seZoneData['ZONE']?></td>
                                                                        <td> <button type="button" class="btn btn-primary" name="myBtn" id ="myBtn" data-toggle="modal" data-target="#myModalshowzoneskb"   onclick="checking_zoneskb('<?=$result_seZoneData['ZONESKB_ID']?>');">แก้ไขข้อมูล</button></td>
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
                                                            function edit_zoneskb(value,id,modifyby){

                                                                // alert("editzoneskb");
                                                               
                                                                var id = id;
                                                                var zone = value;
                                                                var modifyby = modifyby;

                                                                // alert(id);
                                                                // alert(zone);
                                                                // alert(modifyby);

                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data2.php',
                                                                    data: {

                                                                        txt_flg: "update_zoneforskb",
                                                                        id:id,
                                                                        province: '',
                                                                        zone: zone,
                                                                        createby: '',
                                                                        createdate:'',
                                                                        modifyby:modifyby,
                                                                        modifydate:''
                                                                    },
                                                                    success: function (rs) {

                                                                        // alert(rs);   
                                                                            // document.getElementById('txt_cause').value  = '';
                                                                            // document.getElementById('txt_action').value = '';
                                                                            // document.getElementById('txt_drivername').value = '';
                                                                            // document.getElementById('txt_datedata').value = '';

                                                                        // alert("แก้ไขข้อมูลเรียบร้อย");
                                                                        // window.location.reload();
                                                                    }
                                                                });

                                                                        
                                                            }

                                                            function edit_provinceskb(value,id,modifyby){

                                                                // alert("editzoneskb");

                                                                var id = id;
                                                                var province = value;
                                                                var modifyby = modifyby;

                                                                // alert(id);
                                                                // alert(zone);
                                                                // alert(modifyby);

                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data2.php',
                                                                    data: {

                                                                        txt_flg: "update_provinceforskb",
                                                                        id:id,
                                                                        province: province,
                                                                        zone: '',
                                                                        createby: '',
                                                                        createdate:'',
                                                                        modifyby:modifyby,
                                                                        modifydate:''
                                                                    },
                                                                    success: function (rs) {

                                                                        // alert(rs);   
                                                                            // document.getElementById('txt_cause').value  = '';
                                                                            // document.getElementById('txt_action').value = '';
                                                                            // document.getElementById('txt_drivername').value = '';
                                                                            // document.getElementById('txt_datedata').value = '';

                                                                        // alert("แก้ไขข้อมูลเรียบร้อย");
                                                                        // window.location.reload();
                                                                    }
                                                                });

                                                                        
                                                                }

                                                            function insert_zoneskb(){
                                                                // alert('บันทึกข้อมูลเรียบร้อย insert');
                                                                
                                                                var province = document.getElementById('txt_insertprovince').value;
                                                                var zone = document.getElementById('txt_insertzone').value;
                                                                var createby = document.getElementById('txt_createby').value;
                                                                


                                                                if (province == '') {
                                                                    alert("กรุณาระบุข้อมูลจังหวัด !!!");
                                                                }else if(zone == ''){
                                                                    alert("กรุณาระบุข้อมูลภาค !!!");
                                                                }else{
                                                                    alert("OK INSERT");
                                                                    $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data2.php',
                                                                    data: {

                                                                        txt_flg: "save_zoneforskb",
                                                                        id:'',
                                                                        province: province,
                                                                        zone: zone,
                                                                        createby: createby,
                                                                        createdate:'',
                                                                        modifyby:'',
                                                                        modifydate:''
                                                                    },
                                                                    success: function (rs) {

                                                                        // alert(rs);   
                                                                            // document.getElementById('txt_cause').value  = '';
                                                                            // document.getElementById('txt_action').value = '';
                                                                            // document.getElementById('txt_drivername').value = '';
                                                                            // document.getElementById('txt_datedata').value = '';

                                                                        alert("บันทึกข้อมูลเรียบร้อย");
                                                                        window.location.reload();
                                                                    }
                                                                });
                                                                }

                                                            }

                                                            function reload(){
                                                                alert('บันทึกข้อมูลเรียบร้อย');
                                                                window.location.reload();
                                                            }

                                                            function checking_zoneskb(zoneid){

                                                                // alert(zoneid);
                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data2.php',
                                                                    data: {
                                                                        txt_flg: "checking_zoneskb", zoneid: zoneid
                                                                },
                                                                success: function (response) {
                                                                    if (response){

                                                                        document.getElementById("datazonesr").innerHTML = response;
                                                                        document.getElementById("datazonedef").innerHTML = "";

                                                                        $(document).ready(function () {
                                                                            $('#dataTables-example3').DataTable({
                                                                                responsive: true
                                                                            });


                                                                        });

                                                                    }

                                                                    }
                                                                });

                                                            }
                                                            function select_zoneforskb()
                                                            {


                                                                var zone = document.getElementById('txt_searchzone').value;

                                                                // alert(datestart);
                                                                // alert(dateend);
                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data2.php',
                                                                    data: {
                                                                        txt_flg: "select_zoneforskb", zone: zone
                                                                    },
                                                                    success: function (response) {
                                                                        if (response)
                                                                        {
                                                                            document.getElementById("datasr").innerHTML = response;
                                                                            document.getElementById("datadef").innerHTML = "";
                                                                        }
                                                                        $(document).ready(function () {
                                                                            $('#dataTables-example').DataTable({
                                                                                responsive: true,
                                                                            });
                                                                        });



                                                                    }
                                                                });
                                                                //}

                                                            }
                                                            function excel_zoneforskb()
                                                            {
                                                            var chk = 'excel';
                                                            window.open('excel_zoneforskb.php?report=' + chk , '_blank');

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
                                                                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                                });
                                                            });
                                                            $(document).ready(function () {
                                                                $('#dataTables-example').DataTable({
                                                                    responsive: true,
                                                                });
                                                            });

                                                            $(document).ready(function () {
                                                                $('#dataTables-example3').DataTable({
                                                                    responsive: true
                                                                });
                                                            });

            </script>


    </body>

</html>

<?php
sqlsrv_close($conn);
?>
