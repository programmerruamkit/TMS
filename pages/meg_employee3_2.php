<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
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
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!--<link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">-->
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">



        <link rel="stylesheet" href="../fullcalendar_th/js/fullcalendar-2.1.1/fullcalendar.min.css">
        <style type="text/css">
            html,body{
                maring:0;
                padding:0;
                font-family:tahoma, "Microsoft Sans Serif", sans-serif, Verdana;   
                font-size:14px;
            }
            #calendar{
                max-width: 60%;
                margin: 0 auto;
                font-size:14px;
            }        
        </style>
    </head>


    <script src="../vendor/jquery/jquery.min.js"></script>   
    <script type="text/javascript" src="../fullcalendar_th/js/fullcalendar-2.1.1/lib/moment.min.js"></script>
    <script type="text/javascript" src="../fullcalendar_th/js/fullcalendar-2.1.1/fullcalendar.min.js"></script>
    <script type="text/javascript" src="../fullcalendar_th/js/fullcalendar-2.1.1/lang/th.js"></script>
    <script type="text/javascript" src="../fullcalendar_th/script.js"></script>
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
            <form  name="searchform" id="searchform" method="post">
                <div class="row" >
                    <div class="col-lg-12">

                        <h2 class="page-header"><i class="glyphicon glyphicon-user"></i>  
                            ปฎิทินปฏิบัติงาน

                        </h2>
                    </div>


                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">

                                <div class="row">
                                    <div class = "col-lg-2">
                                        &nbsp;
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel-heading -->

                            <div class="panel-body">

                                <div id='calendar'></div>

                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>


    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script src="../js/jquery.datetimepicker.full.js"></script>
    <script src="../dist/js/jszip.min.js"></script>
    <script src="../dist/js/dataTables.buttons.min.js"></script>
    <script src="../dist/js/buttons.html5.min.js"></script>
    <script src="../dist/js/buttons.print.min.js"></script>
    <script src="../dist/js/jquery.autocomplete.js"></script>
</body>


</body>



</html>
<?php
sqlsrv_close($conn);
?>