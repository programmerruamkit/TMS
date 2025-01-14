<!DOCTYPE html>
<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");
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
        <!--<link href="../dist/css/sb-admin-2.css" rel="stylesheet">-->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <style>
            .navbar-default {

                border-color: #ffcb0b;
            }

            .popover-content {
                padding: 10px 10px;
                width: 100px;
            }
            .nav>li>a {
                position: relative;
                display: block;
                padding: 14px 30px;

            }


            .styled-select.slate select {
                border: 1px solid #ccc;
                font-size: 16px;
                height: 34px;
                width: 150px;

            }


        </style>

    </head>
    <body>


        <!-- Navigation -->

        <div id="wrapper">

            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

                <div class="navbar-header" >
                    <button type="button"  class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a  class="navbar-brand" href="index.html"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>

                </div>

            </nav>

            <div id="page-wrapper">
                <font style="font-family: monospace">
                <div class="row">
                    <div class="col-lg-12">&nbsp;</div>
                </div>
                <div class="row">
                    <div class="col-lg-1">&nbsp;</div>
                    <div class="col-lg-3">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">
                                <b>รูปแบบการส่งข้อมูล : Webservice</b>
                            </div>
                            <div class="panel-body">



                                <b>URL</b> : 203.150.225.30:8080/pages/meg_inputttastrrrservice.php<br>
                                <b>Method</b> : insPlanttastrrr <br>
                                <b>parameter</b> : dateinput (Varchar(200)) <br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;employeecode (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;vehiclenumber (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;vehicletype (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;jobstart (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;jobend (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;zone (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;documentnumber (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;weightin (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;remark (Varchar(200))<br>

                                <u><b>ตัวอย่าง</b></u><br>
                                <i><font style="color: red;font-size: 12px">require_once("lib/nusoap.php");<br>
                                    $client = new nusoap_client("http://203.150.225.30:8080/pages/meg_inputttastrrrservice.php?wsdl", true);<br>
                                    $params = array(<br>
                                    'dateinput' => "xx/xx/xxxx",<br>
                                    'employeecode' => "xxxxxx",<br>
                                    'vehiclenumber' => "xx-xxxx",<br>
                                    'vehicletype' => "xx",<br>
                                    'jobstart' => "xx",<br>
                                    'jobend' => "xx",<br>
                                    'zone' => "xx",<br>
                                    'documentnumber' => "xx",<br>
                                    'weightin' => "xx",<br>
                                    'remark' => "xx"<br>
                                    );
                                    $data = $client->call("insPlanttastrrr", $params);</font></i>





                            </div>
                            <!-- /.panel-body -->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">
                                <b>รูปแบบการส่งข้อมูล : Post</b>
                            </div>
                            <div class="panel-body">



                                <b>URL</b> : 203.150.225.30:8080/pages/meg_inputttastrrrpost.php <br>
                                <b>Method</b> : POST <br>
                                <b>parameter</b> : dateinput (Varchar(200)) <br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;employeecode (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;vehiclenumber (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;vehicletype (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;jobstart (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;jobend (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;zone (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;documentnumber (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;weightin (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;remark (Varchar(200))<br>

                                <u><b>ตัวอย่าง</b></u><br>
                                <i><font style="color: red;font-size: 12px">

                                    < form action="http://203.150.225.30:8080/pages/meg_inputttastrrrpost.php" method="POST">
                                    DATEINPUT : < input type="text" id="dateinput " name="dateinput" value="">
                                    EMPLOYEECODE : < input type="text" id="employeecode " name="employeecode" value="">
                                    VEHICLENUMBER : < input type="text" id="vehiclenumber" name="vehiclenumber" value="">
                                    VEHICLETYPE : < input type="text" id="vehicletype" name="vehicletype" value="">
                                    JOBSTART : < input type="text" id="jobstart" name="jobstart" value="">
                                    JOBEND : < input type="text" id="jobend" name="jobend" value="">
                                    ZONE : < input type="text" id="zone" name="zone" value="">
                                    DOCUMENTNUMBER : < input type="text" id="documentnumber" name="documentnumber" value="">
                                    WEIGHTIN : < input type="text" id="weightin" name="weightin" value="">
                                    REMARK : < input type="text" id="remark" name="remark" value="">
                                    < input type="submit" value="Submit">
                                    < /form>
                                    </form>
                                    </font>
                                </i>




                            </div>
                            <!-- /.panel-body -->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">
                                <b>รูปแบบการส่งข้อมูล : Get</b>
                            </div>
                            <div class="panel-body">


                                <b>URL</b> : 203.150.225.30:8080/pages/meg_inputttastrrrget.php <br>
                                <b>Method</b> : GET <br>
                                <b>parameter</b> : dateinput (Varchar(200)) <br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;employeecode (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;vehiclenumber (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;vehicletype (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;jobstart (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;jobend (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;zone (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;documentnumber (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;weightin (Varchar(200))<br>
                                &emsp;&emsp;&emsp;&emsp;&emsp;remark (Varchar(200))<br>

                                <u><b>ตัวอย่าง</b></u><br>
                                <i><font style="color: red;font-size: 12px">
                                    < form action="http://203.150.225.30:8080/pages/meg_inputttastrrrget.php" method="GET">
                                    DATEINPUT : < input type="text" id="dateinput " name="dateinput" value="">
                                    EMPLOYEECODE : < input type="text" id="employeecode " name="employeecode" value="">
                                    VEHICLENUMBER : < input type="text" id="vehiclenumber" name="vehiclenumber" value="">
                                    VEHICLETYPE : < input type="text" id="vehicletype" name="vehicletype" value="">
                                    JOBSTART : < input type="text" id="jobstart" name="jobstart" value="">
                                    JOBEND : < input type="text" id="jobend" name="jobend" value="">
                                    ZONE : < input type="text" id="zone" name="zone" value="">
                                    DOCUMENTNUMBER : < input type="text" id="documentnumber" name="documentnumber" value="">
                                    WEIGHTIN : < input type="text" id="weightin" name="weightin" value="">
                                    REMARK : < input type="text" id="remark" name="remark" value="">
                                    < input type="submit" value="Submit">
                                    < /form>
                                    </font></i>




                            </div>
                            <!-- /.panel-body -->
                        </div>
                    </div>
                    <div class="col-lg-1">&nbsp;</div>  



                </div>
                </font>



                </body>


                </html>
                <?php
                sqlsrv_close($conn);
                ?>
