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
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/morrisjs/morris.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <style>
            .disabledTab{
                pointer-events: none;
            }
            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {

                border-left: 1px solid #ffcb0b;
            }
        </style>
    </head>
    <?php
    $selected = "";
    $str_active = ($_GET['type'] != "") ? $_GET['type'] : "employee";

    //แก้ไขพนักงาน
    if ($_GET['employeeid'] != "") {
        $sql_seEmp = "{call megEmployee_v2(?,?)}";
        $params_seEmp = array(
            array('se', SQLSRV_PARAM_IN),
            array($_GET['employeeid'], SQLSRV_PARAM_IN)
        );
        $query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
        $result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC);
    }
    //แก้ไขบริษัท
    if ($_GET['employeecompanyid'] != "") {
        $sql_seComp = "{call megEmployeecompany_v2(?,?,?)}";
        $params_seComp = array(
            array('se', SQLSRV_PARAM_IN),
            array($_GET['employeeid'], SQLSRV_PARAM_IN),
            array($_GET['employeecompanyid'], SQLSRV_PARAM_IN)
        );
        $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
        $result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);
    }
    if ($_GET['employeecardid'] != "") {
        $sql_seCard = "{call megEmployeecard_v2(?,?,?)}";
        $params_seCard = array(
            array('se', SQLSRV_PARAM_IN),
            array($_GET['employeeid'], SQLSRV_PARAM_IN),
            array($_GET['employeecardid'], SQLSRV_PARAM_IN)
        );
        $query_seCard = sqlsrv_query($conn, $sql_seCard, $params_seCard);
        $result_seCard = sqlsrv_fetch_array($query_seCard, SQLSRV_FETCH_ASSOC);
    }
    if ($_GET['employeetrainingid'] != "") {
        $sql_seTraining = "{call megTraining_v2(?,?,?)}";
        $params_seTraining = array(
            array('se', SQLSRV_PARAM_IN),
            array($_GET['employeeid'], SQLSRV_PARAM_IN),
            array($_GET['employeetrainingid'], SQLSRV_PARAM_IN)
        );
        $query_seTraining = sqlsrv_query($conn, $sql_seTraining, $params_seTraining);
        $result_seTraining = sqlsrv_fetch_array($query_seTraining, SQLSRV_FETCH_ASSOC);
    }
    if ($_GET['employeeaddressid'] != "") {
        $sql_seAddress = "{call megAddress_v2(?,?,?)}";
        $params_seAddress = array(
            array('se', SQLSRV_PARAM_IN),
            array($_GET['employeeid'], SQLSRV_PARAM_IN),
            array($_GET['employeeaddressid'], SQLSRV_PARAM_IN)
        );
        $query_seAddress = sqlsrv_query($conn, $sql_seAddress, $params_seAddress);
        $result_seAddress = sqlsrv_fetch_array($query_seAddress, SQLSRV_FETCH_ASSOC);
    }
    ?>
    <body>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php
                include '../pages/meg_header.php';
                include '../pages/meg_leftmenu.php';
                ?>
            </nav>

            <form action="" id="insEmployee" name="insEmployee" method="POST" accept-charset="utf-8" enctype="multipart/form-data" >
                <div id="page-wrapper">
                    <div class="row" >
                        <div class="col-lg-12">

                            <h2 class="page-header"><i class="glyphicon glyphicon-user"></i>  
                                <?= ($_GET['employeeid'] != '') ? $result_seEmp['NAME'] : "ข้อมูลพนักงาน " ?>
                            </h2>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <?php
                                    $meg = ($_GET['meg'] == 'add') ? 'เพิ่มข้อมูล' : 'แก้ไขข้อมูล';
                                    echo $_SESSION["link"] . " / " . $meg;
                                    ?>
                                </div>
                                <div class="panel-body" style="background-color: #f8f8f8">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>รูปพนักงาน</label>

                                                <p style="text-align: center" class="help-block">อัพโหลดไฟล์ภาพ ไม่เกิน 200X230 พิกเซล</p>
                                                <div style="width: 214px;height: 280px;border: 1px solid #cccccc;border-radius: 3px; margin: auto;">

                                                    <input class="form-control" id="txt_employeeid" type="hidden" name="txt_employeeid" value="<?= $_GET['employeeid'] ?>">
                                                    <input class="form-control" id="txt_employeecardid" type="hidden" name="txt_employeecardid" value="<?= $_GET['employeecardid'] ?>">
                                                    <input class="form-control" id="txt_employeecompanyid" type="hidden" name="txt_employeecompanyid" value="<?= $_GET['employeecompanyid'] ?>">
                                                    <input class="form-control" id="txt_employeetrainingid" type="hidden" name="txt_employeetrainingid" value="<?= $_GET['employeetrainingid'] ?>">
                                                    <input class="form-control" id="txt_employeeaddressid" type="hidden" name="txt_employeeaddressid" value="<?= $_GET['employeeaddressid'] ?>">
                                                    <input class="form-control" id="txt_stractive" type="hidden" name="txt_stractive" value="<?= $str_active ?>">
                                                    <input class="form-control" id="txt_flg" type="hidden" name="txt_flg" value="save_empployee">
                                                    <input class="form-control" id="txt_typemeg" type="hidden" name="txt_typemeg" value="<?= $_GET['meg'] ?>">
                                                    <img src="<?php echo ($result_seEmp['IMAGENAME'] == "") ? "../images/person.png" : "../upload_imageemployee/" . $result_seEmp['IMAGENAME'] ?>" id="imagePreview" alt="แสดงตัวอย่างรูปภาพ" style="position: relative;width: 200px;height: 230px;border-radius: 3px;margin-left: 6px;margin-top: 5px;border: 1px solid #bce8f1;">
                                                    <div style="text-align: center;">
                                                        <button type="button" style="width: 65px;margin-top: 5px;;" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-picture"></span> แก้ไข</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>คำนำหน้าชื่อ</label>

                                                <select class="form-control" required="" id="cb_prefix" name="cb_prefix" autocomplete="off">
                                                    <option value="">เลือกคำนำหน้าชื่อ</option>
                                                    <?php
                                                    $conn_sex = connect("RTMS");
                                                    $sql_sex = "{call megPrefixname_v2(?)}";
                                                    $params_sex = array(
                                                        array('se', SQLSRV_PARAM_IN)
                                                    );
                                                    $query_sex = sqlsrv_query($conn_sex, $sql_sex, $params_sex);
                                                    while ($result_sex = sqlsrv_fetch_array($query_sex, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = "";
                                                        if ($result_sex["PREFIXCODE"] == $result_seEmp['PREFIXCODE']) {
                                                            $selected = "SELECTED";
                                                        }
                                                        ?>
                                                        <option value="<?= $result_sex['PREFIXCODE'] ?>" <?= $selected ?> ><?= $result_sex['PREFIXDESC'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>ชื่อ</label>
                                                <input class="form-control" autocomplete="off" required="" id="txt_firstnameth" name="txt_firstnameth" onkeyup="checkTextth1(this.value)" value="<?= $result_seEmp['FIRSTNAMETHAI'] ?>">
                                            </div>

                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>นามสกุล</label>
                                                <input class="form-control" autocomplete="off" required="" id="txt_lastnameth" name="txt_lastnameth" onkeyup="checkTextth2(this.value)" value="<?= $result_seEmp['LASTNAMETHAI'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>Firstname <i><font style="color: red"> (ชื่อภาษาอังกฤษ)</font></i></label>
                                                <input class="form-control" autocomplete="off" required="" id="txt_firstnameen" name="txt_firstnameen" onkeyup="checkTexten(this.value);" value="<?= $result_seEmp['FIRSTNAMEENG'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>Lastname <i><font style="color: red"> (นามสกุลภาษาอังกฤษ)</font></i></label>
                                                <input class="form-control" autocomplete="off" required="" id="txt_lastnameen" name="txt_lastnameen" onkeyup="checkTexten(this.value);" value="<?= $result_seEmp['LASTNAMEENG'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>วันเกิด</label>
                                                <input class="form-control dateth"  required="" id="txt_birthday" name="txt_birthday" readonly="" style="background-color: #f080802e" value="<?= $result_seEmp['BIRTHDAY'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>เพศ</label>
                                                <select class="form-control" id="cb_sex" name="cb_sex" required="">
                                                    <option value="">เลือกเพศ</option>
                                                    <?php
                                                    if ($result_seEmp['SEX'] != "") {
                                                        $selected = "SELECTED";
                                                    }
                                                    switch ($result_seEmp['SEX']) {
                                                        case 'f': {
                                                                ?>
                                                                <option value="f" <?= $selected ?> >ชาย</option>
                                                                <option value="m" >หญิง</option>
                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value="m" <?= $selected ?> >หญิง</option>
                                                                <option value="f" >ชาย</option>

                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>ส่วนสูง</label>
                                                <input class="form-control" required="" autocomplete="off" id="txt_height" maxlength="3" name="txt_height" onKeyUp="if (isNaN(this.value)) {
                                                            alert('กรุณากรอกตัวเลข');
                                                            this.value = '';
                                                        }" value="<?= $result_seEmp['HEIGHT'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>น้ำหนัก</label>
                                                <input class="form-control" required="" autocomplete="off" id="txt_wigth" maxlength="3" name="txt_wigth" onKeyUp="if (isNaN(this.value)) {
                                                            alert('กรุณากรอกตัวเลข');
                                                            this.value = '';
                                                        }" value="<?= $result_seEmp['WEIGHT'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>กรุ๊ปเลือด</label>
                                                <select class="form-control" required="" id="cb_bloodgroup" name="cb_bloodgroup">
                                                    <option value="">เลือกกรุ๊ปเลือด</option>

                                                    <?php
                                                    if ($result_seEmp['BLOODGROUP'] != "") {
                                                        $selected = "SELECTED";
                                                    }
                                                    switch ($result_seEmp['BLOODGROUP']) {
                                                        case 'A': {
                                                                ?>
                                                                <option value="A" <?= $selected ?>>A</option>
                                                                <option value="B">B</option>
                                                                <option value="O">O</option>
                                                                <option value="AB">AB</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case 'B': {
                                                                ?>
                                                                <option value="A" >A</option>
                                                                <option value="B" <?= $selected ?>>B</option>
                                                                <option value="O">O</option>
                                                                <option value="AB">AB</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case 'O': {
                                                                ?>
                                                                <option value="A" >A</option>
                                                                <option value="B">B</option>
                                                                <option value="O" <?= $selected ?>>O</option>
                                                                <option value="AB">AB</option>
                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value="A" >A</option>
                                                                <option value="B">B</option>
                                                                <option value="O">O</option>
                                                                <option value="AB" <?= $selected ?>>AB</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>สัญชาติ</label>
                                                <select class="form-control" required="" id="cb_nationality" name="cb_nationality">
                                                    <option value="">เลือกประเทศ</option>
                                                    <?php
                                                    if ($result_seEmp['NATIONALITY'] != "") {
                                                        $selected = "SELECTED";
                                                    }
                                                    switch ($result_seEmp['NATIONALITY']) {
                                                        case 'จีน': {
                                                                ?>
                                                                <option value="ไทย" >ไทย</option>
                                                                <option value="จีน" <?= $selected ?>>จีน</option>
                                                                <option value="อังกฤษ">อังกฤษ</option>
                                                                <option value="สหรัฐอเมริกา">สหรัฐอเมริกา</option>

                                                                <?php
                                                            }
                                                            break;
                                                        case 'อังกฤษ': {
                                                                ?>
                                                                <option value="ไทย" >ไทย</option>
                                                                <option value="จีน" >จีน</option>
                                                                <option value="อังกฤษ" <?= $selected ?>>อังกฤษ</option>
                                                                <option value="สหรัฐอเมริกา">สหรัฐอเมริกา</option>

                                                                <?php
                                                            }
                                                            break;
                                                        case 'สหรัฐอเมริกา': {
                                                                ?>
                                                                <option value="ไทย" >ไทย</option>
                                                                <option value="จีน" >จีน</option>
                                                                <option value="อังกฤษ" >อังกฤษ</option>
                                                                <option value="สหรัฐอเมริกา" <?= $selected ?>>สหรัฐอเมริกา</option>

                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value="ไทย" <?= $selected ?>>ไทย</option>
                                                                <option value="จีน">จีน</option>
                                                                <option value="อังกฤษ">อังกฤษ</option>
                                                                <option value="สหรัฐอเมริกา">สหรัฐอเมริกา</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>เชื้อชาติ</label>
                                                <select class="form-control" required="" id="cb_race" name="cb_race">
                                                    <option value="">เลือกประเทศ</option>
                                                    <?php
                                                    if ($result_seEmp['RACE'] != "") {
                                                        $selected = "SELECTED";
                                                    }
                                                    switch ($result_seEmp['RACE']) {
                                                        case 'จีน': {
                                                                ?>
                                                                <option value="ไทย" >ไทย</option>
                                                                <option value="จีน" <?= $selected ?>>จีน</option>
                                                                <option value="อังกฤษ">อังกฤษ</option>
                                                                <option value="สหรัฐอเมริกา">สหรัฐอเมริกา</option>

                                                                <?php
                                                            }
                                                            break;
                                                        case 'อังกฤษ': {
                                                                ?>
                                                                <option value="ไทย" >ไทย</option>
                                                                <option value="จีน" >จีน</option>
                                                                <option value="อังกฤษ" <?= $selected ?>>อังกฤษ</option>
                                                                <option value="สหรัฐอเมริกา">สหรัฐอเมริกา</option>

                                                                <?php
                                                            }
                                                            break;
                                                        case 'สหรัฐอเมริกา': {
                                                                ?>
                                                                <option value="ไทย" >ไทย</option>
                                                                <option value="จีน" >จีน</option>
                                                                <option value="อังกฤษ" >อังกฤษ</option>
                                                                <option value="สหรัฐอเมริกา" <?= $selected ?>>สหรัฐอเมริกา</option>

                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value="ไทย" <?= $selected ?>>ไทย</option>
                                                                <option value="จีน">จีน</option>
                                                                <option value="อังกฤษ">อังกฤษ</option>
                                                                <option value="สหรัฐอเมริกา">สหรัฐอเมริกา</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>

                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>ศาสนา</label>
                                                <select class="form-control" required="" id="cb_religion" name="cb_religion">
                                                    <option value="">เลือกศาสนา</option>

                                                    <?php
                                                    if ($result_seEmp['RELIGION'] != "") {
                                                        $selected = "SELECTED";
                                                    }
                                                    switch ($result_seEmp['RELIGION']) {
                                                        case 'พุทธ': {
                                                                ?>
                                                                <option value="พุทธ" <?= $selected ?>>พุทธ</option>
                                                                <option value = "คริสต์">คริสต์</option>
                                                                <option value = "อิสลาม">อิสลาม</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case 'คริสต์': {
                                                                ?>
                                                                <option value="พุทธ">พุทธ</option>
                                                                <option value = "คริสต์" <?= $selected ?>>คริสต์</option>
                                                                <option value = "อิสลาม">อิสลาม</option>

                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value="พุทธ">พุทธ</option>
                                                                <option value = "คริสต์">คริสต์</option>
                                                                <option value = "อิสลาม" <?= $selected ?>>อิสลาม</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class = "row">
                                        <div class = "col-lg-3">
                                            <div class = "form-group">
                                                <label>โทรศัพท์บ้าน</label>
                                                <input class = "form-control" autocomplete="off" id = "txt_phoneemployee" name = "txt_phoneemployee" onKeyUp = "if (isNaN(this.value)) {
                                                            alert('กรุณากรอกตัวเลข');
                                                            this.value = '';
                                                        }" value="<?= $result_seEmp['MOBILENUMBER1'] ?>" maxlength="10">
                                            </div>
                                        </div>
                                        <div class = "col-lg-3">
                                            <div class = "form-group">
                                                <font style = "color: red">* </font><label>โทรศัพท์มือถือ</label>
                                                <input class = "form-control" autocomplete="off" required="" id = "txt_mobile" name = "txt_mobile" onKeyUp = "if (isNaN(this.value)) {
                                                            alert('กรุณากรอกตัวเลข');
                                                            this.value = '';
                                                        }" value="<?= $result_seEmp['MOBILENUMBER2'] ?>" maxlength="10">
                                            </div>
                                        </div>
                                        <div class = "col-lg-3">
                                            <div class = "form-group">
                                                <label>อีเมลล์ <i><font style = "color: red"> (xxx@email.com)</font></i></label>
                                                <input class = "form-control" autocomplete="off" type="email"  id = "txt_emailemployee" name = "txt_emailemployee"  value="<?= $result_seEmp['EMAILADDRESS'] ?>">
                                            </div>
                                        </div>
                                        <div class = "col-lg-3">
                                            <div class = "form-group">
                                                <label>สถานะ</label>
                                                <select class="form-control"  id="cb_activestatusemp" name="cb_activestatusemp">
                                                    <?php
                                                    if ($result_seEmp['ACTIVESTATUS'] == "1") {
                                                        $selected = "SELECTED";
                                                    }
                                                    switch ($result_seEmp['ACTIVESTATUS']) {
                                                        case '1': {
                                                                ?>
                                                                <option value = "0" >ไม่ใช้งาน</option>
                                                                <option value = "1" <?= $selected ?>>ใช้งาน</option>
                                                                <?php
                                                            }
                                                            break;

                                                        default : {
                                                                ?>
                                                                <option value = "0" <?= $selected ?>>ไม่ใช้งาน</option>
                                                                <option value="1" >ใช้งาน</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class = "panel panel-default">
                                <div class = "panel-heading" style="background-color: #e7e7e7">
                                    <font style="font-size: 16px"><b>ข้อมูลพนักงานย่อย</b></font>
                                </div>

                                <div class = "panel-body">
                                    <!--Nav tabs -->
                                    <ul class = "nav nav-tabs">
                                        <?php
                                        if ($str_active == "card") {
                                            ?>
                                            <li class = "disabled disabledTab"><a href = "#tap_company" ">บริษัท</a></li>
                                            <li class = "active"><a href = "#tap_card" >บัตร</a></li>
                                            <li class = "disabled disabledTab"><a href = "#tap_training" >อบรม</a></li>
                                            <li class = "disabled disabledTab"><a href = "#tap_address" >ที่อยู่</a></li>
                                            <?php
                                        } else if ($str_active == "company") {
                                            ?>
                                            <li class = "active"><a href = "#tap_company" >บริษัท</a></li>
                                            <li class = "disabled disabledTab"><a href = "#tap_card" >บัตร</a></li>
                                            <li class = "disabled disabledTab"><a href = "#tap_training" >อบรม</a></li>
                                            <li class = "disabled disabledTab"><a href = "#tap_address" >ที่อยู่</a></li>
                                            <?php
                                        } else if ($str_active == "training") {
                                            ?>
                                            <li class = "disabled disabledTab"><a href = "#tap_company" >บริษัท</a></li>
                                            <li class = "disabled disabledTab"><a href = "#tap_card" >บัตร</a></li>
                                            <li class = "active"><a href = "#tap_training" >อบรม</a></li>
                                            <li class = "disabled disabledTab"><a href = "#tap_address" >ที่อยู่</a></li>
                                            <?php
                                        } else if ($str_active == "address") {
                                            ?>
                                            <li class = "disabled disabledTab"><a href = "#tap_company" >บริษัท</a></li>
                                            <li class = "disabled disabledTab"><a href = "#tap_card" >บัตร</a></li>
                                            <li class = "disabled disabledTab"><a href = "#tap_training" >อบรม</a></li>
                                            <li class = "active"><a href = "#tap_address" >ที่อยู่</a></li>
                                            <?php
                                        } else {
                                            ?>
                                            <li class = "active"><a href = "#tap_company" data-toggle = "tab">บริษัท</a></li>
                                            <li class = ""><a href = "#tap_card" data-toggle = "tab">บัตร</a></li>
                                            <li class = ""><a href = "#tap_training" data-toggle = "tab">อบรม</a></li>
                                            <li class = ""><a href = "#tap_address" data-toggle = "tab">ที่อยู่</a></li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                    <div class = "tab-content">

                                        <div class = "<?php echo ($str_active == "card" ) ? "tab-pane fade in active" : "tab-pane fade "; ?>" id = "tap_card">
                                            <div class = "panel-body">
                                                <div class = "row">
                                                    <div class = "col-lg-2">

                                                        <div class = "form-group">

                                                            <?php
                                                            if ($_GET['meg'] == "edit" && $str_active == "card") {
                                                                ?>
                                                                <label>ประเภทบัตร</label>
                                                                <select disabled style="background-color: #f080802e" class="form-control" id="cb_cardtype" name="cb_cardtype">

                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <label>ประเภทบัตร</label>
                                                                    <select    class="form-control"   id="cb_cardtype" name="cb_cardtype">

                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <option value = "">เลือกประเภทบัตร</option>

                                                                    <?php
                                                                    $sql_ct = "{call megCardtype_v2(?)}";
                                                                    $params_ct = array(
                                                                        array('se', SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_ct = sqlsrv_query($conn, $sql_ct, $params_ct);
                                                                    while ($result_ct = sqlsrv_fetch_array($query_ct, SQLSRV_FETCH_ASSOC)) {
                                                                        $selected = "";
                                                                        if ($result_ct["CARDTYPECODE"] == $result_seCard['CARDTYPECODE']) {
                                                                            $selected = "SELECTED";
                                                                        }
                                                                        ?>
                                                                        <option value="<?= $result_ct['CARDTYPECODE'] ?>" <?= $selected ?>><?= $result_ct['CARDTYPEDESC'] ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label>เลขที่บัตรพนักงาน</label>
                                                            <input class="form-control" autocomplete="off" id="txt_cardno" name="txt_cardno" value="<?= $result_seCard['CARDNUMBER'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class = "col-lg-2">
                                                        <div class = "form-group">
                                                            <label>สถานะ</label>
                                                            <select class="form-control" id="cb_activestatuscard" name="cb_activestatuscard">
                                                                <?php
                                                                if ($result_seCard['ACTIVESTATUS'] == "1") {
                                                                    $selected = "SELECTED";
                                                                }
                                                                switch ($result_seCard['ACTIVESTATUS']) {
                                                                    case '1': {
                                                                            ?>
                                                                            <option value = "0" >ไม่ใช้งาน</option>
                                                                            <option value = "1" <?= $selected ?>>ใช้งาน</option>
                                                                            <?php
                                                                        }
                                                                        break;

                                                                    default : {
                                                                            ?>
                                                                            <option value = "0" <?= $selected ?>>ไม่ใช้งาน</option>
                                                                            <option value="1" >ใช้งาน</option>
                                                                            <?php
                                                                        }
                                                                        break;
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">

                                                        <div class="form-group">
                                                            <label>วันที่ออกบัตร</label>
                                                            <input class="form-control dateen" id="txt_carddatestart" name="txt_carddatestart" readonly="" style="background-color: #f080802e" value="<?= ($result_seCard['ISSUEDATE'] != "") ? $result_seCard['ISSUEDATE'] : ""; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">

                                                        <div class="form-group">
                                                            <label>วันบัตรหมดอายุ</label>
                                                            <input class="form-control dateen" id="txt_carddateend" name="txt_carddateend" readonly="" style="background-color: #f080802e" value="<?= ($result_seCard['EXPIREDATE'] != "") ? $result_seCard['EXPIREDATE'] : ""; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label>จำนวนวันแจ้งเตือน</label>

                                                            <input class="form-control" onKeyUp = "if (isNaN(this.value)) {
                                                                        alert('กรุณากรอกตัวเลข');
                                                                        this.value = '';
                                                                    }" id="txt_datealert" autocomplete="off" name="txt_datealert"  value="<?= ($result_seCard['ALERTDATE'] != "") ? $result_seCard['ALERTDATE'] : ""; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>สถานที่ออกบัตร</label>
                                                            <textarea class="form-control" autocomplete="off" rows="3" id="txt_issueplace" name="txt_issueplace" ><?= $result_seCard['ISSUEPLACE'] ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>รายละเอียดข้อความ</label>
                                                            <textarea class="form-control" autocomplete="off" rows="3" id="txt_alertmessage" name="txt_alertmessage" ><?= $result_seCard['ALERTMESSAGE'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label>แนบเอกสาร</label>
                                                        <input type="file"   class="form-control"  id="file_doccard" name="file_doccard" >

                                                    </div>
                                                    <div class="col-md-10">
                                                        <label>&nbsp;</label>
                                                        <?php
                                                        if ($result_seCard['FILENAME'] != "") {
                                                            ?>
                                                            <div >
                                                                <a class="btn btn-outline btn-default view-pdf" href="../upload_documentcard/<?= $result_seCard['FILENAME'] ?>"><li class="fa fa-file-text-o"></li> <?= $result_seCard['FILENAME'] ?></a>

                                                            </div>

                                                            <?php
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
                                                <div class = "row">&nbsp;</div>
                                                <div class = "row">&nbsp;</div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" style="background-color: #e7e7e7">
                                                                ข้อมูลบัตร                            
                                                            </div>
                                                            <div class="panel-body">
                                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">


                                                                    <div class="row"><div class="col-sm-12">
                                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>ประเภทบัตร</th>
                                                                                        <th>เลขที่บัตร</th>
                                                                                        <th>วันที่ออกบัตร</th>
                                                                                        <th>วันบัตรหมดอายุ</th>
                                                                                        <th>รายละเอียดข้อความ</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    if ($_GET['employeecardid'] != "") {
                                                                                        $sql_seCard1 = "{call megEmployeecard_v2(?,?,?)}";
                                                                                        $params_seCard1 = array(
                                                                                            array('se', SQLSRV_PARAM_IN),
                                                                                            array($_GET['employeeid'], SQLSRV_PARAM_IN),
                                                                                            array($_GET['employeecardid'], SQLSRV_PARAM_IN)
                                                                                        );
                                                                                    } else {
                                                                                        $sql_seCard1 = "{call megEmployeecard_v2(?,?)}";
                                                                                        $params_seCard1 = array(
                                                                                            array('se', SQLSRV_PARAM_IN),
                                                                                            array($_GET['employeeid'], SQLSRV_PARAM_IN)
                                                                                        );
                                                                                    }
                                                                                    $query_seCard1 = sqlsrv_query($conn, $sql_seCard1, $params_seCard1);
                                                                                    while ($result_seCard1 = sqlsrv_fetch_array($query_seCard1, SQLSRV_FETCH_ASSOC)) {
                                                                                        ?>
                                                                                        <tr class="odd gradeX">
                                                                                            <td><?= $result_seCard1['CARDTYPEDESC'] ?></td>
                                                                                            <td><?= $result_seCard1['CARDNUMBER'] ?></td>
                                                                                            <td><?= date_format(date_create($result_seCard1['ISSUEDATE']), 'd/m/Y') ?></td>
                                                                                            <td><?= date_format(date_create($result_seCard1['EXPIREDATE']), 'd/m/Y') ?></td>
                                                                                            <td><?= $result_seCard1['ALERTMESSAGE'] ?></td>

                                                                                        </tr>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div></div></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="<?php echo ($str_active == "company" || $str_active == "employee") ? "tab-pane fade in active" : "tab-pane fade"; ?>" id="tap_company">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">

                                                            <?php
                                                            if ($_GET['meg'] == "add") {
                                                                ?>
                                                                <font style = "color: red">* </font><label>รหัสพนักงาน</label>
                                                                <input class="form-control" required="" autocomplete="off" id="txt_employeecode" name="txt_employeecode" value="<?= $result_seEmp['EMPLOYEECODE'] ?>">
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <label>รหัสพนักงาน</label>
                                                                <input class="form-control" readonly="" style="background-color: #f080802e" id="txt_employeecode" name="txt_employeecode" value="<?= $result_seEmp['EMPLOYEECODE'] ?>">
                                                                <?php
                                                            }
                                                            ?>


                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>บริษัท</label>
                                                            <?= ($_GET['meg'] == "edit" && $str_active == "company") ? '<font style = "color: red">* </font>' : '' ?><select  class="form-control" <?= ($_GET['meg'] == "edit" && $str_active == "company") ? 'required="required"' : '' ?>  id="cb_company" name="cb_company">
                                                                <option value="">เลือกบริษัท</option>
                                                                <?php
                                                                $sql_cp = "{call megCompany_v2(?)}";
                                                                $params_cp = array(
                                                                    array('se', SQLSRV_PARAM_IN)
                                                                );
                                                                $query_cp = sqlsrv_query($conn, $sql_cp, $params_cp);
                                                                while ($result_cp = sqlsrv_fetch_array($query_cp, SQLSRV_FETCH_ASSOC)) {
                                                                    $selected = "";
                                                                    if ($result_cp["COMPANYCODE"] == $result_seComp['COMPANYCODE']) {
                                                                        $selected = "SELECTED";
                                                                    }
                                                                    ?>
                                                                    <option value="<?= $result_cp['COMPANYCODE'] ?>" <?= $selected ?>><?= $result_cp['THAINAME'] ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>ฝ่ายงาย</label>
                                                            <select onchange="fetch_department(this.value);"  class="form-control" id="cb_divistion" name="cb_divistion">

                                                                <option value="">เลือกฝ่ายงาน</option>
                                                                <?php
                                                                $sql_div = "{call megDivision_v2(?)}";
                                                                $params_div = array(
                                                                    array('se', SQLSRV_PARAM_IN)
                                                                );
                                                                $query_div = sqlsrv_query($conn, $sql_div, $params_div);
                                                                while ($result_div = sqlsrv_fetch_array($query_div, SQLSRV_FETCH_ASSOC)) {
                                                                    $selected = "";
                                                                    if ($result_div["DIVISIONCODE"] == $result_seComp['DIVISIONCODE']) {
                                                                        $selected = "SELECTED";
                                                                    }
                                                                    ?>
                                                                    <option value="<?= $result_div['DIVISIONCODE'] ?>" <?= $selected ?>><?= $result_div['DEVISIONNAME'] ?></option>
                                                                    <?php
                                                                }
                                                                ?>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>สายงาน</label>
                                                            <select  class="form-control" id="cb_department" name="cb_department">
                                                                <option value="">เลือกสายงาน</option>
                                                                <?php
                                                                $sql_dep = "{call megDepartment_v2(?,?)}";
                                                                $params_dep = array(
                                                                    array('se', SQLSRV_PARAM_IN),
                                                                    array($_POST['data_cbdiv'], SQLSRV_PARAM_IN)
                                                                );
                                                                $query_dep = sqlsrv_query($conn, $sql_dep, $params_dep);
                                                                while ($result_dep = sqlsrv_fetch_array($query_dep, SQLSRV_FETCH_ASSOC)) {
                                                                    $selected = "";
                                                                    if ($result_dep["DEPARTMENTCODE"] == $result_seComp['DEPARTMENTCODE']) {
                                                                        $selected = "SELECTED";
                                                                    }
                                                                    ?>
                                                                    <option value="<?= $result_dep['DEPARTMENTCODE'] ?>" <?= $selected ?>><?= $result_dep['DEPARTMENTNAME'] ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class = "row">
                                                    <div class = "col-lg-3">
                                                        <div class = "form-group">
                                                            <label>ตำแหน่ง</label>
                                                            <select class = "form-control" id = "cb_position" name = "cb_position">
                                                                <option value="">เลือกตำแหน่ง</option>
                                                                <?php
                                                                $sql_posi = "{call megPosition_v2(?)}";
                                                                $params_posi = array(
                                                                    array('se', SQLSRV_PARAM_IN)
                                                                );
                                                                $query_posi = sqlsrv_query($conn, $sql_posi, $params_posi);
                                                                while ($result_posi = sqlsrv_fetch_array($query_posi, SQLSRV_FETCH_ASSOC)) {
                                                                    $selected = "";
                                                                    if ($result_posi["POSITIONCODE"] == $result_seComp['POSITIONCODE']) {
                                                                        $selected = "SELECTED";
                                                                    }
                                                                    ?>
                                                                    <option value="<?= $result_posi['POSITIONCODE'] ?>" <?= $selected ?>><?= $result_posi['POSITIONDESC'] ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>วันที่เริ่มงาน</label>
                                                            <input class="form-control dateen" id="txt_datestart" name="txt_datestart" readonly="" style="background-color: #f080802e" value="<?= $result_seComp['STARTDATE'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>วันที่ลาออก</label>
                                                            <input class="form-control dateen" id="txt_dateend" name="txt_dateend" readonly="" style="background-color: #f080802e" value="<?= $result_seComp['ENDDATE'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>สถานะ</label>
                                                            <select class="form-control" id="cb_activestatuscomp" name="cb_activestatuscomp">

                                                                <?php
                                                                if ($result_seComp['ACTIVESTATUS'] == "1") {
                                                                    $selected = "SELECTED";
                                                                }
                                                                switch ($result_seComp['ACTIVESTATUS']) {
                                                                    case '1': {
                                                                            ?>
                                                                            <option value = "0" >ไม่ใช้งาน</option>
                                                                            <option value = "1" <?= $selected ?>>ใช้งาน</option>
                                                                            <?php
                                                                        }
                                                                        break;

                                                                    default : {
                                                                            ?>
                                                                            <option value = "0" <?= $selected ?>>ไม่ใช้งาน</option>
                                                                            <option value="1" >ใช้งาน</option>
                                                                            <?php
                                                                        }
                                                                        break;
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>หมายเหตุ</label>
                                                            <textarea class="form-control" autocomplete="off" rows="3" id="txt_remark" name="txt_remark" ><?= $result_seComp['REMARK'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class = "row">&nbsp;</div>
                                                <div class = "row">&nbsp;</div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" style="background-color: #e7e7e7">
                                                                <font style="font-size: 16px"><b>ข้อมูลบริษัท</b></font>                            
                                                            </div>
                                                            <div class="panel-body">
                                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                                    <div class="row"><div class="col-sm-12">
                                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>ชื่อบริษัท</th>
                                                                                        <th>ชื่อสายงาน</th>
                                                                                        <th>ชื่อฝ่ายงาน</th>
                                                                                        <th>ชื่อตำแหน่ง</th>
                                                                                        <th>หมายเหตุ</th>
                                                                                        <th>สถานะ</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    if ($_GET['employeecompanyid'] != "") {
                                                                                        $sql_seComp1 = "{call megEmployeecompany_v2(?,?,?)}";
                                                                                        $params_seComp1 = array(
                                                                                            array('se', SQLSRV_PARAM_IN),
                                                                                            array($_GET['employeeid'], SQLSRV_PARAM_IN),
                                                                                            array($_GET['employeecompanyid'], SQLSRV_PARAM_IN)
                                                                                        );
                                                                                    } else {
                                                                                        $sql_seComp1 = "{call megEmployeecompany_v2(?)}";
                                                                                        $params_seComp1 = array(
                                                                                            array('se', SQLSRV_PARAM_IN)
                                                                                        );
                                                                                    }

                                                                                    $query_seComp1 = sqlsrv_query($conn, $sql_seComp1, $params_seComp1);
                                                                                    while ($result_seComp1 = sqlsrv_fetch_array($query_seComp1, SQLSRV_FETCH_ASSOC)) {
                                                                                        ?>
                                                                                        <tr class="odd gradeX">
                                                                                            <td><?= $result_seComp1['THAINAME'] ?></td>
                                                                                            <td><?= $result_seComp1['DEVISIONNAME'] ?></td>
                                                                                            <td><?= $result_seComp1['DEPARTMENTNAME'] ?></td>
                                                                                            <td><?= $result_seComp1['POSITIONDESC'] ?></td>
                                                                                            <td><?= $result_seComp1['REMARK'] ?></td>
                                                                                            <td><?php echo ($result_seComp1['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>

                                                                                        </tr>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div></div></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="<?php echo ($str_active == "training" ) ? "tab-pane fade in active" : "tab-pane fade"; ?>" id="tap_training">
                                            <div class="panel-body">
                                                <div class="row">

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>คอร์สเรียน</label>
                                                            <select onchange="fetch_div(this.value);" class="form-control" id="cb_trainingname" name="cb_trainingname">
                                                                <option value="">เลือกคอร์สเรียน</option>

                                                                <?php
                                                                $sql_course = "{call megCoursetype_v2(?)}";
                                                                $params_course = array(
                                                                    array('se', SQLSRV_PARAM_IN)
                                                                );
                                                                $query_course = sqlsrv_query($conn, $sql_course, $params_course);
                                                                while ($result_course = sqlsrv_fetch_array($query_course, SQLSRV_FETCH_ASSOC)) {
                                                                    $selected = "";
                                                                    if ($result_course["COURSETYPECODE"] == $result_seTraining['COURSETYPECODE']) {
                                                                        $selected = "SELECTED";
                                                                    }
                                                                    ?>
                                                                    <option value="<?= $result_course['COURSETYPECODE'] ?>" <?= $selected ?>><?= $result_course['COURSETYPEDESC'] ?></option>
                                                                    <?php
                                                                }
                                                                ?>


                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>ราคาคอร์สเรียน</label>
                                                            <input class="form-control " autocomplete="off" id="txt_trainingvalues" name="txt_trainingvalues"  value="<?= $result_seTraining['COSTVALUES'] ?>">
                                                        </div>
                                                    </div>  
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>สถาบัน</label>
                                                            <input class="form-control " autocomplete="off" id="txt_traininginstitution" name="txt_traininginstitution"   value="<?= $result_seTraining['INSTITUTION'] ?>">
                                                        </div>
                                                    </div>




                                                </div>
                                                <div class = "row">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>ใบรับรอง</label>
                                                            <input class="form-control " autocomplete="off" id="txt_trainingauthenticate" name="txt_trainingauthenticate"   value="<?= $result_seTraining['AUTHENTICATE'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>ปีใบรับรอง</label>
                                                            <input class="form-control " autocomplete="off" id="txt_trainingauthenticateyear" name="txt_trainingauthenticateyear"  value="<?= $result_seTraining['AUTHENTICATEYEAR'] ?>">
                                                        </div>
                                                    </div>                                              

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>สถานะ</label>
                                                            <select class="form-control" id="cb_activestatustraining" name="cb_activestatustraining">

                                                                <?php
                                                                if ($result_seTraining['ACTIVESTATUS'] == "1") {
                                                                    $selected = "SELECTED";
                                                                }
                                                                switch ($result_seTraining['ACTIVESTATUS']) {
                                                                    case '1': {
                                                                            ?>
                                                                            <option value = "0" >ไม่ใช้งาน</option>
                                                                            <option value = "1" <?= $selected ?>>ใช้งาน</option>
                                                                            <?php
                                                                        }
                                                                        break;

                                                                    default : {
                                                                            ?>
                                                                            <option value = "0" <?= $selected ?>>ไม่ใช้งาน</option>
                                                                            <option value="1" >ใช้งาน</option>
                                                                            <?php
                                                                        }
                                                                        break;
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>หมายเหตุ</label>
                                                            <textarea class="form-control" autocomplete="off" rows="3" id="txt_trainingremark" name="txt_trainingremark" ><?= $result_seTraining['REMARK'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class = "row">&nbsp;</div>
                                                <div class = "row">&nbsp;</div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" style="background-color: #e7e7e7">
                                                                <font style="font-size: 16px"><b>ข้อมูลอบรม</b></font>                            
                                                            </div>
                                                            <div class="panel-body">
                                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                                    <div class="row"><div class="col-sm-12">
                                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>ชื่อคอร์ส</th>
                                                                                        <th>ชื่อสถาบัน</th>
                                                                                        <th>ใบรับรอง</th>
                                                                                        <th>ปีใบรับรอง</th>
                                                                                        <th>ราคา</th>
                                                                                        <th>หมายเหตุ</th>
                                                                                        <th>สถานะ</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    if ($_GET['employeetrainingid'] != "") {
                                                                                        $sql_seTraining1 = "{call megTraining_v2(?,?,?)}";
                                                                                        $params_seTraining1 = array(
                                                                                            array('se', SQLSRV_PARAM_IN),
                                                                                            array($_GET['employeeid'], SQLSRV_PARAM_IN),
                                                                                            array($_GET['employeetrainingid'], SQLSRV_PARAM_IN)
                                                                                        );
                                                                                    } else {
                                                                                        $sql_seTraining1 = "{call megTraining_v2(?)}";
                                                                                        $params_seTraining1 = array(
                                                                                            array('se', SQLSRV_PARAM_IN)
                                                                                        );
                                                                                    }

                                                                                    $query_seTraining1 = sqlsrv_query($conn, $sql_seTraining1, $params_seTraining1);
                                                                                    while ($result_seTraining1 = sqlsrv_fetch_array($query_seTraining1, SQLSRV_FETCH_ASSOC)) {
                                                                                        ?>
                                                                                        <tr class="odd gradeX">
                                                                                            <td><?= $result_seTraining1['COURSETYPEDESC'] ?></td>
                                                                                            <td><?= $result_seTraining1['INSTITUTION'] ?></td>
                                                                                            <td><?= $result_seTraining1['AUTHENTICATE'] ?></td>
                                                                                            <td><?= $result_seTraining1['AUTHENTICATEYEAR'] ?></td>
                                                                                            <td><?= $result_seTraining1['COSTVALUES'] ?></td>
                                                                                            <td><?= $result_seTraining1['REMARK'] ?></td>
                                                                                            <td><?php echo ($result_seTraining1['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>

                                                                                        </tr>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div></div></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="<?php echo ($str_active == "address" ) ? "tab-pane fade in active" : "tab-pane fade"; ?>" id="tap_address">
                                            <div class="panel-body">
                                                <div class="row">

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>ประเภทที่อยู่</label>
                                                            <select  class="form-control" id="cb_addresstypecode" name="cb_addresstypecode">
                                                                <option value="">เลือกประเภทที่อยู่</option>
                                                                <?php
                                                                $sql_seAddresstype = "{call megAddresstype_v2(?)}";
                                                                $params_seAddresstype = array(
                                                                    array('se', SQLSRV_PARAM_IN)
                                                                );

                                                                $query_seAddresstype = sqlsrv_query($conn, $sql_seAddresstype, $params_seAddresstype);
                                                                while ($result_seAddresstype = sqlsrv_fetch_array($query_seAddresstype, SQLSRV_FETCH_ASSOC)) {
                                                                    $selected = "";
                                                                    if ($result_seAddresstype["ADDRESSTYPECODE"] == $result_seAddress['ADDRESSTYPECODE']) {
                                                                        $selected = "SELECTED";
                                                                    }
                                                                    ?>
                                                                    <option value="<?= $result_seAddresstype['ADDRESSTYPECODE'] ?>"<?= $selected ?>><?= $result_seAddresstype['ADDRESSTYPEDESC'] ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <div class="form-group">
                                                            <label>เลขที่</label>
                                                            <input class="form-control " autocomplete="off" id="txt_addressno" name="txt_addressno"  value="<?= $result_seAddress['ADDRESSNO'] ?>">
                                                        </div>
                                                    </div>  
                                                    <div class="col-lg-1">
                                                        <div class="form-group">
                                                            <label>หมู่</label>
                                                            <input class="form-control " autocomplete="off" id="txt_village" name="txt_village"   value="<?= $result_seAddress['VILLAGE'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <div class="form-group">
                                                            <label>&nbsp;</label>
                                                            <input class="form-control "  autocomplete="off" id="txt_floor" name="txt_floor"   value="<?= $result_seAddress['FLOOR'] ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>ถนน</label>
                                                            <input class="form-control " autocomplete="off" id="txt_street" name="txt_street"  value="<?= $result_seAddress['STREET'] ?>">
                                                        </div>
                                                    </div> 
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>ชอย</label>
                                                            <input class="form-control " autocomplete="off" id="txt_sidestreet" name="txt_sidestreet"  value="<?= $result_seAddress['SIDESTREET'] ?>">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>จังหวัด</label>
                                                            <select onchange="fetch_amphur(this.value)"  class="form-control" id="cb_provincecode" name="cb_provincecode">
                                                                <option value="">เลือกจังหวัด</option>
                                                                <?php
                                                                $sql_seProvince = "{call megProvince_v2(?)}";
                                                                $params_seProvince = array(
                                                                    array('se', SQLSRV_PARAM_IN)
                                                                );

                                                                $query_seProvince = sqlsrv_query($conn, $sql_seProvince, $params_seProvince);
                                                                while ($result_seProvince = sqlsrv_fetch_array($query_seProvince, SQLSRV_FETCH_ASSOC)) {
                                                                    $selected = "";
                                                                    if ($result_seProvince["PROVINCE_ID"] == $result_seAddress['PROVINCECODE']) {
                                                                        $selected = "SELECTED";
                                                                    }
                                                                    ?>
                                                                    <option value="<?= $result_seProvince['PROVINCE_ID'] ?>"<?= $selected ?>><?= $result_seProvince['PROVINCE_NAME'] ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>อำเภอ</label>
                                                            <select onchange="fetch_district(this.value)" class="form-control" id="cb_amphurcode" name="cb_amphurcode">
                                                                <?php
                                                                if ($result_seAddress['PREFECTURECODE'] != "") {
                                                                    $sql_seAmphur = "{call megAmphur_v2(?,?)}";
                                                                    $params_seAmphur = array(
                                                                        array('se', SQLSRV_PARAM_IN),
                                                                        array($result_seAddress['PROVINCECODE'], SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seAmphur = sqlsrv_query($conn, $sql_seAmphur, $params_seAmphur);
                                                                    while ($result_seAmphur = sqlsrv_fetch_array($query_seAmphur, SQLSRV_FETCH_ASSOC)) {
                                                                        $selected = "";
                                                                        if ($result_seAmphur["AMPHUR_ID"] == $result_seAddress['PREFECTURECODE']) {
                                                                            $selected = "SELECTED";
                                                                        }
                                                                        ?>
                                                                        <option value="<?= $result_seAmphur['AMPHUR_ID'] ?>"<?= $selected ?>><?= $result_seAmphur['AMPHUR_NAME'] ?></option>
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <option value="">เลือกอำเภอ</option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">

                                                        <div class="form-group">
                                                            <label>ตำบล</label>
                                                            <select onchange="fetch_zipcode(this.value)" class="form-control" id="cb_districtcode" name="cb_districtcode">
                                                                <?php
                                                                if ($result_seAddress['DISTRICTCODE'] != "") {
                                                                    $sql_seDistrict = "{call megDistrict_v2(?,?)}";
                                                                    $params_seDistrict = array(
                                                                        array('se', SQLSRV_PARAM_IN),
                                                                        array($result_seAddress['PREFECTURECODE'], SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seDistrict = sqlsrv_query($conn, $sql_seDistrict, $params_seDistrict);
                                                                    while ($result_seDistrict = sqlsrv_fetch_array($query_seDistrict, SQLSRV_FETCH_ASSOC)) {
                                                                        $selected = "";
                                                                        if ($result_seDistrict["DISTRICT_CODE"] == $result_seAddress['DISTRICTCODE']) {
                                                                            $selected = "SELECTED";
                                                                        }
                                                                        ?>
                                                                        <option value="<?= $result_seDistrict['DISTRICT_CODE'] ?>"<?= $selected ?>><?= $result_seDistrict['DISTRICT_NAME'] ?></option>
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <option value="">เลือกตำบล</option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>รหัสไปรษณีย์</label>
                                                            <select class="form-control" id="cb_zipcode" name="cb_zipcode">
                                                                <?php
                                                                if ($result_seAddress['ZIPCODE'] != "") {
                                                                    $sql_seZipcode = "{call megZipcode_v2(?,?)}";
                                                                    $params_seZipcode = array(
                                                                        array('se', SQLSRV_PARAM_IN),
                                                                        array($result_seAddress['DISTRICTCODE'], SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seZipcode = sqlsrv_query($conn, $sql_seZipcode, $params_seZipcode);
                                                                    while ($result_seZipcode = sqlsrv_fetch_array($query_seZipcode, SQLSRV_FETCH_ASSOC)) {
                                                                        $selected = "";
                                                                        if ($result_seZipcode["DISTRICT_CODE"] == $result_seAddress['DISTRICTCODE']) {
                                                                            $selected = "SELECTED";
                                                                        }
                                                                        ?>
                                                                        <option value="<?= $result_seZipcode['ZIPCODE'] ?>"<?= $selected ?>><?= $result_seZipcode['ZIPCODE'] ?></option>
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <option value="">เลือกรหัสไปรษณีย์</option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>ที่อยู่ปัจุบัน</label>
                                                            <textarea class="form-control" autocomplete="off" rows="3" id="txt_fulladdress" name="txt_fulladdress" ><?= $result_seAddress['FULLADDRESS'] ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>หมายเหตุ</label>
                                                            <textarea class="form-control" autocomplete="off" rows="3" id="txt_descriptions" name="txt_descriptions" ><?= $result_seAddress['FULLADDRESS'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>เบอร์โทรศัพท์</label>
                                                            <input class="form-control " autocomplete="off" id="txt_phoneaddress" name="txt_phoneaddress"   value="<?= $result_seAddress['PHONE'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>สถานะ</label>
                                                            <select class="form-control" id="cb_activestatusaddress" name="cb_activestatusaddress">

                                                                <?php
                                                                if ($result_seAddress['ACTIVESTATUS'] == "1") {
                                                                    $selected = "SELECTED";
                                                                }
                                                                switch ($result_seAddress['ACTIVESTATUS']) {
                                                                    case '1': {
                                                                            ?>
                                                                            <option value = "0" >ไม่ใช้งาน</option>
                                                                            <option value = "1" <?= $selected ?>>ใช้งาน</option>
                                                                            <?php
                                                                        }
                                                                        break;

                                                                    default : {
                                                                            ?>
                                                                            <option value = "0" <?= $selected ?>>ไม่ใช้งาน</option>
                                                                            <option value="1" >ใช้งาน</option>
                                                                            <?php
                                                                        }
                                                                        break;
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class = "row">&nbsp;</div>
                                                <div class = "row">&nbsp;</div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" style="background-color: #e7e7e7">
                                                                <font style="font-size: 16px"><b>ข้อมูลที่อยู่</b></font>                            
                                                            </div>
                                                            <div class="panel-body">
                                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                                    <div class="row"><div class="col-sm-12">
                                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>ประเภทที่อยู่</th>
                                                                                        <th>ตำบล</th>
                                                                                        <th>อำเภอ</th>
                                                                                        <th>จังหวัด</th>
                                                                                        <th>รหัสไปรษณีย์</th>
                                                                                        <th>เบอร์โทร</th>
                                                                                        <th>สถานะ</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    $sql_seAddress = "{call megAddress_v2(?,?)}";
                                                                                    $params_seAddress = array(
                                                                                        array('se', SQLSRV_PARAM_IN),
                                                                                        array($_GET['employeeid'], SQLSRV_PARAM_IN)
                                                                                    );

                                                                                    $query_seAddress = sqlsrv_query($conn, $sql_seAddress, $params_seAddress);
                                                                                    while ($result_seAddress = sqlsrv_fetch_array($query_seAddress, SQLSRV_FETCH_ASSOC)) {
                                                                                        ?>
                                                                                        <tr class="odd gradeX">
                                                                                            <td><?= $result_seAddress['ADDRESSTYPEDESC'] ?></td>
                                                                                            <td><?= $result_seAddress['DISTRICT_NAME'] ?></td>
                                                                                            <td><?= $result_seAddress['AMPHUR_NAME'] ?></td>
                                                                                            <td><?= $result_seAddress['PROVINCE_NAME'] ?></td>
                                                                                            <td><?= $result_seAddress['ZIPCODE'] ?></td>
                                                                                            <td><?= $result_seAddress['PHONE'] ?></td>
                                                                                            <td><?php echo ($result_seAddress['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>

                                                                                        </tr>
                                                                                        <?php
                                                                                    }
                                                                                    ?>

                                                                                </tbody>
                                                                            </table>
                                                                        </div></div></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-lg-12">
                            <input type="button" name="btnSend" onclick="save_employee();" id="btnSend" value="บันทึกข้อมูล" class="btn btn-primary">

                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-lg-12">
                            <div id="message"></div>
                        </div></div>
                    <div class="row">
                        <div class="col-lg-12">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/raphael/raphael.min.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>



        <script language="javaScript">
                                                                function Checkemail(str) {
                                                                    var Email = /^([a-zA-Z0-9]+)@([a-zA-Z0-9]+)\.([a-zA-Z0-9]{2,5})$/
                                                                    if (!document.getElementById(str).value.match(Email)) {
                                                                        alert('รูปแบบ Email ไม่ถูกต้อง');
                                                                        document.getElementById(str).focus();
                                                                        document.getElementById(str).value = '';
                                                                        return false;
                                                                    }
                                                                }
        </script>
        <script type="text/javascript">
            $('#file').change(function () {
                readImgUrlAndPreview(this);
                function readImgUrlAndPreview(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#imagePreview').attr('src', e.target.result);
                        }
                    }
                    ;
                    reader.readAsDataURL(input.files[0]);
                }
            });
            $(document).ready(function () {
                $('#clear_img').on('click', function (e) {
                    $("#file").val('');
                    $('#imagePreview').attr('src', '../images/person.png');
                });
            });
            function show_btn() {
                $('#update_q1').show();
                $('#txt').hide();
            }



        </script>
        <script type="text/javascript">
            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateen").datetimepicker({
                    timepicker: false,
                    format: 'd/m/Y', // กำหนดรูปแบsบวันที่ ที่ใช้ เป็น 00-00-0000			
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                });
            });
            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateth").datetimepicker({
                    timepicker: false,
                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                    onSelectDate: function (dp, $input) {
                        var yearT = new Date(dp).getFullYear() - 0;
                        var yearTH = yearT + 543;
                        var fulldate = $input.val();
                        var fulldateTH = fulldate.replace(yearT, yearTH);
                        $input.val(fulldateTH);
                    },
                });
                // กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
                $(".dateth").on("mouseenter mouseleave", function (e) {
                    var dateValue = $(this).val();
                    if (dateValue != "") {
                        var arr_date = dateValue.split("/");
                        if (e.type == "mouseenter") {
                            var yearT = arr_date[2] - 543;
                        }
                        if (e.type == "mouseleave") {
                            var yearT = parseInt(arr_date[2]) + 543;
                        }
                        dateValue = dateValue.replace(arr_date[2], yearT);
                        $(this).val(dateValue);
                    }
                });
            });
        </script>

        <script type="text/javascript">
            function save_employee()
            {
                var txt_employeeid = document.getElementById('txt_employeeid').value;
                var txt_employeecardid = document.getElementById("txt_employeecardid").value;
                var txt_employeecompanyid = document.getElementById("txt_employeecompanyid").value;
                var txt_employeetrainingid = document.getElementById("txt_employeetrainingid").value;
                var txt_employeeaddressid = document.getElementById("txt_employeeaddressid").value;
                var txt_stractive = document.getElementById("txt_stractive").value;
                var imagename = '';
                var filename = '';
                var cb_bloodgroup = document.getElementById("cb_bloodgroup").value;
                var cb_sex = document.getElementById("cb_sex").value;
                var cb_prefix = document.getElementById("cb_prefix").value;
                var txt_firstnameth = document.getElementById("txt_firstnameth").value;
                var cb_nationality = document.getElementById("cb_nationality").value;
                var txt_lastnameth = document.getElementById("txt_lastnameth").value;
                var txt_firstnameen = document.getElementById("txt_firstnameen").value;
                var txt_lastnameen = document.getElementById("txt_lastnameen").value;
                var txt_birthday = document.getElementById("txt_birthday").value;
                var txt_wigth = document.getElementById("txt_wigth").value;
                var txt_height = document.getElementById("txt_height").value;
                var cb_race = document.getElementById("cb_race").value;
                var cb_religion = document.getElementById("cb_religion").value;
                var txt_phoneemployee = document.getElementById("txt_phoneemployee").value;
                var txt_mobile = document.getElementById("txt_mobile").value;
                var txt_emailemployee = document.getElementById("txt_emailemployee").value;
                var cb_activestatusemp = document.getElementById("cb_activestatusemp").value;
                var cb_cardtype = document.getElementById("cb_cardtype").value;
                var txt_cardno = document.getElementById("txt_cardno").value;
                var txt_carddatestart = document.getElementById("txt_carddatestart").value;
                var txt_carddateend = document.getElementById("txt_carddateend").value;
                var txt_issueplace = document.getElementById("txt_issueplace").value;
                var txt_datealert = document.getElementById("txt_datealert").value;
                var txt_alertmessage = document.getElementById("txt_alertmessage").value;
                var txt_emailcard = document.getElementById("txt_emailemployee").value;
                var cb_activestatuscard = document.getElementById("cb_activestatuscard").value;
                var txt_employeecode = document.getElementById("txt_employeecode").value;
                var cb_company = document.getElementById("cb_company").value;
                var cb_divistion = document.getElementById("cb_divistion").value;
                var cb_department = document.getElementById("cb_department").value;
                var cb_position = document.getElementById("cb_position").value;
                var txt_datestart = document.getElementById("txt_datestart").value;
                var txt_dateend = document.getElementById("txt_dateend").value;
                var txt_remark = document.getElementById("txt_remark").value;
                var cb_activestatuscomp = document.getElementById("cb_activestatuscomp").value;
                var cb_trainingname = document.getElementById("cb_trainingname").value;
                var txt_traininginstitution = document.getElementById("txt_traininginstitution").value;
                var txt_trainingauthenticate = document.getElementById("txt_trainingauthenticate").value;
                var txt_trainingauthenticateyear = document.getElementById("txt_trainingauthenticateyear").value;
                var txt_trainingvalues = document.getElementById("txt_trainingvalues").value;
                var txt_trainingremark = document.getElementById("txt_trainingremark").value;
                var cb_activestatustraining = document.getElementById("cb_activestatustraining").value;
                var cb_addresstypecode = document.getElementById("cb_addresstypecode").value;
                var txt_addressno = document.getElementById("txt_addressno").value;
                var txt_village = document.getElementById("txt_village").value;
                var txt_floor = document.getElementById("txt_floor").value;
                var txt_street = document.getElementById("txt_street").value;
                var txt_sidestreet = document.getElementById("txt_sidestreet").value;
                var txt_phoneaddress = document.getElementById("txt_phoneaddress").value;
                var cb_districtcode = document.getElementById("cb_districtcode").value;
                var cb_amphurcode = document.getElementById("cb_amphurcode").value;
                var cb_provincecode = document.getElementById("cb_provincecode").value;
                var cb_zipcode = document.getElementById("cb_zipcode").value;
                var txt_fulladdress = document.getElementById("txt_fulladdress").value;
                var txt_descriptions = document.getElementById("txt_descriptions").value;
                var cb_activestatusaddress = document.getElementById("cb_activestatusaddress").value;

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "save_empployee",
                        txt_employeeid: txt_employeeid,
                        txt_employeecardid: txt_employeecardid,
                        txt_employeecompanyid: txt_employeecompanyid,
                        txt_employeetrainingid: txt_employeetrainingid,
                        txt_employeeaddressid: txt_employeeaddressid,
                        txt_stractive: txt_stractive,
                        imagename : imagename,
                        filename : filename,
                        cb_bloodgroup: cb_bloodgroup,
                        cb_sex: cb_sex,
                        cb_prefix: cb_prefix,
                        txt_firstnameth: txt_firstnameth,
                        cb_nationality: cb_nationality,
                        txt_lastnameth: txt_lastnameth,
                        txt_firstnameen: txt_firstnameen,
                        txt_lastnameen: txt_lastnameen,
                        txt_birthday: txt_birthday,
                        txt_wigth: txt_wigth,
                        txt_height: txt_height,
                        cb_race: cb_race,
                        cb_religion: cb_religion,
                        txt_phoneemployee: txt_phoneemployee,
                        txt_mobile: txt_mobile,
                        txt_emailemployee: txt_emailemployee,
                        cb_activestatusemp: cb_activestatusemp,
                        cb_cardtype: cb_cardtype,
                        txt_cardno: txt_cardno,
                        txt_carddatestart: txt_carddatestart,
                        txt_carddateend: txt_carddateend,
                        txt_issueplace: txt_issueplace,
                        txt_datealert: txt_datealert,
                        txt_alertmessage: txt_alertmessage,
                        txt_emailcard: txt_emailcard,
                        cb_activestatuscard: cb_activestatuscard,
                        txt_employeecode: txt_employeecode,
                        cb_company: cb_company,
                        cb_divistion: cb_divistion,
                        cb_department: cb_department,
                        cb_position: cb_position,
                        txt_datestart: txt_datestart,
                        txt_dateend: txt_dateend,
                        txt_remark: txt_remark,
                        cb_activestatuscomp: cb_activestatuscomp,
                        cb_trainingname: cb_trainingname,
                        txt_traininginstitution: txt_traininginstitution,
                        txt_trainingauthenticate: txt_trainingauthenticate,
                        txt_trainingauthenticateyear: txt_trainingauthenticateyear,
                        txt_trainingvalues: txt_trainingvalues,
                        txt_trainingremark: txt_trainingremark,
                        cb_activestatustraining: cb_activestatustraining,
                        cb_addresstypecode: cb_addresstypecode,
                        txt_addressno: txt_addressno,
                        txt_village: txt_village,
                        txt_floor: txt_floor,
                        txt_street: txt_street,
                        txt_sidestreet: txt_sidestreet,
                        txt_phoneaddress: txt_phoneaddress,
                        cb_districtcode: cb_districtcode,
                        cb_amphurcode: cb_amphurcode,
                        cb_provincecode: cb_provincecode,
                        cb_zipcode: cb_zipcode,
                        txt_fulladdress: txt_fulladdress,
                        txt_descriptions: txt_descriptions,
                        cb_activestatusaddress: cb_activestatusaddress
                    },
                    success: function (response) {
                        alert(response);
                        window.location.reload();
                    }
                });
            }
        </script>
        <script>
            /*
             * This is the plugin
             */
            (function (a) {
                a.createModal = function (b) {
                    defaults = {title: "", message: "Your Message Goes Here!", closeButton: true, scrollable: false};
                    var b = a.extend({}, defaults, b);
                    var c = (b.scrollable === true) ? "" : "";
                    html = '<div class="modal fade" id="myModal" >';
                    html += '<div class="modal-dialog" style="width: 60%;height: 100%;">';
                    html += '<div class="modal-content"  style="width: 100%;height: 100%;">';
                    html += '<div class="modal-header" >';
                    html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
                    if (b.title.length > 0) {
                        html += '<h4 class="modal-title">' + b.title + "</h4>"
                    }
                    html += "</div>";
                    html += '<div style="width: 100%;height: 80%;" class="modal-body" ' + c + " >";
                    html += b.message;
                    html += "</div>";

                    html += "</div>";
                    html += "</div>";
                    html += "</div>";
                    a("body").prepend(html);
                    a("#myModal").modal().on("hidden.bs.modal", function () {
                        a(this).remove()
                    })
                }
            })(jQuery);

            /*
             * Here is how you use it
             */
            $(function () {
                $('.view-pdf').on('click', function () {
                    var pdf_link = $(this).attr('href');
                    var iframe = '<div class="iframe-container" style="width: 100%;height: 100%;"><iframe src="' + pdf_link + '" style="width: 100%;height: 100%;"></iframe></div>'
                    $.createModal({
                        title: 'เอกสารแนบ',
                        message: iframe,
                        closeButton: true,
                        scrollable: false
                    });
                    return false;
                });
            })
        </script>
        <script type="text/javascript">
            function fetch_department(val)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "se_department", data_cbdepartment: val
                    },
                    success: function (response) {
                        document.getElementById("cb_department").innerHTML = response;
                    }
                });
            }
            function fetch_amphur(val)
            {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "se_amphur", data_amphur: val
                    },
                    success: function (response) {
                        document.getElementById("cb_amphurcode").innerHTML = response;
                    }
                });
            }
            function fetch_district(val)
            {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "se_district", data_district: val
                    },
                    success: function (response) {
                        document.getElementById("cb_districtcode").innerHTML = response;
                    }
                });
            }
            function fetch_zipcode(val)
            {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "se_zipcode", data_zipcode: val
                    },
                    success: function (response) {
                        document.getElementById("cb_zipcode").innerHTML = response;
                    }
                });
            }

            function checkTextth1(str) {
                var orgi_text = " ๅภถุึคตจขชๆไำพะัีรนยบลฃฟหกดเ้่าสวงผปแอิืทมใฝ๑๒๓๔ู฿๕๖๗๘๙๐ฎฑธํ๊ณฯญฐฅฤฆฏโฌ็๋ษศซฉฮฺ์ฒฬฦ";
                var chk_text = str.split("");
                chk_text.filter(function (s) {
                    if (orgi_text.indexOf(s) == -1) {
                        alert("กรอกได้เฉพาะภาษาไทย");
                        document.getElementById('txt_firstnameth').value = "";
                    }
                });
            }
            function checkTextth2(str) {
                var orgi_text = " ๅภถุึคตจขชๆไำพะัีรนยบลฃฟหกดเ้่าสวงผปแอิืทมใฝ๑๒๓๔ู฿๕๖๗๘๙๐ฎฑธํ๊ณฯญฐฅฤฆฏโฌ็๋ษศซฉฮฺ์ฒฬฦ";
                var chk_text = str.split("");
                chk_text.filter(function (s) {
                    if (orgi_text.indexOf(s) == -1) {
                        alert("กรอกได้เฉพาะภาษาไทย");
                        document.getElementById('txt_lastnameth').value = "";
                    }
                });
            }

            function checkTexten()
            {
                var txtf = document.getElementById('txt_firstnameen').value;
                var txtl = document.getElementById('txt_lastnameen').value;
                if (!txtf.match(/^([a-z0-9\_])+$/i) && txtf != "")
                {
                    alert("กรอกได้เฉพาะภาษาอังกฤษ");
                    document.getElementById('txt_firstnameen').value = "";
                }
                if (!txtl.match(/^([a-z0-9\_])+$/i) && txtl != "")
                {
                    alert("กรอกได้เฉพาะภาษาอังกฤษ");
                    document.getElementById('txt_lastnameen').value = "";
                }

            }
        </script>
    </body>

</html>
<?php
sqlsrv_close($conn);
?>
