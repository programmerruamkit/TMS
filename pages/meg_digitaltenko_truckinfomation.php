
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
    
    <div id="modalHomeEvents" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="height:50px;">
          <label>Digital Tenko (Truck Information)</label> 
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
                
            <!-- <input type="text" name="eventId" id="eventId"/> -->
            <!-- <input type="text" name="idHolder1" id="idHolder1"/> -->
        	<!-- <span id="idHolder"></span>	 -->
            <div id='item1'>
            <label>ทะเบียนรถ :</label> 
            <span id="idHolder"></span>
            </div>
        </div> 
       
        <div class="col-lg-6" id="sandbox-container">
        <br>
                <div>
                    <label>เลือกค้นหาข้อมูลการซ่อมบำรุง</label>
                </div><br>
                    <label>วันที่เริ่มต้น</label>
                <div class="input-group date">
                    <input type="text" class="form-control datestart" readonly=""  style="background-color: #f080802e" id="txt_startdate" name="txt_startdate" placeholder="วันที่เริ่มต้น" value =""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
            </div>
            <div class="col-lg-6" id="sandbox-container">
                <br><br><br>
                <label>วันที่สิ้นสุด</label>
                <div class="input-group date">
                    <input type="text" class="form-control dateend" readonly=""  style="background-color: #f080802e" id="txt_enddate" name="txt_enddate" placeholder="วันที่สิ้นสุด" value =""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
            </div>
            
            <div class="modal-footer">
                <br><br><br><br><br><br><br><br>
                <button style="text-align: center;width: 100px;height: 40px;"  onclick="print_truckinfomation();" type="button" class="btn btn-success"><span class="glyphicon glyphicon-print"></span></button>
            </div>
      </div>

    </div>
  </div>
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
                        <h1>TRUCK INFORMATION</h1>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>


                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">

                                    <div class="row">
                                        <div class="col-sm-6"><a href='index2.php'>หน้าแรก</a> / ข้อมูลรถสายงาน STM-SR</div>
                                        <!-- <div class="col-sm-6 text-right"><a target="_bank" href='meg_vehiclrinfoamata.php?vehicleinfoid=&meg=add'>เพิ่มข้อมูลรถ</a></div> --> 
                                    </div>
                                    



                                </div>
                                <!-- /.panel-heading -->

                                <div class="panel-body">

                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                        <div class="row">


                                            <div class="col-sm-12">
                                                <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example" style="width: 100%;">
                                                    <thead>
                                                        <tr>

                                                            <th><label style="width: 100px;text-align: center">ลำดับ</label></th>
                                                            <th><label style="width: 100px;text-align: center">ลักษณะรถ</th>
                                                            <th><label style="width: 100px">ประเภทรถ</label></th>
                                                            <th><label style="width: 100px">เลขทะเบียนรถ</label></th>
                                                            <th><label style="width: 100px">หน่วยงาน</label></th>
                                                            <th><label style="width: 100px">ยี่ห้อรถ</label></th>
                                                            <th><label style="width: 100px">ประเภทเกียร์รถ</label></th>
                                                            <th><label style="width: 100px">สีรถ</label></th>
                                                            <th><label style="width: 100px">ชื่อรถ (ไทย)</label></th>
                                                            <th><label style="width: 100px">ชื่อรถ (อังกฤษ)</label></th>
                                                            <th><label style="width: 100px">สถานะ</label></th>
                                                            <th><label style="width: 100px">หมายเหตุ</label></th>
                                                            <th><label style="width: 100px">พิมพ์ข้อมูลรถ</label></th>
                                                            <th><label style="width: 100px">แก้ไข</label></th>
                                                            <th><label style="width: 100px">ลบ</label></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        $i = 1;
                                                        $sql_infolist = "SELECT a.VEHICLEINFOID, a.VEHICLEREGISNUMBER, a.VEHICLEGROUPCODE,b.VEHICLEGROUPDESC, a.VEHICLETYPECODE,c.VEHICLETYPEDESC,a.VEHICLETYPEIMAGE, 
                                                        a.BRANDCODE,d.BRANDDESC, a.GEARTYPECODE,e.GEARTYPEDESC, a.COLORCODE,f.COLORDESC, a.SERIES, a.THAINAME, a.ENGNAME, a.HORSEPOWER, a.CC, a.MACHINENUMBER, 
                                                        a.CHASSISNUMBER, a.ENERGY, a.[WEIGHT], a.MAXIMUMLOAD,
                                                        a.VEHICLEBUYWHERE,a.ACTIVESTATUS, a.REMARK, 
                                                        a.CREATEBY, a.CREATEDATE, a.MODIFIEDBY, a.MODIFIEDDATE
                                                        FROM dbo.VEHICLEINFO a
                                                        LEFT JOIN dbo.VEHICLEGROUP b ON a.VEHICLEGROUPCODE = b.VEHICLEGROUPCODE
                                                        LEFT JOIN dbo.VEHICLETYPE c ON a.VEHICLETYPECODE = c.VEHICLETYPECODE
                                                        LEFT JOIN dbo.VEHICLEBRAND d ON a.BRANDCODE = d.BRANDCODE
                                                        LEFT JOIN dbo.VEHICLEGEARTYPE e ON a.GEARTYPECODE = e.GEARTYPECODE
                                                        LEFT JOIN dbo.VEHICLECOLOR f ON a.COLORCODE = f.COLORCODE
                                                        WHERE a.ACTIVESTATUS !=''
                                                        -- AND a.REMARK ='RKS(STM-SR)'
                                                        --AND VEHICLEREGISNUMBER IN('65-2898','64-2376','64-2377','65-2897','65-3386','65-3406','65-3142')
                                                        ORDER BY a.VEHICLEREGISNUMBER ASC";
                                                            
                                                        $params_infolist = array();
                                                        $query_infolist = sqlsrv_query($conn, $sql_infolist, $params_infolist);
                                                        while ($result_infolist = sqlsrv_fetch_array($query_infolist, SQLSRV_FETCH_ASSOC)) {
                                                            
                                                            if ($result_infolist['VEHICLETYPEDESC'] == 'รถบรรทุก 10 ล้อ(ตู้กันวิงเหล็ก)') {
                                                                $VEHICLETYPE1  = substr("รถบรรทุก 10 ล้อ(ตู้กันวิงเหล็ก)",0,37);
                                                                $VEHICLETYPE2  = substr("รถบรรทุก 10 ล้อ(ตู้กันวิงเหล็ก)",37,44);
                                                            }else{

                                                            }

                                                            
                                                            ?>
                                                            <tr>

                                                                <td style="width: 100px;text-align: center"><?= $i ?></td>
                                                                <td style="width: 100px;text-align: center"><img width="66%" src="../images/DigitalTenko_Truck/truckTMT.png"></td>
                                                                <td><?= $VEHICLETYPE1 ?><br><?=$VEHICLETYPE2?></td>
                                                                <td><?= $result_infolist['VEHICLEREGISNUMBER'] ?></td>
                                                                <td><?= $result_infolist['VEHICLEGROUPDESC'] ?></td>
                                                                <td><?= $result_infolist['BRANDDESC'] ?></td>
                                                                <td><?= $result_infolist['GEARTYPEDESC'] ?></td>
                                                                <td><?= $result_infolist['COLORDESC'] ?></td>
                                                                <td><?= $result_infolist['THAINAME'] ?></td>
                                                                <td><?= $result_infolist['ENGNAME'] ?></td>
                                                        
                                                                <td><?php echo ($result_infolist['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                <td><?= $result_infolist['REMARK'] ?></td>
                                                                <td style="width: 100px;text-align: center"><button style="text-align: center;width: 100px;height: 40px;" class="open-homeEvents btn btn-primary" data-id="<?=$result_infolist['VEHICLEREGISNUMBER']?>"  data-toggle="modal" data-target="#modalHomeEvents"><span class="glyphicon glyphicon-print"></span></button>	</button></td>
                                                   
                                                                <td style="text-align: center">
                                                                    <a href='meg_digitaltenko_vehicledetail.php?vehicleinfoid=<?= $result_infolist['VEHICLEINFOID'] ?>&meg=edit' target="_bank" class='list-group-item'><span class="glyphicon glyphicon-wrench"></span></a>
                                                                </td>
                                                                <td style="text-align: center">
                                                                    <button style="text-align: center" onclick="delete_vehicleinfo(<?= $result_infolist['VEHICLEINFOID'] ?>);" title="ลบข้อมูล" type="button" class="list-group-item"><span class="glyphicon glyphicon-remove"></span></button>
                                                                </td>
                                                                



                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>

                                                    </tbody>


                                                </table>


                                            </div>

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

                                    $('.datestart').datepicker({
                                        format: "dd/mm/yyyy",
                                        language: "th"
                                        
                                    });                   

                                    $('.dateend').datepicker({
                                        format: "dd/mm/yyyy",
                                        language: "th"
                                        
                                    });  

                                    $(document).on("click", ".open-homeEvents", function () {
                                        var eventId = $(this).data('id');
                                        $('#idHolder').html( eventId );
                                        
                                    });

                                        $(document).ready(function () {
                                            $('#dataTables-example').DataTable({
                                                order: [[0, "asc"]],
                                                scrollX: true,
                                                scrollY: '500px',
                                            });
                                        });

                                        function delete_vehicleinfo(vehicleinfoid)
                                        {
                                            var confirmation = confirm("ต้องการลบข้อมูล ?");

                                            if (confirmation) {
                                                $.ajax({
                                                    type: 'post',
                                                    url: 'meg_data.php',
                                                    data: {
                                                        txt_flg: "delete_vehicleinfo", vehicleinfoid: vehicleinfoid
                                                    },
                                                    success: function () {
                                                        alert('ลบข้อมูลเรียบร้อยแล้ว');
                                                        window.location.reload();
                                                    }
                                                });
                                            }
                                        }

                                        function print_truckinfomation()
                                        {
                                            var vehicleregisnumber = $('#item1 span').text();
                                            var startdate = document.getElementById('txt_startdate').value;
                                            var enddate   = document.getElementById('txt_enddate').value;
                                            
                                            // alert($('#item1 span').text());
                                        //    var vehicleregisnumber = document.getElementById("idHolder").value;    
                                            // alert(vehicleregisnumber);
                                            // alert(startdate);
                                            // alert(enddate);
                                            window.open('pdf_digitaltenko_truckinfomation.php?vehicleregisnumber='+vehicleregisnumber+ '&startdate=' + startdate+ '&enddate=' + enddate, '_blank');
                                            
                                            
                                        }
    </script>
</html>
<?php
sqlsrv_close($conn);
?>
