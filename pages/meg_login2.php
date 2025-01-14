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

        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div id="chart_stopwork" class="modal fade" role="dialog" >

                <div class="modal-dialog" style="width: 30%;">
                    <div class="modal-content">

                        <div class="panel-body">
                            <div class="modal-header">
                                <i class="fa fa-unlock "></i> <b>ขอใช้งานระบบ</b>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <font style="color: red">* </font><label for="recipient-name" class="col-form-label">ชื่อ-นามสกุล :</label>
                                    <input type="text" onchange="chg_employee(this.value)"  name="txt_employeename"  id="txt_employeename" class="form-control" >
                                    <input type="text" style="display: none"  name="txt_employeeid"  id="txt_employeeid" class="form-control">
                                </div>
                                <div class="form-group">
                                    <font style="color: red">* </font><label for="recipient-name" class="col-form-label">Username :</label>
                                    <input type="text" class="form-control" id="txt_username" name="txt_username">
                                </div>
                                <div class="form-group">
                                    <font style="color: red">* </font><label for="message-text" class="col-form-label">Password :</label>
                                    <input type="text" class="form-control" id="txt_password" name="txt_password">
                                </div>

                                <div class="form-group">
                                    <label>หมายเหตุ</label>
                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_remark" name="txt_remark"></textarea>

                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                <button type="button" class="btn btn-primary" onclick="save_reqaccount();">ส่งข้อมูล</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Sign In</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" id="txt_usernamelogin"  name="txt_usernamelogin" type="text" autofocus="off">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" id="txt_passwordlogin"  name="txt_passwordlogin" type="password" autofocus="off">
                                    </div>
                                    <!--<div class="form-group">
                                        <label>
                                            <a href="#" data-toggle="modal" data-target="#chart_stopwork">ใช้งานครั้งแรก</a>
                                        </label>
                                    </div>-->
                                    <!-- Change this to a button or input when using this as a form -->
                                    <a href="#" class="btn btn-lg btn-success btn-block" onclick="login();">Login</a>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>
    </body>
</html>
<script>
                                        function login()
                                        {

                                            var username = document.getElementById('txt_usernamelogin').value;
                                            var password = document.getElementById('txt_passwordlogin').value;
                                            if (username == "" || password == "")
                                            {
                                                alert('กรุณากรอกชื่อเข้าใช้งานและรหัสผ่าน !!!');
                                            } else
                                            {
                                                $.ajax({
                                                    type: 'post',
                                                    url: 'meg_data.php',
                                                    data: {
                                                        txt_flg: "login", username: username, password: password
                                                    },
                                                    success: function (response) {
                                                        // alert(response);
                                                        //document.getElementById("test").innerHTML = response;
                                                        if (response == 0)
                                                        {
                                                            alert('ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง กรุณาเข้าระบบอีกครั้ง !!!');
                                                        } else
                                                        {
                                                            window.location.href = 'meg_employee5.php?type=transportplan';
                                                        }
                                                    }
                                                });
                                            }

                                        }
</script>
<script>
    function chg_employee(val)
    {
        $.ajax({
            type: 'post',
            url: 'meg_data.php',
            data: {
                txt_flg: "select_employee", txt_employeename: val
            },
            success: function (response) {

                if (response)
                {
                    document.getElementById("txt_employeeid").value = response;
                }
            }
        });

    }
</script>
<script type="text/javascript">
    var txt_employeename = [
<?php
$employee = "";
$sql_seEmp = "{call megStopwork_v2(?,?)}";
$params_seEmp = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
while ($result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC)) {
    $employee .= "'" . $result_seEmp['NAME'] . "',";
}
echo rtrim($employee, ",");
?>
    ];
    $(function () {
        $("#txt_employeename").autocomplete({
            source: [txt_employeename]
        });
    });


</script>
<script type="text/javascript">
    function chknull_reqaccount()
    {
        if (document.getElementById('txt_employeename').value == '')
        {
            alert('ชื่อ-นามสกุล เป็นค่าว่าง !!!')
            document.getElementById('txt_employeename').focus();
            return false;
        } else if (document.getElementById('txt_username').value == '')
        {
            alert('Username เป็นค่าว่าง !!!')
            document.getElementById('txt_username').focus();
            return false;
        } else if (document.getElementById('txt_password').value == '')
        {
            alert('Password เป็นค่าว่าง !!!')
            document.getElementById('txt_password').focus();
            return false;
        } else
        {
            return true;
        }
    }
    function save_reqaccount()
    {
        var employeeid = document.getElementById('txt_employeeid').value;
        var username = document.getElementById('txt_username').value;
        var password = document.getElementById('txt_password').value;
        var remarkaccount = document.getElementById('txt_remark').value;


        if (chknull_reqaccount())
        {
            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "save_roleaccount", accountid: '', roleid: 3, employeeid: employeeid, username: username, password: password, remarkaccount: remarkaccount, activestatusaccount: 0

                },
                success: function (response) {
                    alert(response);
                    window.location.reload();
                }
            });
        }
    }
</script>
