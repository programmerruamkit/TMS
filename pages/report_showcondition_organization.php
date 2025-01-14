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


// $sql_sedata = "SELECT  TOP 1 ID,DIABETES,HIGHTBLOODPRESSURE,LOWBLOODPRESSURE,
//     HEARTDISEASE, EPILEPPSY, BRAINSURGERY, SHORTSIGHT,SHORTSIGHT_R,SHORTSIGHT_L,LONGSIGHT,LONGSIGHT_R,LONGSIGHT_L,
//     OBLIQUESIGHT,OBLIQUESIGHT_R,OBLIQUESIGHT_L,COLORBLIND_OK,COLORBLIND_NG,OTHERDISEASE1,OTHERDISEASE2,OTHERDISEASE3,
//     OTHERDISEASE4,OTHERDISEASE5,OTHERDISEASE6,CREATEDATE
//     FROM [dbo].[HEALTHHISTORY]
//     WHERE EMPLOYEECODE ='" . $result_empcode['EMPCODE'] . "'
//     AND CREATEYEAR ='" . $_GET['createyear'] . "'
//     AND ACTIVESTATUS ='1'
//     ORDER BY CREATEDATE DESC";
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
            .container {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            }

            /* Hide the browser's default checkbox */
            .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
            }

            /* Create a custom checkbox */
            .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #8e8e8e;
            }

            /* On mouse-over, add a grey background color */
            .container:hover input ~ .checkmark {
            background-color: #ccc;
            }

            /* When the checkbox is checked, add a blue background */
            .container input:checked ~ .checkmark {
            background-color: #05ad16;
            }

            /* Create the checkmark/indicator (hidden when not checked) */
            .checkmark:after {
            content: "";
            position: absolute;
            display: none;
            }

            /* Show the checkmark when checked */
            .container input:checked ~ .checkmark:after {
            display: block;
            }

            /* Style the checkmark/indicator */
            .container .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
            }

            table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            }

            td, th {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
            }

            tr:nth-child(even) {
            background-color: #dddddd;
            }
        </style>
    </head>
    <body>

        <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header" >
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
        </div>
        </nav>


            <div id="page-wrapper">
                <p>&nbsp;</p>

                <div id="datade_edit">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <div class="row">
                                        <div class="col-lg-11" >
                                            <h4><b>รายละเอียดการลงข้อมูล Organization</b></h4> 
                                        </div>
                                        <!-- <input type="button"   data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!" onclick ="confirm_delete();" name="btnSend" id="btnSend" value="ลบข้อมูลสุขภาพ" class="btn btn-danger"> -->
                                    </div>
                                </div>
                                
                                <div id="datadef_edit">
                                    <div class="panel-body">
                                        <!-- START ROW1 -->
                                        <div class="row" >
                                            <div class="col-lg-4" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f8f8f8;">
                                                        <label><font style="font-size: 16px">เงื่อนไขการลงข้อมูล</font></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;font-size: 18px">
                                                            <div class = "row">
                                                                <div class="col-lg-12">
                                                                    1.ช่อง EMPLOYEECODE ให้ใส่ข้อมูลรหัสพนักงาน 6 หลัก 
                                                                    <br> เช่น 021233,092302,100023
                                                                </div><br>
                                                                <div class="col-lg-12">
                                                                    2.ช่อง AREA ถ้าเป็นพื้นที่ อมตะให้ใส่ "amata" ถ้าเป็นพื้นที่เกตเวย์ให้ใส่ "gateway"
                                                                </div><br>
                                                                <div class="col-lg-12">
                                                                    3. ช่อง COMPANYCODE ใส่ข้อมูลตัวเลข 2 หลักแรกของรหัสพนักงาน
                                                                    <br> เช่น 100006 ให้ใส่ "10" ,060235 ให้ใส่ "06"
                                                                </div><br>
                                                                <div class="col-lg-12">
                                                                    4. DEPARTMENTCODE มีข้อมูลที่ต้องใส่ดังนี้  ให้ใส่รหัสตาม Department<br><br>
                                                                    <table>
                                                                        <tr>
                                                                            <th>DEPARTMENTNAME</th>
                                                                            <th>DEPARTMENTCODE</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: left;">Administration</td>
                                                                            <td>01</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: left;">Accounting/Finance</td>
                                                                            <td>02</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: left;">Transportation</td>
                                                                            <td>03</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: left;">Affiliate Business</td>
                                                                            <td>04</td>
                                                                        </tr>
                                                                        </table>    
                                                                </div><br>
                                                                <div class="col-lg-12">
                                                                     5. SECTIONCODE มีข้อมูลที่ต้องใส่ดังนี้   ให้ใส่รหัสตาม Section ที่พนักงานสังกัดอยู่<br><br>
                                                                    <table>
                                                                        <tr>
                                                                            <th>SECTIONNAME</th>
                                                                            <th>SECTIONCODE</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: left;">Accounting</td>
                                                                            <td>01</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: left;">Corporate Strategy</td>
                                                                            <td>01</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: left;">Customer Relation Managemet</td>
                                                                            <td>01</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: left;">Ruamkit Rungrueng Truck Details</td>
                                                                            <td>01</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: left;">Administration</td>
                                                                            <td>02</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: left;">Finance</td>
                                                                            <td>02</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: left;">Operation</td>
                                                                            <td>02</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: left;">Ruamkit Information Technology</td>
                                                                            <td>02</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: left;">Ruamkit Rungrueng Traning Center</td>
                                                                            <td>03</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: left;">Safety & Quality</td>
                                                                            <td>03</td>
                                                                        </tr>
                                                                        </table>    
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <!-- END COLUNM1 -->
                                    
                                            
                                         

                                        

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
                  
                



            </div>

        </div>

        


    
        <script type="text/javascript">

                                                                
            
                   
                
            

        </script>






    </body>

</html>
<?php
sqlsrv_close($conn);
?>