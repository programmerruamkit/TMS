<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

// $db = connect("RTMS");

$output = '';

// Check if form was submitted
if(isset($_POST['submit'])) {

	// Configure upload directory and allowed file types
	$upload_dir = '../images/employee/'.DIRECTORY_SEPARATOR;
	$allowed_types = array('jpg');
	$i = 0;
	// Define maxsize for files i.e 2MB
	$maxsize = 1 * 1024 * 1024;
    // echo "<br>";
	// Checks if user sent an empty form
	if(!empty(array_filter($_FILES['files']['name']))) {

		// Loop through each file in files[] array
		foreach ($_FILES['files']['tmp_name'] as $key => $value) {
			
            $i++;
			$file_tmpname = $_FILES['files']['tmp_name'][$key];
			$file_name = $_FILES['files']['name'][$key];
			$file_size = $_FILES['files']['size'][$key];
			$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

			// Set upload file path
			$filepath = $upload_dir.$file_name;

            

			// Check file type is allowed or not
			if(in_array(strtolower($file_ext), $allowed_types)) {

				// Verify file size - 2MB max
				if ($file_size < $maxsize){
                    
                    // echo "OK";
                    // If file with name already exist then append time in
                    // front of name of the file to avoid overwriting of file
                    if(file_exists($filepath)) {
                        // $i--;
                        // $output = "ไม่สามารถเพิ่มรูปได้เนื่องจาก {$file_name} มีในระบบแล้ว <br />";
                        // ถ้ารูปซ้ำ เพิ่มรูปและ Track เวลา
                        // $filepath = $upload_dir.time().$file_name;
                        $filepath = $upload_dir.$file_name;
                        if( move_uploaded_file($file_tmpname, $filepath)) {

                            // echo "<script>
                            //          alert('เพิ่มรูปเรียบร้อย {$file_name}');
                            //       </script>";

                        	// echo "เพิ่มรูปเรียบร้อย {$file_name} <br />";
                            $output = "เพิ่มรูปเรียบร้อยจำนวน: {$i} ไฟล์ <br />";
                            // echo "111";
                        }
                        else {					

                        	// echo "Error uploading {$file_name} <br />";
                            // echo "<script>
                            //         alert('ไม่สามารถเพิ่มรูปได้ {$file_name}');
                            //       </script>";


                            $output = "ไม่สามารถเพิ่มรูปได้ 11{$file_name} <br />";
                        }
                    }else {
                    
                        if( move_uploaded_file($file_tmpname, $filepath)) {

                            // echo "<script>
                            //          alert('เพิ่มรูปเรียบร้อย {$file_name}');
                            //       </script>";
                            // echo "เพิ่มรูปเรียบร้อย {$file_name} <br />";

                            $output = "เพิ่มรูปเรียบร้อยจำนวน: {$i} ไฟล์ <br />";
                            // echo "222";
                        } else {					
                            // echo "Error uploading {$file_name} <br />";
                            // echo "<script>
                            //         alert('ไม่สามารถเพิ่มรูปได้ {$file_name}');
                            //       </script>";
                            // echo "ไม่สามารถเพิ่มรูปได้ {$file_name} <br />";
                            
                            $output = "ไม่สามารถเพิ่มรูปได้ {$file_name}55 <br />";

                        }
                    }

                }else {
                         // echo "Error: File size is larger than the allowed limit.";
                        
                        // echo "<script>
                        //         alert('ไม่สามารถเพิ่มรูปได้เนื่องจากไฟล์มีขนาดใหญ่เกินไป (ไฟล์ต้องขนาดไม่เกิน 1MB)');
                        //       </script>";

                        $output = "ไม่สามารถเพิ่มรูปได้เนื่องจากไฟล์มีขนาดใหญ่เกินไป (ไฟล์ต้องขนาดไม่เกิน 1MB)";

                }
			} else {
				
                        // If file extension not valid
                        // echo "<script>
                        //                 // alert('ไม่สามารถเพิ่มรูปได้เนื่องจาก {$file_name} รูปแบบไม่ถูกต้อง ต้องเป็น .jpg เท่านั้น');
                        //                 // alert('รูปแบบไฟล์ต้องเป็น .jpg เท่านั้น');
                        //                 alert('ไม่สามารถเพิ่มรูปได้เนื่องจาก {$file_name} รูปแบบไม่ถูกต้อง \\nรูปแบบไฟล์ต้องเป็น .jpg เท่านั้น');

                        //       </script>";
                        
                        // echo "Error uploading {$file_name} ";
                        // echo "({$file_ext} file type is not allowed)<br / >";

                        $output = "ไม่สามารถเพิ่มรูปได้เนื่องจาก {$file_name} รูปแบบไม่ถูกต้อง <b>รูปแบบไฟล์ต้องเป็น .jpg เท่านั้น</b> ";

			}
        // for each
		}
	}
	else {
		
            // If no files selected
            // echo "No files selected.";
            // echo "<script>
            //             alert('ยังไม่ได้เลือกไฟล์ กรุณาเลือกไฟล์!!!');
            //     </script>";

            $output = "ยังไม่ได้เลือกไฟล์ กรุณาเลือกไฟล์!!!";
	}
}


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
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">


        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        
        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.min.js"></script>
        <link href="style/style.css" rel="stylesheet" type="text/css">

        <!-- Zoom CSS -->
        <link rel="stylesheet" type="text/css" href="css/zoom.css">

        <style>

            .navbar-default {

            border-color: #ffcb0b;
            }
            #page-wrapper {
            border-left: 1px solid #ffcb0b;
            }
            /* .container {
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
            } */

            /* Hide the browser's default checkbox */
            /* .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
            } */

            /* .button {
            display: inline-block;
            padding: 15px 25px;
            font-size: 24px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
            } */

            /* .button:hover {background-color: #3e8e41}

            .button:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(10px);
            } */

        </style>
    </head>

    <body >
        <div class="modal fade" id="modal_selecttenko" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-modal-parent="#modal_copydiagram">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">

                    <div id="select_selecttenko"></div>
                </div>
            </div>
        </div>



        
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">

            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../pages/index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <font style="color:#337ab7 "><?= $result_seEmployee['nameT'] ?></font>
                </li>
                <li class="dropdown">
                    <?php
                    if ($_SESSION["ROLENAME"] != "") {
                        ?>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <?= $_SESSION["ROLENAME"] ?>
                        </a>
                        <?php
                    } else {
                        ?>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            เลือกสิทธิ์เข้าใช้งาน <i class="fa fa-caret-down"></i>
                        </a>
                        <?php
                    }
                    ?>
                    <ul class="dropdown-menu dropdown-user">
                        <?php
                        $query_sePremissions3 = sqlsrv_query($conn, $sql_sePremissions, $params_sePremissions);
                        while ($result_sePremissions3 = sqlsrv_fetch_array($query_sePremissions3, SQLSRV_FETCH_ASSOC)) {
                            ?>
                            <li><a href="" onclick="create_premissions('<?= $result_sePremissions3['ROLEID'] ?>');"><i class="fa fa-user fa-fw"></i> <?= $result_sePremissions3['ROLENAME'] ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>

                <li>
                    <font style="color:#337ab7 "><?= $result_sePremissions["NAME"] ?></font>
                </li>
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
        </nav>


                        


        <div class="row">

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #e7e7e7">
                        <div class="row">

                            <div class="col-lg-6">

                                <?php
                                $meg = 'อัพโหลดข้อมูลรูปภาพพนักงาน';


                                echo "<a href='index2.php?type=report'>หน้าหลัก</a>  / " . $meg;
                                $link = "<a href='index.php?type=report'>หน้าหลัก</a> ";
                                $_SESSION["link"] = $link;
                                ?>
                            </div>
                           

                            <div class="col-lg-6 text-right">
                                <?= $result_seCompany['Company_NameT'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-md-2" >&nbsp;</div>
                        </div>
                        <div id="datadef">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    อัพโหลดข้อมูลรูปภาพพนักงาน <font color="red" style="font-size: 25px;">* กรุณาตรวจสอบข้อมูลก่อนอัพโหลดข้อมูลใหม่</font>
                                                </div>



                                            </div>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <!-- Nav tabs -->
                                            <!-- <ul class="nav nav-pills">
                                                <li class="active"><a href="#accident" data-toggle="tab" aria-expanded="true">ลงข้อมูลอุบัติเหตุ</a>
                                                </li>
                                                <li><a href="#simulator" data-toggle="tab">ลงข้อมูล SIMULATOR</a>
                                                </li>
                                            </ul> -->
                                            <div class="tab-content">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <p><font color="red"><h4><b><u>เงื่อนไขในการเพิ่มรูปพนักงาน</u></b></h4></b></font></p>
                                                        <p><font color="red">1.ขนาดไฟล์ต้องไม่เกิน<b> 1 MB</b> หรือ <b>1024 KB</b> </font></p>
                                                        <p><font color="red">2.รูปต้องมีขนาด  <b>"700X900(แนวตั้ง)"</b> เท่านั้น</font></p>
                                                        <p><font color="red">3.นามสกุลไฟล์ ที่อนุญาต <b>".jpg"</b> เท่านั้น</font></p>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12" >
                                                        <!-- <form  action="file_upload.php"  method="POST" enctype="multipart/form-data"> -->
                                                        <form  method="POST" enctype="multipart/form-data">
                                                            <div class="col-md-3">
                                                                <input type="file" name="files[]" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" multiple>
                                                                <!-- <button type="submit" name="import" class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">เพิ่ม</button> -->
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                <button style="height: 35px;width: 100px" type="submit" name="submit" value="Upload" class="btn btn-info" type="button" id="inputGroupFileAddon04">เพิ่มข้อมูล</button> 
                                                            </div>
                                                            
                                                        </form>
                                                        
                                                    </div>
                                                    <div>
                                                        <br>
                                                        <br>
                                                        <h2><?=$output?></h2>
                                                    </div>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12" >&nbsp;</div>
                                                </div>
                                                <div class="tab-pane fade active in" id="accident">
                                                    <div class="row">
                                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                                <div id="datadef">
                                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                        <thead>
                                                                            <tr>    
                                                                                <th>รหัสพนักงาน</th>
                                                                                <th>ชื่อ-นามสกุล</th>
                                                                                <th>เบอร์โทรศัพท์</th>
                                                                                <th>รูปภาพ</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php
                                                                            $i = 1;

                                                                            // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
                                                                            // $condiReporttransport2 = "";
                                                                            // $condiReporttransport3 = "";

                                                                            $condition2 = "";
                                                                            $condition3 = "";

                                                                            $sql_seEmp = "{call megEmployeeEHR_v2(?,?)}";
                                                                            $params_seEmp = array(
                                                                                array('select_employeeehr2', SQLSRV_PARAM_IN),
                                                                                array('', SQLSRV_PARAM_IN)
                                                                            );


                                                                            $query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
                                                                            while ($result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC)) {

                                                                                
                                                                                ?>

                                                                                <tr class="odd gradeX">
                                                                                    <td><?= $result_seEmp['PersonCode'] ?></td>
                                                                                    <td><?= $result_seEmp['nameT'] ?></td>
                                                                                    <td><?= $result_seEmp['CardTel'] ?></td>
                                                                                    <td><img  style="padding:4px;text-align:center;height: 90px;width: 90px;" src="../images/employee/<?=$result_seEmp['PersonCode']?>.jpg" data-action="zoom" alt="Pic_Driver1" ></td>
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
                                                        
                                                    </div>
                                                </div>
                                                    <br>
                                                    
                                             
                                            </div>
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel -->
                                </div>

                            </div>
                        </div>
                        <div id="datasr"></div>
                        <!-- /.panel -->
                    </div>
                </div>
            </div>




        <!--<script src="../vendor/jquery/jquery.min.js"></script>-->
            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../js/jquery.datetimepicker.full.js"></script>

            <script src="../dist/js/jszip.min.js"></script>
            <script src="../dist/js/dataTables.buttons.min.js"></script>
            <!-- <script src="../dist/js/buttons.html5.min.js"></script>
            <script src="../dist/js/buttons.print.min.js"></script> -->
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>   

            <!-- Zoom Js -->
            <script src="js/zoom.js"></script>
    </body>
    



                                                                                            


            <script type="text/javascript"> 
                                 
             
            

            // $(function () {
            //     $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            //     // กรณีใช้แบบ input
            //     $(".dateen").datetimepicker({
            //         timepicker: true,
            //         dateformat: 'Y-m-d' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
            //         lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            //         timeFormat: "HH:mm"

            //     }
            //     );
            // });

            // $(function () {
            //     $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            //     // กรณีใช้แบบ input
            //     $(".dateensimu").datetimepicker({
            //         timepicker: false,
            //         format: 'Y-m-d', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
            //         lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


            //     });
            // });


            </script>
            <script>
                $(document).ready(function () {
                    $('#dataTables-example1').DataTable({
                        responsive: true
                    });
                   
                });
            </script>

    

</html>
<?php
sqlsrv_close($conn);
?>
