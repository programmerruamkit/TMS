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


$sql_sedata = "SELECT SELFCHECKID,EMPLOYEECODE,EMPLOYEENAME,TIMEWORKING,TIMEWORKINGSTATUS,
TIMEWORKINGDATANG1,TIMEWORKINGDATANG2,TIMEWORKINGDATANG3,TIMEWORKINGDATANG4,TIMEWORKINGDATANG5,TIMEWORKINGDATANG6
FROM DRIVERSELFCHECK	
WHERE SELFCHECKID ='".$_GET['selfcheckid']."'";
$params_sedata = array();
$query_sedata = sqlsrv_query($conn, $sql_sedata, $params_sedata);
$result_sedata = sqlsrv_fetch_array($query_sedata, SQLSRV_FETCH_ASSOC);


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

                <div id="datade_edit">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <div class="row">
                                        <div class="col-lg-11" >
                                            <h4>เลขที่การแจ้งสุขภาพตนเอง: <b><?=$_GET['selfcheckid']?></b></h4> 
                                            <h4>ชื่อพนักงาน: <b><?=$_GET['employeename']?></b></h4> 
                                        </div>
                                        <!-- <input type="button"   data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!" onclick ="confirm_delete();" name="btnSend" id="btnSend" value="ลบข้อมูลสุขภาพ" class="btn btn-danger"> -->
                                    </div>
                                </div>
                                <input  class="form-control" type="hidden" id="txt_selfcheckid" name="txt_selfcheckid" value="<?=$_GET['selfcheckid']?>">
                                <input  class="form-control" type="hidden" id="txt_empcode" name="txt_empcode" value="<?=$_GET['employeecode']?>">
                                <input  class="form-control" type="hidden" id="txt_empname" name="txt_empname" value="<?=$_GET['employeename']?>">
                                <div id="datadef_edit">
                                    <div class="panel-body" style="text-align: center;">
                                        <!-- START ROW1 -->
                                        <div class="row" >
                                            <div class="panel-heading" style="background-color: #f8f8f8;">
                                                <label><font style="font-size: 16px">ลงข้อมูลรายละเอียดสาเหตุการวิ่งงานเกิน 14 ชั่วโมง</font></label>
                                            </div>
                                            <div class="panel-body">
                                                <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                    <div class = "row">
                                                        <div class="scol-lg-4">
                                                            <form class="form-inline">
                                                                <div class="form-group">
                                                                    <label >(1)</label>
                                                                    <input type="text" class="form-control" id="txt_cause_workinggrater14data1" name = "txt_cause_workinggrater14data1" value="<?=$result_sedata['TIMEWORKINGDATANG1']?>" size="80" autocomplete="off">
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
                                                                    <label >(2)</label>
                                                                    <input type="text" class="form-control" id="txt_cause_workinggrater14data2" name = "txt_cause_workinggrater14data2" value="<?=$result_sedata['TIMEWORKINGDATANG2']?>" size="80" autocomplete="off">
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
                                                                    <label >(3)</label>
                                                                    <input type="text" class="form-control" id="txt_cause_workinggrater14data3" name = "txt_cause_workinggrater14data3" value="<?=$result_sedata['TIMEWORKINGDATANG3']?>" size="80" autocomplete="off">
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
                                                                    <label >(4)</label>
                                                                    <input type="text" class="form-control" id="txt_cause_workinggrater14data4" name = "txt_cause_workinggrater14data4" value="<?=$result_sedata['TIMEWORKINGDATANG4']?>" size="80" autocomplete="off">
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
                                                                    <label >(5)</label>
                                                                    <input type="text" class="form-control" id="txt_cause_workinggrater14data5" name = "txt_cause_workinggrater14data5" value="<?=$result_sedata['TIMEWORKINGDATANG5']?>" size="80" autocomplete="off">
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
                                                                    <label >(6)</label>
                                                                    <input type="text" class="form-control" id="txt_cause_workinggrater14data6" name = "txt_cause_workinggrater14data6" value="<?=$result_sedata['TIMEWORKINGDATANG6']?>" size="80" autocomplete="off">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class = "row">
                                                        <label ></label>
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

                                </div>
                                <div id="datasr_edit"></div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>




                </div>
                <div id="datasr_edit">

                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        &nbsp;

                    </div>
                </div>
                <div class = "row">
                    <div class="col-lg-12">
                            <div class="form-group" style="text-align: center;">
                                <input type="button" style="width: 80%;height:80px;font-size: 25px;" onclick="insert_timeworkingdatang();" name="btnSend" id="btnSend" value="บันทึกข้อมูล" class="btn btn-success">
                            </div>
                    </div>
                </div>  
                



            <!-- </div> -->

        <!-- </div> -->

        


    
        <script type="text/javascript">

                                                                
            function insert_timeworkingdatang()
            {
                
                var selfcheckid = document.getElementById('txt_selfcheckid').value;
                var employeecode = document.getElementById('txt_empcode').value;
                var employeename = document.getElementById('txt_empname').value;
                var data1 = document.getElementById('txt_cause_workinggrater14data1').value;
                var data2 = document.getElementById('txt_cause_workinggrater14data2').value;
                var data3 = document.getElementById('txt_cause_workinggrater14data3').value;
                var data4 = document.getElementById('txt_cause_workinggrater14data4').value;
                var data5 = document.getElementById('txt_cause_workinggrater14data5').value;
                var data6 = document.getElementById('txt_cause_workinggrater14data6').value;
                // alert(selfcheckid);
                // alert(employeecode);
                // alert(employeename);
                // alert(data);

                $.ajax({
                    type: 'post',
                    url: 'meg_data2.php',
                    data: {
                        txt_flg: "insert_timeworkingdatang", selfcheckid: selfcheckid,employeecode: employeecode,employeename:employeename,data1:data1,data2:data2,data3:data3,data4:data4,data5:data5,data6:data6

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