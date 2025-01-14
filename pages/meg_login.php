<!DOCTYPE html>
<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
include("../MobileDetect/Mobile_Detect.php");

$detect = new Mobile_Detect();

// Check for any mobile device.
if ($detect->isMobile()){
   // mobile content
    $checkClient = 'MB';
    $TitleShow = 'display:none;';
}
else {
   // other content for desktops
   $checkClient = 'DT';
   $TitleShow = '';
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
        <!-- <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
         -->
        <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-3/assets/css/login-3.css">
        <link href="https://fonts.googleapis.com/css?family=Kanit:500,600,700" rel="stylesheet">
    </head>
    <style>
        .swal2-popup {
            font-size: 16px !important;
            padding: 17px;
            border: 1px solid #F0E1A1;
            display: block;
            margin: 22px;
            text-align: center;
            color: #61534e;
        }
        body{
            font-family: 'Kanit';font-size: 16px;

        }
    </style>
    <body>
        <div class="container">
            <section class="p-3 p-md-4 p-xl-5">
                <div class="container">
                    <div class="row">
                    <div class="col-12 col-md-6 bsb-tpl-bg-platinum">
                        <div class="d-flex flex-column justify-content-between h-100 p-3 p-md-4 p-xl-5">
                        <h3 class="m-0">Welcome!&nbsp;⛟ </h3>
                        <h3 class="m-0"><font style="color: #21b4fe;font-size: 28px;">TRANSPORT MANAGEMENT SYSTEM</font></h3>
                        <br>
                        <div style="width:100%;height:140%;padding-bottom:20%;position:relative;text-align: center;">
                            <iframe style="border:none;position:absolute;top:0;left:0;width:100%;height:110%;border:none;overflow:hidden !important;<?=$TitleShow?>" src="//openspeedtest.com/Get-widget.php"></iframe></div>
                            <!-- <img class="img-fluid rounded mx-auto my-4" loading="lazy" src="./assets/img/bsb-logo.svg" width="245" height="80" alt="BootstrapBrain Logo"> -->
                            <!-- <p class="mb-0">Not a member yet? <a href="#!" class="link-secondary text-decoration-none">Register now</a></p> -->
                        </div>
                    </div>
                    <div class="col-12 col-md-6 bsb-tpl-bg-lotion">
                        <div class="p-3 p-md-4 p-xl-5">
                        <div class="row">
                            <div class="col-12">
                            <div class="mb-5">
                                <h3>เข้าสู่ระบบ TMS</h3>
                            </div>
                            </div>
                        </div>
                        <form action="#!">
                            <div class="row gy-3 gy-md-4 overflow-hidden">
                            <div class="col-12">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="txt_usernamelogin" id="txt_usernamelogin" placeholder="" required>
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="txt_passwordlogin" id="txt_passwordlogin" value="" required>
                            </div>
                            <div class="col-12">
                                <!-- <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="remember_me" id="remember_me">
                                <label class="form-check-label text-secondary" for="remember_me">
                                    Keep me logged in
                                </label>
                                </div> -->
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                <button class="btn bsb-btn-xl btn-success" onclick="login()" type="button">เข้าสู่ระบบ</button>
                                </div>
                            </div>
                            </div>
                        </form>
                        <!-- <div class="row">
                            <div class="col-12">
                            <hr class="mt-5 mb-4 border-secondary-subtle">
                            <div class="text-end">
                                <a href="#!" class="link-secondary text-decoration-none">Forgot password</a>
                            </div>
                            </div>
                        </div> -->
                        <div class="row">
                            <!-- <div class="col-12">
                            <p class="mt-5 mb-4">Or sign in with</p>
                            <div class="d-flex gap-3 flex-column flex-xl-row">
                                <a href="#!" class="btn bsb-btn-xl btn-outline-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                                    <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z" />
                                </svg>
                                <span class="ms-2 fs-6">Google</span>
                                </a>
                                <a href="#!" class="btn bsb-btn-xl btn-outline-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                </svg>
                                <span class="ms-2 fs-6">Facebook</span>
                                </a>
                                <a href="#!" class="btn bsb-btn-xl btn-outline-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                                </svg>
                                <span class="ms-2 fs-6">Twitter</span>
                                </a>
                            </div>
                            </div>
                        </div> -->
						<br>
						<br>
						<br>
                        </div>
                    </div>
                    </div>
                </div>
            </section>    
            


        </div>
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>
        <!-- Sweet Alert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    </body>
</html>
<script>                             

                                        $("input").keydown(function(event){
                                            if (event.keyCode == 13) {
                                                // do something here
                                                // alert("You Pres Enter");
                                                login();

                                            }
                                        });
                                        function login()
                                        {

                                            // alert("login click");
                                            var username = document.getElementById('txt_usernamelogin').value;
                                            var password = document.getElementById('txt_passwordlogin').value;
                                            if (username == "" || password == "")
                                            {
                                                // alert('กรุณากรอกชื่อเข้าใช้งานและรหัสผ่าน !!!');
                                                swal.fire({
                                                    title: "Warning!",
                                                    text: "กรุณากรอกชื่อเข้าใช้งานและรหัสผ่าน !!!",
                                                    showConfirmButton: true,
                                                    allowOutsideClick: false,
                                                    icon: "warning"
                                                });
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
                                                                // alert('ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง กรุณาเข้าระบบอีกครั้ง !!!');
                                                                swal.fire({
                                                                    title: "Warning!",
                                                                    text: "ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง !!!",
                                                                    showConfirmButton: true,
                                                                    allowOutsideClick: false,
                                                                    icon: "warning"
                                                                });
                                                            } else
                                                            {

                                                                    /*if ('<?//= $_GET['data'] ?>' == '1')
                                                                    {
                                                                    window.location.href = 'index.php';
                                                                    } else if ('<?//= $_GET['data'] ?>' == '2')
                                                                    {
                                                                    window.location.href = 'meg_employee6.php?type=transportplan';
                                                                    } else if ('<?//= $_GET['data'] ?>' == '3')
                                                                    {
                                                                    window.location.href = 'meg_transportcompensation.php';
                                                                    } else if ('<?//= $_GET['data'] ?>' == '4')
                                                                    {
                                                                    window.location.href = 'adjust_price/index.php';
                                                                    } else
                                                                    {
                                                                    window.location.href = 'index.php';
                                                                    }*/
                                                                            window.location.href = 'index.php';

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
