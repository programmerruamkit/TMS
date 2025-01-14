
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
                        <h1>จัดการข้อมูล ORGANIZATION</h1>
                    </div>
                    <!-- <div class="col-md-12" style="background-color: #e7e7e7">
                        <h1><?=$result_seName['NAME']?></h1>
                    </div> -->
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="well">
                            <div class="row" style="text-align: center;font-size: 30px">
                                <b><p style="color:red">**กรุณาเปิดอ่านรายละเอียดการลงข้อมูล ก่อนทำการลงข้อมูล</p></b>

                            </div>
                    </div>
                </div>
            </div>
                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="text-align: right">
                            <button type="button" style= "height:40px;width:200px" class="custom-btn btn-11 btn btn-danger btn-md" name="myBtn" id ="myBtn" onclick="opencondition()">อ่านรายละเอียดการลงข้อมูล</button>
                           
                         
                        </div>
                        <div class="col-md-6" style="text-align: left">
                            <button type="button" style= "height:40px;width:150px" class="btn btn-primary btn-md" name="myBtn" id ="myBtn" onclick="insert_data('<?=$empcheck?>','<?=$result_seYears['YEARS']?>','<?=$result_seYears['YEARS']?>')">เพิ่มข้อมูลพนักงาน</button>
                           
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
                                        <div class="col-sm-6"><a href='report_organization.php'>จัดการข้อมูล</a> / รายละเอียดข้อมูล Organization</div>
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
                                                                    <th>NO</th>
                                                                    <th>ORG_ID</th>
                                                                    <th>EMPLOYEECODE</th>
                                                                    <th>EMPLOYEENAME</th>
                                                                    <th>AREA</th>
                                                                    <th>CONPANYCODE</th>
                                                                    <th>DEPARTMENTCODE</th>
                                                                    <th>SECTIONCODE</th>
                                                                    <th>EDIT</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            $i = 1;

                                                            // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
                                                            // $condiReporttransport2 = "";
                                                            // $condiReporttransport3 = "";

                                                            $sql_seOrganizationData = "SELECT ORGANIZATIONID,EMPLOYEECODE,b.nameT AS 'NAME',AREA,a.COMPANYCODE,DEPARTMENTCODE,SECTIONCODE
                                                            FROM ORGANIZATION  a
                                                            LEFT JOIN EMPLOYEEEHR2 b ON b.PersonCode = a.EMPLOYEECODE
                                                            ORDER BY EMPLOYEECODE,COMPANYCODE,DEPARTMENTCODE,SECTIONCODE";
                                                            $params_seOrganizationData = array();
                                                            $query_seOrganizationData = sqlsrv_query($conn, $sql_seOrganizationData, $params_seOrganizationData);
                                                            while ($result_seOrganizationData = sqlsrv_fetch_array($query_seOrganizationData, SQLSRV_FETCH_ASSOC)) {
                                                                
                                                                // $sql_seName = "SELECT nameT AS 'NAME' FROM EMPLOYEEEHR2 WHERE PersonCode ='".$result_seOrganizationData['EMPLOYEECODE']."'";
                                                                // $params_seName = array();
                                                                // $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                                                // $result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC);

                                                                // $sql_seDriverAge = "SELECT BirthDate103,[yearb],monthb,dayb FROM EMPLOYEEEHR2
                                                                // WHERE PersonCode ='".$_GET['employeecode']."'";
                                                                // $params_seDriverAge = array();
                                                                // $query_seDriverAge  = sqlsrv_query($conn, $sql_seDriverAge , $params_seDriverAge);
                                                                // $result_seDriverAge  = sqlsrv_fetch_array($query_seDriverAge , SQLSRV_FETCH_ASSOC);

                                                                
                                                                ?>

<tr>
                                                                    
                                                                    <?php
                                                                    if ($result_seOrganizationData['NAME'] == '') {
                                                                     ?> 
                                                                        <td style="text-align: center;background-color: #F98A7F"><?= $i ?></td>
                                                                        <td style="text-align: center;background-color: #F98A7F"><?= $result_seOrganizationData['ORGANIZATIONID'] ?></td>
                                                                        <td style="background-color: #F98A7F"><?= $result_seOrganizationData['EMPLOYEECODE'] ?></td>
                                                                        <td style="background-color: #F98A7F"><?= $result_seOrganizationData['NAME'] ?></td>
                                                                        <td style="background-color: #F98A7F"><input class="form-control " placeholder="รายละเอียด"    title="รายละเอียด"  onchange="edit_organization(this.value, 'AREA', '<?=$result_seOrganizationData['ORGANIZATIONID']?>')"            style="height:40px; width:200px" id="txt_dayaccident" name="txt_dayaccident" value="<?= $result_seOrganizationData['AREA'] ?>"              min="" max=""  autocomplete="off"></td>
                                                                        <td style="background-color: #F98A7F"><input class="form-control " placeholder="รายละเอียด"    title="รายละเอียด"  onchange="edit_organization(this.value, 'COMPANYCODE', '<?=$result_seOrganizationData['ORGANIZATIONID']?>')"     style="height:40px; width:200px" id="txt_dayaccident" name="txt_dayaccident" value="<?= $result_seOrganizationData['COMPANYCODE'] ?>"       min="" max=""  autocomplete="off"></td>
                                                                        <td style="background-color: #F98A7F"><input class="form-control"  placeholder="รายละเอียด"    title="รายละเอียด"  onchange="edit_organization(this.value, 'DEPARTMENTCODE', '<?=$result_seOrganizationData['ORGANIZATIONID']?>')"  style="height:40px; width:250px" id="txt_dayaccident" name="txt_dayaccident" value="<?= $result_seOrganizationData['DEPARTMENTCODE'] ?>"    min="" max=""  autocomplete="off"></td>
                                                                        <td style="background-color: #F98A7F"><input class="form-control"  placeholder="รายละเอียด"    title="รายละเอียด"  onchange="edit_organization(this.value, 'SECTIONCODE', '<?=$result_seOrganizationData['ORGANIZATIONID']?>')"     style="height:40px; width:250px" id="txt_dayaccident" name="txt_dayaccident" value="<?= $result_seOrganizationData['SECTIONCODE'] ?>"       min="" max=""  autocomplete="off"></td>
                                                                        <td style="text-align: center;background-color: #F98A7F"><input type="button"   data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!" onclick ="confirm_delete('<?=$result_seOrganizationData['ORGANIZATIONID']?>');"       name="btnSend" id="btnSend" value="ลบข้อมูล" class="btn btn-danger"></td>
                                                                     <?php
                                                                    }else{
                                                                     ?>
                                                                        <td style="text-align: center;"><?= $i ?></td>
                                                                        <td style="text-align: center;"><?= $result_seOrganizationData['ORGANIZATIONID'] ?></td>
                                                                        <td style=""><?= $result_seOrganizationData['EMPLOYEECODE'] ?></td>
                                                                        <td style=""><?= $result_seOrganizationData['NAME'] ?></td>
                                                                        <td style=""><input class="form-control " placeholder="รายละเอียด"    title="รายละเอียด"  onchange="edit_organization(this.value, 'AREA', '<?=$result_seOrganizationData['ORGANIZATIONID']?>')"            style="height:40px; width:200px" id="txt_dayaccident" name="txt_dayaccident" value="<?= $result_seOrganizationData['AREA'] ?>"              min="" max=""  autocomplete="off"></td>
                                                                        <td style=""><input class="form-control " placeholder="รายละเอียด"    title="รายละเอียด"  onchange="edit_organization(this.value, 'COMPANYCODE', '<?=$result_seOrganizationData['ORGANIZATIONID']?>')"     style="height:40px; width:200px" id="txt_dayaccident" name="txt_dayaccident" value="<?= $result_seOrganizationData['COMPANYCODE'] ?>"       min="" max=""  autocomplete="off"></td>
                                                                        <td style=""><input class="form-control"  placeholder="รายละเอียด"    title="รายละเอียด"  onchange="edit_organization(this.value, 'DEPARTMENTCODE', '<?=$result_seOrganizationData['ORGANIZATIONID']?>')"  style="height:40px; width:250px" id="txt_dayaccident" name="txt_dayaccident" value="<?= $result_seOrganizationData['DEPARTMENTCODE'] ?>"    min="" max=""  autocomplete="off"></td>
                                                                        <td style=""><input class="form-control"  placeholder="รายละเอียด"    title="รายละเอียด"  onchange="edit_organization(this.value, 'SECTIONCODE', '<?=$result_seOrganizationData['ORGANIZATIONID']?>')"     style="height:40px; width:250px" id="txt_dayaccident" name="txt_dayaccident" value="<?= $result_seOrganizationData['SECTIONCODE'] ?>"       min="" max=""  autocomplete="off"></td>
                                                                        <td style="text-align: center;"><input type="button"   data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!" onclick ="confirm_delete('<?=$result_seOrganizationData['ORGANIZATIONID']?>');"       name="btnSend" id="btnSend" value="ลบข้อมูล" class="btn btn-danger"></td>    
                                                                     <?php
                                                                    }
                                                                    ?>
                                                                   
                                                                    
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

                                        function opencondition() {
                                            // alert(employeename);
                                            // alert(createyear);
                                            window.open('report_showcondition_organization.php?condition="read"', '_blank', 
                                            "toolbar=yes,scrollbars=yes,resizable=yes,top=25,left=400,width=700,height=700");

                                            // window.open('report_digitaltenkoshowhealthhistory.php?employeename=' + employeename + '&createyear='+createyear, '_blank', 
                                            // "toolbar=yes,scrollbars=yes,resizable=yes,top=25,left=400,width=700,height=700");
                                        }
                                        function insert_data() {
                                            // alert(employeename);
                                            // alert(createyear);
                                            window.open('report_insertorganizationdata.php?condition="read"', '_blank', 
                                            "toolbar=yes,scrollbars=yes,resizable=yes,top=25,left=250,width=1000,height=700");

                                            // window.open('report_digitaltenkoshowhealthhistory.php?employeename=' + employeename + '&createyear='+createyear, '_blank', 
                                            // "toolbar=yes,scrollbars=yes,resizable=yes,top=25,left=400,width=700,height=700");
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
                                                
                                                delete_organization(id);   
                                                }else{

                                                    window.location.reload();      
                                                }

                                            
                                            }); 

                                        } 
                                        function edit_organization(value, fieldname, organizationid) {

                                            var modifiedby = document.getElementById('txt_user').value;

                                            // alert(value);
                                            // alert(fieldname);
                                            // alert(organizationid);
                                            // alert(IDPLAN);
                                            // alert(IDDRIVER);
                                            //  alert(modifiedby);

                                            $.ajax({
                                                url: 'meg_data2.php',
                                                type: 'POST',
                                                data: {
                                                    txt_flg: "update_organization", value: value, fieldname: fieldname, organizationid: organizationid,modifiedby: modifiedby
                                                },
                                                success: function (rs) {
                                                    alert("แก้ไขข้อมูลเรียบร้อย !!");
                                                    window.location.reload();
                                                }
                                            });


                                        }
                                        function delete_organization(id){
                                            
                                            // alert('delete');
                                            // alert(id);

                                            $.ajax({
                                                    type: 'post',
                                                    url: 'meg_data2.php',
                                                    data: {

                                                    txt_flg: "delete_organization",
                                                    value:'', 
                                                    fieldname: '',
                                                    id: id, 
                                                    modifyby: ''


                                                    },
                                                    success: function (response) {
                                                        if (response) {

                                                            alert("ลบข้อมูลเรียบร้อย");
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
