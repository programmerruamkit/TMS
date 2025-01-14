<?php
date_default_timezone_set("Asia/Bangkok");
require_once("class/meg_function.php");
$conn = connect("RTMS");
$sql_seCount = "{call megDriverregister(?)}";
$params_seCount = array(
    array('select_driverregister', SQLSRV_PARAM_IN)
);
$query_seCount = sqlsrv_query($conn, $sql_seCount, $params_seCount);
$result_seCount = sqlsrv_fetch_array($query_seCount, SQLSRV_FETCH_ASSOC);
?>
<html lang="en">

    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>ระบบบันทึกข้อมูลผู้เข้าชมงาน</title>

        <!-- Bootstrap Core CSS -->
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    </head>
    <body  >
        <div class="row">
            <div class="col-lg-12">
                &nbsp;
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-1">&nbsp;</div>
            <div class="col-lg-10">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            
                            <div class="col-lg-12 text-right"><font style="font-size: 16px;font-family:cursive "><span class="glyphicon glyphicon-user"></span> จำนวนผู้เข้าชมงาน <b><?= $result_seCount['CNT'] ?></b> คน</font></div>

                        </div>

                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>ชื่อ :</label> <font style="color: red">*</font>
                                    <input class="form-control" id="txt_fname" name="txt_fname">

                                </div>

                            </div>
                            <div class="col-lg-3">

                                <div class="form-group">
                                    <label>นามสกุล :</label> <font style="color: red">*</font>
                                    <input class="form-control" id="txt_lname" name="txt_lname">

                                </div>

                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>อายุ (ปี) : <font style="color: red">*</font></label>
                                    <input class="form-control" id="txt_age" name="txt_age">

                                </div>
                            </div>
                            <div class="col-lg-3">

                                <div class="form-group">
                                    <label>เพศ :</label> <br>

                                    <label class="radio-inline">
                                        <input type="radio" name="rdo_gender" id="rdo_genderm" value="ชาย" checked="">ชาย
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="rdo_gender" id="rdo_genderf" value="หญิง">หญิง
                                    </label>


                                </div>

                            </div>

                            <!-- /.col-lg-6 (nested) -->

                            <!-- /.col-lg-6 (nested) -->
                        </div>
                        <div class="row">
                            <div class="col-lg-3">

                                <div class="form-group">
                                    <label>ระดับการศึกษา : <font style="color: red">*</font></label>
                                    <select class="form-control" id="cb_education" name="cb_education">
                                        <option value="">เลือก</option>
                                        <option value="ต่ำกว่าปริญญาตรี">ต่ำกว่าปริญญาตรี</option>
                                        <option value="ปริญญาตรี">ปริญญาตรี</option>
                                        <option value="สูงกว่าปริญญาตรี">สูงกว่าปริญญาตรี</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-lg-3">

                                <div class="form-group">
                                    <label>ตำแหน่งงาน : <font style="color: red">*</font></label>
                                    <input class="form-control" id="txt_position" name="txt_position">

                                </div>

                            </div>
                            <div class="col-lg-3">


                                <div class="form-group">
                                    <label>อีเมล : <font style="color: red">*</font></label>
                                    <input class="form-control" id="txt_email" name="txt_email">

                                </div>
                            </div>
                            <div class="col-lg-3">


                                <div class="form-group">
                                    <label>เบอร์โทรศัพท์ : <font style="color: red">*</font></label>
                                    <input class="form-control" id="txt_tel" name="txt_tel">

                                </div>

                            </div>
                            <!-- /.col-lg-6 (nested) -->

                            <!-- /.col-lg-6 (nested) -->
                        </div>
                        <div class="row">

                            <div class="col-lg-3">

                                <div class="form-group">
                                    <label>ชื่อบริษัท : <font style="color: red">*</font></label>
                                    <input class="form-control" id="txt_company" name="txt_company">

                                </div>

                            </div>
                            <div class="col-lg-6">


                                <div class="form-group">
                                    <label>ประเภทธุรกิจ : </label><br>
                                    <label class="radio-inline">
                                        <input type="radio" name="rdo_businesstype" id="rdo_busitypetransport" value="transport" checked="">ขนส่ง
                                    </label>
                                    <!--<label class="radio-inline">
                                        <input type="radio" name="rdo_businesstype" id="rdo_busitypemanufacture" value="manufacture">การผลิต
                                    </label>-->
                                    <label class="radio-inline">
                                        <input type="radio" name="rdo_businesstype" id="rdo_busitypeother" value="other">อื่นๆ ระบุ
                                    </label>
                                    <input class="" id="txt_businesstype" name="txt_businesstype">
                                </div>
                            </div>

                            <!-- /.col-lg-6 (nested) -->

                            <!-- /.col-lg-6 (nested) -->
                        </div>
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>ข้อเสนอแนะ :</label>
                                    <textarea class="form-control" name="txt_remark" id="txt_remark" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="well">
                            <h4>ประวัติการเข้าชมงาน</h4>
                            <p style="font-size: 16px">เคยเข้าชมงานแข่งขัน TDEM Driving Skill Contest มาก่อนหรือไม่.</p>
                            <div class="form-group">

                                <div class="radio">
                                    <label>
                                        <input type="radio" name="rdo_history" id="rdo_historyyes" value="เคย" checked="">เคย ระบุ <input class="" id="txt_history" name="txt_history"> ครั้ง
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="rdo_history" id="rdo_historyno" value="ไม่เคย">ไม่เคย
                                    </label>
                                </div>

                            </div>


                        </div>

                    </div>
                    <div class="panel-footer ">
                        <div class="row">
                            
                            <div class="col-lg-12 text-right"><button type="button" class="btn btn-default" onclick="cancel_driverregister()"><span class="glyphicon glyphicon-remove"> ยกเลิกข้อมูล </span></button>
                                <button type="button" class="btn btn-default" onclick="save_driverregister()"><span class="glyphicon glyphicon-plus"> บันทึกข้อมูล </span></button></div>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <div class="col-lg-1">&nbsp;</div>
            <!-- /.col-lg-12 -->
        </div>



        <script src="../vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>


    </body>
    <script>
                                    function chknull_driverregister()
                                    {
                                        if (document.getElementById("txt_fname").value == "")
                                        {
                                            alert('ชื่อ เป็นค่าว่าง !!!')
                                            document.getElementById('txt_fname').focus();
                                            return false;
                                        } else if (document.getElementById("txt_lname").value == "")
                                        {
                                            alert('นามสกุล เป็นค่าว่าง !!!')
                                            document.getElementById('txt_lname').focus();
                                            return false;
                                        } else if (document.getElementById("txt_age").value == "")
                                        {
                                            alert('อายุ เป็นค่าว่าง !!!')
                                            document.getElementById('txt_age').focus();
                                            return false;
                                        } else if (document.getElementById("cb_education").value == "")
                                        {
                                            alert('ระดับการศึกษา เป็นค่าว่าง !!!')
                                            document.getElementById('cb_education').focus();
                                            return false;
                                        } else if (document.getElementById("txt_position").value == "")
                                        {
                                            alert('ตำแหน่งงาน เป็นค่าว่าง !!!')
                                            document.getElementById('txt_position').focus();
                                            return false;
                                        } else if (document.getElementById("txt_email").value == "")
                                        {
                                            alert('อีเมล เป็นค่าว่าง !!!')
                                            document.getElementById('txt_email').focus();
                                            return false;
                                        } else if (document.getElementById("txt_tel").value == "")
                                        {
                                            alert('เบอร์โทรศัพท์ เป็นค่าว่าง !!!')
                                            document.getElementById('txt_tel').focus();
                                            return false;
                                        } else if (document.getElementById("txt_company").value == "")
                                        {
                                            alert('ชื่อบริษัท เป็นค่าว่าง !!!')
                                            document.getElementById('txt_company').focus();
                                            return false;
                                        } else
                                        {
                                            if (confirm("ยืนยันการทำรายการ ?")) {
                                                alert("ขอบคุณที่เข้าร่วมทำกิจกรรมครับ");
                                                return true;
                                            } else {
                                                return false;
                                            }

                                        }
                                    }
                                    function cancel_driverregister()
                                    {
                                        if (confirm("ยืนยันการลบข้อมูลทั้งหมด ?")) {
                                            document.getElementById("txt_fname").value = "";
                                            document.getElementById("txt_lname").value = "";
                                            document.getElementById("txt_age").value = "";
                                            document.getElementById("cb_education").value = "";
                                            document.getElementById("txt_position").value = "";
                                            document.getElementById("txt_email").value = "";
                                            document.getElementById("txt_tel").value = "";
                                            document.getElementById("txt_company").value = "";
                                            document.getElementById("txt_remark").value = "";
                                            document.getElementById("txt_businesstype").value = "";
                                            document.getElementById("txt_history").value = "";
                                            document.getElementById('rdo_genderm').checked = true;
                                            document.getElementById('rdo_busitypetransport').checked = true;
                                            document.getElementById('rdo_historyyes').checked = true;
                                        }

                                    }
                                    function save_driverregister()
                                    {
                                        var txtfname = document.getElementById("txt_fname").value;
                                        var txtlname = document.getElementById("txt_lname").value;
                                        var txtage = document.getElementById("txt_age").value;
                                        var cbeducation = document.getElementById("cb_education").value;
                                        var txtposition = document.getElementById("txt_position").value;
                                        var txtemail = document.getElementById("txt_email").value;
                                        var txttel = document.getElementById("txt_tel").value;
                                        var txtcompany = document.getElementById("txt_company").value;
                                        var txtremark = document.getElementById("txt_remark").value;
                                        var txtbusinesstype = document.getElementById("txt_businesstype").value;
                                        var txthistory = document.getElementById("txt_history").value;

                                        if (chknull_driverregister())
                                        {
                                            var rdogender = "";
                                            if (document.getElementById('rdo_genderm').checked) {
                                                rdogender = document.getElementById('rdo_genderm').value;
                                            } else
                                            {
                                                rdogender = document.getElementById('rdo_genderf').value;
                                            }
                                            var rdobusitype = "";
                                            if (document.getElementById('rdo_busitypetransport').checked) {
                                                rdobusitype = document.getElementById('rdo_busitypetransport').value;
                                            } else
                                            {
                                                rdobusitype = document.getElementById('rdo_busitypeother').value;
                                            }
                                            var rdohistory = "";
                                            if (document.getElementById('rdo_historyyes').checked) {
                                                rdohistory = document.getElementById('rdo_historyyes').value;
                                            } else
                                            {
                                                rdohistory = document.getElementById('rdo_historyyes').value;
                                            }
                                            $.ajax({
                                                type: 'post',
                                                url: 'meg_data.php',
                                                data: {
                                                    txt_flg: "save_driverregister", condition1: '', driverregister_fname: txtfname,
                                                    driverregister_lname: txtlname, driverregister_age: txtage, driverregister_gender: rdogender,
                                                    driverregister_education: cbeducation,
                                                    driverregister_position: txtposition, driverregister_email: txtemail,
                                                    driverregister_tel: txttel, driverregister_company: txtcompany,
                                                    driverregister_businesstype: rdobusitype, driverregister_businesstypetext: txtbusinesstype,
                                                    driverregister_history: rdohistory, driverregister_historytext: txthistory,
                                                    activestatus: '1', remark: txtremark
                                                },
                                                success: function () {
                                                    
                                                    window.location.href = 'index.php';

                                                }
                                            });


                                        }
                                    }
    </script>

</html>
