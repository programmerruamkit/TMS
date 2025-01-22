<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["PASSWORD"])) {
    header("location:../pages/meg_login.php?data=3");
}
$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
$result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>กลุ่มร่วมกิจรุ่งเรือง</title>

        <!-- Bootstrap Core CSS -->
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <!-- <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet"> -->

        <!-- Custom CSS -->
        <!-- <link href="../dist/css/sb-admin-2.css" rel="stylesheet"> -->

        

        <!-- Custom Fonts -->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    </head>
    <style>


        div a {
            color:black;

        }

        /*body {
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: teal;
        }
        */
        :root {
            font-size: 10px;
        }

        div b {
            padding: 0;
            list-style-type: none;
        }

        div b {
            width: 200px;
            height: 100px;
            /*font-size: 20px; */
            text-align: center;
            line-height: 7rem;
            font-family: sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            transition: 0.3s;
            margin: 1rem;
            color: white;
        }

        div b::before,
        div b::after {
            content: '';
            position: absolute;
            width: inherit;
            height: inherit;
            top: 0;
            left: 0;
            transition: 0.3s;
        }

        div b::before {
            background-color: #000000b3;
            z-index: -1;
            box-shadow: 0.2rem 0.2rem 0.5rem rgba(0, 0, 0, 0.2);
            color: white;
        }

        div b::after {
            background-color: #999;
            transform: translate(1.5rem, 1.5rem);
            z-index: -2;
            color: black;
        }

        div b:hover {
            transform: translate(1.5rem, 1.5rem);
            color: white;
        }

        div b:hover::before {
            /*background-color: #00000087;*/
        }

        div b:hover::after {
            background-color: #999;
            transform: translate(-1.5rem, -1.5rem);
        }



        body {
            /* Location of the image */

            background-image: url(../images/Concept_new_background.png);
            /* background อันเดิมใช้ BCT3 */
            /* background-image: url(../images/BCT3.png); */
            /* Background image is centered vertically and horizontally at all times */
            background-position: center center;

            /* Background image doesn't tile */
            background-repeat: no-repeat;

            /* Background image is fixed in the viewport so that it doesn't move when 
               the content's height is greater than the image's height */
            background-attachment: fixed;

            /* This is what makes the background image rescale based
               on the container's size */
            background-size: cover;

            /* Set a background color that will be displayed
               while the background image is loading */
            background-color: white;
        }
        @media only screen and (max-width: 767px) {
            body {
                /* The file size of this background image is 93% smaller
                   to improve page load speed on mobile internet connections */
                background-image: url(../images/Concept_new_background.png);
                 /* background อันเดิมใช้ BCT3 */
                /* background-image: url(../images/BCT3.png); */
                background-position: center center;
                background-repeat: no-repeat;

                /* Background image is fixed in the viewport so that it doesn't move when 
                   the content's height is greater than the image's height */
                background-attachment: fixed;

                /* This is what makes the background image rescale based
                   on the container's size */
                background-size: cover;

                /* Set a background color that will be displayed
                   while the background image is loading */
                background-color: white;
            }
        }


    </style>

    <body style="background-color: #31708f" >
        
        

        <div class="row">
            <div class="col-lg-2" >
                <a href="index2.php">

                    <b class="fa  fa-truck fa-3x">
                        <br>
                        <font style="font-size: 25px"> ระบบขนส่ง</font>
                    </b>

                </a>
            </div>
            <?php if ($_SESSION["ROLENAME"] == 'ADMINGMT' || $_SESSION["ROLENAME"] == 'Digital Tenko (TDEM)' ) {
             ?>

             <?php
            }else {
            ?>
                <div class="col-lg-2">
                <a href="meg_transportcompensation.php">

                    <b class="fa fa-user fa-3x">
                        <br>
                        <font style="font-size: 25px">ค่าตอบแทน</font>
                    </b>
                </a>
            </div>
            <?php
            }
            ?>
            
        <!-- ///////////////////////////////////////////////////////////////////// -->
            <div class="col-lg-2">
                <?php
                if (($_SESSION["ROLENAME"] == 'ADMIN') || ($_SESSION["ROLENAME"] == 'EHR') || ($_SESSION["ROLENAME"] == 'MANAGER(AMT)')) {
                ?>
                    <a href="meg_cashadvanceofficer.php">
                        <b class="fa fa-credit-card fa-3x">
                            <br>
                            <font style="font-size: 25px">เบิกเงินล่วงหน้า</font>
                        </b>
                    </a>
                <?php
                }else if ($_SESSION["ROLENAME"] == 'DRIVER' || $_SESSION["ROLENAME"] == 'MAINTENANCE(AMT)' || $_SESSION["ROLENAME"] == 'MAINTENANCE(GW)'
                || $_SESSION["ROLENAME"] == 'TENKO(AMT)' || $_SESSION["ROLENAME"] == 'TENKO(GW)'|| $_SESSION["ROLENAME"] == 'PLANNING(AMT)'
				|| $_SESSION["ROLENAME"] == 'BILLING(GW)'){
                ?>  
                    <a href="meg_cashadvancedriver.php">
                        <b class="fa fa-money fa-3x">
                            <br>
                            <font style="font-size: 25px">เบิกเงินล่วงหน้า</font>
                        </b>
                    </a>
                <?php
                }else {
                ?>

                <?php
                }
                ?>
            </div>
        <!-- ///////////////////////////////////////////////////////////////////// -->
            <?php if (($_SESSION["ROLENAME"] == 'ADMIN') || ($_SESSION["ROLENAME"] == 'PLANNING(GW)') || ($_SESSION["ROLENAME"] == 'DRIVER')) { ?>
				<div class="col-lg-2">
                    <a href="meg_newtransportplangw.php">
                        <b class="fa fa-bus fa-3x">
                            <br>
                            <font style="font-size: 21px">เพิ่มแผนงาน(ปกติ)</font>
                        </b>
                    </a>
                </div>
			<?php } ?>
        <!-- ////////////////////////////////////////////////////////////////////////////// -->
            <?php
           if ($_SESSION["ROLENAME"] == 'DRIVER') {
            ?>
                <div class="col-lg-2">
                    <a href="meg_selfcheck.php">
                        <b class="fa fa-list-alt fa-3x">
                            <br>
                            <font style="font-size: 25px">แจ้งสุขภาพตนเอง</font>
                        </b>
                    </a>
                </div>
                <div class="col-lg-2">
                    <a href="meg_planningdata.php">

                        <b class="fa fa-pencil-square-o fa-3x">
                            <br>
                            <font style="font-size: 25px">ข้อมูลแผนงาน</font>
                        </b>
                    </a>
                </div>
				<?php
                if ($_SESSION["USERNAME"] == '100007' || $_SESSION["USERNAME"] == '100006') {
                ?>
                    <div class="col-lg-2" style="">
						<a href="meg_drivingpattern_driver.php">

							<b class="fa fa-3x">
								<font style="font-size: 20px">DRIVINGPATTERN<br>แผนวิ่งงาน</br></font>
							</b>
						</a>
					</div>
					<div class="col-lg-2" >
						<a href="meg_drivingpattern_driverselect.php">
							<b class="fa fa-3x">
								<font style="font-size: 20px">DRIVINGPATTERN<br>วิ่งงานจริง</br></font>
							</b>
						</a>
					</div>
                <?php
                }else {
                ?>

                <?php
                }
                ?>
				
					
				
				
            <?php
           }else {
            ?>

            <?php
           }
           ?> 
            
              
        <!-- ///////////////////////////////////////////////////////////////////// -->
            <div class="col-lg-2">
                <?php if (($_SESSION["ROLENAME"] == 'ADMIN')||($_SESSION["ROLENAME"] == 'TENKO(GW)')||($_SESSION["ROLENAME"] == 'PLANNING(GW)')) { ?>
                    <a href="meg_cashoilaverage.php">
                        <b class="fa fa-credit-card fa-3x">
                            <br>
                            <font style="font-size: 20px">เบิกเงินค่าเฉลี่ยน้ำมัน</font>
                        </b>
                    </a>
                <?php } ?>
            </div>


         <!-- ////////////////////////////////////////////////////////////////////        -->
           
         <?php if ($_SESSION["ROLENAME"] == 'ADMINGMT' || $_SESSION["ROLENAME"] == 'Digital Tenko (TDEM)') {
             ?>

             <?php
            }else {
            ?>
            <!-- <div class="col-lg-2">
                <a href="meg_driverchecking.php">

                    <b class="fa fa-list-alt fa-3x">
                        <br>
                        <font style="font-size: 25px">ตรวจสอบงาน</font>
                    </b>
                </a>
            </div> -->
            <?php
            }
            ?>
        
            <!--<div class="col-lg-2">
                <a href="report_covid19.php">

                    <b class="fa fa-connectdevelop fa-3x">
                        <br>
                        <font style="font-size: 25px">ตรวจ COVID 19</font>
                    </b>
                </a>
            </div>
            -->
            <!--<div class="col-lg-2">
               <a href="meg_dashboardamt.php">

                   <b class="fa fa-calendar fa-3x">
                       <br>
                       <font style="font-size: 25px">แผนงาน(AMT)</font>
                   </b>
               </a>
           </div>
            <div class="col-lg-2">
               <a href="meg_dashboardgw.php">

                   <b class="fa fa-calendar fa-3x">
                       <br>
                       <font style="font-size: 25px">แผนงาน(GW)</font>
                   </b>
               </a>
           </div>
            -->
            <!--<div class="col-lg-2">
                <a href="meg_employee4.php">

                    <b class="fa fa-clock-o fa-3x">
                        <br>
                        <font style="font-size: 25px">ลงเวลาเข้าออก</font>
                    </b>
                </a>
            </div>
            <div class="col-lg-6">
                &nbsp;
            </div>
            -->



        </div>


        <div class="row">
            <div class="col-lg-12 text-center">&nbsp;</div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">&nbsp;</div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">&nbsp;</div>
        </div>

        <script src="../vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <!-- <script src="../vendor/metisMenu/metisMenu.min.js"></script> -->

        <!-- Morris Charts JavaScript -->
     

        <!-- Custom Theme JavaScript -->
        <!-- <script src="../dist/js/sb-admin-2.js"></script> -->

        <script type="text/javascript">
            //$(window).on('load', function () {
           //     $('#myModal').modal('show');
           // });
        </script>

    </body>

</html>
