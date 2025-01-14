<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


// $sql_empcode = "SELECT TOP 1 PersonCode AS 'EMPCODE' FROM [203.150.225.30].[TigerE-HR].dbo.PNT_Person
// WHERE (FnameT+' '+LnameT) = RTRIM('" . $_GET['employeename'] . "') AND EndDate IS NULL";
// $params_empcode = array();
// $query_empcode = sqlsrv_query($conn, $sql_empcode, $params_empcode);
// $result_empcode = sqlsrv_fetch_array($query_empcode, SQLSRV_FETCH_ASSOC);


// $sql_sedata = "SELECT SELFCHECKID,EMPLOYEECODE,EMPLOYEENAME,TIMEWORKING,TIMEWORKINGSTATUS,
// TIMEWORKINGDATANG1,TIMEWORKINGDATANG2,TIMEWORKINGDATANG3,TIMEWORKINGDATANG4,TIMEWORKINGDATANG5,TIMEWORKINGDATANG6
// FROM DRIVERSELFCHECK	
// WHERE SELFCHECKID ='".$_GET['selfcheckid']."'";
// $params_sedata = array();
// $query_sedata = sqlsrv_query($conn, $sql_sedata, $params_sedata);
// $result_sedata = sqlsrv_fetch_array($query_sedata, SQLSRV_FETCH_ASSOC);


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
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.min.js"></script>
        <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../dist/js/jquery.autocomplete.js"></script> 
        <style>
            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {
                border-left: 1px solid #ffcb0b;
            }
            .textarea {
            background-color: #dddddd;
            color: #666666;
            padding: 1em;
            border-radius: 10px;
            border: 2px solid transparent;
            outline: none;
            font-family: "Heebo", sans-serif;
            font-weight: 500;
            font-size: 16px;
            line-height: 1.4;
            width: 685px;
            height: 120px;
            transition: all 0.2s;
            }

            .textarea:hover {
            cursor: pointer;
            background-color: #eeeeee;
            }

            .textarea:focus {
            cursor: text;
            color: #333333;
            background-color: white;
            border-color: #333333;
            }

        </style>
    </head>
    <body>

        <!-- <div id="wrapper"> -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href=""><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
            </div>
            
            </nav>


            <!-- <div id="page-wrapper"> -->
                <p>&nbsp;</p>
                <input type="hidden" name= "txt_user" id="txt_user" value="<?=$_SESSION["USERNAME"] ?>"></input> 
                <!-- <div id="datade_edit"> -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                
                                
                                
                                
                                <!-- <div id="datadef_edit"> -->
                                    <div class="panel-body" style="text-align: center;">
                                        <!-- START ROW1 -->
                                        <div class="row" >
                                            <div class="panel-heading" style="background-color: #f8f8f8;">
                                                <label><font style="font-size: 18px">ลงข้อมูลพนักงานในตาราง Organization</font></label>
                                            </div>
                                            <div class="panel-body">
                                                <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                    <div class = "row">
                                                        <div class="scol-lg-4" >
                                                            <form class="form-inline">
                                                                <div class="form-group" >
                                                                    <label >EMPLOYEECODE: </label>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="scol-lg-4">
                                                            <form class="form-inline">
                                                                <div class="form-group">
                                                                    <input type="text"  class="form-control" id="txt_organization_employeecode" name = "txt_organization_employeecode" value="" size="80" autocomplete="off">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class = "row">
                                                        <div class="scol-lg-4">
                                                            <form class="form-inline">
                                                                <div class="form-group">
                                                                    <label >AREA: </label>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="scol-lg-4">
                                                            <form class="form-inline">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" id="txt_organization_area" name = "txt_organization_area" value="" size="80" autocomplete="off">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class = "row">
                                                        <label ></label>
                                                    </div>
                                                    <div class = "row">
                                                        <div class="scol-lg-4">
                                                            <form class="form-inline">
                                                                <div class="form-group">
                                                                    <label >COMPANYCODE: </label>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="scol-lg-4">
                                                            <form class="form-inline">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" id="txt_organization_companycode" name = "txt_organization_companycode" value="" size="80" autocomplete="off">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class = "row">
                                                        <label ></label>
                                                    </div>
                                                    <div class = "row">
                                                        <div class="scol-lg-4">
                                                            <form class="form-inline">
                                                                <div class="form-group">
                                                                    <label >DEPARTMENTCODE: </label>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="scol-lg-4">
                                                            <form class="form-inline">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" id="txt_organization_departmentcode" name = "txt_organization_departmentcode" value="" size="80" autocomplete="off">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class = "row">
                                                        <label ></label>
                                                    </div>
                                                    <div class = "row">
                                                        <div class="scol-lg-4">
                                                            <form class="form-inline">
                                                                <div class="form-group" >
                                                                    <label >SECTIONCODE: </label>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="scol-lg-4">
                                                            <form class="form-inline">
                                                                <div class="form-group" >
                                                                    <input type="text" class="form-control" id="txt_organization_sectioncode" name = "txt_organization_sectioncode" value="" size="80" autocomplete="off">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <!-- END COLUNM3 -->
                                         

                                        

                                        <!-- <div class="row">
                                            <div class="col-lg-12">
                                                <input type="button"  data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการแก้ไขข้อมูล!!!" onclick ="confirm_edit();" name="btnSend" id="btnSend" value="แก้ไขข้อมูลสุขภาพ" class="btn btn-primary">
                                            </div>
                                            
                                        </div> -->

                                        <!-- /.row (nested) -->
                                    </div>

                                <!-- </div> -->
                                <!-- <div id="datasr_edit"></div> -->
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>




                <!-- </div> -->
               
                <div class = "row">
                    <div class="col-lg-12">
                            <div class="form-group" style="text-align: center;">
                                <input type="button" style="width: 80%;height:80px;font-size: 25px;" onclick="insert_organization();" name="btnSend" id="btnSend" value="บันทึกข้อมูล" class="btn btn-success">
                            </div>
                    </div>
                </div>  
                



            <!-- </div> -->

        <!-- </div> -->

        


    
        <script type="text/javascript">

                                                                
            function insert_organization()
            {
                
                var employeecode    = document.getElementById('txt_organization_employeecode').value;
                var area            = document.getElementById('txt_organization_area').value;
                var companycode     = document.getElementById('txt_organization_companycode').value;
                var departmentcode  = document.getElementById('txt_organization_departmentcode').value;
                var sectioncode     = document.getElementById('txt_organization_sectioncode').value;
                var createby        = document.getElementById('txt_user').value;
                // alert(selfcheckid);
                // alert(employeecode);
                // alert(employeename);
                // alert(data);
              


                $.ajax({
                    type: 'post',
                    url: 'meg_data2.php',
                    data: {
                        txt_flg: "insert_organization", employeecode: employeecode,area: area,companycode:companycode,departmentcode:departmentcode,sectioncode:sectioncode,createby:createby

                    },
                    success: function (response) {

                        alert("บันทึกข้อมูลเรียบร้อย");
                        window.location.reload();

                    }
                });

            }
                   
                
            

        </script>






    </body>

</html>
<?php
sqlsrv_close($conn);
?>